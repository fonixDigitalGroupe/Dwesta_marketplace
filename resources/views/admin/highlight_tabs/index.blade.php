@extends('layouts.admin')

@section('title', 'Gestion des Onglets - Actualités')

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
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Onglets de la Bento Grid</h1>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

            <!-- Action Bar -->
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 1.5rem;">
                <a href="{{ route('admin.highlight-tabs.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Nouvel Onglet <i class="fas fa-plus-square"></i>
                </a>
                <a href="{{ route('admin.highlights.index') }}" style="display: flex; align-items: center; gap: 8px; background: #333; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Retour aux Actualités <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 80px;">Pos</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Nom de l'onglet</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Statut</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tabs as $tab)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.85rem; font-weight: 600; color: #333;">
                                #{{ $tab->position }}
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #333;">
                                <div style="font-weight: 600; color: #333;">{{ $tab->name }}</div>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee;">
                                @if($tab->active)
                                    <span style="background: #e6f9ed; color: #1e7e34; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Actif</span>
                                @else
                                    <span style="background: #fff5f5; color: #c53030; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Désactivé</span>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <a href="{{ route('admin.highlight-tabs.edit', $tab) }}" 
                                       style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #eff6ff; color: #2563eb; border-radius: 6px; font-size: 0.8rem; text-decoration: none; border: 1px solid #dbeafe; transition: all 0.2s;" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form id="delete-tab-{{ $tab->id }}" action="{{ route('admin.highlight-tabs.destroy', $tab) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteTab({{ $tab->id }})" 
                                                style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fef2f2; color: #dc2626; border-radius: 6px; font-size: 0.8rem; border: 1px solid #fee2e2; cursor: pointer; transition: all 0.2s;" 
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 3rem; text-align: center; color: #94a3b8; font-size: 0.9rem;">
                                Aucun onglet trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDeleteTab(id) {
            Swal.fire({
                title: 'Supprimer cet onglet ?',
                text: "Attention : si cet onglet contient des actualités, la suppression sera bloquée par la base de données.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                borderRadius: '12px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-tab-' + id).submit();
                }
            })
        }
    </script>
    @endpush
@endsection
