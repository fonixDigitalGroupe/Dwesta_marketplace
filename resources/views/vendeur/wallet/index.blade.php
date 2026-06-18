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
       FINANCE CARD
    ══════════════════════════════ */
    .finance-card {
        background: linear-gradient(135deg, #004aad 0%, #0066ee 60%, #0a84ff 100%);
        border-radius: 18px;
        padding: 2rem 2.25rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 74, 173, 0.12);
    }
    .finance-card::before {
        content: '';
        position: absolute;
        width: 320px; height: 320px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
        top: -120px; right: -80px;
    }
    .finance-card::after {
        content: '';
        position: absolute;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        bottom: -60px; left: 40px;
    }
    .finance-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.75rem;
        position: relative; z-index: 1;
    }
    .finance-card-label {
        font-size: 0.78rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        opacity: 0.8;
        margin-bottom: 0.4rem;
    }
    .finance-card-balance {
        font-size: 2.6rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        line-height: 1;
    }
    .finance-card-balance sup {
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.75;
        vertical-align: super;
        margin-right: 4px;
    }
    .finance-card-currency {
        font-size: 0.9rem;
        opacity: 0.7;
        margin-left: 6px;
        font-weight: 400;
    }
    .finance-card-badge {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        display: flex;
        align-items: center;
        gap: 5px;
        backdrop-filter: blur(4px);
    }
    .finance-card-stats {
        display: flex;
        gap: 2rem;
        position: relative; z-index: 1;
        flex-wrap: wrap;
    }
    .finance-stat {
        flex: 1;
        min-width: 120px;
    }
    .finance-stat-label {
        font-size: 0.73rem;
        opacity: 0.65;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .finance-stat-value {
        font-size: 1.2rem;
        font-weight: 700;
    }
    .finance-stat-value.muted { opacity: 0.6; font-size: 0.95rem; font-weight: 400; }
    .finance-divider {
        width: 1px;
        background: rgba(255,255,255,0.2);
        align-self: stretch;
    }

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

        {{-- ══ FINANCE CARD ══ --}}
        <div class="finance-card">
            <div class="finance-card-top">
                <div>
                    <div class="finance-card-label">Solde disponible</div>
                    <div class="finance-card-balance">
                        <sup>FCFA</sup>{{ number_format($availableBalance, 0, ',', ' ') }}
                    </div>
                </div>
                <div>
                    <div class="finance-card-badge">
                        <i class="fas fa-shield-alt"></i> Sécurisé
                    </div>
                    <div style="font-size: 0.7rem; opacity: 0.6; text-align: right; margin-top: 8px;">
                        {{ now()->format('d/m/Y') }}
                    </div>
                </div>
            </div>

            <div class="finance-card-stats">
                <div class="finance-stat">
                    <div class="finance-stat-label"><i class="fas fa-hourglass-half"></i> En séquestre</div>
                    @if($pendingBalance > 0)
                        <div class="finance-stat-value">{{ number_format($pendingBalance, 0, ',', ' ') }} <span style="font-size:0.75rem;font-weight:400;opacity:0.75;">FCFA</span></div>
                    @else
                        <div class="finance-stat-value muted">— FCFA</div>
                    @endif
                </div>
                <div class="finance-divider"></div>
                <div class="finance-stat">
                    <div class="finance-stat-label"><i class="fas fa-arrow-down"></i> Total disponible</div>
                    <div class="finance-stat-value" style="color: #86efac;">{{ number_format($availableBalance, 0, ',', ' ') }} <span style="font-size:0.75rem;font-weight:400;opacity:0.75;">FCFA</span></div>
                </div>
                <div class="finance-divider"></div>
                <div class="finance-stat">
                    <div class="finance-stat-label"><i class="fas fa-exchange-alt"></i> Transactions</div>
                    <div class="finance-stat-value">{{ $recentTransactions->total() }}</div>
                </div>
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
