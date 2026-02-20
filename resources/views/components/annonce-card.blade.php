@props(['annonce'])

<a href="{{ route('annonces.show', $annonce->slug) }}" class="annonce-card-component rakuten-card" style="background: white; border: 1px solid #f0f0f0; text-decoration: none; color: inherit; transition: all 0.2s; display: flex; flex-direction: column; height: 100%; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
    <div style="position: relative; aspect-ratio: 1; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 10px;">
        @if($annonce->photoPrincipale())
            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: contain; transition: transform 0.3s;" class="card-img">
        @else
            <div style="color: #ccc; font-size: 0.8rem; background: #f9f9f9; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">Pas d'image</div>
        @endif
        
        @if($annonce->urgentActive())
            <span style="position: absolute; top: 12px; left: 12px; background: #bf0000; color: white; padding: 3px 10px; font-size: 0.65rem; font-weight: 700; border-radius: 50px; text-transform: uppercase; z-index: 2;">Urgent</span>
        @endif

        @if($annonce->aLaUneActive())
             <span style="position: absolute; top: 12px; right: 12px; background: #ffc107; color: #000; padding: 3px 10px; font-size: 0.65rem; font-weight: 700; border-radius: 50px; text-transform: uppercase; z-index: 2;">Top</span>
        @endif
    </div>
    
    <div style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <h3 style="font-size: 0.95rem; font-weight: 500; line-height: 1.4; height: 2.7rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 0.75rem; color: #333;">
                {{ $annonce->titre }}
            </h3>
            
            <div style="font-size: 1.2rem; font-weight: 800; color: #bf0000; margin-bottom: 0.5rem;">
                {{ number_format($annonce->prix, 0, ',', ' ') }} <span style="font-size: 0.9rem; font-weight: 600;">FCFA</span>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.75rem; color: #999; margin-top: 0.5rem; border-top: 1px solid #f5f5f5; padding-top: 0.75rem;">
            <div style="display: flex; align-items: center; gap: 0.35rem;">
                <svg style="width: 14px; height: 14px; opacity: 0.6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                {{ $annonce->vues }}
            </div>
            <div>
                {{ $annonce->publiee_le ? $annonce->publiee_le->diffForHumans() : $annonce->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
</a>

<style>
    .annonce-card-component:hover {
        border-color: #bf0000 !important;
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08) !important;
    }
    .annonce-card-component:hover .card-img {
        transform: scale(1.05);
    }
</style>
