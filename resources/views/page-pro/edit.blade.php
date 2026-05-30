@extends('layouts.app')

@section('title', 'Personnaliser ma Boutique - Karnou')

@push('styles')
<style>
    .pro-page-edit {
        max-width: 900px;
    }

    .gift-card-box {
        margin-bottom: 2.5rem;
    }

    .section-title {
        font-size: 0.8rem;
        font-weight: 800;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #f68b1e;
    }

    .form-box {
        background: #fff;
        border: 1px solid #efefef;
        border-radius: 10px;
        padding: 2rem;
    }

    .form-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #666;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 700;
        transition: all 0.2s;
        outline: none;
    }

    .form-control:focus {
        border-color: #004aad;
        box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.1);
    }

    .btn-buy-now {
        background: #f68b1e;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 14px 30px;
        font-weight: 800;
        font-size: 0.9rem;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-buy-now:hover {
        background: #e07a10;
        transform: translateY(-2px);
    }

    .preview-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .preview-container {
        background: #f8fafc;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
    }

    .logo-preview-wrapper {
        width: 100px;
        height: 100px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 50%;
        margin: 0 auto 1.25rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .banner-preview-wrapper {
        width: 100%;
        height: 100px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 1.25rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input-hint {
        font-size: 0.7rem;
        color: #999;
        margin-top: 6px;
        font-weight: 500;
    }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-outline:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .preview-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content pro-page-edit">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 2rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Ma Boutique Professionnelle</h1>
            <a href="{{ route('page-pro.show', $pagePro->slug) }}" target="_blank" style="color: #f68b1e; text-decoration: none; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                Voir ma page
            </a>
        </div>

        @if(session('success'))
            <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c8e6c9; font-size: 0.9rem; font-weight: 600;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #fff5f5; color: #fa5252; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #ffe3e3;">
                <ul style="margin: 0; padding-left: 1.2rem; font-size: 0.85rem; font-weight: 600;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('page-pro.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Identité de la boutique -->
            <div class="gift-card-box">
                <h2 class="section-title">Identité Visuelle</h2>
                <div class="form-box">
                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label">Nom commercial</label>
                        <input type="text" name="nom_boutique" class="form-control" value="{{ old('nom_boutique', $pagePro->nom_boutique) }}" placeholder="Ex: Ma Super Boutique">
                        <p class="input-hint">Le nom qui sera affiché en haut de votre page pro.</p>
                    </div>

                    <div class="preview-grid">
                        <div class="preview-container">
                            <label class="form-label">Logo</label>
                            <div class="logo-preview-wrapper" id="logo-preview-id">
                                @if($pagePro->logo)
                                    <img src="{{ Storage::url($pagePro->logo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-camera" style="color: #ccc; font-size: 1.5rem;"></i>
                                @endif
                            </div>
                            <input type="file" name="logo" class="form-control" style="font-size: 0.75rem;" accept="image/*" onchange="previewImg(this, 'logo-preview-id')">
                        </div>

                        <div class="preview-container">
                            <label class="form-label">Bannière</label>
                            <div class="banner-preview-wrapper" id="banner-preview-id">
                                @if($pagePro->banniere)
                                    <img src="{{ Storage::url($pagePro->banniere) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-image" style="color: #ccc; font-size: 1.5rem;"></i>
                                @endif
                            </div>
                            <input type="file" name="banniere" class="form-control" style="font-size: 0.75rem;" accept="image/*" onchange="previewImg(this, 'banner-preview-id')">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Présentation -->
            <div class="gift-card-box">
                <h2 class="section-title">Présentation</h2>
                <div class="form-box">
                    <div style="margin-bottom: 1.5rem;">
                        <label class="form-label">Description de la boutique</label>
                        <textarea name="description" rows="6" class="form-control" placeholder="Décrivez votre boutique, vos produits et votre expertise...">{{ old('description', $pagePro->description) }}</textarea>
                    </div>

                    <div>
                        <label class="form-label">Couleur du thème</label>
                        <input type="color" name="couleur_primaire" class="form-control" value="{{ $pagePro->couleur_primaire ?? '#004aad' }}" style="height: 48px; padding: 4px; cursor: pointer;">
                        <p class="input-hint">Cette couleur sera utilisée pour les boutons et les accents de votre page.</p>
                    </div>
                </div>
            </div>

            <div style="text-align: right; margin-bottom: 4rem;">
                <button type="submit" class="btn-buy-now">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </main>
</div>

<script>
    function previewImg(input, wrapperId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(wrapperId).innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
