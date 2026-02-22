@props(['annonce'])

<a href="{{ route('annonces.show', $annonce->slug) }}" class="annonce-card-component rakuten-card" style="background: white; border: 1px solid #e0e0e0; text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%; border-radius: 8px; overflow: hidden; position: relative;">
    <div style="position: relative; aspect-ratio: 1; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 15px;">
        @if($annonce->photoPrincipale())
            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: contain;" class="card-img">
        @else
            <div style="color: #ccc; font-size: 0.8rem; background: #f9f9f9; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">Pas d'image</div>
        @endif
    </div>
    
    <div style="padding: 1rem; flex: 1; display: flex; flex-direction: column;">
        <h3 style="font-size: 0.85rem; font-weight: 500; line-height: 1.3; height: 2.6rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 0.75rem; color: #666;">
            {{ $annonce->titre }}
        </h3>
        
        <div style="margin-top: auto;">
            <div style="font-size: 0.85rem; color: #bf0000; font-weight: 600; margin-bottom: 2px;">
                Neufs dès <span style="font-size: 1.1rem; font-weight: 800;">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
            </div>
            
            <div style="display: flex; gap: 2px; margin-top: 10px; align-items: center;">
                @if($annonce->nombre_avis > 0)
                    @php
                        $rating = $annonce->note_moyenne;
                        $fullStars = floor($rating);
                        $halfStar = ($rating - $fullStars) >= 0.5;
                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                    @endphp
                    @for($i = 0; $i < $fullStars; $i++)
                        <i class="fas fa-star" style="font-size: 10px; color: #ffbc00;"></i>
                    @endfor
                    @if($halfStar)
                        <i class="fas fa-star-half-alt" style="font-size: 10px; color: #ffbc00;"></i>
                    @endif
                    @for($i = 0; $i < $emptyStars; $i++)
                        <i class="far fa-star" style="font-size: 10px; color: #ffbc00;"></i>
                    @endfor
                    <span style="font-size: 10px; color: #999; margin-left: 4px;">{{ $annonce->nombre_avis }} avis</span>
                @else
                    @for($i = 0; $i < 5; $i++)
                        <i class="fas fa-star" style="font-size: 10px; color: #ddd;"></i>
                    @endfor
                    <span style="font-size: 10px; color: #999; margin-left: 4px;">0 avis</span>
                @endif
            </div>
        </div>
    </div>
</a>
