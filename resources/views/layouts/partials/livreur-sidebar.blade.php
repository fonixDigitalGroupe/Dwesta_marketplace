<aside class="sidebar">
    <div class="sidebar-user">
        <h2>{{ auth()->user()->prenom ?? auth()->user()->name }}</h2>
        <div style="font-size: 0.7rem; color: #ff750f; font-weight: 600; text-transform: uppercase; margin-top: 4px;">Pôle Logistique (Livreur)</div>
    </div>

    <!-- Dashboard -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="3" width="15" height="13"></rect>
                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                <circle cx="18.5" cy="18.5" r="2.5"></circle>
            </svg>
            Mes Livraisons
        </div>
        <ul class="sidebar-menu">
            <li><a href="#">Commandes Disponibles</a></li>
            <li><a href="#">En cours de livraison</a></li>
            <li><a href="#">Historique Livré</a></li>
        </ul>
    </div>

    <!-- Finances -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"></path>
            </svg>
            Gains & Paiements
        </div>
        <ul class="sidebar-menu">
            <li><a href="#">Mes Commissions</a></li>
            <li><a href="#">Historique Paiements</a></li>
        </ul>
    </div>

    <!-- Mon Véhicule -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="w-5 h-5" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"></path>
            </svg>
            Paramètres
        </div>
        <ul class="sidebar-menu">
            <li><a href="#">Profil Livreur</a></li>
            <li><a href="#">Documents</a></li>
        </ul>
    </div>
</aside>

<style>
    .sidebar { width: 260px; background: white; border: 1px solid #eee; border-radius: 8px; padding: 1.5rem 1rem; }
    .sidebar-user { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #f5f5f5; }
    .sidebar-user h2 { font-size: 1.1rem; color: #333; font-weight: 700; margin: 0; }
    .sidebar-section { margin-bottom: 1.5rem; }
    .sidebar-title { display: flex; align-items: center; gap: 10px; font-size: 0.85rem; font-weight: 700; color: #666; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .sidebar-menu { list-style: none; padding: 0; margin: 0; }
    .sidebar-menu li { margin-bottom: 5px; }
    .sidebar-menu a { display: block; padding: 0.6rem 0.8rem; font-size: 0.9rem; color: #444; border-radius: 6px; text-decoration: none; transition: all 0.2s; }
    .sidebar-menu a:hover { background: #fff7ed; color: #ff750f; }
    .sidebar-menu a.active { background: #ff750f; color: white; font-weight: 600; }
</style>
