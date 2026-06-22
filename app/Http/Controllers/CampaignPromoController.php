<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CampaignPromoController extends Controller
{
    /**
     * Vérifie si une catégorie a une campagne active et si le code promo est valide.
     * GET /api/campaigns/check-promo?code=CODE&categorie_id=123
     */
    public function check(Request $request)
    {
        $code = strtoupper(trim($request->query('code', '')));
        $categorieId = intval($request->query('categorie_id', 0));

        if (!$code || !$categorieId) {
            return response()->json(['valid' => false, 'message' => 'Paramètres manquants.']);
        }

        // Récupérer la catégorie et ses parents jusqu'au N1
        $category = Category::find($categorieId);
        if (!$category) {
            return response()->json(['valid' => false, 'message' => 'Catégorie introuvable.']);
        }

        // Collecter tous les IDs parents (N1, N2, N3 = la catégorie elle-même)
        $categoryIds = $this->getAncestorIds($category);

        // Trouver un coupon actif correspondant à ce code et à cette famille de catégories
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->where(function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds)
                  ->orWhereIn('category_id_n1', $categoryIds)
                  ->orWhereIn('category_id_n2', $categoryIds);
            })
            ->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Code promo invalide ou non applicable à cette catégorie.']);
        }

        // Vérifier si une campagne active est liée à ce coupon
        $campaign = Campaign::where('coupon_id', $coupon->id)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->first();

        if (!$campaign) {
            return response()->json(['valid' => false, 'message' => 'Aucune campagne active pour ce code.']);
        }

        return response()->json([
            'valid'            => true,
            'discount_type'    => $coupon->type,   // 'percent' ou 'fixed'
            'discount_value'   => $coupon->value,
            'campaign_ends_at' => $campaign->ends_at?->toIsoString(),
            'campaign_id'      => $campaign->id,
            'coupon_id'        => $coupon->id,
        ]);
    }

    /**
     * Vérifie si une catégorie a une campagne active (utilisé pour afficher le champ promo).
     * GET /api/campaigns/has-active?categorie_id=123
     */
    public function hasActive(Request $request)
    {
        $categorieId = intval($request->query('categorie_id', 0));

        if (!$categorieId) {
            return response()->json(['has_campaign' => false]);
        }

        $category = Category::find($categorieId);
        if (!$category) {
            return response()->json(['has_campaign' => false]);
        }

        $categoryIds = $this->getAncestorIds($category);

        $hasCampaign = Campaign::whereHas('coupon', function ($q) use ($categoryIds) {
                $q->where('is_active', true)
                  ->where(function ($sq) use ($categoryIds) {
                      $sq->whereIn('category_id', $categoryIds)
                        ->orWhereIn('category_id_n1', $categoryIds)
                        ->orWhereIn('category_id_n2', $categoryIds);
                  });
            })
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->exists();

        return response()->json(['has_campaign' => $hasCampaign]);
    }

    /**
     * Retourne les IDs de la catégorie et de tous ses ancêtres.
     */
    private function getAncestorIds(Category $category): array
    {
        $ids = [$category->id];
        $current = $category;
        while ($current->parent_id) {
            $ids[] = $current->parent_id;
            $current = Category::find($current->parent_id);
            if (!$current) break;
        }
        return $ids;
    }
}
