@extends('layouts.app')

@section('title', 'Finaliser votre abonnement - Karnou')

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

    .checkout-sub-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px 60px;
    }

    .checkout-card {
        background: white;
        border-radius: 12px;
        box-shadow: none;
        border: 1px solid #efefef;
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

    .plan-preview {
        background: linear-gradient(135deg, #004aad 0%, #002d6a 100%);
        border-radius: 12px;
        padding: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .plan-preview .plan-name {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .plan-preview .plan-price {
        font-size: 1.5rem;
        font-weight: 800;
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
        background: #004aad !important;
        color: white !important;
        padding: 16px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-top: 24px;
        cursor: pointer;
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
        color: var(--karnou-orange);
    }

    /* Simplified Header Override */
    .top-banner, .mobile-menu-btn, .search-container, .header-actions, .mobile-search-row, .header-row-2 {
        display: none !important;
    }
    .header-row-1 .header-container { justify-content: center !important; }
    .header-logo-text img { height: 26px !important; }
    footer, .rk-footer { display: none !important; }
</style>
@endpush

@section('content')
<div class="checkout-sub-container">
    <div style="margin-bottom: 24px;">
        <a href="{{ route('abonnements.index') }}" style="text-decoration: none; color: #777; font-size: 0.85rem;">
            <i class="fas fa-arrow-left"></i> Retour aux choix
        </a>
    </div>

    <div class="checkout-card">
        <div class="checkout-summary">
            <span class="summary-title">Votre Abonnement</span>
            
            <div class="plan-preview">
                <div class="plan-name">{{ $abonnement->nom }}</div>
                <div class="plan-price">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA</div>
                <div style="font-size: 0.7rem; opacity: 0.8; margin-top: 10px;">{{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces' }} / mois</div>
            </div>

            <div style="font-size: 0.85rem; color: #555; line-height: 1.6;">
                En souscrivant à cet abonnement, vous bénéficiez de tous les avantages du forfait <strong>{{ $abonnement->nom }}</strong> pour une durée d'un mois.
            </div>

            <div style="margin-top: 24px; padding: 15px; background: #fff8f0; border-radius: 8px; border: 1px dashed #f68b1e;">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="auto_renew" value="1" id="auto_renew" checked style="cursor: pointer;">
                    <label class="form-check-label" for="auto_renew" style="font-size: 0.85rem; font-weight: 600; color: #111; cursor: pointer;">
                        Renouvellement automatique
                    </label>
                </div>
                <p style="font-size: 0.75rem; color: #666; margin-top: 5px; margin-bottom: 0;">Votre forfait sera renouvelé chaque mois automatiquement.</p>
            </div>
        </div>

        <div class="checkout-payment">
            <span class="summary-title">Mode de Paiement</span>

            <form action="{{ route('abonnements.subscribe') }}" method="POST" id="sub-form">
                @csrf
                <input type="hidden" name="abonnement_id" value="{{ $abonnement->id }}">
                <input type="hidden" name="auto_renew" id="auto_renew_hidden" value="1">

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
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png" class="option-icon" alt="OM">
                            <span class="option-name">Orange Money</span>
                        </label>
                    </div>

                    <div class="payment-option">
                        <input type="radio" name="payment_method" value="free" id="opt-free" style="display: none;">
                        <label for="opt-free">
                            <img src="https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png" class="option-icon" alt="Free">
                            <span class="option-name">Free Money</span>
                        </label>
                    </div>

                    <div class="payment-option">
                        <input type="radio" name="payment_method" value="cb" id="opt-cb" style="display: none;">
                        <label for="opt-cb">
                            <div style="display: flex; gap: 4px; margin-right: 12px;">
                                <i class="fab fa-cc-visa" style="color: #1a1f71; font-size: 18px;"></i>
                                <i class="fab fa-cc-mastercard" style="color: #eb001b; font-size: 18px;"></i>
                            </div>
                            <span class="option-name">Carte Bancaire</span>
                        </label>
                    </div>
                @else
                    <input type="hidden" name="payment_method" value="cb">
                    <div style="padding: 20px; background: #eef2ff; border-radius: 12px; color: var(--karnou-blue); font-weight: 700; text-align: center;">
                        Forfait Gratuit
                    </div>
                @endif

                <div class="total-row">
                    <span class="total-label">Total à payer</span>
                    <span class="total-amount">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA</span>
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

<script>
    document.getElementById('auto_renew').addEventListener('change', function() {
        document.getElementById('auto_renew_hidden').value = this.checked ? '1' : '0';
    });
</script>
@endsection
