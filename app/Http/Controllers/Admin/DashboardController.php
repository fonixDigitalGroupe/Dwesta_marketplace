<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendeur;
use App\Models\Annonce;
use App\Models\Litige;
use App\Models\Order;
use App\Models\PointRelais;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        // 1. Utilisateurs & Vendeurs
        $usersCount = User::count();
        $newUsersThisMonth = User::where('created_at', '>=', $startOfMonth)->count();
        
        $vendeursCount = Vendeur::count();
        $proSellers = Vendeur::where('type', 'professionnel')->count();
        $amateurSellers = Vendeur::where('type', 'particulier')->count();
        $vendeursPending = Vendeur::where('statut_verification', 'en_attente')->count();

        // 2. Annonces (Catalogue)
        $annoncesCount = Annonce::where('statut', 'publiee')->count();
        $annoncesPending = Annonce::where('statut', 'en_attente')->count();

        // 3. Logistique
        $pointsRelaisCount = PointRelais::where('is_active', true)->count();
        
        $litigesOpen = Litige::where('statut', 'en_cours')->count();

        // 4. Commandes & Finances
        $ordersCount = Order::count();
        
        // Commandes en cours (payé, prêt, en route, disponible)
        $ordersInProgress = Order::whereIn('statut', ['paye', 'pret_expedition', 'en_route', 'disponible'])->count();
        $ordersDelivered = Order::where('statut', 'livre')->count();

        // Volume d'affaires global et commissions générées (sur les commandes payées ou plus)
        // On exclut les commandes en attente de paiement, annulées, etc. pour le CA réel
        $completedOrders = Order::whereIn('statut', ['paye', 'pret_expedition', 'en_route', 'disponible', 'livre'])->get();
        $totalCA = $completedOrders->sum('total_final');
        $totalCommissions = $completedOrders->sum('commission_plateforme');

        // 5. Activité Récente
        $latestOrders = Order::with(['buyer', 'seller.user', 'seller.professionnel'])
            ->latest()
            ->take(5)
            ->get();
            
        $latestVendeurs = Vendeur::with(['user', 'professionnel'])
            ->latest()
            ->take(5)
            ->get();

        $stats = compact(
            'usersCount', 'newUsersThisMonth', 'vendeursCount', 'proSellers', 'amateurSellers', 'vendeursPending',
            'annoncesCount', 'annoncesPending', 'pointsRelaisCount', 'litigesOpen',
            'ordersCount', 'ordersInProgress', 'ordersDelivered', 
            'totalCA', 'totalCommissions',
            'latestOrders', 'latestVendeurs'
        );

        return view('admin.dashboard', compact('stats'));
    }
}
