@extends('layouts.app')

@section('title', 'Cartes Cadeaux - Karnou')

@push('styles')
<style>
    .gift-card-page {
        width: 100%;
    }

    /* Hide everything in header except logo */
    .top-banner,
    .mobile-menu-btn,
    .search-container,
    .header-actions,
    .mobile-search-row,
    .header-row-2 {
        display: none !important;
    }

    .header-row-1 .header-container {
        justify-content: center !important;
    }

    .header-logo-text img {
        height: 26px !important;
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
        display: none;
    }

    /* Purchase Cards Grid */
    .gift-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-bottom: 2.5rem;
    }

    .purchase-card {
        border: 1px solid #efefef;
        border-radius: 10px;
        padding: 1.5rem 1rem;
        text-align: center;
        background: #fff;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        transition: transform 0.2s;
    }

    .purchase-card.popular {
        border-color: #f68b1e;
        background: #fffaf5;
    }

    .card-visual {
        height: 80px;
        background: linear-gradient(135deg, #eee 0%, #ddd 100%);
        border-radius: 8px;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .card-visual i {
        font-size: 2.5rem;
        color: rgba(0,0,0,0.1);
        z-index: 1;
    }

    .purchase-card:nth-child(1) .card-visual { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
    .purchase-card:nth-child(2) .card-visual { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    .purchase-card:nth-child(3) .card-visual { background: linear-gradient(135deg, #0ba360 0%, #3cba92 100%); color: white; }

    .card-visual .gift-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1rem;
        opacity: 0.8;
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
        margin-bottom: 0;
    }

    .purchase-card .desc {
        color: #777;
        font-size: 0.75rem;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .btn-buy-now {
        width: 100%;
        padding: 0.7rem;
        border: none;
        background: #f68b1e;
        color: #fff;
        border-radius: 6px;
        font-weight: 800;
        font-size: 0.85rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-buy-now:hover {
        background: #e67e00;
        color: #fff;
    }

    .purchase-card:first-child .btn-buy-now,
    .purchase-card:last-child .btn-buy-now {
        background: #004aad;
    }

    .purchase-card:first-child .btn-buy-now:hover,
    .purchase-card:last-child .btn-buy-now:hover {
        background: #003685;
    }

    /* Balance Checker Tool */
    .balance-checker-container {
        background: #fff;
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2.5rem;
        border: 1px solid #efefef;
    }

    .balance-checker-card {
        background: #1a1f2c;
        border-radius: 12px;
        padding: 2rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .balance-checker-card::after {
        content: '\f06b';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        bottom: -20px;
        right: -10px;
        font-size: 8rem;
        color: rgba(255, 255, 255, 0.05);
        pointer-events: none;
    }

    .balance-checker-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #f68b1e;
        margin-bottom: 0.5rem;
    }

    .balance-checker-subtitle {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .balance-input-wrapper {
        display: flex;
        gap: 10px;
    }

    .balance-input-wrapper input {
        flex: 1;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        padding: 10px 15px;
        border-radius: 6px;
        outline: none;
    }

    .balance-input-wrapper button {
        background: #f68b1e;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 0 20px;
        font-weight: 700;
        cursor: pointer;
    }

    .balance-result {
        margin-top: 1.5rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        display: none;
    }

    /* History Table */
    .history-card {
        background: #fff;
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid #efefef;
    }

    .table-cards {
        width: 100%;
        border-collapse: collapse;
    }

    .table-cards th {
        text-align: left;
        padding: 0.75rem;
        color: #888;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid #eee;
    }

    .table-cards td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #f9f9f9;
        font-size: 0.9rem;
    }

    .code-badge {
        font-family: monospace;
        background: #f4f4f4;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 700;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .status-active { background: #e8f5e9; color: #2e7d32; }
    .status-used { background: #fee2e2; color: #b91c1c; }

    @media (max-width: 991px) {
        .gift-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 767px) {
        .gift-cards-grid { grid-template-columns: 1fr; }
        .balance-input-wrapper { flex-direction: column; }
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

            @if(session('success'))
                <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="gift-card-section mb-5">
                <h2 class="section-title">
                    <i class="fas fa-shopping-basket"></i>
                    Acheter une carte
                </h2>
                <div class="gift-cards-grid">
                    @forelse($giftCardOptions as $option)
                        <div class="purchase-card {{ $option->is_popular ? 'popular' : '' }}">
                            @if($option->is_popular)
                                <span class="popular-badge">Populaire</span>
                            @endif
                            
                            <div class="card-visual">
                                <i class="fas fa-gift"></i>
                                <span class="gift-badge"><i class="fas fa-medal"></i></span>
                            </div>

                            <div>
                                <div class="amount">{{ number_format($option->amount, 0, ',', ' ') }} <small style="font-size: 0.8rem; opacity: 0.7;">FCFA</small></div>
                                <div class="desc">{{ $option->description ?: 'Créditez votre compte instantanément.' }}</div>
                            </div>

                            <form action="{{ route('gift-cards.buy') }}" method="POST">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $option->amount }}">
                                <button type="submit" class="btn-buy-now">Prendre cette carte</button>
                            </form>
                        </div>
                    @empty
                        <p style="grid-column: 1/-1; text-align: center; padding: 2rem; color: #666;">Aucune option disponible.</p>
                    @endforelse
                </div>
            </div>

            <div class="balance-checker-container">
                <h2 class="section-title"><i class="fas fa-shield-alt"></i> Vérification</h2>
                <div class="balance-checker-card">
                    <div class="balance-checker-title">Ma Carte</div>
                    <div class="balance-checker-subtitle">Consulter le solde d'une carte</div>
                    
                    <div class="balance-input-wrapper">
                        <input type="text" id="balance-code-input" placeholder="XXXX-XXXX-XXXX-XXXX" oninput="this.value = this.value.toUpperCase()">
                        <button type="button" onclick="checkGiftCardBalance()">Vérifier</button>
                    </div>

                    <div class="balance-result" id="balance-result"></div>
                </div>
            </div>

            <div class="history-card">
                <h2 class="section-title">
                    Mes achats
                </h2>
                <div style="overflow-x: auto; border: 1px solid #eee; border-radius: 8px;">
                    <table class="table-cards">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Valeur</th>
                                <th>État</th>
                                <th>Date</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($boughtCards as $card)
                                <tr>
                                    <td><span class="code-badge">{{ $card->code }}</span></td>
                                    <td>{{ number_format($card->amount, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="status-badge status-{{ $card->status }}">
                                            {{ $card->status == 'active' ? 'Disponible' : 'Utilisée' }}
                                        </span>
                                    </td>
                                    <td style="color: #666;">{{ $card->created_at->format('d/m/Y') }}</td>
                                    <td style="text-align: right;">
                                        <form action="{{ route('gift-cards.destroy', $card->id) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #888; cursor: pointer; font-size: 0.8rem;">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 2.5rem; color: #999;">
                                        <i class="fas fa-shopping-cart" style="display:block; font-size: 1.5rem; margin-bottom: 0.5rem; opacity: 0.3;"></i>
                                        Aucun achat de carte cadeau pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
            resultBox.innerHTML = `<div style="font-weight: 700;">Solde : ${data.balance.toLocaleString()} FCFA</div>
                                  <div style="font-size: 0.8rem; opacity: 0.8;">État : ${data.status}</div>`;
        } else {
            resultBox.innerHTML = `<div style="color: #ff8a8a;">${data.message}</div>`;
        }
    } catch (e) {
        resultBox.innerHTML = 'Erreur.';
    }
}
</script>
@endpush
