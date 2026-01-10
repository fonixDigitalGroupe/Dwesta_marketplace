@extends('layouts.app')

@section('title', 'Mon Porte-Monnaie - Mady Market')

@push('styles')
<style>
    .wallet-container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
    
    .balance-card { background: linear-gradient(135deg, #bf0000 0%, #8b0000 100%); color: white; border-radius: 12px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 20px rgba(191, 0, 0, 0.3); }
    .balance-amount { font-size: 3rem; font-weight: bold; margin: 1rem 0; }
    .balance-label { font-size: 0.9rem; opacity: 0.9; }
    
    .packs-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
    .pack-card { background: white; border: 2px solid #e0e0e0; border-radius: 12px; padding: 2rem; text-align: center; transition: all 0.3s; position: relative; }
    .pack-card.popular { border-color: #bf0000; box-shadow: 0 4px 20px rgba(191, 0, 0, 0.2); }
    .pack-card.popular::before { content: '⭐ POPULAIRE'; position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #bf0000; color: white; padding: 0.25rem 1rem; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
    .pack-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    
    .pack-credits { font-size: 2.5rem; font-weight: bold; color: #bf0000; margin: 1rem 0; }
    .pack-bonus { background: #fdf2f2; color: #bf0000; padding: 0.5rem 1rem; border-radius: 20px; display: inline-block; font-weight: bold; margin: 0.5rem 0; }
    .pack-price { font-size: 1.5rem; font-weight: bold; margin: 1rem 0; }
    
    .btn-buy { background: #bf0000; color: white; border: none; padding: 1rem 2rem; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%; transition: all 0.2s; }
    .btn-buy:hover { background: #8b0000; }
    
    .transactions-table { background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
    .transaction-row { display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 1rem; padding: 1rem; border-bottom: 1px solid #f0f0f0; align-items: center; }
    .transaction-row:last-child { border-bottom: none; }
    .transaction-header { background: #f9f9f9; font-weight: bold; font-size: 0.9rem; color: #666; }
    
    .badge-credit { background: #e6fffa; color: #2c7a7b; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: bold; }
    .badge-debit { background: #fff5f5; color: #c53030; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: bold; }
    
    .payment-methods { display: flex; gap: 1rem; margin-top: 1rem; justify-content: center; }
    .payment-btn { flex: 1; padding: 0.75rem; border: 2px solid #e0e0e0; background: white; border-radius: 8px; cursor: pointer; transition: all 0.2s; }
    .payment-btn.selected { border-color: #bf0000; background: #fdf2f2; }
</style>
@endpush

@section('content')
<div class="wallet-container">
    <div class="balance-card">
        <div class="balance-label">Mon solde de crédits</div>
        <div class="balance-amount">{{ number_format($balance, 0, ',', ' ') }}</div>
        <p style="opacity: 0.9; font-size: 0.95rem;">Utilisez vos crédits pour booster vos annonces et augmenter votre visibilité !</p>
    </div>

    @if(session('success'))
        <div style="background: #e6fffa; color: #2c7a7b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #b2f5ea;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Recharger mon compte</h2>
    
    <div class="packs-grid">
        @foreach($packs as $pack)
            <div class="pack-card {{ $pack['popular'] ?? false ? 'popular' : '' }}">
                <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">{{ $pack['label'] }}</h3>
                <div class="pack-credits">{{ $pack['credits'] }}</div>
                <div style="color: #666; font-size: 0.9rem;">crédits</div>
                
                @if($pack['bonus'] > 0)
                    <div class="pack-bonus">+ {{ $pack['bonus'] }} BONUS</div>
                @endif
                
                <div class="pack-price">{{ number_format($pack['price'], 0, ',', ' ') }} FCFA</div>
                
                <form action="{{ route('credits.buy') }}" method="POST" onsubmit="return confirmPurchase(event, '{{ $pack['label'] }}', {{ $pack['price'] }})">
                    @csrf
                    <input type="hidden" name="pack_id" value="{{ $pack['id'] }}">
                    <input type="hidden" name="payment_method" value="om" class="payment-method-input">
                    
                    <div class="payment-methods">
                        <button type="button" class="payment-btn selected" onclick="selectPayment(this, 'om')">
                            <div style="font-weight: bold; font-size: 0.85rem;">Orange Money</div>
                        </button>
                        <button type="button" class="payment-btn" onclick="selectPayment(this, 'momo')">
                            <div style="font-weight: bold; font-size: 0.85rem;">MoMo</div>
                        </button>
                    </div>
                    
                    <button type="submit" class="btn-buy">Acheter</button>
                </form>
            </div>
        @endforeach
    </div>

    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem;">Historique des transactions</h2>
    
    @if($transactions->count() > 0)
        <div class="transactions-table">
            <div class="transaction-row transaction-header">
                <div>Date</div>
                <div>Description</div>
                <div>Type</div>
                <div style="text-align: right;">Montant</div>
            </div>
            @foreach($transactions as $transaction)
                <div class="transaction-row">
                    <div style="font-size: 0.9rem; color: #666;">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                    <div style="font-size: 0.95rem;">{{ $transaction->description }}</div>
                    <div>
                        <span class="badge-{{ $transaction->type }}">
                            {{ $transaction->type === 'credit' ? '+ Crédit' : '- Débit' }}
                        </span>
                    </div>
                    <div style="text-align: right; font-weight: bold; color: {{ $transaction->type === 'credit' ? '#2c7a7b' : '#c53030' }};">
                        {{ $transaction->type === 'credit' ? '+' : '-' }}{{ $transaction->amount }}
                    </div>
                </div>
            @endforeach
        </div>
        
        <div style="margin-top: 2rem;">
            {{ $transactions->links() }}
        </div>
    @else
        <div style="padding: 3rem; text-align: center; background: #f9f9f9; border-radius: 8px; border: 2px dashed #e0e0e0;">
            <p style="color: #666;">Aucune transaction pour le moment.</p>
        </div>
    @endif
</div>

<script>
function selectPayment(btn, method) {
    const form = btn.closest('form');
    form.querySelectorAll('.payment-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    form.querySelector('.payment-method-input').value = method;
}

function confirmPurchase(event, packName, price) {
    return confirm(`Confirmer l'achat du ${packName} pour ${price.toLocaleString()} FCFA ?`);
}
</script>
@endsection
