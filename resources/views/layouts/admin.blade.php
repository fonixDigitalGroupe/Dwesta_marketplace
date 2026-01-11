<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Mady Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --mady-red: #bf0000;
            --mady-red-hover: #a00000;
            --mady-light-red: #fef2f2;
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

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        body { background-color: var(--slate-50); color: var(--slate-800); line-height: 1.5; -webkit-font-smoothing: antialiased; }

        /* Professional Header */
        .admin-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--slate-200);
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--mady-red);
            letter-spacing: -0.02em;
        }

        .nav-crumbs {
            flex: 1;
            margin-left: 2rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            color: var(--slate-500);
            font-weight: 500;
        }

        .nav-crumbs a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-crumbs a:hover { color: var(--slate-900); }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .btn-site {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--slate-600);
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-site:hover { background: var(--slate-100); color: var(--slate-900); }

        .profile-stack {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 1.5rem;
            border-left: 1px solid var(--slate-200);
        }

        .profile-info { text-align: right; }
        .profile-name { font-size: 0.875rem; font-weight: 700; color: var(--slate-900); }
        .profile-role { font-size: 0.75rem; font-weight: 600; color: var(--mady-red); }

        .profile-avatar {
            width: 36px;
            height: 36px;
            background: var(--slate-900);
            color: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        /* Layout Architecture */
        .admin-main {
            display: flex;
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            gap: 2rem;
        }

        /* Sidebar: Clean & Minimalist */
        .sidebar {
            width: 260px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sidebar-nav-group {
            background: #fff;
            border: 1px solid var(--slate-200);
            border-radius: 16px;
            padding: 0.75rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .sidebar-label {
            padding: 0.5rem 0.75rem;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--slate-400);
            margin-bottom: 0.25rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.75rem;
            text-decoration: none;
            color: var(--slate-600);
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .sidebar-link svg { width: 18px; height: 18px; opacity: 0.7; }

        .sidebar-link:hover {
            background: var(--slate-50);
            color: var(--slate-900);
        }

        .sidebar-link.active {
            background: var(--mady-light-red);
            color: var(--mady-red);
        }

        .sidebar-link.active svg { opacity: 1; color: var(--mady-red); }

        /* Main Viewport */
        .viewport { flex: 1; min-width: 0; }

        /* Global UI Utilities */
        .card-pro {
            background: #fff;
            border: 1px solid var(--slate-200);
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .btn-pro-primary {
            background: var(--mady-red);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-pro-primary:hover { background: var(--mady-red-hover); transform: translateY(-1px); }

        @media (max-width: 1100px) {
            .admin-main { flex-direction: column; }
            .sidebar { width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body class="h-full">

    <header class="admin-header">
        <div class="header-content">
            <a href="{{ route('home') }}" class="brand">
                <span class="logo-text">Mady Market</span>
            </a>

            <div class="nav-crumbs">
                <a href="{{ route('admin.dashboard') }}">Administration</a>
                @hasSection('breadcrumbs')
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    @yield('breadcrumbs')
                @endif
            </div>

            <div class="header-actions">
                <div class="profile-stack">
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->prenom }}</div>
                        <div class="profile-role">Super Administrateur</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="admin-main">
        <aside class="sidebar">
            <nav class="sidebar-nav-group">
                <div class="sidebar-label">Global</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
            </nav>

            <nav class="sidebar-nav-group">
                <div class="sidebar-label">Inventaire</div>
                <a href="{{ route('admin.categories.l1') }}" class="sidebar-link {{ request()->routeIs('admin.categories.l1') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    Niveau 1 (Racines)
                </a>
                <a href="{{ route('admin.categories.l2') }}" class="sidebar-link {{ request()->routeIs('admin.categories.l2') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    Niveau 2 (Sous-cats)
                </a>
                <a href="{{ route('admin.categories.l3') }}" class="sidebar-link {{ request()->routeIs('admin.categories.l3') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Niveau 3 (Détails)
                </a>
            </nav>

            <nav class="sidebar-nav-group">
                <div class="sidebar-label">Sécurité</div>
                <a href="{{ route('admin.vendeurs.verification.index') }}" class="sidebar-link {{ request()->routeIs('admin.vendeurs.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Vérification Vendeurs
                </a>
                <a href="{{ route('admin.annonces.moderation.index') }}" class="sidebar-link {{ request()->routeIs('admin.annonces.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Modération
                </a>
            </nav>

            <div style="margin-top: auto; padding-top: 1rem;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link" style="width: 100%; border: none; background: none; cursor: pointer; color: var(--slate-400);">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="viewport">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
