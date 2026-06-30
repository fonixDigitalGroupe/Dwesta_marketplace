@extends('layouts.app')

@section('title', 'Mes Crédits - Karnou')

@section('content')



    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="account-header">
                <h1>Mes Crédits</h1>
            </div>



            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Premium Credits Card --}}
            <style>
                .main-content {
                    background: #fdfdfd;
                    min-height: 100vh;
                    padding: 2rem !important;
                }
                .account-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding-bottom: 0.5rem;
                    margin-bottom: 1.5rem;
                    border-bottom: 1px solid #eee;
                }
                .account-header h1 {
                    font-size: 1.1rem;
                    font-weight: 600;
                    color: #333;
                    margin: 0;
                }

                /* 💳 Balance Card - Premium Dark Glossy */
                .balance-card {
                    background: linear-gradient(135deg, #001f3f 0%, #004aad 100%);
                    border-radius: 12px;
                    padding: 24px 32px;
                    color: #fff;
                    position: relative;
                    overflow: hidden;
                    margin-bottom: 2.5rem;
                    box-shadow: none;
                    border: 1px solid rgba(255,255,255,0.1);
                    width: 100%;
                    max-width: 450px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    min-height: 160px;
                }
                .balance-card::before {
                    content: '';
                    position: absolute;
                    top: -100px; right: -100px;
                    width: 300px; height: 300px;
                    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
                    pointer-events: none;
                }
                .balance-card-chip {
                    width: 50px;
                    height: 40px;
                    background: linear-gradient(135deg, #ffd700 0%, #ffae00 100%);
                    border-radius: 8px;
                    margin-bottom: 20px;
                    position: relative;
                    box-shadow: inset 0 1px 1px rgba(255,255,255,0.5);
                }
                .balance-card-chip::after {
                    content: '';
                    position: absolute;
                    top: 50%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.1);
                }
                .balance-card-label {
                    font-size: 0.75rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    opacity: 0.7;
                    margin-bottom: 5px;
                }
                .balance-card-value {
                    font-size: 2.8rem;
                    font-weight: 900;
                    letter-spacing: -0.03em;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }
                .balance-card-unit {
                    font-size: 1rem;
                    font-weight: 700;
                    background: rgba(255,255,255,0.15);
                    padding: 4px 12px;
                    border-radius: 100px;
                    backdrop-filter: blur(4px);
                }
                .balance-card-footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end;
                    margin-top: auto;
                }
                .balance-card-holder {
                    font-family: 'Courier New', Courier, monospace;
                    font-size: 0.85rem;
                    letter-spacing: 0.1em;
                    text-transform: uppercase;
                    opacity: 0.9;
                }
                .balance-card-brand {
                    font-size: 0.95rem;
                    font-weight: 900;
                    font-style: italic;
                    opacity: 0.7;
                }

                /* 📦 Pack Cards */
                .packs-grid {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 1rem;
                    margin-bottom: 3rem;
                    max-width: 800px;
                }
                .pack-card {
                    background: linear-gradient(135deg, #f9b572 0%, #f79d5c 50%, #f4845f 100%);
                    border-radius: 16px;
                    padding: 20px 22px;
                    color: #fff;
                    position: relative;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    min-height: 180px;
                    box-shadow: 0 2px 8px rgba(244, 132, 95, 0.15);
                    text-align: left;
                }
                .pack-card::after {
                    content: '\f51e'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
                    position: absolute; bottom: -18px; right: -6px; font-size: 76px;
                    color: rgba(255,255,255,0.12); transform: rotate(-12deg); pointer-events: none;
                }
                .pack-brand {
                    position: absolute;
                    top: 15px;
                    right: 18px;
                    font-size: 12px;
                    font-weight: 900;
                    color: rgba(255,255,255,0.7);
                    letter-spacing: 0.5px;
                }
                .pack-label {
                    font-size: 9px;
                    color: rgba(255,255,255,0.8);
                    letter-spacing: 1.2px;
                    text-transform: uppercase;
                    margin-bottom: 4px;
                    font-weight: 700;
                }
                .pack-value-large {
                    font-size: 24px;
                    font-weight: 800;
                    color: #fff;
                    margin: 2px 0 10px 0;
                    line-height: 1;
                }
                .pack-price-gold {
                    display: inline-block;
                    align-self: flex-start;
                    font-size: 14px;
                    font-weight: 800;
                    color: #b4530a;
                    background: rgba(255,255,255,0.92);
                    padding: 6px 12px;
                    border-radius: 8px;
                    margin-top: auto;
                }
                .pack-bonus-badge {
                    display: inline-block;
                    padding: 3px 10px;
                    border-radius: 20px;
                    font-size: 9px;
                    font-weight: 700;
                    margin-top: 8px;
                    background: rgba(255,255,255,0.92);
                    color: #b4530a;
                }
                .btn-buy-card {
                    margin-top: 12px;
                    width: 100%;
                    padding: 0.7rem;
                    border-radius: 10px;
                    border: none;
                    background: rgba(255,255,255,0.92);
                    color: #b4530a;
                    font-weight: 800;
                    font-size: 0.82rem;
                    cursor: pointer;
                    transition: all 0.2s;
                    position: relative;
                    z-index: 5;
                }
                .btn-buy-card:hover {
                    background: #fff;
                    color: #9a4308;
                }

                /* 📝 Transactions List */
                .section-title {
                    font-size: 0.85rem;
                    font-weight: 600;
                    color: #333;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    margin-bottom: 1.25rem;
                }
                .tx-list {
                    background: #fff;
                    border: 1px solid #f0f0f0;
                    border-radius: 12px;
                    overflow: hidden;
                }
                .tx-item {
                    display: grid;
                    grid-template-columns: auto 1fr auto;
                    align-items: center;
                    padding: 0.9rem 1.5rem;
                    border-bottom: 1px solid #f8f8f8;
                    transition: background 0.2s;
                    gap: 1.2rem;
                }
                .tx-item:hover { background: #fcfcfc; }
                .tx-item:last-child { border-bottom: none; }
                
                .tx-icon {
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 0.9rem;
                }
                .tx-icon.in { background: #f0fdf4; color: #16a34a; }
                .tx-icon.out { background: #fef2f2; color: #dc2626; }

                .tx-info {
                    display: flex;
                    flex-direction: column;
                }
                .tx-desc {
                    font-size: 0.9rem;
                    font-weight: 600;
                    color: #1f2937;
                    margin-bottom: 1px;
                }
                .tx-date {
                    font-size: 0.75rem;
                    color: #9ca3af;
                }
                .tx-amount {
                    font-size: 0.95rem;
                    font-weight: 700;
                    text-align: right;
                }
                .tx-amount.plus { color: #059669; }
                .tx-amount.minus { color: #111827; }

                @media (max-width: 991px) {
                    .packs-grid { grid-template-columns: repeat(2, 1fr); }
                }
                @media (max-width: 768px) {
                    .main-content { padding: 0.75rem !important; min-height: 0; }
                    .balance-card { padding: 25px; min-height: 180px; max-width: 100%; }
                    .balance-card-value { font-size: 2.3rem; }
                    .packs-grid { grid-template-columns: repeat(2, 1fr); max-width: 100%; gap: 0.6rem; }
                    .pack-card { padding: 14px; min-height: 150px; }
                    .pack-value-large { font-size: 15px; }
                    .pack-price-gold { font-size: 16px; }
                    .tx-item { padding: 0.85rem 1rem; gap: 0.75rem; }
                    .tx-info { min-width: 0; }
                    .tx-desc, .tx-date { overflow-wrap: anywhere; word-break: break-word; }
                    .tx-date { font-size: 0.7rem; }
                    .tx-amount { font-size: 0.85rem; }
                }
                @media (max-width: 400px) {
                    .packs-grid { grid-template-columns: 1fr; }
                }
            </style>



            @if(session('success'))
                <div style="background: #ecfdf5; color: #065f46; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; border-left: 5px solid #10b981; font-weight: 500;">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
                </div>
            @endif

            {{-- 💳 Balance Card --}}
            <div class="balance-card">
                <div class="balance-card-chip"></div>
                <div>
                    <div class="balance-card-label">Crédits disponibles</div>
                    <div class="balance-card-value">
                        {{ number_format($balance, 0, ',', ' ') }}
                        <span class="balance-card-unit">CRÉDITS</span>
                    </div>
                </div>
                
                <div class="balance-card-footer">
                    <div class="balance-card-holder">{{ Auth::user()->name ?? 'Landing savane Diallo' }}</div>
                    <div class="balance-card-brand">Karnou Pass</div>
                </div>
            </div>

            {{-- 📦 Forfaits disponibles --}}
            @if(isset($packs) && count($packs) > 0)
                <h2 class="section-title">Recharger mon compte</h2>
                <div class="packs-grid">
                    @foreach($packs as $pack)
                        <div class="pack-card">
                            <div class="pack-brand">KARNOU</div>
                            
                            <div class="pack-label">Type de forfait</div>
                            <div style="font-size: 13px; font-weight: 700; margin-bottom: 8px; color: rgba(255,255,255,0.9);">
                                {{ $pack->nom ?? 'Forfait Crédits' }}
                            </div>

                            <div class="pack-label">Valeur en crédits</div>
                            <div class="pack-value-large">{{ number_format($pack->credits, 0, ',', ' ') }} CR</div>

                            <div class="pack-price-gold">{{ number_format($pack->prix, 0, ',', ' ') }} FCFA</div>

                            @if($pack->bonus_credits > 0 || (isset($pack->nom) && strtolower($pack->nom) == 'starter'))
                                <div>
                                    <span class="pack-bonus-badge">+ {{ number_format($pack->bonus_credits ?? 0, 0, ',', ' ') }} CR OFFERTS</span>
                                </div>
                            @endif

                            <form action="{{ route('account.credits.checkout') }}" method="POST" style="width: 100%;">
                                @csrf
                                <input type="hidden" name="pack_id" value="{{ $pack->id }}">
                                <button type="submit" class="btn-buy-card">
                                    Prendre ce pack
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- 📝 Historique des transactions --}}
            @if(isset($transactions))
                <h2 class="section-title">Historique des utilisations</h2>

                @if($transactions->count() > 0)
                    <div class="tx-list">
                        @foreach($transactions as $transaction)
                            @php 
                                $isPositive = $transaction->montant > 0;
                            @endphp
                            <div class="tx-item">
                                <div class="tx-icon {{ $isPositive ? 'in' : 'out' }}">
                                    <i class="fas {{ $isPositive ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                                </div>
                                <div class="tx-info">
                                    <div class="tx-desc">{{ $transaction->description }}</div>
                                    <div class="tx-date">{{ $transaction->created_at->format('d M Y à H:i') }}</div>
                                </div>
                                <div class="tx-amount {{ $isPositive ? 'plus' : 'minus' }}">
                                    {{ $isPositive ? '+' : '' }}{{ number_format($transaction->montant, 0, ',', ' ') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($transactions->hasPages())
                        <div style="margin-top: 2rem; display: flex; justify-content: center;">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                @else
                    <div style="padding: 4rem 2rem; text-align: center; background: #fff; border: 1px solid #e5e7eb; border-radius: 20px;">
                        <i class="fas fa-history" style="font-size: 3rem; color: #e5e7eb; margin-bottom: 1.5rem; display: block;"></i>
                        <p style="color: #9ca3af; margin: 0; font-size: 0.95rem;">Aucune transaction enregistrée pour le moment.</p>
                    </div>
                @endif
            @endif

        </main>
    </div>

@endsection
