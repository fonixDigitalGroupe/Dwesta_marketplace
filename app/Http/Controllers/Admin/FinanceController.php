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

        // Totaux (période + statut filtrés) pour l'onglet "Toutes les Transactions"
        $overviewTotals = null;
        if ($tab === 'overview') {
            $baseOverview = Order::whereIn('statut', $paidStatuses)
                ->when($statutFiltre, fn($q) => $q->where('statut', $statutFiltre))
                ->whereBetween('created_at', $periode);
            $overviewTotals = [
                'ventes'      => (clone $baseOverview)->sum('total_final'),
                'commissions' => (clone $baseOverview)->sum('commission_plateforme'),
                'abonnements' => VendeurAbonnement::whereBetween('vendeur_abonnements.created_at', $periode)
                    ->join('abonnements', 'vendeur_abonnements.abonnement_id', '=', 'abonnements.id')
                    ->sum('abonnements.prix_mensuel'),
                'credits'     => CreditTransaction::where('credit_transactions.type', 'achat')
                    ->where('credit_transactions.related_type', \App\Models\CreditPack::class)
                    ->whereBetween('credit_transactions.created_at', $periode)
                    ->join('credit_packs', 'credit_transactions.related_id', '=', 'credit_packs.id')
                    ->sum('credit_packs.prix'),
                'giftcards'   => GiftCard::whereBetween('created_at', $periode)->sum('amount'),
                'retraits'    => abs(Transaction::where('wallet_status', 'withdrawn')
                    ->whereBetween('created_at', $periode)->sum('montant')),
            ];
        }

        // Total de l'onglet courant (période filtrée) : abonnements, crédits, cartes cadeaux, retraits
        $tabTotal = null;
        if ($tab === 'commissions') {
            $tabTotal = [
                'label' => 'Total des commissions',
                'value' => Order::where('commission_plateforme', '>', 0)
                    ->whereIn('statut', $paidStatuses)
                    ->when($statutFiltre, fn($q) => $q->where('statut', $statutFiltre))
                    ->whereBetween('created_at', $periode)
                    ->sum('commission_plateforme'),
            ];
        } elseif ($tab === 'subscriptions') {
            $tabTotal = [
                'label' => 'Total des abonnements',
                'value' => VendeurAbonnement::whereBetween('vendeur_abonnements.created_at', $periode)
                    ->join('abonnements', 'vendeur_abonnements.abonnement_id', '=', 'abonnements.id')
                    ->sum('abonnements.prix_mensuel'),
            ];
        } elseif ($tab === 'credits') {
            $tabTotal = [
                'label' => 'Total des crédits vendus',
                'value' => CreditTransaction::where('credit_transactions.type', 'achat')
                    ->where('credit_transactions.related_type', \App\Models\CreditPack::class)
                    ->whereBetween('credit_transactions.created_at', $periode)
                    ->join('credit_packs', 'credit_transactions.related_id', '=', 'credit_packs.id')
                    ->sum('credit_packs.prix'),
            ];
        } elseif ($tab === 'gift-cards') {
            $tabTotal = [
                'label' => 'Total des cartes cadeaux',
                'value' => GiftCard::whereBetween('created_at', $periode)->sum('amount'),
            ];
        } elseif ($tab === 'withdrawals') {
            $tabTotal = [
                'label' => 'Total des retraits',
                'value' => abs(Transaction::where('wallet_status', 'withdrawn')
                    ->whereBetween('created_at', $periode)->sum('montant')),
            ];
        }

        return view('admin.finance.index', compact('tab', 'stripeOverview', 'data', 'dateDebut', 'dateFin', 'statutFiltre', 'overviewTotals', 'tabTotal'));
    }

    /**
     * Détail de ce qui est dû à chaque vendeur (portefeuille séquestre).
     */
    public function vendeursDetail(Request $request)
    {
        // Montants en portefeuille par vendeur : en séquestre (pending) + disponible (available)
        $rows = Transaction::selectRaw('user_id,
                SUM(CASE WHEN wallet_status = ? THEN montant ELSE 0 END) as en_sequestre,
                SUM(CASE WHEN wallet_status = ? THEN montant ELSE 0 END) as disponible,
                SUM(CASE WHEN wallet_status IN (?, ?) THEN montant ELSE 0 END) as total_du,
                SUM(CASE WHEN wallet_status = ? THEN ABS(montant) ELSE 0 END) as deja_retire',
                [
                    Transaction::STATUS_PENDING,
                    Transaction::STATUS_AVAILABLE,
                    Transaction::STATUS_PENDING, Transaction::STATUS_AVAILABLE,
                    Transaction::STATUS_WITHDRAWN,
                ])
            ->whereIn('wallet_status', [Transaction::STATUS_PENDING, Transaction::STATUS_AVAILABLE, Transaction::STATUS_WITHDRAWN])
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->get()
            ->map(function ($r) {
                $r->user = \App\Models\User::find($r->user_id);
                return $r;
            })
            ->filter(fn ($r) => $r->user !== null)
            ->sortByDesc('total_du')
            ->values();

        $totalGlobal = $rows->sum('total_du');

        return view('admin.finance.vendeurs', compact('rows', 'totalGlobal'));
    }

    /**
     * Détail des commandes d'un vendeur (clients + statut), filtrable par statut.
     */
    public function vendeurOrders(Request $request, \App\Models\User $user)
    {
        $vendeur = $user->vendeur;
        if (!$vendeur) {
            return redirect()->route('admin.finance.vendeurs')->with('error', 'Ce compte n\'est pas un vendeur.');
        }

        $statutFiltre = $request->get('statut');

        $ordersQuery = Order::where('vendeur_id', $vendeur->id)->with('buyer');

        // Compteurs par statut (toutes les commandes du vendeur)
        $countsParStatut = (clone $ordersQuery)
            ->selectRaw('statut, COUNT(*) as n')
            ->groupBy('statut')
            ->pluck('n', 'statut')
            ->toArray();
        $totalCommandes = array_sum($countsParStatut);

        $orders = (clone $ordersQuery)
            ->when($statutFiltre, fn($q) => $q->where('statut', $statutFiltre))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.finance.vendeur-orders', compact('user', 'vendeur', 'orders', 'statutFiltre', 'countsParStatut', 'totalCommandes'));
    }
}
