@extends('layouts.admin')

@section('title', 'Ajouter une catégorie')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <a href="{{ route('admin.categories.l1') }}">Catalogue</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <span style="color: var(--mady-red); font-weight: 700;">Nouveau</span>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    
    <header style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.02em; margin-bottom: 0.25rem;">Ajouter une catégorie</h1>
        <p style="font-size: 0.875rem; color: var(--slate-500); font-weight: 500;">Configurez les paramètres d'un nouvel élément de votre catalogue.</p>
    </header>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
            
            <!-- Left Colonne: Form Fields -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section 1: Identité -->
                <div class="card-pro" style="padding: 2rem;">
                    <h2 style="font-size: 1rem; font-weight: 800; color: var(--slate-900); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                        <span style="color: var(--mady-red);">01.</span> Identité Commerciale
                    </h2>
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <div>
                            <label for="nom" style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Nom de la catégorie <span style="color: var(--mady-red);">*</span></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required 
                                   style="width: 100%; padding: 12px 16px; border: 1px solid var(--slate-200); border-radius: 10px; font-size: 0.9375rem; color: var(--slate-900); outline: none; transition: all 0.2s;" 
                                   onfocus="this.style.borderColor='var(--mady-red)'; this.style.boxShadow='0 0 0 4px var(--mady-light-red)'" 
                                   onblur="this.style.borderColor='var(--slate-200)'; this.style.boxShadow='none'">
                            @error('nom') <p style="color: var(--mady-red); font-size: 0.75rem; margin-top: 6px; font-weight: 600;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Description (SEO & Info)</label>
                            <textarea name="description" id="description" rows="4" 
                                      style="width: 100%; padding: 12px 16px; border: 1px solid var(--slate-200); border-radius: 10px; font-size: 0.9375rem; color: var(--slate-900); outline: none; transition: all 0.2s; resize: vertical;" 
                                      onfocus="this.style.borderColor='var(--mady-red)'; this.style.boxShadow='0 0 0 4px var(--mady-light-red)'" 
                                      onblur="this.style.borderColor='var(--slate-200)'; this.style.boxShadow='none'">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Structure -->
                <div class="card-pro" style="padding: 2rem;">
                    <h2 style="font-size: 1rem; font-weight: 800; color: var(--slate-900); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                        <span style="color: var(--mady-red);">02.</span> Architecture
                    </h2>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div>
                            <label for="parent_id" style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Catégorie Parente</label>
                            <select name="parent_id" id="parent_id" 
                                    style="width: 100%; padding: 12px 16px; border: 1px solid var(--slate-200); border-radius: 10px; font-size: 0.9375rem; color: var(--slate-900); outline: none; background: #fff; cursor: pointer;">
                                <option value="">-- Racine (Niveau 1) --</option>
                                @foreach($categoriesTree as $treeItem)
                                    <option value="{{ $treeItem->id }}" {{ old('parent_id') == $treeItem->id ? 'selected' : '' }}>{{ $treeItem->nom }}</option>
                                    @foreach($treeItem->enfants as $child)
                                        <option value="{{ $child->id }}" {{ old('parent_id') == $child->id ? 'selected' : '' }}>&nbsp;&nbsp;↳ {{ $child->nom }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="ordre" style="display: block; font-size: 0.8125rem; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Ordre d'affichage</label>
                            <input type="number" name="ordre" id="ordre" value="{{ old('ordre', 0) }}" 
                                   style="width: 100%; padding: 12px 16px; border: 1px solid var(--slate-200); border-radius: 10px; font-size: 0.9375rem; color: var(--slate-900); outline: none;">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Colonne: Sidebar -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <div class="card-pro" style="padding: 1.5rem;">
                    <h3 style="font-size: 0.875rem; font-weight: 800; color: var(--slate-900); margin-bottom: 1.25rem;">Visuel & État</h3>
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <div>
                            <label for="icone" style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--slate-500); text-transform: uppercase; margin-bottom: 8px;">Icône (Emoji/SVG)</label>
                            <input type="text" name="icone" id="icone" value="{{ old('icone', '📁') }}" 
                                   style="width: 100%; padding: 12px; border: 1px solid var(--slate-200); border-radius: 10px; font-size: 1.25rem; text-align: center;">
                        </div>

                        <div style="padding-top: 1rem; border-top: 1px solid var(--slate-100);">
                            <div style="display: flex; align-items: center; gap: 12px; cursor: pointer;" onclick="document.getElementById('actif').click()">
                                <input type="checkbox" name="actif" id="actif" value="1" {{ old('actif', true) ? 'checked' : '' }} 
                                       style="width: 18px; height: 18px; accent-color: var(--mady-red); cursor: pointer;">
                                <span style="font-size: 0.875rem; font-weight: 700; color: var(--slate-900);">Catégorie Active</span>
                            </div>
                            <p style="font-size: 0.75rem; color: var(--slate-500); margin-top: 6px; margin-left: 30px;">Définit si la catégorie est visible par les clients.</p>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="submit" class="btn-pro-primary" style="justify-content: center; padding: 14px;">
                        Créer la catégorie
                    </button>
                    <a href="{{ route('admin.categories.l1') }}" style="display: flex; justify-content: center; padding: 14px; background: #fff; border: 1px solid var(--slate-200); border-radius: 10px; color: var(--slate-500); text-decoration: none; font-weight: 700; font-size: 0.9rem; transition: all 0.2s;" onmouseover="this.style.background='var(--slate-50)'; this.style.color='var(--slate-900)'" onmouseout="this.style.background='#fff'; this.style.color='var(--slate-500)'">
                        Annuler
                    </a>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection
