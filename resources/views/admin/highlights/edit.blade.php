@extends('layouts.admin')

@section('title', 'Modifier l\'actualité')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.highlights.index') }}" style="color: #666; text-decoration: none;">Gestion des Actualités</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Modifier l'élément</span>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <header style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Modifier l'élément</h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Mettre à jour les informations pour cette position dans la grille.</p>
        </div>
        <a href="{{ route('admin.highlights.index') }}" 
           style="color: #000; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 6px; transition: all 0.2s; padding: 8px 0;"
           onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a>
    </header>

    <form action="{{ route('admin.highlights.update', $highlight) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
            
            <!-- Left Column -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section: Contenu -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Informations de l'actualité</h2>
                    
                    <div style="display: grid; gap: 1.25rem;">
                        <div>
                            <label for="title" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Titre principal <span style="color: red;">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $highlight->title) }}" required placeholder="Ex: Smartphones & Tablettes"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('title') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                   onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('title') ? '#dc3545' : '#e0e0e0' }}'">
                        </div>
                        
                        <div>
                            <label for="subtitle" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Sous-titre (Facultatif)</label>
                            <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $highlight->subtitle) }}" placeholder="Ex: Nouveautés et petits prix"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('subtitle') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                   onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('subtitle') ? '#dc3545' : '#e0e0e0' }}'">
                        </div>
                        
                        <div>
                            <label for="link_url" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Lien URL (Facultatif)</label>
                            <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $highlight->link_url) }}" placeholder="https://..."
                                   style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('link_url') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                   onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('link_url') ? '#dc3545' : '#e0e0e0' }}'">
                        </div>
                    </div>
                </div>

                <!-- Section: Image -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Visuel</h2>
                    
                    <div style="border: 2px dashed {{ $errors->has('image') ? '#dc3545' : '#e0e0e0' }}; border-radius: 8px; padding: 2rem; text-align: center; background: #fafafa; cursor: pointer; transition: all 0.2s;" 
                         onclick="document.getElementById('image-input').click()"
                         onmouseover="this.style.borderColor='#ff750f'; this.style.backgroundColor='#fff'"
                         onmouseout="this.style.borderColor='{{ $errors->has('image') ? '#dc3545' : '#e0e0e0' }}'; this.style.backgroundColor='#fafafa'">
                        
                        <div id="dropzone-text" style="{{ $highlight->image_path ? 'display: none;' : '' }}">
                            <svg width="40" height="40" fill="none" stroke="#999" viewBox="0 0 24 24" style="margin-bottom: 10px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p style="font-size: 0.9rem; color: #666; font-weight: 500;">Cliquez pour changer l'image</p>
                        </div>
                        <img id="preview-img" src="{{ $highlight->image_url }}" style="{{ $highlight->image_path ? 'display: block;' : 'display: none;' }} max-width: 100%; max-height: 250px; margin: 0 auto; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    </div>
                    <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                    @error('image')
                        <p style="color: #dc3545; font-size: 0.8rem; margin-top: 8px;">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Right Column -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section: Emplacement -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.25rem;">Emplacement</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                        <div>
                            <label for="highlight_tab_id" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Catégorie (Onglet)</label>
                            <select name="highlight_tab_id" id="highlight_tab_id" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#ff750f'">
                                @foreach($tabs as $tab)
                                    <option value="{{ $tab->id }}" {{ old('highlight_tab_id', $highlight->highlight_tab_id) == $tab->id ? 'selected' : '' }}>{{ $tab->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="position" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Position dans la grille</label>
                            <select name="position" id="position" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#ff750f'">
                                @foreach($positions as $key => $label)
                                    <option value="{{ $key }}" {{ old('position', $highlight->position) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section: Actions -->
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="submit" 
                            style="width: 100%; padding: 12px; background: #000; color: #fff; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'" 
                            onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                        Mettre à jour l'élément
                    </button>
                    
                    <a href="{{ route('admin.highlights.index') }}" 
                       style="width: 100%; padding: 12px; background: transparent; color: #666; border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 500; text-align: center; text-decoration: none; cursor: pointer; transition: all 0.2s;"
                       onmouseover="this.style.backgroundColor='#f8fafc'; this.style.borderColor='#cbd5e1'; this.style.color='#333'" 
                       onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='#e0e0e0'; this.style.color='#666'">
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
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
