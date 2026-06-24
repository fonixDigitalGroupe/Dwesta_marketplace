@extends('layouts.app')

@section('title', 'Mes Annonces')

@push('styles')
<style>
    .my-listings-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    /* Header Section */
    .listings-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .btn {
        padding: 0.65rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #00A400; /* Project Primary Green */
        color: white;
        box-shadow: 0 4px 6px rgba(0, 164, 0, 0.15);
    }

    .btn-primary:hover {
        background-color: #008f00;
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(0, 164, 0, 0.2);
    }

    .btn-secondary {
        background-color: #f3f4f6;
        color: #4b5563;
        border: 1px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background-color: #e5e7eb;
        color: #1f2937;
    }
    
    .btn-danger {
        background-color: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    
    .btn-danger:hover {
        background-color: #fecaca;
        color: #b91c1c;
    }
    
    .btn-outline-primary {
        background-color: transparent;
        color: #00A400;
        border: 1px solid #00A400;
    }
    
    .btn-outline-primary:hover {
        background-color: #ebf9eb;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
    }

    /* Alerts */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .alert-success {
        background-color: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background-color: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* Grid Layout */
    .listings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: #00A400;
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
        transform: scale(1.03);
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
        top: 1rem;
        right: 1rem;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.75rem;
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
    
    .status-expired {
        background-color: rgba(255, 255, 255, 0.95);
        color: #4b5563;
        border: 1px solid #9ca3af;
    }
    
    .urgent-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background-color: #dc2626;
        color: white;
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);
    }

    .card-content {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .listing-meta {
        font-size: 0.8rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .listing-meta-dot {
        width: 3px;
        height: 3px;
        background-color: #d1d5db;
        border-radius: 50%;
    }

    .listing-title {
        font-size: 1.15rem;
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
        color: #00A400;
    }

    .listing-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #00A400;
        margin-bottom: 0.75rem;
    }

    .listing-stats {
        display: flex;
        gap: 1rem;
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
        color: #6b7280;
        font-size: 0.85rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    /* Card Actions */
    .card-actions {
        padding: 0.75rem 1.25rem;
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

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        background-color: #fff;
        border-radius: 12px;
        border: 2px dashed #e5e7eb;
    }

    .empty-icon {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1.5rem;
        display: block;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .empty-description {
        color: #6b7280;
        font-size: 1.1rem;
        margin-bottom: 2rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .listings-grid {
            grid-template-columns: 1fr;
        }
        
        .header-actions {
            width: 100%;
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="my-listings-container">
    <div class="listings-header">
        <h1 class="page-title">Mes Annonces</h1>
        
        <div class="header-actions">
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Accueil
            </a>
            <a href="{{ route('annonces.create', ['type' => 'produit']) }}" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Créer une annonce
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" id="alert-success" style="display: flex; justify-content: space-between; align-items: center;">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('alert-success').style.display='none'" style="background: none; border: none; font-size: 1.25rem; line-height: 1; color: #065f46; cursor: pointer; padding: 0 0 0 1rem; opacity: 0.7;" title="Fermer">✕</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" id="alert-error" style="display: flex; justify-content: space-between; align-items: center;">
            <span>{{ session('error') }}</span>
            <button onclick="document.getElementById('alert-error').style.display='none'" style="background: none; border: none; font-size: 1.25rem; line-height: 1; color: #991b1b; cursor: pointer; padding: 0 0 0 1rem; opacity: 0.7;" title="Fermer">✕</button>
        </div>
    @endif

    @if($annonces->count() > 0)
        <div class="listings-grid">
            @foreach($annonces as $annonce)
                <div class="listing-card">
                    <!-- Status Badge -->
                    @if($annonce->estPubliee())
                        <span class="status-badge status-published">Publiée</span>
                    @elseif($annonce->estBrouillon())
                        <span class="status-badge status-draft">Brouillon</span>
                    @elseif($annonce->statut === 'en_attente')
                        <span class="status-badge status-pending">En attente</span>
                    @elseif($annonce->statut === 'rejetee')
                        <span class="status-badge status-rejected">Rejetée</span>
                    @elseif($annonce->estExpiree())
                        <span class="status-badge status-expired">Expirée</span>
                    @endif

                    <!-- Urgent Badge -->
                    @if($annonce->estUrgent())
                        <span class="urgent-badge">URGENT</span>
                    @endif

                    <!-- Image -->
                    <div class="card-image-wrapper">
                        @if($annonce->photoPrincipale())
                            <img src="{{ $annonce->photoPrincipale()->thumbnail_url ?? $annonce->photoPrincipale()->url }}" 
                                 alt="{{ $annonce->titre }}" 
                                 class="card-image"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="no-image-placeholder" style="display: none;">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Image indisponible</span>
                            </div>
                        @else
                            <div class="no-image-placeholder">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Aucune photo</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="card-content">
                        <div class="listing-meta">
                            <span>{{ ucfirst($annonce->type) }}</span>
                            @if($annonce->category)
                                <span class="listing-meta-dot"></span>
                                <span>{{ $annonce->category->nom }}</span>
                            @endif
                        </div>

                        <h3 class="listing-title">
                            <a href="{{ route('annonces.show', $annonce) }}">{{ Str::limit($annonce->titre, 50) }}</a>
                        </h3>

                        @if($annonce->prix)
                            <div class="listing-price">
                                {{ number_format($annonce->prix_affiche, 0, ',', ' ') }} FCFA
                            </div>
                        @endif

                        <div class="listing-stats">
                            <div class="stat-item" title="Date de création">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $annonce->created_at->format('d/m/Y') }}
                            </div>
                            <div class="stat-item" title="Nombre de vues">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $annonce->vues }}
                            </div>
                            @if($annonce->nb_photos > 0)
                            <div class="stat-item" title="Nombre de photos">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $annonce->nb_photos }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card-actions">
                        <a href="{{ route('annonces.show', $annonce) }}" class="btn btn-sm btn-outline-primary" style="border: none; padding-left: 0; color: #6b7280;">
                            Voir détails
                        </a>
                        
                        <div class="action-group">
                            <a href="{{ route('annonces.edit', $annonce) }}" class="btn btn-sm btn-secondary" title="Modifier">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            
                            @if($annonce->estBrouillon())
                                <form method="POST" action="{{ route('annonces.publier', $annonce) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary" title="Publier">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('annonces.destroy', $annonce) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
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
            <p class="empty-description">C'est le moment idéal pour commencer à vendre ! Créez votre première annonce en quelques clics.</p>
            <a href="{{ route('annonces.create', ['type' => 'produit']) }}" class="btn btn-primary btn-lg">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Créer ma première annonce
            </a>
        </div>
    @endif
</div>
@endsection