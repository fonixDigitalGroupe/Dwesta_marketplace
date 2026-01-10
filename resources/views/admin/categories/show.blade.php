@extends('layouts.app')

@section('title', 'Catégorie - ' . $category->nom)

@section('content')
<div style="max-width: 800px; margin: 3rem auto; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('admin.categories.index') }}" style="display: inline-block; color: #EF3B2D; text-decoration: none; margin-bottom: 1rem; font-weight: 500;">
                ← Retour à la liste
            </a>
            <h1 style="color: #333; margin-top: 0;">{{ $category->nom }}</h1>
        </div>

        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Slug :</strong>
                    <span style="color: #333;">{{ $category->slug }}</span>
                </div>
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Statut :</strong>
                    @if($category->actif)
                        <span style="color: #28a745; font-weight: 500;">✓ Active</span>
                    @else
                        <span style="color: #6c757d; font-weight: 500;">Inactive</span>
                    @endif
                </div>
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Ordre :</strong>
                    <span style="color: #333;">{{ $category->ordre }}</span>
                </div>
                @if($category->parent)
                    <div>
                        <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Catégorie parente :</strong>
                        <a href="{{ route('admin.categories.show', $category->parent) }}" style="color: #EF3B2D; text-decoration: none;">
                            {{ $category->parent->nom }}
                        </a>
                    </div>
                @else
                    <div>
                        <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Type :</strong>
                        <span style="color: #333;">Catégorie principale</span>
                    </div>
                @endif
            </div>

            @if($category->description)
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #dee2e6;">
                    <strong style="color: #666; display: block; margin-bottom: 0.5rem;">Description :</strong>
                    <p style="color: #333; margin: 0;">{{ $category->description }}</p>
                </div>
            @endif

            @if($category->icone)
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #dee2e6;">
                    <strong style="color: #666; display: block; margin-bottom: 0.5rem;">Icône :</strong>
                    <span style="font-size: 2rem;">{{ $category->icone }}</span>
                </div>
            @endif
        </div>

        @if($category->enfants->count() > 0)
            <div style="margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem;">Sous-catégories ({{ $category->enfants->count() }})</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                    @foreach($category->enfants as $enfant)
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 4px; border: 1px solid #dee2e6;">
                            <a href="{{ route('admin.categories.show', $enfant) }}" style="color: #333; text-decoration: none; font-weight: 500;">
                                {{ $enfant->nom }}
                            </a>
                            @if(!$enfant->actif)
                                <span style="color: #6c757d; font-size: 0.75rem; margin-left: 0.5rem;">(Inactive)</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div style="display: flex; gap: 1rem; padding-top: 2rem; border-top: 1px solid #dee2e6;">
            <a href="{{ route('admin.categories.edit', $category) }}" style="display: inline-block; background: #17a2b8; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                Modifier
            </a>
            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 500; cursor: pointer;">
                    Supprimer
                </button>
            </form>
            <a href="{{ route('admin.categories.index') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection

