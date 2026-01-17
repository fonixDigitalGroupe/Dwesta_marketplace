<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Mady Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #333;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Public Header Styles Replication */
        .top-banner {
            background-color: #1e293b;
            height: 40px;
            width: 100%;
        }


        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            position: sticky;
            top: 0;
            z-index: 2000;
        }

        .header-row-1 {
            border-bottom: 1px solid #f0f0f0;
            padding: 0.5rem 0;
        }

        .header-container {
            width: 100%;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            position: relative;
            max-width: 1600px;
            margin: 0 auto;
            min-height: 50px;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            color: #1e293b;
            flex-shrink: 0;
        }

        .search-container {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 400px;
            display: flex;
            align-items: center;
        }

        .search-field {
            flex: 1;
            display: flex;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            font-size: 1rem;
            outline: none;
        }

        .search-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 0 1.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-button:hover {
            background-color: #000;
        }

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
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
        }

        .header-link:hover {
            color: #000;
        }

        .header-link svg {
            width: 20px;
            height: 20px;
        }

        /* Admin Layout Structure */
        .admin-main {
            display: flex;
            max-width: 1600px;
            /* Largeur max augmentée pour le confort admin */
            margin: 2rem auto;
            margin-left: 3rem;
            padding: 0 1.5rem;
            gap: 2rem;
        }

        /* Sidebar Style Rakuten */
        .sidebar {
            width: 240px;
            flex-shrink: 0;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 0;
            padding: 0;
            height: fit-content;
        }

        .sidebar-user {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid #e5e5e5;
        }

        .sidebar-user h2 {
            font-size: 1rem;
            color: #333;
            font-weight: 600;
        }

        .sidebar-section {
            border-bottom: 1px solid #f0f0f0;
            padding: 0.75rem 0;
        }

        .sidebar-section:last-child {
            border-bottom: none;
        }

        .sidebar-title {
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-title svg {
            width: 18px;
            height: 18px;
            color: #666;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 0.35rem 1rem 0.35rem 2.75rem;
            color: #666;
            text-decoration: none;
            font-size: 0.8rem;
            transition: color 0.15s;
        }

        .sidebar-menu li a:hover {
            color: #000;
        }

        .sidebar-menu li a.active {
            color: #000;
            font-weight: 600;
            background-color: #f8fafc;
        }

        /* Main Viewport */
        .viewport {
            flex: 1;
            min-width: 0;
            background: transparent;
        }

        /* Breadcrumb */
        .breadcrumb {
            max-width: 1600px;
            margin: 1rem auto;
            margin-left: 3rem;
            padding: 0 1.5rem;
            font-size: 0.85rem;
            color: #666;
        }

        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* User Dropdown */
        .user-dropdown-container {
            position: relative;
        }

        .user-dropdown-trigger {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .user-dropdown-trigger:hover {
            background-color: #f6f6f6;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
            display: none;
            z-index: 3000;
            overflow: hidden;
        }

        .user-dropdown-menu.show {
            display: block;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .user-dropdown-item:hover {
            background-color: #f9f9f9;
            color: #bf0000;
        }

        .user-dropdown-divider {
            height: 1px;
            background-color: #f0f0f0;
            margin: 0.25rem 0;
        }

        /* Global UI Utilities */
        .card-pro {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 2rem;
        }

        .btn-pro-primary {
            background: var(--mady-red);
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-pro-primary:hover {
            background: var(--mady-red-hover);
            color: white;
        }

        @media (max-width: 1100px) {
            .admin-main {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="h-full">

    <div class="top-banner"></div>



    <header class="header">
        <div class="header-row-1">
            <div class="header-container">
                <a href="{{ route('home') }}" class="logo" title="Retour à l'accueil">
                </a>

                <div class="search-container">
                    <form action="#" method="GET" style="width: 100%;">
                        <div class="search-field">
                            <input type="text" class="search-input" placeholder="Rechercher dans l'administration..."
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
                            <a href="{{ route('dashboard') }}" class="user-dropdown-item">
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
        <a href="{{ route('home') }}">Accueil</a> > <span>Administration</span>
        @yield('breadcrumbs')
    </div>

    <div class="admin-main">
        <aside class="sidebar">
            <div class="sidebar-user">
                <h2>{{ auth()->user()->prenom ?? auth()->user()->name }}</h2>
            </div>






            <!-- Finance -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <!-- Icone Finance type "Mes finances" (Carte/Portefeuille - Bleu foncé) -->
                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                        <path
                            d="M21 7H3C1.89543 7 1 7.89543 1 9V19C1 20.1046 1.89543 21 3 21H21C22.1046 21 23 20.1046 23 19V9C23 7.89543 22.1046 7 21 7Z"
                            fill="#2c3e50" />
                        <path d="M1 11H23V15H1V11Z" fill="#34495e" />
                        <circle cx="18" cy="18" r="1.5" fill="#e74c3c" />
                    </svg>
                    Finance
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Portefeuilles & Crédits</a></li>
                    <li><a href="#">Abonnements & Packs</a></li>
                </ul>
            </div>

            <!-- Logistique -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <!-- Icone Logistique type "Mes ventes/Colis" (Carton/Box - Marron/Orange) -->
                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                        <path
                            d="M20 7.5L12 3L4 7.5M20 7.5V16.5L12 21M20 7.5L12 12M4 7.5L12 12M4 7.5V16.5L12 21M12 21V12"
                            stroke="#d35400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8 10L16 14.5" stroke="#d35400" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    Logistique
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Transporteurs</a></li>
                    <li><a href="#">Points Relais</a></li>
                    <li><a href="#">Suivi des Livraisons</a></li>
                </ul>
            </div>

            <!-- Contenu & Marketing -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <!-- Icone Contenu type "Mes annonces" (Magasin/Store - Orange/Rouge) -->
                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                        <path d="M3 9l9-6 9 6v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" fill="#f39c12" />
                        <polyline points="9 22 9 12 15 12 15 22" fill="#e67e22" />
                    </svg>
                    Contenu
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Bannières Publicitaires</a></li>
                </ul>
            </div>

            <!-- Configuration -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <!-- Icone Paramètres type "Mes informations" (Utilisateur - Rouge/Bordeaux) -->
                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" fill="#c0392b" />
                        <circle cx="12" cy="7" r="4" fill="#e74c3c" />
                    </svg>
                    Paramètres
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('admin.categories.l1') }}"
                            class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Catégories &
                            Architecture</a></li>
                    <li><a href="{{ route('admin.users.index') }}"
                            class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Gestion des
                            Utilisateurs</a></li>
                    <li><a href="{{ route('admin.vendeurs.verification.index') }}"
                            class="{{ request()->routeIs('admin.vendeurs.verification.*') ? 'active' : '' }}">Validation
                            Vendeurs</a></li>
                    <li><a href="#">Rôles & Permissions</a></li>
                </ul>
            </div>


        </aside>

        <main class="viewport">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('userMenuTrigger');
            const menu = document.getElementById('userDropdownMenu');

            if (trigger && menu) {
                trigger.addEventListener('click', functio n(e) {
                    e.stopPropagation();
                    menu.classList.toggle('show');
                });

                document.addEventListener('click', functi on(e) {
                    if(!trigger.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove('show');
                }
            });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>