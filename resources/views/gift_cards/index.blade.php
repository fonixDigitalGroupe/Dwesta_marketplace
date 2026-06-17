@extends('layouts.app')

@section('title', 'Cartes Cadeaux - Karnou')

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">

            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Cartes cadeaux</h1>
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

            {{-- Section : Acheter une carte --}}
            <div style="margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Acheter une carte cadeau</h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                    @forelse($giftCardOptions as $option)
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border: 1px solid {{ $option->is_popular ? '#EF3B2D' : '#dee2e6' }}; position: relative;">

                            @if($option->is_popular)
                                <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #EF3B2D; color: white; padding: 0.2rem 0.9rem; border-radius: 20px; font-size: 0.72rem; font-weight: bold; white-space: nowrap;">
                                    POPULAIRE
                                </div>
                            @endif

                            <h3 style="color: #333; margin-top: 0; margin-bottom: 0.5rem; font-size: 1rem;">
                                Carte {{ number_format($option->amount, 0, ',', ' ') }} FCFA
                            </h3>

                            <div style="font-size: 1.75rem; font-weight: 700; color: #EF3B2D; margin-bottom: 0.25rem;">
                                {{ number_format($option->amount, 0, ',', ' ') }} FCFA
                            </div>

                            <div style="font-size: 0.85rem; color: #666; margin-bottom: 1rem; line-height: 1.4;">
                                {{ $option->description ?: 'Créditez votre compte Karnou instantanément.' }}
                            </div>

                            <form action="{{ route('gift-cards.buy') }}" method="POST">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $option->amount }}">
                
                                <button type="submit"
                                    style="display: block; width: 100%; text-align: center; background: #EF3B2D; color: white; padding: 0.6rem; border-radius: 4px; border: none; cursor: pointer; font-size: 0.9rem; font-weight: 600;">
                                    Acheter
                                </button>
                            </form>
                        </div>
                    @empty
                        <p style="grid-column: 1/-1; text-align: center; padding: 2rem; color: #666;">Aucune option disponible.</p>
                    @endforelse
                </div>
            </div>

            {{-- Section : Vérification de solde --}}
            <div style="background: #e3f2fd; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #1976d2;">
                <h2 style="color: #1976d2; margin-top: 0; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Vérifier le solde d'une carte</h2>

                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <input type="text" id="balance-code-input"
                        placeholder="XXXX-XXXX-XXXX-XXXX"
                        oninput="this.value = this.value.toUpperCase()"
                        style="flex: 1; min-width: 200px; padding: 0.6rem 1rem; border: 1px solid #90caf9; border-radius: 4px; font-size: 0.9rem; outline: none; background: white; color: #333;">
                    <button type="button" onclick="checkGiftCardBalance()"
                        style="background: #1976d2; color: white; border: none; border-radius: 4px; padding: 0.6rem 1.5rem; font-weight: 700; cursor: pointer; font-size: 0.9rem; white-space: nowrap;">
                        Vérifier
                    </button>
                </div>

                <div id="balance-result" style="display: none; margin-top: 1rem; padding: 1rem; background: white; border-radius: 4px; border: 1px solid #90caf9;"></div>
            </div>

            {{-- Section : Mes achats --}}
            <div style="margin-top: 1rem;">
                <h2 style="color: #333; margin-bottom: 1rem; font-size: 1rem; font-weight: 700;">Mes cartes achetées</h2>

                @if($boughtCards->count() > 0)
                    <div style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
                        {{-- Header --}}
                        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 1rem; padding: 0.75rem 1rem; background: #f8f9fa; font-weight: 700; font-size: 0.85rem; color: #666; border-bottom: 1px solid #dee2e6;">
                            <div>Code</div>
                            <div>Valeur</div>
                            <div>État</div>
                            <div>Date</div>
                            <div style="text-align: right;">Action</div>
                        </div>
                        {{-- Rows --}}
                        @foreach($boughtCards as $card)
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 1rem; padding: 0.85rem 1rem; border-bottom: 1px solid #f0f0f0; align-items: center;">
                                <div>
                                    <span style="font-family: monospace; background: #f4f4f4; padding: 4px 8px; border-radius: 4px; font-weight: 700; font-size: 0.85rem;">{{ $card->code }}</span>
                                </div>
                                <div style="font-size: 0.9rem; color: #333; font-weight: 600;">{{ number_format($card->amount, 0, ',', ' ') }} FCFA</div>
                                <div>
                                    @if($card->status == 'active')
                                        <span style="background: #d4edda; color: #155724; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Disponible</span>
                                    @else
                                        <span style="background: #f8d7da; color: #721c24; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Utilisée</span>
                                    @endif
                                </div>
                                <div style="font-size: 0.875rem; color: #666;">{{ $card->created_at->format('d/m/Y') }}</div>
                                <div style="text-align: right;">
                                    <form action="{{ route('gift-cards.destroy', $card->id) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #888; cursor: pointer; font-size: 0.8rem;">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 2rem; text-align: center; background: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">
                        <p style="color: #666; margin: 0;">Aucun achat de carte cadeau pour le moment.</p>
                    </div>
                @endif
            </div>

        </main>
    </div>

@endsection

@push('scripts')
<script>
async function checkGiftCardBalance() {
    const code = document.getElementById('balance-code-input').value.trim();
    const resultBox = document.getElementById('balance-result');
    if (!code) return;

    try {
        const resp = await fetch("{{ route('gift-cards.check-balance') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code })
        });
        const data = await resp.json();
        resultBox.style.display = 'block';
        if (data.success) {
            resultBox.innerHTML = `<div style="font-weight: 700; color: #155724;">Solde : ${data.balance.toLocaleString()} FCFA</div>
                                  <div style="font-size: 0.8rem; color: #666; margin-top: 0.25rem;">État : ${data.status}</div>`;
        } else {
            resultBox.innerHTML = `<div style="color: #721c24;">${data.message}</div>`;
        }
    } catch (e) {
        resultBox.innerHTML = '<div style="color: #721c24;">Erreur de connexion.</div>';
    }
}
</script>
@endpush
