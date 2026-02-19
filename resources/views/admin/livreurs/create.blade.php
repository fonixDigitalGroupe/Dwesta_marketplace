@extends('layouts.admin')

@section('title', 'Nouveau Livreur')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.livreurs.index') }}" style="color: #666; text-decoration: none;">Livreurs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Ajouter</span>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">

    <header style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Nouveau Livreur</h1>
        <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Enregistrez un livreur de proximité dans le système.</p>
    </header>

    <form action="{{ route('admin.livreurs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
            
            <!-- Colonne Gauche -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section 1: Utilisateur -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Associer à un Utilisateur</h2>
                    
                    <div>
                        <label for="user_id" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Sélectionner le livreur <span style="color: red;">*</span></label>
                        <select name="user_id" id="user_id" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; background: white;"
                                onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                            <option value="">Sélectionner un utilisateur</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->prenom }} {{ $user->nom }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p style="color: #ef4444; font-size: 0.75rem; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Section 2: Informations Véhicule -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Informations Véhicule</h2>
                    
                    <div style="display: grid; gap: 1.25rem;">
                        <div>
                            <label for="type_vehicule" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Type de véhicule <span style="color: red;">*</span></label>
                            <select name="type_vehicule" id="type_vehicule" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; background: white;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                <option value="">Sélectionner un type</option>
                                <option value="Moto" {{ old('type_vehicule') == 'Moto' ? 'selected' : '' }}>Moto</option>
                                <option value="Voiture" {{ old('type_vehicule') == 'Voiture' ? 'selected' : '' }}>Voiture</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section 3: Pièce d'identité -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1rem;">Pièce d'identité</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div>
                            <label for="type_document" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">Type de document <span style="color: red;">*</span></label>
                            <select name="type_document" id="type_document" required
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;"
                                    onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                                <option value="CNI" {{ old('type_document') == 'CNI' ? 'selected' : '' }}>CNI</option>
                                <option value="Passport" {{ old('type_document') == 'Passport' ? 'selected' : '' }}>Passport</option>
                                <option value="Titre de séjour" {{ old('type_document') == 'Titre de séjour' ? 'selected' : '' }}>Titre de séjour</option>
                            </select>
                        </div>
                        <div>
                            <label for="numero_document" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">N° du document</label>
                            <input type="text" name="numero_document" id="numero_document" value="{{ old('numero_document') }}"
                                   style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;"
                                   onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>
                        <div>
                            <label for="document_recto" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">Document (Recto)</label>
                            <input type="file" name="document_recto" id="document_recto" accept="image/*,application/pdf"
                                   style="width: 100%; padding: 6px 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.85rem; color: #333; outline: none;">
                        </div>
                        <div>
                            <label for="document_verso" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">Document (Verso)</label>
                            <input type="file" name="document_verso" id="document_verso" accept="image/*,application/pdf"
                                   style="width: 100%; padding: 6px 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.85rem; color: #333; outline: none;">
                        </div>
                    </div>
                </div>

                <!-- Section 4: État -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <label for="actif" style="display: flex; align-items: center; gap: 12px; cursor: pointer; user-select: none;">
                        <input type="checkbox" name="actif" id="actif" value="1" {{ old('actif', true) ? 'checked' : '' }}>
                        <span style="font-size: 0.9rem; font-weight: 550; color: #333;">Livreur Actif</span>
                    </label>
                </div>

                <!-- Boutons d'action -->
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="submit" style="background: #000; color: #fff; border: none; padding: 0.85rem; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                        Enregistrer
                    </button>
                    <a href="{{ route('admin.livreurs.index') }}" style="display: flex; justify-content: center; padding: 0.85rem; background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
