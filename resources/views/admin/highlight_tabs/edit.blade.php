@extends('layouts.admin')

@section('title', 'Modifier l\'onglet')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.highlight-tabs.index') }}" style="color: #666; text-decoration: none;">Gestion des Onglets</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Modifier l'onglet</span>
@endsection

@section('content')
    <div style="max-width: 1000px; margin: 0 auto;">

        <header style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Modifier l'onglet</h1>
                <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Mettez à jour les informations de la catégorie "Bento".</p>
            </div>
            <a href="{{ route('admin.highlight-tabs.index') }}" 
               style="color: #000; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 6px; transition: all 0.2s; padding: 8px 0;"
               onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
        </header>

        <form action="{{ route('admin.highlight-tabs.update', $highlightTab) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Section: Informations -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">
                            Détails de l'onglet
                        </h2>
                        
                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label for="name" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nom de l'onglet <span style="color: red;">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $highlightTab->name) }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('name') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('name') ? '#dc3545' : '#e0e0e0' }}'">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Configuration -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.25rem;">Configuration</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <div>
                                <label for="position" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Ordre d'affichage</label>
                                <input type="number" name="position" id="position" value="{{ old('position', $highlightTab->position) }}"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid {{ $errors->has('position') ? '#dc3545' : '#e0e0e0' }}; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='{{ $errors->has('position') ? '#dc3545' : '#e0e0e0' }}'">
                            </div>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <input type="checkbox" name="active" id="active" value="1" {{ old('active', $highlightTab->active) ? 'checked' : '' }} style="cursor: pointer;">
                                <label for="active" style="font-size: 0.9rem; color: #333; cursor: pointer; font-weight: 500;">Activer l'onglet</label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" 
                                style="width: 100%; padding: 12px; background: #000; color: #fff; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'" 
                                onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">
                            Enregistrer les modifications
                        </button>
                        
                        <a href="{{ route('admin.highlight-tabs.index') }}" 
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
@endsection
