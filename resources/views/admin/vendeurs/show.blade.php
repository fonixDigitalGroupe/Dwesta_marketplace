@extends('layouts.admin')

@section('title', 'Vérification Vendeur - ' . ($vendeur->user->prenom ?? 'Utilisateur') . ' ' . ($vendeur->user->nom ?? 'Inconnu'))

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.vendeurs.verification.index') }}">Vérifications Vendeurs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Détails du Dossier</span>
@endsection

@section('content')
<div style="max-width: 1000px;">
    <!-- Actions Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600; margin-bottom: 0.25rem;">Examen du Vendeur</h1>
            <p style="font-size: 0.85rem; color: #666;">Détails complets et documents pour validation.</p>
        </div>
        <a href="{{ route('admin.vendeurs.verification.index') }}" 
           style="display: inline-block; color: #666; font-size: 0.75rem; text-decoration: none; padding: 5px 12px; border: 1px solid #ddd; border-radius: 4px; font-weight: 600; transition: all 0.2s;">
            ← Retour à la liste
        </a>
    </div>

    <!-- Main Container (Minimal) -->
    <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 2px; padding: 2rem;">
        
        <div style="display: grid; grid-template-columns: 1fr; gap: 2.5rem;">
            
            <!-- Informations de base -->
            <section>
                <h2 style="font-size: 0.85rem; font-weight: 700; color: #111; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f0f0f0; padding-bottom: 0.75rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    Identité de l'Utilisateur
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.25rem;">Nom & Prénom</span>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">{{ $vendeur->user->prenom ?? '-' }} {{ $vendeur->user->nom ?? '-' }}</div>
                    </div>
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.25rem;">Adresse Email</span>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">{{ $vendeur->user->email ?? '-' }}</div>
                    </div>
                    @if($vendeur->user->telephone)
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.25rem;">Téléphone</span>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">{{ $vendeur->user->telephone }}</div>
                    </div>
                    @endif
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.25rem;">Inscrit le</span>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">{{ $vendeur->user->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
            </section>

            <!-- Profil Vendeur -->
            <section>
                <h2 style="font-size: 0.85rem; font-weight: 700; color: #111; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f0f0f0; padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                    Détails du Compte Vendeur
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.5rem;">Type de Compte</span>
                        @if($vendeur->estParticulier())
                            <span style="padding: 2px 8px; background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">Particulier</span>
                        @else
                            <span style="padding: 2px 8px; background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">Professionnel</span>
                        @endif
                    </div>
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.5rem;">Statut de Vérification</span>
                        @if($vendeur->statut_verification === 'en_attente')
                            <span style="padding: 2px 8px; background: #fafafa; color: #b45309; border: 1px solid #fae8ff; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">En attente de validation</span>
                        @elseif($vendeur->statut_verification === 'verifie')
                            <span style="padding: 2px 8px; background: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">Vérifié le {{ $vendeur->verifie_le ? $vendeur->verifie_le->format('d/m/Y') : '' }}</span>
                        @else
                            <span style="padding: 2px 8px; background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">Rejeté</span>
                        @endif
                    </div>
                </div>
            </section>

            <!-- Preuves et Documents -->
            <section>
                <h2 style="font-size: 0.85rem; font-weight: 700; color: #111; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f0f0f0; padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                    Pièces Justificatives
                </h2>

                @if($vendeur->estParticulier() && $vendeur->particulier)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.25rem;">Type & Numéro de Pièce</span>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">
                            {{ strtoupper($vendeur->particulier->type_document ?? 'Document') }} : {{ $vendeur->particulier->numero_document ?? 'N/A' }}
                        </div>
                    </div>
                    @if($vendeur->particulier->document_url)
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.5rem;">Document CNI/Passeport</span>
                        <a href="{{ $vendeur->particulier->document_url }}" target="_blank" 
                           style="display: inline-flex; align-items: center; gap: 6px; color: #333; font-size: 0.75rem; text-decoration: none; padding: 4px 10px; border: 1px solid #333; border-radius: 4px; font-weight: 600;">
                            Visualiser le document
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                    @endif
                </div>
                @elseif($vendeur->estProfessionnel() && $vendeur->professionnel)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.25rem;">Raison Sociale</span>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">{{ $vendeur->professionnel->nom_entreprise }}</div>
                    </div>
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.25rem;">N° RCCM / Registre</span>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">{{ $vendeur->professionnel->numero_registre_commerce }}</div>
                    </div>
                    @if(isset($vendeur->professionnel->registre_url))
                    <div>
                        <span style="font-size: 0.7rem; color: #999; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 0.5rem;">Extrait RCCM</span>
                        <a href="{{ $vendeur->professionnel->registre_url }}" target="_blank" 
                           style="display: inline-flex; align-items: center; gap: 6px; color: #333; font-size: 0.75rem; text-decoration: none; padding: 4px 10px; border: 1px solid #333; border-radius: 4px; font-weight: 600;">
                            Télécharger l'extrait
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                    @endif
                </div>
                @endif
            </section>

            <!-- Zone de décision -->
            @if($vendeur->statut_verification === 'en_attente')
            <section style="border-top: 1px solid #f0f0f0; padding-top: 2rem;">
                <h2 style="font-size: 0.85rem; font-weight: 700; color: #111; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1.5rem;">
                    Décision d'Approbation
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
                    <!-- Valider -->
                    <div style="padding: 1.5rem; border: 1px solid #e5e5e5; border-radius: 4px;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: #15803d; text-transform: uppercase; display: block; margin-bottom: 1rem;">Option 1 : Approuver le dossier</span>
                        <form method="POST" action="{{ route('admin.vendeurs.verification.approve', $vendeur) }}">
                            @csrf
                            <div style="margin-bottom: 1.25rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #666; margin-bottom: 0.5rem;">Message de bienvenue (facultatif)</label>
                                <textarea name="commentaire" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.85rem; outline: none;"></textarea>
                            </div>
                            <button type="submit" style="width: 100%; background: #000; color: #fff; padding: 0.75rem; border: none; border-radius: 4px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: opacity 0.2s;" 
                                    onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                Valider et confirmer
                            </button>
                        </form>
                    </div>

                    <!-- Rejeter -->
                    <div style="padding: 1.5rem; border: 1px solid #fee2e2; border-radius: 4px;">
                        <span style="font-size: 0.75rem; font-weight: 700; color: #b91c1c; text-transform: uppercase; display: block; margin-bottom: 1rem;">Option 2 : Rejeter la demande</span>
                        <form method="POST" action="{{ route('admin.vendeurs.verification.reject', $vendeur) }}">
                            @csrf
                            <div style="margin-bottom: 1.25rem;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #666; margin-bottom: 0.5rem;">Motif du rejet (obligatoire)</label>
                                <textarea name="raison_rejet" rows="3" required style="width: 100%; padding: 0.75rem; border: 1px solid #fee2e2; border-radius: 4px; font-size: 0.85rem; outline: none;"></textarea>
                            </div>
                            <button type="submit" style="width: 100%; background: transparent; color: #b91c1c; border: 1px solid #b91c1c; padding: 0.75rem; border-radius: 4px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.background='#b91c1c'; this.style.color='#fff'"
                                    onmouseout="this.style.background='transparent'; this.style.color='#b91c1c'">
                                Envoyer le rejet
                            </button>
                        </form>
                    </div>
                </div>
            </section>
            @endif

            <!-- Historique (si déjà traité) -->
            @if($vendeur->statut_verification !== 'en_attente')
            <section style="border-top: 1px solid #f0f0f0; padding-top: 2rem;">
                <div style="padding: 1.25rem; background: #fafafa; border-radius: 4px; border: 1px solid #eee;">
                    @if($vendeur->statut_verification === 'verifie')
                        <h4 style="font-size: 0.85rem; font-weight: 700; color: #15803d; margin-bottom: 0.25rem;">✓ Dossier validé</h4>
                        <p style="font-size: 0.8rem; color: #666;">Ce vendeur a été officiellement approuvé le {{ $vendeur->verifie_le ? $vendeur->verifie_le->format('d/m/Y à H:i') : '-' }}.</p>
                    @else
                        <h4 style="font-size: 0.85rem; font-weight: 700; color: #b91c1c; margin-bottom: 0.25rem;">✕ Dossier rejeté</h4>
                        <p style="font-size: 0.8rem; color: #666; margin-bottom: 0.5rem;">Raison : {{ $vendeur->raison_rejet }}</p>
                        <p style="font-size: 0.75rem; color: #999;">Décision prise le {{ $vendeur->verifie_le ? $vendeur->verifie_le->format('d/m/Y à H:i') : '-' }}.</p>
                    @endif
                </div>
            </section>
            @endif

        </div>
    </div>
</div>
@endsection


