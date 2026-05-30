<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display the account dashboard.
     */
    public function index()
    {
        return view('account.dashboard', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's location coordinates.
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $user->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Localisation mise à jour avec succès.',
        ]);
    }

    /**
     * Display user's order history.
     */
    public function orders(Request $request)
    {
        $user = Auth::user();

        $activeStatuses = ['en_attente', 'paye', 'pret_expedition', 'en_route', 'disponible', 'livre'];
        $returnedStatuses = ['annule', 'litige'];

        $activeCount = $user->orders()->whereIn('statut', $activeStatuses)->count();
        $returnedCount = $user->orders()->whereIn('statut', $returnedStatuses)->count();

        $tab = $request->query('tab', 'active');
        $query = $user->orders()->with(['items.annonce.photos', 'seller.user'])->latest();

        if ($tab === 'returned') {
            $query->whereIn('statut', $returnedStatuses);
        } else {
            $query->whereIn('statut', $activeStatuses);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('account.orders', compact('orders', 'activeCount', 'returnedCount', 'tab'));
    }

    /**
     * Display the details of a specific order for the buyer.
     */
    public function orderShow(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, "Vous n'êtes pas autorisé à voir cette commande");
        }

        // Load necessary relationships
        $order->load(['items.annonce.photos', 'seller.user']);

        return view('account.order-show', compact('order'));
    }

    /**
     * Display the tracking history of a specific order.
     */
    public function orderTracking(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, "Vous n'êtes pas autorisé à voir cette commande");
        }

        // Load necessary relationships
        $order->load(['items.annonce.photos', 'seller.user']);

        return view('account.order-tracking', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancelOrder(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, "Vous n'êtes pas autorisé à annuler cette commande.");
        }

        // Business Rule: Cannot cancel if delivered, shipped, or in dispute/already cancelled
        $nonCancellableStatuses = [
            Order::STATUT_EN_ROUTE,
            Order::STATUT_DISPONIBLE,
            Order::STATUT_LIVRE,
            Order::STATUT_ANNULE,
            Order::STATUT_LITIGE
        ];

        if (in_array($order->statut, $nonCancellableStatuses)) {
            $message = match ($order->statut) {
                Order::STATUT_LIVRE => "Cette commande a déjà été livrée et ne peut plus être annulée.",
                Order::STATUT_EN_ROUTE, Order::STATUT_DISPONIBLE => "Cette commande est déjà en cours de livraison et ne peut plus être annulée.",
                Order::STATUT_ANNULE => "Cette commande est déjà annulée.",
                Order::STATUT_LITIGE => "Cette commande fait l'objet d'un litige et ne peut être annulée directement.",
                default => "Cette commande ne peut plus être annulée dans son état actuel."
            };
            return back()->with('error', $message);
        }

        // Update status to Cancelled
        $order->update([
            'statut' => Order::STATUT_ANNULE
        ]);

        return back()->with('success', 'Votre commande n°' . $order->reference . ' a été annulée avec succès.');
    }
}
