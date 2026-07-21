@extends('layouts.admin')

@section('title', 'Gestion des Options de Cartes Cadeaux')

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
        
        .filter-label {
            font-size: 0.8rem;
            color: #555;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .filter-select {
            padding: 6px 10px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: #fff;
            font-size: 0.85rem;
            color: #111;
            outline: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-input:focus,
        .filter-select:focus {
            border-color: #ff9900 !important;
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15);
        }

        @media print {
            .sidebar, .navbar, .settings-tabs, .filters-bar, .actions-column, .pagination-container, .btn-amazon-primary, .btn-amazon-secondary, .admin-sub-header, header, footer {
                display: none !important;
            }
            .main-content {
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }
            .container-fluid {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            table {
                width: 100% !important;
                border: 1px solid #111 !important;
            }
            th, td {
                border: 1px solid #111 !important;
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
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                        <i class="fas fa-gift" style="font-size: 0.8rem;"></i>
                        <span style="line-height: 1;">Cartes Cadeaux</span>
                    </div>
                </div>

                <div style="display: flex; gap: 8px;">
                    @if($giftCardOptions->total() < 3)
                        <a href="{{ route('admin.gift_cards.create') }}" class="btn-amazon-primary" style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border-color: #c05d00;">
                            <i class="fas fa-plus"></i> Nouvelle carte cadeau
                        </a>
                    @else
                        <span title="Limite de 3 cartes cadeau atteinte"
                            class="btn-amazon-secondary" style="opacity: 0.6; cursor: not-allowed; background: #f1f5f9;">
                            <i class="fas fa-lock" style="font-size: 0.7rem;"></i> Nouvelle carte cadeau (Limite atteinte)
                        </span>
                    @endif
                </div>
            </div>

            <!-- Barre de filtre -->
            <div class="filters-bar"
                style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
                <form action="{{ route('admin.gift_cards.index') }}" method="GET" style="display: flex; align-items: center; flex: 1; position: relative;">
                    <div style="display: flex; width: 100%; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher par montant ou libellé..."
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
                        <a href="{{ route('admin.gift_cards.index') }}" 
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
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 150px;">
                            Montant</th>
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">
                            Description</th>
                        <th
                            style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">
                            Populaire</th>
                        <th
                            style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">
                            Statut</th>
                        <th
                            style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;" class="actions-column">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($giftCardOptions as $option)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td
                                style="padding: 12px 15px; font-size: 0.95rem; color: #111; font-weight: 700; border-right: 1px solid #eff3f6;">
                                {{ number_format($option->amount, 0, ',', ' ') }} F
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #eff3f6;">
                                {{ $option->description ? ucfirst($option->description) : '-' }}
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                @if($option->is_popular)
                                    <span class="badge-amazon"
                                        style="background: #e77600; color: #fff;">OUI</span>
                                @else
                                    <span style="font-size: 0.75rem; color: #999;">Non</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                @if($option->is_active)
                                    <span class="badge-amazon badge-amazon-success">Active</span>
                                @else
                                    <span class="badge-amazon badge-amazon-danger">Suspendue</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: right;" class="actions-column">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.gift_cards.edit', $option) }}"
                                        style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                        onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                        onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                        Modifier
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <form id="delete-form-{{ $option->id }}"
                                        action="{{ route('admin.gift_cards.destroy', $option) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $option->id }})"
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
                            <td colspan="5"
                                style="padding: 3rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucune option de carte cadeau disponible.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($giftCardOptions->total() > 0)
                <div class="pagination-container"
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        <strong>{{ $giftCardOptions->total() }}</strong> lignes
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($giftCardOptions->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #e2e8f0; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $giftCardOptions->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #1e293b; font-size: 0.8rem; text-decoration: none; border: 1px solid #e2e8f0; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'" onmouseout="this.style.borderColor='#e2e8f0'">Précédent</a>
                        @endif

                        @foreach(range(1, $giftCardOptions->lastPage()) as $i)
                            @if($i == $giftCardOptions->currentPage())
                                <span style="padding: 6px 12px; background: #3b82f6; color: #fff; font-weight: 600; font-size: 0.8rem; border: 1px solid #3b82f6; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $giftCardOptions->url($i) }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #e2e8f0; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'" onmouseout="this.style.borderColor='#e2e8f0'">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if($giftCardOptions->hasMorePages())
                            <a href="{{ $giftCardOptions->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #1e293b; font-size: 0.8rem; text-decoration: none; border: 1px solid #e2e8f0; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'" onmouseout="this.style.borderColor='#e2e8f0'">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #e2e8f0; border-radius: 4px; cursor: not-allowed;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(id) {
                if (confirm('Êtes-vous sûr de vouloir supprimer cette option ?')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }
        </script>
    @endpush
@endsection