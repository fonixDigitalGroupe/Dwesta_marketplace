<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_url' => 'nullable|url',
            'promo_discount' => 'nullable|string|max:20',
            'promo_conditions' => 'nullable|string|max:50',
            'promo_code' => 'nullable|string|max:20',
            'has_payment_4x' => 'boolean',
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

        // Par défaut actif à la création si non précisé (le champ est retiré du form)
        $data['active'] = $request->has('active') ? $request->boolean('active') : true;
        $data['has_payment_4x'] = $request->boolean('has_payment_4x');

        Banner::create($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Bannière créée avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_url' => 'nullable|url',
            'promo_discount' => 'nullable|string|max:20',
            'promo_conditions' => 'nullable|string|max:50',
            'promo_code' => 'nullable|string|max:20',
            'has_payment_4x' => 'boolean',
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

        // Préserver le statut actuel si le champ est absent du formulaire (cas standard après retrait du checkbox)
        if (!$request->has('active')) {
            unset($data['active']);
        } else {
            $data['active'] = $request->boolean('active');
        }
        
        $data['has_payment_4x'] = $request->boolean('has_payment_4x');

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
