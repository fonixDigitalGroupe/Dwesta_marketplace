<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transporteur;
use App\Models\User;
use App\Services\DocumentUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransporteurController extends Controller
{
    protected $documentUploadService;

    public function __construct(DocumentUploadService $documentUploadService)
    {
        $this->documentUploadService = $documentUploadService;
    }

    /**
     * Liste de tous les transporteurs
     */
    public function index()
    {
        // On récupère les transporteurs existants
        $transporteurs = Transporteur::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        // On compte les transporteurs en attente
        $pendingCount = Transporteur::where('statut_verification', 'en_attente')->count();

        return view('admin.transporteurs.index', compact('transporteurs', 'pendingCount'));
    }

    /**
     * Voir les détails KYC d'un transporteur
     */
    public function show(Transporteur $transporteur)
    {
        $transporteur->load('user');

        // Préparation des URLs sécurisées pour les documents
        $documents = [
            'permis_recto' => $this->documentUploadService->getDocumentUrl($transporteur->permis_recto),
            'permis_verso' => $this->documentUploadService->getDocumentUrl($transporteur->permis_verso),
            'cni_recto' => $this->documentUploadService->getDocumentUrl($transporteur->cni_recto),
            'cni_verso' => $this->documentUploadService->getDocumentUrl($transporteur->cni_verso),
            'carte_grise' => $this->documentUploadService->getDocumentUrl($transporteur->carte_grise),
            'assurance' => $this->documentUploadService->getDocumentUrl($transporteur->assurance),
        ];

        return view('admin.transporteurs.show', compact('transporteur', 'documents'));
    }

    /**
     * Approuver le KYC d'un transporteur
     */
    public function approve(Request $request, Transporteur $transporteur)
    {
        try {
            $transporteur->update([
                'statut_verification' => 'verifie',
                'raison_rejet' => null,
            ]);

            // S'assurer que l'utilisateur a le rôle transporteur
            if (!$transporteur->user->hasRole('transporteur')) {
                $transporteur->user->assignRole('transporteur');
            }

            return redirect()->route('admin.transporteurs.index');
        } catch (\Exception $e) {
            Log::error('Erreur approbation transporteur: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'approbation.');
        }
    }

    /**
     * Rejeter le KYC d'un transporteur
     */
    public function reject(Request $request, Transporteur $transporteur)
    {
        $request->validate([
            'raison_rejet' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $transporteur->update([
                'statut_verification' => 'rejete',
                'raison_rejet' => $request->raison_rejet,
            ]);

            return redirect()->route('admin.transporteurs.index');
        } catch (\Exception $e) {
            Log::error('Erreur rejet transporteur: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du rejet.');
        }
    }

    /**
     * Show the form for creating a new transporteur.
     */
    public function create()
    {
        $users = User::role('transporteur')->get();
        return view('admin.transporteurs.create', compact('users'));
    }

    /**
     * Store a newly created transporteur.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:transporteurs,user_id',
            'type_vehicule' => 'required|string|max:255',
            'marque_vehicule' => 'required|string|max:255',
            'modele_vehicule' => 'required|string|max:255',
            'immatriculation' => 'required|string|max:255|unique:transporteurs,immatriculation',
            'numero_permis' => 'nullable|string|max:255',
            'photo_vehicule' => 'nullable|image|max:5120',
            'permis_recto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = $validated;

        // Upload des fichiers
        if ($request->hasFile('photo_vehicule')) {
            $data['photo_vehicule'] = $this->documentUploadService->uploadTransporteurDocument(
                $request->file('photo_vehicule'), 'vehicule', $request->user_id
            );
        }

        if ($request->hasFile('permis_recto')) {
            $data['permis_recto'] = $this->documentUploadService->uploadTransporteurDocument(
                $request->file('permis_recto'), 'permis', $request->user_id
            );
        }

        $transporteur = Transporteur::create(array_merge($data, [
            'statut_verification' => 'verifie', // Créé manuellement par admin = auto-vérifié
            'actif' => $request->has('actif')
        ]));

        // S'assurer que l'utilisateur a le rôle transporteur
        if (!$transporteur->user->hasRole('transporteur')) {
            $transporteur->user->assignRole('transporteur');
        }

        return redirect()->route('admin.transporteurs.index')->with('success', 'Transporteur créé avec succès.');
    }

    /**
     * Show the form for editing.
     */
    public function edit(Transporteur $transporteur)
    {
        return view('admin.transporteurs.edit', compact('transporteur'));
    }

    /**
     * Update the transporteur.
     */
    public function update(Request $request, Transporteur $transporteur)
    {
        $validated = $request->validate([
            'type_vehicule' => 'required|string|max:255',
            'marque_vehicule' => 'required|string|max:255',
            'modele_vehicule' => 'required|string|max:255',
            'immatriculation' => 'required|string|max:255|unique:transporteurs,immatriculation,' . $transporteur->id,
            'numero_permis' => 'nullable|string|max:255',
            'photo_vehicule' => 'nullable|image|max:5120',
            'permis_recto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = $validated;

        // Upload des fichiers
        if ($request->hasFile('photo_vehicule')) {
            // Optionnel : supprimer l'ancienne photo
            if ($transporteur->photo_vehicule) {
                $this->documentUploadService->deleteDocument($transporteur->photo_vehicule);
            }
            $data['photo_vehicule'] = $this->documentUploadService->uploadTransporteurDocument(
                $request->file('photo_vehicule'), 'vehicule', $transporteur->user_id
            );
        }

        if ($request->hasFile('permis_recto')) {
            // Optionnel : supprimer l'ancien permis
            if ($transporteur->permis_recto) {
                $this->documentUploadService->deleteDocument($transporteur->permis_recto);
            }
            $data['permis_recto'] = $this->documentUploadService->uploadTransporteurDocument(
                $request->file('permis_recto'), 'permis', $transporteur->user_id
            );
        }

        $transporteur->update(array_merge($data, [
            'actif' => $request->has('actif')
        ]));

        return redirect()->route('admin.transporteurs.index')->with('success', 'Transporteur mis à jour avec succès.');
    }

    /**
     * Remove the transporteur.
     */
    public function destroy(Transporteur $transporteur)
    {
        $transporteur->delete();
        return redirect()->route('admin.transporteurs.index')->with('success', 'Transporteur supprimé.');
    }
}
