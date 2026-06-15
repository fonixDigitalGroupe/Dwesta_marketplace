@extends('layouts.app')

@section('title', 'Mes Commandes - Karnou')

@push('styles')
<style>
    .orders-list { display: flex; flex-direction: column; gap: 1.25rem; }
    
    .order-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 0.9rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }
    
    .order-image-box {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
    }
    .order-image-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .order-main-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .order-title {
        font-size: 0.95rem;
        font-weight: 400;
        color: #282828;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .order-ref {
        font-size: 0.82rem;
        color: #75757a;
        margin-bottom: 6px;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 2px;
        margin-bottom: 8px;
        width: fit-content;
    }
    
    .status-paye { background: #009966; color: #fff; }
    .status-en_attente { background: #f68b1e; color: #fff; }
    .status-livre { background: #009966; color: #fff; }
    .status-annule { background: #e0e0e0; color: #333; }

    .order-date {
        font-weight: 700;
        color: #333;
        font-size: 0.9rem;
    }

    .order-extra-data {
        margin-top: 6px;
        font-size: 0.8rem;
        color: #666;
        display: flex;
        gap: 1.5rem;
    }

    .btn-detail {
        color: #f68b1e;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.95rem;
        margin-top: 2px;
        white-space: nowrap;
    }
    .btn-detail:hover {
        text-decoration: underline;
    }

    .action-required-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fff4e5;
        color: #f68b1e;
        border: 1px solid #f68b1e;
        border-radius: 3px;
        padding: 3px 8px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 6px;
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
                    
                    <div style="display: flex; gap: 1.5rem; flex: 1;">
                        <div class="order-image-box">
                            @php 
                                $firstItem = $order->items->first();
                                $photo = $firstItem ? $firstItem->annonce->photoPrincipale() : null; 
                            @endphp
                            <img src="{{ $photo ? Storage::url($photo->chemin) : 'https://via.placeholder.com/100' }}">
                        </div>

                        <div class="order-main-info">

                            <div class="order-title">
                                @foreach($order->items as $item)
                                    {{ $item->annonce->titre }}@if(!$loop->last), @endif
                                @endforeach
                            </div>
                            <div class="order-ref">
                                Commande {{ $order->reference }}
                            </div>
                            
                            <div class="status-badge status-{{ $order->statut }}">
                                {{ Str::upper(str_replace('_', ' ', $order->statut)) }}
                            </div>

                            <div class="order-date">
                                Le {{ $order->created_at->format('d-m-Y') }}
                            </div>

                            <!-- Keep seller info intact -->
                            <div class="order-extra-data">
                                <div>Acheteur : <strong>{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</strong></div>
                                <div>Total : <strong>{{ number_format($order->total_produits, 0, ',', ' ') }} DA</strong></div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                        <a href="{{ route('vendeur.orders.show', $order->id) }}" class="btn-detail">Détails</a>
                        @if($order->statut === 'paye')
                            <form method="POST" action="{{ route('logistics.markAsReady', $order) }}">
                                @csrf
                                <button type="submit" style="background:#f68b1e; color:#fff; border:none; padding:5px 12px; border-radius:3px; font-size:0.75rem; font-weight:700; cursor:pointer; white-space:nowrap;">
                                    ✓ Valider
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 4rem; background: white; color: #888;">
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
