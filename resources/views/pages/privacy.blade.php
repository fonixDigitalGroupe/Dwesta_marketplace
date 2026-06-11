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
        <div class="legal-container">

            <div class="legal-header">
                <h1>Politique de Vie Privée</h1>
                <p class="last-update">Dernière mise à jour : Juin 2025</p>
            </div>

            <div class="legal-body">
                <p>Karnou Group (ci-après « Karnou » ou « Nous ») accorde une importance primordiale à la protection et au respect de votre vie privée. La présente Politique de Vie Privée a pour objet de vous informer sur la manière dont nous collectons, utilisons, partageons et protégeons vos données à caractère personnel lorsque vous utilisez notre Plateforme.</p>
                <p>En utilisant la Plateforme Karnou, vous acceptez les pratiques décrites dans la présente Politique. Si vous n'acceptez pas ces conditions, nous vous invitons à ne pas utiliser nos services.</p>

                <h2>1. Qui est responsable du traitement de vos données ?</h2>
                <p>Le responsable du traitement de vos données personnelles est Karnou Group, société enregistrée en République Centrafricaine, dont le siège social est situé à Bangui. Pour toute question relative à vos données, vous pouvez nous contacter à l'adresse : <strong>privacy@karnou.net</strong></p>

                <h2>2. Quelles données personnelles collectons-nous ?</h2>
                <p>Nous collectons différentes catégories de données personnelles selon votre utilisation de la Plateforme :</p>
                <ul>
                    <li><strong>Données d'identification :</strong> nom, prénom, adresse e-mail, numéro de téléphone, date de naissance.</li>
                    <li><strong>Données de livraison :</strong> adresse postale, ville, pays.</li>
                    <li><strong>Données financières :</strong> mode de paiement utilisé (nous ne stockons jamais les numéros de carte bancaire complets).</li>
                    <li><strong>Données de navigation :</strong> adresse IP, type de navigateur et d'appareil, pages visitées, durée des sessions.</li>
                    <li><strong>Données de transaction :</strong> historique d'achats et de ventes, avis laissés, montants des transactions.</li>
                    <li><strong>Données de communication :</strong> messages échangés via notre messagerie interne, échanges avec notre service client.</li>
                </ul>

                <h2>3. Pourquoi collectons-nous vos données ? (Finalités)</h2>
                <p>Vos données sont collectées et traitées pour les finalités suivantes :</p>
                <ul>
                    <li>Création et gestion de votre compte utilisateur.</li>
                    <li>Traitement et suivi de vos commandes, ainsi que leur livraison via Karnou Express.</li>
                    <li>Sécurisation des transactions et prévention de la fraude.</li>
                    <li>Amélioration de la Plateforme grâce à l'analyse de l'audience et des comportements de navigation.</li>
                    <li>Envoi de communications commerciales et promotionnelles (uniquement avec votre consentement).</li>
                    <li>Respect de nos obligations légales et réglementaires.</li>
                    <li>Résolution des litiges et médiation entre Acheteurs et Vendeurs.</li>
                </ul>

                <h2>4. Base légale du traitement</h2>
                <p>Nous traitons vos données personnelles sur la base des fondements juridiques suivants :</p>
                <ul>
                    <li><strong>L'exécution du contrat :</strong> pour traiter vos commandes et gérer votre compte.</li>
                    <li><strong>Votre consentement :</strong> pour les communications marketing et l'utilisation de certains cookies.</li>
                    <li><strong>Notre intérêt légitime :</strong> pour améliorer nos services, prévenir la fraude et assurer la sécurité de la Plateforme.</li>
                    <li><strong>Le respect d'une obligation légale :</strong> pour la conservation de certaines données à des fins fiscales ou comptables.</li>
                </ul>

                <h2>5. Partage de vos données avec des tiers</h2>
                <p>Karnou ne vend jamais vos données personnelles à des tiers. Nous pouvons cependant les partager dans les cas suivants :</p>
                <ul>
                    <li><strong>Partenaires logistiques :</strong> Karnou Express et tout transporteur tiers pour l'acheminement de vos commandes.</li>
                    <li><strong>Prestataires de paiement :</strong> pour sécuriser et traiter vos transactions financières.</li>
                    <li><strong>Prestataires techniques :</strong> hébergement, analyses, support client, agissant en tant que sous-traitants.</li>
                    <li><strong>Autorités compétentes :</strong> en cas d'obligation légale ou de réquisition judiciaire.</li>
                </ul>

                <h2>6. Durée de conservation des données</h2>
                <p>Vos données personnelles sont conservées pendant la durée nécessaire à l'accomplissement des finalités pour lesquelles elles ont été collectées, et conformément aux obligations légales :</p>
                <ul>
                    <li>Données de compte actif : pendant toute la durée de votre inscription sur la Plateforme.</li>
                    <li>Données de transaction : 5 ans à compter de la transaction, pour des raisons comptables.</li>
                    <li>Données de navigation (cookies) : 13 mois maximum.</li>
                </ul>
                <p>Au-delà de ces durées, vos données sont supprimées ou anonymisées.</p>

                <h2>7. Vos droits sur vos données</h2>
                <p>Conformément à la réglementation applicable sur la protection des données, vous disposez des droits suivants :</p>
                <ul>
                    <li><strong>Droit d'accès :</strong> obtenir une copie de vos données personnelles que nous détenons.</li>
                    <li><strong>Droit de rectification :</strong> corriger toute donnée inexacte ou incomplète.</li>
                    <li><strong>Droit à l'effacement :</strong> demander la suppression de vos données dans les conditions prévues par la loi.</li>
                    <li><strong>Droit d'opposition :</strong> vous opposer au traitement de vos données à des fins de prospection commerciale.</li>
                    <li><strong>Droit à la portabilité :</strong> recevoir vos données dans un format structuré et lisible par machine.</li>
                    <li><strong>Droit de retrait du consentement :</strong> retirer votre consentement à tout moment sans que cela affecte la licéité du traitement antérieur.</li>
                </ul>
                <p>Pour exercer ces droits, connectez-vous à votre espace personnel ou écrivez-nous à <strong>privacy@karnou.net</strong>. Nous nous engageons à répondre à votre demande dans un délai d'un mois.</p>

                <h2>8. Sécurité de vos données</h2>
                <p>Karnou met en œuvre des mesures techniques et organisationnelles appropriées pour protéger vos données contre tout accès non autorisé, toute perte, modification ou divulgation. Parmi ces mesures : chiffrement SSL/TLS de toutes les communications, accès restreint aux données par notre personnel, audits de sécurité réguliers.</p>

                <h2>9. Cookies et traceurs</h2>
                <p>Karnou utilise des cookies et autres traceurs pour améliorer votre expérience sur la Plateforme. Pour en savoir plus sur notre usage des cookies et sur la façon de les gérer, consultez notre <a href="{{ route('cookies') }}">Politique de Gestion des Cookies</a>.</p>

                <h2>10. Modification de la Politique de Vie Privée</h2>
                <p>Karnou se réserve le droit de modifier la présente Politique à tout moment. En cas de modification substantielle, nous vous en informerons par e-mail ou par une notification visible sur la Plateforme. La version en vigueur est celle affichée sur cette page.</p>

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
    .legal-container { max-width: 860px; margin: 0 auto; padding: 0 2rem; }

    .legal-header { margin-bottom: 3rem; padding-bottom: 2rem; border-bottom: 1px solid #eee; }
    .legal-header h1 { font-size: 2rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 0.5rem; letter-spacing: -0.5px; }
    .last-update { font-size: 0.875rem; color: #888; font-family: 'Inter', sans-serif; margin: 0; }

    .legal-body { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #444; line-height: 1.75; }
    .legal-body p { margin-bottom: 1.2rem; }
    .legal-body h2 { font-size: 1.15rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 2.5rem 0 0.8rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0; }
    .legal-body ul { padding-left: 1.5rem; margin-bottom: 1.2rem; }
    .legal-body li { margin-bottom: 0.6rem; }
    .legal-body a { color: #004aad; text-decoration: none; }
    .legal-body a:hover { text-decoration: underline; }

    .header, .top-banner { display: none !important; }

    @media (max-width: 768px) {
        .legal-header h1 { font-size: 1.5rem; }
        .legal-body { font-size: 0.9rem; }
    }
</style>
@endsection
