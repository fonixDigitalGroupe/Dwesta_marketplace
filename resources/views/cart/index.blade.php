@extends('layouts.app')

@section('title', 'Votre Panier - Dwesta')

@push('styles')
<style>
    :root {
        --rk-primary: #ff8c00;
        --rk-secondary: #004aad;
        --rk-bg: #f8f9fa;
        --rk-border: #eef0f2;
        --rk-text-muted: #757575;
    }

    body { background-color: var(--rk-bg); }

    .cart-wrapper {
        max-width: 1300px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        align-items: start;
    }

    /* main content */
    .cart-main-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .cart-section-title {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #1a1a1a;
    }

    .vendor-card {
        background: #fff;
        border: 1px solid var(--rk-border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .vendor-banner {
        padding: 1rem 1.5rem;
        background: #fff;
        border-bottom: 1px solid var(--rk-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .vendor-info-box {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .vendor-avatar-mini {
        width: 32px;
        height: 32px;
        background: #f0f0f0;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--rk-secondary);
        font-size: 1rem;
    }

    .vendor-name-link {
        font-weight: 700;
        color: #333;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .badge-pro {
        background: #e1f5fe;
        color: #039be5;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 4px;
        text-transform: uppercase;
    }

    .badge-verified {
        color: #4caf50;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* cart items */
    .item-row {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 1.5rem;
        border-bottom: 1px solid var(--rk-border);
        transition: background 0.2s;
    }

    .item-row:last-child { border-bottom: none; }
    .item-row:hover { background: #fafafa; }

    .item-image-box {
        width: 120px;
        height: 120px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }

    .item-image-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 4px;
    }

    .item-details {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .item-title-link {
        font-size: 1.05rem;
        font-weight: 600;
        color: #333;
        text-decoration: none;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .item-title-link:hover { color: var(--rk-secondary); }

    .item-meta {
        font-size: 0.85rem;
        color: var(--rk-text-muted);
        display: flex;
        gap: 15px;
    }

    .item-actions {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .action-link {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--rk-secondary);
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
    }

    .action-link:hover { text-decoration: underline; }
    .action-link.remove { color: #d32f2f; }

    .item-pricing-zone {
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 140px;
    }

    .item-price-unit {
        font-size: 1.25rem;
        font-weight: 900;
        color: #1a1a1a;
    }

    .item-qty-selector {
        display: flex;
        align-items: center;
        background: #f1f3f5;
        border-radius: 20px;
        padding: 2px;
        width: fit-content;
        margin-left: auto;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: #fff;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: transform 0.1s;
    }

    .qty-btn:active { transform: scale(0.9); }
    .qty-val { width: 35px; text-align: center; font-weight: 700; font-size: 0.9rem; }

    /* sidebar */
    .cart-summary-sidebar {
        position: sticky;
        top: 2rem;
    }

    .summary-card-modern {
        background: #fff;
        border: 1px solid var(--rk-border);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .summary-title {
        font-weight: 800;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--rk-border);
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-size: 0.95rem;
        color: #444;
    }

    .summary-line.total {
        margin-top: 1.5rem;
        padding-top: 1.25rem;
        border-top: 2px solid #f8f9fa;
        font-weight: 900;
        font-size: 1.4rem;
        color: #000;
    }

    .btn-checkout-primary {
        display: block;
        width: 100%;
        background: var(--rk-primary);
        color: #fff;
        text-align: center;
        padding: 1rem;
        border-radius: 8px;
        font-weight: 800;
        font-size: 1rem;
        text-decoration: none;
        margin-top: 1.5rem;
        box-shadow: 0 4px 10px rgba(255, 140, 0, 0.3);
        transition: all 0.2s;
    }

    .btn-checkout-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255, 140, 0, 0.4);
        background: #fb8c00;
    }

    .trust-badges {
        margin-top: 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .trust-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-align: center;
        font-size: 0.75rem;
        color: #888;
    }

    .trust-item i { font-size: 1.2rem; color: #444; }

    /* Empty state */
    .empty-cart-hero {
        background: #fff;
        border-radius: 12px;
        padding: 5rem 2rem;
        text-align: center;
        grid-column: 1 / -1;
        border: 1px dashed #ced4da;
    }

    @media (max-width: 991px) {
        .cart-grid { grid-template-columns: 1fr; }
        .cart-summary-sidebar { position: static; }
    }
</style>
@endpush

@section('content')
<div class="cart-wrapper">
    <div class="cart-grid">
        @if(count($cartGrouped) > 0)
            <div class="cart-main-container">
                <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 0.5rem;">
                    <h1 class="cart-section-title">Mon Panier</h1>
                    @php $itemCount = $cartGrouped->flatten()->sum('quantite'); @endphp
                    <span style="color: var(--rk-text-muted); font-weight: 500;">({{ $itemCount }} {{ Str::plural('article', $itemCount) }})</span>
                </div>

                @foreach($cartGrouped as $vendeurId => $items)
                    @php $vendeur = $items->first()->annonce->vendeur; @endphp
                    <div class="vendor-card">
                        <div class="vendor-banner">
                            <div class="vendor-info-box">
                                <div class="vendor-avatar-mini"><i class="fas fa-store"></i></div>
                                <div>
                                    @if($vendeur && $vendeur->professionnel)
                                        <a href="#" class="vendor-name-link">{{ $vendeur->professionnel->nom_entreprise }}</a>
                                        <span class="badge-pro">PRO</span>
                                    @elseif($vendeur && $vendeur->user)
                                        <a href="#" class="vendor-name-link">{{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}</a>
                                    @else
                                        <span class="vendor-name-link">Vendeur particulier</span>
                                    @endif
                                </div>
                            </div>
                            @if($vendeur && $vendeur->estVerifie())
                                <div class="badge-verified">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Vendeur vérifié</span>
                                </div>
                            @endif
                        </div>

                        <div class="vendor-items">
                            @foreach($items as $item)
                                <div class="item-row">
                                    <div class="item-image-box">
                                        @php $photo = $item->annonce->photoPrincipale(); @endphp
                                        @if($photo)
                                            <img src="{{ Storage::url($photo->chemin) }}" alt="{{ $item->annonce->titre }}">
                                        @else
                                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #ccc; background: #fafafa;">
                                                <i class="fas fa-image" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="item-details">
                                        <div>
                                            <a href="{{ route('annonces.show', $item->annonce->slug) }}" class="item-title-link">
                                                {{ $item->annonce->titre }}
                                            </a>
                                            <div class="item-meta">
                                                <span><i class="fas fa-tag"></i> {{ $item->annonce->category->nom }}</span>
                                                @if($item->variante)
                                                    <span><strong>{{ $item->variante->type }}:</strong> {{ $item->variante->valeur }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="item-actions">
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" id="remove-form-{{ $item->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-link remove">
                                                    <i class="far fa-trash-alt"></i> Supprimer
                                                </button>
                                            </form>
                                            <a class="action-link"><i class="far fa-heart"></i> Mettre de côté</a>
                                        </div>
                                    </div>

                                    <div class="item-pricing-zone">
                                        <div class="item-price-unit">
                                            @php 
                                                $prixU = $item->annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0);
                                            @endphp
                                            {{ number_format($prixU * $item->quantite, 0, ',', ' ') }} DA
                                        </div>
                                        
                                        <div class="item-qty-selector">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; align-items: center;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="qty-btn" onclick="updateQty(this, -1)">-</button>
                                                <input type="text" name="quantite" value="{{ $item->quantite }}" class="qty-val" readonly>
                                                <button type="button" class="qty-btn" onclick="updateQty(this, 1)">+</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary-sidebar">
                <div class="summary-card-modern">
                    <div class="summary-title">Récapitulatif</div>
                    
                    <div class="summary-line">
                        <span>Sous-total ({{ $itemCount }} articles)</span>
                        <span>{{ number_format($subtotal, 0, ',', ' ') }} DA</span>
                    </div>
                    
                    <div class="summary-line">
                        <span>Frais de livraison</span>
                        <span style="color: #4caf50; font-weight: 600;">Calculés à l'étape suivante</span>
                    </div>

                    <div class="summary-line total">
                        <span>Total (TTC)</span>
                        <span>{{ number_format($subtotal, 0, ',', ' ') }} DA</span>
                    </div>

                    <a href="{{ route('checkout.step1') }}" class="btn-checkout-primary">
                        COMMANDER LE PANIER
                    </a>

                    <div style="margin-top: 1.5rem; font-size: 0.8rem; color: #666; text-align: center;">
                        <i class="fas fa-lock" style="margin-right: 5px;"></i> Transactions sécurisées et cryptées
                    </div>
                </div>

                <div class="trust-badges">
                    <div class="trust-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Paiement sécurisé</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-undo"></i>
                        <span>Retours facilités</span>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart-hero">
                <div style="font-size: 4rem; color: #dee2e6; margin-bottom: 1.5rem;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2 style="font-weight: 800; margin-bottom: 1rem;">Votre panier est vide</h2>
                <p style="color: #6c757d; margin-bottom: 2rem;">Il semble que vous n'ayez pas encore ajouté d'articles à votre panier.</p>
                <a href="{{ route('home') }}" class="btn-checkout-primary" style="display: inline-block; width: auto; padding-left: 3rem; padding-right: 3rem;">
                    Continuer mes achats
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    function updateQty(btn, delta) {
        const form = btn.closest('form');
        const input = form.querySelector('.qty-val');
        let newVal = parseInt(input.value) + delta;
        if (newVal < 1) newVal = 1;
        input.value = newVal;
        form.submit();
    }
</script>
@endsection
