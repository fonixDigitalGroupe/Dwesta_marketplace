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

            {{-- Solde actuel --}}
            <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #dee2e6;">
                <h2 style="color: #333; margin-top: 0; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Solde actuel</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <strong style="color: #666; display: block; margin-bottom: 0.25rem; font-size: 0.85rem;">Vos crédits disponibles :</strong>
                        <span style="font-size: 2rem; font-weight: 800; color: #333;">{{ number_format($balance, 0, ',', ' ') }} <span style="font-size: 1.4rem; color: #ffbe00;">⭐</span></span>
                    </div>
                    <div>
                        <strong style="color: #666; display: block; margin-bottom: 0.25rem; font-size: 0.85rem;">Utilisation :</strong>
                        <span style="color: #555; font-size: 0.95rem;">Boostez vos annonces et augmentez votre visibilité sur la plateforme.</span>
                    </div>
                </div>

                <div>
                    <strong style="color: #333; display: block; margin-bottom: 0.5rem; font-size: 0.85rem;">Comment utiliser vos crédits ?</strong>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="padding: 0.4rem 0; color: #555; font-size: 0.9rem;"><span style="color: #28a745; margin-right: 0.5rem;">✓</span> Mise en avant de votre annonce sur la page d'accueil</li>
                        <li style="padding: 0.4rem 0; color: #555; font-size: 0.9rem;"><span style="color: #28a745; margin-right: 0.5rem;">✓</span> Badge "Urgent" pour attirer l'attention des acheteurs</li>
                        <li style="padding: 0.4rem 0; color: #555; font-size: 0.9rem;"><span style="color: #28a745; margin-right: 0.5rem;">✓</span> Ajout de vidéo à votre annonce</li>
                    </ul>
                </div>
            </div>

            {{-- Forfaits disponibles --}}
            @if(isset($packs) && count($packs) > 0)
            <div style="margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Forfaits disponibles</h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                    @foreach($packs as $pack)
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border: 1px solid {{ ($pack['popular'] ?? false) ? '#EF3B2D' : '#dee2e6' }}; position: relative;">

                            @if($pack['popular'] ?? false)
                                <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #f68b1e; color: white; padding: 0.2rem 0.9rem; border-radius: 20px; font-size: 0.72rem; font-weight: bold; white-space: nowrap;">
                                    POPULAIRE
                                </div>
                            @endif

                            <h3 style="color: #333; margin-top: 0; margin-bottom: 0.5rem; font-size: 1rem;">{{ $pack['label'] }}</h3>

                            <div style="font-size: 1.75rem; font-weight: 700; color: #333; margin-bottom: 0.25rem;">
                                {{ number_format($pack['credits'], 0, ',', ' ') }} crédits
                            </div>

                            @if(($pack['bonus'] ?? 0) > 0)
                                <div style="display: inline-block; background: #fff3cd; color: #856404; padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.75rem;">
                                    + {{ number_format($pack['bonus'], 0, ',', ' ') }} crédits offerts
                                </div>
                            @endif

                            <div style="font-size: 0.85rem; color: #666; margin-bottom: 1rem; line-height: 1.4;">
                                {{ number_format($pack['price'], 0, ',', ' ') }} FCFA
                            </div>

                            <form action="{{ route('credits.buy') }}" method="POST" onsubmit="return confirm('Confirmer l\'achat de ce forfait pour {{ number_format($pack[\'price\'], 0, \',\', \' \') }} FCFA ?')">
                                @csrf
                                <input type="hidden" name="pack_id" value="{{ $pack['id'] }}">

                                <button type="submit"
                                    style="display: block; width: 100%; text-align: center; background: {{ ($loop->first || $loop->last) ? '#004aad' : '#f68b1e' }}; color: white; padding: 0.6rem; border-radius: 4px; border: none; cursor: pointer; font-size: 0.9rem; font-weight: 600;">
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
                    <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
                        {{-- Header --}}
                        <div style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 0.75rem 1rem; background: #f8f9fa; font-weight: 700; font-size: 0.85rem; color: #666; border-bottom: 1px solid #dee2e6;">
                            <div>Date</div>
                            <div>Description</div>
                            <div>Type</div>
                            <div style="text-align: right;">Crédits</div>
                        </div>
                        {{-- Rows --}}
                        @foreach($transactions as $transaction)
                            <div style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 0.85rem 1rem; border-bottom: 1px solid #f0f0f0; align-items: center;">
                                <div style="font-size: 0.875rem; color: #666;">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                <div style="font-size: 0.9rem; color: #333;">{{ $transaction->description }}</div>
                                <div>
                                    @php $type = $transaction->type; @endphp
                                    @if(in_array($type, ['achat', 'bonus', 'remboursement']))
                                        <span style="background: #d4edda; color: #155724; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">{{ ucfirst($type) }}</span>
                                    @else
                                        <span style="background: #f8d7da; color: #721c24; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Dépense</span>
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
            @endif

        </main>
    </div>

@endsection
