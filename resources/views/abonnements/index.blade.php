@extends('layouts.app')

@section('title', 'Abonnements - Mady Market')

@push('styles')
<style>
    .subscription-container { max-width: 1100px; margin: 1.5rem auto; padding: 0 1rem; }
    
    .current-plan { 
        background: linear-gradient(135deg, #1e1e1e 0%, #333333 100%); 
        color: white; 
        border-radius: 12px; 
        padding: 1.5rem 2rem; 
        margin-bottom: 2.5rem; 
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .current-plan-info { flex: 1; }
    .current-plan-title { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-bottom: 0.25rem; }
    .current-plan-name { font-size: 1.6rem; font-weight: 800; margin: 0; }
    .current-plan-expires { font-size: 0.85rem; opacity: 0.8; margin-top: 0.25rem; }
    
    .plans-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        gap: 1.25rem; 
        margin-bottom: 3rem; 
    }
    
    .plan-card { 
        background: white; 
        border: 1px solid #e0e0e0; 
        border-radius: 12px; 
        padding: 1.5rem; 
        text-align: center; 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
        position: relative;
        display: flex;
        flex-direction: column;
    }
    
    .plan-card.recommended { 
        border: 2px solid #bf0000; 
        box-shadow: 0 10px 30px rgba(191, 0, 0, 0.08); 
        transform: translateY(-5px);
    }
    
    .plan-card.recommended::before { 
        content: 'RECOMMANDÉ'; 
        position: absolute; 
        top: -12px; 
        left: 50%; 
        transform: translateX(-50%); 
        background: #bf0000; 
        color: white; 
        padding: 0.25rem 1rem; 
        border-radius: 20px; 
        font-size: 0.7rem; 
        font-weight: 800; 
        letter-spacing: 0.5px;
    }
    
    .plan-card:hover:not(.recommended) { 
        border-color: #333;
        transform: translateY(-5px);
    }
    
    .plan-name { font-size: 1.25rem; font-weight: 700; color: #333; margin-bottom: 0.5rem; }
    .plan-price { font-size: 1.8rem; font-weight: 800; color: #bf0000; margin: 1rem 0 0.25rem; }
    .plan-price-label { font-size: 0.8rem; color: #666; margin-bottom: 1rem; }
    
    .commission-badge { 
        background: #fdf2f2; 
        color: #bf0000; 
        padding: 0.35rem 0.75rem; 
        border-radius: 6px; 
        display: inline-block; 
        font-weight: 700; 
        font-size: 0.85rem;
        margin: 0.5rem auto; 
    }

    .plan-description { color: #666; font-size: 0.85rem; margin: 1rem 0; line-height: 1.5; min-height: 3rem; }
    
    .plan-features { text-align: left; margin: 1rem 0 2rem; padding: 0; list-style: none; flex-grow: 1; }
    .plan-features li { padding: 0.5rem 0; border-bottom: 1px solid #f5f5f5; display: flex; align-items: flex-start; gap: 0.6rem; font-size: 0.85rem; color: #444; }
    .plan-features li:last-child { border-bottom: none; }
    .feature-icon { color: #2e7d32; font-weight: bold; flex-shrink: 0; }
    
    .btn-subscribe { 
        background: #bf0000; 
        color: white; 
        border: none; 
        padding: 0.8rem 1.5rem; 
        border-radius: 6px; 
        font-weight: 700; 
        font-size: 0.95rem; 
        cursor: pointer; 
        width: 100%; 
        transition: all 0.2s; 
    }
    .btn-subscribe:hover { background: #8b0000; box-shadow: 0 4px 10px rgba(191, 0, 0, 0.2); }
    .btn-subscribe:disabled { background: #e0e0e0; color: #9e9e9e; cursor: not-allowed; }
    
    .btn-current { border: 2px solid #2e7d32; background: white; color: #2e7d32; }
    .btn-current:hover { background: #f1f8e9; }

    @media (max-width: 900px) {
        .plans-grid { grid-template-columns: 1fr; }
        .plan-card.recommended { transform: none; }
    }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('profile.show') }}">Mon Compte</a> > <span>Abonnements</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="subscription-container" style="max-width: 100%; margin: 0; padding: 0;">
                <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem; text-align: center;">Choisissez votre forfait</h1>
                <p style="text-align: center; color: #666; margin-bottom: 3rem;">Augmentez votre visibilité et réduisez vos commissions avec nos offres premium</p>

                @if($abonnementActif)
                    <div class="current-plan">
                        <div class="current-plan-info">
                            <div class="current-plan-title">Votre forfait actuel</div>
                            <div class="current-plan-name">{{ $abonnementActif->abonnement->nom }}</div>
                            <div class="current-plan-expires">
                                Expire le {{ $abonnementActif->date_fin->format('d/m/Y') }}
                                @if($abonnementActif->renouvellement_automatique)
                                    • Renouvellement automatique activé
                                @endif
                            </div>
                        </div>
                        @if($abonnementActif->renouvellement_automatique)
                            <form action="{{ route('abonnements.cancel') }}" method="POST">
                                @csrf
                                <button type="submit" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4); padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                    Désactiver le renouvellement
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                @if(session('success'))
                    <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #c8e6c9; font-weight: 500;">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                <div class="plans-grid">
                    @foreach($abonnements as $index => $abonnement)
                        <div class="plan-card {{ $index === 1 ? 'recommended' : '' }}">
                            <div class="plan-name">{{ $abonnement->nom }}</div>
                            
                            <div class="commission-badge">
                                {{ $abonnement->commission }}% de commission
                            </div>

                            <div class="plan-price">
                                {{ $abonnement->prix_mensuel > 0 ? number_format($abonnement->prix_mensuel, 0, ',', ' ') : '0' }} <span style="font-size: 1rem;">FCFA</span>
                            </div>
                            <div class="plan-price-label">par mois</div>

                            <p class="plan-description">{{ $abonnement->description }}</p>

                            <ul class="plan-features">
                                <li>
                                    <span class="feature-icon">✓</span>
                                    <span>{{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces/mois' }}</span>
                                </li>
                                <li>
                                    <span class="feature-icon">✓</span>
                                    <span>Visibilité accrue</span>
                                </li>
                                @if($abonnement->page_pro)
                                    <li>
                                        <span class="feature-icon">✓</span>
                                        <span>Boutique personnalisée</span>
                                    </li>
                                @endif
                                <li>
                                    <span class="feature-icon">✓</span>
                                    <span>Support prioritaire</span>
                                </li>
                            </ul>

                            @if($abonnementActif && $abonnementActif->abonnement_id === $abonnement->id)
                                <button class="btn-subscribe btn-current" disabled>Forfait actuel</button>
                            @else
                                <form action="{{ route('abonnements.checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="abonnement_id" value="{{ $abonnement->id }}">
                                    <button type="submit" class="btn-subscribe">
                                        {{ $abonnement->prix_mensuel > 0 ? 'Souscrire' : 'Activer' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
@endsection
