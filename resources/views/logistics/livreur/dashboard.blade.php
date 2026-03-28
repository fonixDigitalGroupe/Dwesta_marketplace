@extends('layouts.livreur')

@section('title', 'Tableau de bord - Livreur')

@push('styles')
<style>
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .metric-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .metric-title {
        color: #666;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .mady-table {
        width: 100%;
        border-collapse: collapse;
    }

    .mady-table th {
        background: #f8fafc;
        padding: 0.75rem 1rem;
        font-size: 0.8rem;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
    }

    .mady-table td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
        color: #334155;
        vertical-align: middle;
    }

    .mady-table tbody tr:hover {
        background: #f8fafc;
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-blue { background: #eff6ff; color: #3b82f6; border: 1px solid #bfdbfe; }
    .badge-green { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .badge-orange { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }

    .action-btn {
        background: #fff;
        border: 1px solid #d1d5db;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .action-btn:hover { background: #f9fafb; border-color: #9ca3af; }
    .action-btn.primary { background: #ff8c00; color: white; border-color: #ff8c00; }
    .action-btn.primary:hover { background: #e67e00; border-color: #e67e00; }
    .action-btn.success { background: #10b981; color: white; border-color: #10b981; }
    .action-btn.success:hover { background: #059669; border-color: #059669; }
</style>
@endpush

@section('breadcrumbs')
    > <span>Tableau de bord</span>
@endsection

@section('content')

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 0.25rem;">Espace Livreur</h1>
            <p style="color: #64748b; font-size: 0.95rem;">Gérez vos livraisons finales et vos courses de proximité.</p>
        </div>
        <div>
            <a href="#" class="btn-pro-primary" style="background: #ff8c00;">
                <i class="fas fa-route"></i> Zone de livraison
            </a>
        </div>
    </div>

    <!-- Metrics -->
    <div class="metric-grid">
        <div class="metric-card" style="border-top: 4px solid #ff8c00;">
            <div class="metric-title">Colis Disponibles</div>
            <div class="metric-value">{{ $stats['disponibles'] }}</div>
        </div>
        <div class="metric-card" style="border-top: 4px solid #3b82f6;">
            <div class="metric-title">Livraisons en cours</div>
            <div class="metric-value">{{ $stats['mes_livraisons'] }}</div>
        </div>
        <div class="metric-card" style="border-top: 4px solid #10b981;">
            <div class="metric-title">Total Livré</div>
            <div class="metric-value">{{ $stats['total_livre'] }}</div>
        </div>
        <div class="metric-card" style="border-top: 4px solid #8b5cf6;">
            <div class="metric-title">Mes Commissions</div>
            <div class="metric-value">{{ number_format($stats['gains'], 0, ',', ' ') }} <span style="font-size: 0.9rem; color: #64748b;">FCFA</span></div>
        </div>
    </div>


    <!-- Mes Livraisons (En Route) -->
    <div class="card-pro" style="padding: 0;">
        <div class="card-header" style="padding: 1.5rem 1.5rem 1rem 1.5rem; margin-bottom: 0;">
            <div class="card-title">
                <i class="fas fa-truck-ramp-box" style="color: #3b82f6;"></i> Mes livraisons en cours
            </div>
            <span class="badge badge-blue">{{ $myDeliveries->count() }} en cours</span>
        </div>
        
        @if($myDeliveries->count() > 0)
        <table class="mady-table">
            <thead>
                <tr>
                    <th>N° Suivi</th>
                    <th>Destination</th>
                    <th>Acheteur</th>
                    <th>Statut</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($myDeliveries as $order)
                <tr>
                    <td><strong>#{{ $order->reference }}</strong></td>
                    <td>
                        <div style="font-weight: 500;">{{ $order->ville_destination ?? 'Dakar' }}</div>
                        <div style="font-size: 0.8rem; color: #64748b;">{{ $order->adresse_livraison }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $order->buyer->prenom ?? 'Client' }} {{ $order->buyer->nom ?? '' }}</div>
                        <div style="font-size: 0.8rem; color: #64748b;"><i class="fas fa-phone" style="margin-right:4px;"></i>{{ $order->buyer->telephone ?? 'N/A' }}</div>
                    </td>
                    <td><span class="badge badge-blue">En Route</span></td>
                    <td style="text-align: right;">
                        <form action="{{ route('livreur.delivered', $order) }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="action-btn success" title="Marquer comme livré">
                                <i class="fas fa-check-circle"></i> Livré
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="padding: 3rem; text-align: center; color: #64748b;">
            <i class="fas fa-box" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 1rem; display: block;"></i>
            Vous n'avez pas de livraison active pour le moment.
        </div>
        @endif
    </div>

@endsection
