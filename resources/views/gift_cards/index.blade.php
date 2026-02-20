@extends('layouts.app')

@section('title', 'Cartes Cadeaux - Mady Market')

@push('styles')
<style>
    .gift-card-page {
        max-width: 900px;
    }
    .gift-card-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .gift-card-design {
        background: linear-gradient(135deg, #f39c12 0%, #d35400 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(211, 84, 0, 0.3);
    }
    .gift-card-design::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .card-logo {
        font-weight: 900;
        font-size: 1.2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-amount {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
    }
    .card-code {
        font-family: monospace;
        letter-spacing: 2px;
        font-size: 1.2rem;
        background: rgba(0,0,0,0.2);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: inline-block;
    }
    .redeem-form input {
        border-radius: 8px 0 0 8px !important;
        border: 2px solid #e0e0e0;
        padding: 0.75rem 1rem;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .redeem-form button {
        border-radius: 0 8px 8px 0 !important;
        background: #222;
        color: white;
        font-weight: bold;
        padding: 0 1.5rem;
    }
    .table-cards {
        width: 100%;
        border-collapse: collapse;
    }
    .table-cards th {
        text-align: left;
        padding: 1rem;
        background: #f8f9fa;
        color: #888;
        font-size: 0.8rem;
        text-transform: uppercase;
    }
    .table-cards td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }
    .status-badge {
        padding: 0.2rem 0.6rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-active { background: #e8f5e9; color: #2e7d32; }
    .status-used { background: #eee; color: #888; }
</style>
@endpush

@section('content')
<div class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('account.index') }}">Mon Compte</a> > <span>Cartes cadeaux</span>
</div>

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content gift-card-page">
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem;">Cartes cadeaux</h1>

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
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Utiliser un code</h2>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">Entrez le code de votre carte cadeau pour créditer votre porte-monnaie.</p>
            
            <form action="{{ route('gift-cards.redeem') }}" method="POST" class="redeem-form">
                @csrf
                <div style="display: flex;">
                    <input type="text" name="code" placeholder="XXXX-XXXX-XXXX" class="form-control" style="flex: 1;" required>
                    <button type="submit" class="btn">Appliquer</button>
                </div>
            </form>
        </div>

        <div class="gift-card-box">
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Acheter une carte cadeau</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <!-- Pack 5000 -->
                <div style="border: 2px solid #eee; border-radius: 12px; padding: 1.5rem; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 900; margin-bottom: 0.5rem;">5 000 FCFA</div>
                    <p style="color: #888; font-size: 0.8rem; margin-bottom: 1.5rem;">Idéal pour un petit cadeau</p>
                    <form action="{{ route('gift-cards.buy') }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="5000">
                        <button type="submit" style="width: 100%; padding: 0.75rem; border: none; background: #ef6c00; color: white; border-radius: 6px; font-weight: bold; cursor: pointer;">Acheter</button>
                    </form>
                </div>
                <!-- Pack 10000 -->
                <div style="border: 2px solid #ef6c00; border-radius: 12px; padding: 1.5rem; text-align: center; position: relative;">
                    <span style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #ef6c00; color: white; font-size: 0.65rem; padding: 2px 10px; border-radius: 10px; font-weight: 800;">POPULAIRE</span>
                    <div style="font-size: 1.5rem; font-weight: 900; margin-bottom: 0.5rem;">10 000 FCFA</div>
                    <p style="color: #888; font-size: 0.8rem; margin-bottom: 1.5rem;">Le cadeau parfait</p>
                    <form action="{{ route('gift-cards.buy') }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="10000">
                        <button type="submit" style="width: 100%; padding: 0.75rem; border: none; background: #ef6c00; color: white; border-radius: 6px; font-weight: bold; cursor: pointer;">Acheter</button>
                    </form>
                </div>
            </div>
        </div>

        @if($boughtCards->isNotEmpty())
            <div class="gift-card-box">
                <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Mes cartes achetées</h2>
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
                                    <td style="font-family: monospace; font-weight: bold;">{{ $card->code }}</td>
                                    <td>{{ number_format($card->amount, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="status-badge status-{{ $card->status }}">
                                            {{ $card->status == 'active' ? 'Disponible' : 'Utilisée' }}
                                        </span>
                                    </td>
                                    <td style="color: #888; font-size: 0.85rem;">{{ $card->created_at->format('d/m/Y') }}</td>
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
