@props(['annonce'])

<a href="{{ route('annonces.show', $annonce->slug) }}" class="annonce-card-component" style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; text-decoration: none; color: inherit; transition: all 0.2s; display: flex; flex-direction: column; height: 100%;">
    <div style="position: relative; aspect-ratio: 1; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        @if($annonce->photoPrincipale())
            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: contain;">
        @else
            <div style="color: #ccc; font-size: 0.8rem;">Pas d'image</div>
        @endif
        
        @if($annonce->urgentActive())
            <span style="position: absolute; top: 10px; left: 10px; background: #bf0000; color: white; padding: 2px 8px; font-size: 0.7rem; font-weight: bold; border-radius: 4px; text-transform: uppercase;">Urgent</span>
        @endif

        @if($annonce->aLaUneActive())
             <span style="position: absolute; top: 10px; right: 10px; background: #ffc107; color: #000; padding: 2px 8px; font-size: 0.7rem; font-weight: bold; border-radius: 4px; text-transform: uppercase;">Top</span>
        @endif
    </div>
    
    <div style="padding: 1rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="font-size: 1.1rem; font-weight: 800; color: #bf0000; margin-bottom: 0.5rem;">
                {{ number_format($annonce->prix, 0, ',', ' ') }} FCFA
            </div>
            <h3 style="font-size: 0.9rem; font-weight: 500; line-height: 1.3; height: 2.6rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 0.5rem; color: #333;">
                {{ $annonce->titre }}
            </h3>
        </div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.75rem; color: #888;">
            <div style="display: flex; align-items: center; gap: 0.25rem;">
                <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
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
        border-color: #bf0000;
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
</style>
