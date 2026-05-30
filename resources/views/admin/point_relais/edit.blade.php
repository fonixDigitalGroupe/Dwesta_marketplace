@extends('layouts.admin')

@section('title', 'Modifier le Point Relais')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Input Amazon Style Modernisé (Coherent with Filters) */
        input[type="text"], 
        input[type="tel"],
        input[type="number"], 
        textarea, 
        select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.82rem;
            outline: none;
            background: #fff;
            color: #475569;
            transition: all 0.2s;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #ff9900 !important;
        }

        .amazon-card {
            background: #fff;
            border: 1px solid #eff3f6;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #fff;
        }

        .btn-amazon-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.03em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-amazon-secondary:hover {
            background: #f8fafc;
            border-color: #dee2e6;
            color: #1e293b;
        }

        /* Custom Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 0.85rem;
            color: #1e293b;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .checkmark {
            height: 18px;
            width: 18px;
            background-color: #fff;
            border: 2px solid #dee2e6;
            border-radius: 4px;
            position: relative;
            transition: all 0.2s;
        }
        
        .checkbox-container input:checked ~ .checkmark {
            background-color: #ff9900;
            border-color: #ff9900;
        }
        
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 5px;
            top: 2px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
        }

        .iti { width: 100%; }
        
        #map {
            width: 100%;
            height: 300px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            margin-bottom: 12px;
            z-index: 0;
        }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                    <span>Modifier le Point Relais : {{ $point_relais->nom }}</span>
                </div>
            </div>
            
            <a href="{{ route('admin.point-relais.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Voir les points relais
            </a>
        </div>

        <form action="{{ route('admin.point-relais.update', $point_relais) }}" method="POST" id="pointRelaisForm">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">
                
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Identité & Contact</h3>
                        
                        <div style="margin-bottom: 15px;">
                            <label for="nom" class="field-label">Nom du Point Relais <small style="color: red;">*</small></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $point_relais->nom) }}" required 
                                   placeholder="Ex: Boutique Central Bangui"
                                   oninput="if(this.value) this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                            @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label for="managers" class="field-label">Responsable <small style="color: red;">*</small></label>
                            <select name="managers[]" id="managers" required>
                                <option value="">Sélectionner un responsable</option>
                                @php $currentManagers = old('managers', $point_relais->users->pluck('id')->toArray()); @endphp
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $currentManagers) ? 'selected' : '' }}>
                                        {{ $user->prenom }} {{ $user->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('managers') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 0;">
                            <label for="telephone" class="field-label">Téléphone</label>
                            <input type="tel" name="telephone" id="telephone" value="{{ old('telephone', $point_relais->telephone) }}" placeholder="7x xx xx xx">
                            <input type="hidden" name="full_telephone" id="full_telephone">
                        </div>
                    </div>

                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Localisation Administrative</h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label for="pays" class="field-label">Pays <small style="color: red;">*</small></label>
                                <select name="pays" id="pays" required>
                                    <option value="">Sélectionner un pays</option>
                                    @php
                                        $countries = ["Sénégal", "France", "Côte d'Ivoire", "Mali", "Burkina Faso", "Guinée", "Mauritanie", "Gambie", "Bénin", "Togo", "Niger", "Cameroun", "Gabon", "Congo", "RDC", "Tchad", "Centrafrique", "Maroc", "Algérie", "Tunisie", "Belgique", "Suisse", "Canada", "USA", "Espagne", "Italie", "Allemagne", "Chine", "Dubaï"];
                                    @endphp
                                    @foreach($countries as $country)
                                        <option value="{{ $country }}" {{ old('pays', $point_relais->pays) == $country ? 'selected' : '' }}>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="region" class="field-label">Région <small style="color: red;">*</small></label>
                                <select name="region" id="region" required>
                                    <option value="">Sélectionner une région</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 0;">
                            <label for="adresse" class="field-label">Adresse Complète <small style="color: red;">*</small></label>
                            <textarea name="adresse" id="adresse" rows="3" required
                                      placeholder="Numéro, rue, quartier..."
                                      oninput="if(this.value) this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">{{ old('adresse', $point_relais->adresse) }}</textarea>
                            @error('adresse') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Position Géo-Exacte</h3>
                        
                        <div id="map"></div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                            <div>
                                <label for="latitude" class="field-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $point_relais->latitude) }}"
                                       placeholder="0.000000" oninput="syncMapFromInputs()">
                            </div>
                            <div>
                                <label for="longitude" class="field-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $point_relais->longitude) }}"
                                       placeholder="0.000000" oninput="syncMapFromInputs()">
                            </div>
                        </div>

                        <button type="button" id="btn-geolocation" class="btn-amazon-secondary" style="font-size: 0.72rem; padding: 6px 12px;">
                            <i class="fas fa-crosshairs"></i> Ma position actuelle
                        </button>
                    </div>

                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Statut & Publication</h3>
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $point_relais->is_active) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Point Relais Actif</span>
                            </label>
                            
                            <label class="checkbox-container">
                                <input type="checkbox" name="est_point_special" value="1" {{ old('est_point_special', $point_relais->est_point_special) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #ff9900; text-transform: uppercase; letter-spacing: 0.05em;">Point Spécial (Karnou)</span>
                            </label>
                        </div>
                        
                        <p style="font-size: 0.75rem; color: #64748b; margin-left: 28px; margin-top: 10px; line-height: 1.4;">
                            Un <strong>Point Spécial</strong> est un lieu de retrait spécifique géré par Karnou.
                        </p>
                    </div>

                </div>

                <!-- Actions Row -->
                <div style="grid-column: 1 / -1; display: grid; grid-template-columns: 140px 140px; gap: 12px; justify-content: end; border-top: 1px solid #eff3f6; padding-top: 20px;">
                    <button type="submit" class="btn-amazon-primary">
                        METTRE À JOUR
                    </button>
                    <a href="{{ route('admin.point-relais.index') }}" class="btn-amazon-secondary">
                        ANNULER
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map, marker;

    function initMap() {
        const defaultLat = 4.361220, defaultLng = 18.558200;
        const initialLat = parseFloat(document.getElementById('latitude').value) || defaultLat;
        const initialLng = parseFloat(document.getElementById('longitude').value) || defaultLng;

        map = L.map('map').setView([initialLat, initialLng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);

        marker.on('dragend', function() {
            const pos = marker.getLatLng();
            document.getElementById('latitude').value = pos.lat.toFixed(6);
            document.getElementById('longitude').value = pos.lng.toFixed(6);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
        });
    }

    function syncMapFromInputs() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            const pos = [lat, lng];
            marker.setLatLng(pos);
            map.panTo(pos);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initMap();

        const phoneInput = document.querySelector("#telephone");
        const countrySelect = document.querySelector("#pays");
        const regionSelect = document.querySelector("#region");

        const countryMap = {
            "Sénégal": "sn", "France": "fr", "Côte d'Ivoire": "ci", "Mali": "ml", "Burkina Faso": "bf",
            "Guinée": "gn", "Mauritanie": "mr", "Gambie": "gm", "Bénin": "bj", "Togo": "tg",
            "Niger": "ne", "Cameroun": "cm", "Gabon": "ga", "Congo": "cg", "RDC": "cd",
            "Tchad": "td", "Centrafrique": "cf", "Maroc": "ma", "Algérie": "dz", "Tunisie": "tn",
            "Belgique": "be", "Suisse": "ch", "Canada": "ca", "USA": "us", "Espagne": "es",
            "Italie": "it", "Allemagne": "de", "Chine": "cn", "Dubaï": "ae"
        };

        const regionsByCountry = {
            "Centrafrique": ["Bangui", "Ombella-M'Poko", "Lobaye", "Mambéré-Kadéï", "Nana-Mambéré", "Sangha-Mbaéré", "Ouham", "Ouham-Pendé", "Nana-Grébizi", "Kémo", "Ouaka", "Basse-Kotto", "Mbomou", "Haut-Mbomou", "Bamingui-Bangoran", "Vakaga"],
            "Sénégal": ["Dakar", "Diourbel", "Fatick", "Kaffrine", "Kaolack", "Kédougou", "Kolda", "Louga", "Matam", "Saint-Louis", "Sédhiou", "Tambacounda", "Thiès", "Ziguinchor"],
            "France": ["Auvergne-Rhône-Alpes", "Bourgogne-Franche-Comté", "Bretagne", "Centre-Val de Loire", "Corse", "Grand Est", "Hauts-de-France", "Île-de-France", "Normandie", "Nouvelle-Aquitaine", "Occitanie", "Pays de la Loire", "Provence-Alpes-Côte d'Azur"],
            "Côte d'Ivoire": ["Abidjan", "Bas-Sassandra", "Comoé", "Denguélé", "Gôh-Djiboua", "Lacs", "Lagunes", "Montagnes", "Sassandra-Marahoué", "Savanes", "Vallée du Bandama", "Woroba", "Zanzan"],
            "Cameroun": ["Adamaoua", "Centre", "Est", "Extrême-Nord", "Littoral", "Nord", "Nord-Ouest", "Ouest", "Sud", "Sud-Ouest"],
            "Mali": ["Kayes", "Koulikoro", "Sikasso", "Ségou", "Mopti", "Tombouctou", "Gao", "Kidal", "Taoudénit", "Ménaka", "Bamako"],
            "Burkina Faso": ["Boucle du Mouhoun", "Cascades", "Centre", "Centre-Est", "Centre-Nord", "Centre-Ouest", "Centre-Sud", "Est", "Hauts-Bassins", "Nord", "Plateau-Central", "Sahel", "Sud-Ouest"],
            "Guinée": ["Boké", "Conakry", "Faranah", "Kankan", "Kindia", "Labé", "Mamou", "Nzérékoré"],
            "Tchad": ["N'Djamena", "Barh el Gazel", "Batha", "Borkou", "Chari-Baguirmi", "Ennedi-Est", "Ennedi-Ouest", "Guéra", "Hadjer-Lamis", "Kanem", "Lac", "Logone Occidental", "Logone Oriental", "Mandoul", "Mayo-Kebbi Est", "Mayo-Kebbi Ouest", "Moyen-Chari", "Ouaddaï", "Salamat", "Sila", "Tandjilé", "Tibesti", "Wadi Fira"],
            "Maroc": ["Casablanca-Settat", "Rabat-Salé-Kénitra", "Fès-Meknès", "Tanger-Tétouan-Al Hoceïma", "Marrakech-Safi", "Béni Mellal-Khénifra"],
        };

        const countryCoordinates = {
            "Centrafrique": [4.39, 18.55], "Sénégal": [14.49, -14.45], "France": [46.22, 2.21],
            "Côte d'Ivoire": [7.53, -5.54], "Mali": [17.57, -3.99], "Burkina Faso": [12.23, -1.56],
            "Guinée": [9.94, -9.69], "Mauritanie": [21.00, -10.94], "Gambie": [13.44, -15.31],
            "Bénin": [9.30, 2.31], "Togo": [8.61, 0.82], "Niger": [17.60, 8.08],
            "Cameroun": [7.36, 12.35], "Gabon": [-0.80, 11.60], "Congo": [-0.22, 15.82],
            "RDC": [-4.03, 21.75], "Tchad": [15.45, 18.73], "Maroc": [31.79, -7.09],
            "Algérie": [28.03, 1.65], "Tunisie": [33.88, 9.53], "Belgique": [50.50, 4.46],
            "Suisse": [46.81, 8.22], "Canada": [56.13, -106.34], "USA": [37.09, -95.71],
            "Espagne": [40.46, -3.74], "Italie": [41.87, 12.56], "Allemagne": [51.16, 10.45],
            "Chine": [35.86, 104.19], "Dubaï": [25.20, 55.27]
        };

        const regionCoordinates = {
            "Bangui": [4.3947, 18.5582], "Bamingui-Bangoran": [8.2733, 20.7122], "Basse-Kotto": [4.8719, 21.2845], "Haut-Mbomou": [6.2537, 25.4734], "Kémo": [5.8868, 19.3783], "Lobaye": [4.3526, 17.4795], "Mambéré-Kadéï": [4.7056, 15.9700], "Mbomou": [5.5568, 23.7633], "Nana-Grébizi": [7.1849, 19.3783], "Nana-Mambéré": [5.6932, 15.2195], "Ombella-M'Poko": [5.1189, 18.4276], "Ouaka": [6.3168, 20.7122], "Ouham": [7.0909, 17.6689], "Ouham-Pendé": [6.4851, 16.1581], "Sangha-Mbaéré": [3.4369, 16.3464], "Vakaga": [9.0000, 23.0000],
            "Dakar": [14.7167, -17.4677], "Abidjan": [5.3600, -4.0083], "Bamako": [12.6392, -8.0029], "Ouagadougou": [12.3714, -1.5197],
            "Conakry": [9.6412, -13.5784], "Douala": [4.0511, 9.7679], "Yaoundé": [3.8480, 11.5021], "Libreville": [0.4162, 9.4673],
            "Brazzaville": [-4.2634, 15.2832], "Kinshasa": [-4.4419, 15.2663], "N'Djamena": [12.1348, 15.0557], "Casablanca": [33.5731, -7.5898]
        };

        const updateRegions = (country, currentRegion = null) => {
            const regions = regionsByCountry[country] || [];
            regionSelect.innerHTML = '<option value="">Sélectionner une région</option>';
            regions.forEach(r => {
                const opt = document.createElement('option');
                opt.value = r; opt.textContent = r;
                if (r === currentRegion) opt.selected = true;
                regionSelect.appendChild(opt);
            });
            if (regions.length === 0) {
                const opt = document.createElement('option');
                opt.value = currentRegion || "Autre"; opt.textContent = currentRegion || "Autre...";
                opt.selected = true;
                regionSelect.appendChild(opt);
            }
        };

        const iti = window.intlTelInput(phoneInput, {
            initialCountry: countryMap["{{ old('pays', $point_relais->pays) }}"] || "cf",
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        countrySelect.addEventListener('change', function () {
            updateRegions(this.value);
            const code = countryMap[this.value];
            if (code) iti.setCountry(code);
            const coords = countryCoordinates[this.value];
            if (coords) map.setView(coords, 6);
        });

        regionSelect.addEventListener('change', function () {
            const coords = regionCoordinates[this.value];
            if (coords) {
                map.setView(coords, 12);
                marker.setLatLng(coords);
                document.getElementById('latitude').value = coords[0].toFixed(6);
                document.getElementById('longitude').value = coords[1].toFixed(6);
            }
        });

        updateRegions("{{ old('pays', $point_relais->pays) }}", "{{ old('region', $point_relais->region) }}");

        document.getElementById('btn-geolocation').onclick = () => {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(p => {
                    const lat = p.coords.latitude, lng = p.coords.longitude;
                    document.getElementById('latitude').value = lat.toFixed(6);
                    document.getElementById('longitude').value = lng.toFixed(6);
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 15);
                });
            }
        };

        phoneInput.addEventListener('blur', () => {
            document.querySelector("#full_telephone").value = iti.getNumber();
        });
    });
</script>
@endpush
