@extends('layouts.app')

@section('title', 'Abonnements - Karnou')

@push('styles')
<style>
    body {
        background-color: #f7f8f8 !important;
    }
    
    .subscription-container { 
        max-width: 1200px; 
        margin: 2rem auto; 
        padding: 0 1.5rem; 
        font-family: 'Roboto', -apple-system, sans-serif;
    }
    
    .subscription-header {
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    .subscription-header h1 {
        font-size: 1.15rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .subscription-header p {
        color: #565959;
        font-size: 0.88rem;
        margin-top: 4px;
        max-width: none;
    }

    /* Redesigned Card Layout (Forced Single Row on Desktop) */
    .plans-grid {
        display: flex;
        flex-direction: row;
        gap: 1rem;
        margin-bottom: 4rem;
        justify-content: center;
        align-items: stretch;
    }

    @media (max-width: 991px) {
        .plans-grid {
            flex-wrap: wrap;
        }
    }

    .plan-card {
        flex: 1;
        min-width: 0; /* Allow cards to shrink to fit */
        max-width: 350px;
        background: #fff;
        border: 1px solid #d5d9d9;
        border-radius: 12px;
        padding: 0;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .plan-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        border-color: #004aad;
    }

    .plan-card.selected {
        border: 2px solid #004aad;
        box-shadow: 0 8px 16px rgba(0,74,173,0.1);
    }

    .plan-card.is-subscribed {
        border-color: #007600;
    }

    .plan-card-header {
        padding: 2rem 1.5rem;
        text-align: center;
        background: #fcfcfc;
        border-bottom: 1px solid #f0f0f0;
    }

    .plan-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .badge-pro { background: #004aad; color: white; }
    .badge-free { background: #565959; color: white; }
    .badge-active { background: #007600; color: white; }

    .plan-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f1111;
        margin-bottom: 0.5rem;
    }

    .plan-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f1111;
    }

    .plan-price small {
        font-size: 0.85rem;
        font-weight: 500;
        color: #565959;
    }

    .plan-features {
        padding: 2rem 1.5rem;
        flex: 1;
    }

    .feature-item {
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
        font-size: 0.9rem;
        color: #333;
        line-height: 1.4;
    }

    .feature-item i {
        color: #007600;
        margin-top: 3px;
        font-size: 0.8rem;
    }

    .feature-item.disabled {
        color: #999;
        text-decoration: line-through;
    }

    .feature-item.disabled i {
        color: #ddd;
    }

    .plan-footer {
        padding: 1.5rem;
        border-top: 1px solid #f0f0f0;
        text-align: center;
    }

    .plan-card.is-restricted {
        opacity: 0.7;
        filter: grayscale(0.5);
        cursor: not-allowed;
    }

    /* Rakuten inspired highlighting */
    .plan-card.popular {
        border-color: #f68b1e;
    }
    .popular-tag {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        background: #f68b1e;
        color: white;
        text-align: center;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 0;
        text-transform: uppercase;
    }

    .btn-select {
        width: 100%;
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid #004aad;
        background: transparent;
        color: #004aad;
    }

    .plan-card.selected .btn-select {
        background: #004aad;
        color: white;
    }

    .btn-select:hover:not(:disabled) {
        background: #f0f7ff;
    }

    .btn-select:disabled {
        background: #f0f2f2;
        border-color: #d5d9d9;
        color: #565959;
        cursor: not-allowed;
    }

    /* Fixed Bar */
    .checkout-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        padding: 1rem 2rem;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        z-index: 1000;
        border-top: 1px solid #d5d9d9;
    }
</style>
@endpush

@section('content')
    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="subscription-container">
                <div class="subscription-header" style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <h1>Abonnements Vendeur</h1>
                        <p>Sélectionnez un pack pour booster la visibilité de vos annonces et accéder à nos outils professionnels.</p>
                    </div>
                    <div style="font-size: 0.8rem; color: #007185; cursor: pointer; font-weight: 500; margin-bottom: 5px;">
                        <i class="far fa-question-circle"></i> Comment ça marche ?
                    </div>
                </div>

                @if(session('error_banner'))
                    <div class="restricted-alert" style="background-color: #fff5f5; color: #c53030; border: 1px solid #ffcdd2;">
                        <i class="fa-solid fa-circle-exclamation" style="font-size: 1.2rem;"></i>
                        <div style="font-weight: 500;">
                            {{ session('error_banner') }}
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="current-plan-alert">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($abonnementActif)
                    <div class="current-plan-alert">
                        <i class="fa-solid fa-star"></i>
                        <div style="flex: 1;">
                            <strong>{{ $abonnementActif->abonnement->nom }} actif</strong>
                            <div style="font-size: 0.8rem; opacity: 0.9; margin-top: 2px;">
                                Expire le {{ $abonnementActif->date_fin->format('d/m/Y') }}.
                                @if($abonnementActif->renouvellement_automatique) Renouvellement auto activé. @endif
                            </div>
                        </div>
                        @if($abonnementActif->renouvellement_automatique)
                            <form action="{{ route('abonnements.cancel') }}" method="POST">
                                @csrf
                                <button type="submit" style="background: white; border: 1px solid #c8e6c9; color: #2e7d32; padding: 4px 12px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; cursor: pointer;">
                                    Désactiver
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                @if(auth()->user()->vendeur->estParticulier())
                    <div class="restricted-alert">
                        <i class="fa-solid fa-circle-info"></i>
                        <div style="font-size: 0.85rem;">
                            <strong>Compte Vendeur Particulier</strong><br>
                            Les forfaits PRO sont réservés aux professionnels. 
                            <a href="{{ route('vendeur.create') }}" style="color: #004aad; text-decoration: underline; font-weight: 600;">Devenir PRO →</a>
                        </div>
                    </div>
                @endif

                <form action="{{ route('abonnements.subscribe') }}" method="POST" id="subscription-form">
                    @csrf
                    <input type="hidden" name="payment_method" value="cb">
                    <input type="hidden" name="abonnement_id" id="selected-abonnement-id" value="">
                    
                    <div class="plans-grid">
                        @foreach($abonnements as $abonnement)
                            @php 
                                $isSubscribed = $abonnementActif && $abonnementActif->abonnement_id === $abonnement->id;
                                $isRestrictedParticular = auth()->user()->vendeur->estParticulier() && $abonnement->prix_mensuel > 0;
                                $isRestrictedPro = auth()->user()->vendeur->estProfessionnel() && $abonnement->prix_mensuel == 0;
                                $isRestricted = $isRestrictedParticular || $isRestrictedPro;
                                $isPopular = $abonnement->nom === 'Pack Business' || $abonnement->nom === 'Vendeur Pro'; // Exemple de mise en avant
                            @endphp

                            <div class="plan-card {{ $isSubscribed ? 'is-subscribed' : '' }} {{ $isRestricted ? 'is-restricted' : '' }} {{ $isPopular ? 'popular' : '' }}" 
                                 onclick="{{ ($isSubscribed || $isRestricted) ? '' : 'selectPlan(this, ' . $abonnement->id . ')' }}">
                                
                                @if($isPopular)
                                    <div class="popular-tag">Plus Populaire</div>
                                @endif

                                <div class="plan-card-header">
                                    @if($isSubscribed)
                                        <span class="plan-badge badge-active">Actif</span>
                                    @elseif($abonnement->prix_mensuel == 0)
                                        <span class="plan-badge badge-free">Standard</span>
                                    @else
                                        <span class="plan-badge badge-pro">Professionnel</span>
                                    @endif

                                    <div class="plan-name">{{ $abonnement->nom }}</div>
                                    <div class="plan-price">
                                        @if($abonnement->prix_mensuel > 0)
                                            {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} <small>FCFA/mois</small>
                                        @else
                                            Gratuit
                                        @endif
                                    </div>
                                </div>

                                <div class="plan-features">
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span>{{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces incluses' }}</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Commission réduite ({{ number_format($abonnement->commission, 0) }}%)</span>
                                    </div>
                                    <div class="feature-item {{ $abonnement->page_pro ? '' : 'disabled' }}">
                                        <i class="fas {{ $abonnement->page_pro ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        <span>Page Boutique Pro personnalisée</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Visibilité accrue sur la marketplace</span>
                                    </div>
                                    @if($abonnement->description)
                                        <div class="feature-item" style="border-top: 1px solid #f9f9f9; padding-top: 10px; margin-top: 10px; font-style: italic; font-size: 0.8rem; color: #666;">
                                            <span>{{ $abonnement->description }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="plan-footer">
                                    @if($isSubscribed)
                                        <button type="button" class="btn-select" disabled>Abonnement actuel</button>
                                    @elseif($isRestricted)
                                        <button type="button" class="btn-select" disabled>Indisponible</button>
                                    @else
                                        <button type="button" class="btn-select">Sélectionner</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="checkout-bar" id="checkout-bar" style="display: none;">
                        <div style="font-size: 1rem; color: #333;">
                            Pack sélectionné : <strong id="selected-plan-name" style="color: #004aad;">...</strong>
                        </div>
                        <button type="submit" class="btn-amazon-primary" id="submit-button" style="min-width: 200px;">
                            Continuer vers le paiement
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function selectPlan(card, id) {
            document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            
            document.getElementById('selected-abonnement-id').value = id;
            const name = card.querySelector('.plan-name').innerText;
            document.getElementById('selected-plan-name').innerText = name;
            document.getElementById('checkout-bar').style.display = 'flex';
        }
    </script>
@endsection
