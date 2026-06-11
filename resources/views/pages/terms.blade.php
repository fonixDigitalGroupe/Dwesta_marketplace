@extends('layouts.app')

@section('title', 'Conditions Générales d\'Utilisation - Karnou')

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
                <li class="active"><a href="{{ route('terms') }}">Conditions générales</a></li>
                <li><a href="{{ route('privacy') }}">Vie privée</a></li>
                <li><a href="{{ route('cookies') }}">Gestion des cookies</a></li>
            </ul>
        </div>
    </nav>

    <div class="legal-content">
        <div class="about-container">
            <div class="section-header center-header">
                <h1 class="qui-title">Conditions Générales d'Utilisation</h1>
                <div class="qui-line"></div>
            </div>

            <div class="legal-text">
                <section>
                    <h3>1. Objet et Champ d'Application</h3>
                    <p>Les présentes Conditions Générales d'Utilisation (CGU) détaillent les règles régissant l'utilisation de la plateforme Karnou. En accédant à nos services, vous acceptez sans réserve l'intégralité de ces conditions. Karnou se réserve le droit de modifier ces termes à tout moment pour les adapter aux évolutions du site et de la législation.</p>
                </section>

                <section>
                    <h3>2. Inscription et Sécurité du Compte</h3>
                    <p>Pour bénéficier de l'intégralité de nos services, l'utilisateur doit créer un compte. Vous vous engagez à fournir des informations exactes et à les maintenir à jour. La confidentialité de vos identifiants de connexion relève de votre entière responsabilité. Toute activité effectuée depuis votre compte est réputée être de votre fait.</p>
                </section>

                <section>
                    <h3>3. Obligations de l'Utilisateur</h3>
                    <p>L'utilisateur s'engage à utiliser le site conformément aux lois en vigueur. Sont strictement interdits :</p>
                    <ul>
                        <li>La publication de contenus illicites, haineux ou diffamatoires.</li>
                        <li>L'usurpation d'identité ou la création de comptes multiples à des fins frauduleuses.</li>
                        <li>L'utilisation de scripts automatisés pour collecter des données sans autorisation préalable.</li>
                    </ul>
                </section>

                <section>
                    <h3>4. Transactions et Paiements</h3>
                    <p>Karnou facilite les transactions entre acheteurs et vendeurs via des solutions de paiement sécurisées. Nous agissons en tant qu'intermédiaire et ne saurions être tenus responsables des litiges directs entre utilisateurs, bien que nous mettions à disposition un service de médiation pour résoudre les différends.</p>
                </section>

                <section>
                    <h3>5. Propriété Intellectuelle</h3>
                    <p>L'ensemble des textes, graphiques, logos et logiciels présents sur Karnou est la propriété exclusive du groupe ou de ses partenaires. Toute reproduction, même partielle, est interdite sans accord écrit préalable.</p>
                </section>

                <section>
                    <h3>6. Limitation de Responsabilité</h3>
                    <p>Bien que nous fassions tout notre possible pour assurer la disponibilité et l'exactitude des informations, Karnou ne garantit pas que le service sera exempt d'interruptions ou d'erreurs. Nous déclinons toute responsabilité en cas de perte de données ou de dommages indirects liés à l'usage de la plateforme.</p>
                </section>

                <section>
                    <h3>7. Résiliation</h3>
                    <p>En cas de non-respect de ces CGU, Karnou se réserve le droit de suspendre ou de supprimer votre compte de plein droit, sans préavis ni indemnité, sans préjudice des éventuelles actions judiciaires qui pourraient être engagées.</p>
                </section>

                <section>
                    <h3>8. Loi Applicable et Juridiction</h3>
                    <p>Les présentes conditions sont régies par les lois en vigueur dans le pays de siège du groupe Karnou. Tout litige relatif à leur interprétation ou leur exécution sera soumis à la compétence exclusive des tribunaux compétents.</p>
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
