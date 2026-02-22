<footer class="rk-footer">
    <!-- Top trust bar -->
    <div class="rk-footer-trust">
        <div class="rk-footer-content">
            <div class="trust-items">
                <div class="trust-item">
                    <div class="trust-icon">🔒</div>
                    <div>
                        <strong>Paiement sécurisé</strong>
                        <span>Transactions cryptées</span>
                    </div>
                </div>
                <div class="trust-sep"></div>
                <div class="trust-item">
                    <div class="trust-icon">🚚</div>
                    <div>
                        <strong>Livraison partout</strong>
                        <span>Suivi en temps réel</span>
                    </div>
                </div>
                <div class="trust-sep"></div>
                <div class="trust-item">
                    <div class="trust-icon">↩️</div>
                    <div>
                        <strong>Retour facile</strong>
                        <span>30 jours pour changer d'avis</span>
                    </div>
                </div>
                <div class="trust-sep"></div>
                <div class="trust-item">
                    <div class="trust-icon">⭐</div>
                    <div>
                        <strong>Vendeurs certifiés</strong>
                        <span>Avis clients vérifiés</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main footer body -->
    <div class="rk-footer-main">
        <div class="rk-footer-content">
            <!-- Top: Newsletter -->
            <div class="rk-footer-newsletter">
                <div class="newsletter-info">
                    <h3>Recevez les meilleures offres</h3>
                    <p>Inscrivez-vous à notre newsletter et ne ratez plus aucune promotion.</p>
                </div>
                <form class="newsletter-form" onsubmit="return false;">
                    <div class="input-group">
                        <input type="email" placeholder="Votre adresse email">
                        <button type="submit">S'abonner</button>
                    </div>
                    <p class="newsletter-privacy">En vous inscrivant, vous acceptez nos <a href="#">CGU</a> et notre <a href="#">Politique de confidentialité</a>.</p>
                </form>
            </div>

            <div class="rk-footer-divider"></div>

            <!-- Link Columns -->
            <div class="rk-footer-grid">
                <!-- Branding -->
                <div class="rk-footer-col branding-col">
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Karnou" style="height: 45px; width: auto; filter: brightness(0) invert(1);">
                    </div>
                    <p class="footer-desc">Votre marketplace de confiance pour acheter et vendre en toute sécurité. Des milliers d'annonces au meilleur prix.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter / X"><i class="fab fa-x-twitter"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    </div>
                    <div class="app-badges">
                        <a href="#" class="app-badge">
                            <i class="fab fa-apple"></i>
                            <div>
                                <span>Télécharger sur</span>
                                <strong>App Store</strong>
                            </div>
                        </a>
                        <a href="#" class="app-badge">
                            <i class="fab fa-google-play"></i>
                            <div>
                                <span>Disponible sur</span>
                                <strong>Google Play</strong>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Acheter & Vendre -->
                <div class="rk-footer-col">
                    <h4>Acheter & Vendre</h4>
                    <ul>
                        <li><a href="{{ route('search.index') }}">Toutes les annonces</a></li>
                        <li><a href="{{ route('annonces.create') }}">Déposer une annonce</a></li>
                        <li><a href="#">Comment ça marche ?</a></li>
                        <li><a href="#">Conseils de sécurité</a></li>
                        <li><a href="#">Guide du vendeur</a></li>
                        <li><a href="#">Vendre en tant que Pro</a></li>
                        <li><a href="#">Tarifs et commissions</a></li>
                    </ul>
                </div>

                <!-- Catégories populaires -->
                <div class="rk-footer-col">
                    <h4>Catégories populaires</h4>
                    <ul>
                        <li><a href="#">Informatique & Bureautique</a></li>
                        <li><a href="#">Smartphones & Tablettes</a></li>
                        <li><a href="#">Mode & Vêtements</a></li>
                        <li><a href="#">Maison & Jardin</a></li>
                        <li><a href="#">Electroménager</a></li>
                        <li><a href="#">Livres & BD</a></li>
                        <li><a href="#">Jeux vidéo</a></li>
                    </ul>
                </div>

                <!-- Informations -->
                <div class="rk-footer-col">
                    <h4>Informations</h4>
                    <ul>
                        <li><a href="#">À propos de Karnou</a></li>
                        <li><a href="#">Nos engagements</a></li>
                        <li><a href="#">Blog & Actualités</a></li>
                        <li><a href="#">Presse</a></li>
                        <li><a href="#">Partenaires</a></li>
                        <li><a href="#">Recrutement</a></li>
                        <li><a href="#">Investisseurs</a></li>
                    </ul>
                </div>

                <!-- Aide & Support -->
                <div class="rk-footer-col">
                    <h4>Aide & Support</h4>
                    <ul>
                        <li><a href="#">Centre d'aide</a></li>
                        <li><a href="#">Contactez-nous</a></li>
                        <li><a href="#">Modes de livraison</a></li>
                        <li><a href="#">Retours & Remboursements</a></li>
                        <li><a href="#">Suivi de commande</a></li>
                        <li><a href="#">Signaler un problème</a></li>
                        <li><a href="#">Protection acheteur</a></li>
                    </ul>
                </div>
            </div>

            <div class="rk-footer-divider"></div>

            <!-- Bottom bar -->
            <div class="rk-footer-bottom">
                <div class="payment-methods">
                    <span class="payment-label">Paiements acceptés :</span>
                    <i class="fab fa-cc-visa" title="Visa"></i>
                    <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                    <i class="fab fa-cc-paypal" title="PayPal"></i>
                    <span class="custom-pay-icon" title="Orange Money">OM</span>
                    <span class="custom-pay-icon" title="Wave">Wave</span>
                </div>
                <div class="footer-legal">
                    <div class="legal-links">
                        <a href="#">Mentions légales</a>
                        <a href="#">CGU</a>
                        <a href="#">CGV</a>
                        <a href="#">Confidentialité</a>
                        <a href="#">Cookies</a>
                        <a href="#">Accessibilité</a>
                    </div>
                    <p>&copy; {{ date('Y') }} Karnou Marketplace. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* ===== TRUST BAR ===== */
    .rk-footer-trust {
        background: #f0f0f0;
        border-top: 1px solid #e0e0e0;
        padding: 1.5rem 0;
    }
    .trust-items {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        flex-wrap: wrap;
    }
    .trust-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0 2.5rem;
    }
    .trust-sep {
        width: 1px;
        height: 40px;
        background: #ddd;
    }
    .trust-icon {
        font-size: 1.6rem;
        line-height: 1;
    }
    .trust-item strong {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #111;
    }
    .trust-item span {
        display: block;
        font-size: 0.75rem;
        color: #777;
    }

    /* ===== MAIN FOOTER ===== */
    .rk-footer-main {
        background: #1a1a1a;
        color: #ccc;
        padding: 4rem 0 0;
    }

    .rk-footer-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* ===== NEWSLETTER ===== */
    .rk-footer-newsletter {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 3rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }
    .newsletter-info h3 {
        font-size: 1.3rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 0.4rem;
    }
    .newsletter-info p {
        color: #aaa;
        font-size: 0.9rem;
    }
    .newsletter-form {
        flex: 0 0 420px;
    }
    .newsletter-form .input-group {
        display: flex;
        gap: 0;
        margin-bottom: 0.6rem;
        border-radius: 6px;
        overflow: hidden;
    }
    .newsletter-form input {
        flex: 1;
        padding: 0.8rem 1rem;
        border: none;
        outline: none;
        background: #2a2a2a;
        color: #fff;
        font-size: 0.9rem;
    }
    .newsletter-form input::placeholder { color: #777; }
    .newsletter-form button {
        background: #db0001;
        color: #fff;
        border: none;
        padding: 0 1.5rem;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s;
    }
    .newsletter-form button:hover { background: #b00000; }
    .newsletter-privacy {
        font-size: 0.72rem;
        color: #666;
    }
    .newsletter-privacy a { color: #888; text-decoration: underline; }

    /* ===== GRID ===== */
    .rk-footer-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr 1fr 1fr 1fr;
        gap: 2.5rem;
        margin-bottom: 3rem;
    }

    /* ===== BRANDING COL ===== */
    .branding-col .footer-desc {
        color: #999;
        line-height: 1.6;
        margin: 1.2rem 0 1.5rem;
        font-size: 0.85rem;
    }
    .social-links {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
    }
    .social-links a {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #2a2a2a;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #aaa;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .social-links a:hover {
        background: #db0001;
        color: #fff;
    }
    .app-badges {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .app-badge {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        background: #2a2a2a;
        border: 1px solid #333;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: #ccc;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.8rem;
    }
    .app-badge:hover { background: #333; color: #fff; }
    .app-badge i { font-size: 1.4rem; color: #fff; }
    .app-badge span { display: block; font-size: 0.65rem; color: #888; }
    .app-badge strong { display: block; font-size: 0.85rem; color: #fff; font-weight: 700; }

    /* ===== LINK COLUMNS ===== */
    .rk-footer-col h4 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 1.2rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .rk-footer-col ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .rk-footer-col ul li {
        margin-bottom: 0.6rem;
    }
    .rk-footer-col ul li a {
        text-decoration: none;
        color: #999;
        font-size: 0.85rem;
        transition: color 0.2s;
        line-height: 1.4;
    }
    .rk-footer-col ul li a:hover {
        color: #fff;
    }

    /* ===== DIVIDER ===== */
    .rk-footer-divider {
        height: 1px;
        background: #2a2a2a;
        margin-bottom: 2rem;
    }

    /* ===== BOTTOM BAR ===== */
    .rk-footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding: 1.5rem 0 2rem;
        border-top: 1px solid #2a2a2a;
    }
    .payment-methods {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .payment-label {
        font-size: 0.75rem;
        color: #666;
        margin-right: 0.3rem;
    }
    .payment-methods i {
        font-size: 2rem;
        color: #666;
    }
    .custom-pay-icon {
        font-size: 0.65rem;
        font-weight: 800;
        border: 1px solid #444;
        padding: 3px 7px;
        border-radius: 4px;
        color: #888;
    }
    .footer-legal {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
    }
    .footer-legal p {
        font-size: 0.75rem;
        color: #555;
        margin: 0;
    }
    .legal-links {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: flex-end;
    }
    .legal-links a {
        color: #666;
        text-decoration: none;
        font-size: 0.75rem;
        transition: color 0.2s;
    }
    .legal-links a:hover { color: #ccc; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .rk-footer-grid {
            grid-template-columns: 1fr 1fr 1fr;
        }
        .rk-footer-newsletter {
            flex-direction: column;
            align-items: flex-start;
        }
        .newsletter-form { flex: 1; width: 100%; }
    }
    @media (max-width: 768px) {
        .trust-items { flex-direction: column; gap: 1rem; }
        .trust-sep { display: none; }
        .rk-footer-grid { grid-template-columns: 1fr 1fr; }
        .rk-footer-bottom { flex-direction: column; align-items: flex-start; }
        .footer-legal { align-items: flex-start; }
        .legal-links { justify-content: flex-start; }
    }
    @media (max-width: 640px) {
        .rk-footer-grid { grid-template-columns: 1fr; }
    }
</style>

