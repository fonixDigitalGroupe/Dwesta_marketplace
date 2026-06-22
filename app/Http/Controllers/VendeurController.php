<?php

namespace App\Http\Controllers;

use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Models\VendeurProfessionnel;
use App\Services\DocumentNotificationService;
use App\Services\DocumentUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewVendorNotification;
use App\Mail\VendorApplicationConfirmation;
use App\Models\Abonnement;
use App\Models\VendeurAbonnement;
use Carbon\Carbon;

class VendeurController extends Controller
{
    protected $documentUploadService;
    protected $documentNotificationService;
    protected $subscriptionService;

    public function __construct(
        DocumentUploadService $documentUploadService, 
        DocumentNotificationService $documentNotificationService,
        \App\Services\SubscriptionService $subscriptionService
    ) {
        $this->documentUploadService = $documentUploadService;
        $this->documentNotificationService = $documentNotificationService;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Affiche le formulaire de création de compte vendeur
     */
    public function create()
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est déjà un vendeur professionnel
        if ($user->vendeur && $user->vendeur->estProfessionnel() && !request()->has('update')) {
            return redirect()->route('vendeur.show')->with('info', 'Vous avez déjà un compte vendeur professionnel.');
        }

        // Si c'est un vendeur particulier vérifié, il peut quand même accéder pour passer PRO ou mettre à jour
        if ($user->vendeur && $user->vendeur->estParticulier() && $user->vendeur->estOfficiel() && !request()->has('update')) {
            // On laisse passer vers la vue
        } elseif ($user->estVendeurOfficiel() && !request()->has('update')) {
            return redirect()->route('vendeur.show')->with('info', 'Vous avez déjà un compte vendeur.');
        }

        return view('vendeur.create');
    }

