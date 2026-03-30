@extends('layouts.admin')

@section('title', 'Gestion des Critères de Filtrage')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    select:focus, input:focus {
        border-color: #aaa !important;
        box-shadow: 0 0 0 2px rgba(0,0,0,0.05) !important;
        outline: none;
    }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">

        <!-- Titre en majuscules type image -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            Gestion des Critères de Filtrage
        </h2>

        <!-- Barre d'outils type image -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.filters.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                Liste des critères <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
            <a href="{{ route('admin.filters.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; text-decoration: none; transition: opacity 0.2s;">
                Nouveau critère <i class="fas fa-plus-square"></i>
            </a>
        </div>


        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1rem;">
            
            <!-- Filtres type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #333;">
                    <form action="{{ route('admin.filters.index') }}" method="GET" id="filter-form" style="display: flex; align-items: center; gap: 10px;">
                        <div>
                            Afficher 
                            <select name="per_page" onchange="this.form.submit()" 
                                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                <option value="8" {{ ($perPage ?? 8) == 8 ? 'selected' : '' }}>8</option>
                                <option value="50" {{ ($perPage ?? 8) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ ($perPage ?? 8) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            lignes
                        </div>

                        <input type="hidden" name="search" value="{{ $search ?? '' }}">
                        
                        <div>
                            Cat N1: 
                            <select name="l1" id="l1_filter" onchange="this.form.submit()" 
                                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                <option value="">Toutes</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ request('l1') == $parent->id ? 'selected' : '' }}>{{ $parent->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            Cat N2: 
                            <select name="l2" id="l2_filter" onchange="this.form.submit()" 
                                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'" {{ !request('l1') ? 'disabled' : '' }}>
                                <option value="">Toutes</option>
                            </select>
                        </div>

                        <div>
                            Cat N3: 
                            <select name="category_id" id="l3_filter" onchange="this.form.submit()" 
                                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'" {{ !request('l2') ? 'disabled' : '' }}>
                                <option value="">Toutes</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div style="font-size: 0.85rem; color: #333;">
                    <form action="{{ route('admin.filters.index') }}" method="GET" style="display: flex; align-items: center;">
                        <input type="hidden" name="per_page" value="{{ $perPage ?? 8 }}">
                        <input type="hidden" name="l1" value="{{ request('l1') }}">
                        <input type="hidden" name="l2" value="{{ request('l2') }}">
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        Chercher: <input type="text" name="search" value="{{ $search ?? '' }}" 
                            placeholder="Tapez et Entrée..."
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; outline: none; margin-left: 5px; background-color: #fff; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 250px;">Filtre</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Options de filtre</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filters as $filter)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                <div style="font-weight: 600; color: #333; margin-bottom: 2px;">{{ $filter->nom }}</div>
                                <div style="font-size: 0.75rem; color: #888;">{{ $filter->slug }}</div>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                @if(!empty($filter->options))
                                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                        @foreach($filter->options as $option)
                                            <span style="background: #fff7ed; color: #c2410c; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; border: 1px solid #fdba74;">
                                                {{ $option }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="color: #ccc; font-style: italic;">Aucune option</span>
                                @endif
                                <div style="margin-top: 8px; font-size: 0.7rem; color: #999;">
                                    Catégorie: {{ $filter->category->nom ?? 'N/A' }}
                                </div>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                    <a href="{{ route('admin.filters.edit', $filter) }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #004aad; color: #fff; border-radius: 3px; font-size: 0.75rem; text-decoration: none;" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $filter->id }}" action="{{ route('admin.filters.destroy', $filter) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $filter->id }})" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #e74c3c; color: #fff; border-radius: 3px; font-size: 0.75rem; border: none; cursor: pointer;" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">Aucun critère trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <div style="font-size: 0.85rem; color: #666;">
                    Affichage de {{ $filters->firstItem() ?? 0 }} à {{ $filters->lastItem() ?? 0 }} sur {{ $filters->total() }} éléments
                </div>
                <div style="display: flex; gap: 0; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                    @if($filters->onFirstPage())
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem; border-right: 1px solid #ddd;">Prec</span>
                    @else
                        <a href="{{ $filters->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">Prec</a>
                    @endif

                    @foreach(range(1, $filters->lastPage()) as $i)
                        @if($i == $filters->currentPage())
                            <span style="padding: 6px 12px; background: #e67e00; color: #fff; font-size: 0.85rem; border-right: 1px solid #ddd;">{{ $i }}</span>
                        @else
                            <a href="{{ $filters->url($i) }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($filters->hasMorePages())
                        <a href="{{ $filters->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none;">Suiv</a>
                    @else
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem;">Suiv</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e67e00',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                borderRadius: '8px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        document.addEventListener('DOMContentLoaded', function() {
            const l1Select = document.getElementById('l1_filter');
            const l2Select = document.getElementById('l2_filter');
            const l3Select = document.getElementById('l3_filter');

            const initialL2Id = "{{ request('l2') }}";
            const initialL3Id = "{{ request('category_id') }}";

            function fetchChildren(parentId, targetSelect, placeholder, selectedId = null) {
                if (!parentId) {
                    targetSelect.innerHTML = `<option value="">${placeholder}</option>`;
                    targetSelect.disabled = true;
                    return Promise.resolve();
                }
                
                return fetch(`/admin/filters/categories/${parentId}/children`)
                    .then(response => response.json())
                    .then(data => {
                        targetSelect.innerHTML = `<option value="">${placeholder}</option>`;
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
                l3Select.innerHTML = '<option value="">Toutes</option>';
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
@endsection
