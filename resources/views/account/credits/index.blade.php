@extends('layouts.app')

@section('title', 'Mes Crédits - Karnou')

@section('content')



    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">

            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mes Crédits</h1>
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
                .page-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 2rem;
                }
                .page-title {
                    font-size: 1.5rem;
                    font-weight: 800;
                    color: #111827;
                    margin: 0;
                    letter-spacing: -0.02em;
                }

                /* 💳 Balance Card - Premium Dark Glossy */
                .balance-card {
                    background: linear-gradient(135deg, #001f3f 0%, #004aad 100%);
                    border-radius: 24px;
                    padding: 40px;
                    color: #fff;
                    position: relative;
                    overflow: hidden;
                    margin-bottom: 3rem;
                    box-shadow: 0 20px 40px rgba(0, 74, 173, 0.15);
                    max-width: 900px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    min-height: 220px;
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
                    font-size: 3.5rem;
                    font-weight: 900;
                    letter-spacing: -0.03em;
                    display: flex;
                    align-items: center;
                    gap: 15px;
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
                    font-size: 1.1rem;
                    letter-spacing: 0.2em;
                    text-transform: uppercase;
                    opacity: 0.9;
                }
                .balance-card-brand {
                    font-size: 1.2rem;
                    font-weight: 900;
                    font-style: italic;
                    opacity: 0.5;
                }

                /* 📦 Pack Cards */
                .packs-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                    gap: 1.5rem;
                    margin-bottom: 4rem;
                }
                .pack-card {
                    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 20px;
                    padding: 2.2rem 2rem;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    position: relative;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                    color: #fff;
                }
                .pack-card::before {
                    content: '';
                    position: absolute;
                    top: -30px; right: -30px;
                    width: 100px; height: 100px;
                    background: rgba(255,255,255,0.03);
                    border-radius: 50%;
                }
                .pack-card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
                    border-color: rgba(255,215,0,0.3);
                }
                .pack-card.popular {
                    border: 2px solid #f68b1e;
                }
                .popular-badge {
                    position: absolute;
                    top: 0;
                    right: 0;
                    background: #f68b1e;
                    color: #fff;
                    padding: 5px 20px;
                    font-size: 0.75rem;
                    font-weight: 800;
                    border-bottom-left-radius: 12px;
                    z-index: 2;
                }
                .pack-icon {
                    width: 55px;
                    height: 55px;
                    background: rgba(255,255,255,0.05);
                    border-radius: 14px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 1.5rem;
                    color: #FFD700;
                    font-size: 1.4rem;
                    transition: all 0.3s;
                    border: 1px solid rgba(255,255,255,0.1);
                }
                .pack-card:hover .pack-icon {
                    background: #FFD700;
                    color: #000;
                    transform: scale(1.1) rotate(5deg);
                }
                .pack-name {
                    font-size: 0.8rem;
                    font-weight: 700;
                    color: rgba(255,255,255,0.5);
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    margin-bottom: 0.5rem;
                }
                .pack-credits {
                    font-size: 2.8rem;
                    font-weight: 900;
                    color: #fff;
                    margin-bottom: 0.25rem;
                    line-height: 1;
                    letter-spacing: -0.02em;
                }
                .pack-price {
                    font-size: 1.35rem;
                    font-weight: 800;
                    color: #FFD700;
                    margin-bottom: 1.5rem;
                }
                .pack-bonus {
                    background: rgba(255, 215, 0, 0.15);
                    color: #FFD700;
                    font-size: 0.75rem;
                    font-weight: 800;
                    padding: 6px 14px;
                    border-radius: 100px;
                    margin-bottom: 2.2rem;
                    border: 1px solid rgba(255, 215, 0, 0.2);
                }
                .btn-buy {
                    width: 100%;
                    padding: 0.9rem;
                    border-radius: 12px;
                    border: none;
                    background: #fff;
                    color: #111827;
                    font-weight: 800;
                    font-size: 0.9rem;
                    cursor: pointer;
                    transition: all 0.2s;
                }
                .btn-buy:hover {
                    background: #FFD700;
                    transform: scale(1.03);
                }

                /* 📝 Transactions List */
                .section-title {
                    font-size: 1.25rem;
                    font-weight: 800;
                    color: #111827;
                    margin-bottom: 1.5rem;
                }
                .tx-list {
                    background: #fff;
                    border: 1px solid #e5e7eb;
                    border-radius: 20px;
                    overflow: hidden;
                }
                .tx-item {
                    display: grid;
                    grid-template-columns: auto 1fr auto;
                    align-items: center;
                    padding: 1.25rem 2rem;
                    border-bottom: 1px solid #f3f4f6;
                    transition: background 0.2s;
                    gap: 1.5rem;
                }
                .tx-item:hover { background: #fafafa; }
                .tx-item:last-child { border-bottom: none; }
                
                .tx-icon {
                    width: 48px;
                    height: 48px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.2rem;
                }
                .tx-icon.in { background: #ecfdf5; color: #10b981; }
                .tx-icon.out { background: #fef2f2; color: #ef4444; }

                .tx-info {
                    display: flex;
                    flex-direction: column;
                }
                .tx-desc {
                    font-size: 0.95rem;
                    font-weight: 700;
                    color: #111827;
                    margin-bottom: 2px;
                }
                .tx-date {
                    font-size: 0.8rem;
                    color: #6b7280;
                }
                .tx-amount {
                    font-size: 1.1rem;
                    font-weight: 800;
                    text-align: right;
                }
                .tx-amount.plus { color: #10b981; }
                .tx-amount.minus { color: #ef4444; }

                @media (max-width: 768px) {
                    .balance-card { padding: 25px; min-height: 180px; }
                    .balance-card-value { font-size: 2.5rem; }
                    .tx-item { padding: 1rem; gap: 1rem; }
                }
            </style>

            <div class="page-header">
                <h1 class="page-title">Mes Crédits</h1>
            </div>

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
                    <div class="balance-card-holder">{{ Auth::user()->name ?? 'MEMBRE KARNOU' }}</div>
                    <div class="balance-card-brand">Karnou Pass</div>
                </div>
            </div>

            {{-- 📦 Forfaits disponibles --}}
            @if(isset($packs) && count($packs) > 0)
                <h2 class="section-title">Recharger mon compte</h2>
                <div class="packs-grid">
                    @foreach($packs as $pack)
                        @php
                            $isPopular = ($pack->nom === 'Pack 25 000' || ($pack->popular ?? false) || $pack->credits >= 100);
                        @endphp
                        <div class="pack-card {{ $isPopular ? 'popular' : '' }}">
                            @if($isPopular)
                                <div class="popular-badge">POPULAIRE</div>
                            @endif

                            <div class="pack-icon">
                                <i class="fas {{ $pack->credits > 50 ? 'fa-crown' : 'fa-coins' }}"></i>
                            </div>

                            <div class="pack-name">{{ $pack->nom ?? 'Forfait Crédits' }}</div>
                            <div class="pack-credits">{{ number_format($pack->credits, 0, ',', ' ') }} <small style="font-size: 0.9rem; vertical-align: middle;">CR</small></div>
                            <div class="pack-price">{{ number_format($pack->prix, 0, ',', ' ') }} FCFA</div>

                            @if($pack->bonus_credits > 0)
                                <div class="pack-bonus">+ {{ number_format($pack->bonus_credits, 0, ',', ' ') }} offerts</div>
                            @else
                                <div style="margin-bottom: 3.5rem;"></div>
                            @endif

                            <form action="{{ route('account.credits.checkout') }}" method="POST" onsubmit="return confirm('Confirmer l\'achat de ce forfait pour {{ number_format($pack->prix, 0, ',', ' ') }} FCFA ?')" style="width: 100%;">
                                @csrf
                                <input type="hidden" name="pack_id" value="{{ $pack->id }}">
                                <button type="submit" class="btn-buy">
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
