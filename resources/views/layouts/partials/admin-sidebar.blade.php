<aside class="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">
             @if(isset($siteSettings['logo']))
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo">
            @else
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
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
                <li><a href="{{ route('admin.vendeurs.verification.index') }}" class="{{ request()->routeIs('admin.vendeurs.verification.*') ? 'active' : '' }}">
                    <i class="fas fa-check-circle"></i>
                    <span>Validation Vendeurs</span>
                    @if(isset($pendingVendorsCount) && $pendingVendorsCount > 0)
                        <span style="background: var(--mady-red); color: white; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 10px; margin-left: auto;">
                            {{ $pendingVendorsCount }}
                        </span>
                    @endif
                </a></li>
                <li><a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" class="{{ request('role') == 'vendeur' ? 'active' : '' }}"><i class="fas fa-store"></i> <span>Liste Vendeurs</span></a></li>
            </ul>
        </div>

        <div class="sidebar-separator"></div>

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
                <li><a href="{{ route('admin.highlights.index') }}" class="{{ request()->routeIs('admin.highlights.*') ? 'active' : '' }}"><i class="fas fa-bullhorn"></i> <span>Actualités</span></a></li>
                <li><a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}"><i class="fas fa-ticket-alt"></i> <span>Codes Promo</span></a></li>
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


