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
        flex-wrap: nowrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        flex: 1 1 0;
        min-width: 120px;
    }

    /* Les deux boutons restent ensemble, alignés à droite sur la même ligne */
    .filter-actions {
        display: flex;
        gap: 0.75rem;
        align-items: flex-end;
        flex-shrink: 0;
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
        width: 100%;
    }

    .btn-filter {
        background: #f68b1e;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        height: 38px;
    }

    .btn-filter:hover { background: #e07b10; }

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

    /* ── Pagination professionnelle ── */
    .karnou-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .karnou-pagination .kp-link {
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        color: #374151;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.18s ease;
        box-sizing: border-box;
    }
    .karnou-pagination a.kp-link:hover {
        border-color: #f68b1e;
        color: #f68b1e;
        background: #fff5ec;
    }
    .karnou-pagination .kp-active {
        background: #f68b1e;
        border-color: #f68b1e;
        color: #fff;
        box-shadow: 0 2px 6px rgba(246, 139, 30, 0.25);
        cursor: default;
    }
    .karnou-pagination .kp-disabled {
        color: #d1d5db;
        background: #fafafa;
        cursor: not-allowed;
    }
    .karnou-pagination .kp-dots {
        border-color: transparent;
        background: transparent;
        font-weight: 800;
        color: #9ca3af;
        cursor: default;
    }
    .karnou-pagination .kp-arrow {
        font-size: 0.75rem;
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
            flex-wrap: wrap;
        }
        .filter-group { flex: 1 1 auto; }
        .filter-group input { width: 100%; }
        .filter-actions {
            display: flex;
            gap: 0.75rem;
            width: 100%;
        }
        .filter-actions .btn-filter,
        .filter-actions .btn-reset {
            flex: 1;
            width: auto;
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
        background: #f0f2f2;
        color: #555;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-bottom: 1px solid #e0e0e0;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    /* Conteneur de tableau avec défilement vertical */
    .table-scroll {
        max-height: 440px;
        overflow-y: auto;
        overflow-x: auto;
        border: 1px solid #eee;
        border-radius: 8px;
    }
    .table-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
    .table-scroll::-webkit-scrollbar-thumb { background: #d1d1d1; border-radius: 4px; }
    .table-scroll::-webkit-scrollbar-track { background: transparent; }

    /* Listes de cartes défilantes (Top Ventes / Top Vues / Stock) */
    .list-scroll {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1rem;
        max-height: 440px;
        overflow-y: auto;
    }
    .list-scroll::-webkit-scrollbar { width: 8px; }
    .list-scroll::-webkit-scrollbar-thumb { background: #d1d1d1; border-radius: 4px; }
    .list-scroll::-webkit-scrollbar-track { background: transparent; }

    .table-history td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #e5e5e5;
        border-right: 1px solid #eee;
        vertical-align: middle;
    }
    .table-history td:last-child,
    .table-history th:last-child { border-right: none; }
    .table-history th { border-right: 1px solid #e0e0e0; }

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
                    <input type="date" name="date_debut" value="{{ $dateDebut }}" onchange="this.form.submit()">
                </div>
                <div class="filter-group">
                    <label>Date de fin</label>
                    <input type="date" name="date_fin" value="{{ $dateFin }}" onchange="this.form.submit()">
                </div>
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
                <button class="tab-btn" onclick="showTab(event, 'tab-stock')">État du stock</button>
            </div>

            <!-- Tab: Ventes Récentes -->
            <div id="tab-recent" class="tab-content active">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 class="section-title" style="margin-bottom: 0; font-size: 0.7rem;">Dernières transactions</h3>
                    <a href="{{ route('vendeur.orders') }}" style="font-size: 0.75rem; font-weight: 800; color: #f68b1e; text-transform: uppercase; text-decoration: none;">Voir tout <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="table-scroll">
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
                <div class="list-scroll">
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
                <div class="list-scroll">
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

                <div class="list-scroll">
                    @forelse($stockAnnonces as $annonce)
                        @php
                            $isEcommerce = optional($annonce->category)->famille === \App\Models\Category::FAMILLE_ECOMMERCE;
                            $cfg = $stockConfig[$annonce->disponibilite] ?? ['label' => ucfirst(str_replace('_', ' ', $annonce->disponibilite ?? '—')), 'color' => '#777', 'bg' => '#f5f5f5', 'icon' => 'fa-box'];
                            $qte = optional($annonce->produit)->quantite;
                        @endphp
                        <div class="mini-product">
                            <img src="{{ $annonce->photoPrincipale() ? asset('storage/' . $annonce->photoPrincipale()->chemin) : asset('images/no-image.png') }}" alt="">
                            <div class="info">
                                <div class="name">{{ $annonce->titre }}</div>
                                <div class="meta">{{ $annonce->category->nom ?? 'Sans catégorie' }}</div>
                            </div>
                            @if($isEcommerce)
                                <div style="display: flex; align-items: center; gap: 0.6rem; flex-shrink: 0;">
                                    @if(!is_null($qte))
                                        <span class="count-badge"><i class="fas fa-cubes" style="color:#888; margin-right:4px;"></i>{{ $qte }} en stock</span>
                                    @endif
                                    {{-- Pas de badge vert « En stock » : la quantité l'indique déjà.
                                         On n'affiche le badge que pour rupture / sur commande. --}}
                                    @if($annonce->disponibilite !== \App\Models\Annonce::DISPONIBILITE_EN_STOCK)
                                        <span class="stock-badge" style="background: {{ $cfg['bg'] }}; color: {{ $cfg['color'] }}; border: 1px solid {{ $cfg['color'] }}33;">
                                            <i class="fas {{ $cfg['icon'] }}"></i> {{ $cfg['label'] }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="stock-badge" style="background: #f5f5f5; color: #999; border: 1px solid #e5e5e5;">
                                    <i class="fas fa-minus-circle"></i> Non applicable
                                </span>
                            @endif
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem; color: #999;">Aucune annonce à afficher.</div>
                    @endforelse
                </div>

                @if($stockAnnonces->hasPages())
                    <div style="margin-top: 1.5rem;">
                        {{ $stockAnnonces->links('vendor.pagination.karnou') }}
                    </div>
                @endif
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

    // Rouvre l'onglet « État du stock » après une navigation de pagination (?tab=stock)
    document.addEventListener('DOMContentLoaded', function () {
        var params = new URLSearchParams(window.location.search);
        if (params.get('tab') === 'stock') {
            var btn = document.querySelector('.tab-btn[onclick*="tab-stock"]');
            if (btn) btn.click();
        }
    });
</script>
@endsection
