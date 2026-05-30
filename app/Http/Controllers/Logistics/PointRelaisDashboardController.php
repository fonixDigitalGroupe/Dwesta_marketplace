<?php

namespace App\Http\Controllers\Logistics;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointRelaisDashboardController extends Controller
{
    /**
     * Dashboard du point relais
     */
    public function index()
    {
        $user = Auth::user();
        
        // Obtenir les IDs des points relais gérés par cet utilisateur
        $pointRelaisIds = \App\Models\PointRelais::whereHas('users', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('id');

        // Commandes qui arrivent (En attente de réception)
        $ordersIncoming = Order::whereIn('destination_point_relais_id', $pointRelaisIds)
            ->whereIn('statut', [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE])
            ->with(['buyer', 'items'])
            ->latest()
            ->get();

        // Commandes en stock prêtes pour retrait
        $ordersInStock = Order::whereIn('destination_point_relais_id', $pointRelaisIds)
            ->where('statut', Order::STATUT_DISPONIBLE)
            ->with(['buyer', 'items'])
            ->latest()
            ->get();

        // Statistiques pour le tableau de bord
        $stats = [
            'incoming_today' => Order::whereIn('destination_point_relais_id', $pointRelaisIds)
                                     ->whereIn('statut', [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE])
                                     ->whereDate('updated_at', today())
                                     ->count(),
            'in_stock' => $ordersInStock->count(),
            'delivered_today' => Order::whereIn('destination_point_relais_id', $pointRelaisIds)
                                      ->where('statut', Order::STATUT_LIVRE)
                                      ->whereDate('updated_at', today())
                                      ->count(),
            'total_managed' => Order::whereIn('destination_point_relais_id', $pointRelaisIds)
                                    ->where('statut', Order::STATUT_LIVRE)
                                    ->count(),
        ];

        return view('logistics.relais', compact('ordersIncoming', 'ordersInStock', 'stats'));
    }
}
