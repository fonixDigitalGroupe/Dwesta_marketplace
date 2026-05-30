@extends('layouts.admin')

@section('title', 'Ajouter un pays')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Input Amazon Style Modernisé */
        input[type="text"], 
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

        /* Buttons Alignés avec Index */
        .btn-amazon-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff !important;
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
        }

        .btn-amazon-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569 !important;
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
            color: #1e293b !important;
        }

        /* Custom Checkbox Amaon Style */
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

        #interactive-map {
            width: 100%;
            height: 400px;
            border: 1px solid #eff3f6;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .map-status {
            font-size: 0.75rem;
            color: #64748b;
            font-style: italic;
            margin-top: 5px;
            padding: 8px;
            background: #f8fafc;
            border-radius: 4px;
        }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto; width: 100%;">
    
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                    <span>Ajouter un pays d'Afrique</span>
                </div>
            </div>
            
            <a href="{{ route('admin.countries.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-globe-africa" style="color: #ff9900;"></i> Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.countries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">
                
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Sélection du Pays</h3>
                        <div style="margin-bottom: 15px;">
                            <label class="field-label">Choisir dans la liste <small style="color: red;">*</small></label>
                            <select id="country-selector" required>
                                <option value="">-- Sélectionner un pays d'Afrique --</option>
                                @foreach($africanCountries as $c)
                                    <option value="{{ $c['code'] }}" 
                                            data-name="{{ $c['name'] }}" 
                                            data-phone="{{ $c['phone'] }}" 
                                            data-format="{{ $c['format'] }}"
                                            data-lat="{{ $c['lat'] }}"
                                            data-lng="{{ $c['lng'] }}"
                                            data-emoji="{{ $c['emoji'] }}">
                                        {{ $c['emoji'] }} {{ $c['name'] }} ({{ $c['phone'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Détails Administratifs</h3>
                        
                        <input type="hidden" name="code" id="code">
                        <input type="hidden" name="flag" id="flag">
                        <input type="hidden" name="map_external_url" id="map_external_url">

                        <div style="margin-bottom: 15px;">
                            <label for="name" class="field-label">Nom officiel du pays</label>
                            <input type="text" name="name" id="name" required placeholder="Le nom s'affichera ici..."
                                   oninput="if(this.value) this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label for="phone_code" class="field-label">Indicatif International</label>
                                <input type="text" name="phone_code" id="phone_code" placeholder="Ex: +221">
                            </div>
                            <div>
                                <label for="currency" class="field-label">Devise locale</label>
                                <input type="text" name="currency" id="currency" value="FCFA">
                            </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <label for="phone_format" class="field-label">Format de téléphone (0 = chiffre)</label>
                            <input type="text" name="phone_format" id="phone_format" placeholder="Ex: 00 000 00 00">
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Cartographie</h3>
                        <div id="interactive-map"></div>
                        <div id="map-status" class="map-status">Sélectionnez un pays...</div>
                    </div>

                    <div class="amazon-card" style="margin: 0; display: flex; flex-direction: column;">
                        <h3 class="section-title" style="margin-bottom: 15px;">Publication</h3>
                        
                        <div style="margin-bottom: 25px;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase;">Activer ce pays</span>
                            </label>
                        </div>

                        <!-- Actions Row -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <button type="submit" class="btn-amazon-primary">
                                ENREGISTRER
                            </button>
                            <a href="{{ route('admin.countries.index') }}" class="btn-amazon-secondary">
                                ANNULER
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map, geojsonLayer;

    document.addEventListener('DOMContentLoaded', function() {
        map = L.map('interactive-map').setView([10, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const selector = document.getElementById('country-selector');
        const nameInput = document.getElementById('name');
        const codeInput = document.getElementById('code');
        const flagInput = document.getElementById('flag');
        const phoneInput = document.getElementById('phone_code');
        const formatInput = document.getElementById('phone_format');
        const mapExternalInput = document.getElementById('map_external_url');
        const statusEl = document.getElementById('map-status');

        selector.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            if (!opt.value) return;

            const name = opt.getAttribute('data-name');
            const code = opt.value;
            const emoji = opt.getAttribute('data-emoji');
            const lat = parseFloat(opt.getAttribute('data-lat'));
            const lng = parseFloat(opt.getAttribute('data-lng'));

            nameInput.value = name;
            codeInput.value = code;
            flagInput.value = emoji;
            phoneInput.value = opt.getAttribute('data-phone');
            formatInput.value = opt.getAttribute('data-format');

            map.setView([lat, lng], 5);
            statusEl.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Délimitation des frontières : ${name}...`;

            if (geojsonLayer) map.removeLayer(geojsonLayer);

            fetch(`https://nominatim.openstreetmap.org/search?country=${encodeURIComponent(name)}&polygon_geojson=1&format=json`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0 && data[0].geojson) {
                        geojsonLayer = L.geoJSON(data[0].geojson, {
                            style: { color: '#ff9900', weight: 2, fillOpacity: 0.1 }
                        }).addTo(map);
                        map.fitBounds(geojsonLayer.getBounds());
                        statusEl.innerHTML = `<i class="fas fa-check-circle" style="color: #569b00"></i> Frontières de ${name} identifiées.`;
                    } else {
                        statusEl.innerHTML = `<i class="fas fa-info-circle"></i> Localisation trouvée pour ${name}.`;
                    }
                })
                .catch(() => {
                    statusEl.innerHTML = `<i class="fas fa-map-marker-alt"></i> Position centrée sur ${name}.`;
                });

            mapExternalInput.value = `https://static-maps.yandex.ru/1.x/?ll=${lng},${lat}&z=5&l=map&size=600,400`;
        });
    });
</script>
@endpush
@endsection
