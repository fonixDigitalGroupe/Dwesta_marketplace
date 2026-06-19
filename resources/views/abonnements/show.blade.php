@extends('layouts.app')

@section('title', $abonnement->nom . ' - Karnou')

@push('styles')
<style>
    body { background-color: #f7f8f8 !important; }

    .show-page {
        max-width: 840px;
        margin: 2rem auto;
        padding: 0 1.5rem 4rem;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Breadcrumb */
    .show-breadcrumb {
        font-size: 0.82rem;
        color: #565959;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-wrap: wrap;
    }
    .show-breadcrumb a { color: #007185; text-decoration: none; }
    .show-breadcrumb a:hover { text-decoration: underline; color: #c7511f; }

    /* ── Hero card ── */
    .plan-hero {
        background: linear-gradient(135deg, #004aad 0%, #0066ee 60%, #0a84ff 100%);
        border-radius: 10px;
        padding: 2rem 2.25rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 12px rgba(0,74,173,0.14);
    }
    .plan-hero::before {
        content: '';
        position: absolute;
        width: 280px; height: 280px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
        top: -100px; right: -70px;
        pointer-events: none;
    }
    .plan-hero-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        position: relative; z-index: 1;
        flex-wrap: wrap;
    }
    .plan-hero-name {
        font-size: 1.75rem;
        font-weight: 700;
        letter-spacing: -0.3px;
    }
    .plan-hero-desc {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-top: 4px;
    }
    .plan-hero-price {
        text-align: right;
        flex-shrink: 0;
    }
    .plan-hero-price .amount {
        font-size: 2.2rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        line-height: 1;
    }
    .plan-hero-price .amount sup {
        font-size: 0.9rem;
        font-weight: 400;
        opacity: 0.7;
        vertical-align: super;
        margin-right: 3px;
    }
    .plan-hero-price .per-month {
        font-size: 0.8rem;
        opacity: 0.65;
        margin-top: 2px;
    }
    .plan-hero-price .free-text {
        font-size: 1.75rem;
        font-weight: 700;
        color: #86efac;
    }

    /* Plan tags / chips */
    .plan-tags {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        position: relative; z-index: 1;
    }
    .plan-tag {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ── Section card ── */
    .show-card {
        background: #fff;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .show-card-heading {
        background: #f0f2f2;
        padding: 0.6rem 1.25rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f1111;
        border-bottom: 1px solid #d5d9d9;
    }
    .show-card-body { padding: 1.25rem 1.5rem; }

    /* Feature rows */
    .feature-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.65rem 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.88rem;
    }
    .feature-row:last-child { border-bottom: none; }
    .feature-row i { color: #007600; margin-top: 2px; flex-shrink: 0; font-size: 0.85rem; }
    .feature-row .feat-label { font-weight: 600; color: #0f1111; margin-bottom: 1px; }
    .feature-row .feat-desc  { color: #565959; font-size: 0.81rem; }

    /* Already subscribed notice */
    .already-sub-notice {
        background: #e6f4ea;
        border: 1px solid #a8d5b1;
        border-radius: 6px;
        padding: 0.85rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        font-size: 0.87rem;
        color: #155724;
        margin-bottom: 1.25rem;
    }
    .already-sub-notice a { color: #155724; font-weight: 600; }

    /* Subscribe form */
    .subscribe-form-inner { }
    .form-row { margin-bottom: 1.1rem; }
    .form-row label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .form-select {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.92rem;
        color: #111827;
        outline: none;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-select:focus {
        border-color: #004aad;
        box-shadow: 0 0 0 3px rgba(0,74,173,0.12);
    }
    .autorenew-row-form {
        display: flex;
        align-items: flex-start;
        gap: 0.65rem;
    }
    .autorenew-row-form input[type="checkbox"] {
        accent-color: #004aad;
        width: 16px; height: 16px;
        margin-top: 3px;
        cursor: pointer;
        flex-shrink: 0;
    }
    .autorenew-row-form label { font-size: 0.87rem; color: #333; cursor: pointer; }
    .autorenew-row-form label small { display: block; font-size: 0.77rem; color: #565959; margin-top: 2px; }

    .btn-subscribe-now {
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
        margin-top: 1.25rem;
    }
    .btn-subscribe-now:hover { background: #F7CA00; }

    /* Locked state */
    .locked-notice {
        background: #fff8f0;
        border: 1px solid #f4c28e;
        border-radius: 6px;
        padding: 0.85rem 1.25rem;
        font-size: 0.86rem;
        color: #7a4a00;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .locked-notice a { color: #7a4a00; font-weight: 600; }

    /* Back link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.83rem;
        color: #007185;
        text-decoration: none;
        margin-top: 1rem;
    }
    .back-link:hover { text-decoration: underline; color: #c7511f; }
</style>
@endpush

@section('content')
    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="show-page">

                {{-- Breadcrumb --}}
                <div class="show-breadcrumb">
                    <a href="{{ route('abonnements.index') }}">Abonnements</a>
                    <i class="fas fa-chevron-right" style="font-size: 0.65rem;"></i>
                    <span>{{ $abonnement->nom }}</span>
                </div>

                {{-- Alerts --}}
                @if(session('error'))
                    <div style="background:#fff5f5;border:1px solid #f5c6cb;border-radius:6px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.87rem;color:#721c24;display:flex;align-items:center;gap:.6rem;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                {{-- Already subscribed notice --}}
                @auth
                    @if($abonnementActuel && $abonnementActuel->abonnement_id === $abonnement->id)
                        <div class="already-sub-notice">
                            <i class="fas fa-circle-check"></i>
                            <span>
                                Vous êtes actuellement abonné à ce forfait.
                                <a href="{{ route('abonnements.index') }}">Gérer mon abonnement →</a>
                            </span>
                        </div>
                    @endif
                @endauth

                {{-- Plan hero --}}
                <div class="plan-hero">
                    <div class="plan-hero-top">
                        <div>
                            <div class="plan-hero-name">{{ $abonnement->nom }}</div>
                            @if($abonnement->description)
                                <div class="plan-hero-desc">{{ $abonnement->description }}</div>
                            @endif
                        </div>
                        <div class="plan-hero-price">
                            @if($abonnement->prix_mensuel > 0)
                                <div class="amount">
                                    <sup>FCFA</sup>{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }}
                                </div>
                                <div class="per-month">par mois</div>
                            @else
                                <div class="free-text">Gratuit</div>
                            @endif
                        </div>
                    </div>
                    <div class="plan-tags">
                        <span class="plan-tag">
                            <i class="fas fa-tag"></i>
                            {{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces/mois' }}
                        </span>
                        <span class="plan-tag">
                            <i class="fas fa-percent"></i>
                            Commission {{ number_format($abonnement->commission, 0) }}%
                        </span>
                        @if($abonnement->page_pro)
                            <span class="plan-tag">
                                <i class="fas fa-store"></i>
                                Page Boutique Pro
                            </span>
                        @endif
                        <span class="plan-tag">
                            <i class="fas fa-calendar-alt"></i>
                            Durée : 1 mois
                        </span>
                    </div>
                </div>

                {{-- Features detail --}}
                <div class="show-card">
                    <div class="show-card-heading">Ce que comprend ce forfait</div>
                    <div class="show-card-body">
                        <div class="feature-row">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <div class="feat-label">
                                    {{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces par mois' }}
                                </div>
                                <div class="feat-desc">Publiez autant d'annonces que vous le souhaitez dans votre quota mensuel.</div>
                            </div>
                        </div>
                        <div class="feature-row">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <div class="feat-label">Commission {{ number_format($abonnement->commission, 0) }}% par vente</div>
                                <div class="feat-desc">Gardez plus de vos revenus grâce à un taux de commission compétitif.</div>
                            </div>
                        </div>
                        @if($abonnement->page_pro)
                            <div class="feature-row">
                                <i class="fas fa-check-circle"></i>
                                <div>
                                    <div class="feat-label">Page Boutique Pro incluse</div>
                                    <div class="feat-desc">Bénéficiez d'une page boutique personnalisée pour renforcer votre marque.</div>
                                </div>
                            </div>
                        @endif
                        <div class="feature-row">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <div class="feat-label">Durée de 1 mois</div>
                                <div class="feat-desc">Renouvelable manuellement ou automatiquement selon vos préférences.</div>
                            </div>
                        </div>
                        <div class="feature-row">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <div class="feat-label">Support vendeur prioritaire</div>
                                <div class="feat-desc">Accès à notre équipe support dédiée aux vendeurs Karnou.</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Subscribe / Action block --}}
                @auth
                    @php
                        $isAlreadySubscribed  = $abonnementActuel && $abonnementActuel->abonnement_id === $abonnement->id;
                        $isVendeur            = auth()->user()->estVendeur() && auth()->user()->vendeur;
                        $isVerified           = $isVendeur && auth()->user()->vendeur->estVerifie();
                        $isParticulier        = $isVendeur && auth()->user()->vendeur->estParticulier();
                        $isRestrictedForPlan  = $isParticulier && $abonnement->prix_mensuel > 0;
                    @endphp

                    @if(!$isAlreadySubscribed)
                        <div class="show-card">
                            <div class="show-card-heading">Souscrire à ce forfait</div>
                            <div class="show-card-body">
                                @if(!$isVendeur)
                                    <div class="locked-notice">
                                        <i class="fas fa-lock"></i>
                                        <span>Vous devez créer un compte vendeur pour souscrire.
                                            <a href="{{ route('vendeur.create') }}">Créer un compte vendeur →</a>
                                        </span>
                                    </div>
                                @elseif(!$isVerified)
                                    <div class="locked-notice">
                                        <i class="fas fa-lock"></i>
                                        <span>Votre compte vendeur doit être vérifié par notre équipe avant de souscrire.</span>
                                    </div>
                                @elseif($isRestrictedForPlan)
                                    <div class="locked-notice">
                                        <i class="fas fa-lock"></i>
                                        <span>En tant que vendeur particulier, vous ne pouvez souscrire qu'au forfait gratuit.
                                            <a href="{{ route('vendeur.create') }}">Devenir Pro →</a>
                                        </span>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('abonnements.subscribe') }}">
                                        @csrf
                                        <input type="hidden" name="abonnement_id" value="{{ $abonnement->id }}">
                                        <input type="hidden" name="payment_method" value="cb">

                                        <div class="form-row autorenew-row-form">
                                            <input type="checkbox" name="renouvellement_automatique" value="1" id="renew" checked>
                                            <label for="renew">
                                                Renouvellement automatique
                                                <small>L'abonnement sera renouvelé automatiquement à la fin de la période.</small>
                                            </label>
                                        </div>

                                        <button type="submit" class="btn-subscribe-now">
                                            @if($abonnement->prix_mensuel > 0)
                                                S'abonner — {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA / mois →
                                            @else
                                                Activer ce forfait gratuitement →
                                            @endif
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                @endauth

                <a href="{{ route('abonnements.index') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Retour aux abonnements
                </a>

            </div>
        </main>
    </div>
@endsection