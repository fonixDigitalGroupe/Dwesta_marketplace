@extends('layouts.livreur')

@section('title', 'Historique Livré - Livreur')

@push('styles')
<style>
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

    .badge-green { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

    .commission-text {
        font-weight: 800;
        color: #10b981;
    }
</style>
@endpush

@section('breadcrumbs')
    > <span>Livreur</span> > <span>Historique des livraisons</span>
@endsection

@section('content')

    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin-bottom: 0.25rem;">Historique Livré</h1>
        <p style="color: #64748b; font-size: 0.95rem;">Retrouvez ici toutes vos livraisons terminées et vos gains associés.</p>
    </div>

    <div class="card-pro" style="padding: 0;">
        <div class="card-header" style="padding: 1.5rem 1.5rem 1rem 1.5rem; margin-bottom: 0;">
            <div class="card-title">
                <i class="fas fa-check-double" style="color: #10b981;"></i> Livraisons effectuées
            </div>
            <span class="badge badge-green">{{ $history->total() }} terminées</span>
        </div>
        
        @if($history->count() > 0)
        <table class="mady-table">
            <thead>
                <tr>
                    <th>N° Suivi</th>
                    <th>Destination</th>
                    <th>Date de livraison</th>
                    <th>Commission</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $order)
                <tr>
                    <td><strong>#{{ $order->reference }}</strong></td>
                    <td>
                        <div style="font-weight: 500;">{{ $order->ville_destination ?? 'Dakar' }}</div>
                        <div style="font-size: 0.8rem; color: #64748b;">{{ $order->adresse_livraison }}</div>
                    </td>
                    <td>
                        <div style="font-size: 0.9rem;">{{ $order->updated_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td>
                        <span class="commission-text">{{ number_format($order->commission_livreur, 0, ',', ' ') }} FCFA</span>
                    </td>
                    <td><span class="badge badge-green">Livré</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="padding: 1.5rem;">
            {{ $history->links() }}
        </div>
        @else
        <div style="padding: 4rem; text-align: center; color: #64748b;">
            <i class="fas fa-history" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1.5rem; display: block;"></i>
            Vous n'avez pas encore effectué de livraison.
        </div>
        @endif
    </div>

@endsection
