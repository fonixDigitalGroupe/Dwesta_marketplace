@extends('layouts.admin')

@section('title', 'Ajouter une Actualité')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }

    /* Input Amazon Style */
    input[type="text"]:focus, input[type="number"]:focus,
    textarea:focus, select:focus {
        border-color: #e77600 !important;
        box-shadow: 0 0 3px 2px rgba(228,121,17,0.5) !important;
        outline: none;
    }

    /* Custom Checkbox Amazon Style */
    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 4px 0;
        user-select: none;
        font-size: 0.85rem;
        color: #111;
    }
    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    .checkmark {
        height: 16px;
        width: 16px;
        background-color: #fff;
        border: 1px solid #adb1b8;
        border-radius: 0;
        position: relative;
        transition: all 0.1s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) inset;
        flex-shrink: 0;
    }
    .checkbox-container:hover input ~ .checkmark {
        border-color: #e77600;
        box-shadow: 0 0 3px rgba(228,121,17,0.5);
    }
    .checkbox-container input:checked ~ .checkmark {
        background-color: #fff;
        border-color: #e77600;
    }
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 5px;
        top: 1px;
        width: 4px;
        height: 8px;
        border: solid #e77600;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .checkbox-container input:checked ~ .checkmark:after { display: block; }

    .amazon-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        padding: 25px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 500;
        color: #111;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e7e7e7;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #adb1b8;
        border-radius: 0;
        font-size: 0.85rem;
        outline: none;
        background: #fcfcfc;
        box-sizing: border-box;
    }

    .form-group { margin-bottom: 20px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-error {
        color: #bf0000;
        font-size: 0.75rem;
        margin-top: 6px;
    }

    .btn-amazon-primary {
        background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
        border: 1px solid #a88734;
        color: #111;
        padding: 8px 24px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        text-decoration: none;
        box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-amazon-primary:hover {
        background: linear-gradient(to bottom, #f5d78e, #eeb933);
        border-color: #9c7e31;
        color: #111;
        text-decoration: none;
    }

    .btn-amazon-secondary {
        background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
        border: 1px solid #adb1b8;
        color: #111;
        padding: 8px 24px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        text-decoration: none;
        box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-amazon-secondary:hover {
        background: linear-gradient(to bottom, #e7eaf0, #d8dade);
        border-color: #a2a6ac;
        color: #111;
        text-decoration: none;
    }

    /* Dropzone Amazon Style */
    .dropzone-area {
        border: 2px dashed #adb1b8;
        padding: 2.5rem;
        text-align: center;
        background: #fcfcfc;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
        position: relative;
    }
    .dropzone-area:hover {
        border-color: #e77600;
        background: #fffbf2;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    {{-- En-tête de page --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">
            Ajouter une Actualité
        </h1>
        <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i>
            Retour à la liste
        </a>
    </div>

    {{-- Erreurs globales --}}
    @if($errors->any())
        <div style="background: #fff8f8; border: 1px solid #f5c6c6; padding: 12px 16px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li style="font-size: 0.85rem; color: #bf0000;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.highlights.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start;">

            {{-- Colonne gauche : Contenu + Image --}}
            <div>
                {{-- Carte Contenu --}}
                <div class="amazon-card">
                    <h3 class="section-title">Contenu de l'Actualité</h3>

                    <div class="form-group">
                        <label for="title" class="form-label">
                            Titre principal <small style="color: red;">*</small>
                        </label>
                        <input type="text" name="title" id="title"
                               class="form-input" value="{{ old('title') }}"
                               required placeholder="Ex: Mode Homme, Été 2025...">
                        @error('title') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="subtitle" class="form-label">
                            Sous-titre
                            <span style="font-weight: 400; color: #777; font-size: 0.78rem;">&nbsp;— optionnel</span>
                        </label>
                        <input type="text" name="subtitle" id="subtitle"
                               class="form-input" value="{{ old('subtitle') }}"
                               placeholder="Ex: Nouveautés été">
                        @error('subtitle') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="link_url" class="form-label">
                            Catégorie de redirection
                        </label>
                        <select name="link_url" id="link_url" class="form-input" style="background: #fcfcfc;">
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
                                <option value="{{ $catUrl }}" {{ old('link_url') == $catUrl ? 'selected' : '' }}>
                                    {{ $category->chemin }}
                                </option>
                            @endforeach
                        </select>
                        @error('link_url') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Carte Image --}}
                <div class="amazon-card">
                    <h3 class="section-title">Image d'illustration</h3>

                    <div class="dropzone-area" onclick="document.getElementById('image-input').click()">
                        <div id="dropzone-content">
                            <i class="fas fa-cloud-upload-alt"
                               style="font-size: 2rem; color: #adb1b8; margin-bottom: 10px; display: block;"></i>
                            <p style="font-size: 0.85rem; color: #555; font-weight: 700; margin: 0;">
                                Cliquez pour sélectionner une image
                            </p>
                            <p style="font-size: 0.75rem; color: #777; margin-top: 5px;">
                                Format recommandé : 800×800 px — JPG, PNG, WebP
                            </p>
                        </div>
                        <img id="preview-img"
                             style="display: none; max-width: 100%; max-height: 180px;
                                    object-fit: contain; margin-top: 10px;">
                    </div>
                    <input type="file" id="image-input" name="image"
                           accept="image/*" style="display: none;"
                           onchange="previewImage(this)" required>
                    @error('image') <p class="form-error" style="margin-top: 8px;">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Colonne droite : Configuration --}}
            <div>
                <div class="amazon-card">
                    <h3 class="section-title">Configuration</h3>

                    <div class="form-group">
                        <label for="highlight_tab_id" class="form-label">
                            Onglet parent <small style="color: red;">*</small>
                        </label>
                        <select name="highlight_tab_id" id="highlight_tab_id"
                                class="form-input" style="background: #fcfcfc;" required>
                            @foreach($tabs as $tab)
                                <option value="{{ $tab->id }}"
                                    {{ (old('highlight_tab_id') ?? request('tab')) == $tab->id ? 'selected' : '' }}>
                                    {{ $tab->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('highlight_tab_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="position" class="form-label">
                            Position dans la grille <small style="color: red;">*</small>
                        </label>
                        <select name="position" id="position"
                                class="form-input" style="background: #fcfcfc;" required>
                            @foreach($positions as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('position') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('position') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                        <label class="checkbox-container">
                            <input type="checkbox" name="active" value="1"
                                   {{ old('active', true) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span style="font-weight: 500;">Rendre visible sur le site</span>
                        </label>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer Actions --}}
        <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 20px;">
            <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary">
                Annuler
            </a>
            <button type="submit" class="btn-amazon-primary">
                Enregistrer l'actualité
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-img');
            const dropzoneContent = document.getElementById('dropzone-content');
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (dropzoneContent) dropzoneContent.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
