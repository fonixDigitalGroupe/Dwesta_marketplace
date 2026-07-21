@extends('layouts.admin')

@section('title', 'Gestion des Points Relais')

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

        .badge-amazon-danger {
            color: #c40000;
            background: #fff5f5;
        }

        .badge-amazon-warning {
            color: #c45500;
            background: #fff8e1;
            border: 1px solid #ffecb3;
        }

        @media print {
            .sidebar, .navbar, .settings-tabs, .filters-bar, .actions-column, .pagination-container, .btn-amazon-primary, .btn-amazon-secondary, header, footer {
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

@section('content')
    <div style="max-width: 1600px; margin: 0 auto; width: 100%; padding-top: 0;">
        <!-- Main Card -->
        <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; margin-top: -20px;">

            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <i class="fas fa-map-marker-alt" style="font-size: 0.8rem;"></i>
                    <span style="line-height: 1;">Points Relais</span>
                </div>

                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.point-relais.create') }}" class="btn-amazon-primary">
                        <i class="fas fa-plus"></i> Nouveau Point Relais
                    </a>
                </div>
            </div>

            <!-- Barre de filtre -->
            <div class="filters-bar"
                style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
                <form action="{{ route('admin.point-relais.index') }}" method="GET" style="display: flex; align-items: center; flex: 1; gap: 12px; flex-wrap: wrap;">
                    <select name="responsable" onchange="this.form.submit()"
                        style="padding: 9px 12px; border: 1px solid #dee2e6; border-radius: 4px; background: #fff; font-size: 0.85rem; color: #111; cursor: pointer; min-width: 180px;">
                        <option value="">Tous les responsables</option>
                        @foreach($responsables as $r)
                            <option value="{{ $r->id }}" {{ (string) request('responsable') === (string) $r->id ? 'selected' : '' }}>{{ $r->prenom }} {{ $r->nom }}</option>
                        @endforeach
                    </select>
                    <div style="display: flex; flex: 1; min-width: 220px; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un point relais par nom, ville, adresse..."
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

                    @if(request('search') || request('responsable'))
                        <a href="{{ route('admin.point-relais.index') }}"
                           style="color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                           onmouseover="this.style.textDecoration='underline'"
                           onmouseout="this.style.textDecoration='none'">
                           Effacer
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Point Relais</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Localisation</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;" class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($points as $point)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.8rem; border-right: 1px solid #eff3f6;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="color: #111; font-weight: 700;">{{ $point->nom }}</span>
                                    @if($point->est_point_special)
                                        <span class="badge-amazon badge-amazon-warning" title="Point Spécial Karnou">
                                            <i class="fas fa-star" style="font-size: 0.6rem;"></i> SPÉCIAL
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #111; border-right: 1px solid #eff3f6;">
                                <div style="font-weight: 600; color: #111; margin-bottom: 2px;">{{ $point->region }}, {{ $point->pays }}</div>
                                <div style="font-size: 0.75rem; color: #111; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $point->adresse }}">
                                    {{ $point->adresse }}
                                </div>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <span class="badge-amazon {{ $point->is_active ? 'badge-amazon-success' : 'badge-amazon-danger' }}">
                                    {{ $point->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;" class="actions-column">
                                <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.point-relais.edit', $point) }}" title="Modifier"
                                        style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; color: #111; text-decoration: none; transition: background 0.2s;"
                                        onmouseover="this.style.background='#f3f4f6'"
                                        onmouseout="this.style.background='transparent'"><i class="fas fa-pen-to-square" style="font-size: 0.95rem;"></i></a>
                                    <form action="{{ route('admin.point-relais.destroy', $point) }}" method="POST"
                                        onsubmit="return confirm('Supprimer ce point relais ?')" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Supprimer"
                                            style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; background: none; border: none; color: #c40000; cursor: pointer; transition: background 0.2s;"
                                            onmouseover="this.style.background='#fff5f5'"
                                            onmouseout="this.style.background='transparent'"><i class="fas fa-trash" style="font-size: 0.9rem;"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucun point relais trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links -->
            @if($points->total() > 0)
                <div class="pagination-container"
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        <strong>{{ $points->total() }}</strong> lignes
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($points->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $points->previousPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">Précédent</a>
                        @endif

                        @foreach(range(max(1, $points->currentPage() - 2), min($points->lastPage(), $points->currentPage() + 2)) as $i)
                            @if($i == $points->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1e40af; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $points->url($i) }}"
                                    style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                    onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                    onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if($points->hasMorePages())
                            <a href="{{ $points->nextPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
