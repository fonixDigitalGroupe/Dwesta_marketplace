@extends('layouts.admin')

@php
    $isSellerView = in_array($role, ['vendeur', 'vendeur_pro', 'vendeur_particulier']);
    $isCustomerView = $role === 'acheteur';
    $currentTitle = $isSellerView ? 'Gestion des Vendeurs' : ($isCustomerView ? 'Gestion des Clients' : 'Gestion des Utilisateurs');
 @endphp

@section('title', $currentTitle)

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Pas de barre d'onglets sur la page utilisateurs */
        .sub-header-slot { display: none !important; }

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

        .badge-amazon-warning {
            color: #f68b1e;
            background: #fff8f3;
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
        
        .filter-select:focus,
        .filter-input:focus {
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
                        <i class="fas fa-users" style="font-size: 0.8rem;"></i>
                        <span style="line-height: 1;">{{ $currentTitle }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px;">
                    @if(!in_array($role, ['vendeur', 'acheteur']))
                    <a href="{{ route('admin.users.create') }}" class="btn-amazon-primary" style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border-color: #c05d00;">
                        <i class="fas fa-plus"></i> Nouveau
                    </a>
                    @endif
                </div>
            </div>

            <!-- Formulaire Global pour la recherche et les filtres -->
            <div class="filters-bar" style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 0; margin-bottom: 20px;">
                <form action="{{ route('admin.users.index') }}" method="GET" id="filter-wrapper" style="display: flex; flex-direction: column; gap: 15px;">
                    <input type="hidden" name="role" value="{{ $role }}">

                    @if(!empty($customRoles) && !in_array($role, ['vendeur', 'acheteur']))
                    <div style="display: flex; gap: 15px;">
                        <div style="flex: 1; max-width: 300px;">
                            <label class="filter-label">Filtrer par rôle personnalisé</label>
                            <select onchange="if(this.value) window.location.href='{{ route('admin.users.index') }}?role=' + encodeURIComponent(this.value)"
                                    class="filter-select" style="width: 100%;">
                                <option value="">— Choisir un rôle —</option>
                                @foreach($customRoles as $rn => $rl)
                                    <option value="{{ $rn }}" {{ $role === $rn ? 'selected' : '' }}>{{ $rl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    @if($role === 'vendeur')
                    <!-- Zone de filtres spécifiques -->
                    <div style="display: flex; gap: 15px;">
                        <div style="flex: 1; max-width: 300px;">
                            <label class="filter-label">Type de Vendeur</label>
                            <select name="type_vendeur" onchange="this.form.submit()" class="filter-select" style="width: 100%;">
                                <option value="">Tous les types</option>
                                <option value="professionnel" {{ request('type_vendeur') === 'professionnel' ? 'selected' : '' }}>Professionnel</option>
                                <option value="particulier" {{ request('type_vendeur') === 'particulier' ? 'selected' : '' }}>Particulier</option>
                            </select>
                        </div>
                        <div style="flex: 1; max-width: 300px;">
                            <label class="filter-label">Statut</label>
                            <select name="status" onchange="this.form.submit()" class="filter-select" style="width: 100%;">
                                <option value="">Tous les statuts</option>
                                <option value="actif" {{ request('status') === 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="attente" {{ request('status') === 'attente' ? 'selected' : '' }}>En attente</option>
                                <option value="suspendu" {{ request('status') === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Recherche (Type amazon Search Bar) -->
                    <div style="display: flex; align-items: center; width: 100%; position: relative;">
                        <div style="display: flex; width: 100%; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher par nom, email, tel..."
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
                            <a href="{{ route('admin.users.index') }}" 
                               style="margin-left: 15px; color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                               onmouseover="this.style.textDecoration='underline'"
                               onmouseout="this.style.textDecoration='none'">
                               Effacer
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">
                            Prénom / Nom</th>
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">
                            Email</th>
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">
                            Téléphone</th>
                        <th
                            style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 140px;">
                            Rôle</th>
                        <th
                            style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">
                            Statut</th>
                        <th
                            style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 160px;" class="actions-column">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td
                                style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; border-right: 1px solid #eff3f6;">
                                {{ $user->prenom }} {{ $user->nom }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #eff3f6;">
                                {{ $user->email }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #eff3f6;">
                                {{ $user->telephone ?? '-' }}
                            </td>

                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                @php
                                    $roleName = 'Acheteur';
                                    $textColor = '#555';
                                    $bgColor = 'transparent';

                                    if ($user->hasRole('admin')) {
                                        $roleName = 'Admin';
                                        $textColor = '#c45500';
                                        $bgColor = '#fff8f3';
                                    } elseif ($user->vendeur) {
                                        if ($user->vendeur->type === 'professionnel') {
                                            $roleName = 'Vendeur Pro';
                                            $textColor = '#0066c0';
                                            $bgColor = '#f0f7ff';
                                        } else {
                                            $roleName = 'Vendeur Part';
                                            $textColor = '#0066c0';
                                            $bgColor = '#e6f6f9';
                                        }
                                    } elseif ($user->roles->first()) {
                                        $roleName = ucfirst($user->roles->first()->name);
                                        $bgColor = '#f6f6f6';
                                    }
                                @endphp
                                <span
                                    style="font-size: 0.85rem; color: {{ $textColor }}; font-weight: 600; text-transform: none; display: inline-block;">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                @if (!$user->is_active)
                                    <span class="badge-amazon badge-amazon-danger">Suspendu</span>
                                @elseif ($user->vendeur && !$user->vendeur->estVerifie())
                                    <span class="badge-amazon badge-amazon-warning">En attente</span>
                                @else
                                    <span class="badge-amazon badge-amazon-success">Actif</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: right;" class="actions-column">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    @if ($user->vendeur)
                                        <a href="{{ route('admin.vendeurs.verification.show', $user->vendeur) }}"
                                            style="color: #c45500; font-size: 0.8rem; text-decoration: none; font-weight: 600;"
                                            onmouseover="this.style.textDecoration='underline'"
                                            onmouseout="this.style.textDecoration='none'">
                                            Examiner
                                        </a>
                                        @if ($role !== 'vendeur')
                                            <span style="color: #ddd;">|</span>
                                        @endif
                                    @endif

                                    @if (request('role') !== 'vendeur')
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                            onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                            onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                            Modifier
                                        </a>
                                        <span style="color: #ddd;">|</span>
                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.textDecoration='underline'"
                                                onmouseout="this.style.color='#c40000'; this.style.textDecoration='none'">
                                                Supprimer
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 3rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucun utilisateur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($users->total() > 0)
                <div class="pagination-container"
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        <strong>{{ $users->total() }}</strong> lignes
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($users->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #e2e8f0; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #1e293b; font-size: 0.8rem; text-decoration: none; border: 1px solid #e2e8f0; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'" onmouseout="this.style.borderColor='#e2e8f0'">Précédent</a>
                        @endif

                        @php
                            $startPage = max(1, $users->currentPage() - 2);
                            $endPage = min($users->lastPage(), $startPage + 4);
                        @endphp

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            @if ($i == $users->currentPage())
                                <span style="padding: 6px 12px; background: #3b82f6; color: #fff; font-weight: 600; font-size: 0.8rem; border: 1px solid #3b82f6; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $users->url($i) }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #e2e8f0; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'" onmouseout="this.style.borderColor='#e2e8f0'">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #1e293b; font-size: 0.8rem; text-decoration: none; border: 1px solid #e2e8f0; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'" onmouseout="this.style.borderColor='#e2e8f0'">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #e2e8f0; border-radius: 4px; cursor: not-allowed;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
