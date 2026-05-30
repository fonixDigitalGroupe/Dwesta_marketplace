<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Karnou Agence') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- intl-tel-input Assets --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/build/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/build/js/intlTelInput.min.js" defer></script>

    @stack('styles')
</head>

    <style>
        :root {
            --sidebar-bg: #002e6b;
            --sidebar-text: rgba(255, 255, 255, 0.70);
            --sidebar-text-hover: #ffffff;
            --sidebar-hover: rgba(255, 255, 255, 0.08);
            --sidebar-active: rgba(255, 255, 255, 0.15);
            --sidebar-accent: #ff8c00;
            --mady-blue: #004aad;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background: #f1f5f9;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Wrapper ─── */
        .agence-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* ─── Sidebar ─── */
        .agence-sidebar {
            width: 220px;
            flex-shrink: 0;
            background-color: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            z-index: 100;
            box-shadow: 1px 0 0 rgba(255, 255, 255, 0.05);
            border-right: none;
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            flex-shrink: 0;
            padding: 0 1rem;
        }

        .sidebar-brand img {
            height: 30px;
            width: auto;
            max-width: 85%;
            object-fit: contain;
        }

        .sidebar-body {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0.65rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 0.85rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .sidebar-menu li a:hover {
            background-color: var(--sidebar-hover);
            color: var(--sidebar-text-hover);
        }

        .sidebar-menu li a.active {
            background-color: var(--sidebar-active);
            color: #fff;
        }

        /* Line separator in sidebar */
        .sidebar-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 0.6rem 1.25rem 0.1rem;
        }

        .sidebar-menu li a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .sidebar-menu li a.active i,
        .sidebar-menu li a:hover i {
            opacity: 1;
            color: var(--sidebar-accent);
        }

        /* Sidebar footer user zone */
        .sidebar-user {
            padding: 0.85rem 1rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .sidebar-user-avatar {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.68rem;
            color: var(--sidebar-accent);
        }

        .sidebar-logout {
            margin-left: auto;
            color: rgba(255,255,255,0.35);
            font-size: 0.85rem;
            cursor: pointer;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
        }

        .sidebar-logout:hover {
            color: #ef4444;
        }

        /* ─── Main Content ─── */
        .agence-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top header bar */
        .agence-header {
            height: 70px;
            min-height: 70px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            flex-shrink: 0;
            gap: 2rem;
        }

        .header-logo-mobile {
            display: none;
        }

        .search-container {
            flex: 1;
            max-width: 500px;
        }

        .search-input {
            width: 100%;
            padding: 0.6rem 1.25rem;
            background-color: #f3f4f6;
            border: 1px solid transparent;
            border-radius: 9999px;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s;
            color: #4b5563;
        }

        .search-input:focus {
            background-color: #fff;
            border-color: var(--mady-blue);
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.1);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-left: auto;
        }

        .header-link {
            color: #4b5563;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .header-link:hover {
            color: #111827;
        }

        .user-header-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .user-header-profile:hover {
            background: #f9fafb;
        }

        .user-header-avatar {
            width: 32px;
            height: 32px;
            background: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4b5563;
            font-size: 0.85rem;
        }

        .user-header-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
        }

        /* ─── Page content ─── */
        .agence-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
        }
        /* Flash messages */
        .flash-success {
            background: #28a745;
            color: #fff;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            font-size: 0.875rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .flash-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        /* User Dropdown */
        .user-dropdown-container {
            position: relative;
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 200px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
            overflow: hidden;
        }

        .user-dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            transition: background 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: #f9fafb;
            color: var(--mady-blue);
        }
    </style>
</head>
<body>
<div class="agence-wrapper">

    {{-- ─── Sidebar ─── --}}
    <aside class="agence-sidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Karnou Logo">
            </a>
        </div>

        {{-- Nav --}}
        <div class="sidebar-body">
            
            {{-- Groupe 1 : Principal --}}
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-divider"></div>

            {{-- Groupe 2 : Opérations --}}
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('operations.stock') }}" class="{{ request()->routeIs('operations.stock') ? 'active' : '' }}">
                        <i class="fas fa-warehouse"></i>
                        <span>Stock</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('operations.litiges') }}" class="{{ request()->routeIs('operations.litiges') ? 'active' : '' }}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Litiges</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-divider"></div>

            {{-- Groupe 3 : Finances --}}
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('finances.paiements') }}" class="{{ request()->routeIs('finances.paiements') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Paiements</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-divider"></div>

            {{-- Groupe 4 : Analyse --}}
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('operations.stats') }}" class="{{ request()->routeIs('operations.stats') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Statistiques</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-divider"></div>

            {{-- Groupe 5 : Configuration --}}
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- User zone removed/moved to header if wanted, but keeping for now as redundancy or refined --}}
        {{-- ... --}}
    </aside>

    {{-- ─── Main ─── --}}
    <div class="agence-main">

        {{-- Header --}}
        <header class="agence-header">
            {{-- Search Bar --}}
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Rechercher...">
            </div>

            {{-- Actions --}}
            <div class="header-actions">
                <a href="/" class="header-link" title="Aller sur le site">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Site public</span>
                </a>

                {{-- User Profile similar to admin --}}
                <div class="user-dropdown-container">
                    <div class="user-header-profile" id="userMenuTrigger">
                        <div class="user-header-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="user-header-name">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down" style="font-size: 0.7rem; opacity: 0.4; margin-left: 5px;"></i>
                    </div>

                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user-circle"></i>
                            Mon profil
                        </a>
                        <div style="height: 1px; background: #f3f4f6;"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: #ef4444;">
                                <i class="fas fa-sign-out-alt"></i>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="agence-content">
            @if(isset($header_tabs))
                <div class="sub-header-tabs" style="margin-bottom: 20px;">
                    {{ $header_tabs }}
                </div>
            @endif
            @if(session('success'))
                <div class="flash-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="flash-error">
                    @foreach($errors->all() as $error)
                        <div>- {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const trigger = document.getElementById('userMenuTrigger');
        const menu = document.getElementById('userDropdownMenu');

        if (trigger && menu) {
            trigger.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.classList.toggle('show');
            });

            document.addEventListener('click', function (e) {
                if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove('show');
                }
            });
        }
    });
</script>

    @stack('scripts')
</body>
</html>
