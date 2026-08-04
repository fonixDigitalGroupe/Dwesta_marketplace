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

        // Toutes les commandes (liste défilante, sans pagination)
        $orders = $query->get();

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
    /**
     * Permet à l'acheteur de finaliser le paiement en ligne (Stripe) d'une
     * commande encore en attente (ex. choisie en paiement à la livraison),
     * à tout moment depuis "Mes achats".
     */
    public function payOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, "Vous n'êtes pas autorisé à payer cette commande.");
        }

        if ($order->statut !== Order::STATUT_EN_ATTENTE) {
            return back()->with('error', 'Cette commande ne peut plus être payée en ligne (statut : ' . $order->statut_label . ').');
        }

        try {
            $stripe = app(\App\Services\StripeService::class);
            $buyer = $order->buyer;
            $nom = $buyer ? trim(($buyer->prenom ?? '') . ' ' . ($buyer->nom ?? '')) : null;

            $session = $stripe->createMarketplaceSession(
                (float) ($order->total_final ?? $order->total_produits),
                route('checkout.success'),
                route('account.orders.show', $order),
                $buyer->email ?? null,
                ['order_ids' => (string) $order->id],
                $nom ?: null
            );

            // Le fulfillment retrouve la commande via stripe_session_id
            $order->update(['stripe_session_id' => $session->id]);

            return redirect($session->url);
        } catch (\Throwable $e) {
            \Log::error('payOrder Stripe error', ['order' => $order->id, 'error' => $e->getMessage()]);
            return back()->with('error', "Le paiement en ligne est momentanément indisponible. Réessayez plus tard.");
        }
    }

    public function cancelOrder(Request $request, Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, "Vous n'êtes pas autorisé à annuler cette commande.");
        }

        // Motif d'annulation obligatoire (formulaire type signalement)
        $validated = $request->validate([
            'motif_annulation' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

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

        // Créer un litige visible par l'admin (traçabilité de l'annulation)
        $description = '[Annulation client] Motif : ' . $validated['motif_annulation'];
        if (!empty($validated['description'])) {
            $description .= ' — ' . $validated['description'];
        }

        $reportedId = optional($order->vendeur)->user_id;
        if ($reportedId) {
            \App\Models\Litige::create([
                'commande_id' => $order->id,
                'reporter_id' => Auth::id(),
                'reported_id' => $reportedId,
                'motif'       => 'autre',
                'description' => $description,
                'statut'      => 'en_cours',
            ]);
        }

        // Update status to Cancelled
        $order->update([
            'statut' => Order::STATUT_ANNULE
        ]);

        return back()->with('success', 'Votre commande n°' . $order->reference . ' a été annulée. Votre demande a été transmise à notre équipe.');
    }
}
