@extends('layouts.app')

@section('title', 'Espace Transporteur')

@push('styles')
<style>
    .dashboard-container { max-width: 1300px; margin: 2rem auto; padding: 0 1rem; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #1a1a1a; margin-bottom: 2rem; letter-spacing: -0.5px; }

    /* Action Banner */
    .action-banner { background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%); border-radius: 12px; padding: 2rem; color: white; display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15); }
    .action-banner h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; }
    .action-banner p { font-size: 0.95rem; opacity: 0.9; }
    .btn-action-main { background: #ff750f; color: white; text-decoration: none; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 1rem; transition: transform 0.2s, box-shadow 0.2s; display: inline-flex; align-items: center; gap: 8px; border: none; }
    .btn-action-main:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(255,117,15,0.3); color: white; }

    /* Tables */
    .section-header { font-size: 1.25rem; font-weight: 700; color: #333; margin-bottom: 1rem; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #eee; padding-bottom: 0.75rem; }
    .table-card { background: white; border-radius: 12px; border: 1px solid #eaeaea; box-shadow: 0 2px 8px rgba(0,0,0,0.03); overflow: hidden; margin-bottom: 2.5rem; }
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { background: #f8fafc; padding: 1rem 1.5rem; text-align: left; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #eaeaea; }
    .custom-table td { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; color: #334155; vertical-align: middle; }
    .custom-table tr:last-child td { border-bottom: none; }
    .custom-table tr:hover { background: #f8fafc; }

    /* Utilities */
    .order-ref { font-weight: 700; color: #0f172a; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.9rem; }
    .empty-state { text-align: center; padding: 3rem; color: #94a3b8; font-size: 1rem; background: white; border-radius: 12px; border: 1px dashed #cbd5e1; }
    
    /* Buttons and Badges */
    .btn-scan { background: #000; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; cursor: pointer; text-decoration: none; font-size: 0.85rem; transition: background 0.2s; }
    .btn-scan:hover { background: #333; color: white; }
    .badge-route { background: #eff6ff; color: #3b82f6; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border: 1px solid #bfdbfe; }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <h1 class="page-title">Espace Transporteur</h1>

    <!-- Action SCAN -->
    <div class="action-banner">
        <div>
            <h2>Scanner un colis</h2>
            <p>Simulez le scan lors du ramassage d'un colis chez le vendeur.</p>
        </div>
        <a href="{{ route('scan.index') }}" class="btn-action-main">
            <i class="fa-solid fa-barcode"></i> Ouvrir le Scanner
        </a>
    </div>

    <!-- Colis à Ramasser (PRET) -->
    <div>
        <div class="section-header">
            <i class="fa-solid fa-box" style="color: #ff750f;"></i> Colis prêts à être ramassés (Chez le Vendeur)
        </div>
        @if($ordersPickup->count() > 0)
            <div class="table-card">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Vendeur</th>
                            <th>Adresse</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordersPickup as $order)
                        <tr>
                            <td><span class="order-ref">{{ $order->reference }}</span></td>
                            <td style="font-weight: 500;">{{ $order->seller->user->prenom }} {{ $order->seller->user->nom }}</td>
                            <td><span style="color: #64748b; font-size: 0.85rem;"><i class="fa-solid fa-location-dot" style="color:#cbd5e1; margin-right:4px;"></i>{{ $order->seller->user->adresse }}</span></td>
                            <td style="text-align: right;">
                                <form action="{{ route('scan.process') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $order->tracking_token }}">
                                    <button type="submit" class="btn-scan">
                                        Ramasser
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-boxes-stacked" style="font-size: 2rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p>Aucun colis en attente de ramassage.</p>
            </div>
        @endif
    </div>

    <!-- Colis En Route -->
    <div style="margin-top: 3rem;">
        <div class="section-header">
            <i class="fa-solid fa-truck" style="color: #3b82f6;"></i> Colis en cours de livraison
        </div>
        @if($ordersEnRoute->count() > 0)
            <div class="table-card">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Destination</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordersEnRoute as $order)
                        <tr>
                            <td><span class="order-ref">{{ $order->reference }}</span></td>
                            <td>
                                <div style="font-weight: 500;">{{ $order->adresse_livraison }}</div>
                                <div style="font-size: 0.8rem; color: #64748b;">Dakar (Sénégal)</div>
                            </td>
                            <td>
                                <span class="badge-route">En Route</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-truck-ramp-box" style="font-size: 2rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p>Aucun colis en cours de transport actuellement.</p>
            </div>
        @endif
    </div>
</div>
@endsection
