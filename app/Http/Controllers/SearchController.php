<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Affiche les résultats de la recherche avec filtres
     */
    public function index(Request $request)
    {
        $query = Annonce::publiees()->with(['photos', 'category', 'vendeur.user', 'options']);

        // Recherche textuelle
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('titre', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtre par catégorie
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->whereIn('categorie_id', $category->descendantsAndSelf()->pluck('id'));
            }
        }

        // Filtre par prix
        if ($request->filled('min_prix')) {
            $query->where('prix', '>=', $request->min_prix);
        }
        if ($request->filled('max_prix')) {
            $query->where('prix', '<=', $request->max_prix);
        }

        // Filtre par état (si applicable au type produit)
        if ($request->filled('etat')) {
            $etats = is_array($request->etat) ? $request->etat : [$request->etat];
            $query->whereIn('etat', $etats);
        }

        // Filtre par type de vendeur (Pro/Particulier)
        if ($request->filled('vendeur_type')) {
            $vendeurType = $request->vendeur_type;
            $query->whereHas('vendeur', function($q) use ($vendeurType) {
                $q->where('type', $vendeurType);
            });
        }

        // Tri
        $sort = $request->get('sort', 'relevance');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('prix', 'desc');
                break;
            case 'newest':
                $query->orderBy('publiee_le', 'desc');
                break;
            default:
                // Priorité aux annonces "À la une" puis par vues
                $query->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM annonce_options WHERE annonce_id = annonces.id AND a_la_une = 1) THEN 0 ELSE 1 END")
                      ->orderBy('vues', 'desc');
                break;
        }

        $annonces = $query->paginate(24)->withQueryString();
        
        // Données pour la sidebar de filtres
        $categories = Category::whereNull('parent_id')->with('enfantsActifs')->get();
        
        return view('search.index', compact('annonces', 'categories'));
    }

    /**
     * Autocomplétion pour la barre de recherche
     */
    public function autocomplete(Request $request)
    {
        $term = $request->get('q');
        if (!$term || strlen($term) < 2) {
            return response()->json([]);
        }

        // 1. Suggestions de catégories
        $categories = Category::where('nom', 'LIKE', "%{$term}%")
            ->where('actif', true)
            ->limit(3)
            ->get(['nom', 'slug'])
            ->map(function($c) {
                return [
                    'type' => 'category',
                    'label' => "Dans la catégorie : {$c->nom}",
                    'url' => route('categories.show', $c->slug)
                ];
            });

        // 2. Suggestions de produits
        $produits = Annonce::publiees()
            ->where('titre', 'LIKE', "%{$term}%")
            ->limit(5)
            ->get(['id', 'titre', 'slug'])
            ->map(function($a) {
                return [
                    'type' => 'product',
                    'label' => $a->titre,
                    'url' => route('annonces.show', $a->slug)
                ];
            });

        return response()->json($categories->merge($produits));
    }
}
