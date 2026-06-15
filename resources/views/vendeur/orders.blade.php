@extends('layouts.app')

@section('title', 'Mes Commandes - Karnou')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    .dashboard-container {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .orders-list { display: flex; flex-direction: column; gap: 1rem; }
    
    .order-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: #75757a;
        margin-bottom: 0.25rem;
    }

    .order-card-status-title {
        font-size: 1.15rem;
        font-weight: 500;
        color: #313133;
        margin-bottom: 0.25rem;
    }

    .order-card-description {
        font-size: 0.88rem;
        color: #535357;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        max-width: 900px;
    }

    .product-info-box {
        border: 1px solid #d1d1d1;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        display: flex;
        align-self: flex-start;
        align-items: center;
        gap: 1.5rem;
        min-width: 60%;
    }
    
    .order-image-box {
        width: 60px;
        height: 60px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
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
        font-weight: 400;
        color: #313133;
    }

    .btn-detail {
        color: #f68b1e;
        font-weight: 400;
        text-decoration: none;
        font-size: 0.85rem;
    }
    .btn-detail:hover {
        text-decoration: underline;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        border-top: 1px solid #f1f1f1;
        padding-top: 0.75rem;
    }

    .order-price {
        font-weight: 500;
        color: #313133;
        font-size: 0.95rem;
    }

    .btn-validate {
        background: #f68b1e;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
        cursor: pointer;
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
                        @elseif($order->statut === 'pret_expedition')
                            Prêt pour expédition!
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
                        Votre commande {{ $order->reference }} a été {{ $order->statut === 'paye' ? 'confirmée' : ($order->statut === 'pret_expedition' ? 'marquée comme prête' : ($order->statut === 'livre' ? 'livrée' : 'mise à jour')) }}. 
                        @if($order->statut === 'paye')
                            Elle est prête à être préparée pour l'expédition.
                        @elseif($order->statut === 'pret_expedition')
                            Elle est en attente de ramassage par le transporteur.
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
