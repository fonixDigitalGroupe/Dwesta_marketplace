<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Liste toutes les commandes avec filtres
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10);

        $query = Order::with(['buyer', 'seller.user', 'items.annonce'])->latest();

        // Filtre par statut
        if (!empty($status)) {
            $query->where('statut', $status);
        }

        // Recherche par référence, client ou vendeur
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('buyer', function($u) use ($search) {
                      $u->where('prenom', 'like', "%{$search}%")
                        ->orWhere('nom', 'like', "%{$search}%");
                  })
                  ->orWhereHas('seller.user', function($u) use ($search) {
                      $u->where('prenom', 'like', "%{$search}%")
                        ->orWhere('nom', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate($perPage)->withQueryString();

        return view('admin.orders.index', compact('orders', 'status', 'search', 'perPage'));
    }

    /**
     * Affiche les détails d'une commande
     */
    public function show(Order $order)
    {
        $order->load(['buyer', 'seller.user', 'items.annonce.photos', 'transactions']);
        
        return view('admin.orders.show', compact('order'));
    }
}
