@php
    $tabs = [
        ['id' => 'categories', 'label' => 'Catégories', 'route' => 'admin.categories.l1', 'icon' => 'fa-sitemap'],
        ['id' => 'filters', 'label' => 'Filtres', 'route' => 'admin.filters.index', 'icon' => 'fa-filter'],
        ['id' => 'visibility', 'label' => 'Visibilité', 'route' => 'admin.settings.visibility', 'icon' => 'fa-eye'],
        ['id' => 'users', 'label' => 'Utilisateurs', 'route' => 'admin.users.index', 'icon' => 'fa-users'],
        ['id' => 'gift_cards', 'label' => 'Cartes Cadeaux', 'route' => 'admin.gift_cards.index', 'icon' => 'fa-gift'],
        ['id' => 'configuration', 'label' => 'Configuration', 'route' => 'admin.settings.index', 'icon' => 'fa-tools'],
        ['id' => 'credits', 'label' => 'Crédits', 'route' => 'admin.credits.packs', 'icon' => 'fa-coins'],
        ['id' => 'abonnements', 'label' => 'Abonnements', 'route' => 'admin.abonnements.index', 'icon' => 'fa-id-card'],
        ['id' => 'roles', 'label' => 'Rôles & Perms', 'route' => 'admin.roles.index', 'icon' => 'fa-shield-alt'],
        ['id' => 'pays', 'label' => 'Pays', 'route' => 'admin.countries.index', 'icon' => 'fa-globe-africa'],
        ['id' => 'expedition', 'label' => 'Expédition', 'route' => 'admin.shipping.index', 'icon' => 'fa-truck-loading'],
    ];

    $currentTab = null;
    if (request()->routeIs('admin.categories.*'))
        $currentTab = 'categories';
    elseif (request()->routeIs('admin.filters.*'))
        $currentTab = 'filters';
    elseif (request()->routeIs('admin.settings.visibility'))
        $currentTab = 'visibility';
    elseif (request()->routeIs('admin.users.*'))
        $currentTab = 'users';
    elseif (request()->routeIs('admin.gift_cards.*'))
        $currentTab = 'gift_cards';
    elseif (request()->routeIs('admin.settings.*') || request()->routeIs('admin.shipping.*'))
        $currentTab = 'expedition';
    elseif (request()->routeIs('admin.credits.*'))
        $currentTab = 'credits';
    elseif (request()->routeIs('admin.abonnements.*'))
        $currentTab = 'abonnements';
    elseif (request()->routeIs('admin.roles.*'))
        $currentTab = 'roles';
    elseif (request()->routeIs('admin.countries.*'))
        $currentTab = 'pays';
@endphp

<div id="tabs-wrapper"
    style="background: #fff; border-bottom: 1px solid #e2e8f0; position: relative; display: flex; align-items: center; overflow: hidden; height: 34px;">

    <!-- Fleche Gauche -->
    <div id="fade-left"
        style="position: absolute; left: 0; top: 0; bottom: 0; width: 40px; background: linear-gradient(to right, #fff, transparent); z-index: 5; pointer-events: none; display: none;">
    </div>
    <button id="scroll-left" class="nav-arrow" title="Précédent"
        style="position: absolute; left: 0; top: 0; bottom: 0; width: 32px; background: #fff; border: none; z-index: 10; cursor: pointer; display: none; align-items: center; justify-content: center; color: #94a3b8; transition: all 0.2s;">
        <i class="fas fa-chevron-left" style="font-size: 0.8rem;"></i>
    </button>

    <!-- Conteneur des onglets -->
    <div id="tabs-container"
        style="display: flex; align-items: stretch; overflow-x: auto; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none; flex: 1; padding: 0; height: 100%;">
        @foreach($tabs as $tab)
            <a href="{{ route($tab['route']) }}" class="settings-tab-link {{ $currentTab == $tab['id'] ? 'active' : '' }}" data-tab-id="{{ $tab['id'] }}"
                style="display: flex; align-items: center; gap: 8px; padding: 0 18px; font-size: 0.78rem; font-weight: {{ $currentTab == $tab['id'] ? '600' : '400' }}; color: {{ $currentTab == $tab['id'] ? '#475569' : '#94a3b8' }}; text-decoration: none; transition: all 0.2s; white-space: nowrap; position: relative; background: transparent; border: none;"
                onmouseover="this.style.color='{{ $currentTab == $tab['id'] ? '#334155' : '#64748b' }}'; this.style.background='rgba(0,0,0,0.02)'"
                onmouseout="this.style.color='{{ $currentTab == $tab['id'] ? '#475569' : '#94a3b8' }}'; this.style.background='transparent'">
                <i class="fas {{ $tab['icon'] }}"
                    style="font-size: 0.85rem; color: {{ $currentTab == $tab['id'] ? '#ff9900' : '#cbd5e1' }}; transition: all 0.2s;"></i>
                {{ $tab['label'] }}
            </a>
        @endforeach
    </div>

    <!-- Fleche Droite -->
    <div id="fade-right"
        style="position: absolute; right: 0; top: 0; bottom: 0; width: 40px; background: linear-gradient(to left, #fff, transparent); z-index: 5; pointer-events: none; display: none;">
    </div>
    <button id="scroll-right" class="nav-arrow" title="Suivant"
        style="position: absolute; right: 0; top: 0; bottom: 0; width: 32px; background: #fff; border: none; z-index: 10; cursor: pointer; display: none; align-items: center; justify-content: center; color: #94a3b8; transition: all 0.2s;">
        <i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i>
    </button>
</div>

<style>
    #tabs-container::-webkit-scrollbar {
        display: none;
    }

    .nav-arrow:hover {
        color: #ff9900 !important;
    }

    .settings-tab-link:hover {
        background: #f8fafc;
    }
    
    .settings-tab-link.active i {
        transform: scale(1.1);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('tabs-container');
        const btnLeft = document.getElementById('scroll-left');
        const btnRight = document.getElementById('scroll-right');
        const fadeLeft = document.getElementById('fade-left');
        const fadeRight = document.getElementById('fade-right');

        function updateArrows() {
            const isScrollable = container.scrollWidth > container.clientWidth;
            if (isScrollable) {
                const atStart = container.scrollLeft <= 10;
                const atEnd = container.scrollLeft >= (container.scrollWidth - container.clientWidth - 10);

                btnLeft.style.display = atStart ? 'none' : 'flex';
                fadeLeft.style.display = atStart ? 'none' : 'block';

                btnRight.style.display = atEnd ? 'none' : 'flex';
                fadeRight.style.display = atEnd ? 'none' : 'block';
            } else {
                btnLeft.style.display = 'none';
                btnRight.style.display = 'none';
                fadeLeft.style.display = 'none';
                fadeRight.style.display = 'none';
            }
        }

        btnLeft.onclick = () => container.scrollBy({ left: -250, behavior: 'smooth' });
        btnRight.onclick = () => container.scrollBy({ left: 250, behavior: 'smooth' });

        container.addEventListener('scroll', updateArrows);
        window.addEventListener('resize', updateArrows);

        setTimeout(() => {
            updateArrows();
            const activeTab = container.querySelector('.settings-tab-link.active');
            if (activeTab) {
                const rect = activeTab.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();
                if (rect.left < containerRect.left || rect.right > containerRect.right) {
                    activeTab.scrollIntoView({ inline: 'center', behavior: 'smooth' });
                }
            }
        }, 100);
    });
</script>