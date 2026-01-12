    <header class="header">
        <div class="header-row-1">
            <div class="header-container">
                <button class="mobile-menu-btn" @click="mobileMenuOpen = true">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <a href="{{ route('home') }}" class="logo"></a>

                <div class="search-container">
                    <form action="{{ route('search.index') }}" method="GET" style="width: 100%;"
                        id="global-search-form">
                        <div class="search-field">
                            <input type="text" name="q" class="search-input" id="global-search-input"
                                placeholder="Je cherche un produit, une marque..." value="{{ request('q') }}"
                                autocomplete="off">
                            <button type="submit" class="search-button">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <div id="autocomplete-results"></div>
                </div>

                <div class="header-actions">

                    <div class="sell-button-container">
                        <button type="button" class="sell-button" style="cursor: default;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            <span>Mettre en vente</span>
                            <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="sell-dropdown" id="layoutSellDropdown">
                            <!-- Inactif -->
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->hasRole('Administrateur'))
                            <a href="{{ route('admin.categories.l1') }}" class="header-link">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span style="font-weight: 800; color: #bf0000;">Back Office</span>
                            </a>
                        @endif
                        <a href="{{ route('profile.show') }}" class="header-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ auth()->user()->prenom ?? auth()->user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="header-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Connexion</span>
                        </a>
                    @endauth

                    @auth
                        <span class="header-link disabled-action" title="Favoris">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </span>
                    @endauth

                    @inject('cartService', 'App\Services\CartService')
                    <span class="header-link disabled-action" title="Panier">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        @if($cartService->getItemsCount() > 0)
                            <span
                                style="position: absolute; top: -8px; right: -8px; background: #bf0000; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white;">
                                {{ $cartService->getItemsCount() }}
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="header-row-2">
            <div class="header-container" style="min-height: 40px; justify-content: flex-start; gap: 2rem;">
                <div class="cat-nav-item" @click="mobileMenuOpen = !mobileMenuOpen"
                    style="font-weight: bold; display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Toutes les catégories
                </div>
                <a href="{{ route('search.index', ['category' => 'e-commerce']) }}" class="cat-nav-item badge-style">E-commerce</a>
                <a href="{{ route('search.index', ['category' => 'telephonie-tablette']) }}" class="cat-nav-item badge-style">Téléphonie, Tablette</a>
                <a href="{{ route('search.index', ['category' => 'immobilier']) }}" class="cat-nav-item badge-style">Immobilier</a>
                <a href="{{ route('search.index', ['category' => 'vehicules']) }}" class="cat-nav-item badge-style">Véhicules</a>
            </div>
        </div>

        @php 
            $cats = \App\Models\Category::racines()->actives()->parOrdre()->get(); 
        @endphp

        <!-- Mega Menu Dropdown -->
        <div class="mobile-menu-drawer" x-show="mobileMenuOpen"
            :class="{ 'open': mobileMenuOpen, 'expanded': selectedCategory }" x-data="{ selectedCategory: null }"
            @click.away="mobileMenuOpen = false" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0">


            <!-- Main Content Panel -->
            <div style="display: flex; height: 600px; overflow: hidden; background: #fff;">
                <!-- Left Sidebar: All Categories -->
                <div
                style="width: 250px; min-width: 250px; background: #fff; border-right: 1px solid #f0f0f0; overflow-y: auto;">
                @foreach($cats as $cat)
                    <div class="cat-sidebar-item" :class="{ 'active-cat-item': selectedCategory === {{ $cat->id }} }"
                        @mouseenter="selectedCategory = {{ $cat->id }}" @click="selectedCategory = {{ $cat->id }}">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span
                                style="font-size: 1rem; width: 20px; text-align: center; color: inherit;">{!! $cat->icone ?? '📁' !!}</span>
                            <span style="font-size: 0.88rem; font-weight: 400;">{{ $cat->nom }}</span>
                        </div>
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7">
                            </path>
                            </svg>
                        </div>
                @endforeach
                </div>

                <!-- Right Pane: Hierarchical Content -->
                <div x-show="selectedCategory" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                style="flex: 1; overflow-y: auto; padding: 40px; background: #fff; border-left: 1px solid #eee;">
                    @foreach($cats as $cat)
                        <div x-show="selectedCategory === {{ $cat->id }}" style="display: flex; gap: 60px;">
                            <!-- Hierarchical Groups -->
                        <div style="flex: 1; display: flex; flex-direction: column; gap: 0;">
                            @foreach($cat->enfantsActifs()->with('enfantsActifs')->get() as $sousCat)
                                <div style="display: flex; border-bottom: 1px solid #eee; padding: 20px 0;">
                                    <!-- Level 2 Header -->
                                    <div style="width: 250px; padding-right: 30px;">
                                        <h3
                                            style="font-size: 0.75rem; font-weight: 800; color: #000; text-transform: uppercase; letter-spacing: 0.5px; margin: 4px 0 0 0; line-height: 1.2;">
                                            <a href="{{ route('categories.show', $sousCat->slug) }}"
                                                style="text-decoration: none; color: inherit;">{{ $sousCat->nom }}</a>
                                                </h3>
                                    </div>
                                    <!-- Level 3 Links Grid -->
                                    <div
                                    style="flex: 1; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 40px;">
                                    @foreach($sousCat->enfantsActifs as $enfant)
                                        <a href="{{ route('categories.show', $enfant->slug) }}"
                                            style="text-decoration: none; color: #666; font-size: 0.85rem; transition: color 0.1s; font-weight: 400;"
                                            onmouseover="this.style.color='#000'; this.style.textDecoration='underline';"
                                            onmouseout="this.style.color='#666'; this.style.textDecoration='none';">
                                                {{ $enfant->nom }}
                                            </a>
                                    @endforeach
                                        </div>
                                    </div>
                            @endforeach
                            </div>

                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <script>
        function toggleSellDropdown() {
            const button = event.target.closest('.sell-button');
            const container = button.closest('.sell-button-container');
            const dropdown = container.querySelector('.sell-dropdown');

            dropdown.classList.toggle('show');
            button.classList.toggle('active');
        }

        document.addEventListener('click', (e) => {
            const container = document.querySelector('.sell-button-container');
            if (container && !container.contains(e.target)) {
                const dropdown = container.querySelector('.sell-dropdown');
                const button = container.querySelector('.sell-button');
                if (dropdown && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    button.classList.remove('active');
                }
            }
        });
    </script>
