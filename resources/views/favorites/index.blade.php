@extends('layouts.app')

@section('title', 'Mes Favoris - Mady Market')

@push('styles')
<style>
    /* Premium Card Flat Style */
    .premium-card-flat {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 0.75rem;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: all 0.2s;
        height: 100%;
    }

    .premium-card-flat:hover {
        border-color: #ddd;
    }

    .card-media-flat {
        width: 100%;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        background: #fff;
    }

    .card-media-flat img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .card-info-flat {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title-flat {
        font-size: 1rem;
        line-height: 1.3;
        color: #1a1a1a;
        margin-bottom: 6px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-weight: 800;
        height: 2.6em;
    }

    .card-review-row {
        display: flex;
        align-items: center;
        gap: 2px;
        color: #f5a623;
        font-size: 0.8rem;
        margin: 4px 0 6px 0;
    }

    .card-review-count {
        color: #007185;
        font-size: 0.8rem;
        margin-left: 4px;
        font-weight: 400;
    }

    .card-price-row-flat {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .price-value-flat {
        color: #f68b1e;
        font-weight: 800;
        font-size: 1.25rem;
    }

    .card-price-old {
        font-size: 0.75rem;
        color: #999;
        text-decoration: line-through;
    }

    .card-discount {
        font-size: 0.7rem;
        font-weight: 800;
        color: #fff;
        background: #004aad;
        padding: 1px 5px;
        border-radius: 3px;
    }

    .fav-remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255,255,255,0.9);
        border: 1px solid #eee;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #db0001;
        font-size: 0.9rem;
        z-index: 30;
        transition: all 0.2s;
    }

    .fav-remove-btn:hover {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        color: #ff0000;
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
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(215px, 1fr)); gap: 1.5rem;">
                @foreach($favorites as $annonce)
                    <div style="position: relative;">
                        {{-- Remove from favorites button --}}
                        <form action="{{ route('favorites.toggle', $annonce->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="fav-remove-btn" title="Retirer des favoris">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>

                        <a href="{{ route('annonces.show', $annonce->slug) }}" class="premium-card-flat">
                            <div class="card-media-flat">
                                @if($annonce->photoPrincipale())
                                    <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                                @else
                                    <div class="no-photo-flat">
                                        <i class="fas fa-image" style="font-size: 2rem; color: #ddd; display: block; margin-bottom: 4px;"></i>
                                        Pas d'image
                                    </div>
                                @endif
                            </div>

                            <div class="card-info-flat">
                                <h3 class="card-title-flat">{{ $annonce->titre }}</h3>

                                {{-- Avis clients --}}
                                @php
                                    $moyenneNote = $annonce->note_moyenne ?? 0;
                                    $nbAvis      = $annonce->nombre_avis ?? 0;
                                @endphp
                                <div class="card-review-row">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($moyenneNote))
                                            <i class="fas fa-star"></i>
                                        @elseif($i == ceil($moyenneNote) && ($moyenneNote - floor($moyenneNote)) >= 0.5)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="card-review-count">({{ $nbAvis }})</span>
                                </div>

                                {{-- Prix --}}
                                <div class="card-price-row-flat">
                                    @if($annonce->should_show_etat)
                                        <span class="card-etat-badge" style="color: {{ $annonce->etat_couleur }};">{{ $annonce->etat_libelle }}</span>
                                        <span class="card-price-text" style="color: #666; font-size: 0.85rem; margin: 0 2px;">dès</span>
                                    @endif
                                    <span class="price-value-flat">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                                    @if($annonce->prix_original && $annonce->prix_original > $annonce->prix)
                                        <span class="card-price-old">{{ number_format($annonce->prix_original, 0, ',', ' ') }}</span>
                                        <span class="card-discount">-{{ $annonce->discount_percentage }}%</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 2rem;">
                {{ $favorites->links() }}
            </div>

        @else
            <div style="padding: 3rem; text-align: center;">
                <i class="fa-regular fa-heart" style="font-size: 4rem; color: #ddd; display: block; margin-bottom: 1.5rem;"></i>
                <h3 style="margin-bottom: 0.5rem; color: #444;">Vous n'avez pas encore de favoris</h3>
                <p style="color: #666; font-size: 0.95rem;">Ajoutez des annonces à vos favoris en cliquant sur ❤️</p>
            </div>
        @endif
    </main>
</div>
@endsection