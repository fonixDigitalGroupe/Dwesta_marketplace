<footer class="rk-footer">
    <!-- Tier 1: Réassurance -->
    <div class="footer-reinsurance">
        <div class="footer-container">
            <div class="reinsurance-grid">
                <a href="{{ route('le-choix') }}" class="reinsurance-item" style="text-decoration: none;">
                    <div class="reinsurance-icon-box"><i class="fa-solid fa-layer-group"></i></div>
                    <div class="reinsurance-text">
                        <span class="reinsurance-label">Le choix</span>
                        <span class="reinsurance-value">Neuf et occasion</span>
                    </div>
                </a>
                <a href="{{ route('la-securite') }}" class="reinsurance-item" style="text-decoration: none;">
                    <div class="reinsurance-icon-box"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="reinsurance-text">
                        <span class="reinsurance-label">La sécurité</span>
                        <span class="reinsurance-value">Satisfait ou remboursé</span>
                    </div>
                </a>
                <a href="{{ route('service-clients') }}" class="reinsurance-item" style="text-decoration: none;">
                    <div class="reinsurance-icon-box"><i class="fa-solid fa-headset"></i></div>
                    <div class="reinsurance-text">
                        <span class="reinsurance-label">Le service clients</span>
                        <span class="reinsurance-value">À votre écoute</span>
                    </div>
                </a>
                <a href="{{ route('expedition') }}" class="reinsurance-item" style="text-decoration: none;">
                    <div class="reinsurance-icon-box"><i class="fa-solid fa-truck-fast"></i></div>
                    <div class="reinsurance-text">
                        <span class="reinsurance-label">L'expédition</span>
                        <span class="reinsurance-value">Livraison rapide</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Tier 2: Main Links -->
    <div class="footer-main">
        <div class="footer-container">
            <div class="footer-links-grid">
                <div class="footer-links-col">
                    <h4 class="footer-col-title">LIENS UTILES</h4>
                    <ul class="footer-links-list">
                        <li><a href="#">Mon compte</a></li>
                        <li><a href="#">Mon panier</a></li>
                        <li><a href="#">Vendre</a></li>
                        <li><a href="#">Suivre ma commande</a></li>
                    </ul>
                </div>
                <div class="footer-separator"></div>
                <div class="footer-links-col">
                    <h4 class="footer-col-title">AIDE & CONTACT</h4>
                    <ul class="footer-links-list">
                        <li><a href="{{ route('help') }}">Besoin d'aide ?</a></li>
                        <li><a href="{{ route('contact') }}">Nous contacter</a></li>
                        <li><a href="{{ route('report') }}">Signaler un contenu</a></li>
                        <li><a href="{{ route('eshop.landing') }}">Ouvrir un e-shop</a></li>
                    </ul>
                </div>
                <div class="footer-separator"></div>
                <div class="footer-links-col">
                    <h4 class="footer-col-title">KARNOU</h4>
                    <ul class="footer-links-list">
                        <li><a href="{{ route('about') }}">À propos de Karnou</a></li>
                        <li><a href="{{ route('terms') }}">Conditions générales</a></li>
                        <li><a href="{{ route('privacy') }}">Vie privée</a></li>
                        <li><a href="{{ route('cookies') }}">Gestion des cookies</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tier 3: Social & Payment -->
    <div class="footer-connections">
        <div class="footer-container">
            <div class="connections-wrapper">
                <div class="social-box">
                    <a href="#" class="soc-link linkedin"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="soc-link facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="soc-link instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="soc-link youtube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="soc-link tiktok"><i class="fab fa-tiktok"></i></a>
                </div>

            </div>
        </div>
    </div>



    <!-- Tier 5: Bottom Branding -->
    <div class="footer-brand-section">
        <div class="footer-container">
            <div class="brand-flex">
                <div class="brand-logo-final"></div>
                <div class="brand-links-final">
                    <a href="#">Karnou Agence</a>
                    <a href="#">Karnou Express</a>
                    <a href="{{ route('about') }}">À propos de Karnou</a>
                </div>
                <div class="region-dropdown"></div>
            </div>
            <div class="footer-copyright-final">
                © 2024 - 2026
            </div>
        </div>
    </div>
</footer>

