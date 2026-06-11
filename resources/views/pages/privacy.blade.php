@extends('layouts.app')

@section('title', 'Politique de Vie Privée - Karnou')

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
                    </ul>
                </nav>
            </div>
        </div>
    </header>


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

            <div class="legal-contact-strip">
                <i class="fa-regular fa-envelope"></i>
                <div>
                    <strong>Exercer vos droits ou poser une question ?</strong><br>
                    Contactez notre délégué à la protection des données à <a href="mailto:privacy@karnou.net">privacy@karnou.net</a> — réponse garantie sous 30 jours.
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .legal-page { background: #f8f9fb; min-height: 100vh; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
    .header, .top-banner { display: none !important; }

    /* --- Corporate Header --- */
    .corporate-header { background: #fff; padding: 1.2rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; }
    .corp-logo { display: block; text-decoration: none; }
    .corp-brand { font-size: 1.4rem; font-weight: 700; color: #004aad; letter-spacing: -1px; }
    .corp-nav ul { display: flex; list-style: none; gap: 2rem; margin: 0; padding: 0; }
    .corp-nav ul li a { text-decoration: none; color: #555; font-size: 0.9rem; font-weight: 500; font-family: 'Inter', sans-serif; transition: all 0.2s; border-bottom: 2px solid transparent; padding-bottom: 0.5rem; }
    .corp-nav ul li a:hover { color: #004aad; }
    .corp-nav ul li.active a { color: #004aad; border-bottom: 2px solid #004aad; font-weight: 600; }

    .legal-hero {
        background: linear-gradient(135deg, rgba(0, 74, 173, 0.9) 0%, rgba(0, 49, 130, 0.8) 100%), url('/images/vie_privee.jpg');
        background-size: cover;
        background-position: center;
        padding: 4rem 2rem;
        color: #fff;
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
    .toc-list li a:hover { background: #f0f4ff; color: #004aad; }

    .legal-main { flex: 1; min-width: 0; }

    .legal-intro { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #555; line-height: 1.75; margin-bottom: 2rem; }

    .legal-disclaimer { display: flex; align-items: flex-start; gap: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #004aad; border-radius: 8px; padding: 1.2rem 1.5rem; font-family: 'Inter', sans-serif; font-size: 0.9rem; color: #1e3a6a; line-height: 1.6; margin-bottom: 2rem; }
    .legal-disclaimer i { font-size: 1.2rem; color: #004aad; margin-top: 0.1rem; flex-shrink: 0; }

    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 2rem 2rem 2rem 1.5rem; margin-bottom: 1.2rem; transition: border-color 0.2s, box-shadow 0.2s; }
    .legal-article:hover { border-color: #c7d8f8; box-shadow: 0 4px 16px rgba(0,74,173,0.06); }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #d0ddf5; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.75; margin-bottom: 0.8rem; }
    .article-body ul { padding-left: 1.3rem; margin-bottom: 0.8rem; }
    .article-body li { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.7; margin-bottom: 0.5rem; }
    .article-body a { color: #004aad; text-decoration: none; }
    .article-body a:hover { text-decoration: underline; }

    .legal-contact-strip { display: flex; align-items: center; gap: 1.2rem; background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%); border: 1px solid #c7d8f8; border-radius: 12px; padding: 1.5rem 2rem; margin-top: 2rem; font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #1a1a1a; line-height: 1.6; }
    .legal-contact-strip i { font-size: 1.8rem; color: #004aad; flex-shrink: 0; }
    .legal-contact-strip a { color: #004aad; text-decoration: none; font-weight: 600; }
    .legal-contact-strip a:hover { text-decoration: underline; }

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
                    link.style.background = '#eff6ff';
                    link.style.color = '#004aad';
                    link.style.fontWeight = '600';
                }
            });
        }, { rootMargin: '-20% 0px -70% 0px' });
        articles.forEach(a => observer.observe(a));
    });
</script>
@endsection
