<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    public function index()
    {
        $rules = ShippingRule::with(['sourceCountry', 'destinationCountry'])->orderBy('id', 'desc')->get();
        $countries = \App\Models\Country::active()->orderBy('name')->get();
        return view('admin.settings.shipping', compact('rules', 'countries'));
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
}
