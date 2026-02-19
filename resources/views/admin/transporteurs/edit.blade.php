@extends('layouts.admin')

@section('title', 'Modifier Transporteur : ' . $transporteur->user->prenom)

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.transporteurs.index') }}" style="color: #666; text-decoration: none;">Transporteurs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Modifier</span>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">

    <header style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Modifier Transporteur</h1>
        <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Mise à jour des informations de {{ $transporteur->user->prenom }} {{ $transporteur->user->nom }}.</p>
    </header>

    <form action="{{ route('admin.transporteurs.update', $transporteur) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
            
            <!-- Colonne Gauche -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section 1: Utilisateur (Lecture seule) -->
                <div style="background: #f9fafb; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1rem;">Utilisateur Associé</h2>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: #fff; border: 1px solid #e0e0e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #666;">
                            {{ substr($transporteur->user->prenom, 0, 1) }}{{ substr($transporteur->user->nom, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #333;">{{ $transporteur->user->prenom }} {{ $transporteur->user->nom }}</div>
                            <div style="font-size: 0.85rem; color: #666;">{{ $transporteur->user->email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Informations Véhicule -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Informations Véhicule</h2>
                    
                    <div style="display: grid; gap: 1.25rem;">
                        <div>
                            <label for="type_vehicule" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Type de véhicule <span style="color: red;">*</span></label>
                            <select name="type_vehicule" id="type_vehicule" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; background: white;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                <option value="Moto" {{ old('type_vehicule', $transporteur->type_vehicule) == 'Moto' ? 'selected' : '' }}>Moto</option>
                                <option value="Voiture" {{ old('type_vehicule', $transporteur->type_vehicule) == 'Voiture' ? 'selected' : '' }}>Voiture</option>
                                <option value="Camion" {{ old('type_vehicule', $transporteur->type_vehicule) == 'Camion' ? 'selected' : '' }}>Camion</option>
                                <option value="Van" {{ old('type_vehicule', $transporteur->type_vehicule) == 'Van' ? 'selected' : '' }}>Van</option>
                                <option value="Autre" {{ old('type_vehicule', $transporteur->type_vehicule) == 'Autre' ? 'selected' : '' }}>Autre...</option>
                            </select>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <div>
                                <label for="marque_vehicule" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Marque <span style="color: red;">*</span></label>
                                <select name="marque_vehicule" id="marque_vehicule" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; background: white;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                    <option value="">Sélectionner une marque</option>
                                </select>
                            </div>
                            <div>
                                <label for="modele_vehicule" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Modèle <span style="color: red;">*</span></label>
                                <select name="modele_vehicule" id="modele_vehicule" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; background: white;"
                                        onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                    <option value="">Sélectionner un modèle</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="immatriculation" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Plaque d'immatriculation <span style="color: red;">*</span></label>
                            <input type="text" name="immatriculation" id="immatriculation" value="{{ old('immatriculation', $transporteur->immatriculation) }}" required
                                   style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                   onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>

                        <div>
                            <label for="photo_vehicule" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Photo du véhicule</label>
                            @if($transporteur->photo_vehicule)
                                <div style="margin-bottom: 10px;">
                                    <img src="{{ route('documents.show', ['path' => base64_encode($transporteur->photo_vehicule)]) }}" style="height: 100px; border-radius: 4px; border: 1px solid #ddd;">
                                </div>
                            @endif
                            <input type="file" name="photo_vehicule" id="photo_vehicule" accept="image/*"
                                   style="width: 100%; padding: 8px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section 3: Documents / KYC IDs -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1rem;">Documents (IDs)</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div>
                            <label for="numero_permis" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">N° Permis de conduire</label>
                            <input type="text" name="numero_permis" id="numero_permis" value="{{ old('numero_permis', $transporteur->numero_permis) }}"
                                   style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;"
                                   onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>
                        <div>
                            <label for="permis_recto" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">Photo du permis (Recto)</label>
                            @if($transporteur->permis_recto)
                                <div style="margin-bottom: 10px;">
                                    <a href="{{ route('documents.show', ['path' => base64_encode($transporteur->permis_recto)]) }}" target="_blank" style="font-size: 0.75rem; color: #ff750f;">Voir le document actuel</a>
                                </div>
                            @endif
                            <input type="file" name="permis_recto" id="permis_recto" accept="image/*,application/pdf"
                                   style="width: 100%; padding: 6px 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.85rem; color: #333; outline: none;">
                        </div>
                    </div>
                </div>

                <!-- Section 4: État -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <label for="actif" style="display: flex; align-items: center; gap: 12px; cursor: pointer; user-select: none;">
                        <div style="position: relative; width: 20px; height: 20px;">
                            <input type="checkbox" name="actif" id="actif" value="1" {{ old('actif', $transporteur->actif) ? 'checked' : '' }}
                                   style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;"
                                   onchange="this.nextElementSibling.style.backgroundColor = this.checked ? '#ff750f' : '#fff'; this.nextElementSibling.style.borderColor = this.checked ? '#ff750f' : '#e0e0e0'; this.nextElementSibling.querySelector('svg').style.display = this.checked ? 'block' : 'none'">
                            <div style="position: absolute; top: 0; left: 0; height: 20px; width: 20px; background-color: {{ old('actif', $transporteur->actif) ? '#ff750f' : '#fff' }}; border: 2px solid {{ old('actif', $transporteur->actif) ? '#ff750f' : '#e0e0e0' }}; border-radius: 4px; transition: all 0.2s;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: {{ old('actif', $transporteur->actif) ? 'block' : 'none' }};">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                        </div>
                        <span style="font-size: 0.9rem; font-weight: 550; color: #333;">Transporteur Actif</span>
                    </label>
                </div>

                <!-- Section 5: Statut -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <div style="font-size: 0.85rem; color: #666; margin-bottom: 10px;">Statut de vérification</div>
                    @if($transporteur->statut_verification === 'verifie')
                        <span style="background: #ecfdf5; color: #10b981; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; border: 1px solid #d1fae5;">Vérifié</span>
                    @elseif($transporteur->statut_verification === 'rejete')
                        <span style="background: #fef2f2; color: #ef4444; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; border: 1px solid #fee2e2;">Rejeté</span>
                    @else
                        <span style="background: #fffbeb; color: #d97706; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; border: 1px solid #fef3c7;">En attente</span>
                    @endif
                </div>

                <!-- Boutons d'action -->
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="submit" style="background: #000; color: #fff; border: none; padding: 0.85rem; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                        Mettre à jour
                    </button>
                    <a href="{{ route('admin.transporteurs.index') }}" style="display: flex; justify-content: center; padding: 0.85rem; background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;"
                       onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const vehiculeData = {
        "Toyota": ["Hilux", "Corolla", "Land Cruiser", "RAV4", "Yaris", "Hiace", "Avensis", "Fortuner"],
        "Mercedes-Benz": ["Vito", "Sprinter", "Classe C", "Classe E", "Actros", "GLK", "ML"],
        "Peugeot": ["Partner", "Expert", "Boxer", "208", "301", "308", "508", "3008"],
        "Renault": ["Kangoo", "Trafic", "Clio", "Megane", "Logan", "Duster"],
        "Hyundai": ["H1", "H100", "Accent", "Elantra", "Tucson", "Santa Fe", "i10", "i20"],
        "Kia": ["K2700", "Rio", "Sportage", "Picanto", "Sorento", "Cerato", "Optima"],
        "Ford": ["Ranger", "Transit", "Focus", "Fiesta", "Explorer", "Everest"],
        "Mitsubishi": ["L200", "Canter", "Pajero", "Outlander", "ASX"],
        "Nissan": ["Navara", "Patrol", "Qashqai", "Urvan", "NP300"],
        "Volkswagen": ["Transporter", "Caddy", "Golf", "Polo", "Passat", "Amarok", "Crafter"],
        "Isuzu": ["D-Max", "N-Series", "F-Series"],
        "Suzuki": ["Carry", "Swift", "Vitara", "Ertiga", "Jimny"],
        "Dacia": ["Logan", "Sandero", "Duster", "Dokker"]
    };

    const marqueSelect = document.getElementById('marque_vehicule');
    const modeleSelect = document.getElementById('modele_vehicule');

    const currentMarque = "{{ old('marque_vehicule', $transporteur->marque_vehicule) }}";
    const currentModele = "{{ old('modele_vehicule', $transporteur->modele_vehicule) }}";

    // Populate Marque
    Object.keys(vehiculeData).sort().forEach(marque => {
        const option = document.createElement('option');
        option.value = marque;
        option.textContent = marque;
        if (currentMarque === marque) option.selected = true;
        marqueSelect.appendChild(option);
    });

    // Add Autre to Marques if not already there
    if (!vehiculeData["Autre"]) {
        const optionAutreMarque = document.createElement('option');
        optionAutreMarque.value = "Autre";
        optionAutreMarque.textContent = "Autre...";
        if (currentMarque === "Autre") optionAutreMarque.selected = true;
        marqueSelect.appendChild(optionAutreMarque);
    }

    // Populate "Autre" for Marque if not in list
    if (currentMarque && !vehiculeData[currentMarque]) {
        const optionAutre = document.createElement('option');
        optionAutre.value = currentMarque;
        optionAutre.textContent = currentMarque;
        optionAutre.selected = true;
        marqueSelect.appendChild(optionAutre);
    }

    // Function to update models
    function updateModels(selectedMarque, selectedModel = null) {
        modeleSelect.innerHTML = '<option value="">Sélectionner un modèle</option>';
        if (vehiculeData[selectedMarque]) {
            vehiculeData[selectedMarque].sort().forEach(modele => {
                const option = document.createElement('option');
                option.value = modele;
                option.textContent = modele;
                if (selectedModel === modele) option.selected = true;
                modeleSelect.appendChild(option);
            });
            // Add "Autre" option
            const optionAutre = document.createElement('option');
            optionAutre.value = "Autre";
            optionAutre.textContent = "Autre...";
            if (selectedModel === "Autre") optionAutre.selected = true;
            modeleSelect.appendChild(optionAutre);
        } else if (selectedModel) {
            // Case where marque is not in list but we have a model
             const option = document.createElement('option');
             option.value = selectedModel;
             option.textContent = selectedModel;
             option.selected = true;
             modeleSelect.appendChild(option);
        }
    }

    marqueSelect.addEventListener('change', function() {
        updateModels(this.value);
    });

    // Initial load
    if (marqueSelect.value) {
        updateModels(marqueSelect.value, currentModele);
    }
});
</script>
@endpush
@endsection
