@extends('layouts.app')

@section('title', 'Modifier la Catégorie - ' . $category->nom)

@section('content')
<div style="max-width: 800px; margin: 3rem auto; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('admin.categories.index') }}" style="display: inline-block; color: #EF3B2D; text-decoration: none; margin-bottom: 1rem; font-weight: 500;">
                ← Retour à la liste
            </a>
            <h1 style="color: #333; margin-top: 0;">Modifier la Catégorie</h1>
        </div>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Nom de la catégorie <span style="color: #EF3B2D;">*</span></label>
                <input type="text" name="nom" value="{{ old('nom', $category->nom) }}" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('nom')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Catégorie parente</label>
                <select name="parent_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                    <option value="">Aucune (Catégorie principale)</option>
                    @php
                        function formatCategoryOptionEdit($category, $level = 0) {
                            $prefix = str_repeat('— ', $level);
                            return $prefix . $category->nom;
                        }
                        function buildCategoryTreeEdit($categories, $parentId = null, $level = 0) {
                            $result = [];
                            foreach ($categories as $category) {
                                if ($category->parent_id == $parentId) {
                                    $result[] = ['category' => $category, 'level' => $level];
                                    $children = buildCategoryTreeEdit($categories, $category->id, $level + 1);
                                    $result = array_merge($result, $children);
                                }
                            }
                            return $result;
                        }
                        $categoryTree = buildCategoryTreeEdit($categories);
                    @endphp
                    @foreach($categoryTree as $item)
                        <option value="{{ $item['category']->id }}" {{ old('parent_id', $category->parent_id) == $item['category']->id ? 'selected' : '' }}>
                            {{ formatCategoryOptionEdit($item['category'], $item['level']) }}
                        </option>
                    @endforeach
                </select>
                <small style="color: #666; font-size: 0.875rem;">Sélectionnez une catégorie parente (une sous-catégorie peut aussi être parent)</small>
                @error('parent_id')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Description</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Icône</label>
                <input type="text" name="icone" value="{{ old('icone', $category->icone) }}" placeholder="shopping-bag, car, home, etc." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                <small style="color: #666; font-size: 0.875rem;">Nom de l'icône (FontAwesome, emoji, etc.)</small>
                @error('icone')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Ordre d'affichage</label>
                <input type="number" name="ordre" value="{{ old('ordre', $category->ordre) }}" min="0" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                <small style="color: #666; font-size: 0.875rem;">Plus le nombre est petit, plus la catégorie apparaîtra en premier</small>
                @error('ordre')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; color: #333; cursor: pointer;">
                    <input type="checkbox" name="actif" value="1" {{ old('actif', $category->actif) ? 'checked' : '' }} style="margin-right: 0.5rem;">
                    <span>Catégorie active</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="flex: 1; background: #EF3B2D; color: white; border: none; padding: 0.75rem; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer;">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.categories.index') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; text-align: center; font-weight: 500;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

