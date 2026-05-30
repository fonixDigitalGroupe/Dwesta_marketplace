<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\VendeurAbonnement;
use App\Models\CreditTransaction;
use App\Models\GiftCard;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'overview');

        // =========================================================
        // Financial Overview: toutes les métriques Stripe
        // =========================================================
        $paidStatuses = ['paye', 'pret_expedition', 'en_route', 'disponible', 'livre'];

        // Volume brut total encaissé via Stripe (total_final de toutes commandes payées)
        $volumeTotal = Order::whereIn('statut', $paidStatuses)->sum('total_final');

        // Commissions plateforme gagnées sur ces commandes
        $commissionsTotal = Order::whereIn('statut', $paidStatuses)->sum('commission_plateforme');

        // Montant vendeurs (après déduction commission)
        $vendeursMontantTotal = $volumeTotal - $commissionsTotal;

        // État du portefeuille vendeurs via transactions
        $escrowPending = Transaction::where('wallet_status', Transaction::STATUS_PENDING)->sum('montant');
        $escrowAvailable = Transaction::where('wallet_status', Transaction::STATUS_AVAILABLE)->sum('montant');
        $escrowWithdrawn = abs(Transaction::where('wallet_status', Transaction::STATUS_WITHDRAWN)->sum('montant'));

        // Compteurs
        $ordresPaies = Order::whereIn('statut', $paidStatuses)->count();
        $commandesEnAttente = Order::where('statut', 'en_attente')->count();

        // Revenus abonnements
        $subscriptionsRevenue = VendeurAbonnement::where('vendeur_abonnements.actif', true)
            ->join('abonnements', 'vendeur_abonnements.abonnement_id', '=', 'abonnements.id')
            ->sum('abonnements.prix_mensuel');

        // Crédits vendus
        $creditsRevenue = CreditTransaction::where('type', 'achat')->sum('montant');

        $stripeOverview = compact(
            'volumeTotal',
            'commissionsTotal',
            'vendeursMontantTotal',
            'escrowPending',
            'escrowAvailable',
            'escrowWithdrawn',
            'ordresPaies',
            'commandesEnAttente',
            'subscriptionsRevenue',
            'creditsRevenue'
        );

        $data = [];

        switch ($tab) {
            case 'subscriptions':
                $data = VendeurAbonnement::with(['vendeur.user', 'abonnement'])
                    ->latest()
                    ->paginate(15);
                break;

            case 'credits':
                $data = CreditTransaction::with('user')
                    ->where('type', 'achat')
                    ->latest()
                    ->paginate(15);
                break;

            case 'gift-cards':
                $data = GiftCard::with(['buyer', 'user'])
                    ->latest()
                    ->paginate(15);
                break;

            case 'commissions':
                $data = Order::with(['seller.user', 'buyer'])
                    ->where('commission_plateforme', '>', 0)
                    ->whereIn('statut', $paidStatuses)
                    ->latest()
                    ->paginate(15);
                break;

            case 'withdrawals':
                $data = Transaction::with('user')
                    ->where('wallet_status', 'withdrawn')
                    ->latest()
                    ->paginate(15);
                break;

            default: // overview
                $data = Order::with(['seller', 'buyer'])
                    ->whereIn('statut', $paidStatuses)
                    ->latest()
                    ->paginate(20);
                break;
        }

        return view('admin.finance.index', compact('tab', 'stripeOverview', 'data'));
    }
}
