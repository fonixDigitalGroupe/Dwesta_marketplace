@php $user = auth()->user(); @endphp
@push('styles')
    <style>
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto 2rem;
            padding: 0.5rem 2rem 2rem 7rem;
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 2.5rem;
        }

        .sidebar {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 0;
            padding: 1.5rem 0;
            height: fit-content;
        }

        .sidebar-user {
            padding: 0.5rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 0.5rem;
        }

        .sidebar-user h2 {
            font-size: 1.1rem;
            color: #333;
            padding-left: 0.8rem;
            font-weight: 700;
        }

        .sidebar-section {
            margin-bottom: 0.5rem;
        }

        .sidebar-title {
            padding: 0.3rem 0.8rem;
            font-weight: 700;
            font-size: 0.95rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0px;
        }

        .sidebar-title svg,
        .sidebar-title .icon-img {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 1px 0.5rem 1px 3.2rem;
            color: #888;
            text-decoration: none;
            font-size: 0.88rem;
            transition: all 0.2s;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            color: #222;
        }

        .sidebar-menu li a.active {
            font-weight: 700;
        }

        .sidebar-menu li .inactive-link {
            display: block;
            padding: 1px 0.5rem 1px 3.2rem;
            color: #ccc;
            font-size: 0.88rem;
            cursor: not-allowed;
            text-decoration: none;
        }

        .sidebar-divider {
            height: 1px;
            background: #eee;
            margin: 1rem 1.5rem;
        }

        .main-content {
            background: transparent;
            padding-top: 0.5rem;
        }

        .breadcrumb {
            max-width: 1400px;
            margin: 3rem auto 0;
            padding: 0 2rem 0 7rem;
            font-size: 0.85rem;
            color: #666;
        }

        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }
            
            .breadcrumb {
                padding-left: 2rem;
            }
            
            .dashboard-container {
                padding-left: 2rem;
            }
        }
    </style>
@endpush


<aside class="sidebar">
    <div class="sidebar-user">
        <h2>{{ $user->prenom }}</h2>
    </div>

    <!-- Mes achats -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                <path d="M4 9h16v11H4z" fill="#f39c12" />
                <path d="M2 7l4 2h12l4-2-4-3H6z" fill="#ffb74d" />
            </svg>
            Mes achats
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('account.orders') }}" class="{{ request()->routeIs('account.orders') ? 'active' : '' }}">Tous mes achats</a></li>
            <li><a href="{{ route('favorites.index') }}" class="{{ request()->routeIs('favorites.*') ? 'active' : '' }}">Mes favoris</a></li>
            <li><a href="{{ route('gift-cards.index') }}" class="{{ request()->routeIs('gift-cards.*') ? 'active' : '' }}">Cartes cadeaux</a></li>
        </ul>
    </div>

    <!-- Mes avis -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="#fbc02d">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
            </svg>
            Mes avis
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('account.avis') }}" class="{{ request()->routeIs('account.avis') ? 'active' : '' }}">Tous mes avis</a></li>
        </ul>
    </div>

    <div class="sidebar-divider"></div>

    <!-- Mes ventes -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="#757575">
                <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21v-.05c0-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
            </svg>
            Mes ventes
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('vendeur.orders') }}" class="{{ request()->routeIs('vendeur.orders') ? 'active' : '' }}">Toutes mes ventes</a></li>
        </ul>
    </div>

    <!-- Mes annonces -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                <path d="M20,4H4V6H20V4M21,14V12L20,7H4L3,12V14H4V20H14V14H18V20H20V14H21M12,18H6V14H12V18Z" fill="#e67e22" />
            </svg>
            Mes annonces
        </div>
        <ul class="sidebar-menu">
            @if($user->vendeur)
                <li><a href="{{ route('vendeur.show') }}" class="{{ request()->routeIs('vendeur.show') ? 'active' : '' }}">État du compte</a></li>
                <li><a href="{{ route('vendeur.mes-annonces') }}" class="{{ request()->routeIs('vendeur.mes-annonces') ? 'active' : '' }}">Toutes mes annonces</a></li>
                @if($user->vendeur->pagePro)
                    <li><a href="{{ route('page-pro.show', $user->vendeur->pagePro->slug) }}" target="_blank">Ma Boutique PRO</a></li>
                @else
                    <li><span class="inactive-link" title="Créez votre boutique PRO pour l'afficher ici">Ma Boutique PRO</span></li>
                @endif
            @else
                <li><span class="inactive-link" title="Devenez vendeur pour gérer vos annonces">État du compte</span></li>
                <li><span class="inactive-link" title="Devenez vendeur pour voir vos annonces">Toutes mes annonces</span></li>
                <li><a href="{{ route('vendeur.create') }}" class="{{ request()->routeIs('vendeur.create') ? 'active' : '' }}" style="color: #bf0000; font-weight: bold;">Devenir Vendeur</a></li>
            @endif
        </ul>
    </div>

    <!-- Communauté -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="#3498db">
                <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z" />
            </svg>
            Communauté
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('conversations.index') }}" class="{{ request()->routeIs('conversations.*') ? 'active' : '' }}">Mes messages</a></li>
            <li><a href="#" class="inactive-link" title="Bientôt disponible">Contacter Aide & support</a></li>
        </ul>
    </div>

    <!-- Mes finances -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                <rect x="2" y="5" width="20" height="14" rx="2" fill="#34495e" />
                <rect x="2" y="8" width="20" height="3" fill="#2c3e50" />
            </svg>
            Mes finances
        </div>
        <ul class="sidebar-menu">
            @if($user->vendeur)
                <li><a href="{{ route('vendeur.wallet.index') }}" class="{{ request()->routeIs('vendeur.wallet.index') ? 'active' : '' }}">Mon Porte-Monnaie</a></li>
                <li>
                    <a href="{{ route('vendeur.wallet.index', ['withdraw' => 1]) }}" 
                       @if(request()->routeIs('vendeur.wallet.index')) onclick="event.preventDefault(); openWithdrawModal();" @endif>
                       Demander un retrait
                    </a>
                </li>
            @else
                <li><span class="inactive-link" title="Devenez vendeur pour gérer vos finances">Mon Porte-Monnaie</span></li>
            @endif
            <li><a href="#" class="inactive-link" title="Bientôt disponible">Statistiques</a></li>
            <li><a href="#" class="inactive-link" title="Bientôt disponible">Mes paiements</a></li>
        </ul>
    </div>

    <!-- Mes informations -->
    <div class="sidebar-section">
        <div class="sidebar-title">
            <svg viewBox="0 0 24 24" fill="#d32f2f">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            Mes informations
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Mon adresse e-mail</a></li>
            <li><a href="{{ route('profile.show') }}#changement-mot-de-passe">Mon mot de passe</a></li>
            @if($user->vendeur && $user->estVendeurOfficiel())
                <li><a href="{{ route('abonnements.index') }}" class="{{ request()->routeIs('abonnements.*') ? 'active' : '' }}">Mes abonnements</a></li>
            @else
                <li><span class="inactive-link" title="Votre compte doit être vérifié pour accéder aux abonnements.">Mes abonnements</span></li>
            @endif
        </ul>
    </div>

    <div class="sidebar-divider"></div>

    <!-- Déconnexion -->
    <div class="sidebar-section">
        <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form" style="display: none;">
            @csrf
        </form>
        <a href="#" class="sidebar-title"
            onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
            style="text-decoration: none; color: #bf0000; cursor: pointer;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" style="width: 22px; height: 22px;">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Déconnexion
        </a>
    </div>
</aside>
