<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Category;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('category')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $n1Categories = Category::whereNull('parent_id')->get();
        $allCategories = Category::orderBy('nom')->get();
        return view('admin.coupons.create', compact('n1Categories', 'allCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'category_id_n1' => 'nullable|exists:categories,id',
            'category_id_n2' => 'nullable|exists:categories,id',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $validated;
        $data['code'] = strtoupper(trim($validated['code']));
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('coupons', 'public');
            $data['banner_image'] = $path;
        }

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Code promotionnel créé avec succès.');
    }

    public function edit(Coupon $coupon)
    {
        $n1Categories = Category::whereNull('parent_id')->get();
        $allCategories = Category::orderBy('nom')->get();
        return view('admin.coupons.edit', compact('coupon', 'n1Categories', 'allCategories'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:categories,id',
            'category_id_n1' => 'nullable|exists:categories,id',
            'category_id_n2' => 'nullable|exists:categories,id',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $validated;
        $data['code'] = strtoupper(trim($validated['code']));
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('banner_image')) {
            if ($coupon->banner_image) {
                Storage::disk('public')->delete($coupon->banner_image);
            }
            $path = $request->file('banner_image')->store('coupons', 'public');
            $data['banner_image'] = $path;
        }

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Code promotionnel mis à jour.');
    }

    public function destroy(Coupon $coupon)
    {
        if ($coupon->banner_image) {
            Storage::disk('public')->delete($coupon->banner_image);
        }
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Code promotionnel supprimé.');
    }

    public function toggleActive(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return redirect()->back()->with('success', 'Statut du code mis à jour.');
    }
}
