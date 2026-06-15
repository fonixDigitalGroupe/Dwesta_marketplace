@extends('layouts.app')

@section('title', 'Mes Commandes - Karnou')

@push('styles')
<style>
    .orders-list { display: flex; flex-direction: column; gap: 1.5rem; }
    
    .order-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        transition: box-shadow 0.2s;
    }
    
    .order-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #75757a;
    }

    .order-card-status-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #282828;
        margin-top: 0.25rem;
    }

    .order-card-description {
        font-size: 0.9rem;
        color: #282828;
        line-height: 1.5;
        margin-bottom: 0.5rem;
    }

    .product-info-box {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 0.75rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .order-image-box {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
        border-radius: 4px;
    }
    
    .order-image-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: #282828;
        line-height: 1.4;
    }

    .btn-detail {
        color: #f68b1e;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s;
    }
    .btn-detail:hover {
        color: #e07a16;
        text-decoration: none;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
    }

    .order-price {
        font-weight: 700;
        color: #f68b1e;
        font-size: 1.05rem;
    }

    .btn-validate {
        background: #f68b1e;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-validate:hover {
        background: #e07a16;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mes ventes</h1>
            <div style="font-size: 0.85rem; color: #666;">
                {{ $orders->total() }} commande(s) trouvée(s)
            </div>
        </div>

        <div class="orders-list">
            @forelse($orders as $order)
                <div class="order-card">
                    <div class="order-card-header">
                        <span>{{ $order->created_at->translatedFormat('d F') }}</span>
                        <a href="{{ route('vendeur.orders.show', $order->id) }}" class="btn-detail">Détails</a>
                    </div>

                    <div class="order-card-status-title">
                        @if($order->statut === 'paye')
                            Confirmé!
                        @elseif($order->statut === 'en_attente')
                            En attente de paiement
                        @elseif($order->statut === 'livre')
                            Livré!
                        @elseif($order->statut === 'annule')
                            Annulé
                        @else
                            {{ ucfirst(str_replace('_', ' ', $order->statut)) }}
                        @endif
                    </div>

                    <div class="order-card-description">
                        Votre commande {{ $order->reference }} a été {{ $order->statut === 'paye' ? 'confirmée' : ($order->statut === 'livre' ? 'livrée' : 'mise à jour') }}. 
                        @if($order->statut === 'paye')
                            Elle est prête à être préparée pour l'expédition.
                        @endif
                        Nous vous remercions pour votre activité sur Karnou!
                    </div>

                    <div class="product-info-box">
                        <div class="order-image-box">
                            @php 
                                $firstItem = $order->items->first();
                                $photo = $firstItem ? $firstItem->annonce->photoPrincipale() : null; 
                            @endphp
                            <img src="{{ $photo ? Storage::url($photo->chemin) : 'https://via.placeholder.com/100' }}">
                        </div>
                        <div class="product-details">
                            <div class="product-name">
                                @if($order->items->count() > 1)
                                    {{ $order->items->first()->annonce->titre }} et {{ $order->items->count() - 1 }} autre(s) article(s)
                                @else
                                    {{ $order->items->first()->annonce->titre ?? 'Produit sans titre' }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="order-footer">
                        <div class="order-price">
                            Total : {{ number_format($order->total_produits, 0, ',', ' ') }} FCFA
                        </div>
                        @if($order->statut === 'paye')
                            <form method="POST" action="{{ route('logistics.markAsReady', $order) }}">
                                @csrf
                                <button type="submit" class="btn-validate">
                                    ✓ Valider
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 4rem; background: white; color: #888; border: 1px solid #e0e0e0; border-radius: 4px;">
                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p style="font-size: 1.1rem; font-weight: 600;">Aucune vente pour le moment</p>
                </div>
            @endforelse
        </div>

        <div style="margin-top: 2rem;">
            {{ $orders->links() }}
        </div>
    </main>
</div>
@endsection
