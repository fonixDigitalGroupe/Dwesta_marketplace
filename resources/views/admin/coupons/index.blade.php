@extends('layouts.admin')

@section('title', 'Gestion des Codes Promo')

@section('breadcrumbs')
    <span style="color: #111827; font-weight: 600;">Codes Promo</span>
@endsection

@section('content')
<div style="max-width: 100%;">
    <!-- En-tête -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0 0 0.5rem 0;">Codes Promo</h1>
            <p style="color: #6b7280; margin: 0; font-size: 0.95rem;">Gérez vos coupons de réduction et offres spéciales.</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" style="background-color: #004aad; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: background-color 0.2s;">
            <i class="fas fa-plus"></i> Nouveau Code Promo
        </a>
    </div>

    <!-- Filtres & Grille -->
    <div style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        
        @if($coupons->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Code</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Réduction</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Validité</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Utilisation</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Statut</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $coupon)
                            <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 1rem 1.5rem;">
                                    <div style="font-weight: 700; color: #111827; font-size: 1rem;">{{ $coupon->code }}</div>
                                    @if($coupon->category)
                                        <div style="font-size: 0.8rem; color: #6b7280; margin-top: 4px;">{{ $coupon->category->nom }}</div>
                                    @else
                                        <div style="font-size: 0.8rem; color: #6b7280; margin-top: 4px;">Toutes catégories</div>
                                    @endif
                                </td>
                                
                                <td style="padding: 1rem 1.5rem; color: #374151;">
                                    <span style="font-weight: 600; font-size: 1.1rem;">
                                        {{ $coupon->type == 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', ' ') . ' FCFA' }}
                                    </span>
                                    @if($coupon->min_purchase > 0)
                                        <div style="font-size: 0.75rem; color: #6b7280;">Dès {{ number_format($coupon->min_purchase, 0, ',', ' ') }} FCFA</div>
                                    @endif
                                </td>

                                <td style="padding: 1rem 1.5rem;">
                                    @if($coupon->start_date || $coupon->end_date)
                                        <div style="font-size: 0.85rem; color: #4b5563;">
                                            @if($coupon->start_date)Du {{ $coupon->start_date->format('d/m/Y') }}<br>@endif
                                            @if($coupon->end_date)Au {{ $coupon->end_date->format('d/m/Y') }}@endif
                                        </div>
                                    @else
                                        <span style="font-size: 0.85rem; color: #9ca3af;">Permanent</span>
                                    @endif
                                </td>

                                <td style="padding: 1rem 1.5rem; font-size: 0.9rem; color: #374151;">
                                    <strong>{{ $coupon->used_count }}</strong>
                                    @if($coupon->usage_limit)
                                        / {{ $coupon->usage_limit }}
                                    @else
                                        <span style="color: #9ca3af;">/ ∞</span>
                                    @endif
                                </td>

                                <td style="padding: 1rem 1.5rem;">
                                    <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                title="Cliquez pour changer le statut"
                                                style="background: none; border: none; padding: 4px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: all 0.2s;
                                                {{ $coupon->is_active ? 'background-color: #dcfce7; color: #166534;' : 'background-color: #fee2e2; color: #991b1b;' }}">
                                            <i class="fas fa-circle" style="font-size: 0.4rem; margin-right: 4px; vertical-align: middle;"></i>
                                            {{ $coupon->is_active ? 'Actif' : 'Inactif' }}
                                        </button>
                                    </form>
                                </td>

                                <td style="padding: 1rem 1.5rem; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                           style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 6px; background-color: #f3f4f6; color: #4b5563; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#111827';" 
                                           onmouseout="this.style.backgroundColor='#f3f4f6'; this.style.color='#4b5563';">
                                            <i class="fas fa-pen" style="font-size: 0.85rem;"></i>
                                        </a>

                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce code promo ? Cette action est irréversible.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 6px; background-color: #fee2e2; color: #dc2626; border: none; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.backgroundColor='#fecaca';" 
                                                    onmouseout="this.style.backgroundColor='#fee2e2';">
                                                <i class="fas fa-trash" style="font-size: 0.85rem;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($coupons->hasPages())
                <div style="padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; background: #fff;">
                    {{ $coupons->links() }}
                </div>
            @endif

        @else
            <div style="padding: 4rem 2rem; text-align: center;">
                <div style="width: 64px; height: 64px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem auto; color: #9ca3af;">
                    <i class="fas fa-tags" style="font-size: 1.5rem;"></i>
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0;">Aucun code promo</h3>
                <p style="color: #6b7280; font-size: 0.95rem; margin: 0 0 1.5rem 0;">Commencez par créer votre premier code promotionnel pour vos clients.</p>
                <a href="{{ route('admin.coupons.create') }}" style="background-color: #004aad; color: white; padding: 0.6rem 1.25rem; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-block;">
                    Ajouter un code
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
