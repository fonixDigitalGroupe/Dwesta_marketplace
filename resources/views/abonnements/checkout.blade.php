@extends('layouts.app')

@section('title', 'Confirmation — ' . $abonnement->nom . ' — Karnou')

@push('styles')
<style>
    body { background-color: #f7f8f8 !important; }

    .ckout-page {
        max-width: 680px;
        margin: 2rem auto;
        padding: 0 1.25rem 5rem;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Breadcrumb */
    .ckout-breadcrumb {
        font-size: 0.82rem;
        color: #565959;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .ckout-breadcrumb a { color: #007185; text-decoration: none; }
    .ckout-breadcrumb a:hover { text-decoration: underline; color: #c7511f; }

    /* Page title */
    .ckout-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f1111;
        margin: 0 0 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #ddd;
    }

    /* Plan summary card */
    .plan-card {
        background: #fff;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }
    .plan-card-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f1111;
        margin-bottom: 4px;
    }
    .plan-card-desc {
        font-size: 0.83rem;
        color: #565959;
        line-height: 1.5;
    }
    .plan-card-feat {
        margin-top: 0.65rem;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .plan-card-feat span {
        font-size: 0.8rem;
        color: #007600;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .plan-card-price {
        text-align: right;
        flex-shrink: 0;
        padding-top: 2px;
    }
    .plan-card-price .price-val {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f1111;
    }
    .plan-card-price .price-sub {
        font-size: 0.78rem;
        color: #565959;
    }
    .plan-card-price .price-free {
        font-size: 1.2rem;
        font-weight: 700;
        color: #007600;
    }

    /* Section block */
    .ckout-section {
        background: #fff;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .ckout-section-heading {
        background: #f0f2f2;
        padding: 0.6rem 1.25rem;
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f1111;
        border-bottom: 1px solid #d5d9d9;
    }
    .ckout-section-body {
        padding: 1rem 1.25rem;
    }

    /* Payment method options */
    .pay-options { display: flex; flex-direction: column; gap: 0.65rem; }
    .pay-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.15s, border-color 0.15s;
    }
    .pay-option:hover { border-color: #a0aec0; background: #fafbfc; }
    .pay-option input[type="radio"]:checked + .pay-label-inner { font-weight: 700; color: #0f1111; }
    .pay-option:has(input:checked) {
        border-color: #004aad;
        background: #f0f5fb;
        box-shadow: 0 0 0 2px rgba(0,74,173,0.1);
    }
    .pay-option input[type="radio"] {
        accent-color: #004aad;
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        cursor: pointer;
    }
    .pay-label-inner {
        font-size: 0.9rem;
        color: #333;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Auto-renew row */
    .autorenew-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .autorenew-row input[type="checkbox"] {
        accent-color: #004aad;
        width: 16px;
        height: 16px;
        margin-top: 3px;
        cursor: pointer;
        flex-shrink: 0;
    }
    .autorenew-row label {
        font-size: 0.87rem;
        color: #333;
        cursor: pointer;
        line-height: 1.5;
    }
    .autorenew-row label small { color: #565959; display: block; margin-top: 2px; font-size: 0.77rem; }

    /* Order summary box */
    .order-summary {
        background: #f7f8f8;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
        font-size: 0.88rem;
    }
    .order-summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.35rem 0;
        color: #333;
    }
    .order-summary-row.total {
        font-size: 1rem;
        font-weight: 700;
        color: #0f1111;
        border-top: 1px solid #d5d9d9;
        margin-top: 0.5rem;
        padding-top: 0.65rem;
    }

    /* Submit button */
    .btn-confirm {
        width: 100%;
        background: #FFD814;
        color: #111;
        border: 1px solid #FCD200;
        border-radius: 6px;
        padding: 0.75rem;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.15s;
        box-shadow: 0 2px 5px rgba(213,217,217,.5);
    }
    .btn-confirm:hover { background: #F7CA00; }

    .skip-link {
        display: block;
        text-align: center;
        margin-top: 0.85rem;
        font-size: 0.83rem;
        color: #007185;
        text-decoration: none;
    }
    .skip-link:hover { text-decoration: underline; color: #c7511f; }

    .security-line {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: #565959;
        margin-top: 0.75rem;
    }
    .security-line i { color: #007600; }

    @media (max-width: 480px) {
        .plan-card { flex-direction: column; }
        .plan-card-price { text-align: left; }
    }
</style>
@endpush

@section('content')
    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="ckout-page">

                {{-- Breadcrumb --}}
                <div class="ckout-breadcrumb">
                    <a href="{{ route('abonnements.index') }}">Abonnements</a>
                    <i class="fas fa-chevron-right" style="font-size: 0.65rem;"></i>
                    <span>Confirmation</span>
                </div>

                <h1 class="ckout-title">Confirmer votre abonnement</h1>

                {{-- Plan Summary --}}
                <div class="plan-card">
                    <div>
                        <div class="plan-card-name">{{ $abonnement->nom }}</div>
                        @if($abonnement->description)
                            <div class="plan-card-desc">{{ $abonnement->description }}</div>
                        @endif
                        <div class="plan-card-feat">
                            <span><i class="fas fa-check"></i>
                                {{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces/mois' }}
                            </span>
                            <span><i class="fas fa-check"></i> Commission {{ number_format($abonnement->commission, 0) }}%</span>
                            @if($abonnement->page_pro)
                                <span><i class="fas fa-check"></i> Page Boutique Pro incluse</span>
                            @endif
                            <span><i class="fas fa-check"></i> Durée : 1 mois</span>
                        </div>
                    </div>
                    <div class="plan-card-price">
                        @if($abonnement->prix_mensuel > 0)
                            <div class="price-val">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA</div>
                            <div class="price-sub">par mois</div>
                        @else
                            <div class="price-free">Gratuit</div>
                        @endif
                    </div>
                </div>

                <form action="{{ route('abonnements.subscribe') }}" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" name="abonnement_id" value="{{ $abonnement->id }}">

                    {{-- Payment method --}}
                    @if($abonnement->prix_mensuel > 0)
                        <div class="ckout-section">
                            <div class="ckout-section-heading">Moyen de paiement</div>
                            <div class="ckout-section-body">
                                <div class="pay-options">
                                    <label class="pay-option">
                                        <input type="radio" name="payment_method" value="om" checked>
                                        <span class="pay-label-inner">
                                            <img src="{{ asset('images/logoOM.png') }}" alt="Orange Money" height="20" onerror="this.style.display='none'">
                                            Orange Money
                                        </span>
                                    </label>
                                    <label class="pay-option">
                                        <input type="radio" name="payment_method" value="wave">
                                        <span class="pay-label-inner">
                                            <img src="{{ asset('images/logowave.png') }}" alt="Wave" height="20" onerror="this.style.display='none'">
                                            Wave
                                        </span>
                                    </label>
                                    <label class="pay-option">
                                        <input type="radio" name="payment_method" value="cb">
                                        <span class="pay-label-inner">
                                            <i class="far fa-credit-card" style="color:#004aad;"></i>
                                            Carte Bancaire
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="payment_method" value="cb">
                    @endif

                    {{-- Auto-renew --}}
                    <div class="ckout-section">
                        <div class="ckout-section-heading">Options</div>
                        <div class="ckout-section-body">
                            <div class="autorenew-row">
                                <input type="checkbox" name="auto_renew" value="1" id="auto_renew" checked>
                                <label for="auto_renew">
                                    Renouvellement automatique
                                    <small>Votre abonnement sera renouvelé automatiquement à la fin de la période, sans interruption de service.</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Order total --}}
                    <div class="order-summary">
                        <div class="order-summary-row">
                            <span>Forfait {{ $abonnement->nom }}</span>
                            <span>
                                @if($abonnement->prix_mensuel > 0)
                                    {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA
                                @else
                                    0 FCFA
                                @endif
                            </span>
                        </div>
                        <div class="order-summary-row">
                            <span>Durée</span>
                            <span>1 mois</span>
                        </div>
                        <div class="order-summary-row total">
                            <span>Total à payer</span>
                            <span>
                                @if($abonnement->prix_mensuel > 0)
                                    {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA
                                @else
                                    Gratuit
                                @endif
                            </span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-confirm">
                        @if($abonnement->prix_mensuel > 0)
                            Payer {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA →
                        @else
                            Activer le forfait gratuit →
                        @endif
                    </button>
                    <a href="{{ route('abonnements.index') }}" class="skip-link">Annuler et retourner aux abonnements</a>
                    <div class="security-line">
                        <i class="fas fa-lock"></i> Transaction sécurisée via PayDunya
                    </div>
                </form>

            </div>
        </main>
    </div>
@endsection
