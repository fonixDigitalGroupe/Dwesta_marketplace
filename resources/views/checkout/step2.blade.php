@extends('layouts.app')

@section('title', 'Mode de Paiement - Étape 2 - Karnou')

@push('styles')
<style>
    :root {
        --rk-orange: #f58220;
        --rk-badge-bg: #fff0e0;
        --rk-border: #eee;
        --rk-bg: #fdfdfd;
        --rk-text-main: #333;
        --rk-text-muted: #666;
    }

    body { background-color: #f5f5f5; font-family: 'Inter', sans-serif; }

    .checkout-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; display: grid; grid-template-columns: 1fr 380px; gap: 2rem; }
    
    @media (max-width: 991px) {
        .checkout-container { grid-template-columns: 1fr; margin: 1rem auto; }
        .checkout-right { order: 2; }
    }

    .checkout-main { background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
    
    .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 10px; font-weight: 700; color: #444; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .header-step { background: #4CAF50; color: white; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; }

    .section-group { border-bottom: 8px solid #f8f9fa; }
    .section-group:last-child { border-bottom: none; }
    
    .section-title { padding: 1.5rem 1.5rem 0.5rem; font-size: 1.1rem; font-weight: 800; color: #1a1a1a; }

    .payment-option {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.2s;
        position: relative;
    }
    .payment-option:hover { background: #fafafa; }
    .payment-option input {
        width: 24px;
        height: 24px;
        cursor: pointer;
        accent-color: var(--rk-orange);
        margin: 0;
    }

    .option-content { flex: 1; }
    .option-title { font-weight: 700; font-size: 1.05rem; display: flex; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 4px; color: #222; }
    .option-amount { background: #fff1e6; color: #f58220; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; border: 1px solid #ffd8b1; }
    .option-desc { font-size: 0.9rem; color: #666; line-height: 1.5; }

    .option-icon { width: 45px; display: flex; align-items: center; justify-content: flex-end; }
    .option-icon img { max-width: 100%; max-height: 30px; object-fit: contain; }
    .option-icon i { font-size: 1.5rem; }

    /* Phone Input Area */
    #phone_input_container {
        padding: 1.5rem;
        background: #fffcf5;
        border-bottom: 1px solid #f0eddf;
    }
    .phone-field-group { max-width: 400px; }
    .phone-label { display: block; font-weight: 700; font-size: 0.9rem; color: #333; margin-bottom: 10px; }
    .phone-input-wrapper { display: flex; border: 2px solid #ddd; border-radius: 6px; overflow: hidden; background: white; transition: border-color 0.2s; }
    .phone-input-wrapper:focus-within { border-color: var(--rk-orange); }
    .phone-prefix { background: #f8f9fa; padding: 0.85rem 1rem; border-right: 1px solid #ddd; font-weight: 600; color: #666; font-size: 1rem; }
    .phone-field { border: none; padding: 0.85rem 1rem; font-size: 1rem; flex: 1; outline: none; font-weight: 600; width: 100%; }
    .phone-help { font-size: 0.8rem; color: #777; margin-top: 10px; display: flex; gap: 8px; align-items: center; }

    /* Summary Sidebar */
    .sidebar-summary { background: #fff; border: 1px solid #ddd; padding: 1.75rem; border-radius: 8px; position: sticky; top: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
    .summary-title { font-weight: 800; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #eee; font-size: 1.15rem; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #444; }
    .summary-total { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #f0f0f0; font-weight: 900; font-size: 1.35rem; display: flex; justify-content: space-between; color: #000; }
    
    .btn-confirm { background: var(--rk-orange); color: white; border: none; padding: 1rem; border-radius: 6px; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: all 0.2s; width: 100%; margin-top: 1.5rem; box-shadow: 0 4px 12px rgba(245, 130, 32, 0.2); }
    .btn-confirm:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(245, 130, 32, 0.3); opacity: 0.95; }
    .btn-confirm:active { transform: translateY(0); }

    /* For Mobile */
    @media (max-width: 480px) {
        .payment-option { padding: 1.25rem 1rem; }
        .option-title { font-size: 0.95rem; }
        .option-desc { font-size: 0.85rem; }
        .btn-confirm { padding: 0.9rem; font-size: 1rem; }
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="checkout-left">
        <form action="{{ route('checkout.process') }}" method="POST" id="paymentForm">
            @csrf
            <div class="checkout-main">
                <div class="card-header">
                    <span class="header-step"><i class="fas fa-check"></i></span>
                    Mode de paiement
                </div>

                <!-- MOBILE MONEY SECTION -->
                <div class="section-group">
                    <div class="section-title">Mobile Money</div>

                    <!-- ORANGE MONEY -->
                    <label class="payment-option" onclick="selectOption(this)">
                        <input type="radio" name="payment_choice" value="commande_om" onchange="updateInputs(this)">
                        <div class="option-content">
                            <div class="option-title">
                                Avec Orange Money 
                                <span class="option-amount">soit un montant total de {{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="option-desc">Paiement rapide et sécurisé via votre compte Orange Money.</div>
                        </div>
                        <div class="option-icon">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png" alt="OM">
                        </div>
                    </label>

                    <!-- WAVE -->
                    <label class="payment-option" onclick="selectOption(this)">
                        <input type="radio" name="payment_choice" value="commande_wave" onchange="updateInputs(this)">
                        <div class="option-content">
                            <div class="option-title">
                                Avec Wave 
                                <span class="option-amount">soit un montant total de {{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="option-desc">Payez instantanément avec l'application Wave mobile.</div>
                        </div>
                        <div class="option-icon">
                            <img src="https://vignette.wikia.nocookie.net/logopedia/images/d/d0/Wave_Logo.svg" alt="Wave">
                        </div>
                    </label>

                    <!-- FREE MONEY -->
                    <label class="payment-option" onclick="selectOption(this)">
                        <input type="radio" name="payment_choice" value="commande_free" onchange="updateInputs(this)">
                        <div class="option-content">
                            <div class="option-title">Free Money</div>
                            <div class="option-desc">Utilisez votre compte Free Money pour payer.</div>
                        </div>
                        <div class="option-icon">
                            <img src="https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png" alt="Free Money">
                        </div>
                    </label>

                    <!-- PHONE INPUT (DYNAMICALLY VISIBLE) -->
                    <div id="phone_input_container" style="display: none;">
                        <div class="phone-field-group">
                            <label for="phone_number" class="phone-label">Numéro de téléphone pour le paiement</label>
                            <div class="phone-input-wrapper">
                                <span class="phone-prefix">+221</span>
                                <input type="tel" name="phone_number" id="phone_number" 
                                       value="{{ Auth::user()->telephone }}" 
                                       placeholder="77XXXXXXX" 
                                       class="phone-field">
                            </div>
                            <div class="phone-help">
                                <i class="fas fa-shield-alt"></i>
                                <span>Un code de confirmation ou une notification de paiement sera envoyé sur ce numéro.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- INTERNATIONAL SECTION -->
                <div class="section-group">
                    <div class="section-title">Carte Bancaire / International</div>
                    <label class="payment-option" onclick="selectOption(this)">
                        <input type="radio" name="payment_choice" value="commande_cb" onchange="updateInputs(this)">
                        <div class="option-content">
                            <div class="option-title">VISA, Mastercard</div>
                            <div class="option-desc">Paiement par carte bancaire internationale via PayDunya sécurisé.</div>
                        </div>
                        <div class="option-icon" style="gap: 5px;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" style="height: 12px;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" style="height: 18px;">
                        </div>
                    </label>
                </div>

                <!-- DELIVERY SECTION -->
                <div class="section-group">
                    <div class="section-title">Paiement à la livraison</div>
                    <label class="payment-option" onclick="selectOption(this)">
                        <input type="radio" name="payment_choice" value="livraison_buyer" onchange="updateInputs(this)">
                        <div class="option-content">
                            <div class="option-title">Paiement à la livraison</div>
                            <div class="option-desc">Payez dès réception de votre commande à domicile.</div>
                        </div>
                        <div class="option-icon">
                            <i class="fas fa-handshake" style="color: var(--rk-orange);"></i>
                        </div>
                    </label>
                </div>

                <input type="hidden" name="gestion_paiement" id="gestion_paiement" value="">
                <input type="hidden" name="moyen_paiement" id="moyen_paiement" value="">
                <!-- Nationality Context (Auto) -->
                <input type="hidden" name="user_country" value="{{ Auth::user()->pays ?? 'Sénégal' }}">
            </div>
        </form>
    </div>

    <div class="checkout-right">
        <div class="sidebar-summary">
            <div class="summary-title">Résumé de commande</div>
            
            <div class="summary-row">
                <span>Total articles ({{ $cartGrouped->flatten(1)->count() }})</span>
                <span style="font-weight: 700;">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>
            <div class="summary-row">
                <span>Frais de Livraison</span>
                <span>0 FCFA</span>
            </div>

            <div class="summary-total">
                <span>Total</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>

            <button type="button" onclick="confirmOrder(this)" class="btn-confirm" id="btn-confirm">
                Confirmer le mode de paiement
            </button>
            <a href="{{ route('checkout.step1') }}" style="display: block; text-align: center; margin-top: 1.25rem; color: #777; font-size: 0.85rem; text-decoration: none; font-weight: 500;">
                <i class="fas fa-arrow-left" style="font-size: 0.7rem; margin-right: 5px;"></i> Revenir à la livraison
            </a>
        </div>
    </div>
</div>

<script>
    function selectOption(el) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('input').checked = true;
        updateInputs(el.querySelector('input'));
    }

    function updateInputs(input) {
        const val = input.value;
        const gp = document.getElementById('gestion_paiement');
        const mp = document.getElementById('moyen_paiement');
        const phoneContainer = document.getElementById('phone_input_container');
        const phoneInput = document.getElementById('phone_number');

        if (val.startsWith('commande_')) {
            gp.value = 'commande';
            const method = val.replace('commande_', '');
            mp.value = method;

            // Show/Hide phone input for direct mobile methods
            const directMethods = ['om', 'wave', 'free'];
            if (directMethods.includes(method)) {
                phoneContainer.style.display = 'block';
                phoneInput.required = true;
                phoneInput.focus();
            } else {
                phoneContainer.style.display = 'none';
                phoneInput.required = false;
            }
        } else {
            gp.value = val;
            mp.value = 'cod';
            phoneContainer.style.display = 'none';
            phoneInput.required = false;
        }
    }

    function confirmOrder(btn) {
        const selected = document.querySelector('input[name="payment_choice"]:checked');
        if (!selected) {
            alert('Veuillez sélectionner un mode de paiement pour continuer.');
            return;
        }

        const phoneInput = document.getElementById('phone_number');
        if (phoneInput.required && !phoneInput.value.trim()) {
            alert('Veuillez saisir votre numéro de téléphone pour le paiement.');
            phoneInput.focus();
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement en cours...';
        document.getElementById('paymentForm').submit();
    }

    // Auto-select COD or previous selection on load
    document.addEventListener('DOMContentLoaded', () => {
        const checked = document.querySelector('input[name="payment_choice"]:checked');
        if (checked) {
            selectOption(checked.closest('.payment-option'));
        }
    });
</script>
@endsection
