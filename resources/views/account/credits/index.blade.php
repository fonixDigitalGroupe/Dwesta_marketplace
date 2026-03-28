@extends('layouts.app')

@section('title', 'Mes Crédits - Karnou')

@push('styles')
    <style>
        .dashboard-container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 1rem 2rem;
            gap: 2rem;
        }

        .breadcrumb {
            max-width: 1200px;
            margin: 1rem auto 0;
            padding: 0 1rem;
            font-size: 0.85rem;
            color: #666;
        }

        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb span {
            color: #333;
            font-weight: bold;
        }

        .main-content {
            flex: 1;
            background: #fff;
        }

        .account-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .account-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #333;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('account.index') }}">Mon Compte</a> > <span>Mes Crédits</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="account-header">
                <h1>Mes Crédits</h1>
            </div>

            {{-- Alerts --}}
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

            {{-- Solde actuel --}}
            <div style="background: #e3f2fd; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #1976d2;">
                <h2 style="color: #1976d2; margin-top: 0; margin-bottom: 1rem; font-size: 1.25rem;">Solde actuel</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Vos crédits disponibles :</strong>
                        <span style="font-size: 2rem; font-weight: 800; color: #333;">
                            {{ number_format($balance, 0, ',', ' ') }}
                            <span style="font-size: 1.4rem; color: #ffbe00;">⭐</span>
                        </span>
                    </div>
                </div>


            </div>

            {{-- Forfaits disponibles --}}
            <div style="margin-top: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem; font-size: 1.25rem;">Forfaits disponibles</h2>

                @if(isset($packs) && $packs->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        @foreach($packs as $pack)
                            @php
                                $isPopular = ($pack->nom ?? $pack->label ?? '') === 'Pack 25 000' || ($pack->popular ?? false);
                            @endphp
                            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border: 1px solid {{ $isPopular ? '#EF3B2D' : '#dee2e6' }}; position: relative;">

                                @if($isPopular)
                                    <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #EF3B2D; color: white; padding: 0.2rem 0.9rem; border-radius: 20px; font-size: 0.72rem; font-weight: bold; white-space: nowrap;">
                                        POPULAIRE
                                    </div>
                                @endif

                                <h3 style="color: #333; margin-top: 0; margin-bottom: 0.5rem; font-size: 1rem;">{{ $pack->nom ?? $pack->label ?? 'Pack' }}</h3>

                                <div style="font-size: 1.6rem; font-weight: 700; color: #EF3B2D; margin-bottom: 0.25rem;">
                                    {{ number_format($pack->credits, 0, ',', ' ') }} crédits
                                </div>

                                @if(($pack->bonus_credits ?? 0) > 0)
                                    <div style="display: inline-block; background: #fff3cd; color: #856404; padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.82rem; font-weight: 600; margin-bottom: 0.75rem;">
                                        dont {{ number_format($pack->bonus_credits, 0, ',', ' ') }} crédits offerts
                                    </div>
                                @endif

                                <div style="font-size: 1.2rem; font-weight: 700; color: #333; margin: 0.75rem 0 1rem;">
                                    {{ number_format($pack->prix, 0, ',', ' ') }} FCFA
                                </div>

                                <form action="{{ route('credits.buy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pack_id" value="{{ $pack->id }}">
                                    <button type="submit"
                                        style="display:block; width:100%; text-align:center; background:#000; color:white; padding:0.6rem; border-radius:4px; border:none; cursor:pointer; font-size:0.9rem; font-weight:600;">
                                        Acheter
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 2rem; text-align: center; background: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">
                        <p style="color: #666; margin: 0;">Aucun forfait disponible pour le moment.</p>
                    </div>
                @endif
            </div>

            {{-- Historique transactions --}}
            <div style="margin-top: 3rem;">
                <h2 style="color: #333; margin-bottom: 1rem; font-size: 1.25rem;">Historique des transactions</h2>

                @if($transactions->count() > 0)
                    <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
                        <div style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 0.75rem 1rem; background: #f8f9fa; font-weight: 700; font-size: 0.85rem; color: #666; border-bottom: 1px solid #dee2e6;">
                            <div>Date</div>
                            <div>Description</div>
                            <div>Type</div>
                            <div style="text-align: right;">Crédits</div>
                        </div>
                        @foreach($transactions as $transaction)
                            <div style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 0.85rem 1rem; border-bottom: 1px solid #f0f0f0; align-items: center;">
                                <div style="font-size: 0.875rem; color: #666;">
                                    {{ $transaction->created_at->format('d/m/Y') }}
                                </div>
                                <div style="font-size: 0.9rem; color: #333;">
                                    {{ $transaction->description }}
                                </div>
                                <div>
                                    @if(in_array($transaction->type, ['achat', 'bonus', 'remboursement']))
                                        <span style="background: #d4edda; color: #155724; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    @else
                                        <span style="background: #f8d7da; color: #721c24; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                            Dépense
                                        </span>
                                    @endif
                                </div>
                                <div style="text-align: right; font-weight: 700; color: {{ $transaction->montant > 0 ? '#155724' : '#721c24' }};">
                                    {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant, 0, ',', ' ') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top: 1.5rem;">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div style="padding: 2rem; text-align: center; background: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">
                        <p style="color: #666; margin: 0;">Aucune transaction pour le moment.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

@endsection
