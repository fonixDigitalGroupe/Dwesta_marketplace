@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Gestion des Utilisateurs</span>
@endsection

@section('content')
    <div style="max-width: 1200px;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                Liste des Utilisateurs
            </h1>
            <div style="display: flex; gap: 10px;">
                <a href="#" style="display: flex; align-items: center; gap: 6px; padding: 0.5rem 1rem; background-color: #fff; border: 1px solid #dc2626; color: #dc2626; border-radius: 4px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.2s;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Télécharger PDF
                </a>
                <a href="#" style="display: flex; align-items: center; gap: 6px; padding: 0.5rem 1rem; background-color: #fff; border: 1px solid #16a34a; color: #16a34a; border-radius: 4px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.2s;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Exporter vers Excel
                </a>
            </div>
        </div>

        <!-- Description Box -->
        <div
            style="background: #fffaf0; border: 1px solid #ff9d00; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 12px; border-radius: 2px;">
            <div style="flex-shrink: 0; margin-top: 2px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" fill="#ff9d00" />
                    <path d="M12 7v6M12 17h.01" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                </svg>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #333; font-weight: 600; margin-bottom: 0.15rem;">
                    Administration des comptes
                </div>
                <div style="font-size: 0.8rem; color: #444; line-height: 1.4;">
                    Consultez et gérez l'ensemble des utilisateurs inscrits sur la plateforme.
                </div>
            </div>
        </div>

        <!-- Filters Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" style="background: #fff; padding: 1rem; border: 1px solid #e5e5e5; margin-bottom: 1.5rem; display: flex; gap: 1rem; align-items: flex-end; border-radius: 2px;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem; flex: 1;">
                <label for="role" style="font-size: 0.85rem; font-weight: 600; color: #333;">Rôle</label>
                <select name="role" id="role" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.9rem;">
                    <option value="">Tous les rôles</option>
                    <option value="Administrateur" {{ request('role') == 'Administrateur' ? 'selected' : '' }}>Administrateur</option>
                    <option value="Vendeur" {{ request('role') == 'Vendeur' ? 'selected' : '' }}>Vendeur</option>
                    <option value="Utilisateur" {{ request('role') == 'Utilisateur' ? 'selected' : '' }}>Utilisateur</option>
                </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem; flex: 1;">
                <label for="nationalite" style="font-size: 0.85rem; font-weight: 600; color: #333;">Nationalité</label>
                <select name="nationalite" id="nationalite" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.9rem;">
                    <option value="">Toutes les nationalités</option>
                    @foreach($nationalites as $nat)
                        <option value="{{ $nat }}" {{ request('nationalite') == $nat ? 'selected' : '' }}>{{ $nat }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem; flex: 1;">
                <label for="civilite" style="font-size: 0.85rem; font-weight: 600; color: #333;">Civilité</label>
                <select name="civilite" id="civilite" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.9rem;">
                    <option value="">Toutes</option>
                    @foreach($civilites as $civ)
                        <option value="{{ $civ }}" {{ request('civilite') == $civ ? 'selected' : '' }}>{{ $civ }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" style="background: #333; color: #fff; padding: 0.6rem 1.2rem; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; height: 38px;">
                Filtrer
            </button>
            
            @if(request()->has('role') || request()->has('nationalite'))
                <a href="{{ route('admin.users.index') }}" style="color: #666; text-decoration: none; font-size: 0.85rem; background: #fff; border: 1px solid #ccc; padding: 0.6rem 1rem; border-radius: 4px; transition: all 0.2s; display: inline-flex; height: 38px; align-items: center; justify-content: center;">Réinitialiser</a>
            @endif
        </form>

        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5;">
                <span style="font-size: 0.8rem; color: #666;">{{ $users->count() }} utilisateur(s)</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8fafc; text-align: left;">
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Infos</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Téléphone</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Email</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Rôle</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom: 1px solid #e5e5e5;">
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div>
                                        <div style="font-size: 0.875rem; color: #333; font-weight: 500;">
                                            @if($user->civilite)
                                                <span style="color: #64748b; font-size: 0.8rem; margin-right: 2px; font-weight: 400;">{{ $user->civilite }}</span>
                                            @endif
                                            {{ $user->prenom }} {{ $user->nom }}
                                        </div>
                                        <div style="font-size: 0.75rem; color: #999;">Inscrit le {{ $user->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: #666;">
                                {{ $user->telephone ?? '-' }}
                            </td>
                            <td style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: #666;">
                                {{ $user->email }}
                            </td>
                            <td style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: #666;">
                                @if($user->hasRole('Administrateur')) 
                                    <span style="background-color: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Admin</span>
                                @elseif($user->estVendeur())
                                    <span style="background-color: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Vendeur</span>
                                @else
                                    <span style="background-color: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 9999px; font-size: 0.7rem; font-weight: 600;">Utilisateur</span>
                                @endif
                            </td>
                            <td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="#" style="color: #666; font-size: 0.75rem; text-decoration: none; padding: 4px 8px; background: #f1f5f9; border-radius: 4px;">Détails</a>
                                
                                <form action="{{ route('admin.users.suspend', $user) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" style="color: {{ $user->is_active ? '#d97706' : '#16a34a' }}; font-size: 0.75rem; background: none; border: none; cursor: pointer; padding: 4px 8px; border: 1px solid {{ $user->is_active ? '#d97706' : '#16a34a' }}; border-radius: 4px;">
                                        {{ $user->is_active ? 'Suspendre' : 'Activer' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="color: #dc2626; font-size: 0.75rem; background: none; border: none; cursor: pointer; padding: 4px 8px; border: 1px solid #dc2626; border-radius: 4px;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4"
                                style="padding: 3rem 1.25rem; text-align: center; color: #999; font-size: 0.875rem;">
                                Aucun utilisateur trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div style="padding: 1rem; border-top: 1px solid #e5e5e5;">
                {{ $users->links('admin.pagination') }}
            </div>
        </div>
    </div>
@endsection
