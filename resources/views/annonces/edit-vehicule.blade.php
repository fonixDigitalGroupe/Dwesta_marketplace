@extends('layouts.app')

@section('title', 'Modifier mon véhicule - Mady Market')

@push('styles')
    <style>
        :root {
            --primary-black: #1a1a1a;
            --secondary-grey: #4a4a4a;
            --light-grey: #f5f5f5;
            --border-color: #e0e0e0;
            --accent-color: #000000;
        }

        .create-annonce-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 3rem;
        }

        /* Sidebar - Progress Indicator */
        .progress-sidebar {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .progress-step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
            position: relative;
        }

        .progress-step:last-child {
            margin-bottom: 0;
        }

        .progress-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 12px;
            top: 32px;
            width: 2px;
            height: calc(100% + 0.5rem);
            background: var(--border-color);
        }

        .progress-step.active:not(:last-child)::after,
        .progress-step.completed:not(:last-child)::after {
            background: var(--primary-black);
        }

        .step-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .progress-step.active .step-circle {
            border-color: var(--primary-black);
            background: var(--primary-black);
        }

        .progress-step.completed .step-circle {
            border-color: var(--primary-black);
            background: var(--primary-black);
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
            display: none;
        }

        .progress-step.active .step-dot {
            display: block;
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--secondary-grey);
            margin-bottom: 0.25rem;
        }

        .progress-step.active .step-title {
            color: var(--primary-black);
        }

        .step-number {
            font-size: 0.75rem;
            color: #888;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Form Content */
        .form-content {
            background: white;
            border-radius: 12px;
            padding: 3rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary-black);
            margin-bottom: 1.5rem;
            letter-spacing: -0.025em;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            font-weight: 700;
            color: var(--primary-black);
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary-black);
            box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.05);
        }

        textarea.form-input {
            min-height: 150px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary-black);
            color: white;
        }

        .btn-primary:hover {
            background: #333;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--light-grey);
            color: var(--primary-black);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #e5e5e5;
        }

        /* Steps display */
        .form-step {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Image preview */
        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .image-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--border-color);
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0,0,0,0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .remove-btn:hover {
            background: rgba(0,0,0,0.8);
        }

        .option-card {
            background: #fdfdfd;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all 0.2s;
        }

        .option-card:hover {
            border-color: var(--primary-black);
            background: #fff;
        }

        .option-card input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 0.25rem;
            cursor: pointer;
            accent-color: var(--primary-black);
        }
    </style>
@endpush

@section('content')
<div class="breadcrumb" style="max-width: 1200px; margin: 1rem auto; padding: 0 1rem;">
    <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('vendeur.mes-annonces') }}">Mes annonces</a> > <span>Modifier mon véhicule</span>
</div>

