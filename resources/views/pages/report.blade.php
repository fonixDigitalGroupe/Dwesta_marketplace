@extends('layouts.app')

@section('title', 'Signaler un contenu - Karnou')

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
    <div class="legal-hero" style="background-image: linear-gradient(rgba(0, 74, 173, 0.9), rgba(0, 74, 173, 0.9)), url('{{ asset('images/report_bannier.png') }}');">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Confiance & Sécurité</span>
            <h1>Signaler un contenu inapproprié</h1>
            <p>Aidez-nous à maintenir la plateforme Karnou sûre et respectueuse pour tous.</p>
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
                        <li><a href="#pourquoi" class="toc-link active">Pourquoi signaler ?</a></li>
                        <li><a href="#comment" class="toc-link">Comment signaler ?</a></li>
                        <li><a href="#process" class="toc-link">Notre processus</a></li>
                        <li><a href="#sanctions" class="toc-link">Sanctions possibles</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Content -->
            <main class="legal-body">
                <section id="pourquoi" class="legal-section">
                    <h2>Pourquoi signaler un contenu ?</h2>
                    <p>La sécurité et l'intégrité de notre marketplace sont nos priorités. Vous devez signaler tout contenu qui :</p>
                    <ul>
                        <li>Est illégal, frauduleux ou trompeur.</li>
                        <li>Est haineux, harcelant ou violent.</li>
                        <li>Porte atteinte à la propriété intellectuelle.</li>
                        <li>Est une tentative d'arnaque ou de phishing.</li>
                    </ul>
                </section>

                <section id="comment" class="legal-section">
                    <h2>Comment signaler ?</h2>
                    <p>Pour chaque annonce, vous trouverez un bouton "Signaler" qui vous permet de nous alerter directement.</p>
                    <p>Vous pouvez également envoyer un email détaillé à notre équipe de modération en précisant le lien de l'annonce ou l'identifiant du vendeur.</p>
                </section>

                <section id="process" class="legal-section">
                    <h2>Notre processus de modération</h2>
                    <p>Chaque signalement est examiné manuellement par nos équipes de confiance et sécurité sous 24h.</p>
                </section>

                <section id="sanctions" class="legal-section">
                    <h2>Sanctions possibles</h2>
                    <p>En cas de violation confirmée de nos CGU, nous pouvons supprimer le contenu, suspendre temporairement le compte, ou bannir définitivement l'utilisateur.</p>
                </section>
            </main>
        </div>
    </div>
</div>

<style>
    /* Same styles as help.blade.php for consistency */
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
