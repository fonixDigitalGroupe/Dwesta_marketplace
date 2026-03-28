@extends('layouts.app')

@section('title', 'Votre Panier - Mady Market')

@push('styles')
<style>
    .cart-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; display: grid; grid-template-columns: 1fr 350px; gap: 2rem; }
    
    .cart-main { background: transparent; }
    .seller-group { background: white; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 2rem; overflow: hidden; }
    .seller-header { padding: 1rem 1.5rem; background: #f9f9f9; border-bottom: 1px solid #e0e0e0; display: flex; align-items: center; gap: 1rem; }
    .seller-name { font-weight: bold; color: #333; }
    .seller-badge { background: #eee; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem; color: #666; }

    .cart-item { padding: 1.5rem; border-bottom: 1px solid #f0f0f0; display: grid; grid-template-columns: 100px 1fr 150px 120px; gap: 1.5rem; align-items: center; }
    .cart-item:last-child { border-bottom: none; }
    .item-image { width: 100px; height: 100px; background: #f5f5f5; border-radius: 4px; overflow: hidden; }
    .item-image img { width: 100%; height: 100%; object-fit: cover; }
    
    .item-info { display: flex; flex-direction: column; gap: 0.5rem; }
    .item-title { font-weight: 500; color: #333; text-decoration: none; font-size: 1.1rem; }
    .item-title:hover { color: #bf0000; }
    .item-variant { font-size: 0.85rem; color: #777; }

    .item-qty { display: flex; align-items: center; gap: 0.5rem; }
    .qty-input { width: 50px; padding: 0.4rem; border: 1px solid #ddd; border-radius: 4px; text-align: center; }
    
    .item-price { text-align: right; font-weight: bold; font-size: 1.1rem; color: #333; }
    .btn-remove { color: #999; border: none; background: none; cursor: pointer; font-size: 0.85rem; padding: 0; margin-top: 0.5rem; text-decoration: underline; }
    .btn-remove:hover { color: #bf0000; }

    .cart-sidebar { position: sticky; top: 2rem; }
    .summary-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem; }
    .summary-title { font-size: 1.25rem; font-weight: bold; margin-bottom: 1.5rem; border-bottom: 1px solid #f0f0f0; padding-bottom: 1rem; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 1rem; color: #666; }
    .summary-total { display: flex; justify-content: space-between; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f0f0f0; font-weight: bold; font-size: 1.3rem; color: #333; }
    
    .btn-checkout { display: block; width: 100%; background: #ff8c00; color: white; text-align: center; padding: 0.8rem 1rem; border-radius: 4px; font-weight: 700; font-size: 0.9rem; text-decoration: none; margin-top: 1.5rem; transition: opacity 0.2s; }
    .btn-checkout:hover { opacity: 0.9; }

    .empty-cart { text-align: center; padding: 5rem 2rem; background: white; border: 1px solid #e0e0e0; border-radius: 8px; grid-column: 1 / -1; }
</style>
@endpush

@section('content')
<div class="cart-container">
    <div class="cart-main">
        <h1 style="margin-bottom: 2rem; font-size: 1.75rem;">Mon Panier</h1>

        @if(session('success'))
            <div style="background: #e6fffa; color: #2c7a7b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #b2f5ea;">
                {{ session('success') }}
            </div>
        @endif

        @forelse($cartGrouped as $vendeurId => $items)
            @php $vendeur = $items->first()->annonce->vendeur; @endphp
            <div class="seller-group">
                <div class="seller-header">
                    <span class="seller-name">Vendeur : 
                        @if($vendeur && $vendeur->professionnel)
                            {{ $vendeur->professionnel->nom_entreprise }}
                        @elseif($vendeur && $vendeur->user)
                            {{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}
                        @else
                            Vendeur inconnu
                        @endif
                    </span>
                    @if($vendeur && $vendeur->estVerifie())
                        <span class="seller-badge">Vérifié ✅</span>
                    @endif
                </div>

                @foreach($items as $item)
                    <div class="cart-item">
                        <div class="item-image">
                            @if($item->annonce->photoPrincipale())
                                <img src="{{ Storage::url($item->annonce->photoPrincipale()->chemin) }}" alt="{{ $item->annonce->titre }}">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #ccc;">📷</div>
                            @endif
                        </div>
                        
                        <div class="item-info">
                            <a href="{{ route('annonces.show', $item->annonce->slug) }}" class="item-title">{{ $item->annonce->titre }}</a>
                            @if($item->variante)
                                <span class="item-variant">{{ $item->variante->type }} : {{ $item->variante->valeur }}</span>
                            @endif
                        </div>

                        <div class="item-qty">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; align-items: center; gap: 0.5rem;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantite" value="{{ $item->quantite }}" min="1" class="qty-input" onchange="this.form.submit()">
                            </form>
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">Supprimer</button>
                            </form>
                        </div>

                        <div class="item-price">
                            @php 
                                $prixU = $item->annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0);
                            @endphp
                            {{ number_format($prixU * $item->quantite, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="empty-cart">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                <h2>Votre panier est vide</h2>
                <p style="color: #666; margin-bottom: 2rem;">Il est temps de dénicher les meilleures offres sur Mady Market !</p>
                <a href="{{ route('home') }}" class="btn-checkout" style="display: inline-block; width: auto; padding: 1rem 3rem;">Retour à l'accueil</a>
            </div>
        @endforelse
    </div>

    @if($cartGrouped->isNotEmpty())
    <aside class="cart-sidebar">
        <div class="summary-card">
            <h2 class="summary-title">Récapitulatif</h2>
            
            <div class="summary-row">
                <span>Articles ({{ $cartGrouped->flatten()->sum('quantite') }})</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>
            
            <div class="summary-row">
                <span>Frais de port</span>
                <span style="color: #28a745;">Calculés à l'étape suivante</span>
            </div>

            <div class="summary-total">
                <span>Total</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>

            <a href="{{ route('checkout.step1') }}" class="btn-checkout">Finaliser ma commande</a>
            
            <p style="font-size: 0.8rem; color: #999; margin-top: 1rem; text-align: center;">
                <i class="fas fa-lock"></i> Paiement 100% sécurisé
            </p>
            
            <form action="{{ route('cart.clear') }}" method="POST" style="margin-top: 1.5rem; text-align: center;">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: none; border: none; color: #999; font-size: 0.85rem; cursor: pointer; text-decoration: underline;">Vider mon panier</button>
            </form>
        </div>

    </aside>
    @endif
</div>
@endsection
