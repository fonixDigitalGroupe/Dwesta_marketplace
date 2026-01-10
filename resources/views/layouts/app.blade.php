<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mady Market')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f6f6f6; color: #333; }
        
        .top-banner { background-color: #bf0000; color: white; text-align: center; padding: 0.5rem; font-size: 0.9rem; position: relative; }
        .top-banner .close-btn { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); cursor: pointer; }

        .header { background-color: #ffffff; border-bottom: 1px solid #e0e0e0; padding: 0.75rem 0; sticky; top: 0; z-index: 1000; }
        .header-container { max-width: 1200px; margin: 0 auto; padding: 0 1rem; display: flex; align-items: center; gap: 2rem; }
        
        .logo { display: flex; align-items: center; text-decoration: none; font-size: 1.5rem; font-weight: bold; color: #bf0000; flex-shrink: 0; }
        .logo img { height: 40px; margin-right: 0.5rem; }

        .search-container { flex: 1; display: flex; align-items: center; max-width: 600px; position: relative; }
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

        /* Autocomplétion UI */
        #autocomplete-results { position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e0e0e0; border-radius: 0 0 4px 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 2000; display: none; }
        .autocomplete-item { padding: 0.75rem 1rem; cursor: pointer; border-bottom: 1px solid #f9f9f9; display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: #333; }
        .autocomplete-item:hover { background: #fdf2f2; }
        .autocomplete-item .type-badge { font-size: 0.7rem; padding: 2px 6px; border-radius: 10px; background: #eee; color: #666; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="top-banner">
        Mady Market : Profitez de nos meilleures offres sur tous les produits !
        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
    </div>

    <header class="header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="https://laravel.com/img/logomark.min.svg" alt="Logo">
                Mady Market
            </a>
            
            <div class="search-container">
                <form action="{{ route('search.index') }}" method="GET" style="width: 100%;" id="global-search-form">
                    <div class="search-field">
                        <input type="text" name="q" class="search-input" id="global-search-input" placeholder="Rechercher un produit, une marque..." value="{{ request('q') }}" autocomplete="off">
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
                            <div style="font-weight: 500; font-size: 0.95rem; color: #333; margin-bottom: 0.25rem;">Vendre un produit</div>
                            <div style="font-size: 0.85rem; color: #666;">Déposez une annonce gratuitement</div>
                        </a>
                    </div>
                </div>
                
                @auth
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
                </a>
            </div>
        </div>
    </header>

    @if(session('success'))
        <div style="max-width: 1200px; margin: 1rem auto; background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px;">{{ session('success') }}</div>
    @endif

    @yield('content')

    <script>
        function toggleSellDropdown() {
            const btn = document.querySelector('.sell-button');
            const dropdown = document.getElementById('layoutSellDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            btn.classList.toggle('active');
        }

        document.addEventListener('click', (e) => {
            if (!document.querySelector('.sell-button-container').contains(e.target)) {
                document.getElementById('layoutSellDropdown').style.display = 'none';
                document.querySelector('.sell-button').classList.remove('active');
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
</body>
</html>
