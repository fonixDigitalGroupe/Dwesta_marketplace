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
<div style="max-width: 1200px; margin: 0 auto;">
    
    <!-- Main Conteneur style Amazon Card -->
    <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px; margin-top: -50px;">
        
        <!-- Top Action Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e7e7e7;">
            <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">Gestion des Commandes</h1>
            <div style="display: flex; gap: 8px;">
                <button onclick="window.print()" style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-print"></i> Imprimer
                </button>
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

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('admin.orders.index') }}" style="border: 1px solid #e7e7e7; padding: 15px; border-radius: 4px; margin-bottom: 20px; display: flex; gap: 20px;">
            <input type="hidden" name="status" value="{{ $status }}">
            
            <div style="flex: 1;">
                <label style="display: block; font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 5px;">Rechercher une commande</label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Référence, nom du client ou vendeur..." 
                        style="flex: 1; padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; outline: none; font-size: 0.85rem;">
                    <button type="submit" style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 20px; border-radius: 0; font-size: 0.85rem; font-weight: 400; cursor: pointer; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;">
                        Filtrer
                    </button>
                    @if($search || $status)
                        <a href="{{ route('admin.orders.index') }}" style="display: flex; align-items: center; padding: 0 10px; color: #0066c0; font-size: 0.8rem; text-decoration: none;">Effacer</a>
                    @endif
                </div>
            </div>

            <div style="width: 150px;">
                <label style="display: block; font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 5px;">Par page</label>
                <select name="per_page" onchange="this.form.submit()" class="filter-select" style="width: 100%;">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
        </form>

        <!-- Orders Table -->
        <div style="border: 1px solid #e7e7e7; border-radius: 0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; min-width: 1000px;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Référence / Date</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Client</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Vendeur</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Mode & Livraison</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Total</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 150px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-weight: 500; color: #0066c0; font-size: 0.85rem;">{{ $order->reference }}</div>
                            <div style="font-size: 0.75rem; color: #555; margin-top: 2px;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-weight: 500; font-size: 0.85rem; color: #111;">{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</div>
                            <div style="font-size: 0.75rem; color: #888;">{{ $order->buyer->email }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-weight: 500; font-size: 0.85rem; color: #111;">{{ $order->seller->user->prenom }} {{ $order->seller->user->nom }}</div>
                            <div style="font-size: 0.75rem; color: #888; margin-top: 2px;">{{ ucfirst($order->seller->type) }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-size: 0.85rem; color: #222;">{{ ucfirst($order->mode_livraison) }}</div>
                            <div style="font-size: 0.75rem; color: #666; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $order->adresse_livraison }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-weight: 700; font-size: 0.9rem; color: #111;">{{ number_format($order->total_final, 0, ',', ' ') }} <small style="font-size: 0.7rem; font-weight: 400;">FCFA</small></div>
                            <div style="font-size: 0.7rem; color: #999;">{{ $order->items->count() }} article(s)</div>
                        </td>
                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
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
                                <a href="{{ route('admin.orders.show', $order) }}" style="color: #0066c0; font-size: 0.8rem; text-decoration: none; font-weight: 500; background: #f0f7ff; padding: 2px 10px; border-radius: 2px;">Détails</a>
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
        @if($orders->total() > 0)
        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0;">
            <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                Affichage de {{ $orders->firstItem() ?? 0 }} à {{ $orders->lastItem() ?? 0 }} sur {{ $orders->total() }} commandes
            </div>
            
            <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                @if ($orders->onFirstPage())
                    <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                @endif

                @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                @else
                    <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
