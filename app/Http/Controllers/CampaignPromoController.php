<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignPromoController extends Controller
{
    /**
     * Vérifie si une catégorie a une campagne active et si le code promo est valide.
     * GET /api/campaigns/check-promo?code=CODE&categorie_id=123
     */
    public function check(Request $request)
    {
        try {
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

            $user = auth()->user();
            $sellerType = ($user && $user->vendeur) ? $user->vendeur->type : 'particulier';
            $categoryIds = $this->getAncestorIds($category);

            // Trouver un coupon actif dont la cible (niveau le plus profond renseigné)
            // correspond à la catégorie de l'annonce ou à l'un de ses ancêtres.
            $coupon = Coupon::where('code', $code)
                ->where('is_active', true)
                ->whereIn(DB::raw('COALESCE(category_id, category_id_n2, category_id_n1)'), $categoryIds)
                ->where(function ($q) use ($sellerType) {
                    $q->where('seller_type', 'all')
                      ->orWhere('seller_type', $sellerType);
                })
                ->first();

            if (!$coupon) {
                return response()->json(['valid' => false, 'message' => 'Code promo invalide, expiré ou non applicable à votre profil/catégorie.']);
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

            // Determine the dates (Campaign priority, then Coupon)
            $startsAt = $campaign->starts_at ?? $coupon->start_date;
            $endsAt = $campaign->ends_at ?? $coupon->end_date;

            return response()->json([
                'valid'            => true,
                'discount_type'    => $coupon->type,
                'discount_value'   => $coupon->value,
                'campaign_starts_at' => $startsAt ? $startsAt->toIsoString() : null,
                'campaign_ends_at' => $endsAt ? $endsAt->toIsoString() : null,
                'campaign_id'      => $campaign->id,
                'coupon_id'        => $coupon->id,
            ]);
        } catch (\Exception $e) {
            \Log::error('Promo check error: ' . $e->getMessage());
            return response()->json(['valid' => false, 'message' => 'Une erreur est survenue lors de la vérification.']);
        }
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
                  ->whereIn(DB::raw('COALESCE(category_id, category_id_n2, category_id_n1)'), $categoryIds);
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
