@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('breadcrumbs')
    <span style="color: var(--mady-red); font-weight: 700;">Vue d'ensemble</span>
@endsection

@push('styles')
<style>
    /* CSS Variables existantes de layouts.admin */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--slate-200);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    }
    
    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .stat-title {
        color: var(--slate-500);
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .icon-blue { background: #e0f2fe; color: #0284c7; }
    .icon-green { background: #dcfce7; color: #16a34a; }
    .icon-red { background: #fee2e2; color: #dc2626; }
    .icon-orange { background: #ffedd5; color: #ea580c; }
    .icon-purple { background: #f3e8ff; color: #9333ea; }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--slate-900);
        line-height: 1;
    }
    
    .stat-subtext {
        font-size: 0.875rem;
        color: var(--slate-500);
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .badge-alert {
        display: inline-flex;
        align-items: center;
        padding: 0.125rem 0.625rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        background-color: #fee2e2;
        color: #b91c1c;
    }

    /* Tables Grid */
    .tables-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    @media(min-width: 1024px) {
        .tables-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .dashboard-panel {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--slate-200);
        overflow: hidden;
    }
    
    .panel-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--slate-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
    }
    
    .panel-title {
        font-weight: 700;
        color: var(--slate-800);
        font-size: 1.1rem;
    }
    
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }
    .table-custom th {
        text-align: left;
        padding: 0.75rem 1.5rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--slate-500);
        background: #f8fafc;
        border-bottom: 1px solid var(--slate-200);
    }
    .table-custom td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--slate-200);
        font-size: 0.875rem;
        color: var(--slate-700);
        vertical-align: middle;
    }
    .table-custom tr:last-child td {
        border-bottom: none;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .status-badge.success { background: #dcfce7; color: #166534; }
    .status-badge.warning { background: #fef9c3; color: #854d0e; }
    .status-badge.danger { background: #fee2e2; color: #991b1b; }
    .status-badge.info { background: #dbeafe; color: #1e40af; }
    .status-badge.neutral { background: #f1f5f9; color: #475569; }

</style>
@endpush

@section('content')
<div style="display: flex; flex-direction: column; gap: 0;">
    
    <!-- Hero Section -->
    <header style="display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.03em; margin-bottom: 0.5rem;">Tableau de Bord</h1>
            <p style="color: var(--slate-500);">Vue d'ensemble de l'activité de la marketplace.</p>
        </div>
    </header>

    <!-- SECTION FINANCES & COMMANDES -->
    <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--slate-800); margin-bottom: 1rem;">Finances & Activité</h2>
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-title">Volume d'Affaires</span>
                <div class="stat-icon icon-green"><i class="fas fa-coins"></i></div>
            </div>
            <div class="stat-value">{{ number_format($stats['totalCA'], 0, ',', ' ') }} <small style="font-size:1rem;">FCFA</small></div>
            <div class="stat-subtext">Sur les commandes payées & livrées</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-title">Commissions Plateforme</span>
                <div class="stat-icon icon-blue"><i class="fas fa-percent"></i></div>
            </div>
            <div class="stat-value">{{ number_format($stats['totalCommissions'], 0, ',', ' ') }} <small style="font-size:1rem;">FCFA</small></div>
            <div class="stat-subtext">Revenus générés</div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-title">Commandes Totales</span>
                <div class="stat-icon icon-orange"><i class="fas fa-shopping-bag"></i></div>
            </div>
            <div class="stat-value">{{ $stats['ordersCount'] }}</div>
            <div class="stat-subtext">
                <span style="color:#ea580c; font-weight: 600;">{{ $stats['ordersInProgress'] }}</span> en cours | 
                <span style="color:#16a34a; font-weight: 600; margin-left:4px;">{{ $stats['ordersDelivered'] }}</span> livrées
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-title">Points Relais Actifs</span>
                <div class="stat-icon icon-purple"><i class="fas fa-map-marker-alt"></i></div>
            </div>
            <div class="stat-value">{{ $stats['pointsRelaisCount'] }}</div>
            <div class="stat-subtext">Disponibles pour livraison</div>
        </div>
    </div>

    <!-- SECTION UTILISATEURS & CATALOGUE -->
    <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--slate-800); margin-top: 1rem; margin-bottom: 1rem;">Communauté & Catalogue</h2>
    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-title">Utilisateurs</span>
                <div class="stat-icon icon-blue"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value">{{ $stats['usersCount'] }}</div>
            <div class="stat-subtext">
                <span style="color:#0284c7; font-weight: 600;">+{{ $stats['newUsersThisMonth'] }}</span> ce mois-ci
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-title">Vendeurs Inscrits</span>
                <div class="stat-icon icon-purple"><i class="fas fa-store"></i></div>
            </div>
            <div class="stat-value">{{ $stats['vendeursCount'] }}</div>
            <div class="stat-subtext">
                PRO: <strong>{{ $stats['proSellers'] }}</strong> | Particuliers: <strong>{{ $stats['amateurSellers'] }}</strong>
            </div>
            @if($stats['vendeursPending'] > 0)
                <div style="margin-top: 0.75rem;">
                    <a href="{{ route('admin.vendeurs.verification.index') }}" class="badge-alert" style="text-decoration: none;">
                        {{ $stats['vendeursPending'] }} en attente de vérification &rarr;
                    </a>
                </div>
            @endif
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-title">Annonces Actives</span>
                <div class="stat-icon icon-green"><i class="fas fa-box-open"></i></div>
            </div>
            <div class="stat-value">{{ $stats['annoncesCount'] }}</div>
            <div class="stat-subtext">Annonces publiées sur le site</div>
            @if($stats['annoncesPending'] > 0)
                <div style="margin-top: 0.75rem;">
                    <a href="{{ route('admin.annonces.moderation.index') }}" class="badge-alert" style="text-decoration: none; background: #fff7ed; color: #c2410c;">
                        {{ $stats['annoncesPending'] }} à modérer &rarr;
                    </a>
                </div>
            @endif
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <span class="stat-title">Litiges Ouverts</span>
                <div class="stat-icon icon-red"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
            <div class="stat-value">{{ $stats['litigesOpen'] }}</div>
            <div class="stat-subtext">Nécessitant une intervention</div>
            @if($stats['litigesOpen'] > 0)
                <div style="margin-top: 0.75rem;">
                    <a href="{{ route('admin.litiges.index') }}" class="badge-alert" style="text-decoration: none;">
                        Gérer les litiges &rarr;
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- RECENT ACTIVITY TABLES -->
    <div class="tables-grid">
        <!-- Dernières Commandes -->
        <div class="dashboard-panel">
            <div class="panel-header">
                <h3 class="panel-title">Dernières Commandes</h3>
            </div>
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['latestOrders'] as $order)
                        <tr>
                            <td>
                                <strong>#{{ $order->reference }}</strong><br>
                                <span style="font-size:0.75rem; color:#888;">{{ $order->buyer ? $order->buyer->prenom : 'Anonyme' }}</span>
                            </td>
                            <td><strong>{{ number_format($order->total_final, 0, ',', ' ') }} FCFA</strong></td>
                            <td>
                                @php
                                    $badgeClass = 'neutral';
                                    if(in_array($order->statut, ['paye', 'pret_expedition', 'en_route'])) $badgeClass = 'info';
                                    if($order->statut === 'livre') $badgeClass = 'success';
                                    if($order->statut === 'litige') $badgeClass = 'danger';
                                    if($order->statut === 'en_attente') $badgeClass = 'warning';
                                @endphp
                                <span class="status-badge {{ $badgeClass }}">{{ $order->statut_label ?? ucfirst($order->statut) }}</span>
                            </td>
                            <td style="font-size:0.8rem;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: #888;">Aucune commande récente.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Nouveaux Vendeurs -->
        <div class="dashboard-panel">
            <div class="panel-header">
                <h3 class="panel-title">Derniers Vendeurs Inscrits</h3>
                <a href="{{ route('admin.vendeurs.verification.index') }}" style="font-size: 0.85rem; color: var(--mady-red); text-decoration: none; font-weight: 600;">Voir tout &rarr;</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Nom / Raison Sociale</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Création</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['latestVendeurs'] as $v)
                        <tr>
                            <td>
                                <strong>
                                    @if($v->professionnel)
                                        {{ $v->professionnel->nom_entreprise }}
                                    @elseif($v->user)
                                        {{ $v->user->prenom }} {{ $v->user->nom }}
                                    @else
                                        Vendeur Inconnu
                                    @endif
                                </strong>
                            </td>
                            <td>
                                <span class="status-badge {{ $v->type === 'professionnel' ? 'info' : 'neutral' }}">
                                    {{ ucfirst($v->type) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $vBadge = match($v->statut_verification) {
                                        'verifie' => 'success',
                                        'en_attente' => 'warning',
                                        'rejete' => 'danger',
                                        default => 'neutral'
                                    };
                                @endphp
                                <span class="status-badge {{ $vBadge }}">{{ ucfirst($v->statut_verification) }}</span>
                            </td>
                            <td style="font-size:0.8rem;">{{ $v->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: #888;">Aucun vendeur inscrit récemment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
