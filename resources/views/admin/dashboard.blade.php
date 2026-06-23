@extends('layouts.admin')

@section('title', 'Tableau de Bord')

@section('content')
<div style="max-width: 1400px; margin: -0.75rem auto 0; padding-bottom: 1rem;">


    {{-- ROW 1: KEY PERFORMANCE INDICATORS --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 0.75rem; margin-bottom: 1rem;">
        
        {{-- CHIFFRE D'AFFAIRES --}}
        <div style="background: #fff; border-radius: 8px; padding: 0.75rem 1rem; border: 1px solid #edf2f7; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <div style="width: 34px; height: 34px; background: #ebf5ff; color: #3182ce; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                    <i class="fas fa-wallet"></i>
                </div>
                <span style="font-size: 0.65rem; font-weight: 700; color: #38a169; background: #f0fff4; padding: 2px 6px; border-radius: 4px;">TOTAL CA</span>
            </div>
            <div>
                <h3 style="font-size: 0.75rem; color: #718096; font-weight: 600; margin: 0;">Volume d'affaires</h3>
                <div style="font-size: 1.25rem; font-weight: 800; color: #1a202c;">{{ number_format($stats['totalCA'], 0, ',', ' ') }} <small style="font-size: 0.75rem;">FCFA</small></div>
            </div>
        </div>

        {{-- COMMISSIONS --}}
        <div style="background: #fff; border-radius: 8px; padding: 0.75rem 1rem; border: 1px solid #edf2f7; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <div style="width: 34px; height: 34px; background: #fff5f5; color: #e53e3e; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                    <i class="fas fa-percentage"></i>
                </div>
                <span style="font-size: 0.65rem; font-weight: 700; color: #e53e3e; background: #fff5f5; padding: 2px 6px; border-radius: 4px;">PLATEFORME</span>
            </div>
            <div>
                <h3 style="font-size: 0.75rem; color: #718096; font-weight: 600; margin: 0;">Commissions nettes</h3>
                <div style="font-size: 1.25rem; font-weight: 800; color: #1a202c;">{{ number_format($stats['totalCommissions'], 0, ',', ' ') }} <small style="font-size: 0.75rem;">FCFA</small></div>
            </div>
        </div>

        {{-- COMMANDES --}}
        <div style="background: #fff; border-radius: 8px; padding: 0.75rem 1rem; border: 1px solid #edf2f7; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <div style="width: 34px; height: 34px; background: #f0fff4; color: #38a169; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
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
        <div style="background: #fff; border-radius: 8px; padding: 0.75rem 1rem; border: 1px solid #edf2f7; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                <div style="width: 34px; height: 34px; background: #faf5ff; color: #805ad5; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
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

    {{-- ROW 2: USERS & SELLERS DETAILS --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 0.75rem; margin-bottom: 1rem;">
        
        {{-- CLIENTS --}}
        <div style="background: #fff; border-radius: 8px; padding: 1rem; border: 1px solid #edf2f7;">
            <h2 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-user-tag" style="color: #38a169; font-size: 0.85rem;"></i> Clients (Acheteurs)
            </h2>
            <div style="display: flex; align-items: center;">
                <div style="flex: 1; text-align: center; border-right: 1px solid #f1f5f9;">
                    <div style="font-size: 1.5rem; font-weight: 800; color: #2d3748;">{{ $stats['clientsCount'] }}</div>
                    <div style="font-size: 0.75rem; color: #718096;">Clients simples</div>
                </div>
                <div style="flex: 1; text-align: center;">
                    <div style="font-size: 1.25rem; font-weight: 800; color: #38a169;">+{{ $stats['newClientsThisMonth'] }}</div>
                    <div style="font-size: 0.75rem; color: #718096;">Nouveaux (mois)</div>
                </div>
            </div>
        </div>

        {{-- UTILISATEURS (TOTAL) --}}
        <div style="background: #fff; border-radius: 8px; padding: 1rem; border: 1px solid #edf2f7;">
            <h2 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-users" style="color: #3182ce; font-size: 0.85rem;"></i> Audience Globale
            </h2>
            <div style="display: flex; align-items: center;">
                <div style="flex: 1; text-align: center; border-right: 1px solid #f1f5f9;">
                    <div style="font-size: 1.5rem; font-weight: 800; color: #2d3748;">{{ $stats['usersCount'] }}</div>
                    <div style="font-size: 0.75rem; color: #718096;">Total Utilisateurs</div>
                </div>
                <div style="flex: 1; text-align: center;">
                    <div style="font-size: 1.25rem; font-weight: 800; color: #3182ce;">+{{ $stats['newUsersThisMonth'] }}</div>
                    <div style="font-size: 0.75rem; color: #718096;">Nouveaux (mois)</div>
                </div>
            </div>
        </div>

        {{-- VENDEURS --}}
        <div style="background: #fff; border-radius: 8px; padding: 1rem; border: 1px solid #edf2f7;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h2 style="font-size: 0.9rem; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-store" style="color: #ff8c00; font-size: 0.85rem;"></i> Partenaires Vendeurs
                </h2>
                @if($stats['vendeursPending'] > 0)
                    <a href="{{ route('admin.users.index', ['role' => 'vendeur', 'status' => 'attente']) }}" style="font-size: 0.65rem; font-weight: 700; color: #ff8c00; text-decoration: none; background: #fffaf0; padding: 2px 8px; border-radius: 4px;">
                        {{ $stats['vendeursPending'] }} en attente
                    </a>
                @endif
            </div>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; text-align: center;">
                <div>
                    <div style="font-size: 1.1rem; font-weight: 800; color: #2d3748;">{{ $stats['vendeursCount'] }}</div>
                    <div style="font-size: 0.65rem; color: #718096;">TOTAL</div>
                </div>
                <div>
                    <div style="font-size: 1.1rem; font-weight: 800; color: #3182ce;">{{ $stats['proSellers'] }}</div>
                    <div style="font-size: 0.65rem; color: #718096;">PROS</div>
                </div>
                <div>
                    <div style="font-size: 1.1rem; font-weight: 800; color: #718096;">{{ $stats['amateurSellers'] }}</div>
                    <div style="font-size: 0.65rem; color: #718096;">PARTIC.</div>
                </div>
            </div>
        </div>

        {{-- LOGISTIQUE --}}
        <div style="background: #fff; border-radius: 8px; padding: 1rem; border: 1px solid #edf2f7;">
            <h2 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-truck" style="color: #805ad5; font-size: 0.85rem;"></i> Logistique
            </h2>
            <div style="display: flex; align-items: center;">
                <div style="flex: 1; text-align: center; border-right: 1px solid #f1f5f9;">
                    <div style="font-size: 1.5rem; font-weight: 800; color: #2d3748;">{{ $stats['livreursCount'] }}</div>
                    <div style="font-size: 0.75rem; color: #718096;">Livreurs actifs</div>
                </div>
                <div style="flex: 1; text-align: center;">
                    <div style="font-size: 1.5rem; font-weight: 800; color: #805ad5;">{{ $stats['pointsRelaisCount'] }}</div>
                    <div style="font-size: 0.75rem; color: #718096;">Points Relais</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW 3: RECENT TABLES --}}
    <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 0.75rem;">
        
        {{-- DERNIÈRES COMMANDES --}}
        <div style="background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid #edf2f7;">
            <div style="padding: 0.75rem 1rem; background: #fbfcfd; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 0.85rem; font-weight: 700; color: #2d3748;">Dernières Flux Commandes</h3>
                <a href="{{ route('admin.orders.index') }}" style="font-size: 0.75rem; font-weight: 600; color: #3182ce; text-decoration: none;">Voir tout</a>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.8rem;">
                    <thead>
                        <tr style="background: #f8fafc; text-align: left;">
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
            <div style="padding: 0.75rem 1rem; background: #fbfcfd; border-bottom: 1px solid #edf2f7;">
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
