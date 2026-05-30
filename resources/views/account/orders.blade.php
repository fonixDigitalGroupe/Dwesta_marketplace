@extends('layouts.app')

@section('title', 'Mes Achats - Mady Market')

@push('styles')
<style>
    .jumia-tabs {
        display: flex;
        gap: 24px;
        border-bottom: 1px solid #eeeeee;
        margin-top: 1rem;
        margin-bottom: 1.5rem;
    }
    .jumia-tab {
        color: #777;
        font-weight: 600;
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
    
    .jumia-card {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 1rem;
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
        background: #fff;
    }
    
    .jumia-card-img {
        width: 80px;
        height: 80px;
        border-radius: 4px;
        object-fit: contain;
        background: #fcfcfc;
        border: 1px solid #eee;
        flex-shrink: 0;
    }
    .jumia-card-img-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 4px;
        background: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .jumia-card-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }
    
    .jumia-card-title {
        font-size: 1rem;
        font-weight: 500;
        color: #333;
        margin: 0 0 4px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .jumia-card-ref {
        font-size: 0.85rem;
        color: #777;
        margin-bottom: 12px;
    }
    
    .jumia-status-badge {
        display: inline-block;
        background: #00a046;
        color: #fff;
        padding: 2px 6px;
        font-size: 0.65rem;
        font-weight: 700;
        border-radius: 2px;
        text-transform: uppercase;
        margin-bottom: 6px;
        align-self: flex-start;
    }
    .jumia-status-badge.attente { background: #f68b1e; }
    .jumia-status-badge.annule { background: #d32f2f; }
    
    .jumia-card-date {
        font-size: 0.9rem;
        font-weight: 700;
        color: #333;
    }

    .jumia-card-actions {
        display: flex;
        align-items: flex-start;
        min-width: 80px;
        justify-content: flex-end;
    }
    
    .jumia-btn-details {
        color: #f68b1e;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
    }
    .jumia-btn-details:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <div style="padding-bottom: 0.5rem; margin-bottom: 2rem; border-bottom: 1px solid #eee; margin-left: -1.5rem; margin-right: -1.5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
            <h1 style="font-size: 1.25rem; font-weight: 600; color: #333; margin: 0;">Vos commandes</h1>
        </div>

        <div class="jumia-tabs">
            <a href="?tab=active" class="jumia-tab {{ $tab !== 'returned' ? 'active' : '' }}">
                EN COURS/LIVRÉES ({{ $activeCount ?? 0 }})
            </a>
            <a href="?tab=returned" class="jumia-tab {{ $tab === 'returned' ? 'active' : '' }}">
                ANNULÉES/RETOURNÉES ({{ $returnedCount ?? 0 }})
            </a>
        </div>

        @if($orders->isEmpty())
            <div style="padding: 3rem; text-align: center;">
                <div style="font-size: 4rem; color: #ddd; margin-bottom: 1.5rem;"><i class="fa-solid fa-bag-shopping"></i></div>
                <h3 style="margin-bottom: 0.5rem; color: #444;">Vous n'avez pas encore effectué d'achats.</h3>
                <p style="color: #666; font-size: 0.95rem;">Découvrez des milliers de produits et trouvez votre bonheur dès maintenant.</p>
            </div>
        @else
            <div class="orders-list" style="border: none; background: transparent;">
                @foreach($orders as $order)
                    @php 
                        $firstItem = $order->items->first();
                        $statusClass = '';
                        if(in_array($order->statut, ['en_attente', 'paye', 'pret_expedition'])) $statusClass = 'attente';
                        if(in_array($order->statut, ['annule', 'litige'])) $statusClass = 'annule';
                        
                        $titre = $firstItem && $firstItem->annonce ? $firstItem->annonce->titre : 'Produit retiré';
                        if($order->items->count() > 1) {
                            $titre .= ' (+ ' . ($order->items->count() - 1) . ' autres produits)';
                        }
                    @endphp
                    <div class="jumia-card">
                        @php $photo = $firstItem && $firstItem->annonce ? $firstItem->annonce->photoPrincipale() : null; @endphp
                        @if($photo)
                            <img src="{{ Storage::url($photo->chemin) }}" class="jumia-card-img" alt="">
                        @else
                            <div class="jumia-card-img-placeholder">
                                <i class="fa-solid fa-star"></i>
                            </div>
                        @endif
                        
                        <div class="jumia-card-info">
                            <h3 class="jumia-card-title">{{ $titre }}</h3>
                            <div class="jumia-card-ref">Commande {{ $order->reference }}</div>
                            <span class="jumia-status-badge {{ $statusClass }}">
                                {{ $order->statut_label }}
                            </span>
                            <div class="jumia-card-date">Le {{ $order->created_at->format('d-m-Y') }}</div>
                        </div>

                        <div class="jumia-card-actions">
                            <a href="{{ route('account.orders.show', $order) }}" class="jumia-btn-details">Détails</a>
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
