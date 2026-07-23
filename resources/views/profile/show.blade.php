@extends('layouts.app')

@section('title', 'Mon Profil - Karnou')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Rakuten Style Forms */
        .rakuten-form-container {
            max-width: 800px;
            padding: 1rem 0;
            text-align: left;
        }

        .rakuten-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .rakuten-radio-group {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .rakuten-radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .rakuten-radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #0076ad;
        }

        .rakuten-field-group {
            margin-bottom: 1rem;
            width: 100%;
        }

        /* Mobile-first : 1 champ par ligne PAR DÉFAUT.
           display:block => les champs (.rakuten-field-group, width:100%) s'empilent
           comme des blocs normaux, sans dépendre d'aucune grille. */
        .rakuten-form-grid {
            display: block;
            margin-bottom: 1rem;
        }
        .rakuten-form-grid > .rakuten-field-group {
            width: 100%;
            margin-bottom: 1rem;
        }

        /* 2 colonnes uniquement sur grand écran (desktop). */
        @media (min-width: 1025px) {
            .rakuten-form-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }
            .rakuten-form-grid > .rakuten-field-group {
                margin-bottom: 0;
            }
        }

        .rakuten-field {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0.1rem 0.75rem;
            background: #fff;
            transition: border-color 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rakuten-field:focus-within {
            border-color: #ff4e00;
        }

        .rakuten-label {
            display: block;
            font-size: 0.7rem;
            color: #888;
            margin-bottom: 0px;
            line-height: 1;
        }

        .rakuten-error-alert {
            background-color: #fff6f6;
            border: 1px solid #ff0000;
            color: #333;
            padding: 0.5rem 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.88rem;
            max-width: 100%;
            border-radius: 2px;
        }

        .rakuten-error-alert .error-icon {
            background-color: #ff0000;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 12px;
            font-weight: bold;
        }

        .rakuten-success-alert {
            background-color: #f6fff6;
            color: #00a650;
            padding: 0.6rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: 4px;
        }

        .rakuten-success-alert .success-icon {
            background-color: #00a650;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 10px;
            font-weight: bold;
        }

        .rakuten-input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 0.9rem;
            color: #333;
            padding: 0;
            background: transparent;
        }

        .rakuten-input:focus {
            outline: none;
            box-shadow: none;
        }

        .rakuten-input option {
            background: #fff;
            color: #333;
        }

        .rakuten-input option:hover,
        .rakuten-input option:focus,
        .rakuten-input option:active,
        .rakuten-input option:checked {
            background-color: #eee !important;
            background: #eee !important;
        }

        .btn-rakuten {
            background: #004aad;
            color: #fff;
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            font-size: 1rem;
            margin: 1.25rem 0 2rem;
            width: 220px;
            transition: opacity 0.2s;
        }

        .btn-rakuten:hover {
            opacity: 0.85;
        }

        .password-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .eye-toggle {
            background: none;
            border: none;
            padding: 0;
            margin-left: 0.5rem;
            cursor: pointer;
            color: #888;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .eye-toggle svg {
            width: 20px;
            height: 20px;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .content-header h1 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        @media (max-width: 1024px) {
            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .rakuten-form-container {
                padding: 0.5rem 0;
            }

            .btn-rakuten {
                width: 100%;
                text-align: center;
            }

            /* Boutons de la carte empilés et pleine largeur (Me géolocaliser,
               Valider ma position, Fermer la carte) */
            .profile-map-actions {
                flex-direction: column;
                gap: 0.6rem !important;
            }
            .profile-map-actions .btn-rakuten {
                flex: none !important;
                width: 100% !important;
                margin: 0 !important;
            }

            /* Rangée de recherche d'adresse empilée + bouton Rechercher plus haut */
            .profile-search-row {
                flex-direction: column;
            }
            .profile-search-row .btn-rakuten {
                width: 100% !important;
                padding: 0.85rem 1.5rem !important;
                min-height: 46px;
            }

            /* Bouton "Préciser ma position sur la carte" pleine largeur */
            #btn-toggle-map {
                width: 100% !important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endpush

@section('content')
    <!-- Breadcrumb (Above sidebar) -->

    <div class="dashboard-container">
        @include('partials.profile-sidebar')
        <main class="main-content">

            <div class="content-header">
                <h1>Mes informations</h1>
            </div>

            <div class="rakuten-form-container">
                <h2 class="rakuten-title">Informations personnelles</h2>

                @if(session('success'))
                    <div class="rakuten-success-alert">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="rakuten-error-alert">
                        <div class="error-icon">✕</div>
                        <span>
                            @if($errors->has('current_password_info'))
                                {{ $errors->first('current_password_info') }}
                            @else
                                {{ $errors->first() }}
                            @endif
                        </span>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="rakuten-radio-group">
                        <span style="color: #333;">Civilité :</span>
                        <label class="rakuten-radio-item">
                            <input type="radio" name="civilite" value="madame" {{ strtolower(old('civilite', $user->civilite)) == 'madame' ? 'checked' : '' }}>
                            Madame
                        </label>
                        <label class="rakuten-radio-item">
                            <input type="radio" name="civilite" value="monsieur" {{ strtolower(old('civilite', $user->civilite)) == 'monsieur' ? 'checked' : '' }}>
                            Monsieur
                        </label>
                    </div>

                    <div class="rakuten-form-grid">
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Prénom</label>
                                <input type="text" name="prenom" class="rakuten-input"
                                    value="{{ old('prenom', $user->prenom) }}" required>
                            </div>
                        </div>

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Nom</label>
                                <input type="text" name="nom" class="rakuten-input" value="{{ old('nom', $user->nom) }}">
                            </div>
                        </div>

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Nationalité</label>
                                <select name="nationalite" id="profile-nationalite" class="rakuten-input" style="appearance: none; -webkit-appearance: none; cursor: pointer;">
                                    <option value="">Choisir un pays</option>
                                    @php
                                        $currentNationalite = old('nationalite', $user->nationalite);
                                    @endphp
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}" {{ $currentNationalite == $country->name ? 'selected' : '' }}>
                                            {{ $country->flag }} {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Région</label>
                                <select name="region" id="profile-region" class="rakuten-input" style="appearance: none; -webkit-appearance: none; cursor: pointer;">
                                    <option value="">Choisir d'abord un pays</option>
                                </select>
                            </div>
                        </div>

                        <script>
                            (function () {
                                const regionsParPays = @json($countries->mapWithKeys(fn($c) => [$c->name => $c->regions->pluck('name')]));
                                const regionActuelle = @json(old('region', $user->region));
                                const paysSel = document.getElementById('profile-nationalite');
                                const regionSel = document.getElementById('profile-region');
                                function majRegions() {
                                    const regions = regionsParPays[paysSel.value] || [];
                                    regionSel.innerHTML = '<option value="">' + (regions.length ? 'Choisir une région' : 'Aucune région disponible') + '</option>';
                                    regions.forEach(function (r) {
                                        const opt = document.createElement('option');
                                        opt.value = r;
                                        opt.textContent = r;
                                        if (r === regionActuelle) opt.selected = true;
                                        regionSel.appendChild(opt);
                                    });
                                }
                                paysSel.addEventListener('change', majRegions);
                                majRegions();
                            })();
                        </script>

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Tel</label>
                                <input type="tel" name="telephone" class="rakuten-input"
                                    value="{{ old('telephone', $user->telephone) }}">
                            </div>
                        </div>

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Adresse</label>
                                <input type="text" name="adresse" class="rakuten-input"
                                    value="{{ old('adresse', $user->adresse) }}">
                            </div>
                        </div>

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Code Postal</label>
                                <input type="text" name="code_postal" class="rakuten-input"
                                    value="{{ old('code_postal', $user->code_postal) }}">
                            </div>
                        </div>

                        <div class="rakuten-field-group" style="grid-column: span 2;">
                            <div class="rakuten-field">
                                <label class="rakuten-label">E-mail actuel</label>
                                <input type="email" name="email" class="rakuten-input" value="{{ old('email', $user->email) }}"
                                    required>
                            </div>
                        </div>

                        <!-- Full Geolocation Management Section -->
                        <div id="profile-geolocation-section" class="rakuten-field-group" style="grid-column: span 2; margin-top: 1.5rem;">
                            <h2 class="rakuten-title">Localisation</h2>
                            
                            <!-- Toggle Button -->
                            <button type="button" id="btn-toggle-map" class="btn-rakuten" style="margin: 0; background: #fff; color: #f68b1e; border: 1px solid #f68b1e; width: auto; padding: 0.5rem 1rem;">
                                <i class="fa-solid fa-map-location-dot"></i> Préciser ma position sur la carte
                            </button>

                            <div id="map-collapsible-content" style="display: none; margin-top: 1.5rem;">
                                <p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">
                                    Recherchez votre quartier ou déplacez le marqueur sur la carte pour définir votre position exacte.
                                </p>
                                
                                <div class="profile-search-row" style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <input type="text" id="profile-address-search" placeholder="Tapez votre quartier ou adresse" style="flex: 1; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.9rem; min-width: 0;">
                                    <button type="button" id="btn-profile-search" class="btn-rakuten" style="width: auto; margin: 0; padding: 0 1.5rem;">
                                        <i class="fa-solid fa-magnifying-glass"></i> Rechercher
                                    </button>
                                </div>

                                <div id="profile-location-status-msg" style="margin-top: 0.5rem; padding: 0.75rem; border-radius: 4px; font-size: 0.85rem; display: none; margin-bottom: 0.5rem;"></div>

                                <style>
                                    #profile-map {
                                        height: 350px;
                                        width: 100%;
                                        border-radius: 4px;
                                        border: 1px solid #ccc;
                                        z-index: 10;
                                    }
                                    .profile-map-actions {
                                        margin-top: 1rem;
                                        display: flex;
                                        gap: 1rem;
                                    }
                                </style>
                                
                                <div id="profile-map"></div>

                                <div class="profile-map-actions">
                                    <button type="button" id="btn-profile-geolocation" class="btn-rakuten" style="margin: 0; background: #f68b1e; flex: 1;">
                                        <i class="fa-solid fa-location-crosshairs"></i> Me géolocaliser
                                    </button>
                                    <button type="button" id="btn-profile-save-location" class="btn-rakuten" style="margin: 0; background: #333; flex: 1; display: none;">
                                        <i class="fa-solid fa-floppy-disk"></i> Valider ma position
                                    </button>
                                    <button type="button" id="btn-close-map" class="btn-rakuten" style="margin: 0; background: #eee; color: #333; flex: 0.5;">
                                        Fermer la carte
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-rakuten">Valider</button>
                </form>

                <h2 id="changement-mot-de-passe" class="rakuten-title">Changement de mot de passe</h2>
                <div style="max-width: 500px;">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Ancien mot de passe</label>
                                <div class="password-container">
                                    <input type="password" name="current_password" class="rakuten-input password-toggle-input"
                                        required>
                                    <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Nouveau mot de passe</label>
                                <div class="password-container">
                                    <input type="password" name="password" class="rakuten-input password-toggle-input" required>
                                    <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Confirmez votre nouveau mot de passe</label>
                                <div class="password-container">
                                    <input type="password" name="password_confirmation"
                                        class="rakuten-input password-toggle-input" required>
                                    <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-rakuten">Valider</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

@endsection

@push('scripts')
    <script>
        function togglePassword(event) {
            const button = event.currentTarget;
            const container = button.closest('.password-container');
            const input = container.querySelector('.password-toggle-input');

            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnGeo = document.getElementById('btn-profile-geolocation');
            const btnSave = document.getElementById('btn-profile-save-location');
            const btnSearch = document.getElementById('btn-profile-search');
            const btnToggleMap = document.getElementById('btn-toggle-map');
            const btnCloseMap = document.getElementById('btn-close-map');
            const mapCollapsible = document.getElementById('map-collapsible-content');
            const searchInput = document.getElementById('profile-address-search');
            const statusMsg = document.getElementById('profile-location-status-msg');

            function showStatus(message, type = 'info') {
                if (!statusMsg) return;
                statusMsg.innerHTML = message;
                statusMsg.style.display = 'block';
                if (type === 'success') {
                    statusMsg.style.backgroundColor = '#d4edda';
                    statusMsg.style.color = '#155724';
                    statusMsg.style.border = '1px solid #c3e6cb';
                } else if (type === 'error') {
                    statusMsg.style.backgroundColor = '#f8d7da';
                    statusMsg.style.color = '#721c24';
                    statusMsg.style.border = '1px solid #f5c6cb';
                } else {
                    statusMsg.style.backgroundColor = '#e2e3e5';
                    statusMsg.style.color = '#383d41';
                    statusMsg.style.border = '1px solid #d6d8db';
                }
                if (type === 'success') {
                    setTimeout(() => { statusMsg.style.display = 'none'; }, 5000);
                }
            }

            const userLat = {{ $user->latitude ?? 'null' }};
            const userLng = {{ $user->longitude ?? 'null' }};
            const userCountry = "{{ $user->nationalite }}";
            
            const initialLat = userLat ?? 14.4974;
            const initialLng = userLng ?? -17.4419;
            const zoomLevel = userLat ? 15 : 6;

            const mapPanel = document.getElementById('profile-map');
            if (mapPanel) {
                const map = L.map('profile-map').setView([initialLat, initialLng], zoomLevel);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                let marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

                // Fallback: Si pas de coordonnées, on centre sur le pays
                if (!userLat && userCountry) {
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(userCountry)}&limit=1`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                const lat = parseFloat(data[0].lat);
                                const lon = parseFloat(data[0].lon);
                                map.setView([lat, lon], 6);
                                marker.setLatLng([lat, lon]);
                            }
                        });
                }

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    if (btnSave) btnSave.style.display = 'block';
                });

                marker.on('dragend', function() {
                    if (btnSave) btnSave.style.display = 'block';
                });

                if (btnToggleMap && mapCollapsible) {
                    btnToggleMap.addEventListener('click', function() {
                        mapCollapsible.style.display = 'block';
                        btnToggleMap.style.display = 'none';
                        setTimeout(() => {
                            map.invalidateSize();
                        }, 200);
                    });
                }

                if (btnCloseMap && mapCollapsible) {
                    btnCloseMap.addEventListener('click', function() {
                        mapCollapsible.style.display = 'none';
                        btnToggleMap.style.display = 'inline-block';
                    });
                }

                function searchAddress() {
                    const query = searchInput.value;
                    if (!query) return;
                    const originalBtnContent = btnSearch.innerHTML;
                    btnSearch.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    btnSearch.disabled = true;

                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
                        .then(response => response.json())
                        .then(data => {
                            btnSearch.innerHTML = originalBtnContent;
                            btnSearch.disabled = false;
                            if (data && data.length > 0) {
                                const lat = parseFloat(data[0].lat);
                                const lon = parseFloat(data[0].lon);
                                map.setView([lat, lon], 16);
                                marker.setLatLng([lat, lon]);
                                if (btnSave) btnSave.style.display = 'block';
                                showStatus('<strong>Lieu trouvé :</strong> La carte a été centrée. Ajustez le marqueur si nécessaire.', 'info');
                            } else {
                                showStatus('<strong>Non trouvé :</strong> Adresse introuvable.', 'error');
                            }
                        })
                        .catch(() => {
                            btnSearch.innerHTML = originalBtnContent;
                            btnSearch.disabled = false;
                            showStatus('Erreur lors de la recherche.', 'error');
                        });
                }

                if (btnSearch) btnSearch.addEventListener('click', searchAddress);
                if (searchInput) searchInput.addEventListener('keypress', function(e) { if (e.key === 'Enter') searchAddress(); });

                if (btnSave) {
                    btnSave.addEventListener('click', function() {
                        const pos = marker.getLatLng();
                        const originalContent = btnSave.innerHTML;
                        btnSave.disabled = true;
                        btnSave.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sauvegarde...';

                        fetch("{{ route('account.update-location') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ latitude: pos.lat, longitude: pos.lng })
                        })
                        .then(response => response.json())
                        .then(data => {
                            btnSave.disabled = false;
                            btnSave.innerHTML = originalContent;
                            if (data.success) {
                                btnSave.style.display = 'none';
                                showStatus('<strong>Succès :</strong> ' + data.message, 'success');
                            } else {
                                showStatus('<strong>Erreur :</strong> ' + data.message, 'error');
                            }
                        })
                        .catch(() => {
                            btnSave.disabled = false;
                            btnSave.innerHTML = originalContent;
                            showStatus('Erreur réseau.', 'error');
                        });
                    });
                }

                if (btnGeo) {
                    btnGeo.addEventListener('click', function() {
                        const originalContent = btnGeo.innerHTML;
                        
                        if (!navigator.geolocation) {
                            showStatus('La géolocalisation n\'est pas supportée par votre navigateur.', 'error');
                            return;
                        }

                        btnGeo.disabled = true;
                        btnGeo.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Localisation en cours...';

                        // On surveille la position pendant quelques secondes et on garde
                        // la lecture la plus précise. Le 1er point renvoyé est souvent une
                        // estimation réseau/WiFi grossière ; le GPS l'affine ensuite.
                        let bestPos = null;
                        let watchId = null;
                        let done = false;

                        function finishGeo(success) {
                            if (done) return;
                            done = true;
                            if (watchId !== null) navigator.geolocation.clearWatch(watchId);
                            btnGeo.disabled = false;
                            btnGeo.innerHTML = originalContent;

                            if (success && bestPos) {
                                const lat = bestPos.coords.latitude;
                                const lng = bestPos.coords.longitude;
                                const acc = Math.round(bestPos.coords.accuracy);
                                map.setView([lat, lng], 17);
                                marker.setLatLng([lat, lng]);
                                if (btnSave) btnSave.style.display = 'block';
                                if (acc > 100) {
                                    showStatus('<strong>Position approximative</strong> (précision ~' + acc + ' m). Déplacez le marqueur pour ajuster votre emplacement exact.', 'error');
                                } else {
                                    showStatus('<strong>Succès :</strong> Position trouvée (précision ~' + acc + ' m). Ajustez le marqueur si besoin.', 'info');
                                }
                            } else {
                                showStatus('<strong>Erreur :</strong> Impossible de récupérer une position précise. Placez le marqueur manuellement sur la carte.', 'error');
                            }
                        }

                        watchId = navigator.geolocation.watchPosition(
                            (position) => {
                                // Garder la position la plus précise (accuracy la plus faible)
                                if (!bestPos || position.coords.accuracy < bestPos.coords.accuracy) {
                                    bestPos = position;
                                    map.setView([position.coords.latitude, position.coords.longitude], 17);
                                    marker.setLatLng([position.coords.latitude, position.coords.longitude]);
                                }
                                // Précision suffisante → on arrête tout de suite
                                if (position.coords.accuracy <= 25) {
                                    finishGeo(true);
                                }
                            },
                            (error) => {
                                if (bestPos) {
                                    finishGeo(true);
                                } else {
                                    done = true;
                                    if (watchId !== null) navigator.geolocation.clearWatch(watchId);
                                    btnGeo.disabled = false;
                                    btnGeo.innerHTML = originalContent;
                                    let errorMsg = 'Impossible de récupérer votre position.';
                                    if (error.code === 1) errorMsg = 'Géolocalisation refusée. Autorisez l\'accès à la localisation dans votre navigateur.';
                                    else if (error.code === 2) errorMsg = 'Position indisponible.';
                                    else if (error.code === 3) errorMsg = 'Délai dépassé, réessayez.';
                                    showStatus('<strong>Erreur :</strong> ' + errorMsg, 'error');
                                }
                            },
                            {
                                enableHighAccuracy: true,
                                timeout: 20000,
                                maximumAge: 0
                            }
                        );

                        // Après 15s, on s'arrête et on utilise la meilleure position obtenue
                        setTimeout(() => finishGeo(!!bestPos), 15000);
                    });
                }
            }
        });
    </script>
@endpush