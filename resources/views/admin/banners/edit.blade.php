@extends('layouts.admin')

@section('title', 'Modifier la Bannière')

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

    .is-invalid {
        border-color: #c40000 !important;
        background-color: #fff8f8 !important;
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
        <h1 style="font-size: 1.5rem; font-weight: 500; color: #111; margin: 0;">Modifier la Bannière #{{ $banner->id }}</h1>
        <a href="{{ route('admin.banners.index') }}" class="btn-amazon-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 25px;">
            
            {{-- Colonne Gauche : Contenu --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                {{-- Carte Informations --}}
                <div class="amazon-card">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Modification des informations
                    </h2>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                            <div>
                                <label for="category_id_n1" class="form-label">Catégorie Niveau 1</label>
                                <select name="category_id_n1" id="category_id_n1" class="form-select @error('category_id_n1') is-invalid @enderror" onchange="filterN2Categories()">
                                    <option value="">-- Sélectionner N1 --</option>
                                    @foreach($n1Categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id_n1', $banner->category_id_n1) == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                                    @endforeach
                                </select>
                                @error('category_id_n1') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="category_id_n2" class="form-label">Catégorie Niveau 2</label>
                                <select name="category_id_n2" id="category_id_n2" class="form-select @error('category_id_n2') is-invalid @enderror" onchange="filterN3Categories()">
                                    <option value="">-- Sélectionner N2 --</option>
                                    @foreach($allCategories->where('parent_id', old('category_id_n1', $banner->category_id_n1)) as $cat2)
                                        <option value="{{ $cat2->id }}" {{ old('category_id_n2', $banner->category_id_n2) == $cat2->id ? 'selected' : '' }}>{{ $cat2->nom }}</option>
                                    @endforeach
                                </select>
                                @error('category_id_n2') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="category_id" class="form-label">Catégorie cible (N3)</label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">-- Sélectionner N3 --</option>
                                    @foreach($allCategories->where('parent_id', old('category_id_n2', $banner->category_id_n2)) as $cat3)
                                        <option value="{{ $cat3->id }}" {{ old('category_id', $banner->category_id) == $cat3->id ? 'selected' : '' }}>{{ $cat3->nom }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="title" class="form-label">Titre commercial <span style="color: #c40000;">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $banner->title) }}" class="form-input @error('title') is-invalid @enderror" required>
                            @error('title') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
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
                            <img id="preview-img" src="{{ $banner->image_url }}" style="max-width: 100%; max-height: 150px; object-fit: contain; border-radius: 2px;">
                            
                            <div style="margin-top: 10px; color: #565959; font-size: 0.8rem;">
                                <i class="fas fa-sync" style="margin-right: 5px;"></i> Changer l'image
                            </div>
                        </div>
                        <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview-img')">
                        @error('image') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                    </div>

                    <div class="amazon-card">
                        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                            Image de la page (Landing)
                        </h2>

                        <div class="dropzone-amazon" onclick="document.getElementById('landing-image-input').click()">
                            @if($banner->landing_page_image)
                                <img id="preview-landing-img" src="{{ $banner->landing_page_image }}" style="max-width: 100%; max-height: 150px; object-fit: contain; border-radius: 2px;">
                            @else
                                <div id="landing-dropzone-content">
                                    <i class="fas fa-desktop" style="font-size: 32px; color: #bbb; margin-bottom: 15px;"></i>
                                    <p style="font-size: 0.85rem; color: #111; font-weight: 700;">Ajouter une image de page</p>
                                </div>
                                <img id="preview-landing-img" style="display: none; max-width: 100%; max-height: 150px; object-fit: contain; border-radius: 2px;">
                            @endif
                            <div style="margin-top: 10px; color: #565959; font-size: 0.8rem;">
                                <i class="fas fa-sync" style="margin-right: 5px;"></i> {{ $banner->landing_page_image ? 'Changer' : 'Choisir' }} l'image
                            </div>
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
                            <input type="number" name="order" id="order" value="{{ old('order', $banner->order) }}" min="0" class="form-input" required>
                        </div>

                        <div style="border-top: 1px solid #eee; padding-top: 15px;">
                            <label for="start_date" class="form-label">Date de début</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $banner->start_date ? $banner->start_date->format('Y-m-d') : '') }}" class="form-input">
                        </div>

                        <div>
                            <label for="end_date" class="form-label">Date de fin</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $banner->end_date ? $banner->end_date->format('Y-m-d') : '') }}" class="form-input">
                        </div>

                        <div style="background: #fcfcfc; border: 1px solid #eee; padding: 15px; border-radius: 4px;">
                            <div style="display: flex; align-items: start; gap: 10px;">
                                <input type="checkbox" name="active" id="active" value="1" {{ old('active', $banner->active) ? 'checked' : '' }} 
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #e47911; margin-top: 2px;">
                                <label for="active" style="cursor: pointer;">
                                    <div style="font-size: 0.85rem; font-weight: 700; color: #111;">Bannière active</div>
                                    <div style="font-size: 0.75rem; color: #555;">La bannière est affichée publiquement.</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 25px; display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 40px;">
                            Mettre à jour la bannière
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn-amazon-secondary" style="width: 100%; height: 40px;">
                            Annuler
                        </a>
                    </div>
                </div>

                <div class="amazon-card" style="padding: 20px; background: #fdfdfd; border-color: #e2e2e2;">
                    <div style="font-size: 0.85rem; color: #555;">
                        <i class="fas fa-info-circle" style="color: #0066c0; margin-right: 5px;"></i>
                        Dernière modification le : <br>
                        <strong style="color: #111;">{{ $banner->updated_at->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>

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

const allCategories = @json($allCategories);

function filterN2Categories() {
    const n1Id = document.getElementById('category_id_n1').value;
    const n2Select = document.getElementById('category_id_n2');
    const n3Select = document.getElementById('category_id');
    
    n2Select.innerHTML = '<option value="">-- Sélectionner N2 --</option>';
    n3Select.innerHTML = '<option value="">-- Sélectionner N3 --</option>';
    
    if (n1Id) {
        const filtered = allCategories.filter(c => c.parent_id == n1Id);
        filtered.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.nom;
            n2Select.appendChild(opt);
        });
    }
}

function filterN3Categories() {
    const n2Id = document.getElementById('category_id_n2').value;
    const n3Select = document.getElementById('category_id');
    
    n3Select.innerHTML = '<option value="">-- Sélectionner N3 --</option>';
    
    if (n2Id) {
        const filtered = allCategories.filter(c => c.parent_id == n2Id);
        filtered.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.nom;
            n3Select.appendChild(opt);
        });
    }
}
</script>
@endsection
