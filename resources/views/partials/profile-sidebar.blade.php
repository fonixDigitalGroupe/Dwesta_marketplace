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
            background-color: #ebebeb !important;
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
            background-color: #d1d1d1;
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
            /* Fond tout blanc sur mobile */
            html,
            body {
                background-color: #fff !important;
            }

            .dashboard-container {
                grid-template-columns: 1fr;
                padding: 1rem 0.5rem;
                gap: 1rem;
                background-color: #fff;
            }

            .sidebar {
                display: block;
                background: transparent;
                border: none;
                padding: 0;
                margin: 0;
            }
            
            .sidebar-standard {
                display: none !important;
            }

            /* Page "Mon compte" : menu en liste (comme l'app) sur mobile, sans cadre */
            .sidebar-standard.acc-index {
                display: block !important;
                background: #fff;
                border: none;
                border-radius: 0;
                overflow: hidden;
            }
            .sidebar-standard.acc-index .sidebar-item {
                padding: 14px 16px;
                border-bottom: 1px solid #f2f2f2;
                font-size: 0.95rem;
            }
            .sidebar-standard.acc-index .inactive-link {
                padding: 14px 16px;
                border-bottom: 1px solid #f2f2f2;
                font-size: 0.95rem;
            }
            /* Chevron à droite sur chaque lien */
            .sidebar-standard.acc-index a.sidebar-item::after {
                content: '\203A';
                margin-left: auto;
                color: #ccc;
                font-size: 1.4rem;
                line-height: 1;
                padding-left: 10px;
            }
            .sidebar-standard.acc-index .sidebar-divider {
                display: none;
            }
            .mobile-account-greeting {
                display: block;
                background: #f68b1e;
                color: #fff;
                padding: 16px;
            }

            .main-content {
                padding: 1rem;
                border-radius: 4px;
                background: #fff;
            }

            .rakuten-mobile-nav {
                display: block !important;
                margin-top: 0;
                padding-bottom: 2rem;
            }
            /* Sur la page d'accueil du compte, on remplace l'ancien menu mobile par la liste */
            .rakuten-mobile-nav.acc-index {
                display: none !important;
            }

            .rakuten-group-title {
                font-size: 0.95rem;
                font-weight: 700;
                margin: 1.5rem 0 0.6rem;
                color: #333;
            }

            .rakuten-card {
                background: #fff;
                border: 1px solid #e0e0e0;
                border-radius: 4px;
                overflow: hidden;
                margin-bottom: 1rem;
            }

            .rakuten-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.1rem 1rem;
                border-bottom: 1px solid #f5f5f5;
                text-decoration: none;
                color: #333;
                font-size: 0.95rem;
            }

            .rakuten-item:last-child {
                border-bottom: none;
            }

            .rakuten-item i {
                font-size: 1.2rem;
                color: #333;
                width: 24px;
                text-align: center;
            }

            .rakuten-item .chevron {
                color: #ccc;
                font-size: 0.8rem;
            }

            /* Barre supérieure mobile (flèche retour + titre de la page) */
            .account-mobile-topbar {
                display: flex;
                align-items: center;
                gap: 14px;
                background: #fff;
                padding: 14px 12px;
                border-bottom: 1px solid #eee;
                margin: -1rem -0.5rem 1rem;
            }
            .account-back-btn {
                color: #333;
                font-size: 1.2rem;
                line-height: 1;
                text-decoration: none;
            }
            .account-topbar-title {
                font-weight: 700;
                font-size: 1.05rem;
                color: #222;
            }
            /* Évite le doublon du titre (déjà affiché dans la barre) */
            .hide-on-mobile-account {
                display: none !important;
            }
        }
        
        .rakuten-mobile-nav {
            display: none;
        }

        /* L'en-tête de bienvenue n'apparaît que sur mobile */
        .mobile-account-greeting {
            display: none;
        }
    </style>
@endpush

