<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Coupon;

class PromotionController extends Controller
{
    /**
     * Tableau de bord Promotions
     */
    public function index()
    {
        // Statistiques rapides
        $totalBanners       = Banner::count();
        $activeBanners      = Banner::where('active', true)->count();
        $expiredBanners     = Banner::where('active', true)
                                ->whereNotNull('end_date')
                                ->where('end_date', '<', now())
                                ->count();

        $totalCoupons       = Coupon::count();
        $activeCoupons      = Coupon::where('is_active', true)->count();

        // Dernières bannières actives
        $latestBanners = Banner::where('active', true)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // Derniers codes promo actifs
        $latestCoupons = Coupon::where('is_active', true)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return view('admin.promotions.index', compact(
            'totalBanners', 'activeBanners', 'expiredBanners',
            'totalCoupons', 'activeCoupons',
            'latestBanners', 'latestCoupons'
        ));
    }
}
