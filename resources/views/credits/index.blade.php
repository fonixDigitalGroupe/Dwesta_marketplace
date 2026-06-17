@extends('layouts.app')

@section('title', 'Mes Crédits - Karnou')

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">

            <div
                style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mes Crédits</h1>
            </div>

            @if(session('success'))
                <div
                    style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div
                    style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Solde actuel - Carte Finance --}}
            <div
                style="background: linear-gradient(135deg, #004aad 0%, #003685 100%); padding: 2.5rem; border-radius: 20px; margin-bottom: 2.5rem; border: none; box-shadow: 0 15px 35px rgba(0,74,173,0.25); position: relative; overflow: hidden; color: white;">
                {{-- Effet de carte (cercle décoratif) --}}
                <div
                    style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%;">
                </div>
                <div
                    style="position: absolute; bottom: -30px; left: -30px; width: 120px; height: 120px; background: rgba(255,255,255,0.03); border-radius: 50%;">
                </div>

                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 2.5rem; position: relative; z-index: 1;">
                    {{-- Balance Card --}}
                    <div style="flex: 1; min-width: 250px;">
                        <div
                            style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem; opacity: 0.8; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;">
                            <i class="fas fa-wallet"></i> Solde actuel
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <div
                                style="font-size: 3.5rem; font-weight: 900; line-height: 1; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 15px;">
                                {{ number_format($balance, 0, ',', ' ') }}
                                <i class="fas fa-star"
                                    style="font-size: 2rem; color: #ffbe00; filter: drop-shadow(0 0 10px rgba(255, 190, 0, 0.5));"></i>
                            </div>
                            <div style="font-size: 0.9rem; font-weight: 500; opacity: 0.9; letter-spacing: 0.5px;">VOS
                                CRÉDITS DISPONIBLES</div>
                        </div>

                        <div
                            style="font-family: 'Courier New', monospace; font-size: 1.1rem; letter-spacing: 3px; opacity: 0.6; margin-top: 2rem;">
                            **** **** **** {{ sprintf('%04d', Auth::user()->id ?? 0) }}
                        </div>
                    </div>

                    {{-- Features Card (Glassmorphism effect) --}}
                    <div
                        style="flex: 1.5; min-width: 300px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 15px; border: 1px solid rgba(255, 255, 255, 0.15); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
                        <h3
                            style="color: white; margin-top: 0; margin-bottom: 1.5rem; font-size: 1.1rem; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-info-circle" style="opacity: 0.8;"></i>
                            Comment utiliser vos crédits ?
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr; gap: 1.2rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div
                                    style="width: 32px; height: 32px; background: rgba(255, 255, 255, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: #ffffff;">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <span style="font-size: 0.9rem; font-weight: 500; opacity: 0.95;">Mise en avant sur la page
                                    d'accueil</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div
                                    style="width: 32px; height: 32px; background: rgba(239, 59, 45, 0.3); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: #ffffff;">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <span style="font-size: 0.9rem; font-weight: 500; opacity: 0.95;">Badge "Urgent" pour plus
                                    de vues</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div
                                    style="width: 32px; height: 32px; background: rgba(246, 139, 30, 0.3); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: #ffffff;">
                                    <i class="fas fa-video"></i>
                                </div>
                                <span style="font-size: 0.9rem; font-weight: 500; opacity: 0.95;">Ajout de vidéo à votre
                                    annonce</span>
                            </div>
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
                            <div
                                style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border: 1px solid {{ $isPopular ? '#EF3B2D' : '#dee2e6' }}; position: relative; display: flex; flex-direction: column; justify-content: space-between;">

                                @if($isPopular)
                                    <div
                                        style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #f68b1e; color: white; padding: 0.2rem 0.9rem; border-radius: 20px; font-size: 0.72rem; font-weight: bold; white-space: nowrap; z-index: 1;">
                                        POPULAIRE
                                    </div>
                                @endif

                                <div style="text-align: center; margin-bottom: 1rem;">
                                    <h3
                                        style="color: #666; margin-top: 0; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                        {{ $pack->nom ?? $pack->label ?? 'Forfait Crédits' }}
                                    </h3>

                                    <div style="font-size: 1.75rem; font-weight: 800; color: #333; margin-bottom: 0.25rem;">
                                        {{ number_format($pack->credits ?? $pack['credits'] ?? 0, 0, ',', ' ') }} <small
                                            style="font-size: 0.8rem; font-weight: 600; opacity: 0.7;">CRÉDITS</small>
                                    </div>

                                    <div style="font-size: 1rem; font-weight: 700; color: #333; margin-bottom: 0.5rem;">
                                        {{ number_format($pack->prix ?? $pack->price ?? $pack['price'] ?? 0, 0, ',', ' ') }} FCFA
                                    </div>
                                </div>

                                <form action="{{ route('account.credits.checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pack_id" value="{{ $pack->id ?? $pack['id'] ?? '' }}">

                                    <button type="submit"
                                        style="display: block; width: 100%; text-align: center; background: {{ ($loop->first || $loop->last) ? '#004aad' : '#f68b1e' }}; color: white; padding: 0.7rem; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem; font-weight: 700;">
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
                    <h2 style="color: #333; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Historique des transactions
                    </h2>

                    @if($transactions->count() > 0)
                        <div style="border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden;">
                            <div
                                style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 0.85rem 1rem; background: #f8f9fa; font-weight: 700; font-size: 0.8rem; color: #888; border-bottom: 1px solid #dee2e6; text-transform: uppercase;">
                                <div>Date</div>
                                <div>Description</div>
                                <div style="text-align: center;">État</div>
                                <div style="text-align: right;">Crédits</div>
                            </div>
                            @foreach($transactions as $transaction)
                                <div
                                    style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 1rem; border-bottom: 1px solid #f0f0f0; align-items: center;">
                                    <div style="font-size: 0.85rem; color: #777;">{{ $transaction->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <div style="font-size: 0.9rem; color: #444; font-weight: 500;">{{ $transaction->description }}</div>
                                    <div style="text-align: center;">
                                        <span
                                            style="background: {{ $transaction->montant > 0 ? '#e8f5e9' : '#fff1f2' }}; color: {{ $transaction->montant > 0 ? '#2e7d32' : '#be123c' }}; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                            {{ $transaction->montant > 0 ? 'Entrée' : 'Sortie' }}
                                        </span>
                                    </div>
                                    <div
                                        style="text-align: right; font-weight: 700; color: {{ $transaction->montant > 0 ? '#2e7d32' : '#be123c' }}; font-size: 0.95rem;">
                                        {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant, 0, ',', ' ') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </main>
    </div>

@endsection