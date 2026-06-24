<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Services\AnnonceOptionService;
use App\Services\AnnonceService;
use App\Services\CreditService;
use App\Services\ImportAnnoncesCSVService;
use App\Services\MediaUploadService;
use App\Services\RecommandationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AnnonceController extends Controller
{
    protected AnnonceService $annonceService;
    protected AnnonceOptionService $optionService;
    protected MediaUploadService $mediaService;
    protected ImportAnnoncesCSVService $importService;
    protected RecommandationService $recommandationService;
    protected CreditService $creditService;
    protected \App\Services\AnnoncePaymentService $paymentService;
    protected \App\Services\SubscriptionService $subscriptionService;

    public function __construct(
        AnnonceService $annonceService,
        AnnonceOptionService $optionService,
        MediaUploadService $mediaService,
        ImportAnnoncesCSVService $importService,
        RecommandationService $recommandationService,
        CreditService $creditService,
        \App\Services\AnnoncePaymentService $paymentService,
        \App\Services\SubscriptionService $subscriptionService
    ) {
        $this->annonceService = $annonceService;
        $this->optionService = $optionService;
        $this->mediaService = $mediaService;
        $this->importService = $importService;
        $this->recommandationService = $recommandationService;
        $this->creditService = $creditService;
        $this->paymentService = $paymentService;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Liste des annonces du vendeur
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create')
                ->with('error_banner', 'Vous devez créer un compte vendeur pour publier des annonces.');
        }

        $vendeur = $user->vendeur;
        $annonces = $vendeur->annonces()
            ->with(['category', 'photos'])
            ->latest()
            ->paginate(15);

        return view('annonces.index', compact('annonces'));
    }

    /**
     * Affiche le formulaire de création selon le type
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        // Tous les utilisateurs connectés peuvent créer une annonce
        // Si l'utilisateur n'est pas vendeur, on créera automatiquement un compte vendeur lors de la création de l'annonce

        $type = $request->query('type', 'produit');

        // Nettoyer le type (au cas où il y aurait des caractères indésirables)
        $type = trim(strtolower($type));

        // Valider le type
        if (!in_array($type, [Annonce::TYPE_PRODUIT, Annonce::TYPE_SERVICE, Annonce::TYPE_IMMOBILIER, Annonce::TYPE_VEHICULE])) {
            $type = Annonce::TYPE_PRODUIT;
        }

        $categories = Category::actives()->parOrdre()->get();
        $creditServices = \App\Models\CreditServiceConfig::actif()->get();
        $creditBalance = $this->creditService->solde($user);
        $vendeur = $user->vendeur;
        $annoncesRestantes = $vendeur ? $this->subscriptionService->getRemainingAnnonces($vendeur) : 5;

        // Utiliser la vue multi-étapes pour tous les types
        return view('annonces.create', compact('categories', 'type', 'creditBalance', 'creditServices', 'annoncesRestantes'));
    }

    /**
     * Enregistre une nouvelle annonce
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $type = $request->input('type');

        // 1. Validation de base TOUJOURS en premier
        $validated = $this->validateAnnonce($request, $type);

        // 2. Si l'utilisateur n'est pas vendeur, créer automatiquement un compte vendeur particulier
        if (!$user->estVendeur()) {
            $vendeur = Vendeur::create([
                'user_id' => $user->id,
                'type' => 'particulier',
                'statut_verification' => 'en_attente',
                'actif' => true,
            ]);

            // Créer un vendeur particulier basique (sans document pour l'instant)
            VendeurParticulier::create([
                'vendeur_id' => $vendeur->id,
                'type_document' => 'cni',
                'numero_document' => 'A_COMPLETER',
                'document_path' => null,
            ]);

            // Assigner le rôle Vendeur Particulier
            $user->assignRole('Vendeur Particulier');

            // Recharger la relation
            $user->load('vendeur');
        }

        $vendeur = $user->vendeur;

        // Mettre à jour les coordonnées de l'utilisateur
        $user->update([
            'telephone' => $validated['user_phone'],
            'code_postal' => $validated['code_postal'],
        ]);

        // Fix missing disponibilite as it was removed from form
        if (!isset($validated['disponibilite'])) {
            $validated['disponibilite'] = 'en_stock';
        }

        // Vérifier les limites d'annonces selon l'abonnement
        if (!$this->subscriptionService->canPublishAnnonce($vendeur)) {
            $remaining = $this->subscriptionService->getRemainingAnnonces($vendeur);
            return back()->withInput()->with('limit_error', "Limite d'annonces atteinte (0 restante).");
        }

        try {
            // 1. Vérification du solde pour la catégorie (si payante)
            $categorie = Category::findOrFail($validated['categorie_id']);
            if (!$this->paymentService->canAffordPublication($user, $categorie)) {
                return back()->withInput()->with('error', "Solde insuffisant pour publier dans cette catégorie ({$categorie->nom}). Coût : " . number_format($categorie->listing_price, 0) . " FCFA. Rechargez vos crédits.");
            }

            $annonceData = array_merge($validated, ['attributes' => $request->input('attributes', [])]);

            // === Appliquer le code promo si valide ===
            $promoCode = strtoupper(trim($request->input('promo_code', '')));
            if ($promoCode) {
                $coupon = \App\Models\Coupon::where('code', $promoCode)
                    ->where('is_active', true)
                    ->first();

                if ($coupon) {
                    // Vérifier campagne active
                    $campaign = \App\Models\Campaign::where('coupon_id', $coupon->id)
                        ->where(function ($q) { $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()); })
                        ->where(function ($q) { $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()); })
                        ->first();

                    if ($campaign) {
                        $vendeurPrix = floatval($annonceData['prix']);
                        if ($coupon->type === 'percent') {
                            $promoPrix = $vendeurPrix * (1 - $coupon->value / 100);
                        } else {
                            $promoPrix = max(0, $vendeurPrix - $coupon->value);
                        }
                        // Le prix du vendeur devient le prix barré, le prix promo est le prix final
                        $annonceData['prix_original'] = $vendeurPrix;
                        $annonceData['prix'] = round($promoPrix, 2);
                        $annonceData['coupon_code'] = $coupon->code;
                        $annonceData['promo_expires_at'] = $campaign->ends_at;
                    }
                }
            }

            $annonce = $this->annonceService->creerAnnonce($vendeur, $annonceData, $type);

            // 2. Paiement effectif de la publication
            $this->paymentService->processPublicationPayment($user, $categorie, "REF-" . $annonce->id);

            // Upload des photos
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $estPrincipale = $index === 0;
                    $this->mediaService->uploadPhoto($photo, $annonce->id, $estPrincipale, $index);
                }

                // Mettre à jour le nombre de photos
                $annonce->update(['nb_photos' => $annonce->photos()->count()]);
            }

            // Upload de la vidéo si fournie
            if ($request->hasFile('video')) {
                $this->mediaService->uploadVideo($request->file('video'), $annonce->id);
                $annonce->update(['video_achetee' => true]);
                
                // S'assurer que le service vidéo est dans la liste des services à activer
                if (!isset($selectedServices)) {
                    $selectedServices = $request->input('services', []);
                }
                if (!in_array('video', $selectedServices)) {
                    $selectedServices[] = 'video';
                }
            }

            // Gestion des options payantes (consommation de crédits)
            if ($validated['statut'] === Annonce::STATUT_PUBLIEE && ($request->has('services') || (isset($selectedServices) && !empty($selectedServices)))) {
                if (!isset($selectedServices)) {
                    $selectedServices = $request->input('services', []); // Array de clés comme ['video', 'boost']
                }
                $totalCost = 0;
                $configsToActivate = [];

                foreach ($selectedServices as $serviceKey) {
                    $config = \App\Models\CreditServiceConfig::where('cle', $serviceKey)->where('actif', true)->first();
                    if ($config) {
                        $totalCost += $config->credits_requis;
                        $configsToActivate[] = $config;
                    }
                }

                if ($totalCost > 0) {
                    if (!$this->creditService->aAssezDeCredits($user, $totalCost)) {
                        // Annuler la création
                        $annonce->forceDelete();
                        return back()->withInput()->with('error', "Crédits insuffisants pour les options choisies. Solde actuel : " . $this->creditService->solde($user) . " crédits.");
                    }

                    // Activer chaque service
                    foreach ($configsToActivate as $config) {
                        $this->creditService->activerService($user, $annonce, $config->cle);
                    }
                }
            }

            if ($validated['statut'] === Annonce::STATUT_PUBLIEE) {
                // Incrémenter le compteur d'annonces utilisées
                $this->subscriptionService->incrementAnnonceCount($vendeur);
                
                return redirect()->route('vendeur.mes-annonces')
                    ->with('success', 'Votre annonce a été publiée avec succès.');
            }

            return redirect()->route('vendeur.mes-annonces')
                ->with('success', 'Votre annonce a été enregistrée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création annonce: ' . $e->getMessage());
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Affiche une annonce
     */
    public function show(Annonce $annonce)
    {
        $annonce->load(['vendeur.user', 'vendeur.professionnel', 'vendeur.pagePro', 'category', 'photos', 'video', 'options', 'produit', 'service', 'immobilier', 'vehicule', 'avisApprouves.user']);
        $annonce->incrementerVues();

        // Vérifier si l'utilisateur connecté peut laisser un avis
        $peutLaisserAvis = false;
        if (Auth::check()) {
            $existingAvis = \App\Models\Avis::where('annonce_id', $annonce->id)
                ->where('user_id', Auth::id())
                ->first();
            $peutLaisserAvis = !$existingAvis;
        }

        // Obtenir les recommandations
        $recommandations = $this->recommandationService->getAllRecommandations($annonce);

        // Statistiques de la boutique
        $vendeur = $annonce->vendeur;
        $annonceIds = $vendeur->annonces()->pluck('id');
        $boutique_rating = \App\Models\Avis::whereIn('annonce_id', $annonceIds)->avg('note') ?? 0;
        $boutique_sales = \App\Models\OrderItem::whereIn('annonce_id', $annonceIds)->count();
        $boutique_avis_count = \App\Models\Avis::whereIn('annonce_id', $annonceIds)->count();

        return view('annonces.show', compact('annonce', 'peutLaisserAvis', 'recommandations', 'boutique_rating', 'boutique_sales', 'boutique_avis_count'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Annonce $annonce)
    {
        $user = Auth::user();

        if ($annonce->vendeur_id !== $user->vendeur->id) {
            return redirect()->route('vendeur.mes-annonces')
                ->with('error', 'Vous n\'avez pas accès à cette annonce.');
        }

        $annonce->load([
            'produit',
            'service',
            'immobilier',
            'vehicule',
            'options',
            'filteredAttributes',
            'medias' => function ($query) {
                $query->where('type', 'photo')->orderBy('ordre');
            }
        ]);
        $categories = Category::actives()->parOrdre()->get();
        $creditServices = \App\Models\CreditServiceConfig::actif()->get();
        $creditBalance = $this->creditService->solde($user);
        $annoncesRestantes = $this->subscriptionService->getRemainingAnnonces($user->vendeur);

        return view("annonces.edit-{$annonce->type}", compact('annonce', 'categories', 'creditServices', 'creditBalance', 'annoncesRestantes'));
    }

    /**
     * Met à jour une annonce
     */
    public function update(Request $request, Annonce $annonce)
    {
        $user = Auth::user();

        if ($annonce->vendeur_id !== $user->vendeur->id) {
            return redirect()->route('vendeur.mes-annonces')
                ->with('error', 'Vous n\'avez pas accès à cette annonce.');
        }

        $validated = $this->validateAnnonce($request, $annonce->type, $annonce);

        try {
            $annonceData = array_merge($validated, ['attributes' => $request->input('attributes', [])]);
            $this->annonceService->mettreAJourAnnonce($annonce, $annonceData);

            // Gestion de la suppression des médias
            if ($request->has('delete_media_ids') && !empty($request->input('delete_media_ids'))) {
                $mediaIds = explode(',', $request->input('delete_media_ids'));
                foreach ($mediaIds as $mediaId) {
                    $media = $annonce->medias()->find($mediaId);
                    if ($media) {
                        // Supprimer le fichier du stockage
                        if ($media->chemin && Storage::exists($media->chemin)) {
                            Storage::delete($media->chemin);
                        }
                        // Supprimer l'enregistrement
                        $media->delete();
                    }
                }
            }

            // Upload de la vidéo si fournie
            if ($request->hasFile('video')) {
                $this->mediaService->uploadVideo($request->file('video'), $annonce->id);
                $annonce->update(['video_achetee' => true]);
                
                // Préparer les services pour activation automatique
                if (!isset($selectedServices)) {
                    $selectedServices = $request->input('services', []);
                }
                if (!in_array('video', $selectedServices)) {
                    $selectedServices[] = 'video';
                }
            }

            // Gestion des photos supplémentaires
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $ordre = $annonce->photos()->max('ordre') + 1;
                    $this->mediaService->uploadPhoto($photo, $annonce->id, false, $ordre);
                }
                $annonce->update(['nb_photos' => $annonce->photos()->count()]);
            }

            // Gestion des options payantes (consommation de crédits)
            if ($annonce->statut === Annonce::STATUT_PUBLIEE && ($request->has('services') || (isset($selectedServices) && !empty($selectedServices)))) {
                if (!isset($selectedServices)) {
                    $selectedServices = $request->input('services', []); // Array de clés comme ['video', 'boost']
                }
                $totalCost = 0;
                $configsToActivate = [];

                foreach ($selectedServices as $serviceKey) {
                    // Check if not already active to avoid double charging
                    $alreadyActive = \App\Models\AnnonceCreditService::where('annonce_id', $annonce->id)
                        ->where('service', $serviceKey)
                        ->actif()
                        ->exists();

                    if (!$alreadyActive) {
                        $config = \App\Models\CreditServiceConfig::where('cle', $serviceKey)->where('actif', true)->first();
                        if ($config) {
                            $totalCost += $config->credits_requis;
                            $configsToActivate[] = $config;
                        }
                    }
                }

                if ($totalCost > 0) {
                    if (!$this->creditService->aAssezDeCredits($user, $totalCost)) {
                        return back()->withInput()->with('error', "Annonce mise à jour, mais crédits insuffisants pour les NOUVELLES options choisies. Solde actuel : " . $this->creditService->solde($user) . " crédits.");
                    }

                    // Activer chaque nouveau service
                    foreach ($configsToActivate as $config) {
                        $this->creditService->activerService($user, $annonce, $config->cle);
                    }
                }
            }

            return redirect()->route('vendeur.mes-annonces')
                ->with('success', 'Annonce mise à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour annonce: ' . $e->getMessage());
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Publie une annonce (passe de brouillon à publiée)
     */
    public function publier(Annonce $annonce)
    {
        $user = Auth::user();

        if ($annonce->vendeur_id !== $user->vendeur->id) {
            return redirect()->route('vendeur.mes-annonces')
                ->with('error', 'Vous n\'avez pas accès à cette annonce.');
        }

        try {
            $this->annonceService->publierAnnonce($annonce);

            return redirect()->route('vendeur.mes-annonces')
                ->with('success', 'Annonce publiée avec succès !');
        } catch (\Exception $e) {
            return redirect()->route('vendeur.mes-annonces')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Supprime une annonce
     */
    public function destroy(Annonce $annonce)
    {
        $user = Auth::user();

        if ($annonce->vendeur_id !== $user->vendeur->id) {
            return redirect()->route('vendeur.mes-annonces')
                ->with('error', 'Vous n\'avez pas accès à cette annonce.');
        }

        try {
            // Supprimer tous les médias
            $this->mediaService->deleteAllMedia($annonce->id);

            // Supprimer l'annonce (cascade supprimera les relations)
            $annonce->delete();

            return redirect()->route('vendeur.mes-annonces')
                ->with('success', 'Annonce supprimée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression annonce: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de la suppression.');
        }
    }

    /**
     * Affiche le preview d'une annonce
     */
    public function preview(Annonce $annonce)
    {
        $user = Auth::user();

        if ($annonce->vendeur_id !== $user->vendeur->id) {
            return redirect()->route('vendeur.mes-annonces')
                ->with('error', 'Vous n\'avez pas accès à cette annonce.');
        }

        $annonce->load(['vendeur.user', 'vendeur.professionnel', 'vendeur.pagePro', 'category', 'photos', 'video', 'options', 'produit', 'service', 'immobilier', 'vehicule']);

        return view('annonces.preview', compact('annonce'));
    }

    /**
     * Valide les données d'une annonce selon son type
     */
    private function validateAnnonce(Request $request, string $type, ?Annonce $annonce = null): array
    {
        $rules = [
            'categorie_id' => ['required', 'exists:categories,id'],
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'statut' => ['nullable', 'in:brouillon,en_attente,publiee'],
            'user_phone' => ['nullable', 'string', 'max:255', Rule::unique('users', 'telephone')->ignore(Auth::id())],
            'code_postal' => ['nullable', 'string', 'max:255'],
        ];

        // Règles communes
        if ($type === Annonce::TYPE_PRODUIT || $type === Annonce::TYPE_IMMOBILIER || $type === Annonce::TYPE_VEHICULE) {
            $rules['prix'] = ['required', 'numeric', 'min:0'];
            $rules['prix_original'] = ['nullable', 'numeric', 'min:0'];
            $rules['type_livraison'] = ['nullable', 'in:retrait_boutique,retrait_point_relais,livraison_point_special'];
            $rules['disponibilite'] = ['nullable', 'in:en_stock,rupture_stock,sur_commande'];
        }

        // Règles spécifiques par type
        switch ($type) {
            case Annonce::TYPE_PRODUIT:
                $rules['marque'] = ['nullable', 'string', 'max:255'];
                $rules['modele'] = ['nullable', 'string', 'max:255'];
                $rules['etat'] = ['nullable', 'in:Neuf,Occasion,Reconditionné'];
                $rules['quantite'] = ['nullable', 'integer', 'min:1'];
                $rules['prix_moyen_marche'] = ['nullable', 'numeric', 'min:0'];
                break;

            case Annonce::TYPE_SERVICE:
                $rules['type_tarification'] = ['required', 'in:fixe,horaire,devis'];
                $rules['tarif_horaire'] = ['required_if:type_tarification,horaire', 'nullable', 'numeric', 'min:0'];
                $rules['duree_estimee'] = ['nullable', 'string', 'max:255'];
                $rules['deplacement_inclus'] = ['nullable', 'boolean'];
                $rules['zone_intervention'] = ['nullable', 'string', 'max:500'];
                break;

            case Annonce::TYPE_IMMOBILIER:
                $rules['type_transaction'] = ['required', 'in:vente,location'];
                $rules['prix_vente'] = ['required_if:type_transaction,vente', 'nullable', 'numeric', 'min:0'];
                $rules['loyer_mensuel'] = ['required_if:type_transaction,location', 'nullable', 'numeric', 'min:0'];
                $rules['surface'] = ['nullable', 'integer', 'min:1'];
                $rules['pieces'] = ['nullable', 'integer', 'min:1'];
                $rules['chambres'] = ['nullable', 'integer', 'min:0'];
                break;

            case Annonce::TYPE_VEHICULE:
                $rules['marque'] = ['required', 'string', 'max:255'];
                $rules['modele'] = ['required', 'string', 'max:255'];
                $rules['annee'] = ['nullable', 'integer', 'min:1900', 'max:' . date('Y')];
                $rules['kilometrage'] = ['nullable', 'integer', 'min:0'];
                $rules['carburant'] = ['nullable', 'string', 'max:50'];
                $rules['boite_vitesse'] = ['nullable', 'in:Manuelle,Automatique'];
                $rules['etat'] = ['nullable', 'in:Neuf,Occasion,Reconditionné'];
                $rules['couleur'] = ['nullable', 'string', 'max:50'];
                $rules['portes'] = ['nullable', 'integer', 'min:2', 'max:5'];
                $rules['places'] = ['nullable', 'integer', 'min:1'];
                break;
        }

        // Validation des photos
        if (!$annonce) {
            $rules['photos'] = ['required', 'array', 'min:1', 'max:8'];
            $rules['photos.*'] = ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120']; // 5 Mo max
        } else {
            $rules['photos'] = ['nullable', 'array', 'max:8'];
            $rules['photos.*'] = ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120'];
        }

        // Validation de la vidéo
        if ($request->hasFile('video')) {
            $rules['video'] = ['file', 'mimes:mp4,mov,avi', 'max:51200']; // 50 Mo max
        }

        // Validation des options
        $rules['options'] = ['nullable', 'array'];
        $rules['options.a_la_une'] = ['nullable', 'boolean'];
        $rules['options.urgent'] = ['nullable', 'boolean'];
        $rules['options.video'] = ['nullable', 'boolean'];
        $rules['options.republication_auto'] = ['nullable', 'boolean'];

        // Validation des variantes (Tailles, Couleurs, etc.)
        $rules['variantes'] = ['nullable', 'array'];
        $rules['variantes.*.type'] = ['required_with:variantes', 'string', 'in:taille,couleur,matiere,autre'];
        $rules['variantes.*.valeur'] = ['required_with:variantes', 'string', 'max:255'];
        $rules['variantes.*.stock'] = ['nullable', 'integer', 'min:0'];
        $rules['variantes.*.prix_supplementaire'] = ['nullable', 'numeric', 'min:0'];

        $messages = [
            'description.min' => 'La description doit contenir au moins :min caractères.',
            'etat.in' => "L'état sélectionné est invalide.",
            'user_phone.unique' => 'Ce numéro de téléphone est déjà utilisé par un autre compte.',
            'categorie_id.required' => 'La catégorie est requise.',
            'titre.required' => 'Le titre est requis.',
            'description.required' => 'La description est requise.',
            'prix.required' => 'Le prix est requis.',
            'photos.required' => 'Veuillez ajouter au moins 1 photo pour votre annonce.',
            'photos.min' => 'Il faut au minimum :min photo.',
            'photos.max' => 'Vous ne pouvez pas ajouter plus de :max photos.',
            'photos.*.image' => 'Le fichier doit être une image.',
        ];

        $validated = $request->validate($rules, $messages);

        // Calculer le prix pour les services
        if ($type === Annonce::TYPE_SERVICE && $validated['type_tarification'] === 'fixe') {
            $validated['prix'] = $request->input('prix');
        }

        return $validated;
    }

    /**
     * Affiche le formulaire d'import CSV
     */
    public function showImportForm()
    {
        // if (!$user->vendeur->estProfessionnel()) {
        //     return redirect()->route('vendeur.mes-annonces')
        //         ->with('error', 'Cette fonctionnalité est réservée aux vendeurs professionnels.');
        // }

        return view('annonces.import-csv');
    }

    /**
     * Traite l'upload et l'import du fichier CSV
     */
    public function importCSV(Request $request)
    {
        $user = Auth::user();
        $vendeur = $user->vendeur;

        $request->validate([
            'fichier_csv' => ['required', 'file', 'mimes:csv,txt', 'max:10240'], // 10 Mo max
            'statut' => ['nullable', 'in:brouillon,publiee'],
            'skip_errors' => ['nullable', 'boolean'],
        ]);

        try {
            // Sauvegarder le fichier temporairement
            $file = $request->file('fichier_csv');
            $filePath = $file->storeAs('temp', 'import_' . time() . '.csv', 'local');
            $fullPath = storage_path('app/' . $filePath);

            $options = [
                'statut' => $request->input('statut', 'brouillon'),
                'skip_errors' => $request->boolean('skip_errors', false),
                'batch_size' => 50,
            ];

            // Importer
            $rapport = $this->importService->importer($fullPath, $vendeur, $options);

            // Supprimer le fichier temporaire
            Storage::disk('local')->delete($filePath);

            return redirect()->route('vendeur.mes-annonces')
                ->with('success', "Import terminé: {$rapport['reussies']} annonce(s) créée(s), {$rapport['echecs']} échec(s).")
                ->with('import_rapport', $rapport);
        } catch (\Exception $e) {
            Log::error('Erreur import CSV: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }

    /**
     * Télécharge un template CSV
     */
    public function downloadTemplate(Request $request)
    {
        $type = $request->get('type', 'produit');
        $template = $this->importService->genererTemplate($type);

        $filename = "template_import_{$type}.csv";

        return response($template, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