    /**
     * Crée un compte vendeur particulier
     */
    public function storeParticulier(Request $request)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est déjà un vendeur particulier complet (sauf si demande d'update)
        if ($user->vendeur && $user->vendeur->estParticulier() && $user->vendeur->estOfficiel() && !$request->has('update')) {
            return redirect()->route('vendeur.show')->with('error', 'Vous avez déjà un compte vendeur particulier.');
        }

        $request->validate([
            'type_document' => ['required', 'in:cni,passeport,recepisse'],
            'numero_document' => ['required', 'string', 'max:255'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5 Mo
            'date_emission_document' => ['required', 'date'],
            'date_expiration_document' => ['nullable', 'date', 'after:date_emission_document'],
            'lieu_emission' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            // Récupérer ou créer le vendeur
            $vendeur = $user->vendeur;
            if ($vendeur) {
                $vendeur->update([
                    'type' => 'particulier',
                    'statut_verification' => 'en_attente',
                    'actif' => true,
                ]);
            } else {
                $vendeur = Vendeur::create([
                    'user_id' => $user->id,
                    'type' => 'particulier',
                    'statut_verification' => 'verifie', // Auto-activé comme demandé
                    'verifie_le' => now(),
                    'actif' => true,
                ]);
                $this->assignDefaultSubscription($vendeur);
            }

            // Upload du document
            $documentPath = $this->documentUploadService->uploadDocument(
                $request->file('document'),
                $request->type_document,
                $vendeur->id
            );

            // Créer ou mettre à jour le vendeur particulier
            VendeurParticulier::updateOrCreate(
                ['vendeur_id' => $vendeur->id],
                [
                    'type_document' => $request->type_document,
                    'numero_document' => $request->numero_document,
                    'document_path' => $documentPath,
                    'date_emission_document' => $request->date_emission_document,
                    'date_expiration_document' => $request->date_expiration_document,
                    'lieu_emission' => $request->lieu_emission,
                ]
            );

            // S'assurer que l'utilisateur a le rôle Vendeur Particulier
            if (!$user->hasRole('Vendeur Particulier')) {
                $user->assignRole('Vendeur Particulier');
            }

            // Notification Admin
            Mail::to(config('mail.from.address'))->send(new NewVendorNotification($vendeur));
            
            // Notification Utilisateur
            Mail::to($user->email)->send(new VendorApplicationConfirmation($vendeur));

            DB::commit();

            return redirect()->route('vendeur.show')->with('success', 'Votre demande de compte vendeur a été soumise avec succès ! Un e-mail de confirmation a été envoyé à ' . $user->email . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création compte vendeur particulier: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Une erreur est survenue lors de la création de votre compte vendeur.');
        }
    }

    /**
     * Crée un compte vendeur professionnel
     */
    public function storeProfessionnel(Request $request)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est déjà un vendeur professionnel (sauf si demande d'update)
        if ($user->vendeur && $user->vendeur->estProfessionnel() && !$request->has('update')) {
            return redirect()->route('vendeur.show')->with('error', 'Vous avez déjà un compte vendeur professionnel.');
        }

        $request->validate([
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'numero_registre_commerce' => ['nullable', 'string', 'max:255'],
            'registre_commerce' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'date_expiration_registre' => ['nullable', 'date'],
            'numero_identification_fiscale' => ['nullable', 'string', 'max:255'],
            'adresse_entreprise' => ['nullable', 'string', 'max:500'],
            'telephone_entreprise' => ['nullable', 'string', 'max:20'],
            'email_entreprise' => ['nullable', 'email', 'max:255'],
            'description_entreprise' => ['nullable', 'string'],
            'site_web' => ['nullable', 'url', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            // Récupérer ou créer le vendeur
            $vendeur = $user->vendeur;
            if ($vendeur) {
                // Sauvegarde de l'état si déjà vérifié particulier
                $wasVerifiedParticular = $vendeur->estParticulier() && $vendeur->estVerifie();

                // On ne change le type en 'professionnel' QUE si l'admin approuve plus tard
                // pour permettre de garder les avantages particulier en attendant.
                $vendeur->update([
                    'statut_verification' => 'en_attente',
                    'raison_rejet' => null
                ]);

                // On ne supprime pas encore le particulier si on est en transition
                // if ($vendeur->particulier) { $vendeur->particulier->delete(); } // Supprimé pour garder les avantages
            } else {
                $vendeur = Vendeur::create([
                    'user_id' => $user->id,
                    'type' => 'professionnel',
                    'statut_verification' => 'verifie', // Auto-activé comme demandé
                    'verifie_le' => now(),
                    'actif' => true,
                ]);
                $this->assignDefaultSubscription($vendeur);
            }

            // Upload du registre de commerce
            $registrePath = $this->documentUploadService->uploadDocument(
                $request->file('registre_commerce'),
                'registre_commerce',
                $vendeur->id
            );

            // Créer ou mettre à jour le vendeur professionnel
            VendeurProfessionnel::updateOrCreate(
                ['vendeur_id' => $vendeur->id],
                [
                    'nom_entreprise' => $request->nom_entreprise,
                    'numero_registre_commerce' => $request->numero_registre_commerce,
                    'registre_commerce_path' => $registrePath,
                    'date_expiration_registre' => $request->date_expiration_registre,
                    'numero_identification_fiscale' => $request->numero_identification_fiscale,
                    'adresse_entreprise' => $request->adresse_entreprise,
                    'telephone_entreprise' => $request->telephone_entreprise,
                    'email_entreprise' => $request->email_entreprise,
                    'description_entreprise' => $request->description_entreprise,
                    'site_web' => $request->site_web,
                ]
            );

            // Assigner le rôle Vendeur Professionnel
            $user->assignRole('Vendeur Professionnel');

            // Notification Admin
            Mail::to(config('mail.from.address'))->send(new NewVendorNotification($vendeur));

            // Notification Utilisateur
            Mail::to($user->email)->send(new VendorApplicationConfirmation($vendeur));

            DB::commit();

            return redirect()->route('vendeur.show')->with('success', 'Votre demande de compte vendeur professionnel a été soumise avec succès ! Un e-mail de confirmation a été envoyé à ' . $user->email . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création compte vendeur professionnel: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Une erreur est survenue lors de la création de votre compte vendeur.');
        }
    }

    /**
     * Affiche les informations du compte vendeur
     */
    public function show()
    {
        $user = Auth::user();

        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create')->with('error_banner', 'Vous devez créer un compte vendeur pour accéder à cette page.');
        }

        $vendeur = $user->vendeur;
        $vendeur->load(['particulier', 'professionnel', 'abonnementActif.abonnement', 'pagePro']);

        // Récupérer les alertes d'expiration
        $alertes = $this->documentNotificationService->getAlertesActives($vendeur);

        // Récupérer les stats d'annonces
        $nombreAnnoncesPubliees = $vendeur->annonces()->whereIn('statut', ['publiee', 'en_attente'])->count();
        $annoncesRestantes = $this->subscriptionService->getRemainingAnnonces($vendeur);
        $abonnementActuel = $vendeur->abonnementActuel;

        return view('vendeur.show', compact('vendeur', 'alertes', 'nombreAnnoncesPubliees', 'annoncesRestantes', 'abonnementActuel'));
    }

    /**
     * Affiche la page "Mes annonces" avec toutes les annonces du vendeur
     */
    public function mesAnnonces()
    {
        $user = Auth::user();

        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create')->with('error_banner', 'Vous devez créer un compte vendeur pour accéder à cette page.');
        }

        $vendeur = $user->vendeur;
        $vendeur->load(['abonnementActif.abonnement', 'pagePro']);

        // Récupérer toutes les annonces du vendeur
        $annonces = $vendeur->annonces()
            ->with(['category', 'photos', 'options'])
            ->latest()
            ->paginate(20);

        // Vérifier si le vendeur a un abonnement payant pour afficher le lien boutique
        $subscriptionService = app(\App\Services\SubscriptionService::class);
        $hasPaidSubscription = $subscriptionService->hasPaidSubscription($vendeur);

        return view('vendeur.mes-annonces', compact('vendeur', 'annonces', 'hasPaidSubscription'));
    }

    /**
     * Met à jour les documents d'un vendeur particulier
     */
    public function updateDocumentParticulier(Request $request, Vendeur $vendeur)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est le propriétaire
        if ($vendeur->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }

        if (!$vendeur->estParticulier()) {
            return back()->with('error', 'Ce compte n\'est pas un compte particulier.');
        }

        $request->validate([
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'type_document' => ['required', 'in:cni,passeport,recepisse'],
            'numero_document' => ['required', 'string', 'max:255'],
            'date_emission_document' => ['required', 'date'],
            'date_expiration_document' => ['nullable', 'date', 'after:date_emission_document'],
            'lieu_emission' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $particulier = $vendeur->particulier;

            // Supprimer l'ancien document
            if ($particulier->document_path) {
                $this->documentUploadService->deleteDocument($particulier->document_path);
            }

            // Upload du nouveau document
            $documentPath = $this->documentUploadService->uploadDocument(
                $request->file('document'),
                $request->type_document,
                $vendeur->id
            );

            // Mettre à jour les informations
            $particulier->update([
                'type_document' => $request->type_document,
                'numero_document' => $request->numero_document,
                'document_path' => $documentPath,
                'date_emission_document' => $request->date_emission_document,
                'date_expiration_document' => $request->date_expiration_document,
                'lieu_emission' => $request->lieu_emission,
            ]);

            // Réinitialiser le statut de vérification
            $vendeur->update([
                'statut_verification' => 'en_attente',
                'raison_rejet' => null,
            ]);

            return redirect()->route('vendeur.show');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour document particulier: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour du document.');
        }
    }

    /**
     * Met à jour les documents d'un vendeur professionnel
     */
    public function updateDocumentProfessionnel(Request $request, Vendeur $vendeur)
    {
        $user = Auth::user();

        // Vérifier que l'utilisateur est le propriétaire
        if ($vendeur->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }

        if (!$vendeur->estProfessionnel()) {
            return back()->with('error', 'Ce compte n\'est pas un compte professionnel.');
        }

        $request->validate([
            'registre_commerce' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'numero_registre_commerce' => ['nullable', 'string', 'max:255'],
            'date_expiration_registre' => ['nullable', 'date'],
            'numero_identification_fiscale' => ['nullable', 'string', 'max:255'],
            'adresse_entreprise' => ['nullable', 'string', 'max:500'],
            'telephone_entreprise' => ['nullable', 'string', 'max:20'],
            'email_entreprise' => ['nullable', 'email', 'max:255'],
            'description_entreprise' => ['nullable', 'string'],
            'site_web' => ['nullable', 'url', 'max:255'],
        ]);

        try {
            $professionnel = $vendeur->professionnel;

            $updateData = [
                'nom_entreprise' => $request->nom_entreprise,
                'numero_registre_commerce' => $request->numero_registre_commerce,
                'date_expiration_registre' => $request->date_expiration_registre,
                'numero_identification_fiscale' => $request->numero_identification_fiscale,
                'adresse_entreprise' => $request->adresse_entreprise,
                'telephone_entreprise' => $request->telephone_entreprise,
                'email_entreprise' => $request->email_entreprise,
                'description_entreprise' => $request->description_entreprise,
                'site_web' => $request->site_web,
            ];

            // Si un nouveau registre est uploadé
            if ($request->hasFile('registre_commerce')) {
                // Supprimer l'ancien document
                if ($professionnel->registre_commerce_path) {
                    $this->documentUploadService->deleteDocument($professionnel->registre_commerce_path);
                }

                // Upload du nouveau document
                $registrePath = $this->documentUploadService->uploadDocument(
                    $request->file('registre_commerce'),
                    'registre_commerce',
                    $vendeur->id
                );

                $updateData['registre_commerce_path'] = $registrePath;
            }

            // Mettre à jour les informations
            $professionnel->update($updateData);

            // Réinitialiser le statut de vérification si un document a été changé
            if ($request->hasFile('registre_commerce')) {
                $vendeur->update([
                    'statut_verification' => 'en_attente',
                    'raison_rejet' => null,
                ]);
            }

            return redirect()->route('vendeur.show');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour document professionnel: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }
    /**
     * Affiche les ventes (commandes reçues) du vendeur
     */
    public function orders()
    {
        $user = Auth::user();

        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create')->with('error_banner', 'Vous devez créer un compte vendeur pour accéder à cette page.');
        }

        $vendeur = $user->vendeur;

        // Récupérer toutes les commandes passées chez ce vendeur
        $orders = $vendeur->orders()
            ->with(['buyer', 'items.annonce'])
            ->latest()
            ->paginate(20);

        // Stats rapides (sur toutes les commandes, pas seulement la page)
        $allOrders = $vendeur->orders();
        $stats = [
            'total'     => (clone $allOrders)->count(),
            'revenue'   => (clone $allOrders)->sum('total_produits'),
            'pending'   => (clone $allOrders)->where('statut', 'paye')->count(),
            'delivered' => (clone $allOrders)->where('statut', 'livre')->count(),
        ];

        return view('vendeur.orders', compact('vendeur', 'orders', 'stats'));
    }

    /**
     * Affiche le détail d'une commande reçue (côté vendeur)
     */
    public function orderShow(\App\Models\Order $order)
    {
        $user = Auth::user();

        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create');
        }

        $vendeur = $user->vendeur;

        // Sécurité : la commande doit appartenir à ce vendeur
        if ($order->vendeur_id !== $vendeur->id) {
            abort(403, 'Accès non autorisé.');
        }

        $order->load(['buyer', 'items.annonce.photos']);

        return view('vendeur.order-show', compact('order'));
    }

    /**
     * Génère et télécharge le bordereau d'expédition / facture avec QR Code
     */
    public function invoice(\App\Models\Order $order)
    {
        $user = Auth::user();

        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create');
        }

        $vendeur = $user->vendeur;

        // Sécurité : la commande doit appartenir à ce vendeur
        if ($order->vendeur_id !== $vendeur->id) {
            abort(403, 'Accès non autorisé.');
        }

        $order->load(['buyer', 'items.annonce.photos']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('vendeur.order-invoice', compact('order', 'vendeur'));
        
        return $pdf->download('facture-commande-' . $order->reference . '.pdf');
    }

    /**
     * Affiche les statistiques du vendeur
     */
    public function stats()
    {
        $user = Auth::user();
        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create');
        }

        $vendeur = $user->vendeur;
        $ordersQuery = $vendeur->orders()->where('statut', '!=', 'annule');

        $stats = [
            'total_orders' => $ordersQuery->count(),
            'total_revenue' => $ordersQuery->sum('total_produits'),
            'total_commissions' => $ordersQuery->sum('commission_plateforme'),
        ];

        $recentOrders = $vendeur->orders()
            ->with(['buyer', 'items.annonce'])
            ->latest()
            ->limit(10)
            ->get();

        return view('vendeur.stats', compact('vendeur', 'stats', 'recentOrders'));
    }

    /**
     * Attribue automatiquement l'abonnement gratuit par défaut
     */
    private function assignDefaultSubscription(Vendeur $vendeur)
    {
        if (!$vendeur->abonnements()->where('actif', true)->exists()) {
            $abonnementGratuit = Abonnement::where('type', Abonnement::TYPE_GRATUIT)->first();
            if ($abonnementGratuit) {
                VendeurAbonnement::create([
                    'vendeur_id' => $vendeur->id,
                    'abonnement_id' => $abonnementGratuit->id,
                    'date_debut' => Carbon::today(),
                    'date_fin' => Carbon::today()->addYears(10),
                    'actif' => true,
                    'renouvellement_automatique' => false,
                    'nombre_annonces_utilisees' => 0,
                ]);
            }
        }
    }
}
