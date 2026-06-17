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

            {{-- Solde actuel --}}
            <div
                style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #dee2e6;">
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="color: #333; margin-top: 0; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">
                            Solde actuel</h2>
                        <div>
                            <strong style="color: #666; display: block; margin-bottom: 0.25rem; font-size: 0.85rem;">Vos
                                crédits disponibles :</strong>
                            <span
                                style="font-size: 2rem; font-weight: 800; color: #333;">{{ number_format($balance, 0, ',', ' ') }}
                                <span style="font-size: 1.4rem; color: #ffbe00;">⭐</span></span>
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