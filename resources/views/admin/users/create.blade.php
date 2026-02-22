@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.users.index') }}" style="color: #666; text-decoration: none;">Gestion des Utilisateurs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Créer un utilisateur</span>
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

        <header style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Nouveau compte utilisateur</h1>
                <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Remplissez les informations pour créer un nouvel accès avec un rôle spécifique.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" 
               style="color: #000; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 6px; transition: all 0.2s; padding: 8px 0;"
               onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
        </header>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section 1: Identité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">
                            Identité Personnelle
                        </h2>
                        
                        <div style="display: grid; gap: 1.25rem;">


                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                                <div>
                                    <label for="prenom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Prénom <span style="color: red;">*</span></label>
                                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('prenom') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('prenom') ? '#dc3545' : '#e0e0e0' }}'">
                                </div>
                                <div>
                                    <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nom <span style="color: red;">*</span></label>
                                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
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
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('email') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#dc3545' : '#e0e0e0' }}'">
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                                <div>
                                    <label for="telephone" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Téléphone</label>
                                    <input type="tel" id="telephone" value="{{ old('telephone') }}"
                                        style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('telephone') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('telephone') ? '#dc3545' : '#e0e0e0' }}'">
                                    <input type="hidden" name="telephone" id="full_telephone" value="{{ old('telephone') }}">
                                </div>
                                <div>
                                    <label for="nationalite" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nationalité</label>
                                    <select name="nationalite" id="nationalite"
                                        style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('nationalite') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('nationalite') ? '#dc3545' : '#e0e0e0' }}'">
                                        <option value="" style="background-color: white;">Sélectionner...</option>
                                        <option value="Afrique du Sud" style="background-color: white;">Afrique du Sud</option>
                                        <option value="Algérie" style="background-color: white;">Algérie</option>
                                        <option value="Angola" style="background-color: white;">Angola</option>
                                        <option value="Bénin" style="background-color: white;">Bénin</option>
                                        <option value="Botswana" style="background-color: white;">Botswana</option>
                                        <option value="Burkina Faso" style="background-color: white;">Burkina Faso</option>
                                        <option value="Burundi" style="background-color: white;">Burundi</option>
                                        <option value="Cameroun" style="background-color: white;">Cameroun</option>
                                        <option value="Cap-Vert" style="background-color: white;">Cap-Vert</option>
                                        <option value="Centrafrique" {{ old('nationalite', 'Centrafrique') == 'Centrafrique' ? 'selected' : '' }} style="background-color: white;">Centrafrique</option>
                                        <option value="Comores" style="background-color: white;">Comores</option>
                                        <option value="Congo" style="background-color: white;">Congo</option>
                                        <option value="Côte d'Ivoire" style="background-color: white;">Côte d'Ivoire</option>
                                        <option value="Djibouti" style="background-color: white;">Djibouti</option>
                                        <option value="Égypte" style="background-color: white;">Égypte</option>
                                        <option value="Érythrée" style="background-color: white;">Érythrée</option>
                                        <option value="Eswatini" style="background-color: white;">Eswatini</option>
                                        <option value="Éthiopie" style="background-color: white;">Éthiopie</option>
                                        <option value="Gabon" style="background-color: white;">Gabon</option>
                                        <option value="Gambie" style="background-color: white;">Gambie</option>
                                        <option value="Ghana" style="background-color: white;">Ghana</option>
                                        <option value="Guinée" style="background-color: white;">Guinée</option>
                                        <option value="Guinée-Bissau" style="background-color: white;">Guinée-Bissau</option>
                                        <option value="Guinée équatoriale" style="background-color: white;">Guinée équatoriale</option>
                                        <option value="Kenya" style="background-color: white;">Kenya</option>
                                        <option value="Lesotho" style="background-color: white;">Lesotho</option>
                                        <option value="Liberia" style="background-color: white;">Liberia</option>
                                        <option value="Libye" style="background-color: white;">Libye</option>
                                        <option value="Madagascar" style="background-color: white;">Madagascar</option>
                                        <option value="Malawi" style="background-color: white;">Malawi</option>
                                        <option value="Mali" style="background-color: white;">Mali</option>
                                        <option value="Maroc" style="background-color: white;">Maroc</option>
                                        <option value="Maurice" style="background-color: white;">Maurice</option>
                                        <option value="Mauritanie" style="background-color: white;">Mauritanie</option>
                                        <option value="Mozambique" style="background-color: white;">Mozambique</option>
                                        <option value="Namibie" style="background-color: white;">Namibie</option>
                                        <option value="Niger" style="background-color: white;">Niger</option>
                                        <option value="Nigeria" style="background-color: white;">Nigeria</option>
                                        <option value="Ouganda" style="background-color: white;">Ouganda</option>
                                        <option value="République Démocratique du Congo" style="background-color: white;">RDC</option>
                                        <option value="Rwanda" style="background-color: white;">Rwanda</option>
                                        <option value="Sao Tomé-et-Principe" style="background-color: white;">Sao Tomé-et-Principe</option>
                                        <option value="Sénégal" style="background-color: white;">Sénégal</option>
                                        <option value="Seychelles" style="background-color: white;">Seychelles</option>
                                        <option value="Sierra Leone" style="background-color: white;">Sierra Leone</option>
                                        <option value="Somalie" style="background-color: white;">Somalie</option>
                                        <option value="Soudan" style="background-color: white;">Soudan</option>
                                        <option value="Soudan du Sud" style="background-color: white;">Soudan du Sud</option>
                                        <option value="Tanzanie" style="background-color: white;">Tanzanie</option>
                                        <option value="Tchad" style="background-color: white;">Tchad</option>
                                        <option value="Togo" style="background-color: white;">Togo</option>
                                        <option value="Tunisie" style="background-color: white;">Tunisie</option>
                                        <option value="Zambie" style="background-color: white;">Zambie</option>
                                        <option value="Zimbabwe" style="background-color: white;">Zimbabwe</option>
                                        <option value="Française" style="background-color: white;">Française</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="adresse" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Adresse complète</label>
                                <textarea name="adresse" id="adresse" rows="2"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('adresse') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('adresse') ? '#dc3545' : '#e0e0e0' }}'">{{ old('adresse') }}</textarea>
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
                                        <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }} style="background-color: white;">
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
                        
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <div>
                                <label for="password" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Mot de passe</label>
                                <div style="position: relative;">
                                    <input type="password" name="password" id="create_password" autocomplete="new-password"
                                        style="width: 100%; padding: 10px 40px 10px 14px; border: 1px solid {{ $errors->has('password') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('password') ? '#dc3545' : '#e0e0e0' }}'">
                                    <button type="button" onclick="togglePasswordVisibility('create_password', this)" 
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
                                    <input type="password" name="password_confirmation" id="create_password_confirmation" autocomplete="new-password"
                                        style="width: 100%; padding: 10px 40px 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                    <button type="button" onclick="togglePasswordVisibility('create_password_confirmation', this)" 
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
                            Créer l'utilisateur
                        </button>
                        
                        <a href="{{ route('admin.users.index') }}" 
                           style="width: 100%; padding: 12px; background: transparent; color: #666; border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 500; text-align: center; text-decoration: none; cursor: pointer; transition: all 0.2s;"
                           onmouseover="this.style.backgroundColor='#f8fafc'; this.style.borderColor='#cbd5e1'; this.style.color='#333'" 
                           onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#e0e0e0'; this.style.color='#666'">
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
                initialCountry: "cf",
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

            // Auto-generate password
            function generateDefaultPassword(length = 12) {
                const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
                let retVal = "";
                for (let i = 0; i < length; ++i) {
                    retVal += charset.charAt(Math.floor(Math.random() * charset.length));
                }
                return retVal;
            }

            const defaultPass = generateDefaultPassword();
            const passInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            
            if (!passInput.value) {
                passInput.value = defaultPass;
                confirmInput.value = defaultPass;
            }

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
        });
    </script>
@endpush
@endsection
