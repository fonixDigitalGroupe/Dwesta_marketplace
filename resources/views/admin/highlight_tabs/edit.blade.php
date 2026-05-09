@extends('layouts.admin')

@section('title', 'Modifier l\'Onglet')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
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
        box-shadow: 0 0 3px 2px rgba(228, 121, 17, 0.5) !important;
    }

    .btn-amazon-primary {
        background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
        border: 1px solid #a88734;
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
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    
    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1 style="font-size: 1.5rem; font-weight: 500; color: #111; margin: 0;">Modifier l'Onglet</h1>
        <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.highlight-tabs.update', $highlightTab) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 25px;">
            
            {{-- Colonne Gauche --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                <div class="amazon-card">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Détails de l'onglet
                    </h2>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label for="name" class="form-label">Nom de l'onglet <span style="color: #c40000;">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $highlightTab->name) }}" class="form-input" placeholder="Ex: E-commerce, Immobilier, Services..." required>
                            <p style="font-size: 0.75rem; color: #555; margin-top: 5px;">Le nom qui apparaîtra sur la Bento Grid du site.</p>
                        </div>

                        <div>
                            <label for="slug" class="form-label">Identifiant unique (Slug) <span style="font-weight: 400; color: #565959;">— automatique si vide</span></label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $highlightTab->slug) }}" class="form-input" placeholder="ex: e-commerce">
                        </div>
                    </div>
                </div>

            </div>

            {{-- Colonne Droite --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                <div class="amazon-card">
                    <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 15px; color: #111;">Configuration</h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label for="position" class="form-label">Ordre d'affichage</label>
                            <input type="number" name="position" id="position" value="{{ old('position', $highlightTab->position) }}" min="0" class="form-input" required>
                        </div>

                        <div style="background: #fcfcfc; border: 1px solid #eee; padding: 15px; border-radius: 4px;">
                            <div style="display: flex; align-items: start; gap: 10px;">
                                <input type="checkbox" name="active" id="active" value="1" {{ old('active', $highlightTab->active) ? 'checked' : '' }} 
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #e47911; margin-top: 2px;">
                                <label for="active" style="cursor: pointer;">
                                    <div style="font-size: 0.85rem; font-weight: 700; color: #111;">Onglet actif</div>
                                    <div style="font-size: 0.75rem; color: #555;">Désactivez pour masquer tout le groupe d'actualités.</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 25px; display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 40px;">
                            Mettre à jour l'onglet
                        </button>
                        <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-secondary" style="width: 100%; height: 40px;">
                            Annuler
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection
