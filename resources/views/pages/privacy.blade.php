@extends('layouts.app')

@section('title', 'Vie Privée - Karnou')

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
                <li class="active"><a href="{{ route('privacy') }}">Vie privée</a></li>
                <li><a href="{{ route('cookies') }}">Gestion des cookies</a></li>
            </ul>
        </div>
    </nav>

    <div class="legal-content">
        <div class="about-container">
            <div class="section-header center-header">
                <h1 class="qui-title">Politique de Confidentialité</h1>
                <div class="qui-line"></div>
            </div>

            <div class="legal-text">
                <section>
                    <h3>1. Collecte des données</h3>
                    <p>Nous collectons les informations que vous nous fournissez directement, notamment lors de la création d'un compte, de la modification de votre profil, ou de la réalisation d'un achat.</p>
                </section>

                <section>
                    <h3>2. Utilisation des données</h3>
                    <p>Les données collectées sont utilisées pour fournir, maintenir et améliorer nos services, pour traiter vos transactions et pour vous envoyer des communications relatives à vos commandes.</p>
                </section>

                <section>
                    <h3>3. Partage des informations</h3>
                    <p>Nous ne partageons pas vos informations personnelles avec des tiers, sauf dans les cas suivants : avec votre consentement, pour des besoins de traitement externe (logistique), ou pour des raisons juridiques.</p>
                </section>

                <section>
                    <h3>4. Sécurité</h3>
                    <p>Nous mettons en œuvre des mesures de sécurité appropriées pour protéger vos données contre tout accès, modification, divulgation ou destruction non autorisé.</p>
                </section>

                <section>
                    <h3>5. Vos droits</h3>
                    <p>Vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles. Vous pouvez exercer ces droits en nous contactant via votre espace client ou par e-mail.</p>
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
    .qui-title { font-size: 2.5rem; font-weight: 300; color: #1a1a1a; margin-bottom: 1rem; font-family: 'Outfit', sans-serif; }
    .qui-line { width: 60px; height: 3px; background: #004aad; margin: 0 auto; }
    
    .legal-text { max-width: 800px; margin: 0 auto; color: #444; line-height: 1.8; }
    .legal-text section { margin-bottom: 3rem; }
    .legal-text h3 { font-size: 1.4rem; color: #1a1a1a; margin-bottom: 1rem; font-family: 'Outfit', sans-serif; }
    
    .header, .top-banner { display: none !important; }
</style>
@endsection
