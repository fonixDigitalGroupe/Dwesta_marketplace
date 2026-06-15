@extends('layouts.app')

@section('title', 'Finaliser l\'achat de votre carte cadeau - Karnou')

@push('styles')
<style>
    :root {
        --karnou-blue: #004aad;
        --karnou-orange: #f68b1e;
        --bg-gray: #f8f9fa;
    }

    body {
        background-color: var(--bg-gray);
    }

    .checkout-gift-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .checkout-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        display: flex;
        flex-wrap: wrap;
    }

    .checkout-summary {
        flex: 1;
        min-width: 300px;
        background: #fff;
        padding: 30px;
        border-right: 1px solid #f0f0f0;
    }

    .checkout-payment {
        flex: 1.2;
        min-width: 300px;
        padding: 30px;
        background: #fafafa;
    }

    .summary-title {
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #777;
        margin-bottom: 20px;
        display: block;
    }

    .gift-preview {
        background: linear-gradient(135deg, #004aad 0%, #003070 100%);
        aspect-ratio: 1.58 / 1;
        border-radius: 12px;
        padding: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 10px 20px rgba(0,74,173,0.15);
    }

    .gift-preview::after {
        content: '';
        position: absolute;
        top: -20%;
        right: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .gift-preview .logo {
        height: 25px;
        margin-bottom: 30px;
    }

    .gift-preview .value {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .gift-preview .label {
        font-size: 0.7rem;
        text-transform: uppercase;
        opacity: 0.7;
        letter-spacing: 1px;
    }

    .payment-option {
        margin-bottom: 12px;
    }

    .payment-option label {
        display: flex;
        align-items: center;
        padding: 16px;
        background: white;
        border: 2px solid #eee;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .payment-option input:checked + label {
        border-color: var(--karnou-blue);
        background: #f0f7ff;
    }

    .option-icon {
        width: 32px;
        height: 32px;
        margin-right: 12px;
        object-fit: contain;
    }

    .option-name {
        font-weight: 600;
        font-size: 0.95rem;
    }

    .btn-confirm {
        display: block;
        width: 100%;
        background: var(--karnou-orange);
        color: white;
        padding: 16px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-top: 24px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-confirm:hover {
        background: #e67e00;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px dashed #eee;
    }

    .total-label {
        font-weight: 700;
        font-size: 0.9rem;
    }

    .total-amount {
        font-weight: 800;
        font-size: 1.2rem;
        color: var(--karnou-blue);
    }

    .gift-preview .medal-badge {
        position: absolute;
        bottom: 20px;
        right: 20px;
        font-size: 2.5rem;
        opacity: 0.15;
    }

    .gift-preview .gift-icon-main {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 1.5rem;
        opacity: 0.6;
    }

    /* Simplified Header Override */
    .top-banner,
    .mobile-menu-btn,
    .search-container,
    .header-actions,
    .mobile-search-row,
    .header-row-2 {
        display: none !important;
    }

    .header-row-1 .header-container {
        justify-content: center !important;
    }

    .header-logo-text img {
        height: 26px !important;
    }
</style>
@endpush

@section('content')
<div class="checkout-gift-container">
    <div style="margin-bottom: 24px;">
        <a href="{{ route('gift-cards.index') }}" style="text-decoration: none; color: #777; font-size: 0.85rem;">
            <i class="fas fa-arrow-left"></i> Retour aux choix
        </a>
    </div>

    <div class="checkout-card">
        <div class="checkout-summary">
            <span class="summary-title">Récapitulatif</span>
            
            <div class="gift-preview">
                <img src="{{ asset('images/logo.png') }}" class="logo" style="filter: brightness(0) invert(1);" alt="Karnou">
                <i class="fas fa-gift gift-icon-main"></i>
                <div class="value">{{ number_format($amount, 0, ',', ' ') }} <small style="font-size: 1rem;">FCFA</small></div>
                <div class="label">Carte Cadeau Dwesta</div>
                <i class="fas fa-medal medal-badge"></i>
            </div>

            <div style="font-size: 0.85rem; color: #555; line-height: 1.6;">
                Cette carte cadeau est valable 1 an sur toute la marketplace Karnou. 
                Elle permettra de créditer un compte du montant indiqué instantanément.
            </div>

            <div class="total-row">
                <span class="total-label">À PAYER</span>
                <span class="total-amount">{{ number_format($amount, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <div class="checkout-payment">
            <span class="summary-title">Mode de Paiement</span>

            <form action="{{ route('gift-cards.confirm') }}" method="POST">
                @csrf
                <div class="payment-option">
                    <input type="radio" name="moyen_paiement" value="wave" id="opt-wave" checked style="display: none;">
                    <label for="opt-wave">
                        <img src="{{ asset('images/logowave.png') }}" class="option-icon" alt="Wave">
                        <span class="option-name">Wave Senegal</span>
                    </label>
                </div>

                <div class="payment-option">
                    <input type="radio" name="moyen_paiement" value="om" id="opt-om" style="display: none;">
                    <label for="opt-om">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png" class="option-icon" alt="OM">
                        <span class="option-name">Orange Money</span>
                    </label>
                </div>

                <div class="payment-option">
                    <input type="radio" name="moyen_paiement" value="free" id="opt-free" style="display: none;">
                    <label for="opt-free">
                        <img src="https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png" class="option-icon" alt="Free">
                        <span class="option-name">Free Money</span>
                    </label>
                </div>

                <div class="payment-option">
                    <input type="radio" name="moyen_paiement" value="cb" id="opt-cb" style="display: none;">
                    <label for="opt-cb">
                        <div style="display: flex; gap: 4px; margin-right: 12px;">
                            <i class="fab fa-cc-visa" style="color: #1a1f71; font-size: 18px;"></i>
                            <i class="fab fa-cc-mastercard" style="color: #eb001b; font-size: 18px;"></i>
                        </div>
                        <span class="option-name">Carte Bancaire</span>
                    </label>
                </div>

                <button type="submit" class="btn-confirm">
                    Confirmer et Payer
                </button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <img src="https://paydunya.com/assets/images/logo_transparent.png" alt="PayDunya" style="height: 20px; opacity: 0.6;">
                <p style="font-size: 0.7rem; color: #aaa; margin-top: 10px;">Paiement sécurisé par PayDunya</p>
            </div>
        </div>
    </div>
</div>
@endsection
