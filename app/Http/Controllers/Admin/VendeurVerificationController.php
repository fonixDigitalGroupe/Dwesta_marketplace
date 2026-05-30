<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendeur;
use App\Services\DocumentUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendeurStatusUpdated;
use App\Models\Abonnement;
use App\Models\VendeurAbonnement;
use Carbon\Carbon;

class VendeurVerificationController extends Controller
{
    protected $documentUploadService;

    public function __construct(DocumentUploadService $documentUploadService)
    {
        $this->documentUploadService = $documentUploadService;
        // Le middleware 'auth' et 'role:Administrateur' sont déjà appliqués dans les routes
    }


    /**
     * Affiche les détails d'un vendeur pour vérification
     */
    public function show(Vendeur $vendeur)
    {
        $vendeur->load(['user', 'particulier', 'professionnel']);

        // Générer les URLs temporaires pour les documents
        // On affiche les docs particulier s'ils existent (même si le vendeur passe en Pro)
        if ($vendeur->particulier && $vendeur->particulier->document_path) {
            $vendeur->particulier->document_url = $this->documentUploadService->getDocumentUrl(
                $vendeur->particulier->document_path
            );
        }

        // On affiche les docs pro s'ils existent
        if ($vendeur->professionnel && $vendeur->professionnel->registre_commerce_path) {
            $vendeur->professionnel->registre_url = $this->documentUploadService->getDocumentUrl(
                $vendeur->professionnel->registre_commerce_path
            );
        }

        return view('admin.vendeurs.show', compact('vendeur'));
    }

    /**
     * Approuve un vendeur
     */
    public function approve(Request $request, Vendeur $vendeur)
    {
        $request->validate([
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            // Si c'est un particulier qui passe professionnel, on change son type maintenant
            $updateData = [
                'statut_verification' => 'verifie',
                'verifie_le' => now(),
                'verifie_par' => Auth::id(),
                'raison_rejet' => null,
            ];

            if ($vendeur->professionnel()->exists()) {
                $updateData['type'] = 'professionnel';
                
                // Supprimer les données particulier devenues obsolètes
                if ($vendeur->particulier) {
                    $vendeur->particulier->delete();
                }
            }

            $vendeur->update($updateData);

            // Attribution du rôle vendeur (avant cahier des charges)
            $vendeur->user->assignRole('vendeur');

            // Envoyer une notification au vendeur
            Mail::to($vendeur->user->email)->send(new VendeurStatusUpdated($vendeur));

            // Activation automatique du forfait gratuit s'il n'en a pas déjà un
            if (!$vendeur->abonnements()->where('actif', true)->exists()) {
                $abonnementGratuit = Abonnement::where('type', Abonnement::TYPE_GRATUIT)->first();
                if ($abonnementGratuit) {
                    VendeurAbonnement::create([
                        'vendeur_id' => $vendeur->id,
                        'abonnement_id' => $abonnementGratuit->id,
                        'date_debut' => Carbon::today(),
                        'date_fin' => Carbon::today()->addYears(10), // Longue durée pour le gratuit
                        'actif' => true,
                        'renouvellement_automatique' => false,
                        'nombre_annonces_utilisees' => 0,
                    ]);
                }
            }

            return redirect()->route('admin.users.index', ['role' => 'vendeur'])->with('success', 'Vendeur approuvé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur approbation vendeur: ' . $e->getMessage());

            return back()->with('error', 'Une erreur est survenue lors de l\'approbation.');
        }
    }

    /**
     * Rejette un vendeur
     */
    public function reject(Request $request, Vendeur $vendeur)
    {
        $request->validate([
            'raison_rejet' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $vendeur->update([
                'statut_verification' => 'rejete',
                'raison_rejet' => $request->raison_rejet,
                'verifie_le' => now(),
                'verifie_par' => Auth::id(),
            ]);

            // Envoyer une notification au vendeur avec la raison du rejet
            Mail::to($vendeur->user->email)->send(new VendeurStatusUpdated($vendeur));

            return redirect()->route('admin.users.index', ['role' => 'vendeur'])->with('info', 'Le dossier du vendeur a été rejeté.');
        } catch (\Exception $e) {
            Log::error('Erreur rejet vendeur: ' . $e->getMessage());

            return back()->with('error', 'Une erreur est survenue lors du rejet.');
        }
    }
}

