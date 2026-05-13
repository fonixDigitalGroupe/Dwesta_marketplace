@extends('layouts.app')

@section('title', 'Mes Commandes - Mady Market')

@push('styles')
<style>
    .orders-list { background: transparent; display: flex; flex-direction: column; gap: 1rem; }
    .order-card { background: white; border: 1px solid #eee; border-radius: 12px; padding: 1.5rem; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .order-card:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0,0,0,0.05); }
    
    .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid #f8f9fa; }
    .order-info { display: flex; flex-direction: column; gap: 4px; }
    .order-ref { font-weight: 900; font-size: 1.05rem; color: #1a1a1a; text-transform: uppercase; }
    .order-date { font-size: 0.85rem; color: #888; }
    
    .status-badge { padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; border: 1px solid transparent; }
    .status-paye { background: #e8f5e9; color: #1b5e20; border-color: #c8e6c9; }
    .status-en_attente { background: #fff3e0; color: #e65100; border-color: #ffe0b2; }
    .status-livre { background: #e3f2fd; color: #0d47a1; border-color: #bbdefb; }
    .status-annule { background: #fafafa; color: #999; border-color: #ddd; }

    .item-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .item-img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; background: #f5f5f5; border: 1px solid #eee; }
    .item-meta { flex: 1; }
    .item-name { font-size: 0.95rem; font-weight: 700; color: #333; margin-bottom: 2px; }
    .item-buyer { font-size: 0.85rem; color: #777; }

    .order-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px dashed #eee; }
    .total-box { display: flex; flex-direction: column; }
    .total-label { font-size: 0.75rem; color: #999; text-transform: uppercase; font-weight: 700; }
    .total-value { font-size: 1.2rem; font-weight: 900; color: #ff8c00; }
    
    .btn-detail { background: #f8f9fa; color: #444; border: 1px solid #ddd; padding: 0.6rem 1.25rem; border-radius: 8px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s; }
    .btn-detail:hover { background: #000; color: #fff; border-color: #000; }

    .commission-box { font-size: 0.8rem; color: #777; font-style: italic; }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mes commandes reçues</h1>
            <div style="font-size: 0.85rem; color: #666;">
                {{ $orders->total() }} commande(s) trouvée(s)
            </div>
        </div>

        <div class="orders-list">
            @forelse($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <span class="order-ref">#{{ $order->reference }}</span>
                            <span class="order-date">Commandé le {{ $order->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="status-badge status-{{ $order->statut }}">
                            {{ Str::upper(str_replace('_', ' ', $order->statut)) }}
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->items as $item)
                            <div class="item-row">
                                @php $photo = $item->annonce->photoPrincipale(); @endphp
                                <img src="{{ $photo ? Storage::url($photo->chemin) : 'https://via.placeholder.com/60' }}" class="item-img">
                                <div class="item-meta">
                                    <div class="item-name">{{ $item->annonce->titre }}</div>
                                    <div class="item-buyer">
                                        Acheteur : {{ $order->buyer->prenom }} {{ $order->buyer->nom }}
                                    </div>
                                </div>
                                <div style="text-align: right; font-weight: 700; color: #444;">
                                    x{{ $item->quantite }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-footer">
                        <div class="total-box">
                            <span class="total-label">Revenu</span>
                            <span class="total-value">{{ number_format($order->total_produits, 0, ',', ' ') }} DA</span>
                            <div class="commission-box">
                                Plateforme : {{ number_format($order->commission_plateforme, 0, ',', ' ') }} DA
                            </div>
                        </div>
                        <a href="{{ route('vendeur.orders.show', $order->id) }}" class="btn-detail">Détails</a>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 4rem; background: white; border: 1px solid #eee; border-radius: 12px; color: #888;">
                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p style="font-size: 1.1rem; font-weight: 600;">Aucune commande pour le moment</p>
                </div>
            @endforelse
        </div>

        <div style="margin-top: 2rem;">
            {{ $orders->links() }}
        </div>
    </main>
</div>
@endsection
