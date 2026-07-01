@extends('layouts.app')

@section('title', 'Effectuer un retrait - Karnou')

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

        .card-jumia {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
            font-size: 14px;
            font-weight: 500;
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
            transition: background 0.2s, opacity 0.2s;
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
            font-size: 14px;
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

        .wallet-alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wallet-alert.error {
            background-color: #fde8e8;
            color: #9b1c1c;
            border: 1px solid #f8b4b4;
        }

        .wallet-alert.success {
            background-color: #def7ec;
            color: #03543f;
            border: 1px solid #bcf0da;
        }

        /* Operator image styling */
        .operator-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e5e7eb;
        }

        /* Simplified Header/Footer Overrides */
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

        footer,
        .rk-footer {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="pay-container">

        <div class="section-title" style="margin-bottom: 10px;">
            <span>DISPONIBILITÉ DES FONDS</span>
        </div>
        <div
            style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #efefef; padding: 20px 24px; margin-bottom: 16px;">
            <div class="amount-display">
                <span class="amount-label" style="font-size: 13px;">SOLDE DISPONIBLE</span>
                <span class="amount-value" style="font-size: 15px; color: #2e7d32;">FCFA
                    {{ number_format($availableBalance, 0, ',', ' ') }}</span>
            </div>
        </div>

        @if(session('error'))
            <div class="wallet-alert error">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="wallet-alert success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($availableBalance > 0)
            <form action="{{ route('vendeur.wallet.withdraw') }}" method="POST" id="withdraw-form">
                @csrf

                <div class="section-title" style="margin-bottom: 10px; margin-top: 16px;">
                    <span>MONTANT DU RETRAIT</span>
                </div>
                <div class="card-jumia" style="margin-bottom: 0;">
                    <div class="card-section">
                        <div class="phone-input-wrapper" style="margin-top: 0;">
                            <label class="phone-label">Préciser le montant à retirer (FCFA)</label>
                            <div class="input-group-jumia">
                                <input type="number" id="montant" name="montant" class="jumia-input" min="1"
                                    max="{{ $availableBalance }}" required placeholder="0"
                                    style="font-size: 16px; font-weight: 700;" oninput="updateButtonText(this.value)">
                                <span style="font-weight: 700; color: #777; padding-right: 15px;">FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-title" style="margin-bottom: 10px; margin-top: 16px;">
                    <span>MODE DE RETRAIT</span>
                </div>
                <div class="card-jumia" style="margin-bottom: 0;">
                    <div class="card-section">
                        <div class="phone-input-wrapper" style="margin-top: 0;">
                            <label class="phone-label">Choisir un opérateur</label>
                            <div class="input-group-jumia" style="margin-bottom: 16px; background: white;">
                                <div class="input-prefix"
                                    style="background: white; border-right: none; padding: 10px; display: flex; align-items: center; justify-content: center; min-width: 50px;">
                                    <img id="operator-icon" class="operator-img" src="{{ asset('images/logoOM.png') }}">
                                </div>
                                <select id="moyen" name="moyen" class="jumia-input"
                                    style="border: none; background: transparent; appearance: none; cursor: pointer;"
                                    onchange="updateOperatorIcon(this.value)">
                                    <option value="om" selected>Orange Money</option>
                                    <option value="wave">Wave</option>
                                </select>
                                <div style="padding-right: 12px; color: #777;">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-title" style="margin-bottom: 10px; margin-top: 16px;">
                    <span>VOS COORDONNÉES DE RETRAIT</span>
                </div>
                <div class="card-jumia" style="margin-bottom: 0;">
                    <div class="card-section">
                        <div class="phone-input-wrapper" style="margin-top: 0;">
                            <label class="phone-label">Numéro de téléphone Mobile Money</label>
                            <div class="input-group-jumia">
                                <span class="input-prefix" style="display: flex; align-items: center; gap: 8px;">
                                    <img src="https://flagcdn.com/w20/sn.png" width="20" alt="Senegal">
                                    +221
                                </span>
                                <input type="text" name="telephone" id="telephone" class="jumia-input"
                                    value="{{ old('telephone', $user->telephone ? ltrim($user->telephone, '+221') : '') }}"
                                    required placeholder="7x xxx xx xx">
                            </div>
                            <p style="font-size: 11px; color: #75757a; margin-top: 6px; margin-bottom: 0;">Vérifiez
                                attentivement votre numéro avant de valider.</p>
                        </div>
                    </div>
                </div>

                <div class="card-jumia" style="margin-top: 16px;">
                    <div class="card-section" style="border-bottom: none;">
                        <button type="submit" id="btn-submit" class="btn-pay-now"
                            style="margin-top: 0; background-color: var(--karnou-blue); box-shadow: 0 4px 6px rgba(0, 74, 173, 0.2);">
                            VALIDER LE RETRAIT
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div
                style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px 24px; text-align: center; border: 1px solid #efefef;">
                <i class="fas fa-lock" style="font-size: 48px; color: #ccc; margin-bottom: 16px;"></i>
                <p style="font-size: 15px; color: #555; font-weight: 600;">Votre solde actuel
                    ({{ number_format($availableBalance, 0, ',', ' ') }} FCFA) ne permet pas d'effectuer de retrait.</p>
                <a href="{{ route('vendeur.wallet.index') }}" class="btn-pay-now"
                    style="background-color: var(--karnou-blue); display: inline-block; width: auto; padding: 12px 30px; text-decoration: none; margin-top: 16px;">Retourner
                    au Portefeuille</a>
            </div>
        @endif

        <div class="footer-links">
            <a href="{{ route('vendeur.wallet.index') }}" style="color: var(--karnou-blue); font-weight: 600;">← Retourner à
                votre Portefeuille</a>
        </div>

    </div>

    @push('scripts')
        <script>
            function updateOperatorIcon(value) {
                const icon = document.getElementById('operator-icon');
                const logos = {
                    'om': '{{ asset("images/logoOM.png") }}',
                    'wave': '{{ asset("images/logowave.png") }}'
                };
                icon.src = logos[value] || '';
            }

            function updateButtonText(val) {
                const btn = document.getElementById('btn-submit');
                if (!btn) return;
                const amount = parseFloat(val);
                if (amount > 0) {
                    btn.textContent = 'RETIRER MAINTENANT : FCFA ' + amount.toLocaleString('fr-FR');
                } else {
                    btn.textContent = 'VALIDER LE RETRAIT';
                }
            }
        </script>
    @endpush
@endsection