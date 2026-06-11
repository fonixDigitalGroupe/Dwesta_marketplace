@extends('layouts.app')

@section('title', 'Besoin d\'aide ? - Centre de Support Karnou')

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
                        <li class="{{ Route::is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">À propos de Karnou</a></li>
                        <li class="{{ Route::is('terms') ? 'active' : '' }}"><a href="{{ route('terms') }}">Conditions générales</a></li>
                        <li class="{{ Route::is('privacy') ? 'active' : '' }}"><a href="{{ route('privacy') }}">Vie privée</a></li>
                        <li class="{{ Route::is('cookies') ? 'active' : '' }}"><a href="{{ route('cookies') }}">Gestion des cookies</a></li>
                        <li><a href="#">Actualité</a></li>
                        <li class="{{ Route::is('help') ? 'active' : '' }}"><a href="{{ route('help') }}">Besoin d'aide ?</a></li>
                        <li class="{{ Route::is('eshop.landing') ? 'active' : '' }}"><a href="{{ route('eshop.landing') }}">Ouvrir un e-shop</a></li>
                        <li class="{{ Route::is('report') ? 'active' : '' }}"><a href="{{ route('report') }}">Signaler un contenu</a></li>
                        <li class="{{ Route::is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="legal-hero" style="background-image: linear-gradient(rgba(0, 74, 173, 0.9), rgba(0, 74, 173, 0.9)), url('{{ asset('images/help_bannier.png') }}');">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Centre de Support</span>
            <h1>Comment pouvons-nous vous aider aujourd'hui ?</h1>
            <p>Trouvez toutes les réponses à vos questions sur l'utilisation de la plateforme Karnou.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="about-container">
        <div class="legal-layout">
            <!-- Sidebar TOC -->
            <aside class="legal-sidebar">
                <nav class="toc">
                    <h3>Sommaire</h3>
                    <ul>
                        <li><a href="#achat" class="toc-link active">Acheter sur Karnou</a></li>
                        <li><a href="#vente" class="toc-link">Vendre sur Karnou</a></li>
                        <li><a href="#paiement" class="toc-link">Paiements & Sécurité</a></li>
                        <li><a href="#compte" class="toc-link">Mon Compte</a></li>
                        <li><a href="#livraison" class="toc-link">Livraison</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Content -->
            <main class="legal-body">
                <section id="achat" class="legal-section">
                    <h2>Acheter sur Karnou</h2>
                    <p>Karnou vous offre une expérience d'achat sécurisée et simplifiée à travers toute la Centrafrique.</p>
                    <div class="faq-list">
                        <div class="faq-item">
                            <h3>Comment passer une commande ?</h3>
                            <p>Parcourez nos catégories, ajoutez les produits au panier et suivez les étapes de validation.</p>
                        </div>
                        <div class="faq-item">
                            <h3>Quels sont les modes de livraison ?</h3>
                            <p>Nous livrons à domicile dans les grandes villes ou via des points relais partenaires.</p>
                        </div>
                    </div>
                </section>

                <section id="vente" class="legal-section">
                    <h2>Vendre sur Karnou</h2>
                    <p>Devenez un acteur du commerce digital en ouvrant votre propre e-shop.</p>
                    <div class="faq-list">
                        <div class="faq-item">
                            <h3>Comment devenir vendeur ?</h3>
                            <p>Cliquez sur "Ouvrir un e-shop" et complétez votre dossier professionnel.</p>
                        </div>
                    </div>
                </section>

                <section id="paiement" class="legal-section">
                    <h2>Paiements & Sécurité</h2>
                    <p>Tous vos paiements sont protégés par nos partenaires de paiement mobile (Orange Money, Wave, etc.).</p>
                </section>

                <section id="compte" class="legal-section">
                    <h2>Mon Compte</h2>
                    <p>Gérez vos informations personnelles, vos commandes et vos favoris depuis votre tableau de bord.</p>
                </section>

                <section id="livraison" class="legal-section">
                    <h2>Livraison</h2>
                    <p>Informations sur les délais de livraison et le suivi de vos colis.</p>
                </section>
            </main>
        </div>
    </div>
</div>

<style>
    /* Reuse consistent styles from about.blade.php */
    .legal-page { font-family: 'Outfit', sans-serif; color: #333; background-color: #fff; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
    
    .corporate-header { background: #fff; padding: 1.25rem 0; border-bottom: 1px solid #efefef; position: sticky; top: 0; z-index: 1000; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; padding: 0 2rem; }
    .corp-logo { display: block; text-decoration: none; }
    .corp-brand { font-size: 1.4rem; font-weight: 700; color: #004aad; letter-spacing: -1px; }
    .corp-nav ul { display: flex; list-style: none; gap: 0.8rem; margin: 0; padding: 0; flex-wrap: wrap; justify-content: flex-end; }
    .corp-nav ul li a { text-decoration: none; color: #555; font-size: 0.82rem; font-weight: 500; font-family: 'Inter', sans-serif; transition: all 0.2s; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; }
    .corp-nav ul li a:hover { color: #004aad; }
    .corp-nav ul li.active a { color: #004aad; border-bottom: 2px solid #004aad; font-weight: 600; }

    .legal-hero { height: 350px; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center; color: #fff; }
    .legal-hero-inner { max-width: 800px; padding: 2rem; }
    .legal-category-badge { display: inline-block; padding: 0.5rem 1.25rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px; backdrop-filter: blur(5px); }
    .legal-hero h1 { font-size: 3rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.1; letter-spacing: -1px; }
    .legal-hero p { font-size: 1.2rem; opacity: 0.9; font-weight: 400; }

    .legal-layout { display: grid; grid-template-columns: 280px 1fr; gap: 4rem; padding: 4rem 0; }
    .legal-sidebar { position: sticky; top: 120px; height: fit-content; }
    .toc h3 { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #999; margin-bottom: 1.5rem; font-weight: 800; }
    .toc ul { list-style: none; padding: 0; margin: 0; border-left: 1px solid #efefef; }
    .toc-link { display: block; padding: 0.75rem 1.5rem; text-decoration: none; color: #666; font-size: 0.95rem; font-weight: 500; transition: all 0.3s; margin-left: -1px; border-left: 2px solid transparent; }
    .toc-link:hover { color: #004aad; background: #f8fbff; }
    .toc-link.active { color: #004aad; border-left-color: #004aad; font-weight: 700; background: #f0f7ff; }

    .legal-body { line-height: 1.8; color: #444; font-size: 1.05rem; }
    .legal-section { margin-bottom: 5rem; scroll-margin-top: 100px; }
    .legal-section h2 { font-size: 2rem; font-weight: 800; color: #111; margin-bottom: 1.5rem; letter-spacing: -0.5px; }
    .faq-item { margin-bottom: 2rem; }
    .faq-item h3 { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 0.5rem; }

    @media (max-width: 968px) {
        .legal-layout { grid-template-columns: 1fr; gap: 2rem; }
        .legal-sidebar { display: none; }
        .legal-hero h1 { font-size: 2.2rem; }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tocLinks = document.querySelectorAll('.toc-link');
        const sections = document.querySelectorAll('.legal-section');

        function setActiveLink() {
            let index = sections.length;
            while(--index && window.scrollY + 150 < sections[index].offsetTop) {}
            tocLinks.forEach((link) => link.classList.remove('active'));
            tocLinks[index].classList.add('active');
        }

        setActiveLink();
        window.addEventListener('scroll', setActiveLink);
    });
</script>
@endsection