<style>
    .rk-footer {
        background: #fff;
        font-family: 'Outfit', sans-serif;
        color: #1a1a1a;
        border-top: 1px solid #eee;
    }

    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Tier 1: Réassurance */
    .footer-reinsurance {
        background: #f3f4f6;
        padding: 2rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .reinsurance-grid {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .reinsurance-item {
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }

    .reinsurance-icon-box {
        font-size: 2rem;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
    }

    .reinsurance-text {
        display: flex;
        flex-direction: column;
    }

    .reinsurance-label {
        font-size: 0.75rem;
        color: #555;
        margin-bottom: 2px;
        font-weight: 500;
        text-transform: uppercase;
    }

    .reinsurance-value {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a1a;
        white-space: nowrap;
    }

    /* Tier 2: Main Links */
    .footer-main {
        background: #f9fafb;
        padding: 5rem 0;
        border-bottom: 1px solid #eee;
    }

    .footer-links-grid {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .footer-links-col {
        flex: 1;
    }

    .footer-separator {
        width: 1px;
        height: 150px;
        background: #eee;
        margin: 0 2rem;
    }

    .footer-col-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #111;
        margin-bottom: 2rem;
        letter-spacing: 0.5px;
    }

    .footer-links-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links-list li {
        margin-bottom: 1rem;
    }

    .footer-links-list li a {
        text-decoration: none;
        color: #1a1a1a;
        font-size: 0.95rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .footer-links-list li a:hover {
        color: #004aad;
    }

    /* New Redesigned Tiers */
    .footer-connections {
        border-top: 1px solid #eee;
        padding: 1.5rem 0;
        background: #fff;
    }

    .connections-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 3rem;
    }

    .social-box {
        display: flex;
        gap: 1.5rem;
    }

    .soc-link {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        font-size: 1.1rem;
        transition: transform 0.2s;
    }

    .soc-link:hover {
        transform: scale(1.1);
    }

    .soc-link.linkedin {
        background: #0077b5;
    }

    .soc-link.facebook {
        background: #1877f2;
    }

    .soc-link.x-twitter {
        background: #000;
    }

    .soc-link.instagram {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    }

    .soc-link.youtube {
        background: #ff0000;
    }

    .soc-link.pinterest {
        background: #bd081c;
    }

    .soc-link.tiktok {
        background: #000;
    }

    .connections-sep {
        width: 1px;
        height: 40px;
        background: #ddd;
    }

    .payment-box {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        font-size: 1.8rem;
        color: #555;
    }

    .pay-brand {
        font-weight: 800;
        font-size: 1rem;
        color: #000;
    }

    /* App Promo */
    .footer-app-promo {
        background: #f7f7f7;
        padding: 3rem 0;
        text-align: center;
    }

    .app-promo-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }

    .app-promo-text {
        color: #333;
        font-size: 1rem;
        font-weight: 500;
        max-width: 600px;
    }

    .app-buttons {
        display: flex;
        gap: 1.5rem;
    }

    .app-badge-btn {
        background: #000;
        color: #fff;
        padding: 0.6rem 1.4rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .app-badge-btn:hover {
        opacity: 0.8;
    }

    .app-badge-btn i {
        font-size: 1.8rem;
    }

    .app-badge-btn .btn-txt {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        line-height: 1.1;
    }

    .app-badge-btn .btn-txt span {
        font-size: 0.65rem;
        text-transform: uppercase;
    }

    .app-badge-btn .btn-txt strong {
        font-size: 0.95rem;
    }

    /* Brand Section */
    .footer-brand-section {
        padding: 3rem 0 1.5rem;
        background: #fff;
    }

    .brand-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .brand-logo-final {
        font-size: 1.8rem;
        font-weight: 900;
        color: #000;
        letter-spacing: -1px;
    }

    .brand-links-final {
        display: flex;
        gap: 2rem;
    }

    .brand-links-final a {
        text-decoration: none;
        color: #666;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .brand-links-final a:hover {
        color: #000;
    }

    .region-btn {
        background: #fff;
        border: 1px solid #ddd;
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        color: #555;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .footer-copyright-final {
        text-align: center;
        color: #888;
        font-size: 0.85rem;
        margin-top: 2rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .reinsurance-grid {
            flex-wrap: wrap;
            justify-content: center;
        }

        .footer-links-grid {
            gap: 1rem;
        }

        .footer-separator {
            margin: 0 1rem;
        }
    }

    @media (max-width: 768px) {
        .reinsurance-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .reinsurance-item {
            flex-direction: column;
            text-align: center;
            padding: 1.5rem;
            background: #f9f9f9;
            border-radius: 12px;
        }

        .footer-links-grid {
            flex-direction: column;
            gap: 3rem;
        }

        .footer-separator {
            display: none;
        }

        .footer-bottom-flex {
            flex-direction: column-reverse;
            gap: 2rem;
            text-align: center;
        }

        .footer-international .footer-container {
            flex-direction: column;
            gap: 2rem;
            text-align: center;
        }

        .international-links {
            justify-content: center;
        }
    }
</style>
</style>