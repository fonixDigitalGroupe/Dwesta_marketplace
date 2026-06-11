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
                    <h3>Qu'est-ce qu'un cookie ?</h3>
                    <p>Un cookie est un petit fichier texte déposé sur votre ordinateur lors de la visite d'un site ou de la consultation d'une publicité. Ils ont notamment pour but de collecter des informations relatives à votre navigation sur les sites et de vous adresser des services personnalisés.</p>
                </section>

                <section>
                    <h3>Pourquoi utilisons-nous des cookies ?</h3>
                    <p>Karnou utilise des cookies pour :</p>
                    <ul>
                        <li>Assurer le bon fonctionnement du site et faciliter votre navigation.</li>
                        <li>Mémoriser vos préférences d'affichage (langue, paramètres de recherche).</li>
                        <li>Réaliser des statistiques de visite pour améliorer l'expérience utilisateur.</li>
                        <li>Sécuriser votre connexion et prévenir les fraudes.</li>
                    </ul>
                </section>

                <section>
                    <h3>Comment gérer les cookies ?</h3>
                    <p>Vous pouvez à tout moment choisir de désactiver ces cookies. Votre navigateur peut également être paramétré pour vous signaler les cookies qui sont déposés dans votre ordinateur et vous demander de les accepter ou non.</p>
                </section>

                <section>
                    <h3>Plus d'informations</h3>
                    <p>Pour en savoir plus sur les cookies et leur gestion, nous vous invitons à consulter le site de la CNIL ou les rubriques d'aide de votre navigateur.</p>
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
    .legal-text ul { padding-left: 1.5rem; margin-bottom: 1rem; }
    .legal-text li { margin-bottom: 0.5rem; }
    
    .header, .top-banner { display: none !important; }
</style>
@endsection
