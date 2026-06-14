@extends('layouts.app')

@section('title', 'Cartes Cadeaux - Karnou')

@push('styles')
<style>
    .gift-card-page {
        max-width: 900px;
    }

    .gift-card-box {
        margin-bottom: 2.5rem;
    }

    .section-title {
        font-size: 0.8rem;
        font-weight: 800;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #f68b1e;
    }

    /* Purchase Cards Grid */
    .gift-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }

    .purchase-card {
        border: 1px solid #efefef;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        background: #fff;
        position: relative;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .purchase-card:hover {
        border-color: #004aad;
        background: #fff;
        transform: translateY(-2px);
    }

    .purchase-card.popular {
        border-color: #f68b1e;
        background: #fff;
    }

    .popular-badge {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: #f68b1e;
        color: white;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 2px 10px;
        border-radius: 10px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .purchase-card .amount {
        font-size: 1.5rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 0px;
    }

    .purchase-card .desc {
        color: #777;
        font-size: 0.75rem;
        margin-bottom: 0.75rem;
        height: auto;
        overflow: hidden;
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-buy-now {
        width: 100%;
        padding: 0.6rem;
        border: none;
        background: #f68b1e;
        color: #fff;
        border-radius: 6px;
        font-weight: 800;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: auto;
    }

    .btn-buy-now:hover {
        background: #e67e00;
        color: #fff;
        transform: translateY(-2px);
    }

    /* History Table */
    .table-cards {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .table-cards th {
        text-align: left;
        padding: 0.75rem 1rem;
        background: #fff;
        color: #888;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid #eee;
    }

    .table-cards td {
        padding: 1rem;
        border-bottom: 1px solid #f9f9f9;
        vertical-align: middle;
    }

    .code-badge {
        font-family: 'Courier New', monospace;
        background: #f0f4f8;
        color: #333;
        padding: 3px 8px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.75rem;
    }

    .status-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-used {
        background: #f5f5f5;
        color: #999;
    }

    @media (max-width: 991px) {
        .gift-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 767px) {
        .gift-cards-grid { grid-template-columns: 1fr; }
    }

    /* Balance Checker Card */
    .balance-checker-card {
        background: linear-gradient(135deg, #004aad 0%, #1a5ccc 100%);
        border-radius: 16px;
        padding: 1.75rem 2rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .balance-checker-card::before {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        top: -60px;
        right: -60px;
    }
    .balance-checker-card::after {
        content: '';
        position: absolute;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        bottom: -40px;
        left: 30px;
    }
    .balance-checker-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.75;
        margin-bottom: 0.4rem;
    }
    .balance-checker-subtitle {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
    }
    .balance-input-group {
        display: flex;
        gap: 10px;
        position: relative;
        z-index: 2;
    }
    .balance-input-group input {
        flex: 1;
        padding: 10px 16px;
        border-radius: 8px;
        border: none;
        background: rgba(255,255,255,0.15);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 1px;
        outline: none;
        backdrop-filter: blur(4px);
    }
    .balance-input-group input::placeholder { color: rgba(255,255,255,0.55); font-weight: 500; letter-spacing: 0; }
    .balance-input-group input:focus { background: rgba(255,255,255,0.22); }
    .balance-input-group button {
        background: #f68b1e;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        text-transform: uppercase;
        white-space: nowrap;
        transition: background 0.2s;
    }
    .balance-input-group button:hover { background: #e07a10; }
    .balance-result {
        margin-top: 1.25rem;
        background: rgba(255,255,255,0.12);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        display: none;
        backdrop-filter: blur(4px);
        position: relative;
        z-index: 2;
    }
    .balance-result-amount {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -0.5px;
    }
    .balance-result-label {
        font-size: 0.75rem;
        opacity: 0.7;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }
    .balance-result-meta {
        margin-top: 0.6rem;
        font-size: 0.8rem;
        opacity: 0.85;
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
</style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content gift-card-page">
            <div
                style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Cartes cadeaux</h1>
            </div>

            @if(session('success'))
                <div
                    style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div
                    style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #ffcdd2;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Redeem section removed --}}

            <div class="gift-card-box">
                <h2 class="section-title">
                    <i class="fas fa-wallet" style="color: #004aad;"></i> Choisissez votre mode de paiement
                </h2>
                <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid #eee; margin-bottom: 2rem;">
                    <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <label style="flex: 1; min-width: 150px; cursor: pointer;">
                            <input type="radio" name="global_moyen_paiement" value="wave" checked style="display: none;" onchange="updatePaymentMethod(this)">
                            <div class="payment-selector-item" data-value="wave" style="border: 2px solid #004aad; border-radius: 8px; padding: 15px; text-align: center; background: #f0f7ff;">
                                <img src="{{ asset('images/logowave.png') }}" alt="Wave" style="height: 30px; margin-bottom: 5px; display: block; margin-left: auto; margin-right: auto;">
                                <span style="font-size: 0.8rem; font-weight: 700;">Wave</span>
                            </div>
                        </label>
                        <label style="flex: 1; min-width: 150px; cursor: pointer;">
                            <input type="radio" name="global_moyen_paiement" value="om" style="display: none;" onchange="updatePaymentMethod(this)">
                            <div class="payment-selector-item" data-value="om" style="border: 2px solid #eee; border-radius: 8px; padding: 15px; text-align: center;">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png" alt="OM" style="height: 30px; margin-bottom: 5px; display: block; margin-left: auto; margin-right: auto;">
                                <span style="font-size: 0.8rem; font-weight: 700;">Orange Money</span>
                            </div>
                        </label>
                        <label style="flex: 1; min-width: 150px; cursor: pointer;">
                            <input type="radio" name="global_moyen_paiement" value="free" style="display: none;" onchange="updatePaymentMethod(this)">
                            <div class="payment-selector-item" data-value="free" style="border: 2px solid #eee; border-radius: 8px; padding: 15px; text-align: center;">
                                <img src="https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png" alt="Free" style="height: 30px; margin-bottom: 5px; display: block; margin-left: auto; margin-right: auto;">
                                <span style="font-size: 0.8rem; font-weight: 700;">Free Money</span>
                            </div>
                        </label>
                        <label style="flex: 1; min-width: 150px; cursor: pointer;">
                            <input type="radio" name="global_moyen_paiement" value="cb" style="display: none;" onchange="updatePaymentMethod(this)">
                            <div class="payment-selector-item" data-value="cb" style="border: 2px solid #eee; border-radius: 8px; padding: 15px; text-align: center;">
                                <div style="height: 30px; display: flex; align-items: center; justify-content: center; gap: 5px; margin-bottom: 5px;">
                                    <i class="fab fa-cc-visa" style="color: #1a1f71; font-size: 20px;"></i>
                                    <i class="fab fa-cc-mastercard" style="color: #eb001b; font-size: 20px;"></i>
                                </div>
                                <span style="font-size: 0.8rem; font-weight: 700;">Carte Bancaire</span>
                            </div>
                        </label>
                    </div>
                </div>

                <h2 class="section-title">
                    Choisissez le montant de votre carte
                </h2>
                <div class="gift-cards-grid">
                    @forelse($giftCardOptions as $option)
                        <div class="purchase-card {{ $option->is_popular ? 'popular' : '' }}">
                            @if($option->is_popular)
                                <span class="popular-badge">Populaire</span>
                            @endif
                            <div class="amount">{{ number_format($option->amount, 0, ',', ' ') }} <small
                                    style="font-size: 0.8rem;">FCFA</small></div>
                            <div class="desc">{{ $option->description ?: 'Créditez votre compte instantanément.' }}</div>
                            <form action="{{ route('gift-cards.buy') }}" method="POST">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $option->amount }}">
                                <input type="hidden" name="moyen_paiement" class="form-moyen-paiement" value="wave">
                                <button type="submit" class="btn-buy-now">Acheter avec <span class="selected-method-label">Wave</span></button>
                            </form>
                        </div>
                    @empty
                        <p style="color: #666; font-size: 0.9rem; grid-column: 1/-1; text-align: center; padding: 2rem;">Aucune
                            option de carte cadeau n'est disponible pour le moment.</p>
                    @endforelse
                </div>
            </div>

            {{-- Balance Checker --}}
            <div class="gift-card-box">
                <h2 class="section-title"><i class="fas fa-search-dollar"></i> Vérifier le solde d'une carte</h2>
                <div class="balance-checker-card">
                    <div class="balance-checker-title">Dwesta · Carte Cadeau</div>
                    <div class="balance-checker-subtitle">Entrez votre code pour consulter le solde disponible</div>
                    <div class="balance-input-group">
                        <input type="text" id="balance-code-input" placeholder="EX: XXXX-XXXX-XXXX" oninput="this.value = this.value.toUpperCase()">
                        <button type="button" onclick="checkGiftCardBalance()"><i class="fas fa-search"></i> Vérifier</button>
                    </div>
                    <div class="balance-result" id="balance-result">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                            <div>
                                <div class="balance-result-amount"><span id="br-balance">0</span> <span style="font-size: 1rem; font-weight: 500;">FCFA</span></div>
                                <div class="balance-result-label">Solde disponible</div>
                            </div>
                            <div style="text-align: right;">
                                <div id="br-status-badge" style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;"></div>
                            </div>
                        </div>
                        <div class="balance-result-meta">
                            <span><i class="fas fa-ticket-alt"></i> Code : <strong id="br-code"></strong></span>
                            <span><i class="fas fa-coins"></i> Valeur initiale : <strong id="br-amount">0</strong> FCFA</span>
                            <span id="br-expiry-wrap"><i class="fas fa-calendar-alt"></i> Expire le : <strong id="br-expiry"></strong></span>
                        </div>
                    </div>
                </div>
            </div>

            @if($boughtCards->isNotEmpty())
                <div class="gift-card-box">
                    <h2 class="section-title">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Mes cartes achetées
                    </h2>
                    <div style="overflow-x: auto; border: 1px solid #eee; border-radius: 8px;">
                        <table class="table-cards">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Valeur</th>
                                    <th>Statut</th>
                                    <th>Date d'achat</th>
                                    <th style="width: 50px; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($boughtCards as $card)
                                    <tr>
                                        <td><span class="code-badge">{{ $card->code }}</span></td>
                                        <td style="font-weight: 700; color: #333;">{{ number_format($card->amount, 0, ',', ' ') }}
                                            FCFA</td>
                                        <td>
                                            <span class="status-badge status-{{ $card->status }}">
                                                {{ $card->status == 'active' ? 'Disponible' : 'Utilisée' }}
                                            </span>
                                        </td>
                                        <td style="color: #777;">{{ $card->created_at->format('d/m/Y') }}</td>
                                        <td style="text-align: center;">
                                            <form action="{{ route('gift-cards.destroy', $card->id) }}" method="POST" onsubmit="return confirm('Supprimer cette carte cadeau de votre liste ?');" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: none; border: none; color: #aaa; cursor: pointer; font-size: 0.75rem; font-weight: 500; padding: 5px; text-transform: uppercase;" title="Supprimer">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </main>
    </div>
@endsection
@push('scripts')
<script>
async function checkGiftCardBalance() {
    const code = document.getElementById('balance-code-input').value.trim();
    const resultBox = document.getElementById('balance-result');
    if (!code) { alert('Veuillez entrer un code.'); return; }
    const btn = document.querySelector('.balance-input-group button');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Vérification...';
    try {
        const resp = await fetch("{{ route('gift-cards.check-balance') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code })
        });
        const data = await resp.json();
        resultBox.style.display = 'block';
        if (data.success) {
            document.getElementById('br-balance').innerText = data.balance.toLocaleString('fr-FR');
            document.getElementById('br-amount').innerText = data.amount.toLocaleString('fr-FR');
            document.getElementById('br-code').innerText = data.code;
            const badge = document.getElementById('br-status-badge');
            if (data.status === 'active' && data.balance > 0) {
                badge.innerText = '✓ Active'; badge.style.background = 'rgba(255,255,255,0.2)'; badge.style.color = '#fff';
            } else if (data.status === 'used') {
                badge.innerText = '✗ Utilisée'; badge.style.background = 'rgba(0,0,0,0.25)'; badge.style.color = '#ffcccc';
            } else {
                badge.innerText = '⚠ Expirée'; badge.style.background = 'rgba(246,139,30,0.3)'; badge.style.color = '#ffe0b2';
            }
            const expiryWrap = document.getElementById('br-expiry-wrap');
            if (data.expiry) { document.getElementById('br-expiry').innerText = data.expiry; expiryWrap.style.display = 'inline'; }
            else { expiryWrap.style.display = 'none'; }
        } else {
            resultBox.innerHTML = '<span style="opacity:0.85;font-size:0.9rem;"><i class="fas fa-exclamation-circle"></i> ' + data.message + '</span>';
        }
    } catch (e) {
        resultBox.style.display = 'block';
        resultBox.innerHTML = '<span style="opacity:0.85;"><i class="fas fa-exclamation-circle"></i> Erreur réseau.</span>';
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-search"></i> Vérifier';
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('balance-code-input');
    if (input) input.addEventListener('keydown', e => { if (e.key === 'Enter') checkGiftCardBalance(); });
});

function updatePaymentMethod(radio) {
    const value = radio.value;
    const label = radio.closest('label').querySelector('span').innerText;
    
    // Update all hidden inputs
    document.querySelectorAll('.form-moyen-paiement').forEach(input => {
        input.value = value;
    });
    
    // Update all button labels
    document.querySelectorAll('.selected-method-label').forEach(span => {
        span.innerText = label;
    });
    
    // Update visual styles
    document.querySelectorAll('.payment-selector-item').forEach(item => {
        item.style.borderColor = '#eee';
        item.style.background = 'white';
    });
    
    const selectedItem = radio.closest('label').querySelector('.payment-selector-item');
    selectedItem.style.borderColor = '#004aad';
    selectedItem.style.background = '#f0f7ff';
}
</script>
@endpush
