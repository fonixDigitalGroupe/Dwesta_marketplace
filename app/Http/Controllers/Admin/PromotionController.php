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

        // Toutes les annonces ayant adhéré à un coupon (actives comme inactives) :
        // une annonce reste listée même après désactivation du coupon, avec un
        // statut « Inactif » et son prix initial rétabli.
        $adherents = \App\Models\Annonce::whereNotNull('coupon_code')
            ->where('coupon_code', '!=', '')
            ->with(['vendeur.user', 'vendeur.professionnel', 'vendeur.particulier', 'category'])
            ->latest('updated_at')
            ->paginate(20, ['*'], 'adherents_page')
            ->appends($request->only(['search', 'per_page', 'coupons_page', 'campaigns_page']));

        // Coupons des adhérents, indexés par code, pour déterminer le statut
        // (actif/inactif) de chaque adhésion d'après l'état réel du coupon.
        $adherentCoupons = Coupon::whereIn('code', $adherents->pluck('coupon_code')->filter()->unique())
            ->get()
            ->keyBy('code');

        return view('admin.promotions.index', compact('coupons', 'campaigns', 'adherents', 'adherentCoupons'));
    }
}
