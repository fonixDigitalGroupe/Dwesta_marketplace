@extends('layouts.app')

@section('title', 'Statistiques Vendeur - Karnou')

@push('styles')
<style>
    .gift-card-page {
        max-width: 900px;
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
        color: #f68b1e;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    /* Smaller, prettier cards */
    .stat-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.25rem;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s;
    }

    .stat-card:hover {
        border-color: #f68b1e;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .stat-card .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .stat-card .content {
        text-align: left;
    }

    .stat-card .amount {
        font-size: 1.25rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 2px;
        display: flex;
        align-items: baseline;
        gap: 4px;
    }

    .stat-card .amount small {
        font-size: 0.8rem;
        font-weight: 600;
        color: #999;
    }

    .stat-card .label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Filter Form Styles */
    .stats-filter-form {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        flex: 0 1 auto;
    }

    .filter-group label {
        font-size: 0.7rem;
        font-weight: 800;
        color: #666;
        text-transform: uppercase;
    }

    .filter-group input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 0.55rem 0.65rem;
        font-size: 0.9rem;
        outline: none;
        width: 260px;
        max-width: 100%;
    }

    /* Pousse les boutons Appliquer / Réinitialiser vers la droite */
    .stats-filter-form .btn-filter {
        margin-left: auto;
    }

    .btn-filter {
        background: #004aad;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        height: 38px;
    }

    .btn-filter:hover { background: #003a8c; }

    .btn-reset {
        background: #f68b1e;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .btn-reset:hover { background: #e87a0e; color: white; }

    /* Tabs Styles */
    .stats-tabs {
        display: flex;
        gap: 2rem;
        border-bottom: 2px solid #eee;
        margin-bottom: 2rem;
    }

    .tab-btn {
        padding: 0.75rem 0;
        font-size: 0.85rem;
        font-weight: 700;
        color: #888;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s;
        margin-bottom: -2px;
    }

    .tab-btn:hover { color: #f68b1e; }
    .tab-btn.active {
        color: #f68b1e;
        border-bottom-color: #f68b1e;
    }

    .tab-content { display: none; }
    .tab-content.active { display: block; animation: fadeIn 0.3s ease-in-out; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Small Product Card for Stats */
    .mini-product {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .mini-product:last-child { border-bottom: none; }
    .mini-product img {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        object-fit: cover;
    }
    .mini-product .info { flex: 1; }
    .mini-product .name { font-weight: 700; font-size: 0.85rem; color: #333; }
    .mini-product .meta { font-size: 0.75rem; color: #888; }
    .mini-product .count-badge {
        background: #f8f9fa;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
        color: #333;
    }
    .stock-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 800;
        white-space: nowrap;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .stats-tabs { gap: 1rem; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
        .stats-tabs::-webkit-scrollbar { display: none; }
        .tab-btn { flex-shrink: 0; }

        /* Formulaire de filtre empilé et pleine largeur */
        .stats-filter-form {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }
        .filter-group { flex: 1 1 auto; }
        .filter-group input { width: 100%; }
        .stats-filter-form .btn-filter,
        .stats-filter-form .btn-reset {
            margin-left: 0;
            width: 100%;
            height: 42px;
        }

        .table-history { font-size: 0.82rem; }
        .table-history th,
        .table-history td { padding: 0.7rem 0.6rem; }
    }

    /* Card Variations */
    .card-rev .icon-circle { background: #fff4e5; color: #f68b1e; }
    .card-orders .icon-circle { background: #e8f5e9; color: #2e7d32; }

    /* History Table (Matches Credits Table) */
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

    .badge-status {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-livre { background: #e8f5e9; color: #2e7d32; }
    .status-annule { background: #ffebee; color: #c62828; }
    .status-attente { background: #fff8e6; color: #f68b1e; }
    .status-default { background: #f5f5f5; color: #777; }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content gift-card-page">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Tableau de bord & Statistiques</h1>
        </div>

        @if(session('success'))
            <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9;">
                {{ session('success') }}
            </div>
        @endif

        <div class="gift-card-box">
            <h2 class="section-title">Filtres de période</h2>
            <form action="{{ route('vendeur.stats') }}" method="GET" class="stats-filter-form">
                <div class="filter-group">
                    <label>Date de début</label>
                    <input type="date" name="date_debut" value="{{ $dateDebut }}">
                </div>
                <div class="filter-group">
                    <label>Date de fin</label>
                    <input type="date" name="date_fin" value="{{ $dateFin }}">
                </div>
                <button type="submit" class="btn-filter">Appliquer</button>
                <a href="{{ route('vendeur.stats') }}" class="btn-reset">Réinitialiser</a>
            </form>

            <h2 class="section-title">Aperçu global</h2>
            <div class="stats-grid">
                <div class="stat-card card-rev">
                    <div class="icon-circle"><i class="fas fa-wallet"></i></div>
                    <div class="content">
                        <div class="amount">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} <small>FCFA</small></div>
                        <div class="label">Chiffre d'affaires total</div>
                    </div>
                </div>

                <div class="stat-card card-orders">
                    <div class="icon-circle"><i class="fas fa-shopping-bag"></i></div>
                    <div class="content">
                        <div class="amount">{{ $stats['total_orders'] }}</div>
                        <div class="label">Total Commandes</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="gift-card-box">
            <h2 class="section-title">Analyse Détaillée</h2>
            
            <div class="stats-tabs">
                <button class="tab-btn active" onclick="showTab(event, 'tab-recent')">Ventes Récentes</button>
                <button class="tab-btn" onclick="showTab(event, 'tab-top-sold')">Top Ventes</button>
                <button class="tab-btn" onclick="showTab(event, 'tab-top-viewed')">Top Vues</button>
                <button class="tab-btn" onclick="showTab(event, 'tab-status')">États des Ventes</button>
                <button class="tab-btn" onclick="showTab(event, 'tab-stock')">État du stock</button>
            </div>

            <!-- Tab: Ventes Récentes -->
            <div id="tab-recent" class="tab-content active">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 class="section-title" style="margin-bottom: 0; font-size: 0.7rem;">Dernières transactions</h3>
                    <a href="{{ route('vendeur.orders') }}" style="font-size: 0.75rem; font-weight: 800; color: #004aad; text-transform: uppercase; text-decoration: none;">Voir tout <i class="fas fa-arrow-right"></i></a>
                </div>
                <div style="overflow-x: auto; border: 1px solid #eee; border-radius: 8px;">
                    <table class="table-history">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th style="text-align: right;">Net Vendeur</th>
                                <th style="text-align: center;">Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td style="font-weight: 800; color: #000;">#{{ $order->reference }}</td>
                                    <td style="text-align: right; color: #2e7d32; font-weight: 800;">{{ number_format($order->total_produits - $order->commission_plateforme, 0, ',', ' ') }} <small>FCFA</small></td>
                                    <td style="text-align: center;">
                                        @php
                                            $s = $order->statut;
                                            $badge = match($s) {
                                                'livre' => 'livre',
                                                'annule' => 'annule',
                                                'en_attente' => 'attente',
                                                default => 'default'
                                            };
                                        @endphp
                                        <span class="badge-status status-{{ $badge }}">{{ $order->statut_label }}</span>
                                    </td>
                                    <td style="color: #777; font-size: 0.85rem;">{{ $order->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem; color: #999;">Aucune vente récente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab: Top Ventes -->
            <div id="tab-top-sold" class="tab-content">
                <div style="border: 1px solid #eee; border-radius: 8px; padding: 1rem;">
                    @forelse($topSoldAnnonces as $annonce)
                        <div class="mini-product">
                            <img src="{{ $annonce->photoPrincipale() ? asset('storage/' . $annonce->photoPrincipale()->chemin) : asset('images/no-image.png') }}" alt="">
                            <div class="info">
                                <div class="name">{{ $annonce->titre }}</div>
                                <div class="meta">{{ $annonce->category->nom ?? 'Sans catégorie' }}</div>
                            </div>
                            <div class="count-badge">{{ $annonce->total_sales }} ventes</div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem; color: #999;">Pas encore de ventes sur cette période.</div>
                    @endforelse
                </div>
            </div>

            <!-- Tab: Top Vues -->
            <div id="tab-top-viewed" class="tab-content">
                <div style="border: 1px solid #eee; border-radius: 8px; padding: 1rem;">
                    @forelse($topViewedAnnonces as $annonce)
                        <div class="mini-product">
                            <img src="{{ $annonce->photoPrincipale() ? asset('storage/' . $annonce->photoPrincipale()->chemin) : asset('images/no-image.png') }}" alt="">
                            <div class="info">
                                <div class="name">{{ $annonce->titre }}</div>
                                <div class="meta">{{ $annonce->category->nom ?? 'Sans catégorie' }}</div>
                            </div>
                            <div class="count-badge">{{ $annonce->vues }} vues</div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem; color: #999;">Aucune vue enregistrée.</div>
                    @endforelse
                </div>
            </div>

            <!-- Tab: Status Breakdown -->
            <div id="tab-status" class="tab-content">
                <div class="stats-grid" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));">
                    @php
                        $availableStatuses = [
                            'en_attente' => ['label' => 'En attente', 'color' => '#f59e0b', 'bg' => '#fef3c7'],
                            'paye' => ['label' => 'Payé', 'color' => '#10b981', 'bg' => '#d1fae5'],
                            'expedie' => ['label' => 'Expédié', 'color' => '#3b82f6', 'bg' => '#dbeafe'],
                            'livre' => ['label' => 'Livré', 'color' => '#059669', 'bg' => '#ecfdf5'],
                            'annule' => ['label' => 'Annulé', 'color' => '#ef4444', 'bg' => '#fee2e2'],
                        ];
                    @endphp

                    @foreach($availableStatuses as $key => $config)
                        <div style="background: {{ $config['bg'] }}; padding: 1.25rem; border-radius: 8px; text-align: center; border: 1px solid {{ $config['color'] }}22;">
                            <div style="font-size: 1.5rem; font-weight: 900; color: {{ $config['color'] }}">{{ $statusBreakdown[$key] ?? 0 }}</div>
                            <div style="font-size: 0.75rem; font-weight: 800; color: {{ $config['color'] }}; text-transform: uppercase;">{{ $config['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tab: État du stock -->
            <div id="tab-stock" class="tab-content">
                @php
                    $stockConfig = [
                        'en_stock'      => ['label' => 'En stock',     'color' => '#059669', 'bg' => '#ecfdf5', 'icon' => 'fa-check-circle'],
                        'rupture_stock' => ['label' => 'Rupture',      'color' => '#ef4444', 'bg' => '#fee2e2', 'icon' => 'fa-times-circle'],
                        'sur_commande'  => ['label' => 'Sur commande', 'color' => '#f59e0b', 'bg' => '#fef3c7', 'icon' => 'fa-clock'],
                    ];
                @endphp

                <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 1.5rem;">
                    @foreach($stockConfig as $key => $cfg)
                        <div style="background: {{ $cfg['bg'] }}; padding: 1.1rem; border-radius: 8px; text-align: center; border: 1px solid {{ $cfg['color'] }}22;">
                            <div style="font-size: 1.5rem; font-weight: 900; color: {{ $cfg['color'] }}">{{ $stockSummary[$key] ?? 0 }}</div>
                            <div style="font-size: 0.72rem; font-weight: 800; color: {{ $cfg['color'] }}; text-transform: uppercase;">{{ $cfg['label'] }}</div>
                        </div>
                    @endforeach
                </div>

                <div style="border: 1px solid #eee; border-radius: 8px; padding: 1rem;">
                    @forelse($stockAnnonces as $annonce)
                        @php $cfg = $stockConfig[$annonce->disponibilite] ?? ['label' => ucfirst(str_replace('_', ' ', $annonce->disponibilite ?? '—')), 'color' => '#777', 'bg' => '#f5f5f5', 'icon' => 'fa-box']; @endphp
                        <div class="mini-product">
                            <img src="{{ $annonce->photoPrincipale() ? asset('storage/' . $annonce->photoPrincipale()->chemin) : asset('images/no-image.png') }}" alt="">
                            <div class="info">
                                <div class="name">{{ $annonce->titre }}</div>
                                <div class="meta">{{ $annonce->category->nom ?? 'Sans catégorie' }}</div>
                            </div>
                            <span class="stock-badge" style="background: {{ $cfg['bg'] }}; color: {{ $cfg['color'] }}; border: 1px solid {{ $cfg['color'] }}33;">
                                <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['label'] }}
                            </span>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem; color: #999;">Aucune annonce à afficher.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function showTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.remove("active");
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>
@endsection
