@extends('layouts.app')

@section('title', 'Gestion des Cookies - Karnou')

@section('content')
<div class="legal-page">
    <!-- Corporate Header -->
    <header class="corporate-header">
        <div class="about-container">
            <div class="corp-header-flex">
                <a href="{{ route('home') }}" class="corp-logo">
                    @if($logoUrl = \App\Models\Setting::logoUrl())
                        <img src="{{ $logoUrl }}" alt="Logo" style="height: 26px; width: auto;">
                    @else
                        <span class="corp-brand">Karnou</span>
                    @endif
                </a>
                <nav class="corp-nav">
                    <ul>
                        <li><a href="#">Actualités</a></li>
                        <li class="active"><a href="{{ route('about') }}">À propos</a></li>
                        <li><a href="#">Carrières</a></li>
                        <li><a href="#">Vendeurs pros</a></li>
                        <li><a href="#">Presse</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Sub-Header Navigation -->
    <nav class="about-sub-nav">
        <div class="about-container">
            <ul class="sub-nav-list">
                <li><a href="{{ route('about') }}">À propos de Karnou</a></li>
                <li><a href="{{ route('terms') }}">Conditions générales</a></li>
                <li><a href="{{ route('privacy') }}">Vie privée</a></li>
                <li class="active"><a href="{{ route('cookies') }}">Gestion des cookies</a></li>
            </ul>
        </div>
    </nav>

    <div class="legal-content">
        <div class="legal-container">

            <div class="legal-header">
                <h1>Politique de Gestion des Cookies</h1>
                <p class="last-update">Dernière mise à jour : Juin 2025</p>
            </div>

            <div class="legal-body">
                <p>La présente politique a pour objet de vous informer sur la manière dont Karnou utilise des traceurs (cookies) lors de votre navigation sur la Plateforme. Elle s'applique à l'ensemble des services accessibles depuis notre site internet et notre application mobile.</p>

                <h2>1. Qu'est-ce qu'un cookie ?</h2>
                <p>Un cookie est un petit fichier texte déposé sur le disque dur de votre terminal (ordinateur, smartphone, tablette) lors de votre visite sur notre site. Il permet à la Plateforme de vous reconnaître lors de vos prochaines visites, de mémoriser vos préférences et d'améliorer votre expérience de navigation. Les cookies ne contiennent aucune donnée permettant de vous identifier directement.</p>

                <h2>2. Les cookies que nous utilisons</h2>
                <p>Karnou utilise plusieurs catégories de cookies, classées selon leur finalité :</p>

                <h3 style="font-size:1rem; font-weight:700; color:#1a1a1a; margin: 1.5rem 0 0.5rem; font-family:'Outfit','Inter',sans-serif;">a) Cookies strictement nécessaires</h3>
                <p>Ces cookies sont indispensables au bon fonctionnement de la Plateforme. Sans eux, certains services essentiels, comme le maintien de votre session connectée, la gestion de votre panier ou la sécurisation des formulaires, ne peuvent pas fonctionner. Ils ne nécessitent pas votre consentement.</p>

                <h3 style="font-size:1rem; font-weight:700; color:#1a1a1a; margin: 1.5rem 0 0.5rem; font-family:'Outfit','Inter',sans-serif;">b) Cookies de préférences</h3>
                <p>Ces cookies permettent à notre Plateforme de mémoriser des informations relatives à votre navigation pour vous offrir une expérience personnalisée. Par exemple, votre langue d'affichage préférée, votre devise ou votre région de livraison.</p>

                <h3 style="font-size:1rem; font-weight:700; color:#1a1a1a; margin: 1.5rem 0 0.5rem; font-family:'Outfit','Inter',sans-serif;">c) Cookies analytiques et de statistiques</h3>
                <p>Ces cookies nous permettent de mesurer l'audience de la Plateforme, d'analyser les comportements de navigation (pages les plus visitées, temps de visite, taux de rebond, etc.) et d'améliorer nos services. Les données collectées sont agrégées et anonymisées. Nous utilisons à cet effet des outils d'analyse comme Google Analytics.</p>

                <h3 style="font-size:1rem; font-weight:700; color:#1a1a1a; margin: 1.5rem 0 0.5rem; font-family:'Outfit','Inter',sans-serif;">d) Cookies de ciblage et marketing</h3>
                <p>Ces cookies permettent de vous proposer des publicités adaptées à vos centres d'intérêts, sur notre Plateforme ou sur des sites tiers. Ils nous permettent également de limiter le nombre de fois qu'une même publicité vous est affichée. Ces cookies ne sont activés qu'avec votre consentement explicite.</p>

                <h2>3. Durée de vie des cookies</h2>
                <p>Les cookies déposés sur votre terminal ont une durée de vie variable :</p>
                <ul>
                    <li>Les cookies de session expirent automatiquement à la fermeture de votre navigateur.</li>
                    <li>Les cookies persistants ont une durée de vie maximale de <strong>13 mois</strong>, conformément aux recommandations des autorités de protection des données.</li>
                </ul>
                <p>À l'expiration de cette durée, votre consentement sera à nouveau sollicité lors de votre prochaine visite.</p>

                <h2>4. Comment gérer et paramétrer vos cookies ?</h2>
                <p>Vous pouvez gérer votre consentement aux cookies à tout moment via le bandeau de gestion des cookies accessible depuis notre Plateforme. Vous pouvez également paramétrer directement votre navigateur pour accepter ou refuser les cookies. Voici comment procéder selon votre navigateur :</p>
                <ul>
                    <li><strong>Google Chrome :</strong> Paramètres > Confidentialité et sécurité > Cookies et autres données de site.</li>
                    <li><strong>Mozilla Firefox :</strong> Paramètres > Vie privée et sécurité > Cookies et données de sites.</li>
                    <li><strong>Microsoft Edge :</strong> Paramètres > Cookies et autorisations de site > Gérer et supprimer les cookies.</li>
                    <li><strong>Safari (macOS) :</strong> Préférences > Confidentialité > Cookies et données de sites web.</li>
                    <li><strong>Safari (iOS) :</strong> Réglages > Safari > Confidentialité et sécurité.</li>
                </ul>
                <p><strong>Attention :</strong> la désactivation des cookies strictement nécessaires peut altérer le bon fonctionnement de la Plateforme (connexion, panier, etc.).</p>

                <h2>5. Cookies déposés par des tiers</h2>
                <p>Certains cookies présents sur notre Plateforme sont déposés par des partenaires tiers (réseaux sociaux, outils d'analyse). Karnou n'a aucun contrôle sur ces cookies. Nous vous encourageons à consulter les politiques de confidentialité de ces partenaires si vous souhaitez en savoir plus.</p>

                <h2>6. Mise à jour de la politique</h2>
                <p>La présente politique est susceptible d'être modifiée à tout moment pour s'adapter à l'évolution de nos services ou à la réglementation en vigueur. La version en vigueur est celle disponible en permanence sur cette page.</p>

                <p>Pour toute question concernant notre politique de cookies, vous pouvez nous contacter à l'adresse <strong>privacy@karnou.net</strong> ou consulter notre <a href="{{ route('privacy') }}">Politique de Vie Privée</a>.</p>

            </div>
        </div>
    </div>
</div>

<style>
    .legal-page { background: #fff; padding-bottom: 6rem; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

    /* Header & Nav */
    .corporate-header { background: #fff; padding: 1.2rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; }
    .corp-header-flex { display: flex; justify-content: flex-start; align-items: center; gap: 3rem; }
    .corp-brand { font-size: 1.4rem; font-weight: 700; color: #004aad; letter-spacing: -1px; text-decoration: none; padding: 1rem 0; margin-left: 2rem; }
    .corp-nav ul { display: flex; list-style: none; gap: 1.5rem; margin: 0; padding: 0; }
    .corp-nav ul li a { text-decoration: none; color: #333; font-size: 0.9rem; font-weight: 400; padding: 1rem 0; font-family: 'Inter', sans-serif; }
    .corp-nav ul li.active a { background: #004aad; color: #fff; padding: 1rem 1.4rem; border-radius: 4px; }

    .about-sub-nav { background: #fff; border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 100; padding: 1.2rem 0; box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05); }
    .about-sub-nav .about-container { display: flex; justify-content: center; align-items: center; }
    .sub-nav-list { display: flex; list-style: none; gap: 2.5rem; margin: 0; padding: 0; }
    .sub-nav-list li a { text-decoration: none; color: #333; font-size: 0.9rem; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; font-family: 'Inter', sans-serif; }
    .sub-nav-list li.active a { border-bottom: 2px solid #004aad; font-weight: 600; }

    /* Legal Layout */
    .legal-content { padding: 4rem 0 6rem; }
    .legal-container { max-width: 860px; margin: 0 auto; padding: 0 2rem; }

    .legal-header { margin-bottom: 3rem; padding-bottom: 2rem; border-bottom: 1px solid #eee; }
    .legal-header h1 { font-size: 2rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 0.5rem; letter-spacing: -0.5px; }
    .last-update { font-size: 0.875rem; color: #888; font-family: 'Inter', sans-serif; margin: 0; }

    .legal-body { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #444; line-height: 1.75; }
    .legal-body p { margin-bottom: 1.2rem; }
    .legal-body h2 { font-size: 1.15rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 2.5rem 0 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0; }
    .legal-body ul { padding-left: 1.5rem; margin-bottom: 1.2rem; }
    .legal-body li { margin-bottom: 0.6rem; }
    .legal-body a { color: #004aad; text-decoration: none; }
    .legal-body a:hover { text-decoration: underline; }

    .header, .top-banner { display: none !important; }

    @media (max-width: 768px) {
        .legal-header h1 { font-size: 1.5rem; }
        .legal-body { font-size: 0.9rem; }
    }
</style>
@endsection
