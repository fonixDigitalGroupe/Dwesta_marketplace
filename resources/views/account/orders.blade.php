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
        color: #f68b1e;
    }
    .jumia-tab.active {
        color: #f68b1e;
        border-bottom-color: #f68b1e;
    }

    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        max-height: 600px;
        overflow-y: auto;
        padding-right: 6px;
    }
    /* Barre de défilement discrète */
    .orders-list::-webkit-scrollbar { width: 8px; }
    .orders-list::-webkit-scrollbar-thumb { background: #d1d1d1; border-radius: 4px; }
    .orders-list::-webkit-scrollbar-track { background: transparent; }
    
    .order-card {
        background: #fff;
        border: 1px solid #f0f0f2;
        border-radius: 6px;
        padding: 0.85rem 1rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .order-thumb {
        width: 72px;
        height: 72px;
        flex-shrink: 0;
        border: 1px solid #eee;
        border-radius: 6px;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .order-thumb img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .order-main {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .order-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .order-titles { min-width: 0; }

    .order-product-name {
        font-size: 0.95rem;
        font-weight: 500;
        color: #313133;
        line-height: 1.3;
    }
    .order-ref {
        font-size: 0.82rem;
        color: #8e8e93;
        margin-top: 2px;
    }

    .btn-detail {
        color: #f68b1e;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.85rem;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-detail:hover { text-decoration: underline; }

    .order-status-line {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }
    .order-badge {
        align-self: flex-start;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 3px 8px;
        border-radius: 3px;
    }
    .order-date {
        font-size: 0.95rem;
        font-weight: 600;
        color: #313133;
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
                    @php
                        $firstItem = $order->items->first();
                        $photo = $firstItem && $firstItem->annonce ? $firstItem->annonce->photoPrincipale() : null;
                        $titre = $firstItem && $firstItem->annonce ? $firstItem->annonce->titre : 'Produit retiré';
                        if($order->items->count() > 1) {
                            $titre .= ' (+ ' . ($order->items->count() - 1) . ' autres produits)';
                        }
                        $badge = match($order->statut) {
                            'paye'            => ['Confirmé', '#16a34a'],
                            'pret_expedition' => ['Prêt pour expédition', '#0076ad'],
                            'en_route'        => ['En livraison', '#0076ad'],
                            'disponible'      => ['Disponible au relais', '#0076ad'],
                            'livre'           => ['Colis livré', '#16a34a'],
                            'en_attente'      => ['En attente de paiement', '#f68b1e'],
                            'annule'          => ['Annulé', '#9ca3af'],
                            default           => [$order->statut_label, '#0076ad'],
                        };
                    @endphp
                    <div class="order-card">
                        <div class="order-thumb">
                            @if($photo)
                                <img src="{{ Storage::url($photo->chemin) }}" alt="">
                            @else
                                <i class="fa-solid fa-image" style="color: #ddd; font-size: 1.5rem;"></i>
                            @endif
                        </div>
                        <div class="order-main">
                            <div class="order-top">
                                <div class="order-titles">
                                    <div class="order-product-name">{{ $titre }}</div>
                                    <div class="order-ref">Commande {{ $order->reference }}</div>
                                </div>
                                <a href="{{ route('account.orders.show', $order) }}" class="btn-detail">Détails</a>
                            </div>
                            <div class="order-status-line">
                                <span class="order-badge" style="background: {{ $badge[1] }};">{{ $badge[0] }}</span>
                                <span class="order-date">Le {{ $order->created_at->format('d-m-Y') }}</span>
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
