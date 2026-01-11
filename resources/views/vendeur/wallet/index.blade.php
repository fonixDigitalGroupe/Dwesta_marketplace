@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mon Portefeuille (Wallet)</h1>
        <a href="{{ route('vendeur.show') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour au Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <!-- Solde Disponible -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #1a237e 0%, #283593 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title mb-0">Solde Disponible</h5>
                        <i class="fas fa-wallet fa-2x opacity-50"></i>
                    </div>
                    <h2 class="display-5 fw-bold mb-3">{{ number_format($availableBalance) }} FCFA</h2>
                    <p class="mb-4 opacity-75">Fonds prêts à être retirés ou utilisés pour vos options.</p>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                        <i class="fas fa-hand-holding-usd me-2"></i>Demander un retrait
                    </button>
                </div>
            </div>
        </div>

        <!-- Solde en Attente (Escrow) -->
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm bg-light">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title mb-0 text-muted">En attente (Séquestre)</h5>
                        <i class="fas fa-lock fa-2x text-muted opacity-25"></i>
                    </div>
                    <h2 class="display-5 fw-bold mb-3 text-dark">{{ number_format($pendingBalance) }} FCFA</h2>
                    <p class="mb-4 text-muted">Fonds bloqués pendant la livraison ou le délai de rétractation.</p>
                    <div class="d-flex align-items-center text-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>{{ $pendingTransactions->count() }} transaction(s) en cours de libération</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historique des Transactions -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Dernières Opérations</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Référence</th>
                            <th>Description</th>
                            <th>Montant</th>
                            <th>Statut Wallet</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $transaction)
                            <tr>
                                <td class="ps-4 text-muted">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td><code>{{ $transaction->reference_externe }}</code></td>
                                <td>
                                    @if($transaction->order_id)
                                        Commande <a href="#">#{{ $transaction->order->reference }}</a>
                                    @else
                                        {{ $transaction->metadata['type'] ?? 'Transaction' }}
                                    @endif
                                </td>
                                <td class="fw-bold {{ $transaction->montant > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->montant > 0 ? '+' : '' }}{{ number_format($transaction->montant) }} FCFA
                                </td>
                                <td>
                                    @if($transaction->wallet_status == 'pending')
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i>En attente
                                            <br><small>Libération: {{ $transaction->release_at->format('d/m/Y') }}</small>
                                        </span>
                                    @elseif($transaction->wallet_status == 'available')
                                        <span class="badge bg-success">Libéré</span>
                                    @elseif($transaction->wallet_status == 'withdrawn')
                                        <span class="badge bg-info">Retiré</span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    @if($transaction->order_id)
                                        <a href="#" class="btn btn-sm btn-outline-primary">Détails</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-exchange-alt fa-3x mb-3 opacity-25"></i>
                                    <p>Aucune transaction enregistrée.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($recentTransactions->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $recentTransactions->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Retrait -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('vendeur.wallet.withdraw') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Demander un retrait</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Votre solde disponible est de <strong>{{ number_format($availableBalance) }} FCFA</strong>.</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Montant à retirer (FCFA)</label>
                        <input type="number" name="montant" class="form-control" min="1000" max="{{ $availableBalance }}" required>
                        <div class="form-text">Minimum: 1,000 FCFA.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Moyen de retrait</label>
                        <select name="moyen" class="form-select" required>
                            <option value="om">Orange Money</option>
                            <option value="momo">MTN Mobile Money</option>
                            <option value="virement">Virement Bancaire</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" {{ $availableBalance < 1000 ? 'disabled' : '' }}>Confirmer le retrait</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
