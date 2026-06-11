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
        <div class="legal-container">

            <div class="legal-header">
                <h1>Conditions Générales d'Utilisation</h1>
                <p class="last-update">Dernière mise à jour : Juin 2025</p>
            </div>

            <div class="legal-body">

                <p>Les présentes Conditions Générales d'Utilisation (ci-après « CGU ») régissent l'accès et l'utilisation du site internet et de l'application mobile Karnou (ci-après « la Plateforme »), exploitée par Karnou Group. En accédant à la Plateforme, l'utilisateur reconnaît avoir lu, compris et accepté sans réserve les présentes CGU.</p>

                <h2>Article 1 – Définitions</h2>
                <p>Dans les présentes CGU, les termes suivants ont la signification suivante :</p>
                <ul>
                    <li><strong>Karnou / Nous :</strong> désigne le groupe Karnou, société de droit centrafricain opérant la Plateforme.</li>
                    <li><strong>Utilisateur :</strong> désigne toute personne physique ou morale accédant à la Plateforme, qu'elle soit Acheteur ou Vendeur.</li>
                    <li><strong>Acheteur :</strong> désigne tout Utilisateur qui effectue ou tente d'effectuer un achat sur la Plateforme.</li>
                    <li><strong>Vendeur :</strong> désigne tout Utilisateur qui publie des annonces et propose des produits à la vente sur la Plateforme.</li>
                    <li><strong>Annonce :</strong> désigne l'offre de vente d'un produit publiée par un Vendeur sur la Plateforme.</li>
                    <li><strong>Transaction :</strong> désigne l'ensemble des opérations réalisées entre un Acheteur et un Vendeur via la Plateforme.</li>
                </ul>

                <h2>Article 2 – Objet et Acceptation des CGU</h2>
                <p>Les présentes CGU ont pour objet de définir les conditions d'accès et d'utilisation de la Plateforme ainsi que les droits et obligations des Utilisateurs. Karnou se réserve le droit de modifier les présentes CGU à tout moment. Les modifications entreront en vigueur dès leur publication sur la Plateforme. Il appartient à l'Utilisateur de consulter régulièrement les CGU.</p>

                <h2>Article 3 – Accès à la Plateforme et Création de Compte</h2>
                <p>L'accès à la Plateforme est gratuit pour tout Utilisateur disposant d'un accès à internet. Toutefois, certaines fonctionnalités (achat, vente, messagerie) nécessitent la création d'un compte personnel. L'Utilisateur s'engage à :</p>
                <ul>
                    <li>Fournir des informations exactes, complètes et à jour lors de son inscription.</li>
                    <li>Maintenir la confidentialité de ses identifiants de connexion (identifiant et mot de passe).</li>
                    <li>Informer Karnou immédiatement en cas d'utilisation non autorisée de son compte.</li>
                    <li>Ne pas créer plusieurs comptes ou utiliser le compte d'un tiers.</li>
                </ul>
                <p>Karnou se réserve le droit de suspendre ou de supprimer tout compte en cas de violation des présentes CGU ou de suspicion de fraude.</p>

                <h2>Article 4 – Rôle de Karnou et Responsabilité</h2>
                <p>Karnou agit en qualité d'intermédiaire entre les Acheteurs et les Vendeurs. À ce titre, Karnou n'est pas vendeur des produits listés sur la Plateforme et ne peut être tenu responsable des informations communiquées par les Vendeurs, de la qualité ou de la conformité des produits vendus, ni de l'exécution des Transactions. Cependant, Karnou met à disposition des Utilisateurs un service client et un système de médiation pour faciliter la résolution des litiges.</p>

                <h2>Article 5 – Publication des Annonces</h2>
                <p>Tout Vendeur est seul responsable du contenu de ses Annonces. Sont strictement interdites les annonces relatives à :</p>
                <ul>
                    <li>Des produits illicites ou dont la vente est réglementée (armes, substances contrôlées, etc.).</li>
                    <li>Des produits contrefaits ou portant atteinte aux droits de propriété intellectuelle de tiers.</li>
                    <li>Des produits dangereux pour la santé ou la sécurité des personnes.</li>
                    <li>Des denrées alimentaires ou médicaments sans les autorisations requises.</li>
                </ul>
                <p>Karnou se réserve le droit de supprimer toute Annonce non conforme aux présentes CGU sans préavis ni indemnité.</p>

                <h2>Article 6 – Transactions et Paiements</h2>
                <p>Les Transactions réalisées sur la Plateforme sont soumises aux conditions suivantes :</p>
                <ul>
                    <li>Le prix d'un produit est celui indiqué dans l'Annonce au moment de la commande, hors frais de livraison.</li>
                    <li>Le paiement est encaissé par Karnou pour le compte du Vendeur et est conservé en séquestre jusqu'à la bonne réception du produit par l'Acheteur.</li>
                    <li>La vente est finalisée lorsque l'Acheteur confirme la bonne réception du produit ou à l'expiration du délai de réclamation.</li>
                </ul>

                <h2>Article 7 – Livraison et Karnou Express</h2>
                <p>Les délais et frais de livraison sont indiqués dans chaque Annonce. Karnou met à disposition son service de livraison intégré, Karnou Express, permettant de suivre les colis en temps réel. En cas de retard ou de perte de colis, l'Acheteur doit contacter le service client Karnou dans un délai maximal de 30 jours suivant la date de livraison estimée.</p>

                <h2>Article 8 – Droit de Rétractation et Retours</h2>
                <p>Conformément aux dispositions légales en vigueur, tout Acheteur particulier bénéficie d'un droit de rétractation de 14 jours à compter de la réception de son colis, sans avoir à justifier de motifs ni à payer de pénalités. Pour exercer ce droit, l'Acheteur doit notifier sa décision au Vendeur via la messagerie de la Plateforme. Les frais de retour sont à la charge de l'Acheteur, sauf si le Vendeur a accepté de les prendre en charge.</p>

                <h2>Article 9 – Propriété Intellectuelle</h2>
                <p>L'ensemble des contenus de la Plateforme (textes, images, logos, graphismes, logiciels) est protégé par la législation sur la propriété intellectuelle. Toute reproduction, représentation, modification ou exploitation, totale ou partielle, sans le consentement préalable et écrit de Karnou est strictement interdite.</p>

                <h2>Article 10 – Comportements Interdits</h2>
                <p>Sont strictement prohibés sur la Plateforme :</p>
                <ul>
                    <li>Toute tentative de contournement des systèmes de paiement de la Plateforme.</li>
                    <li>Le harcèlement, les menaces ou insultes envers un autre Utilisateur.</li>
                    <li>La publication de faux avis ou de commentaires frauduleux.</li>
                    <li>La collecte de données personnelles d'autres Utilisateurs sans leur consentement.</li>
                    <li>L'utilisation de robots ou de tout autre procédé automatisé pour accéder à la Plateforme.</li>
                </ul>

                <h2>Article 11 – Résiliation et Suspension</h2>
                <p>Karnou se réserve le droit de suspendre ou résoudre, de plein droit et sans préavis, le compte d'un Utilisateur en cas de manquement grave aux présentes CGU. L'Utilisateur peut également demander la clôture de son compte à tout moment depuis les paramètres de son profil ou en contactant le service client.</p>

                <h2>Article 12 – Loi Applicable et Juridiction Compétente</h2>
                <p>Les présentes CGU sont régies par le droit applicable dans le pays de siège social de Karnou Group. Tout litige relatif à leur interprétation ou à leur exécution, qui n'aurait pas pu être résolu à l'amiable, sera soumis à la juridiction compétente.</p>

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
    .corp-nav ul li a { text-decoration: none; color: #333; font-size: 0.9rem; font-weight: 400; padding: 1rem 0; font-family: 'Inter', sans-serif; }
    .corp-nav ul li.active a { background: #004aad; color: #fff; padding: 1rem 1.4rem; border-radius: 4px; }

    .about-sub-nav { background: #fff; border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 100; padding: 1.2rem 0; box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05); }
    .about-sub-nav .about-container { display: flex; justify-content: center; align-items: center; }
    .sub-nav-list { display: flex; list-style: none; gap: 2.5rem; margin: 0; padding: 0; }
    .sub-nav-list li a { text-decoration: none; color: #333; font-size: 0.9rem; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; font-family: 'Inter', sans-serif; }
    .sub-nav-list li.active a { border-bottom: 2px solid #004aad; font-weight: 600; }

    /* Legal Layout */
    .legal-content { padding: 4rem 0 6rem; }

    .legal-container {
        max-width: 860px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .legal-header {
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #eee;
    }

    .legal-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        font-family: 'Outfit', 'Inter', sans-serif;
        margin: 0 0 0.5rem;
        letter-spacing: -0.5px;
    }

    .last-update {
        font-size: 0.875rem;
        color: #888;
        font-family: 'Inter', sans-serif;
        margin: 0;
    }

    .legal-body {
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: #444;
        line-height: 1.75;
    }

    .legal-body p {
        margin-bottom: 1.2rem;
    }

    .legal-body h2 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a1a1a;
        font-family: 'Outfit', 'Inter', sans-serif;
        margin: 2.5rem 0 0.8rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .legal-body ul {
        padding-left: 1.5rem;
        margin-bottom: 1.2rem;
    }

    .legal-body li {
        margin-bottom: 0.6rem;
    }

    .header, .top-banner { display: none !important; }

    @media (max-width: 768px) {
        .legal-header h1 { font-size: 1.5rem; }
        .legal-body { font-size: 0.9rem; }
    }
</style>
@endsection
