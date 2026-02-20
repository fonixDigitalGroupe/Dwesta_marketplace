@extends('layouts.app')

@section('title', 'Mon compte - Mady Market')

@push('styles')
    <style>
        .dashboard-container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 1rem 2rem;
            gap: 2rem;
        }

        .breadcrumb {
            max-width: 1200px;
            margin: 1rem auto 0;
            padding: 0 1rem;
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

        .breadcrumb span {
            color: #333;
            font-weight: bold;
        }

        .main-content {
            flex: 1;
            background: #fff;
        }

        .account-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .account-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #333;
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
        }

        .security-alert a {
            color: #0099ff;
            text-decoration: underline;
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
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('account.index') }}">Mon Compte</a> > <span>Mon compte</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="account-header">
                <h1>Mon compte</h1>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="#" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Déconnexion
                    </a>
                </form>
            </div>



            <div class="security-alert">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p>
                    Attention votre compte n'est pas correctement sécurisé ! Pour renforcer la sécurité de votre compte, veuillez paramétrer la double authentification <a href="#">ici</a>
                </p>
            </div>

            <div class="survey-section" x-data="{ score: 2 }">
                <h3>Recommanderiez-vous Mady Market à vos proches? <span style="color: #999;">*</span></h3>
                <p class="survey-subtext">0 = Pas du tout probable, 10 = Très probable</p>
                <div class="score-buttons">
                    <template x-for="i in [0,1,2,3,4,5,6,7,8,9,10]">
                        <button type="button" class="score-btn" :class="{ 'active': score === i }" @click="score = i" x-text="i"></button>
                    </template>
                </div>
                <button type="button" class="btn-send">
                    Envoyer
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M5 12h16" />
                    </svg>
                </button>
            </div>



            <div class="dashboard-columns-grid">
                <!-- Column 1 -->
                <div class="column-stack">
                    <div class="karnou-card">
                        <div class="karnou-card-header">
                            <span class="icon orange-icon">🎁</span>
                            <h2>Pas encore acheteur ?</h2>
                        </div>
                        <div class="karnou-card-body">
                            <p>L'achat sur Mady Market c'est :</p>
                            <ul class="karnou-list">
                                <li><b>200 000</b> nouveaux articles mis en vente par jour</li>
                                <li><b>Prix bas toute l'année</b></li>
                                <li>Produits <b>neufs et d'occasion</b></li>
                                <li>Un système d'achat immédiat</li>
                                <li>Le <u>paiement sécurisé</u></li>
                                <li>La <u>garantie de bonne réception</u> des produits commandés</li>
                            </ul>
                            <a href="{{ route('search.index') }}" class="karnou-card-btn">Tous les produits</a>
                            <div class="karnou-card-links">
                                <a href="#">Comment acheter ?</a>
                            </div>
                        </div>
                    </div>

                    <div class="karnou-card">
                        <div class="karnou-card-header">
                            <span class="icon red-icon">📌</span>
                            <h2>Mes favoris</h2>
                        </div>
                        <div class="karnou-card-body">
                            <div class="sub-card-links">

                                <div>
                                    <a href="{{ route('favorites.index') }}" class="sub-card-link-item">Voir ma liste de favoris</a>
                                    <p class="sub-card-text">Pour acheter plus tard les produits qui vous intéressent... <a href="#" style="color: #666;">en savoir plus</a></p>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <!-- Column 2 -->
                <div class="column-stack">
                    <div class="karnou-card">
                        <div class="karnou-card-header">
                            <span class="icon blue-icon">€</span>
                            <h2>Pas encore vendeur ?</h2>
                        </div>
                        <div class="karnou-card-body">
                            <ul class="karnou-list">
                                <li>Mettre en vente, <b><u>c'est simple et rapide</u></b></li>
                                <li>Votre paiement est <b><u>garanti à 100 %</u></b></li>
                                <li>L'expédition de vos produits <b><u>est gratuite</u></b></li>
                                <li>Vendez <b><u>près de chez vous</u></b> les produits volumineux</li>
                                <li>Tout en bénéficiant d'un <b>Service Clients à votre écoute</b></li>
                            </ul>
                            <a href="{{ route('annonces.create') }}" class="karnou-card-btn">Vendre maintenant</a>
                            <div class="karnou-card-links">
                                <a href="#">Comment vendre ?</a>
                                <a href="#">Calcul de mes paiements</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3 -->
                <div class="column-stack">
                    <div class="karnou-card">
                        <div class="karnou-card-header">
                            <span class="icon comm-icon">💬</span>
                            <h2>Communauté</h2>
                        </div>
                        <div class="karnou-card-body">
                            <div class="sub-card-links">
                                <a href="{{ route('conversations.index') }}" class="sub-card-link-item">Mes messages</a>
                                <a href="#" class="sub-card-link-item">Contacter Mady Market</a>
                            </div>
                            

                        </div>
                    </div>

                    <div class="karnou-card">
                        <div class="karnou-card-header">
                            <span class="icon finance-icon">💳</span>
                            <h2>Mes finances</h2>
                        </div>
                        <div class="karnou-card-body">
                            <div class="sub-card-links">
                                <a href="{{ route('vendeur.wallet.index') }}" class="sub-card-link-item">Mon Porte-Monnaie</a>
                                <a href="#" class="sub-card-link-item">Mes paiements</a>
                                <a href="#" class="sub-card-link-item">Mes déclarations</a>
                                <div style="border-top: 1px dotted #ccc; margin: 0.5rem 0; padding-top: 0.5rem;">
                                    <a href="#" class="sub-card-link-item">Besoin d'aide sur votre Porte-Monnaie ?</a>
                                    <a href="#" class="sub-card-link-item">Besoin d'aide sur vos paiements ?</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="karnou-card">
                        <div class="karnou-card-header">
                            <span class="icon user-icon">👤</span>
                            <h2>Mes informations</h2>
                        </div>
                        <div class="karnou-card-body">
                            <div class="sub-card-links">
                                <a href="{{ route('profile.show') }}" class="sub-card-link-item">Mon adresse e-mail</a>
                                <a href="{{ route('profile.show') }}" class="sub-card-link-item">Mon mot de passe</a>
                                <a href="{{ route('profile.show') }}" class="sub-card-link-item">Double authentification</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
