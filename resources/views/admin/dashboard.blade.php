@extends('layouts.admin')

@section('title', 'Tableau de Bord')

@section('content')
<div style="max-width: 1400px; margin: 0 auto; padding-bottom: 3rem;">

    <div style="margin-bottom: 2.5rem;">
        <h1 style="font-size: 1.6rem; font-weight: 800; color: #111; margin-bottom: 0.25rem; letter-spacing: -0.02em;">Tableau de Bord</h1>
        <p style="font-size: 0.95rem; color: #666; margin: 0;">Bienvenue dans votre centre de contrôle marketplace.</p>
    </div>

    {{-- ROW 1: KEY PERFORMANCE INDICATORS --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        
        {{-- CHIFFRE D'AFFAIRES --}}
        <div style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid #edf2f7; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="width: 48px; height: 48px; background: #ebf5ff; color: #3182ce; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fas fa-wallet"></i>
                </div>
                <span style="font-size: 0.75rem; font-weight: 700; color: #38a169; background: #f0fff4; padding: 4px 8px; border-radius: 20px;">TOTAL CA</span>
            </div>
            <div>
                <h3 style="font-size: 0.875rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem;">Volume d'affaires</h3>
                <div style="font-size: 1.5rem; font-weight: 800; color: #1a202c;">{{ number_format($stats['totalCA'], 0, ',', ' ') }} <small style="font-size: 0.9rem;">FCFA</small></div>
            </div>
        </div>

        {{-- COMMISSIONS --}}
        <div style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid #edf2f7; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="width: 48px; height: 48px; background: #fff5f5; color: #e53e3e; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fas fa-percentage"></i>
                </div>
                <span style="font-size: 0.75rem; font-weight: 700; color: #e53e3e; background: #fff5f5; padding: 4px 8px; border-radius: 20px;">PLATEFORME</span>
            </div>
            <div>
                <h3 style="font-size: 0.875rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem;">Commissions nettes</h3>
                <div style="font-size: 1.5rem; font-weight: 800; color: #1a202c;">{{ number_format($stats['totalCommissions'], 0, ',', ' ') }} <small style="font-size: 0.9rem;">FCFA</small></div>
            </div>
        </div>

        {{-- COMMANDES --}}
        <div style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid #edf2f7; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="width: 48px; height: 48px; background: #f0fff4; color: #38a169; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.85rem; font-weight: 700; color: #2d3748;">{{ $stats['ordersInProgress'] }}</div>
                    <div style="font-size: 0.65rem; color: #718096; text-transform: uppercase;">En cours</div>
                </div>
            </div>
            <div>
                <h3 style="font-size: 0.875rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem;">Total Commandes</h3>
                <div style="font-size: 1.5rem; font-weight: 800; color: #1a202c;">{{ $stats['ordersCount'] }}</div>
            </div>
        </div>

        {{-- ANNONCES --}}
        <div style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid #edf2f7; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div style="width: 48px; height: 48px; background: #faf5ff; color: #805ad5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fas fa-tags"></i>
                </div>
                @if($stats['annoncesPending'] > 0)
                    <span style="font-size: 0.7rem; font-weight: 800; color: #fff; background: #ff8c00; padding: 3px 7px; border-radius: 6px;">{{ $stats['annoncesPending'] }} À VALIDER</span>
                @endif
            </div>
            <div>
                <h3 style="font-size: 0.875rem; color: #718096; font-weight: 600; margin-bottom: 0.25rem;">Catalogue Actif</h3>
                <div style="font-size: 1.5rem; font-weight: 800; color: #1a202c;">{{ $stats['annoncesCount'] }}</div>
            </div>
        </div>

    </div>

    {{-- ROW 2: USERS & SELLERS DETAILS --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        
        {{-- UTILISATEURS --}}
        <div style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid #edf2f7;">
            <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-users" style="color: #3182ce;"></i> Communauté
            </h2>
            <div style="display: flex; align-items: center; gap: 2rem;">
                <div style="flex: 1; text-align: center; border-right: 1px solid #edf2f7;">
                    <div style="font-size: 2rem; font-weight: 800; color: #2d3748;">{{ $stats['usersCount'] }}</div>
                    <div style="font-size: 0.8rem; color: #718096;">Utilisateurs inscrits</div>
                </div>
                <div style="flex: 1; text-align: center;">
                    <div style="font-size: 1.75rem; font-weight: 800; color: #38a169;">+{{ $stats['newUsersThisMonth'] }}</div>
                    <div style="font-size: 0.8rem; color: #718096;">Ce mois-ci</div>
                </div>
            </div>
        </div>

        {{-- VENDEURS --}}
        <div style="background: #fff; border-radius: 16px; padding: 1.5rem; border: 1px solid #edf2f7;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1rem; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-store" style="color: #ff8c00;"></i> Vendeurs
                </h2>
                @if($stats['vendeursPending'] > 0)
                    <a href="{{ route('admin.vendeurs.index') }}" style="font-size: 0.75rem; font-weight: 700; color: #ff8c00; text-decoration: none; background: #fffaf0; padding: 4px 10px; border-radius: 20px;">
                        {{ $stats['vendeursPending'] }} en attente
                    </a>
                @endif
            </div>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; text-align: center;">
                <div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: #2d3748;">{{ $stats['vendeursCount'] }}</div>
                    <div style="font-size: 0.7rem; color: #718096; text-transform: uppercase;">Total</div>
                </div>
                <div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: #3182ce;">{{ $stats['proSellers'] }}</div>
                    <div style="font-size: 0.7rem; color: #718096; text-transform: uppercase;">Pros</div>
                </div>
                <div>
                    <div style="font-size: 1.25rem; font-weight: 800; color: #718096;">{{ $stats['amateurSellers'] }}</div>
                    <div style="font-size: 0.7rem; color: #718096; text-transform: uppercase;">Partic.</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ROW 3: RECENT TABLES --}}
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        
        {{-- DERNIÈRES COMMANDES --}}
        <div style="background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #edf2f7;">
            <div style="padding: 1.25rem; background: #fbfcfd; border-bottom: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 0.95rem; font-weight: 700; color: #2d3748;">Dernières Commandes</h3>
                <a href="{{ route('admin.orders.index') }}" style="font-size: 0.8rem; font-weight: 600; color: #3182ce; text-decoration: none;">Voir tout</a>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: #f8fafc; text-align: left;">
                            <th style="padding: 0.85rem 1rem; color: #718096; font-weight: 600;">Date</th>
                            <th style="padding: 0.85rem 1rem; color: #718096; font-weight: 600;">Client</th>
                            <th style="padding: 0.85rem 1rem; color: #718096; font-weight: 600;">Montant</th>
                            <th style="padding: 0.85rem 1rem; color: #718096; font-weight: 600;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['latestOrders'] as $order)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 0.85rem 1rem; color: #4a5568;">{{ $order->created_at->format('d/m H:i') }}</td>
                            <td style="padding: 0.85rem 1rem;">
                                <div style="font-weight: 600; color: #1a202c;">{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</div>
                                <div style="font-size: 0.7rem; color: #a0aec0;">Réf: {{ $order->reference }}</div>
                            </td>
                            <td style="padding: 0.85rem 1rem; font-weight: 700; color: #2d3748;">{{ number_format($order->total_final, 0, ',', ' ') }} <small>FCFA</small></td>
                            <td style="padding: 0.85rem 1rem;">
                                <span style="font-size: 0.7rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-transform: uppercase; 
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
        <div style="background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #edf2f7;">
            <div style="padding: 1.25rem; background: #fbfcfd; border-bottom: 1px solid #edf2f7;">
                <h3 style="font-size: 0.95rem; font-weight: 700; color: #2d3748;">Nouveaux Vendeurs</h3>
            </div>
            <div style="padding: 0.5rem 0;">
                @foreach($stats['latestVendeurs'] as $vendeur)
                <div style="display: flex; align-items: center; gap: 12px; padding: 0.75rem 1.25rem; border-bottom: 1px solid #f8fafc;">
                    <div style="width: 36px; height: 36px; background: #f7fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #cbd5e0; border: 1px solid #edf2f7;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.85rem; font-weight: 600; color: #2d3748;">
                            @if($vendeur->type === 'professionnel')
                                {{ $vendeur->professionnel->nom_entreprise }}
                            @else
                                {{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}
                            @endif
                        </div>
                        <div style="font-size: 0.7rem; color: #a0aec0;">{{ $vendeur->created_at->diffForHumans() }}</div>
                    </div>
                    <span style="font-size: 0.65rem; font-weight: 700; color: #718096; background: #edf2f7; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">
                        {{ $vendeur->type == 'professionnel' ? 'PRO' : 'PART' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
