@extends('layouts.admin')

@section('title', isset($banner) ? 'Modifier la bannière' : 'Créer une bannière')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.banners.index') }}" style="color: #666; text-decoration: none;">Gestion des Bannières</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">{{ isset($banner) ? 'Modifier' : 'Créer' }} une bannière</span>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <header style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">
                {{ isset($banner) ? 'Modifier la bannière' : 'Nouvelle bannière publicitaire' }}
            </h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Configurez le visuel et les paramètres de redirection pour la page d'accueil.</p>
        </div>
        <a href="{{ route('admin.banners.index') }}" 
           style="color: #000; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 6px; transition: all 0.2s; padding: 8px 0;"
           onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a>
    </header>

    <form action="{{ isset($banner) ? route('admin.banners.update', $banner) : route('admin.banners.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($banner))
            @method('PUT')
        @endif

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
            <!-- Left Column -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Section 1: Informations -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Informations de la bannière</h2>
                    
                    <div style="display: grid; gap: 1.25rem;">
                        <div>
                            <label for="title" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Titre de la bannière <span style="color: red;">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $banner->title ?? '') }}" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#ff750f'">
                        </div>

                        <div>
                            <label for="link_url" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">URL de redirection</label>
                            <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $banner->link_url ?? '') }}"
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#ff750f'" placeholder="https://...">
                        </div>
                    </div>
                </div>



                <!-- Section 3: Visuel -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Visuel Publicitaire</h2>
                    
                    <div style="border: 2px dashed #e0e0e0; border-radius: 8px; padding: 2rem; text-align: center; background: #fafafa; cursor: pointer; position: relative; overflow: hidden;" onclick="document.getElementById('image-input').click()">
                        @if(isset($banner) && $banner->image_url)
                            <img id="preview-img" src="{{ $banner->image_url }}" style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div id="dropzone-text">
                                <svg width="40" height="40" fill="none" stroke="#999" viewBox="0 0 24 24" style="margin-bottom: 10px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p style="font-size: 0.9rem; color: #666;">Cliquez pour sélectionner une image</p>
                            </div>
                            <img id="preview-img" style="display: none; max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                        @endif
                    </div>
                    <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                </div>
            </div>

            <!-- Right Column -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Paramètres -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.25rem;">Paramètres d'affichage</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        <div>
                            <label for="order" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Ordre d'affichage</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $banner->order ?? 1) }}" min="1"
                                style="width: 70px; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                onfocus="this.style.borderColor='#ff750f'">
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 0.85rem; font-weight: 500; color: #666;">Visible sur le site</span>
                            <label style="position: relative; display: inline-block; width: 44px; height: 24px;">
                                <input type="checkbox" name="active" value="1" {{ old('active', $banner->active ?? true) ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ (old('active', $banner->active ?? true)) ? '#ff750f' : '#ccc' }}; transition: .4s; border-radius: 24px;">
                                    <span style="position: absolute; content: ''; height: 18px; width: 18px; left: {{ (old('active', $banner->active ?? true)) ? '22px' : '3px' }}; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%;"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Planification -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.25rem;">Planification (Optionnel)</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        <div>
                            <label for="start_date" style="display: block; font-size: 0.8rem; color: #666; margin-bottom: 5px;">Date de début</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($banner->start_date) ? $banner->start_date->format('Y-m-d') : '') }}"
                                style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;">
                        </div>
                        <div>
                            <label for="end_date" style="display: block; font-size: 0.8rem; color: #666; margin-bottom: 5px;">Date de fin</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($banner->end_date) ? $banner->end_date->format('Y-m-d') : '') }}"
                                style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="submit" 
                            style="width: 100%; padding: 12px; background: #000; color: #fff; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        {{ isset($banner) ? 'Mettre à jour' : 'Créer la bannière' }}
                    </button>
                    
                    <a href="{{ route('admin.banners.index') }}" 
                       style="width: 100%; padding: 12px; background: transparent; color: #666; border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 500; text-align: center; text-decoration: none; cursor: pointer; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#f8fafc'">
                        Annuler
                    </a>
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
            const placeholder = document.getElementById('dropzone-text');
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
            if (placeholder) placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
