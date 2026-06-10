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
    <section class="about-hero" id="apropos">
        <div class="hero-overlay"></div>
        <div class="hero-container">
            <h1>Karnou,<br>groupe d'innovation digitale<br>au service de la société</h1>
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
                    <div class="ecosystem-drawing">
                        <div class="core-node">
                            <span class="core-text">Karnou</span>
                        </div>
                        <div class="satellites">
                            <div class="satellite-node node-acheteurs">
                                <div class="node-icon"><i class="fa-solid fa-users"></i></div>
                                <span class="node-label">Acheteurs</span>
                            </div>
                            <div class="satellite-node node-vendeurs">
                                <div class="node-icon"><i class="fa-solid fa-store"></i></div>
                                <span class="node-label">Vendeurs</span>
                            </div>
                            <div class="satellite-node node-express">
                                <div class="node-icon"><i class="fa-solid fa-truck-fast"></i></div>
                                <span class="node-label">Express</span>
                            </div>
                            <div class="satellite-node node-agence">
                                <div class="node-icon"><i class="fa-solid fa-building-user"></i></div>
                                <span class="node-label">Agence</span>
                            </div>
                            <div class="satellite-node node-vente">
                                <div class="node-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                                <span class="node-label">Vente</span>
                            </div>
                        </div>
                        <svg class="connections-svg" viewBox="0 0 500 500">
                            <line class="conn-line" x1="250" y1="250" x2="100" y2="150" />
                            <line class="conn-line" x1="250" y1="250" x2="400" y2="150" />
                            <line class="conn-line" x1="250" y1="250" x2="100" y2="350" />
                            <line class="conn-line" x1="250" y1="250" x2="400" y2="350" />
                            <line class="conn-line" x1="250" y1="250" x2="250" y2="80" />
                        </svg>
                    </div>
                </div>
                <div class="diagram-right">
                    <div class="ecosystem-text">
                        <p>Karnou se compose de multiples entités, soit autant d'expertises qui positionnent le groupe comme un acteur incontournable de la scène tech africaine :</p>
                        <ul>
                            <li><strong>Karnou Agence :</strong> Notre réseau de points de retrait pour une proximité maximale avec nos utilisateurs.</li>
                            <li><strong>Karnou Express :</strong> Société de livraison de colis innovante qui permet à chacun de devenir livreur et de gagner des commissions.</li>
                            <li><strong>Vente sur Karnou :</strong> Une plateforme ouverte permettant de vendre des produits en tant que vendeur particulier ou professionnel en toute simplicité.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Global Footprint Section -->
    <section class="about-footprint">
        <div class="about-container">
            <div class="section-header">
                <h2>Une empreinte <strong>mondiale</strong></h2>
                <div class="header-line"></div>
            </div>

            <div class="footprint-map-wrapper">
                <div class="dot-map-bg">
                    <!-- Dots will be generated by CSS pattern or simplified SVG -->
                    <svg class="world-dots" viewBox="0 0 1000 500" preserveAspectRatio="xMidYMid slice">
                        <defs>
                            <pattern id="dotPattern" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="1.5" fill="#e0e0e0" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#dotPattern)" />
                    </svg>
                </div>

                <div class="country-markers">
                    @php
                        $coordinates = [
                            'AF' => ['top' => '50%', 'left' => '65%'],
                            'AL' => ['top' => '41%', 'left' => '52%'],
                            'DZ' => ['top' => '52%', 'left' => '48%'],
                            'AD' => ['top' => '42%', 'left' => '48%'],
                            'AO' => ['top' => '68%', 'left' => '53%'],
                            'AR' => ['top' => '85%', 'left' => '32%'],
                            'AM' => ['top' => '45%', 'left' => '60%'],
                            'AU' => ['top' => '80%', 'left' => '85%'],
                            'AT' => ['top' => '38%', 'left' => '52%'],
                            'AZ' => ['top' => '43%', 'left' => '62%'],
                            'BS' => ['top' => '45%', 'left' => '28%'],
                            'BH' => ['top' => '55%', 'left' => '65%'],
                            'BD' => ['top' => '55%', 'left' => '72%'],
                            'BB' => ['top' => '50%', 'left' => '32%'],
                            'BY' => ['top' => '32%', 'left' => '55%'],
                            'BE' => ['top' => '40%', 'left' => '50%'],
                            'BZ' => ['top' => '50%', 'left' => '22%'],
                            'BJ' => ['top' => '58%', 'left' => '50%'],
                            'BT' => ['top' => '50%', 'left' => '75%'],
                            'BO' => ['top' => '70%', 'left' => '30%'],
                            'BA' => ['top' => '42%', 'left' => '52%'],
                            'BW' => ['top' => '75%', 'left' => '55%'],
                            'BR' => ['top' => '70%', 'left' => '35%'],
                            'BN' => ['top' => '60%', 'left' => '80%'],
                            'BG' => ['top' => '41%', 'left' => '55%'],
                            'BF' => ['top' => '56%', 'left' => '49%'],
                            'BI' => ['top' => '65%', 'left' => '56%'],
                            'CV' => ['top' => '55%', 'left' => '40%'],
                            'KH' => ['top' => '62%', 'left' => '78%'],
                            'CM' => ['top' => '60%', 'left' => '52%'],
                            'CA' => ['top' => '30%', 'left' => '20%'],
                            'CF' => ['top' => '58%', 'left' => '55%'],
                            'TD' => ['top' => '55%', 'left' => '54%'],
                            'CL' => ['top' => '80%', 'left' => '28%'],
                            'CN' => ['top' => '45%', 'left' => '75%'],
                            'CO' => ['top' => '58%', 'left' => '27%'],
                            'KM' => ['top' => '68%', 'left' => '60%'],
                            'CG' => ['top' => '65%', 'left' => '52%'],
                            'CD' => ['top' => '65%', 'left' => '54%'],
                            'CR' => ['top' => '53%', 'left' => '24%'],
                            'CI' => ['top' => '58%', 'left' => '47%'],
                            'HR' => ['top' => '41%', 'left' => '51%'],
                            'CU' => ['top' => '46%', 'left' => '26%'],
                            'CY' => ['top' => '50%', 'left' => '60%'],
                            'CZ' => ['top' => '39%', 'left' => '53%'],
                            'DK' => ['top' => '32%', 'left' => '51%'],
                            'DJ' => ['top' => '58%', 'left' => '62%'],
                            'DM' => ['top' => '50%', 'left' => '32%'],
                            'DO' => ['top' => '47%', 'left' => '30%'],
                            'EC' => ['top' => '60%', 'left' => '26%'],
                            'EG' => ['top' => '50%', 'left' => '57%'],
                            'SV' => ['top' => '52%', 'left' => '23%'],
                            'GQ' => ['top' => '62%', 'left' => '51%'],
                            'ER' => ['top' => '56%', 'left' => '60%'],
                            'EE' => ['top' => '30%', 'left' => '55%'],
                            'SZ' => ['top' => '78%', 'left' => '57%'],
                            'ET' => ['top' => '60%', 'left' => '59%'],
                            'FJ' => ['top' => '75%', 'left' => '95%'],
                            'FI' => ['top' => '25%', 'left' => '55%'],
                            'FR' => ['top' => '42%', 'left' => '49%'],
                            'GA' => ['top' => '64%', 'left' => '51%'],
                            'GM' => ['top' => '56%', 'left' => '45%'],
                            'GE' => ['top' => '42%', 'left' => '60%'],
                            'DE' => ['top' => '38%', 'left' => '51%'],
                            'GH' => ['top' => '58%', 'left' => '49%'],
                            'GR' => ['top' => '44%', 'left' => '54%'],
                            'GD' => ['top' => '52%', 'left' => '32%'],
                            'GT' => ['top' => '52%', 'left' => '22%'],
                            'GN' => ['top' => '56%', 'left' => '46%'],
                            'GW' => ['top' => '56%', 'left' => '45%'],
                            'GY' => ['top' => '55%', 'left' => '33%'],
                            'HT' => ['top' => '47%', 'left' => '29%'],
                            'HN' => ['top' => '51%', 'left' => '23%'],
                            'HU' => ['top' => '40%', 'left' => '53%'],
                            'IS' => ['top' => '25%', 'left' => '42%'],
                            'IN' => ['top' => '52%', 'left' => '68%'],
                            'ID' => ['top' => '65%', 'left' => '80%'],
                            'IR' => ['top' => '48%', 'left' => '62%'],
                            'IQ' => ['top' => '48%', 'left' => '60%'],
                            'IE' => ['top' => '38%', 'left' => '47%'],
                            'IL' => ['top' => '50%', 'left' => '58%'],
                            'IT' => ['top' => '43%', 'left' => '51%'],
                            'JM' => ['top' => '48%', 'left' => '27%'],
                            'JP' => ['top' => '45%', 'left' => '85%'],
                            'JO' => ['top' => '50%', 'left' => '59%'],
                            'KZ' => ['top' => '38%', 'left' => '65%'],
                            'KE' => ['top' => '63%', 'left' => '58%'],
                            'KI' => ['top' => '60%', 'left' => '98%'],
                            'KP' => ['top' => '42%', 'left' => '81%'],
                            'KR' => ['top' => '43%', 'left' => '82%'],
                            'KW' => ['top' => '52%', 'left' => '62%'],
                            'KG' => ['top' => '41%', 'left' => '67%'],
                            'LA' => ['top' => '58%', 'left' => '77%'],
                            'LV' => ['top' => '32%', 'left' => '55%'],
                            'LB' => ['top' => '50%', 'left' => '59%'],
                            'LS' => ['top' => '82%', 'left' => '56%'],
                            'LR' => ['top' => '60%', 'left' => '46%'],
                            'LY' => ['top' => '52%', 'left' => '53%'],
                            'LI' => ['top' => '40%', 'left' => '51%'],
                            'LT' => ['top' => '32%', 'left' => '54%'],
                            'LU' => ['top' => '40%', 'left' => '51%'],
                            'MG' => ['top' => '75%', 'left' => '63%'],
                            'MW' => ['top' => '70%', 'left' => '58%'],
                            'MY' => ['top' => '62%', 'left' => '76%'],
                            'MV' => ['top' => '63%', 'left' => '67%'],
                            'ML' => ['top' => '54%', 'left' => '49%'],
                            'MT' => ['top' => '46%', 'left' => '51%'],
                            'MH' => ['top' => '55%', 'left' => '95%'],
                            'MQ' => ['top' => '51%', 'left' => '33%'],
                            'MR' => ['top' => '53%', 'left' => '45%'],
                            'MU' => ['top' => '76%', 'left' => '65%'],
                            'MX' => ['top' => '50%', 'left' => '20%'],
                            'FM' => ['top' => '58%', 'left' => '90%'],
                            'MD' => ['top' => '38%', 'left' => '56%'],
                            'MC' => ['top' => '42%', 'left' => '50%'],
                            'MN' => ['top' => '38%', 'left' => '75%'],
                            'ME' => ['top' => '42%', 'left' => '52%'],
                            'MA' => ['top' => '50%', 'left' => '46%'],
                            'MZ' => ['top' => '73%', 'left' => '59%'],
                            'MM' => ['top' => '54%', 'left' => '73%'],
                            'NA' => ['top' => '75%', 'left' => '53%'],
                            'NR' => ['top' => '60%', 'left' => '96%'],
                            'NP' => ['top' => '48%', 'left' => '70%'],
                            'NL' => ['top' => '38%', 'left' => '50%'],
                            'NZ' => ['top' => '88%', 'left' => '90%'],
                            'NI' => ['top' => '52%', 'left' => '23%'],
                            'NE' => ['top' => '54%', 'left' => '52%'],
                            'NG' => ['top' => '58%', 'left' => '51%'],
                            'MK' => ['top' => '42%', 'left' => '53%'],
                            'NO' => ['top' => '25%', 'left' => '51%'],
                            'OM' => ['top' => '56%', 'left' => '65%'],
                            'PK' => ['top' => '50%', 'left' => '67%'],
                            'PW' => ['top' => '60%', 'left' => '86%'],
                            'PA' => ['top' => '55%', 'left' => '26%'],
                            'PG' => ['top' => '65%', 'left' => '88%'],
                            'PY' => ['top' => '75%', 'left' => '33%'],
                            'PE' => ['top' => '68%', 'left' => '28%'],
                            'PH' => ['top' => '57%', 'left' => '83%'],
                            'PL' => ['top' => '36%', 'left' => '54%'],
                            'PT' => ['top' => '44%', 'left' => '46%'],
                            'QA' => ['top' => '54%', 'left' => '63%'],
                            'RE' => ['top' => '76%', 'left' => '64%'],
                            'RO' => ['top' => '40%', 'left' => '55%'],
                            'RU' => ['top' => '30%', 'left' => '70%'],
                            'RW' => ['top' => '65%', 'left' => '56%'],
                            'KN' => ['top' => '50%', 'left' => '32%'],
                            'LC' => ['top' => '50%', 'left' => '32%'],
                            'VC' => ['top' => '50%', 'left' => '32%'],
                            'WS' => ['top' => '70%', 'left' => '98%'],
                            'SM' => ['top' => '42%', 'left' => '51%'],
                            'ST' => ['top' => '62%', 'left' => '49%'],
                            'SA' => ['top' => '54%', 'left' => '60%'],
                            'SN' => ['top' => '55%', 'left' => '45%'],
                            'RS' => ['top' => '41%', 'left' => '53%'],
                            'SC' => ['top' => '67%', 'left' => '65%'],
                            'SL' => ['top' => '58%', 'left' => '46%'],
                            'SG' => ['top' => '65%', 'left' => '77%'],
                            'SK' => ['top' => '39%', 'left' => '54%'],
                            'SI' => ['top' => '41%', 'left' => '51%'],
                            'SB' => ['top' => '68%', 'left' => '92%'],
                            'SO' => ['top' => '60%', 'left' => '62%'],
                            'ZA' => ['top' => '82%', 'left' => '55%'],
                            'SS' => ['top' => '58%', 'left' => '57%'],
                            'ES' => ['top' => '45%', 'left' => '48%'],
                            'LK' => ['top' => '60%', 'left' => '70%'],
                            'SD' => ['top' => '54%', 'left' => '56%'],
                            'SR' => ['top' => '56%', 'left' => '33%'],
                            'SE' => ['top' => '28%', 'left' => '53%'],
                            'CH' => ['top' => '41%', 'left' => '50%'],
                            'SY' => ['top' => '48%', 'left' => '59%'],
                            'TW' => ['top' => '52%', 'left' => '82%'],
                            'TJ' => ['top' => '42%', 'left' => '66%'],
                            'TZ' => ['top' => '66%', 'left' => '58%'],
                            'TH' => ['top' => '58%', 'left' => '75%'],
                            'TL' => ['top' => '65%', 'left' => '83%'],
                            'TG' => ['top' => '59%', 'left' => '50%'],
                            'TK' => ['top' => '65%', 'left' => '98%'],
                            'TO' => ['top' => '75%', 'left' => '98%'],
                            'TT' => ['top' => '53%', 'left' => '32%'],
                            'TN' => ['top' => '48%', 'left' => '51%'],
                            'TR' => ['top' => '44%', 'left' => '58%'],
                            'TM' => ['top' => '44%', 'left' => '64%'],
                            'TV' => ['top' => '65%', 'left' => '98%'],
                            'UG' => ['top' => '62%', 'left' => '57%'],
                            'UA' => ['top' => '35%', 'left' => '57%'],
                            'AE' => ['top' => '56%', 'left' => '63%'],
                            'GB' => ['top' => '36%', 'left' => '48%'],
                            'US' => ['top' => '40%', 'left' => '18%'],
                            'UY' => ['top' => '82%', 'left' => '34%'],
                            'UZ' => ['top' => '41%', 'left' => '65%'],
                            'VU' => ['top' => '74%', 'left' => '93%'],
                            'VE' => ['top' => '55%', 'left' => '29%'],
                            'VN' => ['top' => '56%', 'left' => '79%'],
                            'EH' => ['top' => '53%', 'left' => '45%'],
                            'YE' => ['top' => '58%', 'left' => '62%'],
                            'ZM' => ['top' => '70%', 'left' => '56%'],
                            'ZW' => ['top' => '75%', 'left' => '56%'],
                        ];
                    @endphp

                    @if(isset($countries) && $countries->count() > 0)
                        @foreach($countries as $country)
                            @php
                                $pos = $coordinates[strtoupper($country->code)] ?? ['top' => '50%', 'left' => '50%'];
                            @endphp
                            <div class="marker-container" style="top: {{ $pos['top'] }}; left: {{ $pos['left'] }};">
                                <div class="marker-dot"></div>
                                <div class="marker-info">
                                    @if($country->flag)
                                        <img src="{{ $country->flag }}" class="marker-flag" alt="{{ $country->name }}">
                                    @endif
                                    <span class="marker-name">{{ $country->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback for Centrafrique if DB is empty or missing during demo -->
                        <div class="marker-container" style="top: 58%; left: 55%;">
                            <div class="marker-dot"></div>
                            <div class="marker-info">
                                <img src="/images/flags/cf.png" class="marker-flag" alt="Centrafrique" onerror="this.style.display='none'">
                                <span class="marker-name">République Centrafricaine</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Founder Quote Section -->
    <section class="about-founder-quote">
        <div class="about-container">
            <div class="quote-flex">
                <div class="quote-image">
                    <img src="/images/founder_karnou.png" alt="Jean-Pierre Karnou">
                </div>
                <div class="quote-box">
                    <div class="quote-icon">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <blockquote class="quote-text">
                        "Nous continuons de croire que le monde numérique a le potentiel d'améliorer la vie de nous tous. Oubliez la peur. Adoptez l'optimisme."
                    </blockquote>
                    <cite class="quote-author">
                        Jean-Pierre Karnou – <span>Fondateur et CEO de Karnou Group</span>
                    </cite>
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
        padding: 5rem 0 8rem;
        background: #fff; /* White background as requested */
    }

    .diagram-wrapper {
        display: flex;
        align-items: center;
        gap: 5rem;
        margin-top: 4rem;
    }

    .diagram-left {
        flex: 1.2;
        display: flex;
        justify-content: center;
        min-height: 500px;
        position: relative;
    }

    .ecosystem-drawing {
        position: relative;
        width: 100%;
        max-width: 500px;
        height: 500px;
        background: #fff;
    }

    .core-node {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #004aad 0%, #003a88 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
    }

    .core-text {
        color: #fff;
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: 1px;
    }

    .satellite-node {
        position: absolute;
        width: 80px;
        height: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 4;
    }

    .satellite-node:hover {
        opacity: 0.9;
    }

    .node-icon {
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        border: 1px solid #eee;
    }

    .node-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        white-space: nowrap;
    }

    /* Node Positions */
    .node-acheteurs { top: 15%; left: 10%; }
    .node-vendeurs { top: 15%; right: 10%; }
    .node-express { bottom: 15%; left: 10%; }
    .node-agence { bottom: 15%; right: 10%; }
    .node-vente { top: 0%; left: 50%; transform: translateX(-50%); }

    /* Colors Mixing - Gray for satellites, Blue for core */
    .node-acheteurs .node-icon { color: #888; }
    .node-vendeurs .node-icon { color: #888; } 
    .node-express .node-icon { color: #888; }
    .node-agence .node-icon { color: #888; }
    .node-vente .node-icon { color: #888; }

    .connections-svg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .conn-line {
        stroke: #e0e6ed;
        stroke-width: 2;
        stroke-dasharray: 5;
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
        font-size: 2rem;
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
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .corp-header-flex {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 3rem; /* Reduced from 5rem to shift menu left */
    }

    .corp-brand {
        font-size: 1.4rem;
        font-weight: 700; /* Reduced from 800 */
        color: #004aad; /* Brand Blue */
        letter-spacing: -1px;
        text-decoration: none;
        padding: 1rem 0;
        margin-left: 2rem;
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
        font-weight: 400; /* Reduced from 500 */
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
        font-weight: 400; /* Also reduced here */
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
        padding: 1.2rem 0;
        box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05);
        font-family: 'Inter', sans-serif;
    }

    .about-sub-nav .about-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1.5rem;
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
        font-weight: 400; /* Reduced from 500 */
        transition: all 0.2s;
        padding-bottom: 0.3rem;
        border-bottom: 2px solid transparent;
    }

    .sub-nav-list li.active a,
    .sub-nav-list li a:hover {
        color: #333;
    }

    .sub-nav-list li.active a {
        border-bottom: 2px solid #004aad; /* Brand Blue */
        box-shadow: none;
        font-weight: 400; /* Reduced from 500 */
    }

    .sub-nav-search {
        color: #004aad; /* Brand Blue */
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    /* Hero Section */
    .about-hero {
        height: 400px;
        background: url('/images/about_hero_final.png') center/cover no-repeat;
        display: flex;
        align-items: center;
        position: relative;
        margin: 2rem 5rem;
        border-radius: 12px;
        overflow: hidden;
    }

    .hero-container {
        padding: 0 4rem; /* Aligned left with padding */
        z-index: 2;
        width: 100%;
    }

    .about-hero h1 {
        color: #fff;
        font-size: 3rem;
        font-weight: 400; /* Removed bold */
        line-height: 1.2;
        max-width: 600px; /* Constrain width to force 3 lines */
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
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
        background: #004aad; /* Changed from red to blue as requested */
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

    /* Footprint Section */
    .about-footprint {
        padding: 6rem 0;
        background: #fdfdfd;
        overflow: hidden;
    }

    .footprint-map-wrapper {
        position: relative;
        width: 100%;
        max-width: 1000px;
        margin: 4rem auto 0;
        aspect-ratio: 2 / 1;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 2rem;
    }

    .dot-map-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.5;
    }

    .world-dots {
        width: 100%;
        height: 100%;
    }

    .country-markers {
        position: relative;
        width: 100%;
        height: 100%;
        z-index: 2;
    }

    .marker-container {
        position: absolute;
        transform: translate(-50%, -50%);
        cursor: pointer;
        z-index: 5;
    }

    .marker-dot {
        width: 12px;
        height: 12px;
        background: #004aad;
        border: 2px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0,74,173,0.5);
        transition: transform 0.3s ease;
    }

    .marker-container:hover .marker-dot {
        transform: scale(1.5);
    }

    .marker-info {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-10px);
        background: #fff;
        padding: 0.6rem 1rem;
        border-radius: 8px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 0.8rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .marker-container:hover .marker-info {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(-20px);
    }

    .marker-flag {
        width: 20px;
        height: 15px;
        object-fit: cover;
        border-radius: 2px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .marker-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    /* Founder Quote Section */
    .about-founder-quote {
        padding: 6rem 0 10rem;
        background: #fff;
    }

    .quote-flex {
        display: flex;
        align-items: stretch;
        max-width: 1000px;
        margin: 0 auto;
    }

    .quote-image {
        flex: 1;
        position: relative;
        overflow: hidden;
    }

    .quote-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transform: perspective(1000px) rotateY(-5deg);
        box-shadow: 20px 0 40px rgba(0,0,0,0.1);
    }

    .quote-box {
        flex: 1;
        background: #fff;
        padding: 4rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        margin-left: -50px;
        z-index: 2;
    }

    .quote-icon {
        font-size: 4rem;
        color: #eee;
        line-height: 1;
        margin-bottom: 1.5rem;
    }

    .quote-text {
        font-size: 1.5rem;
        font-weight: 400;
        line-height: 1.5;
        color: #333;
        font-family: 'Outfit', sans-serif;
        margin: 0 0 2rem;
        font-style: normal;
    }

    .quote-author {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        font-style: normal;
    }

    .quote-author span {
        font-weight: 400;
        color: #666;
    }

    @media (max-width: 768px) {
        .about-founder-quote { padding: 4rem 0; }
        .quote-flex { flex-direction: column; }
        .quote-box { margin-left: 0; margin-top: -30px; padding: 3rem 2rem; }
        .quote-text { font-size: 1.25rem; }
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
