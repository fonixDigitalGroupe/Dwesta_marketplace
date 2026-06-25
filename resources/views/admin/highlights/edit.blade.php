@extends('layouts.admin')

@section('title', 'Modifier une Actualité')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        /* Input Amazon Style Modernisé */
        input[type="text"],
        input[type="number"],
        input[type="date"],
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

        /* Buttons Alignés */
        .btn-amazon-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff;
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
            color: #fff;
        }

        .btn-amazon-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
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
            color: #1e293b;
        }

        .dropzone-amazon {
            border: 1px dashed #dee2e6;
            border-radius: 6px;
            padding: 30px 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s;
        }

        .dropzone-amazon:hover {
            border-color: #ff9900;
            background: #fff;
        }

        /* Custom Checkbox */
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
            flex-shrink: 0;
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
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: -30px auto 0;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        {{-- Card Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-pen" style="font-size: 0.8rem;"></i>
                <span>Modifier l'Actualité</span>
            </div>

            <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Voir les actualités
            </a>
        </div>

        {{-- Erreurs globales --}}
        @if($errors->any())
            <div style="background: #fff5f5; border: 1px solid #fecaca; padding: 15px; margin-bottom: 20px; border-radius: 6px;">
                <div style="color: #c40000; font-weight: 700; margin-bottom: 8px; font-size: 0.85rem;">
                    <i class="fas fa-exclamation-triangle"></i> Des erreurs sont survenues :
                </div>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li style="font-size: 0.8rem; color: #bf0000;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.highlights.update', $highlight) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

                {{-- Left Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Contenu --}}
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Contenu de l'actualité</h3>

                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div>
                                <label for="title" class="field-label">Titre principal <small style="color: red;">*</small></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $highlight->title) }}" required>
                                @error('title') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="link_url" class="field-label">Catégorie de redirection</label>
                                <select name="link_url" id="link_url" style="cursor: pointer;">
                                    <option value="">-- Sélectionner une catégorie --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->url }}" {{ old('link_url', $highlight->link_url) == $category->url ? 'selected' : '' }}>
                                            {{ $category->chemin }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('link_url') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Image d'illustration</h3>
                        <div class="dropzone-amazon" onclick="document.getElementById('image-input').click()">
                            <div id="dropzone-content" style="{{ $highlight->image_path ? 'display: none;' : '' }}">
                                <i class="fas fa-image" style="font-size: 24px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                <p style="font-size: 0.75rem; color: #64748b; font-weight: 600;">Cliquez pour sélectionner une image</p>
                                <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 4px;">Recommandé : 800×800 px — JPG, PNG, WebP</p>
                            </div>
                            <img id="preview-img" src="{{ $highlight->image_url }}" style="{{ $highlight->image_path ? 'display: inline-block;' : 'display: none;' }} max-width: 100%; max-height: 160px; object-fit: contain;">
                        </div>
                        <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                        <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 8px;">Laissez vide pour conserver l'image actuelle.</p>
                        @error('image') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Right Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Configuration</h3>

                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div>
                                <label for="highlight_tab_id" class="field-label">Onglet parent <small style="color: red;">*</small></label>
                                <select name="highlight_tab_id" id="highlight_tab_id" style="cursor: pointer;" required>
                                    @foreach($tabs as $tab)
                                        <option value="{{ $tab->id }}" {{ old('highlight_tab_id', $highlight->highlight_tab_id) == $tab->id ? 'selected' : '' }}>
                                            {{ $tab->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('highlight_tab_id') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="position" class="field-label">Position dans la grille <small style="color: red;">*</small></label>
                                <select name="position" id="position" style="cursor: pointer;" required>
                                    @foreach($positions as $key => $label)
                                        <option value="{{ $key }}" {{ old('position', $highlight->position) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('position') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div style="border-top: 1px solid #f1f5f9; padding-top: 15px;">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="active" value="1" {{ old('active', $highlight->active) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Rendre visible sur le site</span>
                                </label>
                            </div>
                        </div>

                        <div style="margin-top: 25px; display: grid; grid-template-columns: 1fr; gap: 10px;">
                            <button type="submit" class="btn-amazon-primary">
                                ENREGISTRER LES MODIFICATIONS
                            </button>
                            <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary">
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
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-img');
            const dropzoneContent = document.getElementById('dropzone-content');
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
            if (dropzoneContent) dropzoneContent.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
