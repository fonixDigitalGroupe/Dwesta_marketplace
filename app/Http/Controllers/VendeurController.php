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

class VendeurController extends Controller
{
    protected $documentUploadService;
    protected $documentNotificationService;

    public function __construct(DocumentUploadService $documentUploadService, DocumentNotificationService $documentNotificationService)
    {
        $this->documentUploadService = $documentUploadService;
        $this->documentNotificationService = $documentNotificationService;
    }

    /**
     * Affiche le formulaire de création de compte vendeur
     */
    public function create()
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est déjà vendeur
        if ($user->estVendeur()) {
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

        // Vérifier si l'utilisateur est déjà vendeur
        if ($user->estVendeur()) {
            return redirect()->route('vendeur.show')->with('error', 'Vous avez déjà un compte vendeur.');
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

            // Créer le vendeur
            $vendeur = Vendeur::create([
                'user_id' => $user->id,
                'type' => 'particulier',
                'statut_verification' => 'en_attente',
                'actif' => true,
            ]);

            // Upload du document
            $documentPath = $this->documentUploadService->uploadDocument(
                $request->file('document'),
                $request->type_document,
                $vendeur->id
            );

            // Créer le vendeur particulier
            VendeurParticulier::create([
                'vendeur_id' => $vendeur->id,
                'type_document' => $request->type_document,
                'numero_document' => $request->numero_document,
                'document_path' => $documentPath,
                'date_emission_document' => $request->date_emission_document,
                'date_expiration_document' => $request->date_expiration_document,
                'lieu_emission' => $request->lieu_emission,
            ]);

            // Assigner le rôle Vendeur Particulier
            $user->assignRole('Vendeur Particulier');

            DB::commit();

            return redirect()->route('vendeur.show')->with('success', 'Votre demande de compte vendeur a été soumise avec succès. Elle sera vérifiée par un administrateur.');
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

        // Vérifier si l'utilisateur est déjà vendeur
        if ($user->estVendeur()) {
            return redirect()->route('vendeur.show')->with('error', 'Vous avez déjà un compte vendeur.');
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

            // Créer le vendeur
            $vendeur = Vendeur::create([
                'user_id' => $user->id,
                'type' => 'professionnel',
                'statut_verification' => 'en_attente',
                'actif' => true,
            ]);

            // Upload du registre de commerce
            $registrePath = $this->documentUploadService->uploadDocument(
                $request->file('registre_commerce'),
                'registre_commerce',
                $vendeur->id
            );

            // Créer le vendeur professionnel
            VendeurProfessionnel::create([
                'vendeur_id' => $vendeur->id,
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
            ]);

            // Assigner le rôle Vendeur Professionnel
            $user->assignRole('Vendeur Professionnel');

            DB::commit();

            return redirect()->route('vendeur.show')->with('success', 'Votre demande de compte vendeur professionnel a été soumise avec succès. Elle sera vérifiée par un administrateur.');
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
            return redirect()->route('vendeur.create')->with('info', 'Vous devez créer un compte vendeur pour accéder à cette page.');
        }

        $vendeur = $user->vendeur;
        $vendeur->load(['particulier', 'professionnel', 'abonnementActif.abonnement', 'pagePro']);

        // Récupérer les alertes d'expiration
        $alertes = $this->documentNotificationService->getAlertesActives($vendeur);

        return view('vendeur.show', compact('vendeur', 'alertes'));
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

            return redirect()->route('vendeur.show')->with('success', 'Document mis à jour avec succès. Votre compte sera revérifié par un administrateur.');
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

            return redirect()->route('vendeur.show')->with('success', 'Informations mises à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour document professionnel: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }
}

