@extends('layouts.app')

@section('title', 'Mes Favoris')

@section('content')
    <div class="main-content">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem;">Mes Favoris</h1>
            <p style="color: #666;">Retrouvez ici toutes vos annonces sauvegardées.</p>
        </div>

        @if($favorites->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
                @foreach($favorites as $annonce)
                    @include('components.annonce-card', ['annonce' => $annonce])
                @endforeach
            </div>
            <div style="margin-top: 2rem;">
                {{ $favorites->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 4rem; background: white; border-radius: 8px; border: 1px solid #e0e0e0;">
                <svg style="width: 64px; height: 64px; margin-bottom: 1rem; color: #ccc;" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
                <h3 style="font-size: 1.2rem; font-weight: bold; margin-bottom: 0.5rem;">Aucun favori pour le moment</h3>
                <p style="color: #666; margin-bottom: 2rem;">Parcourez le catalogue pour ajouter des articles à votre liste de
                    souhaits.</p>
                <a href="{{ route('search.index') }}"
                    style="background: #bf0000; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: bold;">Découvrir
                    les offres</a>
            </div>
        @endif
    </div>
@endsection