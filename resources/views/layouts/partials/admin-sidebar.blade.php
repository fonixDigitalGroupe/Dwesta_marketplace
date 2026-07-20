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
                @can('view_dashboard')
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>

        <div class="sidebar-separator"></div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                @can('approve_vendors')<li><a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" class="{{ request('role') == 'vendeur' ? 'active' : '' }}"><i class="fas fa-store"></i> <span>Vendeurs</span>@if(($pendingVendorsCount ?? 0) > 0)<span class="sidebar-badge">{{ $pendingVendorsCount > 9 ? '9+' : $pendingVendorsCount }}</span>@endif</a></li>@endcan
                @can('manage_users')<li><a href="{{ route('admin.users.index', ['role' => 'acheteur']) }}" class="{{ request('role') == 'acheteur' ? 'active' : '' }}"><i class="fas fa-users"></i> <span>Clients</span></a></li>@endcan
                @can('moderate_products')<li><a href="{{ route('admin.annonces.index') }}" class="{{ request()->routeIs('admin.annonces.*') ? 'active' : '' }}"><i class="fas fa-clipboard-list"></i> <span>Articles</span></a></li>@endcan
                @can('manage_orders')<li><a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fas fa-shopping-basket"></i> <span>Commandes</span>@if(($activeOrdersCount ?? 0) > 0)<span class="sidebar-badge">{{ $activeOrdersCount > 9 ? '9+' : $activeOrdersCount }}</span>@endif</a></li>@endcan
            </ul>
        </div>

        <div class="sidebar-separator"></div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                @can('view_finances')<li><a href="{{ route('admin.finance.index') }}" class="{{ request()->routeIs('admin.finance.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> <span>Détails Financiers</span></a></li>@endcan
                @if(Route::has('admin.messagerie.index')) @can('manage_messagerie')
                <li><a href="{{ route('admin.messagerie.index') }}" class="{{ request()->routeIs('admin.messagerie.*') ? 'active' : '' }}"><i class="fas fa-envelope"></i> <span>Messagerie</span></a></li>
                @endcan @endif
            </ul>
        </div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                @can('manage_carriers')<li><a href="{{ route('admin.transporteurs.index') }}" class="{{ request()->routeIs('admin.transporteurs.*') ? 'active' : '' }}"><i class="fas fa-truck"></i> <span>Transporteurs</span>@if(($pendingTransporteursCount ?? 0) > 0)<span class="sidebar-badge">{{ $pendingTransporteursCount > 9 ? '9+' : $pendingTransporteursCount }}</span>@endif</a></li>@endcan
                @can('manage_drivers')<li><a href="{{ route('admin.livreurs.index') }}" class="{{ request()->routeIs('admin.livreurs.*') ? 'active' : '' }}"><i class="fas fa-motorcycle"></i> <span>Livreurs</span>@if(($pendingLivreursCount ?? 0) > 0)<span class="sidebar-badge">{{ $pendingLivreursCount > 9 ? '9+' : $pendingLivreursCount }}</span>@endif</a></li>@endcan
                @can('manage_pickup_points')<li><a href="{{ route('admin.point-relais.index') }}" class="{{ request()->routeIs('admin.point-relais.*') ? 'active' : '' }}"><i class="fas fa-map-marker-alt"></i> <span>Dépôts Relais</span></a></li>@endcan
            </ul>
        </div>

        <div class="sidebar-separator"></div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                @can('manage_banners')<li><a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"><i class="fas fa-images"></i> <span>Bannières</span></a></li>@endcan
                @can('manage_coupons')<li><a href="{{ route('admin.promotions.index') }}" class="{{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}"><i class="fas fa-tags"></i> <span>Promotions</span></a></li>@endcan
                @can('manage_highlights')<li><a href="{{ route('admin.highlights.index') }}" class="{{ request()->routeIs('admin.highlights.*') ? 'active' : '' }}"><i class="fas fa-bullhorn"></i> <span>Actualités</span></a></li>@endcan
            </ul>
        </div>

        <div class="sidebar-separator"></div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                @canany(['manage_categories','manage_filters','manage_visibility','manage_gift_cards','manage_credits','manage_subscriptions','manage_countries','manage_shipping','manage_settings','manage_roles'])
                <li>
                    <a href="{{ route('admin.categories.l1') }}" class="{{ request()->routeIs('admin.categories.*', 'admin.filters.*', 'admin.users.*', 'admin.settings.*', 'admin.credits.*', 'admin.abonnements.*', 'admin.roles.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
                @endcanany
            </ul>
        </div>
    </div>
</aside>


