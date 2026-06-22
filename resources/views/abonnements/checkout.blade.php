@extends('layouts.app')

@section('title', 'Confirmation — ' . $abonnement->nom . ' — Karnou')

@push('styles')
<style>
    :root {
        --karnou-blue: #004aad;
        --karnou-orange: #f68b1e;
        --bg-gray: #f8f9fa;
    }

    body {
        background-color: var(--bg-gray) !important;
    }

    .checkout-sub-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px 60px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .checkout-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #efefef;
        overflow: hidden;
        display: flex;
        flex-wrap: wrap;
    }

    .checkout-summary {
        flex: 1;
        min-width: 320px;
        background: #fff;
        padding: 35px;
        border-right: 1px solid #f0f0f0;
    }

    .checkout-payment {
        flex: 1.2;
        min-width: 320px;
        padding: 35px;
        background: #fafafa;
    }

    .summary-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #999;
        margin-bottom: 24px;
        display: block;
        letter-spacing: 1px;
    }

    /* Plan Details Style */
    .plan-badge {
        display: inline-block;
        padding: 6px 12px;
        background: #eef2ff;
        color: var(--karnou-blue);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .plan-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: #111;
        margin-bottom: 8px;
    }

    .plan-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--karnou-orange);
        margin-bottom: 24px;
    }

    .plan-features {
        list-style: none;
        padding: 0;
        margin: 0 0 30px;
    }

    .plan-features li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        color: #444;
        margin-bottom: 12px;
    }

    .plan-features li i {
        color: #22c55e;
        font-size: 0.9rem;
    }

    /* Payment Options Style */
    .payment-option {
        margin-bottom: 12px;
    }

    .payment-option label {
        display: flex;
        align-items: center;
        padding: 16px;
        background: white;
        border: 2px solid #eee;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .payment-option input:checked + label {
        border-color: var(--karnou-blue);
        background: #f0f7ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,74,173,0.1);
    }

    .option-icon {
        width: 36px;
        height: 36px;
        margin-right: 15px;
        object-fit: contain;
    }

    .option-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #333;
    }

    /* Auto-renew Section */
    .autorenew-box {
        margin-top: 24px;
        padding: 16px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
    }

    .autorenew-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .autorenew-row input[type="checkbox"] {
        accent-color: var(--karnou-blue);
        width: 18px;
        height: 18px;
        margin-top: 2px;
        cursor: pointer;
    }

    .autorenew-row label {
        font-size: 0.85rem;
        color: #444;
        cursor: pointer;
        line-height: 1.4;
    }

    .autorenew-row label strong {
        display: block;
        color: #111;
        margin-bottom: 2px;
    }

    /* Total Section */
    .total-area {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px dashed #eee;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .total-label {
        font-weight: 700;
        font-size: 0.9rem;
        color: #666;
    }

    .total-val {
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--karnou-orange);
    }

    .btn-confirm {
        display: block;
        width: 100%;
        background: var(--karnou-blue) !important;
        color: white !important;
        padding: 18px;
        border: none;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 24px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-confirm:hover {
        background: #003685 !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,74,173,0.2);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #777;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 24px;
        transition: color 0.2s;
    }

    .back-link:hover { color: var(--karnou-blue); }

    .security-footer {
        margin-top: 24px;
        text-align: center;
    }

    .security-footer img { height: 22px; opacity: 0.7; margin-bottom: 10px; }
    .security-footer p { font-size: 0.75rem; color: #aaa; margin: 0; }

    @media (max-width: 768px) {
        .checkout-summary { border-right: none; border-bottom: 1px solid #f0f0f0; }
    }
</style>
@endpush

@section('content')
<div class="checkout-sub-container">
    <a href="{{ route('abonnements.index') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour aux forfaits
    </a>

    <div class="checkout-card">
        {{-- Left: Summary --}}
        <div class="checkout-summary">
            <span class="summary-title">Votre Forfait</span>

            <div class="plan-badge">Abonnement Mensuel</div>
            <h1 class="plan-name">{{ $abonnement->nom }}</h1>
            
            <div class="plan-price">
                @if($abonnement->prix_mensuel > 0)
                    {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA <span style="font-size: 0.8rem; font-weight: 400; color: #888;">/ mois</span>
                @else
                    Gratuit
                @endif
            </div>

            <ul class="plan-features">
                <li><i class="fas fa-check-circle"></i> 
                    <strong>{{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces' }}</strong> par mois
                </li>
                <li><i class="fas fa-check-circle"></i> Commission de <strong>{{ number_format($abonnement->commission, 0) }}%</strong> sur les ventes</li>
                @if($abonnement->page_pro)
                    <li><i class="fas fa-check-circle"></i> Page Boutique Professionnelle incluse</li>
                @endif
                <li><i class="fas fa-check-circle"></i> Support prioritaire inclus</li>
            </ul>

            <div style="font-size: 0.85rem; color: #666; line-height: 1.6; background: #fafafa; padding: 15px; border-radius: 8px; border-left: 4px solid var(--karnou-blue);">
                Boostez votre visibilité et multipliez vos ventes en devenant un vendeur certifié Karnou. 
                L'abonnement prend effet immédiatement après le paiement.
            </div>
        </div>

        {{-- Right: Payment --}}
        <div class="checkout-payment">
            <span class="summary-title">Mode de Paiement</span>

            <form action="{{ route('abonnements.subscribe') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="abonnement_id" value="{{ $abonnement->id }}">

                @if($abonnement->prix_mensuel > 0)
                    <div class="payment-option">
                        <input type="radio" name="payment_method" value="wave" id="opt-wave" checked style="display: none;">
                        <label for="opt-wave">
                            <img src="{{ asset('images/logowave.png') }}" class="option-icon" alt="Wave">
                            <span class="option-name">Wave Senegal</span>
                        </label>
                    </div>

                    <div class="payment-option">
                        <input type="radio" name="payment_method" value="om" id="opt-om" style="display: none;">
                        <label for="opt-om">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png" class="option-icon" alt="Orange Money">
                            <span class="option-name">Orange Money</span>
                        </label>
                    </div>

                    <div class="payment-option">
                        <input type="radio" name="payment_method" value="cb" id="opt-cb" style="display: none;">
                        <label for="opt-cb">
                            <div style="display: flex; gap: 6px; margin-right: 15px; font-size: 20px;">
                                <i class="fab fa-cc-visa" style="color: #1a1f71;"></i>
                                <i class="fab fa-cc-mastercard" style="color: #eb001b;"></i>
                            </div>
                            <span class="option-name">Carte Bancaire / Mastercard</span>
                        </label>
                    </div>
                @else
                    <input type="hidden" name="payment_method" value="free">
                    <div style="padding: 20px; background: #eef2ff; border-radius: 12px; color: var(--karnou-blue); font-weight: 700; text-align: center; margin-bottom: 20px;">
                        <i class="fas fa-gift"></i> Ce forfait est 100% Gratuit
                    </div>
                @endif

                {{-- Auto-renew Option --}}
                <div class="autorenew-box">
                    <div class="autorenew-row">
                        <input type="checkbox" name="auto_renew" value="1" id="auto_renew" checked>
                        <label for="auto_renew">
                            <strong>Renouvellement automatique</strong>
                            Gagnez du temps ! Votre forfait sera renouvelé automatiquement chaque mois.
                        </label>
                    </div>
                </div>

                <div class="total-area">
                    <div class="total-row">
                        <span class="total-label">Sous-total</span>
                        <span style="font-weight: 600;">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="total-row">
                        <span class="total-label">Frais de service</span>
                        <span style="font-weight: 600;">0 FCFA</span>
                    </div>
                    <div class="total-row" style="margin-top: 10px;">
                        <span class="total-label" style="color: #111; font-size: 1rem;">Total à payer</span>
                        <span class="total-val">
                            {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-confirm">
                    @if($abonnement->prix_mensuel > 0)
                        Payer et Activer →
                    @else
                        Activer Gratuitement →
                    @endif
                </button>
            </form>

            <div class="security-footer">
                <img src="https://paydunya.com/assets/images/logo_transparent.png" alt="PayDunya">
                <p>Paiement sécurisé et crypté via PayDunya</p>
                <p style="margin-top: 4px; opacity: 0.5;">Frais de transaction inclus dans le prix</p>
            </div>
        </div>
    </div>
</div>
@endsection
