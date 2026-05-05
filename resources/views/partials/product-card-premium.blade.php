<a href="{{ route('annonces.show', $annonce->slug) }}" class="n1-top-card premium-card-flat">
    <div class="card-media-flat">
        @if($annonce->photoPrincipale())
            <img src="{{ asset('storage/' . $annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
        @else
            <div class="no-photo-flat">No photo</div>
        @endif
    </div>

    <div class="card-info-flat">
        <h3 class="card-title-flat">{{ $annonce->titre }}</h3>
        
        <div class="card-price-row-flat" style="display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap;">
            <span class="price-value-flat" style="color: #ff8c00; font-weight: 700;">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
            @if($annonce->prix_original && $annonce->prix_original > $annonce->prix)
                <span class="original-price-flat" style="color: #999; text-decoration: line-through; font-size: 0.75rem;">{{ number_format($annonce->prix_original, 0, ',', ' ') }} FCFA</span>
                <span class="discount-badge-flat" style="background: #ff4d4f; color: #fff; font-size: 0.65rem; padding: 1px 4px; border-radius: 3px; font-weight: 700;">-{{ $annonce->discount_percentage }}%</span>
            @endif
        </div>


        @if($annonce->vendeur && (!isset($hideSeller) || !$hideSeller))
        <div style="font-size: 0.7rem; color: #888; margin-top: 8px; display: flex; align-items: center; gap: 5px; flex-wrap: wrap; border-top: 1px solid #f8f8f8; padding-top: 8px;">
            <span>Par <strong>
                @if($annonce->vendeur->type === 'professionnel' && $annonce->vendeur->professionnel)
                    {{ $annonce->vendeur->professionnel->nom_entreprise }}
                @else
                    {{ $annonce->vendeur->user->prenom ?? 'Vendeur' }}
                @endif
            </strong></span>
            @if($annonce->vendeur->type === 'professionnel')
                <span style="background: #fff; color: #333; font-size: 7px; font-weight: 800; padding: 0px 4px; border: 1px solid #ddd; text-transform: uppercase;">PRO</span>
            @endif
        </div>
        @endif
    </div>
</a>
