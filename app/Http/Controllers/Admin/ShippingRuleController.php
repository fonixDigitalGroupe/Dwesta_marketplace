<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterRegionTariff;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    public function index()
    {
        $rules = ShippingRule::with(['sourceCountry', 'destinationCountry'])->orderBy('id', 'desc')->get();
        $countries = \App\Models\Country::active()->orderBy('name')->get();
        $interRegionTariffs = InterRegionTariff::with('country')->orderBy('id', 'desc')->get();
        return view('admin.settings.shipping', compact('rules', 'countries', 'interRegionTariffs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'source_country_id' => 'required|exists:countries,id',
            'destination_country_id' => 'required|exists:countries,id',
            'zone_name' => 'nullable|string|max:255',
            'delivery_type' => 'required|in:livraison_domicile,retrait_point_relais',
            'price' => 'required|numeric|min:0',
            'delivery_delay' => 'nullable|string|max:100',
        ]);

        ShippingRule::create($validated);

        return redirect()->back()->with('success', 'Règle de livraison ajoutée.');
    }

    public function update(Request $request, ShippingRule $shippingRule)
    {
        $validated = $request->validate([
            'source_country_id' => 'required|exists:countries,id',
            'destination_country_id' => 'required|exists:countries,id',
            'zone_name' => 'nullable|string|max:255',
            'delivery_type' => 'required|in:livraison_domicile,retrait_point_relais',
            'price' => 'required|numeric|min:0',
            'delivery_delay' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $shippingRule->update($validated);

        return redirect()->back()->with('success', 'Règle de livraison mise à jour.');
    }

    public function destroy(ShippingRule $shippingRule)
    {
        $shippingRule->delete();
        return redirect()->back()->with('success', 'Règle supprimée.');
    }

    public function toggle(ShippingRule $shippingRule)
    {
        $shippingRule->update(['is_active' => !$shippingRule->is_active]);
        return redirect()->back()->with('success', 'Statut mis à jour.');
    }

    /**
     * Enregistre (ou met à jour) le tarif inter-régions d'un pays :
     * un prix pour la même région et un prix pour les régions différentes.
     */
    public function storeInterRegion(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'delivery_type' => 'required|in:livraison_domicile,retrait_point_relais',
            'same_region_price' => 'required|numeric|min:0',
            'inter_region_price' => 'required|numeric|min:0',
            'delivery_delay' => 'nullable|string|max:100',
        ]);

        InterRegionTariff::updateOrCreate(
            ['country_id' => $validated['country_id'], 'delivery_type' => $validated['delivery_type']],
            [
                'same_region_price' => $validated['same_region_price'],
                'inter_region_price' => $validated['inter_region_price'],
                'delivery_delay' => $validated['delivery_delay'] ?? null,
            ]
        );

        return redirect()->back()->with('success', 'Tarif inter-régions enregistré.');
    }

    public function toggleInterRegion(InterRegionTariff $interRegionTariff)
    {
        $interRegionTariff->update(['is_active' => !$interRegionTariff->is_active]);
        return redirect()->back()->with('success', 'Statut mis à jour.');
    }

    public function destroyInterRegion(InterRegionTariff $interRegionTariff)
    {
        $interRegionTariff->delete();
        return redirect()->back()->with('success', 'Tarif inter-régions supprimé.');
    }
}
