@extends('layouts.admin')

@section('title', 'Vérification Vendeur - ' . ($vendeur->user->prenom ?? 'Utilisateur') . ' ' . ($vendeur->user->nom ?? 'Inconnu'))

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <a href="{{ route('admin.dashboard') }}">Administration</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <a href="{{ route('admin.vendeurs.verification.index') }}">Vérifications</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <span style="color: var(--mady-red); font-weight: 700;">Détails Vendeur</span>
@endsection

@section('content')
<div class="card-pro" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--slate-900); margin: 0;">Vérification Vendeur</h1>
            <p style="color: var(--slate-500); font-weight: 500; margin-top: 0.25rem;">Examinez les informations et documents du marchand.</p>
        </div>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('admin.vendeurs.verification.index') }}" class="btn-pro-secondary">
                ← Retour à la liste
            </a>
        </div>
    </div>

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #f5c6cb; font-weight: 600;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #c3e6cb; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
        
        <!-- Informations utilisateur -->
        <div style="background: var(--slate-50); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--slate-100);">
            <h2 style="font-size: 1rem; font-weight: 800; color: var(--slate-900); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Informations Utilisateur
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div>
                    <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Nom complet</strong>
                    <div style="font-weight: 700; color: var(--slate-900);">{{ $vendeur->user->prenom ?? 'Utilisateur' }} {{ $vendeur->user->nom ?? 'Inconnu' }}</div>
                </div>
                <div>
                    <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Email</strong>
                    <div style="font-weight: 700; color: var(--slate-900);">{{ $vendeur->user->email ?? 'Email non disponible' }}</div>
                </div>
                @if(isset($vendeur->user) && $vendeur->user->telephone)
                <div>
                    <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Téléphone</strong>
                    <div style="font-weight: 700; color: var(--slate-900);">{{ $vendeur->user->telephone }}</div>
                </div>
                @endif
                <div>
                    <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Date d'inscription</strong>
                    <div style="font-weight: 700; color: var(--slate-900);">{{ isset($vendeur->user) ? $vendeur->user->created_at->format('d/m/Y H:i') : 'Inconnue' }}</div>
                </div>
            </div>
        </div>

        <!-- Informations vendeur -->
        <div style="background: var(--slate-50); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--slate-100);">
            <h2 style="font-size: 1rem; font-weight: 800; color: var(--slate-900); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Détails du Compte Vendeur
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Type de Compte</strong>
                    <div style="margin-top: 0.5rem;">
                        @if($vendeur->estParticulier())
                            <span style="display: inline-flex; align-items: center; padding: 4px 12px; background: #e0f2fe; color: #0369a1; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">Particulier</span>
                        @else
                            <span style="display: inline-flex; align-items: center; padding: 4px 12px; background: #fef3c7; color: #b45309; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">Professionnel</span>
                        @endif
                    </div>
                </div>
                <div>
                    <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Statut de Vérification</strong>
                    <div style="margin-top: 0.5rem;">
                        @if($vendeur->statut_verification === 'en_attente')
                            <span style="display: inline-flex; align-items: center; padding: 4px 12px; background: #fef3c7; color: #b45301; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                En attente
                            </span>
                        @elseif($vendeur->statut_verification === 'verifie')
                            <span style="display: inline-flex; align-items: center; padding: 4px 12px; background: #dcfce7; color: #15803d; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Vérifié
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; padding: 4px 12px; background: #fee2e2; color: #b91c1c; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Rejeté
                            </span>
                        @endif
                    </div>
                </div>
                <div>
                    <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Date de demande</strong>
                    <div style="font-weight: 700; color: var(--slate-900);">{{ $vendeur->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Informations spécifiques -->
        @if($vendeur->estParticulier() && $vendeur->particulier)
            <div style="background: var(--slate-50); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--slate-100);">
                <h2 style="font-size: 1rem; font-weight: 800; color: var(--slate-900); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Détails de la CNI / Passeport
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Type & Numéro</strong>
                        <div style="font-weight: 700; color: var(--slate-900);">{{ strtoupper($vendeur->particulier->type_document) }} - {{ $vendeur->particulier->numero_document }}</div>
                    </div>
                    @if($vendeur->particulier->date_expiration_document)
                    <div>
                        <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Expiration</strong>
                        <div style="font-weight: 700; color: var(--slate-900);">{{ $vendeur->particulier->date_expiration_document->format('d/m/Y') }}</div>
                    </div>
                    @endif
                    @if(isset($vendeur->particulier->document_url))
                    <div>
                        <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Justificatif</strong>
                        <a href="{{ $vendeur->particulier->document_url }}" target="_blank" class="btn-pro-secondary" style="padding: 6px 12px; font-size: 0.7rem; display: inline-flex; gap: 4px; margin-top: 4px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            Ouvrir le document
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        @elseif($vendeur->estProfessionnel() && $vendeur->professionnel)
            <div style="background: var(--slate-50); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--slate-100);">
                <h2 style="font-size: 1rem; font-weight: 800; color: var(--slate-900); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m-4 6h4m-4 4h4m1 1H7"></path></svg>
                    Informations Professionnelles
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div>
                        <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Entreprise</strong>
                        <div style="font-weight: 700; color: var(--slate-900);">{{ $vendeur->professionnel->nom_entreprise }}</div>
                    </div>
                    <div>
                        <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">Registre du Commerce (RCCM)</strong>
                        <div style="font-weight: 700; color: var(--slate-900);">{{ $vendeur->professionnel->numero_registre_commerce }}</div>
                    </div>
                    @if(isset($vendeur->professionnel->registre_url))
                    <div>
                        <strong style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); display: block; margin-bottom: 0.25rem;">RCCM Document</strong>
                        <a href="{{ $vendeur->professionnel->registre_url }}" target="_blank" class="btn-pro-secondary" style="padding: 6px 12px; font-size: 0.7rem; display: inline-flex; gap: 4px; margin-top: 4px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            Ouvrir le RCCM
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Actions de validation (uniquement si en attente) -->
        @if($vendeur->statut_verification === 'en_attente')
            <div style="border-top: 1px solid var(--slate-200); padding-top: 2rem; margin-top: 1rem;">
                <h2 style="font-size: 1.125rem; font-weight: 800; color: var(--slate-900); margin-bottom: 1.5rem;">Décision d'Approbation</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                    <!-- Approuver -->
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 1.5rem; border-radius: 12px;">
                        <h3 style="font-size: 0.9375rem; font-weight: 800; color: #166534; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Valider le profil
                        </h3>
                        <form method="POST" action="{{ route('admin.vendeurs.verification.approve', $vendeur) }}">
                            @csrf
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #166534; margin-bottom: 0.5rem; text-transform: uppercase;">Message au vendeur (optionnel)</label>
                                <textarea name="commentaire" rows="3" placeholder="Ex: Votre compte a été validé. Bienvenue sur Mady Market !" style="width: 100%; padding: 0.75rem; border: 1px solid #bbf7d0; border-radius: 8px; font-size: 0.875rem; background: white;"></textarea>
                            </div>
                            <button type="submit" class="btn-pro-primary" style="width: 100%; background: #22c55e; border-color: #16a34a; justify-content: center; font-weight: 800;">
                                Approuver le dossier
                            </button>
                        </form>
                    </div>

                    <!-- Rejeter -->
                    <div style="background: #fef2f2; border: 1px solid #fecaca; padding: 1.5rem; border-radius: 12px;">
                        <h3 style="font-size: 0.9375rem; font-weight: 800; color: #991b1b; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Rejeter le dossier
                        </h3>
                        <form method="POST" action="{{ route('admin.vendeurs.verification.reject', $vendeur) }}">
                            @csrf
                            <div style="margin-bottom: 1rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #991b1b; margin-bottom: 0.5rem; text-transform: uppercase;">Raison du rejet (requis)</label>
                                <textarea name="raison_rejet" rows="3" required placeholder="Ex: Document d'identité illisible, veuillez renvoyer une photo nette." style="width: 100%; padding: 0.75rem; border: 1px solid #fecaca; border-radius: 8px; font-size: 0.875rem; background: white;"></textarea>
                            </div>
                            <button type="submit" class="btn-pro-secondary" style="width: 100%; background: #ef4444; color: white; border-color: #dc2626; justify-content: center; font-weight: 800;">
                                Rejeter le dossier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- Historique si déjà traité -->
            <div style="border-top: 1px solid var(--slate-200); padding-top: 2rem; margin-top: 1rem;">
                <div style="background: var(--slate-100); padding: 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 1rem;">
                    @if($vendeur->statut_verification === 'verifie')
                        <div style="width: 40px; height: 40px; background: #dcfce7; color: #15803d; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p style="font-weight: 800; color: var(--slate-900); margin: 0;">Dossier validé le {{ $vendeur->verifie_le ? $vendeur->verifie_le->format('d/m/Y') : 'N/A' }}</p>
                            <p style="font-size: 0.8125rem; color: var(--slate-500); margin: 0;">Le vendeur a désormais accès aux fonctionnalités de vente.</p>
                        </div>
                    @else
                        <div style="width: 40px; height: 40px; background: #fee2e2; color: #b91c1c; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <div>
                            <p style="font-weight: 800; color: var(--slate-900); margin: 0;">Dossier rejeté le {{ $vendeur->verifie_le ? $vendeur->verifie_le->format('d/m/Y') : 'N/A' }}</p>
                            <p style="font-size: 0.8125rem; color: #b91c1c; font-weight: 700; margin: 0;">Raison : {{ $vendeur->raison_rejet }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

