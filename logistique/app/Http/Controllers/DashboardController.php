<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // S'assurer que l'utilisateur a un profil livreur
        if (!$user->livreur) {
            return view('dashboard_no_livreur');
        }

        $activeDeliveries = Order::where('livreur_id', $user->livreur->id)
            ->whereIn('statut', [Order::STATUT_EN_ROUTE])
            ->latest()
            ->get();

        $completedDeliveries = Order::where('livreur_id', $user->livreur->id)
            ->where('statut', Order::STATUT_LIVRE)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('activeDeliveries', 'completedDeliveries'));
    }
}
