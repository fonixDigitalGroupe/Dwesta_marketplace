@extends('layouts.app')

@section('title', 'Cartes Cadeaux - Karnou')

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <style>
                .main-content {
                    background: #fdfdfd;
                    min-height: 100vh;
                    padding: 2rem !important;
                }
                .account-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding-bottom: 0.5rem;
                    margin-bottom: 1.5rem;
                    border-bottom: 1px solid #eee;
                }
                .account-header h1 {
                    font-size: 1.1rem;
                    font-weight: 600;
                    color: #333;
                    margin: 0;
                }

                /* 💳 Balance Card - Premium Dark Glossy */
                .balance-card {
                    background: linear-gradient(135deg, #001f3f 0%, #004aad 100%);
                    border-radius: 12px;
                    padding: 24px 32px;
                    color: #fff;
                    position: relative;
                    overflow: hidden;
                    margin-bottom: 2.5rem;
                    box-shadow: none;
                    border: 1px solid rgba(255,255,255,0.1);
                    width: 100%;
                    max-width: 450px;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    min-height: 160px;
                }
                .balance-card::before {
                    content: '';
                    position: absolute;
                    top: -100px; right: -100px;
                    width: 300px; height: 300px;
                    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
                    pointer-events: none;
                }
                .balance-card-chip {
                    width: 50px;
                    height: 40px;
                    background: linear-gradient(135deg, #ffd700 0%, #ffae00 100%);
                    border-radius: 8px;
                    margin-bottom: 20px;
                    position: relative;
                    box-shadow: inset 0 1px 1px rgba(255,255,255,0.5);
                }
                .balance-card-chip::after {
                    content: '';
                    position: absolute;
                    top: 50%; left: 0; right: 0; height: 1px; background: rgba(0,0,0,0.1);
                }
                .balance-card-label {
                    font-size: 0.75rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    opacity: 0.7;
                    margin-bottom: 5px;
                }
                .balance-card-value {
                    font-size: 2.8rem;
                    font-weight: 900;
                    letter-spacing: -0.03em;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }
                .balance-card-unit {
                    font-size: 1rem;
                    font-weight: 700;
                    background: rgba(255,255,255,0.15);
                    padding: 4px 12px;
                    border-radius: 100px;
                    backdrop-filter: blur(4px);
                }
                .balance-card-footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end;
                    margin-top: auto;
                }
                .balance-card-holder {
                    font-family: 'Courier New', Courier, monospace;
                    font-size: 0.85rem;
                    letter-spacing: 0.1em;
                    text-transform: uppercase;
                    opacity: 0.9;
                }
                .balance-card-brand {
                    font-size: 0.95rem;
                    font-weight: 900;
                    font-style: italic;
                    opacity: 0.7;
                }

                /* 📦 Pack Cards */
                .packs-grid {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 1rem;
                    margin-bottom: 3rem;
                    max-width: 800px;
                }
                .pack-card {
                    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                    border-radius: 14px;
                    padding: 18px 20px;
                    color: #fff;
                    position: relative;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    min-height: 180px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    text-align: left;
                }
                .pack-card::before {
                    content: '';
                    position: absolute;
                    top: -40px; right: -40px;
                    width: 150px; height: 150px;
                    background: rgba(255,255,255,0.04);
                    border-radius: 50%;
                    pointer-events: none;
                }
                .pack-card::after {
                    content: '';
                    position: absolute;
                    bottom: -50px; left: -20px;
                    width: 180px; height: 180px;
                    background: rgba(255,255,255,0.03);
                    border-radius: 50%;
                    pointer-events: none;
                }
                .pack-brand {
                    position: absolute;
                    top: 15px;
                    right: 18px;
                    font-size: 11px;
                    font-weight: 900;
                    color: rgba(255,255,255,0.25);
                    letter-spacing: -0.5px;
                }
                .pack-label {
                    font-size: 8px;
                    color: rgba(255,255,255,0.55);
                    letter-spacing: 1.2px;
                    text-transform: uppercase;
                    margin-bottom: 3px;
                    font-weight: 700;
                }
                .pack-value-large {
                    font-size: 18px;
                    font-weight: 800;
                    letter-spacing: 1.5px;
                    color: #fff;
                    font-family: 'Courier New', monospace;
                    margin: 2px 0 10px 0;
                }
                .pack-price-gold {
                    font-size: 20px;
                    font-weight: 800;
                    color: #004aad;
                    margin-top: auto;
                }
                .pack-bonus-badge {
                    display: inline-block;
                    padding: 2px 8px;
                    border-radius: 20px;
                    font-size: 9px;
                    font-weight: 700;
                    margin-top: 8px;
                    background: rgba(246, 139, 30, 0.15);
                    color: #f68b1e;
                    border: 1px solid rgba(246, 139, 30, 0.3);
                }
                .btn-buy-card {
                    margin-top: 15px;
                    width: 100%;
                    padding: 0.65rem;
                    border-radius: 8px;
                    border: none;
                    background: rgba(255,255,255,0.1);
                    color: #fff;
                    font-weight: 700;
                    font-size: 0.8rem;
                    cursor: pointer;
                    transition: all 0.2s;
                    border: 1px solid rgba(255,255,255,0.2);
                    position: relative;
                    z-index: 5;
                }
                .btn-buy-card:hover {
                    background: #fff;
                    color: #111827;
                }

                /* 📝 Transactions List */
                .section-title {
                    font-size: 0.85rem;
                    font-weight: 600;
                    color: #333;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    margin-bottom: 1.25rem;
                }
                .tx-list {
                    background: #fff;
                    border: 1px solid #f0f0f0;
                    border-radius: 12px;
                    overflow: hidden;
                }
                .tx-item {
                    display: grid;
                    grid-template-columns: auto 1fr auto;
                    align-items: center;
                    padding: 0.9rem 1.5rem;
                    border-bottom: 1px solid #f8f8f8;
                    transition: background 0.2s;
                    gap: 1.2rem;
                }
                .tx-item:hover { background: #fcfcfc; }
                .tx-item:last-child { border-bottom: none; }
                
                .tx-icon {
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 0.9rem;
                }
                .tx-icon.in { background: #f0fdf4; color: #16a34a; }
                .tx-icon.out { background: #fef2f2; color: #dc2626; }

                .tx-info {
                    display: flex;
                    flex-direction: column;
                }
                .tx-desc {
                    font-size: 0.9rem;
                    font-weight: 600;
                    color: #1f2937;
                    margin-bottom: 1px;
                }
                .tx-date {
                    font-size: 0.75rem;
                    color: #9ca3af;
                }
                .tx-amount {
                    font-size: 0.95rem;
                    font-weight: 700;
                    text-align: right;
                }
                .tx-amount.plus { color: #059669; }
                .tx-amount.minus { color: #111827; }

                @media (max-width: 991px) {
                    .packs-grid { grid-template-columns: repeat(2, 1fr); }
                }
                @media (max-width: 768px) {
                    .main-content { padding: 0.75rem !important; min-height: 0; }
                    .balance-card { padding: 25px; min-height: 180px; max-width: 100%; }
                    .balance-card-value { font-size: 2.3rem; }
                    .packs-grid { grid-template-columns: repeat(2, 1fr); max-width: 100%; gap: 0.6rem; }
                    .pack-card { padding: 14px; min-height: 150px; }
                    .pack-value-large { font-size: 15px; }
                    .pack-price-gold { font-size: 16px; }
                    .tx-item { padding: 0.85rem 1rem; gap: 0.75rem; grid-template-columns: auto 1fr auto; }
                    .tx-info { min-width: 0; }
                    .tx-desc, .tx-date { overflow-wrap: anywhere; word-break: break-word; }
                    .tx-date { font-size: 0.7rem; }
                    .tx-amount { font-size: 0.85rem; }
                    .section-title { margin-bottom: 0.9rem; }
                }
                @media (max-width: 400px) {
                    .packs-grid { grid-template-columns: 1fr; }
                }

                /* 🎫 Gift Card Visual Visualizing */
                .gift-card-visual {
                    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                    border-radius: 16px;
                    padding: 28px 30px;
                    color: #fff;
                    position: relative;
                    overflow: hidden;
                    margin-top: 1rem;
                    box-shadow: 0 4px 16px rgba(15, 52, 96, 0.15);
                    max-width: 450px;
                }
                .gift-card-visual::before {
                    content: '\f06b';
                    font-family: 'Font Awesome 5 Free';
                    font-weight: 900;
                    position: absolute;
                    top: -20px; right: 20px;
                    font-size: 80px;
                    color: rgba(255,255,255,0.03);
                    transform: rotate(15deg);
                    pointer-events: none;
                }
                .gift-card-visual::after {
                    content: '\f06b';
                    font-family: 'Font Awesome 5 Free';
                    font-weight: 900;
                    position: absolute;
                    bottom: -20px; left: 20px;
                    font-size: 60px;
                    color: rgba(255,255,255,0.02);
                    transform: rotate(-15deg);
                    pointer-events: none;
                }
                .gc-brand { position: absolute; top: 20px; right: 24px; font-size: 16px; font-weight: 900; color: rgba(255,255,255,0.25); letter-spacing: -1px; }
                .gc-label { font-size: 10px; color: rgba(255,255,255,0.55); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 4px; }
                .gc-code { font-size: 22px; font-weight: 800; letter-spacing: 5px; color: #fff; font-family: 'Courier New', monospace; margin: 6px 0 18px 0; }
                .gc-row { display: flex; gap: 40px; align-items: flex-end; }
                .gc-amount { font-size: 28px; font-weight: 800; color: #3b82f6; }
                .gc-expiry { font-size: 12px; color: rgba(255,255,255,0.6); }
                .gc-status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; margin-top: 14px; }
                .gc-status-active { background: rgba(76,175,80,0.25); color: #81C784; border: 1px solid rgba(76,175,80,0.4); }
                .gc-status-used { background: rgba(244,67,54,0.2); color: #EF9A9A; border: 1px solid rgba(244,67,54,0.3); }
                .gc-status-expired { background: rgba(158,158,158,0.2); color: #BDBDBD; border: 1px solid rgba(158,158,158,0.3); }
                .gc-balance-bar-wrap { margin-top: 16px; background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; height: 6px; }
                .gc-balance-bar { height: 6px; background: linear-gradient(90deg, #3b82f6, #2563eb); border-radius: 20px; transition: width 0.6s ease; }
            </style>

            <div class="account-header">
                <h1>Cartes cadeaux</h1>
            </div>

            @if(session('success'))
                <div style="background: #ecfdf5; color: #065f46; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; border-left: 5px solid #10b981; font-weight: 500;">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #fef2f2; color: #991b1b; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; border-left: 5px solid #ef4444; font-weight: 500;">
                    <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> {{ session('error') }}
                </div>
            @endif

            {{-- 💳 Info Card / Checkout Section --}}
            <h2 class="section-title">Acheter une carte cadeau</h2>
            @if(isset($giftCardOptions) && count($giftCardOptions) > 0)
                <div class="packs-grid">
                    @foreach($giftCardOptions as $option)
                        <div class="pack-card">
                            <div class="pack-brand">KARNOU</div>
                            
                            <div class="pack-label">Type de carte</div>
                            <div style="font-size: 13px; font-weight: 700; margin-bottom: 8px; color: rgba(255,255,255,0.9);">
                                Carte Cadeau Premium
                            </div>

                            <div class="pack-label">Valeur faciale</div>
                            <div class="pack-value-large">{{ number_format($option->amount, 0, ',', ' ') }} FCFA</div>

                            <div class="pack-price-gold">{{ number_format($option->amount, 0, ',', ' ') }} FCFA</div>

                            @if($option->is_popular)
                                <div>
                                    <span class="pack-bonus-badge">POPULAIRE</span>
                                </div>
                            @endif

                            <form action="{{ route('gift-cards.buy') }}" method="POST" style="width: 100%;">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $option->amount }}">
                                <button type="submit" class="btn-buy-card">
                                    Offrir ce pack
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- 🔍 Vérification de solde --}}
            <h2 class="section-title">Vérifier le solde</h2>
            <div style="background: #fff; padding: 1.5rem; border-radius: 12px; margin-bottom: 3rem; border: 1px solid #f0f0f0;">
                <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">Entrez le code de votre carte pour consulter son solde et son état.</p>
                <div style="display: flex; gap: 0.75rem; max-width: 500px;">
                    <input type="text" id="balance-code-input"
                        placeholder="XXXX-XXXX-XXXX-XXXX"
                        oninput="this.value = this.value.toUpperCase()"
                        style="flex: 1; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.9rem; outline: none; background: #f9fafb; font-family: monospace; font-weight: 700; letter-spacing: 1px;">
                    <button type="button" onclick="checkGiftCardBalance()"
                        style="background: #004aad; color: white; border: none; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 700; cursor: pointer; font-size: 0.9rem; transition: background 0.2s;">
                        Vérifier
                    </button>
                </div>
                <div id="balance-result" style="display: none; margin-top: 1.5rem;"></div>
            </div>

            {{-- 📜 Historique des cartes --}}
            <h2 class="section-title">Mes cartes achetées</h2>
            @if(isset($boughtCards) && $boughtCards->count() > 0)
                <div class="tx-list">
                    @foreach($boughtCards as $card)
                        @php 
                            $isActive = $card->status == 'active';
                        @endphp
                        <div class="tx-item">
                            <div class="tx-icon {{ $isActive ? 'in' : 'out' }}">
                                <i class="fas {{ $isActive ? 'fa-gift' : 'fa-check' }}"></i>
                            </div>
                            <div class="tx-info">
                                <div class="tx-desc">Carte {{ number_format($card->amount, 0, ',', ' ') }} FCFA</div>
                                <div class="tx-date">Commandée le {{ $card->created_at->format('d M Y à H:i') }} • Code: <span style="font-family: monospace; font-weight: 700;">{{ $card->code }}</span></div>
                            </div>
                            <div class="tx-amount {{ $isActive ? 'plus' : 'minus' }}" style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                <span>{{ number_format($card->amount, 0, ',', ' ') }} FCFA</span>
                                <span style="font-size: 0.65rem; padding: 2px 8px; border-radius: 100px; background: {{ $isActive ? '#f0fdf4' : '#f3f4f6' }}; color: {{ $isActive ? '#16a34a' : '#6b7280' }}; border: 1px solid {{ $isActive ? '#dcfce7' : '#e5e7eb' }}; text-transform: uppercase;">
                                    {{ $isActive ? 'Disponible' : 'Utilisée' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="padding: 4rem 2rem; text-align: center; background: #fff; border: 1px solid #f0f0f0; border-radius: 12px;">
                    <i class="fas fa-gift" style="font-size: 3rem; color: #f3f4f6; margin-bottom: 1.5rem; display: block;"></i>
                    <p style="color: #9ca3af; margin: 0; font-size: 0.95rem;">Vous n'avez pas encore acheté de carte cadeau.</p>
                </div>
            @endif

        </main>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
async function checkGiftCardBalance() {
    const code = document.getElementById('balance-code-input').value.trim();
    const resultBox = document.getElementById('balance-result');
    if (!code) return;

    resultBox.style.display = 'block';
    resultBox.innerHTML = '<div style="text-align:center; padding:1rem; color:#666;"><i class="fas fa-spinner fa-spin"></i> Vérification...</div>';

    try {
        const resp = await fetch("{{ route('gift-cards.check-balance') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code })
        });
        const data = await resp.json();

        if (data.success) {
            const pct = data.amount > 0 ? Math.round((data.balance / data.amount) * 100) : 0;
            const statusClass = data.status === 'active' ? 'gc-status-active' : (data.status === 'used' ? 'gc-status-used' : 'gc-status-expired');
            const statusLabel = data.status === 'active' ? '✓ Active' : (data.status === 'used' ? '✗ Utilisée' : '⚠ Expirée');
            const expiryText = data.expiry ? `Exp. ${data.expiry}` : '';

            resultBox.innerHTML = `
                <div class="gift-card-visual">
                    <div class="gc-brand">KARNOU</div>
                    <div class="gc-label">Code de la carte</div>
                    <div class="gc-code">${data.code}</div>
                    <div class="gc-row">
                        <i class="fas fa-gift" style="position: absolute; bottom: 40px; right: 30px; font-size: 40px; color: rgba(255,255,255,0.05); pointer-events: none;"></i>
                        <div>
                            <div class="gc-label">Solde disponible</div>
                            <div class="gc-amount">${data.balance.toLocaleString('fr-FR')} FCFA</div>
                        </div>
                        ${data.amount !== data.balance ? `<div>
                            <div class="gc-label">Valeur initiale</div>
                            <div style="font-size:16px; color:rgba(255,255,255,0.6); font-weight:600;">${data.amount.toLocaleString('fr-FR')} FCFA</div>
                        </div>` : ''}
                    </div>
                    ${data.amount > 0 ? `<div class="gc-balance-bar-wrap" style="margin-top:14px;"><div class="gc-balance-bar" style="width:${pct}%;"></div></div>` : ''}
                    <div>
                        <span class="gc-status-badge ${statusClass}">${statusLabel}</span>
                        ${expiryText ? `<span style="font-size:11px; color:rgba(255,255,255,0.5); margin-left:10px;">${expiryText}</span>` : ''}
                    </div>
                </div>`;
        } else {
            resultBox.innerHTML = `<div style="background:#fff3f3; border:1px solid #ffcdd2; border-radius:8px; padding:1rem; color:#c62828; font-size:0.9rem;">
                <i class="fas fa-times-circle"></i> ${data.message}
            </div>`;
        }
    } catch (e) {
        resultBox.innerHTML = '<div style="color:#721c24; text-align:center; padding:1rem;">Erreur de connexion.</div>';
    }
}
</script>
@endpush

