@extends('layouts.admin')

@section('title', 'Gestion des Promotions')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

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
                <a href="{{ route('admin.banners.index') }}" class="btn-amazon-secondary">
                    <i class="fas fa-image"></i> Bannières
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
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 110px;">Visuel</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Code</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 130px;">Type</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 110px;">Valeur</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 130px;">Utilisations</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 190px;">Période</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Statut</th>
                    <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                        onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">

                        <td style="padding: 8px; text-align: center; border-right: 1px solid #eff3f6;">
                            @if($coupon->banner_image)
                                <img src="{{ Storage::url($coupon->banner_image) }}" alt="{{ $coupon->code }}"
                                     style="width: 80px; height: 32px; object-fit: cover; border: 1px solid #eff3f6; background: #fff; border-radius: 2px;">
                            @else
                                <div style="width: 80px; height: 32px; background: #f1f5f9; border: 1px solid #eff3f6; border-radius: 2px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="color: #cbd5e1; font-size: 0.9rem;"></i>
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

                        <td style="padding: 12px 15px; font-size: 0.85rem; color: #475569; border-right: 1px solid #eff3f6;">
                            {{ $coupon->used_count ?? 0 }} / {{ $coupon->usage_limit ?? '∞' }}
                        </td>

                        <td style="padding: 12px 15px; font-size: 0.82rem; color: #475569; border-right: 1px solid #eff3f6;">
                            @if($coupon->start_date || $coupon->end_date)
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span>Du : <span style="font-weight: 600;">{{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') : '∞' }}</span></span>
                                    <span>Au : <span style="font-weight: 600;">{{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') : '∞' }}</span></span>
                                </div>
                            @else
                                <span style="color: #94a3b8; font-style: italic;">Permanent</span>
                            @endif
                        </td>

                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                            <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;">
                                    <span class="badge-amazon {{ $coupon->is_active ? 'badge-amazon-success' : 'badge-amazon-danger' }}">
                                        {{ $coupon->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </button>
                            </form>
                        </td>

                        <td style="padding: 12px 15px; text-align: right;">
                            <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                    style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                    onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                    onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                    Modifier
                                </a>
                                <span style="color: #ddd;">|</span>
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
                        <td colspan="8" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eff3f6;">
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

    </div>
</div>

@push('scripts')
<script>
function confirmDeleteCoupon(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c40000',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-coupon-' + id).submit();
        }
    });
}
</script>
@endpush

@endsection
