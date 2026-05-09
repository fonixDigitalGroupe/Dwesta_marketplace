@extends('layouts.app')

@section('title', 'Mes Crédits - Dwesta')

@push('styles')
<style>
    /* ===== LAYOUT ===== */
    .credits-page { display: flex; flex-direction: column; gap: 1.25rem; }

    /* ===== BALANCE HERO ===== */
    .balance-hero {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .balance-hero-header {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .balance-hero-header h2 {
        font-size: 0.85rem;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        margin: 0;
    }
    .balance-hero-body {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    .balance-amount {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }
    .balance-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #004aad;
        line-height: 1;
    }
    .balance-unit {
        font-size: 1rem;
        font-weight: 600;
        color: #64748b;
    }
    .balance-divider {
        width: 1px;
        height: 50px;
        background: #e0e0e0;
    }
    .balance-info-item {
        display: flex;
        flex-direction: column;
    }
    .balance-info-label {
        font-size: 0.72rem;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 3px;
    }
    .balance-info-value {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a1a;
    }
    .balance-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #dcfce7;
        color: #15803d;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .balance-status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #15803d;
    }

    /* ===== PACKS SECTION ===== */
    .section-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .section-card-header {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .section-card-header h2 {
        font-size: 0.85rem;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        margin: 0;
    }
    .section-card-body { padding: 1.25rem; }

    .packs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
    }
    .pack-card {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        padding: 1.25rem;
        position: relative;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }
    .pack-card:hover {
        border-color: #004aad;
        box-shadow: 0 4px 12px rgba(0,74,173,0.08);
    }
    .pack-card.popular {
        border-color: #004aad;
        background: #fafcff;
    }
    .pack-popular-badge {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: #004aad;
        color: #fff;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }
    .pack-name {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }
    .pack-credits-amount {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1a1a1a;
        line-height: 1;
        margin-bottom: 2px;
    }
    .pack-credits-label {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 0.75rem;
    }
    .pack-bonus {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fef9c3;
        color: #854d0e;
        padding: 3px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }
    .pack-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 1rem;
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f0f0;
    }
    .pack-buy-btn {
        display: block;
        width: 100%;
        text-align: center;
        background: #004aad;
        color: #fff;
        padding: 0.6rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 700;
        transition: background 0.2s;
        text-decoration: none;
    }
    .pack-buy-btn:hover { background: #003a8a; }
    .pack-card.popular .pack-buy-btn {
        background: #004aad;
        box-shadow: 0 4px 12px rgba(0,74,173,0.25);
    }

    /* ===== TRANSACTIONS ===== */
    .transactions-table {
        width: 100%;
        border-collapse: collapse;
    }
    .transactions-table th {
        padding: 0.6rem 1rem;
        background: #f8f9fa;
        font-size: 0.75rem;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: 1px solid #e0e0e0;
        text-align: left;
    }
    .transactions-table td {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: #333;
        border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }
    .transactions-table tr:last-child td { border-bottom: none; }
    .transactions-table tr:hover td { background: #fafafa; }
    .txn-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .txn-badge.credit { background: #dcfce7; color: #15803d; }
    .txn-badge.debit  { background: #fee2e2; color: #dc2626; }
    .txn-amount { font-weight: 700; font-size: 0.95rem; }
    .txn-amount.positive { color: #15803d; }
    .txn-amount.negative { color: #dc2626; }

    /* ===== EMPTY ===== */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #94a3b8;
    }
    .empty-state i { font-size: 2.5rem; margin-bottom: 1rem; display: block; }
    .empty-state p { font-size: 0.9rem; }

    /* ===== ALERTS ===== */
    .alert { padding: 0.75rem 1rem; border-radius: 4px; font-size: 0.9rem; margin-bottom: 1rem; border: 1px solid; }
    .alert-success { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
    .alert-error   { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
</style>
@endpush

@section('content')
<nav class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a> &gt;
    <a href="{{ route('account.index') }}">Mon compte</a> &gt;
    <span>Mes Crédits</span>
</nav>

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content" style="padding: 0;">
        <div class="credits-page">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle" style="margin-right:8px;"></i>{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error"><i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>{{ session('error') }}</div>
            @endif

            {{-- ===== SOLDE ===== --}}
            <div class="balance-hero">
                <div class="balance-hero-header">
                    <h2>Mon Portefeuille de Crédits</h2>
                    <span class="balance-status-badge">Actif</span>
                </div>
                <div class="balance-hero-body">
                    <div class="balance-amount">
                        <span class="balance-number">{{ number_format($balance, 0, ',', ' ') }}</span>
                        <span class="balance-unit">DA</span>
                    </div>
                    <div class="balance-divider"></div>
                    <div class="balance-info-item">
                        <span class="balance-info-label">Solde disponible</span>
                        <span class="balance-info-value">{{ number_format($balance, 0, ',', ' ') }} DA</span>
                    </div>
                    <div class="balance-divider"></div>
                    <div class="balance-info-item">
                        <span class="balance-info-label">Dernière recharge</span>
                        @php
                            $lastCredit = $transactions->where('montant', '>', 0)->first();
                        @endphp
                        <span class="balance-info-value">
                            {{ $lastCredit ? $lastCredit->created_at->format('d/m/Y') : '—' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ===== PACKS ===== --}}
            <div class="section-card">
                <div class="section-card-header">
                    <h2>Recharger mes crédits</h2>
                </div>
                <div class="section-card-body">
                    @if(isset($packs) && $packs->count() > 0)
                        <div class="packs-grid">
                            @foreach($packs as $pack)
                                @php
                                    $isPopular = ($pack->nom ?? $pack->label ?? '') === 'Pack 25 000' || ($pack->popular ?? false);
                                @endphp
                                <div class="pack-card {{ $isPopular ? 'popular' : '' }}">
                                    @if($isPopular)
                                        <div class="pack-popular-badge">✦ LE PLUS POPULAIRE</div>
                                    @endif

                                    <div class="pack-name">{{ $pack->nom ?? $pack->label ?? 'Pack' }}</div>

                                    <div class="pack-credits-amount">{{ number_format($pack->credits, 0, ',', ' ') }}</div>
                                    <div class="pack-credits-label">crédits</div>

                                    @if(($pack->bonus_credits ?? 0) > 0)
                                        <div class="pack-bonus">
                                            <i class="fas fa-gift" style="font-size:0.7rem;"></i>
                                            +{{ number_format($pack->bonus_credits, 0, ',', ' ') }} offerts
                                        </div>
                                    @endif

                                    <div class="pack-price">{{ number_format($pack->prix, 0, ',', ' ') }} DA</div>

                                    <form action="{{ route('credits.buy') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="pack_id" value="{{ $pack->id }}">
                                        <button type="submit" class="pack-buy-btn">Acheter</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <p style="margin-top: 1rem; font-size: 0.78rem; color: #94a3b8; text-align: center;">
                            <i class="fas fa-lock" style="margin-right:4px;"></i>
                            Paiement sécurisé · Les crédits sont crédités instantanément après confirmation.
                        </p>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-coins"></i>
                            <p>Aucun forfait disponible pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===== HISTORIQUE ===== --}}
            <div class="section-card">
                <div class="section-card-header">
                    <h2>Historique des transactions</h2>
                </div>
                <div style="overflow-x: auto;">
                    @if($transactions->count() > 0)
                        <table class="transactions-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th style="text-align: right;">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td style="color: #64748b; font-size: 0.8rem; white-space: nowrap;">
                                            {{ $transaction->created_at->format('d/m/Y') }}<br>
                                            <span style="font-size: 0.72rem; color: #94a3b8;">{{ $transaction->created_at->format('H:i') }}</span>
                                        </td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>
                                            @if(in_array($transaction->type, ['achat', 'bonus', 'remboursement']))
                                                <span class="txn-badge credit">
                                                    <i class="fas fa-arrow-down" style="font-size:0.6rem;"></i>
                                                    {{ ucfirst($transaction->type) }}
                                                </span>
                                            @else
                                                <span class="txn-badge debit">
                                                    <i class="fas fa-arrow-up" style="font-size:0.6rem;"></i>
                                                    Dépense
                                                </span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            <span class="txn-amount {{ $transaction->montant > 0 ? 'positive' : 'negative' }}">
                                                {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant, 0, ',', ' ') }} DA
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div style="padding: 1rem; border-top: 1px solid #f0f0f0;">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-receipt"></i>
                            <p>Aucune transaction pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>
</div>
@endsection
