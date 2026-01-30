@extends('layouts.app')

@section('title', 'Modifier ma Page Pro')

@section('content')
@extends('layouts.app')

@section('title', 'Personnaliser ma Boutique - Mady Market')

@push('styles')
<style>
    /* Ensure dashboard layout styles are available or scoped here if not global */
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto 2rem;
        padding: 0.5rem 2rem 2rem 7rem;
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 2.5rem;
    }

    @media (max-width: 1024px) {
        .dashboard-container {
            grid-template-columns: 1fr;
            padding-left: 2rem;
        }
    }

    .edit-pro-container {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 2rem;
    }

    .edit-section-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
        color: #333;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #444;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #bf0000;
        outline: none;
    }

    .btn-save {
        background: #bf0000;
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 4px;
        font-weight: 700;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.2s;
    }

    .btn-save:hover {
        background: #990000;
    }

    .preview-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #ddd;
        margin-bottom: 10px;
    }
    
    .preview-banner {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('profile.show') }}">Mon Compte</a> > <span>Ma Boutique</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 style="font-size: 1.8rem; font-weight: 700; margin: 0;">Personnaliser ma Boutique</h1>
                <a href="{{ route('page-pro.show', $pagePro->slug) }}" target="_blank" style="color: #bf0000; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 5px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Voir ma boutique en ligne
                </a>
            </div>

            <div class="edit-pro-container">
                <form action="{{ route('page-pro.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="edit-section-title">Identité Visuelle</div>
                    
                    <div class="row" style="display: flex; flex-wrap: wrap; gap: 2rem;">
                        <div style="flex: 1; min-width: 250px;">
                            <div class="form-group">
                                <label class="form-label">Logo de la boutique</label>
                                @if($pagePro->logo)
                                    <img src="{{ Storage::url($pagePro->logo) }}" class="preview-image">
                                @endif
                                <input type="file" name="logo" class="form-control" accept="image/*">
                                <small style="color: #666;">Format carré recommandé (JPG, PNG)</small>
                            </div>
                        </div>

                        <div style="flex: 2; min-width: 300px;">
                            <div class="form-group">
                                <label class="form-label">Bannière d'en-tête</label>
                                @if($pagePro->banniere)
                                    <img src="{{ Storage::url($pagePro->banniere) }}" class="preview-banner">
                                @endif
                                <input type="file" name="banniere" class="form-control" accept="image/*">
                                <small style="color: #666;">Image large recommandée (1200x300px)</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="max-width: 200px;">
                        <label class="form-label">Couleur Principale</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="color" name="couleur_primaire" value="{{ $pagePro->couleur_primaire ?? '#3b82f6' }}" style="height: 40px; width: 60px; border: 1px solid #ccc; padding: 2px;">
                            <span style="font-size: 0.9rem; color: #666;">Votre couleur de marque</span>
                        </div>
                    </div>

                    <div class="edit-section-title" style="margin-top: 2rem;">Informations & Contact</div>

                    <div class="form-group">
                        <label class="form-label">Description de la boutique</label>
                        <textarea name="description" rows="5" class="form-control" placeholder="Présentez votre activité, vos produits, votre histoire...">{{ old('description', $pagePro->description) }}</textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label class="form-label">Email Contact (Public)</label>
                            <input type="email" name="email_contact" value="{{ old('email_contact', $pagePro->email_contact) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Téléphone (Public)</label>
                            <input type="text" name="telephone_contact" value="{{ old('telephone_contact', $pagePro->telephone_contact) }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Site Web (Optionnel)</label>
                            <input type="url" name="site_web" value="{{ old('site_web', $pagePro->site_web) }}" class="form-control" placeholder="https://...">
                        </div>
                    </div>

                    <div class="edit-section-title" style="margin-top: 2rem;">Réseaux Sociaux</div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label class="form-label">Facebook</label>
                            <input type="url" name="facebook" value="{{ $pagePro->reseaux_sociaux['facebook'] ?? '' }}" class="form-control" placeholder="Lien profil Facebook">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Instagram</label>
                            <input type="url" name="instagram" value="{{ $pagePro->reseaux_sociaux['instagram'] ?? '' }}" class="form-control" placeholder="Lien profil Instagram">
                        </div>
                    </div>

                    <div style="margin-top: 2rem; text-align: right;">
                        <button type="submit" class="btn-save">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
@endsection
