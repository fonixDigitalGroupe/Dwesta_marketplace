@extends('layouts.app')

@section('title', 'Éditer ma Page Pro')

@section('content')
<div style="max-width: 900px; margin: 3rem auto; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <a href="{{ route('dashboard') }}" style="display: inline-block; color: #EF3B2D; text-decoration: none; font-weight: 500;">
                    ← Retour au dashboard
                </a>
                <a href="{{ route('vendeur.show') }}" style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                    Mon compte vendeur
                </a>
                <a href="{{ route('abonnements.index') }}" style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                    Mes abonnements
                </a>
            </div>
            <h1 style="color: #333; margin-top: 0;">Éditer ma Page Pro</h1>
        </div>

        <div style="background: #e3f2fd; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
            <strong>URL de votre page pro :</strong> 
            <a href="{{ $pagePro->url }}" target="_blank" style="color: #EF3B2D; text-decoration: none; margin-left: 0.5rem;">
                {{ $pagePro->url }}
            </a>
        </div>

        <form method="POST" action="{{ route('page-pro.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem;">Logo</h2>
                @if($pagePro->logo)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $pagePro->logo) }}" alt="Logo" style="max-width: 200px; max-height: 200px; border-radius: 4px;">
                    </div>
                @endif
                <input type="file" name="logo" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                <small style="color: #666;">Format : JPG, PNG. Taille maximale : 2 Mo</small>
                @error('logo')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem;">Bannière</h2>
                @if($pagePro->banniere)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $pagePro->banniere) }}" alt="Bannière" style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 4px;">
                    </div>
                @endif
                <input type="file" name="banniere" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                <small style="color: #666;">Format : JPG, PNG. Taille maximale : 5 Mo</small>
                @error('banniere')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Description</label>
                <textarea name="description" rows="6" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">{{ old('description', $pagePro->description) }}</textarea>
                <small style="color: #666;">Décrivez votre activité, vos produits ou services (max 2000 caractères)</small>
                @error('description')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <h2 style="color: #333; margin-bottom: 1rem;">Informations de contact</h2>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Téléphone de contact</label>
                <input type="tel" name="telephone_contact" value="{{ old('telephone_contact', $pagePro->telephone_contact) }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('telephone_contact')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Email de contact</label>
                <input type="email" name="email_contact" value="{{ old('email_contact', $pagePro->email_contact) }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('email_contact')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Site web</label>
                <input type="url" name="site_web" value="{{ old('site_web', $pagePro->site_web) }}" placeholder="https://example.com" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('site_web')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <h2 style="color: #333; margin-bottom: 1rem;">Réseaux sociaux</h2>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Facebook</label>
                <input type="url" name="facebook" value="{{ old('facebook', $pagePro->reseaux_sociaux['facebook'] ?? '') }}" placeholder="https://facebook.com/votre-page" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('facebook')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Instagram</label>
                <input type="url" name="instagram" value="{{ old('instagram', $pagePro->reseaux_sociaux['instagram'] ?? '') }}" placeholder="https://instagram.com/votre-compte" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('instagram')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Twitter</label>
                <input type="url" name="twitter" value="{{ old('twitter', $pagePro->reseaux_sociaux['twitter'] ?? '') }}" placeholder="https://twitter.com/votre-compte" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('twitter')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">LinkedIn</label>
                <input type="url" name="linkedin" value="{{ old('linkedin', $pagePro->reseaux_sociaux['linkedin'] ?? '') }}" placeholder="https://linkedin.com/company/votre-entreprise" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('linkedin')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <button type="submit" style="flex: 1; min-width: 200px; background: #EF3B2D; color: white; border: none; padding: 0.75rem; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer;">
                    Enregistrer les modifications
                </button>
                <a href="{{ $pagePro->url }}" target="_blank" style="display: inline-block; background: #28a745; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; text-align: center; font-weight: 500;">
                    Voir ma page pro
                </a>
                <a href="{{ route('vendeur.show') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; text-align: center; font-weight: 500;">
                    Mon compte vendeur
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

