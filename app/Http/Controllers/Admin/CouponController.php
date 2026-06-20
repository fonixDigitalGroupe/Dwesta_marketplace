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
        $categories = Category::orderBy('nom')->get();
        return view('admin.coupons.create', compact('categories'));
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
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('coupons', 'public');
            $validated['banner_image'] = $path;
        }

        if ($request->hasFile('page_image')) {
            $path = $request->file('page_image')->store('coupons', 'public');
            $validated['page_image'] = $path;
        }

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Code promotionnel créé avec succès.');
    }

    public function edit(Coupon $coupon)
    {
        $categories = Category::orderBy('nom')->get();
        return view('admin.coupons.edit', compact('coupon', 'categories'));
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
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('banner_image')) {
            if ($coupon->banner_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($coupon->banner_image);
            }
            $path = $request->file('banner_image')->store('coupons', 'public');
            $validated['banner_image'] = $path;
        }

        if ($request->hasFile('page_image')) {
            if ($coupon->page_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($coupon->page_image);
            }
            $path = $request->file('page_image')->store('coupons', 'public');
            $validated['page_image'] = $path;
        }

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Code promotionnel mis à jour.');
    }

    public function destroy(Coupon $coupon)
    {
        if ($coupon->banner_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($coupon->banner_image);
        }
        if ($coupon->page_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($coupon->page_image);
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
