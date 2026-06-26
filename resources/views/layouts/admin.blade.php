<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Karnou</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @stack('styles')
    <style>
        :root {
            --mady-red: #bf0000;
            --mady-red-hover: #a00000;
            --mady-blue: #3b82f6; /* Vibrant Blue Kelasi Style */
            --sidebar-bg: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%); /* Royal Blue Kelasi Gradient */
            --sidebar-text: rgba(255, 255, 255, 0.7);
            --sidebar-text-hover: #ffffff;
            --sidebar-hover: rgba(255, 255, 255, 0.08);
            --sidebar-active: rgba(255, 153, 0, 0.12); /* Vibrant Orange active tint */
            --sidebar-text-active: #ff9900; /* Vibrant Orange active text */
            --sidebar-accent: #ff9900; /* Vibrant Orange accent marker */
            --slate-50: #f8fafc;
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

        /* Sidebar Refined */
        .sidebar {
            width: 220px;
            /* More compact width */
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            flex-shrink: 0;
            z-index: 100;
            box-shadow: 1px 0 0 rgba(255, 255, 255, 0.05);
            border-right: none;
        }

        .sidebar-brand {
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 70px;
            background: var(--sidebar-bg);
            /* Logo area follows sidebar style */
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand img {
            height: 30px;
            width: auto;
            max-width: 85%;
            object-fit: contain;
        }

        .sidebar-separator {
            margin: 0.6rem 1.25rem 0.1rem;
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
        }

        .sidebar-container {
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
            color: var(--sidebar-text-active) !important;
        }

        .sidebar-menu li a.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            top: 0.75rem;
            bottom: 0.75rem;
            width: 3px;
            background-color: var(--sidebar-accent);
            border-radius: 0 4px 4px 0;
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

        .sidebar-submenu {
            margin-top: 4px;
            border-left: 1px solid rgba(255, 255, 255, 0.05);
            margin-left: 1.6rem;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sidebar-submenu a {
            font-size: 0.8rem !important;
            padding: 0.5rem 1rem !important;
            opacity: 0.8;
        }

        .sidebar-submenu a:hover {
            opacity: 1;
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
            height: 70px !important;
            min-height: 70px !important;
            max-height: 70px !important;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 40;
            box-sizing: border-box;
            overflow: visible;
        }

        .header-container {
            width: 100%;
            height: 70px !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1600px;
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

        .sub-header-slot {
            background-color: transparent;
            min-height: 34px;
            display: flex;
            flex-direction: column;
        }

        /* Breadcrumb Refined */
        .breadcrumb {
            padding: 0 1.5rem;
            font-size: 0.8rem;
            color: #6b7280;
            max-width: 1600px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            height: 40px;
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
            padding: 1rem 1.5rem 1.5rem;
            max-width: 1600px;
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
            top: 100%;
            right: 0;
            width: 220px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: none;
            z-index: 1000;
            overflow: hidden;
        }

        /* Ouverture au clic (JS) ET au survol (fallback fiable sans JS) */
        .user-dropdown-menu.show,
        .user-dropdown-container:hover .user-dropdown-menu {
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
            from {
                transform: translateY(10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #374151;
        }

        /* Professional Amazon-style SweetAlert */
        .amazon-swal-popup {
            border-radius: 0 !important;
            padding: 1.5rem !important;
            border: 1px solid #ddd !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
            max-width: 450px !important;
        }

        .amazon-swal-title {
            font-size: 1.15rem !important;
            font-weight: 600 !important;
            color: #111 !important;
            margin-bottom: 0.75rem !important;
            padding: 0 !important;
            text-align: left !important;
        }

        .amazon-swal-text {
            font-size: 0.9rem !important;
            color: #333 !important;
            margin-bottom: 1.5rem !important;
            text-align: left !important;
        }

        .amazon-swal-confirm {
            background: linear-gradient(to bottom, #f7dfa5, #f0c14b) !important;
            border: 1px solid #a88734 !important;
            color: #111 !important;
            padding: 8px 20px !important;
            border-radius: 0 !important;
            font-size: 0.85rem !important;
            height: 31px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .4) inset !important;
        }

        .amazon-swal-confirm:hover {
            background: linear-gradient(to bottom, #f5d78e, #eeb933) !important;
            border-color: #9c7e31 !important;
        }

        .amazon-swal-cancel {
            background: linear-gradient(to bottom, #f7f8fa, #e7e9ec) !important;
            border: 1px solid #adb1b8 !important;
            color: #111 !important;
            padding: 8px 20px !important;
            border-radius: 0 !important;
            font-size: 0.85rem !important;
            height: 31px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .6) inset !important;
            margin-right: 10px !important;
        }

        .amazon-swal-cancel:hover {
            background: linear-gradient(to bottom, #e7eaf0, #d8dade) !important;
            border-color: #a2a6ac !important;
        }

        .swal2-actions {
            justify-content: flex-end !important;
            padding: 0 !important;
            margin-top: 1rem !important;
        }

        .swal2-icon {
            display: none !important;
            /* Hide standard icon for cleaner professional look */
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
                                <div
                                    style="width: 32px; height: 32px; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #4b5563;">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <span
                                    style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ auth()->user()->prenom }}</span>
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

            <!-- Sub-Header (Breadcrumbs or Tabs) -->
            <div class="sub-header-slot">
                @hasSection('sub_header')
                    @yield('sub_header')
                @else
                    @hasSection('breadcrumbs')
                        <div class="breadcrumb">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a> <span
                                style="margin: 0 0.5rem; opacity: 0.4;">/</span>
                            @yield('breadcrumbs')
                        </div>
                    @endif
                @endif
            </div>

            <!-- Content -->
            <main class="viewport">
                @if(session('success'))
                    <div id="success-alert"
                        style="background: #28a745; color: #fff; padding: 12px 20px; border-radius: 4px; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px; font-weight: 500; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: opacity 0.5s ease-out; animation: slideIn 0.3s ease-out;"
                        role="alert">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div id="error-alert"
                        style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.25rem; margin-bottom: 1.5rem; border-radius: 0; position: relative; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); transition: opacity 0.5s ease-out; animation: slideIn 0.3s ease-out;"
                        role="alert">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 0.5rem;">
                            <span style="font-size: 0.875rem; font-weight: 600;">Oups ! Un petit problème :</span>
                        </div>
                        <ul style="list-style: none; margin: 0; padding: 0 0 0 10px; font-size: 0.85rem; line-height: 1.5;">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
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

            // Auto-dismiss success alert
            const alerts = ['success-alert', 'error-alert'];
            alerts.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    setTimeout(() => {
                        el.style.opacity = '0';
                        setTimeout(() => {
                            el.remove();
                        }, 500);
                    }, 5000);
                }
            });
        });

        // Global Professional Delete Confirmation
        window.confirmDelete = function (param) {
            let formId = param;
            // If it's a number or a string that looks like an ID, prepend the prefix
            if (!isNaN(param) && typeof param !== 'object') {
                formId = 'delete-form-' + param;
            }

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'amazon-swal-popup',
                    confirmButton: 'amazon-swal-confirm',
                    cancelButton: 'amazon-swal-cancel',
                    title: 'amazon-swal-title',
                    htmlContainer: 'amazon-swal-text',
                    actions: 'amazon-swal-actions'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    if (form) {
                        form.submit();
                    } else {
                        console.error('Form not found: ' + formId);
                    }
                }
            });
        };
    </script>
    @stack('scripts')
    @include('partials.unread-messages-widget')
</body>

</html>