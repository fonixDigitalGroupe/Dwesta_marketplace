@extends('layouts.app')

@section('title', 'Cartes Cadeaux - Mady Market')

<style>
    html, body, .dashboard-container, .main-content {
        background-color: #fff !important;
    }

    .gift-card-page {
        max-width: 900px;
    }

    .gift-card-box {
        background: #fff;
        border: 1px solid #eeeeee;
        border-radius: 8px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #004aad;
    }

    .redeem-form .input-group {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .redeem-form .input-group:focus-within {
        border-color: #004aad;
    }

    .redeem-form input {
        border: none !important;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        flex: 1;
        outline: none;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .redeem-form button {
        background: #004aad;
        color: white;
        border: none;
        padding: 0 1.5rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }

    .redeem-form button:hover {
        background: #003680;
    }

    /* Purchase Cards Grid */
    .gift-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.25rem;
    }

    .purchase-card {
        border: 1px solid #efefef;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.2s;
        background: #fafafa;
        position: relative;
    }

    .purchase-card:hover {
        border-color: #004aad;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background: #fff;
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
    }

    .purchase-card .amount {
        font-size: 1.5rem;
        font-weight: 800;
        color: #f68b1e;
        margin-bottom: 0.25rem;
    }

    .purchase-card .desc {
        color: #777;
        font-size: 0.8rem;
        margin-bottom: 1.25rem;
        height: 2.4rem;
        overflow: hidden;
    }

    .btn-buy-now {
        width: 100%;
        padding: 0.65rem;
        border: 1px solid #004aad;
        background: #fff;
        color: #004aad;
        border-radius: 4px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-buy-now:hover {
        background: #004aad;
        color: #fff;
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
        background: #fcfcfc;
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
    }

    .status-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-active { background: #e8f5e9; color: #2e7d32; }
    .status-used { background: #f5f5f5; color: #999; }
</style>

@section('content')

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content gift-card-page">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Cartes cadeaux</h1>
        </div>

        @if(session('success'))
            <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #ffcdd2;">
                ❌ {{ session('error') }}
            </div>
        @endif

        <div class="gift-card-box">
            <h2 class="section-title">
                <i class="fa-solid fa-ticket"></i>
                Utiliser un code
            </h2>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">Entrez le code de votre carte cadeau pour créditer votre porte-monnaie.</p>
            
            <form action="{{ route('gift-cards.redeem') }}" method="POST" class="redeem-form">
                @csrf
                <div class="input-group">
                    <input type="text" name="code" placeholder="XXXX-XXXX-XXXX" required>
                    <button type="submit">Appliquer</button>
                </div>
            </form>
        </div>

        <div class="gift-card-box">
            <h2 class="section-title">
                <i class="fa-solid fa-cart-shopping"></i>
                Acheter une carte cadeau
            </h2>
            <div class="gift-cards-grid">
                @forelse($giftCardOptions as $option)
                    <div class="purchase-card {{ $option->is_popular ? 'popular' : '' }}">
                        @if($option->is_popular)
                            <span class="popular-badge">Populaire</span>
                        @endif
                        <div class="amount">{{ number_format($option->amount, 0, ',', ' ') }} <small style="font-size: 0.8rem;">FCFA</small></div>
                        <div class="desc">{{ $option->description ?: 'Créditez votre compte instantanément.' }}</div>
                        <form action="{{ route('gift-cards.buy') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $option->amount }}">
                            <button type="submit" class="btn-buy-now">Acheter maintenant</button>
                        </form>
                    </div>
                @empty
                    <p style="color: #666; font-size: 0.9rem; grid-column: 1/-1; text-align: center; padding: 2rem;">Aucune option de carte cadeau n'est disponible pour le moment.</p>
                @endforelse
            </div>
        </div>

        @if($boughtCards->isNotEmpty())
            <div class="gift-card-box" style="padding: 0; overflow: hidden;">
                <div style="padding: 1.75rem 1.75rem 0.5rem 1.75rem;">
                    <h2 class="section-title">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Mes cartes achetées
                    </h2>
                </div>
                <div style="overflow-x: auto;">
                    <table class="table-cards">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Valeur</th>
                                <th>Statut</th>
                                <th>Date d'achat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($boughtCards as $card)
                                <tr>
                                    <td><span class="code-badge">{{ $card->code }}</span></td>
                                    <td style="font-weight: 700; color: #333;">{{ number_format($card->amount, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="status-badge status-{{ $card->status }}">
                                            {{ $card->status == 'active' ? 'Disponible' : 'Utilisée' }}
                                        </span>
                                    </td>
                                    <td style="color: #777;">{{ $card->created_at->format('d/m/Y') }}</td>
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
