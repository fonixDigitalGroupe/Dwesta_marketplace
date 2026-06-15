@extends('layouts.app')

@section('title', 'Mes Achats - Karnou')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    .dashboard-container {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .jumia-tabs {
        display: flex;
        gap: 24px;
        border-bottom: 1px solid #eeeeee;
        margin-top: 1rem;
        margin-bottom: 1.5rem;
    }
    .jumia-tab {
        color: #75757a;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        text-transform: uppercase;
        padding: 0 0 10px 0;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
    }
    .jumia-tab:hover {
        color: #004aad;
    }
    .jumia-tab.active {
        color: #004aad;
        border-bottom-color: #004aad;
    }

    .orders-list { display: flex; flex-direction: column; gap: 1rem; }
    
    .order-card {
        background: #fff;
        border: 1px solid #f0f0f2;
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
        border: 1px solid #ececee;
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
        color: #004aad;
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
</style>
@endpush

@section('content')

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <div style="padding-bottom: 0.5rem; margin-bottom: 1rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.15rem; font-weight: 600; color: #333; margin: 0;">Vos commandes</h1>
        </div>

        <div class="jumia-tabs">
            <a href="?tab=active" class="jumia-tab {{ $tab !== 'returned' ? 'active' : '' }}">
                EN COURS/LIVRÉES ({{ $activeCount ?? 0 }})
            </a>
            <a href="?tab=returned" class="jumia-tab {{ $tab === 'returned' ? 'active' : '' }}">
                ANNULÉES ({{ $returnedCount ?? 0 }})
            </a>
        </div>

        @if($orders->isEmpty())
            <div style="padding: 4rem; text-align: center; background: white; border: 1px solid #f0f0f2; border-radius: 4px;">
                <div style="font-size: 3rem; color: #ddd; margin-bottom: 1.5rem;"><i class="fa-solid fa-bag-shopping"></i></div>
                <h3 style="margin-bottom: 0.5rem; color: #444; font-size: 1.1rem; font-weight: 600;">Vous n'avez pas encore effectué d'achats.</h3>
                <p style="color: #666; font-size: 0.9rem;">Découvrez des milliers de produits et trouvez votre bonheur dès maintenant.</p>
            </div>
        @else
            <div class="orders-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-card-header">
                            <span>{{ $order->created_at->translatedFormat('d F') }}</span>
                            <a href="{{ route('account.orders.show', $order) }}" class="btn-detail">Détails</a>
                        </div>

                        <div class="order-card-status-title">
                            @if($order->statut === 'paye')
                                Confirmé!
                            @elseif($order->statut === 'pret_expedition')
                                Prêt pour expédition!
                            @elseif($order->statut === 'en_route')
                                En cours de livraison!
                            @elseif($order->statut === 'livre')
                                Livré!
                            @elseif($order->statut === 'en_attente')
                                En attente de paiement
                            @elseif($order->statut === 'annule')
                                Annulé
                            @else
                                {{ $order->statut_label }}
                            @endif
                        </div>

                        <div class="order-card-description">
                            Votre commande {{ $order->reference }} a été {{ $order->statut === 'paye' ? 'confirmée' : ($order->statut === 'livre' ? 'livrée' : 'mise à jour') }}. 
                            @if($order->statut === 'paye')
                                Le vendeur prépare actuellement votre colis.
                            @elseif($order->statut === 'en_route')
                                Votre colis est en cours d'acheminement vers vous.
                            @endif
                            Merci pour votre achat sur Karnou!
                        </div>

                        <div class="product-info-box">
                            <div class="order-image-box">
                                @php 
                                    $firstItem = $order->items->first();
                                    $photo = $firstItem && $firstItem->annonce ? $firstItem->annonce->photoPrincipale() : null; 
                                @endphp
                                @if($photo)
                                    <img src="{{ Storage::url($photo->chemin) }}" alt="">
                                @else
                                    <i class="fa-solid fa-image" style="color: #ddd; font-size: 1.5rem;"></i>
                                @endif
                            </div>
                            <div class="product-details">
                                <div class="product-name">
                                    @php 
                                        $titre = $firstItem && $firstItem->annonce ? $firstItem->annonce->titre : 'Produit retiré';
                                        if($order->items->count() > 1) {
                                            $titre .= ' (+ ' . ($order->items->count() - 1) . ' autres produits)';
                                        }
                                    @endphp
                                    {{ $titre }}
                                </div>
                            </div>
                        </div>

                        <div class="order-footer">
                            <div class="order-price">
                                Total : {{ number_format($order->total_final ?? $order->total_produits, 0, ',', ' ') }} FCFA
                            </div>
                            @if($order->statut === 'en_route')
                                <a href="{{ route('account.orders.tracking', $order) }}" class="btn-detail">Suivre mon colis</a>
                            @endif
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
