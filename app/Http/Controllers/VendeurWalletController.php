<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class VendeurWalletController extends Controller
{
    public function __construct()
    {
        // Middleware handled in routes/web.php in Laravel 11
    }

    /**
     * Dashboard du Wallet Vendeur
     */
    public function index()
    {
        $user = Auth::user();

        // On s'assure qu'il est vendeur (Supprimé pour permettre l'accès à tous les utilisateurs selon la demande)
        // if (!$user->vendeur) {
        //     return redirect()->route('vendeur.create')->with('info', 'Vous devez être vendeur pour accéder au wallet.');
        // }

        // Revenus disponibles = ventes libérées (escrow) moins retraits.
        // Basé uniquement sur les transactions : 0 si aucune vente.
        $availableBalance = (float) Transaction::where('user_id', $user->id)
            ->where('statut', 'succes')
            ->whereIn('wallet_status', [Transaction::STATUS_AVAILABLE, Transaction::STATUS_WITHDRAWN])
            ->sum('montant');
        $availableBalance = max(0, $availableBalance);

        // Revenus en attente (séquestre)
        $pendingTransactions = Transaction::where('user_id', $user->id)
            ->where('wallet_status', 'pending')
            ->where('statut', 'succes')
            ->orderBy('release_at', 'asc')
            ->get();

        $pendingBalance = $pendingTransactions->sum('montant');

        // Historique récent
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('vendeur.wallet.index', compact('user', 'availableBalance', 'pendingBalance', 'pendingTransactions', 'recentTransactions'));
    }

    /**
     * Formulaire de retrait dédié (style SoftPay)
     */
    public function showWithdrawForm()
    {
        $user = Auth::user();

        $availableBalance = (float) Transaction::where('user_id', $user->id)
            ->where('statut', 'succes')
            ->whereIn('wallet_status', [Transaction::STATUS_AVAILABLE, Transaction::STATUS_WITHDRAWN])
            ->sum('montant');
        $availableBalance = max(0, $availableBalance);

        return view('vendeur.wallet.withdraw', compact('user', 'availableBalance'));
    }


    /**
     * Demande de retrait.
     *
     * Les retraits (paiement sortant vers Wave/Orange Money) ne sont pas
     * réalisables via Stripe Checkout. Depuis la bascule tout-Stripe (mode test),
     * cette fonctionnalité est désactivée en attendant un canal de payout dédié.
     */
    public function requestWithdrawal(Request $request)
    {
        return back()->with('error', 'Les retraits sont temporairement indisponibles : Stripe ne permet pas les versements sortants vers Mobile Money. Un canal de retrait dédié sera réactivé prochainement.');
    }
}
