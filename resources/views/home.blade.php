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
    <div style="background: linear-gradient(135deg, #bf0000 0%, #a00000 100%); padding: 3rem; border-radius: 12px; margin-bottom: 3rem; display: flex; gap: 3rem; align-items: center; color: white;">
        <div class="hero-text">
            <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 1.5rem; line-height: 1.1;">Le meilleur choix,<br>au meilleur prix.</h1>
            <p style="font-size: 1.25rem; margin-bottom: 2.5rem; opacity: 0.9;">Rejoignez Club R et profitez de remises imbattables sur des millions de produits.</p>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('annonces.create') }}" style="background: white; color: #bf0000; padding: 1rem 2rem; border-radius: 50px; font-weight: bold; text-decoration: none; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">Vendre un article</a>
                <a href="{{ route('search.index') }}" style="background: transparent; border: 2px solid white; color: white; padding: 1rem 2rem; border-radius: 50px; font-weight: bold; text-decoration: none; font-size: 1.1rem;">Découvrir les offres</a>
            </div>
        </div>
        <div style="flex: 1; display: flex; justify-content: center;">
            <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 20px; backdrop-filter: blur(5px);">
                 <img src="https://laravel.com/img/logomark.min.svg" alt="Mady Market" style="height: 150px; filter: brightness(0) invert(1);">
            </div>
        </div>
    </div>


    <!-- Section: Nos offres imbattables (Urgentes) -->
    @php $offresImbattables = \App\Models\Annonce::publiees()->urgentes()->latest()->limit(5)->get(); @endphp
    @if($offresImbattables->count() > 0)
    <div style="margin-bottom: 4rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.8rem; font-weight: bold; color: #bf0000;">Nos offres imbattables</h2>
            <a href="{{ route('search.index', ['filter' => 'urgent']) }}" style="color: #bf0000; font-weight: bold; text-decoration: none;">Voir tout &rarr;</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem;">
            @foreach($offresImbattables as $annonce)
                @include('components.annonce-card', ['annonce' => $annonce])
            @endforeach
        </div>
    </div>
    @endif

    <!-- Section: Top des produits les plus consultés -->
    @php $topConsultes = \App\Models\Annonce::publiees()->orderBy('vues', 'desc')->limit(5)->get(); @endphp
    <div style="margin-bottom: 4rem; background: #fff; padding: 2rem; border-radius: 12px; border: 1px solid #e0e0e0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.8rem; font-weight: bold;">Top des produits les plus consultés</h2>
            <a href="{{ route('search.index', ['sort' => 'views']) }}" style="color: #666; font-weight: bold; text-decoration: none;">Voir plus</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem;">
            @foreach($topConsultes as $annonce)
                @include('components.annonce-card', ['annonce' => $annonce])
            @endforeach
        </div>
    </div>

    <!-- Section: Nos top produits du moment (A la Une) -->
    @php $topDuMoment = \App\Models\Annonce::publiees()->aLaUne()->latest()->limit(5)->get(); @endphp
    <div style="margin-bottom: 4rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.8rem; font-weight: bold;">Nos top produits du moment</h2>
            <a href="{{ route('search.index', ['filter' => 'featured']) }}" style="color: #666; font-weight: bold; text-decoration: none;">Voir plus</a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem;">
            @foreach($topDuMoment as $annonce)
                @include('components.annonce-card', ['annonce' => $annonce])
            @endforeach
        </div>
    </div>

    <!-- Dernières opportunités (Fallback) -->
    <div style="margin-bottom: 4rem;">
        <h2 style="margin-bottom: 2rem; font-size: 1.8rem; font-weight: bold;">Dernières opportunités</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
            @php
                $recentAnnonces = \App\Models\Annonce::publiees()->latest()->limit(10)->get();
            @endphp
            @foreach($recentAnnonces as $annonce)
                @include('components.annonce-card', ['annonce' => $annonce])
            @endforeach
        </div>
    </div>
</div>
@endsection
