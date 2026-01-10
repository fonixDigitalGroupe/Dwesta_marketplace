@extends('layouts.app')

@section('title', 'Gestion des Catégories')

@section('content')
<div style="max-width: 1200px; margin: 3rem auto; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <h1 style="color: #333; margin: 0;">Gestion des Catégories</h1>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('admin.categories.create') }}" style="display: inline-block; background: #EF3B2D; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                    + Nouvelle catégorie
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

        @if($categories->count() > 0)
            <div style="display: grid; gap: 1.5rem;">
                @foreach($categories as $categorie)
                    <div style="border: 1px solid #dee2e6; border-radius: 8px; padding: 1.5rem; background: #f8f9fa;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                @if($categorie->icone)
                                    <span style="font-size: 1.5rem;">📁</span>
                                @endif
                                <div>
                                    <h3 style="color: #333; margin: 0; font-size: 1.25rem;">
                                        <a href="{{ route('admin.categories.show', $categorie) }}" style="color: #333; text-decoration: none;">
                                            {{ $categorie->nom }}
                                        </a>
                                    </h3>
                                    @if($categorie->description)
                                        <p style="color: #666; margin: 0.25rem 0 0 0; font-size: 0.875rem;">{{ $categorie->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                @if(!$categorie->actif)
                                    <span style="background: #6c757d; color: white; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 500;">
                                        Inactive
                                    </span>
                                @endif
                                <a href="{{ route('admin.categories.edit', $categorie) }}" style="display: inline-block; background: #17a2b8; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                                    Modifier
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $categorie) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($categorie->enfants->count() > 0)
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #dee2e6;">
                                <strong style="color: #666; font-size: 0.875rem; display: block; margin-bottom: 0.75rem;">Sous-catégories :</strong>
                                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 0.75rem;">
                                    @foreach($categorie->enfants as $enfant)
                                        <div style="background: white; padding: 0.75rem; border-radius: 4px; border: 1px solid #dee2e6;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem;">
                                                <div style="flex: 1; min-width: 0;">
                                                    <a href="{{ route('admin.categories.show', $enfant) }}" style="color: #333; text-decoration: none; font-weight: 500; display: block; margin-bottom: 0.25rem;">
                                                        {{ $enfant->nom }}
                                                    </a>
                                                    @if(!$enfant->actif)
                                                        <span style="color: #6c757d; font-size: 0.75rem;">(Inactive)</span>
                                                    @endif
                                                </div>
                                                <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                                                    <a href="{{ route('admin.categories.edit', $enfant) }}" style="display: inline-block; background: #17a2b8; color: white; padding: 0.4rem 0.75rem; text-decoration: none; border-radius: 4px; font-size: 0.75rem; font-weight: 500; white-space: nowrap;">
                                                        Modifier
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.categories.destroy', $enfant) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer la catégorie « {{ $enfant->nom }} » et toutes ses sous-catégories ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.4rem 0.75rem; border-radius: 4px; font-size: 0.75rem; cursor: pointer; font-weight: 500; white-space: nowrap;">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            {{-- Afficher les sous-catégories de niveau 2 --}}
                                            @if($enfant->enfants->count() > 0)
                                                <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #e9ecef; padding-left: 0.5rem;">
                                                    @foreach($enfant->enfants as $petitEnfant)
                                                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; padding: 0.5rem; background: #f8f9fa; border-radius: 4px;">
                                                            <div style="flex: 1; min-width: 0;">
                                                                <a href="{{ route('admin.categories.show', $petitEnfant) }}" style="color: #333; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                                                    — {{ $petitEnfant->nom }}
                                                                </a>
                                                                @if(!$petitEnfant->actif)
                                                                    <span style="color: #6c757d; font-size: 0.7rem;">(Inactive)</span>
                                                                @endif
                                                            </div>
                                                            <div style="display: flex; gap: 0.25rem; flex-shrink: 0;">
                                                                <a href="{{ route('admin.categories.edit', $petitEnfant) }}" style="display: inline-block; background: #17a2b8; color: white; padding: 0.25rem 0.5rem; text-decoration: none; border-radius: 3px; font-size: 0.7rem; font-weight: 500;">
                                                                    Modifier
                                                                </a>
                                                                <form method="POST" action="{{ route('admin.categories.destroy', $petitEnfant) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer la catégorie « {{ $petitEnfant->nom }} » et toutes ses sous-catégories ?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.7rem; cursor: pointer; font-weight: 500;">
                                                                        Supprimer
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: #666;">
                <p style="font-size: 1.125rem; margin-bottom: 0.5rem;">Aucune catégorie créée</p>
                <a href="{{ route('admin.categories.create') }}" style="display: inline-block; background: #EF3B2D; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; margin-top: 1rem; font-weight: 500;">
                    Créer la première catégorie
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

