<a href="{{ route('annonces.show', $annonce->slug) }}" class="n1-top-card premium-card-flat {{ $class ?? '' }}" {!! $attributes ?? '' !!}>
    <div class="card-media-flat">
        @if($annonce->photoPrincipale())
            <img src="{{ asset('storage/' . $annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
        @else
            <div class="no-photo-flat">No photo</div>
        @endif
    </div>

    <div class="card-info-flat">
        <h3 class="card-title-flat">{{ $annonce->titre }}</h3>

        {{-- Prix + État --}}
        <div class="card-price-row-flat">
            @if($annonce->should_show_etat)
                <span class="card-etat-badge" style="color: {{ $annonce->etat_couleur }};">{{ $annonce->etat_libelle }}</span>
                <span class="card-price-text" style="color: #666; font-size: 0.85rem; margin: 0 2px;">dès</span>
            @endif
            <span class="price-value-flat">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
        </div>

        {{-- Avis clients --}}
        <div class="card-review-row">
            @php
                $moyenneNote = $annonce->note_moyenne ?? 0;
                $nbAvis      = $annonce->nombre_avis ?? 0;
            @endphp
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
    </div>
</a>
