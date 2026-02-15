@push('styles')
    <style>
        .rakuten-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            margin-top: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .content-header h1 {
            font-size: 1.5rem;
            color: #333;
            font-weight: 700;
            margin: 0;
        }

        .wallet-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            padding: 1.5rem;
            border-radius: 4px;
        }

        .wallet-label {
            font-size: 0.8rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .wallet-amount {
            font-size: 1.8rem;
            font-weight: 800;
            color: #333;
        }

        .btn-rakuten {
            background: #000;
            color: #fff;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-block;
            transition: opacity 0.2s;
        }

        .btn-rakuten:hover {
            opacity: 0.85;
            color: #fff;
        }

        .table-rakuten {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .table-rakuten th {
            text-align: left;
            padding: 1rem;
            background: #fafafa;
            border-bottom: 2px solid #eee;
            color: #666;
            font-weight: 700;
        }

        .table-rakuten td {
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .badge-rakuten {
            padding: 0.3rem 0.6rem;
            border-radius: 2px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('profile.show') }}">Mon Compte</a> > <span>Mon Portefeuille</span>
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

            <div class="row g-4 mb-5">
                <!-- Solde Disponible -->
                <div class="col-md-6">
                    <div class="wallet-card" style="border-top: 4px solid #bf0000;">
                        <div class="wallet-label">Solde Disponible</div>
                        <div class="wallet-amount" style="color: #bf0000;">{{ number_format($availableBalance) }} FCFA</div>
                        <p class="text-muted small mt-2 mb-4">Prêt à être retiré ou utilisé.</p>
                        <button class="btn-rakuten" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                            Demander un retrait
                        </button>
                    </div>
                </div>

                <!-- Solde en Attente -->
                <div class="col-md-6">
                    <div class="wallet-card">
                        <div class="wallet-label">En attente (Séquestre)</div>
                        <div class="wallet-amount">{{ number_format($pendingBalance) }} FCFA</div>
                        <p class="text-muted small mt-2 mb-4">Fonds bloqués pendant la transaction.</p>
                        <div class="text-muted small">
                            {{ $pendingTransactions->count() }} transaction(s) en cours
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique -->
            <h2 class="rakuten-title">Dernières Opérations</h2>
            <div class="rakuten-content-container" style="max-width: 100%;">
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
                                <td style="color: #666; font-size: 0.85rem;">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($transaction->order_id)
                                        <span style="display: block; font-weight: 700; color: #333;">Commande #{{ $transaction->order->reference }}</span>
                                        <small style="color: #888;">{{ $transaction->reference_externe }}</small>
                                    @else
                                        <span style="display: block; font-weight: 700; color: #333;">{{ $transaction->metadata['type'] ?? 'Transaction' }}</span>
                                        <small style="color: #888;">{{ $transaction->reference_externe }}</small>
                                    @endif
                                </td>
                                <td style="font-weight: 800; {{ $transaction->montant > 0 ? 'color: #2e7d32;' : 'color: #d32f2f;' }}">
                                    {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant) }} FCFA
                                </td>
                                <td>
                                    @if($transaction->wallet_status == 'pending')
                                        <span class="badge-rakuten badge-pending">En attente</span>
                                        <div style="color: #999; font-size: 0.75rem; margin-top: 2px;">Libération: {{ $transaction->release_at->format('d/m/Y') }}</div>
                                    @elseif($transaction->wallet_status == 'available')
                                        <span class="badge-rakuten badge-verified">Libéré</span>
                                    @elseif($transaction->wallet_status == 'withdrawn')
                                        <span class="badge-rakuten" style="background: #f0f0f0; color: #666;">Retiré</span>
                                    @else
                                        <span class="badge-rakuten" style="background: #f0f0f0; color: #666;">N/A</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    @if($transaction->order_id)
                                        <a href="#" class="btn-rakuten-outline" style="padding: 0.3rem 0.8rem; font-size: 0.75rem;">Détails</a>
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
    </div>

    <!-- Modal de Retrait (Keep Bootstrap but restyle content) -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('vendeur.wallet.withdraw') }}" method="POST">
                @csrf
                <div class="modal-content border-0 shadow-lg" style="border-radius: 8px;">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title" style="font-weight: 700;">Demander un retrait</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p style="color: #666; font-size: 0.95rem; margin-bottom: 2rem;">
                            Votre solde disponible est de <strong style="color: #bf0000;">{{ number_format($availableBalance) }} FCFA</strong>.
                        </p>
                        
                        <div class="mb-4">
                            <label style="display: block; font-size: 0.75rem; color: #999; font-weight: 700; text-transform: uppercase;">Montant à retirer (FCFA)</label>
                            <input type="number" name="montant" class="form-control" min="1000" max="{{ $availableBalance }}" required 
                                style="border: 2px solid #eee; padding: 0.75rem; border-radius: 4px; font-weight: 700;">
                            <div style="font-size: 0.7rem; color: #999; margin-top: 5px;">Minimum: 1,000 FCFA.</div>
                        </div>

                        <div class="mb-3">
                            <label style="display: block; font-size: 0.75rem; color: #999; font-weight: 700; text-transform: uppercase;">Moyen de retrait</label>
                            <select name="moyen" class="form-select" required style="border: 2px solid #eee; padding: 0.75rem; border-radius: 4px;">
                                <option value="om">Orange Money</option>
                                <option value="momo">MTN Mobile Money</option>
                                <option value="virement">Virement Bancaire</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn-rakuten-outline" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn-rakuten" {{ $availableBalance < 1000 ? 'disabled' : '' }} style="background: #bf0000; padding: 0.7rem 2rem;">
                            Confirmer le retrait
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
