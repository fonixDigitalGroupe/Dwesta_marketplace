@extends('layouts.admin')

@php
    $isSellerView = in_array($role, ['vendeur', 'vendeur_pro', 'vendeur_particulier']);
    $currentTitle = $isSellerView ? 'Gestion des Vendeurs' : 'Gestion des Utilisateurs';
@endphp

@section('title', $currentTitle)

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

        .filter-label {
            font-size: 0.8rem;
            color: #555;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .filter-select {
            padding: 6px 10px;
            border: 1px solid #adb1b8;
            border-radius: 0;
            background: #fff;
            font-size: 0.85rem;
            color: #111;
            outline: none;
            cursor: pointer;
        }

        /* Onglets style Paramètres Amazon */
        .admin-tabs {
            background: #fff;
            border: 1px solid #e7e7e7;
            border-bottom: none;
            display: flex;
            align-items: stretch;
            height: 50px;
            overflow: hidden;
        }

        .admin-tab {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 22px;
            font-size: 0.85rem;
            color: #555;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
            font-weight: 500;
        }

        .admin-tab:hover {
            background: rgba(0, 0, 0, 0.02);
            color: #111;
        }

        .admin-tab.active {
            font-weight: 700;
            color: #111;
        }

        .admin-tab i {
            font-size: 0.9rem;
            opacity: 0.6;
        }

        .admin-tab.active i {
            opacity: 1;
            color: #e77600;
        }
    </style>
@endpush



@section('sub_header')
    <!-- Onglets -->
    <div class="admin-tabs">
        <div style="max-width: 1200px; margin: 0 auto; width: 100%; display: flex; height: 100%;">
            <a href="{{ route('admin.users.index', ['role' => 'acheteur']) }}" 
               class="admin-tab {{ request('role') == 'acheteur' || empty(request('role')) ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Clients
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" 
               class="admin-tab {{ request('role') == 'vendeur' ? 'active' : '' }}">
                <i class="fas fa-id-card"></i>
                Vendeurs
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div style="max-width: 1200px; margin: 0 auto;">

        <!-- Main Conteneur style Amazon Card -->
        <div
            style="background: #fff; border: 1px solid #e7e7e7; border-top: none; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    {{ $currentTitle }}
                </h1>

                <div style="display: flex; gap: 8px;">
                    <a href="javascript:window.print()"
                        style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Imprimer
                    </a>
                </div>
            </div>

            <!-- Barre de filtres grise Harmonisée -->
            <div
                style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 0; margin-bottom: 20px;">
                <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                    
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                        <span>Afficher</span>
                        <select
                            onchange="window.location.href = '{{ request()->fullUrlWithQuery(['per_page' => '']) }}'.replace('per_page=', 'per_page=' + this.value)"
                            style="padding: 3px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #fcfcfc; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                            <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span>résultats</span>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-size: 0.8rem; color: #555; font-weight: 500;">Rechercher :</span>
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Nom, email, tel..."
                            style="padding: 6px 12px; border: 1px solid #adb1b8; border-radius: 0; outline: none; font-size: 0.85rem; width: 250px;">
                    </div>
                </form>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Prénom / Nom</th>
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Email / Tel</th>
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Pays</th>
                        <th
                            style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 140px;">
                            Rôle</th>
                        <th
                            style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 100px;">
                            Statut</th>
                        <th
                            style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 160px;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td
                                style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; border-right: 1px solid #e7e7e7;">
                                {{ $user->prenom }} {{ $user->nom }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span>{{ $user->email }}</span>
                                    <span style="font-size: 0.75rem; color: #888;">{{ $user->telephone ?? '-' }}</span>
                                </div>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                {{ $user->nationalite ?? '-' }}
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @php
                                    $roleName = 'Acheteur';
                                    $textColor = '#555';

                                    if ($user->hasRole('admin')) {
                                        $roleName = 'Admin';
                                        $textColor = '#c45500';
                                    } elseif ($user->vendeur) {
                                        if ($user->vendeur->type === 'professionnel') {
                                            $roleName = 'Vendeur Pro';
                                            $textColor = '#0066c0';
                                        } else {
                                            $roleName = 'Vendeur Part';
                                            $textColor = '#007185';
                                        }
                                    } elseif ($user->roles->first()) {
                                        $roleName = ucfirst($user->roles->first()->name);
                                    }
                                @endphp
                                <span
                                    style="font-size: 0.75rem; color: {{ $textColor }}; font-weight: 700; text-transform: uppercase;">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @if (!$user->is_active)
                                    <span
                                        style="font-size: 0.75rem; color: #c40000; font-weight: 600; background: #fff5f5; padding: 2px 8px; border-radius: 12px;">Suspendu</span>
                                @elseif ($user->vendeur && !$user->vendeur->estVerifie())
                                    <span
                                        style="font-size: 0.75rem; color: #f68b1e; font-weight: 700; background: #fff8f3; padding: 2px 8px; border-radius: 12px;">En attente</span>
                                @else
                                    <span
                                        style="font-size: 0.75rem; color: #569b00; font-weight: 600; background: #f7fff0; padding: 2px 8px; border-radius: 12px;">Actif</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    @if ($user->vendeur)
                                        <a href="{{ route('admin.vendeurs.verification.show', $user->vendeur) }}"
                                            style="color: #c45500; font-size: 0.8rem; text-decoration: none; font-weight: 600; background: #fff8f3; border: 1px solid #fbd8b4; padding: 2px 8px; border-radius: 2px;"
                                            onmouseover="this.style.background='#fef0e1'"
                                            onmouseout="this.style.background='#fff8f3'">
                                            Examiner
                                        </a>
                                        @if (request('role') !== 'vendeur')
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

            <!-- Pagination Info & Links Harmonisée -->
            @if($users->total() > 0)
                <div
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Affichage de {{ $users->firstItem() ?? 0 }} à {{ $users->lastItem() ?? 0 }} sur
                        {{ $users->total() }} résultats
                    </div>
                    <div
                        style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                        @if ($users->onFirstPage())
                            <span
                                style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                        @endif

                        @php
                            $startPage = max(1, $users->currentPage() - 2);
                            $endPage = min($users->lastPage(), $startPage + 4);
                        @endphp

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            @if ($i == $users->currentPage())
                                <span
                                    style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #004aad;">{{ $i }}</span>
                            @else
                                <a href="{{ $users->url($i) }}"
                                    style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
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
