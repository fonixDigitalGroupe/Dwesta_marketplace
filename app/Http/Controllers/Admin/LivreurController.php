<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livreur;
use App\Models\User;
use App\Services\DocumentUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LivreurController extends Controller
{
    protected $documentUploadService;

    public function __construct(DocumentUploadService $documentUploadService)
    {
        $this->documentUploadService = $documentUploadService;
    }

    /**
     * Liste de tous les livreurs
     */
    public function index()
    {
        $livreurs = Livreur::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        $pendingCount = Livreur::where('statut_verification', 'en_attente')->count();

        return view('admin.livreurs.index', compact('livreurs', 'pendingCount'));
    }

    /**
     * Voir les détails KYC d'un livreur
     */
    public function show(Livreur $livreur)
    {
        $livreur->load('user');

        $documents = [
            'document_recto' => $this->documentUploadService->getDocumentUrl($livreur->document_recto),
            'document_verso' => $this->documentUploadService->getDocumentUrl($livreur->document_verso),
        ];

        return view('admin.livreurs.show', compact('livreur', 'documents'));
    }

    /**
     * Approuver le KYC d'un livreur
     */
    public function approve(Request $request, Livreur $livreur)
    {
        try {
            $livreur->update([
                'statut_verification' => 'verifie',
                'raison_rejet' => null,
            ]);

            if (!$livreur->user->hasRole('livreur')) {
                $livreur->user->assignRole('livreur');
            }

            return redirect()->route('admin.livreurs.index');
        } catch (\Exception $e) {
            Log::error('Erreur approbation livreur: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'approbation.');
        }
    }

    /**
     * Rejeter le KYC d'un livreur
     */
    public function reject(Request $request, Livreur $livreur)
    {
        $request->validate([
            'raison_rejet' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $livreur->update([
                'statut_verification' => 'rejete',
                'raison_rejet' => $request->raison_rejet,
            ]);

            return redirect()->route('admin.livreurs.index');
        } catch (\Exception $e) {
            Log::error('Erreur rejet livreur: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du rejet.');
        }
    }

    /**
     * Show the form for creating a new livreur.
     */
    public function create()
    {
        $users = User::role('livreur')->get();
        return view('admin.livreurs.create', compact('users'));
    }

    /**
     * Store a newly created livreur.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:livreurs,user_id',
            'type_vehicule' => 'required|in:Moto,Voiture',
            'type_document' => 'required|in:CNI,Passport,Titre de séjour',
            'numero_document' => 'nullable|string|max:255',
            'document_recto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'document_verso' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = $validated;

        if ($request->hasFile('document_recto')) {
            $data['document_recto'] = $this->documentUploadService->uploadLivreurDocument(
                $request->file('document_recto'), 'kyc', $request->user_id
            );
        }

        if ($request->hasFile('document_verso')) {
            $data['document_verso'] = $this->documentUploadService->uploadLivreurDocument(
                $request->file('document_verso'), 'kyc', $request->user_id
            );
        }

        $livreur = Livreur::create(array_merge($data, [
            'statut_verification' => 'verifie',
            'actif' => $request->has('actif')
        ]));

        if (!$livreur->user->hasRole('livreur')) {
            $livreur->user->assignRole('livreur');
        }

        return redirect()->route('admin.livreurs.index')->with('success', 'Livreur créé avec succès.');
    }

    /**
     * Show the form for editing.
     */
    public function edit(Livreur $livreur)
    {
        return view('admin.livreurs.edit', compact('livreur'));
    }

    /**
     * Update the livreur.
     */
    public function update(Request $request, Livreur $livreur)
    {
        $validated = $request->validate([
            'type_vehicule' => 'required|in:Moto,Voiture',
            'type_document' => 'required|in:CNI,Passport,Titre de séjour',
            'numero_document' => 'nullable|string|max:255',
            'document_recto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'document_verso' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = $validated;

        if ($request->hasFile('document_recto')) {
            if ($livreur->document_recto) {
                $this->documentUploadService->deleteDocument($livreur->document_recto);
            }
            $data['document_recto'] = $this->documentUploadService->uploadLivreurDocument(
                $request->file('document_recto'), 'kyc', $livreur->user_id
            );
        }

        if ($request->hasFile('document_verso')) {
            if ($livreur->document_verso) {
                $this->documentUploadService->deleteDocument($livreur->document_verso);
            }
            $data['document_verso'] = $this->documentUploadService->uploadLivreurDocument(
                $request->file('document_verso'), 'kyc', $livreur->user_id
            );
        }

        $livreur->update(array_merge($data, [
            'actif' => $request->has('actif')
        ]));

        return redirect()->route('admin.livreurs.index')->with('success', 'Livreur mis à jour avec succès.');
    }

    /**
     * Remove the livreur.
     */
    public function destroy(Livreur $livreur)
    {
        $livreur->delete();
        return redirect()->route('admin.livreurs.index')->with('success', 'Livreur supprimé.');
    }
}
