@extends('layouts.app')

@section('title', 'Mady Market - Votre marketplace en ligne')

@push('styles')
<style>
    /* Styles spécifiques à la home page */
    .hero-section { background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; display: flex; gap: 2rem; align-items: center; border: 1px solid #e0e0e0; }
    .hero-text { flex: 1; }
    .hero-title { font-size: 2.5rem; font-weight: bold; color: #333; margin-bottom: 1rem; }
    .hero-subtitle { font-size: 1.25rem; color: #666; margin-bottom: 2rem; }
    .hero-image { flex: 1; text-align: center; }
    .hero-image img { max-width: 100%; height: auto; }
    
    .category-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
    .category-card { background: white; padding: 1.5rem; border-radius: 8px; text-align: center; text-decoration: none; color: #333; border: 1px solid #e0e0e0; transition: all 0.2s; }
    .category-card:hover { border-color: #bf0000; color: #bf0000; transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .category-icon { font-size: 2.5rem; margin-bottom: 1rem; display: block; }

    .main-content {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-text">
            <h1 class="hero-title">Achetez et vendez en toute confiance</h1>
            <p class="hero-subtitle">Rejoignez la plus grande marketplace Rakuten-style d'Afrique.</p>
            <a href="{{ route('annonces.create') }}" class="club-r" style="display: inline-block; padding: 1rem 2rem; font-size: 1.1rem; text-decoration: none;">Mettre en vente maintenant</a>
        </div>
        <div class="hero-image">
            <img src="https://laravel.com/img/logomark.min.svg" alt="Mady Market Hero" style="height: 200px;">
        </div>
    </div>

    <!-- Catégories à la une -->
    <h2 style="margin-bottom: 1.5rem; font-size: 1.5rem;">Parcourir les catégories</h2>
    <div class="category-grid">
        @php
            $displayCategories = \App\Models\Category::whereNull('parent_id')->where('actif', true)->get();
        @endphp
        @foreach($displayCategories as $cat)
            <a href="{{ route('categories.show', $cat->slug) }}" class="category-card">
                <span class="category-icon">{{ $cat->icone ?? '📦' }}</span>
                <span style="font-weight: 500;">{{ $cat->nom }}</span>
            </a>
        @endforeach
    </div>

    <!-- Section Annonces Récentes -->
    <h2 style="margin-bottom: 1.5rem; font-size: 1.5rem;">Dernières opportunités</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
        @php
            $recentAnnonces = \App\Models\Annonce::publiees()->latest()->limit(8)->get();
        @endphp
        @foreach($recentAnnonces as $annonce)
            <a href="{{ route('annonces.show', $annonce->slug) }}" style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; text-decoration: none; color: inherit; transition: transform 0.2s; display: flex; flex-direction: column;">
                <div style="aspect-ratio: 1; background: #f9f9f9;">
                    @if($annonce->photoPrincipale())
                        <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #ccc;">Pas d'image</div>
                    @endif
                </div>
                <div style="padding: 1rem;">
                    <div style="font-weight: bold; color: #bf0000; margin-bottom: 0.25rem;">{{ number_format($annonce->prix, 2, ',', ' ') }} €</div>
                    <div style="font-size: 0.9rem; line-height: 1.2; height: 2.4rem; overflow: hidden;">{{ $annonce->titre }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
