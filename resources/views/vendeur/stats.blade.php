@extends('layouts.app')

@section('title', 'Statistiques Vendeur - Dwesta')

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 2rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Tableau de bord & Statistiques</h1>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
            <!-- Total Revenue Card -->
            <div style="background: white; border: 1px solid #eee; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 60px; height: 60px; background: #fff8e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ff8c00;">
                    <i class="fas fa-wallet" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Chiffre d'affaires total</div>
                    <div style="font-size: 1.8rem; font-weight: 900; color: #1a1a1a;">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} DA</div>
                </div>
            </div>

            <!-- Total Orders Card -->
            <div style="background: white; border: 1px solid #eee; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 1.5rem;">
                <div style="width: 60px; height: 60px; background: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1976d2;">
                    <i class="fas fa-shopping-bag" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.85rem; color: #888; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Total Commandes</div>
                    <div style="font-size: 1.8rem; font-weight: 900; color: #1a1a1a;">{{ $stats['total_orders'] }}</div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
            <!-- This Month Revenue Card -->
            <div style="background: white; border: 1px solid #eee; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 1.25rem;">
                <div style="width: 50px; height: 50px; background: #e8f5e9; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #2e7d32;">
                    <i class="fas fa-chart-line" style="font-size: 1.2rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.8rem; color: #888; font-weight: 600;">Revenus ce mois</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #1a1a1a;">{{ number_format($stats['revenue_this_month'], 0, ',', ' ') }} DA</div>
                </div>
            </div>

            <!-- This Month Orders Card -->
            <div style="background: white; border: 1px solid #eee; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 1.25rem;">
                <div style="width: 50px; height: 50px; background: #f3e5f5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #7b1fa2;">
                    <i class="fas fa-box" style="font-size: 1.2rem;"></i>
                </div>
                <div>
                    <div style="font-size: 0.8rem; color: #888; font-weight: 600;">Commandes ce mois</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #1a1a1a;">{{ $stats['orders_this_month'] }}</div>
                </div>
            </div>
        </div>

        <div style="margin-top: 2rem; background: #e1f5fe; border: 1px solid #b3e5fc; border-radius: 12px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem; color: #0277bd;">
            <i class="fas fa-info-circle"></i>
            <p style="margin: 0; font-size: 0.95rem; font-weight: 600;">
                Conseil : Augmentez votre visibilité en boostant vos annonces avec vos crédits !
            </p>
        </div>
    </main>
</div>
@endsection
