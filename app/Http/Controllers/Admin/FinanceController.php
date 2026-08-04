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

        // Filtre de période (par défaut : 1er au dernier jour du mois courant)
        $dateDebut = $request->filled('date_debut')
            ? \Carbon\Carbon::parse($request->date_debut)->startOfDay()
            : now()->startOfMonth()->startOfDay();
        $dateFin = $request->filled('date_fin')
            ? \Carbon\Carbon::parse($request->date_fin)->endOfDay()
            : now()->endOfMonth()->endOfDay();
        $periode = [$dateDebut, $dateFin];

        // Filtre de statut (appliqué aux onglets basés sur les commandes)
        $statutFiltre = $request->get('statut');

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

        // Crédits vendus : on somme le PRIX payé (FCFA) des packs, pas le nombre de crédits.
        $creditsRevenue = CreditTransaction::where('credit_transactions.type', 'achat')
            ->where('credit_transactions.related_type', \App\Models\CreditPack::class)
            ->join('credit_packs', 'credit_transactions.related_id', '=', 'credit_packs.id')
            ->sum('credit_packs.prix');

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
                    ->whereBetween('created_at', $periode)
                    ->latest()
                    ->paginate(15)->withQueryString();
                break;

            case 'credits':
                $data = CreditTransaction::with(['user', 'related'])
                    ->where('type', 'achat')
                    ->whereBetween('created_at', $periode)
                    ->latest()
                    ->paginate(15)->withQueryString();
                break;

            case 'gift-cards':
                $data = GiftCard::with(['buyer', 'redeemer'])
                    ->whereBetween('created_at', $periode)
                    ->latest()
                    ->paginate(15)->withQueryString();
                break;

            case 'commissions':
                $data = Order::with(['seller.user', 'buyer'])
                    ->where('commission_plateforme', '>', 0)
                    ->whereIn('statut', $paidStatuses)
                    ->when($statutFiltre, fn($q) => $q->where('statut', $statutFiltre))
                    ->whereBetween('created_at', $periode)
                    ->latest()
                    ->paginate(15)->withQueryString();
                break;

            case 'withdrawals':
                $data = Transaction::with('user')
                    ->where('wallet_status', 'withdrawn')
                    ->whereBetween('created_at', $periode)
                    ->latest()
                    ->paginate(15)->withQueryString();
                break;

            default: // overview
                $data = Order::with(['seller', 'buyer'])
                    ->whereIn('statut', $paidStatuses)
                    ->when($statutFiltre, fn($q) => $q->where('statut', $statutFiltre))
                    ->whereBetween('created_at', $periode)
                    ->latest()
                    ->paginate(20)->withQueryString();
                break;
        }

        return view('admin.finance.index', compact('tab', 'stripeOverview', 'data', 'dateDebut', 'dateFin', 'statutFiltre'));
    }
}
