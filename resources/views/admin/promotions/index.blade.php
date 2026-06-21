@extends('layouts.admin')

@section('title', 'Gestion des Promotions')

@push('styles')
<style>
    .promo-stat-card {
        background: #fff;
        border-radius: 10px;
        padding: 1.3rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        transition: box-shadow 0.2s;
    }
    .promo-stat-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
    .promo-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .promo-stat-icon.blue { background: #eff6ff; color: #2563eb; }
    .promo-stat-icon.green { background: #f0fdf4; color: #16a34a; }
    .promo-stat-icon.orange { background: #fff7ed; color: #ea580c; }
    .promo-stat-icon.red { background: #fef2f2; color: #dc2626; }
    .promo-stat-value { font-size: 1.6rem; font-weight: 800; color: #1e293b; line-height: 1; }
    .promo-stat-label { font-size: 0.8rem; color: #64748b; margin-top: 2px; }

    .promo-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 2rem 0 1rem;
    }
    .promo-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .promo-section-title i { color: #f68b1e; }

    .promo-card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1rem;
    }
    .promo-banner-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        overflow: hidden;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .promo-banner-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.08); transform: translateY(-2px); }
    .promo-banner-img { height: 110px; background: #f8fafc; overflow: hidden; position: relative; }
    .promo-banner-img img { width: 100%; height: 100%; object-fit: cover; }
    .promo-banner-img .no-img { display: flex; align-items: center; justify-content: center; height: 100%; color: #cbd5e1; font-size: 2rem; }
    .promo-banner-body { padding: 0.9rem; }
    .promo-banner-name { font-weight: 600; font-size: 0.9rem; color: #1e293b; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .promo-badge { font-size: 0.7rem; font-weight: 600; padding: 2px 8px; border-radius: 10px; }
    .promo-badge.active { background: #dcfce7; color: #15803d; }
    .promo-badge.expired { background: #fee2e2; color: #b91c1c; }
    .promo-banner-actions { display: flex; gap: 6px; margin-top: 8px; }
    .promo-btn-sm { font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; text-decoration: none; border: 1px solid #e2e8f0; color: #475569; background: #fff; transition: all 0.15s; }
    .promo-btn-sm:hover { background: #f1f5f9; color: #1e293b; }
    .promo-btn-sm.primary { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .promo-btn-sm.primary:hover { background: #dbeafe; }

    .promo-coupon-table { width: 100%; border-collapse: collapse; }
    .promo-coupon-table th { background: #f8fafc; color: #64748b; font-size: 0.75rem; font-weight: 600; padding: 8px 12px; text-align: left; border-bottom: 1px solid #e9ecef; }
    .promo-coupon-table td { padding: 10px 12px; font-size: 0.85rem; border-bottom: 1px solid #f1f5f9; color: #334155; vertical-align: middle; }
    .promo-coupon-table tr:last-child td { border-bottom: none; }
    .promo-coupon-table tr:hover td { background: #f8fafc; }
    .code-badge { font-family: monospace; background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 700; color: #1e293b; letter-spacing: 0.5px; }

    .main-content { background: #f8fafc !important; }
</style>
@endpush

@section('content')
<div style="max-width: 1400px; margin: 0 auto; padding: 0 1.5rem;">

    {{-- Page Header --}}
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.4rem; font-weight: 800; color: #1e293b; margin: 0;">
                <i class="fas fa-tags" style="color: #f68b1e; margin-right: 8px;"></i>
                Espace Promotions
            </h1>
            <p style="color: #64748b; font-size: 0.85rem; margin: 4px 0 0;">Gérez vos bannières promotionnelles et vos codes promo depuis un seul endroit.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.banners.create') }}" class="promo-btn-sm primary">
                <i class="fas fa-image"></i> Nouvelle bannière
            </a>
            <a href="{{ route('admin.coupons.create') }}" class="promo-btn-sm" style="background: #fff7ed; border-color: #fed7aa; color: #c2410c;">
                <i class="fas fa-percentage"></i> Nouveau code promo
            </a>
        </div>
    </div>





    {{-- Codes Promo Section --}}
    <div class="promo-section-header">
        <div class="promo-section-title">
            <i class="fas fa-percentage"></i> Codes promo actifs récents
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="promo-btn-sm">
            Voir tous <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    @if($latestCoupons->isEmpty())
        <div style="background: #fff; border: 1px solid #e9ecef; border-radius: 10px; padding: 2rem; text-align: center; color: #94a3b8; margin-bottom: 2rem;">
            <i class="fas fa-percentage" style="font-size: 2rem; margin-bottom: 8px;"></i><br>
            Aucun code promo actif. <a href="{{ route('admin.coupons.create') }}" style="color: #2563eb;">Créer un code promo</a>
        </div>
    @else
        <div style="background: #fff; border: 1px solid #e9ecef; border-radius: 10px; overflow: hidden; margin-bottom: 2rem;">
            <table class="promo-coupon-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Valeur</th>
                        <th>Utilisations</th>
                        <th>Expire le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestCoupons as $coupon)
                        <tr>
                            <td><span class="code-badge">{{ $coupon->code }}</span></td>
                            <td>{{ $coupon->type === 'percent' ? 'Pourcentage' : 'Montant fixe' }}</td>
                            <td>
                                <strong style="color: #f68b1e;">
                                    {{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0) . ' FCFA' }}
                                </strong>
                            </td>
                            <td>
                                {{ $coupon->usage_count ?? 0 }} / {{ $coupon->usage_limit ?? '∞' }}
                            </td>
                            <td>
                                @if($coupon->end_date)
                                    {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}
                                @else
                                    <span style="color: #94a3b8;">Sans limite</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="promo-btn-sm primary">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
