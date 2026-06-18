@extends('layouts.app')

@section('title', 'Finaliser le paiement - Karnou')

@push('styles')
<style>
    :root {
        --karnou-blue: #004aad;
        --karnou-orange: #f68b1e;
        --bg-gray: #f0f2f2;
    }

    body {
        background-color: var(--bg-gray);
        font-family: 'Inter', sans-serif;
    }

    .pay-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 15px;
    }

    .brand-header {
        text-align: center;
        margin-bottom: 24px;
    }

    .brand-logo {
        height: 40px;
    }

    .card-jumia {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .card-section {
        padding: 24px;
        border-bottom: 1px solid #eee;
    }

    .card-section:last-child {
        border-bottom: none;
    }

    .section-title {
        color: #75757a;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 16px;
        display: flex;
        justify-content: space-between;
    }

    .amount-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .amount-label {
        font-weight: 700;
        font-size: 14px;
        color: #313133;
    }

    .amount-value {
        font-weight: 700;
        font-size: 18px;
        color: #2196F3;
    }

    .method-box {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .method-icon {
        width: 48px;
        height: 48px;
        object-fit: contain;
    }

    .method-name {
        font-weight: 600;
        font-size: 15px;
    }

    .phone-input-wrapper {
        margin-top: 20px;
    }

    .phone-label {
        font-size: 13px;
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
        display: block;
    }

    .input-group-jumia {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .input-group-jumia:focus-within {
        border-color: var(--karnou-blue);
    }

    .input-prefix {
        background: #f0f0f0;
        padding: 12px;
        color: #666;
        font-weight: 600;
        border-right: 1px solid #ddd;
    }

    .jumia-input {
        flex: 1;
        padding: 12px;
        border: none;
        outline: none;
        font-size: 16px;
        font-weight: 600;
    }

    .btn-pay-now {
        display: block;
        width: 100%;
        background: #2196F3;
        color: white;
        text-align: center;
        padding: 16px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        margin-top: 24px;
        box-shadow: 0 4px 6px rgba(33, 150, 243, 0.2);
        transition: background 0.2s;
    }

    .btn-pay-now:hover {
        background: #1976D2;
    }

    .btn-pay-now:disabled {
        background: #ccc;
        cursor: not-allowed;
        box-shadow: none;
    }

    .security-note {
        text-align: center;
        font-size: 12px;
        color: #75757a;
        margin-top: 24px;
        line-height: 1.6;
    }

    .footer-links {
        text-align: center;
        margin-top: 32px;
    }

    .footer-links a {
        color: #007185;
        text-decoration: none;
        font-size: 13px;
    }

    /* Loader */
    .btn-loader {
        display: none;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Simplified Header Override */
    .top-banner,
    .mobile-menu-btn,
    .search-container,
    .header-actions,
    .mobile-search-row,
    .header-row-2 {
        display: none !important;
    }

    .header-row-1 .header-container {
        justify-content: center !important;
    }

    .header-logo-text img {
        height: 26px !important;
    }
</style>
@endpush

@section('content')
<div class="pay-container">

    <div class="card-jumia">
        <div class="card-section">
            <div class="section-title">
                <span>RÉCAPITULATIF DE PAIEMENT</span>
            </div>
            <div class="amount-display">
                <span class="amount-label">{{ $description ?? 'MONTANT TOTAL À PAYER' }}</span>
                <span class="amount-value">FCFA {{ number_format($total, 0, ',', ' ') }}</span>
            </div>
        </div>

        <div class="card-section">
            <div class="section-title">MODE DE PAIEMENT SÉLECTIONNÉ</div>
            
            <div class="phone-input-wrapper" style="margin-top: 0;">
                <label class="phone-label">Choisir un opérateur</label>
                <div class="input-group-jumia" style="margin-bottom: 16px; background: white;">
                    <div class="input-prefix" style="background: white; border-right: none; padding: 10px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                        <img id="operator-icon" src="{{ $moyenPaiement == 'om' ? 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png' : ($moyenPaiement == 'wave' ? asset('images/logowave.png') : 'https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png') }}" 
                             style="width: 32px; height: 32px; object-fit: contain;">
                    </div>
                    <select id="moyen_paiement" class="jumia-input" style="border: none; background: transparent; appearance: none; cursor: pointer;" onchange="updateOperatorIcon(this.value)">
                        <option value="wave" {{ $moyenPaiement == 'wave' ? 'selected' : '' }}>Wave Senegal</option>
                        <option value="om" {{ $moyenPaiement == 'om' ? 'selected' : '' }}>Orange Money</option>
                        <option value="free" {{ $moyenPaiement == 'free' ? 'selected' : '' }}>Free Money</option>
                        <option value="cb" {{ $moyenPaiement == 'cb' ? 'selected' : '' }}>Carte Bancaire (Visa/Mastercard)</option>
                    </select>
                    <div style="padding-right: 12px; color: #777;">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>

            <div class="phone-input-wrapper">
                <label class="phone-label">Numéro de téléphone</label>
                <div class="input-group-jumia">
                    <span class="input-prefix" style="display: flex; align-items: center; gap: 8px;">
                        <img src="https://flagcdn.com/w20/sn.png" srcset="https://flagcdn.com/w40/sn.png 2x" width="20" alt="Senegal">
                        +221
                    </span>
                    <input type="text" id="phone_pay" class="jumia-input" value="{{ $buyer->telephone ?? Auth::user()->telephone ? ltrim(Auth::user()->telephone, '+221') : '' }}" placeholder="7x xxx xx xx">
                </div>
            </div>

            <div class="phone-input-wrapper">
                <label class="phone-label">Adresse E-mail</label>
                <div class="input-group-jumia">
                    <span class="input-prefix" style="background: white; border-right: none;">
                        <i class="fas fa-envelope" style="color: #666;"></i>
                    </span>
                    <input type="email" id="email_pay" class="jumia-input" value="{{ $buyer->email ?? Auth::user()->email ?? '' }}" placeholder="exemple@mail.com">
                </div>
            </div>

            <button id="btn-pay" class="btn-pay-now" onclick="initiatePayment()">
                <span id="btn-text">PAYER MAINTENANT : FCFA {{ number_format($total, 0, ',', ' ') }}</span>
                <div id="btn-spinner" class="btn-loader"></div>
            </button>
        </div>
    </div>

    <p class="security-note">
        En cliquant sur "PAYER MAINTENANT", j'accepte les <a href="#">Conditions générales d'utilisation</a> et les <a href="#">Politiques de confidentialité</a>.<br><br>
        <strong>Note:</strong> Karnou ne vous demandera jamais votre mot de passe, votre code PIN, votre code CVV ou les détails complets de votre carte par téléphone ou par e-mail.
    </p>

    <div class="footer-links">
        <a href="{{ route('home') }}">Retour vers KARNOU MARKETPLACE</a>
    </div>
</div>

@push('scripts')
<script>
    function updateOperatorIcon(value) {
        const icon = document.getElementById('operator-icon');
        const logos = {
            'wave': '{{ asset("images/logowave.png") }}',
            'om': 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Orange_Money_logo.svg/1024px-Orange_Money_logo.svg.png',
            'free': 'https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png',
            'cb': 'https://cdn-icons-png.flaticon.com/512/633/633611.png'
        };
        icon.src = logos[value] || '';
    }

    async function initiatePayment() {
        const btn = document.getElementById('btn-pay');
        const btnText = document.getElementById('btn-text');
        const spinner = document.getElementById('btn-spinner');
        const phone = document.getElementById('phone_pay').value;
        const email = document.getElementById('email_pay').value;

        // Validation basique
        if (!phone || phone.length < 9) {
            alert('Veuillez entrer un numéro de téléphone valide.');
            return;
        }

        if (!email || !email.includes('@')) {
            alert('Veuillez entrer une adresse e-mail valide.');
            return;
        }

        // UI State
        btn.disabled = true;
        btnText.style.display = 'none';
        spinner.style.display = 'block';

        try {
            const response = await fetch('{{ route("checkout.process-softpay", $token) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    phone_number: '+221' + phone.replace(/^(\+221|00221)/, '').replace(/\s/g, ''),
                    email: email,
                    moyen_paiement: document.getElementById('moyen_paiement').value
                })
            });

            const result = await response.json();

            if (result.success) {
                // Redirection directe vers le wallet ou page de succès (push)
                window.location.href = result.redirect_url;
            } else {
                alert('Erreur: ' + (result.message || 'Le paiement n\'a pas pu être initié.'));
                btn.disabled = false;
                btnText.style.display = 'block';
                spinner.style.display = 'none';
            }
        } catch (error) {
            console.error('Payment error:', error);
            alert('Une erreur technique est survenue.');
            btn.disabled = false;
            btnText.style.display = 'block';
            spinner.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
