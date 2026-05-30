@extends('layouts.app')

@section('title', 'Mes Avis - Mady Market')

@push('styles')
<style>
    .avis-card {
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #eee;
        transition: background 0.2s;
    }
    .avis-card + .avis-card {
        border-top: none;
        border-radius: 0;
    }
    .avis-card:first-child {
        border-radius: 8px 8px 0 0;
    }
    .avis-card:last-child {
        border-radius: 0 0 8px 8px;
        border-bottom: 1px solid #eee;
    }
    .avis-card:only-child {
        border-radius: 8px;
    }
    .stars {
        display: flex;
        gap: 2px;
    }
    .star-filled { color: #f39c12; }
    .star-empty  { color: #ddd; }
    .badge-statut {
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-approuve  { background: #e8f5e9; color: #2e7d32; }
    .badge-en_attente { background: #fff3e0; color: #ef6c00; }
    .badge-rejete    { background: #fde8e8; color: #c62828; }
</style>
@endpush

@section('content')

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mes avis</h1>
        </div>

        @if($avis->isEmpty())
            <div style="padding: 3rem; text-align: center;">
                <div style="font-size: 4rem; color: #ddd; margin-bottom: 1.5rem;"><i class="fa-regular fa-comment-dots"></i></div>
                <h3 style="margin-bottom: 0.5rem; color: #444;">Vous n'avez encore laissé aucun avis.</h3>
                <p style="color: #666; font-size: 0.95rem;">Laissez des avis sur vos achats pour guider la communauté Karnou.</p>
            </div>
        @else
            <div>
                @foreach($avis as $item)
                    <div class="avis-card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                            <div>
                                @if($item->annonce)
                                    <a href="{{ route('annonces.show', $item->annonce) }}" style="font-weight: 700; font-size: 0.95rem; color: #222; text-decoration: none;">
                                        {{ $item->annonce->titre }}
                                    </a>
                                @else
                                    <span style="font-weight: 700; font-size: 0.95rem; color: #999;">Annonce retirée</span>
                                @endif
                                <div style="font-size: 0.8rem; color: #aaa; margin-top: 2px;">
                                    Publié le {{ $item->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                            <span class="badge-statut badge-{{ $item->statut }}">
                                @if($item->statut === 'approuve') Approuvé
                                @elseif($item->statut === 'en_attente') En attente
                                @else Rejeté
                                @endif
                            </span>
                        </div>

                        <div class="stars" style="margin-bottom: 0.6rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $i <= $item->note ? '#f39c12' : '#ddd' }}">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                            @endfor
                        </div>

                        @if($item->commentaire)
                            <p style="font-size: 0.9rem; color: #555; line-height: 1.5; margin: 0;">{{ $item->commentaire }}</p>
                        @endif

                        @if($item->statut === 'rejete' && $item->raison_rejet)
                            <div style="margin-top: 0.75rem; padding: 0.6rem 0.9rem; background: #fde8e8; border-radius: 6px; font-size: 0.82rem; color: #c62828;">
                                <strong>Motif du rejet :</strong> {{ $item->raison_rejet }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 2rem;">
                {{ $avis->links() }}
            </div>
        @endif
    </main>
</div>
@endsection
