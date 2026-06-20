@extends('layouts.admin')

@section('title', 'Gestion des Codes Promo')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
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

        .coupon-visual {
            width: 40px;
            height: 24px;
            object-fit: cover;
            border: 1px solid #eff3f6;
            background: #fff;
            border-radius: 2px;
        }
    </style>
@endpush

@section('content')
<div style="max-width: 1600px; margin: -30px auto 0; width: 100%; padding-top: 0;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
        
        {{-- Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-ticket-alt" style="font-size: 0.8rem;"></i>
                <span>Gestion des Codes Promo</span>
            </div>

            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.coupons.create') }}" class="btn-amazon-primary">
                    <i class="fas fa-plus"></i> Nouveau code
                </a>
            </div>
        </div>

        {{-- Table --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
            <thead>
                <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 80px;">Visuels</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Code & Type</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Valeur</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Restriction</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 180px;">Validité</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Statut</th>
                    <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                        onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                        
                        <td style="padding: 8px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                            <div style="display: flex; gap: 4px; justify-content: center;">
                                @if($coupon->banner_image)
                                    <img src="{{ asset('storage/' . $coupon->banner_image) }}" class="coupon-visual" title="Bannière">
                                @else
                                    <div class="coupon-visual" style="display: flex; align-items: center; justify-content: center; background: #f8fafc; color: #cbd5e1; font-size: 10px;"><i class="fas fa-image"></i></div>
                                @endif
                                @if($coupon->page_image)
                                    <img src="{{ asset('storage/' . $coupon->page_image) }}" class="coupon-visual" title="Image Page">
                                @else
                                    <div class="coupon-visual" style="display: flex; align-items: center; justify-content: center; background: #f8fafc; color: #cbd5e1; font-size: 10px;"><i class="fas fa-desktop"></i></div>
                                @endif
                            </div>
                        </td>

                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-size: 0.88rem; font-weight: 700; color: #1e293b;">{{ $coupon->code }}</div>
                            <div style="font-size: 0.72rem; color: #94a3b8; text-transform: uppercase;">{{ $coupon->type == 'percent' ? 'Pourcentage' : 'Montant Fixe' }}</div>
                        </td>

                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-size: 0.88rem; font-weight: 700; color: #0066c0;">
                                {{ number_format($coupon->value, 0, ',', ' ') }}{{ $coupon->type == 'percent' ? '%' : ' FCFA' }}
                            </div>
                            @if($coupon->min_purchase)
                                <div style="font-size: 0.72rem; color: #64748b;">Min : {{ number_format($coupon->min_purchase, 0, ',', ' ') }} FCFA</div>
                            @endif
                        </td>

                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-size: 0.82rem; color: #475569;">
                                {{ $coupon->category ? ($coupon->category->chemin ?? $coupon->category->nom) : 'Tout le site' }}
                            </div>
                        </td>

                        <td style="padding: 12px 15px; font-size: 0.82rem; color: #475569; border-right: 1px solid #eff3f6;">
                            <div style="display: flex; flex-direction: column; gap: 2px;">
                                <span>Du : <span style="font-weight: 600;">{{ $coupon->start_date ? $coupon->start_date->format('d/m/Y') : '∞' }}</span></span>
                                <span>Au : <span style="font-weight: 600;">{{ $coupon->end_date ? $coupon->end_date->format('d/m/Y') : '∞' }}</span></span>
                            </div>
                            @if($coupon->usage_limit)
                                <div style="font-size: 0.72rem; color: #94a3b8; margin-top: 4px;">Usage : {{ $coupon->used_count }}/{{ $coupon->usage_limit }}</div>
                            @endif
                        </td>

                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                            <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" method="POST">
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
                                <form id="delete-form-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $coupon->id }})"
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
                        <td colspan="7" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eff3f6;">
                            Aucun code promotionnel trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $coupons->links() }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#c40000',
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