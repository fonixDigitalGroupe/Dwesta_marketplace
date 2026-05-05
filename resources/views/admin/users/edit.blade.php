@extends('layouts.admin')

@section('title', 'Modifier l\'utilisateur')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .main-content { background-color: #f8f9fa !important; }
        
        /* Input Amazon Style */
        input[type="text"]:focus, 
        input[type="email"]:focus, 
        input[type="tel"]:focus, 
        input[type="password"]:focus, 
        textarea:focus, 
        select:focus {
            border-color: #e77600 !important;
            box-shadow: 0 0 3px 2px rgba(228,121,17,0.5) !important;
            outline: none;
        }

        .amazon-card {
            background: #fff;
            border: 1px solid #e7e7e7;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 25px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: #111;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e7e7e7;
        }

        .btn-amazon-primary {
            background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
            border: 1px solid #a88734;
            color: #111;
            padding: 8px 24px;
            border-radius: 0;
            font-size: 0.85rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-amazon-primary:hover {
            background: linear-gradient(to bottom, #f5d78e, #eeb933);
            border-color: #9c7e31;
        }

        .btn-amazon-secondary {
            background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
            border: 1px solid #adb1b8;
            color: #111;
            padding: 8px 24px;
            border-radius: 0;
            font-size: 0.85rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .iti { width: 100%; }
        .iti__selected-flag { padding-right: 12px !important; position: relative; border-radius: 0 !important; }
        .iti__selected-flag::after { content: ""; position: absolute; right: 0; top: 20%; bottom: 20%; width: 1px; background-color: #adb1b8; pointer-events: none; }
        #telephone { padding-left: 55px !important; }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Modifier l'utilisateur : {{ $user->prenom }} {{ $user->nom }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn-amazon-secondary" style="gap: 8px;">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PATCH')

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: stretch;">
            
            <!-- Left Column: Personnel -->
            <div class="amazon-card">
                <h3 class="section-title">Informations Personnelles</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label for="prenom" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Prénom <small style="color: red;">*</small></label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" required
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                    </div>
                    <div>
                        <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Nom <small style="color: red;">*</small></label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" required
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="email" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Adresse Email <small style="color: red;">*</small></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label for="telephone" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Téléphone</label>
                        <input type="tel" id="telephone" value="{{ old('telephone', $user->telephone) }}"
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                        <input type="hidden" name="telephone" id="full_telephone" value="{{ old('telephone', $user->telephone) }}">
                    </div>
                    <div>
                        <label for="nationalite" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Nationalité</label>
                        <select name="nationalite" id="nationalite"
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; cursor: pointer;">
                            <option value="">Sélectionner...</option>
                            @php
                                $countries = ['Sénégal', 'Afrique du Sud', 'Algérie', 'Angola', 'Bénin', 'Burkina Faso', 'Cameroun', 'Centrafrique', 'Congo', 'Côte d\'Ivoire', 'Égypte', 'Gabon', 'Guinée', 'Mali', 'Maroc', 'Mauritanie', 'Niger', 'Nigeria', 'Tchad', 'Togo', 'Tunisie', 'Française'];
                            @endphp
                            @foreach($countries as $country)
                                <option value="{{ $country }}" {{ old('nationalite', $user->nationalite) == $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="adresse" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Adresse complète</label>
                    <textarea name="adresse" id="adresse" rows="4"
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; resize: vertical; font-family: inherit;">{{ old('adresse', $user->adresse) }}</textarea>
                </div>
            </div>

            <!-- Right Column: Config -->
            <div class="amazon-card">
                <h3 class="section-title">Accès & Rôle</h3>
                
                <div style="margin-bottom: 20px;">
                    <label for="role" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Rôle système <small style="color: red;">*</small></label>
                    <select name="role" id="role" required
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; cursor: pointer;">
                        <option value="">Choisir un rôle...</option>
                        @foreach($roles as $value => $label)
                            <option value="{{ $value }}" {{ old('role', $user->roles->first()?->name) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee;">
                    <p style="font-size: 0.8rem; color: #777; font-style: italic; margin-bottom: 10px;">Laissez vide pour conserver le mot de passe actuel.</p>
                    <div style="margin-bottom: 20px;">
                        <label for="password" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" autocomplete="new-password"
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="password_confirmation" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Confirmer nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                    </div>
                </div>

                <!-- Footer Actions in sidebar -->
                <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 30px;">
                    <button type="submit" class="btn-amazon-primary" style="padding: 12px;">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-amazon-secondary" style="padding: 12px;">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.querySelector("#telephone");
            var fullPhoneInput = document.querySelector("#full_telephone");
            var nationaliteSelect = document.querySelector("select[name='nationalite']");
            
            const countryMapping = {
                'Sénégal': 'sn', 'Afrique du Sud': 'za', 'Algérie': 'dz', 'Angola': 'ao', 'Bénin': 'bj', 
                'Burkina Faso': 'bf', 'Cameroun': 'cm', 'Centrafrique': 'cf', 'Congo': 'cg', "Côte d'Ivoire": 'ci', 
                'Égypte': 'eg', 'Gabon': 'ga', 'Guinée': 'gn', 'Mali': 'ml', 'Maroc': 'ma', 'Mauritanie': 'mr', 
                'Niger': 'ne', 'Nigeria': 'ng', 'Tchad': 'td', 'Togo': 'tg', 'Tunisie': 'tn', 'Française': 'fr'
            };
            
            var iti = window.intlTelInput(input, {
                initialCountry: "auto",
                geoIpLookup: function(success, failure) {
                    const countryCode = countryMapping[nationaliteSelect.value] || 'sn';
                    success(countryCode);
                },
                autoPlaceholder: "off",
                onlyCountries: Object.values(countryMapping),
                preferredCountries: ['sn', 'fr', 'cf'],
                nationalMode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            nationaliteSelect.addEventListener('change', function() {
                const countryCode = countryMapping[this.value];
                if (countryCode) iti.setCountry(countryCode);
            });

            const updateFullPhone = () => { fullPhoneInput.value = iti.getNumber(); };
            input.addEventListener('input', updateFullPhone);
            input.addEventListener('countrychange', updateFullPhone);
            input.closest('form').addEventListener('submit', updateFullPhone);
            
            if (nationaliteSelect.value) {
                const initialCountryCode = countryMapping[nationaliteSelect.value];
                if (initialCountryCode) iti.setCountry(initialCountryCode);
            }
        });
    </script>
@endpush
@endsection
