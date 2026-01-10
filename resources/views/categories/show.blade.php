@extends('layouts.app')

@section('title', $category->nom . ' - Mady Market')

@push('styles')
<style>
    .category-show-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
    
    .breadcrumbs { margin-bottom: 2rem; font-size: 0.9rem; color: #666; }
    .breadcrumbs a { color: #bf0000; text-decoration: none; }
    .breadcrumbs a:hover { text-decoration: underline; }

    .category-header { background: white; padding: 2.5rem; border-radius: 8px; border: 1px solid #e0e0e0; margin-bottom: 2rem; text-align: center; }
    .category-title { font-size: 2.5rem; color: #333; margin-bottom: 0.5rem; }
    .category-desc { color: #666; font-size: 1.1rem; max-width: 800px; margin: 0 auto; }

    .category-split { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; }
    
    .subcats-sidebar { background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #e0e0e0; height: fit-content; }
    .subcats-title { font-weight: bold; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f0f0f0; }
    .subcat-link { display: block; padding: 0.5rem 0; color: #666; text-decoration: none; font-size: 0.95rem; }
    .subcat-link:hover { color: #bf0000; }

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
            <span> / </span>
            <a href="{{ route('categories.show', $ancetre->slug) }}">{{ $ancetre->nom }}</a>
        @endforeach
        <span> / </span>
        <span>{{ $category->nom }}</span>
    </div>

    <div class="category-header">
        <h1 class="category-title">
            @if($category->icone) {{ $category->icone }} @endif
            {{ $category->nom }}
        </h1>
        @if($category->description)
            <p class="category-desc">{{ $category->description }}</p>
        @endif
    </div>

    <div class="category-split">
        <aside class="subcats-sidebar">
            <h3 class="subcats-title">Sous-catégories</h3>
            @if($category->enfantsActifs->isNotEmpty())
                @foreach($category->enfantsActifs as $enfant)
                    <a href="{{ route('categories.show', $enfant->slug) }}" class="subcat-link">{{ $enfant->nom }}</a>
                @endforeach
            @else
                <p style="color: #999; font-size: 0.9rem;">Aucune sous-catégorie</p>
                @if($category->parent)
                    <a href="{{ route('categories.show', $category->parent->slug) }}" class="subcat-link" style="margin-top: 1rem; color: #bf0000;">← Retour à {{ $category->parent->nom }}</a>
                @endif
            @endif
        </aside>

        <main>
            <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 1.25rem;">{{ $annonces->total() }} annonce(s) trouvée(s)</h2>
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
        </main>
    </div>
</div>
@endsection

