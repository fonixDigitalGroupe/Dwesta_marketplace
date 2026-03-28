@props(['annonce'])

<a href="{{ route('annonces.show', $annonce->slug) }}" class="annonce-card-component rakuten-card" style="background: white; border: 1px solid #e0e0e0; text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%; border-radius: 8px; overflow: hidden; position: relative;">
    <div style="position: relative; aspect-ratio: 1; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 15px;">
        @if($annonce->aLaUneActive())
            <div style="position: absolute; top: 10px; left: 10px; background: #ffbc00; color: #000; font-size: 0.65rem; font-weight: 800; padding: 2px 8px; border-radius: 4px; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">SPONSORISÉ</div>
        @endif
        @if($annonce->photoPrincipale())
            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: contain;" class="card-img">
        @else
            <div style="color: #ccc; font-size: 0.8rem; background: #f9f9f9; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">Pas d'image</div>
        @endif
    </div>
    
    <div style="padding: 0.9rem; flex: 1; display: flex; flex-direction: column; gap: 4px;">
        <h3 style="font-size: 0.8rem; font-weight: 700; line-height: 1.25; height: 2.1rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 0.2rem; color: #333;">
            {{ $annonce->titre }}
        </h3>

        <div style="display: flex; gap: 4px; align-items: center; margin-bottom: 2px;">
            @php
                $rating = $annonce->note_moyenne;
                $fullStars = floor($rating);
                $halfStar = ($rating - $fullStars) >= 0.5;
                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            @endphp
            <div style="display: flex; gap: 0; color: #ffbc00; font-size: 0.7rem;">
                @for($i = 0; $i < $fullStars; $i++) <i class="fas fa-star"></i> @endfor
                @if($halfStar) <i class="fas fa-star-half-alt"></i> @endif
                @for($i = 0; $i < $emptyStars; $i++) <i class="far fa-star"></i> @endfor
            </div>
            <span style="font-size: 0.7rem; color: #777;">{{ $annonce->nombre_avis ?? 0 }} avis</span>
        </div>

        <div style="margin-top: auto;">
            <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 4px; flex-wrap: wrap;">
                <span style="font-size: 1.1rem; font-weight: 800; color: #db0001;">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                <span style="font-weight: bold; color: #db0001;">·</span>
                <span style="font-size: 0.75rem; font-weight: 700; color: #db0001;">
                    {{ ucfirst($annonce->metadata?->etat ?? 'Occasion') }}
                </span>
            </div>

            @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
            <div style="font-size: 0.7rem; color: #777; margin-bottom: 0.7rem; display: flex; align-items: center; gap: 3px;">
                <span>Par 
                    <span style="font-weight: 600; color: #333;">
                        {{ $annonce->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}
                        <span style="background: #fff; color: #333; font-size: 6px; font-weight: 800; padding: 1px 4px; border-radius: 0; border: 1px solid #ddd; text-transform: uppercase;">PRO</span>
                    </span>
                </span>
            </div>
            @endif
            
            <div style="padding-top: 4px;">
                <span style="display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.5rem; border: 1.5px solid #111; border-radius: 8px; background: #fff; color: #111; font-size: 0.85rem; font-weight: 800;">
                    Voir le produit
                </span>
            </div>
        </div>
    </div>
    </div>
</a>
