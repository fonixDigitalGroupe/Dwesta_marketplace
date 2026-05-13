<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCardOption;
use Illuminate\Http\Request;

class GiftCardOptionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');

        $query = GiftCardOption::query();

        if ($search) {
            $query->where('amount', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $giftCardOptions = $query->orderBy('amount', 'asc')->paginate($perPage);

        return view('admin.gift_cards.index', compact('giftCardOptions', 'perPage', 'search'));
    }

    public function create()
    {
        return view('admin.gift_cards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if (GiftCardOption::count() >= 3) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['amount' => 'Vous ne pouvez pas enregistrer plus de 3 cartes cadeaux au total.']);
        }

        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');

        GiftCardOption::create($validated);

        return redirect()->route('admin.gift_cards.index')->with('success', 'Carte cadeau créée avec succès.');
    }

    public function edit(GiftCardOption $giftCardOption)
    {
        return view('admin.gift_cards.edit', compact('giftCardOption'));
    }

    public function update(Request $request, GiftCardOption $giftCardOption)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_active'] = $request->has('is_active');

        $giftCardOption->update($validated);

        return redirect()->route('admin.gift_cards.index')->with('success', 'Carte cadeau mise à jour avec succès.');
    }

    public function destroy(GiftCardOption $giftCardOption)
    {
        $giftCardOption->delete();
        return redirect()->route('admin.gift_cards.index')->with('success', 'Carte cadeau supprimée avec succès.');
    }

    public function toggleStatus(GiftCardOption $giftCardOption)
    {
        $giftCardOption->update(['is_active' => !$giftCardOption->is_active]);
        return redirect()->route('admin.gift_cards.index')->with('success', 'Statut de la carte cadeau modifié avec succès.');
    }
}
