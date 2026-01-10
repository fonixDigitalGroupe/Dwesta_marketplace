<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendeur;
use App\Services\DocumentUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VendeurVerificationController extends Controller
{
    protected $documentUploadService;

    public function __construct(DocumentUploadService $documentUploadService)
    {
        $this->documentUploadService = $documentUploadService;
        // Le middleware 'auth' et 'role:Administrateur' sont déjà appliqués dans les routes
    }

    /**
     * Liste des vendeurs en attente de vérification
     */
    public function index()
    {
        $vendeursEnAttente = Vendeur::where('statut_verification', 'en_attente')
            ->with(['user', 'particulier', 'professionnel'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.vendeurs.verification', compact('vendeursEnAttente'));
    }

    /**
     * Affiche les détails d'un vendeur pour vérification
     */
    public function show(Vendeur $vendeur)
    {
        $vendeur->load(['user', 'particulier', 'professionnel']);

        // Générer les URLs temporaires pour les documents
        if ($vendeur->estParticulier() && $vendeur->particulier) {
            $vendeur->particulier->document_url = $this->documentUploadService->getDocumentUrl(
                $vendeur->particulier->document_path
            );
        }

        if ($vendeur->estProfessionnel() && $vendeur->professionnel) {
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
            $vendeur->update([
                'statut_verification' => 'verifie',
                'verifie_le' => now(),
                'verifie_par' => Auth::id(),
                'raison_rejet' => null,
            ]);

            // TODO: Envoyer une notification au vendeur

            return redirect()->route('admin.vendeurs.verification.index')
                ->with('success', 'Vendeur approuvé avec succès.');
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

            // TODO: Envoyer une notification au vendeur avec la raison du rejet

            return redirect()->route('admin.vendeurs.verification.index')
                ->with('success', 'Vendeur rejeté avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur rejet vendeur: ' . $e->getMessage());

            return back()->with('error', 'Une erreur est survenue lors du rejet.');
        }
    }
}

