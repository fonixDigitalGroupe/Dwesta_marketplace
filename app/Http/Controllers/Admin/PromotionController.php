<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Liste des codes promo (style banners)
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $search  = $request->input('search');

        $coupons = Coupon::withCount('campaigns')
            ->when($search, function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'coupons_page')
            ->appends($request->only(['search', 'per_page', 'campaigns_page']));

        $campaigns = \App\Models\Campaign::with('coupon')
            ->latest()
            ->paginate(10, ['*'], 'campaigns_page')
            ->appends($request->only(['search', 'per_page', 'coupons_page']));

        return view('admin.promotions.index', compact('coupons', 'campaigns'));
    }
}
