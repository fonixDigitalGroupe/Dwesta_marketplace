@extends('layouts.app')

@section('title', 'Abonnements - Mady Market')

@push('styles')
<style>
    .subscription-container { max-width: 900px; margin: 1.5rem auto; padding: 0 1rem; }
    
    .section-header-bar {
        padding: 0.5rem 0;
        margin-bottom: 1rem;
        font-weight: bold;
        color: #333;
        text-transform: lowercase;
        border-radius: 2px;
        background: transparent;
    }

    .plans-list {
        background: white;
        border-top: 1px solid #e0e0e0;
        margin-bottom: 3rem;
    }

    .plan-row {
        display: flex;
        align-items: center;
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.2s;
        gap: 1.25rem;
        cursor: pointer;
    }

    .plan-row input[type="radio"] {
        display: none;
    }

    .plan-row:hover {
        background-color: #fafafa;
    }

    .plan-row.selected .plan-checkbox {
        background-color: #ef6c00;
        border-color: #ef6c00;
    }

    .plan-row.selected .plan-checkbox svg {
        display: block;
    }

    .plan-checkbox-wrapper {
        flex-shrink: 0;
    }

    .plan-checkbox {
        width: 22px;
        height: 22px;
        border-radius: 4px;
        border: 2px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    /* Keep the 'active' class for the currently subscribed plan */
    .plan-row.is-subscribed {
        opacity: 0.8;
        background-color: #f9f9f9;
        cursor: default;
    }

    .plan-row.is-subscribed .plan-checkbox {
        background-color: #ccc;
        border-color: #ccc;
    }
    
    .plan-row.is-subscribed .plan-checkbox svg {
        display: block;
    }

    .plan-checkbox svg {
        width: 14px;
        height: 14px;
        color: white;
        display: none;
    }

    .plan-content {
        flex: 1;
    }

    .plan-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 0.25rem;
    }

    .plan-description {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.4;
    }

    .plan-benefits {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #888;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .benefit-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .plan-right {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-shrink: 0;
    }

    .plan-price-box {
        text-align: right;
    }

    .plan-price-amount {
        font-size: 1.25rem;
        font-weight: 800;
        color: #000;
    }

    .plan-price-period {
        font-size: 0.75rem;
        color: #999;
        display: block;
    }

    .subscription-actions {
        margin-top: 2rem;
        display: flex;
        justify-content: flex-start;
    }

    .btn-submit-plan {
        padding: 1rem 3rem;
        background-color: #ef6c00;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: 800;
        font-size: 1rem;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 6px rgba(239, 108, 0, 0.2);
    }

    .btn-submit-plan:hover:not(:disabled) {
        background-color: #e65100;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(239, 108, 0, 0.3);
    }

    .btn-submit-plan:disabled {
        background-color: #e0e0e0;
        color: #999;
        cursor: not-allowed;
        box-shadow: none;
    }

    .current-plan-banner {
        background: #fff8e1;
        border: 1px solid #ffe082;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .banner-text {
        font-size: 0.95rem;
        color: #856404;
    }

    /* Override breadcrumb to match clean look */
    .breadcrumb {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 1.5rem;
    }
    .breadcrumb a { color: #555; text-decoration: none; }
    .breadcrumb a:hover { color: #ef6c00; }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('profile.show') }}">Mon Compte</a> > <span>Mes abonnements</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            <div class="subscription-container">
                <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem;">Mes abonnements</h1>
                <p style="color: #666; margin-bottom: 2rem; font-size: 0.95rem;">
                    Boostez votre activité en choisissant le forfait qui vous correspond.
                </p>

                @if(session('success'))
                    <div style="background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #c8e6c9;">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @if($abonnementActif)
                    <div class="current-plan-banner">
                        <div class="banner-text">
                            <strong>Forfait actuel : {{ $abonnementActif->abonnement->nom }}</strong><br>
                            <span style="font-size: 0.85rem;">Expire le {{ $abonnementActif->date_fin->format('d/m/Y') }}</span>
                        </div>
                        @if($abonnementActif->renouvellement_automatique)
                            <form action="{{ route('abonnements.cancel') }}" method="POST">
                                @csrf
                                <button type="submit" style="background: none; border: 1px solid #ef6c00; color: #ef6c00; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold; cursor: pointer;">
                                    Désactiver le renouvellement
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                <div class="section-header-bar">forfaits disponibles</div>

                <form action="{{ route('abonnements.checkout') }}" method="POST" id="subscription-form">
                    @csrf
                    <div class="plans-list">
                        @foreach($abonnements as $abonnement)
                            @php $isSubscribed = $abonnementActif && $abonnementActif->abonnement_id === $abonnement->id; @endphp
                            <div class="plan-row {{ $isSubscribed ? 'is-subscribed' : '' }}" 
                                 onclick="{{ $isSubscribed ? '' : 'selectPlan(this, ' . $abonnement->id . ', \'' . addslashes($abonnement->nom) . '\')' }}">
                                
                                <input type="radio" name="abonnement_id" value="{{ $abonnement->id }}" {{ $isSubscribed ? 'disabled' : '' }}>
                                
                                <div class="plan-checkbox-wrapper">
                                    <div class="plan-checkbox">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </div>
                                
                                <div class="plan-content">
                                    <div class="plan-title">{{ $abonnement->nom }}</div>
                                    <div class="plan-description">{{ $abonnement->description }}</div>
                                    <div class="plan-benefits">
                                        <div class="benefit-item">
                                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                            {{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces' }}
                                        </div>
                                        <div class="benefit-item">
                                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                            {{ number_format($abonnement->commission, 0) }}% de commission
                                    </div>
                                        @if($abonnement->page_pro)
                                            <div class="benefit-item">
                                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                                Boutique Page Pro
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="plan-right">
                                    <div class="plan-price-box">
                                        <span class="plan-price-amount">
                                            {{ $abonnement->prix_mensuel > 0 ? number_format($abonnement->prix_mensuel, 0, ',', ' ') : '0' }} FCFA
                                        </span>
                                        <span class="plan-price-period">/ mois</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="subscription-actions">
                        <button type="button" class="btn-submit-plan" id="submit-button" disabled onclick="alert('OK ' + selectedPlanName)">
                            Continuer avec ce forfait
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        let selectedPlanName = '';

        function selectPlan(row, id, name) {
            // Unselect all other rows
            document.querySelectorAll('.plan-row').forEach(r => {
                r.classList.remove('selected');
                const radio = r.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });

            // Select this row
            row.classList.add('selected');
            selectedPlanName = name;
            
            const radio = row.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                // Enable submit button
                document.getElementById('submit-button').disabled = false;
            }
        }
    </script>
@endsection
