@extends('layouts.app')

@section('title', 'Créer une annonce - Service')

@section('content')
<div style="max-width: 1000px; margin: 3rem auto; padding: 2rem;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('annonces.index') }}" style="display: inline-block; color: #EF3B2D; text-decoration: none; margin-bottom: 1rem;">
            ← Retour aux annonces
        </a>
    </div>

    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h1 style="color: #333; margin-bottom: 2rem;">Créer une annonce - Service</h1>

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('annonces.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="service">

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
                <input type="text" name="titre" value="{{ old('titre') }}" required maxlength="255" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Ex: Réparation de smartphones">
                @error('titre')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Description <span style="color: #EF3B2D;">*</span></label>
                <textarea name="description" required minlength="20" rows="5" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Décrivez votre service en détail (minimum 20 caractères)">{{ old('description') }}</textarea>
                @error('description')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Type de tarification -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Type de tarification <span style="color: #EF3B2D;">*</span></label>
                <select name="type_tarification" id="type_tarification" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">Sélectionnez</option>
                    <option value="fixe" {{ old('type_tarification') == 'fixe' ? 'selected' : '' }}>Forfait fixe</option>
                    <option value="horaire" {{ old('type_tarification') == 'horaire' ? 'selected' : '' }}>Tarif horaire</option>
                    <option value="devis" {{ old('type_tarification') == 'devis' ? 'selected' : '' }}>Sur devis</option>
                </select>
                @error('type_tarification')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Prix (si forfait fixe) -->
            <div style="margin-bottom: 1.5rem;" id="prix_fixe_container" style="display: none;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Prix forfaitaire (FCFA)</label>
                <input type="number" name="prix" id="prix_fixe" value="{{ old('prix') }}" min="0" step="0.01" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="15000">
                @error('prix')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tarif horaire (si tarif horaire) -->
            <div style="margin-bottom: 1.5rem;" id="tarif_horaire_container" style="display: none;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Tarif horaire (FCFA) <span style="color: #EF3B2D;">*</span></label>
                <input type="number" name="tarif_horaire" value="{{ old('tarif_horaire') }}" min="0" step="0.01" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="5000">
                @error('tarif_horaire')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Durée estimée -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Durée estimée</label>
                <input type="text" name="duree_estimee" value="{{ old('duree_estimee') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Ex: 2 heures">
                @error('duree_estimee')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Déplacement inclus -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; color: #333; font-weight: 500; cursor: pointer;">
                    <input type="checkbox" name="deplacement_inclus" value="1" {{ old('deplacement_inclus') ? 'checked' : '' }}>
                    Déplacement inclus
                </label>
                @error('deplacement_inclus')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Zone d'intervention -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Zone d'intervention</label>
                <input type="text" name="zone_intervention" value="{{ old('zone_intervention') }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" placeholder="Ex: Bamako">
                @error('zone_intervention')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Photos -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Photos (optionnel, 1-8 photos, max 5 Mo chacune)</label>
                <input type="file" name="photos[]" accept="image/jpeg,image/jpg,image/png,image/webp" multiple style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                <small style="color: #666;">Formats acceptés : JPG, PNG, WEBP. Taille maximale : 5 Mo par photo</small>
                @error('photos.*')
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

@push('scripts')
<script>
    document.getElementById('type_tarification').addEventListener('change', function() {
        const prixFixeContainer = document.getElementById('prix_fixe_container');
        const tarifHoraireContainer = document.getElementById('tarif_horaire_container');
        const prixFixe = document.getElementById('prix_fixe');
        
        if (this.value === 'fixe') {
            prixFixeContainer.style.display = 'block';
            tarifHoraireContainer.style.display = 'none';
            prixFixe.required = true;
        } else if (this.value === 'horaire') {
            prixFixeContainer.style.display = 'none';
            tarifHoraireContainer.style.display = 'block';
            prixFixe.required = false;
        } else {
            prixFixeContainer.style.display = 'none';
            tarifHoraireContainer.style.display = 'none';
            prixFixe.required = false;
        }
    });
    
    // Initialiser l'affichage au chargement
    document.getElementById('type_tarification').dispatchEvent(new Event('change'));
</script>
@endpush
@endsection

