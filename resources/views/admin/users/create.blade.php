@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .iti { width: 100%; }
        .iti__selected-flag { padding-right: 12px !important; position: relative; }
        .iti__selected-flag::after { content: ""; position: absolute; right: 0; top: 20%; bottom: 20%; width: 1px; background-color: #e0e0e0; pointer-events: none; }
        #telephone { padding-left: 55px !important; }
    </style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Titre en majuscules -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            Créer un nouvel utilisateur
        </h2>

        <!-- Barre d'outils -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.users.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <i class="fas fa-arrow-left" style="font-size: 0.75rem; opacity: 0.6;"></i> Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Informations Personnelles
                        </h3>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div>
                                <label for="prenom" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Prénom <small style="color: red;">*</small></label>
                                <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Nom <small style="color: red;">*</small></label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="email" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Adresse Email <small style="color: red;">*</small></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div>
                                <label for="telephone" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Téléphone</label>
                                <input type="tel" id="telephone" value="{{ old('telephone') }}"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                <input type="hidden" name="telephone" id="full_telephone" value="{{ old('telephone') }}">
                            </div>
                            <div>
                                <label for="nationalite" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Nationalité</label>
                                <select name="nationalite" id="nationalite"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                    <option value="">Sélectionner...</option>
                                    @php
                                    $countries = ['Sénégal', 'Afrique du Sud', 'Algérie', 'Angola', 'Bénin', 'Burkina Faso', 'Cameroun', 'Centrafrique', 'Congo', 'Côte d\'Ivoire', 'Égypte', 'Gabon', 'Guinée', 'Mali', 'Maroc', 'Mauritanie', 'Niger', 'Nigeria', 'Tchad', 'Togo', 'Tunisie', 'Française'];
                                @endphp
                                @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ old('nationalite') == $country ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="adresse" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Adresse complète</label>
                            <textarea name="adresse" id="adresse" rows="2"
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical; font-family: inherit;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">{{ old('adresse') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
                        <h3 style="font-size: 0.9rem; color: #333; font-weight: 600; margin-bottom: 1.25rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">Configuration</h3>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label for="role" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Rôle <small style="color: red;">*</small></label>
                            <select name="role" id="role" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                <option value="">Choisir un rôle...</option>
                                @foreach($roles as $value => $label)
                                    <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="password" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Mot de passe</label>
                            <input type="password" name="password" id="password" autocomplete="new-password" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="password_confirmation" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Confirmation</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>

                        <!-- Buttons on the same line -->
                        <div style="display: flex; gap: 10px; margin-top: 1rem;">
                            <a href="{{ route('admin.users.index') }}" style="flex: 1; display: flex; justify-content: center; padding: 12px; background: #dc2626; border: none; border-radius: 6px; color: #fff; text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                Annuler
                            </a>
                            <button type="submit" style="flex: 1; background-color: #e67e00; color: #fff; border: none; padding: 12px; border-radius: 6px; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                Créer l'utilisateur
                            </button>
                        </div>
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
                initialCountry: "sn",
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
        });
    </script>
@endpush
@endsection
