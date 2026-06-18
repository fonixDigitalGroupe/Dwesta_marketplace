@extends('layouts.app')

@push('styles')
<style>
    .wallet-page {
        max-width: 900px;
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

    /* Balance Dashboard Card (Matches Gift Card Premium Style) */
    .wallet-balance-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        border-radius: 16px;
        padding: 30px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 2.5rem;
        box-shadow: none;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        min-height: 180px;
    }
    
    .wallet-balance-card::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 150px; height: 150px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .wallet-balance-card::after {
        content: '';
        position: absolute;
        bottom: -50px; left: -20px;
        width: 180px; height: 180px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
    }

    .card-brand-label {
        position: absolute;
        top: 24px;
        right: 30px;
        font-size: 14px;
        font-weight: 900;
        color: rgba(255,255,255,0.2);
        letter-spacing: 1px;
    }

    .balance-details {
        position: relative;
        z-index: 2;
    }

    .balance-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255,255,255,0.55);
        margin-bottom: 8px;
    }

    .balance-amount {
        font-size: 2.8rem;
        font-weight: 900;
        line-height: 1;
        color: #fff;
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .balance-amount small {
        font-size: 1.1rem;
        font-weight: 700;
        color: rgba(255,255,255,0.6);
    }

    .btn-withdraw-payout {
        background: #f68b1e;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.85rem 1.75rem;
        font-size: 0.85rem;
        font-weight: 800;
        cursor: pointer;
        text-transform: uppercase;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: none;
    }

    .btn-withdraw-payout:hover {
        background: #fa9d3e;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(246, 139, 30, 0.5);
    }

    /* History Table (Matches Gift Cards Mes cartes achetées) */
    .table-history {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .table-history th {
        text-align: left;
        padding: 0.75rem 1rem;
        background: #fff;
        color: #888;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid #eee;
    }

    .table-history td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f9f9f9;
        vertical-align: middle;
    }

    .status-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-available { background: #e8f5e9; color: #2e7d32; }
    .status-pending { background: #fff8e6; color: #f68b1e; }
    .status-withdrawn { background: #f5f5f5; color: #777; }

    .amount-positive { color: #2e7d32; font-weight: 800; }
    .amount-negative { color: #d32f2f; font-weight: 800; }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal-container {
        background: #fff;
        width: 100%;
        max-width: 440px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
    }

    .modal-header h3 { margin: 0; font-size: 1.1rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }

    .payment-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1rem;
    }

    .payment-option {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .payment-option:hover { border-color: #f68b1e; background: #fffbf8; }
    .payment-option.active { border-color: #f68b1e; background: #fffbf8; box-shadow: inset 0 0 0 1px #f68b1e; }
    .payment-option img { height: 35px; }
    .payment-option span { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }

    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #666; margin-bottom: 0.5rem; }
    .form-group input { 
        width: 100%; 
        padding: 10px 14px; 
        border: 1px solid #ddd; 
        border-radius: 8px; 
        font-size: 1rem; 
        font-weight: 700;
        outline: none;
    }
    .form-group input:focus { border-color: #004aad; }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content wallet-page">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mon Portefeuille</h1>
        </div>

        @if(session('success'))
            <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9; font-size: 0.9rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #ffebee; color: #c62828; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #ffcdd2; font-size: 0.9rem;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Card Balance (Design aligned with Gift Card Premium Style) -->
        <div class="wallet-balance-card">
            <div class="card-brand-label">WALLETPASS</div>
            <div class="balance-details">
                <div class="balance-label">Solde disponible</div>
                <div class="balance-amount">
                    {{ number_format($availableBalance, 0, ',', ' ') }}
                    <small>FCFA</small>
                </div>
            </div>
            
            <div style="position: relative; z-index: 2; opacity: 0.15; transform: rotate(-15deg);">
                <i class="fas fa-wallet" style="font-size: 5rem; color: #fff;"></i>
            </div>
        </div>

        @if($availableBalance >= 1000)
        <!-- Integrated Withdrawal Form (Matches Gift Card Purchase UI) -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 2rem; margin-bottom: 2.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
            <h2 style="color: #333; margin-top: 0; margin-bottom: 1.5rem; font-size: 1rem; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-paper-plane" style="color: #f68b1e;"></i>
                Retirer mes revenus
            </h2>

            <form action="{{ route('vendeur.wallet.withdraw') }}" method="POST" id="payoutForm">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Montant (min. 1000 FCFA)</label>
                        <div style="position: relative;">
                            <input type="number" name="montant" max="{{ $availableBalance }}" min="1000" required placeholder="1 000" style="padding-right: 50px;">
                            <span style="position: absolute; right: 14px; top: 12px; font-weight: 800; color: #bbb; font-size: 0.8rem;">FCFA</span>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Numéro de téléphone</label>
                        <input type="text" name="telephone" required value="{{ $user->telephone }}" placeholder="7x xxx xx xx">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Mode de retrait</label>
                        <div class="payment-grid" style="grid-template-columns: 1fr 1fr; margin-top: 0; gap: 10px;">
                            <div class="payment-option active" onclick="selectPay('om', this)" style="padding: 10px 5px;">
                                <img src="{{ asset('images/logoOM.png') }}" alt="OM" style="height: 25px;">
                                <span style="font-size: 0.65rem;">Orange Money</span>
                            </div>
                            <div class="payment-option" onclick="selectPay('wave', this)" style="padding: 10px 5px;">
                                <img src="{{ asset('images/logowave.png') }}" alt="Wave" style="height: 25px;">
                                <span style="font-size: 0.65rem;">Wave Cash</span>
                            </div>
                        </div>
                        <input type="hidden" name="moyen" id="pay_method" value="om">
                    </div>

                </div>

                <button type="submit" style="background: #004aad; color: #fff; border: none; border-radius: 8px; padding: 1rem 2rem; font-weight: 800; font-size: 0.9rem; text-transform: uppercase; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; max-width: 300px; margin: 0 auto; transition: all 0.2s;">
                    Transférer maintenant
                </button>
            </form>
        </div>
        @else
        <div style="background: #fafafa; border: 1px dashed #ddd; border-radius: 12px; padding: 2rem; text-align: center; margin-bottom: 2.5rem; color: #888;">
            <i class="fas fa-lock" style="font-size: 1.5rem; margin-bottom: 10px; opacity: 0.5;"></i>
            <p style="margin: 0; font-size: 0.9rem; font-weight: 600;">Minimum de 1 000 FCFA requis pour effectuer un retrait.</p>
        </div>
        @endif

        @if($pendingBalance > 0)
        <div style="background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-clock" style="color: #f68b1e; font-size: 1.1rem;"></i>
                <span style="font-size: 0.85rem; font-weight: 700; color: #666; text-transform: uppercase;">Libération prévue</span>
            </div>
            <div style="font-size: 1.1rem; font-weight: 800; color: #000;">
                {{ number_format($pendingBalance, 0, ',', ' ') }} <small style="font-size: 0.8rem; opacity: 0.6;">FCFA</small>
            </div>
        </div>
        @endif

        <!-- History Transactions -->
        <div class="gift-card-box">
            <h2 class="section-title">
                Historique des transactions
            </h2>
            <div style="overflow-x: auto; border: 1px solid #eee; border-radius: 8px;">
                <table class="table-history">
                    <thead>
                        <tr>
                            <th>Détails</th>
                            <th style="text-align: right;">Montant</th>
                            <th style="text-align: center;">Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $tx)
                            <tr>
                                <td>
                                    <div style="font-weight: 800; color: #000;">
                                        @if($tx->order_id)
                                            Vente #{{ $tx->order->reference }}
                                        @else
                                            {{ ($tx->metadata['type'] ?? '') == 'withdrawal' ? 'Retrait Mobile Money' : 'Ajustement' }}
                                        @endif
                                    </div>
                                    <div style="font-size: 0.7rem; color: #999; font-family: monospace;">{{ $tx->reference_externe }}</div>
                                </td>
                                <td class="{{ $tx->montant > 0 ? 'amount-positive' : 'amount-negative' }}" style="text-align: right; font-size: 1rem;">
                                    {{ $tx->montant > 0 ? '+' : '' }}{{ number_format($tx->montant, 0, ',', ' ') }} <small style="font-size: 0.75rem;">FCFA</small>
                                </td>
                                <td style="text-align: center;">
                                    @php
                                        $s = $tx->wallet_status;
                                        $label = $s == 'available' ? 'Disponible' : ($s == 'pending' ? 'En attente' : 'Retiré');
                                        $badge = $s == 'available' ? 'available' : ($s == 'pending' ? 'pending' : 'withdrawn');
                                    @endphp
                                    <span class="status-badge status-{{ $badge }}">{{ $label }}</span>
                                </td>
                                <td style="color: #777; font-size: 0.85rem;">{{ $tx->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 4rem; color: #999; font-size: 0.9rem;">
                                    Aucun mouvement enregistré.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($recentTransactions->hasPages())
                <div style="margin-top: 1.5rem;">
                    {{ $recentTransactions->links() }}
                </div>
            @endif
        </div>
    </main>
</div>


@push('scripts')
<script>
    function selectPay(m, el) {
        document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('pay_method').value = m;
    }
    function openPayout() { document.getElementById('payoutModal').style.display = 'flex'; }
    function closePayout() { document.getElementById('payoutModal').style.display = 'none'; }
    window.onclick = function(e) { if(e.target == document.getElementById('payoutModal')) closePayout(); }
</script>
@endpush
@endsection
