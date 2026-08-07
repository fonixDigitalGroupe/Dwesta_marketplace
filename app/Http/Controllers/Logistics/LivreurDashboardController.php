<?php

namespace App\Http\Controllers\Logistics;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivreurDashboardController extends Controller
{
    /**
     * Dashboard du livreur
     */
    public function index()
    {
        $user = Auth::user();
        $livreur = $user->livreur;

        if (!$livreur) {
            return redirect()->route('account.index')->with('error', 'Profil livreur non trouvé.');
        }

        // Statistiques
        $stats = [
            'disponibles' => Order::whereIn('statut', [Order::STATUT_PRET, Order::STATUT_DISPONIBLE])->whereNull('livreur_id')->count(),
            'mes_livraisons' => Order::where('livreur_id', $livreur->id)->where('statut', Order::STATUT_EN_ROUTE)->count(),
            'total_livre' => Order::where('livreur_id', $livreur->id)->where('statut', Order::STATUT_LIVRE)->count(),
            'gains' => Order::where('livreur_id', $livreur->id)->where('statut', Order::STATUT_LIVRE)->sum('commission_livreur'),
        ];

        // Commandes disponibles (Prêt chez le vendeur ou Disponible en point relais pour livraison finale)
        $availableOrders = Order::with(['seller.user'])
            ->whereIn('statut', [Order::STATUT_PRET, Order::STATUT_DISPONIBLE])
            ->whereNull('livreur_id')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Mes livraisons en cours
        $myDeliveries = Order::with(['seller.user', 'buyer'])
            ->where('livreur_id', $livreur->id)
            ->where('statut', Order::STATUT_EN_ROUTE)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('logistics.livreur.dashboard', compact('stats', 'availableOrders', 'myDeliveries'));
    }

    /**
     * Voir les commandes disponibles
     */
    public function availableOrders()
    {
        $availableOrders = Order::with(['seller.user'])
            ->whereIn('statut', [Order::STATUT_PRET, Order::STATUT_DISPONIBLE])
            ->whereNull('livreur_id')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('logistics.livreur.orders.available', compact('availableOrders'));
    }

    /**
     * Voir les expéditions en cours
     */
    public function ongoingOrders()
    {
        $livreur = Auth::user()->livreur;
        if (!$livreur) return redirect()->route('account.index');

        $ongoingOrders = Order::with(['seller.user', 'buyer'])
            ->where('livreur_id', $livreur->id)
            ->where('statut', Order::STATUT_EN_ROUTE)
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('logistics.livreur.orders.ongoing', compact('ongoingOrders'));
    }

    /**
     * Voir l'historique des livraisons
     */
    public function deliveryHistory()
    {
        $livreur = Auth::user()->livreur;
        if (!$livreur) return redirect()->route('account.index');

        $history = Order::with(['seller.user', 'buyer'])
            ->where('livreur_id', $livreur->id)
            ->where('statut', Order::STATUT_LIVRE)
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('logistics.livreur.orders.history', compact('history'));
    }

    /**
     * Prendre en charge une livraison (Pickup)
     */
    public function pickup(Order $order, Request $request)
    {
        $livreur = Auth::user()->livreur;

        if (!in_array($order->statut, [Order::STATUT_PRET, Order::STATUT_DISPONIBLE])) {
            return back()->with('error', 'Cette commande n\'est pas prête pour la livraison.');
        }

        $request->validate(['code_ramassage' => 'required|string'], [
            'code_ramassage.required' => 'Veuillez saisir le code de ramassage remis par le vendeur.',
        ]);

        if (trim($request->code_ramassage) !== (string) $order->code_ramassage) {
            return back()->with('error', 'Code de ramassage incorrect. Demandez au vendeur le code à 4 chiffres.');
        }

        $order->update([
            'livreur_id' => $livreur->id,
            'statut' => Order::STATUT_EN_ROUTE,
        ]);

        return redirect()->route('livreur.dashboard')->with('success', 'Ramassage confirmé. En route vers le client !');
    }

    /**
     * Marquer comme livré (Delivery)
     */
    public function delivered(Order $order, Request $request)
    {
        // Le client remet son code de confirmation de livraison à 4 chiffres.
        $request->validate(['code_livraison' => 'required|string'], [
            'code_livraison.required' => 'Veuillez saisir le code de livraison remis par le client.',
        ]);

        if (trim($request->code_livraison) !== (string) $order->code_livraison) {
            return back()->with('error', 'Code de livraison incorrect. Demandez au client le code à 4 chiffres.');
        }

        $order->update([
            'statut' => Order::STATUT_LIVRE,
        ]);

        // Libération des fonds pour le vendeur
        $transactions = \App\Models\Transaction::where('order_id', $order->id)
            ->where('wallet_status', \App\Models\Transaction::STATUS_PENDING)
            ->get();

        foreach ($transactions as $tx) {
            $tx->update([
                'wallet_status' => \App\Models\Transaction::STATUS_AVAILABLE,
                'release_at' => now()
            ]);

            // Incrémentation du solde réel de l'utilisateur concerné (le vendeur)
            $user = $tx->user;
            if ($user) {
                $user->increment('credit_balance', $tx->montant);
            }
        }

        return redirect()->route('livreur.dashboard')->with('success', 'Commande livrée avec succès. Les fonds ont été libérés pour le vendeur.');
    }
}
