@extends('layouts.admin')

@section('title', 'Architecture - ' . $category->nom)

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
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Architecture : {{ $category->nom }}</h1>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

            <!-- Action Bar -->
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 1.5rem;">
                <a href="{{ $category->parent_id ? route('admin.categories.show', $category->parent_id) : route('admin.categories.l1') }}" 
                   style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; font-weight: 500; transition: all 0.2s;" 
                   onmouseover="this.style.borderColor='#e67e00'" onmouseout="this.style.borderColor='#ddd'">
                    <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i> Retour
                </a>
                <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" 
                   style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" 
                   onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Nouveau <i class="fas fa-plus-square"></i>
                </a>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

            <!-- Toolbar (Afficher / Chercher) -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #333;">
                    <div>
                        Afficher 
                        <select onchange="window.location.href = '{{ request()->fullUrlWithQuery(['per_page' => '']) }}'.replace('per_page=', 'per_page=' + this.value)" 
                            style="padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s; min-width: 60px;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                            <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        lignes
                    </div>
                </div>

                <div style="font-size: 0.85rem; color: #333;">
                    <form action="{{ route('admin.categories.show', $category) }}" method="GET" style="display: flex; align-items: center;">
                        @if(request('per_page')) <input type="hidden" name="per_page" value="{{ request('per_page') }}"> @endif
                        Chercher: <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Tapez et Entrée..."
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; outline: none; margin-left: 5px; background-color: #fff; transition: all 0.2s; font-size: 0.85rem; min-width: 200px;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                    </form>
                </div>
            </div>
            
            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Sous-catégorie</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Statut</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enfants as $enfant)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #333; font-family: inherit;">
                                    <div style="font-weight: 600; color: #333; margin-bottom: 2px;">{{ $enfant->nom }}</div>
                                    @if($enfant->description)
                                        <div style="font-size: 0.75rem; color: #777; margin-top: 4px; max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $enfant->description }}
                                        </div>
                                    @endif
                                </td>
                                <td style="padding: 10px; border: 1px solid #eee;">
                                    @if($enfant->actif)
                                        <span style="background: #e6f9ed; color: #1e7e34; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Active</span>
                                    @else
                                        <span style="background: #fff5f5; color: #c53030; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Suspendue</span>
                                    @endif
                                </td>
                                <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                    <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                        <a href="{{ route('admin.categories.show', $enfant) }}" 
                                           style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #f8fafc; color: #64748b; border-radius: 6px; font-size: 0.8rem; text-decoration: none; border: 1px solid #e2e8f0; transition: all 0.2s;" 
                                           onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f8fafc'"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $enfant) }}" 
                                           style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #eff6ff; color: #2563eb; border-radius: 6px; font-size: 0.8rem; text-decoration: none; border: 1px solid #dbeafe; transition: all 0.2s;" 
                                           onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form id="toggle-form-{{ $enfant->id }}" action="{{ route('admin.categories.toggle-status', $enfant) }}" method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button type="button" onclick="confirmToggle({{ $enfant->id }}, {{ $enfant->actif ? 'true' : 'false' }})" 
                                                    style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: {{ $enfant->actif ? '#fff7ed' : '#f0fdf4' }}; color: {{ $enfant->actif ? '#c2410c' : '#15803d' }}; border-radius: 6px; font-size: 0.8rem; border: 1px solid {{ $enfant->actif ? '#ffedd5' : '#dcfce7' }}; cursor: pointer; transition: all 0.2s;" 
                                                    onmouseover="this.style.background='{{ $enfant->actif ? '#ffedd5' : '#dcfce7' }}'" onmouseout="this.style.background='{{ $enfant->actif ? '#fff7ed' : '#f0fdf4' }}'"
                                                    title="{{ $enfant->actif ? 'Suspendre' : 'Activer' }}">
                                                <i class="fas fa-{{ $enfant->actif ? 'lock' : 'lock-open' }}"></i>
                                            </button>
                                        </form>
                                        <form id="delete-form-{{ $enfant->id }}" action="{{ route('admin.categories.destroy', $enfant) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $enfant->id }})" 
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
                                <td colspan="3" style="padding: 3rem; text-align: center; color: #94a3b8; font-size: 0.9rem;">
                                    <i class="fas fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 1rem; opacity: 0.3;"></i>
                                    Aucune sous-catégorie trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
            </table>

            <!-- Pagination logic -->
            @if($enfants->total() > 0)
                <div style="border-top: 1px solid #f3f3f3; margin-top: 1.5rem; padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 0.85rem; color: #64748b; font-weight: 500;">
                        ligne {{ $enfants->firstItem() }} sur {{ $enfants->total() }}
                    </div>
                    <div style="display: flex; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; background: #fff;">
                        @if($enfants->onFirstPage())
                            <span style="padding: 8px 16px; background: #fff; color: #94a3b8; font-size: 0.85rem; border-right: 1px solid #e2e8f0; cursor: not-allowed; font-weight: 500;">Prec</span>
                        @else
                            <a href="{{ $enfants->previousPageUrl() }}" style="padding: 8px 16px; background: #fff; color: #2563eb; text-decoration: none; font-size: 0.85rem; border-right: 1px solid #e2e8f0; transition: all 0.2s; font-weight: 500;" onmouseover="this.style.background='#f8fafc'">Prec</a>
                        @endif

                        @foreach($enfants->getUrlRange(1, $enfants->lastPage()) as $page => $url)
                            @if($page == $enfants->currentPage())
                                <span style="padding: 8px 16px; background: #eff6ff; color: #2563eb; font-weight: 700; font-size: 0.85rem; {{ $loop->last ? '' : 'border-right: 1px solid #e2e8f0;' }}">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" style="padding: 8px 16px; background: #fff; color: #2563eb; text-decoration: none; font-size: 0.85rem; border-right: 1px solid #e2e8f0; transition: all 0.2s; font-weight: 500;" onmouseover="this.style.background='#f8fafc'">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($enfants->hasMorePages())
                            <a href="{{ $enfants->nextPageUrl() }}" style="padding: 8px 16px; background: #fff; color: #2563eb; text-decoration: none; font-size: 0.85rem; transition: all 0.2s; font-weight: 500; border-left: 1px solid #e2e8f0;" onmouseover="this.style.background='#f8fafc'">Suiv</a>
                        @else
                            <span style="padding: 8px 16px; background: #fff; color: #94a3b8; font-size: 0.85rem; cursor: not-allowed; font-weight: 500; border-left: 1px solid #e2e8f0;">Suiv</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmToggle(id, isActive) {
            const actionText = isActive ? 'suspendre' : 'activer';
            const actionColor = isActive ? '#e67e00' : '#1e7e34';
            
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `Voulez-vous vraiment ${actionText} cette catégorie ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: actionColor,
                cancelButtonColor: '#64748b',
                confirmButtonText: `Oui, ${actionText} !`,
                cancelButtonText: 'Annuler',
                borderRadius: '12px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('toggle-form-' + id).submit();
                }
            })
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                borderRadius: '12px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
@endsection