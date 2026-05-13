@extends('layouts.admin')

@section('title', 'Ajouter une Actualité')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }

    /* Input Amazon Style */
    input[type="text"]:focus, input[type="number"]:focus,
    textarea:focus, select:focus {
        border-color: #e77600 !important;
        
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
        background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); border: 1px solid #004aad; color: #fff;
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
        background: linear-gradient(180deg, #0069d9 0%, #004494 100%);
        border-color: #003d82;
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
        padding: 1.25rem;
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
<div style="max-width: 100%; margin-top: -50px;">

    <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; padding: 25px;">
        {{-- En-tête de page --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Ajouter une Actualité</h1>
            <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary" style="gap: 8px;">
                <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
            </a>
        </div>

        {{-- Erreurs globales --}}
        @if($errors->any())
            <div style="background: #fff8f8; border: 1px solid #f5c6c6; padding: 15px; margin-bottom: 25px; border-radius: 4px;">
                <div style="color: #c40000; font-weight: 700; margin-bottom: 8px; font-size: 0.9rem;">
                    <i class="fas fa-exclamation-triangle"></i> Des erreurs sont survenues :
                </div>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li style="font-size: 0.85rem; color: #bf0000;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.highlights.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 25px; align-items: start;">

                {{-- Colonne gauche : Contenu + Image --}}
                <div style="display: flex; flex-direction: column; gap: 25px;">
                    {{-- Carte Contenu --}}
                    <div class="amazon-card">
                        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                            Contenu de l'Actualité
                        </h2>

                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="form-group">
                                <label for="title" class="form-label">
                                    Titre principal <span style="color: #c40000;">*</span>
                                </label>
                                <input type="text" name="title" id="title"
                                       class="form-input" value="{{ old('title') }}"
                                       required placeholder="Ex: Mode Homme, Été 2025...">
                                @error('title') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group">
                                <label for="link_url" class="form-label">
                                    Catégorie de redirection
                                </label>
                                <select name="link_url" id="link_url" class="form-input" style="background: #fff; height: 40px; cursor: pointer;">
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
                    </div>

                    {{-- Carte Image --}}
                    <div class="amazon-card">
                        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                            Image d'illustration
                        </h2>

                        <div class="dropzone-area" onclick="document.getElementById('image-input').click()" style="border-radius: 4px;">
                            <div id="dropzone-content">
                                <i class="fas fa-cloud-upload-alt"
                                   style="font-size: 2.5rem; color: #adb1b8; margin-bottom: 12px; display: block;"></i>
                                <p style="font-size: 0.9rem; color: #111; font-weight: 700; margin: 0;">
                                    Cliquez pour sélectionner une image
                                </p>
                                <p style="font-size: 0.8rem; color: #565959; margin-top: 5px;">
                                    Format recommandé : 800×800 px — JPG, PNG, WebP
                                </p>
                            </div>
                            <img id="preview-img"
                                 style="display: none; max-width: 100%; max-height: 160px;
                                        object-fit: contain; margin-top: 10px; border-radius: 2px;">
                        </div>
                        <input type="file" id="image-input" name="image"
                               accept="image/*" style="display: none;"
                               onchange="previewImage(this)" required>
                        @error('image') <p class="form-error" style="margin-top: 10px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Colonne droite : Configuration --}}
                <div style="display: flex; flex-direction: column; gap: 25px;">
                    <div class="amazon-card">
                        <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 15px; color: #111;">Configuration</h2>

                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="form-group">
                                <label for="highlight_tab_id" class="form-label">
                                    Onglet parent <span style="color: #c40000;">*</span>
                                </label>
                                <select name="highlight_tab_id" id="highlight_tab_id"
                                        class="form-input" style="background: #fff; height: 40px; cursor: pointer;" required>
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
                                    Position dans la grille <span style="color: #c40000;">*</span>
                                </label>
                                <select name="position" id="position"
                                        class="form-input" style="background: #fff; height: 40px; cursor: pointer;" required>
                                    @foreach($positions as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('position') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group" style="padding-top: 5px;">
                                <label class="checkbox-container" style="margin: 0; padding: 0;">
                                    <input type="checkbox" name="active" value="1"
                                           {{ old('active', true) ? 'checked' : '' }}
                                           style="width: 18px; height: 18px; cursor: pointer; accent-color: #e47911;">
                                    <span class="checkmark"></span>
                                    <div style="margin-left: 5px;">
                                        <div style="font-size: 0.85rem; font-weight: 700; color: #111;">Rendre visible sur le site</div>
                                        <div style="font-size: 0.75rem; color: #555;">La mise en avant sera affichée.</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div style="margin-top: 30px; display: flex; flex-direction: column; gap: 12px;">
                            <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 40px; font-weight: 700;">
                                Enregistrer l'actualité
                            </button>
                            <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary" style="width: 100%; height: 40px;">
                                Annuler
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>
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
