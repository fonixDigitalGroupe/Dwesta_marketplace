<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Karnou Marketplace')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden;
            width: 100%;
        }

        body {
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc; /* Premium Slate-50 */
            color: #1e293b; /* Slate-800 */
            -webkit-font-smoothing: antialiased;
            position: relative;
        }

        [x-cloak] {
            display: none !important;
        }

        /* MINI LAYOUT BACKUP */
        @if(request('layout') == 'mini')
        .header, .footer, .top-banner, .top-banner + .header { display: none !important; visibility: hidden !important; }
        body { padding-top: 0 !important; margin-top: 0 !important; background: #fff !important; }
        @endif

        .top-banner {
            background-color: #004aad;
            height: 40px;
            width: 100%;
        }

        /* Global mobile rules for non-header elements */
        @media (max-width: 768px) {
            .shop-container {
                background-color: white;
                max-width: none;
                margin: 0;
            }

            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>

@php
    $corporateRoutes = ['about', 'terms', 'privacy', 'cookies', 'help', 'report', 'contact', 'eshop.landing'];
    $isCorporatePage = Route::is(...$corporateRoutes);
@endphp

<body x-data="{ mobileMenuOpen: false }">
    <!-- Top Notification Bar (for Wishlist etc) -->
    <div x-data="{ 
        showBar: false, 
        message: '', 
        type: 'success' 
    }"
    @notify.window="
        if($event.detail.type === 'success' || !$event.detail.type) {
            message = $event.detail.message;
            showBar = true;
            setTimeout(() => showBar = false, 5000);
        }
    "
    x-show="showBar"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform -translate-y-full"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-full"
    style="background: #108a43; color: white; padding: 12px 1rem; position: fixed; top: 0; left: 0; right: 0; z-index: 99999; display: flex; align-items: center; justify-content: center; font-weight: 500; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-height: 48px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check" style="font-size: 1rem;"></i>
            <span x-text="message" style="font-size: 0.95rem; letter-spacing: 0.3px;"></span>
        </div>
        <button @click="showBar = false" style="position: absolute; right: 1.5rem; background: rgba(255,255,255,0.2); border: none; color: white; cursor: pointer; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
            <i class="fas fa-times" style="font-size: 0.8rem;"></i>
        </button>
    </div>

    @if(!$isCorporatePage)
        <div class="top-banner"></div>
    @endif


    @if(!$isCorporatePage)
        @include('layouts.partials.header')
    @endif


    @yield('content')

    @if(!$isCorporatePage)
        @include('layouts.partials.footer')
    @endif


    <script>
        // Scripts globaux
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

        // Autocomplete Logic
        const searchInput = document.getElementById('global-search-input');
        const resultsContainer = document.getElementById('autocomplete-results');
        let timeout = null;

        if (searchInput && resultsContainer) {
            searchInput.addEventListener('input', function () {
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
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('error'))
                if (!document.querySelector('.alert-error')) {
                    Swal.fire({
                        title: 'Erreur',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#bf0000'
                    });
                }
            @endif
        });
    </script>
    @stack('scripts')
    <x-toast />
</body>

</html>