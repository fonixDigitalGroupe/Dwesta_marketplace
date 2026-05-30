@extends('layouts.admin')

@section('title', 'Gestion Finance - Administration')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }

    /* ---- Stripe Overview Bar ---- */
    .stripe-overview {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 4px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    .stripe-overview-header {
        background: #1a1f36;
        color: #fff;
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .stripe-overview-header h2 {
        font-size: 0.85rem;
        font-weight: 600;
        margin: 0;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .stripe-badge {
        background: #6772e5;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .stripe-metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        border-bottom: 1px solid #e7e7e7;
    }
    .stripe-metric {
        padding: 18px 20px;
        border-right: 1px solid #e7e7e7;
    }
    .stripe-metric:last-child { border-right: none; }
    .stripe-metric-label {
        font-size: 0.72rem;
        color: #666;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .stripe-metric-value {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1a1f36;
        line-height: 1;
    }
    .stripe-metric-caption {
        font-size: 0.72rem;
        color: #999;
        margin-top: 4px;
    }
    .stripe-metric-value.green { color: #09825d; }
    .stripe-metric-value.orange { color: #c45500; }
    .stripe-metric-value.red { color: #c40000; }
    .stripe-metric-value.blue { color: #1a56db; }

    .stripe-escrow-bar {
        padding: 15px 20px;
        display: flex;
        gap: 30px;
        align-items: center;
        background: #f9fbff;
        border-top: 1px solid #e7e7e7;
        flex-wrap: wrap;
    }
    .escrow-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .escrow-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .escrow-label { font-size: 0.78rem; color: #555; }
    .escrow-value { font-size: 0.85rem; font-weight: 700; color: #111; }

    /* ---- Amazon Tabs ---- */
    .amazon-tabs-container {
        display: flex;
        gap: 20px;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 20px;
        padding-bottom: 0;
    }
    .tab-link {
        padding: 10px 5px;
        text-decoration: none;
        font-size: 0.85rem;
        color: #555;
        font-weight: 400;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
    }
    .tab-link:hover { color: #c45500; }
    .tab-link.active {
        color: #c45500;
        font-weight: 700;
        border-bottom-color: #c45500;
    }

    /* ---- Amazon Table ---- */
    .table-amazon {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #e7e7e7;
    }
    .table-amazon th {
        background: #f6f6f6;
        padding: 10px 15px;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 700;
        color: #111;
        text-transform: uppercase;
        border-bottom: 1px solid #e7e7e7;
        border-right: 1px solid #e7e7e7;
    }
    .table-amazon td {
        padding: 12px 15px;
        font-size: 0.85rem;
        border-bottom: 1px solid #e7e7e7;
        border-right: 1px solid #e7e7e7;
        color: #333;
    }
    .table-amazon tr:hover { background-color: #f9f9f9; }

    .badge-finance {
        padding: 2px 8px;
        border-radius: 2px;
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid transparent;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <!-- ===== COMPTE KARNOU ===== -->
    <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px; margin-top: -50px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e7e7e7;">
            <h2 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">Compte Karnou</h2>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

            {{-- Solde Karnou retirable --}}
            <div style="border: 1px solid #e7e7e7; border-radius: 4px; padding: 20px; background: #f9fbff;">
                <div style="font-size: 0.72rem; color: #555; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 12px;">
                    Solde Karnou (retirable)
                </div>
                @php
                    $soldeKarnou = $stripeOverview['commissionsTotal'] + $stripeOverview['creditsRevenue'] + $stripeOverview['subscriptionsRevenue'];
                @endphp
                <div style="font-size: 2rem; font-weight: 800; color: #09825d; line-height: 1; margin-bottom: 6px;">
                    {{ number_format($soldeKarnou, 0, ',', ' ') }}
                    <span style="font-size: 0.9rem; font-weight: 500; color: #888;">FCFA</span>
                </div>
                <div style="font-size: 0.75rem; color: #888; margin-bottom: 15px;">Disponible pour retrait côté plateforme</div>
                <div style="border-top: 1px solid #e7e7e7; padding-top: 12px; display: flex; flex-direction: column; gap: 7px;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                        <span style="color: #555;">Commissions ventes</span>
                        <span style="font-weight: 700; color: #111;">{{ number_format($stripeOverview['commissionsTotal'], 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                        <span style="color: #555;">Abonnements vendeurs</span>
                        <span style="font-weight: 700; color: #111;">{{ number_format($stripeOverview['subscriptionsRevenue'], 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                        <span style="color: #555;">Crédits vendus</span>
                        <span style="font-weight: 700; color: #111;">{{ number_format($stripeOverview['creditsRevenue'], 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            {{-- Montant à payer aux vendeurs --}}
            <div style="border: 1px solid #e7e7e7; border-radius: 4px; padding: 20px; background: #fffbf7;">
                <div style="font-size: 0.72rem; color: #555; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 12px;">
                    À payer aux Vendeurs
                </div>
                <div style="font-size: 2rem; font-weight: 800; color: #c45500; line-height: 1; margin-bottom: 6px;">
                    {{ number_format($stripeOverview['vendeursMontantTotal'], 0, ',', ' ') }}
                    <span style="font-size: 0.9rem; font-weight: 500; color: #888;">FCFA</span>
                </div>
                <div style="font-size: 0.75rem; color: #888; margin-bottom: 15px;">Volume total encaissé moins les commissions</div>
                <div style="border-top: 1px solid #e7e7e7; padding-top: 12px; display: flex; flex-direction: column; gap: 7px;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                        <span style="color: #555;">Volume total des ventes</span>
                        <span style="font-weight: 700; color: #111;">{{ number_format($stripeOverview['volumeTotal'], 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem;">
                        <span style="color: #555;">– Commissions prélevées</span>
                        <span style="font-weight: 700; color: #c40000;">- {{ number_format($stripeOverview['commissionsTotal'], 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.8rem; padding-top: 5px; border-top: 1px dashed #e7e7e7;">
                        <span style="color: #111; font-weight: 700;">Net vendeurs</span>
                        <span style="font-weight: 800; color: #c45500;">{{ number_format($stripeOverview['vendeursMontantTotal'], 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== DÉTAILS FINANCIERS ===== -->
    <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px; margin-top: 20px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e7e7e7;">
            <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">Détails Financiers</h1>
            <div class="text-muted" style="font-size: 0.75rem; color: #888;">Mise à jour : {{ now()->format('H:i') }}</div>
        </div>

        <!-- Tabs Navigation -->
        <div class="amazon-tabs-container">
            <a href="{{ route('admin.finance.index', ['tab' => 'overview']) }}" class="tab-link {{ $tab == 'overview' ? 'active' : '' }}">Toutes les Transactions</a>
            <a href="{{ route('admin.finance.index', ['tab' => 'commissions']) }}" class="tab-link {{ $tab == 'commissions' ? 'active' : '' }}">Commissions</a>
            <a href="{{ route('admin.finance.index', ['tab' => 'subscriptions']) }}" class="tab-link {{ $tab == 'subscriptions' ? 'active' : '' }}">Abonnements</a>
            <a href="{{ route('admin.finance.index', ['tab' => 'credits']) }}" class="tab-link {{ $tab == 'credits' ? 'active' : '' }}">Crédits</a>
            <a href="{{ route('admin.finance.index', ['tab' => 'gift-cards']) }}" class="tab-link {{ $tab == 'gift-cards' ? 'active' : '' }}">Cartes Cadeaux</a>
            <a href="{{ route('admin.finance.index', ['tab' => 'withdrawals']) }}" class="tab-link {{ $tab == 'withdrawals' ? 'active' : '' }}">Retraits</a>
        </div>

        <div class="finance-content">

            {{-- OVERVIEW --}}
            @if($tab == 'overview')
                <table class="table-amazon">
                    <thead>
                        <tr>
                            <th>Référence / Date</th>
                            <th>Acheteur</th>
                            <th>Vendeur</th>
                            <th>Total Vente</th>
                            <th>Commission</th>
                            <th style="border-right: none;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $order)
                            <tr>
                                <td>
                                    <div style="font-weight: 500; color: #0066c0;">
                                        <a href="{{ route('admin.orders.show', $order) }}" style="color: #0066c0; text-decoration: none;">{{ $order->reference }}</a>
                                    </div>
                                    <div style="font-size: 0.75rem; color: #888;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;">{{ $order->buyer->name }}</div>
                                    <div style="font-size: 0.75rem; color: #888;">{{ $order->buyer->email }}</div>
                                </td>
                                <td>{{ $order->seller->identite }}</td>
                                <td style="font-weight: 700; color: #1a56db;">{{ number_format($order->total_final, 0, ',', ' ') }} FCFA</td>
                                <td style="font-weight: 700; color: #c45500;">{{ number_format($order->commission_plateforme, 0, ',', ' ') }} FCFA</td>
                                <td style="border-right: none;">
                                    @php
                                        $colors = ['paye' => ['#f0fdf4','#166534'], 'livre' => ['#f0fdf4','#166534'], 'pret_expedition' => ['#fff8f3','#c45500'], 'en_route' => ['#fff8f3','#c45500'], 'disponible' => ['#fff8f3','#c45500']];
                                        $c = $colors[$order->statut] ?? ['#f3f4f6','#4b5563'];
                                    @endphp
                                    <span class="badge-finance" style="background: {{ $c[0] }}; color: {{ $c[1] }}; border-color: {{ $c[1] }}33;">{{ $order->statut_label }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" style="padding: 40px; text-align: center; color: #888;">Aucune transaction.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-top: 20px;">{{ $data->links() }}</div>
            @endif

            {{-- COMMISSIONS --}}
            @if($tab == 'commissions')
                <table class="table-amazon">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Vendeur</th>
                            <th>Total Vente</th>
                            <th>Commission</th>
                            <th style="border-right: none;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}" style="color: #0066c0; font-weight: 600;">{{ $order->reference }}</a></td>
                                <td>{{ $order->seller->identite }}</td>
                                <td style="font-weight: 500;">{{ number_format($order->total_produits, 0, ',', ' ') }} FCFA</td>
                                <td style="font-weight: 700; color: #c45500;">{{ number_format($order->commission_plateforme, 0, ',', ' ') }} FCFA</td>
                                <td style="border-right: none;">{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="padding: 40px; text-align: center; color: #888;">Aucune commission.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-top: 20px;">{{ $data->links() }}</div>
            @endif

            {{-- SUBSCRIPTIONS --}}
            @if($tab == 'subscriptions')
                <table class="table-amazon">
                    <thead>
                        <tr>
                            <th>Vendeur</th>
                            <th>Forfait</th>
                            <th>Période</th>
                            <th>Tarif Mensuel</th>
                            <th style="border-right: none;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $sub)
                            <tr>
                                <td>
                                    <div style="font-weight: 500; color: #0066c0;">{{ $sub->vendeur->identite }}</div>
                                    <div style="font-size: 0.75rem; color: #888;">{{ $sub->vendeur->user->email }}</div>
                                </td>
                                <td style="font-weight: 700;">{{ strtoupper($sub->abonnement->nom) }}</td>
                                <td>Du {{ $sub->date_debut->format('d/m/y') }} au {{ $sub->date_fin->format('d/m/y') }}</td>
                                <td style="font-weight: 700;">{{ number_format($sub->abonnement->prix_mensuel, 0, ',', ' ') }} FCFA</td>
                                <td style="border-right: none;">
                                    @if($sub->estActif())
                                        <span class="badge-finance" style="background: #f0fdf4; color: #166534; border-color: #bbf7d0;">Actif</span>
                                    @else
                                        <span class="badge-finance" style="background: #fef2f2; color: #991b1b; border-color: #fecdd3;">Inactif</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="padding: 40px; text-align: center; color: #888;">Aucun abonnement.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-top: 20px;">{{ $data->links() }}</div>
            @endif

            {{-- CREDITS --}}
            @if($tab == 'credits')
                <table class="table-amazon">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th style="border-right: none;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $tx)
                            <tr>
                                <td style="font-weight: 500; color: #0066c0;">{{ $tx->user->name }}</td>
                                <td>{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                                <td style="font-weight: 700; color: #09825d;">{{ number_format($tx->montant, 0, ',', ' ') }} FCFA</td>
                                <td style="border-right: none;">{{ $tx->description }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="padding: 40px; text-align: center; color: #888;">Aucun achat de crédits.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-top: 20px;">{{ $data->links() }}</div>
            @endif

            {{-- GIFT CARDS --}}
            @if($tab == 'gift-cards')
                <table class="table-amazon">
                    <thead>
                        <tr>
                            <th>Code Carte</th>
                            <th>Acheteur</th>
                            <th>Valeur</th>
                            <th>Utilisateur</th>
                            <th style="border-right: none;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $card)
                            <tr>
                                <td><code style="font-weight: 700; background: #f3f3f3; padding: 2px 5px;">{{ $card->code }}</code></td>
                                <td>{{ $card->buyer->name }}</td>
                                <td style="font-weight: 700;">{{ number_format($card->amount, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $card->user ? $card->user->name : '-' }}</td>
                                <td style="border-right: none;">
                                    <span class="badge-finance"
                                        style="background: {{ $card->status == 'active' ? '#f0fdf4' : '#f3f4f6' }};
                                               color: {{ $card->status == 'active' ? '#166534' : '#4b5563' }};
                                               border-color: {{ $card->status == 'active' ? '#bbf7d0' : '#e5e7eb' }};">
                                        {{ ucfirst($card->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="padding: 40px; text-align: center; color: #888;">Aucune carte cadeau.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-top: 20px;">{{ $data->links() }}</div>
            @endif

            {{-- WITHDRAWALS --}}
            @if($tab == 'withdrawals')
                <table class="table-amazon">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Vendeur</th>
                            <th>Montant Retiré</th>
                            <th>Référence</th>
                            <th style="border-right: none;">Méthode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $tx)
                            <tr>
                                <td>{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                                <td style="font-weight: 500; color: #0066c0;">{{ $tx->user->name }}</td>
                                <td style="font-weight: 700; color: #c40000;">{{ number_format(abs($tx->montant), 0, ',', ' ') }} FCFA</td>
                                <td><code>{{ $tx->reference_externe }}</code></td>
                                <td style="border-right: none;">{{ strtoupper($tx->moyen_paiement) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="padding: 40px; text-align: center; color: #888;">Aucun retrait enregistré.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-top: 20px;">{{ $data->links() }}</div>
            @endif

        </div>
    </div>

</div>
@endsection
