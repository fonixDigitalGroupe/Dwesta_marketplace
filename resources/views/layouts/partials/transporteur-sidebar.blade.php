<aside class="sidebar">
    <div class="sidebar-user">
        <h2>{{ auth()->user()->prenom ?? auth()->user()->name }}</h2>
        <div style="font-size: 0.7rem; color: #ff750f; font-weight: 600; text-transform: uppercase; margin-top: 4px;">Pôle Logistique (Transporteur)</div>
    </div>

    <!-- Dashboard -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" fill="#ff750f" />
            </svg>
            Vue d'ensemble
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('transporteur.dashboard') }}" class="{{ request()->routeIs('transporteur.dashboard') ? 'active' : '' }}">Tableau de bord</a></li>
        </ul>
    </div>

    <!-- Mes Missions -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" stroke="#ff750f" stroke-width="2" />
                <path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 011 1v1m2 1h2a1 1 0 001-1v-4a1 1 0 00-1-1h-2m-7 0H5" stroke="#ff750f" stroke-width="2" />
            </svg>
            Mes Missions
        </div>
        <ul class="sidebar-menu">
            <li><a href="#">Colis Disponibles</a></li>
            <li><a href="#">Livraisons en Cours</a></li>
            <li><a href="#">Historique des Courses</a></li>
        </ul>
    </div>

    <!-- Finances -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" fill="#ff750f" />
                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z" fill="#ff750f" />
            </svg>
            Portefeuille
        </div>
        <ul class="sidebar-menu">
            <li><a href="#">Mes Commissions</a></li>
            <li><a href="#">Demandes de Virement</a></li>
        </ul>
    </div>

    <!-- Mon Véhicule -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M3 13h18M5 17h14m-9-8l2 2 4-4" stroke="#ff750f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Paramètres
        </div>
        <ul class="sidebar-menu">
            <li><a href="#">Mes Informations</a></li>
            <li><a href="#">Mon Véhicule</a></li>
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
