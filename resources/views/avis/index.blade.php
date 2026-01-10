@extends('layouts.app')

@section('title', 'Avis - ' . $annonce->titre)

@section('content')
<div style="max-width: 1000px; margin: 2rem auto; padding: 0 1rem;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('annonces.show', $annonce) }}" style="color: #666; text-decoration: none; font-size: 0.875rem;">
            ← Retour à l'annonce
        </a>
        <h1 style="color: #333; margin: 1rem 0 0.5rem 0;">Avis clients</h1>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('annonces.show', $annonce) }}" style="color: #666; text-decoration: none;">{{ $annonce->titre }}</a>
            <span style="color: #666;">•</span>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($annonce->note_moyenne))
                        <span style="color: #ffc107; font-size: 1.125rem;">★</span>
                    @elseif($i - 0.5 <= $annonce->note_moyenne)
                        <span style="color: #ffc107; font-size: 1.125rem;">☆</span>
                    @else
                        <span style="color: #ddd; font-size: 1.125rem;">★</span>
                    @endif
                @endfor
                <span style="color: #666; font-weight: 500; margin-left: 0.5rem;">{{ number_format($annonce->note_moyenne, 1) }} / 5</span>
                <span style="color: #666;">({{ $annonce->nombre_avis }} avis)</span>
            </div>
        </div>
    </div>

    @if($avis->count() > 0)
        <div style="display: grid; gap: 1.5rem; margin-bottom: 2rem;">
            @foreach($avis as $avisItem)
                <div style="padding: 1.5rem; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #EF3B2D;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <div style="font-weight: 600; color: #333; margin-bottom: 0.25rem; font-size: 1.125rem;">
                                {{ $avisItem->user->prenom }} {{ $avisItem->user->nom ?? '' }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $avisItem->note)
                                        <span style="color: #ffc107; font-size: 1.125rem;">★</span>
                                    @else
                                        <span style="color: #ddd; font-size: 1.125rem;">★</span>
                                    @endif
                                @endfor
                                <span style="color: #666; font-size: 0.875rem; margin-left: 0.5rem;">{{ $avisItem->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <p style="color: #666; line-height: 1.6; margin: 0 0 1rem 0;">{{ $avisItem->commentaire }}</p>
                    @if($avisItem->photos && count($avisItem->photos) > 0)
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            @foreach($avisItem->photos as $photoPath)
                                <img src="{{ asset('storage/' . $photoPath) }}" alt="Photo avis" style="width: 120px; height: 120px; object-fit: cover; border-radius: 4px; cursor: pointer;" onclick="openLightbox(0); document.getElementById('lightbox-image').src = this.src;">
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $avis->links() }}
        </div>
    @else
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 3rem; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">⭐</div>
            <p style="margin: 0; color: #666;">Aucun avis pour le moment</p>
        </div>
    @endif
</div>

<!-- Lightbox pour les photos -->
<div id="lightbox" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 9999; cursor: pointer;" onclick="closeLightbox()">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
        <img id="lightbox-image" src="" alt="" style="max-width: 100%; max-height: 90vh; object-fit: contain;">
    </div>
    <button onclick="closeLightbox(); event.stopPropagation();" style="position: absolute; top: 2rem; right: 2rem; background: rgba(255,255,255,0.2); color: white; border: 2px solid white; border-radius: 50%; width: 50px; height: 50px; font-size: 1.5rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">&times;</button>
</div>

@push('scripts')
<script>
    function openLightbox(index) {
        document.getElementById('lightbox').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endpush
@endsection

