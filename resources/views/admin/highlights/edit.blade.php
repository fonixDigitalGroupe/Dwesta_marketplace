@extends('layouts.admin')

@section('title', 'Modifier l\'Actualité')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
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
        box-shadow: 0 0 3px 2px rgba(228, 121, 17, 0.5) !important;
    }

    .btn-amazon-primary {
        background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
        border: 1px solid #a88734;
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
        padding: 30px;
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
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    
    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1 style="font-size: 1.5rem; font-weight: 500; color: #111; margin: 0;">Modifier l'Actualité</h1>
        <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    @if ($errors->any())
    <div style="background: #FFF4F4; border: 1px solid #c40000; border-radius: 4px; padding: 15px; margin-bottom: 25px;">
        <div style="color: #c40000; font-weight: 700; margin-bottom: 5px; font-size: 0.9rem;">
            <i class="fas fa-exclamation-triangle"></i> Des erreurs sont survenues :
        </div>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li style="color: #c40000; font-size: 0.85rem;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.highlights.update', $highlight) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 25px;">
            
            {{-- Colonne Gauche --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                <div class="amazon-card">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Contenu de l'actualité
                    </h2>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label for="title" class="form-label">Titre principal <span style="color: #c40000;">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $highlight->title) }}" class="form-input" placeholder="Ex: Mode Homme, Été 2025..." required>
                        </div>

                        <div>
                            <label for="subtitle" class="form-label">Sous-titre <span style="font-weight: 400; color: #565959;">— optionnel</span></label>
                            <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $highlight->subtitle) }}" class="form-input" placeholder="Ex: Nouveautés été">
                        </div>

                        <div>
                            <label for="link_url" class="form-label">Catégorie de redirection</label>
                            <select name="link_url" id="link_url" class="form-select">
                                <option value="">-- Sélectionner une catégorie --</option>
                                @foreach($categories as $category)
                                    @php
                                        $ancetres = $category->ancetres;
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
                                    <option value="{{ $catUrl }}" {{ old('link_url', $highlight->link_url) == $catUrl ? 'selected' : '' }}>
                                        {{ $category->chemin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="amazon-card">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Image d'illustration
                    </h2>

                    <div class="dropzone-amazon" onclick="document.getElementById('image-input').click()">
                        <div id="dropzone-content" style="{{ $highlight->image_path ? 'display: none;' : '' }}">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #bbb; margin-bottom: 10px;"></i>
                            <p style="font-size: 0.9rem; color: #111; font-weight: 700;">Changer l'image</p>
                        </div>
                        <img id="preview-img" src="{{ $highlight->image_url }}" style="{{ $highlight->image_path ? 'display: inline-block;' : 'display: none;' }} max-width: 100%; max-height: 250px; object-fit: contain; border-radius: 2px;">
                        
                        <div style="margin-top: 15px; color: #565959; font-size: 0.85rem;">
                             Cliquer pour sélectionner un nouveau fichier
                        </div>
                    </div>
                    <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                </div>

            </div>

            {{-- Colonne Droite --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                <div class="amazon-card">
                    <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 15px; color: #111;">Configuration</h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label for="highlight_tab_id" class="form-label">Onglet parent <span style="color: #c40000;">*</span></label>
                            <select name="highlight_tab_id" id="highlight_tab_id" class="form-select" required>
                                @foreach($tabs as $tab)
                                    <option value="{{ $tab->id }}" {{ old('highlight_tab_id', $highlight->highlight_tab_id) == $tab->id ? 'selected' : '' }}>{{ $tab->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="position" class="form-label">Position dans la grille <span style="color: #c40000;">*</span></label>
                            <select name="position" id="position" class="form-select" required>
                                @foreach($positions as $key => $label)
                                    <option value="{{ $key }}" {{ old('position', $highlight->position) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="background: #fcfcfc; border: 1px solid #eee; padding: 15px; border-radius: 4px;">
                            <div style="display: flex; align-items: start; gap: 10px;">
                                <input type="checkbox" name="active" id="active" value="1" {{ old('active', $highlight->active) ? 'checked' : '' }} 
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #e47911; margin-top: 2px;">
                                <label for="active" style="cursor: pointer;">
                                    <div style="font-size: 0.85rem; font-weight: 700; color: #111;">Rendre visible sur le site</div>
                                    <div style="font-size: 0.75rem; color: #555;">Désactivez pour masquer sans supprimer.</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 25px; display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 40px;">
                            Enregistrer les modifications
                        </button>
                        <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary" style="width: 100%; height: 40px;">
                            Annuler
                        </a>
                    </div>
                </div>

                <div class="amazon-card" style="padding: 20px; background: #fdfdfd; border-color: #e2e2e2;">
                    <div style="font-size: 0.85rem; color: #555;">
                        <i class="fas fa-info-circle" style="color: #0066c0; margin-right: 5px;"></i>
                        Dernière mise à jour : <br>
                        <strong style="color: #111;">{{ $highlight->updated_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-img');
            const dropzone = document.getElementById('dropzone-content');
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
            if (dropzone) dropzone.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