<aside class="sidebar">
    <div class="rakuten-mobile-nav {{ request()->routeIs('account.index') ? 'acc-index' : '' }}">
        @if(request()->routeIs('account.index'))
            <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 1.5rem; color: #333;">Votre compte</h1>

            {{-- Informations Personnelles (Top) --}}
            <div class="rakuten-card">
                <div style="padding: 1rem 1rem 0.5rem; border-bottom: 1px solid #f5f5f5;">
                    <h2 style="font-size: 0.8rem; font-weight: 700; color: #666; text-transform: uppercase; margin: 0;">Informations personnelles</h2>
                </div>
                <div style="padding: 1rem;">
                    <div style="font-weight: 700; font-size: 1rem; color: #000; margin-bottom: 0.25rem;">{{ $user->prenom }} {{ $user->nom }}</div>
                    <div style="font-size: 0.9rem; color: #666;">{{ $user->email }}</div>
                </div>
                <a href="{{ route('profile.show') }}" class="rakuten-item" style="border-top: 1px solid #f5f5f5; border-bottom: none; background: #fffaf5;">
                    <span style="color: #f68b1e; font-weight: 700; font-size: 0.85rem;">Gérer mon profil</span>
                    <i class="fa-solid fa-chevron-right chevron" style="color: #f68b1e;"></i>
                </a>
            </div>

            {{-- Adresses --}}
            <div class="rakuten-card">
                <div style="padding: 1rem 1rem 0.5rem; border-bottom: 1px solid #f5f5f5; display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 0.8rem; font-weight: 700; color: #666; text-transform: uppercase; margin: 0;">Adresses</h2>
                    <a href="{{ route('profile.show') }}" style="color: #f68b1e; font-size: 0.9rem;"><i class="fa-solid fa-pen"></i></a>
                </div>
                <div style="padding: 1rem;">
                    <p style="font-weight: 700; font-size: 0.9rem; color: #333; margin-bottom: 0.4rem;">Adresse par défaut :</p>
                    @if($user->adresse)
                        <div style="font-size: 0.9rem; color: #555; line-height: 1.4;">
                            {{ $user->prenom }} {{ $user->nom }}<br>
                            {{ $user->adresse }}<br>
                            {{ $user->ville }} {{ $user->code_postal }}<br>
                            {{ $user->telephone }}
                        </div>
                    @else
                        <div style="font-size: 0.9rem; color: #888;">Aucune adresse enregistrée.</div>
                    @endif
                </div>
            </div>

            {{-- Localisation & Préférences --}}
            <div class="rakuten-card">
                <div style="padding: 1rem 1rem 0.5rem; border-bottom: 1px solid #f5f5f5;">
                    <h2 style="font-size: 0.8rem; font-weight: 700; color: #666; text-transform: uppercase; margin: 0;">Localisation & Préférences</h2>
                </div>
                <div style="padding: 1rem;">
                    <p style="font-weight: 700; font-size: 0.9rem; color: #333; margin-bottom: 0.4rem;">Votre localisation :</p>
                    <div style="font-size: 0.9rem; color: #555; line-height: 1.4;">
                        {{ $user->nationalite ?? 'Non définie' }}<br>
                        {{ $user->adresse ?? 'Aucune adresse enregistrée' }}
                    </div>
                    <a href="{{ route('profile.show') }}#profile-geolocation-section" style="display: block; color: #004aad; font-size: 0.85rem; font-weight: 700; margin-top: 1rem; text-decoration: none;">
                        Gérer ma localisation et mes préférences
                    </a>
                </div>
            </div>

            {{-- Mes achats --}}
            <div class="rakuten-group-title">Mes achats</div>
            <div class="rakuten-card">
                <a href="{{ route('account.orders') }}" class="rakuten-item">
                    <span>Tous mes achats</span>
                    <i class="fa-solid fa-chevron-right chevron"></i>
                </a>
                <a href="{{ route('gift-cards.index') }}" class="rakuten-item">
                    <span>Mes cartes cadeaux</span>
                    <i class="fa-solid fa-chevron-right chevron"></i>
                </a>
                <a href="{{ route('favorites.index') }}" class="rakuten-item">
                    <span>Ma liste de favoris</span>
                    <i class="fa-solid fa-chevron-right chevron"></i>
                </a>
            </div>

            {{-- Communauté --}}
            <div class="rakuten-group-title">Communauté</div>
            <div class="rakuten-card">
                <a href="{{ route('conversations.index') }}" class="rakuten-item">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fa-regular fa-comments"></i>
                        <span>Mes messages</span>
                    </div>
                    <i class="fa-solid fa-chevron-right chevron"></i>
                </a>
                <a href="{{ route('account.avis') }}" class="rakuten-item">
                    <span>Mes avis</span>
                    <i class="fa-solid fa-chevron-right chevron"></i>
                </a>
            </div>

            {{-- Mes ventes --}}
            <div class="rakuten-group-title">Mes ventes</div>
            <div class="rakuten-card">
                @if(!$user->vendeur)
                    <a href="{{ route('vendeur.create') }}" class="rakuten-item">
                        <span style="color: #f68b1e; font-weight: 600;">Devenir vendeur</span>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                @else
                    <a href="{{ route('vendeur.create') }}" class="rakuten-item">
                        <span>Mettre en vente</span>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                    <a href="{{ route('vendeur.mes-annonces') }}" class="rakuten-item" {{ $isRejected ? 'style=color:#ccc;pointer-events:none' : '' }}>
                        <span>Mes annonces</span>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                    <a href="{{ route('vendeur.orders') }}" class="rakuten-item" {{ $isRejected ? 'style=color:#ccc;pointer-events:none' : '' }}>
                        <span>Mes ventes</span>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                @endif
                <a href="{{ route('account.credits.index') }}" class="rakuten-item">
                    <span>Mes crédits</span>
                    <i class="fa-solid fa-chevron-right chevron"></i>
                </a>
            </div>

            {{-- Outils --}}
            <div class="rakuten-group-title">Outils</div>
            <div class="rakuten-card">
                <a href="{{ route('vendeur.wallet.index') }}" class="rakuten-item">
                    <span>Mon porte-monnaie</span>
                    <i class="fa-solid fa-chevron-right chevron"></i>
                </a>
                <a href="{{ route('abonnements.index') }}" class="rakuten-item">
                    <span>Mes abonnements</span>
                    <i class="fa-solid fa-chevron-right chevron"></i>
                </a>
            </div>

            {{-- Déconnexion --}}
            <div class="rakuten-card" style="margin-top: 2rem; border-color: #ffcdd2;">
                <a href="#" class="rakuten-item" style="color: #c40000;" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span style="font-weight: 700;">Déconnexion</span>
                    </div>
                </a>
            </div>
        @else
            {{-- Barre supérieure mobile avec flèche retour (occupe toute la largeur) --}}
            <div class="account-mobile-topbar">
                <a href="{{ route('account.index') }}" class="account-back-btn" aria-label="Retour">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <span class="account-topbar-title" id="accountTopbarTitle">Mon compte</span>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var titleEl = document.getElementById('accountTopbarTitle');
                    if (!titleEl) return;
                    var h1 = document.querySelector('.main-content h1');
                    if (h1 && h1.textContent.trim()) {
                        titleEl.textContent = h1.textContent.trim();
                        h1.classList.add('hide-on-mobile-account');
                    }
                });
            </script>
        @endif
    </div>

    <div class="sidebar-standard {{ request()->routeIs('account.index') ? 'acc-index' : '' }}">
        {{-- En-tête de bienvenue (mobile uniquement) --}}
        <div class="mobile-account-greeting">
            <div style="font-weight: 700; font-size: 1.1rem;">Bonjour, {{ $user->prenom ?? $user->name }}</div>
            <div style="font-size: 0.85rem; opacity: 0.95; word-break: break-all;">{{ $user->email }}</div>
        </div>

        <!-- Votre compte -->
        <a href="{{ route('account.index') }}"
            class="sidebar-item {{ request()->routeIs('account.index') ? 'active' : '' }}">
            <i class="fa-regular fa-user"></i>
            <span>Votre compte Karnou</span>
        </a>
        
        {{-- ... existing sidebar content ... --}}

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

    <a href="{{ route('vendeur.wallet.index') }}"
        class="sidebar-item {{ request()->routeIs('vendeur.wallet.*') ? 'active' : '' }}"
        style="padding-left: 16px;">
        <span style="font-size: 0.95rem; color: #555;">Mon Porte-Monnaie</span>
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

        <!-- Mes crédits -->
    <a href="{{ route('account.credits.index') }}"
        class="sidebar-item {{ request()->routeIs('account.credits.*') ? 'active' : '' }}">
        <i class="fa-solid fa-coins"></i>
        <span>Mes crédits</span>
    </a>
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

    {{-- Mon Porte-Monnaie moved up to general section --}}


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