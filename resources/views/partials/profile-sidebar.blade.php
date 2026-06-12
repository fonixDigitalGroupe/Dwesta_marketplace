@php 
        $user = auth()->user();
    $unreadCount = \App\Models\Message::where('sender_id', '!=', $user->id)
        ->whereNull('read_at')
        ->whereHas('conversation', function ($q) use ($user) {
            $q->where('user1_id', $user->id)->orWhere('user2_id', $user->id);
        })->count();
    $isRejected = $user->vendeur && $user->vendeur->statut_verification === 'rejete';
    $isProWithoutPlan = $user->vendeur && $user->vendeur->estProfessionnel() && $user->vendeur->estVerifie() && !$user->vendeur->aForfaitPayantActif();
    $isInactiveForPro = $isRejected || $isProWithoutPlan;
@endphp
@push('styles')
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 1.5rem;
        }

        body {
            background-color: #ffffff !important;
        }

        .sidebar {
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 4px;
            padding: 0;
            height: fit-content;
            box-shadow: none;
            margin-left: 2rem;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: #333;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.2s;
            border-bottom: 1px solid transparent;
        }

        .sidebar-item:hover {
            background-color: #f7f7f7;
            color: #333;
        }

        .sidebar-item.active,
        .sidebar-item.active span {
            color: #333 !important;
        }

        .sidebar-item.active {
            background-color: #ededed;
            font-weight: 600;
        }

        .sidebar-item.active i {
            color: #333 !important;
            opacity: 1;
        }

        .sidebar-item i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
            color: #333;
            opacity: 0.7;
            text-align: center;
        }

        .sidebar-item.active i {
            opacity: 1;
        }

        .sidebar-header {
            padding: 15px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
            font-weight: 700;
            text-decoration: none;
            font-size: 1.05rem;
        }

        .sidebar-header:hover {
            background: #f7f7f7;
        }

        .sidebar-group-title {
            padding: 15px 16px 5px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #000;
            background: #fff;
        }

        .sidebar-divider {
            height: 1px;
            background: #f0f0f0;
            margin: 5px 0;
        }

        .badge-count {
            background: #f68b1e;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            margin-left: auto;
        }

        .main-content {
            background: #fff;
            padding: 0.75rem 2rem 2rem;
            border: 1px solid #eeeeee;
            border-radius: 4px;
            box-shadow: none;
        }

        .breadcrumb {
            max-width: 1400px;
            margin: 1.5rem auto 0;
            padding: 0 2rem;
            font-size: 0.85rem;
            color: #666;
        }

        .inactive-link {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: #ccc;
            text-decoration: none;
            font-size: 1rem;
            cursor: not-allowed;
        }

        .inactive-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
            color: #ddd;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .breadcrumb,
            .dashboard-container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endpush

