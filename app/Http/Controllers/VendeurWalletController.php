<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Services\PayDunyaService;
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
     * Demande de retrait via PayDunya
     */
    public function requestWithdrawal(Request $request, PayDunyaService $payDunya)
    {
        $request->validate([
            'montant' => 'required|numeric|min:1',
            'moyen' => 'required|in:om,wave',
            'telephone' => 'required|string|min:7' // Format flexible pour les pays limitrophes ou local
        ]);

        $user = Auth::user();

        if ($request->montant > $user->credit_balance) {
            return back()->with('error', 'Solde insuffisant.');
        }

        try {
            // Appel à PayDunya Disbursement (Payout)
            $response = $payDunya->disburse($request->montant, $request->telephone, $request->moyen, [
                'user_id' => $user->id,
                'vendeur_id' => $user->vendeur->id ?? null
            ]);

            if (isset($response['response_code']) && $response['response_code'] === '00') {
                // Débit du solde
                $user->decrement('credit_balance', $request->montant);

                // Création de la transaction
                Transaction::create([
                    'user_id' => $user->id,
                    'reference_externe' => $response['disburse_token'] ?? ('WD-' . strtoupper(Str::random(8))),
                    'montant' => -$request->montant,
                    'moyen_paiement' => $request->moyen,
                    'statut' => 'succes',
                    'wallet_status' => 'withdrawn',
                    'metadata' => [
                        'type' => 'withdrawal',
                        'requested_at' => now(),
                        'phone' => $request->telephone,
                        'paydunya_token' => $response['disburse_token'] ?? null
                    ]
                ]);

                return back()->with('success', 'Votre retrait de ' . number_format($request->montant) . ' FCFA a été traité avec succès via PayDunya.');
            } else {
                $errorMsg = $response['response_text'] ?? 'Une erreur est survenue lors du retrait via PayDunya.';
                return back()->with('error', 'Erreur : ' . $errorMsg);
            }

        } catch (\Exception $e) {
            Log::error('PayDunya Withdrawal Exception: ' . $e->getMessage());
            return back()->with('error', 'Impossible de traiter le retrait pour le moment. Veuillez réessayer plus tard.');
        }
    }
}
