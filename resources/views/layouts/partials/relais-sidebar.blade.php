<aside class="sidebar">
    <div class="sidebar-user">
        <h2>{{ auth()->user()->prenom ?? auth()->user()->name }}</h2>
    </div>

    <!-- Dashboard -->
    <div class="sidebar-section">
        <a href="{{ route('relais.dashboard') }}" class="sidebar-title {{ request()->routeIs('relais.dashboard') ? 'active' : '' }}" style="text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" style="width: 18px; height: 18px;">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke="#3498db" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Vue d'ensemble
        </a>
    </div>

    <!-- Outils Logistique -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                <path d="M20 7.5L12 3L4 7.5M20 7.5V16.5L12 21M20 7.5L12 12M4 7.5L12 12M4 7.5V16.5L12 21M12 21V12" stroke="#d35400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8 10L16 14.5" stroke="#d35400" stroke-width="1.5" stroke-linecap="round" />
            </svg>
            Opérations Colis
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('scan.index') }}" class=""><i class="fas fa-qrcode" style="width: 20px; color: #ff750f;"></i> Scanner de Colis</a></li>
            <li><a href="#" class=""><i class="fas fa-truck-loading" style="width: 20px; color: #ff750f;"></i> Arrivages</a></li>
            <li><a href="#" class=""><i class="fas fa-box-open" style="width: 20px; color: #ff750f;"></i> En Stock</a></li>
        </ul>
    </div>

    <!-- Paramètres -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <i class="fas fa-cogs" style="font-size: 1.1rem; color: #666;"></i>
            Paramètres Relais
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class=""><i class="fas fa-store" style="width: 20px;"></i> Mes Informations</a></li>
            <li><a href="#" class=""><i class="fas fa-chart-line" style="width: 20px;"></i> Mes Commissions</a></li>
        </ul>
    </div>
</aside>
