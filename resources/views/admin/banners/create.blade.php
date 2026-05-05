@extends('layouts.admin')

@section('title', 'Nouvelle Bannière')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    input:focus, textarea:focus, select:focus {
        border-color: #e67e00 !important;
        box-shadow: 0 0 0 2px rgba(230,126,0,0.05) !important;
        outline: none;
    }
</style>
@endpush

@section('content')
<div style="max-width: 100%;">
    <!-- Main Conteneur -->
    <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
        
        <div style="margin-bottom: 0.5rem;">
            <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Nouvelle Bannière</h1>
        </div>
        <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1rem;"></div>

        <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 1rem;">
            <a href="{{ route('admin.banners.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#e67e00'" onmouseout="this.style.borderColor='#ddd'">
                Retour à la liste <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
        </div>

        <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
                
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Informations de la bannière
                        </h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div>
                                    <label for="famille" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Famille de la page</label>
                                    <select name="famille" id="famille" 
                                        style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff;">
                                        <option value="">-- Bannière Globale --</option>
                                        @foreach($familles as $famille)
                                            <option value="{{ $famille }}" {{ old('famille') == $famille ? 'selected' : '' }}>{{ $famille }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="category_id" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Catégorie (optionnel)</label>
                                    <select name="category_id" id="category_id" 
                                        style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff;">
                                        <option value="">-- Toutes les catégories --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="title" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Titre de la bannière <small style="color: red;">*</small></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>

                            <div>
                                <label for="link_url" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">URL de redirection (Catégorie)</label>
                                <select name="link_url" id="link_url"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                    <option value="">-- Sélectionner une catégorie --</option>
                                    @foreach($categories as $category)
                                        @php
                                            $ancetres = $category->ancetres ?? [];
                                            $catUrl = '';
                                            if (count($ancetres) > 0) {
                                                $racine = $ancetres[0];
                                                $params = ['slug' => $racine->slug];
                                                if (count($ancetres) === 1) {
                                                    // N2
                                                    $params['active'] = $category->id;
                                                } else {
                                                    // N3
                                                    $params['active'] = $ancetres[1]->id;
                                                    $params['n3'] = $category->id;
                                                }
                                                $catUrl = route('categories.show', $params, false);
                                            } else {
                                                // N1 (Root)
                                                $catUrl = route('categories.show', $category->slug, false);
                                            }
                                        @endphp
                                        <option value="{{ $catUrl }}" {{ old('link_url') == $catUrl ? 'selected' : '' }}>
                                            {{ $category->chemin ?? $category->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Visuel Publicitaire
                        </h3>
                        
                        <div style="border: 2px dashed #e2e8f0; border-radius: 8px; padding: 2.5rem; text-align: center; background: #f8fafc; cursor: pointer; position: relative; transition: all 0.2s;" 
                             onclick="document.getElementById('image-input').click()"
                             onmouseover="this.style.borderColor='#e67e00'; this.style.background='#fff7ed'"
                             onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'">
                            
                            <div id="dropzone-content">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: #94a3b8; margin-bottom: 1rem;"></i>
                                <p style="font-size: 0.9rem; color: #64748b; font-weight: 500; margin: 0;">Cliquez pour sélectionner une image</p>
                            </div>
                            <img id="preview-img" style="display: none; max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 4px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        </div>
                        <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)" required>
                    </div>


                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                        <h3 style="font-size: 0.9rem; color: #333; font-weight: 600; margin-bottom: 1.25rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">Configuration</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <div>
                                <label for="order" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Ordre d'affichage</label>
                                <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>

                            <div>
                                <label for="start_date" style="display: block; font-size: 0.8rem; font-weight: 600; color: #555; margin-bottom: 6px;">Date de début</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333;">
                            </div>
                            <div>
                                <label for="end_date" style="display: block; font-size: 0.8rem; font-weight: 600; color: #555; margin-bottom: 6px;">Date de fin</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333;">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                            <a href="{{ route('admin.banners.index') }}" style="flex: 1; display: flex; justify-content: center; padding: 12px; background: #dc2626; border: none; border-radius: 6px; color: #fff; text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                Annuler
                            </a>
                            <button type="submit" style="flex: 1; background-color: #e67e00; color: #fff; border: none; padding: 12px; border-radius: 6px; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
