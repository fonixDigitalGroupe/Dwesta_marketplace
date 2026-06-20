@extends('layouts.admin')

@section('title', 'Gestion des Bannières')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    .sub-header-slot { display: none !important; }
    select:focus, input:focus {
        border-color: #adb1b8 !important;
        
        outline: none;
    }
</style>
@endpush

@section('content')
<div style="max-width: 100%;">

    {{-- Main Conteneur style Amazon Card --}}
    <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                Gestion des Bannières
            </h1>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.banners.create') }}"
                   style="background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); border: 1px solid #004aad; color: #fff; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                    Nouvelle bannière
                </a>
                <a href="javascript:window.print()"
                   style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                    Imprimer
                </a>
            </div>
        </div>

        {{-- Barre de filtre --}}
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                <span>Afficher</span>
                <select onchange="window.location.href = '{{ route('admin.banners.index') }}?per_page=' + this.value + '&search={{ request('search') }}'"
                    style="padding: 4px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #f0f2f2; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                    <option value="8"   {{ request('per_page', 8) == 8   ? 'selected' : '' }}>8</option>
                    <option value="25"  {{ request('per_page') == 25  ? 'selected' : '' }}>25</option>
                    <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>résultats par page</span>
            </div>

            <div style="font-size: 0.8rem;">
                <form action="{{ route('admin.banners.index') }}" method="GET"
                      style="display: flex; align-items: center; gap: 8px;">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 8) }}">
                    <span style="color: #555;">Rechercher :</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Titre de la bannière..."
                           style="padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; outline: none; width: 220px; font-size: 0.8rem;">
                </form>
            </div>
        </div>

        {{-- Table Amazon Design --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
            <thead>
                <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 60px;">Ordre</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 110px;">Visuel</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Détails de la Bannière</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 175px;">Période</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 90px;">Statut</th>
                    <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 175px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                    <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;"
                        onmouseover="this.style.background='#f9f9f9'"
                        onmouseout="this.style.background='transparent'">

                        <td style="padding: 12px 15px; text-align: center; font-size: 0.85rem; font-weight: 700; color: #555; border-right: 1px solid #e7e7e7;">
                            #{{ $banner->order }}
                        </td>

                        <td style="padding: 8px; text-align: center; border-right: 1px solid #e7e7e7;">
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                                 style="width: 80px; height: 32px; object-fit: cover; border: 1px solid #ddd; background: #fff;">
                        </td>

                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-weight: 600; color: #111; font-size: 0.85rem;">{{ $banner->title }}</div>
                            @if($banner->link_url)
                                <div style="font-size: 0.7rem; color: #0066c0; margin-top: 4px;">
                                    {{ Str::limit(str_replace(['/categories/e-commerce', '/categories/immobilier'], '', $banner->link_url), 50) }}
                                </div>
                            @endif
                        </td>

                        <td style="padding: 12px 15px; font-size: 0.8rem; color: #555; border-right: 1px solid #e7e7e7;">
                            @if($banner->start_date || $banner->end_date)
                                <div>Du : {{ $banner->start_date ? $banner->start_date->format('d/m/Y') : '∞' }}</div>
                                <div>Au : {{ $banner->end_date ? $banner->end_date->format('d/m/Y') : '∞' }}</div>
                            @else
                                <span style="color: #999; font-style: italic;">Permanent</span>
                            @endif
                        </td>

                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                            @if($banner->active)
                                <span style="font-size: 0.75rem; color: #569b00; font-weight: 600;">Active</span>
                            @else
                                <span style="font-size: 0.75rem; color: #c40000; font-weight: 600;">Inactive</span>
                            @endif
                        </td>

                        <td style="padding: 12px 15px; text-align: right;">
                            <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                <a href="{{ route('admin.banners.edit', $banner) }}"
                                   style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                   onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                   onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                    Modifier
                                </a>
                                <span style="color: #ddd;">|</span>
                                <form id="toggle-form-{{ $banner->id }}"
                                      action="{{ route('admin.banners.toggle-status', $banner) }}"
                                      method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="button"
                                            onclick="confirmToggle({{ $banner->id }}, {{ $banner->active ? 'true' : 'false' }})"
                                            style="background: none; border: none; color: #0066c0; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                            onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                            onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                        {{ $banner->active ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                                <span style="color: #ddd;">|</span>
                                <form id="delete-form-{{ $banner->id }}"
                                      action="{{ route('admin.banners.destroy', $banner) }}"
                                      method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete({{ $banner->id }})"
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
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                            Aucune bannière trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination Info & Links Harmonisée --}}
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
            <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                Affichage de {{ $banners->firstItem() ?? 0 }} à {{ $banners->lastItem() ?? 0 }} sur {{ $banners->total() }} résultats
            </div>
            <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                @if($banners->onFirstPage())
                    <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                @else
                    <a href="{{ $banners->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                @endif

                @php
                    $pStart = max(1, $banners->currentPage() - 2);
                    $pEnd   = min($banners->lastPage(), $pStart + 4);
                @endphp

                @for($i = $pStart; $i <= $pEnd; $i++)
                    @if($i == $banners->currentPage())
                        <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #004aad;">{{ $i }}</span>
                    @else
                        <a href="{{ $banners->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                    @endif
                @endfor

                @if($banners->hasMorePages())
                    <a href="{{ $banners->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                @else
                    <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                @endif
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function confirmToggle(id, isActive) {
        const actionText = isActive ? 'désactiver' : 'activer';
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: `Voulez-vous vraiment ${actionText} cette bannière ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e67e00',
            cancelButtonColor: '#d33',
            confirmButtonText: `Oui, ${actionText} !`,
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('toggle-form-' + id).submit();
            }
        });
    }

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
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection
