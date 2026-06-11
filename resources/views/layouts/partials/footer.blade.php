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

    <!-- Tier 3: Copyright & Social -->
    <div class="footer-bottom-info">
        <div class="footer-container">
            <div class="footer-bottom-flex">
                <div class="copyright">
                    © Karnou Group - Tous droits réservés 2024
                </div>
                <div class="social-icons">
                    <a href="#" class="social-link facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link x-twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-link instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link linkedin"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-link youtube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tier 4: Legal & International -->
    <div class="footer-international">
        <div class="footer-container">
            <div class="international-links">
                <a href="#">Mentions légales</a>
                <span class="sep">|</span>
                <a href="{{ route('privacy') }}">Politique de confidentialité</a>

                <span class="sep">|</span>
                <a href="#">Karnou France</a>
                <span class="sep">|</span>
                <a href="#">Karnou Sénégal</a>
                <span class="sep">|</span>
                <a href="#">Karnou USA</a>
            </div>
            <div class="footer-logo-small">
                <span class="karnou-brand">Karnou.</span>
            </div>
        </div>
    </div>
</footer>

<style>
    .rk-footer {
        background: #fff;
        font-family: 'Outfit', sans-serif;
        color: #333;
        border-top: 1px solid #eee;
    }

    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Tier 1: Réassurance */
    .footer-reinsurance {
        background: #fff;
        padding: 2rem 0;
        border-bottom: 1px solid #eee;
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
        color: #666;
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
        color: #999;
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
        background: #fdfdfd;
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
        color: #555;
        font-size: 0.95rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .footer-links-list li a:hover {
        color: #004aad;
    }

    /* Tier 3: Info & Social */
    .footer-bottom-info {
        background: #fff;
        padding: 2.5rem 0;
        border-bottom: 1px solid #eee;
    }

    .footer-bottom-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .copyright {
        font-size: 0.9rem;
        color: #888;
        font-weight: 500;
    }

    .social-icons {
        display: flex;
        gap: 0.8rem;
    }

    .social-link {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        font-size: 1rem;
        transition: transform 0.2s, background 0.2s;
    }

    .social-link:hover {
        transform: translateY(-3px);
    }

    .social-link.facebook { background: #004aad; } /* Corporate Red */
    .social-link.x-twitter { background: #004aad; }
    .social-link.instagram { background: #004aad; }
    .social-link.linkedin { background: #004aad; }
    .social-link.youtube { background: #004aad; }

    /* Tier 4: International */
    .footer-international {
        background: #fdfdfd;
        padding: 2rem 0 4rem;
    }

    .footer-international .footer-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .international-links {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .international-links a {
        text-decoration: none;
        color: #999;
        font-size: 0.85rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .international-links a:hover {
        color: #004aad;
    }

    .international-links .sep {
        color: #eee;
        font-size: 0.8rem;
    }

    .karnou-brand {
        font-size: 1.5rem;
        font-weight: 900;
        color: #004aad;
        letter-spacing: -1px;
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

