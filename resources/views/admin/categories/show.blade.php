@extends('layouts.admin')

@section('title', 'Détails - ' . $category->nom)

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .action-btn { transition: all 0.2sease; }
        .action-btn:hover { transform: translateY(-1px); }
    </style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        
        <!-- Titre en majuscules -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: space-between;">
            <span>Architecture : {{ $category->nom }}</span>
        </h2>

        <!-- Barre d'outils (Toolbar) -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.categories.l1') }}" 
                style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                Liste des catégories <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
            
            <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" 
                style="display: flex; align-items: center; gap: 8px; background: #e67e00; border: 1px solid #c05d00; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #fff; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); font-weight: 500;">
                Nouvelle sous-catégorie <i class="fas fa-plus-square" style="font-size: 0.75rem;"></i>
            </a>
        </div>


        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1rem;">

            <!-- Table Header Info (Optional, but replacing the old one) -->
            <div style="padding: 0 0 1rem 0; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 0.85rem; font-weight: 600; color: #333;">Liste des sous-catégories</span>
                <span style="font-size: 0.8rem; color: #888; background: #f8f9fa; border: 1px solid #eee; padding: 2px 8px; border-radius: 12px;">{{ $category->enfants->count() }} élément(s)</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Nom de la sous-catégorie</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.85rem; color: #444;">
                    @forelse($category->enfants as $enfant)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                <div style="font-weight: 600; color: #333; margin-bottom: 2px;">
                                    {{ $enfant->nom }}
                                </div>
                            </td>

                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                    <a href="{{ route('admin.categories.show', $enfant) }}" 
                                       style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #64748b; color: #fff; border-radius: 3px; font-size: 0.75rem; text-decoration: none;" 
                                       title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $enfant) }}" 
                                       style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #004aad; color: #fff; border-radius: 3px; font-size: 0.75rem; text-decoration: none;" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $enfant->id }}" action="{{ route('admin.categories.destroy', $enfant) }}" method="POST" style="display:inline;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $enfant->id }})" 
                                                style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #e74c3c; color: #fff; border-radius: 3px; font-size: 0.75rem; border: none; cursor: pointer;" 
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucune sous-catégorie trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    </script>
    @endpush
@endsection