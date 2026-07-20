<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    /**
     * Liste des annonces avec filtres
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        $perPage = $request->get('per_page', 8);
        $cat1 = $request->get('cat1');
        $cat2 = $request->get('cat2');
        $cat3 = $request->get('cat3');

        $query = Annonce::with(['vendeur.user', 'categorie'])->latest();

        // Filtre par statut
        if (!empty($status)) {
            $query->where('statut', $status);
        }

        // Filtre par catégorie (le niveau le plus profond sélectionné + descendants)
        $selectedCat = $cat3 ?: ($cat2 ?: $cat1);
        if (!empty($selectedCat)) {
            $query->whereIn('categorie_id', $this->categoryWithDescendants((int) $selectedCat));
        }

        // Recherche par titre ou vendeur
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhereHas('vendeur.user', function($u) use ($search) {
                      $u->where('prenom', 'like', "%{$search}%")
                        ->orWhere('nom', 'like', "%{$search}%");
                  });
            });
        }

        $annonces = $query->paginate($perPage)->withQueryString();

        // Listes des catégories pour les filtres en cascade
        $categoriesN1 = \App\Models\Category::whereNull('parent_id')->where('actif', true)
            ->orderBy('ordre')->orderBy('nom')->get(['id', 'nom']);
        $categoriesN2 = $cat1
            ? \App\Models\Category::where('parent_id', $cat1)->where('actif', true)->orderBy('ordre')->orderBy('nom')->get(['id', 'nom'])
            : collect();
        $categoriesN3 = $cat2
            ? \App\Models\Category::where('parent_id', $cat2)->where('actif', true)->orderBy('ordre')->orderBy('nom')->get(['id', 'nom'])
            : collect();

        return view('admin.annonces.index', compact('annonces', 'status', 'search', 'perPage', 'cat1', 'cat2', 'cat3', 'categoriesN1', 'categoriesN2', 'categoriesN3'));
    }

    /**
     * Retourne l'id d'une catégorie et de tous ses descendants (récursif).
     */
    private function categoryWithDescendants(int $id): array
    {
        $ids = [$id];
        foreach (\App\Models\Category::where('parent_id', $id)->pluck('id') as $childId) {
            $ids = array_merge($ids, $this->categoryWithDescendants((int) $childId));
        }
        return $ids;
    }

    /**
     * Approuve une annonce (Modération)
     */
    public function approve(Annonce $annonce)
    {
        $annonce->update([
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'expire_le' => now()->addMonths(6), // Durée par défaut si non spécifiée
        ]);
        
        return back()->with('success', 'L\'annonce a été publiée avec succès.');
    }

    /**
     * Rejette une annonce (Modération)
     */
    public function reject(Request $request, Annonce $annonce)
    {
        $request->validate([
            'raison_rejet' => 'nullable|string|max:1000'
        ]);

        $annonce->update([
            'statut' => Annonce::STATUT_REJETEE,
            'raison_rejet' => $request->raison_rejet
        ]);

        // Envoyer l'email de notification au vendeur
        try {
            \Illuminate\Support\Facades\Mail::to($annonce->vendeur->user->email)->send(new \App\Mail\AnnonceRejected($annonce));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur lors de l'envoi de l'email de rejet d'annonce : " . $e->getMessage());
        }

        return back()->with('info', 'L\'annonce a été rejetée et le vendeur a été notifié.');
    }
}
