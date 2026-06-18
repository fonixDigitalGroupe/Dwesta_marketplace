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
                .premium-credits-card {
                    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                    border-radius: 16px;
                    padding: 30px;
                    color: #fff;
                    position: relative;
                    overflow: hidden;
                    margin-bottom: 2.5rem;
                    box-shadow: none;
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end;
                    min-height: 180px;
                    max-width: 800px;
                }
                .premium-credits-card::before {
                    content: '';
                    position: absolute;
                    top: -40px; right: -40px;
                    width: 150px; height: 150px;
                    background: rgba(255,255,255,0.04);
                    border-radius: 50%;
                }
                .premium-credits-card::after {
                    content: '';
                    position: absolute;
                    bottom: -50px; left: -20px;
                    width: 180px; height: 180px;
                    background: rgba(255,255,255,0.03);
                    border-radius: 50%;
                }
                .card-tag {
                    position: absolute;
                    top: 24px;
                    right: 30px;
                    font-size: 14px;
                    font-weight: 900;
                    color: rgba(255,255,255,0.2);
                    letter-spacing: 1px;
                }
                .credits-label {
                    font-size: 10px;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: 1.5px;
                    color: rgba(255,255,255,0.55);
                    margin-bottom: 8px;
                }
                .credits-amount {
                    font-size: 2.8rem;
                    font-weight: 900;
                    line-height: 1;
                    display: flex;
                    align-items: baseline;
                    gap: 8px;
                }
                .credits-amount small {
                    font-size: 1.1rem;
                    font-weight: 700;
                    color: rgba(255,255,255,0.6);
                }
                .card-holder {
                    font-size: 12px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    color: rgba(255,255,255,0.8);
                    margin-top: 15px;
                }
            </style>

            <div class="premium-credits-card">
                <div class="card-tag">CREDITPASS</div>
                <div style="position: relative; z-index: 2;">
                    <div class="credits-label">Crédits disponibles</div>
                    <div class="credits-amount">
                        {{ number_format($balance, 0, ',', ' ') }}
                        <small>CRÉDITS</small>
                    </div>
                    <div class="card-holder">{{ Auth::user()->name ?? 'MEMBRE KARNOU' }}</div>
                </div>
                
                <div style="position: relative; z-index: 2; margin-bottom: 10px;">
                    <i class="fas fa-coins" style="font-size: 2.5rem; color: rgba(255,215,0,0.4);"></i>
                </div>
            </div>

            {{-- Forfaits disponibles --}}
            @if(isset($packs) && count($packs) > 0)
            <div style="margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Acheter des crédits</h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
                    @foreach($packs as $pack)
                        @php
                            $isPremium = ($pack->credits == 100 && $pack->prix == 9000);
                            $isPopular = ($pack->nom ?? $pack->label ?? '') === 'Pack 25 000' || ($pack->popular ?? false) || $isPremium;
                        @endphp
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border: 1px solid {{ $isPopular ? '#EF3B2D' : '#dee2e6' }}; position: relative; display: flex; flex-direction: column; justify-content: space-between;">

                            @if($isPopular)
                                <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #f68b1e; color: white; padding: 0.2rem 0.9rem; border-radius: 20px; font-size: 0.72rem; font-weight: bold; white-space: nowrap; z-index: 1;">
                                    POPULAIRE
                                </div>
                            @endif

                            <div style="text-align: center; margin-bottom: 0.75rem;">
                                <h3 style="color: #666; margin-top: 0; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ $pack->nom ?? 'Forfait Crédits' }}
                                </h3>

                                <div style="font-size: 1.85rem; font-weight: 800; color: #333; margin-bottom: 0.15rem;">
                                    {{ number_format($pack->credits, 0, ',', ' ') }} <small style="font-size: 0.8rem; font-weight: 600; opacity: 0.7;">CRÉDITS</small>
                                </div>

                                <div style="font-size: 1rem; font-weight: 700; color: #333; margin-bottom: 0.5rem;">
                                    {{ number_format($pack->prix, 0, ',', ' ') }} FCFA
                                </div>

                                    <div style="display: inline-block; color: #000; padding: 0.2rem 0; font-size: 0.7rem; font-weight: 800; margin-top: 4px;">
                                        + {{ number_format($pack->bonus_credits ?? 0, 0, ',', ' ') }} CRÉDITS OFFERTS
                                    </div>
                            </div>

                            <form action="{{ route('account.credits.checkout') }}" method="POST" onsubmit="return confirm('Confirmer l\'achat de ce forfait pour {{ number_format($pack->prix, 0, ',', ' ') }} FCFA ?')">
                                @csrf
                                <input type="hidden" name="pack_id" value="{{ $pack->id }}">

                                <button type="submit"
                                    style="display: block; width: 100%; text-align: center; background: {{ ($loop->first || $loop->last) ? '#004aad' : '#f68b1e' }}; color: white; padding: 0.6rem; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 700; transition: background 0.2s;">
                                    Acheter
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Historique des transactions --}}
            @if(isset($transactions))
            <div style="margin-top: 1rem;">
                <h2 style="color: #333; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Historique des transactions</h2>

                @if($transactions->count() > 0)
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                        {{-- Header --}}
                        <div style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 0.85rem 1rem; background: #f8f9fa; font-weight: 700; font-size: 0.8rem; color: #888; border-bottom: 1px solid #dee2e6; text-transform: uppercase;">
                            <div>Date</div>
                            <div>Description</div>
                            <div style="text-align: center;">État</div>
                            <div style="text-align: right;">Crédits</div>
                        </div>
                        {{-- Rows --}}
                        @foreach($transactions as $transaction)
                            <div style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 1rem; border-bottom: 1px solid #f0f0f0; align-items: center;">
                                <div style="font-size: 0.85rem; color: #777;">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                <div style="font-size: 0.9rem; color: #444; font-weight: 500;">{{ $transaction->description }}</div>
                                <div style="text-align: center;">
                                    @php $type = $transaction->type ?? ($transaction->montant > 0 ? 'positif' : 'negatif'); @endphp
                                    @if($transaction->montant > 0)
                                        <span style="background: #e8f5e9; color: #2e7d32; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Entrée</span>
                                    @else
                                        <span style="background: #fff1f2; color: #be123c; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Sortie</span>
                                    @endif
                                </div>
                                <div style="text-align: right; font-weight: 700; color: {{ $transaction->montant > 0 ? '#2e7d32' : '#be123c' }}; font-size: 0.95rem;">
                                    {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant, 0, ',', ' ') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($transactions->hasPages())
                        <div style="margin-top: 1.5rem;">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                @else
                    <div style="padding: 3rem; text-align: center; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6;">
                        <i class="fas fa-history" style="display:block; font-size: 2rem; color: #ddd; margin-bottom: 1rem;"></i>
                        <p style="color: #999; margin: 0; font-size: 0.9rem;">Aucune transaction enregistrée pour le moment.</p>
                    </div>
                @endif
            </div>
            @endif

        </main>
    </div>

@endsection
