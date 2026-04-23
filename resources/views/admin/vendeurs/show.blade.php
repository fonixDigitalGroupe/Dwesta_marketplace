@extends('layouts.admin')

@section('title', 'Détails Vendeur - ' . ($vendeur->user->prenom ?? 'Utilisateur'))

@section('breadcrumbs')
    <div style="display: flex; align-items: center; gap: 8px; color: #64748b; font-size: 0.85rem;">
        <a href="{{ route('admin.vendeurs.verification.index') }}" style="color: #64748b; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#64748b'">Vérifications Vendeurs</a>
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.5;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
        </svg>
        <span style="color: #0f172a; font-weight: 600;">Détails du Dossier</span>
    </div>
@endsection

@section('content')
<div style="max-width: 1100px; margin: 0 auto; padding-bottom: 3rem;">
    
    <!-- Action Header -->
    <div style="display: flex; justify-content: flex-end; margin-bottom: 1.5rem;">
        <a href="{{ route('admin.vendeurs.verification.index') }}" 
           style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 0.85rem; text-decoration: none; padding: 0.5rem 0; background: transparent; font-weight: 500; transition: all 0.2s;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour à la liste
        </a>
    </div>

    <!-- Profile Header Card -->
    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0; padding: 2rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="width: 80px; height: 80px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; color: #94a3b8; position: relative;">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        
        <div style="flex: 1;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 0.5rem;">
                <h1 style="font-size: 1.5rem; color: #0f172a; font-weight: 700; margin: 0;">{{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}</h1>
                @if($vendeur->statut_verification === 'en_attente')
                    <span style="background: #fafafa; color: #92400e; padding: 4px 12px; border: 1px solid #fef3c7; border-radius: 0; font-size: 0.75rem; font-weight: 600;">En attente de vérification</span>
                @elseif($vendeur->statut_verification === 'verifie')
                    <span style="background: #f0fdf4; color: #15803d; padding: 4px 12px; border: 1px solid #dcfce7; border-radius: 0; font-size: 0.75rem; font-weight: 600;">Profil Vérifié ✓</span>
                @else
                    <span style="background: #fef2f2; color: #b91c1c; padding: 4px 12px; border: 1px solid #fee2e2; border-radius: 0; font-size: 0.75rem; font-weight: 600;">Profil Rejeté ✕</span>
                @endif
            </div>
            <div style="display: flex; gap: 20px; color: #64748b; font-size: 0.85rem;">
                <span style="display: flex; align-items: center; gap: 6px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> {{ $vendeur->user->email }}</span>
                @if($vendeur->user->telephone)
                    <span style="display: flex; align-items: center; gap: 6px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> {{ $vendeur->user->telephone }}</span>
                @endif
                <span style="display: flex; align-items: center; gap: 6px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> Inscrit le {{ $vendeur->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; align-items: stretch;">
        
        <!-- Left: Information Cards -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            
            <!-- Account Info -->
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0; overflow: hidden;">
                <div style="background: #f8fafc; padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 0.8rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informations du Compte
                </div>
                <div style="padding: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Type de Compte</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">@if($vendeur->estParticulier()) Vendeur part @else Vendeur pro @endif</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Statut</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">{{ ucfirst($vendeur->statut_verification) }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Date de création</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">{{ $vendeur->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>


            <!-- Business Info (Only if Pro) -->
            @if($vendeur->estProfessionnel() && $vendeur->professionnel)
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0; overflow: hidden;">
                <div style="background: #f8fafc; padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 0.8rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2-2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Détails de l'Entreprise
                </div>
                <div style="padding: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Raison Sociale</span>
                        <span style="color: #0f172a; font-size: 0.9rem; font-weight: 700; color: #1e40af;">{{ $vendeur->professionnel->nom_entreprise }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">N° RCCM</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">{{ $vendeur->professionnel->numero_registre_commerce }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Date d'émission *</span>
                        <span style="color: #16a34a; font-size: 0.85rem; font-weight: 700;">{{ $vendeur->professionnel->date_emission_registre ? $vendeur->professionnel->date_emission_registre->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Date d'expiration</span>
                        <span style="color: #dc2626; font-size: 0.85rem; font-weight: 700;">{{ $vendeur->professionnel->date_expiration_registre ? $vendeur->professionnel->date_expiration_registre->format('d/m/Y') : '-' }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Identification Personnelle (Only if Part) -->
            @if($vendeur->estParticulier() && $vendeur->particulier)
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0; overflow: hidden;">
                <div style="background: #f8fafc; padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 0.8rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Document d'Identité
                </div>
                <div style="padding: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Type Document</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">{{ strtoupper($vendeur->particulier->type_document) }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Numéro de Pièce</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">{{ $vendeur->particulier->numero_document }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Date d'émission</span>
                        <span style="color: #16a34a; font-size: 0.85rem; font-weight: 700;">{{ $vendeur->particulier->date_emission_document ? $vendeur->particulier->date_emission_document->format('d/m/Y') : '-' }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Date d'expiration</span>
                        <span style="color: #dc2626; font-size: 0.85rem; font-weight: 700;">{{ $vendeur->particulier->date_expiration_document ? $vendeur->particulier->date_expiration_document->format('d/m/Y') : '-' }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Abonnement Info -->
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0; overflow: hidden;">
                <div style="background: #f8fafc; padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 0.8rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    Abonnement & Formule
                </div>
                <div style="padding: 1.5rem;">
                    @php
                        $abonnementActif = $vendeur->abonnementActif;
                        $formule = $vendeur->abonnement_actuel;
                    @endphp
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Formule</span>
                        <div>
                            @if($abonnementActif)
                            <span style="display: inline-block; background: #eff6ff; color: #1d4ed8; padding: 2px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                {{ $formule->nom ?? $formule->type }}
                            </span>
                            @else
                            <span style="display: inline-block; background: #fff7ed; color: #c2410c; padding: 2px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                                Gratuit
                            </span>
                            @endif
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Commission</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">{{ $formule ? $formule->commission : 'N/A' }}%</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem; margin-bottom: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Prix Mensuel</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">{{ $formule ? number_format($formule->prix_mensuel, 0, ',', ' ') : 0 }} FCFA</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 1rem;">
                        <span style="color: #64748b; font-size: 0.85rem;">Page Pro</span>
                        <span style="color: #0f172a; font-size: 0.85rem; font-weight: 600;">{{ $formule && $formule->page_pro ? 'Inclus' : 'Non inclus' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Documents & Actions -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            
            <!-- Document View -->
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0; overflow: hidden; height: 100%; display: flex; flex-direction: column;">
                <div style="background: #f8fafc; padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 0.8rem; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px; border-radius: 0;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Pièce Justificative
                </div>
                <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fff;">
                    @php
                        $docUrl = null;
                        if($vendeur->estParticulier() && $vendeur->particulier) $docUrl = $vendeur->particulier->document_url;
                        if($vendeur->estProfessionnel() && $vendeur->professionnel) $docUrl = $vendeur->professionnel->registre_url;
                    @endphp

                    @if($docUrl)
                        <div style="width: 100%; max-width: 300px; padding: 2rem; border: 2px dashed #e2e8f0; border-radius: 0; background: #fff; text-align: center;">
                            <svg width="48" height="48" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" style="margin-bottom: 1rem;"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.5rem;">Un document est joint au dossier de vérification.</p>
                            <a href="{{ $docUrl }}" target="_blank" 
                               style="display: inline-flex; align-items: center; gap: 8px; background: #0f172a; color: #fff; padding: 0.75rem 1.25rem; border-radius: 0; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: transform 0.2s;"
                               onmouseover="this.style.transform='translateY(-2px)'"
                               onmouseout="this.style.transform='translateY(0)'">
                                Visualiser le fichier
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    @else
                        <div style="text-align: center; color: #94a3b8;">
                            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 0.5rem;"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <p style="font-size: 0.85rem;">Aucun document disponible.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Decision Flow Section -->
    @if($vendeur->statut_verification === 'en_attente')
    <div style="margin-top: 3rem;">
        <h2 style="font-size: 1.1rem; color: #0f172a; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <span style="display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: #0f172a; color: #fff; border-radius: 0; font-size: 0.75rem;">⚡</span>
            Décision Finale & Approbation
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
            <!-- APPROVE CARD -->
            <div style="background: #fff; border: 1px solid #dcfce7; border-radius: 0; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01), 0 2px 4px -1px rgba(0,0,0,0.01);">
                <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="width: 40px; height: 40px; background: #f0fdf4; color: #15803d; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1rem; color: #16a34a; font-weight: 700; margin: 0;">Approuver le Vendeur</h3>
                        <p style="font-size: 0.8rem; color: #16a34a; opacity: 0.8; margin-top: 2px;">Confirmer l'identité et activer le compte.</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('admin.vendeurs.verification.approve', $vendeur) }}">
                    @csrf
                    <div style="margin-bottom: 1.5rem;">
                        <textarea name="commentaire" rows="3" placeholder="Message optionnel pour le vendeur..." style="width: 100%; border: 1px solid #dcfce7; border-radius: 0; padding: 0.75rem; font-size: 0.85rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#16a34a'" onblur="this.style.borderColor='#dcfce7'"></textarea>
                    </div>
                    <button type="submit" style="width: 100%; background: #16a34a; color: #fff; padding: 0.875rem; border: none; border-radius: 0; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#15803d'; this.style.transform='scale(1.01)'"
                            onmouseout="this.style.background='#16a34a'; this.style.transform='scale(1)'">
                        Valider Décision ✓
                    </button>
                </form>
            </div>

            <!-- REJECT CARD -->
            <div style="background: #fff; border: 1px solid #fee2e2; border-radius: 0; padding: 2rem;">
                <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="width: 40px; height: 40px; background: #fef2f2; color: #b91c1c; border-radius: 0; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 1rem; color: #991b1b; font-weight: 700; margin: 0;">Rejeter la Demande</h3>
                        <p style="font-size: 0.8rem; color: #b91c1c; opacity: 0.8; margin-top: 2px;">Notifier le vendeur en cas de problème.</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('admin.vendeurs.verification.reject', $vendeur) }}">
                    @csrf
                    <div style="margin-bottom: 1.5rem;">
                        <textarea name="raison_rejet" rows="3" required placeholder="Motif du rejet (obligatoire...)" style="width: 100%; border: 1px solid #fee2e2; border-radius: 0; padding: 0.75rem; font-size: 0.85rem; outline: none;"></textarea>
                    </div>
                    <button type="submit" style="width: 100%; background: transparent; color: #b91c1c; border: 1px solid #b91c1c; padding: 0.875rem; border-radius: 0; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#b91c1c'; this.style.color='#fff'"
                            onmouseout="this.style.background='transparent'; this.style.color='#b91c1c'">
                        Envoyer le Rejet ✕
                    </button>
                </form>
            </div>
        </div>
    </div>
    @else

    @endif
    <!-- Subscription History Section -->
    <div style="margin-top: 3rem; margin-bottom: 3rem;">
        <h2 style="font-size: 1.1rem; color: #0f172a; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <span style="display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: #f8fafc; border: 1px solid #e2e8f0; color: #475569; border-radius: 0; font-size: 0.75rem;">📅</span>
            Historique des Abonnements
        </h2>

        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem;">
                <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">Formule</th>
                        <th style="padding: 1rem 1.5rem; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">Période</th>
                        <th style="padding: 1rem 1.5rem; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">Annonces</th>
                        <th style="padding: 1rem 1.5rem; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 0.75rem;">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendeur->abonnements()->with('abonnement')->orderBy('date_debut', 'desc')->get() as $hist)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 1rem 1.5rem; font-weight: 600; color: #0f172a;">{{ $hist->abonnement->nom }}</td>
                        <td style="padding: 1rem 1.5rem; color: #64748b;">
                            Du {{ $hist->date_debut->format('d/m/Y') }} au {{ $hist->date_fin->format('d/m/Y') }}
                        </td>
                        <td style="padding: 1rem 1.5rem; color: #64748b;">
                            {{ $hist->nombre_annonces_utilisees }} / {{ $hist->abonnement->nombre_annonces == 0 ? '∞' : $hist->abonnement->nombre_annonces }}
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            @if($hist->estActif())
                                <span style="background: #f0fdf4; color: #15803d; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">ACTIF</span>
                            @elseif($hist->estExpire())
                                <span style="background: #fef2f2; color: #991b1b; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">EXPIRÉ</span>
                            @else
                                <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">INACTIF</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 2rem 1.5rem; text-align: center; color: #94a3b8;">Aucun historique d'abonnement payant trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection


