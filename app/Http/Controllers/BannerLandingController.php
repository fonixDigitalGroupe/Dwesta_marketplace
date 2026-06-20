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

        $categoryIds = collect();
        
        // 1. Catégorie principale directe
        if ($banner->category_id) {
            $cat = Category::find($banner->category_id);
            if ($cat) {
                $categoryIds = $categoryIds->merge($cat->getAllDescendantIds());
            }
        }

        // 2. Catégories via la relation pivot
        $pivotCategories = $banner->categories;
        foreach ($pivotCategories as $pivotCat) {
            $categoryIds = $categoryIds->merge($pivotCat->getAllDescendantIds());
        }

        $categoryIds = $categoryIds->unique()->toArray();

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

        // Sections par état (Rakuten Style)
        $produitsNeufs = collect();
        $produitsOccasion = collect();
        if (!empty($categoryIds)) {
            $produitsNeufs = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->whereHas('produit', function($q) {
                    $q->whereIn('etat', ['Neuf', 'neuf']);
                })
                ->latest()
                ->limit(10)
                ->get();

            $produitsOccasion = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->whereHas('produit', function($q) {
                    $q->whereIn('etat', ['Occasion', 'occasion']);
                })
                ->latest()
                ->limit(10)
                ->get();
        }

        return view('banners.landing', compact(
            'banner', 
            'category', 
            'annonces',
            'topConsultes',
            'produitsNeufs',
            'produitsOccasion'
        ));
    }
}
