<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer toutes les annonces de l'utilisateur s'il est vendeur
        $annonces = collect();
        if ($user->estVendeur()) {
            $annonces = $user->vendeur->annonces()
                ->with(['categorie', 'medias' => function($query) {
                    $query->where('type', 'photo')->orderBy('ordre');
                }])
                ->latest()
                ->get();
        }
        
        // Récupérer les achats (commandes passées)
        $orders = $user->orders()->with('items.annonce', 'seller.user')->latest()->get();
        
        return view('dashboard.index', [
            'user' => $user,
            'annonces' => $annonces,
            'orders' => $orders,
        ]);
    }
}

