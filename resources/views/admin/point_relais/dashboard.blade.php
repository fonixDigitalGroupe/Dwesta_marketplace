@extends('layouts.admin')

@section('title', 'Tableau de bord Dépôt Relais')

@section('breadcrumbs')
    > <span>Dépôt Relais</span> > <span>Tableau de bord</span>
@endsection

@section('content')
<div style="padding: 1rem 0;">
    <!-- Welcome Header -->
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; letter-spacing: -0.025em;">Pôle Logistique & Dépôts Relais</h1>
            <p style="color: #64748b; font-size: 1rem; margin-top: 0.25rem;">Bienvenue, {{ auth()->user()->prenom }}. Voici l'état de vos points de collecte.</p>
        </div>
        <div style="background: white; padding: 0.5rem 1rem; border-radius: 9999px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 10px; height: 10px; background: #10b981; border-radius: 50%; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);"></div>
            <span style="font-size: 0.875rem; font-weight: 600; color: #1e293b;">Opérationnel</span>
        </div>
    </div>

    <!-- Stats Overview -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        <!-- Arrivées Prévues -->
        <div style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="color: #64748b; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Arrivées Prévues</div>
                    <div style="font-size: 2.25rem; font-weight: 800; color: #1e293b;">{{ $stats['en_attente'] }}</div>
                </div>
                <div style="background: #eff6ff; color: #3b82f6; padding: 0.75rem; border-radius: 12px;">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.875rem; color: #64748b; display: flex; align-items: center; gap: 0.25rem;">
                <span style="color: #3b82f6; font-weight: 600;">En route</span> vers vos points
            </div>
        </div>

        <!-- Prêts pour retrait -->
        <div style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="color: #64748b; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Prêts pour Retrait</div>
                    <div style="font-size: 2.25rem; font-weight: 800; color: #1e293b;">{{ $stats['en_stock'] }}</div>
                </div>
                <div style="background: #f0fdf4; color: #22c55e; padding: 0.75rem; border-radius: 12px;">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.875rem; color: #64748b; display: flex; align-items: center; gap: 0.25rem;">
                <span style="color: #22c55e; font-weight: 600;">En stock</span> - Attente client
            </div>
        </div>

        <!-- Commissions -->
        <div style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div style="color: #64748b; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Cagnotte</div>
                    <div style="font-size: 1.75rem; font-weight: 800; color: #1e293b;">{{ number_format($user->credit_balance ?? 0, 0, ',', ' ') }} FCFA</div>
                </div>
                <div style="background: #faf5ff; color: #9333ea; padding: 0.75rem; border-radius: 12px;">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div style="margin-top: 1rem; font-size: 0.875rem; color: #64748b;">
                Solde disponible. <a href="#" style="color: #9333ea; font-weight: 600;">Retirer</a>
            </div>
        </div>
    </div>

    <!-- Active Management Tabs -->
    <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <!-- Tabs Nav -->
        <div style="display: flex; border-bottom: 1px solid #e2e8f0; background: #f8fafc; padding: 0 1.5rem;">
            <button onclick="switchTab('incoming')" id="tab-incoming-btn" class="tab-btn active-tab" style="padding: 1.25rem 1.5rem; font-weight: 700; font-size: 0.875rem; border-bottom: 2px solid #6b21a8; color: #6b21a8; background: none; border-top: none; border-left: none; border-right: none; cursor: pointer; transition: all 0.2s;">
                ARRIVAGES ({{ $incomingOrders->count() }})
            </button>
            <button onclick="switchTab('ready')" id="tab-ready-btn" class="tab-btn" style="padding: 1.25rem 1.5rem; font-weight: 700; font-size: 0.875rem; border-bottom: 2px solid transparent; color: #64748b; background: none; border-top: none; border-left: none; border-right: none; cursor: pointer; transition: all 0.2s;">
                EN STOCK ({{ $readyOrders->count() }})
            </button>
            <button onclick="switchTab('history')" id="tab-history-btn" class="tab-btn" style="padding: 1.25rem 1.5rem; font-weight: 700; font-size: 0.875rem; border-bottom: 2px solid transparent; color: #64748b; background: none; border-top: none; border-left: none; border-right: none; cursor: pointer; transition: all 0.2s;">
                HISTORIQUE
            </button>
        </div>

        <!-- Tab Content: Incoming -->
        <div id="tab-incoming" class="tab-content" style="padding: 1.5rem;">
            @forelse($incomingOrders as $order)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 1rem; transition: all 0.2s; background: #fff;">
                    <div style="display: flex; align-items: center; gap: 1.25rem; flex: 1;">
                        <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1e293b; font-size: 1rem;">CMD-{{ $order->id }}</div>
                            <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.25rem;">
                                Client : <span style="color: #1e293b; font-weight: 600;">{{ $order->buyer->prenom }} {{ $order->buyer->name }}</span>
                            </div>
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem;">
                                Expédié par : {{ $order->seller->nom_boutique ?? 'Vendeur Direct' }}
                            </div>
                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem; font-style: italic;">
                                {{ $order->items->count() }} article(s) : {{ Str::limit($order->items->map(fn($item) => $item->annonce->titre)->join(', '), 40) }}
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right; display: flex; align-items: center; gap: 1.5rem;">
                        <div style="display: none; md:block">
                            <span style="display: block; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Destination</span>
                            <span style="font-size: 0.875rem; font-weight: 600; color: #1e293b;">{{ $order->destinationPointRelais->nom }}</span>
                        </div>
                        <form action="{{ route('admin.prive.point-relais.receive', $order) }}" method="POST">
                            @csrf
                            <button type="submit" style="background: #6b21a8; color: white; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 700; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: background 0.2s;">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Réceptionner
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 4rem 2rem;">
                    <div style="background: #f8fafc; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #cbd5e1;">
                        <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4" />
                        </svg>
                    </div>
                    <h3 style="font-weight: 700; color: #1e293b; font-size: 1.125rem;">Aucun arrivage prévu</h3>
                    <p style="color: #64748b; margin-top: 0.5rem;">Tous les colis expédiés ont été réceptionnés.</p>
                </div>
            @endforelse
        </div>

        <!-- Tab Content: Ready -->
        <div id="tab-ready" class="tab-content" style="padding: 1.5rem; display: none;">
            @forelse($readyOrders as $order)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 1rem; transition: all 0.2s; background: #fff;">
                    <div style="display: flex; align-items: center; gap: 1.25rem; flex: 1;">
                        <div style="width: 48px; height: 48px; background: #f0fdf4; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #22c55e;">
                            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1e293b; font-size: 1rem;">CMD-{{ $order->id }}</div>
                            <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.25rem;">
                                Client prêt : <span style="color: #1e293b; font-weight: 600;">{{ $order->buyer->prenom }} {{ $order->buyer->name }}</span>
                            </div>
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem;">
                                Tél client : {{ $order->buyer->telephone ?? 'Non renseigné' }}
                            </div>
                            <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem; font-style: italic;">
                                {{ $order->items->count() }} article(s) : {{ Str::limit($order->items->map(fn($item) => $item->annonce->titre)->join(', '), 40) }}
                            </div>
                        </div>
                    </div>
                    <div style="text-align: right; display: flex; align-items: center; gap: 1.5rem;">
                         <div style="display: none; md:block">
                            <span style="display: block; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Code Retrait</span>
                            <span style="font-size: 0.875rem; font-weight: 700; color: #6b21a8; background: #f3e8ff; padding: 2px 8px; border-radius: 4px;">RETA-{{ $order->id }}</span>
                        </div>
                        <form action="{{ route('admin.prive.point-relais.deliver', $order) }}" method="POST">
                            @csrf
                            <button type="submit" style="background: #10b981; color: white; border: none; padding: 0.6rem 1.25rem; border-radius: 8px; font-weight: 700; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: background 0.2s;">
                                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Remettre au client
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 4rem 2rem;">
                    <div style="background: #f8fafc; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #cbd5e1;">
                         <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 style="font-weight: 700; color: #1e293b; font-size: 1.125rem;">Stock vide</h3>
                    <p style="color: #64748b; margin-top: 0.5rem;">Aucun colis n'est actuellement en attente de retrait.</p>
                </div>
            @endforelse
        </div>

        <!-- Tab Content: History -->
        <div id="tab-history" class="tab-content" style="padding: 1.5rem; display: none;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                        <tr>
                            <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 700;">Commande</th>
                            <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 700;">Client</th>
                            <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 700;">Date Retrait</th>
                            <th style="padding: 1rem; font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 700;">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deliveredOrders as $order)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 1rem; font-weight: 600; color: #1e293b;">CMD-{{ $order->id }}</td>
                                <td style="padding: 1rem; color: #64748b;">{{ $order->buyer->prenom }} {{ $order->buyer->name }}</td>
                                <td style="padding: 1rem; color: #64748b;">{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                <td style="padding: 1rem;">
                                    <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">LIVRÉ</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 3rem; text-align: center; color: #94a3b8;">Aucun historique récent.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- My Pickup Points (Managers) -->
    <div style="margin-top: 3rem;" id="points">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.75rem;">
            <svg style="width: 24px; height: 24px; color: #6b21a8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Mes Dépôts Relais Assignés
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($poids_relais as $point)
                <div style="background: white; padding: 1.5rem; border-radius: 16px; border: 1px solid #e2e8f0; display: flex; gap: 1.5rem; align-items: flex-start;">
                    <div style="width: 56px; height: 56px; background: #f5f3ff; color: #6b21a8; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg style="width: 30px; height: 30px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-weight: 800; color: #1e293b; font-size: 1.125rem;">{{ $point->nom }}</h3>
                        <p style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem; line-height: 1.5;">{{ $point->adresse }}</p>
                        <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                            <a href="tel:{{ $point->telephone }}" style="font-size: 0.875rem; font-weight: 700; color: #6b21a8; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $point->telephone ?? 'Contact non renseigné' }}
                            </a>
                            <div style="font-size: 0.75rem; font-weight: 600; color: #22c55e; background: #f0fdf4; padding: 4px 10px; border-radius: 9999px; width: fit-content;">ACTIF</div>
                        </div>
                        <div style="margin-top: 1rem;">
                            <a href="{{ route('admin.prive.point-relais.edit', $point) }}" style="display: inline-block; padding: 0.5rem 1rem; background: #f1f5f9; color: #475569; border-radius: 8px; font-size: 0.875rem; font-weight: 600; text-decoration: none; transition: all 0.2s;">
                                Modifier les infos
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // Remove active class from buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active-tab');
            btn.style.color = '#64748b';
            btn.style.borderBottomColor = 'transparent';
        });

        // Show selected content
        document.getElementById('tab-' + tabId).style.display = 'block';
        
        // Set active button
        const activeBtn = document.getElementById('tab-' + tabId + '-btn');
        activeBtn.classList.add('active-tab');
        activeBtn.style.color = '#6b21a8';
        activeBtn.style.borderBottomColor = '#6b21a8';
    }
</script>
<style>
    .active-tab {
        color: #6b21a8 !important;
        border-bottom-color: #6b21a8 !important;
    }
    .tab-btn:hover {
        color: #6b21a8 !important;
    }
    @media (max-width: 768px) {
        .tab-btn {
            padding: 1rem 0.75rem !important;
            font-size: 0.75rem !important;
        }
    }
</style>
@endpush
@endsection
