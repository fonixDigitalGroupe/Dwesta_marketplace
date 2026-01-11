@extends('layouts.app')

@section('title', $category->nom . ' - Mady Market')

@push('styles')
<style>
    .category-show-container { max-width: 1200px; margin: 1rem auto; padding: 0 1rem; }
    
    .breadcrumbs { margin-bottom: 1rem; font-size: 0.85rem; color: #666; display: flex; align-items: center; gap: 0.5rem; }
    .breadcrumbs a { color: #333; text-decoration: none; }
    .breadcrumbs a:hover { color: #bf0000; }
    .breadcrumbs span { color: #ccc; }

    .category-header { background: white; padding: 2rem; border-radius: 8px; border: 1px solid #e0e0e0; margin-bottom: 1.5rem; }
    .category-title-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem; }
    .category-title { font-size: 2rem; color: #333; font-weight: 800; }
    .category-desc { color: #666; font-size: 1rem; }

    /* Horizontal Category Nav */
    .horizontal-cat-nav { background: white; border-bottom: 1px solid #e0e0e0; margin-bottom: 2rem; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
    .horizontal-cat-nav::-webkit-scrollbar { display: none; }
    .cat-nav-list { display: flex; list-style: none; padding: 0; margin: 0; }
    .cat-nav-item { border-bottom: 2px solid transparent; transition: all 0.2s; }
    .cat-nav-item.active { border-bottom-color: #bf0000; }
    .cat-nav-link { display: block; padding: 1rem 1.5rem; text-decoration: none; color: #333; font-weight: 500; font-size: 0.95rem; }
    .cat-nav-item.active .cat-nav-link { color: #bf0000; font-weight: bold; }
    .cat-nav-item:hover .cat-nav-link { color: #bf0000; }

    .ads-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; }
    
    .ad-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; text-decoration: none; color: inherit; transition: all 0.2s; display: flex; flex-direction: column; }
    .ad-card:hover { transform: translateY(-4px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-color: #bf0000; }
    .ad-image { aspect-ratio: 1; background: #f9f9f9; position: relative; }
    .ad-image img { width: 100%; height: 100%; object-fit: cover; }
    .ad-price { color: #bf0000; font-weight: bold; font-size: 1.2rem; margin-top: 0.5rem; }
    .ad-info { padding: 1rem; flex: 1; display: flex; flex-direction: column; gap: 0.25rem; }
    .ad-title { font-size: 0.95rem; line-height: 1.4; height: 2.8rem; overflow: hidden; }
</style>
@endpush

@section('content')
<div class="category-show-container">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Accueil</a>
        @foreach($category->ancetres as $ancetre)
            <span>/</span>
            <a href="{{ route('categories.show', $ancetre->slug) }}">{{ $ancetre->nom }}</a>
        @endforeach
        <span>/</span>
        <span style="font-weight: 600; color: #333;">{{ $category->nom }}</span>
    </div>

    <div class="category-header">
        <div class="category-title-row">
            @if($category->icone) <span style="font-size: 2rem;">{{ $category->icone }}</span> @endif
            <h1 class="category-title">{{ $category->nom }}</h1>
        </div>
        @if($category->description)
            <p class="category-desc">{{ $category->description }}</p>
        @endif
    </div>

    <!-- Navigation horizontale des sous-catégories (Nav bar) -->
    @php 
        $siblings = $category->parent ? $category->parent->enfantsActifs : \App\Models\Category::racines()->actives()->get();
    @endphp

    <nav class="horizontal-cat-nav">
        <ul class="cat-nav-list">
            @if($category->parent)
                <li class="cat-nav-item">
                    <a href="{{ route('categories.show', $category->parent->slug) }}" class="cat-nav-link" style="color: #666; display: flex; align-items: center; gap: 0.25rem;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        {{ $category->parent->nom }}
                    </a>
                </li>
            @endif
            
            @foreach($siblings as $item)
                <li class="cat-nav-item {{ $item->id === $category->id ? 'active' : '' }}">
                    <a href="{{ route('categories.show', $item->slug) }}" class="cat-nav-link">
                        {{ $item->nom }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <!-- Explorateur de Hiérarchie (Grid style Rakuten) -->
    @if($category->enfantsActifs->isNotEmpty())
    <div style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 2rem; margin-bottom: 2rem;">
        <h3 style="font-size: 1.1rem; font-weight: bold; margin-bottom: 2rem; color: #333; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #f0f0f0; padding-bottom: 0.75rem;">
            Explorer {{ $category->nom }}
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 3rem;">
            @foreach($category->enfantsActifs as $enfant)
                <div>
                    <h4 style="font-weight: 800; font-size: 0.95rem; margin-bottom: 1rem; color: #000; text-transform: uppercase;">
                        <a href="{{ route('categories.show', $enfant->slug) }}" style="text-decoration: none; color: inherit;">{{ $enfant->nom }}</a>
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.5rem;">
                        @foreach($enfant->enfantsActifs as $petitEnfant)
                            <li>
                                <a href="{{ route('categories.show', $petitEnfant->slug) }}" style="text-decoration: none; color: #666; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='#bf0000'" onmouseout="this.style.color='#666'">
                                    {{ $petitEnfant->nom }}
                                </a>
                            </li>
                        @endforeach
                        @if($enfant->enfantsActifs->isEmpty())
                            <li style="color: #ccc; font-size: 0.85rem; font-style: italic;">Pas de sous-catégories</li>
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-size: 1.25rem; font-weight: bold; color: #333;">
            {{ $annonces->total() }} annonce(s) dans <span style="color: #bf0000;">{{ $category->nom }}</span>
        </h2>
    </div>

    <div class="ads-grid">
        @forelse($annonces as $annonce)
            <a href="{{ route('annonces.show', $annonce->slug) }}" class="ad-card">
                <div class="ad-image">
                    @if($annonce->photoPrincipale())
                        <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                    @else
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #ccc;">Pas d'image</div>
                    @endif
                </div>
                <div class="ad-info">
                    <div class="ad-price">{{ number_format($annonce->prix, 2, ',', ' ') }} €</div>
                    <div class="ad-title">{{ $annonce->titre }}</div>
                    <div style="font-size: 0.8rem; color: #999; margin-top: auto;">{{ $annonce->vendeur->user->name }}</div>
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: white; border: 1px solid #e0e0e0; border-radius: 8px;">
                <p style="color: #666;">Aucune annonce dans cette catégorie pour le moment.</p>
                <a href="{{ route('home') }}" style="color: #bf0000; text-decoration: none; display: inline-block; margin-top: 1rem;">Retour à l'accueil</a>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 3rem; display: flex; justify-content: center;">
        {{ $annonces->links() }}
    </div>
</div>
@endsection


