@extends('layouts.app')

@section('title', 'Mes Achats - Mady Market')

@push('styles')
<style>
    .orders-list {
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }
    .order-card {
        padding: 1.5rem;
        border-bottom: 1px solid #eee;
        transition: background 0.2s;
    }
    .order-card:last-child {
        border-bottom: none;
    }
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .order-ref {
        font-weight: 800;
        font-size: 1.1rem;
        color: #222;
        text-transform: uppercase;
    }
    .order-date {
        font-size: 0.85rem;
        color: #888;
    }
    .order-status {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-paye { background: #e8f5e9; color: #2e7d32; }
    .status-en_attente { background: #fff3e0; color: #ef6c00; }
    .status-livre { background: #e3f2fd; color: #1976d2; }
    
    .order-items {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .item-row {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .item-img {
        width: 50px;
        height: 50px;
        border-radius: 4px;
        object-fit: cover;
        background: #f5f5f5;
    }
    .item-info {
        flex: 1;
    }
    .item-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
    }
    .item-price {
        font-size: 0.9rem;
        color: #666;
    }
    .order-footer {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-total {
        font-size: 1.1rem;
        font-weight: 800;
        color: #ef6c00;
    }
</style>
@endpush

@section('content')

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mes achats</h1>
        </div>

        @if($orders->isEmpty())
            <div style="background: white; padding: 3rem; text-align: center; border-radius: 8px; border: 1px solid #eee;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🛍️</div>
                <h3 style="margin-bottom: 0.5rem;">Vous n'avez pas encore effectué d'achats.</h3>
            </div>
        @else
            <div class="orders-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-ref">#{{ $order->reference }}</div>
                                <div class="order-date">Commandé le {{ $order->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                            <span class="order-status status-{{ $order->statut }}">
                                {{ $order->statut_label }}
                            </span>
                        </div>

                        <div class="order-items">
                            @foreach($order->items as $item)
                                <div class="item-row">
                                    @if($item->annonce && $item->annonce->main_photo)
                                        <img src="{{ asset('storage/' . $item->annonce->main_photo) }}" class="item-img" alt="">
                                    @else
                                        <div class="item-img"></div>
                                    @endif
                                    <div class="item-info">
                                        <div class="item-name">{{ $item->annonce ? $item->annonce->titre : 'Produit retiré' }}</div>
                                        <div class="item-price">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA x {{ $item->quantite }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="order-footer">
                            <div style="font-size: 0.85rem; color: #888;">
                                Vendu par : <strong>
                                    @if($order->seller && $order->seller->professionnel)
                                        {{ $order->seller->professionnel->nom_entreprise }}
                                    @elseif($order->seller && $order->seller->user)
                                        {{ $order->seller->user->prenom }} {{ $order->seller->user->nom }}
                                    @else
                                        Vendeur inconnu
                                    @endif
                                </strong>
                            </div>
                            <div class="order-total">
                                Total : {{ number_format($order->total_final, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 2rem;">
                {{ $orders->links() }}
            </div>
        @endif
    </main>
</div>
@endsection
