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
        <div class="about-container">
            <div class="section-header center-header">
                <h1 class="qui-title">Gestion des Cookies</h1>
                <div class="qui-line"></div>
            </div>

            <div class="legal-text">
                <section>
                    <h3>1. Qu'est-ce qu'un Cookie ?</h3>
                    <p>Un cookie est un petit fichier texte stocké sur votre appareil lors de la navigation sur Karnou. Il nous permet de reconnaître votre navigateur lors de vos prochaines visites afin d'optimiser votre expérience et d'assurer la sécurité de votre session.</p>
                </section>

                <section>
                    <h3>2. Catégories de Cookies utilisés</h3>
                    <p>Pour assurer le bon fonctionnement de notre écosystème, nous utilisons trois types de cookies :</p>
                    <ul>
                        <li><strong>Cookies Essentiels (Techniques) :</strong> Indispensables à la navigation, ils permettent de rester connecté, de gérer votre panier et de sécuriser les formulaires.</li>
                        <li><strong>Cookies Analytiques :</strong> Ils nous aident à comprendre comment les utilisateurs interagissent avec le site (pages les plus vues, temps passé) pour améliorer nos services.</li>
                        <li><strong>Cookies de Préférence :</strong> Ils mémorisent vos réglages (langue, devise, pays de livraison) pour vous éviter de les ressaisir.</li>
                    </ul>
                </section>

                <section>
                    <h3>3. Finalités de l'usage</h3>
                    <p>Nous utilisons ces technologies pour :</p>
                    <ul>
                        <li>Personnaliser les contenus et les offres que nous vous proposons.</li>
                        <li>Mesurer l'audience et la performance de nos différentes campagnes.</li>
                        <li>Assurer la protection contre les tentatives d'usurpation de compte.</li>
                    </ul>
                </section>

                <section>
                    <h3>4. Contrôle et Paramétrage du Navigateur</h3>
                    <p>Vous pouvez refuser le dépôt de cookies à tout moment via les réglages de votre navigateur. Notez que la désactivation des cookies essentiels peut limiter certaines fonctionnalités (achat, connexion). Voici la marche à suivre selon votre logiciel :</p>
                    <ul>
                        <li><strong>Google Chrome :</strong> Paramètres > Confidentialité et sécurité > Cookies.</li>
                        <li><strong>Mozilla Firefox :</strong> Paramètres > Vie privée et sécurité > Cookies.</li>
                        <li><strong>Safari :</strong> Préférences > Confidentialité.</li>
                        <li><strong>Microsoft Edge :</strong> Paramètres > Cookies et autorisations de site.</li>
                    </ul>
                </section>

                <section>
                    <h3>5. Durée de Vie des Cookies</h3>
                    <p>Les cookies déposés par Karnou ont une durée de vie limitée, ne dépassant généralement pas 13 mois, après quoi nous sollicitons à nouveau votre consentement lors de votre navigation.</p>
                </section>

                <section>
                    <h3>6. Contact et Information Supplémentaire</h3>
                    <p>Pour toute question relative à notre usage des cookies, vous pouvez consulter notre <a href="{{ route('privacy') }}">Politique de Confidentialité</a> ou nous contacter via notre support dédié.</p>
                </section>
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
    .corp-nav ul li a { text-decoration: none; color: #333; font-size: 0.9rem; font-weight: 400; padding: 1rem 0; }
    .corp-nav ul li.active a { background: #004aad; color: #fff; padding: 1rem 1.4rem; border-radius: 4px; }
    
    .about-sub-nav { background: #fff; border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 100; padding: 1.2rem 0; box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05); }
    .about-sub-nav .about-container { display: flex; justify-content: center; align-items: center; }
    .sub-nav-list { display: flex; list-style: none; gap: 2.5rem; margin: 0; padding: 0; }
    .sub-nav-list li a { text-decoration: none; color: #333; font-size: 0.9rem; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; }
    .sub-nav-list li.active a { border-bottom: 2px solid #004aad; }

    /* Legal Content */
    .legal-content { padding: 5rem 0; }
    .section-header { text-align: center; margin-bottom: 4rem; }
    .qui-title { font-size: 2.2rem; font-weight: 300; color: #1a1a1a; margin-bottom: 1rem; font-family: 'Outfit', sans-serif; letter-spacing: -0.5px; }
    .qui-line { width: 60px; height: 3px; background: #004aad; margin: 0 auto; }
    
    .legal-text { max-width: 800px; margin: 0 auto; color: #444; line-height: 1.8; }
    .legal-text section { margin-bottom: 3rem; }
    .legal-text h3 { font-size: 1.4rem; color: #1a1a1a; margin-bottom: 1rem; font-family: 'Outfit', sans-serif; font-weight: 700; }
    .legal-text ul { padding-left: 1.5rem; margin-top: 1rem; }
    .legal-text li { margin-bottom: 0.8rem; }
    
    .header, .top-banner { display: none !important; }
</style>
@endsection
