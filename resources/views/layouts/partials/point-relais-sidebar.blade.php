<aside class="sidebar">
    <div class="sidebar-user">
        <h2>{{ auth()->user()->prenom ?? auth()->user()->name }}</h2>
        <div style="font-size: 0.7rem; color: #6b21a8; font-weight: 600; text-transform: uppercase; margin-top: 4px;">Pôle Point Relais</div>
    </div>

    <!-- Dashboard -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" fill="#6b21a8" />
            </svg>
            Vue d'ensemble
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.prive.point-relais.dashboard') }}" class="{{ request()->routeIs('admin.prive.point-relais.dashboard') ? 'active' : '' }}">Tableau de bord</a></li>
        </ul>
    </div>

    <!-- Gestion des Colis -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M20 7.5L12 3L4 7.5M20 7.5V16.5L12 21M20 7.5L12 12M4 7.5L12 12M4 7.5V16.5L12 21M12 21V12" stroke="#6b21a8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Colis & Commandes
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.prive.point-relais.dashboard') }}#incoming">Arrivages (Prévus)</a></li>
            <li><a href="{{ route('admin.prive.point-relais.dashboard') }}#ready">En Stock (À retirer)</a></li>
            <li><a href="{{ route('admin.prive.point-relais.dashboard') }}#history">Historique des Retraits</a></li>
        </ul>
    </div>

    <!-- Mon Point Relais -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#6b21a8" />
                <circle cx="12" cy="9" r="2.5" fill="white" />
            </svg>
            Mon Point Relais
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.prive.point-relais.dashboard') }}#points">Informations & Horaires</a></li>
        </ul>
    </div>
</aside>
