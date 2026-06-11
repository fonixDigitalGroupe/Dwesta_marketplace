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
                    <h3>1. Préambule et Engagement</h3>
                    <p>La protection de votre vie privée est une priorité absolue pour le groupe Karnou. Cette politique détaille comment nous collectons, utilisons et protégeons vos données personnelles lorsque vous utilisez nos services numériques. Nous nous engageons à respecter scrupuleusement les réglementations en vigueur sur la protection des données.</p>
                </section>

                <section>
                    <h3>2. Nature des Données Collectées</h3>
                    <p>Nous collectons différentes catégories de données pour assurer le bon fonctionnement de notre écosystème :</p>
                    <ul>
                        <li><strong>Données d'identification :</strong> Nom, prénom, adresse e-mail, numéro de téléphone, adresse postale.</li>
                        <li><strong>Données de transaction :</strong> Historique d'achats, méthodes de paiement (sécurisées et cryptées).</li>
                        <li><strong>Données de navigation :</strong> Adresse IP, type de navigateur, pages consultées via nos cookies internes.</li>
                    </ul>
                </section>

                <section>
                    <h3>3. Finalités du Traitement</h3>
                    <p>Vos données sont traitées pour des objectifs précis :</p>
                    <ul>
                        <li>Gestion et exécution de vos commandes et livraisons.</li>
                        <li>Amélioration de votre expérience utilisateur sur la plateforme.</li>
                        <li>Prévention de la fraude et sécurisation des transactions.</li>
                        <li>Envoi de communications marketing (uniquement avec votre consentement explicite).</li>
                    </ul>
                </section>

                <section>
                    <h3>4. Partage avec des Tiers</h3>
                    <p>Vos données ne sont jamais vendues à des tiers. Elles peuvent toutefois être partagées avec nos partenaires logistiques (Karnou Express) et financiers uniquement pour la bonne exécution des services que vous avez sollicités.</p>
                </section>

                <section>
                    <h3>5. Conservation des Données</h3>
                    <p>Karnou ne conserve vos données que le temps nécessaire aux finalités pour lesquelles elles ont été collectées, conformément aux durées de prescription légales. Par exemple, vos données de compte sont conservées tant que votre compte est actif.</p>
                </section>

                <section>
                    <h3>6. Sécurité et Protection de l'Information</h3>
                    <p>Nous utilisons des technologies de pointe, telles que le protocole SSL (Secure Socket Layer), pour crypter les informations sensibles. Nos serveurs font l'objet d'une surveillance constante pour prévenir toute intrusion ou perte de données.</p>
                </section>

                <section>
                    <h3>7. Vos Droits (Accès, Rectification, Suppression)</h3>
                    <p>Conformément à la loi, vous disposez d'un droit total sur vos données. Vous pouvez à tout moment demander l'accès, la rectification ou la suppression de vos informations personnelles. Pour exercer ces droits, contactez-nous via la section "Contact" ou directement depuis vos paramètres de profil.</p>
                </section>

                <section>
                    <h3>8. Modification de la Politique</h3>
                    <p>Karnou peut mettre à jour cette politique périodiquement. Nous vous en informerons par e-mail ou via une notification sur le site en cas de modification substantielle.</p>
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
