<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PointRelais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgenceDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Un utilisateur peut gérer plusieurs points relais (relation belongsToMany)
        $relais = $user->pointRelais;

        if ($relais->isEmpty()) {
            return view('agence.no_relais');
        }

        // Pour la démo, on prend le premier point relais
        $currentRelais = $relais->first();

        // Colis attendus (En route vers ce point relais)
        // Note: Il faudrait une colonne 'point_relais_id' dans 'orders'
        // Pour l'instant on simule avec le mode_livraison qui contient l'info ou une relation dédiée
        $incomingOrders = Order::where('statut', Order::STATUT_EN_ROUTE)
            ->latest()
            ->take(10)
            ->get();

        // Colis en stock au point relais (Disponibles pour retrait)
        $stockOrders = Order::where('statut', Order::STATUT_DISPONIBLE)
            ->latest()
            ->get();

        return view('agence.dashboard', compact('currentRelais', 'incomingOrders', 'stockOrders'));
    }

    /**
     * Confirmer la réception d'un colis au point relais
     */
    public function markAsReceived(Order $order)
    {
        $order->update(['statut' => Order::STATUT_DISPONIBLE]);
        return back()->with('success', 'Le colis a été scanné et est maintenant disponible pour le retrait.');
    }

    /**
     * Confirmer la remise du colis au client final
     */
    public function markAsDelivered(Order $order)
    {
        $order->update(['statut' => Order::STATUT_LIVRE]);
        return back()->with('success', 'Livraison terminée. Le colis a été remis au client.');
    }
}
