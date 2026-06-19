@extends('layouts.app')

@section('title', 'Mon Portefeuille - Karnou')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

    body { background-color: #f4f6f9 !important; }

    .wallet-page {
        font-family: 'Roboto', -apple-system, sans-serif;
        max-width: 980px;
        padding: 2rem 1.5rem 4rem;
    }

    /* ── Page header ── */
    .wallet-page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 1.75rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid #e0e0e0;
    }
    .wallet-page-header h1 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f1111;
        margin: 0;
    }
    .wallet-page-header p {
        color: #6b7280;
        font-size: 0.83rem;
        margin-top: 4px;
    }

    /* ── Alerts ── */
    .wallet-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.85rem 1.1rem;
        border-radius: 8px;
        font-size: 0.88rem;
        margin-bottom: 1.25rem;
    }
    .wallet-alert.success { background: #e6f4ea; color: #155724; border: 1px solid #a8d5b1; }
    .wallet-alert.error   { background: #fff5f5; color: #7f1d1d; border: 1px solid #fca5a5; }

    /* ══════════════════════════════
       REALISTIC BANK CARD
    ══════════════════════════════ */
    .card-scene {
        perspective: 1200px;
        margin-bottom: 1.75rem;
    }
    .finance-card {
        background: linear-gradient(135deg, #003a8c 0%, #004aad 35%, #0062d6 65%, #0a7aff 100%);
        border-radius: 20px;
        padding: 1.75rem 2rem 1.5rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow:
            0 8px 20px rgba(0, 74, 173, 0.18),
            0 3px 8px rgba(0,0,0,0.1),
            inset 0 1px 0 rgba(255,255,255,0.15);
        /* Standard card ratio 85.6mm × 53.98mm */
        aspect-ratio: 85.6 / 53.98;
        max-width: 420px;
        width: 100%;
        font-family: 'Courier New', 'Lucida Console', monospace;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        cursor: default;
        user-select: none;
    }
    .finance-card:hover {
        transform: translateY(-4px) rotateX(2deg);
        box-shadow:
            0 14px 28px rgba(0, 74, 173, 0.22),
            0 6px 12px rgba(0,0,0,0.12),
            inset 0 1px 0 rgba(255,255,255,0.2);
    }
    /* ── Shimmer overlay ── */
    .finance-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            105deg,
            transparent 30%,
            rgba(255,255,255,0.08) 50%,
            transparent 70%
        );
        pointer-events: none;
        z-index: 1;
    }
    /* ── Big decorative circle top-right ── */
    .finance-card::after {
        content: '';
        position: absolute;
        width: 260px; height: 260px;
        background: radial-gradient(circle, rgba(255,255,255,0.07) 0%, transparent 70%);
        border-radius: 50%;
        top: -80px; right: -60px;
        pointer-events: none;
    }
    /* ── Card inner layers ── */
    .card-deco-circle {
        position: absolute;
        width: 180px; height: 180px;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        border-radius: 50%;
        bottom: -60px; left: -40px;
        pointer-events: none;
    }
    .card-inner { position: relative; z-index: 2; height: 100%; display: flex; flex-direction: column; justify-content: space-between; }

    /* ── Row 1: Brand + Network ── */
    .card-row-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-brand-name {
        font-family: 'Roboto', sans-serif;
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        color: #fff;
        text-shadow: 0 1px 4px rgba(0,0,0,0.3);
    }
    .card-brand-name span { color: #f68b1e; }
    /* Visa-style logo circles */
    .card-network {
        display: flex;
        align-items: center;
    }
    .card-network-circles {
        display: flex;
    }
    .card-network-circles span {
        width: 28px; height: 28px;
        border-radius: 50%;
        display: block;
    }
    .card-network-circles span:first-child {
        background: rgba(255,255,255,0.85);
        margin-right: -10px;
    }
    .card-network-circles span:last-child {
        background: rgba(246,139,30,0.85);
    }

    /* ── Row 2: Chip + NFC ── */
    .card-row-chip {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 0.2rem;
    }
    /* Gold chip SVG-based */
    .card-chip {
        width: 46px;
        height: 36px;
        background: linear-gradient(135deg, #c8a951 0%, #f5d060 30%, #d4a82a 55%, #f0c040 75%, #b8952a 100%);
        border-radius: 6px;
        position: relative;
        box-shadow: 0 2px 6px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.3);
        flex-shrink: 0;
        overflow: hidden;
    }
    /* Chip internal lines */
    .card-chip::before {
        content: '';
        position: absolute;
        top: 50%; left: 0; right: 0;
        height: 1px;
        background: rgba(0,0,0,0.2);
        transform: translateY(-50%);
    }
    .card-chip::after {
        content: '';
        position: absolute;
        left: 50%; top: 0; bottom: 0;
        width: 1px;
        background: rgba(0,0,0,0.2);
        transform: translateX(-50%);
    }
    .chip-inner {
        position: absolute;
        inset: 6px;
        background: linear-gradient(135deg, #e8c140, #c8a030);
        border-radius: 3px;
        border: 1px solid rgba(0,0,0,0.15);
    }
    /* NFC icon */
    .card-nfc {
        opacity: 0.8;
        font-size: 1.3rem;
        transform: rotate(90deg);
        display: inline-block;
    }

    /* ── Row 3: Balance label ── */
    .card-balance-section { }
    .card-balance-label {
        font-family: 'Roboto', sans-serif;
        font-size: 0.65rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        opacity: 0.65;
        margin-bottom: 3px;
    }
    .card-balance-amount {
        font-family: 'Roboto', sans-serif;
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        line-height: 1;
        text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .card-balance-amount sup {
        font-size: 0.85rem;
        font-weight: 500;
        opacity: 0.7;
        vertical-align: super;
        margin-right: 4px;
        letter-spacing: 0.05em;
    }

    /* ── Row 4: Number + Expiry ── */
    .card-row-number {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    .card-number {
        display: flex;
        gap: 10px;
        align-items: center;
        font-size: 0.95rem;
        letter-spacing: 0.18em;
        opacity: 0.9;
    }
    .card-number-group { letter-spacing: 0.2em; }
    .card-expiry-block { text-align: right; }
    .card-expiry-label {
        font-family: 'Roboto', sans-serif;
        font-size: 0.55rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        opacity: 0.6;
        margin-bottom: 1px;
    }
    .card-expiry-value {
        font-size: 0.85rem;
        letter-spacing: 0.12em;
        opacity: 0.9;
    }

    /* ── Row 5: Holder ── */
    .card-row-holder {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-holder-label {
        font-family: 'Roboto', sans-serif;
        font-size: 0.55rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        opacity: 0.6;
        margin-bottom: 1px;
    }
    .card-holder-name {
        font-family: 'Roboto', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        opacity: 0.95;
    }
    /* Secure badge */
    .card-secure-badge {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 20px;
        padding: 3px 10px;
        font-family: 'Roboto', sans-serif;
        font-size: 0.6rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        display: flex;
        align-items: center;
        gap: 4px;
        backdrop-filter: blur(4px);
        opacity: 0.9;
    }

    /* ── Below-card stats strip ── */
    .card-stats-strip {
        display: flex;
        gap: 0;
        margin-bottom: 1.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .cstat {
        flex: 1;
        padding: 0.9rem 1rem;
        text-align: center;
        border-right: 1px solid #f3f4f6;
    }
    .cstat:last-child { border-right: none; }
    .cstat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #9ca3af;
        font-weight: 600;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }
    .cstat-value {
        font-size: 1.05rem;
        font-weight: 700;
        color: #111827;
    }
    .cstat-value.green { color: #15803d; }
    .cstat-value.amber { color: #d97706; }

    /* ── Action Buttons Row ── */
    .wallet-actions {
        display: flex;
        gap: 0.85rem;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
    }
    .btn-w-primary {
        background: #004aad;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.65rem 1.35rem;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .btn-w-primary:hover { background: #003a8c; transform: translateY(-1px); }
    .btn-w-outline {
        background: #fff;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0.65rem 1.35rem;
        font-size: 0.88rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .btn-w-outline:hover { background: #f9fafb; }

    /* ── Section card ── */
    .w-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .w-card-header {
        padding: 0.9rem 1.5rem;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .w-card-header h2 {
        font-size: 0.92rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .w-card-header h2 i { color: #004aad; }
    .w-card-body { padding: 1.5rem; }

    /* ── Pending funds box ── */
    .pending-box {
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-radius: 8px;
        padding: 0.85rem 1.1rem;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.85rem;
        color: #92400e;
        margin-top: 1rem;
    }
    .pending-box i { color: #d97706; margin-top: 2px; flex-shrink: 0; }

    /* ── Withdrawal Form ── */
    .withdraw-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.75rem;
        margin-bottom: 1.25rem;
    }
    @media (max-width: 640px) {
        .withdraw-grid { grid-template-columns: 1fr; }
        .finance-card-balance { font-size: 2rem; }
    }
    .form-field label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .form-input {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.92rem;
        color: #111827;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .form-input:focus {
        border-color: #004aad;
        box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.12);
    }
    .amount-wrapper {
        position: relative;
    }
    .amount-wrapper input {
        font-size: 1.3rem;
        font-weight: 700;
        padding-right: 65px;
        color: #111827;
    }
    .amount-suffix {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.82rem;
        font-weight: 700;
        color: #6b7280;
    }
    .available-hint {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        color: #6b7280;
        margin-top: 6px;
    }
    .available-hint strong { color: #007600; }

    /* payment method chips */
    .pay-chips { display: flex; gap: 10px; }
    .pay-chip {
        flex: 1;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.18s;
        background: #fafafa;
        font-size: 0.82rem;
        font-weight: 500;
        color: #374151;
    }
    .pay-chip:hover { border-color: #004aad; background: #f0f5ff; }
    .pay-chip.active {
        border-color: #004aad;
        background: #eef3ff;
        box-shadow: 0 0 0 2px rgba(0,74,173,0.15);
        color: #004aad;
        font-weight: 600;
    }

    .withdraw-notice {
        background: #eff6ff;
        border-left: 4px solid #004aad;
        border-radius: 0 8px 8px 0;
        padding: 0.75rem 1rem;
        display: flex;
        gap: 10px;
        align-items: flex-start;
        font-size: 0.81rem;
        color: #1e40af;
        margin-top: 1.25rem;
    }
    .withdraw-notice i { margin-top: 2px; flex-shrink: 0; }

    .btn-submit-withdraw {
        background: linear-gradient(135deg, #004aad, #0066ee);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.8rem 2.5rem;
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.15s;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        margin-top: 1.5rem;
        box-shadow: 0 4px 14px rgba(0, 74, 173, 0.3);
    }
    .btn-submit-withdraw:hover { opacity: 0.9; transform: translateY(-1px); }

    /* locked state */
    .locked-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #6b7280;
    }
    .locked-state i { font-size: 2.5rem; color: #d1d5db; margin-bottom: 1rem; }
    .locked-state p { font-size: 0.92rem; margin: 0; line-height: 1.6; }

    /* ── Transaction Table ── */
    .tx-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }
    .tx-table th {
        background: #f9fafb;
        color: #6b7280;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.7rem 1.1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
    }
    .tx-table td {
        padding: 0.95rem 1.1rem;
        border-bottom: 1px solid #f3f4f6;
        color: #111827;
        vertical-align: middle;
    }
    .tx-table tr:last-child td { border-bottom: none; }
    .tx-table tr:hover td { background: #fafafa; }

    .tx-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .tx-icon.income  { background: #dcfce7; color: #15803d; }
    .tx-icon.expense { background: #fee2e2; color: #dc2626; }
    .tx-icon.pending { background: #fef9c3; color: #a16207; }

    .tx-ref { font-size: 0.72rem; color: #9ca3af; margin-top: 2px; font-family: monospace; }

    .badge-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.73rem;
        font-weight: 600;
    }
    .badge-available { background: #dcfce7; color: #15803d; }
    .badge-pending   { background: #fef9c3; color: #a16207; }
    .badge-withdrawn { background: #f3f4f6; color: #6b7280; }
    .badge-failed    { background: #fee2e2; color: #dc2626; }

    .tx-empty {
        text-align: center;
        padding: 3rem;
        color: #9ca3af;
    }
    .tx-empty i { font-size: 2rem; margin-bottom: 0.75rem; color: #e5e7eb; }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content wallet-page">

        {{-- Header --}}
        <div class="wallet-page-header">
            <div>
                <h1>Mon Portefeuille</h1>
                <p>Gérez vos revenus et effectuez vos virements en toute sécurité.</p>
            </div>
            <div style="font-size: 0.78rem; color: #007185; font-weight: 500; display: flex; align-items: center; gap: 5px; cursor: pointer;">
                <i class="far fa-question-circle"></i> Comment ça marche ?
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="wallet-alert success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="wallet-alert error">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- ══ REALISTIC BANK CARD ══ --}}
        <div class="card-scene">
            <div class="finance-card">
                <div class="card-deco-circle"></div>
                <div class="card-inner">

                    {{-- Row 1: Brand + Network --}}
                    <div class="card-row-top">
                        <div class="card-brand-name">Kar<span>nou</span></div>
                        <div class="card-network">
                            <div class="card-network-circles">
                                <span></span><span></span>
                            </div>
                        </div>
                    </div>

                    {{-- Row 2: Chip + NFC + Balance --}}
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div class="card-row-chip">
                            <div class="card-chip"><div class="chip-inner"></div></div>
                            <span class="card-nfc">&#x1F6DC;</span>
                        </div>
                        <div class="card-balance-section" style="text-align:right;">
                            <div class="card-balance-label">Solde disponible</div>
                            <div class="card-balance-amount">
                                <sup>FCFA</sup>{{ number_format($availableBalance, 0, ',', ' ') }}
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: Card number --}}
                    <div class="card-row-number">
                        <div class="card-number">
                            <span class="card-number-group">●●●●</span>
                            <span class="card-number-group">●●●●</span>
                            <span class="card-number-group">●●●●</span>
                            <span class="card-number-group" style="letter-spacing:0.15em; opacity:1;">{{ str_pad(substr(md5($user->id), 0, 4), 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="card-expiry-block">
                            <div class="card-expiry-label">Expire</div>
                            <div class="card-expiry-value">{{ now()->addYear()->format('m/y') }}</div>
                        </div>
                    </div>

                    {{-- Row 4: Holder + Secure --}}
                    <div class="card-row-holder">
                        <div>
                            <div class="card-holder-label">Titulaire</div>
                            <div class="card-holder-name">{{ strtoupper(auth()->user()->name) }}</div>
                        </div>
                        <div class="card-secure-badge">
                            <i class="fas fa-lock" style="font-size:0.55rem;"></i> Sécurisé
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Stats strip below card --}}
        <div class="card-stats-strip">
            <div class="cstat">
                <div class="cstat-label"><i class="fas fa-hourglass-half"></i> En séquestre</div>
                @if($pendingBalance > 0)
                    <div class="cstat-value amber">{{ number_format($pendingBalance, 0, ',', ' ') }} <span style="font-size:0.72rem;font-weight:400;">FCFA</span></div>
                @else
                    <div class="cstat-value" style="color:#d1d5db;">— FCFA</div>
                @endif
            </div>
            <div class="cstat">
                <div class="cstat-label"><i class="fas fa-check-circle"></i> Disponible</div>
                <div class="cstat-value green">{{ number_format($availableBalance, 0, ',', ' ') }} <span style="font-size:0.72rem;font-weight:400;">FCFA</span></div>
            </div>
            <div class="cstat">
                <div class="cstat-label"><i class="fas fa-exchange-alt"></i> Transactions</div>
                <div class="cstat-value">{{ $recentTransactions->total() }}</div>
            </div>
        </div>

        {{-- Action buttons --}}
        <div class="wallet-actions">
            <button class="btn-w-primary" onclick="document.getElementById('withdraw-section').scrollIntoView({behavior:'smooth'})">
                <i class="fas fa-paper-plane"></i> Effectuer un retrait
            </button>
            <button class="btn-w-outline" onclick="window.print()">
                <i class="fas fa-file-pdf" style="color: #ef4444;"></i> Relevé PDF
            </button>
            <button class="btn-w-outline" onclick="document.getElementById('tx-section').scrollIntoView({behavior:'smooth'})">
                <i class="fas fa-list-ul" style="color: #6b7280;"></i> Voir l'historique
            </button>
        </div>

        {{-- Pending funds info --}}
        @if($pendingBalance > 0)
            <div class="pending-box" style="margin-bottom: 1.5rem;">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>{{ number_format($pendingBalance, 0, ',', ' ') }} FCFA en attente de libération</strong><br>
                    Ces fonds sont sécurisés en séquestre et seront libérés automatiquement après confirmation des livraisons.
                    @if($pendingTransactions->count() > 0)
                        (Prochaine libération : {{ $pendingTransactions->first()->release_at?->format('d/m/Y') ?? '—' }})
                    @endif
                </div>
            </div>
        @endif

        {{-- ══ WITHDRAWAL SECTION ══ --}}
        <div class="w-card" id="withdraw-section">
            <div class="w-card-header">
                <h2><i class="fas fa-paper-plane"></i> Service de retrait</h2>
                <span style="font-size: 0.75rem; color: #007600; font-weight: 600; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-lock"></i> Transaction sécurisée
                </span>
            </div>
            <div class="w-card-body">
                @if($availableBalance >= 1000)
                    <form action="{{ route('vendeur.wallet.withdraw') }}" method="POST">
                        @csrf
                        <div class="withdraw-grid">
                            {{-- Montant --}}
                            <div class="form-field">
                                <label>Montant à virer</label>
                                <div class="amount-wrapper">
                                    <input type="number" name="montant" class="form-input"
                                        min="1000" max="{{ $availableBalance }}"
                                        required placeholder="0"
                                        value="{{ old('montant') }}">
                                    <span class="amount-suffix">FCFA</span>
                                </div>
                                <div class="available-hint">
                                    <span>Minimum : 1 000 FCFA</span>
                                    <span>Disponible : <strong>{{ number_format($availableBalance, 0, ',', ' ') }} FCFA</strong></span>
                                </div>
                            </div>

                            {{-- Destination --}}
                            <div class="form-field">
                                <label>Numéro Mobile Money</label>
                                <div style="position: relative;">
                                    <i class="fas fa-phone-alt" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:0.85rem;"></i>
                                    <input type="text" name="telephone" class="form-input"
                                        style="padding-left: 36px;"
                                        required
                                        value="{{ old('telephone', $user->telephone) }}"
                                        placeholder="Ex : 77 000 00 00">
                                </div>
                                <p style="font-size: 0.73rem; color: #9ca3af; margin:5px 0 1rem;">Vérifiez votre numéro avant de valider.</p>

                                <label>Réseau</label>
                                <div class="pay-chips">
                                    <div class="pay-chip active" onclick="selectPay('om', this)" id="chip-om">
                                        <img src="{{ asset('images/logoOM.png') }}" alt="Orange Money" height="18">
                                        Orange Money
                                    </div>
                                    <div class="pay-chip" onclick="selectPay('wave', this)" id="chip-wave">
                                        <img src="{{ asset('images/logowave.png') }}" alt="Wave" height="18">
                                        Wave
                                    </div>
                                </div>
                                <input type="hidden" name="moyen" id="pay_method" value="om">
                            </div>
                        </div>

                        <div class="withdraw-notice">
                            <i class="fas fa-clock"></i>
                            <span>Les fonds seront transférés sur votre compte mobile dans un délai moyen de <strong>24h ouvrées</strong> via PayDunya.</span>
                        </div>

                        <button type="submit" class="btn-submit-withdraw">
                            <i class="fas fa-paper-plane"></i> Valider le virement
                        </button>
                    </form>
                @else
                    <div class="locked-state">
                        <div><i class="fas fa-lock"></i></div>
                        <p>
                            Solde insuffisant.<br>
                            Le montant minimum pour effectuer un retrait est de <strong>1 000 FCFA</strong>.<br>
                            <span style="font-size: 0.82rem; color: #9ca3af;">Votre solde actuel : {{ number_format($availableBalance, 0, ',', ' ') }} FCFA</span>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ══ TRANSACTIONS TABLE ══ --}}
        <div class="w-card" id="tx-section">
            <div class="w-card-header">
                <h2><i class="fas fa-list-ul"></i> Historique des transactions</h2>
                <span style="font-size: 0.78rem; color: #6b7280;">
                    {{ $recentTransactions->total() }} transaction(s)
                </span>
            </div>
            <div style="overflow-x: auto;">
                <table class="tx-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $tx)
                            @php
                                $isWithdrawal = ($tx->metadata['type'] ?? '') === 'withdrawal';
                                $iconClass    = $tx->montant < 0 ? 'expense' : ($tx->wallet_status === 'pending' ? 'pending' : 'income');
                                $icon         = $isWithdrawal ? 'fa-paper-plane' : ($tx->montant > 0 ? 'fa-arrow-down' : 'fa-arrow-up');
                                $statusLabel  = match($tx->wallet_status) {
                                    'available'  => 'Confirmé',
                                    'pending'    => 'En attente',
                                    'withdrawn'  => 'Retiré',
                                    default      => ucfirst($tx->wallet_status ?? '—'),
                                };
                                $badgeClass   = match($tx->wallet_status) {
                                    'available' => 'available',
                                    'pending'   => 'pending',
                                    'withdrawn' => 'withdrawn',
                                    default     => 'failed',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="tx-icon {{ $iconClass }}">
                                        <i class="fas {{ $icon }}"></i>
                                    </div>
                                </td>
                                <td style="color: #6b7280; white-space: nowrap;">
                                    {{ $tx->created_at->format('d M Y') }}<br>
                                    <span style="font-size: 0.72rem;">{{ $tx->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #111827;">
                                        @if($tx->order_id)
                                            Vente #{{ $tx->order->reference ?? $tx->order_id }}
                                        @elseif($isWithdrawal)
                                            Retrait Mobile Money
                                        @else
                                            Transaction système
                                        @endif
                                    </div>
                                    <div class="tx-ref">{{ Str::limit($tx->reference_externe, 28) }}</div>
                                </td>
                                <td style="font-weight: 700; white-space: nowrap; color: {{ $tx->montant >= 0 ? '#15803d' : '#dc2626' }};">
                                    {{ $tx->montant >= 0 ? '+' : '' }}{{ number_format($tx->montant, 0, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    <span class="badge-pill badge-{{ $badgeClass }}">{{ $statusLabel }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="tx-empty">
                                        <div><i class="fas fa-receipt"></i></div>
                                        <p>Aucune transaction pour le moment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($recentTransactions->hasPages())
                <div style="padding: 1rem 1.5rem; border-top: 1px solid #f3f4f6;">
                    {{ $recentTransactions->links() }}
                </div>
            @endif
        </div>

    </main>
</div>

@push('scripts')
<script>
    function selectPay(m, el) {
        document.querySelectorAll('.pay-chip').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('pay_method').value = m;
    }
</script>
@endpush
@endsection
