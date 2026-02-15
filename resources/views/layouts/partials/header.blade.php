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
                                placeholder="Rechercher un produit" value="{{ request('q') }}"
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
                    <button type="button" class="sell-button" onclick="toggleSellDropdown()">
                        <span class="sell-icon" style="font-size: 1.2rem; font-weight: 700;">€</span>
                        <span>Mettre en vente</span>
                    </button>
                    <div class="sell-dropdown" id="layoutSellDropdown">
                        <a href="{{ route('annonces.create') }}" class="sell-dropdown-item">
                            <div class="sell-dropdown-item-title">Vendre un produit en tant que particulier</div>
                            <div class="sell-dropdown-item-subtitle">Je dépose une annonce gratuitement</div>
                        </a>
                        <a href="#" class="sell-dropdown-item" style="padding-top: 0.25rem;">
                            <div class="sell-dropdown-item-title" style="font-weight: 400; text-decoration: underline;">Astuces vendeurs particuliers</div>
                        </a>
                        <div class="sell-dropdown-separator"></div>
                        <a href="{{ route('vendeur.create') }}" class="sell-dropdown-item">
                            <div class="sell-dropdown-item-title">Je suis un commerçant</div>
                            <div class="sell-dropdown-item-subtitle">J'ouvre un e-shop</div>
                        </a>
                    </div>
                </div>

                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.categories.l1') }}" class="header-link">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span style="font-weight: 800; color: #0099ff;">Back Office</span>
                            </a>
                        @endif
                        <div class="auth-dropdown-container">
                            <a href="{{ route('account.index') }}" class="header-link">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>{{ auth()->user()->prenom ?? auth()->user()->name }}</span>
                                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px; margin-left: -4px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>
                            <div class="auth-dropdown">
                                <div class="auth-dropdown-content">
                                    <div class="auth-menu-list">
                                        <a href="{{ route('account.index') }}" class="auth-menu-item">
                                            <span>Mon compte</span>
                                            <svg class="auth-icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="auth-menu-item">Suivi de commande</a>
                                        <a href="#" class="auth-menu-item">Mon porte-monnaie</a>
                                        <a href="#" class="auth-menu-item">Mes Messages</a>
                                        
                                        <div class="auth-separator"></div>
                                        
                                        <a href="{{ route('annonces.create') }}" class="auth-menu-item">Mettre en vente un produit</a>
                                        <a href="{{ route('annonces.index', ['vendeur' => auth()->id()]) }}" class="auth-menu-item">Mes articles en vente</a>
                                        <a href="#" class="auth-menu-item">Toutes mes ventes</a>
                                        
                                        <div class="auth-separator"></div>
                                        
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form-dropdown">
                                            @csrf
                                            <a href="#" class="auth-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form-dropdown').submit();" style="color: #0099ff;">
                                                Déconnexion
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="auth-dropdown-container">
                            <a href="{{ route('login') }}" class="header-link">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Se connecter</span>
                                <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px; margin-left: -4px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </a>
                            <div class="auth-dropdown">
                                <div class="auth-dropdown-content">
                                    <a href="{{ route('login') }}" class="auth-btn-login">Se connecter</a>
                                    <a href="{{ route('register') }}" class="auth-link-create">Créer un compte</a>
                                    <div class="auth-separator"></div>
                                    <div class="auth-menu-list">
                                        <a href="{{ route('login') }}" class="auth-menu-item">
                                            <span>Mon compte</span>
                                            <svg class="auth-icon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="#" class="auth-menu-item">Suivi de commande</a>
                                        <a href="#" class="auth-menu-item">Mon porte-monnaie</a>
                                        <a href="#" class="auth-menu-item">Mes Messages</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                        <span class="header-link disabled-action" title="Favoris">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </span>
                </div>
            </div>
        </div>

        <div class="header-row-2">
            <div class="header-container" style="display: flex; align-items: center; gap: 1rem; padding-left: 7rem;">
                <div class="cat-nav-item" @click="mobileMenuOpen = !mobileMenuOpen" style="margin-right: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Toutes les catégories
                </div>

                @php 
                    $nav_cats = \App\Models\Category::racines()->actives()->parOrdre()->get(); 
                @endphp

                <div class="header-badges-container" style="display: flex; gap: 8px; overflow-x: auto; scrollbar-width: none;">
                    @foreach($nav_cats as $cat)
                        <a href="{{ route('annonces.index', ['category' => $cat->id]) }}" class="cat-nav-item badge-style">
                            {{ $cat->nom }}
                        </a>
                    @endforeach
                </div>
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

    <style>
        .auth-dropdown-container {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .auth-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 320px;
            background: #fff;
            border: 1px solid #f8f8f8;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            border-radius: 8px;
            padding: 1.5rem;
            display: none;
            z-index: 1000;
            cursor: default;
            margin-top: 10px; /* Space for the arrow */
        }

        .auth-dropdown-container:hover .auth-dropdown {
            display: block;
        }

        /* Invisible bridge to keep hover active */
        .auth-dropdown::after {
            content: '';
            position: absolute;
            top: -20px;
            left: 0;
            width: 100%;
            height: 20px;
            background: transparent;
        }

        /* Triangle tip */
        .auth-dropdown::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            margin-left: -8px;
            width: 16px;
            height: 16px;
            background: #fff;
            border-top: 1px solid #eee;
            border-left: 1px solid #eee;
            transform: rotate(45deg);
            z-index: 1001; /* Ensure overlapping border */
        }

        .auth-dropdown-content {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .auth-btn-login {
            background: #000;
            color: #fff;
            font-weight: 700;
            text-align: center;
            padding: 0.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1rem;
            display: block;
            transition: all 0.2s;
        }

        .auth-btn-login:hover {
            background: #222;
            color: #fff;
            transform: translateY(-1px);
        }

        .auth-link-create {
            color: #333;
            text-align: center;
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            display: block;
            font-weight: 500;
        }

        .auth-link-create:hover {
            text-decoration: underline;
            color: #000;
        }

        .auth-separator {
            height: 1px;
            background: #f0f0f0;
            margin: 1rem 0;
        }

        .auth-menu-list {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .auth-menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #444;
            text-decoration: none;
            font-size: 0.95rem;
            padding: 0.5rem 0.5rem;
            border-radius: 4px;
            transition: background-color 0.1s, color 0.1s;
        }

        .auth-menu-item:hover {
            background-color: #f9f9f9;
            color: #0099ff;
        }

        .auth-icon-blue {
            width: 24px;
            height: 24px;
            color: #0099ff;
        }
    </style>
