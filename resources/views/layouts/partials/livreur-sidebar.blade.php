<aside class="sidebar">
    <div class="sidebar-user">
        <h2>{{ auth()->user()->prenom ?? auth()->user()->name }}</h2>
        <div style="font-size: 0.7rem; color: #ff750f; font-weight: 600; text-transform: uppercase; margin-top: 4px;">Pôle Logistique (Livreur)</div>
    </div>

    <!-- Vue d'ensemble -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            Vue d'ensemble
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('livreur.dashboard') }}" class="{{ request()->routeIs('livreur.dashboard') ? 'active' : '' }}">Tableau de bord</a></li>
        </ul>
    </div>

    <!-- Mes Livraisons -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="3" width="15" height="13"></rect>
                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                <circle cx="18.5" cy="18.5" r="2.5"></circle>
            </svg>
            Mes Livraisons
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('livreur.orders.available') }}" class="{{ request()->routeIs('livreur.orders.available') ? 'active' : '' }}">Commandes Disponibles</a></li>
            <li><a href="{{ route('livreur.orders.ongoing') }}" class="{{ request()->routeIs('livreur.orders.ongoing') ? 'active' : '' }}">Expéditions en cours</a></li>
            <li><a href="{{ route('livreur.orders.history') }}" class="{{ request()->routeIs('livreur.orders.history') ? 'active' : '' }}">Historique Livré</a></li>
        </ul>
    </div>

    <!-- Finances -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"></path>
            </svg>
            Gains & Portefeuille
        </div>
        <ul class="sidebar-menu">
            <li><a href="#">Mes Commissions</a></li>
            <li><a href="#">Retraits</a></li>
        </ul>
    </div>

    <!-- Compte -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
            </svg>
            Mon Profil
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('profile.show') }}">Paramètres compte</a></li>
            <li><a href="#">Véhicule & Documents</a></li>
        </ul>
    </div>
</aside>

<style>
    .sidebar { width: 240px; flex-shrink: 0; background: #fff; border: 1px solid #e5e5e5; border-radius: 0; padding: 0; height: fit-content; }
    .sidebar-user { padding: 1.25rem 1rem; border-bottom: 1px solid #e5e5e5; }
    .sidebar-user h2 { font-size: 1rem; color: #333; font-weight: 600; }
    .sidebar-section { border-bottom: 1px solid #f0f0f0; padding: 0.75rem 0; }
    .sidebar-section:last-child { border-bottom: none; }
    .sidebar-title { padding: 0.5rem 1rem; font-weight: 600; font-size: 0.875rem; color: #333; display: flex; align-items: center; gap: 0.5rem; }
    .sidebar-title svg { width: 18px; height: 18px; color: #666; }
    .sidebar-menu { list-style: none; }
    .sidebar-menu li a { display: block; padding: 0.35rem 1rem 0.35rem 2.75rem; color: #666; text-decoration: none; font-size: 0.85rem; transition: color 0.15s; }
    .sidebar-menu li a:hover { color: #ff750f; }
    .sidebar-menu li a.active { color: #000; font-weight: 600; border-right: 3px solid #ff750f; background: #fff7ed; }
</style>