<div class="create-annonce-container">
    <aside class="progress-sidebar">
        <div class="progress-step active" data-step="1">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 1</div>
                <div class="step-title">Véhicule & Catégorie</div>
            </div>
        </div>
        <div class="progress-step" data-step="2">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 2</div>
                <div class="step-title">Modèle & Moteur</div>
            </div>
        </div>
        <div class="progress-step" data-step="3">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 3</div>
                <div class="step-title">Détails & Photos</div>
            </div>
        </div>
        <div class="progress-step" data-step="4">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 4</div>
                <div class="step-title">Options & Publication</div>
            </div>
        </div>
    </aside>

    <main class="form-content">
        <form id="editVehiculeForm" action="{{ route('annonces.update', $annonce) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="vehicule">

            <!-- Étape 1: Véhicule & Catégorie -->
            <div class="form-step active" id="step1">
                <h2 class="form-title">Modifier votre véhicule</h2>
                
                <div class="form-group">
                    <label class="form-label">Titre de l'annonce <span style="color: #bf0000;">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre', $annonce->titre) }}" class="form-input" required maxlength="255" placeholder="Ex: Toyota Land Cruiser V8 2022">
                    @error('titre') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Catégorie <span style="color: #bf0000;">*</span></label>
                    <select name="categorie_id" class="form-input" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $categorie)
                            <option value="{{ $categorie->id }}" {{ old('categorie_id', $annonce->categorie_id) == $categorie->id ? 'selected' : '' }}>
                                {{ $categorie->nom }}
                            </option>
                            @foreach($categorie->enfantsActifs as $enfant)
                                <option value="{{ $enfant->id }}" {{ old('categorie_id', $annonce->categorie_id) == $enfant->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;→ {{ $enfant->nom }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Prix de vente (FCFA) <span style="color: #bf0000;">*</span></label>
                    <input type="number" name="prix" value="{{ old('prix', $annonce->prix) }}" class="form-input" required min="0" step="1">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">Continuer</button>
                </div>
            </div>

            <!-- Étape 2: Modèle & Moteur -->
            <div class="form-step" id="step2">
                <h2 class="form-title">Spécifications techniques</h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Marque <span style="color: #bf0000;">*</span></label>
                        <input type="text" name="marque" value="{{ old('marque', $annonce->vehicule->marque ?? '') }}" class="form-input" required placeholder="Ex: Toyota">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Modèle <span style="color: #bf0000;">*</span></label>
                        <input type="text" name="modele" value="{{ old('modele', $annonce->vehicule->modele ?? '') }}" class="form-input" required placeholder="Ex: Prado">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Année</label>
                        <input type="number" name="annee" value="{{ old('annee', $annonce->vehicule->annee ?? '') }}" class="form-input" min="1900" max="{{ date('Y') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kilométrage (km)</label>
                        <input type="number" name="kilometrage" value="{{ old('kilometrage', $annonce->vehicule->kilometrage ?? '') }}" class="form-input" min="0">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Carburant</label>
                        <select name="carburant" class="form-input">
                            <option value="">Sélectionnez</option>
                            <option value="Essence" {{ (old('carburant', $annonce->vehicule->carburant ?? '') == 'Essence') ? 'selected' : '' }}>Essence</option>
                            <option value="Diesel" {{ (old('carburant', $annonce->vehicule->carburant ?? '') == 'Diesel') ? 'selected' : '' }}>Diesel</option>
                            <option value="Hybride" {{ (old('carburant', $annonce->vehicule->carburant ?? '') == 'Hybride') ? 'selected' : '' }}>Hybride</option>
                            <option value="Électrique" {{ (old('carburant', $annonce->vehicule->carburant ?? '') == 'Électrique') ? 'selected' : '' }}>Électrique</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Boîte de vitesse</label>
                        <select name="boite_vitesse" class="form-input">
                            <option value="">Sélectionnez</option>
                            <option value="Manuelle" {{ (old('boite_vitesse', $annonce->vehicule->boite_vitesse ?? '') == 'Manuelle') ? 'selected' : '' }}>Manuelle</option>
                            <option value="Automatique" {{ (old('boite_vitesse', $annonce->vehicule->boite_vitesse ?? '') == 'Automatique') ? 'selected' : '' }}>Automatique</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Précédent</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">Continuer</button>
                </div>
            </div>

            <!-- Étape 3: Détails & Photos -->
            <div class="form-step" id="step3">
                <h2 class="form-title">État & Apparence</h2>

                <div class="form-group">
                    <label class="form-label">Description <span style="color: #bf0000;">*</span></label>
                    <textarea name="description" class="form-input" required minlength="20" placeholder="Décrivez l'historique d'entretien, les options installées, l'état général...">{{ old('description', $annonce->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">État</label>
                        <select name="etat" class="form-input">
                            <option value="Neuf" {{ (old('etat', $annonce->vehicule->etat ?? '') == 'Neuf') ? 'selected' : '' }}>Neuf</option>
                            <option value="Occasion" {{ (old('etat', $annonce->vehicule->etat ?? '') == 'Occasion') ? 'selected' : '' }}>Occasion</option>
                            <option value="Reconditionné" {{ (old('etat', $annonce->vehicule->etat ?? '') == 'Reconditionné') ? 'selected' : '' }}>Reconditionné</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Couleur</label>
                        <input type="text" name="couleur" value="{{ old('couleur', $annonce->vehicule->couleur ?? '') }}" class="form-input" placeholder="Ex: Gris">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Portes</label>
                        <input type="number" name="portes" value="{{ old('portes', $annonce->vehicule->portes ?? '') }}" class="form-input" min="2" max="6">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Places</label>
                        <input type="number" name="places" value="{{ old('places', $annonce->vehicule->places ?? '') }}" class="form-input" min="1" max="60">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Photos du véhicule</label>
                    
                    @if($annonce->photos->count() > 0)
                        <div class="image-preview-container" style="margin-bottom: 1.5rem;">
                            @foreach($annonce->photos as $photo)
                                <div class="image-item" id="media-{{ $photo->id }}">
                                    <img src="{{ asset('storage/' . $photo->chemin) }}" alt="Photo véhicule">
                                    <button type="button" class="remove-btn" onclick="markForDeletion({{ $photo->id }})">&times;</button>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="delete_media_ids" id="delete_media_ids" value="">
                    @endif

                    <input type="file" name="photos[]" multiple class="form-input" accept="image/*">
                    <p style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;">Formats JPG, PNG, WEBP. Max 5 Mo par photo.</p>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Précédent</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(3)">Continuer</button>
                </div>
            </div>

            <!-- Étape 4: Options & Publication -->
            <div class="form-step" id="step4">
                <h2 class="form-title">Finalisation</h2>

                @if(count($optionsDisponibles) > 0)
                    <div class="form-group">
                        <label class="form-label">Mise en avant</label>
                        @foreach($optionsDisponibles as $key => $option)
                            <div class="option-card">
                                <input type="checkbox" name="options[{{ $key }}]" id="opt-{{ $key }}" value="1" 
                                    {{ ($annonce->options && $annonce->options->{$key}) ? 'checked' : '' }}>
                                <div>
                                    <label for="opt-{{ $key }}" style="font-weight: 700; cursor: pointer; display: block; margin-bottom: 0.25rem;">
                                        {{ $option['nom'] }} - {{ number_format($option['prix'], 0, ',', ' ') }} FCFA
                                    </label>
                                    <p style="font-size: 0.85rem; color: #666; margin: 0;">{{ $option['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-input">
                        <option value="publiee" {{ $annonce->statut == 'publiee' ? 'selected' : '' }}>Publiée (En ligne)</option>
                        <option value="brouillon" {{ $annonce->statut == 'brouillon' ? 'selected' : '' }}>Brouillon (Hors ligne)</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Précédent</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </div>
        </form>
    </main>
</div>
@endsection

@push('scripts')
<script>
    function nextStep(current) {
        document.getElementById('step' + current).classList.remove('active');
        document.getElementById('step' + (current + 1)).classList.add('active');
        
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.add('completed');
        document.querySelector(`.progress-step[data-step="${current + 1}"]`).classList.add('active');
        
        window.scrollTo(0, 0);
    }

    function prevStep(current) {
        document.getElementById('step' + current).classList.remove('active');
        document.getElementById('step' + (current - 1)).classList.add('active');
        
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${current - 1}"]`).classList.remove('completed');
        document.querySelector(`.progress-step[data-step="${current - 1}"]`).classList.add('active');
        
        window.scrollTo(0, 0);
    }

    let deletedIds = [];
    function markForDeletion(id) {
        deletedIds.push(id);
        document.getElementById('media-' + id).style.opacity = '0.3';
        document.getElementById('delete_media_ids').value = deletedIds.join(',');
    }
</script>
@endpush
