@extends('layouts.admin')

@section('title', 'Architecture - ' . $category->nom)

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    select:focus, input:focus {
        border-color: #adb1b8 !important;
        
        outline: none;
    }
    .filter-label { font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 4px; display: block; }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    Architecture : {{ $category->nom }}
                </h1>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ $category->parent_id ? route('admin.categories.show', $category->parent_id) : route('admin.categories.l1') }}" 
                       style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i> Retour
                    </a>
                    <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" 
                       style="background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); border: 1px solid #004aad; color: #fff; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                        Nouveau niveau enfant
                    </a>
                </div>
            </div>

            <!-- Barre de filtres grise -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 0; margin-bottom: 20px;">
                <form action="{{ route('admin.categories.show', $category) }}" method="GET" style="display: flex; justify-content: space-between; align-items: end; flex-wrap: wrap; gap: 20px;">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 8) }}">
                    
                    <div style="display: flex; gap: 20px; align-items: end;">
                        <div style="display: flex; flex-direction: column;">
                            <label class="filter-label">Rechercher dans les enfants</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Nom de la sous-catégorie..."
                                style="padding: 6px 12px; border: 1px solid #adb1b8; border-radius: 0; outline: none; font-size: 0.85rem; width: 250px;">
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                        <span>Afficher</span>
                        <select onchange="window.location.href = '{{ request()->fullUrlWithQuery(['per_page' => '']) }}'.replace('per_page=', 'per_page=' + this.value)" 
                            style="padding: 3px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #fcfcfc; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                            <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span>sous-catégories</span>
                    </div>
                </form>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Sous-catégorie</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enfants as $enfant)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.85rem; border-right: 1px solid #e7e7e7;">
                                <div style="font-weight: 600; color: #0066c0;">{{ $enfant->nom }}</div>
                                @if($enfant->description)
                                    <div style="font-size: 0.75rem; color: #777; margin-top: 2px;">{{ Str::limit($enfant->description, 80) }}</div>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @if($enfant->actif)
                                    <span style="font-size: 0.75rem; color: #569b00; font-weight: 600;">Active</span>
                                @else
                                    <span style="font-size: 0.75rem; color: #c40000; font-weight: 600;">Suspendue</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.categories.show', $enfant) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.textDecoration='underline'" 
                                       onmouseout="this.style.textDecoration='none'">
                                       Détails
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <a href="{{ route('admin.categories.edit', $enfant) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                       onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                       Modifier
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <form id="delete-form-{{ $enfant->id }}" action="{{ route('admin.categories.destroy', $enfant) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $enfant->id }})" 
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
                            <td colspan="3" style="padding: 3rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucune sous-catégorie trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links Harmonisée -->
            @if($enfants->total() > 0)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Affichage de {{ $enfants->firstItem() ?? 0 }} à {{ $enfants->lastItem() ?? 0 }} sur {{ $enfants->total() }} résultats
                    </div>
                    <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                        @if($enfants->onFirstPage())
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                        @else
                            <a href="{{ $enfants->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                        @endif

                        @php
                            $eStart = max(1, $enfants->currentPage() - 2);
                            $eEnd = min($enfants->lastPage(), $eStart + 4);
                        @endphp

                        @for($i = $eStart; $i <= $eEnd; $i++)
                            @if($i == $enfants->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #004aad;">{{ $i }}</span>
                            @else
                                <a href="{{ $enfants->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($enfants->hasMorePages())
                            <a href="{{ $enfants->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
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
    </script>
    @endpush
@endsection