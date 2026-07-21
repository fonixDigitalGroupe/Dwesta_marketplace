@extends('layouts.admin')

@section('title', 'Gestion des Critères')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        select:focus,
        input:focus {
            border-color: #adb1b8 !important;
            outline: none;
        }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
            border: 1px solid #1e40af;
            color: #fff;
            padding: 6px 14px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #1d4ed8 0%, #1e3a8a 100%);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            color: #fff;
        }

        .btn-amazon-secondary {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 6px 14px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-amazon-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #1e293b;
        }

        .badge-amazon {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 12px;
        }

        .badge-amazon-success {
            color: #569b00;
            background: #f7fff0;
        }

        .badge-amazon-danger {
            color: #c40000;
            background: #fff5f5;
        }
        
        .filter-label {
            font-size: 0.8rem;
            color: #555;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .filter-select {
            padding: 6px 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: #fff;
            font-size: 0.85rem;
            color: #111;
            outline: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-select:focus {
            border-color: #ff9900 !important;
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15);
        }

        @media print {
            .sidebar, .navbar, .settings-tabs, .filters-bar, .actions-column, .pagination-container, .btn-amazon-primary, .btn-amazon-secondary, .admin-sub-header, header, footer {
                display: none !important;
            }
            .main-content {
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }
        }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
    <div style="max-width: 1600px; margin: 0 auto; width: 100%; padding-top: 0;">

        <!-- Main Card -->
        <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                        <i class="fas fa-filter" style="font-size: 0.8rem;"></i>
                        <span style="line-height: 1;">Gestion des Critères</span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.filters.create') }}" class="btn-amazon-primary">
                        <i class="fas fa-plus"></i> Nouveau critère de filtrage
                    </a>
                </div>
            </div>

            <!-- Barre de filtre -->
            <div class="filters-bar"
                style="background: #f8fafc; border: 1px solid #eff3f6; padding: 15px 16px; border-radius: 4px; margin-bottom: 20px;">
                
                <!-- Sélection des catégories par niveau -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label class="filter-label">Niveau 1</label>
                        <select id="l1_filter" class="filter-select" style="width: 100%;"
                            onchange="applyFilter('l1', this.value)">
                            <option value="">Sélectionner une catégorie L1</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ request('l1') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Niveau 2</label>
                        <select id="l2_filter" class="filter-select" style="width: 100%;"
                            onchange="applyFilter('l2', this.value)" {{ !request('l1') ? 'disabled' : '' }}>
                            <option value="">Sélectionner une catégorie L2</option>
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Niveau 3</label>
                        <select id="l3_filter" class="filter-select" style="width: 100%;"
                            onchange="applyFilter('category_id', this.value)" {{ !request('l2') ? 'disabled' : '' }}>
                            <option value="">Sélectionner une catégorie L3</option>
                        </select>
                    </div>
                </div>
                
                <!-- Recherche -->
                <form action="{{ route('admin.filters.index') }}" method="GET" style="display: flex; gap: 15px; align-items: center; position: relative;">
                    @if(request('l1')) <input type="hidden" name="l1" value="{{ request('l1') }}"> @endif
                    @if(request('l2')) <input type="hidden" name="l2" value="{{ request('l2') }}"> @endif
                    @if(request('category_id')) <input type="hidden" name="category_id" value="{{ request('category_id') }}"> @endif
                    


                    <div style="display: flex; flex: 1; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un critère..."
                            style="padding: 10px 16px; border: none; outline: none; flex: 1; font-size: 0.9rem; background: transparent;"
                            onfocus="document.getElementById('search-container').style.borderColor='#ff9900'; document.getElementById('search-container').style.boxShadow='0 0 0 3px rgba(255, 153, 0, 0.15)'"
                            onblur="document.getElementById('search-container').style.borderColor='#dee2e6'; document.getElementById('search-container').style.boxShadow='none'">
                        
                        <button type="submit" 
                            style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: none; color: #fff; padding: 0 22px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                            onmouseover="this.style.background='linear-gradient(180deg, #f08804 0%, #d87300 100%)'"
                            onmouseout="this.style.background='linear-gradient(180deg, #ff9900 0%, #e77600 100%)'">
                            <i class="fas fa-search" style="font-size: 1.1rem; text-shadow: 0 1px 1px rgba(0,0,0,0.1);"></i>
                        </button>
                    </div>
                    
                    @if(request('search') || request('l1') || request('l2') || request('category_id'))
                        <a href="{{ route('admin.filters.index') }}" 
                           style="color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                           onmouseover="this.style.textDecoration='underline'"
                           onmouseout="this.style.textDecoration='none'">
                           Effacer les filtres
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Critère</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 220px;">Catégorie</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Options de filtre</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 120px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 180px;" class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filters as $filter)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; border-right: 1px solid #eff3f6;">
                                {{ ucfirst($filter->nom) }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #eff3f6;">
                                {{ $filter->category->nom ?? 'N/A' }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #eff3f6;">
                                @if(!empty($filter->options))
                                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                        @foreach($filter->options as $option)
                                            <span style="background: #f8fafc; color: #475569; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; border: 1px solid #e2e8f0;">
                                                {{ $option }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="color: #999; font-style: italic; font-size: 0.8rem;">Aucune option définie</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <form action="{{ route('admin.filters.toggle-status', $filter) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                                        <span class="badge-amazon {{ $filter->is_filterable ? 'badge-amazon-success' : 'badge-amazon-danger' }}">
                                            {{ $filter->is_filterable ? 'Actif' : 'Suspendu' }}
                                        </span>
                                    </button>
                                </form>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;" class="actions-column">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.filters.edit', $filter) }}" title="Modifier"
                                        style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; color: #111; text-decoration: none; transition: background 0.2s;"
                                        onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'"><i class="fas fa-pen-to-square" style="font-size: 0.95rem;"></i></a>
                                    <form id="delete-form-{{ $filter->id }}"
                                        action="{{ route('admin.filters.destroy', $filter) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $filter->id }})" title="Supprimer"
                                            style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; background: none; border: none; color: #c40000; cursor: pointer; transition: background 0.2s;"
                                            onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'"><i class="fas fa-trash" style="font-size: 0.9rem;"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucun critère de filtrage trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links -->
            @if($filters->total() > 0)
                <div class="pagination-container"
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        <strong>{{ $filters->total() }}</strong> lignes
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($filters->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $filters->previousPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">Précédent</a>
                        @endif

                        @foreach(range(max(1, $filters->currentPage() - 2), min($filters->lastPage(), $filters->currentPage() + 2)) as $i)
                            @if($i == $filters->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1e40af; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $filters->url($i) }}"
                                    style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                    onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                    onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if($filters->hasMorePages())
                            <a href="{{ $filters->nextPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function applyFilter(key, value) {
                const url = new URL(window.location.href);
                if (value) {
                    url.searchParams.set(key, value);
                    if (key === 'l1') {
                        url.searchParams.delete('l2');
                        url.searchParams.delete('category_id');
                    } else if (key === 'l2') {
                        url.searchParams.delete('category_id');
                    }
                } else {
                    url.searchParams.delete(key);
                    if (key === 'l1') {
                        url.searchParams.delete('l2');
                        url.searchParams.delete('category_id');
                    } else if (key === 'l2') {
                        url.searchParams.delete('category_id');
                    }
                }
                // Reset to page 1 on filter
                url.searchParams.delete('page');
                window.location.href = url.toString();
            }

            // Pour valider la perte de "confirmDelete" s'il est pas défini globalment
            function confirmDelete(id) {
                if (confirm('Voulez-vous vraiment supprimer ce critère ?')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
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

                l1Select.addEventListener('change', function () {
                    if (!this.value) {
                        l2Select.innerHTML = '<option value="">Sélectionner une catégorie L2</option>';
                        l2Select.disabled = true;
                        l3Select.innerHTML = '<option value="">Sélectionner une catégorie L3</option>';
                        l3Select.disabled = true;
                        return;
                    }
                    
                    fetchChildren(this.value, l2Select, 'Sélectionner une catégorie L2');
                    l3Select.innerHTML = '<option value="">Sélectionner une catégorie L3</option>';
                    l3Select.disabled = true;
                });

                l2Select.addEventListener('change', function () {
                    if (!this.value) {
                        l3Select.innerHTML = '<option value="">Sélectionner une catégorie L3</option>';
                        l3Select.disabled = true;
                        return;
                    }
                    fetchChildren(this.value, l3Select, 'Sélectionner une catégorie L3');
                });

                if (l1Select.value) {
                    fetchChildren(l1Select.value, l2Select, 'Sélectionner une catégorie L2', initialL2Id)
                        .then(() => {
                            if (l2Select.value) {
                                fetchChildren(l2Select.value, l3Select, 'Sélectionner une catégorie L3', initialL3Id);
                            }
                        });
                }
            });
        </script>
    @endpush
@endsection