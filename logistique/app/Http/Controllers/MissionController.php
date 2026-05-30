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

    public function earnings()
    {
        return view('missions.earnings');
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
            'statut' => Order::STATUT_EN_ROUTE,
            'otp_livraison' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT)
        ]);

        return redirect()->route('dashboard')->with('success', 'Mission acceptée ! Un code OTP a été généré pour la livraison.');
    }

    /**
     * Valider la livraison avec l'OTP
     */
    public function deliver(Request $request, Order $order)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        if ($order->otp_livraison !== $request->otp) {
            return back()->with('error', 'Code OTP invalide. Veuillez demander le code correct au client.');
        }

        $order->update([
            'statut' => Order::STATUT_LIVRE,
            'otp_livraison' => null // Consommé
        ]);

        return redirect()->route('dashboard')->with('success', 'Livraison confirmée !');
    }

    /**
     * Mettre à jour la position GPS
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        if ($user->livreur) {
            $user->livreur->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Détails d'une mission
     */
    public function show(Order $order)
    {
        return view('missions.show', compact('order'));
    }
}
