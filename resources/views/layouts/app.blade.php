<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mady Market')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f6f6f6; color: #333; }
        [x-cloak] { display: none !important; }
        
        .top-banner { background-color: #bf0000; color: white; text-align: center; padding: 0.5rem; font-size: 0.9rem; position: relative; }
        .top-banner .close-btn { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); cursor: pointer; }

        .header { background-color: #ffffff; border-bottom: 1px solid #e0e0e0; position: sticky; top: 0; z-index: 2000; }
        .header-row-1 { border-bottom: 1px solid #f0f0f0; padding: 0.5rem 0; }
        .header-row-2 { background-color: #fff; padding: 0.5rem 0; box-shadow: 0 2px 4px rgba(0,0,0,0.05); position: relative; z-index: 10; }
        .header-container { width: 100%; padding: 0 1.5rem; display: flex; align-items: center; gap: 1.5rem; position: relative; }
        
        .logo { display: flex; align-items: center; text-decoration: none; font-size: 1.5rem; font-weight: bold; color: #bf0000; flex-shrink: 0; }
        .logo img { height: 40px; margin-right: 0.5rem; }

        .search-container { flex: 1; display: flex; align-items: center; max-width: 100%; position: relative; }
        .search-field { flex: 1; display: flex; border: 1px solid #e0e0e0; border-radius: 4px; overflow: hidden; }
        .search-input { flex: 1; padding: 0.75rem 1rem; border: none; font-size: 1rem; outline: none; }
        .search-button { background-color: #333; color: white; border: none; padding: 0 1.25rem; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .search-button:hover { background-color: #000; }

        .header-actions { display: flex; align-items: center; gap: 1.5rem; flex-shrink: 0; }
        .header-link { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: #333; font-size: 0.9rem; font-weight: 500; position: relative; }
        .header-link:hover { color: #bf0000; }
        .header-link svg { width: 22px; height: 22px; }

        .club-r { display: flex; align-items: center; gap: 0.25rem; padding: 0.4rem 0.8rem; background: #fdf2f2; border-radius: 20px; color: #bf0000; font-weight: bold; font-size: 0.85rem; text-decoration: none; }
        
        .sell-button-container { position: relative; }
        .sell-button { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: #333; font-size: 0.9rem; font-weight: 500; cursor: pointer; background: white; border: none; padding: 0.5rem; }
        .sell-button:hover { color: #bf0000; }
        .sell-button .chevron { width: 12px; height: 12px; transition: transform 0.2s; }
        .sell-button.active .chevron { transform: rotate(180deg); }
        .sell-dropdown { position: absolute; top: 100%; left: 0; margin-top: 0.5rem; background: white; border: 1px solid #e0e0e0; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 280px; z-index: 1000; display: none; }
        .sell-dropdown.show { display: block; }
        .sell-dropdown-item { display: block; padding: 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #f0f0f0; transition: background-color 0.2s; }
        .sell-dropdown-item:last-child { border-bottom: none; }
        .sell-dropdown-item:hover { background-color: #f5f5f5; }
        .sell-dropdown-item-title { font-weight: 500; font-size: 0.95rem; color: #333; margin-bottom: 0.25rem; }
        .sell-dropdown-item-subtitle { font-size: 0.85rem; color: #666; }
        
        .cat-nav-btn { display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0; background: none; border: none; font-weight: bold; cursor: pointer; color: #333; }
        .quick-links { display: flex; align-items: center; gap: 0.75rem; list-style: none; margin-left: 0; }
        .quick-links a { text-decoration: none; color: #333; font-size: 0.85rem; font-weight: 500; background: #f0f0f0; padding: 4px 14px; border-radius: 50px; transition: all 0.2s; }
        .quick-links a:hover { background: #e0e0e0; color: #000; }
        .quick-links a.active { background: #bf0000; color: #fff; }

        .footer { background-color: #333; color: #fff; padding: 4rem 0 2rem; margin-top: 4rem; }
        .footer-container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; }
        .footer-col h4 { margin-bottom: 1.5rem; font-size: 1.1rem; color: #fff; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 0.75rem; }
        .footer-col ul li a { color: #bbb; text-decoration: none; font-size: 0.9rem; }
        .footer-col ul li a:hover { color: #fff; }
        .footer-bottom { border-top: 1px solid #444; margin-top: 3rem; padding-top: 2rem; text-align: center; color: #888; font-size: 0.85rem; }
        .social-icons { display: flex; gap: 1rem; margin-top: 1rem; }
        .social-icons a { color: white; border: 1px solid #555; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
        .social-icons a:hover { background: #bf0000; border-color: #bf0000; }
        .payment-icons { display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem; filter: grayscale(1); opacity: 0.6; }

        /* Autocomplétion UI */
        #autocomplete-results { position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e0e0e0; border-radius: 0 0 4px 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 2000; display: none; }
        .autocomplete-item { padding: 0.75rem 1rem; cursor: pointer; border-bottom: 1px solid #f9f9f9; display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: #333; }
        .autocomplete-item:hover { background: #fdf2f2; }
        .autocomplete-item .type-badge { font-size: 0.7rem; padding: 2px 6px; border-radius: 10px; background: #eee; color: #666; }

        /* Mobile Menu */
        .mobile-menu-btn { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #333; }
        /* Mega Menu Positioning */
        .mobile-menu-drawer { position: absolute; top: 100%; left: 0; width: 250px; background: white; z-index: 2010; flex-direction: column; box-shadow: 0 15px 40px rgba(0,0,0,0.15); border: 1px solid #e5e5e5; border-top: none; max-height: 85vh; border-radius: 0 0 4px 4px; overflow: hidden; transition: width 0.3s ease-in-out; }
        .mobile-menu-drawer.expanded { width: 1200px; }
        .open { display: flex !important; }
        
        .active-cat-item {
            background: #000 !important;
            color: #fff !important;
        }
        .active-cat-item svg { color: #fff !important; opacity: 1 !important; }
        
        .cat-sidebar-item {
            display: flex; align-items: center; justify-content: space-between; padding: 7px 20px; cursor: pointer; color: #333; transition: all 0.1s; border-bottom: 1px solid transparent;
        }
        .cat-sidebar-item:hover:not(.active-cat-item) { background: #f8f8f8; }
        .cat-sidebar-item svg { opacity: 0.4; color: #666; }
        
        @media (max-width: 768px) {
            .mobile-menu-btn { display: block; margin-right: 1rem; }
            .header-container { gap: 1rem; flex-wrap: wrap; }
            .search-container { order: 3; max-width: none; margin-top: 0.5rem; }
            .header-actions { order: 2; margin-left: auto; gap: 1rem; }
            .header-row-2 { display: none; }
            .footer-container { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
    @stack('styles')
</head>
<body x-data="{ mobileMenuOpen: false }">
    <div class="top-banner">
        Mady Market : Profitez de nos meilleures offres sur tous les produits !
        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
    </div>

    <header class="header">
        <div class="header-row-1">
            <div class="header-container">
                <button class="mobile-menu-btn" @click="mobileMenuOpen = true">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <a href="{{ route('home') }}" class="logo">
                    Mady Market
                </a>

                <div class="search-container">
                    <form action="{{ route('search.index') }}" method="GET" style="width: 100%;" id="global-search-form">
                        <div class="search-field">
                            <input type="text" name="q" class="search-input" id="global-search-input" placeholder="Je cherche un produit, une marque..." value="{{ request('q') }}" autocomplete="off">
                            <button type="submit" class="search-button">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <div id="autocomplete-results"></div>
                </div>

                <div class="header-actions">
                    <a href="#" class="club-r">Club R</a>
                    
                    <div class="sell-button-container">
                        <button type="button" class="sell-button" onclick="toggleSellDropdown()">
                            <span>Mettre en vente</span>
                            <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="sell-dropdown" id="layoutSellDropdown">
                            <a href="{{ route('annonces.create') }}" class="sell-dropdown-item">
                                <div class="sell-dropdown-item-title">Vendre un produit</div>
                                <div class="sell-dropdown-item-subtitle">Déposez une annonce gratuitement</div>
                            </a>
                        </div>
                    </div>
                    
                    @auth
                        @if(auth()->user()->hasRole('Administrateur'))
                            <a href="{{ route('admin.dashboard') }}" class="header-link" style="color: #bf0000; font-weight: 800; border: 1px solid #bf0000; padding: 4px 10px; border-radius: 6px; background: #fff;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 2px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>Back Office</span>
                            </a>
                        @endif
                        <a href="{{ route('profile.show') }}" class="header-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>{{ auth()->user()->prenom ?? auth()->user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="header-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Connexion</span>
                        </a>
                    @endauth

                    @inject('cartService', 'App\Services\CartService')
                    <a href="{{ route('cart.index') }}" class="header-link" title="Panier">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        @if($cartService->getItemsCount() > 0)
                            <span style="position: absolute; top: -8px; right: -8px; background: #bf0000; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white;">
                                {{ $cartService->getItemsCount() }}
                            </span>
                        @endif
                        <span>Panier</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="header-row-2">
            <div class="header-container">
                <button class="cat-nav-btn" @click="mobileMenuOpen = !mobileMenuOpen" :style="mobileMenuOpen ? 'color: #000' : ''">
                    <template x-if="!mobileMenuOpen">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <span>Toutes les catégories</span>
                        </div>
                    </template>
                    <template x-if="mobileMenuOpen">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span>Fermer</span>
                        </div>
                    </template>
                </button>

                <div class="quick-links">
                    @php 
                        $mainCats = \App\Models\Category::racines()->actives()->parOrdre()->limit(8)->get();
                    @endphp
                    @foreach($mainCats as $cat)
                        <a href="{{ route('categories.show', $cat->slug) }}" class="{{ request()->is('categories/' . $cat->slug . '*') ? 'active' : '' }}">
                            {{ $cat->nom }}
                        </a>
                    @endforeach
                </div>

                @php 
                    $cats = \App\Models\Category::racines()->actives()->parOrdre()->get(); 
                @endphp
                
                <!-- Mega Menu Dropdown -->
                <div class="mobile-menu-drawer" 
                     x-show="mobileMenuOpen"
                     :class="{ 'open': mobileMenuOpen, 'expanded': selectedCategory }" 
                     x-data="{ selectedCategory: null }"
                     @click.away="mobileMenuOpen = false"
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    
                    
                    <!-- Main Content Panel -->
                    <div style="display: flex; height: 600px; overflow: hidden; background: #fff;">
                        <!-- Left Sidebar: All Categories -->
                        <div style="width: 250px; min-width: 250px; background: #fff; border-right: 1px solid #f0f0f0; overflow-y: auto;">
                            @foreach($cats as $cat)
                                <div class="cat-sidebar-item" 
                                     :class="{ 'active-cat-item': selectedCategory === {{ $cat->id }} }"
                                     @mouseenter="selectedCategory = {{ $cat->id }}"
                                     @click="selectedCategory = {{ $cat->id }}">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <span style="font-size: 1rem; width: 20px; text-align: center; color: inherit;">{!! $cat->icone ?? '📁' !!}</span>
                                        <span style="font-size: 0.88rem; font-weight: 400;">{{ $cat->nom }}</span>
                                    </div>
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            @endforeach
                        </div>

                        <!-- Right Pane: Hierarchical Content -->
                        <div x-show="selectedCategory" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             style="flex: 1; overflow-y: auto; padding: 40px; background: #fff; border-left: 1px solid #eee;">
                            @foreach($cats as $cat)
                                <div x-show="selectedCategory === {{ $cat->id }}" 
                                     style="display: flex; gap: 60px;">
                                    
                                    <!-- Hierarchical Groups -->
                                    <div style="flex: 1; display: flex; flex-direction: column; gap: 0;">
                                        @foreach($cat->enfantsActifs()->with('enfantsActifs')->get() as $sousCat)
                                            <div style="display: flex; border-bottom: 1px solid #eee; padding: 20px 0;">
                                                <!-- Level 2 Header -->
                                                <div style="width: 250px; padding-right: 30px;">
                                                    <h3 style="font-size: 0.75rem; font-weight: 800; color: #000; text-transform: uppercase; letter-spacing: 0.5px; margin: 4px 0 0 0; line-height: 1.2;">
                                                        <a href="{{ route('categories.show', $sousCat->slug) }}" style="text-decoration: none; color: inherit;">{{ $sousCat->nom }}</a>
                                                    </h3>
                                                </div>
                                                
                                                <!-- Level 3 Links Grid -->
                                                <div style="flex: 1; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 40px;">
                                                    @foreach($sousCat->enfantsActifs as $enfant)
                                                        <a href="{{ route('categories.show', $enfant->slug) }}" 
                                                           style="text-decoration: none; color: #666; font-size: 0.85rem; transition: color 0.1s; font-weight: 400;"
                                                           onmouseover="this.style.color='#000'; this.style.textDecoration='underline';" onmouseout="this.style.color='#666'; this.style.textDecoration='none';">
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
                    </div>
                    
                </div>
            </div>
        </div>
    </header>




    @if(session('success'))
        <div style="max-width: 1200px; margin: 1rem auto; background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px;">{{ session('success') }}</div>
    @endif

    @yield('content')

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <h4>A propos de Mady Market</h4>
                <ul>
                    <li><a href="#">Qui sommes-nous ?</a></li>
                    <li><a href="#">Comment ça marche ?</a></li>
                    <li><a href="#">Nos engagements</a></li>
                    <li><a href="#">Espace Presse</a></li>
                    <li><a href="#">Recrutement</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Aide et contact</h4>
                <ul>
                    <li><a href="#">Centre d'aide</a></li>
                    <li><a href="#">Contactez-nous</a></li>
                    <li><a href="#">Garantie Confiance</a></li>
                    <li><a href="#">Signaler un abus</a></li>
                    <li><a href="#">Remboursements</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Vendre sur Mady Market</h4>
                <ul>
                    <li><a href="{{ route('annonces.create') }}">Déposer une annonce</a></li>
                    <li><a href="#">Tarifs et options</a></li>
                    <li><a href="#">Conseils aux vendeurs</a></li>
                    <li><a href="#">Vendeurs professionnels</a></li>
                    <li><a href="#">Publicité</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Suivez-nous</h4>
                <div class="social-icons">
                    <a href="#">F</a>
                    <a href="#">X</a>
                    <a href="#">I</a>
                    <a href="#">L</a>
                </div>
                <div style="margin-top: 2rem;">
                    <h4 style="font-size: 0.9rem; margin-bottom: 1rem;">Paiements sécurisés</h4>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <span style="background: #444; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem;">VISA</span>
                        <span style="background: #444; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem;">Mastercard</span>
                        <span style="background: #444; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem;">PayPal</span>
                        <span style="background: #444; padding: 4px 8px; border-radius: 4px; font-size: 0.7rem;">Orange Money</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Mady Market. Tous droits réservés.</p>
            <div style="margin-top: 1rem; display: flex; justify-content: center; gap: 1.5rem;">
                <a href="#" style="color: #666; text-decoration: none;">CGU</a>
                <a href="#" style="color: #666; text-decoration: none;">Vie privée</a>
                <a href="#" style="color: #666; text-decoration: none;">Cookies</a>
                <a href="#" style="color: #666; text-decoration: none;">Mentions légales</a>
            </div>
        </div>
    </footer>

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
                if (dropdown) dropdown.classList.remove('show');
                if (button) button.classList.remove('active');
            }
        });

        // Autocomplete Logic
        const searchInput = document.getElementById('global-search-input');
        const resultsContainer = document.getElementById('autocomplete-results');
        let timeout = null;

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value;
            if (query.length < 2) {
                resultsContainer.style.display = 'none';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`/api/search/autocomplete?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            resultsContainer.innerHTML = data.map(item => `
                                <a href="${item.url}" class="autocomplete-item">
                                    <span class="type-badge">${item.type === 'category' ? '📁' : '🛍️'}</span>
                                    <span>${item.label}</span>
                                </a>
                            `).join('');
                            resultsContainer.style.display = 'block';
                        } else {
                            resultsContainer.style.display = 'none';
                        }
                    });
            }, 300);
        });

        document.addEventListener('click', (e) => {
            if (!document.querySelector('.search-container').contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
    </script>
    @stack('scripts')
    <x-toast />
</body>
</html>
