@extends('layouts.app')

@section('title', 'Mon Panier - Dwesta')

@push('styles')
<style>
    :root {
        --jumia-orange: #f68b1e;
        --jumia-orange-hover: #e07b1a;
        --jumia-gray-bg: #f5f5f5;
        --jumia-border: #ededed;
        --jumia-text: #313133;
        --jumia-text-muted: #75757a;
        --jumia-green: #4caf50;
        --jumia-gray-light: #9e9e9e;
    }

    body {
        background-color: var(--jumia-gray-bg);
        font-family: 'Roboto', 'Inter', sans-serif;
        color: var(--jumia-text);
    }

    .container-cart {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 15px;
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 16px;
    }

    /* Main Cart Content */
    .cart-main {
        background: white;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .cart-header {
        padding: 12px 16px;
        border-bottom: 1px solid var(--jumia-border);
        font-size: 20px;
        font-weight: 700;
    }

    .cart-item {
        padding: 16px;
        border-bottom: 1px solid var(--jumia-border);
        display: grid;
        grid-template-columns: 100px 1fr 180px;
        gap: 16px;
    }

    .item-image {
        width: 100px;
        height: 100px;
        border-radius: 4px;
        overflow: hidden;
        background: white;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .item-details {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .item-title {
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 4px;
        color: var(--jumia-text);
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .item-stock {
        font-size: 12px;
        color: #f68b1e;
        margin-bottom: 4px;
    }

    .express-badge {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 900;
        font-style: italic;
        color: #313133;
        text-transform: uppercase;
    }

    .express-badge span {
        color: var(--jumia-orange);
    }

    .item-vendor {
        font-size: 12px;
        color: var(--jumia-text-muted);
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .item-vendor i {
        font-size: 10px;
    }

    .item-vendor .vendor-name {
        color: #007185; /* Professional link-like color for shop names */
        font-weight: 500;
    }

    .item-actions {
        margin-top: 16px;
    }

    .btn-remove {
        background: none;
        border: none;
        color: var(--jumia-orange);
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 0;
        text-transform: uppercase;
    }

    .btn-remove:hover {
        color: var(--jumia-orange-hover);
    }

    .item-pricing {
        text-align: right;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .current-price {
        font-size: 20px;
        font-weight: 700;
    }

    .old-price {
        font-size: 14px;
        color: var(--jumia-gray-light);
        text-decoration: line-through;
        margin-right: 8px;
    }

    .discount-percent {
        font-size: 12px;
        color: #ff9800;
        background: #fff3e0;
        padding: 2px 4px;
        border-radius: 2px;
    }

    /* Qty Control */
    .qty-box {
        margin-top: auto;
    }

    .qty-form {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        gap: 8px;
    }

    .btn-qty {
        width: 32px;
        height: 32px;
        background: var(--jumia-orange);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 700;
        box-shadow: 0 2px 4px rgba(246, 139, 30, 0.2);
    }
    
    .btn-qty:disabled {
        background: #ccc;
        box-shadow: none;
        cursor: not-allowed;
    }

    .btn-qty.minus {
        background: #9e9e9e;
    }
    .btn-qty.minus:hover:not(:disabled) { background: #757575; }
    .btn-qty.plus:hover:not(:disabled) { background: var(--jumia-orange-hover); }

    .qty-num {
        font-size: 16px;
        font-weight: 700;
        width: 20px;
        text-align: center;
    }

    /* Sidebar */
    .cart-sidebar {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sidebar-card {
        background: white;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        padding: 12px 16px;
    }

    .sidebar-header {
        font-size: 13px;
        font-weight: 700;
        color: var(--jumia-text-muted);
        text-transform: uppercase;
        margin-bottom: 12px;
        border-bottom: 1px solid var(--jumia-border);
        padding-bottom: 8px;
    }

    .sidebar-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 16px;
        font-weight: 400;
    }

    .sidebar-row.total {
        font-weight: 700;
        font-size: 18px;
    }

    .shipping-info {
        font-size: 12px;
        color: var(--jumia-text);
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--jumia-border);
    }

    .express-text {
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-style: italic;
    }

    .express-text span {
        color: var(--jumia-orange);
    }

    .btn-order {
        width: 100%;
        background: var(--jumia-orange);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 14px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        text-transform: uppercase;
        margin-top: 12px;
        box-shadow: 0 4px 8px rgba(246, 139, 30, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-order:hover {
        background: var(--jumia-orange-hover);
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(246, 139, 30, 0.4);
    }

    .empty-cart {
        background: white;
        padding: 40px;
        text-align: center;
        border-radius: 4px;
    }

    @media (max-width: 900px) {
        .container-cart {
            grid-template-columns: 1fr;
        }
        .cart-item {
            grid-template-columns: 80px 1fr;
        }
        .item-pricing {
            grid-column: 2;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-cart">
    @php 
        $flattenedItems = $cartGrouped->flatten();
        $totalItems = $flattenedItems->sum('quantite');
    @endphp

    @if($flattenedItems->count() > 0)
        <!-- Main Content -->
        <div>
            <div class="cart-main">
                <div class="cart-header">
                    Panier ({{ $totalItems }})
                </div>

                @foreach($flattenedItems as $item)
                    @php 
                        $annonce = $item->annonce;
                        $prixU = $annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0);
                        $hasPromo = $annonce->prix_original > $annonce->prix;
                        $discount = $annonce->discount_percentage;
                        $photo = $annonce->photoPrincipale();
                    @endphp
                    <div class="cart-item">
                        <div class="item-image">
                            @if($photo)
                                <img src="{{ Storage::url($photo->chemin) }}" alt="{{ $annonce->titre }}">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: white;">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <div class="item-details">
                            <a href="{{ route('annonces.show', $annonce->slug) }}" class="item-title">
                                {{ $annonce->titre }}
                            </a>
                            <div class="item-stock">
                                {{ $annonce->disponibilite === 'en_stock' ? 'En stock' : ($annonce->disponibilite === 'sur_commande' ? 'Disponible sur commande' : 'Quelques articles restants') }}
                            </div>
                            <div class="item-vendor">
                                <i class="fas fa-store"></i> Boutique : <span class="vendor-name">{{ $annonce->vendeur->identite }}</span>
                            </div>

                            <div class="item-actions">
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="item-pricing">
                            <div class="current-price">
                                {{ number_format($prixU, 0, ',', ' ') }} FCFA
                            </div>
                            @if($hasPromo)
                                <div>
                                    <span class="old-price">{{ number_format($annonce->prix_original, 0, ',', ' ') }} FCFA</span>
                                    <span class="discount-percent">-{{ $discount }}%</span>
                                </div>
                            @endif

                            <div class="qty-box">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="qty-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantite" value="{{ $item->quantite }}" class="qty-input-hidden">
                                    <button type="button" onclick="updateQty(this, -1)" class="btn-qty minus" {{ $item->quantite <= 1 ? 'disabled' : '' }}>
                                        -
                                    </button>
                                    <span class="qty-num">{{ $item->quantite }}</span>
                                    <button type="button" onclick="updateQty(this, 1)" class="btn-qty plus">
                                        +
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div class="cart-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-header">Résumé du panier</div>
                
                <div class="sidebar-row">
                    <span>Sous-total</span>
                    <span style="font-weight: 700;">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                </div>

                <div class="shipping-info">
                    Vos articles sont éligibles à la livraison <span class="express-text">KARNOU <span>EXPRESS</span></span>. Recevez votre commande en un temps record !
                </div>

                <a href="{{ route('checkout.step1') }}" style="text-decoration: none;">
                    <button class="btn-order">
                        Commander ({{ number_format($subtotal, 0, ',', ' ') }} FCFA)
                    </button>
                </a>
            </div>
            

        </div>
    @else
        <div class="empty-cart" style="grid-column: 1 / -1;">
            <i class="fas fa-shopping-cart fa-4x" style="color: #eee; margin-bottom: 20px;"></i>
            <h3>Votre panier est vide</h3>
            <p style="color: var(--jumia-text-muted); margin-bottom: 24px;">Il semble que vous n'ayez pas encore ajouté d'articles à votre panier.</p>
            <a href="{{ route('home') }}" class="btn-order" style="display: inline-block; width: auto; min-width: 200px; text-decoration: none;">
                Commencer mes achats
            </a>
        </div>
    @endif
</div>

<script>
    function updateQty(btn, delta) {
        const form = btn.closest('form');
        const input = form.querySelector('.qty-input-hidden');
        
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;

        input.value = val;
        
        btn.disabled = true;
        form.style.opacity = '0.5';
        form.submit();
    }
</script>
@endsection
