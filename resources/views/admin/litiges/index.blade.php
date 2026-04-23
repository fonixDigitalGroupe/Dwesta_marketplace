@extends('layouts.admin')

@section('title', 'Gestion des Litiges')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">

        <!-- Titre en majuscules type image -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            Gestion des Litiges
        </h2>

        <!-- Barre d'outils type image -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.litiges.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                Liste des litiges <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
            <a href="javascript:window.print()" style="display: flex; align-items: center; gap: 8px; background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Imprimer <i class="fas fa-print"></i>
            </a>
        </div>

        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1rem;">
            
            <!-- Barre d'outils secondaire type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #333;">
                    <div>
                        Afficher 
                        <select onchange="window.location.href = '{{ request()->url() }}?per_page=' + this.value" 
                            style="padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s; min-width: 60px;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                            <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        lignes
                    </div>
                </div>
                <div style="font-size: 0.8rem; color: #666;">
                    Total: {{ $litiges->total() }} litige(s)
                </div>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 60px;">ID</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Signalé par</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Contre</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Motif</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Statut</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Date</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($litiges as $litige)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555;">#{{ $litige->id }}</td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-weight: 600;">{{ $litige->reporter->prenom }} {{ $litige->reporter->nom }}</td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555;">{{ $litige->reported->prenom }} {{ $litige->reported->nom }}</td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555;">
                                <span style="background: #f8f9fa; color: #666; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; border: 1px solid #eee;">
                                    {{ ucfirst($litige->motif) }}
                                </span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center;">
                                @if($litige->statut == 'en_cours')
                                    <span style="background: #fff7ed; color: #c2410c; padding: 4px 10px; border-radius: 4px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">En cours</span>
                                @else
                                    <span style="background: #f0fdf4; color: #166534; padding: 4px 10px; border-radius: 4px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase;">{{ ucfirst($litige->statut) }}</span>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.8rem; color: #666;">
                                {{ $litige->created_at->format('d/m/Y') }}
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <a href="{{ route('admin.litiges.show', $litige) }}" style="display: inline-block; background: #004aad; color: #fff; padding: 5px 12px; border-radius: 4px; font-size: 0.75rem; text-decoration: none; font-weight: 600;" title="Détails">
                                    Détails
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">Aucun litige trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination type image -->
            @if($litiges->hasPages())
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <div style="font-size: 0.85rem; color: #666;">
                    ligne {{ $litiges->firstItem() ?? 0 }} sur {{ $litiges->total() }}
                </div>
                <div style="display: flex; gap: 0; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                    @if($litiges->onFirstPage())
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem; border-right: 1px solid #ddd;">Prec</span>
                    @else
                        <a href="{{ $litiges->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">Prec</a>
                    @endif

                    @foreach(range(1, $litiges->lastPage()) as $i)
                        @if($i == $litiges->currentPage())
                            <span style="padding: 6px 12px; background: #e67e00; color: #fff; font-size: 0.85rem; border-right: 1px solid #ddd;">{{ $i }}</span>
                        @else
                            <a href="{{ $litiges->url($i) }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($litiges->hasMorePages())
                        <a href="{{ $litiges->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none;">Suiv</a>
                    @else
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem;">Suiv</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
