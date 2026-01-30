<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogisticsController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes/web.php in Laravel 11
    }

    /**
     * Dashboard pour le Transporteur
     * Affiche les colis "Prêts" à être ramassés
     */
    public function transporteurDashboard()
    {
        // Vérification rôle (à sécuriser plus tard avec Middleware Spatie)
        // if (!Auth::user()->hasRole('Transporteur')) ...

        // Commandes prêtes à être expédiées
        $ordersPickup = Order::where('statut', Order::STATUT_PRET)
            ->with(['seller.user', 'items'])
            ->latest()
            ->get();

        // Commandes en cours de livraison (par moi - simplifié, ici on voit tout)
        $ordersEnRoute = Order::where('statut', Order::STATUT_EN_ROUTE)
             ->with(['seller.user', 'items'])
             ->latest()
             ->get();

        return view('logistics.transporteur', compact('ordersPickup', 'ordersEnRoute'));
    }

    /**
     * Dashboard pour le Point Relais
     * Affiche les colis "En route" (Arrivants) et "Disponibles" (Stock)
     */
    public function relaisDashboard()
    {
        // Commandes qui arrivent
        $ordersIncoming = Order::where('statut', Order::STATUT_EN_ROUTE)
            ->with(['buyer', 'items'])
            ->latest()
            ->get();

        // Commandes en stock prêtes pour retrait
        $ordersInStock = Order::where('statut', Order::STATUT_DISPONIBLE)
            ->with(['buyer', 'items'])
            ->latest()
            ->get();

        return view('logistics.relais', compact('ordersIncoming', 'ordersInStock'));
    }

    /**
     * Action Vendeur : Marquer comme prêt à l'expédition
     */
    public function markAsReady(Order $order)
    {
        // Vérification que c'est bien le vendeur de la commande
        if ($order->vendeur->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->statut !== Order::STATUT_PAYE) {
            return back()->with('error', 'La commande ne peut pas être marquée comme prête.');
        }

        $order->update(['statut' => Order::STATUT_PRET]);

        return back()->with('success', 'Commande marquée comme prête pour le ramassage !');
    }
}
