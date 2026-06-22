@extends('layouts.app')

@section('title', 'Statistiques Vendeur - Karnou')

@push('styles')
<style>
    .gift-card-page {
        max-width: 900px;
    }

    .gift-card-box {
        margin-bottom: 2.5rem;
    }

    .section-title {
        font-size: 0.8rem;
        font-weight: 800;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #f68b1e;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    /* Smaller, prettier cards */
    .stat-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.25rem;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s;
    }

    .stat-card:hover {
        border-color: #f68b1e;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .stat-card .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .stat-card .content {
        text-align: left;
    }

    .stat-card .amount {
        font-size: 1.25rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 2px;
        display: flex;
        align-items: baseline;
        gap: 4px;
    }

    .stat-card .amount small {
        font-size: 0.8rem;
        font-weight: 600;
        color: #999;
    }

    .stat-card .label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Filter Form Styles */
    .stats-filter-form {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .filter-group label {
        font-size: 0.7rem;
        font-weight: 800;
        color: #666;
        text-transform: uppercase;
    }

    .filter-group input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 0.5rem;
        font-size: 0.85rem;
        outline: none;
    }

    .btn-filter {
        background: #004aad;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        height: 38px;
    }

    .btn-filter:hover { background: #003a8c; }

    .btn-reset {
        background: #f68b1e;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .btn-reset:hover { background: #e87a0e; color: white; }

    /* Card Variations */
    .card-rev .icon-circle { background: #fff4e5; color: #f68b1e; }
    .card-orders .icon-circle { background: #e8f5e9; color: #2e7d32; }

    /* History Table (Matches Credits Table) */
    .table-history {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .table-history th {
        text-align: left;
        padding: 0.75rem 1rem;
        background: #fff;
        color: #888;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid #eee;
    }

    .table-history td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f9f9f9;
        vertical-align: middle;
    }

    .badge-status {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-livre { background: #e8f5e9; color: #2e7d32; }
    .status-annule { background: #ffebee; color: #c62828; }
    .status-attente { background: #fff8e6; color: #f68b1e; }
    .status-default { background: #f5f5f5; color: #777; }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content gift-card-page">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Tableau de bord & Statistiques</h1>
        </div>

        @if(session('success'))
            <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9;">
                {{ session('success') }}
            </div>
        @endif

        <div class="gift-card-box">
            <h2 class="section-title">Filtres de période</h2>
            <form action="{{ route('vendeur.stats') }}" method="GET" class="stats-filter-form">
                <div class="filter-group">
                    <label>Date de début</label>
                    <input type="date" name="date_debut" value="{{ $dateDebut }}">
                </div>
                <div class="filter-group">
                    <label>Date de fin</label>
                    <input type="date" name="date_fin" value="{{ $dateFin }}">
                </div>
                <button type="submit" class="btn-filter">Appliquer</button>
                <a href="{{ route('vendeur.stats') }}" class="btn-reset">Réinitialiser</a>
            </form>

            <h2 class="section-title">Aperçu global</h2>
            <div class="stats-grid">
                <div class="stat-card card-rev">
                    <div class="icon-circle"><i class="fas fa-wallet"></i></div>
                    <div class="content">
                        <div class="amount">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} <small>FCFA</small></div>
                        <div class="label">Chiffre d'affaires total</div>
                    </div>
                </div>

                <div class="stat-card card-orders">
                    <div class="icon-circle"><i class="fas fa-shopping-bag"></i></div>
                    <div class="content">
                        <div class="amount">{{ $stats['total_orders'] }}</div>
                        <div class="label">Total Commandes</div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Recent Sales Table -->
        <div class="gift-card-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h2 class="section-title" style="margin-bottom: 0;">Ventes Récentes</h2>
                <a href="{{ route('vendeur.orders') }}" style="font-size: 0.75rem; font-weight: 800; color: #004aad; text-transform: uppercase; text-decoration: none;">Voir tout <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div style="overflow-x: auto; border: 1px solid #eee; border-radius: 8px;">
                <table class="table-history">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th style="text-align: right;">Total Brut</th>
                            <th style="text-align: right;">Com. Platef.</th>
                            <th style="text-align: right;">Net Vendeur</th>
                            <th style="text-align: center;">Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td style="font-weight: 800; color: #000;">#{{ $order->reference }}</td>
                                <td style="text-align: right; font-weight: 700;">{{ number_format($order->total_produits, 0, ',', ' ') }} <small style="font-size: 0.7rem; color: #999;">FCFA</small></td>
                                <td style="text-align: right; color: #d32f2f; font-weight: 600;">-{{ number_format($order->commission_plateforme, 0, ',', ' ') }}</td>
                                <td style="text-align: right; color: #2e7d32; font-weight: 800;">{{ number_format($order->total_produits - $order->commission_plateforme, 0, ',', ' ') }} <small>FCFA</small></td>
                                <td style="text-align: center;">
                                    @php
                                        $s = $order->statut;
                                        $badge = match($s) {
                                            'livre' => 'livre',
                                            'annule' => 'annule',
                                            'en_attente' => 'attente',
                                            default => 'default'
                                        };
                                    @endphp
                                    <span class="badge-status status-{{ $badge }}">{{ $order->statut_label }}</span>
                                </td>
                                <td style="color: #777; font-size: 0.85rem;">{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 3rem; color: #999;">Aucune vente récente enregistrée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
