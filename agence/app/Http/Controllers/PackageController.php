<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Marquer un colis comme arrivé au point relais
     */
    public function receive(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|exists:orders,reference',
        ]);

        $order = Order::where('reference', $request->reference)->firstOrFail();

        if ($order->statut !== Order::STATUT_EN_ROUTE) {
            return back()->with('error', 'Ce colis n\'est pas en cours de transport.');
        }

        $order->update([
            'statut' => Order::STATUT_DISPONIBLE
        ]);

        return back()->with('success', "Colis {$order->reference} marqué comme DISPONIBLE.");
    }

    /**
     * Marquer un colis comme remis au client final
     */
    public function release(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|exists:orders,reference',
        ]);

        $order = Order::where('reference', $request->reference)->firstOrFail();

        if ($order->statut !== Order::STATUT_DISPONIBLE) {
            return back()->with('error', 'Ce colis n\'est pas encore arrivé ou déjà livré.');
        }

        $order->update([
            'statut' => Order::STATUT_LIVRE
        ]);

        return back()->with('success', "Colis {$order->reference} marqué comme LIVRÉ.");
    }
}
