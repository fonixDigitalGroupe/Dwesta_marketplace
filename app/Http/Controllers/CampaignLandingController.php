<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Annonce;
use Illuminate\Http\Request;

class CampaignLandingController extends Controller
{
    /**
     * Affiche la page de destination dédiée d'une campagne promotionnelle.
     */
    public function show(Campaign $campaign)
    {
        $coupon = $campaign->coupon;
        if (!$coupon) {
            return redirect()->route('home')->with('error', 'Aucun coupon associé à cette campagne.');
        }

        $categoryIds = collect();
        $category = null;

        // 1. Récupérer les catégories du coupon
        $couponCatIds = collect([$coupon->category_id, $coupon->category_id_n1, $coupon->category_id_n2])
            ->filter()
            ->unique();

        foreach ($couponCatIds as $catId) {
            $cat = Category::find($catId);
            if ($cat) {
                $categoryIds = $categoryIds->merge($cat->getAllDescendantIds());
                if (!$category) $category = $cat; // Pour le fil d'ariane
            }
        }

        $categoryIds = $categoryIds->unique()->toArray();

        $query = Annonce::publiees();
        
        if (!empty($categoryIds)) {
            $query->whereIn('categorie_id', $categoryIds);
        }

        // Uniquement les annonces ayant appliqué la promo
        $query->whereNotNull('prix_original')
              ->whereColumn('prix_original', '>', 'prix');
        
        if ($campaign->ends_at) {
            $query->where('promo_expires_at', $campaign->ends_at);
        }

        $query->with(['photos', 'category.parent', 'vendeur.user', 'options', 'produit', 'vehicule']);

        // Tri par défaut : Pertinence
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

        return view('campaigns.landing', compact(
            'campaign', 
            'coupon',
            'category', 
            'annonces'
        ));
    }
}
