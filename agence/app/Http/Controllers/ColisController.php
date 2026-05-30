<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ColisController extends Controller
{
    /**
     * Display a listing of orders assigned to the current agency.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $agence = $user->pointRelais()->first();

        if (!$agence) {
            return view('colis.index', [
                'agence' => null,
                'orders' => collect([]),
                'counts' => ['incoming' => 0, 'stock' => 0, 'history' => 0],
                'activeTab' => 'stock'
            ]);
        }

        $activeTab = $request->query('tab', 'stock'); // stock (disponible), incoming (en_route), history (livre)
        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

        $query = Order::where('destination_point_relais_id', $agence->id);

        // Count totals for badges
        $counts = [
            'incoming' => Order::where('destination_point_relais_id', $agence->id)->whereIn('statut', [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE])->count(),
            'stock' => Order::where('destination_point_relais_id', $agence->id)->where('statut', Order::STATUT_DISPONIBLE)->count(),
            'history' => Order::where('destination_point_relais_id', $agence->id)->whereIn('statut', [Order::STATUT_LIVRE, Order::STATUT_ANNULE])->count(),
        ];

        // Filter by tab
        if ($activeTab === 'incoming') {
            $query->whereIn('statut', [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE]);
        } elseif ($activeTab === 'history') {
            $query->whereIn('statut', [Order::STATUT_LIVRE, Order::STATUT_ANNULE]);
        } else {
            // Default to 'stock' (Disponible)
            $query->where('statut', Order::STATUT_DISPONIBLE);
        }

        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('tracking_token', 'like', "%{$search}%")
                  ->orWhereHas('buyer', function($bq) use ($search) {
                      $bq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->with(['buyer', 'seller.user', 'seller.pagePro'])->latest()->paginate($perPage)->withQueryString();

        return view('colis.index', compact('agence', 'orders', 'counts', 'activeTab', 'search', 'perPage'));
    }

    /**
     * Mark an order as received at the agency.
     */
    public function receive(Request $request, Order $order): RedirectResponse
    {
        // Security check
        $agence = $request->user()->pointRelais()->first();
        if (!$agence || $order->destination_point_relais_id !== $agence->id) {
            return Redirect::back()->with('error', 'Action non autorisée.');
        }

        $order->update(['statut' => Order::STATUT_DISPONIBLE]);

        return Redirect::route('operations.stock', ['tab' => 'stock'])->with('status', 'colis-reçu');
    }

    /**
     * Mark an order as delivered to the customer.
     */
    public function deliver(Request $request, Order $order): RedirectResponse
    {
        // Security check
        $agence = $request->user()->pointRelais()->first();
        if (!$agence || $order->destination_point_relais_id !== $agence->id) {
            return Redirect::back()->with('error', 'Action non autorisée.');
        }

        if ($order->statut !== Order::STATUT_DISPONIBLE) {
            return Redirect::back()->with('error', 'Seuls les colis en stock peuvent être livrés.');
        }

        $order->update(['statut' => Order::STATUT_LIVRE]);

        return Redirect::route('operations.stock', ['tab' => 'history'])->with('status', 'colis-livré');
    }

    /**
     * Handle barcode scan for receiving or delivering.
     */
    public function scan(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->code;
        $user = $request->user();
        $agence = $user->pointRelais()->first();

        if (!$agence) {
            return response()->json(['success' => false, 'message' => 'Aucune agence associée à votre compte.'], 403);
        }

        // Search by reference or tracking token
        $order = Order::where('destination_point_relais_id', $agence->id)
            ->where(function($q) use ($code) {
                $q->where('reference', $code)
                  ->orWhere('tracking_token', $code);
            })
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Colis non trouvé ou n\'appartient pas à cette agence.'], 404);
        }

        $oldStatut = $order->statut;
        $message = "";
        $action = "";

        if (in_array($oldStatut, [Order::STATUT_EN_ATTENTE, Order::STATUT_PAYE, Order::STATUT_PRET, Order::STATUT_EN_ROUTE])) {
            $order->update(['statut' => Order::STATUT_DISPONIBLE]);
            $message = "Colis {$order->reference} réceptionné avec succès.";
            $action = "received";
        } elseif ($oldStatut === Order::STATUT_DISPONIBLE) {
            $order->update(['statut' => Order::STATUT_LIVRE]);
            $message = "Colis {$order->reference} livré au client.";
            $action = "delivered";
        } else {
            $statusLabel = match($oldStatut) {
                Order::STATUT_LIVRE => 'déjà livré',
                Order::STATUT_ANNULE => 'annulé',
                default => $oldStatut
            };
            return response()->json(['success' => false, 'message' => "Ce colis est {$statusLabel}."], 422);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'action' => $action,
            'order' => [
                'reference' => $order->reference,
                'buyer' => ($order->buyer->prenom ?? '') . ' ' . ($order->buyer->nom ?? $order->buyer->name ?? ''),
            ]
        ]);
    }
}
