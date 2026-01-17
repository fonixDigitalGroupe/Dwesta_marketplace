@extends('layouts.app')

@section('title', 'Vérification Vendeur - ' . $vendeur->user->prenom . ' ' . ($vendeur->user->nom ?? ''))

@section('content')
<div style="max-width: 1000px; margin: 3rem auto; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <h1 style="color: #333; margin: 0;">Vérification Vendeur</h1>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('admin.vendeurs.verification.index') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                    ← Retour à la liste
                </a>
                <a href="{{ route('home') }}" style="display: inline-block; background: #17a2b8; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                    Accueil
                </a>
            </div>
        </div>

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Informations utilisateur -->
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
            <h2 style="color: #333; margin-bottom: 1rem;">Informations Utilisateur</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div>
                    <strong style="color: #666;">Nom complet :</strong>
                    <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->user->prenom }} {{ $vendeur->user->nom ?? '' }}</div>
                </div>
                <div>
                    <strong style="color: #666;">Email :</strong>
                    <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->user->email }}</div>
                </div>
                @if($vendeur->user->telephone)
                <div>
                    <strong style="color: #666;">Téléphone :</strong>
                    <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->user->telephone }}</div>
                </div>
                @endif
                <div>
                    <strong style="color: #666;">Date d'inscription :</strong>
                    <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->user->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Informations vendeur -->
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
            <h2 style="color: #333; margin-bottom: 1rem;">Informations Vendeur</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div>
                    <strong style="color: #666;">Type :</strong>
                    <div style="margin-top: 0.25rem;">
                        @if($vendeur->estParticulier())
                            <span style="background: #e3f2fd; color: #1976d2; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 500;">
                                Particulier
                            </span>
                        @else
                            <span style="background: #fff3e0; color: #f57c00; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 500;">
                                Professionnel
                            </span>
                        @endif
                    </div>
                </div>
                <div>
                    <strong style="color: #666;">Statut :</strong>
                    <div style="margin-top: 0.25rem;">
                        <span style="background: #ffc107; color: #333; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 500;">
                            En attente
                        </span>
                    </div>
                </div>
                <div>
                    <strong style="color: #666;">Date de demande :</strong>
                    <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Informations particulier -->
        @if($vendeur->estParticulier() && $vendeur->particulier)
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem;">Informations Particulier</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div>
                        <strong style="color: #666;">Type de document :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ strtoupper($vendeur->particulier->type_document) }}</div>
                    </div>
                    <div>
                        <strong style="color: #666;">Numéro de document :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->particulier->numero_document }}</div>
                    </div>
                    @if($vendeur->particulier->date_emission_document)
                    <div>
                        <strong style="color: #666;">Date d'émission :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->particulier->date_emission_document->format('d/m/Y') }}</div>
                    </div>
                    @endif
                    @if($vendeur->particulier->date_expiration_document)
                    <div>
                        <strong style="color: #666;">Date d'expiration :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->particulier->date_expiration_document->format('d/m/Y') }}</div>
                    </div>
                    @endif
                    @if($vendeur->particulier->lieu_emission)
                    <div>
                        <strong style="color: #666;">Lieu d'émission :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->particulier->lieu_emission }}</div>
                    </div>
                    @endif
                </div>
                @if(isset($vendeur->particulier->document_url))
                    <div style="margin-top: 1rem;">
                        <strong style="color: #666; display: block; margin-bottom: 0.5rem;">Document :</strong>
                        <a href="{{ $vendeur->particulier->document_url }}" target="_blank" style="display: inline-block; background: #EF3B2D; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">
                            Voir le document
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Informations professionnel -->
        @if($vendeur->estProfessionnel() && $vendeur->professionnel)
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 4px; margin-bottom: 2rem;">
                <h2 style="color: #333; margin-bottom: 1rem;">Informations Professionnel</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div>
                        <strong style="color: #666;">Nom de l'entreprise :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->professionnel->nom_entreprise }}</div>
                    </div>
                    <div>
                        <strong style="color: #666;">Numéro registre commerce :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->professionnel->numero_registre_commerce }}</div>
                    </div>
                    @if($vendeur->professionnel->numero_identification_fiscale)
                    <div>
                        <strong style="color: #666;">NIF :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->professionnel->numero_identification_fiscale }}</div>
                    </div>
                    @endif
                    @if($vendeur->professionnel->adresse_entreprise)
                    <div>
                        <strong style="color: #666;">Adresse :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->professionnel->adresse_entreprise }}</div>
                    </div>
                    @endif
                    @if($vendeur->professionnel->telephone_entreprise)
                    <div>
                        <strong style="color: #666;">Téléphone :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->professionnel->telephone_entreprise }}</div>
                    </div>
                    @endif
                    @if($vendeur->professionnel->email_entreprise)
                    <div>
                        <strong style="color: #666;">Email :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->professionnel->email_entreprise }}</div>
                    </div>
                    @endif
                    @if($vendeur->professionnel->date_expiration_registre)
                    <div>
                        <strong style="color: #666;">Date expiration registre :</strong>
                        <div style="color: #333; margin-top: 0.25rem;">{{ $vendeur->professionnel->date_expiration_registre->format('d/m/Y') }}</div>
                    </div>
                    @endif
                </div>
                @if(isset($vendeur->professionnel->registre_url))
                    <div style="margin-top: 1rem;">
                        <strong style="color: #666; display: block; margin-bottom: 0.5rem;">Registre de commerce :</strong>
                        <a href="{{ $vendeur->professionnel->registre_url }}" target="_blank" style="display: inline-block; background: #EF3B2D; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">
                            Voir le registre
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Actions -->
        <div style="border-top: 2px solid #dee2e6; padding-top: 2rem; margin-top: 2rem;">
            <h2 style="color: #333; margin-bottom: 1rem;">Actions</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <!-- Formulaire d'approbation -->
                <form method="POST" action="{{ route('admin.vendeurs.verification.approve', $vendeur) }}" style="background: #d4edda; padding: 1.5rem; border-radius: 4px; border: 1px solid #c3e6cb;">
                    @csrf
                    <h3 style="color: #155724; margin-top: 0; margin-bottom: 1rem;">Approuver le vendeur</h3>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: #155724; margin-bottom: 0.5rem; font-weight: 500;">Commentaire (optionnel) :</label>
                        <textarea name="commentaire" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #c3e6cb; border-radius: 4px; font-size: 1rem;"></textarea>
                    </div>
                    <button type="submit" style="background: #28a745; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer; width: 100%;">
                        ✓ Approuver
                    </button>
                </form>

                <!-- Formulaire de rejet -->
                <form method="POST" action="{{ route('admin.vendeurs.verification.reject', $vendeur) }}" style="background: #f8d7da; padding: 1.5rem; border-radius: 4px; border: 1px solid #f5c6cb;">
                    @csrf
                    <h3 style="color: #721c24; margin-top: 0; margin-bottom: 1rem;">Rejeter le vendeur</h3>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; color: #721c24; margin-bottom: 0.5rem; font-weight: 500;">Raison du rejet <span style="color: #dc3545;">*</span> :</label>
                        <textarea name="raison_rejet" rows="3" required style="width: 100%; padding: 0.75rem; border: 1px solid #f5c6cb; border-radius: 4px; font-size: 1rem;"></textarea>
                        <small style="color: #721c24; font-size: 0.875rem;">La raison du rejet sera communiquée au vendeur.</small>
                    </div>
                    <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer; width: 100%;">
                        ✗ Rejeter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

