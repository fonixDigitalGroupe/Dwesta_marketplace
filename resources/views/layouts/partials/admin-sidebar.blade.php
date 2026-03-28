<aside class="sidebar">
    <div class="sidebar-user">
        <h2>{{ auth()->user()->prenom ?? auth()->user()->name }}</h2>
    </div>

    <!-- Dashboard -->
    <div class="sidebar-section">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-title {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" style="width: 18px; height: 18px;">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke="#3498db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Tableau de bord
        </a>
    </div>

    <!-- Logistique -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M20 7.5L12 3L4 7.5M20 7.5V16.5L12 21M20 7.5L12 12M4 7.5L12 12M4 7.5V16.5L12 21M12 21V12" stroke="#d35400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10L16 14.5" stroke="#d35400" stroke-width="1.5" stroke-linecap="round" />
            </svg>
            Logistique
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.transporteurs.index') }}" class="{{ request()->routeIs('admin.transporteurs.*') ? 'active' : '' }}"><i class="fas fa-truck" style="width: 20px; color: #ff750f;"></i> Transporteurs</a></li>
            <li><a href="{{ route('admin.livreurs.index') }}" class="{{ request()->routeIs('admin.livreurs.*') ? 'active' : '' }}"><i class="fas fa-motorcycle" style="width: 20px; color: #ff750f;"></i> Livreurs</a></li>
            <li><a href="{{ route('admin.point-relais.index') }}" class="{{ request()->routeIs('admin.point-relais.*') ? 'active' : '' }}"><i class="fas fa-map-marker-alt" style="width: 20px; color: #ff750f;"></i> Dépôts Relais</a></li>
            <li><a href="#"><i class="fas fa-shipping-fast" style="width: 20px;"></i> Suivi des Livraisons</a></li>
        </ul>
    </div>

    <!-- Gestion des Vendeurs -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" style="color: #6366f1;">
                <path d="M16 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
            </svg>
            Gestion des Vendeurs
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.vendeurs.verification.index') }}" class="{{ request()->routeIs('admin.vendeurs.verification.*') ? 'active' : '' }}" style="display: flex; justify-content: space-between; align-items: center;">
                    <span><i class="fas fa-check-circle" style="width: 20px; color: #6366f1;"></i> Validation Vendeurs</span>
                    @if(isset($pendingVendorsCount) && $pendingVendorsCount > 0)
                        <span style="background: var(--mady-red); color: white; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 10px; min-width: 18px; text-align: center; margin-right: 10px;">
                            {{ $pendingVendorsCount }}
                        </span>
                    @endif
                </a>
            </li>
            <li><a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" class="{{ in_array(request('role'), ['vendeur', 'vendeur_pro', 'vendeur_particulier']) ? 'active' : '' }}"><i class="fas fa-store" style="width: 20px; color: #6366f1;"></i> Vendeurs</a></li>
        </ul>
    </div>


    <!-- Contenu & Marketing -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M3 9l9-6 9 6v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" fill="#f39c12" />
                <polyline points="9 22 9 12 15 12 15 22" fill="#e67e22" />
            </svg>
            Contenu
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"><i class="fas fa-image" style="width: 20px; color: #f39c12;"></i> Bannières Publicitaires</a></li>
            <li><a href="{{ route('admin.highlights.index') }}" class="{{ request()->routeIs('admin.highlights.*') ? 'active' : '' }}"><i class="fas fa-th-large" style="width: 20px; color: #f39c12;"></i> Actualités Karnou</a></li>
            <li><a href="{{ route('admin.highlight-tabs.index') }}" class="{{ request()->routeIs('admin.highlight-tabs.*') ? 'active' : '' }}"><i class="fas fa-tags" style="width: 20px; color: #f39c12;"></i> Gestion des Onglets</a></li>
        </ul>
    </div>

    <!-- Configuration -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <i class="fas fa-cogs" style="font-size: 1.1rem; color: #666;"></i>
            Paramètres
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.categories.l1') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="fas fa-sitemap" style="width: 20px;"></i> Catégories & Architecture</a></li>
            <li><a href="{{ route('admin.filters.index') }}" class="{{ request()->routeIs('admin.filters.*') ? 'active' : '' }}"><i class="fas fa-filter" style="width: 20px;"></i> Critères de filtrage</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') && !request()->has('role') ? 'active' : '' }}"><i class="fas fa-users" style="width: 20px;"></i> Gestion des Utilisateurs</a></li>
            <li><a href="#"><i class="fas fa-user-shield" style="width: 20px;"></i> Rôles et permissions</a></li>
            <li><a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.index') ? 'active' : '' }}"><i class="fas fa-tools" style="width: 20px;"></i> Configuration Générale</a></li>
            <li><a href="{{ route('admin.credits.packs') }}" class="{{ request()->routeIs('admin.credits.packs*') ? 'active' : '' }}"><i class="fas fa-box" style="width: 20px;"></i> Packs de crédits</a></li>
            <li><a href="{{ route('admin.credits.services') }}" class="{{ request()->routeIs('admin.credits.services*') ? 'active' : '' }}"><i class="fas fa-star" style="width: 20px;"></i> Services annonces</a></li>
            <li><a href="{{ route('admin.abonnements.index') }}" class="{{ request()->routeIs('admin.abonnements.*') ? 'active' : '' }}"><i class="fas fa-id-card" style="width: 20px;"></i> Packs d'abonnement</a></li>
        </ul>
    </div>
</aside>
