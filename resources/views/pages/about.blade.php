@extends('layouts.app')

@section('title', 'À propos de Karnou - Notre Mission et Nos Valeurs')

@section('content')
<div class="about-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="about-container">
            <h1 class="hero-title">Redéfinir le e-commerce local</h1>
            <p class="hero-subtitle">Karnou est bien plus qu'une simple marketplace. C'est un écosystème de confiance conçu pour connecter les vendeurs passionnés et les acheteurs exigeants.</p>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="about-mission">
        <div class="about-container">
            <div class="mission-grid">
                <div class="mission-content">
                    <span class="section-badge">Notre Mission</span>
                    <h2>Simplifier chaque interaction</h2>
                    <p>Notre mission est de démocratiser l'accès au commerce en ligne de qualité. Nous croyons que chaque transaction doit être une expérience fluide, sécurisée et valorisante, que vous achetiez un produit neuf ou que vous offriez une seconde vie à un objet.</p>
                    <div class="mission-stats">
                        <div class="stat-item">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">Transactions Sécurisées</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <span class="stat-label">Support Client</span>
                        </div>
                    </div>
                </div>
                <div class="mission-image">
                    <div class="image-box">
                        <img src="https://images.unsplash.com/photo-1556742049-13da736c046c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Karnou Commerce">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="about-values">
        <div class="about-container">
            <div class="section-header">
                <span class="section-badge center">Nos Valeurs</span>
                <h2>Ce qui nous définit</h2>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3>Confiance & Sécurité</h3>
                    <p>La sécurité est notre priorité absolue. Nous mettons en œuvre les meilleures technologies pour protéger vos données et vos transactions.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-handshake"></i></div>
                    <h3>Transparence</h3>
                    <p>Pas de frais cachés. Nous croyons en une communication honnête et claire avec notre communauté de vendeurs et d'acheteurs.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><i class="fa-solid fa-earth-africa"></i></div>
                    <h3>Impact Local</h3>
                    <p>Nous soutenons l'économie locale en offrant aux artisans et commerçants une plateforme puissante pour rayonner.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="about-cta">
        <div class="about-container">
            <div class="cta-box">
                <h2>Prêt à commencer l'aventure ?</h2>
                <p>Rejoignez des milliers d'utilisateurs qui font confiance à Karnou chaque jour.</p>
                <div class="cta-btns">
                    <a href="{{ route('register') }}" class="btn btn-primary">Créer un compte gratuitement</a>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Explorer la marketplace</a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .about-page {
        background: #fff;
        padding-bottom: 6rem;
    }

    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Section Header & Badges */
    .section-badge {
        display: inline-block;
        background: #eef2ff;
        color: #004aad;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    .section-badge.center {
        margin-left: auto;
        margin-right: auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-header h2 {
        font-size: 2.5rem;
        color: #1e293b;
        font-weight: 800;
    }

    /* Hero Section */
    .about-hero {
        background: linear-gradient(135deg, #004aad 0%, #002d6a 100%);
        padding: 8rem 0;
        color: #fff;
        text-align: center;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 1.5rem;
        line-height: 1.1;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Mission Section */
    .about-mission {
        padding: 8rem 0;
    }

    .mission-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5rem;
        align-items: center;
    }

    .mission-content h2 {
        font-size: 2.5rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .mission-content p {
        font-size: 1.1rem;
        color: #64748b;
        line-height: 1.7;
        margin-bottom: 2.5rem;
    }

    .mission-stats {
        display: flex;
        gap: 3rem;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #004aad;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .image-box {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .image-box img {
        width: 100%;
        height: auto;
        display: block;
    }

    /* Values Section */
    .about-values {
        padding: 6rem 0;
        background: #f8fafc;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2.5rem;
    }

    .value-card {
        background: #fff;
        padding: 3rem 2rem;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .value-icon {
        width: 60px;
        height: 60px;
        background: #eef2ff;
        color: #004aad;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border-radius: 12px;
        margin: 0 auto 2rem;
    }

    .value-card h3 {
        font-size: 1.25rem;
        color: #1e293b;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .value-card p {
        color: #64748b;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* CTA Section */
    .about-cta {
        padding: 6rem 0;
    }

    .cta-box {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        padding: 5rem;
        border-radius: 30px;
        text-align: center;
        color: #fff;
    }

    .cta-box h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        font-weight: 800;
    }

    .cta-box p {
        font-size: 1.1rem;
        opacity: 0.8;
        margin-bottom: 3rem;
    }

    .cta-btns {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
    }

    .btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #004aad;
        color: #fff;
    }

    .btn-primary:hover {
        background: #003a88;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .hero-title { font-size: 2.75rem; }
        .mission-grid { gap: 3rem; }
    }

    @media (max-width: 768px) {
        .about-hero { padding: 6rem 0; }
        .hero-title { font-size: 2.25rem; }
        .mission-grid { grid-template-columns: 1fr; text-align: center; padding: 0 1rem; }
        .mission-stats { justify-content: center; }
        .values-grid { grid-template-columns: 1fr; }
        .cta-box { padding: 3rem 1.5rem; }
        .cta-btns { flex-direction: column; }
    }
</style>
@endsection
