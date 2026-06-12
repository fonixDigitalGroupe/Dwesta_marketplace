@extends('layouts.app')

@section('title', 'Mode de Paiement - Étape 2 - Karnou')

@push('styles')
{{-- PayDunya PSR CSS --}}
<link rel="stylesheet" type="text/css" href="https://paydunya.com/assets/psr/css/psr.paydunya.min.css">
<style>
    :root {
        --rk-orange: #f58220;
        --rk-border: #eee;
        --rk-bg: #fdfdfd;
    }

    body { background-color: #f5f5f5; font-family: 'Inter', sans-serif; }

    .checkout-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; display: grid; grid-template-columns: 1fr 380px; gap: 2rem; }
    
    @media (max-width: 991px) {
        .checkout-container { grid-template-columns: 1fr; margin: 1rem auto; }
    }

    .checkout-main { background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
    
    .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 10px; font-weight: 700; color: #444; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .header-step { background: #4CAF50; color: white; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; }

    /* User Info Banner */
    .user-info-banner {
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #fff8f0 0%, #fff3e6 100%);
        border-bottom: 1px solid #fde8cc;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .user-avatar {
        width: 48px; height: 48px;
        background: var(--rk-orange);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 800; font-size: 1.2rem;
        flex-shrink: 0;
    }
    .user-details { flex: 1; }
    .user-name { font-weight: 800; font-size: 1rem; color: #222; }
    .user-meta { font-size: 0.85rem; color: #666; margin-top: 2px; }
    .user-meta span { margin-right: 12px; }
    .user-meta i { color: var(--rk-orange); margin-right: 4px; }

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
    .payment-option:hover, .payment-option.active { background: #fffaf5; }
    .payment-option.active { border-left: 3px solid var(--rk-orange); }

    .payment-option input {
        width: 24px; height: 24px;
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

    /* Sidebar */
    .sidebar-summary { background: #fff; border: 1px solid #ddd; padding: 1.75rem; border-radius: 8px; position: sticky; top: 1rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
    .summary-title { font-weight: 800; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #eee; font-size: 1.15rem; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #444; }
    .summary-total { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #f0f0f0; font-weight: 900; font-size: 1.35rem; display: flex; justify-content: space-between; color: #000; }
    
    .btn-pay {
        background: var(--rk-orange);
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 6px;
        font-weight: 800;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        margin-top: 1.5rem;
        box-shadow: 0 4px 12px rgba(245, 130, 32, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(245, 130, 32, 0.3); }
    .btn-pay:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .psr-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #e8f5e9; color: #2e7d32;
        padding: 2px 8px; border-radius: 4px;
        font-size: 0.7rem; font-weight: 700;
        border: 1px solid #c8e6c9;
    }

    @media (max-width: 480px) {
        .payment-option { padding: 1.25rem 1rem; }
        .option-title { font-size: 0.95rem; }
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="checkout-left">
        <div class="checkout-main">
            <div class="card-header">
                <span class="header-step"><i class="fas fa-check"></i></span>
                Mode de paiement
            </div>

            {{-- USER INFO BANNER --}}
            <div class="user-info-banner">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->prenom ?? 'U', 0, 1)) }}</div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-meta">
                        <span><i class="fas fa-envelope"></i>{{ Auth::user()->email }}</span>
                        <span><i class="fas fa-phone"></i>{{ Auth::user()->telephone ?? 'Non renseigné' }}</span>
                    </div>
                </div>
                <div>
                    <span class="psr-badge"><i class="fas fa-bolt"></i> Pré-rempli</span>
                </div>
            </div>

            {{-- MOBILE MONEY SECTION --}}
            <div class="section-group">
                <div class="section-title">Mobile Money</div>

                {{-- ORANGE MONEY --}}
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="om">
                    <div class="option-content">
                        <div class="option-title">
                            Avec Orange Money
                            <span class="option-amount">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="option-desc">Paiement rapide et sécurisé. Vos informations sont pré-remplies.</div>
                    </div>
                    <div class="option-icon">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png" alt="OM">
                    </div>
                </label>

                {{-- WAVE --}}
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="wave">
                    <div class="option-content">
                        <div class="option-title">
                            Avec Wave
                            <span class="option-amount">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="option-desc">Payez instantanément. Vos informations sont pré-remplies.</div>
                    </div>
                    <div class="option-icon">
                        <img src="{{ asset('images/logowave.png') }}" alt="Wave">
                    </div>
                </label>

                {{-- FREE MONEY --}}
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="free">
                    <div class="option-content">
                        <div class="option-title">Free Money</div>
                        <div class="option-desc">Utilisez votre compte Free Money pour payer.</div>
                    </div>
                    <div class="option-icon">
                        <img src="https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png" alt="Free Money">
                    </div>
                </label>
            </div>

            {{-- CARD SECTION --}}
            <div class="section-group">
                <div class="section-title">Carte Bancaire / International</div>
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="card">
                    <div class="option-content">
                        <div class="option-title">VISA, Mastercard</div>
                        <div class="option-desc">Paiement par carte bancaire internationale via PayDunya sécurisé.</div>
                    </div>
                    <div class="option-icon" style="gap: 5px; flex-direction: column;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" style="height: 12px;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" style="height: 18px;">
                    </div>
                </label>
            </div>

            {{-- COD SECTION --}}
            <div class="section-group">
                <div class="section-title">Paiement à la livraison</div>
                <label class="payment-option" onclick="selectOption(this)">
                    <input type="radio" name="payment_choice" value="cod">
                    <div class="option-content">
                        <div class="option-title">Paiement à la livraison</div>
                        <div class="option-desc">Payez dès réception de votre commande à domicile.</div>
                    </div>
                    <div class="option-icon">
                        <i class="fas fa-handshake" style="color: var(--rk-orange);"></i>
                    </div>
                </label>
            </div>
        </div>
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

            {{-- PSR POPUP BUTTON --}}
            <button class="btn-pay"
                id="btn-pay-psr"
                type="button"
                onclick="triggerPaydunya()"
                style="display: none;">
                <i class="fas fa-lock"></i>
                Payer {{ number_format($subtotal, 0, ',', ' ') }} FCFA
            </button>
            {{-- Hidden PSR trigger button required by PayDunya SDK --}}
            <button class="pay" id="paydunya-trigger"
                data-ref="karnou_{{ Auth::user()->id }}_{{ time() }}"
                data-fullname="{{ Auth::user()->name }}"
                data-email="{{ Auth::user()->email }}"
                data-phone="{{ str_replace('+', '', Auth::user()->telephone ?? '') }}"
                style="display:none;position:absolute;visibility:hidden;"
                onclick="payWithPaydunya(this)">pay</button>

            {{-- COD BUTTON (for cash on delivery) --}}
            <form action="{{ route('checkout.process') }}" method="POST" id="codForm" style="display:none;">
                @csrf
                <input type="hidden" name="gestion_paiement" value="livraison_buyer">
                <input type="hidden" name="moyen_paiement" value="cod">
                <button type="submit" class="btn-pay">
                    <i class="fas fa-handshake"></i>
                    Confirmer (Paiement à la livraison)
                </button>
            </form>

            {{-- DEFAULT BUTTON (visible before selection) --}}
            <button class="btn-pay" id="btn-select-first" onclick="alert('Veuillez sélectionner un mode de paiement.')">
                Sélectionner un mode de paiement
            </button>

            <a href="{{ route('checkout.step1') }}" style="display: block; text-align: center; margin-top: 1.25rem; color: #777; font-size: 0.85rem; text-decoration: none; font-weight: 500;">
                <i class="fas fa-arrow-left" style="font-size: 0.7rem; margin-right: 5px;"></i> Revenir à la livraison
            </a>
        </div>
    </div>
</div>

{{-- PayDunya PSR JavaScript --}}
<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="https://paydunya.com/assets/psr/js/psr.paydunya.min.js"></script>

<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="https://paydunya.com/assets/psr/js/psr.paydunya.min.js"></script>
<script>
    const TOKEN_URL = "{{ route('checkout.paydunya.token') }}";
    let selectedMethod = null;

    function selectOption(el) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
        el.classList.add('active');
        const input = el.querySelector('input');
        input.checked = true;
        selectedMethod = input.value;

        document.getElementById('btn-select-first').style.display = 'none';
        document.getElementById('codForm').style.display = 'none';
        document.getElementById('btn-pay-psr').style.display = 'none';

        if (selectedMethod === 'cod') {
            document.getElementById('codForm').style.display = 'block';
        } else {
            document.getElementById('btn-pay-psr').style.display = 'flex';
        }
    }

    function triggerPaydunya() {
        if (!selectedMethod) {
            alert('Veuillez sélectionner un mode de paiement.');
            return;
        }

        const btn = document.getElementById('btn-pay-psr');
        const trigger = document.getElementById('paydunya-trigger');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Connexion sécurisée...';

        const resetBtn = () => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock"></i> Payer {{ number_format($subtotal, 0, ',', ' ') }} FCFA';
        };

        PayDunya.setup({
            selector: $('#paydunya-trigger'),
            url: TOKEN_URL + '?payment_method=' + encodeURIComponent(selectedMethod),
            method: 'GET',
            displayMode: PayDunya.DISPLAY_IN_POPUP,
            beforeRequest: function() {},
            onSuccess: function(token) { resetBtn(); },
            onTerminate: function(ref, token, status) {
                if (status === 'completed') {
                    window.location.href = "{{ route('paydunya.success') }}?token=" + token;
                } else {
                    resetBtn();
                    if (status === 'failed') alert('Le paiement a échoué. Veuillez réessayer.');
                }
            },
            onError: function(error) {
                resetBtn();
                console.error('PayDunya error:', error);
                alert('Erreur de connexion. Veuillez réessayer.');
            },
            onUnsuccessfulResponse: function(r) { resetBtn(); console.log(r); },
            onClose: function() { resetBtn(); }
        }).requestToken();
    }

    // Global payWithPaydunya function required by PayDunya SDK for class="pay" buttons
    function payWithPaydunya(btn) { triggerPaydunya(); }
</script>
@endsection
