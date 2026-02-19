@extends('layouts.app')

@section('title', 'Tableau de Bord Livreur')

@push('styles')
<style>
    .dashboard-layout { display: flex; max-width: 1300px; margin: 2rem auto; gap: 2rem; padding: 0 1rem; }
    .dashboard-main { flex: 1; }
    
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 2rem; }
    .stat-card { background: white; padding: 1.5rem; border-radius: 12px; border: 1px solid #eee; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .stat-label { font-size: 0.8rem; color: #666; font-weight: 600; text-transform: uppercase; margin-bottom: 0.5rem; }
    .stat-value { font-size: 1.5rem; font-weight: 800; color: #333; }
    
    .section-title { font-size: 1.2rem; font-weight: 700; color: #1a1a1a; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px; }
    
    .order-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; border: 1px solid #eee; }
    .order-table th { background: #f9fafb; padding: 1rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #666; border-bottom: 1px solid #eee; }
    .order-table td { padding: 1rem; border-bottom: 1px solid #f5f5f5; font-size: 0.9rem; color: #333; }
    
    .btn-pickup { background: #000; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; cursor: pointer; text-decoration: none; font-size: 0.85rem; }
    .btn-pickup:hover { background: #333; }
    
    .badge-status { padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .status-pret { background: #ecfdf5; color: #10b981; }
    .status-route { background: #eff6ff; color: #3b82f6; }
    
    .commission-amt { color: #ff750f; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="dashboard-layout">
    @include('layouts.partials/livreur-sidebar')

    <div class="dashboard-main">
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Disponibles</div>
                <div class="stat-value">{{ $stats['disponibles'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">En cours</div>
                <div class="stat-value">{{ $stats['mes_livraisons'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Livrés</div>
                <div class="stat-value">{{ $stats['total_livre'] }}</div>
            </div>
            <div class="stat-card" style="border-left: 4px solid #ff750f;">
                <div class="stat-label">Mes Gains</div>
                <div class="stat-value">{{ number_format($stats['gains'], 0, ',', ' ') }} FCFA</div>
            </div>
        </div>

        <!-- My Current Deliveries -->
        <div class="section-title">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                <path d="M12 6v6l4 2"></path>
            </svg>
            Mes livraisons en cours
        </div>
        
        <table class="order-table" style="margin-bottom: 3rem;">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Destination</th>
                    <th>Vendeur</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myDeliveries as $order)
                <tr>
                    <td style="font-weight: 700;">#{{ $order->reference }}</td>
                    <td>
                        <div style="font-weight: 600;">{{ $order->pays_destination ?? 'Dakar' }}</div>
                        <div style="font-size: 0.8rem; color: #666;">{{ $order->adresse_livraison }}</div>
                    </td>
                    <td>{{ $order->seller->nom_boutique ?? 'Vendeur' }}</td>
                    <td><span class="badge-status status-route">En cours</span></td>
                    <td>
                        <form action="{{ route('livreur.orders.delivered', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-pickup" style="background: #10b981;">Confirmer la livraison (Client)</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #999; padding: 2rem;">Vous n'avez aucune livraison en cours.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Available Orders -->
        <div class="section-title">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Commandes à proximité (Prêtes à livrer)
        </div>
        
        <table class="order-table">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Itinéraire</th>
                    <th>Commission</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($availableOrders as $order)
                <tr>
                    <td style="font-weight: 700;">#{{ $order->reference }}</td>
                    <td>
                        <div style="font-size: 0.85rem; display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <span style="width: 8px; height: 8px; background: #666; border-radius: 50%;"></span>
                                <span>{{ $order->ville_depart ?? 'Dakar' }} ({{ $order->seller->nom_boutique ?? 'Vendeur' }})</span>
                            </div>
                            <div style="border-left: 2px dashed #ccc; margin-left: 3px; height: 10px;"></div>
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <span style="width: 8px; height: 8px; background: #ff750f; border-radius: 50%;"></span>
                                <span style="font-weight: 600;">{{ $order->ville_destination ?? 'Client' }}</span>
                            </div>
                            <div style="font-size: 0.75rem; color: #666; margin-left: 15px;">{{ $order->adresse_livraison }}</div>
                        </div>
                    </td>
                    <td><span class="commission-amt">{{ number_format($order->commission_livreur, 0, ',', ' ') }} FCFA</span></td>
                    <td>
                        <form action="{{ route('livreur.orders.pickup', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-pickup">Accepter la course</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #999; padding: 2rem;">Aucune commande disponible pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
