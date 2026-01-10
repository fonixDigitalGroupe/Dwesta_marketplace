@extends('layouts.app')

@section('title', 'Abonnement - ' . $abonnement->nom)

@section('content')
<div style="max-width: 800px; margin: 3rem auto; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <a href="{{ route('abonnements.index') }}" style="display: inline-block; color: #EF3B2D; text-decoration: none; font-weight: 500;">
                    ← Retour aux abonnements
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                        Dashboard
                    </a>
                    @if(auth()->user()->estVendeur())
                        <a href="{{ route('vendeur.show') }}" style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                            Mon compte vendeur
                        </a>
                    @endif
                @endauth
            </div>
            <h1 style="color: #333; margin-top: 0;">{{ $abonnement->nom }}</h1>
        </div>

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
            <div style="font-size: 2.5rem; font-weight: 700; color: #EF3B2D; margin-bottom: 0.5rem;">
                @if($abonnement->prix_mensuel > 0)
                    {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA
                @else
                    Gratuit
                @endif
                <span style="font-size: 1.25rem; font-weight: 400; color: #666;">/mois</span>
            </div>
            <p style="color: #666; margin: 0;">{{ $abonnement->description }}</p>
        </div>

        <div style="margin-bottom: 2rem;">
            <h2 style="color: #333; margin-bottom: 1rem;">Caractéristiques</h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="padding: 0.75rem 0; border-bottom: 1px solid #dee2e6;">
                    <strong style="color: #333;">Nombre d'annonces :</strong>
                    <span style="color: #666; margin-left: 0.5rem;">
                        @if($abonnement->nombre_annonces == 0)
                            Illimitées
                        @else
                            {{ $abonnement->nombre_annonces }} annonces par mois
                        @endif
                    </span>
                </li>
                <li style="padding: 0.75rem 0; border-bottom: 1px solid #dee2e6;">
                    <strong style="color: #333;">Commission :</strong>
                    <span style="color: #666; margin-left: 0.5rem;">{{ number_format($abonnement->commission, 2, ',', ' ') }}%</span>
                </li>
                @if($abonnement->page_pro)
                    <li style="padding: 0.75rem 0; border-bottom: 1px solid #dee2e6;">
                        <strong style="color: #333;">Page Pro :</strong>
                        <span style="color: #28a745; margin-left: 0.5rem;">✓ Incluse</span>
                    </li>
                @else
                    <li style="padding: 0.75rem 0; border-bottom: 1px solid #dee2e6;">
                        <strong style="color: #333;">Page Pro :</strong>
                        <span style="color: #666; margin-left: 0.5rem;">Non incluse</span>
                    </li>
                @endif
            </ul>
        </div>

        @if($abonnementActuel && $abonnementActuel->abonnement_id === $abonnement->id)
            <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #c3e6cb;">
                <strong>Cet abonnement est actuellement actif.</strong>
                <a href="{{ route('abonnements.mon-abonnement') }}" style="display: block; margin-top: 0.5rem; color: #155724; text-decoration: underline;">
                    Gérer mon abonnement
                </a>
            </div>
        @else
            @auth
                @if(auth()->user()->estVendeur() && auth()->user()->vendeur && auth()->user()->vendeur->estVerifie())
                    <form method="POST" action="{{ route('abonnements.souscrire', $abonnement) }}" style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px;">
                        @csrf
                        <h3 style="color: #333; margin-top: 0; margin-bottom: 1rem;">Souscrire à cet abonnement</h3>
                        
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; color: #333; margin-bottom: 0.5rem; font-weight: 500;">Durée (en mois) :</label>
                            <select name="duree_mois" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                                <option value="1">1 mois</option>
                                <option value="3">3 mois</option>
                                <option value="6">6 mois</option>
                                <option value="12">12 mois</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: flex; align-items: center; color: #333; cursor: pointer;">
                                <input type="checkbox" name="renouvellement_automatique" value="1" style="margin-right: 0.5rem;">
                                <span>Renouvellement automatique</span>
                            </label>
                            <small style="display: block; color: #666; margin-top: 0.25rem; margin-left: 1.75rem;">
                                L'abonnement sera renouvelé automatiquement à la fin de la période
                            </small>
                        </div>

                        <button type="submit" style="width: 100%; background: #EF3B2D; color: white; border: none; padding: 0.75rem; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer;">
                            Souscrire maintenant
                        </button>
                    </form>
                @elseif(auth()->user()->estVendeur() && auth()->user()->vendeur && !auth()->user()->vendeur->estVerifie())
                    <div style="background: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; border: 1px solid #ffc107;">
                        <strong>Votre compte vendeur doit être vérifié avant de souscrire à un abonnement.</strong>
                    </div>
                @else
                    <div style="background: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; border: 1px solid #ffc107;">
                        <strong>Vous devez créer un compte vendeur pour souscrire à un abonnement.</strong>
                        <a href="{{ route('vendeur.create') }}" style="display: block; margin-top: 0.5rem; color: #856404; text-decoration: underline;">
                            Créer mon compte vendeur
                        </a>
                    </div>
                @endif
            @endauth
        @endif
    </div>
</div>
@endsection

