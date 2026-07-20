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
    public function index(Request $request)
    {
        $query = Livreur::with('user');

        // Filtre par statut de vérification
        if ($request->filled('statut') && in_array($request->statut, ['en_attente', 'verifie', 'rejete'])) {
            $query->where('statut_verification', $request->statut);
        }

        // Filtre par pays (colonne users.pays)
        if ($request->filled('pays')) {
            $query->whereHas('user', fn ($q) => $q->where('pays', $request->pays));
        }

        // Recherche libre (nom, email, téléphone, véhicule)
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->whereHas('user', fn ($u) => $u->where('prenom', 'like', "%{$s}%")
                        ->orWhere('nom', 'like', "%{$s}%")
                        ->orWhere('email', 'like', "%{$s}%")
                        ->orWhere('telephone', 'like', "%{$s}%"))
                  ->orWhere('type_vehicule', 'like', "%{$s}%");
            });
        }

        $livreurs = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();

        $pendingCount = Livreur::where('statut_verification', 'en_attente')->count();

        // Liste des pays (table countries)
        $paysDisponibles = \App\Models\Country::orderBy('name')->pluck('name')->all();

        return view('admin.livreurs.index', compact('livreurs', 'pendingCount', 'paysDisponibles'));
    }

    /**
     * Voir les détails KYC d'un livreur
     */
    public function show(Livreur $livreur)
    {
        $livreur->load('user');

        $documents = [
            // Documents « hub » (livreur créé côté admin) → disque privé
            'document_recto' => $this->documentUploadService->getDocumentUrl($livreur->document_recto),
            'document_verso' => $this->documentUploadService->getDocumentUrl($livreur->document_verso),
            // Documents renseignés via la PWA partenaire → disque public de karnou-pwa
            'document_piece' => $this->pwaPublicUrl($livreur->document_piece),
            'photo_vehicule' => $this->pwaPublicUrl($livreur->photo_vehicule),
        ];

        // Le pays n'est pas stocké : comme dans karnou-pwa, on le déduit de
        // l'indicatif téléphonique du livreur (phone_code du pays).
        $pays = $this->paysDepuisTelephone($livreur->user->telephone ?? null)
            ?? $livreur->user->pays;

        return view('admin.livreurs.show', compact('livreur', 'documents', 'pays'));
    }

    /**
     * Déduit le pays d'un numéro de téléphone via l'indicatif (phone_code),
     * en privilégiant l'indicatif le plus long.
     */
    private function paysDepuisTelephone(?string $telephone): ?string
    {
        if (!$telephone) {
            return null;
        }

        return \App\Models\Country::query()
            ->whereNotNull('phone_code')
            ->get(['name', 'phone_code'])
            ->sortByDesc(fn ($c) => strlen($c->phone_code))
            ->first(fn ($c) => $c->phone_code && str_starts_with($telephone, $c->phone_code))
            ?->name;
    }

    /**
     * Construit l'URL publique d'un document téléversé via la PWA partenaire.
     *
     * karnou-pwa stocke ces fichiers sur son disque "public" (partenaire/...).
     * Le hub partage la base mais pas le storage : on préfixe donc le chemin
     * relatif par l'URL publique de la PWA (config services.partenaire.url).
     */
    private function pwaPublicUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // Servi par le hub depuis le disque partagé (route admin authentifiée).
        return route('admin.partenaire-document', ['path' => ltrim($path, '/')]);
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
        $users = User::whereHas('roles', fn($q) => $q->where('name', 'livreur'))->get();
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
     * Remove the livreur.
     */
    public function destroy(Livreur $livreur)
    {
        $livreur->delete();
        return redirect()->route('admin.livreurs.index')->with('success', 'Livreur supprimé.');
    }
}
