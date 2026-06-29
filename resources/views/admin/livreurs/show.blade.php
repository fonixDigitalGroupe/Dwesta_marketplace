@extends('layouts.admin')

@section('title', 'Dossier Livreur - ' . ($livreur->user->prenom ?? 'Utilisateur'))

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        input:focus, textarea:focus, select:focus { border-color: #ff9900 !important; outline: none; }

        .amazon-card {
            background: #fff;
            border: 1px solid #eff3f6;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title i { color: #f68b1e; }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border: none; color: #fff; padding: 8px 24px; border-radius: 4px;
            font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-amazon-orange {
            background: linear-gradient(to bottom, #f68b1e, #e67e22);
            border: 1px solid #d35400; color: #fff; padding: 8px 20px; border-radius: 4px;
            font-size: 0.85rem; font-weight: 600; text-decoration: none;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset; cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;
        }
        .btn-amazon-orange:hover { background: linear-gradient(to bottom, #e67e22, #d35400); border-color: #ba4a00; }

        .btn-amazon-secondary {
            background: #fff; border: 1px solid #ddd; color: #565959; padding: 6px 15px; border-radius: 4px;
            font-size: 0.85rem; font-weight: 500; text-decoration: none; cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s;
        }
        .btn-amazon-secondary:hover { background: #f7f7f7; border-color: #ccc; color: #111; }

        .info-row { display: grid; grid-template-columns: 180px 1fr; gap: 15px; margin-bottom: 12px; font-size: 0.85rem; }
        .info-label { color: #555; font-weight: 500; }
        .info-value { color: #111; font-weight: 600; }

        .status-badge { padding: 2px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 700; display: inline-block; }

        .doc-box { display: block; border-radius: 8px; overflow: hidden; border: 1px solid #eee; }
        .doc-empty { height: 150px; background: #f9fafb; border: 1px dashed #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 0.85rem; }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: -30px auto 0;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        <!-- Card Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <a href="{{ route('admin.livreurs.index') }}" class="btn-amazon-secondary" style="padding: 6px 12px;">
                    <i class="fas fa-chevron-left"></i> Retour
                </a>
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                    <i class="fas fa-id-card" style="font-size: 0.8rem;"></i>
                    <span>Dossier de Vérification — {{ $livreur->user->prenom }} {{ $livreur->user->nom }}</span>
                </div>
            </div>

            <div>
                @if ($livreur->statut_verification === 'en_attente')
                    <span class="status-badge" style="background: #fff8f3; color: #f68b1e; border: 1px solid #fbd8b4;">EN ATTENTE</span>
                @elseif ($livreur->statut_verification === 'verifie')
                    <span class="status-badge" style="background: #f7fff0; color: #569b00; border: 1px solid #c7e5a1;">VÉRIFIÉ</span>
                @else
                    <span class="status-badge" style="background: #fff5f5; color: #c40000; border: 1px solid #f9c2c2;">REJETÉ</span>
                @endif
            </div>
        </div>

        <!-- Row 1: Informations Personnelles & Documents d'identité -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; align-items: stretch;">

            <!-- Card: Informations Personnelles -->
            <div class="amazon-card" style="margin-bottom: 0;">
                <h2 class="section-title">Informations Personnelles</h2>
                <div class="info-row">
                    <span class="info-label">Nom Complet</span>
                    <span class="info-value">{{ $livreur->user->prenom }} {{ $livreur->user->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $livreur->user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">{{ $livreur->user->telephone ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pays</span>
                    <span class="info-value">{{ $pays ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ville</span>
                    <span class="info-value">{{ $livreur->user->ville ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Inscrit le</span>
                    <span class="info-value">{{ $livreur->created_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>

            <!-- Card: Documents fournis (PWA partenaire ou hub) -->
            <div class="amazon-card" style="display: flex; flex-direction: column; margin-bottom: 0;">
                <h2 class="section-title">Documents Fournis</h2>
                @php
                    $pieceLabel = $livreur->type_piece
                        ? strtoupper($livreur->type_piece)
                        : ($livreur->type_document ?? 'Pièce');
                    $docs = array_values(array_filter([
                        ['label' => "Pièce d'identité (" . $pieceLabel . ')', 'path' => $livreur->document_piece, 'url' => $documents['document_piece']],
                        ['label' => 'Pièce — Recto', 'path' => $livreur->document_recto, 'url' => $documents['document_recto']],
                        ['label' => 'Pièce — Verso', 'path' => $livreur->document_verso, 'url' => $documents['document_verso']],
                        ['label' => 'Pièce véhicule', 'path' => $livreur->photo_vehicule, 'url' => $documents['photo_vehicule']],
                    ], fn ($d) => !empty($d['path'])));
                @endphp

                @if(count($docs) === 0)
                    <div class="doc-empty">Aucun document fourni</div>
                @else
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        @foreach($docs as $doc)
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 8px;">{{ $doc['label'] }}</label>
                                @if($doc['url'])
                                    <a href="{{ $doc['url'] }}" target="_blank" class="doc-box">
                                        @if(Str::endsWith(strtolower($doc['path']), '.pdf'))
                                            <div style="padding: 20px; text-align: center; background: #f8fafc;">
                                                <i class="far fa-file-pdf" style="font-size: 2rem; color: #ef4444;"></i>
                                                <div style="font-size: 0.8rem; color: #475569; margin-top: 8px;">Voir le PDF</div>
                                            </div>
                                        @else
                                            <img src="{{ $doc['url'] }}" style="width: 100%; height: 170px; object-fit: cover;">
                                        @endif
                                    </a>
                                @else
                                    <div class="doc-empty">Fichier introuvable</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Row 2: Détails & Décision -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start;">

            <!-- Left Column -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="amazon-card" style="margin-bottom: 0;">
                    <h2 class="section-title">Pièce d'Identité & Véhicule</h2>
                    <div class="info-row">
                        <span class="info-label">Région</span>
                        <span class="info-value">{{ $livreur->region ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Type de Pièce</span>
                        <span class="info-value">{{ strtoupper($livreur->type_piece ?? $livreur->type_document ?? 'N/A') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">N° de Pièce</span>
                        <span class="info-value">{{ $livreur->numero_piece ?? $livreur->numero_document ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Type de Véhicule</span>
                        <span class="info-value">{{ $livreur->type_vehicule ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">N° de Châssis</span>
                        <span class="info-value">{{ $livreur->numero_chassis ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Immatriculation</span>
                        <span class="info-value">{{ $livreur->immatriculation ?? '-' }}</span>
                    </div>
                </div>

                @if($livreur->statut_verification === 'rejete' && $livreur->raison_rejet)
                    <div class="amazon-card" style="border: 1px solid #f9c2c2; background: #fffcfc; margin-bottom: 0;">
                        <h2 class="section-title" style="border-bottom-color: #f9c2c2; color: #c40000;">
                            <i class="fas fa-times-circle"></i> Motif du Rejet
                        </h2>
                        <p style="font-size: 0.85rem; color: #555; white-space: pre-line; margin: 0;">{{ $livreur->raison_rejet }}</p>
                    </div>
                @endif
            </div>

            <!-- Right Column: Decision -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @if($livreur->statut_verification === 'en_attente')
                    <div class="amazon-card" style="border: 2px solid #fbd8b4; background: #fffcf9; margin-bottom: 0;">
                        <h2 class="section-title" style="border-bottom-color: #fbd8b4; color: #c45500;">
                            <i class="fas fa-gavel"></i> Décision Administrative
                        </h2>

                        <div x-data="{
                            decision: 'approve',
                            reason: 'Votre demande de compte livreur n\'a pas pu être approuvée en l\'état sur Karnou. Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.',
                            selectedFields: [],
                            updateReason() {
                                let base = 'Votre demande de compte livreur n\'a pas pu être approuvée en l\'état sur Karnou. Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.';
                                if (this.selectedFields.length > 0) {
                                    base += '\n\nChamps à revoir :\n' + this.selectedFields.map(f => ' - ' + f).join('\n');
                                }
                                this.reason = base;
                            }
                        }">
                            <div style="display: flex; gap: 20px; margin-bottom: 25px; padding: 10px; background: #fff; border: 1px solid #eff3f6; border-radius: 4px;">
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; cursor: pointer; flex: 1; padding: 5px;">
                                    <input type="radio" x-model="decision" value="approve" name="decision_type">
                                    <span style="font-weight: 600; color: #16a34a;">Approuver</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.9rem; cursor: pointer; flex: 1; padding: 5px;">
                                    <input type="radio" x-model="decision" value="reject" name="decision_type">
                                    <span style="font-weight: 600; color: #b91c1c;">Rejeter</span>
                                </label>
                            </div>

                            <!-- Form Approuver -->
                            <form x-show="decision === 'approve'" method="POST" action="{{ route('admin.livreurs.approve', $livreur) }}">
                                @csrf
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 5px;">Commentaire (optionnel)</label>
                                    <textarea name="commentaire" rows="5" style="width: 100%; padding: 10px; border: 1px solid #adb1b8; font-size: 0.85rem; border-radius: 4px; box-sizing: border-box;">Félicitations ! Votre dossier de livreur a été validé. Vous pouvez désormais recevoir des commandes de livraison sur Karnou.</textarea>
                                </div>
                                <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 44px; background: #16a34a; border-color: #15803d; font-size: 0.9rem; font-weight: 600;">
                                    Continuer et Approuver ✓
                                </button>
                            </form>

                            <!-- Form Rejeter -->
                            <form x-show="decision === 'reject'" method="POST" action="{{ route('admin.livreurs.reject', $livreur) }}">
                                @csrf
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 10px; color: #111;">Précisez les champs à revoir :</label>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #fff; padding: 15px; border: 1px solid #eff3f6; border-radius: 4px;">
                                        @php
                                            $fields = [
                                                'Pièce d\'identité (recto)',
                                                'Pièce d\'identité (verso)',
                                                'Numéro de document',
                                                'Type de véhicule',
                                                'Document illisible',
                                                'Document expiré',
                                                'Coordonnées (Tel, Ville)',
                                                'Photo du document',
                                            ];
                                        @endphp
                                        @foreach($fields as $field)
                                            <label style="display: flex; align-items: start; gap: 8px; font-size: 0.8rem; cursor: pointer; line-height: 1.3;">
                                                <input type="checkbox" value="{{ $field }}" x-model="selectedFields" @change="updateReason()" style="margin-top: 2px;">
                                                <span>{{ $field }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 5px;">Motif détaillé du rejet (obligatoire)</label>
                                    <textarea name="raison_rejet" x-model="reason" required rows="6" style="width: 100%; padding: 10px; border: 1px solid #adb1b8; font-size: 0.85rem; border-radius: 4px; box-sizing: border-box;"></textarea>
                                </div>
                                <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 44px; background: #dc2626; border-color: #b91c1c; font-size: 0.9rem; font-weight: 600;">
                                    Rejeter le dossier ✕
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="amazon-card" style="margin-bottom: 0;">
                        <h2 class="section-title">Statut du Dossier</h2>
                        @if($livreur->statut_verification === 'verifie')
                            <p style="font-size: 0.9rem; color: #569b00; font-weight: 600; margin: 0;"><i class="fas fa-check-circle"></i> Ce dossier a été vérifié et approuvé.</p>
                            <form action="{{ route('admin.livreurs.reject', $livreur) }}" method="POST" style="margin-top: 16px;" onsubmit="return confirm('Rejeter ce dossier déjà vérifié ?')">
                                @csrf
                                <input type="hidden" name="raison_rejet" value="Dossier réexaminé puis rejeté par l'administration.">
                                <button type="submit" class="btn-amazon-secondary" style="color: #c40000; border-color: #f9c2c2;">Rejeter ce dossier</button>
                            </form>
                        @else
                            <p style="font-size: 0.9rem; color: #c40000; font-weight: 600; margin: 0;"><i class="fas fa-times-circle"></i> Ce dossier a été rejeté.</p>
                            <form action="{{ route('admin.livreurs.approve', $livreur) }}" method="POST" style="margin-top: 16px;">
                                @csrf
                                <button type="submit" class="btn-amazon-primary" style="background: #16a34a; border-color: #15803d;">Approuver finalement</button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="amazon-card" style="border: 1px solid #f9c2c2; background: #fffcfc;">
            <h3 style="font-size: 0.95rem; color: #c40000; font-weight: 700; margin: 0 0 15px 0; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-triangle"></i> Zone de Danger
            </h3>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="font-size: 0.85rem; font-weight: 700; color: #111; margin: 0;">Supprimer ce livreur</p>
                    <p style="font-size: 0.8rem; color: #666; margin: 5px 0 0 0;">Supprime la fiche livreur et ses documents. Cette action est irréversible.</p>
                </div>
                <form action="{{ route('admin.livreurs.destroy', $livreur) }}" method="POST" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer ce livreur ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-amazon-secondary" style="color: #c40000; border-color: #f9c2c2;">
                        Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
