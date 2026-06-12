@extends('layouts.app')

@section('title', 'Mon compte - Karnou')

@push('styles')
    <style>
        /* Styles spécifiques à la page compte */

        .account-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .account-header h1 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        /* Jumia Cards Styles */
        .jumia-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .jumia-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .jumia-card-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .jumia-card-header h2 {
            font-size: 0.85rem;
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
            margin: 0;
        }

        .jumia-card-body {
            padding: 1rem;
            flex: 1;
        }

        .jumia-card-body p {
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
            color: #333;
            line-height: 1.4;
        }

        .jumia-card-body .top-text {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .jumia-card-body .sub-text {
            color: #8e8e93;
            font-size: 0.85rem;
        }

        .jumia-link {
            color: #f68b1e;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-top: 1rem;
            display: inline-block;
        }

        .jumia-link:hover {
            text-decoration: underline;
        }

        .edit-icon {
            color: #004aad;
            font-size: 1.1rem;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .jumia-grid {
                grid-template-columns: 1fr;
            }
            .account-header {
                display: none !important;
            }
        }

        /* Rakuten Mobile Styles */
        .rakuten-mobile-nav {
            display: none;
        }

        @media (max-width: 1024px) {
            .rakuten-mobile-nav {
                display: block;
                margin-top: 1rem;
                padding-bottom: 3rem;
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

            .rakuten-item .icon-box {
                display: flex;
                align-items: center;
                gap: 12px;
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

            .greeting-rakuten {
                font-size: 1.1rem;
                font-weight: 700;
                margin: 1rem 0 1.5rem;
                color: #000;
            }
            
            .jumia-grid {
                display: none !important;
            }
            
            .profile-completion-alert {
                margin-top: 1rem;
            }
        }

        .logout-link {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #333;
            text-decoration: underline;
            font-size: 0.9rem;
        }

        .club-r-section {
            display: flex;
            border-top: 1px solid #eee;
            padding: 2rem 0;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .club-r-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 200px;
        }

        .club-r-logo {
            font-size: 2.5rem;
            font-weight: 800;
        }

        .club-r-logo span {
            color: #bf0000;
        }

        .club-r-center {
            flex: 1;
        }

        .club-r-center h2 {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .club-r-benefits {
            list-style: none;
            margin-bottom: 1rem;
        }

        .club-r-benefits li {
            position: relative;
            padding-left: 1.2rem;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .club-r-benefits li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #bf0000;
            font-weight: bold;
        }

        .club-r-link {
            color: #0099ff;
            text-decoration: none;
            font-weight: 500;
        }

        .club-r-right {
            width: 320px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            position: relative;
        }

        .club-r-right h3 {
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .club-r-right p {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .partner-logos {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .partner-logos img {
            height: 20px;
            opacity: 0.8;
        }

        .arrow-right {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .security-alert {
            background-color: #fff9f0;
            border: 1px solid #ffcc80;
            padding: 0.5rem 1rem;
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }

        .security-alert svg {
            color: #ff9800;
            flex-shrink: 0;
        }

        .security-alert p {
            font-size: 0.9rem;
            color: #333;
            line-height: 1.4;
            margin: 0;
        }
        .security-alert a {
            color: #0099ff;
            text-decoration: underline;
        }

        .profile-completion-alert {
            background-color: #fff9f0;
            border: 1px solid #ffcc80;
            padding: 1rem;
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            color: #333;
        }

        .profile-completion-alert i {
            font-size: 1.5rem;
            color: #f68b1e;
        }

        .profile-completion-alert .alert-content {
            flex: 1;
        }

        .profile-completion-alert h4 {
            margin: 0 0 5px 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .profile-completion-alert p {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .profile-completion-alert .btn-complete {
            background: #f68b1e;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            white-space: nowrap;
            transition: background 0.2s;
        }

        .profile-completion-alert .btn-complete:hover {
            background: #e07b10;
        }

        @media (max-width: 768px) {
            .account-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .profile-completion-alert {
                flex-direction: column;
                text-align: center;
                gap: 12px;
                padding: 1.25rem;
            }

            .profile-completion-alert i {
                font-size: 2rem;
            }

            .profile-completion-alert .btn-complete {
                width: 100%;
                text-align: center;
            }

            .club-r-section {
                flex-direction: column;
                padding: 1.5rem 0;
                gap: 1.5rem;
            }

            .club-r-left, .club-r-right {
                width: 100%;
            }

            .survey-section {
                padding: 1.5rem 1rem;
            }

            .score-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }

            .dashboard-columns-grid {
                grid-template-columns: 1fr;
            }
        }

        .survey-section {
            background: #fcfcfc;
            padding: 2rem;
            margin: 0 -1rem;
        }

        .survey-section h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .survey-subtext {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .score-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 2rem;
        }

        .score-btn {
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .score-btn:hover {
            border-color: #0099ff;
        }

        .score-btn.active {
            border-color: #0099ff;
            border-width: 2px;
            color: #0099ff;
            font-weight: bold;
        }

        .btn-send {
            background: #000;
            color: #fff;
            padding: 0.5rem 2.5rem;
            border-radius: 6px;
            border: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .referral-banner {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem 0;
        }

        .referral-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .referral-promo-badge {
            background: #bf0000;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 2px;
            text-transform: uppercase;
        }

        .referral-text {
            font-size: 1rem;
            color: #333;
        }

        .referral-text b {
            color: #bf0000;
        }

        .referral-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .dashboard-columns-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
            align-items: flex-start;
        }

        .column-stack {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .karnou-card {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
        }

        .karnou-card-header {
            background: #f8f8f8;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .karnou-card-header h2 {
            font-size: 1rem;
            font-weight: 800;
            color: #333;
            margin: 0;
        }

        .karnou-card-header svg, .karnou-card-header span.icon {
            font-size: 1.2rem;
        }

        .karnou-card-body {
            padding: 1.25rem;
        }

        .karnou-card-body p {
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .karnou-list {
            list-style: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .karnou-list li {
            position: relative;
            padding-left: 1.5rem;
            font-size: 0.85rem;
            color: #333;
            margin-bottom: 0.6rem;
            line-height: 1.3;
        }

        .karnou-list li::before {
            content: "»";
            position: absolute;
            left: 0;
            color: #0076ad;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .karnou-list li b {
            text-decoration: underline;
        }

        .karnou-card-btn {
            display: block;
            width: 100%;
            background: #000;
            color: #fff;
            text-align: center;
            padding: 0.5rem;
            border-radius: 4px;
            font-weight: 800;
            text-decoration: none;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            border: none;
            cursor: pointer;
        }

        .karnou-card-links {
            border-top: 1px dotted #ccc;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .karnou-card-links a {
            font-size: 0.85rem;
            color: #0076ad;
            text-decoration: underline;
        }

        .sub-card-links {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .sub-card-link-item {
            font-size: 0.9rem;
            color: #0076ad;
            text-decoration: underline;
        }

        .sub-card-text {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.2rem;
            line-height: 1.4;
        }

        .karnou-referral-mini {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: #333;
            margin-top: 1rem;
        }

        .karnou-referral-mini:hover {
            background: #fcfcfc;
        }

        .karnou-referral-mini img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .orange-icon { color: #ff9800; }
        .blue-icon { color: #0076ad; }
        .red-icon { color: #bf0000; }
        .yellow-icon { color: #ffc107; }
        .user-icon { color: #e91e63; }
        .finance-icon { color: #607d8b; }
        .comm-icon { color: #673ab7; }

    </style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="account-header">
                <h1>Votre compte</h1>
            </div>

            @php $u = auth()->user(); @endphp

            <div class="rakuten-mobile-nav">
                <div class="greeting-rakuten">Bonjour {{ $u->prenom }}</div>
                
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
                        <div class="icon-box">
                            <i class="fa-regular fa-comments"></i>
                            <span>Mes messages</span>
                        </div>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                </div>

                {{-- Mes ventes --}}
                <div class="rakuten-group-title">Mes ventes</div>
                <div class="rakuten-card">
                    @if(!$u->vendeur)
                        <a href="{{ route('vendeur.create') }}" class="rakuten-item">
                            <span>Devenir vendeur</span>
                            <i class="fa-solid fa-chevron-right chevron"></i>
                        </a>
                    @else
                        <a href="{{ route('vendeur.create') }}" class="rakuten-item">
                            <span>Mettre en vente</span>
                            <i class="fa-solid fa-chevron-right chevron"></i>
                        </a>
                        <a href="{{ route('vendeur.mes-annonces') }}" class="rakuten-item">
                            <span>Mes annonces</span>
                            <i class="fa-solid fa-chevron-right chevron"></i>
                        </a>
                        <a href="{{ route('vendeur.orders') }}" class="rakuten-item">
                            <span>Mes ventes</span>
                            <i class="fa-solid fa-chevron-right chevron"></i>
                        </a>
                    @endif
                </div>

                {{-- Outils --}}
                <div class="rakuten-group-title">Outils</div>
                <div class="rakuten-card">
                    <a href="{{ route('vendeur.wallet.index') }}" class="rakuten-item">
                        <span>Mon porte-monnaie</span>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                    <a href="{{ route('account.credits.index') }}" class="rakuten-item">
                        <span>Mes crédits</span>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                    <a href="{{ route('abonnements.index') }}" class="rakuten-item">
                        <span>Mes abonnements</span>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                    <a href="{{ route('profile.show') }}" class="rakuten-item">
                        <span>Localisation & Préférences</span>
                        <i class="fa-solid fa-chevron-right chevron"></i>
                    </a>
                </div>

                {{-- Déconnexion --}}
                <div class="rakuten-card" style="margin-top: 2rem; border-color: #ffcdd2;">
                    <a href="#" class="rakuten-item" style="color: #c40000;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="icon-box">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span style="font-weight: 700;">Déconnexion</span>
                        </div>
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>

            {{-- Alerte complétion profil si info manquante --}}
            @if(!$u->adresse || !$u->latitude || !$u->longitude)
                <div class="profile-completion-alert">
                    <i class="fa-solid fa-circle-user"></i>
                    <div class="alert-content">
                        <h4>Complétez votre profil !</h4>
                        <p>Afin de profiter pleinement de Karnou, veuillez renseigner votre adresse et votre position géographique.</p>
                    </div>
                    <a href="{{ route('profile.show') }}#profile-geolocation-section" class="btn-complete">
                        Compléter mon profil
                    </a>
                </div>
            @endif

            <div class="jumia-grid">
                <!-- Informations personnelles -->
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Informations personnelles</h2>
                    </div>
                    <div class="jumia-card-body">
                        <p class="top-text">{{ $u->prenom }} {{ $u->nom }}</p>
                        <p class="sub-text">{{ $u->email }}</p>
                    </div>
                </div>

                <!-- Adresses -->
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Adresses</h2>
                        <a href="{{ route('profile.show') }}" class="edit-icon" style="color: #f68b1e;">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </div>
                    <div class="jumia-card-body">
                        <p class="top-text">Adresse par défaut :</p>
                        @if($u->adresse)
                            <p class="sub-text">{{ $u->prenom }} {{ $u->nom }}</p>
                            <p class="sub-text">{{ $u->adresse }}</p>
                            <p class="sub-text">{{ $u->code_postal }}</p>
                            <p class="sub-text">{{ $u->telephone }}</p>
                        @else
                            <p class="sub-text">Aucune adresse enregistrée.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="jumia-grid" style="grid-template-columns: 1fr;">
                <!-- Localisation & Préférences -->
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Localisation & Préférences</h2>
                    </div>
                    <div class="jumia-card-body">
                        <p class="top-text">Votre localisation actuelle :</p>
                        <p class="sub-text">{{ $u->nationalite ?? 'Non définie' }}</p>
                        <p class="sub-text" id="user-address">{{ $u->adresse ?? 'Aucune adresse enregistrée' }}</p>
                        

                        <div style="margin-top: 1rem;" id="manage-location-link-container">
                            <a href="{{ route('profile.show') }}#profile-geolocation-section" class="jumia-link" style="margin-top: 0;">Gérer ma localisation et mes préférences</a>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection

