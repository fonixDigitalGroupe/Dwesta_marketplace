@extends('layouts.app')

@section('title', 'Mes Crédits - Karnou')

@push('styles')
    <style>
        .gift-card-page {
            width: 100%;
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
            display: none;
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

        .purchase-card .price {
            font-size: 0.9rem;
            font-weight: 700;
            color: #f68b1e;
            margin-bottom: 0.5rem;
        }

        .purchase-card .desc {
            color: #777;
            font-size: 0.75rem;
            margin-bottom: 0.75rem;
            min-height: auto;
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
            text-decoration: none;
            margin-top: auto;
        }

        .purchase-card:first-child .btn-buy-now,
        .purchase-card:last-child .btn-buy-now {
            background: #004aad;
        }

        .purchase-card:first-child .btn-buy-now:hover,
        .purchase-card:last-child .btn-buy-now:hover {
            background: #003685;
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

        .status-positive { background: #e8f5e9; color: #2e7d32; }
        .status-negative { background: #ffebee; color: #c62828; }

        @media (max-width: 991px) {
            .gift-cards-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 767px) {
            .gift-cards-grid { grid-template-columns: 1fr; }
        }
    </style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content gift-card-page">
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mes Crédits</h1>
            </div>

            @if(session('success'))
                <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="gift-card-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 class="section-title" style="margin-bottom: 0;">
                         Acheter des crédits
                    </h2>
                    <div style="font-size: 0.9rem; font-weight: 700; color: #333; background: #fcfcfc; border: 1px solid #eee; padding: 0.4rem 1rem; border-radius: 6px; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-wallet" style="color: #f68b1e;"></i>
                        Solde : {{ number_format($balance, 0, ',', ' ') }} Crédits
                    </div>
                </div>

                @if(isset($packs) && $packs->count() > 0)
                    <div class="gift-cards-grid">
                        @foreach($packs as $pack)
                            @php
                                $isPopular = ($pack->nom ?? $pack->label ?? '') === 'Pack 25 000' || ($pack->popular ?? false);
                            @endphp
                            <div class="purchase-card {{ $isPopular ? 'popular' : '' }}">
                                @if($isPopular)
                                    <span class="popular-badge">Populaire</span>
                                @endif
                                <div class="amount">{{ number_format($pack->credits, 0, ',', ' ') }} <small style="font-size: 0.8rem; opacity: 0.7;">CRÉDITS</small></div>
                                <div class="price">{{ number_format($pack->prix, 0, ',', ' ') }} <small style="font-size: 0.8rem;">FCFA</small></div>
                                <div class="desc">
                                    {{ $pack->nom ??  'Créditez votre compte instantanément.' }}
                                    @if(($pack->bonus_credits ?? 0) > 0)
                                        <div style="margin-top: 5px; color: #059669; font-weight: 800; font-size: 0.7rem;">+{{ number_format($pack->bonus_credits) }} FCFA OFFERTS</div>
                                    @endif
                                </div>
                                <form action="{{ route('credits.buy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pack_id" value="{{ $pack->id }}">
                                    <button type="submit" class="btn-buy-now">Acheter maintenant</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: #666; font-size: 0.9rem; text-align: center; padding: 2rem;">Aucun pack disponible pour le moment.</p>
                @endif
            </div>

            <div class="gift-card-box">
                <h2 class="section-title">
                     Historique des transactions
                </h2>
                <div style="overflow-x: auto; border: 1px solid #eee; border-radius: 8px;">
                    <table class="table-cards">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th style="text-align: right;">Montant</th>
                                <th style="width: 50px; text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td style="color: #777;">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div style="font-weight: 500; color: #555;">{{ $transaction->description }}</div>
                                    </td>
                                    <td style="text-align: right; font-weight: 500; color: {{ $transaction->montant > 0 ? '#2e7d32' : '#c62828' }};">
                                        {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant, 0, ',', ' ') }} crédits
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="{{ route('account.credits.transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Supprimer cette transaction de l\'historique ?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #aaa; cursor: pointer; font-size: 0.75rem; font-weight: 500; padding: 5px; text-transform: uppercase;" title="Supprimer">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem; color: #999;">Aucune transaction enregistrée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($transactions->hasPages())
                <div style="margin-top: 1.5rem;">
                    {{ $transactions->links() }}
                </div>
            @endif
        </main>
    </div>
@endsection
