@extends('layouts.admin')

@section('title', 'Gestion des Rôles')

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
                        <i class="fas fa-shield-alt" style="font-size: 0.8rem;"></i>
                        <span style="line-height: 1;">Gestion des rôles</span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.roles.create') }}" class="btn-amazon-primary" style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border-color: #c05d00;">
                        <i class="fas fa-plus"></i> Nouveau rôle
                    </a>
                </div>
            </div>

            <!-- Barre de filtre -->
            <div class="filters-bar"
                style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
                <form action="{{ route('admin.roles.index') }}" method="GET" style="display: flex; align-items: center; flex: 1; position: relative;">
                    <div style="display: flex; width: 100%; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un rôle par son nom..."
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
                    
                    @if(request('search'))
                        <a href="{{ route('admin.roles.index') }}" 
                           style="margin-left: 15px; color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                           onmouseover="this.style.textDecoration='underline'"
                           onmouseout="this.style.textDecoration='none'">
                           Effacer
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Nom du rôle</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Permissions</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Type</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;" class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        {{-- On n'affiche ni les rôles « Personnel » ni vendeur/client (rôles déjà connus) --}}
                        @continue($role->name !== 'admin')
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.8rem; border-right: 1px solid #eff3f6;">
                                <a href="{{ route('admin.roles.edit', $role) }}" 
                                   style="color: #0066c0; text-decoration: none; font-weight: 700; transition: all 0.2s; text-transform: capitalize;"
                                   onmouseover="this.style.textDecoration='underline'; this.style.color='#c45500'"
                                   onmouseout="this.style.textDecoration='none'; this.style.color='#0066c0'">
                                    {{ $role->name }}
                                </a>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #555; border-right: 1px solid #eff3f6;">
                                <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 600px;">
                                    @php
                                        $perms = $role->permissions->pluck('name')->toArray();
                                        $displayLimit = 5;
                                        $displayPerms = array_slice($perms, 0, $displayLimit);
                                        $remainingCount = count($perms) - $displayLimit;
                                    @endphp
                                    @foreach($displayPerms as $perm)
                                        <span style="font-size: 0.7rem; background: #f8fafc; color: #475569; padding: 2px 8px; border-radius: 4px; border: 1px solid #e2e8f0; white-space: nowrap;">
                                            {{ $labels[$perm] ?? $perm }}
                                        </span>
                                    @endforeach
                                    @if($remainingCount > 0)
                                        <span style="font-size: 0.7rem; color: #ff9900; font-weight: 700; cursor: help; align-self: center; margin-left: 4px;" title="{{ implode(', ', array_slice($perms, $displayLimit)) }}">
                                            +{{ $remainingCount }} autres
                                        </span>
                                    @endif
                                    @if(count($perms) === 0)
                                        <span style="font-size: 0.75rem; color: #94a3b8; font-style: italic;">Aucune permission associée</span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <span class="badge-amazon {{ in_array($role->name, ['admin', 'vendeur', 'client']) ? 'badge-amazon-success' : 'badge-amazon-secondary' }}" 
                                      style="{{ !in_array($role->name, ['admin', 'vendeur', 'client']) ? 'background: #f1f5f9; color: #475569;' : '' }}">
                                    {{ in_array($role->name, ['admin', 'vendeur', 'client']) ? 'Système' : 'Personnel' }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;" class="actions-column">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                        style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                        onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                        onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                        Modifier
                                    </a>
                                    
                                    @if(!in_array($role->name, ['admin', 'vendeur', 'client']))
                                        <span style="color: #ddd;">|</span>
                                        <form id="delete-form-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display: inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $role->id }})"
                                                style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.textDecoration='underline'"
                                                onmouseout="this.style.textDecoration='none'">
                                                Supprimer
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucun rôle trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links -->
            @if($roles->total() > 0)
                <div class="pagination-container"
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Affichage de <strong>{{ $roles->firstItem() }}</strong> à <strong>{{ $roles->lastItem() }}</strong> sur <strong>{{ $roles->total() }}</strong> rôles
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($roles->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $roles->previousPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">Précédent</a>
                        @endif

                        @foreach(range(max(1, $roles->currentPage() - 2), min($roles->lastPage(), $roles->currentPage() + 2)) as $i)
                            @if($i == $roles->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1e40af; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $roles->url($i) }}"
                                    style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                    onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                    onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if($roles->hasMorePages())
                            <a href="{{ $roles->nextPageUrl() }}"
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
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ff9900',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler',
                    borderRadius: '4px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                })
            }
        </script>
    @endpush
@endsection