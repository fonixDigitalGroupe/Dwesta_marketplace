<div style="background: #fff; border: 1px solid #e7e7e7; border-bottom: none; display: flex; align-items: stretch; margin-bottom: 0; padding: 0 10px; overflow-x: auto;">
    @php
        $tabs = [
            ['id' => 'categories', 'label' => 'Catégories', 'route' => 'admin.categories.l1', 'icon' => 'fa-sitemap'],
            ['id' => 'filters', 'label' => 'Filtres', 'route' => 'admin.filters.index', 'icon' => 'fa-filter'],
            ['id' => 'users', 'label' => 'Utilisateurs', 'route' => 'admin.users.index', 'icon' => 'fa-users'],
            ['id' => 'gift_cards', 'label' => 'Cartes Cadeaux', 'route' => 'admin.gift_cards.index', 'icon' => 'fa-gift'],
            ['id' => 'configuration', 'label' => 'Configuration', 'route' => 'admin.settings.index', 'icon' => 'fa-tools'],
            ['id' => 'credits', 'label' => 'Crédits', 'route' => 'admin.credits.packs', 'icon' => 'fa-coins'],
            ['id' => 'abonnements', 'label' => 'Abonnements', 'route' => 'admin.abonnements.index', 'icon' => 'fa-id-card'],
            ['id' => 'roles', 'label' => 'Rôles & Perms', 'route' => 'admin.roles.index', 'icon' => 'fa-shield-alt'],
        ];

        $currentTab = null;
        if (request()->routeIs('admin.categories.*')) $currentTab = 'categories';
        elseif (request()->routeIs('admin.filters.*')) $currentTab = 'filters';
        elseif (request()->routeIs('admin.users.*')) $currentTab = 'users'; // Careful with other user routes if needed
        elseif (request()->routeIs('admin.gift_cards.*')) $currentTab = 'gift_cards';
        elseif (request()->routeIs('admin.settings.*')) $currentTab = 'configuration';
        elseif (request()->routeIs('admin.credits.*')) $currentTab = 'credits';
        elseif (request()->routeIs('admin.abonnements.*')) $currentTab = 'abonnements';
        elseif (request()->routeIs('admin.roles.*')) $currentTab = 'roles';
    @endphp

    @foreach($tabs as $tab)
        <a href="{{ route($tab['route']) }}" 
           style="display: flex; align-items: center; gap: 8px; padding: 15px 25px; font-size: 0.85rem; font-weight: {{ $currentTab == $tab['id'] ? '700' : '500' }}; color: {{ $currentTab == $tab['id'] ? '#111' : '#555' }}; text-decoration: none; transition: all 0.2s; white-space: nowrap; position: relative;"
           onmouseover="this.style.color='#111'" onmouseout="this.style.color='{{ $currentTab == $tab['id'] ? '#111' : '#555' }}'">
            <i class="fas {{ $tab['icon'] }}" style="font-size: 0.9rem; opacity: {{ $currentTab == $tab['id'] ? '1' : '0.6' }}; color: {{ $currentTab == $tab['id'] ? '#e77600' : 'inherit' }};"></i>
            {{ $tab['label'] }}
        </a>
    @endforeach
</div>
