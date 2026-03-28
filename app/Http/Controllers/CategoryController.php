<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Affiche les annonces d'une catégorie
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('actif', true)
            ->with(['parent', 'enfantsActifs.enfantsActifs'])
            ->firstOrFail();

        // Charger les annonces de cette catégorie et de ses enfants
        $categoryIds = $category->getAllDescendantIds();
        
        $query = Annonce::publiees()
            ->whereIn('categorie_id', $categoryIds)
            ->with(['photos', 'category', 'vendeur.user', 'options', 'produit', 'vehicule']);

        // Tri
        $sort = request('sort', 'relevance');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('prix', 'desc');
                break;
            default:
                // Priorité : 1) Sponsorisé | 2) Vendeurs pro | 3) Date
                $query
                    ->leftJoin('vendeurs', 'vendeurs.id', '=', 'annonces.vendeur_id')
                    ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM annonce_options WHERE annonce_id = annonces.id AND a_la_une = 1) THEN 0 ELSE 1 END")
                    ->orderByRaw("CASE WHEN vendeurs.type = 'professionnel' THEN 0 ELSE 1 END")
                    ->latest('annonces.publiee_le')
                    ->select('annonces.*');
                break;
        }

        $annonces = $query->paginate(24)->withQueryString();

        return view('categories.show', compact('category', 'annonces'));
    }

    public function getFilters(Category $category)
    {
        return response()->json($category->filters()->orderBy('ordre')->get());
    }
}
