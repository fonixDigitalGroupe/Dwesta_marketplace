@extends('layouts.admin')

@section('title', 'Gestion des Promotions')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #ff9900 0%, #e77600 100%);
            border: 1px solid #c05d00;
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

        .btn-coupon-orange {
            background: linear-gradient(180deg, #ff9900 0%, #e77600 100%);
            border: 1px solid #c05d00;
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
        .btn-coupon-orange:hover {
            background: linear-gradient(180deg, #f08804 0%, #d87300 100%);
            color: #fff;
        }

        .badge-amazon { font-size: 0.75rem; font-weight: 600; padding: 2px 8px; border-radius: 12px; }
        .badge-amazon-success { color: #569b00; background: #f7fff0; }
        .badge-amazon-danger { color: #c40000; background: #fff5f5; }

        .code-badge {
            font-family: monospace;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: 0.5px;
        }
    </style>
@endpush

@section('content')
<div style="max-width: 1600px; margin: -30px auto 0; width: 100%; padding-top: 0;">

    {{-- Main Card --}}
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        {{-- Card Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-percentage" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">Gestion des Codes Promo</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.campaigns.create') }}" class="btn-amazon-primary">
                    <i class="fas fa-bullhorn"></i> Nouvelle Campagne
                </a>

                <a href="{{ route('admin.coupons.create') }}" class="btn-coupon-orange">
                    <i class="fas fa-plus"></i> Nouveau code promo
                </a>
            </div>
        </div>

        {{-- Barre de filtre / recherche --}}
        <div style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 4px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
            <form action="{{ route('admin.promotions.index') }}" method="GET" style="display: flex; align-items: center; flex: 1; position: relative;">
                <input type="hidden" name="per_page" value="{{ request('per_page', 15) }}">
                <div style="display: flex; width: 100%; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un code promo..."
                        style="padding: 10px 16px; border: none; outline: none; flex: 1; font-size: 0.9rem; background: transparent;"
                        onfocus="document.getElementById('search-container').style.borderColor='#ff9900'; document.getElementById('search-container').style.boxShadow='0 0 0 3px rgba(255,153,0,0.15)'"
                        onblur="document.getElementById('search-container').style.borderColor='#dee2e6'; document.getElementById('search-container').style.boxShadow='none'">
                    <button type="submit"
                        style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: none; color: #fff; padding: 0 22px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                        onmouseover="this.style.background='linear-gradient(180deg,#f08804 0%,#d87300 100%)'"
                        onmouseout="this.style.background='linear-gradient(180deg,#ff9900 0%,#e77600 100%)'">
                        <i class="fas fa-search" style="font-size: 1.1rem;"></i>
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.promotions.index', ['per_page' => request('per_page', 15)]) }}"
                       style="margin-left: 15px; color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                       onmouseover="this.style.textDecoration='underline'"
                       onmouseout="this.style.textDecoration='none'">Effacer</a>
                @endif
            </form>

            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555; border-left: 1px solid #eff3f6; padding-left: 15px;">
                <span>Afficher</span>
                <select onchange="window.location.href='{{ route('admin.promotions.index') }}?per_page='+this.value+'&search={{ request('search') }}'"
                    style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; background: #fff; font-size: 0.8rem; color: #475569; cursor: pointer; outline: none;">
                    <option value="15"  {{ request('per_page', 15) == 15  ? 'selected' : '' }}>15</option>
                    <option value="25"  {{ request('per_page') == 25  ? 'selected' : '' }}>25</option>
                    <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
            <thead>
                <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Home</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Page</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Code</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 130px;">Type</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 110px;">Valeur</th>
                    <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 220px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                        onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">

                        <td style="padding: 8px; text-align: center; border-right: 1px solid #eff3f6;">
                            @if($coupon->banner_image)
                                <img src="{{ Storage::url($coupon->banner_image) }}" alt="Home"
                                     style="width: 70px; height: 28px; object-fit: cover; border: 1px solid #eff3f6; background: #fff; border-radius: 2px;">
                            @else
                                <div style="width: 70px; height: 28px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="color: #cbd5e1; font-size: 0.8rem;"></i>
                                </div>
                            @endif
                        </td>

                        <td style="padding: 8px; text-align: center; border-right: 1px solid #eff3f6;">
                            @if($coupon->landing_page_image)
                                <img src="{{ Storage::url($coupon->landing_page_image) }}" alt="Page"
                                     style="width: 70px; height: 28px; object-fit: cover; border: 1px solid #eff3f6; background: #fff; border-radius: 2px;">
                            @else
                                <div style="width: 70px; height: 28px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-desktop" style="color: #cbd5e1; font-size: 0.8rem;"></i>
                                </div>
                            @endif
                        </td>

                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <span class="code-badge">{{ $coupon->code }}</span>
                            @if($coupon->min_purchase)
                                <div style="font-size: 0.72rem; color: #94a3b8; margin-top: 3px;">Min: {{ number_format($coupon->min_purchase, 0) }} FCFA</div>
                            @endif
                        </td>

                        <td style="padding: 12px 15px; font-size: 0.85rem; color: #475569; border-right: 1px solid #eff3f6;">
                            {{ $coupon->type === 'percent' ? 'Pourcentage' : 'Montant fixe' }}
                        </td>

                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <strong style="color: #ff9900; font-size: 0.9rem;">
                                {{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0) . ' FCFA' }}
                            </strong>
                        </td>


                        <td style="padding: 12px 15px; text-align: right;">
                            <div style="display: flex; gap: 12px; justify-content: flex-end; align-items: center;">
                                <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0; display: flex; align-items: center;">
                                        <span class="badge-amazon {{ $coupon->is_active ? 'badge-amazon-success' : 'badge-amazon-danger' }}" style="font-size: 0.65rem; padding: 2px 6px;">
                                            {{ $coupon->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </button>
                                </form>
                                <span style="color: #eee;">|</span>
                                <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                    style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                    onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                    onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                    Modifier
                                </a>
                                <span style="color: #eee;">|</span>
                                <form id="delete-coupon-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDeleteCoupon({{ $coupon->id }})"
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
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eff3f6;">
                            Aucun code promo trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($coupons->total() > 0)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    <strong>{{ $coupons->total() }}</strong> code(s) promo
                </div>
                <div style="display: flex; gap: 4px;">
                    @if($coupons->onFirstPage())
                        <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                    @else
                        <a href="{{ $coupons->previousPageUrl() }}"
                            style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                            onmouseover="this.style.background='#f8fafc'"
                            onmouseout="this.style.background='#fff'">Précédent</a>
                    @endif

                    @foreach(range(max(1, $coupons->currentPage() - 2), min($coupons->lastPage(), $coupons->currentPage() + 2)) as $i)
                        @if($i == $coupons->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1e40af; border-radius: 4px;">{{ $i }}</span>
                        @else
                            <a href="{{ $coupons->url($i) }}"
                                style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;"
                                onmouseover="this.style.background='#f8fafc'"
                                onmouseout="this.style.background='#fff'">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($coupons->hasMorePages())
                        <a href="{{ $coupons->nextPageUrl() }}"
                            style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;"
                            onmouseover="this.style.background='#f8fafc'"
                            onmouseout="this.style.background='#fff'">Suivant</a>
                    @else
                        <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Suivant</span>
                    @endif
                </div>
            </div>
        @endif

        {{-- Section Historique des Campagnes --}}
        <div style="margin-top: 40px; border-top: 2px solid #eff3f6; padding-top: 25px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 20px;">
                <i class="fas fa-history" style="font-size: 0.8rem;"></i>
                <span>Historique des Campagnes Envoyées</span>
            </div>

            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 150px;">Date</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 120px;">Coupon</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Début</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Fin</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Statut</th>
                        <th style="padding: 12px 15px; text-align: center; font-weight: 700; color: #475569; font-size: 0.75rem; border-right: 1px solid #eff3f6;">ENVOYÉS</th>
                        <th style="padding: 12px 15px; text-align: right; font-weight: 700; color: #475569; font-size: 0.75rem;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6; font-size: 0.82rem; color: #475569;">
                                {{ $campaign->created_at->format('d/m/Y') }}
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                                <span class="code-badge">{{ $campaign->coupon->code ?? 'N/A' }}</span>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; font-size: 0.82rem; color: #475569; border-right: 1px solid #eff3f6;">
                                {{ $campaign->starts_at ? $campaign->starts_at->format('d/m/Y') : '-' }}
                            </td>
                            <td style="padding: 12px 15px; text-align: center; font-size: 0.82rem; color: #475569; border-right: 1px solid #eff3f6;">
                                {{ $campaign->ends_at ? $campaign->ends_at->format('d/m/Y') : '-' }}
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                @php
                                    $now = now();
                                    $status = 'Active';
                                    $statusColor = '#569b00';
                                    $statusBg = '#f7fff0';

                                    if ($campaign->ends_at && $campaign->ends_at->isPast()) {
                                        $status = 'Terminée';
                                        $statusColor = '#c40000';
                                        $statusBg = '#fff5f5';
                                    } elseif ($campaign->starts_at && $campaign->starts_at->isFuture()) {
                                        $status = 'À venir';
                                        $statusColor = '#0066c0';
                                        $statusBg = '#f0f7ff';
                                    }
                                @endphp
                                <span class="badge-amazon" style="color: {{ $statusColor }}; background: {{ $statusBg }};">
                                    {{ $status }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; font-weight: 700; color: #1e293b; border-right: 1px solid #eff3f6;">
                                {{ $campaign->sent_count }}
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <button type="button" 
                                        onclick="showCampaignDetails('{{ addslashes($campaign->subject) }}', '{{ addslashes($campaign->message) }}')"
                                        style="background: none; border: none; color: #0066c0; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                        onmouseover="this.style.textDecoration='underline'"
                                        onmouseout="this.style.textDecoration='none'">
                                        Détails
                                    </button>
                                    <span style="color: #eee;">|</span>
                                    <a href="{{ route('admin.campaigns.edit', $campaign) }}"
                                        style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                        onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                        onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                        Modifier
                                    </a>
                                    <span style="color: #eee;">|</span>
                                    <form id="delete-campaign-{{ $campaign->id }}" action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteCampaign({{ $campaign->id }})"
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
                            <td colspan="7" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucune campagne envoyée pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination Campagnes --}}
            @if($campaigns->total() > 0)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        <strong>{{ $campaigns->total() }}</strong> campagne(s)
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($campaigns->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $campaigns->previousPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.background='#f8fafc'"
                                onmouseout="this.style.background='#fff'">Précédent</a>
                        @endif

                        @foreach(range(max(1, $campaigns->currentPage() - 2), min($campaigns->lastPage(), $campaigns->currentPage() + 2)) as $i)
                            @if($i == $campaigns->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1e40af; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $campaigns->url($i) }}"
                                    style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;"
                                    onmouseover="this.style.background='#f8fafc'"
                                    onmouseout="this.style.background='#fff'">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if($campaigns->hasMorePages())
                            <a href="{{ $campaigns->nextPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;"
                                onmouseover="this.style.background='#f8fafc'"
                                onmouseout="this.style.background='#fff'">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>

<style>
    .swal2-title-small {
        font-size: 1.15rem !important;
        font-weight: 700 !important;
        color: #334155 !important;
    }
</style>

@push('scripts')
<script>
function confirmDeleteCoupon(id) {
    Swal.fire({
        title: 'Supprimer ce coupon ?',
        customClass: {
            title: 'swal2-title-small'
        },
        text: "Voulez-vous vraiment supprimer ce coupon ? Cette action est irréversible.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-coupon-' + id).submit();
        }
    });
}

function showCampaignDetails(subject, message) {
    // Linkifier simple pour le modal
    let linkedMessage = message
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;")
        .replace(/\*\*(.*?)\*\*/g, '<strong style="font-weight: 700; color: #1e293b;">$1</strong>')
        .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" style="color: #004aad; text-decoration: underline; font-weight: 600;">$1</a>')
        .replace(/(?<!href=")(?<!">)(https?:\/\/[^\s\(\)<>]+)/g, '<a href="$1" style="color: #004aad; text-decoration: underline; font-weight: 600;">$1</a>')
        .replace(/\n/g, '<br>');

    Swal.fire({
        title: 'Détails de la campagne',
        customClass: {
            title: 'swal2-title-small'
        },
        html: `
            <div style="text-align: left; padding: 10px;">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">Sujet</label>
                    <div style="font-size: 0.9rem; color: #1e293b; font-weight: 600; background: #f8fafc; padding: 8px; border-radius: 4px;">${subject}</div>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">Message</label>
                    <div style="font-size: 0.9rem; color: #475569; background: #f8fafc; padding: 12px; border-radius: 4px; line-height: 1.5;">${linkedMessage}</div>
                </div>
            </div>
        `,
        confirmButtonText: 'Fermer',
        confirmButtonColor: '#0066c0',
    });
}

function confirmDeleteCampaign(id) {
    Swal.fire({
        title: 'Supprimer la campagne ?',
        customClass: {
            title: 'swal2-title-small'
        },
        text: "Voulez-vous vraiment retirer cette campagne de l'historique ? Cela supprimera également les messages associés dans la messagerie des vendeurs.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-campaign-' + id).submit();
        }
    });
}

</script>
@endpush

@endsection
