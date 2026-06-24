    @include('layouts.partials.header_css')
<header class="header">
        <div class="header-row-1">
            <div class="header-container">
                <button class="mobile-menu-btn" @click="mobileMenuOpen = true">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="header-brand-group">
                    <a href="{{ route('home') }}" class="header-logo-text">
                        @if($logoUrl = \App\Models\Setting::logoUrl())
                            <img src="{{ $logoUrl }}" alt="{{ $siteSettings['site_name'] ?? 'Logo' }}" style="height: 26px; width: auto;">
                        @else
                            {{ $siteSettings['site_name'] ?? 'Logo' }}
                        @endif
                    </a>

                </div>

                <div class="search-container desktop-only">
                    <form action="{{ route('search.index') }}" method="GET" style="width: 100%;"
                        id="global-search-form">
                        <div class="search-field">
                            <input type="text" name="q" class="search-input" id="global-search-input"
                                placeholder="Rechercher un produit" value="{{ request('q') }}"
                                autocomplete="off">
                            <button type="submit" class="search-button">
                                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
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
                        <span class="sell-icon" style="display: flex; align-items: center; justify-content: center; margin-right: 6px;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M4 11l8 8a2 2 0 002.828 0l5.858-5.858a2 2 0 000-2.828L11 4H5a2 2 0 00-2 2v6z"></path>
                            </svg>
                        </span>
                        <span>Mettre en vente</span>
                    </button>
                    <div class="sell-dropdown" id="layoutSellDropdown">
                        <a href="{{ route('annonces.create') }}" class="sell-dropdown-item">
                            <div class="sell-dropdown-item-title">Vendre un produit</div>
                            <div class="sell-dropdown-item-subtitle">Je dépose une annonce gratuitement</div>
                        </a>
                        <a href="{{ route('vendeur.astuces') }}" class="sell-dropdown-item" style="padding-top: 0.25rem;">
                            <div class="sell-dropdown-item-title" style="font-weight: 400; text-decoration: underline;">Astuces vendeurs</div>
                        </a>
                        <div class="sell-dropdown-separator"></div>
                        <a href="{{ route('eshop.landing') }}" class="sell-dropdown-item">
                            <div class="sell-dropdown-item-title">Je suis un commerçant</div>
                            <div class="sell-dropdown-item-subtitle">J'ouvre un e-shop</div>
                        </a>
                    </div>
                </div>

                    @auth
                        @php
                            $unreadCount = auth()->user()->unreadMessagesCount();
                        @endphp
                        <a href="{{ route('conversations.index') }}" class="header-link header-msg-link" style="position: relative; display: inline-flex; align-items: center;" title="Messagerie">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            @if($unreadCount > 0)
                                <span style="position: absolute; top: -8px; right: -8px; background: #e11d48 !important; color: white !important; border-radius: 50%; min-width: 18px; height: 18px; padding: 0 4px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; z-index: 999 !important;">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </a>
                        @if(auth()->check() && auth()->user()->hasRole('admin'))
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
                            <a href="{{ route('account.index') }}" class="header-link" style="position: relative;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                @if($unreadCount > 0)
                                    <span style="position: absolute; top: -5px; left: 10px; background: #e11d48; color: white; border-radius: 50%; width: 17px; height: 17px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; z-index: 10;">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
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
                                        <a href="{{ route('account.orders') }}" class="auth-menu-item">Suivi de commande</a>
                                        <a href="{{ route('vendeur.wallet.index') }}" class="auth-menu-item">Mon porte-monnaie</a>
                                        <a href="{{ route('conversations.index') }}" class="auth-menu-item">Mes Messages</a>
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                            <a href="#" class="auth-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
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
                                        <a href="{{ route('account.orders') }}" class="auth-menu-item">Suivi de commande</a>
                                        <a href="{{ route('vendeur.wallet.index') }}" class="auth-menu-item">Mon porte-monnaie</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth



                    <a href="{{ route('favorites.index') }}" class="header-link" title="Mes Favoris">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </a>

                    @inject('cartService', 'App\Services\CartService')
                    <a href="{{ route('cart.index') }}" class="header-link" title="Mon Panier" style="position: relative;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        @if($cartService->getItemsCount() > 0)
                            <span
                                style="position: absolute; top: -8px; right: -8px; background: #f68b1e !important; color: white !important; border-radius: 50%; width: 18px; height: 18px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; z-index: 999 !important;">
                                {{ $cartService->getItemsCount() }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Search Row (Hidden on Desktop) -->
        <div class="mobile-search-row">
            <div class="header-container">
                <div class="search-container mobile-only">
                    <form action="{{ route('search.index') }}" method="GET" style="width: 100%;"
                        id="mobile-search-form">
                        <div class="search-field">
                            <input type="text" name="q" class="search-input" id="mobile-search-input"
                                placeholder="Rechercher un produit" value="{{ request('q') }}"
                                autocomplete="off">
                            <button type="submit" class="search-button">
                                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="header-row-2">
            <div class="header-container" style="display: flex; align-items: center; gap: 1rem; padding-left: 1.5rem; max-width: 1400px; margin: 0 auto;">
                <div class="cat-nav-item" @click="mobileMenuOpen = !mobileMenuOpen" style="margin-right: 0.5rem; color: #333;">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Toutes les catégories
                </div>

                @php 
                    $nav_cats = \App\Models\Category::racines()->actives()->parOrdre()->get(); 
                @endphp

                <div class="header-badges-container">
                    @foreach($nav_cats as $cat)
                        <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                            <a href="{{ route('categories.show', $cat->slug) }}" class="cat-nav-item badge-style">
                                {{ $cat->nom }}
                            </a>
                            @foreach($cat->enfantsActifs()->take(1)->get() as $sub)
                                <a href="{{ route('categories.show', $cat->slug) }}?active={{ $sub->id }}" class="badge-style">
                                    {{ $sub->nom }}
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @php 
            $cats = \App\Models\Category::racines()->actives()->parOrdre()->get(); 
        @endphp

        <!-- Mega Menu Dropdown -->
        <div class="mobile-menu-drawer" x-show="mobileMenuOpen"
            :class="{ 'open': mobileMenuOpen }" x-data="{ selectedCategory: null, openCat: null }"
            @click.away="mobileMenuOpen = false" x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0">

            <!-- ═══ DESKTOP: two-column layout ═══ -->
            <div class="mega-menu-desktop">
                <!-- Left Sidebar -->
                <div class="mega-sidebar">
                    @foreach($cats as $cat)
                        <div class="cat-sidebar-item"
                            :class="{ 'active-cat-item': selectedCategory === {{ $cat->id }} }"
                            @mouseenter="selectedCategory = {{ $cat->id }}"
                            @click="selectedCategory = {{ $cat->id }}">
                            <span>{{ $cat->nom }}</span>
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    @endforeach
                </div>

                <!-- Right Pane -->
                <div class="mega-content" x-show="selectedCategory"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100">
                    @foreach($cats as $cat)
                        <div x-show="selectedCategory === {{ $cat->id }}" style="display: flex; gap: 60px;">
                            <div style="flex: 1; display: flex; flex-direction: column; gap: 0;">
                                @foreach($cat->enfantsActifs()->with('enfantsActifs')->get() as $sousCat)
                                    <div style="display: flex; border-bottom: 1px solid #eee; padding: 10px 0;">
                                        <div style="width: 250px; padding-right: 30px;">
                                            <h3 style="font-size: 0.75rem; font-weight: 800; color: #000; text-transform: uppercase; letter-spacing: 0.5px; margin: 4px 0 0 0; line-height: 1.2;">
                                                <a href="{{ route('categories.show', $cat->slug) }}?active={{ $sousCat->id }}"
                                                    style="text-decoration: none; color: inherit;">{{ $sousCat->nom }}</a>
                                            </h3>
                                        </div>
                                        <div style="flex: 1; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 40px;">
                                            @foreach($sousCat->enfantsActifs as $enfant)
                                                <a href="{{ route('categories.show', $cat->slug) }}?active={{ $sousCat->id }}&n3={{ $enfant->id }}"
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

            <!-- ═══ MOBILE: vertical accordion ═══ -->
            <div class="mega-menu-mobile">
                @foreach($cats as $cat)
                    <div class="acc-item">
                        <!-- Category header row -->
                        <div class="acc-header" @click="openCat = (openCat === {{ $cat->id }}) ? null : {{ $cat->id }}">
                            <a href="{{ route('categories.show', $cat->slug) }}"
                                class="acc-header-link"
                                @click.stop>
                                {{ $cat->nom }}
                            </a>
                            <svg class="acc-chevron" :class="{ 'rotated': openCat === {{ $cat->id }} }"
                                width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Subcategories (expand vertically) -->
                        <div class="acc-body" x-show="openCat === {{ $cat->id }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-1"
                            x-transition:enter-end="opacity-100 transform translate-y-0">
                            @foreach($cat->enfantsActifs()->with('enfantsActifs')->get() as $sousCat)
                                <div class="acc-subcat-group">
                                    <a href="{{ route('categories.show', $cat->slug) }}?active={{ $sousCat->id }}"
                                        class="acc-subcat-title">
                                        {{ $sousCat->nom }}
                                    </a>
                                    @foreach($sousCat->enfantsActifs as $enfant)
                                        <a href="{{ route('categories.show', $cat->slug) }}?active={{ $sousCat->id }}&n3={{ $enfant->id }}"
                                            class="acc-subcat-child">
                                            {{ $enfant->nom }}
                                        </a>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
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

