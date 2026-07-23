@extends('layouts.admin')

@section('title', 'Gestion des Packs d\'Abonnement')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Input Amazon Style Modernisé */
    .filters-bar input[type="text"], .filters-bar select {
        padding: 6px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        background: #fff;
        font-size: 0.8rem;
        color: #1e293b;
        outline: none;
        transition: all 0.2s;
    }

    /* Badges alignés avec Categories */
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

    /* Buttons Amazon Style */
    .btn-amazon-primary {
        background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: #fff !important;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-amazon-primary:hover {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        color: #fff !important;
    }

    .btn-amazon-secondary {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569 !important;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.78rem;
        font-weight: 500;
        letter-spacing: 0.03em;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-amazon-secondary:hover {
        background: #f8fafc;
        border-color: #dee2e6;
        color: #1e293b !important;
    }

    @media print {
        .sidebar, .navbar, .settings-tabs, .filters-bar, .actions-column, .pagination-container, .btn-amazon-primary, .btn-amazon-secondary {
            display: none !important;
        }
    }
</style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
    <div style="max-width: 1600px; margin: 0 auto; width: 100%; padding-top: 0;">
        <!-- Main Card -->
        <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <i class="fas fa-id-card" style="font-size: 0.8rem;"></i>
                    <span style="line-height: 1;">Gestion des Abonnements</span>
                </div>

                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.abonnements.create', $famille ? ['famille' => $famille] : []) }}" class="btn-amazon-primary">
                        <i class="fas fa-plus"></i> Nouveau pack
                    </a>
                </div>
            </div>

            {{-- Onglets par famille --}}
            @php
                $famTabStyle = fn ($actif) => 'padding:8px 16px; text-decoration:none; font-size:0.82rem; border-radius:999px; font-weight:'.($actif ? '700' : '500').'; color:'.($actif ? '#fff' : '#475569').'; background:'.($actif ? '#2563eb' : '#f1f5f9').';';
            @endphp
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px;">
                @foreach(\App\Models\Abonnement::familles() as $f)
                    <a href="{{ route('admin.abonnements.index', ['famille' => $f]) }}" style="{{ $famTabStyle($famille === $f) }}">{{ $f }} ({{ $counts[$f] ?? 0 }})</a>
                @endforeach
            </div>
            
            <!-- Barre de filtre modernisée -->
            <div class="filters-bar"
                style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
                <form action="{{ route('admin.abonnements.index') }}" method="GET" style="display: flex; align-items: center; flex: 1; position: relative;">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                    <div style="display: flex; width: 100%; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher un pack d'abonnement..."
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
                    
                    @if(request('search'))
                        <a href="{{ route('admin.abonnements.index') }}" 
                           style="margin-left: 15px; color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
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
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Nom du Pack</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 120px;">Famille</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Description</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 80px;">Com.</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 80px;">Annonces</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Limite CA</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 120px;">Prix</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;" class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abonnements as $abonnement)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.8rem; border-right: 1px solid #eff3f6;">
                                <span style="color: #0066c0; font-weight: 700;">{{ ucfirst($abonnement->nom) }}</span>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; border-right: 1px solid #eff3f6;">
                                <span class="badge-amazon" style="background:#eef2ff; color:#4338ca;">{{ $abonnement->famille }}</span>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #555; border-right: 1px solid #eff3f6;">{{ Str::limit($abonnement->description, 60) }}</td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #555; text-align: center; border-right: 1px solid #eff3f6;">{{ $abonnement->commission }}%</td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #555; text-align: center; border-right: 1px solid #eff3f6;">
                                @if($abonnement->nombre_annonces > 0)
                                    <span style="font-weight: 600;">{{ $abonnement->nombre_annonces }}</span>
                                @else
                                    <span style="font-style: italic; color: #999;">∞</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #555; text-align: center; border-right: 1px solid #eff3f6;">
                                @if($abonnement->limite_chiffre_affaires)
                                    <span style="font-weight: 600;">{{ number_format($abonnement->limite_chiffre_affaires, 0, ',', ' ') }} F</span>
                                @else
                                    <span style="font-style: italic; color: #999;">∞</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <span class="badge-amazon {{ $abonnement->actif ? 'badge-amazon-success' : 'badge-amazon-danger' }}">
                                    {{ $abonnement->actif ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #111; font-weight: 700; text-align: center; border-right: 1px solid #eff3f6;">
                                {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} F
                            </td>
                            <td style="padding: 12px 15px; text-align: right;" class="actions-column">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.abonnements.edit', $abonnement) }}" title="Modifier"
                                        style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; color: #111; text-decoration: none; transition: background 0.2s;"
                                        onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'"><i class="fas fa-pen-to-square" style="font-size: 0.95rem;"></i></a>
                                    <form id="delete-form-{{ $abonnement->id }}" action="{{ route('admin.abonnements.destroy', $abonnement) }}" method="POST"
                                        onsubmit="return confirm('Supprimer ce pack ?')" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Supprimer"
                                            style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; background: none; border: none; color: #c40000; cursor: pointer; transition: background 0.2s;"
                                            onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'"><i class="fas fa-trash" style="font-size: 0.9rem;"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucun pack d'abonnement trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links -->
            @if($abonnements->total() > 0)
                <div class="pagination-container"
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        <strong>{{ $abonnements->total() }}</strong> lignes
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($abonnements->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $abonnements->previousPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">Précédent</a>
                        @endif

                        @foreach(range(max(1, $abonnements->currentPage() - 2), min($abonnements->lastPage(), $abonnements->currentPage() + 2)) as $i)
                            @if($i == $abonnements->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1d4ed8; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $abonnements->url($i) }}"
                                    style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                    onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                    onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if($abonnements->hasMorePages())
                            <a href="{{ $abonnements->nextPageUrl() }}"
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
