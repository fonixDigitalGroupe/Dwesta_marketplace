<?php

namespace App\Http\Controllers;

use App\Services\CreditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    protected $creditService;

    public function __construct(CreditService $creditService)
    {
        $this->creditService = $creditService;
        $this->middleware('auth');
    }

    /**
     * Afficher la page Mon Porte-Monnaie
     */
    public function index()
    {
        $user = Auth::user();
        $balance = $this->creditService->getBalance($user);
        $packs = $this->creditService->getAvailablePacks();
        $transactions = $user->creditTransactions()->latest()->paginate(20);

        return view('credits.index', compact('balance', 'packs', 'transactions'));
    }

    /**
     * Acheter un pack de crédits
     */
    public function buyPack(Request $request)
    {
        $request->validate([
            'pack_id' => 'required|string',
            'payment_method' => 'required|in:om,momo,cb'
        ]);

        $packs = $this->creditService->getAvailablePacks();
        $selectedPack = collect($packs)->firstWhere('id', $request->pack_id);

        if (!$selectedPack) {
            return back()->with('error', 'Pack invalide.');
        }

        // Simulation de paiement (à remplacer par une vraie intégration)
        $totalCredits = $selectedPack['credits'] + $selectedPack['bonus'];
        
        $this->creditService->addCredits(
            Auth::user(),
            $totalCredits,
            "Achat {$selectedPack['label']} ({$selectedPack['credits']} + {$selectedPack['bonus']} bonus)"
        );

        return back()->with('success', "Vous avez reçu {$totalCredits} crédits !");
    }
}
