@extends('layouts.app')

@section('title', 'À propos de Karnou - Notre Mission et Nos Valeurs')

@section('content')
<div class="about-page">
    <!-- Corporate Header (Hides Global Header via CSS) -->
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
                        <li class="active"><a href="#">À propos</a></li>
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
                <li class="active"><a href="#">À propos de Karnou</a></li>
                <li><a href="#">Conditions générales</a></li>
                <li><a href="#">Vie privée</a></li>
                <li><a href="#">Gestion des cookies</a></li>
            </ul>
            <div class="sub-nav-search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="about-hero" id="apropos" style="margin: 2rem 3rem 0 3rem; border-radius: 14px; overflow: hidden;">
        <div class="hero-overlay"></div>
        <div class="about-container">
            <div class="hero-content">
                <h1 class="hero-title">Karnou, groupe d'innovation digitale au service de la société</h1>
                <div class="header-line left"></div>
            </div>
        </div>
    </section>

    <!-- Qui sommes-nous Section -->
    <section class="about-qui">
        <div class="about-container">
            <div class="section-header center-header">
                <h2 class="qui-title">Qui sommes-nous ?</h2>
                <div class="qui-line"></div>
            </div>

            <p class="qui-description">
                Karnou, fondé en République Centrafricaine, est né de la volonté de démocratiser le commerce numérique en Afrique. Acteur incontournable de l'innovation locale, Karnou rassemble des services digitaux complémentaires dans des domaines aussi variés que l'e-commerce, la logistique, les services financiers et le développement technologique. Karnou accompagne chaque jour des milliers d'acheteurs et de vendeurs dans un écosystème sécurisé et adapté aux réalités africaines.
            </p>

            <!-- Tabs Navigation -->
            <div class="qui-tabs">
                <button class="qui-tab active" onclick="switchQuiTab('philosophie', this)">Philosophie</button>
                <button class="qui-tab" onclick="switchQuiTab('mission', this)">Mission</button>
                <button class="qui-tab" onclick="switchQuiTab('vision', this)">Vision</button>
                <button class="qui-tab" onclick="switchQuiTab('engagement', this)">Engagement</button>
                <button class="qui-tab" onclick="switchQuiTab('valeurs', this)">Valeurs</button>
            </div>

            <!-- Tab Contents -->
            <div class="qui-tab-content active" id="qui-philosophie">
                Karnou contribue au progrès de la société en valorisant l'innovation et l'entrepreneuriat.<br>
                En fournissant des services de qualité à nos clients et partenaires pour les aider à se développer, nous permettons aux acteurs locaux de grandir et de s'approprier les nouvelles technologies de pointe mises à leur disposition.
            </div>
            <div class="qui-tab-content" id="qui-mission">
                Notre mission est de démocratiser l'accès au commerce en ligne de qualité en Afrique Centrale. Chaque transaction sur Karnou doit être une expérience fluide, sécurisée et valorisante pour tous.
            </div>
            <div class="qui-tab-content" id="qui-vision">
                Devenir la plateforme de référence en Afrique francophone, reconnue pour la qualité de son écosystème numérique et l'impact positif qu'elle génère pour les communautés locales.
            </div>
            <div class="qui-tab-content" id="qui-engagement">
                Nous nous engageons à toujours placer l'humain au centre de nos décisions : transparence totale, zéro frais cachés, et un support client disponible à tout moment pour accompagner chaque utilisateur.
            </div>
            <div class="qui-tab-content" id="qui-valeurs">
                Confiance, transparence, innovation et impact local. Ces quatre piliers guident chacune de nos décisions et définissent l'identité profonde de Karnou.
            </div>
        </div>
    </section>

    <!-- Stats Section -->


    <!-- Ecosystem Diagram Section -->
    <section class="about-ecosystem-diagram">
        <div class="about-container">
            <div class="section-header">
                <h2>Un écosystème unique</h2>
                <div class="header-line"></div>
            </div>
            <div class="diagram-wrapper">
                <div class="diagram-left">
                    <svg viewBox="0 0 400 400" class="circular-diagram">
                        <!-- Main Circle -->
                        <circle cx="200" cy="200" r="150" fill="none" stroke="#eee" stroke-width="1" />
                        <!-- Central Logo Area -->
                        <circle cx="200" cy="200" r="50" fill="#004aad" />
                        <text x="200" y="205" text-anchor="middle" fill="white" font-weight="900" font-size="14">KARNOU</text>
                        
                        <!-- Nodes -->
                        <g class="node commerce">
                            <circle cx="200" cy="50" r="35" fill="white" stroke="#004aad" stroke-width="2" />
                            <text x="200" y="55" text-anchor="middle" font-size="10" font-weight="700">COMMERCE</text>
                        </g>
                        <g class="node fintech">
                            <circle cx="350" cy="200" r="35" fill="white" stroke="#004aad" stroke-width="2" />
                            <text x="350" y="205" text-anchor="middle" font-size="10" font-weight="700">FINTECH</text>
                        </g>
                        <g class="node logistique">
                            <circle cx="200" cy="350" r="35" fill="white" stroke="#004aad" stroke-width="2" />
                            <text x="200" y="355" text-anchor="middle" font-size="10" font-weight="700">LOGISTIQUE</text>
                        </g>
                        <g class="node innovation">
                            <circle cx="50" cy="200" r="35" fill="white" stroke="#004aad" stroke-width="2" />
                            <text x="50" y="205" text-anchor="middle" font-size="10" font-weight="700">INNOVATION</text>
                        </g>

                        <!-- Connecting Lines -->
                        <line x1="200" y1="85" x2="200" y2="150" stroke="#004aad" stroke-dasharray="4" />
                        <line x1="315" y1="200" x2="250" y2="200" stroke="#004aad" stroke-dasharray="4" />
                        <line x1="200" y1="315" x2="200" y2="250" stroke="#004aad" stroke-dasharray="4" />
                        <line x1="85" y1="200" x2="150" y2="200" stroke="#004aad" stroke-dasharray="4" />
                    </svg>
                </div>
                <div class="diagram-right">
                    <div class="ecosystem-text">
                        <p>Karnou se compose de multiples entités, soit autant d'expertises qui positionnent le groupe comme un acteur incontournable de la scène tech africaine. Le groupe intervient notamment dans les secteurs suivants :</p>
                        <ul>
                            <li><strong>E-commerce :</strong> Activité historique du groupe, une marketplace 100% confiance.</li>
                            <li><strong>Services financiers :</strong> Des solutions FinTech pour sécuriser les échanges.</li>
                            <li><strong>Logistique :</strong> Un réseau intégré pour une livraison sans faille.</li>
                            <li><strong>Innovation :</strong> Recherche et développement au service de la société.</li>
                        </ul>
                    </div>
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

    /* Diagram Section */
    .about-ecosystem-diagram {
        padding: 8rem 0;
        background: #fff;
    }

    .diagram-wrapper {
        display: flex;
        align-items: center;
        gap: 5rem;
        margin-top: 4rem;
    }

    .diagram-left {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .circular-diagram {
        width: 100%;
        max-width: 400px;
    }

    .diagram-right {
        flex: 1;
    }

    .ecosystem-text p {
        font-size: 1.15rem;
        line-height: 1.7;
        color: #444;
        margin-bottom: 2rem;
    }

    .ecosystem-text ul {
        list-style: none;
        padding: 0;
    }

    .ecosystem-text li {
        margin-bottom: 1.5rem;
        font-size: 1.05rem;
        color: #666;
        padding-left: 1.5rem;
        position: relative;
    }

    .ecosystem-text li::before {
        content: '■';
        position: absolute;
        left: 0;
        color: #004aad;
        font-size: 0.8rem;
        top: 2px;
    }

    /* Mission & Values Refinements */
    .about-mission {
        padding: 8rem 0;
        background: #fdfdfd;
    }

    .section-badge {
        display: inline-block;
        padding: 0.5rem 1.2rem;
        background: rgba(191, 0, 0, 0.1);
        color: #004aad;
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
        color: #1a1a1a;
        font-weight: 300;
        letter-spacing: 0;
        font-family: 'Outfit', 'Inter', sans-serif;
        margin-bottom: 1rem;
    }

    .header-line {
        width: 50px;
        height: 3px;
        background: #004aad;
        margin: 0 auto;
    }

    /* Hiding Global Marketplace Header on this page */
    .header, .top-banner {
        display: none !important;
    }

    /* Corporate Header Style */
    .corporate-header {
        background: #fff;
        padding: 1.2rem 0;
        border-bottom: 1px solid #eee;
    }

    .corp-header-flex {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 10rem;
    }

    .corp-brand {
        font-size: 1.4rem;
        font-weight: 800;
        color: #004aad; /* Brand Blue */
        letter-spacing: -1px;
        text-decoration: none;
        padding: 1rem 0;
    }

    .corp-nav ul {
        display: flex;
        list-style: none;
        gap: 1.5rem;
        margin: 0;
        padding: 0;
        align-items: stretch;
    }

    .corp-nav ul li {
        display: flex;
        align-items: stretch;
    }

    .corp-nav ul li a {
        text-decoration: none;
        color: #333;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s;
        padding: 1rem 0;
        display: flex;
        align-items: center;
    }

    .corp-nav ul li.active a {
        background: #004aad; /* Brand Blue */
        color: #fff;
        padding: 1rem 1.4rem;
        border-radius: 4px;
    }

    .corp-nav ul li a:hover:not(.active a) {
        color: #004aad;
    }

    /* Sub-Header Navigation */
    .about-sub-nav {
        background: #fff;
        border-bottom: 1px solid #eee;
        position: sticky;
        top: 0;
        z-index: 100;
        padding: 0.8rem 0;
    }

    .about-sub-nav .about-container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .sub-nav-list {
        display: flex;
        list-style: none;
        gap: 2.5rem;
        margin: 0;
        padding: 0;
    }

    .sub-nav-list li a {
        text-decoration: none;
        color: #333;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s;
        padding-bottom: 0.6rem;
        border-bottom: 3px solid transparent;
    }

    .sub-nav-list li.active a,
    .sub-nav-list li a:hover {
        color: #333;
    }

    .sub-nav-list li.active a {
        border-bottom-color: #004aad; /* Brand Blue */
        font-weight: 500;
    }

    .sub-nav-search {
        position: absolute;
        right: 2rem;
        color: #004aad; /* Brand Blue */
        font-size: 1rem;
        cursor: pointer;
    }

    /* Hero Section */
    .about-hero {
        height: 450px;
        background: url('/images/about_hero_drone.png') center/cover no-repeat;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        margin: 2rem 3rem 0 3rem !important;
        border-radius: 14px !important;
        max-width: calc(100% - 6rem) !important;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 600px;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.2;
        letter-spacing: -1px;
        margin-bottom: 2rem;
        font-family: 'Outfit', 'Inter', sans-serif;
        text-align: left;
    }

    /* Stats Section */
    .about-stats {
        padding: 6rem 0;
        background: #fff;
    }

    .stats-grid {
        display: flex;
        justify-content: space-between;
        gap: 2rem;
    }

    .stat-box {
        text-align: center;
        flex: 1;
    }

    .stat-val {
        display: block;
        font-size: 2.8rem;
        font-weight: 800;
        color: #004aad;
        margin-bottom: 0.5rem;
        letter-spacing: -1px;
    }

    .stat-desc {
        font-size: 1rem;
        color: #666;
        font-weight: 500;
    }

    /* History Timeline */
    .about-history {
        padding: 6rem 0;
        background: #fdfdfd;
    }

    .history-timeline {
        max-width: 1000px;
        margin: 4rem auto 0;
        position: relative;
    }

    .history-timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 1px;
        background: #eee;
    }

    .timeline-item {
        margin-bottom: 4rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .timeline-item:nth-child(even) {
        flex-direction: row-reverse;
    }

    .timeline-date {
        width: 45%;
        font-size: 2rem;
        font-weight: 900;
        color: #bf0000;
        text-align: right;
        padding: 0 3rem;
    }

    .timeline-item:nth-child(even) .timeline-date {
        text-align: left;
    }

    .timeline-content {
        width: 45%;
        padding: 0 3rem;
    }

    .timeline-content h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .timeline-content p {
        color: #666;
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

    /* Ecosystem Section */
    .about-ecosystem {
        padding: 8rem 0;
        background: #fff;
        overflow: hidden;
    }

    .header-line {
        width: 40px;
        height: 3px;
        background: #bf0000;
        margin: 1.5rem auto 0;
    }

    .ecosystem-map-container {
        position: relative;
        margin-top: 4rem;
    }

    .map-wrapper {
        position: relative;
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }

    .world-map-bg {
        width: 100%;
        height: auto;
        opacity: 0.8;
        display: block;
    }

    .location-pin {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
        z-index: 10;
    }

    .location-pin:hover {
        transform: translate(-50%, -60%) scale(1.1);
    }

    .pin-label {
        background: #fff;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #1e293b;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        white-space: nowrap;
        border: 1px solid #e2e8f0;
    }


    /* Responsive */
    @media (max-width: 1024px) {
        .hero-title { font-size: 2.75rem; }
        .mission-grid { gap: 3rem; }
        .location-pin .pin-label { font-size: 0.65rem; padding: 0.2rem 0.5rem; }
    }

    /* Qui sommes-nous Section */
    .about-qui {
        padding: 6rem 0 4rem;
        background: #fff;
    }

    .center-header {
        text-align: center;
    }

    .qui-title {
        font-size: 3rem;
        font-weight: 300;
        color: #1a1a1a;
        margin-bottom: 1.2rem;
        letter-spacing: -0.5px;
        font-family: 'Outfit', 'Inter', sans-serif;
    }

    .qui-line {
        width: 60px;
        height: 3px;
        background: #004aad;
        margin: 0 auto 2.5rem;
    }

    .qui-description {
        text-align: center;
        max-width: 860px;
        margin: 0 auto 3.5rem;
        color: #555;
        font-size: 1.05rem;
        line-height: 1.8;
    }

    /* Tabs */
    .qui-tabs {
        display: flex;
        justify-content: center;
        gap: 3rem;
        border-bottom: 1px solid #eee;
        margin-bottom: 3rem;
    }

    .qui-tab {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        color: #888;
        padding: 0 0 1rem 0;
        border-bottom: 3px solid transparent;
        margin-bottom: -1px;
        transition: color 0.2s, border-color 0.2s;
        font-family: 'Outfit', sans-serif;
    }

    .qui-tab:hover {
        color: #333;
    }

    .qui-tab.active {
        color: #004aad;
        border-bottom-color: #004aad;
        font-weight: 700;
    }

    /* Tab Content */
    .qui-tab-content {
        display: none;
        text-align: center;
        max-width: 860px;
        margin: 0 auto;
        color: #555;
        font-size: 1rem;
        line-height: 1.9;
        padding: 0 1rem;
    }

    .qui-tab-content.active {
        display: block;
    }

    @media (max-width: 768px) {
        .about-hero { padding: 6rem 0; }
        .hero-title { font-size: 2.25rem; }
        .mission-grid { grid-template-columns: 1fr; text-align: center; padding: 0 1rem; }
        .mission-stats { justify-content: center; }
        .values-grid { grid-template-columns: 1fr; }
        .cta-box { padding: 3rem 1.5rem; }
        .cta-btns { flex-direction: column; }
        
        .map-wrapper { transform: scale(1.2); left: 10%; position: relative; }
        .map-legend { gap: 1rem; }
        .about-ecosystem { display: none; }

        .qui-tabs { gap: 1.5rem; overflow-x: auto; justify-content: flex-start; padding-bottom: 5px; }
        .qui-tab { flex-shrink: 0; }
    }
</style>

<script>
    function switchQuiTab(name, el) {
        // Hide all tab contents
        document.querySelectorAll('.qui-tab-content').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.qui-tab').forEach(t => t.classList.remove('active'));
        // Show selected
        document.getElementById('qui-' + name).classList.add('active');
        el.classList.add('active');
    }
</script>

@endsection
