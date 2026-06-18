@extends('layouts.app')

@section('title', 'Mes abonnements - Karnou')

@push('styles')
<style>
    body {
        background-color: #f7f8f8 !important;
    }

    .abn-page {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1.5rem 4rem;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ── Page title ── */
    .abn-page-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f1111;
        margin: 0 0 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #ddd;
    }

    /* ── Promo banner ── */
    .abn-promo-banner {
        background: #fff8f0;
        border: 1px solid #f4c28e;
        border-radius: 6px;
        padding: 0.85rem 1.1rem;
        margin-bottom: 1.25rem;
        font-size: 0.88rem;
        color: #333;
        line-height: 1.5;
    }
    .abn-promo-banner strong {
        color: #B12704;
    }

    /* ── Email line ── */
    .abn-email-line {
        font-size: 0.88rem;
        color: #333;
        margin-bottom: 1.5rem;
    }

    /* ── Section block ── */
    .abn-section {
        background: #fff;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        margin-bottom: 1.25rem;
        overflow: hidden;
    }

    .abn-section-heading {
        background: #f0f2f2;
        padding: 0.6rem 1.1rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f1111;
        border-bottom: 1px solid #d5d9d9;
    }

    .abn-section-intro {
        padding: 0.75rem 1.1rem 0.25rem;
        font-size: 0.85rem;
        color: #565959;
    }

    /* ── Plan row ── */
    .abn-plan-row {
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        padding: 0.85rem 1.1rem;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        transition: background 0.15s;
        position: relative;
    }

    .abn-plan-row:last-child {
        border-bottom: none;
    }

    .abn-plan-row:hover {
        background: #fafbfc;
    }

    /* Custom checkbox */
    .abn-check {
        width: 22px;
        height: 22px;
        flex-shrink: 0;
        margin-top: 2px;
        accent-color: #004aad;
        cursor: pointer;
    }

    .abn-plan-info {
        flex: 1;
    }

    .abn-plan-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f1111;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .abn-plan-desc {
        font-size: 0.82rem;
        color: #565959;
        line-height: 1.45;
    }

    .abn-plan-price {
        font-size: 0.82rem;
        margin-left: auto;
        flex-shrink: 0;
        text-align: right;
        padding-top: 2px;
    }

    .abn-plan-price .price-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f1111;
    }

    .abn-plan-price .price-sub {
        font-size: 0.75rem;
        color: #565959;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        vertical-align: middle;
    }
    .badge-actif   { background: #007600; color: #fff; }
    .badge-pro     { background: #004aad; color: #fff; }
    .badge-free    { background: #565959; color: #fff; }
    .badge-popular { background: #f68b1e; color: #fff; }
    .badge-locked  { background: #ccc; color: #555; }

    /* ── Checkout bar (fixed) ── */
    .checkout-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        padding: 0.9rem 2rem;
        box-shadow: 0 -3px 10px rgba(0,0,0,0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1.5rem;
        z-index: 1000;
        border-top: 1px solid #d5d9d9;
    }

    .checkout-bar-text {
        font-size: 0.95rem;
        color: #333;
    }

    .btn-subscribe {
        background: #004aad;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 0.65rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
        min-width: 200px;
    }

    .btn-subscribe:hover:not(:disabled) {
        background: #003a8c;
    }

    .btn-subscribe:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* ── Alerts ── */
    .alert-success {
        background: #e6f4ea;
        border: 1px solid #a8d5b1;
        border-radius: 6px;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        font-size: 0.87rem;
        color: #155724;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-error {
        background: #fff5f5;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        font-size: 0.87rem;
        color: #721c24;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-info {
        background: #e8f4fd;
        border: 1px solid #a8d0f0;
        border-radius: 6px;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        font-size: 0.87rem;
        color: #0c5460;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* ── Disabled row ── */
    .abn-plan-row.is-locked {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .abn-plan-row.is-locked .abn-check {
        cursor: not-allowed;
    }

    /* ── Active plan highlight ── */
    .abn-plan-row.is-active-plan {
        background: #f0f7ec;
        border-left: 3px solid #007600;
        padding-left: calc(1.1rem - 3px);
    }

    @media (max-width: 600px) {
        .abn-plan-price { display: none; }
        .checkout-bar { flex-direction: column; gap: 0.75rem; }
    }
</style>
@endpush

@section('content')
    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="abn-page">
                <h1 class="abn-page-title">Mes abonnements</h1>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error') || session('error_banner'))
                    <div class="alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ session('error') ?? session('error_banner') }}</span>
                    </div>
                @endif

                {{-- Promo banner --}}
                <div class="abn-promo-banner">
                    <strong>Karnou sélectionne pour vous tous les meilleurs plans du moment !</strong><br>
                    Boostez la visibilité de vos annonces et accédez à nos outils vendeurs professionnels.
                    Votre e-mail : <strong>{{ auth()->user()->email }}</strong>
                </div>

                {{-- Restricted particulier notice --}}
                @if(auth()->user()->vendeur->estParticulier())
                    <div class="alert-info">
                        <i class="fa-solid fa-circle-info"></i>
                        <div>
                            <strong>Compte Vendeur Particulier.</strong>
                            Les forfaits PRO sont réservés aux professionnels.
                            <a href="{{ route('vendeur.create') }}" style="color: #004aad; font-weight: 600;">Devenir PRO →</a>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form action="{{ route('abonnements.subscribe') }}" method="POST" id="subscription-form">
                    @csrf
                    <input type="hidden" name="payment_method" value="cb">
                    <input type="hidden" name="abonnement_id" id="selected-abonnement-id" value="">

                    {{-- Section: abonnements vendeur --}}
                    <div class="abn-section">
                        <div class="abn-section-heading">Abonnements Vendeur</div>
                        <p class="abn-section-intro">Je souhaite m'abonner au forfait :</p>

                        @foreach($abonnements as $abonnement)
                            @php
                                $isSubscribed     = $abonnementActif && $abonnementActif->abonnement_id === $abonnement->id;
                                $isLockedPart     = auth()->user()->vendeur->estParticulier() && $abonnement->prix_mensuel > 0;
                                $isLockedPro      = auth()->user()->vendeur->estProfessionnel() && $abonnement->prix_mensuel == 0;
                                $isLocked         = $isLockedPart || $isLockedPro;
                                $isPopular        = in_array($abonnement->nom, ['Pack Business', 'Vendeur Pro', 'Business', 'Pro']);
                            @endphp

                            <div class="abn-plan-row {{ $isSubscribed ? 'is-active-plan' : '' }} {{ $isLocked ? 'is-locked' : '' }}"
                                 id="row-{{ $abonnement->id }}"
                                 @if(!$isSubscribed && !$isLocked) onclick="selectPlan({{ $abonnement->id }}, '{{ addslashes($abonnement->nom) }}')" @endif>

                                <input
                                    type="radio"
                                    class="abn-check"
                                    name="_ui_plan_select"
                                    id="plan-{{ $abonnement->id }}"
                                    value="{{ $abonnement->id }}"
                                    {{ $isSubscribed ? 'checked' : '' }}
                                    {{ $isLocked ? 'disabled' : '' }}
                                    onclick="event.stopPropagation(); selectPlan({{ $abonnement->id }}, '{{ addslashes($abonnement->nom) }}')"
                                >

                                <div class="abn-plan-info">
                                    <div class="abn-plan-name">
                                        <label for="plan-{{ $abonnement->id }}" style="cursor: inherit; margin: 0;">
                                            {{ $abonnement->nom }}
                                        </label>

                                        @if($isSubscribed)
                                            <span class="badge badge-actif">Actif</span>
                                        @endif
                                        @if($isPopular && !$isSubscribed)
                                            <span class="badge badge-popular">Populaire</span>
                                        @endif
                                        @if($abonnement->prix_mensuel > 0 && !$isPopular)
                                            <span class="badge badge-pro">Pro</span>
                                        @endif
                                        @if($isLocked)
                                            <span class="badge badge-locked">Indisponible</span>
                                        @endif
                                    </div>

                                    <div class="abn-plan-desc">
                                        @if($abonnement->description)
                                            {{ $abonnement->description }} —
                                        @endif
                                        {{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces/mois' }},
                                        commission {{ number_format($abonnement->commission, 0) }}%
                                        @if($abonnement->page_pro)
                                            , Page Boutique Pro incluse
                                        @endif

                                        @if($isSubscribed && $abonnementActif)
                                            <span style="color: #007600; font-weight: 500; display: block; margin-top: 3px;">
                                                ✓ Expire le {{ $abonnementActif->date_fin->format('d/m/Y') }}
                                                @if($abonnementActif->renouvellement_automatique) · Renouvellement automatique activé @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="abn-plan-price">
                                    @if($abonnement->prix_mensuel > 0)
                                        <div class="price-value">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA</div>
                                        <div class="price-sub">par mois</div>
                                    @else
                                        <div class="price-value" style="color: #007600;">Gratuit</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Renouvellement automatique (si abonnement actif) --}}
                    @if($abonnementActif)
                        <div class="abn-section">
                            <div class="abn-section-heading">Renouvellement automatique</div>
                            <div style="padding: 0.9rem 1.1rem;">
                                <form method="POST" action="{{ route('abonnements.toggle-renouvellement') }}" id="renew-form" style="display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                                    @csrf
                                    <div>
                                        <div style="font-size: 0.9rem; font-weight: 600; color: #0f1111; margin-bottom: 3px;">
                                            Renouvellement automatique de mon abonnement
                                        </div>
                                        <div style="font-size: 0.82rem; color: #565959;">
                                            Votre abonnement sera renouvelé automatiquement à la fin de la période en cours.
                                        </div>
                                    </div>

                                    {{-- Toggle Switch --}}
                                    <label style="position: relative; display: inline-block; width: 52px; height: 28px; cursor: pointer; flex-shrink: 0;">
                                        <input
                                            type="checkbox"
                                            name="activer"
                                            value="1"
                                            {{ $abonnementActif->renouvellement_automatique ? 'checked' : '' }}
                                            onchange="document.getElementById('renew-form').submit()"
                                            style="opacity: 0; width: 0; height: 0;"
                                        >
                                        <span style="
                                            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
                                            background-color: {{ $abonnementActif->renouvellement_automatique ? '#004aad' : '#ccc' }};
                                            border-radius: 28px; transition: 0.3s;">
                                            <span style="
                                                position: absolute; height: 20px; width: 20px;
                                                left: 4px; bottom: 4px; background-color: white;
                                                border-radius: 50%; transition: 0.3s;
                                                transform: translateX({{ $abonnementActif->renouvellement_automatique ? '24px' : '0' }});">
                                            </span>
                                        </span>
                                    </label>
                                </form>
                            </div>
                        </div>

                        {{-- Cancel subscription --}}
                        @if($abonnementActif->renouvellement_automatique)
                            <div style="text-align: right; margin-top: -0.5rem; margin-bottom: 1.25rem;">
                                <form action="{{ route('abonnements.cancel') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        style="background: none; border: none; color: #c0392b; font-size: 0.8rem; cursor: pointer; text-decoration: underline; padding: 0;"
                                        onclick="return confirm('Êtes-vous sûr de vouloir désactiver le renouvellement automatique ?')">
                                        Désactiver le renouvellement automatique
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Expiry warning --}}
                        @if($abonnementActif->date_fin->isPast())
                            <div class="alert-error">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <strong>Votre abonnement a expiré.</strong>&nbsp;
                                <a href="#" onclick="document.querySelector('.abn-plan-row:not(.is-active-plan)').click()" style="color:#721c24;">Choisir un nouveau forfait</a>
                            </div>
                        @elseif($abonnementActif->date_fin->diffInDays(now()) <= 7)
                            <div class="alert-error">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Votre abonnement expire dans <strong>{{ $abonnementActif->date_fin->diffInDays(now()) }} jour(s)</strong>.
                            </div>
                        @endif
                    @endif

                    {{-- Sticky checkout bar --}}
                    <div class="checkout-bar" id="checkout-bar" style="display: none;">
                        <div class="checkout-bar-text">
                            Forfait sélectionné :
                            <strong id="selected-plan-name" style="color: #004aad;">...</strong>
                        </div>
                        <button type="submit" class="btn-subscribe" id="submit-btn">
                            Continuer vers le paiement →
                        </button>
                    </div>
                </form>

                {{-- Help link --}}
                <p style="margin-top: 1rem; font-size: 0.8rem; color: #007185; text-align: center;">
                    <i class="far fa-question-circle"></i>
                    <a href="#" style="color: #007185;">En savoir plus sur nos forfaits vendeur</a>
                </p>

            </div>
        </main>
    </div>

    <script>
        function selectPlan(id, name) {
            // Uncheck all
            document.querySelectorAll('.abn-check').forEach(function(r) {
                r.checked = false;
            });
            // Remove highlight from all rows
            document.querySelectorAll('.abn-plan-row:not(.is-active-plan)').forEach(function(row) {
                row.style.background = '';
            });

            // Check selected
            var radio = document.getElementById('plan-' + id);
            if (radio && !radio.disabled) {
                radio.checked = true;
                var row = document.getElementById('row-' + id);
                if (row) row.style.background = '#f0f5fb';
            }

            document.getElementById('selected-abonnement-id').value = id;
            document.getElementById('selected-plan-name').innerText = name;
            document.getElementById('checkout-bar').style.display = 'flex';
        }
    </script>
@endsection
