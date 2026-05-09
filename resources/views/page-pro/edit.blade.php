@extends('layouts.app')

@section('title', 'Personnaliser ma Boutique - Mady Market')

@push('styles')
<style>
    :root {
        --amz-orange: #FF9900;
        --amz-orange-light: #FFB33E;
        --amz-dark: #232F3E;
        --bg-body: #f9f9f9;
        --border-main: #eeeeee;
        --text-base: #111111;
        --text-secondary: #565959;
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-base);
    }

    .dashboard-container {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
        max-width: 1400px;
        margin: 24px auto;
        padding: 0 20px;
    }

    .main-content {
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        border: 1px solid #e0e0e0;
        overflow: hidden;
        padding: 0;
    }

    .edit-pro-card {
        background: white;
        padding: 1.5rem;
        border-bottom: 1px solid #f8f8f8;
    }
    .edit-pro-card:last-child { border-bottom: none; }

    .edit-card-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 6px;
        color: #555;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #eee;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }

    .form-control:focus {
        border-color: #004aad;
        box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.1);
        outline: none;
    }

    .btn-save {
        background: #004aad;
        border: none;
        border-radius: 8px;
        color: white;
        padding: 12px 30px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background 0.2s;
    }

    .btn-save:hover {
        background: #003a85;
    }

    .preview-section {
        background: #F0F2F2;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid var(--border-main);
        position: relative;
    }

    .logo-preview-box {
        width: 130px;
        height: 130px;
        background: white;
        border: 1px solid var(--border-main);
        border-radius: 50%;
        margin: 0 auto 15px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .banner-preview-box {
        width: 100%;
        height: 130px;
        background: white;
        border: 1px solid var(--border-main);
        border-radius: 4px;
        margin-bottom: 15px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .format-badge {
        font-size: 0.7rem;
        color: var(--text-secondary);
        font-weight: 400;
        margin-bottom: 8px;
        display: block;
    }

    .input-hint {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 4px;
    }

    .social-input-group {
        display: flex;
        align-items: center;
        background: white;
        border: 1px solid #888C8C;
        border-radius: 4px;
        padding-left: 12px;
    }

    .social-input-group:focus-within {
        border-color: #007185;
        box-shadow: 0 0 0 3px #c8f3fa;
    }

    .social-input-group i {
        color: var(--text-secondary);
    }

    .social-input-group .form-control {
        border: none;
        box-shadow: none !important;
    }

    .section-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
    }
</style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            @if(session('success'))
                <div style="background: #e6fcf5; color: #0ca678; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c3fae8; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fff5f5; color: #fa5252; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #ffe3e3; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #fff5f5; color: #fa5252; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #ffe3e3;">
                    <ul style="margin: 0; padding-left: 1.2rem; font-size: 0.9rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f0f0f0; padding: 1.5rem 2rem; background: #fff;">
                <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.25rem; font-weight: 700; color: #1a1a1a; margin: 0;">Personnalisation de la Boutique</h1>
                <a href="{{ route('page-pro.show', $pagePro->slug) }}" target="_blank" class="btn-save" style="background: #f1f5f9; color: #64748b; border: none; padding: 0.6rem 1.2rem; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; border-radius: 20px;">
                    <i class="fas fa-eye" style="color: #004aad;"></i>
                    Aperçu Public
                </a>
            </div>

            <form action="{{ route('page-pro.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Identité Visuelle -->
                <div class="edit-pro-card">
                    <div class="edit-card-title">
                        <i class="fas fa-store" style="color: #FF9900;"></i>
                        Fiche d'Identité de la Boutique
                    </div>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="form-label">Nom commercial</label>
                        <input type="text" name="nom_boutique" class="form-control" value="{{ old('nom_boutique', $pagePro->nom_boutique) }}" placeholder="Nom tel qu'il apparaîtra sur le site">
                        <p class="input-hint">Utilisez un nom professionnel clair pour attirer les clients.</p>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div>
                            <label class="form-label">Logo de la marque</label>
                            <div class="preview-section">
                                <div class="format-badge">Image carrée (ex: 500x500px)</div>
                                <div class="logo-preview-box" id="logo-preview-wrapper">
                                    @if($pagePro->logo)
                                        <img src="{{ Storage::url($pagePro->logo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-camera fa-2x" style="color: #ccc;"></i>
                                    @endif
                                </div>
                                <input type="file" name="logo" class="form-control" accept="image/*" onchange="handleImagePreview(this, 'logo-preview-wrapper')">
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Bannière principale</label>
                            <div class="preview-section">
                                <div class="format-badge">Haute résolution (ex: 1500x400px)</div>
                                <div class="banner-preview-box" id="banner-preview-wrapper">
                                    @if($pagePro->banniere)
                                        <img src="{{ Storage::url($pagePro->banniere) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-image fa-2x" style="color: #ccc;"></i>
                                    @endif
                                </div>
                                <input type="file" name="banniere" class="form-control" accept="image/*" onchange="handleImagePreview(this, 'banner-preview-wrapper')">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 24px;">
                        <label class="form-label">Couleur de thème</label>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <input type="color" name="couleur_primaire" value="{{ $pagePro->couleur_primaire ?? '#004aad' }}" style="padding: 0; width: 60px; height: 35px; border: 1px solid #ddd; cursor: pointer;">
                            <span class="input-hint">Affecte les boutons et les titres de votre boutique.</span>
                        </div>
                    </div>
                </div>

                <!-- Présentation -->
                <div class="edit-pro-card">
                    <div class="edit-card-title">
                        <i class="fas fa-info-circle" style="color: #FF9900;"></i>
                        Présentation de votre activité
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description détaillée</label>
                        <textarea name="description" rows="8" class="form-control" placeholder="Racontez votre histoire et présentez vos produits...">{{ old('description', $pagePro->description) }}</textarea>
                    </div>
                </div>


                <div style="display: flex; justify-content: flex-end; padding: 20px 0;">
                    <button type="submit" class="btn-save">
                        Enregistrer ces informations
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        function handleImagePreview(input, wrapperId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.getElementById(wrapperId);
                    wrapper.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
