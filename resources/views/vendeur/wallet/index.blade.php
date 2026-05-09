@extends('layouts.app')

@push('styles')
    <style>
        :root {
            --primary-blue: #004aad;
            --primary-orange: #f68b1e;
            --success-green: #00a650;
            --pending-orange: #f39c12;
            --text-main: #333;
            --text-muted: #666;
            --bg-gray: #f5f5f5;
            --border-color: #eee;
        }

        /* Layout & Typography */
        .wallet-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .rakuten-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 2rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Summary Bar */
        .summary-bar {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .summary-item {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .summary-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .summary-icon.orange { background: #fff5eb; color: var(--primary-orange); }
        .summary-icon.blue { background: #ebf5ff; color: var(--primary-blue); }

        .summary-value {
            font-size: 2rem;
            font-weight: 800;
            color: #000;
            line-height: 1.2;
        }

        .summary-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Buttons */
        .btn-withdraw {
            background: var(--primary-blue);
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
            width: fit-content;
        }

        .btn-withdraw:hover {
            background: #003a8c;
            color: #fff;
        }

        /* Table */
        .table-container {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .table-rakuten {
            width: 100%;
            border-collapse: collapse;
        }

        .table-rakuten th {
            text-align: left;
            padding: 1.25rem;
            background: #fafafa;
            border-bottom: 1px solid var(--border-color);
            color: #777;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .table-rakuten td {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
            color: var(--text-main);
        }

        .table-rakuten tr:last-child td { border-bottom: none; }

        .table-rakuten tr:hover td { background-color: #f9f9f9; }

        /* Status Badges */
        .status-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .status-available { background: #e6f7ef; color: #00a650; }
        .status-pending { background: #fff8e6; color: #f39c12; }
        .status-withdrawn { background: #f5f5f5; color: #888; }

        .amount-positive { color: #00a650; font-weight: 700; }
        .amount-negative { color: #e74c3c; font-weight: 700; }

        /* Modal */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .custom-modal-content {
            background: #fff;
            width: 100%;
            max-width: 480px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .summary-bar { grid-template-columns: 1fr; }
        }
    </style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 2rem; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mon Portefeuille</h1>
            </div>

            @if(session('success'))
                <div style="background: #f6fff6; color: #00a650; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="summary-bar">
                <!-- Solde Disponible -->
                <div class="summary-item">
                    <div class="summary-header">
                        <div class="summary-label">Portefeuille Actuel</div>
                        <div class="summary-icon orange">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div class="summary-value">{{ number_format($availableBalance) }} <span style="font-size: 1rem; font-weight: 600;">FCFA</span></div>
                    <div class="summary-desc">Fonds disponibles pour retrait immédiat.</div>
                    <button class="btn-withdraw" onclick="openWithdrawModal()">
                        <i class="fas fa-arrow-down-long"></i> Retirer des fonds
                    </button>
                </div>

                <!-- Solde en Attente -->
                <div class="summary-item">
                    <div class="summary-header">
                        <div class="summary-label">En attente (Séquestre)</div>
                        <div class="summary-icon blue">
                            <i class="fas fa-history"></i>
                        </div>
                    </div>
                    <div class="summary-value">{{ number_format($pendingBalance) }} <span style="font-size: 1rem; font-weight: 600;">FCFA</span></div>
                    <div class="summary-desc">En attente de libération ({{ $pendingTransactions->count() }} transaction{{ $pendingTransactions->count() > 1 ? 's' : '' }}).</div>
                </div>
            </div>

            <!-- Historique -->
            <div class="rakuten-title">
                <i class="fas fa-list-ul"></i> Historique des Transactions
            </div>
            
            <div class="table-container">
                <table class="table-rakuten">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                            <tr>
                                <td>
                                    <div style="font-weight: 700;">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                    <div style="font-size: 0.75rem; color: #999;">{{ $transaction->created_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    @if($transaction->order_id)
                                        <div style="font-weight: 600;">Vente #{{ $transaction->order->reference }}</div>
                                        <div style="font-size: 0.75rem; color: #888;">ID: {{ $transaction->reference_externe }}</div>
                                    @else
                                        <div style="font-weight: 600;">
                                            {{ ($transaction->metadata['type'] ?? '') == 'withdrawal' ? 'Retrait de fonds' : 'Transaction' }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #888;">{{ $transaction->reference_externe }}</div>
                                    @endif
                                </td>
                                <td class="{{ $transaction->montant > 0 ? 'amount-positive' : 'amount-negative' }}">
                                    {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant) }} FCFA
                                </td>
                                <td>
                                    @if($transaction->wallet_status == 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock"></i> En attente
                                        </span>
                                        <div style="font-size: 0.7rem; color: #999; margin-top: 3px;">Libéré le {{ $transaction->release_at->format('d/m/Y') }}</div>
                                    @elseif($transaction->wallet_status == 'available')
                                        <span class="status-badge status-available">
                                            <i class="fas fa-check"></i> Disponible
                                        </span>
                                    @elseif($transaction->wallet_status == 'withdrawn')
                                        <span class="status-badge status-withdrawn">
                                            <i class="fas fa-paper-plane"></i> Retiré
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    @if($transaction->order_id)
                                        <a href="{{ route('vendeur.orders.show', $transaction->order_id) }}" style="color: var(--primary-blue); font-size: 1rem;">
                                            <i class="fas fa-circle-info"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 4rem; color: #999;">
                                    <i class="fas fa-receipt" style="font-size: 2rem; display: block; margin-bottom: 1rem; opacity: 0.2;"></i>
                                    Aucune transaction pour le moment
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
        </main>
    </div>

    <!-- Modal de Retrait -->
    <div id="withdrawModalOverlay" class="custom-modal-overlay" style="display: {{ request()->has('withdraw') ? 'flex' : 'none' }};">
        <div class="custom-modal-content">
            <form action="{{ route('vendeur.wallet.withdraw') }}" method="POST">
                @csrf
                <div style="padding: 1.5rem; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #333;">Demande de retrait</h3>
                    <button type="button" onclick="closeWithdrawModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #999;">&times;</button>
                </div>
                
                <div style="padding: 1.5rem;">
                    <div style="background: #fff8f1; border: 1px solid #ffe0b2; padding: 1.25rem; border-radius: 10px; margin-bottom: 1.5rem;">
                        <span style="font-size: 0.75rem; color: #e65100; font-weight: 700; text-transform: uppercase;">Disponible</span>
                        <div style="font-size: 1.75rem; font-weight: 800; color: #000;">{{ number_format($availableBalance) }} <span style="font-size: 1rem;">FCFA</span></div>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 0.5rem;">Montant à retirer</label>
                        <div style="position: relative;">
                            <input type="number" name="montant" max="{{ $availableBalance }}" min="1" required 
                                   style="width: 100%; padding: 0.85rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1.1rem; font-weight: 600;"
                                   placeholder="0">
                            <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); font-weight: 700; color: #999;">FCFA</span>
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 0.5rem;">Mode de paiement</label>
                        <select name="moyen" required style="width: 100%; padding: 0.85rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; background: #fff;">
                            <option value="om">Orange Money</option>
                            <option value="momo">MTN Mobile Money</option>
                            <option value="virement">Virement bancaire</option>
                        </select>
                    </div>
                </div>

                <div style="padding: 1.25rem 1.5rem; background: #fafafa; border-top: 1px solid #eee; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" onclick="closeWithdrawModal()" style="background: none; border: 1px solid #ddd; padding: 0.7rem 1.2rem; border-radius: 6px; font-weight: 600; cursor: pointer;">Annuler</button>
                    <button type="submit" class="btn-withdraw" {{ $availableBalance <= 0 ? 'disabled' : '' }}>
                        Confirmer le retrait
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openWithdrawModal() {
            document.getElementById('withdrawModalOverlay').style.display = 'flex';
        }
        function closeWithdrawModal() {
            document.getElementById('withdrawModalOverlay').style.display = 'none';
        }
        // Fermer en cliquant en dehors
        window.onclick = function(event) {
            let modal = document.getElementById('withdrawModalOverlay');
            if (event.target == modal) {
                closeWithdrawModal();
            }
        }
    </script>
    @endpush
@endsection
