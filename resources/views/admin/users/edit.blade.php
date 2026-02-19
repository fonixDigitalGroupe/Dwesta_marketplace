@extends('layouts.admin')

@section('title', 'Modifier l\'utilisateur')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.users.index') }}" style="color: #666; text-decoration: none;">Gestion des Utilisateurs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Modifier l'utilisateur</span>
@endsection

@section('content')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .iti {
            width: 100%;
        }
        /* Vertical separator for phone input - using pseudo-element to avoid blocking focus */
        .iti__selected-flag {
            padding-right: 12px !important;
            position: relative;
        }
        .iti__selected-flag::after {
            content: "";
            position: absolute;
            right: 0;
            top: 20%;
            bottom: 20%;
            width: 1px;
            background-color: #e0e0e0;
            pointer-events: none;
        }
        #telephone {
            padding-left: 55px !important;
        }
    </style>
@endpush
    <div style="max-width: 1000px; margin: 0 auto;">

        <header style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Modifier le compte utilisateur</h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Mettez à jour les informations de l'utilisateur.</p>
        </header>

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PATCH')

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section 1: Identité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">
                            Identité Personnelle
                        </h2>
                        
                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Civilité</label>
                                <div style="display: flex; gap: 20px;">
                                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.95rem; color: #333;">
                                        <input type="radio" name="civilite" value="M." {{ old('civilite', $user->civilite) == 'M.' ? 'checked' : '' }} style="accent-color: #ff750f; width: 18px; height: 18px;">
                                        M.
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.95rem; color: #333;">
                                        <input type="radio" name="civilite" value="Mme" {{ old('civilite', $user->civilite) == 'Mme' ? 'checked' : '' }} style="accent-color: #ff750f; width: 18px; height: 18px;">
                                        Mme
                                    </label>
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                                <div>
                                    <label for="prenom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Prénom <span style="color: red;">*</span></label>
                                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('prenom') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('prenom') ? '#dc3545' : '#e0e0e0' }}'">
                                </div>
                                <div>
                                    <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nom <span style="color: red;">*</span></label>
                                    <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('nom') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('nom') ? '#dc3545' : '#e0e0e0' }}'">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Contact & Localisation -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">
                            Coordonnées & Localisation
                        </h2>
                        
                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label for="email" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Adresse Email <span style="color: red;">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('email') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#dc3545' : '#e0e0e0' }}'">
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                                <div>
                                    <label for="telephone" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Téléphone</label>
                                    <input type="tel" id="telephone" value="{{ old('telephone', $user->telephone) }}"
                                        style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('telephone') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('telephone') ? '#dc3545' : '#e0e0e0' }}'">
                                    <input type="hidden" name="telephone" id="full_telephone" value="{{ old('telephone', $user->telephone) }}">
                                </div>
                                <div>
                                    <label for="nationalite" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nationalité</label>
                                    <select name="nationalite" id="nationalite"
                                        style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('nationalite') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('nationalite') ? '#dc3545' : '#e0e0e0' }}'">
                                        <option value="" style="background-color: white;">Sélectionner...</option>
                                        @foreach(['Afrique du Sud', 'Algérie', 'Angola', 'Bénin', 'Botswana', 'Burkina Faso', 'Burundi', 'Cameroun', 'Cap-Vert', 'Centrafrique', 'Comores', 'Congo', 'Côte d\'Ivoire', 'Djibouti', 'Égypte', 'Érythrée', 'Eswatini', 'Éthiopie', 'Gabon', 'Gambie', 'Ghana', 'Guinée', 'Guinée-Bissau', 'Guinée équatoriale', 'Kenya', 'Lesotho', 'Liberia', 'Libye', 'Madagascar', 'Malawi', 'Mali', 'Maroc', 'Maurice', 'Mauritanie', 'Mozambique', 'Namibie', 'Niger', 'Nigeria', 'Ouganda', 'République Démocratique du Congo', 'Rwanda', 'Sao Tomé-et-Principe', 'Sénégal', 'Seychelles', 'Sierra Leone', 'Somalie', 'Soudan', 'Soudan du Sud', 'Tanzanie', 'Tchad', 'Togo', 'Tunisie', 'Zambie', 'Zimbabwe', 'Française'] as $country)
                                            <option value="{{ $country }}" {{ old('nationalite', $user->nationalite) == $country ? 'selected' : '' }} style="background-color: white;">{{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="adresse" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Adresse complète</label>
                                <textarea name="adresse" id="adresse" rows="2"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('adresse') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('adresse') ? '#dc3545' : '#e0e0e0' }}'">{{ old('adresse', $user->adresse) }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Configuration -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.25rem;">Habilitations</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div>
                                <label for="role" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Rôle Système</label>
                                <select name="role" id="role"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('role') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('role') ? '#dc3545' : '#e0e0e0' }}'">
                                    <option value="" style="background-color: white;">Sélectionner un rôle...</option>
                                    @foreach($roles as $value => $label)
                                        <option value="{{ $value }}" {{ old('role', $user->roles->first()?->name) == $value ? 'selected' : '' }} style="background-color: white;">
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Sécurité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.25rem;">Sécurité</h3>
                        <p style="font-size: 0.8rem; color: #666; margin-bottom: 1rem;">Laissez vide pour conserver le mot de passe actuel.</p>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <div>
                                <label for="password" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nouveau mot de passe</label>
                                <div style="position: relative;">
                                    <input type="password" name="password" id="edit_password" autocomplete="new-password"
                                        style="width: 100%; padding: 10px 40px 10px 14px; border: 1px solid {{ $errors->has('password') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('password') ? '#dc3545' : '#e0e0e0' }}'">
                                    <button type="button" onclick="togglePasswordVisibility('edit_password', this)" 
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer; color: #999;">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="eye-open">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="eye-closed" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.053 0 2.062.18 3 .512M19.5 19.5L4.5 4.5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.73 5.08A10.43 10.43 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.057 10.057 0 01-1.55 3.593M9.88 9.88l4.24 4.24"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label for="password_confirmation" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Confirmer le mot de passe</label>
                                <div style="position: relative;">
                                    <input type="password" name="password_confirmation" id="edit_password_confirmation" autocomplete="new-password"
                                        style="width: 100%; padding: 10px 40px 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                    <button type="button" onclick="togglePasswordVisibility('edit_password_confirmation', this)" 
                                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer; color: #999;">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="eye-open">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="eye-closed" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.053 0 2.062.18 3 .512M19.5 19.5L4.5 4.5"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.73 5.08A10.43 10.43 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.057 10.057 0 01-1.55 3.593M9.88 9.88l4.24 4.24"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" 
                                style="width: 100%; padding: 12px; background: #000; color: #fff; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'" 
                                onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                            Mettre à jour l'utilisateur
                        </button>
                        
                        <a href="{{ route('admin.users.index') }}" 
                           style="width: 100%; padding: 12px; background: transparent; color: #666; border: none; border-radius: 8px; font-weight: 500; text-align: center; text-decoration: none; cursor: pointer; transition: all 0.2s;"
                           onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.color='#333'" 
                           onmouseout="this.style.backgroundColor='transparent'; this.style.color='#666'">
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
                'Afrique du Sud': 'za', 'Algérie': 'dz', 'Angola': 'ao', 'Bénin': 'bj', 'Botswana': 'bw',
                'Burkina Faso': 'bf', 'Burundi': 'bi', 'Cameroun': 'cm', 'Cap-Vert': 'cv', 'Centrafrique': 'cf',
                'Comores': 'km', 'Congo': 'cg', "Côte d'Ivoire": 'ci', 'Djibouti': 'dj', 'Égypte': 'eg',
                'Érythrée': 'er', 'Eswatini': 'sz', 'Éthiopie': 'et', 'Gabon': 'ga', 'Gambie': 'gm',
                'Ghana': 'gh', 'Guinée': 'gn', 'Guinée-Bissau': 'gw', 'Guinée équatoriale': 'gq', 'Kenya': 'ke',
                'Lesotho': 'ls', 'Liberia': 'lr', 'Libye': 'ly', 'Madagascar': 'mg', 'Malawi': 'mw',
                'Mali': 'ml', 'Maroc': 'ma', 'Maurice': 'mu', 'Mauritanie': 'mr', 'Mozambique': 'mz',
                'Namibie': 'na', 'Niger': 'ne', 'Nigeria': 'ng', 'Ouganda': 'ug', 'République Démocratique du Congo': 'cd',
                'Rwanda': 'rw', 'Sao Tomé-et-Principe': 'st', 'Sénégal': 'sn', 'Seychelles': 'sc', 'Sierra Leone': 'sl',
                'Somalie': 'so', 'Soudan': 'sd', 'Soudan du Sud': 'ss', 'Tanzanie': 'tz', 'Tchad': 'td',
                'Togo': 'tg', 'Tunisie': 'tn', 'Zambie': 'zm', 'Zimbabwe': 'zw', 'Française': 'fr'
            };
            
            var iti = window.intlTelInput(input, {
                initialCountry: "auto",
                geoIpLookup: function(success, failure) {
                    const countryCode = countryMapping[nationaliteSelect.value] || 'cf';
                    success(countryCode);
                },
                autoPlaceholder: "off",
                onlyCountries: [
                    "fr", "dz", "ao", "bj", "bw", "bf", "bi", "cm", "cv", "cf", "td", "km", "cg", "cd", "ci", 
                    "dj", "eg", "gq", "er", "sz", "et", "ga", "gm", "gh", "gn", "gw", "ke", "ls", "lr", 
                    "ly", "mg", "mw", "ml", "mr", "mu", "ma", "mz", "na", "ne", "ng", "rw", "st", "sn", 
                    "sc", "sl", "so", "za", "ss", "sd", "tz", "tg", "tn", "ug", "zm", "zw"
                ],
                preferredCountries: ['cf', 'fr', 'cm', 'td', 'cg', 'ga'],
                nationalMode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            nationaliteSelect.addEventListener('change', function() {
                const countryCode = countryMapping[this.value];
                if (countryCode) iti.setCountry(countryCode);
            });

            const updateFullPhone = () => {
                fullPhoneInput.value = iti.getNumber();
            };

            input.addEventListener('input', updateFullPhone);
            input.addEventListener('countrychange', updateFullPhone);
            
            var form = input.closest('form');
            form.addEventListener('submit', updateFullPhone);

            window.togglePasswordVisibility = function(inputId, button) {
                const input = document.getElementById(inputId);
                const eyeOpen = button.querySelector('.eye-open');
                const eyeClosed = button.querySelector('.eye-closed');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.style.display = 'none';
                    eyeClosed.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeOpen.style.display = 'block';
                    eyeClosed.style.display = 'none';
                }
            };

            // Set initial country based on nationality
            const initialCountryCode = countryMapping[nationaliteSelect.value];
            if (initialCountryCode) {
                iti.setCountry(initialCountryCode);
            }
        });
    </script>
@endpush
@endsection
