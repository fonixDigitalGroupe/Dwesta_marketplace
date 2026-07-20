@extends('layouts.admin')

@section('title', 'Tableau de Bord')

@section('content')
<div style="max-width: 1400px; margin: -1.5rem auto 0; padding-bottom: 1rem;">


    {{-- ROW 1: KEY PERFORMANCE INDICATORS --}}
    <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.75rem; margin-bottom: 1rem;">
        
        {{-- CHIFFRE D'AFFAIRES --}}
        <div style="background: #fff; border-radius: 10px; padding: 0.85rem 1rem; border: 1px solid #edf2f7; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; box-shadow: 0 2px 6px rgba(37,99,235,0.35);">
                    <i class="fas fa-wallet"></i>
                </div>
                <span style="font-size: 0.65rem; font-weight: 700; color: #2563eb; background: #eff6ff; padding: 2px 6px; border-radius: 4px;">TOTAL CA</span>
            </div>
            <div>
                <h3 style="font-size: 0.75rem; color: #718096; font-weight: 600; margin: 0;">Volume d'affaires</h3>
                <div style="font-size: 1.25rem; font-weight: 800; color: #1a202c;">{{ number_format($stats['totalCA'], 0, ',', ' ') }} <small style="font-size: 0.75rem;">FCFA</small></div>
            </div>
        </div>

        {{-- COMMISSIONS --}}
        <div style="background: #fff; border-radius: 10px; padding: 0.85rem 1rem; border: 1px solid #edf2f7; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #7c3aed, #6d28d9); color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; box-shadow: 0 2px 6px rgba(124,58,237,0.35);">
                    <i class="fas fa-percentage"></i>
                </div>
                <span style="font-size: 0.65rem; font-weight: 700; color: #7c3aed; background: #f5f3ff; padding: 2px 6px; border-radius: 4px;">PLATEFORME</span>
            </div>
            <div>
                <h3 style="font-size: 0.75rem; color: #718096; font-weight: 600; margin: 0;">Commissions nettes</h3>
                <div style="font-size: 1.25rem; font-weight: 800; color: #1a202c;">{{ number_format($stats['totalCommissions'], 0, ',', ' ') }} <small style="font-size: 0.75rem;">FCFA</small></div>
            </div>
        </div>

        {{-- COMMANDES --}}
        <div style="background: #fff; border-radius: 10px; padding: 0.85rem 1rem; border: 1px solid #edf2f7; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #059669, #047857); color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; box-shadow: 0 2px 6px rgba(5,150,105,0.35);">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.75rem; font-weight: 700; color: #2d3748;">{{ $stats['ordersInProgress'] }} <span style="font-weight: 400; color: #718096; font-size: 0.6rem;">EN COURS</span></div>
                </div>
            </div>
            <div>
                <h3 style="font-size: 0.75rem; color: #718096; font-weight: 600; margin: 0;">Total Commandes</h3>
                <div style="font-size: 1.25rem; font-weight: 800; color: #1a202c;">{{ $stats['ordersCount'] }}</div>
            </div>
        </div>

        {{-- ANNONCES --}}
        <div style="background: #fff; border-radius: 10px; padding: 0.85rem 1rem; border: 1px solid #edf2f7; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #ea580c, #c2410c); color: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; box-shadow: 0 2px 6px rgba(234,88,12,0.35);">
                    <i class="fas fa-tags"></i>
                </div>
                @if($stats['annoncesPending'] > 0)
                    <span style="font-size: 0.6rem; font-weight: 800; color: #fff; background: #ff8c00; padding: 2px 5px; border-radius: 4px;">{{ $stats['annoncesPending'] }} À VALIDER</span>
                @endif
            </div>
            <div>
                <h3 style="font-size: 0.75rem; color: #718096; font-weight: 600; margin: 0;">Catalogue Actif</h3>
                <div style="font-size: 1.25rem; font-weight: 800; color: #1a202c;">{{ $stats['annoncesCount'] }}</div>
            </div>
        </div>

    </div>

    {{-- ROW 2: RECENT TABLES --}}
    <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 0.75rem;">
        
        {{-- DERNIÈRES COMMANDES --}}
        <div style="background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #edf2f7;">
            <div style="padding: 0.75rem 1rem; background: #fff; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 0.85rem; font-weight: 700; color: #2d3748;">Dernières Flux Commandes</h3>
                <a href="{{ route('admin.orders.index') }}" style="font-size: 0.75rem; font-weight: 600; color: #3182ce; text-decoration: none;">Voir tout</a>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.8rem;">
                    <thead>
                        <tr style="background: #fff; text-align: left;">
                            <th style="padding: 0.5rem 0.75rem; color: #718096; font-weight: 600;">Flux / Date</th>
                            <th style="padding: 0.5rem 0.75rem; color: #718096; font-weight: 600;">Client</th>
                            <th style="padding: 0.5rem 0.75rem; color: #718096; font-weight: 600;">Montant</th>
                            <th style="padding: 0.5rem 0.75rem; color: #718096; font-weight: 600;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['latestOrders'] as $order)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.5rem 0.75rem; color: #4a5568;">{{ $order->created_at->format('d/m H:i') }}</td>
                            <td style="padding: 0.5rem 0.75rem;">
                                <div style="font-weight: 600; color: #1a202c;">{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</div>
                                <div style="font-size: 0.65rem; color: #a0aec0;">REF: {{ $order->reference }}</div>
                            </td>
                            <td style="padding: 0.5rem 0.75rem; font-weight: 700; color: #2d3748;">{{ number_format($order->total_final, 0, ',', ' ') }} <small>FCFA</small></td>
                            <td style="padding: 0.5rem 0.75rem;">
                                <span style="font-size: 0.65rem; font-weight: 700; padding: 2px 6px; border-radius: 4px; text-transform: uppercase; 
                                    @if($order->statut == 'livre') background: #f0fff4; color: #38a169;
                                    @elseif(in_array($order->statut, ['annule', 'echoue'])) background: #fff5f5; color: #e53e3e;
                                    @else background: #ebf5ff; color: #3182ce; @endif">
                                    {{ $order->statut }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- NOUVEAUX VENDEURS --}}
        <div style="background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #edf2f7;">
            <div style="padding: 0.75rem 1rem; background: #fff; border-bottom: 1px solid #edf2f7;">
                <h3 style="font-size: 0.85rem; font-weight: 700; color: #2d3748;">Nouveaux Partenaires</h3>
            </div>
            <div style="padding: 0.25rem 0;">
                @foreach($stats['latestVendeurs'] as $vendeur)
                <div style="display: flex; align-items: center; gap: 10px; padding: 0.4rem 1rem; border-bottom: 1px solid #f8fafc;">
                    <div style="width: 28px; height: 28px; background: #f7fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e0; border: 1px solid #edf2f7; font-size: 0.75rem;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.75rem; font-weight: 600; color: #2d3748; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                            @if($vendeur->type === 'professionnel')
                                {{ $vendeur->professionnel->nom_entreprise }}
                            @else
                                {{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}
                            @endif
                        </div>
                        <div style="font-size: 0.6rem; color: #a0aec0;">{{ $vendeur->created_at->diffForHumans() }}</div>
                    </div>
                    <span style="font-size: 0.55rem; font-weight: 700; color: #718096; background: #edf2f7; padding: 1px 4px; border-radius: 3px;">
                        {{ $vendeur->type == 'professionnel' ? 'PRO' : 'PART' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
