@extends('layouts.admin')

@section('title', 'Gestion des Critères de Filtrage')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    select:focus, input:focus {
        border-color: #adb1b8 !important;
        box-shadow: 0 0 3px rgba(225,121,9,0.5) !important;
        outline: none;
    }
    .filter-label { font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 4px; display: block; }
    .filter-select { padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; background: #fff; font-size: 0.85rem; color: #111; outline: none; cursor: pointer; }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    Gestion des Critères de Filtrage
                </h1>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.filters.create') }}" 
                       style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                        Nouveau critère de filtrage
                    </a>
                    <a href="javascript:window.print()" 
                       style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Imprimer
                    </a>
                </div>
            </div>

            <!-- Barre de filtres grise -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 0; margin-bottom: 20px;">
                <form action="{{ route('admin.filters.index') }}" method="GET" id="filter-form" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) 250px; gap: 20px; align-items: end;">
                    <input type="hidden" name="per_page" value="{{ $perPage ?? 8 }}">
                    
                    <div>
                        <label class="filter-label">Niveau 1</label>
                        <select name="l1" id="l1_filter" onchange="this.form.submit()" class="filter-select" style="width: 100%;">
                            <option value="">Toutes</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ request('l1') == $parent->id ? 'selected' : '' }}>{{ $parent->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label">Niveau 2</label>
                        <select name="l2" id="l2_filter" onchange="this.form.submit()" class="filter-select" style="width: 100%;" {{ !request('l1') ? 'disabled' : '' }}>
                            <option value="">Toutes</option>
                        </select>
                    </div>

                    <div>
                        <label class="filter-label">Niveau 3</label>
                        <select name="category_id" id="l3_filter" onchange="this.form.submit()" class="filter-select" style="width: 100%;" {{ !request('l2') ? 'disabled' : '' }}>
                            <option value="">Toutes</option>
                        </select>
                    </div>

                    <div style="display: flex; flex-direction: column;">
                        <label class="filter-label">Rechercher</label>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                            placeholder="Nom du critère..."
                            style="padding: 6px 12px; border: 1px solid #adb1b8; border-radius: 0; outline: none; font-size: 0.85rem;">
                    </div>
                </form>
            </div>

            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555; margin-bottom: 15px;">
                <span>Afficher</span>
                <select onchange="const form = document.getElementById('filter-form'); const input = document.createElement('input'); input.type = 'hidden'; input.name = 'per_page'; input.value = this.value; form.appendChild(input); form.submit();" 
                    style="padding: 3px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #f0f2f2; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                    <option value="8" {{ ($perPage ?? 8) == 8 ? 'selected' : '' }}>8</option>
                    <option value="25" {{ ($perPage ?? 8) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ ($perPage ?? 8) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ ($perPage ?? 8) == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>résultats par page</span>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Critère</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 220px;">Catégorie</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Options de filtre</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filters as $filter)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; border-right: 1px solid #e7e7e7;">
                                {{ ucfirst($filter->nom) }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                {{ $filter->category->nom ?? 'N/A' }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                @if(!empty($filter->options))
                                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                        @foreach($filter->options as $option)
                                            <span style="background: #fdf2f2; color: #111; padding: 1px 8px; border-radius: 0; font-size: 0.75rem; border: 1px solid #adb1b8;">
                                                {{ $option }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="color: #999; font-style: italic; font-size: 0.8rem;">Aucune option définie</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.filters.edit', $filter) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                       onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                       Modifier
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <form action="{{ route('admin.filters.toggle-status', $filter) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" 
                                                style="background: none; border: none; color: #0066c0; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                                onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                            {{ $filter->is_filterable ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>
                                    <span style="color: #ddd;">|</span>
                                    <form id="delete-form-{{ $filter->id }}" action="{{ route('admin.filters.destroy', $filter) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $filter->id }})" 
                                                style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.textDecoration='underline'" 
                                                onmouseout="this.style.textDecoration='none'">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucun critère de filtrage trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links Harmonisée -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $filters->firstItem() ?? 0 }} à {{ $filters->lastItem() ?? 0 }} sur {{ $filters->total() }} résultats
                </div>
                <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                    @if($filters->onFirstPage())
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                    @else
                        <a href="{{ $filters->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                    @endif

                    @php
                        $fStart = max(1, $filters->currentPage() - 2);
                        $fEnd = min($filters->lastPage(), $fStart + 4);
                    @endphp

                    @for($i = $fStart; $i <= $fEnd; $i++)
                        @if($i == $filters->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); color: #111; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #a88734;">{{ $i }}</span>
                        @else
                            <a href="{{ $filters->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($filters->hasMorePages())
                        <a href="{{ $filters->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                    @else
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
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
                borderRadius: '0'
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
