@extends('layouts.app')

@section('title', 'Cartes Cadeaux - Karnou')

@push('styles')
<style>
    /* variables & Base Styles */
    :root {
        --primary-blue: #004aad;
        --primary-orange: #f6a200;
        --soft-gray: #f8f9fa;
        --border-color: #e9ecef;
        --text-main: #333;
        --text-muted: #6c757d;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        --card-shadow-hover: 0 8px 24px rgba(0, 74, 173, 0.12);
    }

    .gift-card-page {
        max-width: 960px;
        margin: 0 auto;
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
        color: var(--primary-orange);
        font-size: 1.1rem;
    }

    /* Purchase Cards Grid */
    .gift-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .purchase-card {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    .purchase-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: var(--primary-blue);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .purchase-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--primary-blue);
    }

    .purchase-card:hover::before {
        opacity: 1;
    }

    .purchase-card.popular {
        border-color: var(--primary-orange);
    }

    .purchase-card.popular::before {
        background: var(--primary-orange);
        opacity: 1;
    }

    .popular-badge {
        position: absolute;
        top: 15px;
        right: -30px;
        background: var(--primary-orange);
        color: white;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 35px;
        transform: rotate(45deg);
        text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .purchase-card .card-visual {
        width: 120px;
        height: 75px;
        background: linear-gradient(135deg, var(--primary-blue) 0%, #1a5ccc 100%);
        margin: 0 auto 1.5rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 900;
        font-size: 1.2rem;
        box-shadow: 0 6px 12px rgba(0, 74, 173, 0.2);
        position: relative;
    }
    
    .purchase-card.popular .card-visual {
        background: linear-gradient(135deg, var(--primary-orange) 0%, #e67e00 100%);
        box-shadow: 0 6px 12px rgba(246, 162, 0, 0.2);
    }

    .purchase-card .amount {
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--text-main);
        margin-bottom: 0.25rem;
        letter-spacing: -0.5px;
    }

    .purchase-card .currency {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .purchase-card .desc {
        color: var(--text-muted);
        font-size: 0.8rem;
        margin: 1rem 0 1.5rem;
        line-height: 1.5;
        min-height: 2.4rem;
    }

    .btn-buy-now {
        width: 100%;
        padding: 0.85rem;
        border: none;
        background: var(--primary-blue);
        color: #fff;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 10px rgba(0, 74, 173, 0.15);
    }

    .purchase-card.popular .btn-buy-now {
        background: var(--primary-orange);
        box-shadow: 0 4px 10px rgba(246, 162, 0, 0.15);
    }

    .btn-buy-now:hover {
        transform: scale(1.02);
        opacity: 0.95;
        color: #fff;
    }

    /* Balance Checker Tool */
    .balance-checker-container {
        background: #fff;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 3rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
    }

    .balance-checker-card {
        background: linear-gradient(135deg, #101828 0%, #1d2939 100%);
        border-radius: 24px;
        padding: 2.5rem;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(16, 24, 40, 0.15);
    }

    .balance-checker-card::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        top: -100px;
        right: -100px;
    }

    .balance-checker-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--primary-orange);
        margin-bottom: 0.5rem;
    }

    .balance-checker-subtitle {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 2rem;
        line-height: 1.2;
    }

    .balance-input-wrapper {
        display: flex;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 6px;
        border-radius: 16px;
        backdrop-filter: blur(10px);
        margin-bottom: 0;
        max-width: 500px;
    }

    .balance-input-wrapper input {
        flex: 1;
        background: transparent;
        border: none;
        color: #fff;
        padding: 12px 20px;
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        outline: none;
    }

    .balance-input-wrapper input::placeholder {
        color: rgba(255, 255, 255, 0.4);
        font-weight: 500;
        letter-spacing: 0;
    }

    .balance-input-wrapper button {
        background: var(--primary-orange);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0 24px;
        font-size: 0.9rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s;
    }

    .balance-input-wrapper button:hover {
        background: #ffab00;
        transform: translateX(4px);
    }

    .balance-result {
        margin-top: 2rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 18px;
        padding: 2rem;
        display: none;
        animation: fadeInSlide 0.4s ease-out;
    }

    @keyframes fadeInSlide {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .balance-result-amount {
        font-size: 2.5rem;
        font-weight: 900;
        color: #fff;
    }

    /* History Table Styling */
    .history-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
    }

    .table-responsive {
        margin: 0 -1rem;
    }

    .table-cards {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table-cards th {
        padding: 1rem 1.5rem;
        text-align: left;
        color: var(--text-muted);
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-cards tr td {
        background: var(--soft-gray);
        padding: 1.25rem 1.5rem;
        transition: transform 0.2s;
    }

    .table-cards tr td:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    .table-cards tr td:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

    .table-cards tr:hover td {
        background: #f1f3f5;
        transform: scale(1.002);
    }

    .code-badge {
        font-family: 'DM Mono', 'Courier New', monospace;
        background: #fff;
        color: var(--primary-blue);
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.85rem;
        border: 1px solid var(--border-color);
        letter-spacing: 0.5px;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-active { background: #e6fffa; color: #088a6d; }
    .status-used { background: #fee2e2; color: #b91c1c; }

    .btn-delete {
        color: #9ca3af;
        transition: color 0.2s;
        padding: 8px;
        border-radius: 8px;
    }
    .btn-delete:hover {
        color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }

    @media (max-width: 991px) {
        .gift-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 767px) {
        .gift-cards-grid { grid-template-columns: 1fr; }
        .gift-card-header { flex-direction: column; text-align: center; gap: 1rem; }
        .balance-checker-subtitle { font-size: 1.2rem; }
        .balance-input-wrapper { flex-direction: column; background: transparent; border: none; padding: 0; gap: 12px; }
        .balance-input-wrapper input { background: rgba(255,255,255,0.1); border-radius: 12px; border: 1px solid rgba(255,255,255,0.2); }
        .balance-input-wrapper button { padding: 15px; }
    }
</style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content gift-card-page">
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Cartes cadeaux</h1>
            </div>

            <!-- Notifications -->
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4" style="border-radius: 12px; padding: 1rem 1.5rem;">
                    <i class="fas fa-check-circle me-3" style="font-size: 1.2rem;"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-4" style="border-radius: 12px; padding: 1rem 1.5rem;">
                    <i class="fas fa-exclamation-triangle me-3" style="font-size: 1.2rem;"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- Purchase Section -->
            <div class="gift-card-section mb-5">
                <h2 class="section-title">
                    <i class="fas fa-shopping-basket"></i>
                    Acheter une carte
                </h2>
                <div class="gift-cards-grid">
                    @forelse($giftCardOptions as $option)
                        <div class="purchase-card {{ $option->is_popular ? 'popular' : '' }}">
                            @if($option->is_popular)
                                <span class="popular-badge">Top Vente</span>
                            @endif
                            
                            <div class="card-visual">
                                KARNOU
                            </div>
                            
                            <div>
                                <div class="amount">{{ number_format($option->amount, 0, ',', ' ') }} <small class="currency">FCFA</small></div>
                                <div class="desc">{{ $option->description ?: 'Créditez votre compte Dwesta instantanément avec cette carte.' }}</div>
                            </div>

                            <form action="{{ route('gift-cards.buy') }}" method="POST">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $option->amount }}">
                                <button type="submit" class="btn-buy-now">
                                    <span>Prendre cette carte</span>
                                    <i class="fas fa-arrow-right ml-2" style="font-size: 0.8rem;"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: #fff; border-radius: 20px; border: 1px dashed var(--border-color);">
                            <p style="color: var(--text-muted); margin: 0;">Aucune option disponible actuellement.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Balance Checker Tool -->
            <div class="balance-checker-container">
                <h2 class="section-title"><i class="fas fa-shield-alt"></i> Vérification de sécurité</h2>
                <div class="balance-checker-card">
                    <div class="balance-checker-title">Wallet Tools</div>
                    <div class="balance-checker-subtitle">Consulter le solde d'une<br>carte cadeau Dwesta</div>
                    
                    <div class="balance-input-wrapper">
                        <input type="text" id="balance-code-input" placeholder="XXXX-XXXX-XXXX-XXXX" oninput="this.value = this.value.toUpperCase()">
                        <button type="button" onclick="checkGiftCardBalance()">Vérifier</button>
                    </div>

                    <div class="balance-result" id="balance-result">
                        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <div>
                                <div class="balance-result-amount"><span id="br-balance">0</span> <small style="font-size: 1.2rem; opacity: 0.7;">FCFA</small></div>
                                <div style="font-size: 0.9rem; opacity: 0.6; text-transform: uppercase; font-weight: 700; margin-top: 4px;">Solde Actuel</div>
                            </div>
                            <div id="br-status-badge"></div>
                        </div>
                        
                        <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 1.5rem 0;"></div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                            <div>
                                <div style="font-size: 0.7rem; opacity: 0.5; text-transform: uppercase; margin-bottom: 4px;">Code de la carte</div>
                                <div id="br-code" style="font-weight: 800; font-family: monospace; letter-spacing: 1px;">-</div>
                            </div>
                            <div>
                                <div style="font-size: 0.7rem; opacity: 0.5; text-transform: uppercase; margin-bottom: 4px;">Valeur Faciale</div>
                                <div id="br-amount" style="font-weight: 800;">0 FCFA</div>
                            </div>
                        </div>
                        
                        <div id="br-expiry-wrap" style="margin-top: 1.5rem; display: none;">
                            <div style="font-size: 0.7rem; opacity: 0.5; text-transform: uppercase; margin-bottom: 4px;">Date d'expiration</div>
                            <div id="br-expiry" style="font-weight: 800;">-</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purchase History -->
            @if($boughtCards->isNotEmpty())
                <div class="history-card">
                    <h2 class="section-title">
                        <i class="fas fa-history"></i>
                        Historique de mes achats
                    </h2>
                    <div class="table-responsive">
                        <table class="table-cards">
                            <thead>
                                <tr>
                                    <th>Code Secret</th>
                                    <th>Valeur</th>
                                    <th>État</th>
                                    <th>Acheté le</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($boughtCards as $card)
                                    <tr>
                                        <td><span class="code-badge">{{ $card->code }}</span></td>
                                        <td>
                                            <div style="font-weight: 800; color: var(--text-main);">{{ number_format($card->amount, 0, ',', ' ') }} FCFA</div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $card->status }}">
                                                <i class="fas {{ $card->status == 'active' ? 'fa-check' : 'fa-times-circle' }}"></i>
                                                {{ $card->status == 'active' ? 'Disponible' : 'Utilisée' }}
                                            </span>
                                        </td>
                                        <td style="color: var(--text-muted); font-size: 0.85rem;">
                                            {{ $card->created_at->translatedFormat('d M Y') }}
                                        </td>
                                        <td style="text-align: right;">
                                            <form action="{{ route('gift-cards.destroy', $card->id) }}" method="POST" onsubmit="return confirm('Confirmez-vous la suppression de cette carte ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete" title="Supprimer">
                                                    <i class="far fa-trash-alt"></i>
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
    if (!code) { return; }
    
    const btn = document.querySelector('.balance-input-wrapper button');
    const originalText = btn.innerText;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
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
            document.getElementById('br-amount').innerText = data.amount.toLocaleString('fr-FR') + ' FCFA';
            document.getElementById('br-code').innerText = data.code;
            
            const badge = document.getElementById('br-status-badge');
            if (data.status === 'active' && data.balance > 0) {
                badge.innerHTML = '<span class="status-badge status-active">Valide</span>';
            } else {
                badge.innerHTML = '<span class="status-badge status-used">Invalide</span>';
            }
            
            const expiryWrap = document.getElementById('br-expiry-wrap');
            if (data.expiry) { 
                document.getElementById('br-expiry').innerText = data.expiry; 
                expiryWrap.style.display = 'block'; 
            } else { 
                expiryWrap.style.display = 'none'; 
            }
        } else {
            resultBox.innerHTML = '<div style="color: #ff8a8a; font-weight: 600;"><i class="fas fa-exclamation-circle mr-2"></i> ' + data.message + '</div>';
        }
    } catch (e) {
        resultBox.style.display = 'block';
        resultBox.innerHTML = '<div style="color: #ff8a8a;">Erreur de connexion.</div>';
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('balance-code-input');
    if (input) input.addEventListener('keydown', e => { if (e.key === 'Enter') checkGiftCardBalance(); });
});
</script>
@endpush
