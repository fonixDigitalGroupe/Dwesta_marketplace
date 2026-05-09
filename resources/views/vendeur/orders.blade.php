@extends('layouts.app')

@section('title', 'Mes Ventes - Mady Market')

@push('styles')
<style>
    /* ── Stats bar ─────────────────────────────────────── */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .stat-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        width: 42px; height: 42px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-label { font-size: 0.75rem; color: #999; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
    .stat-value { font-size: 1.3rem; font-weight: 800; color: #1a1a1a; margin-top: 1px; }

    /* ── Table wrapper ─────────────────────────────────── */
    .orders-table-wrap {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 0;
        overflow: hidden;
    }
    .orders-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .orders-table-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* ── Table ─────────────────────────────────────────── */
    table.orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }
    table.orders-table thead th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #aaa;
        border-bottom: 1px solid #eee;
        background: #fafafa;
        white-space: nowrap;
    }
    table.orders-table tbody tr {
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.15s;
    }
    table.orders-table tbody tr:last-child { border-bottom: none; }
    table.orders-table tbody tr:hover { background: #fafcff; }
    table.orders-table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        color: #333;
    }

    /* ── Status badges ─────────────────────────────────── */
    .status-badge {
        display: inline-block;
        padding: 0.22rem 0.7rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border: 1px solid transparent;
    }
    .status-paye        { background: #e8f5e9; color: #2e7d32; border-color: #c8e6c9; }
    .status-en_attente  { background: #fff3e0; color: #e65c00; border-color: #ffe0b2; }
    .status-livre       { background: #e3f2fd; color: #1565c0; border-color: #bbdefb; }
    .status-confirme    { background: #f3e5f5; color: #6a1b9a; border-color: #e1bee7; }
    .status-annule      { background: #fafafa; color: #999;     border-color: #ddd;    }

    /* ── Order ref  ────────────────────────────────────── */
    .order-ref {
        font-weight: 700;
        color: #ff750f;
        font-size: 0.82rem;
        letter-spacing: 0.03em;
    }

    /* ── Inline product list ───────────────────────────── */
    .product-list { display: flex; flex-direction: column; gap: 6px; }
    .product-row  { display: flex; align-items: center; gap: 8px; }
    .product-img  {
        width: 36px; height: 36px;
        border-radius: 5px;
        object-fit: cover;
        background: #f0f0f0;
        flex-shrink: 0;
        border: 1px solid #eee;
    }
    .product-name { font-weight: 600; font-size: 0.83rem; color: #333; }
    .product-qty  { font-size: 0.75rem; color: #aaa; }

    /* ── Buyer ─────────────────────────────────────────── */
    .buyer-name { font-weight: 600; color: #333; }
    .buyer-delivery { font-size: 0.75rem; color: #aaa; margin-top: 2px; }

    /* ── Revenue ───────────────────────────────────────── */
    .revenue { font-weight: 800; color: #2e7d32; }

    /* ── Action button ─────────────────────────────────── */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #1a1a1a;
        color: #fff;
        border: none;
        padding: 0.38rem 0.85rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-action:hover { background: #333; }

    @media (max-width: 1100px) {
        .stats-bar { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stats-bar { grid-template-columns: 1fr 1fr; }
        table.orders-table thead th:nth-child(4),
        table.orders-table tbody td:nth-child(4) { display: none; }
    }
</style>
@endpush

@section('content')

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem;">
            <h1 style="font-size: 1.6rem; font-weight: 800; margin: 0; color: #1a1a1a;">Commandes reçues</h1>
        </div>


        {{-- ── Orders Table ────────────────────────────────── --}}
        @if($orders->isEmpty())
            <div style="background: #fff; border: 1px solid #eee; border-radius: 10px; padding: 4rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                <h3 style="margin-bottom: 0.5rem; color: #333;">Aucune commande pour l'instant.</h3>
                <p style="color: #aaa; font-size: 0.9rem;">Dès qu'un client achète l'un de vos produits, la commande apparaîtra ici.</p>
            </div>
        @else
            <div class="orders-table-wrap">

                <div style="overflow-x: auto;">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Produit(s)</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th style="text-align: right;">Revenu</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    {{-- Référence --}}
                                    <td>
                                        <span class="order-ref">#{{ $order->reference }}</span>
                                    </td>

                                    {{-- Produits --}}
                                    <td>
                                        <div class="product-list">
                                            @foreach($order->items->take(2) as $item)
                                                <div class="product-row">
                                                    @if($item->annonce && $item->annonce->main_photo)
                                                        <img src="{{ asset('storage/' . $item->annonce->main_photo) }}" class="product-img" alt="">
                                                    @else
                                                        <div class="product-img"></div>
                                                    @endif
                                                    <div>
                                                        <div class="product-name">{{ Str::limit($item->annonce ? $item->annonce->titre : 'Produit retiré', 28) }}</div>
                                                        <div class="product-qty">Qté : {{ $item->quantite }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 2)
                                                <div style="font-size: 0.73rem; color: #aaa; margin-left: 44px;">+{{ $order->items->count() - 2 }} autre(s)</div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Acheteur --}}
                                    <td>
                                        <div class="buyer-name">{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</div>
                                        <div class="buyer-delivery">{{ ucfirst(str_replace('_', ' ', $order->mode_livraison)) }}</div>
                                    </td>

                                    {{-- Date --}}
                                    <td style="white-space: nowrap; color: #888; font-size: 0.8rem;">
                                        {{ $order->created_at->format('d/m/Y') }}<br>
                                        <span style="color:#bbb;">{{ $order->created_at->format('H:i') }}</span>
                                    </td>

                                    {{-- Statut --}}
                                    <td>
                                        <span class="status-badge status-{{ $order->statut }}">
                                            {{ $order->statut_label }}
                                        </span>
                                    </td>

                                    {{-- Revenu --}}
                                    <td style="text-align: right;">
                                        <span class="revenue">{{ number_format($order->total_produits, 0, ',', ' ') }}</span>
                                        <span style="font-size: 0.72rem; color: #aaa; font-weight: 600;"> FCFA</span>
                                    </td>

                                    {{-- Action --}}
                                    <td style="text-align: right;">
                                        <a href="{{ route('vendeur.orders.show', $order) }}" class="btn-action" style="text-decoration: none;">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Voir
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $orders->links() }}
            </div>
        @endif

    </main>
</div>
@endsection
