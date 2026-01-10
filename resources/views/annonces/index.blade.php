@extends('layouts.app')

@section('title', 'Mes Annonces')

@section('content')
<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h1 style="color: #333; margin: 0;">Mes Annonces</h1>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('annonces.create', ['type' => 'produit']) }}" style="display: inline-block; background: #28a745; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                ➕ Créer une annonce
            </a>
            <a href="{{ route('dashboard') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    @if($annonces->count() > 0)
        <div style="display: grid; gap: 1.5rem; margin-bottom: 2rem;">
            @foreach($annonces as $annonce)
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden; display: flex;">
                    <!-- Photo principale -->
                    <div style="width: 200px; min-width: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                        @if($annonce->photoPrincipale())
                            <img src="{{ $annonce->photoPrincipale()->thumbnail_url ?? $annonce->photoPrincipale()->url }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 200px; object-fit: cover;">
                        @else
                            <div style="color: #999; text-align: center; padding: 2rem;">
                                <div style="font-size: 3rem; margin-bottom: 0.5rem;">📷</div>
                                <div style="font-size: 0.875rem;">Aucune photo</div>
                            </div>
                        @endif
                    </div>

                    <!-- Contenu -->
                    <div style="flex: 1; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                <h2 style="color: #333; margin: 0; font-size: 1.25rem;">
                                    <a href="{{ route('annonces.show', $annonce) }}" style="color: #333; text-decoration: none;">
                                        {{ $annonce->titre }}
                                    </a>
                                </h2>
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    @if($annonce->statut === 'publiee')
                                        <span style="background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                            Publiée
                                        </span>
                                    @elseif($annonce->statut === 'en_attente')
                                        <span style="background: #ffc107; color: #333; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                            En attente
                                        </span>
                                    @elseif($annonce->statut === 'brouillon')
                                        <span style="background: #6c757d; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                            Brouillon
                                        </span>
                                    @elseif($annonce->statut === 'rejete')
                                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                            Rejetée
                                        </span>
                                    @elseif($annonce->statut === 'expiree')
                                        <span style="background: #6c757d; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                            Expirée
                                        </span>
                                    @endif
                                    @if($annonce->options && $annonce->options->urgentActive())
                                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                            URGENT
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div style="color: #666; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                @if($annonce->category)
                                    <span>📁 {{ $annonce->category->nom }}</span>
                                @endif
                                <span style="margin: 0 0.5rem;">•</span>
                                <span>🏷️ {{ ucfirst($annonce->type) }}</span>
                                @if($annonce->prix)
                                    <span style="margin: 0 0.5rem;">•</span>
                                    <span style="color: #EF3B2D; font-weight: 500;">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                                @endif
                            </div>

                            <p style="color: #666; margin: 0; font-size: 0.875rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ Str::limit($annonce->description, 150) }}
                            </p>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #dee2e6;">
                            <div style="color: #666; font-size: 0.875rem;">
                                @if($annonce->publiee_le)
                                    <span>📅 Publiée le {{ $annonce->publiee_le->format('d/m/Y') }}</span>
                                @else
                                    <span>📝 Créée le {{ $annonce->created_at->format('d/m/Y') }}</span>
                                @endif
                                <span style="margin: 0 0.5rem;">•</span>
                                <span>👁️ {{ $annonce->vues }} vue(s)</span>
                                @if($annonce->nb_photos > 0)
                                    <span style="margin: 0 0.5rem;">•</span>
                                    <span>📷 {{ $annonce->nb_photos }} photo(s)</span>
                                @endif
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('annonces.show', $annonce) }}" style="display: inline-block; background: #17a2b8; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                                    Voir
                                </a>
                                <a href="{{ route('annonces.edit', $annonce) }}" style="display: inline-block; background: #ffc107; color: #333; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                                    Modifier
                                </a>
                                @if($annonce->statut === 'brouillon')
                                    <form method="POST" action="{{ route('annonces.publier', $annonce) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: #28a745; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                                            Publier
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('annonces.destroy', $annonce) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
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
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 3rem; text-align: center;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📋</div>
            <h2 style="color: #333; margin-bottom: 0.5rem;">Aucune annonce</h2>
            <p style="color: #666; margin-bottom: 2rem;">Vous n'avez pas encore créé d'annonce.</p>
            <a href="{{ route('annonces.create', ['type' => 'produit']) }}" style="display: inline-block; background: #28a745; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                ➕ Créer ma première annonce
            </a>
        </div>
    @endif
</div>
@endsection

