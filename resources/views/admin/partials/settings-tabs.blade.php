@php
    $tabs = [
        ['id' => 'categories', 'label' => 'Catégories', 'route' => 'admin.categories.l1', 'icon' => 'fa-sitemap'],
        ['id' => 'filters', 'label' => 'Filtres', 'route' => 'admin.filters.index', 'icon' => 'fa-filter'],
        ['id' => 'users', 'label' => 'Utilisateurs', 'route' => 'admin.users.index', 'icon' => 'fa-users'],
        ['id' => 'gift_cards', 'label' => 'Cartes Cadeaux', 'route' => 'admin.gift_cards.index', 'icon' => 'fa-gift'],
        ['id' => 'configuration', 'label' => 'Configuration', 'route' => 'admin.settings.index', 'icon' => 'fa-tools'],
        ['id' => 'credits', 'label' => 'Crédits', 'route' => 'admin.credits.packs', 'icon' => 'fa-coins'],
        ['id' => 'abonnements', 'label' => 'Abonnements', 'route' => 'admin.abonnements.index', 'icon' => 'fa-id-card'],
        ['id' => 'highlights', 'label' => 'Actualités', 'route' => 'admin.highlights.index', 'icon' => 'fa-star'],
        ['id' => 'annonces', 'label' => 'Annonces', 'route' => 'admin.annonces.moderation.index', 'icon' => 'fa-ad'],
        ['id' => 'roles', 'label' => 'Rôles & Perms', 'route' => 'admin.roles.index', 'icon' => 'fa-shield-alt'],
    ];

    $currentTab = null;
    if (request()->routeIs('admin.categories.*'))
        $currentTab = 'categories';
    elseif (request()->routeIs('admin.filters.*'))
        $currentTab = 'filters';
    elseif (request()->routeIs('admin.users.*'))
        $currentTab = 'users';
    elseif (request()->routeIs('admin.gift_cards.*'))
        $currentTab = 'gift_cards';
    elseif (request()->routeIs('admin.settings.*'))
        $currentTab = 'configuration';
    elseif (request()->routeIs('admin.credits.*'))
        $currentTab = 'credits';
    elseif (request()->routeIs('admin.abonnements.*'))
        $currentTab = 'abonnements';
    elseif (request()->routeIs('admin.highlights.*') || request()->routeIs('admin.highlight-tabs.*'))
        $currentTab = 'highlights';
    elseif (request()->routeIs('admin.annonces.*'))
        $currentTab = 'annonces';
    elseif (request()->routeIs('admin.roles.*'))
        $currentTab = 'roles';
@endphp

<div id="tabs-wrapper"
    style="background: #fff; border: 1px solid #e7e7e7; border-bottom: none; box-shadow: inset 0 -1px 0 #e7e7e7; margin-bottom: 0; position: relative; display: flex; align-items: center; overflow: hidden; height: 50px;">

    <!-- Fleche Gauche -->
    <div id="fade-left"
        style="position: absolute; left: 0; top: 0; bottom: 1px; width: 50px; background: linear-gradient(to right, #fff 30%, rgba(255,255,255,0)); z-index: 5; pointer-events: none; display: none;">
    </div>
    <button id="scroll-left" class="nav-arrow" title="Précédent"
        style="position: absolute; left: 0; top: 0; bottom: 1px; width: 28px; background: #fff; border: none; border-right: 1px solid #e7e7e7; z-index: 10; cursor: pointer; display: none; align-items: center; justify-content: center; color: #888; transition: all 0.2s;">
        <i class="fas fa-chevron-left" style="font-size: 0.75rem;"></i>
    </button>

    <!-- Conteneur des onglets -->
    <div id="tabs-container"
        style="display: flex; align-items: stretch; overflow-x: auto; scroll-behavior: smooth; -ms-overflow-style: none; scrollbar-width: none; flex: 1; padding: 0; height: 100%;">
        @foreach($tabs as $tab)
            <a href="{{ route($tab['route']) }}" class="settings-tab-link" data-tab-id="{{ $tab['id'] }}"
                style="display: flex; align-items: center; gap: 8px; padding: 0 22px; font-size: 0.85rem; font-weight: {{ $currentTab == $tab['id'] ? '700' : '500' }}; color: {{ $currentTab == $tab['id'] ? '#111' : '#555' }}; text-decoration: none; transition: all 0.2s; white-space: nowrap; position: relative; margin-bottom: 1px;"
                onmouseover="this.style.color='#111'"
                onmouseout="this.style.color='{{ $currentTab == $tab['id'] ? '#111' : '#555' }}'">
                <i class="fas {{ $tab['icon'] }}"
                    style="font-size: 0.85rem; opacity: {{ $currentTab == $tab['id'] ? '1' : '0.6' }}; color: {{ $currentTab == $tab['id'] ? '#e77600' : 'inherit' }};"></i>
                {{ $tab['label'] }}
            </a>
        @endforeach
    </div>

    <!-- Fleche Droite -->
    <div id="fade-right"
        style="position: absolute; right: 0; top: 0; bottom: 1px; width: 50px; background: linear-gradient(to left, #fff 30%, rgba(255,255,255,0)); z-index: 5; pointer-events: none; display: none;">
    </div>
    <button id="scroll-right" class="nav-arrow" title="Suivant"
        style="position: absolute; right: 0; top: 0; bottom: 1px; width: 28px; background: #fff; border: none; border-left: 1px solid #e7e7e7; z-index: 10; cursor: pointer; display: none; align-items: center; justify-content: center; color: #888; transition: all 0.2s;">
        <i class="fas fa-chevron-right" style="font-size: 0.75rem;"></i>
    </button>
</div>

<style>
    #tabs-container::-webkit-scrollbar {
        display: none;
    }

    .nav-arrow:hover {
        background: #fcfcfc !important;
        color: #e77600 !important;
    }

    .settings-tab-link:hover {
        background: rgba(0, 0, 0, 0.02);
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
            const activeTab = container.querySelector('[style*="border-bottom: 3px solid #e77600"]');
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