<aside class="sidebar">
    <div class="sidebar-brand" style="background-color: white; border-bottom: 2px solid #e5e7eb; height: 60px; display: flex; align-items: center; justify-content: center;">
        <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; display: flex; align-items: center; justify-content: center; width: 100%;">
             @if(isset($siteSettings['logo']))
                <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" style="height: 24px; width: auto;">
            @else
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 24px; width: auto;">
            @endif
        </a>
    </div>



    <div class="sidebar-container">
        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large" style="color: #ff8c00;"></i>
                        Dashboard
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.transporteurs.index') }}" class="{{ request()->routeIs('admin.transporteurs.*') ? 'active' : '' }}"><i class="fas fa-truck" style="color: #ff8c00;"></i> Transporteurs</a></li>
                <li><a href="{{ route('admin.livreurs.index') }}" class="{{ request()->routeIs('admin.livreurs.*') ? 'active' : '' }}"><i class="fas fa-motorcycle" style="color: #ff8c00;"></i> Livreurs</a></li>
                <li><a href="{{ route('admin.point-relais.index') }}" class="{{ request()->routeIs('admin.point-relais.*') ? 'active' : '' }}"><i class="fas fa-map-marker-alt" style="color: #ff8c00;"></i> Dépôts Relais</a></li>
            </ul>
        </div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.vendeurs.verification.index') }}" class="{{ request()->routeIs('admin.vendeurs.verification.*') ? 'active' : '' }}">
                        <i class="fas fa-check-circle" style="color: #ff8c00;"></i>
                        Validation
                        @if(isset($pendingVendorsCount) && $pendingVendorsCount > 0)
                            <span style="background: var(--mady-red); color: white; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 10px; margin-left: auto;">
                                {{ $pendingVendorsCount }}
                            </span>
                        @endif
                    </a>
                </li>
                <li><a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" class="{{ request('role') == 'vendeur' ? 'active' : '' }}"><i class="fas fa-store" style="color: #ff8c00;"></i> Liste Vendeurs</a></li>
            </ul>
        </div>

        <div class="sidebar-section">
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}"><i class="fas fa-image" style="color: #ff8c00;"></i> Bannières</a></li>
                <li><a href="{{ route('admin.highlights.index') }}" class="{{ request()->routeIs('admin.highlights.*') ? 'active' : '' }}"><i class="fas fa-newspaper" style="color: #ff8c00;"></i> Actualités</a></li>
            </ul>
        </div>

        <div class="sidebar-section" x-data="{ openParams: {{ request()->routeIs('admin.categories.*', 'admin.filters.*', 'admin.users.*', 'admin.settings.*', 'admin.credits.*', 'admin.abonnements.*') ? 'true' : 'false' }} }">
            <ul class="sidebar-menu">
                <li>
                    <a href="javascript:void(0)" @click="openParams = !openParams" style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="display: flex; align-items: center; gap: 12px;">
                            <i class="fas fa-cog" style="color: #ff8c00;"></i>
                            Paramètres
                        </span>
                        <i class="fas fa-chevron-down" style="font-size: 0.6rem; transition: transform 0.2s;" :style="openParams ? 'transform: rotate(180deg)' : ''"></i>
                    </a>
                    <ul class="sidebar-submenu" x-show="openParams" x-cloak style="list-style: none; padding-left: 1rem; background: rgba(0,0,0,0.05);">
                        <li><a href="{{ route('admin.categories.l1') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.75rem 1.5rem;"><i class="fas fa-sitemap" style="font-size: 0.8rem; opacity: 0.7;"></i> Catégories</a></li>
                        <li><a href="{{ route('admin.filters.index') }}" class="{{ request()->routeIs('admin.filters.*') ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.75rem 1.5rem;"><i class="fas fa-filter" style="font-size: 0.8rem; opacity: 0.7;"></i> Filtres</a></li>
                        <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') && !request()->has('role') ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.75rem 1.5rem;"><i class="fas fa-users" style="font-size: 0.8rem; opacity: 0.7;"></i> Utilisateurs</a></li>
                        <li><a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.index') ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.75rem 1.5rem;"><i class="fas fa-tools" style="font-size: 0.8rem; opacity: 0.7;"></i> Configuration</a></li>
                        <li><a href="{{ route('admin.credits.packs') }}" class="{{ request()->routeIs('admin.credits.packs*') ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.75rem 1.5rem;"><i class="fas fa-coins" style="font-size: 0.8rem; opacity: 0.7;"></i> Packs Crédits</a></li>
                        <li><a href="{{ route('admin.abonnements.index') }}" class="{{ request()->routeIs('admin.abonnements.*') ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.75rem 1.5rem;"><i class="fas fa-id-card" style="font-size: 0.8rem; opacity: 0.7;"></i> Abonnements</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</aside>
