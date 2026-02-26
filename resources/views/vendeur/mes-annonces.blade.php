@extends('layouts.app')

@section('title', 'Mes annonces - Mady Market')

@push('styles')
<style>
    /* Scoped styles for the dashboard content */
    .dashboard-grid-container {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        padding-top: 1rem; /* Added to match profile page spacing */
    }

    /* Grid Layout */
    .listings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Slightly smaller for sidebar layout */
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    /* Card Styling */
    .listing-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eaeaea;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .listing-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        /* Border color change removed as requested */
    }

    .card-image-wrapper {
        position: relative;
        padding-top: 60%; /* 16:9 Aspect Ratio */
        background-color: #f8f9fa;
        overflow: hidden;
    }

    .card-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .listing-card:hover .card-image {
        transform: scale(1.01); /* Reduced animation */
    }

    .no-image-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        background-color: #f3f4f6;
    }

    .status-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 10;
    }

    .status-published {
        background-color: rgba(255, 255, 255, 0.95);
        color: #059669; /* Green */
        border: 1px solid #34d399;
    }

    .status-pending {
        background-color: rgba(255, 255, 255, 0.95);
        color: #d97706; /* Amber */
        border: 1px solid #fbbf24;
    }

    .status-draft {
        background-color: rgba(255, 255, 255, 0.95);
        color: #6b7280; /* Gray */
        border: 1px solid #d1d5db;
    }
    
    .status-rejected {
        background-color: rgba(255, 255, 255, 0.95);
        color: #dc2626; /* Red */
        border: 1px solid #fecaca;
    }
    
    .card-content {
        padding: 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .listing-meta {
        font-size: 0.75rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .listing-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 0.5rem 0;
        line-height: 1.4;
    }

    .listing-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }

    .listing-title a:hover {
        color: #bf0000;
    }

    .listing-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #bf0000;
        margin-bottom: 0.75rem;
    }

    .listing-stats {
        display: flex;
        gap: 0.75rem;
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid #f3f4f6;
        color: #6b7280;
        font-size: 0.8rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Card Actions */
    .card-actions {
        padding: 0.75rem 1rem;
        background-color: #f9fafb;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .action-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action-sm {
        padding: 0.35rem 0.6rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .btn-edit {
        background-color: #f3f4f6;
        color: #4b5563;
        border-color: #e5e7eb;
    }
    
    .btn-edit:hover {
        background-color: #e5e7eb;
        color: #1f2937;
    }

    .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }
    
    .btn-delete:hover {
        background-color: #fecaca;
        color: #b91c1c;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        background-color: #fff;
        border-radius: 12px;
        border: 2px dashed #e5e7eb;
    }

    /* Header Style from Profile */
    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start; /* Aligns to top like profile */
        margin-bottom: 1.5rem; /* Matches profile gap */
    }

    .content-header h1 {
        font-size: 1.5rem;
        color: #333;
        font-weight: 700;
        margin: 0;
    }

    .btn-create-ad-outline {
        background-color: transparent;
        color: #333;
        padding: 0.7rem 0;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.2s ease;
        border: none;
    }
    
    .btn-create-ad-outline:hover {
        color: #000;
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('profile.show') }}">Mon Compte</a> > <span>Mes annonces</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <!-- Header matching Profile style -->
            <div class="content-header">
                <h1>Mes annonces</h1>
                <a href="{{ route('annonces.create') }}" class="btn-create-ad-outline">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #bf0000;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Mettre en vente
                </a>
            </div>

            <div class="dashboard-grid-container">
                @if(session('success'))
                    <div class="alert alert-success" style="background:#d1e7dd; color:#0f5132; border-color:#badbcc; padding:1rem; border-radius:8px; margin-bottom:1.5rem;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($annonces->count() > 0)
                    <div class="listings-grid">
                        @foreach($annonces as $annonce)
                            <div class="listing-card">
                                <!-- Status Badge -->
                                @if($annonce->statut === 'publiee')
                                    <span class="status-badge status-published">Publiée</span>
                                @elseif($annonce->statut === 'en_attente')
                                    <span class="status-badge status-pending">En attente</span>
                                @elseif($annonce->statut === 'brouillon')
                                    <span class="status-badge status-draft">Brouillon</span>
                                @elseif($annonce->statut === 'rejetee')
                                    <span class="status-badge status-rejected">Rejetée</span>
                                @else
                                    <span class="status-badge status-expired">{{ ucfirst($annonce->statut) }}</span>
                                @endif

                                <!-- Image -->
                                <div class="card-image-wrapper">
                                    @if($annonce->photoPrincipale())
                                        <img src="{{ asset('storage/' . $annonce->photoPrincipale()->chemin) }}" 
                                             alt="{{ $annonce->titre }}" 
                                             class="card-image"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="no-image-placeholder" style="display: none;">
                                            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="no-image-placeholder">
                                            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span style="font-size: 0.8rem; margin-top: 0.5rem;">Pas de photo</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="card-content">
                                    <h3 class="listing-title">
                                        <a href="{{ route('annonces.show', $annonce) }}">{{ Str::limit($annonce->titre, 40) }}</a>
                                    </h3>

                                    @if($annonce->prix)
                                        <div class="listing-price">
                                            {{ number_format($annonce->prix, 0, ',', ' ') }} FCFA
                                        </div>
                                    @endif

                                    <div class="listing-meta">
                                        <span>{{ $annonce->category->nom ?? 'Autre' }}</span>
                                    </div>

                                    <div class="listing-stats">
                                        <div class="stat-item" title="Vues">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ $annonce->vues }}
                                        </div>
                                        <div class="stat-item" title="Date">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $annonce->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card-actions">
                                    <a href="{{ route('annonces.show', $annonce) }}" class="btn-action-sm" style="color: #6b7280; font-size: 0.85rem; font-weight: 500; text-decoration: none;">
                                        Voir
                                    </a>
                                    
                                    <div class="action-group">
                                        <a href="{{ route('annonces.edit', $annonce) }}" class="btn-action-sm btn-edit" title="Modifier">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        <form method="POST" action="{{ route('annonces.destroy', $annonce) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-sm btn-delete border-0" title="Supprimer">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div style="display: flex; justify-content: center; margin-top: 2rem;">
                        {{ $annonces->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <span class="empty-icon">
                            <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </span>
                        <h2 class="empty-title">Aucune annonce pour le moment</h2>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
