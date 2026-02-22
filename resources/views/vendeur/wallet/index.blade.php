@extends('layouts.app')

@push('styles')
    <style>
        :root {
            --rakuten-red: #bf0000;
            --rakuten-red-light: #fff5f5;
            --amazon-orange: #ff9900;
            --success-green: #2ecc71;
            --pending-orange: #f39c12;
            --accent-blue: #3498db;
            --text-main: #333;
            --text-muted: #7f8c8d;
            --bg-light: #fdfdfd;
            --bg-gray: #f8f9fa;
            --border-color: #ecf0f1;
        }

        /* Layout & Typography */
        .rakuten-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 3rem 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .rakuten-title i {
            color: var(--rakuten-red);
        }

        .content-header {
            margin-bottom: 2.5rem;
        }

        .content-header h1 {
            font-size: 2rem;
            color: var(--text-main);
            font-weight: 900;
            letter-spacing: -0.02em;
        }

        /* Summary Bar (Startup Dashboard Style) */
        .summary-bar {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            margin-bottom: 3.5rem;
        }

        .summary-item {
            padding: 2.5rem 2rem;
            border-right: 1px solid var(--border-color);
            display: flex;
            align-items: flex-start;
            gap: 1.5rem;
            transition: background 0.2s;
        }
        .summary-item:hover {
            background: var(--bg-light);
        }

        .summary-item:last-child {
            border-right: none;
        }

        .summary-icon {
            width: 42px;
            height: 42px;
            background: #fff5f0;
            color: var(--amazon-orange);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .summary-icon.blue {
            background: #ebf5fb;
            color: var(--accent-blue);
        }

        .summary-content {
            flex-grow: 1;
        }

        .summary-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }

        .summary-value {
            font-size: 2.25rem;
            font-weight: 900;
            color: #000;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .summary-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        /* Buttons (Rakuten Brand Style) */
        .btn-rakuten {
            background: #000;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 800;
            cursor: pointer;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-rakuten:hover {
            background: #333;
            color: #fff;
        }

        .btn-rakuten-outline {
            background: #fff;
            color: var(--text-main);
            padding: 0.5rem 1.25rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-rakuten-outline:hover {
            border-color: var(--rakuten-red);
            color: var(--rakuten-red);
            background: var(--rakuten-red-light);
        }

        /* Table (Integrated Appearance) */
        .table-container {
            border: 1px solid var(--border-color);
            background: #fff;
            border-radius: 0;
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .table-rakuten {
            width: 100%;
            border-collapse: collapse;
        }

        .table-rakuten th {
            text-align: left;
            padding: 1.25rem 1.5rem;
            background: var(--bg-gray);
            border-bottom: 1px solid var(--border-color);
            color: var(--text-muted);
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table-rakuten td {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            font-size: 0.95rem;
            color: var(--text-main);
        }

        .table-rakuten tr:last-child td {
            border-bottom: none;
        }

        .table-rakuten tr:hover td {
            background-color: var(--bg-light);
        }

        /* Statuses */
        .status-pill {
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-available { background: #e8f8f5; color: #1abc9c; }
        .status-pending { background: #fef5e7; color: #f39c12; }
        .status-withdrawn { background: #f2f4f4; color: #7f8c8d; }

        .price-pos { color: #27ae60; font-weight: 800; }
        .price-neg { color: #e74c3c; font-weight: 800; }

        /* Custom Modal Logic (Alpine.js) */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .custom-modal-content {
            background: #fff;
            width: 100%;
            max-width: 500px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 992px) {
            .summary-bar { grid-template-columns: 1fr; }
            .summary-item { border-right: none; border-bottom: 1px solid var(--border-color); }
            .summary-item:last-child { border-bottom: none; }
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> &gt; <a href="{{ route('account.index') }}">Mon compte</a> &gt; <span>Mon portefeuille</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="content-header">
                <h1>Mon Portefeuille</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="summary-bar">
                <!-- Solde Disponible -->
                <div class="summary-item">
                    <div class="summary-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">Portefeuille Actuel</div>
                        <div class="summary-value">{{ number_format($availableBalance) }} <small style="font-size: 1.25rem;">FCFA</small></div>
                        <div class="summary-desc">Disponible immédiatement.</div>
                        <button class="btn-rakuten" onclick="openWithdrawModal()">
                            <i class="fas fa-arrow-down"></i> Retirer des fonds
                        </button>
                    </div>
                </div>

                <!-- Solde en Attente -->
                <div class="summary-item">
                    <div class="summary-icon blue">
                        <i class="fas fa-clock-rotate-left"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-label">En attente (Séquestre)</div>
                        <div class="summary-value" style="color: #000;">{{ number_format($pendingBalance) }} <small style="font-size: 1.25rem;">FCFA</small></div>
                        <div class="summary-desc">Paiements validés, en attente de libération ({{ $pendingTransactions->count() }} transaction(s)).</div>
                    </div>
                </div>
            </div>

            <!-- Historique -->
            <h2 class="rakuten-title">
                <i class="fas fa-list-ul" style="color: #000;"></i> Historique des Transactions
            </h2>
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
                                <td style="color: var(--text-muted); white-space: nowrap;">
                                    <div style="font-weight: 800; color: var(--text-main);">{{ $transaction->created_at->format('d M Y') }}</div>
                                    <div style="font-size: 0.8rem;"><i class="far fa-clock"></i> {{ $transaction->created_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    @if($transaction->order_id)
                                        <div style="font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                                            <i class="fas fa-box" style="color: var(--accent-blue);"></i>
                                            Vente #{{ $transaction->order->reference }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-left: 1.5rem;">Trans: {{ $transaction->reference_externe }}</div>
                                    @else
                                        <div style="font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                                            @if(($transaction->metadata['type'] ?? '') == 'withdrawal')
                                                <i class="fas fa-paper-plane" style="color: var(--rakuten-red);"></i>
                                                Retrait de fonds
                                            @else
                                                <i class="fas fa-exchange-alt" style="color: var(--text-muted);"></i>
                                                Transaction divers
                                            @endif
                                        </div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-left: 1.5rem;">{{ $transaction->reference_externe }}</div>
                                    @endif
                                </td>
                                <td class="{{ $transaction->montant > 0 ? 'price-pos' : 'price-neg' }}" style="white-space: nowrap; font-size: 1.1rem;">
                                    {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant) }} FCFA
                                </td>
                                <td>
                                    @if($transaction->wallet_status == 'pending')
                                        <span class="status-pill status-pending">
                                            <i class="fas fa-hourglass-start"></i> En attente
                                        </span>
                                        <div style="color: var(--text-muted); font-size: 0.7rem; margin-top: 4px; border-left: 2px solid var(--pending-orange); padding-left: 5px;">Libération: {{ $transaction->release_at->format('d/m/Y') }}</div>
                                    @elseif($transaction->wallet_status == 'available')
                                        <span class="status-pill status-available">
                                            <i class="fas fa-check-circle"></i> Libéré
                                        </span>
                                    @elseif($transaction->wallet_status == 'withdrawn')
                                        <span class="status-pill status-withdrawn">
                                            <i class="fas fa-share-from-square"></i> Retiré
                                        </span>
                                    @else
                                        <span class="status-pill status-withdrawn">N/A</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    @if($transaction->order_id)
                                        <a href="{{ route('vendeur.orders.show', $transaction->order_id) }}" class="btn-rakuten-outline">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem; color: #999;">
                                    Aucune transaction enregistrée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($recentTransactions->hasPages())
                    <div style="margin-top: 1.5rem;">
                        {{ $recentTransactions->links() }}
                    </div>
                @endif
            </div>
        </main>

    <!-- Modal de Retrait (JS Standard) -->
    <div id="withdrawModalOverlay" 
         class="custom-modal-overlay" 
         style="display: {{ request()->has('withdraw') ? 'flex' : 'none' }};">
        <div class="custom-modal-content">
            <form action="{{ route('vendeur.wallet.withdraw') }}" method="POST">
                @csrf
                <div class="modal-header" style="background: var(--bg-gray); border-bottom: 2px solid var(--border-color); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                    <h5 class="modal-title" style="font-weight: 900; letter-spacing: -0.01em; font-size: 1.25rem; color: var(--text-main); display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                        <i class="fas fa-building-columns" style="color: var(--rakuten-red);"></i>
                        Virer vers compte
                    </h5>
                    <button type="button" onclick="closeWithdrawModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted);">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <div style="background: #fff5f0; padding: 1.25rem; border-radius: 12px; margin-bottom: 2rem; border: 1px dashed var(--amazon-orange);">
                        <label style="font-size: 0.75rem; color: var(--amazon-orange); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Fonds disponibles</label>
                        <div style="font-size: 2.25rem; font-weight: 900; color: #000; line-height: 1;">{{ number_format($availableBalance) }} <small style="font-size: 1rem;">FCFA</small></div>
                    </div>
                    
                    <div class="mb-4">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-main); font-weight: 800; margin-bottom: 0.75rem; text-transform: uppercase;">Somme du virement</label>
                        <div style="position: relative;">
                            <input type="number" name="montant" class="form-control" min="1" max="{{ $availableBalance }}" required 
                                style="border: 2px solid var(--border-color); padding: 1rem; border-radius: 8px; font-weight: 800; font-size: 1.5rem; color: var(--text-main); width: 100%;">
                            <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); font-weight: 900; color: var(--text-muted);">XAF</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-main); font-weight: 800; margin-bottom: 0.75rem; text-transform: uppercase;">Canal de réception</label>
                        <select name="moyen" class="form-select" required style="border: 2px solid var(--border-color); padding: 0.75rem; border-radius: 8px; font-weight: 700; width: 100%;">
                            <option value="om">🟠 Orange Money Africa</option>
                            <option value="momo">🟡 MTN MoMo Pay</option>
                            <option value="virement">🏦 Virement SEPA / Local</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="background: var(--bg-gray); padding: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" class="btn-rakuten-outline" onclick="closeWithdrawModal()">Abandonner</button>
                    <button type="submit" class="btn-rakuten" {{ $availableBalance < 1 ? 'disabled' : '' }}>
                        <i class="fas fa-check-double"></i> Confirmer le virement
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
