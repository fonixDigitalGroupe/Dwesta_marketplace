@extends('layouts.app')

@section('title', 'Mon Abonnement - Karnou')

@push('styles')
<style>
    body { background-color: #f7f8f8 !important; }

    .mabn-page {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1.5rem 4rem;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ── Page title ── */
    .mabn-page-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #0f1111;
        margin: 0 0 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #ddd;
    }

    /* ── Alerts ── */
    .mabn-alert {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        font-size: 0.87rem;
        margin-bottom: 1.25rem;
    }
    .mabn-alert.success { background: #e6f4ea; border: 1px solid #a8d5b1; color: #155724; }
    .mabn-alert.error   { background: #fff5f5; border: 1px solid #f5c6cb; color: #721c24; }
    .mabn-alert.warning { background: #fff8f0; border: 1px solid #f4c28e; color: #7a4a00; }
    .mabn-alert.info    { background: #e8f4fd; border: 1px solid #a8d0f0; color: #0c5460; }

    /* ── Active subscription card ── */
    .active-sub-card {
        background: #fff;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .active-sub-card-header {
        background: #f0f2f2;
        padding: 0.6rem 1.25rem;
        border-bottom: 1px solid #d5d9d9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .active-sub-card-header h2 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f1111;
        margin: 0;
    }
    .active-sub-card-body {
        padding: 1.25rem 1.5rem;
    }

    /* Plan identity row */
    .sub-identity {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }
    .sub-plan-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f1111;
        margin-bottom: 4px;
    }
    .sub-plan-desc { font-size: 0.84rem; color: #565959; }
    .sub-price-pill {
        background: #004aad;
        color: #fff;
        border-radius: 20px;
        padding: 5px 14px;
        font-size: 0.88rem;
        font-weight: 700;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .sub-price-pill.free { background: #007600; }

    /* Stats grid */
    .sub-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    .sub-stat-box {
        background: #f7f8f8;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 0.75rem 1rem;
    }
    .sub-stat-label {
        font-size: 0.73rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #565959;
        margin-bottom: 4px;
        font-weight: 600;
    }
    .sub-stat-value {
        font-size: 1rem;
        font-weight: 700;
        color: #0f1111;
    }
    .sub-stat-value.ok { color: #007600; }
    .sub-stat-value.warn { color: #c7511f; }

    /* Progress bar */
    .annonces-progress {
        margin-bottom: 1.25rem;
    }
    .annonces-progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: #565959;
        margin-bottom: 5px;
    }
    .progress-bar-track {
        height: 8px;
        background: #eee;
        border-radius: 4px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        background: #004aad;
        border-radius: 4px;
        transition: width 0.5s;
    }

    /* Features list */
    .sub-features {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem 1.5rem;
        margin-bottom: 1.25rem;
    }
    .sub-feature {
        font-size: 0.83rem;
        color: #333;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .sub-feature i { color: #007600; }

    /* Auto-renew toggle */
    .autorenew-section {
        background: #fff8f0;
        border: 1px solid #f4c28e;
        border-radius: 6px;
        padding: 0.85rem 1.1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .autorenew-info strong { font-size: 0.88rem; color: #0f1111; display: block; margin-bottom: 2px; }
    .autorenew-info small  { font-size: 0.77rem; color: #565959; }

    /* iOS-style toggle */
    .toggle-wrap { display: flex; align-items: center; gap: 8px; }
    .toggle-wrap input[type="checkbox"] {
        appearance: none;
        width: 40px;
        height: 22px;
        background: #ccc;
        border-radius: 11px;
        cursor: pointer;
        position: relative;
        transition: background 0.25s;
        flex-shrink: 0;
    }
    .toggle-wrap input[type="checkbox"]:checked { background: #007600; }
    .toggle-wrap input[type="checkbox"]::after {
        content: '';
        position: absolute;
        width: 18px; height: 18px;
        background: white;
        border-radius: 50%;
        top: 2px; left: 2px;
        transition: transform 0.25s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .toggle-wrap input[type="checkbox"]:checked::after { transform: translateX(18px); }
    .toggle-wrap .toggle-status { font-size: 0.78rem; color: #565959; }

    /* No subscription state */
    .no-sub-state {
        background: #fff;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        padding: 3rem 1.5rem;
        text-align: center;
        margin-bottom: 1.25rem;
    }
    .no-sub-state i { font-size: 2.5rem; color: #d5d9d9; margin-bottom: 1rem; display: block; }
    .no-sub-state h2 { font-size: 1.1rem; font-weight: 700; color: #0f1111; margin-bottom: 0.5rem; }
    .no-sub-state p  { font-size: 0.87rem; color: #565959; margin-bottom: 1.5rem; }
    .btn-goto-plans {
        display: inline-block;
        background: #004aad;
        color: #fff;
        border-radius: 6px;
        padding: 0.65rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-goto-plans:hover { background: #003a8c; color: #fff; }

    /* ── Other available plans ── */
    .other-plans-section {
        background: #fff;
        border: 1px solid #d5d9d9;
        border-radius: 6px;
        overflow: hidden;
    }
    .other-plans-section-heading {
        background: #f0f2f2;
        padding: 0.6rem 1.25rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f1111;
        border-bottom: 1px solid #d5d9d9;
    }
    .other-plan-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid #eee;
    }
    .other-plan-row:last-child { border-bottom: none; }
    .other-plan-row:hover { background: #fafbfc; }
    .other-plan-name { font-size: 0.92rem; font-weight: 700; color: #0f1111; margin-bottom: 2px; }
    .other-plan-desc { font-size: 0.8rem; color: #565959; }
    .other-plan-price { font-size: 0.95rem; font-weight: 700; color: #0f1111; flex-shrink: 0; text-align: right; }
    .other-plan-price .free-txt { color: #007600; }
    .btn-switch-plan {
        display: inline-block;
        background: #fff;
        color: #004aad;
        border: 1px solid #004aad;
        border-radius: 6px;
        padding: 4px 14px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.15s;
        flex-shrink: 0;
    }
    .btn-switch-plan:hover { background: #f0f5fb; color: #004aad; }

    @media (max-width: 600px) {
        .sub-identity { flex-direction: column; }
        .other-plan-row { flex-wrap: wrap; }
        .autorenew-section { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')
    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="mabn-page">
                <h1 class="mabn-page-title">Mon abonnement</h1>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="mabn-alert success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mabn-alert error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($abonnementActif)
                    @php
                        $daysLeft  = (int) now()->diffInDays($abonnementActif->date_fin, false);
                        $isExpired = $abonnementActif->date_fin->isPast();
                        $plan      = $abonnementActif->abonnement;
                        $maxAnn    = $plan->nombre_annonces;
                        $usedAnn   = $abonnementActif->nombre_annonces_utilisees;
                        $pct       = $maxAnn > 0 ? min(100, round($usedAnn / $maxAnn * 100)) : 0;
                    @endphp

                    {{-- Expiry warnings --}}
                    @if($isExpired)
                        <div class="mabn-alert error">
                            <i class="fas fa-triangle-exclamation"></i>
                            <strong>Votre abonnement a expiré.</strong>&nbsp;
                            <a href="{{ route('abonnements.index') }}" style="color: #721c24; font-weight: 600;">Renouveler →</a>
                        </div>
                    @elseif($daysLeft >= 0 && $daysLeft <= 7)
                        <div class="mabn-alert warning">
                            <i class="fas fa-triangle-exclamation"></i>
                            Votre abonnement expire dans <strong>{{ $daysLeft }} jour(s)</strong>.&nbsp;
                            <a href="{{ route('abonnements.index') }}" style="color: #7a4a00; font-weight: 600;">Renouveler →</a>
                        </div>
                    @endif

                    {{-- Active subscription card --}}
                    <div class="active-sub-card">
                        <div class="active-sub-card-header">
                            <h2>Forfait actif</h2>
                            <span style="font-size: 0.75rem; color: #007600; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                <i class="fas fa-circle" style="font-size: 0.45rem;"></i>
                                {{ $isExpired ? 'Expiré' : 'Actif' }}
                            </span>
                        </div>
                        <div class="active-sub-card-body">

                            {{-- Identity --}}
                            <div class="sub-identity">
                                <div>
                                    <div class="sub-plan-name">{{ $plan->nom }}</div>
                                    @if($plan->description)
                                        <div class="sub-plan-desc">{{ $plan->description }}</div>
                                    @endif
                                </div>
                                @if($plan->prix_mensuel > 0)
                                    <div class="sub-price-pill">{{ number_format($plan->prix_mensuel, 0, ',', ' ') }} FCFA / mois</div>
                                @else
                                    <div class="sub-price-pill free">Gratuit</div>
                                @endif
                            </div>

                            {{-- Stats --}}
                            <div class="sub-stats">
                                <div class="sub-stat-box">
                                    <div class="sub-stat-label">Début</div>
                                    <div class="sub-stat-value">{{ $abonnementActif->date_debut->format('d/m/Y') }}</div>
                                </div>
                                <div class="sub-stat-box">
                                    <div class="sub-stat-label">Expiration</div>
                                    <div class="sub-stat-value {{ $isExpired ? 'warn' : ($daysLeft <= 7 ? 'warn' : 'ok') }}">
                                        {{ $abonnementActif->date_fin->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div class="sub-stat-box">
                                    <div class="sub-stat-label">Jours restants</div>
                                    <div class="sub-stat-value {{ $daysLeft <= 7 ? 'warn' : 'ok' }}">
                                        {{ $isExpired ? '0' : $daysLeft }} jour(s)
                                    </div>
                                </div>
                                <div class="sub-stat-box">
                                    <div class="sub-stat-label">Commission</div>
                                    <div class="sub-stat-value">{{ number_format($plan->commission, 0) }}%</div>
                                </div>
                            </div>

                            {{-- Annonces usage --}}
                            @if($maxAnn > 0)
                                <div class="annonces-progress">
                                    <div class="annonces-progress-label">
                                        <span>Annonces utilisées</span>
                                        <span><strong>{{ $usedAnn }}</strong> / {{ $maxAnn }}</span>
                                    </div>
                                    <div class="progress-bar-track">
                                        <div class="progress-bar-fill" style="width: {{ $pct }}%;"></div>
                                    </div>
                                </div>
                            @else
                                <div style="margin-bottom: 1rem; font-size: 0.83rem; color: #007600;">
                                    <i class="fas fa-infinity"></i> Annonces illimitées
                                </div>
                            @endif

                            {{-- Features --}}
                            <div class="sub-features">
                                <span class="sub-feature">
                                    <i class="fas fa-check"></i>
                                    {{ $maxAnn == 0 ? 'Annonces illimitées' : $maxAnn . ' annonces/mois' }}
                                </span>
                                <span class="sub-feature">
                                    <i class="fas fa-check"></i>
                                    Commission {{ number_format($plan->commission, 0) }}%
                                </span>
                                @if($plan->page_pro)
                                    <span class="sub-feature">
                                        <i class="fas fa-check"></i>
                                        Page Boutique Pro
                                    </span>
                                @endif
                            </div>

                            {{-- Auto-renew toggle --}}
                            <div class="autorenew-section">
                                <div class="autorenew-info">
                                    <strong>Renouvellement automatique</strong>
                                    <small>L'abonnement sera renouvelé automatiquement à la fin de la période.</small>
                                </div>
                                <form method="POST" action="{{ route('abonnements.index') }}" id="toggle-renew-form">
                                    @csrf
                                    <div class="toggle-wrap">
                                        <input
                                            type="checkbox"
                                            id="autorenew-toggle"
                                            {{ $abonnementActif->renouvellement_automatique ? 'checked' : '' }}
                                            title="Activer / Désactiver le renouvellement automatique"
                                        >
                                        <span class="toggle-status">
                                            {{ $abonnementActif->renouvellement_automatique ? 'Activé' : 'Désactivé' }}
                                        </span>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                @else
                    {{-- No active subscription --}}
                    <div class="no-sub-state">
                        <i class="fas fa-box-open"></i>
                        <h2>Aucun abonnement actif</h2>
                        <p>Vous n'avez pas de forfait actif. Choisissez un plan pour booster vos ventes.</p>
                        <a href="{{ route('abonnements.index') }}" class="btn-goto-plans">
                            Voir les forfaits disponibles →
                        </a>
                    </div>
                @endif

                {{-- Other available plans --}}
                @php
                    $otherPlans = $abonnements->filter(function($a) use ($abonnementActif) {
                        return !$abonnementActif || $abonnementActif->abonnement_id !== $a->id;
                    });
                @endphp

                @if($otherPlans->count() > 0)
                    <div class="other-plans-section">
                        <div class="other-plans-section-heading">
                            {{ $abonnementActif ? 'Changer de forfait' : 'Forfaits disponibles' }}
                        </div>
                        @foreach($otherPlans as $plan)
                            <div class="other-plan-row">
                                <div>
                                    <div class="other-plan-name">{{ $plan->nom }}</div>
                                    <div class="other-plan-desc">
                                        {{ $plan->nombre_annonces == 0 ? 'Annonces illimitées' : $plan->nombre_annonces . ' annonces/mois' }}
                                        · Commission {{ number_format($plan->commission, 0) }}%
                                    </div>
                                </div>
                                <div class="other-plan-price">
                                    @if($plan->prix_mensuel > 0)
                                        {{ number_format($plan->prix_mensuel, 0, ',', ' ') }} FCFA<br>
                                        <span style="font-size: 0.73rem; color: #565959;">/ mois</span>
                                    @else
                                        <span class="free-txt">Gratuit</span>
                                    @endif
                                </div>
                                <a href="{{ route('abonnements.index') }}" class="btn-switch-plan">
                                    Choisir
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </main>
    </div>
@endsection