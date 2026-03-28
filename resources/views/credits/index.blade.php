@extends('layouts.app')

@section('title', 'Mes Crédits - Mady Market')

@section('content')
<div style="max-width: 900px; margin: 3rem auto; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        {{-- Breadcrumb --}}
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <a href="{{ route('home') }}"
                    style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                    Accueil
                </a>
                <a href="{{ route('account.index') }}"
                    style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                    Mon compte
                </a>
            </div>
            <h1 style="color: #333; margin-top: 0;">Mes Crédits</h1>
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
            <h2 style="color: #1976d2; margin-top: 0; margin-bottom: 1rem;">Solde actuel</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Vos crédits disponibles :</strong>
                    <span style="font-size: 2rem; font-weight: 800; color: #333;">{{ number_format($balance, 0, ',', ' ') }} <span style="font-size: 1.4rem; color: #ffbe00;">⭐</span></span>
                </div>
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Utilisation :</strong>
                    <span style="color: #333; font-size: 0.95rem;">Boostez vos annonces et augmentez votre visibilité sur la plateforme.</span>
                </div>
            </div>

            <div style="background: white; padding: 1rem; border-radius: 4px; margin-bottom: 0;">
                <h3 style="color: #333; margin-top: 0; margin-bottom: 1rem;">Comment utiliser vos crédits ?</h3>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="padding: 0.5rem 0; color: #333;">
                        <span style="color: #28a745; margin-right: 0.5rem;">✓</span>
                        Mise en avant de votre annonce sur la page d'accueil
                    </li>
                    <li style="padding: 0.5rem 0; color: #333;">
                        <span style="color: #28a745; margin-right: 0.5rem;">✓</span>
                        Badge "Urgent" pour attirer l'attention des acheteurs
                    </li>
                    <li style="padding: 0.5rem 0; color: #333;">
                        <span style="color: #28a745; margin-right: 0.5rem;">✓</span>
                        Ajout de vidéo à votre annonce
                    </li>
                </ul>
            </div>
        </div>

        {{-- Forfaits disponibles --}}
        @if(isset($packs) && count($packs) > 0)
        <div style="margin-top: 2rem;">
            <h2 style="color: #333; margin-bottom: 1rem;">Forfaits disponibles</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                @foreach($packs as $pack)
                    <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border: 1px solid {{ ($pack['popular'] ?? false) ? '#EF3B2D' : '#dee2e6' }}; position: relative;">
                        @if($pack['popular'] ?? false)
                            <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #EF3B2D; color: white; padding: 0.2rem 0.9rem; border-radius: 20px; font-size: 0.72rem; font-weight: bold; white-space: nowrap;">
                                POPULAIRE
                            </div>
                        @endif

                        <h3 style="color: #333; margin-top: 0; margin-bottom: 0.5rem;">{{ $pack['label'] }}</h3>

                        <div style="font-size: 1.75rem; font-weight: 700; color: #EF3B2D; margin-bottom: 0.25rem;">
                            {{ number_format($pack['credits'], 0, ',', ' ') }} crédits
                        </div>

                        @if(($pack['bonus'] ?? 0) > 0)
                            <div style="display: inline-block; background: #fff3cd; color: #856404; padding: 0.2rem 0.7rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.75rem;">
                                + {{ number_format($pack['bonus'], 0, ',', ' ') }} crédits offerts
                            </div>
                        @endif

                        <div style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0.75rem 0 1rem;">
                            {{ number_format($pack['price'], 0, ',', ' ') }} FCFA
                        </div>

                        <form action="{{ route('credits.buy') }}" method="POST" onsubmit="return confirm('Confirmer l\'achat de ce forfait pour {{ number_format($pack[\'price\'], 0, \',\', \' \') }} FCFA ?')">
                            @csrf
                            <input type="hidden" name="pack_id" value="{{ $pack['id'] }}">
                            <input type="hidden" name="payment_method" value="om" class="payment-method-input">

                            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem;">
                                <button type="button" class="payment-btn-opt selected-opt" data-method="om"
                                    onclick="selectOpt(this)"
                                    style="flex: 1; padding: 0.5rem 0.25rem; border: 2px solid #EF3B2D; background: #fdf2f2; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 600;">
                                    Orange Money
                                </button>
                                <button type="button" class="payment-btn-opt" data-method="momo"
                                    onclick="selectOpt(this)"
                                    style="flex: 1; padding: 0.5rem 0.25rem; border: 2px solid #dee2e6; background: white; border-radius: 4px; cursor: pointer; font-size: 0.8rem; font-weight: 600;">
                                    MoMo
                                </button>
                            </div>

                            <button type="submit"
                                style="display: block; width: 100%; text-align: center; background: #EF3B2D; color: white; padding: 0.6rem; border-radius: 4px; border: none; cursor: pointer; font-size: 0.9rem; font-weight: 600;">
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
        <div style="margin-top: 3rem;">
            <h2 style="color: #333; margin-bottom: 1rem;">Historique des transactions</h2>

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

    </div>
</div>

<script>
function selectOpt(btn) {
    const form = btn.closest('form');
    form.querySelectorAll('.payment-btn-opt').forEach(b => {
        b.style.borderColor = '#dee2e6';
        b.style.background = 'white';
    });
    btn.style.borderColor = '#EF3B2D';
    btn.style.background = '#fdf2f2';
    form.querySelector('.payment-method-input').value = btn.getAttribute('data-method');
}
</script>
@endsection
