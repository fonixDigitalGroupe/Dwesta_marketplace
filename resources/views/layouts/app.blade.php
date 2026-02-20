<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dwesta Marketplace')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #ffffff; /* Page background white as requested */
            color: #333;
        }

        [x-cloak] {
            display: none !important;
        }

        .top-banner {
            background-color: #004aad;
            height: 40px;
            width: 100%;
        }
    </style>
    <style>
        /* Modern Header Design */
        .header {
            background-color: #ffffff;
            position: relative;
            z-index: 100;
        }

        .header-row-1 {
            padding: 0.4rem 0;
        }

        .header-row-2 {
            background-color: #fff;
            padding: 0.25rem 0 0.6rem 0;
            border-bottom: 1px solid #e0e0e0;
            margin-top: 0;
            margin-bottom: 0; /* Removed margin for breathing room to align with banner */
        }

        .header-container {
            max-width: 1400px;
            /* Wider container */
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center; /* Vertical alignment */
            gap: 1.5rem;
        }

        .header-row-2 .header-container {
            justify-content: flex-start;
            margin-left: calc((100% - 1400px) / 2);
            /* Align with start of container but allow more left lean if needed */
        }

        @media (min-width: 1600px) {
            .header-row-2 .header-container {
                margin-left: 5%;
                /* Shift further left on very wide screens */
            }
        }

        /* Logo */
        .header-logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            color: #000;
            text-decoration: none;
            flex-shrink: 0;
            letter-spacing: -0.5px;
        }

        .header-logo-text span {
            color: #bf0000;
        }

        /* Search Bar */
        .search-container {
            width: 1000px;
            margin: 0 1rem 0 0;
            display: flex;
            align-items: center;
            position: relative;
        }

        .search-field {
            flex: 1;
            display: flex;
            align-items: stretch;
            gap: 0.5rem;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #eeeeee;
            border-radius: 8px 0 0 8px;
            font-size: 1rem;
            outline: none;
            background-color: #eeeeee;
        }

        .search-button {
            background-color: #ff8c00; /* Dark orange matching logo/banner */
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            padding: 0 1.2rem;
            height: auto;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
            margin-left: -1px;
        }

        .search-button:hover {
            background-color: #e67e00; /* Slightly darker on hover */
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-left: auto;
            flex-shrink: 0;
        }

        .header-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #000;
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
        }

        .header-link:hover {
            color: #000;
        }

        .header-link svg {
            width: 22px;
            height: 22px;
        }

        /* Sell Button */
        .sell-button-container {
            position: relative;
        }

        .sell-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            background: transparent;
            border: none;
            padding: 8px 16px;
            transition: all 0.2s;
        }

        .sell-button:hover {
            color: #000;
        }

        .sell-button .chevron {
            width: 12px;
            height: 12px;
            transition: transform 0.2s;
        }

        .sell-button.active .chevron {
            transform: rotate(180deg);
        }

        .sell-dropdown {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 15px;
            background: white;
            border: 2px solid #ccc;
            border-radius: 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            min-width: 320px;
            z-index: 1000;
            display: none;
        }

        /* Triangular arrow on top of dropdown */
        .sell-dropdown::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid #ccc;
        }

        .sell-dropdown::after {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 9px solid transparent;
            border-right: 9px solid transparent;
            border-bottom: 9px solid white;
        }

        .sell-dropdown.show {
            display: block;
        }

        .sell-dropdown-item {
            display: block;
            padding: 1rem;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
            text-align: left;
        }

        .sell-dropdown-item:last-child {
            border-bottom: none;
        }

        .sell-dropdown-item:hover {
            background-color: #f5f5f5;
        }

        .sell-dropdown-item-title {
            font-weight: 500;
            font-size: 0.95rem;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .sell-dropdown-item-subtitle {
            font-size: 0.85rem;
            color: #999;
        }

        .sell-dropdown-separator {
            height: 1px;
            background: #eee;
            margin: 0.5rem 1rem;
        }

        /* Category Nav Items */
        .cat-nav-item {
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: #333;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .badge-style {
            background: #eeeeee;
            padding: 4px 16px;
            border-radius: 50px;
            font-weight: 700; /* Unified font weight */
            color: #333;
            font-size: 0.9rem; /* Unified font size */
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
        }

        .badge-style:hover {
            background: #e0e0e0;
            transform: scale(1.05);
            color: #333;
        }

        /* Global Rakuten Style Border Radius */
        .rakuten-card {
            border-radius: 15px !important;
            overflow: hidden;
        }

        /* Inactive Buttons Style */
        .disabled-action {
            cursor: default !important;
            opacity: 0.6;
            pointer-events: none;
        }

        .disabled-action:hover {
            color: inherit !important;
            background: inherit !important;
        }

        /* Mobile Adjustments */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            margin-right: 1rem;
        }

        @media (max-width: 1024px) {
            .mobile-menu-btn {
                display: block;
            }

            .search-container {
                display: none;
            }

            .header-container {
                gap: 1rem;
                padding: 0 1rem;
            }
        }
    </style>
    <style>
        #autocomplete-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 0 0 4px 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 2000;
            display: none;
        }

        .autocomplete-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f9f9f9;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #333;
        }

        .autocomplete-item:hover {
            background: #fdf2f2;
        }

        .autocomplete-item .type-badge {
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            background: #eee;
            color: #666;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #333;
        }

        /* Mega Menu Positioning */
        .mobile-menu-drawer {
            position: absolute;
            top: 100%;
            left: 0;
            width: 250px;
            background: white;
            z-index: 2010;
            flex-direction: column;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid #e5e5e5;
            border-top: none;
            max-height: 85vh;
            border-radius: 0 0 4px 4px;
            overflow: hidden;
            transition: width 0.3s ease-in-out;
        }

        .mobile-menu-drawer.expanded {
            width: 1200px;
        }

        .open {
            display: flex !important;
        }

        .active-cat-item {
            background: #000 !important;
            color: #fff !important;
        }

        .active-cat-item svg {
            color: #fff !important;
            opacity: 1 !important;
        }

        .cat-sidebar-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 20px;
            cursor: pointer;
            color: #333;
            transition: all 0.1s;
            border-bottom: 1px solid transparent;
        }

        .cat-sidebar-item:hover:not(.active-cat-item) {
            background: #f8f8f8;
        }

        .cat-sidebar-item svg {
            opacity: 0.4;
            color: #666;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
                margin-right: 1rem;
            }

            .header-container {
                gap: 1rem;
                flex-wrap: wrap;
            }

            .search-container {
                order: 3;
                max-width: none;
                margin-top: 0.5rem;
            }

            .header-actions {
                order: 2;
                margin-left: auto;
                gap: 1rem;
            }

            .header-row-2 {
                display: none;
            }

            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Footer Styles */
        .footer {
            background-color: #ffffff;
            color: #333;
            padding: 3rem 0;
            margin-top: 4rem;
            border-top: 1px solid #eee;
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .footer-bottom p {
            color: #888;
            font-size: 0.85rem;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>

<body x-data="{ mobileMenuOpen: false }">
    <div class="top-banner"></div>


    @include('layouts.partials.header')


    @yield('content')

    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Dwesta. Tous droits réservés.</p>
        </div>
    </footer>

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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    title: "{{ session('success') === 'ok' ? '' : 'Succès !' }}",
                    text: "{{ session('success') }}",
                    icon: "{{ session('success') === 'ok' ? '' : 'success' }}",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#bf0000'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Erreur',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#bf0000'
                });
            @endif
        });
    </script>
    @stack('scripts')
    <x-toast />
</body>

</html>