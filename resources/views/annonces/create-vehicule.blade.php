@extends('layouts.app')

@section('title', 'Créer une annonce - Véhicule')

@section('content')
<div style="max-width: 1000px; margin: 3rem auto; padding: 2rem;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('annonces.index') }}" style="display: inline-block; color: #EF3B2D; text-decoration: none; margin-bottom: 1rem;">
            ← Retour aux annonces
        </a>
    </div>

    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h1 style="color: #333; margin-bottom: 2rem;">Créer une annonce - Véhicule</h1>

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('annonces.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="vehicule">

            <!-- Catégorie -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Catégorie <span style="color: #EF3B2D;">*</span></label>
                <select name="categorie_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                        @foreach($categorie->enfantsActifs as $enfant)
                            <option value="{{ $enfant->id }}" {{ old('categorie_id') == $enfant->id ? 'selected' : '' }}>
                                &nbsp;&nbsp;→ {{ $enfant->nom }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
                @error('categorie_id')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Titre -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Titre <span style="color: #EF3B2D;">*</span></label>
                <input type="text" name="titre" value="{{ old('titre') }}" required maxlength="255" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Ex: Toyota Corolla 2020">
                @error('titre')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Description <span style="color: #EF3B2D;">*</span></label>
                <textarea name="description" required minlength="20" rows="5" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Décrivez votre véhicule en détail (minimum 20 caractères)">{{ old('description') }}</textarea>
                @error('description')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Prix -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Prix (FCFA) <span style="color: #EF3B2D;">*</span></label>
                <input type="number" name="prix" value="{{ old('prix') }}" required min="0" step="0.01" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="8000000">
                @error('prix')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Marque et Modèle (obligatoires) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Marque <span style="color: #EF3B2D;">*</span></label>
                    <input type="text" name="marque" value="{{ old('marque') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Ex: Toyota">
                    @error('marque')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Modèle <span style="color: #EF3B2D;">*</span></label>
                    <input type="text" name="modele" value="{{ old('modele') }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Ex: Corolla">
                    @error('modele')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Année et Kilométrage -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Année</label>
                    <input type="number" name="annee" value="{{ old('annee') }}" min="1900" max="{{ date('Y') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="2020">
                    @error('annee')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Kilométrage</label>
                    <input type="number" name="kilometrage" value="{{ old('kilometrage') }}" min="0" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="50000">
                    @error('kilometrage')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Carburant et Boîte de vitesses -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Carburant</label>
                    <input type="text" name="carburant" value="{{ old('carburant') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Ex: Essence">
                    @error('carburant')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Boîte de vitesses</label>
                    <select name="boite_vitesse" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                        <option value="">Sélectionnez</option>
                        <option value="Manuelle" {{ old('boite_vitesse') == 'Manuelle' ? 'selected' : '' }}>Manuelle</option>
                        <option value="Automatique" {{ old('boite_vitesse') == 'Automatique' ? 'selected' : '' }}>Automatique</option>
                    </select>
                    @error('boite_vitesse')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- État, Couleur, Portes, Places -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">État</label>
                    <select name="etat" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                        <option value="">Sélectionnez</option>
                        <option value="Neuf" {{ old('etat') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="Occasion" {{ old('etat') == 'Occasion' ? 'selected' : '' }}>Occasion</option>
                        <option value="Reconditionné" {{ old('etat') == 'Reconditionné' ? 'selected' : '' }}>Reconditionné</option>
                    </select>
                    @error('etat')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Couleur</label>
                    <input type="text" name="couleur" value="{{ old('couleur') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Ex: Blanc">
                    @error('couleur')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Nombre de portes</label>
                    <input type="number" name="portes" value="{{ old('portes') }}" min="2" max="5" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="4">
                    @error('portes')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Nombre de places</label>
                    <input type="number" name="places" value="{{ old('places') }}" min="1" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="5">
                    @error('places')
                        <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Photos -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Photos <span style="color: #EF3B2D;">*</span> (1-8 photos, max 5 Mo chacune)</label>
                <input type="file" name="photos[]" accept="image/jpeg,image/jpg,image/png,image/webp" multiple required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                <small style="color: #666;">Formats acceptés : JPG, PNG, WEBP. Taille maximale : 5 Mo par photo</small>
                @error('photos')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Options payantes -->
            <div style="margin-bottom: 1.5rem; padding: 1.5rem; background: #f8f9fa; border-radius: 4px;">
                <h3 style="color: #333; margin-bottom: 1rem;">Options payantes</h3>
                
                @foreach($optionsDisponibles as $key => $option)
                    <div style="margin-bottom: 1rem; display: flex; align-items: start; gap: 1rem;">
                        <input type="checkbox" name="options[{{ $key }}]" id="option_{{ $key }}" value="1" style="margin-top: 0.25rem;">
                        <div style="flex: 1;">
                            <label for="option_{{ $key }}" style="color: #333; font-weight: 500; cursor: pointer;">
                                {{ $option['nom'] }} - {{ number_format($option['prix'], 0, ',', ' ') }} FCFA
                                @if($option['duree'])
                                    ({{ $option['duree'] }} jours)
                                @endif
                            </label>
                            <p style="color: #666; font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $option['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Statut -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Statut</label>
                <select name="statut" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="brouillon" {{ old('statut', 'brouillon') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="publiee" {{ old('statut') == 'publiee' ? 'selected' : '' }}>Publier immédiatement</option>
                </select>
            </div>

            <!-- Boutons -->
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" style="flex: 1; background: #EF3B2D; color: white; border: none; padding: 0.75rem; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer;">
                    Enregistrer
                </button>
                <a href="{{ route('annonces.index') }}" style="flex: 1; display: block; text-align: center; background: #6c757d; color: white; padding: 0.75rem; border-radius: 4px; text-decoration: none; font-size: 1rem; font-weight: 500;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

