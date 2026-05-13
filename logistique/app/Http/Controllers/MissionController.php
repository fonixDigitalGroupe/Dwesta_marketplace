<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    /**
     * Liste des missions disponibles (Prêt pour expédition et sans livreur)
     */
    public function available()
    {
        $missions = Order::where('statut', Order::STATUT_PRET)
            ->whereNull('livreur_id')
            ->latest()
            ->get();

        return view('missions.available', compact('missions'));
    }

    /**
     * Accepter une mission
     */
    public function accept(Order $order)
    {
        $user = Auth::user();
        if (!$user->livreur) {
            return back()->with('error', 'Vous devez être un livreur vérifié.');
        }

        if ($order->livreur_id) {
            return back()->with('error', 'Cette mission a déjà été acceptée.');
        }

        $order->update([
            'livreur_id' => $user->livreur->id,
            'statut' => Order::STATUT_EN_ROUTE
        ]);

        return redirect()->route('dashboard')->with('success', 'Mission acceptée ! En route.');
    }

    /**
     * Détails d'une mission
     */
    public function show(Order $order)
    {
        return view('missions.show', compact('order'));
    }
}
