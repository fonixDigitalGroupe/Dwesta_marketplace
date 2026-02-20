@extends('layouts.app')

@section('title', 'Mes Ventes - Mady Market')

@push('styles')
<style>
    .sales-list {
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }
    .sale-card {
        padding: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    .sale-card:last-child {
        border-bottom: none;
    }
    .sale-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-paye { background: #e8f5e9; color: #2e7d32; }
    .status-en_attente { background: #fff3e0; color: #ef6c00; }
    .status-livre { background: #e3f2fd; color: #1976d2; }
    
    .item-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
        align-items: center;
    }
    .item-img {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        background: #f5f5f5;
        object-fit: cover;
    }
    .buyer-info {
        font-size: 0.85rem;
        color: #666;
        background: #f9f9f9;
        padding: 0.75rem;
        border-radius: 6px;
        margin-top: 1rem;
    }
</style>
@endpush

@section('content')
<div class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('vendeur.show') }}">Mon Compte Vendeur</a> > <span>Mes ventes</span>
</div>

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem;">Mes ventes (Commandes reçues)</h1>

        @if($orders->isEmpty())
            <div style="background: white; padding: 4rem; text-align: center; border-radius: 8px; border: 1px solid #eee;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                <h3 style="margin-bottom: 0.5rem;">Vous n'avez pas encore reçu de commandes.</h3>
                <p style="color: #666;">Dès qu'un client achète l'un de vos produits, la commande apparaîtra ici.</p>
            </div>
        @else
            <div class="sales-list">
                @foreach($orders as $order)
                    <div class="sale-card">
                        <div class="sale-header">
                            <div>
                                <div style="font-weight: 800; font-size: 1.1rem;">COMMANDE #{{ $order->reference }}</div>
                                <div style="font-size: 0.85rem; color: #888;">Reçue le {{ $order->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                            <span class="status-badge status-{{ $order->statut }}">
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
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.95rem;">{{ $item->annonce ? $item->annonce->titre : 'Produit retiré' }}</div>
                                        <div style="font-size: 0.85rem; color: #666;">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA x {{ $item->quantite }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="buyer-info">
                            <strong>Client :</strong> {{ $order->buyer->prenom }} {{ $order->buyer->nom }}<br>
                            <strong>Livraison :</strong> {{ str_replace('_', ' ', $order->mode_livraison) }}<br>
                            <strong>Adresse :</strong> {{ $order->adresse_livraison }}
                        </div>

                        <div style="margin-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-size: 1.1rem; font-weight: 800; color: #2e7d32;">
                                Revenu : {{ number_format($order->total_produits, 0, ',', ' ') }} FCFA
                            </div>
                            @if($order->statut === 'paye')
                                <button style="background: #222; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; font-weight: bold; cursor: pointer;">
                                    Prêt pour expédition
                                </button>
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
