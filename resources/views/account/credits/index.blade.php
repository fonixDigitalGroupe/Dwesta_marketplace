@extends('layouts.app')

@section('title', 'Mes Crédits - Karnou')

@section('content')

    <style>
        @keyframes lightSweep {
            0% { transform: translateX(-200%) skewX(-25deg); }
            100% { transform: translateX(200%) skewX(-25deg); }
        }
        .card-shimmer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(105deg, 
                transparent 0%, 
                rgba(255,255,255,0.05) 45%, 
                rgba(255,255,255,0.15) 50%, 
                rgba(255,255,255,0.05) 55%, 
                transparent 100%
            );
            animation: lightSweep 4s infinite linear;
            pointer-events: none;
            z-index: 1;
        }
    </style>

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

            {{-- Solde actuel - Carte de Crédit Professionnelle --}}
            <div style="background: linear-gradient(135deg, #004aad 0%, #002a6b 100%); padding: 2.2rem; border-radius: 24px; margin-bottom: 2.5rem; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 25px 50px -12px rgba(0, 74, 173, 0.25); position: relative; overflow: hidden; color: white; max-width: 1000px; display: flex; align-items: stretch; gap: 0; isolation: isolate;">
                
                {{-- Shimmer Effect --}}
                <div class="card-shimmer"></div>

                {{-- Left Side: The Card --}}
                <div style="flex: 1.2; position: relative; padding-right: 2rem; display: flex; flex-direction: column; justify-content: space-between; min-height: 220px; z-index: 2;">
                    {{-- Card Header: Chip and Brand --}}
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        {{-- Realistic Gold EMV Chip --}}
                        <div style="width: 50px; height: 38px; background: linear-gradient(135deg, #ffd700 0%, #e6b800 50%, #b8860b 100%); border-radius: 7px; position: relative; box-shadow: inset 0 1px 2px rgba(255,255,255,0.8), 0 3px 6px rgba(0,0,0,0.3); overflow: hidden; border: 0.5px solid rgba(0,0,0,0.1);">
                            <div style="position: absolute; top: 20%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.15);"></div>
                            <div style="position: absolute; top: 40%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.15);"></div>
                            <div style="position: absolute; top: 60%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.15);"></div>
                            <div style="position: absolute; top: 80%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.15);"></div>
                            <div style="position: absolute; top: 0; bottom: 0; left: 30%; width: 1px; background: rgba(0,0,0,0.15);"></div>
                            <div style="position: absolute; top: 0; bottom: 0; left: 70%; width: 1px; background: rgba(0,0,0,0.15);"></div>
                            <div style="position: absolute; top: 25%; left: 25%; right: 25%; bottom: 25%; border: 1px solid rgba(0,0,0,0.1); border-radius: 3px; background: rgba(255,215,0,0.1);"></div>
                        </div>
                        <div style="font-weight: 800; font-size: 1rem; letter-spacing: 2px; text-transform: uppercase; opacity: 0.95; display: flex; align-items: center; gap: 8px;">
                            <span style="background: white; color: #004aad; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: 900;">KARNOU</span>
                            <span style="font-weight: 200; font-size: 0.9rem; letter-spacing: 4px;">PREMIUM</span>
                        </div>
                    </div>

                    {{-- Card Center: Balance --}}
                    <div style="margin: 1.5rem 0;">
                        <div style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 3px; opacity: 0.7; margin-bottom: 0.5rem; font-weight: 600;">SOLDE DISPONIBLE</div>
                        <div style="display: flex; align-items: baseline; gap: 12px;">
                            <span style="font-size: 3.5rem; font-weight: 900; line-height: 1; letter-spacing: -1px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); text-shadow: 0 2px 10px rgba(0,0,0,0.1);">{{ number_format($balance, 0, ',', ' ') }}</span>
                            <i class="fas fa-star" style="color: #ffd700; font-size: 1.8rem; filter: drop-shadow(0 0 12px rgba(255,215,0,0.5));"></i>
                        </div>
                    </div>

                    {{-- Card Footer: Number and Name --}}
                    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                        <div>
                            <div style="font-family: 'Courier New', Courier, monospace; font-size: 1.35rem; letter-spacing: 3px; margin-bottom: 0.6rem; opacity: 0.95; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                **** **** **** {{ sprintf('%04d', Auth::user()->id ?? 0) }}
                            </div>
                            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9; font-weight: 700;">
                                {{ Auth::user()->name ?? 'MEMBRE KARNOU' }}
                            </div>
                        </div>
                        <div style="opacity: 0.8; transform: translateY(5px);">
                            <svg width="60" height="40" viewBox="0 0 400 248" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="150" cy="124" r="100" fill="#EB001B" fill-opacity="0.8"/>
                                <circle cx="250" cy="124" r="100" fill="#F79E1B" fill-opacity="0.8"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Vertical Divider --}}
                <div style="width: 1px; background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.2), transparent); margin: 0 1.5rem;"></div>

                {{-- Right Side: Benefits --}}
                <div style="flex: 0.8; padding-left: 0.5rem; display: flex; flex-direction: column; justify-content: center; z-index: 2;">
                    <h3 style="color: white; margin-top: 0; margin-bottom: 1.5rem; font-size: 0.85rem; font-weight: 800; opacity: 0.95; letter-spacing: 1.5px; border-left: 3px solid #ffd700; padding-left: 10px;">
                        PRIVILÈGES
                    </h3>
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.85rem; font-size: 0.85rem; color: rgba(255,255,255,0.9);">
                            <div style="width: 24px; height: 24px; background: rgba(16, 185, 129, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-rocket" style="color: #10b981; font-size: 0.75rem;"></i>
                            </div>
                            <span style="font-weight: 500;">Boost Boosters Illimité</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.85rem; font-size: 0.85rem; color: rgba(255,255,255,0.9);">
                            <div style="width: 24px; height: 24px; background: rgba(59, 130, 246, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-crown" style="color: #3b82f6; font-size: 0.75rem;"></i>
                            </div>
                            <span style="font-weight: 500;">Badge Premium Vérifié</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.85rem; font-size: 0.85rem; color: rgba(255,255,255,0.9);">
                            <div style="width: 24px; height: 24px; background: rgba(245, 158, 11, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-bolt" style="color: #f59e0b; font-size: 0.75rem;"></i>
                            </div>
                            <span style="font-weight: 500;">Support Client Prioritaire</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Forfaits disponibles --}}
            @if(isset($packs) && count($packs) > 0)
            <div style="margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Acheter des crédits</h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
                    @foreach($packs as $pack)
                        @php
                            $isPopular = ($pack->nom ?? $pack->label ?? '') === 'Pack 25 000' || ($pack->popular ?? false);
                        @endphp
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border: 1px solid {{ $isPopular ? '#EF3B2D' : '#dee2e6' }}; position: relative; display: flex; flex-direction: column; justify-content: space-between;">

                            @if($isPopular)
                                <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #f68b1e; color: white; padding: 0.2rem 0.9rem; border-radius: 20px; font-size: 0.72rem; font-weight: bold; white-space: nowrap; z-index: 1;">
                                    POPULAIRE
                                </div>
                            @endif

                            <div style="text-align: center; margin-bottom: 1rem;">
                                <h3 style="color: #666; margin-top: 0; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ $pack->nom ?? 'Forfait Crédits' }}
                                </h3>

                                <div style="font-size: 1.75rem; font-weight: 800; color: #333; margin-bottom: 0.25rem;">
                                    {{ number_format($pack->credits, 0, ',', ' ') }} <small style="font-size: 0.8rem; font-weight: 600; opacity: 0.7;">CRÉDITS</small>
                                </div>

                                <div style="font-size: 1rem; font-weight: 700; color: #333; margin-bottom: 0.5rem;">
                                    {{ number_format($pack->prix, 0, ',', ' ') }} FCFA
                                </div>

                                @if(($pack->bonus_credits ?? 0) > 0)
                                    <div style="display: inline-block; background: #dcfce7; color: #166534; padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.75rem; font-weight: 800; margin-top: 5px;">
                                        + {{ number_format($pack->bonus_credits, 0, ',', ' ') }} CRÉDITS OFFERTS
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('account.credits.checkout') }}" method="POST" onsubmit="return confirm('Confirmer l\'achat de ce forfait pour {{ number_format($pack->prix, 0, ',', ' ') }} FCFA ?')">
                                @csrf
                                <input type="hidden" name="pack_id" value="{{ $pack->id }}">

                                <button type="submit"
                                    style="display: block; width: 100%; text-align: center; background: {{ ($loop->first || $loop->last) ? '#004aad' : '#f68b1e' }}; color: white; padding: 0.7rem; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 700; transition: background 0.2s;">
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
