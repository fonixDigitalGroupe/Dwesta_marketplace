<footer class="rk-footer">
    <div class="rk-footer-content">
        <!-- Top Section: Elegant Newsletter -->
        <div class="rk-footer-newsletter">
            <div class="newsletter-info">
                <h3>Inscrivez-vous à notre newsletter</h3>
                <p>Recevez nos meilleures offres et actualités directement dans votre boîte mail.</p>
            </div>
            <form class="newsletter-form">
                <div class="input-group">
                    <input type="email" placeholder="Votre adresse email" required>
                    <button type="submit">S'abonner</button>
                </div>
                <p class="newsletter-privacy">En vous inscrivant, vous acceptez nos <a href="#">CGU</a> et notre <a href="#">Politique de Confidentialité</a>.</p>
            </form>
        </div>

        <div class="rk-footer-grid">
            <!-- Branding & About -->
            <div class="rk-footer-col branding-col">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 50px; width: auto;">
                </div>
                <p class="footer-desc">Votre marketplace de confiance pour acheter et vendre en toute simplicité. Des milliers d'annonces au meilleur prix.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Links Columns -->
            <div class="rk-footer-col">
                <h4>Acheter & Vendre</h4>
                <ul>
                    <li><a href="{{ route('search.index') }}">Toutes les annonces</a></li>
                    <li><a href="{{ route('annonces.create') }}">Déposer une annonce</a></li>
                    <li><a href="#">Comment ça marche ?</a></li>
                    <li><a href="#">Conseils de sécurité</a></li>
                    <li><a href="#">Vendre en tant que Pro</a></li>
                </ul>
            </div>

            <div class="rk-footer-col">
                <h4>Informations</h4>
                <ul>
                    <li><a href="#">À propos de nous</a></li>
                    <li><a href="#">Nos engagements</a></li>
                    <li><a href="#">Blog & Actualités</a></li>
                    <li><a href="#">Avis clients</a></li>
                    <li><a href="#">Recrutement</a></li>
                </ul>
            </div>

            <div class="rk-footer-col">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Centre d'aide</a></li>
                    <li><a href="#">Contactez-nous</a></li>
                    <li><a href="#">Modes de livraison</a></li>
                    <li><a href="#">Paiements sécurisés</a></li>
                    <li><a href="#">Suivi de commande</a></li>
                </ul>
            </div>
        </div>

        <div class="rk-footer-divider"></div>

        <!-- Bottom Section: Payments & Copyright -->
        <div class="rk-footer-bottom">
            <div class="payment-methods">
                <i class="fab fa-cc-visa" title="Visa"></i>
                <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                <i class="fab fa-cc-paypal" title="Paypal"></i>
                <span class="custom-icon" title="Wave/Orange Money">OM/Wave</span>
            </div>
            <div class="footer-legal">
                <p>&copy; {{ date('Y') }} Dwesta. Tous droits réservés.</p>
                <div class="legal-links">
                    <a href="#">Mentions légales</a>
                    <a href="#">CGU</a>
                    <a href="#">Confidentialité</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>

@once
@push('styles')
<style>
    .rk-footer {
        background-color: #f8f9fa;
        color: #333;
        border-top: 1px solid #eee;
        padding: 4rem 0 2rem 0;
        font-family: inherit;
    }

    .rk-footer-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    /* Newsletter Section */
    .rk-footer-newsletter {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
        margin-bottom: 4rem;
        padding: 2.5rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .newsletter-info h3 {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #000;
    }

    .newsletter-info p {
        color: #666;
        font-size: 0.95rem;
    }

    .newsletter-form {
        flex: 0 0 450px;
    }

    .newsletter-form .input-group {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .newsletter-form input {
        flex: 1;
        padding: 0.8rem 1.2rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        outline: none;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }

    .newsletter-form input:focus {
        border-color: #bf0000;
    }

    .newsletter-form button {
        background: #000;
        color: #fff;
        border: none;
        padding: 0 2rem;
        border-radius: 6px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }

    .newsletter-form button:hover {
        background: #bf0000;
    }

    .newsletter-privacy {
        font-size: 0.75rem;
        color: #999;
    }

    .newsletter-privacy a {
        color: #666;
        text-decoration: underline;
    }

    /* Grid Section */
    .rk-footer-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr;
        gap: 3rem;
        margin-bottom: 4rem;
    }

    .branding-col .footer-logo {
        font-size: 1.8rem;
        font-weight: 900;
        color: #000;
        margin-bottom: 1.5rem;
    }

    .branding-col .footer-logo span {
        color: #bf0000;
    }

    .branding-col .footer-desc {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-links a {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #eee;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        text-decoration: none;
        transition: all 0.2s;
    }

    .social-links a:hover {
        background: #bf0000;
        color: #fff;
        transform: translateY(-3px);
    }

    .rk-footer-col h4 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #000;
    }

    .rk-footer-col ul {
        list-style: none;
        padding: 0;
    }

    .rk-footer-col ul li {
        margin-bottom: 0.8rem;
    }

    .rk-footer-col ul li a {
        text-decoration: none;
        color: #666;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .rk-footer-col ul li a:hover {
        color: #bf0000;
        padding-left: 5px;
    }

    /* Bottom Section */
    .rk-footer-divider {
        height: 1px;
        background: #eee;
        margin-bottom: 2rem;
    }

    .rk-footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .payment-methods {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        font-size: 1.8rem;
        color: #999;
    }

    .custom-icon {
        font-size: 0.75rem;
        font-weight: 800;
        border: 1px solid #ccc;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .footer-legal {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
    }

    .footer-legal p {
        font-size: 0.85rem;
        color: #999;
        margin: 0;
    }

    .legal-links {
        display: flex;
        gap: 1.5rem;
    }

    .legal-links a {
        color: #666;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .legal-links a:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .rk-footer-newsletter {
            flex-direction: column;
            text-align: center;
        }
        .newsletter-form {
            flex: 1;
            width: 100%;
        }
        .rk-footer-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .rk-footer-bottom {
            flex-direction: column;
            text-align: center;
        }
        .footer-legal {
            align-items: center;
        }
    }

    @media (max-width: 640px) {
        .rk-footer-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
@endonce
