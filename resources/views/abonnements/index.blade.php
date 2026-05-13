@extends('layouts.app')

@section('title', 'Abonnements - Mady Market')

@push('styles')
<style>
    body {
        background-color: #fff !important;
    }
    .subscription-container { max-width: 800px; margin: 1.5rem auto; padding: 0 1rem; }
    
    .subscription-header {
        text-align: left;
        margin-bottom: 2rem;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 1rem;
    }

    .subscription-header h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .subscription-header p {
        color: #666;
        font-size: 0.9rem;
    }

    /* Checkbox List Layout */
    .plans-list {
        background: white;
        border-top: 1px solid #e0e0e0;
        margin-bottom: 3rem;
    }

    .plan-row {
        display: flex;
        align-items: flex-start;
        padding: 1.25rem 0.5rem;
        border-bottom: 1px solid #e0e0e0;
        gap: 1.25rem;
        cursor: pointer;
        transition: background-color 0.2s;
        position: relative;
    }

    .plan-row:hover {
        background-color: #fcfcfc;
    }

    .plan-row.selected {
        background-color: #f0f7ff;
    }

    .plan-row.is-subscribed {
        background-color: #f8fcf8;
    }

    /* Checkbox Styles */
    .plan-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid #004aad;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        flex-shrink: 0;
        margin-top: 2px;
        transition: all 0.2s;
    }

    /* Blue Checkbox when selected or active */
    .plan-row.selected .plan-checkbox,
    .plan-row.is-subscribed .plan-checkbox {
        background-color: #004aad;
        border-color: #004aad;
    }

    .plan-checkbox svg {
        width: 14px;
        height: 14px;
        color: white;
        display: none;
    }

    .plan-row.selected .plan-checkbox svg,
    .plan-row.is-subscribed .plan-checkbox svg {
        display: block;
    }

    /* Content Layout */
    .plan-info {
        flex: 1;
    }

    .plan-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 2px;
        display: block;
    }

    .plan-subtitle {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.4;
    }

    .plan-price-tag {
        font-weight: 800;
        color: #f68b1e;
    }

    .plan-status-badge {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 800;
        color: #2e7d32;
        margin-top: 4px;
        text-transform: uppercase;
    }

    .plan-row.is-restricted {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Alerts */
    .restricted-alert, .current-plan-alert {
        padding: 1rem;
        border-radius: 4px;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1rem;
        align-items: center;
        font-size: 0.9rem;
        border: 1px solid transparent;
    }

    .restricted-alert { background: #fff8e1; border-color: #ffe082; }
    .current-plan-alert { background: #e8f5e9; border-color: #c8e6c9; color: #2e7d32; }

    /* Sticky Footer */
    .btn-submit-container {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 1.25rem 2rem;
        border-top: 1px solid #e0e0e0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 2rem;
        z-index: 10;
        margin: 0 -1rem;
        box-shadow: 0 -4px 10px rgba(0,0,0,0.03);
    }

    .btn-checkout {
        background: #004aad;
        color: white;
        border: none;
        padding: 0.75rem 2.5rem;
        border-radius: 4px;
        font-size: 0.95rem;
        font-weight: 700;
        text-transform: uppercase;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-checkout:hover:not(:disabled) {
        background-color: #003680;
    }

    .btn-checkout:disabled {
        background: #e0e0e0;
        color: #999;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="subscription-container">
                <div class="subscription-header">
                    <h1>Abonnements Vendeur</h1>
                    <p>Sélectionnez un pack pour booster la visibilité de vos annonces et accéder à nos outils professionnels.</p>
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
                    
                    <div class="plans-list">
                        @foreach($abonnements as $abonnement)
                            @php 
                                $isSubscribed = $abonnementActif && $abonnementActif->abonnement_id === $abonnement->id;
                                
                                // Restriction Particulier -> Forfaits Payants
                                $isRestrictedParticular = auth()->user()->vendeur->estParticulier() && $abonnement->prix_mensuel > 0;
                                
                                // Restriction Professionnel -> Forfait Gratuit
                                $isRestrictedPro = auth()->user()->vendeur->estProfessionnel() && $abonnement->prix_mensuel == 0;
                                
                                $isRestricted = $isRestrictedParticular || $isRestrictedPro;
                            @endphp

                            <div class="plan-row {{ $isSubscribed ? 'is-subscribed' : '' }} {{ $isRestricted ? 'is-restricted' : '' }}" 
                                 onclick="{{ ($isSubscribed || $isRestricted) ? '' : 'selectPlan(this, ' . $abonnement->id . ')' }}">
                                
                                <div class="plan-checkbox">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                </div>

                                <div class="plan-info">
                                    <span class="plan-title">
                                        {{ $abonnement->nom }} 
                                        @if($abonnement->prix_mensuel > 0)
                                            — <span class="plan-price-tag">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA/mois</span>
                                        @else
                                            — <span class="plan-price-tag">Gratuit</span>
                                        @endif
                                    </span>
                                    <div class="plan-subtitle">
                                        {{ $abonnement->description }}.
                                        {{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces' }},
                                        {{ number_format($abonnement->commission, 0) }}% commission.
                                        @if($abonnement->page_pro) Inclut votre Page Boutique Pro. @endif
                                    </div>
                                    @if($isSubscribed)
                                        <span class="plan-status-badge">Votre forfait actuel</span>
                                    @elseif($isRestrictedParticular)
                                        <span class="plan-status-badge" style="color: #666;">Réservé aux comptes Pro</span>
                                    @elseif($isRestrictedPro)
                                        <span class="plan-status-badge" style="color: #c53030;">Indisponible pour les Professionnels</span>
                                    @endif
                                </div>

                                <input type="radio" name="abonnement_id" value="{{ $abonnement->id }}" {{ ($isSubscribed || $isRestricted) ? 'disabled' : '' }} style="display: none;">
                            </div>
                        @endforeach
                    </div>

                    <div class="btn-submit-container">
                        <div id="selection-summary" style="display: none; font-size: 0.9rem; color: #666;">
                            Sélection : <strong id="selected-plan-name">...</strong>
                        </div>
                        <button type="submit" class="btn-checkout" id="submit-button" disabled>
                            Confirmer mon choix
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function selectPlan(card, id) {
            document.querySelectorAll('.plan-row').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            
            const radio = card.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                const name = card.querySelector('.plan-title').innerText.split('—')[0].trim();
                document.getElementById('selected-plan-name').innerText = name;
                document.getElementById('selection-summary').style.display = 'block';
                document.getElementById('submit-button').disabled = false;
            }
        }
    </script>
@endsection
