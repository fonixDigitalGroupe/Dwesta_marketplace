@extends('layouts.admin')

@section('title', 'Gestion des Actualités')

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
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Gestion des Actualités</h1>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

            <!-- Action Bar -->
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 1.5rem;">
                <a href="{{ route('admin.highlights.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Nouveau <i class="fas fa-plus-square"></i>
                </a>
                <a href="{{ route('admin.highlight-tabs.index') }}" style="display: flex; align-items: center; gap: 8px; background: #333; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Gérer les Onglets <i class="fas fa-layer-group"></i>
                </a>
                <a href="javascript:window.print()" style="display: flex; align-items: center; gap: 8px; background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Imprimer <i class="fas fa-print"></i>
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
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        lignes
                    </div>
                </div>

                <div style="font-size: 0.85rem; color: #333;">
                    <form action="{{ route('admin.highlights.index') }}" method="GET" style="display: flex; align-items: center;">
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
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Position</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 80px;">Visuel</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Contenu de l'Actualité</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 180px;">Onglet parent</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Statut</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($highlights as $highlight)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.85rem; font-weight: 600; color: #333;">
                                <span style="background: {{ match($highlight->position) { 1 => '#e0f2fe', 4 => '#fef3c7', default => '#f1f5f9' } }}; 
                                             color: {{ match($highlight->position) { 1 => '#0369a1', 4 => '#92400e', default => '#475569' } }}; 
                                             padding: 4px 10px; border-radius: 9999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">
                                    Position {{ $highlight->position }}
                                </span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center;">
                                <img src="{{ $highlight->image_url }}" alt="{{ $highlight->title }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #eee;">
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #333;">
                                <div style="font-weight: 600; color: #333; margin-bottom: 2px;">{{ $highlight->title }}</div>
                                @if($highlight->subtitle)
                                    <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 4px;">{{ $highlight->subtitle }}</div>
                                @endif
                                @if($highlight->link_url)
                                    <div style="font-size: 0.75rem; color: #2563eb; font-weight: 500;">
                                        <i class="fas fa-link" style="font-size: 0.7rem; opacity: 0.7;"></i> {{ Str::limit($highlight->link_url, 40) }}
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.8rem; color: #333; font-weight: 500;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span>{{ $highlight->highlightTab->name ?? 'Sans onglet' }}</span>
                                </div>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee;">
                                @if($highlight->active)
                                    <span style="background: #e6f9ed; color: #1e7e34; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Actif</span>
                                @else
                                    <span style="background: #fff5f5; color: #c53030; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Masqué</span>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <a href="{{ route('admin.highlights.edit', $highlight) }}" 
                                       style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #eff6ff; color: #2563eb; border-radius: 6px; font-size: 0.8rem; text-decoration: none; border: 1px solid #dbeafe; transition: all 0.2s;" 
                                       onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="toggle-form-{{ $highlight->id }}" action="{{ route('admin.highlights.toggle-status', $highlight) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmToggle({{ $highlight->id }}, {{ $highlight->active ? 'true' : 'false' }})" 
                                                style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: {{ $highlight->active ? '#fff7ed' : '#f0fdf4' }}; color: {{ $highlight->active ? '#c2410c' : '#15803d' }}; border-radius: 6px; font-size: 0.8rem; border: 1px solid {{ $highlight->active ? '#ffedd5' : '#dcfce7' }}; cursor: pointer; transition: all 0.2s;" 
                                                onmouseover="this.style.background='{{ $highlight->active ? '#ffedd5' : '#dcfce7' }}'" onmouseout="this.style.background='{{ $highlight->active ? '#fff7ed' : '#f0fdf4' }}'"
                                                title="{{ $highlight->active ? 'Masquer' : 'Afficher' }}">
                                            <i class="fas fa-{{ $highlight->active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    <form id="delete-form-{{ $highlight->id }}" action="{{ route('admin.highlights.destroy', $highlight) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $highlight->id }})" 
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
                            <td colspan="6" style="padding: 3rem; text-align: center; color: #94a3b8; font-size: 0.9rem;">
                                <i class="fas fa-newspaper" style="font-size: 2rem; display: block; margin-bottom: 1rem; opacity: 0.3;"></i>
                                Aucune actualité trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination logic -->
            @if(method_exists($highlights, 'total') && $highlights->total() > 0)
                <div style="border-top: 1px solid #f3f3f3; margin-top: 1.5rem; padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 0.85rem; color: #64748b; font-weight: 500;">
                        ligne {{ $highlights->firstItem() ?? 0 }} sur {{ $highlights->total() }}
                    </div>
                    <div style="display: flex; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; background: #fff;">
                        @if($highlights->onFirstPage())
                            <span style="padding: 8px 16px; background: #fff; color: #94a3b8; font-size: 0.85rem; border-right: 1px solid #e2e8f0; cursor: not-allowed; font-weight: 500;">Prec</span>
                        @else
                            <a href="{{ $highlights->previousPageUrl() }}" style="padding: 8px 16px; background: #fff; color: #2563eb; text-decoration: none; font-size: 0.85rem; border-right: 1px solid #e2e8f0; transition: all 0.2s; font-weight: 500;" onmouseover="this.style.background='#f8fafc'">Prec</a>
                        @endif

                        @foreach($highlights->getUrlRange(1, $highlights->lastPage()) as $page => $url)
                            @if($page == $highlights->currentPage())
                                <span style="padding: 8px 16px; background: #eff6ff; color: #2563eb; font-weight: 700; font-size: 0.85rem; {{ $loop->last ? '' : 'border-right: 1px solid #e2e8f0;' }}">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" style="padding: 8px 16px; background: #fff; color: #2563eb; text-decoration: none; font-size: 0.85rem; border-right: 1px solid #e2e8f0; transition: all 0.2s; font-weight: 500;" onmouseover="this.style.background='#f8fafc'">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($highlights->hasMorePages())
                            <a href="{{ $highlights->nextPageUrl() }}" style="padding: 8px 16px; background: #fff; color: #2563eb; text-decoration: none; font-size: 0.85rem; transition: all 0.2s; font-weight: 500; border-left: 1px solid #e2e8f0;" onmouseover="this.style.background='#f8fafc'">Suiv</a>
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
            const actionText = isActive ? 'masquer' : 'afficher';
            const actionColor = isActive ? '#e67e00' : '#1e7e34';
            
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `Voulez-vous vraiment ${actionText} cet élément ?`,
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
