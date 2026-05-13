<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PointRelais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Un utilisateur peut gérer plusieurs points relais
        $agencies = $user->pointRelais;

        if ($agencies->isEmpty()) {
            return view('dashboard_no_agence');
        }

        // Pour l'instant, on prend le premier ou on laisse choisir
        $currentAgency = $agencies->first();

        $expectedPackages = Order::where('destination_point_relais_id', $currentAgency->id)
            ->whereIn('statut', [Order::STATUT_EN_ROUTE])
            ->latest()
            ->get();

        $inStockPackages = Order::where('destination_point_relais_id', $currentAgency->id)
            ->where('statut', Order::STATUT_DISPONIBLE)
            ->latest()
            ->get();

        $recentReleases = Order::where('destination_point_relais_id', $currentAgency->id)
            ->where('statut', Order::STATUT_LIVRE)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('currentAgency', 'expectedPackages', 'inStockPackages', 'recentReleases'));
    }
}
