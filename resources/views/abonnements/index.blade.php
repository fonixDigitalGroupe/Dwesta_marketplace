@extends('layouts.app')

@section('title', 'Abonnements - Mady Market')

@push('styles')
<style>
    .subscription-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
    
    .current-plan { background: linear-gradient(135deg, #bf0000 0%, #8b0000 100%); color: white; border-radius: 12px; padding: 2rem; margin-bottom: 3rem; box-shadow: 0 4px 20px rgba(191, 0, 0, 0.3); }
    .current-plan-title { font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem; }
    .current-plan-name { font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem; }
    .current-plan-expires { font-size: 0.9rem; opacity: 0.9; }
    
    .plans-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem; margin-bottom: 3rem; }
    .plan-card { background: white; border: 3px solid #e0e0e0; border-radius: 16px; padding: 2.5rem; text-align: center; transition: all 0.3s; position: relative; }
    .plan-card.recommended { border-color: #bf0000; box-shadow: 0 8px 30px rgba(191, 0, 0, 0.25); transform: scale(1.05); }
    .plan-card.recommended::before { content: '⭐ RECOMMANDÉ'; position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #bf0000; color: white; padding: 0.4rem 1.5rem; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
    .plan-card:hover { transform: translateY(-10px); box-shadow: 0 12px 40px rgba(0,0,0,0.2); }
    
    .plan-name { font-size: 1.8rem; font-weight: bold; margin-bottom: 1rem; color: #333; }
    .plan-price { font-size: 2.5rem; font-weight: bold; color: #bf0000; margin: 1.5rem 0; }
    .plan-price-label { font-size: 0.9rem; color: #666; }
    
    .plan-features { text-align: left; margin: 2rem 0; padding: 0; list-style: none; }
    .plan-features li { padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 0.75rem; }
    .plan-features li:last-child { border-bottom: none; }
    .feature-icon { color: #28a745; font-weight: bold; }
    
    .btn-subscribe { background: #bf0000; color: white; border: none; padding: 1.2rem 2.5rem; border-radius: 8px; font-weight: bold; font-size: 1.1rem; cursor: pointer; width: 100%; transition: all 0.2s; }
    .btn-subscribe:hover { background: #8b0000; transform: scale(1.02); }
    .btn-subscribe:disabled { background: #ccc; cursor: not-allowed; }
    
    .btn-current { background: #28a745; }
    .btn-current:hover { background: #28a745; transform: none; }
    
    .commission-badge { background: #fdf2f2; color: #bf0000; padding: 0.5rem 1rem; border-radius: 20px; display: inline-block; font-weight: bold; margin: 1rem 0; }
</style>
@endpush

@section('content')
<div class="subscription-container">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem; text-align: center;">Choisissez votre forfait</h1>
    <p style="text-align: center; color: #666; margin-bottom: 3rem;">Augmentez votre visibilité et réduisez vos commissions avec nos offres premium</p>

    @if($abonnementActif)
        <div class="current-plan">
            <div class="current-plan-title">Votre forfait actuel</div>
            <div class="current-plan-name">{{ $abonnementActif->abonnement->nom }}</div>
            <div class="current-plan-expires">
                Expire le {{ $abonnementActif->date_fin->format('d/m/Y') }}
                @if($abonnementActif->renouvellement_automatique)
                    • Renouvellement automatique activé
                @endif
            </div>
        </div>
    @endif

    @if(session('success'))
        <div style="background: #e6fffa; color: #2c7a7b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #b2f5ea;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="plans-grid">
        @foreach($abonnements as $index => $abonnement)
            <div class="plan-card {{ $index === 1 ? 'recommended' : '' }}">
                <div class="plan-name">{{ $abonnement->nom }}</div>
                <div class="plan-price">
                    {{ $abonnement->prix_mensuel > 0 ? number_format($abonnement->prix_mensuel, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}
                </div>
                <div class="plan-price-label">par mois</div>
                
                <div class="commission-badge">
                    Commission : {{ $abonnement->commission }}%
                </div>

                <p style="color: #666; font-size: 0.95rem; margin: 1rem 0;">{{ $abonnement->description }}</p>

                <ul class="plan-features">
                    <li>
                        <span class="feature-icon">✓</span>
                        <span>{{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces/mois' }}</span>
                    </li>
                    <li>
                        <span class="feature-icon">✓</span>
                        <span>Commission réduite à {{ $abonnement->commission }}%</span>
                    </li>
                    @if($abonnement->page_pro)
                        <li>
                            <span class="feature-icon">✓</span>
                            <span>Page Boutique personnalisée</span>
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
                    <form action="{{ route('abonnements.subscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="abonnement_id" value="{{ $abonnement->id }}">
                        <input type="hidden" name="payment_method" value="om">
                        <button type="submit" class="btn-subscribe">
                            {{ $abonnement->prix_mensuel > 0 ? 'Souscrire' : 'Activer' }}
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>

    @if($abonnementActif && $abonnementActif->renouvellement_automatique)
        <div style="text-align: center; margin-top: 2rem;">
            <form action="{{ route('abonnements.cancel') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: #666; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer;">
                    Désactiver le renouvellement automatique
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
