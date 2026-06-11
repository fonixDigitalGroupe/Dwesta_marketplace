@extends('layouts.app')

@section('title', 'Politique de Vie Privée - Karnou')

@section('content')
<div class="legal-page">
    <!-- Corporate Header -->
    <header class="corporate-header">
        <div class="about-container">
            <div class="corp-header-flex">
                <div class="header-left">
                    <a href="{{ route('home') }}" class="back-to-site">
                        <i class="fa-solid fa-chevron-left"></i> Retour sur le site
                    </a>
                </div>
                <div class="header-center">
                    <a href="{{ route('home') }}" class="corp-logo">
                        @if($logoUrl = \App\Models\Setting::logoUrl())
                            <img src="{{ $logoUrl }}" alt="Logo">
                        @else
                            <span class="corp-brand">Karnou</span>
                        @endif
                    </a>
                </div>
                <div class="header-right">
                    @auth
                        <a href="{{ route('account.index') }}" class="header-auth">
                            <i class="fa-regular fa-user"></i> {{ auth()->user()->prenom ?? auth()->user()->name }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="header-auth">
                            <i class="fa-regular fa-user"></i> Se connecter
                        </a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="header-link cart-link" title="Mon Panier">
                        <i class="fa-solid fa-cart-shopping"></i> Panier
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sub Nav -->
    <div class="about-sub-nav">
        <div class="about-container">
            <ul>
                <li class="{{ Route::is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">À propos</a></li>
                <li class="{{ Route::is('terms') ? 'active' : '' }}"><a href="{{ route('terms') }}">Conditions</a></li>
                <li class="{{ Route::is('privacy') ? 'active' : '' }}"><a href="{{ route('privacy') }}">Vie privée</a></li>
                <li class="{{ Route::is('cookies') ? 'active' : '' }}"><a href="{{ route('cookies') }}">Cookies</a></li>
                <li class="{{ Route::is('help') ? 'active' : '' }}"><a href="{{ route('help') }}">Aide</a></li>
                <li class="{{ Route::is('eshop.landing') ? 'active' : '' }}"><a href="{{ route('eshop.landing') }}">e-Shop</a></li>
                <li class="{{ Route::is('report') ? 'active' : '' }}"><a href="{{ route('report') }}">Signaler</a></li>
                <li class="{{ Route::is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
    </div>


    <!-- Hero -->
    <div class="legal-hero">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Document légal</span>
            <h1>Politique de Vie Privée</h1>
            <p class="legal-hero-desc">Nous nous engageons à protéger vos données personnelles et à respecter scrupuleusement votre vie privée.</p>
            <div class="legal-meta">
                <span><i class="fa-regular fa-calendar"></i> Mis à jour le 1er juin 2025</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-regular fa-file-lines"></i> 10 sections</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-shield-halved"></i> Données protégées</span>
            </div>
        </div>
    </div>

    <!-- Layout -->
    <div class="legal-layout">

        <!-- TOC Sidebar -->
        <aside class="legal-toc">
            <p class="toc-title">Table des matières</p>
            <ul class="toc-list">
                <li><a href="#sec1">1 — Responsable du traitement</a></li>
                <li><a href="#sec2">2 — Données collectées</a></li>
                <li><a href="#sec3">3 — Finalités</a></li>
                <li><a href="#sec4">4 — Base légale</a></li>
                <li><a href="#sec5">5 — Partage avec des tiers</a></li>
                <li><a href="#sec6">6 — Conservation des données</a></li>
                <li><a href="#sec7">7 — Vos droits</a></li>
                <li><a href="#sec8">8 — Sécurité</a></li>
                <li><a href="#sec9">9 — Cookies</a></li>
                <li><a href="#sec10">10 — Modifications</a></li>
            </ul>
        </aside>

        <!-- Main -->
        <main class="legal-main">



            <p class="legal-intro">Karnou Group (ci-après « Karnou » ou « Nous ») accorde une importance primordiale à la protection de votre vie privée. La présente Politique vous informe sur la façon dont nous collectons, utilisons, partageons et protégeons vos données à caractère personnel lorsque vous utilisez la Plateforme.</p>

            <article id="sec1" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Responsable du traitement</h2>
                    <p>Le responsable du traitement de vos données personnelles est <strong>Karnou Group</strong>, société enregistrée en République Centrafricaine, dont le siège social est situé à Bangui. Pour toute question relative à vos données, vous pouvez nous contacter à <strong>privacy@karnou.net</strong>.</p>
                </div>
            </article>

            <article id="sec2" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Données personnelles collectées</h2>
                    <p>Nous collectons différentes catégories de données selon votre utilisation :</p>
                    <ul>
                        <li><strong>Identification :</strong> nom, prénom, adresse e-mail, numéro de téléphone, date de naissance.</li>
                        <li><strong>Livraison :</strong> adresse postale, ville, pays.</li>
                        <li><strong>Financières :</strong> mode de paiement utilisé (les numéros de carte ne sont jamais stockés en clair).</li>
                        <li><strong>Navigation :</strong> adresse IP, type de navigateur, pages visitées, durée des sessions.</li>
                        <li><strong>Transactions :</strong> historique d'achats et de ventes, avis, montants.</li>
                        <li><strong>Communications :</strong> messages via notre messagerie interne, échanges avec le service client.</li>
                    </ul>
                </div>
            </article>

            <article id="sec3" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>Finalités du traitement</h2>
                    <p>Vos données sont collectées pour les finalités suivantes :</p>
                    <ul>
                        <li>Création et gestion de votre compte utilisateur.</li>
                        <li>Traitement et suivi de vos commandes via Karnou Express.</li>
                        <li>Sécurisation des transactions et prévention de la fraude.</li>
                        <li>Amélioration de la Plateforme via l'analyse d'audience.</li>
                        <li>Envoi de communications commerciales (uniquement avec votre consentement).</li>
                        <li>Respect de nos obligations légales et réglementaires.</li>
                        <li>Résolution des litiges et médiation entre Acheteurs et Vendeurs.</li>
                    </ul>
                </div>
            </article>

            <article id="sec4" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                    <h2>Base légale du traitement</h2>
                    <p>Nous traitons vos données sur la base des fondements suivants :</p>
                    <ul>
                        <li><strong>Exécution du contrat :</strong> pour traiter vos commandes et gérer votre compte.</li>
                        <li><strong>Votre consentement :</strong> pour les communications marketing et certains cookies.</li>
                        <li><strong>Intérêt légitime :</strong> pour améliorer nos services, prévenir la fraude.</li>
                        <li><strong>Obligation légale :</strong> pour la conservation de données fiscales ou comptables.</li>
                    </ul>
                </div>
            </article>

            <article id="sec5" class="legal-article">
                <div class="article-num">05</div>
                <div class="article-body">
                    <h2>Partage avec des tiers</h2>
                    <p>Karnou ne vend jamais vos données. Elles peuvent être partagées avec :</p>
                    <ul>
                        <li><strong>Partenaires logistiques :</strong> Karnou Express et transporteurs tiers pour vos livraisons.</li>
                        <li><strong>Prestataires de paiement :</strong> pour sécuriser vos transactions financières.</li>
                        <li><strong>Prestataires techniques :</strong> hébergement, analyses, support client (sous-traitants contractuels).</li>
                        <li><strong>Autorités compétentes :</strong> en cas d'obligation légale ou de réquisition judiciaire.</li>
                    </ul>
                </div>
            </article>

            <article id="sec6" class="legal-article">
                <div class="article-num">06</div>
                <div class="article-body">
                    <h2>Durée de conservation</h2>
                    <p>Vos données sont conservées en fonction des finalités et des obligations légales :</p>
                    <ul>
                        <li><strong>Données de compte actif :</strong> pendant toute la durée de votre inscription.</li>
                        <li><strong>Données de transaction :</strong> 5 ans à compter de la transaction.</li>
                        <li><strong>Cookies :</strong> 13 mois maximum.</li>
                    </ul>
                    <p>Au-delà de ces durées, vos données sont supprimées ou anonymisées.</p>
                </div>
            </article>

            <article id="sec7" class="legal-article">
                <div class="article-num">07</div>
                <div class="article-body">
                    <h2>Vos droits sur vos données</h2>
                    <p>Vous disposez des droits suivants sur vos données personnelles :</p>
                    <ul>
                        <li><strong>Droit d'accès :</strong> obtenir une copie de vos données.</li>
                        <li><strong>Droit de rectification :</strong> corriger toute donnée inexacte.</li>
                        <li><strong>Droit à l'effacement :</strong> demander la suppression dans les conditions légales.</li>
                        <li><strong>Droit d'opposition :</strong> vous opposer au traitement à des fins de prospection.</li>
                        <li><strong>Droit à la portabilité :</strong> recevoir vos données dans un format lisible.</li>
                        <li><strong>Retrait du consentement :</strong> à tout moment, sans effet rétroactif.</li>
                    </ul>
                    <p>Pour exercer ces droits, connectez-vous à votre espace personnel ou écrivez-nous à <strong>privacy@karnou.net</strong>. Nous répondons sous un mois.</p>
                </div>
            </article>

            <article id="sec8" class="legal-article">
                <div class="article-num">08</div>
                <div class="article-body">
                    <h2>Sécurité de vos données</h2>
                    <p>Karnou met en œuvre des mesures techniques et organisationnelles appropriées : chiffrement SSL/TLS de toutes les communications, accès restreint aux données par notre personnel, et audits de sécurité réguliers pour protéger vos informations contre tout accès non autorisé.</p>
                </div>
            </article>

            <article id="sec9" class="legal-article">
                <div class="article-num">09</div>
                <div class="article-body">
                    <h2>Cookies et traceurs</h2>
                    <p>Karnou utilise des cookies pour améliorer votre expérience. Pour en savoir plus sur notre usage et sur comment les gérer, consultez notre <a href="{{ route('cookies') }}">Politique de Gestion des Cookies</a>.</p>
                </div>
            </article>

            <article id="sec10" class="legal-article">
                <div class="article-num">10</div>
                <div class="article-body">
                    <h2>Modification de la politique</h2>
                    <p>Karnou se réserve le droit de modifier la présente Politique à tout moment. En cas de modification substantielle, nous vous en informerons par e-mail ou par une notification visible sur la Plateforme. La version en vigueur est celle affichée sur cette page.</p>
                </div>
            </article>

        </main>
    </div>
</div>

@push('styles')
<style>
    /* Force hide marketplace elements */
    .top-banner, .header, .footer { display: none !important; visibility: hidden !important; height: 0 !important; overflow: hidden !important; }
    body { padding-top: 0 !important; margin-top: 0 !important; background: #f8f9fb !important; }

    /* --- Base --- */
    .legal-page { background: #f8f9fb; min-height: 100vh; position: relative; z-index: 1000; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

    /* --- Corporate Header --- */
    .corporate-header { background: #fff; padding: 1rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; position: sticky; top: 0; z-index: 1000; }
    .corporate-header .about-container { max-width: 1350px; padding: 0 1.5rem; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; }

    .header-left, .header-right { flex: 1; display: flex; align-items: center; }
    .header-center { flex: 0; display: flex; justify-content: center; }
    .header-right { justify-content: flex-end; gap: 1.5rem; }

    .back-to-site, .header-auth, .cart-link { text-decoration: none; color: #555; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; transition: all 0.2s; }
    .back-to-site:hover, .header-auth:hover, .cart-link:hover { color: #004aad; }
    .back-to-site i, .header-auth i, .cart-link i { font-size: 1rem; }

    .corp-logo img { height: 28px; width: auto; display: block; }
    .corp-brand { font-size: 1.5rem; font-weight: 800; color: #004aad; letter-spacing: -1.5px; }

    /* --- Sub Nav --- */
    .about-sub-nav { background: #fff; border-bottom: 1px solid #eee; position: sticky; top: 61px; z-index: 900; padding: 1.2rem 0; box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05); }
    .about-sub-nav .about-container { max-width: 1350px; }
    .about-sub-nav ul { display: flex; list-style: none; gap: 1rem; margin: 0; padding: 0; justify-content: center; flex-wrap: wrap; }
    .about-sub-nav ul li a { text-decoration: none; color: #555; font-size: 0.85rem; font-weight: 500; padding: 0.6rem 1rem; border-radius: 4px; transition: all 0.2s; }
    .about-sub-nav ul li a:hover { color: #004aad; background: #f0f7ff; }
    .about-sub-nav ul li.active a { background: #004aad; color: #fff; font-weight: 600; padding: 0.7rem 1.2rem; }

    .legal-hero {
        background: linear-gradient(135deg, rgba(0, 74, 173, 0.9) 0%, rgba(0, 49, 130, 0.8) 100%), url('/images/vie_privee.jpg');
        background-size: cover;
        background-position: center;
        padding: 4rem 2rem;
        color: #fff;
        min-height: 480px;
        display: flex;
        align-items: center;
    }
    .legal-hero-inner { max-width: 800px; margin: 0 auto; }
    .legal-category-badge { display: inline-block; background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; padding: 0.35rem 0.9rem; border-radius: 50px; margin-bottom: 1.2rem; font-family: 'Inter', sans-serif; border: 1px solid rgba(255,255,255,0.2); }
    .legal-hero h1 { font-size: 2.2rem; font-weight: 700; font-family: 'Outfit', 'Inter', sans-serif; color: #fff; margin: 0 0 0.8rem; letter-spacing: -0.5px; line-height: 1.2; }
    .legal-hero-desc { font-size: 1rem; color: rgba(255,255,255,0.8); font-family: 'Inter', sans-serif; margin: 0 0 1.5rem; line-height: 1.6; }
    .legal-meta { display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; color: rgba(255,255,255,0.7); font-family: 'Inter', sans-serif; flex-wrap: wrap; }
    .legal-meta i { margin-right: 0.3rem; font-size: 0.8rem; }
    .meta-sep { opacity: 0.4; }

    .legal-layout { display: flex; align-items: flex-start; max-width: 1200px; margin: 3rem auto; padding: 0 2rem; gap: 3rem; }

    .legal-toc { width: 240px; flex-shrink: 0; position: sticky; top: 80px; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 1.5rem; }
    .toc-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #999; font-family: 'Inter', sans-serif; margin: 0 0 1rem; }
    .toc-list { list-style: none; padding: 0; margin: 0; }
    .toc-list li { margin-bottom: 0.1rem; }
    .toc-list li a { display: block; font-size: 0.82rem; color: #555; text-decoration: none; font-family: 'Inter', sans-serif; padding: 0.4rem 0.6rem; border-radius: 6px; transition: all 0.15s; line-height: 1.4; }
    .toc-list li a:hover { background: #fff5eb; color: #f68b1e; }

    .legal-main { flex: 1; min-width: 0; }

    .legal-intro { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #555; line-height: 1.75; margin-bottom: 2rem; }

    .legal-disclaimer { display: flex; align-items: flex-start; gap: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #004aad; border-radius: 8px; padding: 1.2rem 1.5rem; font-family: 'Inter', sans-serif; font-size: 0.9rem; color: #1e3a6a; line-height: 1.6; margin-bottom: 2rem; }
    .legal-disclaimer i { font-size: 1.2rem; color: #004aad; margin-top: 0.1rem; flex-shrink: 0; }

    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 2rem 2rem 2rem 1.5rem; margin-bottom: 1.2rem; transition: border-color 0.2s, box-shadow 0.2s; }
    .legal-article:hover { border-color: #f68b1e; box-shadow: 0 4px 16px rgba(246,139,30,0.1); }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #ffe5cc; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.75; margin-bottom: 0.8rem; }
    .article-body ul { padding-left: 1.3rem; margin-bottom: 0.8rem; }
    .article-body li { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.7; margin-bottom: 0.5rem; }
    .article-body a { color: #f68b1e; text-decoration: none; font-weight: 600; }
    .article-body a:hover { text-decoration: underline; }


    @media (max-width: 900px) {
        .legal-layout { flex-direction: column; }
        .legal-toc { position: static; width: 100%; }
        .toc-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0.2rem; }
        .legal-hero h1 { font-size: 1.6rem; }
    }
    @media (max-width: 600px) {
        .legal-layout { padding: 0 1rem; margin: 1.5rem auto; }
        .article-num { display: none; }
        .legal-article { padding: 1.5rem; }
        .toc-list { grid-template-columns: 1fr; }
    }
</style>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const articles = document.querySelectorAll('.legal-article');
        const tocLinks = document.querySelectorAll('.toc-list a');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const link = document.querySelector(`.toc-list a[href="#${entry.target.id}"]`);
                if (!link) return;
                if (entry.isIntersecting) {
                    tocLinks.forEach(l => { l.style.background=''; l.style.color=''; l.style.fontWeight=''; });
                    link.style.background = '#fff5eb';
                    link.style.color = '#f68b1e';
                    link.style.fontWeight = '600';
                }
            });
        }, { rootMargin: '-20% 0px -70% 0px' });
        articles.forEach(a => observer.observe(a));
    });
</script>
@endsection
