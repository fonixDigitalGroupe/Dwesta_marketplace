@extends('layouts.admin')

@section('title', 'Nouveau Point Relais')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.point-relais.index') }}">Points Relais</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Ajouter</span>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">

    <header style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Nouveau Point Relais</h1>
        <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Configurez les paramètres d'un nouveau lieu de retrait pour les commandes.</p>
    </header>

    <form action="{{ route('admin.point-relais.store') }}" method="POST" id="pointRelaisForm">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
            
            <!-- Colonne Gauche -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section 1: Informations de base -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Informations Générales</h2>
                    
                    <div style="display: grid; gap: 1.25rem;">
                        <div>
                            <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nom du Point Relais <span style="color: red;">*</span></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                                   style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                   onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'"
                                   oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <div>
                                <label for="pays" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Pays <span style="color: red;">*</span></label>
                                <select name="pays" id="pays" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; background: white;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                    <option value="">Sélectionner un pays</option>
                                    @php
                                        $countries = [
                                            "Sénégal", "France", "Côte d'Ivoire", "Mali", "Burkina Faso", "Guinée", "Mauritanie", "Gambie", "Bénin", "Togo", "Niger", "Cameroun", "Gabon", "Congo", "RDC", "Tchad", "Centrafrique", "Maroc", "Algérie", "Tunisie", "Belgique", "Suisse", "Canada", "USA", "Espagne", "Italie", "Allemagne", "Chine", "Dubaï"
                                        ];
                                        // On pourrait ajouter tous les pays ici, ou utiliser un package.
                                    @endphp
                                    @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ old('pays', 'Centrafrique') == $country ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                    <option value="Autre" {{ old('pays') == 'Autre' ? 'selected' : '' }}>Autre...</option>
                                </select>
                            </div>
                            <div>
                                <label for="region" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Région <span style="color: red;">*</span></label>
                                <select name="region" id="region" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; background: white;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                    <option value="">Sélectionner une région</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="adresse" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Adresse Complète <span style="color: red;">*</span></label>
                            <textarea name="adresse" id="adresse" rows="2" required
                                      style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                      onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'"
                                      oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">{{ old('adresse') }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr; gap: 1.25rem;">
                            <div>
                                <label for="telephone" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Téléphone</label>
                                <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}"
                                       style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                       onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                <input type="hidden" name="full_telephone" id="full_telephone">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Colonne Droite -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                {{-- Section Coordonnées retirée --}}
                <input type="hidden" name="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" value="{{ old('longitude') }}">

                <!-- Section 3: Responsables -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1rem;">Responsables</h3>
                    <select name="managers[]" id="managers" required
                            style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; background: white;"
                            onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                        <option value="">Sélectionner un responsable</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ in_array($user->id, old('managers', [])) ? 'selected' : '' }}>
                                {{ $user->prenom }} {{ $user->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Section 4: État -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <label for="is_active" style="display: flex; align-items: center; gap: 12px; cursor: pointer; user-select: none;">
                        <div style="position: relative; width: 20px; height: 20px;">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;"
                                   onchange="this.nextElementSibling.style.backgroundColor = this.checked ? '#ff750f' : '#fff'; this.nextElementSibling.style.borderColor = this.checked ? '#ff750f' : '#e0e0e0'">
                            <div style="position: absolute; top: 0; left: 0; height: 20px; width: 20px; background-color: {{ old('is_active', true) ? '#ff750f' : '#fff' }}; border: 2px solid {{ old('is_active', true) ? '#ff750f' : '#e0e0e0' }}; border-radius: 4px; transition: all 0.2s;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: {{ old('is_active', true) ? 'block' : 'none' }};">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>
                        <span style="font-size: 0.9rem; font-weight: 550; color: #333;">Point Relais Actif</span>
                    </label>
                </div>

                <!-- Boutons d'action -->
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="submit" style="background: #000; color: #fff; border: none; padding: 0.85rem; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 0.9rem; display: flex; align-items: center; justify-content: center;">
                        Enregistrer
                    </button>
                    <a href="{{ route('admin.point-relais.index') }}" style="display: flex; justify-content: center; padding: 0.85rem; background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;"
                       onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
<style>
    .iti { width: 100%; }
    .iti__flag-container { border-radius: 6px 0 0 6px; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script>
    // Phone Input and Country Sync
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelector("#telephone");
        const countrySelect = document.querySelector("#pays");
        
        if (phoneInput) {
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "sn",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
                preferredCountries: ["sn", "fr", "ci", "ml", "bf"]
            });

            // Sync country select with phone input if possible
            const countryMap = {
                "Sénégal": "sn",
                "France": "fr",
                "Côte d'Ivoire": "ci",
                "Mali": "ml",
                "Burkina Faso": "bf",
                "Guinée": "gn",
                "Mauritanie": "mr",
                "Gambie": "gm",
                "Bénin": "bj",
                "Togo": "tg",
                "Niger": "ne",
                "Cameroun": "cm",
                "Gabon": "ga",
                "Congo": "cg",
                "RDC": "cd",
                "Tchad": "td",
                "Centrafrique": "cf",
                "Maroc": "ma",
                "Algérie": "dz",
                "Tunisie": "tn",
                "Belgique": "be",
                "Suisse": "ch",
                "Canada": "ca",
                "USA": "us",
                "Espagne": "es",
                "Italie": "it",
                "Allemagne": "de",
                "Chine": "cn",
                "Dubaï": "ae"
            };

            // Set initial country
            const initialCountry = countrySelect.value || "Centrafrique";

            if (countryMap[initialCountry]) {
                iti.setCountry(countryMap[initialCountry]);
            }

            // Sync regions
            const regionsByCountry = {
                "Centrafrique": ["Bangui", "Ombella-M'Poko", "Lobaye", "Mambéré-Kadéï", "Nana-Mambéré", "Sangha-Mbaéré", "Ouham", "Ouham-Pendé", "Nana-Grébizi", "Kémo", "Ouaka", "Basse-Kotto", "Mbomou", "Haut-Mbomou", "Bamingui-Bangoran", "Vakaga"],
                "Sénégal": ["Dakar", "Diourbel", "Fatick", "Kaffrine", "Kaolack", "Kédougou", "Kolda", "Louga", "Matam", "Saint-Louis", "Sédhiou", "Tambacounda", "Thiès", "Ziguinchor"],
                "France": ["Auvergne-Rhône-Alpes", "Bourgogne-Franche-Comté", "Bretagne", "Centre-Val de Loire", "Corse", "Grand Est", "Hauts-de-France", "Île-de-France", "Normandie", "Nouvelle-Aquitaine", "Occitanie", "Pays de la Loire", "Provence-Alpes-Côte d'Azur"],
                "Côte d'Ivoire": ["Abidjan", "Bas-Sassandra", "Comoé", "Denguélé", "Gôh-Djiboua", "Lacs", "Lagunes", "Montagnes", "Sassandra-Marahoué", "Savanes", "Vallée du Bandama", "Woroba", "Zanzan"],
                "Cameroun": ["Adamaoua", "Centre", "Est", "Extrême-Nord", "Littoral", "Nord", "Nord-Ouest", "Ouest", "Sud", "Sud-Ouest"],
                "Mali": ["Kayes", "Koulikoro", "Sikasso", "Ségou", "Mopti", "Tombouctou", "Gao", "Kidal", "Taoudénit", "Ménaka", "Bamako"],
                "Burkina Faso": ["Boucle du Mouhoun", "Cascades", "Centre", "Centre-Est", "Centre-Nord", "Centre-Ouest", "Centre-Sud", "Est", "Hauts-Bassins", "Nord", "Plateau-Central", "Sahel", "Sud-Ouest"],
                "Guinée": ["Boké", "Conakry", "Faranah", "Kankan", "Kindia", "Labé", "Mamou", "Nzérékoré"],
                "Mauritanie": ["Adrar", "Assaba", "Brakna", "Dakhlet Nouadhibou", "Gorgol", "Guidimaka", "Hodh Ech Chargui", "Hodh El Gharbi", "Inchiri", "Tagant", "Tiris Zemmour", "Trarza", "Nouakchott Nord", "Nouakchott Ouest", "Nouakchott Sud"],
                "Gambie": ["Banjul", "Kanifing", "Brikama", "Mansa Konko", "Kerewan", "Janjanbureh", "Basse Santa Su"],
                "Bénin": ["Alibori", "Atacora", "Atlantique", "Borgou", "Collines", "Couffo", "Donga", "Littoral", "Mono", "Ouémé", "Plateau", "Zou"],
                "Togo": ["Centrale", "Kara", "Maritime", "Plateaux", "Savanes"],
                "Niger": ["Agadez", "Diffa", "Dosso", "Maradi", "Niamey", "Tahoua", "Tillabéri", "Zinder"],
                "Gabon": ["Estuaire", "Haut-Ogooué", "Moyen-Ogooué", "Ngounié", "Nyanga", "Ogooué-Ivindo", "Ogooué-Lolo", "Ogooué-Maritime", "Woleu-Ntem"],
                "Congo": ["Bouenza", "Brazzaville", "Cuvette", "Cuvette-Ouest", "Kouilou", "Lékoumou", "Likouala", "Niari", "Plateaux", "Pointe-Noire", "Pool", "Sangha"],
                "RDC": ["Kinshasa", "Bas-Uele", "Equateur", "Haut-Katanga", "Haut-Lomami", "Haut-Uele", "Ituri", "Kasaï", "Kasaï-Central", "Kasaï-Oriental", "Kongo Central", "Kwango", "Kwilu", "Lomami", "Lualaba", "Mai-Ndombe", "Maniema", "Mongala", "Nord-Kivu", "Nord-Ubangi", "Sankuru", "Sud-Kivu", "Sud-Ubangi", "Tanganyika", "Tshopo", "Tshuapa"],
                "Tchad": ["N'Djamena", "Barh el Gazel", "Batha", "Borkou", "Chari-Baguirmi", "Ennedi-Est", "Ennedi-Ouest", "Guéra", "Hadjer-Lamis", "Kanem", "Lac", "Logone Occidental", "Logone Oriental", "Mandoul", "Mayo-Kebbi Est", "Mayo-Kebbi Ouest", "Moyen-Chari", "Ouaddaï", "Salamat", "Sila", "Tandjilé", "Tibesti", "Wadi Fira"],
                "Maroc": ["Casablanca-Settat", "Rabat-Salé-Kénitra", "Fès-Meknès", "Tanger-Tétouan-Al Hoceïma", "Marrakech-Safi", "Drâa-Tafilalet", "Béni Mellal-Khénifra", "l'Oriental", "Souss-Massa", "Guelmim-Oued Noun", "Laâyoune-Sakia El Hamra", "Dakhla-Oued Ed-Dahab"],
                "Algérie": ["Alger", "Oran", "Constantine", "Annaba", "Blida", "Batna", "Djelfa", "Sétif", "Sidi Bel Abbès", "Biskra", "Tébessa", "Tiaret", "Béjaïa", "Tlemcen", "Béchar", "Skikda", "Mostaganem", "M'Sila", "Mascara", "Ouargla", "Tizi Ouzou"],
                "Tunisie": ["Tunis", "Ariana", "Béja", "Ben Arous", "Bizerte", "Gabès", "Gafsa", "Jendouba", "Kairouan", "Kasserine", "Kébili", "Kef", "Mahdia", "Manouba", "Médenine", "Monastir", "Nabeul", "Sfax", "Sidi Bouzid", "Siliana", "Sousse", "Tataouine", "Tozeur", "Zaghouan"],
                "Belgique": ["Bruxelles", "Anvers", "Brabant flamand", "Brabant wallon", "Flandre-Occidentale", "Flandre-Orientale", "Hainaut", "Liège", "Limbourg", "Luxembourg", "Namur"],
                "Suisse": ["Zurich", "Berne", "Lucerne", "Uri", "Schwytz", "Obwald", "Nidwald", "Glaris", "Zoug", "Fribourg", "Soleure", "Bâle-Ville", "Bâle-Campagne", "Schaffhouse", "Appenzell Rhodes-Extérieures", "Appenzell Rhodes-Intérieures", "Saint-Gall", "Grisons", "Argovie", "Thurgovie", "Tessin", "Vaud", "Valais", "Neuchâtel", "Genève", "Jura"],
                "Canada": ["Ontario", "Québec", "Colombie-Britannique", "Alberta", "Manitoba", "Saskatchewan", "Nouvelle-Écosse", "Nouveau-Brunswick", "Terre-Neuve-et-Labrador", "Île-du-Prince-Édouard"],
                "USA": ["California", "Texas", "Florida", "New York", "Illinois", "Pennsylvania", "Ohio", "Georgia", "North Carolina", "Michigan", "New Jersey", "Virginia", "Washington", "Arizona", "Massachusetts", "Tennessee", "Indiana", "Maryland", "Missouri", "Wisconsin", "Colorado", "Minnesota", "South Carolina", "Alabama", "Louisiana", "Kentucky", "Oregon", "Oklahoma", "Connecticut", "Utah", "Iowa", "Nevada", "Arkansas", "Mississippi", "Kansas", "New Mexico", "Nebraska", "Idaho", "West Virginia", "Hawaii", "New Hampshire", "Maine", "Montana", "Rhode Island", "Delaware", "South Dakota", "North Dakota", "Alaska", "Vermont", "Wyoming"],
                "Espagne": ["Andalousie", "Aragon", "Asturies", "Baléares", "Canaries", "Cantabrie", "Castille-La Manche", "Castille-et-León", "Catalogne", "Communauté de Madrid", "Communauté valencienne", "Estrémadure", "Galice", "La Rioja", "Murcie", "Navarre", "Pays basque"],
                "Italie": ["Lombardie", "Latium", "Campanie", "Vénétie", "Sicile", "Émilie-Romagne", "Piémont", "Pouilles", "Toscane", "Calabre", "Sardaigne", "Ligurie", "Marches", "Abruzzes", "Frioul-Vénétie Julienne", "Trentin-Haut-Adige", "Ombrie", "Basilicate", "Molise", "Vallée d'Aoste"],
                "Allemagne": ["Bade-Wurtemberg", "Basse-Saxe", "Bavière", "Berlin", "Brandebourg", "Brême", "Hambourg", "Hesse", "Mecklembourg-Poméranie-Occidentale", "Rhénanie-du-Nord-Westphalie", "Rhénanie-Palatinat", "Sarre", "Saxe", "Saxe-Anhalt", "Schleswig-Holstein", "Thuringe"],
                "Chine": ["Guangdong", "Shandong", "Henan", "Sichuan", "Jiangsu", "Hebei", "Hunan", "Anhui", "Hubei", "Zhejiang", "Guangxi", "Yunnan", "Jiangxi", "Liaoning", "Heilongjiang", "Shaanxi", "Fujian", "Shanxi", "Guizhou", "Jilin", "Gansu", "Hainan", "Qinghai", "Taiwan", "Beijing", "Shanghai", "Tianjin", "Chongqing", "Nei Mongol", "Ningxia", "Xinjiang", "Xizang"],
                "Dubaï": ["Abou Dabi", "Dubaï", "Charjah", "Ajman", "Oumm al Qaïwaïn", "Ras el Khaïmah", "Fujaïrah"]
            };

            const regionSelect = document.querySelector("#region");
            const updateRegions = (country) => {
                const regions = regionsByCountry[country] || [];
                regionSelect.innerHTML = '<option value="">Sélectionner une région</option>';
                regions.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r;
                    opt.textContent = r;
                    if (r === "{{ old('region') }}") opt.selected = true;
                    regionSelect.appendChild(opt);
                });
                if (regions.length === 0) {
                    const opt = document.createElement('option');
                    opt.value = "Autre";
                    opt.textContent = "Autre...";
                    regionSelect.appendChild(opt);
                }
            };

            // Initial load
            updateRegions(countrySelect.value || 'Centrafrique');

            countrySelect.addEventListener('change', function() {
                const countryCode = countryMap[this.value];
                if (countryCode) {
                    iti.setCountry(countryCode);
                }
                updateRegions(this.value);
            });

            // Geolocation logic
            const btnGeo = document.querySelector("#btn-geolocation");
            if (btnGeo) {
                btnGeo.addEventListener('click', function() {
                    if ("geolocation" in navigator) {
                        btnGeo.innerText = "Recherche en cours...";
                        btnGeo.disabled = true;
                        
                        navigator.geolocation.getCurrentPosition(function(position) {
                            document.querySelector("#latitude").value = position.coords.latitude.toFixed(8);
                            document.querySelector("#longitude").value = position.coords.longitude.toFixed(8);
                            btnGeo.innerHTML = '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Position récupérée !';
                            btnGeo.disabled = false;
                            setTimeout(() => {
                                btnGeo.innerHTML = '<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Ma position actuelle';
                            }, 3000);
                        }, function(error) {
                            alert("Erreur de géolocalisation : " + error.message);
                            btnGeo.innerText = "Ma position actuelle";
                            btnGeo.disabled = false;
                        });
                    } else {
                        alert("La géolocalisation n'est pas supportée par votre navigateur.");
                    }
                });
            }

            // Update hidden field with full phone number
            phoneInput.addEventListener('blur', function() {
                document.querySelector("#full_telephone").value = iti.getNumber();
            });

            // Toggle handling
            const is_active_checkbox = document.getElementById('is_active');
            if (is_active_checkbox) {
                is_active_checkbox.addEventListener('change', function() {
                    const checkIcon = this.nextElementSibling.querySelector('svg');
                    if (checkIcon) checkIcon.style.display = this.checked ? 'block' : 'none';
                });
            }
        }
    });
</script>
@endpush
@endsection
