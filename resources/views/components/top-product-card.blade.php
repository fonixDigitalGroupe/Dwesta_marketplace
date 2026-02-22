@props(['annonce', 'label' => null])

@php
    $prix = $annonce->prix;
@endphp

<a href="{{ route('annonces.show', $annonce->slug) }}" class="top-product-card-component" style="background: white; border: 1px solid #e8e8e8; text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%; border-radius: 8px; overflow: hidden; position: relative;">

    <div style="position: relative; aspect-ratio: 1; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 15px;">
        @if($annonce->photoPrincipale())
            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: contain;">
        @else
            <div style="color: #ccc; font-size: 0.8rem; background: #f9f9f9; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"></div>
        @endif
    </div>

    <div style="padding: 0.75rem 0.9rem; flex: 1; display: flex; flex-direction: column;">
        <h3 style="font-size: 0.8rem; font-weight: 400; line-height: 1.3; height: 2.6rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 0.4rem; color: #333;">
            {{ $annonce->titre }}
        </h3>

        <div style="display: flex; gap: 2px; margin-bottom: 0.5rem; align-items: center;">
            @if($annonce->nombre_avis > 0)
                @php
                    $rating = $annonce->note_moyenne;
                    $fullStars = floor($rating);
                    $halfStar = ($rating - $fullStars) >= 0.5;
                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                @endphp
                @for($i = 0; $i < $fullStars; $i++)
                    <i class="fas fa-star" style="font-size: 9px; color: #ffbc00;"></i>
                @endfor
                @if($halfStar)
                    <i class="fas fa-star-half-alt" style="font-size: 9px; color: #ffbc00;"></i>
                @endif
                @for($i = 0; $i < $emptyStars; $i++)
                    <i class="far fa-star" style="font-size: 9px; color: #ffbc00;"></i>
                @endfor
                <span style="font-size: 9px; color: #999; margin-left: 4px;">({{ $annonce->nombre_avis }})</span>
            @else
                @for($i = 0; $i < 5; $i++)
                    <i class="fas fa-star" style="font-size: 9px; color: #ddd;"></i>
                @endfor
                <span style="font-size: 9px; color: #999; margin-left: 4px;">(0)</span>
            @endif
        </div>


        <div style="margin-top: auto;">
            <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                <span style="font-size: 1rem; font-weight: 900; color: #111;">{{ number_format($prix, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>
    </div>
</a>
