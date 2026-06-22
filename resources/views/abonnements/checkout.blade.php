@extends('layouts.app')

@section('title', 'Finaliser le paiement - Karnou')

@push('styles')
<style>
    :root {
        --karnou-blue: #2196F3;
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
        padding: 0 15px 80px;
    }

    /* Card Jumia Style */
    .card-jumia {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 16px;
        border: 1px solid #efefef;
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
        margin-bottom: 10px;
        display: block;
    }

    .amount-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .amount-label {
        font-weight: 700;
        font-size: 13px;
        color: #313133;
    }

    .amount-value {
        font-weight: 700;
        font-size: 15px;
        color: var(--karnou-blue);
    }

    /* Input Groups */
    .phone-input-wrapper {
        margin-top: 0;
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
        padding: 10px;
        color: #666;
        font-weight: 600;
        border-right: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 50px;
    }

    .jumia-select {
        flex: 1;
        padding: 12px;
        border: none;
        outline: none;
        font-size: 14px;
        font-weight: 500;
        background: transparent;
        appearance: none;
        cursor: pointer;
    }

    .jumia-input {
        flex: 1;
        padding: 12px;
        border: none;
        outline: none;
        font-size: 14px;
        font-weight: 500;
    }

    /* Button Pay */
    .btn-pay-now {
        display: block;
        width: 100%;
        background: var(--karnou-blue);
        color: white;
        text-align: center;
        padding: 16px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.2s;
        box-shadow: 0 4px 6px rgba(33, 150, 243, 0.2);
    }

    .btn-pay-now:hover {
        background: #1976D2;
    }

    .security-note {
        text-align: center;
        font-size: 14px;
        color: #75757a;
        margin-top: 24px;
        line-height: 1.6;
    }

    .security-note a {
        color: var(--karnou-blue);
        font-weight: 600;
        text-decoration: none;
    }

    /* Auto-renew switch */
    .autorenew-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-top: 1px solid #f0f0f0;
    }

    .autorenew-text {
        font-size: 13px;
        color: #555;
    }

    /* Simplified Header Override */
    .top-banner, .mobile-menu-btn, .search-container, .header-actions, .mobile-search-row, .header-row-2 {
        display: none !important;
    }
    .header-row-1 .header-container { justify-content: center !important; }
    .header-logo-text img { height: 26px !important; }
    footer, .rk-footer { display: none !important; }
</style>
@endpush

@section('content')
<div class="pay-container">

    <form action="{{ route('abonnements.subscribe') }}" method="POST">
        @csrf
        <input type="hidden" name="abonnement_id" value="{{ $abonnement->id }}">

        {{-- Section: Récapitulatif --}}
        <div class="section-title">RÉCAPITULATIF DE PAIEMENT</div>
        <div class="card-jumia" style="padding: 20px 24px;">
            <div class="amount-display">
                <span class="amount-label">Abonnement {{ $abonnement->nom }}</span>
                <span class="amount-value">FCFA {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }}</span>
            </div>
        </div>

        @if($abonnement->prix_mensuel > 0)
            {{-- Section: Mode de Paiement --}}
            <div class="section-title" style="margin-top: 16px;">MODE DE PAIEMENT SÉLECTIONNÉ</div>
            <div class="card-jumia">
                <div class="card-section">
                    <label class="phone-label">Choisir un opérateur</label>
                    <div class="input-group-jumia">
                        <div class="input-prefix" style="background: white; border-right: none;">
                            <img id="operator-icon" src="{{ asset('images/logowave.png') }}" style="width: 32px; height: 32px; object-fit: contain;">
                        </div>
                        <select name="payment_method" id="moyen_paiement" class="jumia-select" onchange="updateOperatorIcon(this.value)">
                            <option value="wave" selected>Wave Senegal</option>
                            <option value="om">Orange Money</option>
                            <option value="free">Free Money</option>
                            <option value="cb">Carte Bancaire (Visa/Mastercard)</option>
                        </select>
                        <div style="padding-right: 12px; color: #777;">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: Coordonnées --}}
            <div class="section-title" style="margin-top: 16px;">VOS COORDONNÉES</div>
            <div class="card-jumia">
                <div class="card-section">
                    <div class="phone-input-wrapper">
                        <label class="phone-label">Numéro de téléphone</label>
                        <div class="input-group-jumia">
                            <span class="input-prefix" style="display: flex; align-items: center; gap: 8px;">
                                <img src="https://flagcdn.com/w20/sn.png" width="20" alt="Senegal">
                                +221
                            </span>
                            <input type="text" name="phone" class="jumia-input" value="{{ Auth::user()->telephone ? ltrim(Auth::user()->telephone, '+221') : '' }}" placeholder="7x xxx xx xx">
                        </div>
                    </div>

                    <div class="phone-input-wrapper" style="margin-top: 12px;">
                        <label class="phone-label">Adresse E-mail</label>
                        <div class="input-group-jumia">
                            <span class="input-prefix" style="background: white; border-right: none;">
                                <i class="fas fa-envelope" style="color: #666;"></i>
                            </span>
                            <input type="email" name="email" class="jumia-input" value="{{ Auth::user()->email }}" placeholder="exemple@mail.com">
                        </div>
                    </div>

                    {{-- Auto-renew inside coordinates or at end --}}
                    <div class="autorenew-container" style="margin-top: 20px;">
                        <span class="autorenew-text">Renouvellement automatique</span>
                        <div class="form-check form-switch" style="padding-left: 2.5em;">
                            <input class="form-check-input" type="checkbox" name="auto_renew" value="1" id="auto_renew" checked style="width: 2.5em; height: 1.25em; cursor: pointer;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-jumia" style="margin-top: 16px; border: none; box-shadow: none; background: transparent;">
                <button type="submit" class="btn-pay-now">
                    PAYER MAINTENANT : FCFA {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }}
                </button>
            </div>
        @else
            {{-- Forfait Gratuit --}}
            <input type="hidden" name="payment_method" value="cb">
            <div class="card-jumia" style="padding: 24px; text-align: center; background: #eef2ff;">
                <p style="color: #2196F3; font-weight: 700; margin-bottom: 20px;">Ce forfait est gratuit. Cliquez ci-dessous pour l'activer.</p>
                <button type="submit" class="btn-pay-now">ACTIVER GRATUITEMENT</button>
            </div>
        @endif

        <p class="security-note">
            En cliquant sur le bouton de confirmation, j'accepte les <a href="{{ route('terms') }}">Conditions générales d'utilisation</a>.<br><br>
            <strong>Note:</strong> Karnou ne vous demandera jamais votre mot de passe ou votre code PIN par téléphone.
        </p>

        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('abonnements.index') }}" style="color: #777; font-size: 13px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Annuler et retourner aux choix
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function updateOperatorIcon(value) {
        const icon = document.getElementById('operator-icon');
        const logos = {
            'wave': '{{ asset("images/logowave.png") }}',
            'om': '{{ asset("images/logoOM.png") }}',
            'free': 'https://seeklogo.com/images/F/free-money-logo-A9D7E8B8B5-seeklogo.com.png',
            'cb': 'https://cdn-icons-png.flaticon.com/512/633/633611.png'
        };
        icon.src = logos[value] || '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('moyen_paiement');
        if (select) updateOperatorIcon(select.value);
    });
</script>
@endpush
@endsection
