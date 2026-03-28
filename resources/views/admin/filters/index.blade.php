@extends('layouts.admin')

@section('title', 'Gestion des Critères de Filtrage')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Critères & Attributs</span>
@endsection

@section('content')
    <div style="max-width: 900px;">

        <!-- Header avec bouton -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">Critéres de filtrage</h1>
            <a href="{{ route('admin.filters.create') }}"
                style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #000; color: #fff; border-radius: 8px; transition: all 0.2s;" 
                title="Ajouter un critère"
                onmouseover="this.style.opacity='0.8'" 
                onmouseout="this.style.opacity='1'">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
            </a>
        </div>

        <!-- Filtres de recherche -->
        <div style="background: #fff; border: 1px solid #e5e5e5; padding: 1rem; margin-bottom: 1rem;">
            <form action="{{ route('admin.filters.index') }}" method="GET" id="filter-form">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1rem; align-items: end;">
                    <!-- Niveau 1 -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; color: #666; margin-bottom: 4px;">Catégorie</label>
                        <select name="l1" id="l1_filter" onchange="this.form.submit()" style="width: 100%; padding: 8px; border: 1px solid #e5e5e5; border-radius: 4px; font-size: 0.85rem;">
                            <option value="">-- Toutes --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ request('l1') == $parent->id ? 'selected' : '' }}>{{ $parent->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Niveau 2 -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; color: #666; margin-bottom: 4px;">Sous-catégorie</label>
                        <select name="l2" id="l2_filter" onchange="this.form.submit()" style="width: 100%; padding: 8px; border: 1px solid #e5e5e5; border-radius: 4px; font-size: 0.85rem;" {{ !request('l1') ? 'disabled' : '' }}>
                            <option value="">-- Toutes --</option>
                        </select>
                    </div>
                    <!-- Niveau 3 -->
                    <div>
                        <label style="display: block; font-size: 0.75rem; color: #666; margin-bottom: 4px;">Précision</label>
                        <select name="category_id" id="l3_filter" onchange="this.form.submit()" style="width: 100%; padding: 8px; border: 1px solid #e5e5e5; border-radius: 4px; font-size: 0.85rem;" {{ !request('l2') ? 'disabled' : '' }}>
                            <option value="">-- Toutes --</option>
                        </select>
                    </div>
                    <!-- Actions -->
                    <div style="display: flex; gap: 8px;">
                        @if(request()->anyFilled(['l1', 'l2', 'category_id']))
                            <a href="{{ route('admin.filters.index') }}" style="padding: 8px 12px; background: #f1f5f9; color: #333; border-radius: 4px; font-size: 0.85rem; text-decoration: none;">Réinitialiser</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5;">
                <span style="font-size: 0.8rem; color: #666;">{{ $filters->total() }} critère(s)</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    @forelse($filters as $filter)
                        <tr style="border-bottom: 1px solid #e5e5e5;">
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="font-size: 0.875rem; color: #333; font-weight: 500;">{{ $filter->nom }}</div>
                                <span style="font-size: 0.75rem; color: #666; background: #f8fafc; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                    {{ $filter->category->parent->parent->nom ?? '' }} 
                                    {!! $filter->category->parent ? '<span style="color: #94a3b8; font-size: 0.6rem; margin: 0 4px;">&gt;</span>' : '' !!}
                                    {{ $filter->category->parent->nom ?? '' }}
                                    {!! $filter->category ? '<span style="color: #94a3b8; font-size: 0.6rem; margin: 0 4px;">&gt;</span>' : '' !!}
                                    <span style="color: #000; font-weight: 600;">{{ $filter->category->nom }}</span>
                                </span>
                            </td>
                            <td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 4px;">
                                <a href="{{ route('admin.filters.show', $filter) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #1e293b; background: #f1f5f9; border-radius: 8px; transition: all 0.2s;" 
                                   title="Voir"
                                   onmouseover="this.style.background='#e2e8f0'; this.style.opacity='0.8'" 
                                   onmouseout="this.style.background='#f1f5f9'; this.style.opacity='1'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <a href="{{ route('admin.filters.edit', $filter) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #004aad; background: #eef2ff; border-radius: 8px; transition: all 0.2s;" 
                                   title="Modifier"
                                   onmouseover="this.style.background='#e0e7ff'; this.style.opacity='0.8'" 
                                   onmouseout="this.style.background='#eef2ff'; this.style.opacity='1'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.filters.destroy', $filter) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce critère ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #ef4444; background: #fff1f2; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                                            title="Supprimer"
                                            onmouseover="this.style.background='#ffe4e6'; this.style.transform='scale(1.05)'" 
                                            onmouseout="this.style.background='#fff1f2'; this.style.transform='scale(1)'">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2"
                                style="padding: 3rem 1.25rem; text-align: center; color: #999; font-size: 0.875rem;">
                                Aucun critère
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div style="padding: 1rem; border-top: 1px solid #e5e5e5;">
                {{ $filters->links('admin.pagination') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const l1Select = document.getElementById('l1_filter');
    const l2Select = document.getElementById('l2_filter');
    const l3Select = document.getElementById('l3_filter');

    const initialL2Id = "{{ request('l2') }}";
    const initialL3Id = "{{ request('category_id') }}";

    function fetchChildren(parentId, targetSelect, placeholder, selectedId = null) {
        if (!parentId) {
            targetSelect.innerHTML = `<option value="">-- ${placeholder} --</option>`;
            targetSelect.disabled = true;
            return Promise.resolve();
        }
        
        return fetch(`/admin/filters/categories/${parentId}/children`)
            .then(response => response.json())
            .then(data => {
                targetSelect.innerHTML = `<option value="">-- ${placeholder} --</option>`;
                data.forEach(child => {
                    const option = document.createElement('option');
                    option.value = child.id;
                    option.textContent = child.nom;
                    if (selectedId && child.id == selectedId) {
                        option.selected = true;
                    }
                    targetSelect.appendChild(option);
                });
                targetSelect.disabled = false;
            });
    }

    l1Select.addEventListener('change', function() {
        fetchChildren(this.value, l2Select, 'Toutes');
        l3Select.innerHTML = '<option value="">-- Toutes --</option>';
        l3Select.disabled = true;
    });

    l2Select.addEventListener('change', function() {
        fetchChildren(this.value, l3Select, 'Toutes');
    });

    // Initial load
    if (l1Select.value) {
        fetchChildren(l1Select.value, l2Select, 'Toutes', initialL2Id)
            .then(() => {
                if (l2Select.value) {
                    fetchChildren(l2Select.value, l3Select, 'Toutes', initialL3Id);
                }
            });
    }
});
</script>
@endpush
