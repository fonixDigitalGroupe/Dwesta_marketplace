@extends('layouts.app')

@section('title', 'Mes Favoris - Mady Market')

@push('styles')
<style>
    .fav-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        transition: box-shadow 0.2s, transform 0.2s;
        position: relative;
    }

    .fav-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }

    .fav-card-img {
        aspect-ratio: 1;
        background: #f9f9f9;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 12px;
    }

    .fav-card-img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .fav-card-img .no-img {
        color: #ccc;
        font-size: 0.8rem;
        text-align: center;
    }

    .fav-card-body {
        padding: 0.8rem 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .fav-card-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #222;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.3em;
    }

    .fav-card-price {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: auto;
    }

    .fav-price-main {
        font-size: 1.05rem;
        font-weight: 800;
        color: #db0001;
    }

    .fav-price-old {
        font-size: 0.75rem;
        color: #999;
        text-decoration: line-through;
    }

    .fav-discount {
        font-size: 0.7rem;
        font-weight: 800;
        color: #fff;
        background: #db0001;
        padding: 1px 5px;
        border-radius: 3px;
    }

    .fav-card-vendor {
        font-size: 0.7rem;
        color: #888;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .fav-card-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ffbc00;
        color: #000;
        font-size: 0.6rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 4px;
        z-index: 10;
        text-transform: uppercase;
    }

    .fav-remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255,255,255,0.9);
        border: 1px solid #eee;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #db0001;
        font-size: 0.9rem;
        z-index: 10;
        transition: background 0.2s;
        text-decoration: none;
    }

    .fav-remove-btn:hover {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .fav-stars {
        display: flex;
        align-items: center;
        gap: 3px;
        color: #ffbc00;
        font-size: 0.7rem;
    }

    .fav-stars span {
        color: #888;
        font-size: 0.7rem;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mes Favoris
                @if($favorites->count() > 0)
                    <span style="font-size: 0.85rem; font-weight: 400; color: #888; margin-left: 8px;">({{ $favorites->total() }} article{{ $favorites->total() > 1 ? 's' : '' }})</span>
                @endif
            </h1>
        </div>

        @if($favorites->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 1.2rem;">
                @foreach($favorites as $annonce)
                    <div style="position: relative;">
                        {{-- Remove from favorites button --}}
                        <form action="{{ route('favorites.toggle', $annonce->slug) }}" method="POST" style="position: absolute; top: 10px; right: 10px; z-index: 20;">
                            @csrf
                            <button type="submit" class="fav-remove-btn" title="Retirer des favoris">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>

                        <a href="{{ route('annonces.show', $annonce->slug) }}" class="fav-card">
                            @if($annonce->aLaUneActive())
                                <span class="fav-card-badge">Sponsorisé</span>
                            @endif

                            <div class="fav-card-img">
                                @if($annonce->photoPrincipale())
                                    <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                                @else
                                    <div class="no-img">
                                        <i class="fas fa-image" style="font-size: 2rem; color: #ddd; display: block; margin-bottom: 4px;"></i>
                                        Pas d'image
                                    </div>
                                @endif
                            </div>

                            <div class="fav-card-body">
                                <div class="fav-card-title">{{ $annonce->titre }}</div>

                                {{-- Stars --}}
                                @php
                                    $rating = $annonce->note_moyenne;
                                    $fullStars = floor($rating);
                                    $halfStar = ($rating - $fullStars) >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp
                                <div class="fav-stars">
                                    @for($i = 0; $i < $fullStars; $i++)<i class="fas fa-star"></i>@endfor
                                    @if($halfStar)<i class="fas fa-star-half-alt"></i>@endif
                                    @for($i = 0; $i < $emptyStars; $i++)<i class="far fa-star"></i>@endfor
                                    <span>({{ $annonce->nombre_avis ?? 0 }})</span>
                                </div>

                                {{-- Price --}}
                                <div class="fav-card-price">
                                    <span class="fav-price-main">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                                    @if($annonce->prix_original && $annonce->prix_original > $annonce->prix)
                                        <span class="fav-price-old">{{ number_format($annonce->prix_original, 0, ',', ' ') }}</span>
                                        <span class="fav-discount">-{{ $annonce->discount_percentage }}%</span>
                                    @endif
                                </div>

                                {{-- Vendeur --}}
                                @if($annonce->vendeur)
                                    <div class="fav-card-vendor">
                                        <span>Par</span>
                                        <strong style="color: #444;">
                                            @if($annonce->vendeur->type === 'professionnel' && $annonce->vendeur->professionnel)
                                                {{ $annonce->vendeur->professionnel->nom_entreprise }}
                                            @else
                                                {{ $annonce->vendeur->user->prenom ?? 'Vendeur' }}
                                            @endif
                                        </strong>
                                        @if($annonce->vendeur->type === 'professionnel')
                                            <span style="background: #f5f5f5; color: #555; font-size: 6px; font-weight: 800; padding: 1px 4px; border: 1px solid #ddd; text-transform: uppercase;">PRO</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 2rem;">
                {{ $favorites->links() }}
            </div>

        @else
            <div style="background: white; padding: 4rem 2rem; text-align: center; border-radius: 8px; border: 1px solid #eee;">
                <i class="fas fa-heart" style="font-size: 3rem; color: #eee; display: block; margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.1rem; color: #555; margin-bottom: 0.5rem;">Vous n'avez pas encore de favoris</h3>
                <p style="color: #999; font-size: 0.9rem; margin-bottom: 1.5rem;">Ajoutez des annonces à vos favoris en cliquant sur ❤️</p>
                <a href="{{ route('home') }}" style="background: #db0001; color: white; padding: 0.75rem 2rem; border-radius: 6px; text-decoration: none; font-weight: 700;">
                    Explorer les annonces
                </a>
            </div>
        @endif
    </main>
</div>
@endsection