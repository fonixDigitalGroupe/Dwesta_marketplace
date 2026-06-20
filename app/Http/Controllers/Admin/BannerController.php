<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 8);
        $search = $request->input('search');

        $banners = Banner::when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                            ->orWhere('famille', 'like', "%{$search}%")
                            ->orWhere('link_url', 'like', "%{$search}%");
            })
            ->orderBy('order')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'search' => $search]);

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $n1Categories = \App\Models\Category::whereNull('parent_id')->get();
        $allCategories = \App\Models\Category::orderBy('nom')->get(); // This will include N2 and N3
        $nextOrder = Banner::max('order') + 1;
        return view('admin.banners.create', compact('n1Categories', 'allCategories', 'nextOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category_id_n1' => 'nullable|exists:categories,id',
            'category_id_n2' => 'nullable|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'landing_page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'promo_discount' => 'nullable|string|max:20',
            'promo_conditions' => 'nullable|string|max:50',
            'promo_code' => 'nullable|string|max:20',
            'active' => 'boolean',
            'order' => 'integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $data['image_url'] = Storage::url($path);
        }

        if ($request->hasFile('landing_page_image')) {
            $path = $request->file('landing_page_image')->store('banners', 'public');
            $data['landing_page_image'] = Storage::url($path);
        }

        $data['active'] = $request->has('active') ? $request->boolean('active') : true;
        $data['has_payment_4x'] = $request->boolean('has_payment_4x');
        $data['slug'] = Str::slug($data['title']);
        $data['is_promo'] = false;

        $banner = Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Bannière créée avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $n1Categories = \App\Models\Category::whereNull('parent_id')->get();
        $allCategories = \App\Models\Category::orderBy('nom')->get();
        return view('admin.banners.edit', compact('banner', 'n1Categories', 'allCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'category_id_n1' => 'nullable|exists:categories,id',
            'category_id_n2' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'landing_page_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'promo_discount' => 'nullable|string|max:20',
            'promo_conditions' => 'nullable|string|max:50',
            'promo_code' => 'nullable|string|max:20',
            'active' => 'boolean',
            'order' => 'integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $data['image_url'] = Storage::url($path);
        }

        if ($request->hasFile('landing_page_image')) {
            $path = $request->file('landing_page_image')->store('banners', 'public');
            $data['landing_page_image'] = Storage::url($path);
        }

        if (!$request->has('active')) {
            unset($data['active']);
        } else {
            $data['active'] = $request->boolean('active');
        }
        
        $data['is_promo'] = false;
        $data['has_payment_4x'] = $request->boolean('has_payment_4x');
        $data['slug'] = Str::slug($data['title']);

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Bannière mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        // Optionnel : Supprimer l'image du stockage
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Bannière supprimée avec succès.');
    }

    /**
     * Update status via AJAX (professional vibe)
     */
    public function toggleStatus(Banner $banner)
    {
        $banner->update(['active' => !$banner->active]);
        return response()->json(['success' => true, 'active' => $banner->active]);
    }
}
