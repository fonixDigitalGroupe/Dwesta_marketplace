@extends('layouts.admin')

@section('title', 'Nouvel Onglet - Actualités')

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
            <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Nouvel Onglet "Bento Grid"</h1>
        </div>
        <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1rem;"></div>

        <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 1rem;">
            <a href="{{ route('admin.highlight-tabs.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#e67e00'" onmouseout="this.style.borderColor='#ddd'">
                Retour à la liste <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
        </div>

        <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

        <form action="{{ route('admin.highlight-tabs.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
                
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Détails de l'onglet
                        </h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <div>
                                <label for="name" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Nom de l'onglet <small style="color: red;">*</small></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    placeholder="Ex: Mode, High-Tech, Immoblier..."
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                        <h3 style="font-size: 0.9rem; color: #333; font-weight: 600; margin-bottom: 1.25rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">Configuration</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                            <div>
                                <label for="position" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Ordre d'affichage</label>
                                <input type="number" name="position" id="position" value="{{ old('position', 0) }}" min="0" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                            <a href="{{ route('admin.highlight-tabs.index') }}" style="flex: 1; display: flex; justify-content: center; padding: 12px; background: #dc2626; border: none; border-radius: 6px; color: #fff; text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
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
@endsection
