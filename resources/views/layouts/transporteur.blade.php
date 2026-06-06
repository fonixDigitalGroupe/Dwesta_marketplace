<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Transporteur') - Karnou</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        :root {
            --mady-red: #bf0000;
            --mady-red-hover: #a00000;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        /* SweetAlert Custom Styles */
        .swal2-small-popup { width: 320px !important; padding: 1rem !important; }
        .swal2-small-icon { transform: scale(0.5); margin-top: 0.5rem !important; margin-bottom: -0.5rem !important; }
        .swal2-small-title { font-size: 1.1rem !important; padding-top: 0 !important; }
        .swal2-small-content { font-size: 0.85rem !important; }
        .swal2-small-actions { gap: 8px !important; }
        .swal2-small-confirm, .swal2-small-cancel { padding: 8px 16px !important; font-size: 0.8rem !important; }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Helvetica Neue', Arial, sans-serif; }
        body { background-color: #ffffff; color: #333; line-height: 1.5; -webkit-font-smoothing: antialiased; }

        /* header */
        .top-banner { background-color: #004aad; height: 40px; width: 100%; }
        .header { background-color: #ffffff; border-bottom: 1px solid #e0e0e0; position: sticky; top: 0; z-index: 2000; }
        .header-row-1 { border-bottom: 1px solid #f0f0f0; padding: 0.5rem 0; }
        .header-container { width: 100%; padding: 0 1.5rem; display: flex; align-items: center; position: relative; max-width: 1600px; margin: 0 auto; min-height: 50px; }
        .logo { display: flex; align-items: center; text-decoration: none; font-size: 1.5rem; font-weight: bold; color: #1e293b; flex-shrink: 0; }
        .search-container { width: 100%; max-width: 600px; display: flex; align-items: center; margin-left: 3rem; }
        .search-field { flex: 1; display: flex; align-items: stretch; gap: 0.5rem; }
        .search-input { flex: 1; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 1rem; outline: none; }
        .search-button { background-color: #ff8c00; color: white; border: none; border-radius: 4px; padding: 0 1.25rem; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .search-button:hover { background-color: #e67e00; }
        .header-actions { display: flex; align-items: center; gap: 1.5rem; margin-left: auto; flex-shrink: 0; }
        .header-link { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: #333; font-size: 0.9rem; font-weight: 500; position: relative; }
        .header-link:hover { color: #000; }
        .header-link svg { width: 20px; height: 20px; }

        /* Admin Layout Structure */
        .admin-main { display: flex; max-width: 1600px; margin: 2rem auto; margin-left: 3rem; padding: 0 1.5rem; gap: 2rem; }

        /* Sidebar Style */
        .sidebar { width: 240px; flex-shrink: 0; background: #fff; border: 1px solid #e5e5e5; border-radius: 0; padding: 0; height: fit-content; }
        .sidebar-user { padding: 0.75rem 1rem; border-bottom: 1px solid #e5e5e5; }
        .sidebar-user h2 { font-size: 1rem; color: #333; font-weight: 600; }
        .sidebar-section { border-bottom: 1px solid #f0f0f0; padding: 0.75rem 0; }
        .sidebar-section:last-child { border-bottom: none; }
        .sidebar-title { padding: 0.5rem 1rem; font-weight: 600; font-size: 0.875rem; color: #333; display: flex; align-items: center; gap: 0.5rem; }
        .sidebar-title svg { width: 18px; height: 18px; color: #666; }
        .sidebar-menu { list-style: none; }
        .sidebar-menu li a { display: block; padding: 0.35rem 1rem 0.35rem 2.75rem; color: #666; text-decoration: none; font-size: 0.8rem; transition: color 0.15s; }
        .sidebar-menu li a:hover { color: #000; }
        .sidebar-menu li a.active { color: #000; font-weight: 600; }

        /* Main Viewport */
        .viewport { flex: 1; min-width: 0; background: transparent; }

        /* Breadcrumb */
        .breadcrumb { max-width: 1600px; margin: 1rem auto; margin-left: 3rem; padding: 0 1.5rem; font-size: 0.85rem; color: #666; }
        .breadcrumb a { color: #666; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }

        /* User Dropdown */
        .user-dropdown-container { position: relative; }
        .user-dropdown-trigger { cursor: pointer; display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; border-radius: 4px; transition: background 0.2s; }
        .user-dropdown-trigger:hover { background-color: #f6f6f6; }
        .user-dropdown-menu { position: absolute; top: 100%; right: 0; width: 200px; background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); margin-top: 0.5rem; display: none; z-index: 3000; overflow: hidden; }
        .user-dropdown-menu.show { display: block; }
        .user-dropdown-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; color: #333; text-decoration: none; font-size: 0.9rem; transition: all 0.2s; border: none; background: none; width: 100%; text-align: left; cursor: pointer; }
        .user-dropdown-item:hover { background-color: #f9f9f9; color: #bf0000; }
        .user-dropdown-divider { height: 1px; background-color: #f0f0f0; margin: 0.25rem 0; }

        /* Global UI Utilities */
        .card-pro { background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 2rem; }
        .btn-pro-primary { background: var(--mady-red); color: #fff; padding: 10px 20px; border-radius: 4px; font-weight: 700; font-size: 0.9rem; border: none; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-pro-primary:hover { background: var(--mady-red-hover); color: white; }

        @media (max-width: 1100px) {
            .admin-main { flex-direction: column; }
            .sidebar { width: 100%; }
        }
        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
    <style>
        /* SweetAlert2 Custom popup */
        div:where(.swal2-container) div:where(.swal2-popup) { font-size: 0.85rem !important; border-radius: 8px !important; width: 380px !important; padding: 1rem !important; }
        div:where(.swal2-container) div:where(.swal2-icon) { width: 3.5em !important; height: 3.5em !important; margin: 0.5em auto 0.5em auto !important; }
        div:where(.swal2-container) h2:where(.swal2-title) { padding: 0.2em 0 !important; font-size: 1.1em !important; }
        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm { background-color: #333 !important; }
    </style>
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="h-full">
    <div class="top-banner"></div>

    <header class="header">
        <div class="header-row-1">
            <div class="header-container">
                <a href="{{ route('home') }}" class="logo" title="Retour à l'accueil">
                    <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ $siteSettings['site_name'] ?? 'Logo' }}" style="height: 22px; width: auto;">
                </a>

                <div class="search-container">
                    <form action="#" method="GET" style="width: 100%;">
                        <div class="search-field">
                            <input type="text" class="search-input" placeholder="Rechercher une commande, un colis..."
                                autocomplete="off">
                            <button type="submit" class="search-button">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="header-actions">
                    <a href="{{ route('home') }}" class="header-link" title="Aller sur le site">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span>Site public</span>
                    </a>

                    <div class="user-dropdown-container">
                        <div class="user-dropdown-trigger" id="userMenuTrigger">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span
                                style="font-size: 0.9rem; font-weight: 500; color: #333;">{{ auth()->user()->prenom }}</span>
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="opacity: 0.5;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <a href="{{ route('profile.show') }}" class="user-dropdown-item">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Mon compte
                            </a>
                            <div class="user-dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="user-dropdown-item" style="color: #e03131;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('transporteur.dashboard') }}">Transporteur</a>
        @yield('breadcrumbs')
    </div>

    <div class="admin-main">
        @include('layouts.partials.transporteur-sidebar')

        <main class="viewport">
            @if(session('success'))
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); animation: slideIn 0.3s ease-out;" role="alert">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="background: #dcfce7; border-radius: 50%; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <span style="font-size: 0.875rem; font-weight: 500;">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: #166534; opacity: 0.5; transition: opacity 0.2s; padding: 4px;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.25rem; margin-bottom: 1.5rem; border-radius: 8px; position: relative; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); animation: slideIn 0.3s ease-out;" role="alert">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                        <div style="background: #fee2e2; border-radius: 50%; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <span style="font-size: 0.875rem; font-weight: 600;">Oups ! Un petit problème :</span>
                    </div>
                    <ul style="list-style: none; margin: 0; padding: 0 0 0 36px; font-size: 0.85rem; line-height: 1.5;">
                        @foreach ($errors->all() as $error)
                            <li style="display: flex; align-items: flex-start; gap: 6px;">
                                <span style="color: #ef4444;">•</span> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                    <button onclick="this.parentElement.remove()" style="position: absolute; top: 0.875rem; right: 0.875rem; background: none; border: none; cursor: pointer; color: #991b1b; opacity: 0.5; transition: opacity 0.2s; padding: 4px;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.5'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // User Dropdown
            const trigger = document.getElementById('userMenuTrigger');
            const menu = document.getElementById('userDropdownMenu');

            if (trigger && menu) {
                trigger.addEventListener('click', function(e) { e.stopPropagation(); menu.classList.toggle('show'); });
                document.addEventListener('click', function(e) { if(!trigger.contains(e.target) && !menu.contains(e.target)) { menu.classList.remove('show'); } });
            }

            // Global Delete Confirmation (SweetAlert2)
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Êtes-vous sûr ?', text: "Cette action est irréversible.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#004aad', cancelButtonColor: '#d33', confirmButtonText: 'Oui, supprimer', cancelButtonText: 'Annuler',
                        customClass: { popup: 'swal2-small-popup', icon: 'swal2-small-icon', title: 'swal2-small-title', htmlContainer: 'swal2-small-content', actions: 'swal2-small-actions', confirmButton: 'swal2-small-confirm', cancelButton: 'swal2-small-cancel' }
                    }).then((result) => { if (result.isConfirmed) { form.submit(); } });
                });
            });

            // Suspend/Activate Confirmation
            document.querySelectorAll('.suspend-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const title = this.getAttribute('data-confirm-title') || 'Confirmer l\'action';
                    Swal.fire({
                        title: title, icon: 'warning', showCancelButton: true, confirmButtonColor: '#004aad', cancelButtonColor: '#d33', confirmButtonText: 'Confirmer', cancelButtonText: 'Annuler',
                        customClass: { popup: 'swal2-small-popup', icon: 'swal2-small-icon', title: 'swal2-small-title', htmlContainer: 'swal2-small-content', actions: 'swal2-small-actions', confirmButton: 'swal2-small-confirm', cancelButton: 'swal2-small-cancel' }
                    }).then((result) => { if (result.isConfirmed) { form.submit(); } });
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
