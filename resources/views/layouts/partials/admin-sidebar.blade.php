<aside class="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">
            @if($logoUrl = \App\Models\Setting::logoUrl())
                <img src="{{ $logoUrl }}" alt="Logo">
            @else
                <span style="font-weight: 800; color: #ffffff; font-size: 1.2rem; display: block; padding: 10px;">{{ $siteSettings['site_name'] ?? 'Karnou' }}</span>
            @endif
        </a>
    </div>

    <div class="sidebar-container">
        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-separator"></div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" class="{{ request('role') == 'vendeur' ? 'active' : '' }}"><i class="fas fa-store"></i> <span>Liste Vendeurs</span></a></li>
                <li><a href="{{ route('admin.users.index', ['role' => 'acheteur']) }}" class="{{ request('role') == 'acheteur' ? 'active' : '' }}"><i class="fas fa-users"></i> <span>Liste Clients</span></a></li>
                <li><a href="{{ route('admin.annonces.index') }}" class="{{ request()->routeIs('admin.annonces.*') ? 'active' : '' }}"><i class="fas fa-clipboard-list"></i> <span>Articles</span></a></li>
                <li><a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fas fa-shopping-basket"></i> <span>Commandes</span></a></li>
            </ul>
        </div>

        <div class="sidebar-separator"></div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.finance.index') }}" class="{{ request()->routeIs('admin.finance.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> <span>Détails Financiers</span></a></li>
            </ul>
        </div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.transporteurs.index') }}" class="{{ request()->routeIs('admin.transporteurs.*') ? 'active' : '' }}"><i class="fas fa-truck"></i> <span>Transporteurs</span></a></li>
                <li><a href="{{ route('admin.livreurs.index') }}" class="{{ request()->routeIs('admin.livreurs.*') ? 'active' : '' }}"><i class="fas fa-motorcycle"></i> <span>Livreurs</span></a></li>
                <li><a href="{{ route('admin.point-relais.index') }}" class="{{ request()->routeIs('admin.point-relais.*') ? 'active' : '' }}"><i class="fas fa-map-marker-alt"></i> <span>Dépôts Relais</span></a></li>
            </ul>
        </div>

        <div class="sidebar-separator"></div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"><i class="fas fa-images"></i> <span>Bannières</span></a></li>
                <li><a href="{{ route('admin.promotions.index') }}" class="{{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}"><i class="fas fa-tags"></i> <span>Promotions</span></a></li>
                <li><a href="{{ route('admin.highlights.index') }}" class="{{ request()->routeIs('admin.highlights.*') ? 'active' : '' }}"><i class="fas fa-bullhorn"></i> <span>Actualités</span></a></li>
            </ul>
        </div>

        <div class="sidebar-separator"></div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.categories.l1') }}" class="{{ request()->routeIs('admin.categories.*', 'admin.filters.*', 'admin.users.*', 'admin.settings.*', 'admin.credits.*', 'admin.abonnements.*', 'admin.roles.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>


