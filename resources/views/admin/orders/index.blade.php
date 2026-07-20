@extends('layouts.admin')

@section('title', 'Gestion des Commandes')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .filter-label { font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 4px; display: block; }
        .filter-select { padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; background: #fff; font-size: 0.85rem; color: #111; outline: none; cursor: pointer; }
        
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .status-paye { background-color: #e6f4ea; color: #1e7e34; }
        .status-pret { background-color: #fff4e5; color: #b7791f; }
        .status-en_route { background-color: #e7f3ff; color: #0056b3; }
        .status-livre { background-color: #f0fdf4; color: #166534; }
        .status-annule { background-color: #f3f4f6; color: #374151; }
        .status-litige { background-color: #fef2f2; color: #991b1b; }
        
        .tab-link { padding: 8px 16px; text-decoration: none; color: #555; border-bottom: 2px solid transparent; font-weight: 500; transition: all 0.2s; }
        .tab-link:hover { color: #004aad; }
        .tab-link.active { color: #004aad; border-bottom-color: #004aad; background: #f0f7ff; }
    </style>
@endpush

@section('content')
<div style="max-width: 1600px; margin: -30px auto 0; width: 100%;">

    <!-- Main Card -->
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        <!-- Card Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-shopping-basket" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">Commandes</span>
            </div>
        </div>

        @php
            $totalOrders = \App\Models\Order::count();
            $enCoursOrders = \App\Models\Order::whereIn('statut', ['paye', 'pret_expedition', 'en_route', 'disponible'])->count();
            $livreesOrders = \App\Models\Order::where('statut', 'livre')->count();
            $litigesOrders = \App\Models\Order::whereIn('statut', ['litige', 'annule'])->count();
        @endphp
        <!-- Statistiques commandes -->
        <div style="display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #eff3f6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #f5f3ff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $totalOrders }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Total des commandes</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #eff3f6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $enCoursOrders }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">En cours</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #eff3f6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-circle-check"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $livreesOrders }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Livrées</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #eff3f6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff1f2; color: #f43f5e; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $litigesOrders }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Litiges / annulées</div>
                </div>
            </div>
        </div>

        <!-- Status Filter Tabs (Amazon Style) -->
        <div style="display: flex; gap: 20px; border-bottom: 1px solid #f0f0f0; margin-bottom: 20px; padding-bottom: 0;">
            <a href="{{ route('admin.orders.index') }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ !$status ? '#c45500' : '#555' }}; font-weight: {{ !$status ? '700' : '400' }}; border-bottom: 2px solid {{ !$status ? '#c45500' : 'transparent' }};">
                Tous
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'paye']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'paye' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'paye' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'paye' ? '#c45500' : 'transparent' }};">
                Payés
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pret_expedition']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'pret_expedition' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'pret_expedition' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'pret_expedition' ? '#c45500' : 'transparent' }};">
                En préparation
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'en_route']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'en_route' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'en_route' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'en_route' ? '#c45500' : 'transparent' }};">
                En transit
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'livre']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'livre' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'livre' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'livre' ? '#c45500' : 'transparent' }};">
                Livrés
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'annule']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'annule' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'annule' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'annule' ? '#c45500' : 'transparent' }};">
                Annulés
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'litige']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'litige' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'litige' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'litige' ? '#c45500' : 'transparent' }};">
                Litiges
            </a>
        </div>

        <!-- Barre de filtre / recherche (style banners) -->
        <div style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 4px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
            <form method="GET" action="{{ route('admin.orders.index') }}" style="display: flex; align-items: center; flex: 1; gap: 12px;">
                <input type="hidden" name="status" value="{{ $status }}">
                <div style="display: flex; flex: 1; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff;" id="search-container">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Référence, nom du client ou vendeur..."
                        style="padding: 10px 16px; border: none; outline: none; flex: 1; font-size: 0.9rem; background: transparent;"
                        onfocus="document.getElementById('search-container').style.borderColor='#ff9900'; document.getElementById('search-container').style.boxShadow='0 0 0 3px rgba(255,153,0,0.15)'"
                        onblur="document.getElementById('search-container').style.borderColor='#dee2e6'; document.getElementById('search-container').style.boxShadow='none'">
                    <button type="submit"
                        style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: none; color: #fff; padding: 0 22px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-search" style="font-size: 1.1rem;"></i>
                    </button>
                </div>
                @if($search || $status)
                    <a href="{{ route('admin.orders.index') }}" style="color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;">Effacer</a>
                @endif
            </form>
        </div>

        <!-- Orders Table -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 1000px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Référence / Date</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Client</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Vendeur</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Mode & Livraison</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Total</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 150px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-weight: 700; color: #111; font-size: 0.85rem;">{{ $order->reference }}</div>
                            <div style="font-size: 0.75rem; color: #111; margin-top: 2px;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-weight: 700; font-size: 0.85rem; color: #111;">{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</div>
                            <div style="font-size: 0.75rem; color: #111;">{{ $order->buyer->email }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-weight: 700; font-size: 0.85rem; color: #111;">{{ $order->seller->user->prenom }} {{ $order->seller->user->nom }}</div>
                            <div style="font-size: 0.75rem; color: #111; margin-top: 2px;">{{ ucfirst($order->seller->type) }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-size: 0.85rem; color: #222;">{{ ucfirst($order->mode_livraison) }}</div>
                            <div style="font-size: 0.75rem; color: #666; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $order->adresse_livraison }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-weight: 700; font-size: 0.9rem; color: #111;">{{ number_format($order->total_final, 0, ',', ' ') }} <small style="font-size: 0.7rem; font-weight: 400;">FCFA</small></div>
                            <div style="font-size: 0.7rem; color: #999;">{{ $order->items->count() }} article(s)</div>
                        </td>
                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                            @php
                                $statusLabel = $order->statut_label;
                                $statusColor = '#555';
                                $statusBg = '#f3f4f6';
                                
                                switch($order->statut) {
                                    case 'paye':
                                    case 'livre':
                                        $statusColor = '#569b00';
                                        $statusBg = '#f7fff0';
                                        break;
                                    case 'pret_expedition':
                                    case 'en_route':
                                    case 'disponible':
                                        $statusColor = '#f68b1e';
                                        $statusBg = '#fff8f3';
                                        break;
                                    case 'annule':
                                    case 'litige':
                                        $statusColor = '#c40000';
                                        $statusBg = '#fff5f5';
                                        break;
                                }
                            @endphp
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 2px; font-size: 0.75rem; font-weight: 500; color: {{ $statusColor }}; background: {{ $statusBg }}; border: 1px solid {{ $statusColor }}33;">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td style="padding: 12px 15px; text-align: right;">
                            <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                <a href="{{ route('admin.orders.show', $order) }}" title="Détails"
                                    style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; color: #111; text-decoration: none; transition: background 0.2s;"
                                    onmouseover="this.style.background='#f3f4f6'"
                                    onmouseout="this.style.background='transparent'"><i class="fas fa-eye" style="font-size: 0.95rem;"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 60px; text-align: center; color: #888;">
                            <i class="fas fa-shopping-basket" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.2;"></i>
                            <p>Aucune commande trouvée pour ces critères.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px;">
            <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                Affichage de {{ $orders->firstItem() ?? 0 }} à {{ $orders->lastItem() ?? 0 }} sur {{ $orders->total() }} commandes
            </div>

            <div style="display: flex; gap: 6px; align-items: center;">
                @if ($orders->onFirstPage())
                    <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">Précédent</a>
                @endif

                @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">Suivant</a>
                @else
                    <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Suivant</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
