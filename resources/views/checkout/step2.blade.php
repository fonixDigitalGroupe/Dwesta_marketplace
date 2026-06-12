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
    
    .checkout-main { background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: none; overflow: hidden; }
    
    .card-header { padding: 1rem 1.5rem; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 10px; font-weight: 700; color: #444; font-size: 0.95rem; }
    .header-step { background: #e0e0e0; color: #888; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; }
    .header-step.active { background: #4CAF50; color: white; }

    .section-title { padding: 1.5rem 1.5rem 0.5rem; font-size: 1.1rem; font-weight: 700; color: #222; }

    .payment-option {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f9f9f9;
        cursor: pointer;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        transition: background 0.2s;
        position: relative;
    }
    .payment-option:hover { background: #fafafa; }
    .payment-option input { margin-top: 5px; width: 20px; height: 20px; cursor: pointer; accent-color: var(--rk-orange); }

    .option-content { flex: 1; }
    .option-title { font-weight: 700; font-size: 1rem; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 4px; }
    .option-promo { background: #fff3db; color: #ff8c00; padding: 2px 8px; border-radius: 3px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
    .option-desc { font-size: 0.88rem; color: #555; line-height: 1.4; }

    .option-icon { width: 40px; height: 30px; display: flex; align-items: center; justify-content: center; }
    .option-icon img { max-width: 100%; max-height: 100%; border-radius: 4px; }

    /* Detail box when active */
    .detail-box {
        margin: 10px 1.5rem 1.5rem;
        padding: 1.25rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
        display: none;
    }
    .payment-option.active + .detail-box { display: block; }
    
    .detail-text { font-size: 0.88rem; color: #444; margin-bottom: 10px; }
    .detail-link { color: #007bff; text-decoration: none; font-weight: 600; font-size: 0.85rem; }
    .detail-footer { border-top: 1px solid #eee; margin-top: 15px; padding-top: 12px; display: flex; justify-content: flex-end; align-items: center; gap: 10px; font-size: 0.85rem; font-weight: 700; color: #444; }

    .action-bar { padding: 1.5rem; display: flex; justify-content: flex-end; }
    .btn-confirm { background: var(--rk-orange); color: white; border: none; padding: 0.85rem 2rem; border-radius: 4px; font-weight: 700; font-size: 1.05rem; cursor: pointer; transition: opacity 0.2s; width: 100%; }
    .btn-confirm:hover { opacity: 0.9; }

    /* Specific Icon Styles */
    .icon-om { color: #f58220; font-weight: 900; font-size: 0.8rem; }
    .icon-wave { color: #1fb6ff; font-weight: 900; }
    .icon-cod { color: #f58220; font-size: 1.2rem; }

    .sidebar-summary { background: #fff; border: 1px solid #ddd; padding: 1.75rem; border-radius: 4px; position: sticky; top: 2rem; box-shadow: none; }
    .summary-title { font-weight: 700; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid #eee; font-size: 1.1rem; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.92rem; color: #555; }
    .summary-total { margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid #eee; font-weight: 800; font-size: 1.25rem; display: flex; justify-content: space-between; color: #000; }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="checkout-left">
        <form action="{{ route('checkout.process') }}" method="POST" id="paymentForm">
            @csrf
            <div class="checkout-main">
                <div class="card-header">
                    <span class="header-step active"><i class="fas fa-check" style="font-size: 0.6rem;"></i></span>
                    3. MODE DE PAIEMENT
                </div>

                <div class="section-title">Paiement en ligne (PayDunya)</div>

                <!-- WAVE -->
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="commande_wave" onchange="updateInputs(this)">
                    <div class="option-content">
                        <div class="option-title">Wave <span class="option-promo">Populaire</span></div>
                        <div class="option-desc">Paiement instantané via l'application Wave</div>
                    </div>
                    <div class="option-icon">
                        <img src="https://vignette.wikia.nocookie.net/logopedia/images/d/d0/Wave_Logo.svg" alt="Wave" style="height: 30px;">
                    </div>
                </label>

                <!-- ORANGE MONEY -->
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="commande_om" onchange="updateInputs(this)">
                    <div class="option-content">
                        <div class="option-title">Orange Money</div>
                        <div class="option-desc">Paiement via votre numéro Orange Money</div>
                    </div>
                    <div class="option-icon">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png" alt="OM" style="height: 30px;">
                    </div>
                </label>

                <!-- FREE MONEY -->
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="commande_free" onchange="updateInputs(this)">
                    <div class="option-content">
                        <div class="option-title">Free Money</div>
                        <div class="option-desc">Paiement via votre compte Free Money</div>
                    </div>
                    <div class="option-icon">
                        <img src="https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png" alt="Free Money" style="height: 25px;">
                    </div>
                </label>

                <!-- CARTE BANCAIRE -->
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="commande_cb" onchange="updateInputs(this)">
                    <div class="option-content">
                        <div class="option-title">Carte Bancaire <span class="option-promo">International</span></div>
                        <div class="option-desc">VISA, Mastercard via PayDunya</div>
                    </div>
                    <div class="option-icon" style="display: flex; gap: 4px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" style="height: 12px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" style="height: 20px;">
                    </div>
                </label>

                <!-- PHONE NUMBER INPUT (CONDITIONAL) -->
                <div id="phone_input_container" style="display: none; padding: 1.5rem; background: #fffcf5; border-bottom: 1px solid #f9f9f9; border-top: 1px solid #f9f9f9;">
                    <label for="phone_number" style="display: block; font-weight: 700; font-size: 0.9rem; color: #222; margin-bottom: 8px;">Numéro de téléphone pour le paiement</label>
                    <div style="position: relative;">
                        <input type="tel" name="phone_number" id="phone_number" 
                               value="{{ Auth::user()->telephone }}" 
                               placeholder="Ex: 771234567" 
                               style="width: 100%; padding: 0.85rem 1rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; font-family: inherit; outline: none; transition: border-color 0.2s;">
                    </div>
                    <p style="font-size: 0.8rem; color: #666; margin-top: 8px;">
                        <i class="fas fa-info-circle"></i> S'il s'agit d'Orange Money, vous recevrez une demande de confirmation (push) sur ce numéro.
                    </p>
                </div>


                <div class="section-title">Paiement à la livraison</div>

                <!-- COD -->
                <label class="payment-option active" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="livraison_buyer" checked onchange="updateInputs(this)">
                    <div class="option-content">
                        <div class="option-title">Paiement cash à la livraison</div>
                        <div class="option-desc">Payez directement au livreur lors de la réception</div>
                    </div>
                    <div class="option-icon">
                        <i class="fas fa-hand-holding-usd" style="color: var(--rk-orange);"></i>
                    </div>
                </label>

                <input type="hidden" name="gestion_paiement" id="gestion_paiement" value="livraison_buyer">
                <input type="hidden" name="moyen_paiement" id="moyen_paiement" value="">
            </div>
        </form>
    </div>

    <div class="checkout-right">
        <div class="sidebar-summary">
            <div class="summary-title">Résumé de la commande</div>
            
            @foreach($cartGrouped as $vendeurId => $items)
                @foreach($items as $item)
                    <div class="summary-row">
                        <span>{{ $item->quantite }}x {{ Str::limit($item->annonce->titre, 24) }}</span>
                        <span>{{ number_format(($item->annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0)) * $item->quantite, 0, ',', ' ') }} F</span>
                    </div>
                @endforeach
            @endforeach

            <div class="summary-row" style="margin-top: 1rem; border-top: 1px dashed #eee; padding-top: 1rem;">
                <span>Sous-total</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} F CFA</span>
            </div>
            <div class="summary-row">
                <span>Livraison</span>
                <span style="color: #28a745; font-weight: 700;">Calculé à l'étape suivante</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} F CFA</span>
            </div>

            <div style="margin-top: 2rem;">
                <button type="button" onclick="confirmOrder(this)" class="btn-confirm" id="btn-confirm">
                    Confirmer le mode de paiement
                </button>
                <a href="{{ route('checkout.step1') }}" style="display: block; text-align: center; margin-top: 1rem; color: #999; font-size: 0.85rem; text-decoration: none;">
                    ← Revenir à la livraison
                </a>
            </div>
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

        if (val.startsWith('commande_')) {
            gp.value = 'commande';
            mp.value = val.replace('commande_', '');

            // Show/Hide phone input
            const directMethods = ['om', 'wave', 'free'];
            const phoneContainer = document.getElementById('phone_input_container');
            if (directMethods.includes(mp.value)) {
                phoneContainer.style.display = 'block';
                document.getElementById('phone_number').required = true;
            } else {
                phoneContainer.style.display = 'none';
                document.getElementById('phone_number').required = false;
            }
        } else {
            gp.value = val;
            mp.value = 'cod';
            document.getElementById('phone_input_container').style.display = 'none';
            document.getElementById('phone_number').required = false;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const checkedInput = document.querySelector('input[name="payment_choice"]:checked');
        if (checkedInput) updateInputs(checkedInput);
    });

    function confirmOrder(btn) {
        const selected = document.querySelector('input[name="payment_choice"]:checked');
        if (!selected) {
            btn.style.background = '#dc3545';
            btn.textContent = '⚠ Choisissez un mode de paiement';
            setTimeout(() => {
                btn.style.background = '';
                btn.textContent = 'Confirmer le mode de paiement';
            }, 2000);
            return;
        }
        btn.disabled = true;
        btn.style.background = '#28a745';
        btn.innerHTML = '✔ OK — Traitement en cours...';
        document.getElementById('paymentForm').submit();
    }
</script>
@endsection
