<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;

class BannerLandingController extends Controller
{
    /**
     * Affiche la page de destination dédiée d'une bannière
     */
    public function show(string $slug)
    {
        $banner = Banner::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        $categoryIds = [];
        $category = null;

        if ($banner->category_id) {
            $category = Category::where('id', $banner->category_id)
                ->where('actif', true)
                ->with(['parent', 'enfantsActifs.enfantsActifs'])
                ->first();
            
            if ($category) {
                // On récupère la catégorie cible et tous ses descendants
                $categoryIds = $category->getAllDescendantIds()->toArray();
            }
        }

        $query = Annonce::publiees();
        
        if (!empty($categoryIds)) {
            $query->whereIn('categorie_id', $categoryIds);
        }

        $query->with(['photos', 'category.parent', 'vendeur.user', 'options', 'produit', 'vehicule']);

        // Tri par défaut : Pertinence (Boosted, Pro, Latest)
        $sort = request('sort', 'relevance');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('prix', 'desc');
                break;
            default:
                $query
                    ->leftJoin('vendeurs', 'vendeurs.id', '=', 'annonces.vendeur_id')
                    ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM annonce_options WHERE annonce_id = annonces.id AND a_la_une = 1) THEN 0 ELSE 1 END")
                    ->orderByRaw("CASE WHEN vendeurs.type = 'professionnel' THEN 0 ELSE 1 END")
                    ->latest('annonces.publiee_le')
                    ->select('annonces.*');
                break;
        }

        $annonces = $query->paginate(24)->withQueryString();

        // Sections bonus pour une page "Landing" riche
        $topConsultes = collect();
        if (!empty($categoryIds)) {
            $topConsultes = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->orderBy('vues', 'desc')
                ->limit(12)
                ->get();
        }

        return view('banners.landing', compact(
            'banner', 
            'category', 
            'annonces',
            'topConsultes'
        ));
    }
}
