<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Karnou Pro') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        
        <style>
            :root {
                --primary: #004AAD;
                --orange: #FF6B00;
                --slate: #0F172A;
            }
            body {
                font-family: 'Inter', sans-serif;
                background-color: #F8FAFC;
            }
            .font-outfit { font-family: 'Outfit', sans-serif; }
            .leaflet-control-attribution { display: none !important; }
            .yango-map .leaflet-tile-pane {
                filter: brightness(0.9) contrast(1.1) saturate(0.8);
            }
        </style>
    </head>
    <body class="antialiased text-slate-900 overflow-hidden select-none font-sans">
        
        <div x-data="{ sidebarOpen: false }" class="relative w-full h-[100dvh] max-w-md mx-auto bg-white shadow-2xl flex flex-col overflow-hidden">
            <!-- Page Content -->
            <main class="flex-1 relative w-full overflow-hidden">
                {{ $slot }}
            </main>

            <!-- Sidebar Overlay -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm z-40" 
                 @click="sidebarOpen = false"
                 style="display: none;">
            </div>

            <!-- Professional Sidebar -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="absolute inset-y-0 left-0 w-[85%] bg-white z-50 flex flex-col overflow-hidden shadow-2xl rounded-r-[40px]"
                 style="display: none;">
                
                <!-- Profile Header -->
                <div class="p-8 pb-6 bg-slate-50">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 rounded-2xl bg-primary flex items-center justify-center text-white font-outfit font-black text-2xl shadow-lg shadow-blue-500/20" style="background-color: var(--primary);">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="font-outfit font-black text-xl text-slate-900 leading-none">{{ Auth::user()->prenom ?? Auth::user()->name }}</h2>
                            <p class="text-slate-400 text-xs font-bold mt-2 tracking-widest uppercase">Partenaire Pro</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-6 py-8 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-slate-50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </div>
                        <span class="font-outfit font-extrabold text-lg text-slate-700">Tableau de bord</span>
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-slate-50 transition-all group">
                         <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span class="font-outfit font-extrabold text-lg text-slate-700">Mon Profil</span>
                    </a>

                    <a href="{{ route('missions.earnings') }}" class="flex items-center space-x-4 p-4 rounded-2xl hover:bg-slate-50 transition-all group">
                         <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-outfit font-extrabold text-lg text-slate-700">Mes Revenus</span>
                    </a>
                </nav>

                <!-- Logout -->
                <div class="p-8 bg-slate-50 border-t border-slate-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-3 p-4 bg-white border border-slate-200 rounded-2xl font-outfit font-extrabold text-red-500 hover:bg-red-50 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        @stack('scripts')
    </body>
</html>
