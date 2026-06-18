@extends('layouts.app')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    .wallet-page {
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        max-width: 1000px;
        background-color: #f7f8f8;
        padding: 2rem;
        border-radius: 8px;
    }

    .amazon-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .amazon-card-header {
        padding: 1rem 1.5rem;
        background-color: #f0f2f2;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .amazon-card-header h2 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f1111;
    }

    .amazon-card-content {
        padding: 1.5rem;
    }

    /* Summary Section Layout */
    .wallet-summary-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        align-items: start;
    }

    .balance-box {
        padding: 1.5rem;
        border-right: 1px solid #eee;
    }

    .balance-value {
        font-size: 2.2rem;
        font-weight: 600;
        color: #0f1111;
        margin-bottom: 0.25rem;
    }

    .balance-currency {
        font-size: 1rem;
        font-weight: 500;
        color: #565959;
    }

    .pending-status-box {
        background-color: #fffaf0;
        border: 1px solid #fbd8b4;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 1rem;
    }

    /* Transaction Table */
    .amazon-table {
        width: 100%;
        border-collapse: collapse;
    }

    .amazon-table th {
        background-color: #f0f2f2;
        color: #565959;
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .amazon-table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
        font-size: 0.9rem;
        color: #0f1111;
    }

    .amazon-table tr:hover {
        background-color: #f7f8f8;
    }

    /* Form Styling */
    .amazon-input {
        width: 100%;
        padding: 0.6rem 0.75rem;
        border: 1px solid #888c8c;
        border-radius: 4px;
        font-size: 0.9rem;
        box-shadow: 0 1px 2px rgba(15,17,17,.15) inset;
        outline: none;
    }

    .amazon-input:focus {
        border-color: #e77600;
        box-shadow: 0 0 3px 2px rgba(228,121,17,.5);
    }

    .btn-amazon-primary {
        background: #004aad;
        border-color: #003a8c;
        color: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,.1);
        padding: 0.6rem 1.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid;
        transition: all 0.2s;
    }

    .btn-amazon-primary:hover {
        background: #0056cc;
        border-color: #004aad;
        color: #fff;
    }

    .btn-amazon-outline {
        background: #fff;
        border: 1px solid #D5D9D9;
        color: #0F1111;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        box-shadow: 0 1px 2px 0 rgba(0,0,0,.05);
    }

    .btn-amazon-outline:hover {
        background-color: #f7fafa;
    }

    .status-pill {
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-available { background: #e7f4e4; color: #007600; }
    .status-pending { background: #fff4e5; color: #854d0e; }
    .status-withdrawn { background: #f3f3f3; color: #565959; }

    /* Payment icons */
    .pay-method-chip {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .pay-method-chip.active {
        border-color: #007185;
        background-color: #f0f7f8;
        box-shadow: 0 0 0 1px #007185;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content wallet-page">
        <div style="padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.15rem; font-weight: 600; color: #333; margin: 0;">Mon Portefeuille</h1>
        </div>
        <p style="color: #565959; font-size: 0.88rem; margin-top: -0.75rem; margin-bottom: 1.5rem;">Gérez vos revenus et demandez des virements vers votre compte mobile money.</p>

        @if(session('success'))
            <div style="background: #e7f4e4; color: #007600; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #007600; font-size: 0.9rem;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fffafa; color: #ba000d; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #ba000d; font-size: 0.9rem;">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Amazon Style Summary Card -->
        <div class="amazon-card">
            <div class="amazon-card-header">
                <h2>Récapitulatif du solde</h2>
                <span style="font-size: 0.8rem; color: #f68b1e; font-weight: 500;">Mis à jour à l'instant</span>
            </div>
            <div class="amazon-card-content">
                <div class="wallet-summary-grid">
                    <div class="balance-box">
                        <div style="font-size: 0.9rem; color: #565959; margin-bottom: 0.5rem;">Solde disponible pour retrait</div>
                        <div class="balance-value">
                            {{ number_format($availableBalance, 0, ',', ' ') }}
                            <span class="balance-currency">FCFA</span>
                        </div>
                        
                        @if($pendingBalance > 0)
                        <div class="pending-status-box">
                            <i class="fas fa-info-circle" style="color: #007185;"></i>
                            <div>
                                <div style="font-size: 0.85rem; font-weight: 700; color: #0f1111;">{{ number_format($pendingBalance, 0, ',', ' ') }} FCFA en attente</div>
                                <div style="font-size: 0.75rem; color: #565959;">Ces fonds seront libérés automatiquement après livraison des commandes.</div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div style="padding: 1.5rem;">
                        <h3 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 1rem; color: #0f1111;">Actions rapides</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <button class="btn-amazon-primary" onclick="document.getElementById('withdraw-section').scrollIntoView({behavior: 'smooth'})">Effectuer un retrait</button>
                            <button class="btn-amazon-outline" style="color: #b12704; border-color: #d5d9d9;" onclick="window.print()">
                                <i class="fas fa-file-pdf" style="margin-right: 5px;"></i> Relevé (PDF)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Section -->
        <div class="amazon-card" id="withdraw-section">
            <div class="amazon-card-header">
                <h2>Demander un virement</h2>
                <i class="fas fa-university" style="color: #565959;"></i>
            </div>
            <div class="amazon-card-content">
                @if($availableBalance >= 1000)
                    <form action="{{ route('vendeur.wallet.withdraw') }}" method="POST">
                        @csrf
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                            <div>
                                <label style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 0.5rem;">Montant du retrait</label>
                                <div style="position: relative;">
                                    <input type="number" name="montant" class="amazon-input" max="{{ $availableBalance }}" min="1000" required placeholder="Min. 1000 FCFA">
                                    <span style="position: absolute; right: 10px; top: 8px; color: #888; font-size: 0.85rem;">FCFA</span>
                                </div>
                                <p style="font-size: 0.75rem; color: #565959; margin-top: 6px;">Votre solde actuel est de {{ number_format($availableBalance, 0, ',', ' ') }} FCFA.</p>
                            </div>

                            <div>
                                <label style="display: block; font-size: 0.9rem; font-weight: 700; margin-bottom: 0.5rem;">Coordonnées Mobile Money</label>
                                <input type="text" name="telephone" class="amazon-input" required value="{{ $user->telephone }}" placeholder="Numéro de téléphone">
                                <div style="display: flex; gap: 10px; margin-top: 1rem;">
                                    <div class="pay-method-chip active" onclick="selectPayAmazon('om', this)">
                                        <img src="{{ asset('images/logoOM.png') }}" alt="OM" height="20">
                                        <span style="font-size: 0.8rem; font-weight: 600;">Orange Money</span>
                                    </div>
                                    <div class="pay-method-chip" onclick="selectPayAmazon('wave', this)">
                                        <img src="{{ asset('images/logowave.png') }}" alt="Wave" height="20">
                                        <span style="font-size: 0.8rem; font-weight: 600;">Wave</span>
                                    </div>
                                </div>
                                <input type="hidden" name="moyen" id="amazon_pay_method" value="om">
                            </div>
                        </div>

                        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #eee; text-align: right;">
                            <button type="submit" class="btn-amazon-primary" style="padding: 0.75rem 3rem;">Confirmer le retrait</button>
                        </div>
                    </form>
                @else
                    <div style="background-color: #f7f8f8; padding: 2rem; border-radius: 8px; text-align: center;">
                        <i class="fas fa-lock" style="color: #ddd; font-size: 2rem; margin-bottom: 1rem;"></i>
                        <p style="color: #565959; font-size: 0.95rem; margin: 0;">
                            Vous n'avez pas encore atteint le seuil de retrait de <strong>1 000 FCFA</strong>.<br>
                            Continuez vos ventes pour débloquer votre solde.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Transactions History -->
        <div class="amazon-card">
            <div class="amazon-card-header">
                <h2>Historique des transactions</h2>
                <div style="font-size: 0.85rem; color: #f68b1e; cursor: pointer; font-weight: 500;">Filtrer par date <i class="fas fa-chevron-down"></i></div>
            </div>
            <div style="overflow-x: auto;">
                <table class="amazon-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Montant</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $tx)
                            <tr>
                                <td style="color: #565959;">{{ $tx->created_at->format('d M Y') }}</td>
                                <td>
                                    <div style="font-weight: 600;">
                                        @if($tx->order_id)
                                            Vente Marketplace #{{ $tx->order->reference }}
                                        @else
                                            {{ ($tx->metadata['type'] ?? '') == 'withdrawal' ? 'Demande de retrait' : 'Transaction système' }}
                                        @endif
                                    </div>
                                    <div style="font-size: 0.75rem; color: #888;">ID: {{ $tx->reference_externe }}</div>
                                </td>
                                <td style="font-weight: 700; color: {{ $tx->montant > 0 ? '#007600' : '#b12704' }}; white-space: nowrap;">
                                    {{ $tx->montant > 0 ? '+' : '' }}{{ number_format($tx->montant, 0, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    @php
                                        $s = $tx->wallet_status;
                                        $label = $s == 'available' ? 'Confirmé' : ($s == 'pending' ? 'En attente' : 'Retiré');
                                        $badgeClass = $s == 'available' ? 'available' : ($s == 'pending' ? 'pending' : 'withdrawn');
                                    @endphp
                                    <span class="status-pill status-{{ $badgeClass }}">{{ $label }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 4rem; color: #565959;">
                                    Aucune transaction enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($recentTransactions->hasPages())
            <div style="margin-top: 1rem; display: flex; justify-content: center;">
                {{ $recentTransactions->links() }}
            </div>
        @endif
    </main>
</div>


@push('scripts')
<script>
    function selectPayAmazon(m, el) {
        document.querySelectorAll('.pay-method-chip').forEach(o => o.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('amazon_pay_method').value = m;
    }
</script>
@endpush
@endsection
