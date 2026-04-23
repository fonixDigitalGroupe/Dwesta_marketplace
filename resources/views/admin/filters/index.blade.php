@extends('layouts.admin')

@section('title', 'Gestion des Critères de Filtrage')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    select:focus, input:focus {
        border-color: #e67e00 !important;
        box-shadow: 0 0 0 2px rgba(230,126,0,0.05) !important;
        outline: none;
    }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
            
            <div style="margin-bottom: 0.5rem;">
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Gestion des Critères de Filtrage</h1>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1rem;"></div>

            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 1rem;">
                <a href="{{ route('admin.filters.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Nouveau critère <i class="fas fa-plus-square"></i>
                </a>
                <a href="javascript:window.print()" style="display: flex; align-items: center; gap: 8px; background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Imprimer <i class="fas fa-print"></i>
                </a>
            </div>

            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1rem;"></div>

            <!-- Barre d'outils (Filtres) -->
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                <form action="{{ route('admin.filters.index') }}" method="GET" id="filter-form" style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                    <div style="font-size: 0.85rem; color: #333;">
                        Niveau 1: 
                        <select name="l1" id="l1_filter" onchange="this.form.submit()" 
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s; min-width: 150px; font-size: 0.85rem;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                            <option value="">Toutes</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ request('l1') == $parent->id ? 'selected' : '' }}>{{ $parent->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="font-size: 0.85rem; color: #333;">
                        Niveau 2: 
                        <select name="l2" id="l2_filter" onchange="this.form.submit()" 
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s; min-width: 150px; font-size: 0.85rem;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'" {{ !request('l1') ? 'disabled' : '' }}>
                            <option value="">Toutes</option>
                        </select>
                    </div>

                    <div style="font-size: 0.85rem; color: #333;">
                        Niveau 3: 
                        <select name="category_id" id="l3_filter" onchange="this.form.submit()" 
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s; min-width: 150px; font-size: 0.85rem;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'" {{ !request('l2') ? 'disabled' : '' }}>
                            <option value="">Toutes</option>
                        </select>
                    </div>
                </form>

                <div style="border-bottom: 1px solid #f3f3f3;"></div>

                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #333;">
                        <div>
                            Afficher 
                            <select onchange="const form = document.getElementById('filter-form'); const input = document.createElement('input'); input.type = 'hidden'; input.name = 'per_page'; input.value = this.value; form.appendChild(input); form.submit();"
                                style="padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s; min-width: 60px;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                <option value="8" {{ ($perPage ?? 8) == 8 ? 'selected' : '' }}>8</option>
                                <option value="50" {{ ($perPage ?? 8) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ ($perPage ?? 8) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            lignes
                        </div>
                    </div>

                    <div style="font-size: 0.85rem; color: #333;">
                        <form action="{{ route('admin.filters.index') }}" method="GET" style="display: flex; align-items: center;">
                            @if(request('l1')) <input type="hidden" name="l1" value="{{ request('l1') }}"> @endif
                            @if(request('l2')) <input type="hidden" name="l2" value="{{ request('l2') }}"> @endif
                            @if(request('category_id')) <input type="hidden" name="category_id" value="{{ request('category_id') }}"> @endif
                            @if(isset($perPage)) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
                            Chercher: <input type="text" name="search" value="{{ $search ?? '' }}" 
                                placeholder="Tapez et Entrée..."
                                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; outline: none; margin-left: 5px; background-color: #fff; transition: all 0.2s; font-size: 0.85rem; min-width: 200px;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 12px 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 200px;">Critère</th>
                        <th style="padding: 12px 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 180px;">Catégorie</th>
                        <th style="padding: 12px 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Options de filtre</th>
                        <th style="padding: 12px 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filters as $filter)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; vertical-align: top;">
                                <div style="font-weight: 600; color: #333; text-transform: capitalize;">{{ $filter->nom }}</div>
                            </td>
                            <td style="padding: 12px 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; vertical-align: top;">
                                {{ $filter->category->nom ?? 'N/A' }}
                            </td>
                            <td style="padding: 12px 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555;">
                                @if(!empty($filter->options))
                                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                        @foreach($filter->options as $option)
                                            <span style="background: #fff7ed; color: #e67e00; padding: 2px 10px; border-radius: 4px; font-size: 0.75rem; border: 1px solid #fdba74; font-weight: 500;">
                                                {{ $option }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="color: #ccc; font-style: italic; font-size: 0.8rem;">Aucune option</span>
                                @endif
                            </td>
                            <td style="padding: 12px 10px; border: 1px solid #eee; text-align: right; vertical-align: top;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <a href="{{ route('admin.filters.edit', $filter) }}" 
                                       style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #eff6ff; color: #2563eb; border-radius: 6px; font-size: 0.8rem; text-decoration: none; border: 1px solid #dbeafe; transition: all 0.2s;" 
                                       onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form id="status-form-{{ $filter->id }}" action="{{ route('admin.filters.toggle-status', $filter) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmStatus({{ $filter->id }}, {{ $filter->is_filterable ? 'true' : 'false' }})" 
                                                style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: {{ $filter->is_filterable ? '#fff7ed' : '#f0fdf4' }}; color: {{ $filter->is_filterable ? '#c2410c' : '#15803d' }}; border-radius: 6px; font-size: 0.8rem; border: 1px solid {{ $filter->is_filterable ? '#ffedd5' : '#dcfce7' }}; cursor: pointer; transition: all 0.2s;" 
                                                onmouseover="this.style.background='{{ $filter->is_filterable ? '#ffedd5' : '#dcfce7' }}'" onmouseout="this.style.background='{{ $filter->is_filterable ? '#fff7ed' : '#f0fdf4' }}'"
                                                title="{{ $filter->is_filterable ? 'Suspendre' : 'Activer' }}">
                                            <i class="fas fa-{{ $filter->is_filterable ? 'lock' : 'lock-open' }}"></i>
                                        </button>
                                    </form>

                                    <form id="delete-form-{{ $filter->id }}" action="{{ route('admin.filters.destroy', $filter) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $filter->id }})" 
                                                style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fef2f2; color: #dc2626; border-radius: 6px; font-size: 0.8rem; border: 1px solid #fee2e2; cursor: pointer; transition: all 0.2s;" 
                                                onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 3rem; text-align: center; color: #999; font-size: 0.85rem;">Aucun critère trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                <div style="font-size: 0.85rem; color: #666;">
                    ligne {{ $filters->firstItem() ?? 0 }} sur {{ $filters->total() }}
                </div>
                <div style="display: flex; gap: 0; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    @if($filters->onFirstPage())
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem; border-right: 1px solid #ddd; cursor: not-allowed;">Prec</span>
                    @else
                        <a href="{{ $filters->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">Prec</a>
                    @endif

                    @php
                        $start = max(1, $filters->currentPage() - 2);
                        $end = min($filters->lastPage(), $start + 4);
                        if ($end - $start < 4) {
                            $start = max(1, $end - 4);
                        }
                    @endphp

                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $filters->currentPage())
                            <span style="padding: 6px 12px; background: #eff6ff; color: #2563eb; font-weight: 700; font-size: 0.85rem; border-right: 1px solid #ddd;">{{ $i }}</span>
                        @else
                            <a href="{{ $filters->url($i) }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($filters->hasMorePages())
                        <a href="{{ $filters->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">Suiv</a>
                    @else
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem; cursor: not-allowed;">Suiv</span>
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

        function confirmStatus(id, isFilterable) {
            const actionText = isFilterable ? 'suspendre' : 'activer';
            const actionColor = isFilterable ? '#ea580c' : '#16a34a';
            
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `Voulez-vous vraiment ${actionText} ce critère de filtrage ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: actionColor,
                cancelButtonColor: '#64748b',
                confirmButtonText: `Oui, ${actionText} !`,
                cancelButtonText: 'Annuler',
                borderRadius: '8px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('status-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
@endsection
