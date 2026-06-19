@extends('layouts.admin')

@section('title', 'Nouvelle Bannière')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    .sub-header-slot { display: none !important; }
    
    .amazon-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 4px;
        padding: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 8px;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #adb1b8;
        border-radius: 3px;
        font-size: 0.9rem;
        transition: all 0.1s;
        outline: none;
        background: #fff;
    }

    .form-input:focus, .form-select:focus {
        border-color: #e77600 !important;
        
    }

    .btn-amazon-primary {
        background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); border: 1px solid #004aad;
        border-radius: 3px; color: #fff;
        padding: 8px 15px;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-amazon-secondary {
        background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
        border: 1px solid #adb1b8;
        border-radius: 3px;
        color: #111;
        padding: 8px 15px;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .dropzone-amazon {
        border: 1px dashed #adb1b8;
        border-radius: 4px;
        padding: 40px;
        text-align: center;
        background: #f9f9f9;
        cursor: pointer;
        transition: all 0.2s;
    }

    .dropzone-amazon:hover {
        border-color: #e77600;
        background: #fff;
    }
</style>
@endpush

@section('content')
<div style="max-width: 100%; padding: 0;">
    
    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1 style="font-size: 1.5rem; font-weight: 500; color: #111; margin: 0;">Ajouter une Bannière</h1>
        <a href="{{ route('admin.banners.index') }}" class="btn-amazon-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 25px;">
            
            {{-- Colonne Gauche : Contenu --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                {{-- Carte Informations --}}
                <div class="amazon-card">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Configuration de la bannière
                    </h2>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        
                        <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                            <div>
                                <label for="category_id" class="form-label">Catégorie cible (optionnel)</label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">-- Toutes les catégories --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nom }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="title" class="form-label">Titre commercial <span style="color: #c40000;">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-input @error('title') is-invalid @enderror" placeholder="Ex: Promo d'été 2025, Jusqu'à -50%" required>
                            @error('title') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="link_url" class="form-label">Redirection lors du clic</label>
                            <select name="link_url" id="link_url" class="form-select">
                                <option value="">-- Sélectionner une destination --</option>
                                @foreach($categories as $category)
                                    @php
                                        $ancetres = $category->ancetres ?? [];
                                        $catUrl = '';
                                        if (count($ancetres) > 0) {
                                            $racine = $ancetres[0];
                                            $params = ['slug' => $racine->slug];
                                            if (count($ancetres) === 1) {
                                                $params['active'] = $category->id;
                                            } else {
                                                $params['active'] = $ancetres[1]->id;
                                                $params['n3'] = $category->id;
                                            }
                                            $catUrl = route('categories.show', $params, false);
                                        } else {
                                            $catUrl = route('categories.show', $category->slug, false);
                                        }
                                    @endphp
                                    <option value="{{ $catUrl }}" {{ old('link_url') == $catUrl ? 'selected' : '' }}>
                                        {{ $category->chemin ?? $category->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('link_url') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                        </div>

                        <div style="border-top: 1px solid #eee; padding-top: 20px;">
                            <div id="promo-categories-section" style="background: #fcfcfc; border: 1px solid #eee; padding: 15px; border-radius: 4px;">
                                <label class="form-label">Associer à une ou plusieurs catégories (Menu de la page)</label>
                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #adb1b8; border-radius: 3px; padding: 10px; background: #fff;">
                                    @foreach($allCategories as $cat)
                                        <div style="display: flex; flex-direction: column; gap: 5px; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <input type="checkbox" name="categories[]" id="cat_{{ $cat->id }}" value="{{ $cat->id }}"
                                                    {{ is_array(old('categories')) && in_array($cat->id, old('categories')) ? 'checked' : '' }}
                                                    style="cursor: pointer; accent-color: #007bff;">
                                                <label for="cat_{{ $cat->id }}" style="font-size: 0.85rem; cursor: pointer; font-weight: 500;">{{ $cat->chemin ?? $cat->nom }}</label>
                                            </div>
                                            <div style="padding-left: 25px;">
                                                <input type="text" name="category_descriptions[{{ $cat->id }}]" 
                                                       value="{{ old('category_descriptions.'.$cat->id) }}" 
                                                       class="form-input" 
                                                       placeholder="Description / Critères (ex: Jusqu'à -20% sur cette sélection)" 
                                                       style="font-size: 0.75rem; height: 30px; padding: 4px 8px;">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p style="font-size: 0.75rem; color: #555; margin-top: 8px;">Si coché, les utilisateurs seront redirigés vers une page regroupant ces catégories.</p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Carte Visuels --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="amazon-card">
                        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                            Image de la bannière
                        </h2>

                        <div class="dropzone-amazon" onclick="document.getElementById('image-input').click()">
                            <div id="dropzone-content">
                                <i class="fas fa-image" style="font-size: 32px; color: #bbb; margin-bottom: 10px;"></i>
                                <p style="font-size: 0.85rem; color: #111; margin-bottom: 2px; font-weight: 700;">Cliquez pour l'image principale</p>
                            </div>
                            <img id="preview-img" style="display: none; max-width: 100%; max-height: 150px; object-fit: contain; border-radius: 2px;">
                        </div>
                        <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview-img', 'dropzone-content')" required>
                        @error('image') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>

                    <div class="amazon-card">
                        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                            Image de la page (Landing)
                        </h2>

                        <div class="dropzone-amazon" onclick="document.getElementById('landing-image-input').click()">
                            <div id="landing-dropzone-content">
                                <i class="fas fa-desktop" style="font-size: 32px; color: #bbb; margin-bottom: 10px;"></i>
                                <p style="font-size: 0.85rem; color: #111; margin-bottom: 2px; font-weight: 700;">Cliquez pour l'image de la page</p>
                            </div>
                            <img id="preview-landing-img" style="display: none; max-width: 100%; max-height: 150px; object-fit: contain; border-radius: 2px;">
                        </div>
                        <input type="file" id="landing-image-input" name="landing_page_image" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview-landing-img', 'landing-dropzone-content')">
                        @error('landing_page_image') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>
                </div>

            </div>

            {{-- Colonne Droite : Paramètres --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                <div class="amazon-card">
                    <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 15px; color: #111;">Calendrier & Ordre</h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label for="order" class="form-label">Ordre d'affichage</label>
                            <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0" class="form-input" required>
                            @error('order') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                            <p style="font-size: 0.75rem; color: #555; margin-top: 5px;">Plus le chiffre est bas, plus la bannière apparaît en premier.</p>
                        </div>

                        <div style="border-top: 1px solid #eee; padding-top: 15px;">
                            <label for="start_date" class="form-label">Date de début (optionnel)</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-input">
                        </div>

                        <div>
                            <label for="end_date" class="form-label">Date de fin (optionnel)</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-input">
                        </div>

                        <div style="background: #fcfcfc; border: 1px solid #eee; padding: 15px; border-radius: 4px;">
                            <div style="display: flex; align-items: start; gap: 10px;">
                                <input type="checkbox" name="active" id="active" value="1" {{ old('active', true) ? 'checked' : '' }} 
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #e47911; margin-top: 2px;">
                                <label for="active" style="cursor: pointer;">
                                    <div style="font-size: 0.85rem; font-weight: 700; color: #111;">Rendre visible immédiatement</div>
                                    <div style="font-size: 0.75rem; color: #555;">La bannière sera affichée sur le site si les dates concordent.</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 25px; display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 40px;">
                            Enregistrer la bannière
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn-amazon-secondary" style="width: 100%; height: 40px;">
                            Annuler
                        </a>
                    </div>
                </div>

                {{-- Aide (removed) --}}

            </div>

        </div>
    </form>
</div>

<script>
function previewImage(input, previewId, dropzoneId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const dropzone = document.getElementById(dropzoneId);
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
            if (dropzone) dropzone.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function togglePromoCategories(checked) {
    // Logic removed as per user request
}
</script>
@endsection
