<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Dwesta</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
    <style>
        :root {
            --mady-red: #bf0000;
            --mady-red-hover: #a00000;
            --mady-blue: #004aad;
            --sidebar-bg: #002e6b; /* Even darker blue for a more professional look */
            --sidebar-text: rgba(255, 255, 255, 0.85);
            --sidebar-text-hover: #ffffff;
            --sidebar-hover: rgba(255, 255, 255, 0.1);
            --sidebar-active: rgba(255, 255, 255, 0.15);
            --sidebar-text-hover: #ffffff;
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
            box-sizing: border-box;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Layout Structure */
        body {
            background-color: #f9fafb;
            color: #111827;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        .admin-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Sidebar Dark Theme Refined */
        .sidebar {
            width: 260px; /* Adjusted for better balance */
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Control scroll on menu div instead */
            flex-shrink: 0;
            z-index: 100;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }

        .sidebar-brand {
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 60px;
        }

        .sidebar-user {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #1f2937;
        }

        .sidebar-user h2 {
            font-size: 0.95rem;
            color: #fff;
            font-weight: 600;
            margin: 0;
        }

        .sidebar-section {
            padding: 0;
        }

        .sidebar-title {
            padding: 1.25rem 1.75rem 0.5rem 1.75rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-container {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 2rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-menu li a:hover {
            background-color: var(--sidebar-hover);
            color: var(--sidebar-text-hover);
        }

        .sidebar-menu li a.active {
            background-color: var(--sidebar-active);
            color: #fff;
        }

        .sidebar-menu li a.active i {
            color: #ff8c00 !important;
            opacity: 1;
        }

        .sidebar-menu li a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background-color: #f9fafb;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-container {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
        }

        .search-container {
            flex: 1;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            padding: 0.5rem 1rem;
            background-color: #f3f4f6;
            border: 1px solid transparent;
            border-radius: 9999px;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s;
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
        }

        .header-link {
            color: #4b5563;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .header-link:hover {
            color: #111827;
        }

        /* Breadcrumb Refined */
        .breadcrumb {
            padding: 1rem 1.5rem 0.5rem 1.5rem;
            font-size: 0.8rem;
            color: #6b7280;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        .breadcrumb a {
            color: #6b7280;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: var(--mady-blue);
        }

        /* Viewport Padding */
        .viewport {
            padding: 1.5rem;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        /* User Dropdown */
        .user-dropdown-container {
            position: relative;
        }

        .user-dropdown-trigger {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .user-dropdown-trigger:hover {
            background-color: #f3f4f6;
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 220px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: none;
            z-index: 100;
            overflow: hidden;
            animation: slideIn 0.2s ease-out;
        }

        .user-dropdown-menu.show {
            display: block;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .user-dropdown-item:hover {
            background-color: #f9fafb;
            color: var(--mady-blue);
        }

        @keyframes slideIn {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Custom Scrollbar Styles */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Darker scrollbar for sidebar */
        .sidebar::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #374151;
        }
    </style>
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="h-full">

    <div class="admin-wrapper">
        <!-- Sidebar inclusion -->
        @include('layouts.partials.admin-sidebar')

        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-container">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Rechercher...">
                    </div>

                    <div class="header-actions">
                        <a href="{{ route('home') }}" class="header-link" title="Aller sur le site">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Site public</span>
                        </a>

                        <div class="user-dropdown-container">
                            <div class="user-dropdown-trigger" id="userMenuTrigger">
                                <div style="width: 32px; height: 32px; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #4b5563;">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <span style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ auth()->user()->prenom }}</span>
                                <i class="fas fa-chevron-down" style="font-size: 0.75rem; opacity: 0.4;"></i>
                            </div>
                            <div class="user-dropdown-menu" id="userDropdownMenu">
                                <a href="{{ route('profile.show') }}" class="user-dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    Mon compte
                                </a>
                                <div style="height: 1px; background: #f3f4f6;"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="user-dropdown-item" style="color: #ef4444;">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Breadcrumb -->
            @hasSection('breadcrumbs')
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span style="margin: 0 0.5rem; opacity: 0.4;">/</span>
                @yield('breadcrumbs')
            </div>
            @endif

            <!-- Content -->
            <main class="viewport">
                @if(session('success'))
                    <div id="success-alert" style="background: #28a745; color: #fff; padding: 12px 20px; border-radius: 4px; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: opacity 0.5s ease-out; animation: slideIn 0.3s ease-out;" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.25rem; margin-bottom: 1.5rem; border-radius: 12px; position: relative; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); animation: slideIn 0.3s ease-out;" role="alert">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                            <div style="background: #fee2e2; border-radius: 50%; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 0.8rem;"></i>
                            </div>
                            <span style="font-size: 0.875rem; font-weight: 600;">Oups ! Un petit problème :</span>
                        </div>
                        <ul style="list-style: none; margin: 0; padding: 0 0 0 36px; font-size: 0.85rem; line-height: 1.5;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // User Dropdown
            const trigger = document.getElementById('userMenuTrigger');
            const menu = document.getElementById('userDropdownMenu');

            if (trigger && menu) {
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if(!trigger.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.remove('show');
                    }
                });
            }

            // Auto-dismiss success alert
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
    @stack('scripts')
</body>

</html>