<aside class="sidebar">
    <!-- Votre compte -->
    <a href="{{ route('account.index') }}"
        class="sidebar-item {{ request()->routeIs('account.index') ? 'active' : '' }}">
        <i class="fa-regular fa-user"></i>
        <span>Votre compte Karnou</span>
    </a>

    <!-- Mes achats -->
    <a href="{{ route('account.orders') }}"
        class="sidebar-item {{ request()->routeIs('account.orders') ? 'active' : '' }}">
        <i class="fa-solid fa-shopping-bag"></i>
        <span>Mes achats</span>
    </a>

    <!-- Boîte de réception -->
    <a href="{{ route('conversations.index') }}"
        class="sidebar-item {{ request()->routeIs('conversations.*') ? 'active' : '' }}">
        <i class="fa-regular fa-envelope"></i>
        <span>Boîte de réception</span>
        @if($unreadCount > 0)
            <span class="badge-count">{{ $unreadCount }}</span>
        @endif
    </a>

    <!-- Mes avis -->
    <a href="{{ route('account.avis') }}" class="sidebar-item {{ request()->routeIs('account.avis') ? 'active' : '' }}">
        <i class="fa-regular fa-comment-dots"></i>
        <span>Mes avis</span>
    </a>

    <!-- Bons d'achat -->
    <a href="{{ route('gift-cards.index') }}"
        class="sidebar-item {{ request()->routeIs('gift-cards.*') ? 'active' : '' }}">
        <i class="fa-solid fa-ticket"></i>
        <span>Bons d'achat</span>
    </a>

    <!-- Favoris -->
    <a href="{{ route('favorites.index') }}"
        class="sidebar-item {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
        <i class="fa-regular fa-heart"></i>
        <span>Favoris</span>
    </a>

    <!-- Mes crédits -->
    <a href="{{ route('account.credits.index') }}"
        class="sidebar-item {{ request()->routeIs('account.credits.*') ? 'active' : '' }}">
        <i class="fa-solid fa-coins"></i>
        <span>Mes crédits</span>
    </a>



    @if($user->hasRole('admin'))
        <div class="sidebar-divider"></div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item" style="color: #0099ff;">
            <i class="fa-solid fa-gauge-high"></i>
            <span style="font-weight: 700;">Back Office (Admin)</span>
        </a>
    @endif

    <div class="sidebar-divider"></div>

    <!-- Section: Gérez votre Compte -->
    <div class="sidebar-group-title" style="font-weight: 500; font-size: 1rem; color: #333; padding-top: 10px;">Gérez
        votre Compte</div>



    <a href="{{ route('profile.show') }}"
        class="sidebar-item {{ request()->url() == route('profile.show') && !str_contains(request()->fullUrl(), 'preferences') ? 'active' : '' }}"
        style="padding-left: 16px;">
        <span style="font-size: 0.95rem; color: #555;">Localisation & Préférences</span>
    </a>

    <!-- Vendeur Section -->
    <div class="sidebar-divider"></div>

    <div class="sidebar-group-title" style="font-weight: 500; font-size: 1rem; color: #333; padding-top: 5px;">Vendre
        sur Karnou</div>

    @if(!$user->vendeur)
        <a href="{{ route('vendeur.create') }}" class="sidebar-item" style="color: #f68b1e;">
            <i class="fa-solid fa-plus-circle"></i>
            <span style="font-weight: 600;">Devenir vendeur</span>
        </a>
    @endif

    @if($user->vendeur)
        <a href="{{ route('vendeur.show') }}" class="sidebar-item {{ request()->routeIs('vendeur.show') ? 'active' : '' }}">
            <i class="fa-regular fa-id-card"></i>
            <span>État du compte</span>
        </a>

        @if(!$isRejected)
            <a href="{{ route('vendeur.mes-annonces') }}"
                class="sidebar-item {{ request()->routeIs('vendeur.mes-annonces') ? 'active' : '' }}">
                <i class="fa-solid fa-list"></i>
                <span>Mes annonces</span>
            </a>
            <a href="{{ route('vendeur.orders') }}"
                class="sidebar-item {{ request()->routeIs('vendeur.orders*') ? 'active' : '' }}">
                <i class="fa-solid fa-box-open"></i>
                <span>Mes ventes</span>
            </a>
        @else
            <div class="inactive-link" title="Compte rejeté">
                <i class="fa-solid fa-list"></i>
                <span>Mes annonces</span>
            </div>
            <div class="inactive-link" title="Compte rejeté">
                <i class="fa-solid fa-box-open"></i>
                <span>Mes ventes</span>
            </div>
        @endif
    @else
        <div class="inactive-link" title="Réservé aux vendeurs">
            <i class="fa-regular fa-id-card"></i>
            <span>État du compte</span>
        </div>

        <div class="inactive-link" title="Réservé aux vendeurs">
            <i class="fa-solid fa-list"></i>
            <span>Mes annonces</span>
        </div>
        <div class="inactive-link" title="Réservé aux vendeurs">
            <i class="fa-solid fa-box-open"></i>
            <span>Mes ventes</span>
        </div>
    @endif

    @if(($user->vendeur && $user->vendeur->aAccesPagePro()) || $user->hasRole('admin'))
        <a href="{{ $user->vendeur ? route('page-pro.edit') : route('vendeur.create') }}"
            class="sidebar-item {{ request()->routeIs('page-pro.edit') ? 'active' : '' }}">
            <i class="fa-solid fa-store"></i>
            <span>Gérer ma Boutique PRO</span>
        </a>
    @else
        <div class="inactive-link" title="Réservé aux vendeurs professionnels">
            <i class="fa-solid fa-store"></i>
            <span>Gérer ma Boutique PRO</span>
        </div>
    @endif

    @if((($user->vendeur && $user->vendeur->estProfessionnel()) || $user->hasRole('admin')) && !$isInactiveForPro)
        <a href="{{ $user->vendeur ? route('vendeur.stats') : route('vendeur.create') }}"
            class="sidebar-item {{ request()->routeIs('vendeur.stats') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>Statistiques de vente</span>
        </a>
    @else
        <div class="inactive-link"
            title="{{ $isRejected ? 'Compte rejeté' : ($isProWithoutPlan ? 'Veuillez souscrire à un forfait Basic ou Expert' : 'Réservé aux vendeurs professionnels') }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>Statistiques de vente</span>
        </div>
    @endif

    @if($user->vendeur)
        @if(!$isInactiveForPro)
            <a href="{{ route('vendeur.wallet.index') }}"
                class="sidebar-item {{ request()->routeIs('vendeur.wallet.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wallet"></i>
                <span>Mon Porte-Monnaie</span>
            </a>
        @else
            <div class="inactive-link"
                title="{{ $isRejected ? 'Compte rejeté' : ($isProWithoutPlan ? 'Veuillez souscrire à un forfait Basic ou Expert' : 'Réservé aux vendeurs') }}">
                <i class="fa-solid fa-wallet"></i>
                <span>Mon Porte-Monnaie</span>
            </div>
        @endif
    @else
        <div class="inactive-link" title="Réservé aux vendeurs">
            <i class="fa-solid fa-wallet"></i>
            <span>Mon Porte-Monnaie</span>
        </div>
    @endif


    @if($user->vendeur)
        @if(($user->estVendeurOfficiel() || $user->hasRole('admin')) && !$isRejected)
            <a href="{{ route('abonnements.index') }}"
                class="sidebar-item {{ request()->routeIs('abonnements.*') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Mes abonnements</span>
            </a>
        @else
            <div class="inactive-link" title="{{ $isRejected ? 'Compte rejeté' : 'Réservé aux vendeurs vérifiés' }}">
                <i class="fa-regular fa-calendar-check"></i>
                <span>Mes abonnements</span>
            </div>
        @endif
    @else
        <div class="inactive-link" title="Réservé aux vendeurs">
            <i class="fa-regular fa-calendar-check"></i>
            <span>Mes abonnements</span>
        </div>
    @endif

    <div class="sidebar-divider"></div>

    <!-- Déconnexion -->
    <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form" style="display: none;">
        @csrf
    </form>
    <a href="#" class="sidebar-item"
        onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();"
        style="color: #c40000; margin-top: 10px;">
        <i class="fa-solid fa-sign-out-alt"></i>
        <span>Déconnexion</span>
    </a>
</aside>