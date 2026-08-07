<?php

namespace App\Http\Controllers\Logistics;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransporteurDashboardController extends Controller
{
    /**
     * Dashboard du transporteur
     */
    public function index()
    {
        $user = Auth::user();
        $transporteur = $user->transporteur;

        if (!$transporteur) {
            return redirect()->route('account.index')->with('error', 'Profil transporteur non trouvé.');
        }

        // Statistiques
        $stats = [
            'en_attente' => Order::where('statut', Order::STATUT_PRET)->whereNull('transporteur_id')->count(),
            'mes_courses' => Order::where('transporteur_id', $transporteur->id)->where('statut', Order::STATUT_EN_ROUTE)->count(),
            'total_livre' => Order::where('transporteur_id', $transporteur->id)->whereIn('statut', [Order::STATUT_DISPONIBLE, Order::STATUT_LIVRE])->count(),
            'gains' => Order::where('transporteur_id', $transporteur->id)->whereIn('statut', [Order::STATUT_DISPONIBLE, Order::STATUT_LIVRE])->sum('commission_transporteur'),
        ];

        // Commandes disponibles (Amazon-like: pick what's ready)
        $availableOrders = Order::with(['seller.user'])
            ->where('statut', Order::STATUT_PRET)
            ->whereNull('transporteur_id')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Mes livraisons en cours
        $myDeliveries = Order::with(['seller.user', 'buyer'])
            ->where('transporteur_id', $transporteur->id)
            ->where('statut', Order::STATUT_EN_ROUTE)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('logistics.transporteur.dashboard', compact('stats', 'availableOrders', 'myDeliveries'));
    }

    /**
     * Prendre en charge une commande
     */
    public function pickup(Order $order, Request $request)
    {
        $transporteur = Auth::user()->transporteur;

        if ($order->statut !== Order::STATUT_PRET) {
            return back()->with('error', 'Cette commande n\'est pas prête pour l\'expédition.');
        }

        $request->validate(['code_ramassage' => 'required|string'], [
            'code_ramassage.required' => 'Veuillez saisir le code de ramassage remis par le vendeur.',
        ]);

        if (trim($request->code_ramassage) !== (string) $order->code_ramassage) {
            return back()->with('error', 'Code de ramassage incorrect. Demandez au vendeur le code à 4 chiffres.');
        }

        $order->update([
            'transporteur_id' => $transporteur->id,
            'statut' => Order::STATUT_EN_ROUTE,
        ]);

        return redirect()->route('transporteur.dashboard')->with('success', 'Ramassage confirmé. Bonne route !');
    }

    /**
     * Déposer dans un point relais
     */
    public function dropoff(Order $order, Request $request)
    {
        $request->validate(['code_point_relais' => 'required|string'], [
            'code_point_relais.required' => 'Veuillez saisir le code affiché par le point relais.',
        ]);

        if (trim($request->code_point_relais) !== (string) $order->code_point_relais) {
            return back()->with('error', 'Code point relais incorrect. Demandez au point relais le code à 4 chiffres de la commande.');
        }

        $order->update([
            'statut' => Order::STATUT_DISPONIBLE,
        ]);

        return redirect()->route('transporteur.dashboard')->with('success', 'Dépôt au point relais confirmé.');
    }
}
