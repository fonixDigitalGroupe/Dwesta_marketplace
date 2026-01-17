@extends('layouts.app')

@section('title', 'Mon Abonnement')

@section('content')
    <div style="max-width: 900px; margin: 3rem auto; padding: 2rem;">
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                    <a href="{{ route('abonnements.index') }}"
                        style="display: inline-block; color: #EF3B2D; text-decoration: none; font-weight: 500;">
                        ← Retour aux abonnements
                    </a>
                    <a href="{{ route('home') }}"
                        style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                        Accueil
                    </a>
                    <a href="{{ route('vendeur.show') }}"
                        style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                        Mon compte vendeur
                    </a>
                </div>
                <h1 style="color: #333; margin-top: 0;">Mon Abonnement</h1>
            </div>

            @if(session('success'))
                <div
                    style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div
                    style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                    {{ session('error') }}
                </div>
            @endif

            @if($abonnementActif)
                <div
                    style="background: #e3f2fd; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #1976d2;">
                    <h2 style="color: #1976d2; margin-top: 0; margin-bottom: 1rem;">{{ $abonnementActif->abonnement->nom }}</h2>

                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div>
                            <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Date de début :</strong>
                            <span style="color: #333;">{{ $abonnementActif->date_debut->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Date de fin :</strong>
                            <span style="color: #333;">{{ $abonnementActif->date_fin->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Prix mensuel :</strong>
                            <span style="color: #333;">
                                @if($abonnementActif->abonnement->prix_mensuel > 0)
                                    {{ number_format($abonnementActif->abonnement->prix_mensuel, 0, ',', ' ') }} FCFA
                                @else
                                    Gratuit
                                @endif
                            </span>
                        </div>
                        <div>
                            <strong style="color: #666; display: block; margin-bottom: 0.25rem;">Annonces utilisées :</strong>
                            <span style="color: #333;">
                                {{ $abonnementActif->nombre_annonces_utilisees }} /
                                @if($abonnementActif->abonnement->nombre_annonces == 0)
                                    ∞
                                @else
                                    {{ $abonnementActif->abonnement->nombre_annonces }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div style="background: white; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                        <h3 style="color: #333; margin-top: 0; margin-bottom: 1rem;">Caractéristiques</h3>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 0.5rem 0; color: #333;">
                                <span style="color: #28a745; margin-right: 0.5rem;">✓</span>
                                @if($abonnementActif->abonnement->nombre_annonces == 0)
                                    Annonces illimitées
                                @else
                                    {{ $abonnementActif->abonnement->nombre_annonces }} annonces/mois
                                @endif
                            </li>
                            <li style="padding: 0.5rem 0; color: #333;">
                                <span style="color: #28a745; margin-right: 0.5rem;">✓</span>
                                Commission : {{ number_format($abonnementActif->abonnement->commission, 2, ',', ' ') }}%
                            </li>
                            @if($abonnementActif->abonnement->page_pro)
                                <li style="padding: 0.5rem 0; color: #333;">
                                    <span style="color: #28a745; margin-right: 0.5rem;">✓</span>
                                    Page Pro incluse
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Renouvellement automatique -->
                    <form method="POST" action="{{ route('abonnements.toggle-renouvellement') }}"
                        style="background: white; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                        @csrf
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <strong style="color: #333; display: block; margin-bottom: 0.25rem;">Renouvellement
                                    automatique</strong>
                                <small style="color: #666;">
                                    L'abonnement sera renouvelé automatiquement à la fin de la période
                                </small>
                            </div>
                            <label
                                style="position: relative; display: inline-block; width: 60px; height: 34px; cursor: pointer;">
                                <input type="checkbox" name="activer" value="1" {{ $abonnementActif->renouvellement_automatique ? 'checked' : '' }} onchange="this.form.submit()" style="opacity: 0; width: 0; height: 0;">
                                <span
                                    style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $abonnementActif->renouvellement_automatique ? '#28a745' : '#ccc' }}; border-radius: 34px; transition: 0.4s;">
                                    <span
                                        style="position: absolute; content: ''; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; border-radius: 50%; transition: 0.4s; transform: translateX({{ $abonnementActif->renouvellement_automatique ? '26px' : '0' }});"></span>
                                </span>
                            </label>
                        </div>
                    </form>

                    @if($abonnementActif->date_fin->isPast())
                        <div
                            style="background: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; border: 1px solid #ffc107;">
                            <strong>⚠ Votre abonnement a expiré.</strong>
                            <a href="{{ route('abonnements.index') }}"
                                style="display: block; margin-top: 0.5rem; color: #856404; text-decoration: underline;">
                                Renouveler mon abonnement
                            </a>
                        </div>
                    @elseif($abonnementActif->date_fin->diffInDays(now()) <= 7)
                        <div
                            style="background: #fff3cd; color: #856404; padding: 1rem; border-radius: 4px; border: 1px solid #ffc107;">
                            <strong>⚠ Votre abonnement expire dans {{ $abonnementActif->date_fin->diffInDays(now()) }}
                                jour(s).</strong>
                            <a href="{{ route('abonnements.index') }}"
                                style="display: block; margin-top: 0.5rem; color: #856404; text-decoration: underline;">
                                Renouveler mon abonnement
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div
                    style="background: #fff3cd; color: #856404; padding: 2rem; border-radius: 8px; text-align: center; border: 1px solid #ffc107;">
                    <h2 style="color: #856404; margin-top: 0;">Aucun abonnement actif</h2>
                    <p style="color: #856404; margin-bottom: 1.5rem;">Vous n'avez pas d'abonnement actif pour le moment.</p>
                    <a href="{{ route('abonnements.index') }}"
                        style="display: inline-block; background: #EF3B2D; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                        Voir les abonnements disponibles
                    </a>
                </div>
            @endif

            @if($abonnements->count() > 0)
                <div style="margin-top: 3rem;">
                    <h2 style="color: #333; margin-bottom: 1rem;">Autres abonnements disponibles</h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                        @foreach($abonnements as $abonnement)
                            @if(!$abonnementActif || $abonnementActif->abonnement_id !== $abonnement->id)
                                <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; border: 1px solid #dee2e6;">
                                    <h3 style="color: #333; margin-top: 0; margin-bottom: 0.5rem;">{{ $abonnement->nom }}</h3>
                                    <div style="font-size: 1.5rem; font-weight: 700; color: #EF3B2D; margin-bottom: 1rem;">
                                        @if($abonnement->prix_mensuel > 0)
                                            {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA/mois
                                        @else
                                            Gratuit
                                        @endif
                                    </div>
                                    <a href="{{ route('abonnements.show', $abonnement) }}"
                                        style="display: block; text-align: center; background: #EF3B2D; color: white; padding: 0.5rem; border-radius: 4px; text-decoration: none; font-size: 0.875rem;">
                                        Voir les détails
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection