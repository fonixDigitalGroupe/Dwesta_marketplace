<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        
        // On s'assure qu'il est vendeur
        if (!$user->vendeur) {
            return redirect()->route('vendeur.create')->with('info', 'Vous devez être vendeur pour accéder au wallet.');
        }

        // Revenus disponibles (déjà libérés)
        $availableBalance = $user->credit_balance;

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
     * Demande de retrait (Simulée)
     */
    public function requestWithdrawal(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:1',
            'moyen' => 'required|in:om,momo,virement'
        ]);

        $user = Auth::user();

        if ($request->montant > $user->credit_balance) {
            return back()->with('error', 'Solde insuffisant.');
        }

        // Logique de retrait simulée
        // En prod, on créerait une ligne de transaction de type 'withdrawal'
        
        $user->decrement('credit_balance', $request->montant);

        Transaction::create([
            'user_id' => $user->id,
            'reference_externe' => 'WD-' . strtoupper(Str::random(8)),
            'montant' => -$request->montant,
            'moyen_paiement' => $request->moyen,
            'statut' => 'succes',
            'wallet_status' => 'withdrawn',
            'metadata' => ['type' => 'withdrawal', 'requested_at' => now()]
        ]);

        return back()->with('success', 'Votre demande de retrait de ' . number_format($request->montant) . ' FCFA a été prise en compte.');
    }
}
