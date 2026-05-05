<footer class="rk-footer">
    <!-- Section 1: Réassurance (Barre du haut) -->
    <div class="footer-reinsurance">
        <div class="footer-container">
            <div class="reinsurance-grid">
                <div class="reinsurance-item">
                    <img src="https://image.rakuten.co.jp/rakuten/gold/img/footer/icon_choice.png" alt="Le choix" class="reinsurance-icon" onerror="this.src='https://cdn-icons-png.flaticon.com/512/1170/1170577.png'">
                    <div class="reinsurance-text">
                        <span class="reinsurance-label">Le choix</span>
                        <span class="reinsurance-value">Neuf et occasion</span>
                    </div>
                </div>
                <div class="reinsurance-item">
                    <img src="https://image.rakuten.co.jp/rakuten/gold/img/footer/icon_security.png" alt="La sécurité" class="reinsurance-icon" onerror="this.src='https://cdn-icons-png.flaticon.com/512/1067/1067555.png'">
                    <div class="reinsurance-text">
                        <span class="reinsurance-label">La sécurité</span>
                        <span class="reinsurance-value">Satisfait ou remboursé</span>
                    </div>
                </div>
                <div class="reinsurance-item">
                    <img src="https://image.rakuten.co.jp/rakuten/gold/img/footer/icon_service.png" alt="Le service clients" class="reinsurance-icon" onerror="this.src='https://cdn-icons-png.flaticon.com/512/1041/1041916.png'">
                    <div class="reinsurance-text">
                        <span class="reinsurance-label">Le service clients</span>
                        <span class="reinsurance-value">À votre écoute</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Liens (Corps principal) -->
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
                <div class="footer-links-col">
                    <h4 class="footer-col-title">AIDE</h4>
                    <ul class="footer-links-list">
                        <li><a href="#">Besoin d'aide ?</a></li>
                        <li><a href="#">Ouvrir un e-shop en tant que commerçant</a></li>
                        <li><a href="#">Signaler un contenu illicite</a></li>
                    </ul>
                </div>
                <div class="footer-links-col">
                    <h4 class="footer-col-title">KARNOU</h4>
                    <ul class="footer-links-list">
                        <li><a href="#">Conditions générales</a></li>
                        <li><a href="#">Politique Vie privée</a></li>
                        <li><a href="#">Gestion des cookies</a></li>
                        <li><a href="#">A propos de Karnou</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Social & Paiements (Barre du bas) -->
    <div class="footer-bottom">
        <div class="footer-container">
            <div class="footer-bottom-flex">
                <div class="social-icons">
                    <a href="#" class="social-link linkedin"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-link facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link x-twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-link instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link youtube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link tiktok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .rk-footer {
        background: #fff;
        font-family: 'Outfit', sans-serif;
        color: #333;
    }

    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Section 1: Réassurance */
    .footer-reinsurance {
        background: #fff;
        padding: 2.5rem 0;
        border-bottom: 2.5px solid #f2f2f2;
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

    .reinsurance-icon {
        height: 32px;
        width: auto;
    }

    .club-r-mini-logo {
        font-size: 1.5rem;
        font-weight: 400;
        color: #000;
    }
    .club-r-mini-logo .r-letter {
        font-weight: 800;
        background: #000;
        color: #fff;
        padding: 0 4px;
        border-radius: 4px;
        margin-left: 2px;
    }

    .reinsurance-text {
        display: flex;
        flex-direction: column;
    }

    .reinsurance-label {
        font-size: 0.75rem;
        color: #777;
        margin-bottom: 2px;
    }

    .reinsurance-value {
        font-size: 1rem;
        font-weight: 900;
        color: #000;
        white-space: nowrap;
    }

    /* Section 2: Liens du footer */
    .footer-main {
        padding: 5rem 0;
    }

    .footer-links-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 4rem;
    }

    .footer-col-title {
        font-size: 1.1rem;
        font-weight: 900;
        color: #000;
        margin-bottom: 2rem;
        letter-spacing: 0.5px;
    }

    .footer-links-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links-list li {
        margin-bottom: 0.9rem;
    }

    .footer-links-list li a {
        text-decoration: none;
        color: #444;
        font-size: 1rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .footer-links-list li a:hover {
        color: #bf0000;
    }

    /* Section 3: Social & Paiement */
    .footer-bottom {
        padding: 2.5rem 0 5rem;
        border-top: 1px solid #f2f2f2;
    }

    .footer-bottom-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    .social-icons {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .social-link {
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

    .social-link:hover {
        transform: scale(1.1);
    }

    .social-link.linkedin { background: #0077b5; }
    .social-link.facebook { background: #1877f2; }
    .social-link.x-twitter { background: #000; }
    .social-link.instagram { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
    .social-link.youtube { background: #ff0000; }
    .social-link.pinterest { background: #bd081c; }
    .social-link.tiktok { background: #000; }

    .vertical-divider {
        width: 1px;
        height: 60px;
        background: #ddd;
        margin: 0 1rem;
    }

    .payment-icons {
        display: flex;
        align-items: center;
        gap: 1.8rem;
        flex-wrap: wrap;
    }

    .payment-icons img {
        filter: grayscale(0);
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .reinsurance-grid {
            flex-wrap: wrap;
            justify-content: center;
        }
        .footer-links-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .footer-links-grid {
            grid-template-columns: 1fr;
        }
        .footer-bottom-flex {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .vertical-divider {
            display: none;
        }
    }
</style>

