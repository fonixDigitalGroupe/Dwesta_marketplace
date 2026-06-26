@extends('layouts.admin')

@section('title', 'Détails Vendeur - ' . ($vendeur->user->prenom ?? 'Utilisateur'))

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Input Amazon Style Modernisé */
        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus,
        select:focus {
            border-color: #ff9900 !important;
            outline: none;
        }

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

        .section-title i {
            color: #f68b1e;
        }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff;
            padding: 8px 24px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-amazon-orange {
            background: linear-gradient(to bottom, #f68b1e, #e67e22);
            border: 1px solid #d35400;
            color: #fff;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-amazon-orange:hover {
            background: linear-gradient(to bottom, #e67e22, #d35400);
            border-color: #ba4a00;
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .btn-amazon-secondary {
            background: #fff;
            border: 1px solid #ddd;
            color: #565959;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-amazon-secondary:hover {
            background: #f7f7f7;
            border-color: #ccc;
            color: #111;
        }

        .info-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 15px;
            margin-bottom: 12px;
            font-size: 0.85rem;
        }

        .info-label {
            color: #555;
            font-weight: 500;
        }

        .info-value {
            color: #111;
            font-weight: 600;
        }

        .status-badge {
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }

        .table-amazon {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #eff3f6;
        }

        .table-amazon th {
            background: #f6f6f6;
            padding: 10px 15px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            color: #111;
            text-transform: uppercase;
            border-bottom: 1px solid #eff3f6;
            border-right: 1px solid #eff3f6;
        }

        .table-amazon td {
            padding: 12px 15px;
            font-size: 0.85rem;
            border-bottom: 1px solid #eff3f6;
            border-right: 1px solid #eff3f6;
        }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: -30px auto 0;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
        <!-- Card Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" class="btn-amazon-secondary"
                    style="padding: 6px 12px;">
                    <i class="fas fa-chevron-left"></i> Retour
                </a>
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                    <i class="fas fa-id-card" style="font-size: 0.8rem;"></i>
                    <span>Dossier de Vérification — {{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}</span>
                </div>
            </div>

            <div>
                @if ($vendeur->statut_verification === 'en_attente')
                    <span class="status-badge"
                        style="background: #fff8f3; color: #f68b1e; border: 1px solid #fbd8b4;">EN ATTENTE</span>
                @elseif ($vendeur->statut_verification === 'verifie')
                    <span class="status-badge"
                        style="background: #f7fff0; color: #569b00; border: 1px solid #c7e5a1;">VÉRIFIÉ</span>
                @else
                    <span class="status-badge"
                        style="background: #fff5f5; color: #c40000; border: 1px solid #f9c2c2;">REJETÉ</span>
                @endif
            </div>
        </div>

        <!-- Row 1: Informations Personnelles & Pièce Justificative (Hauteurs égales) -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; align-items: stretch;">
            <!-- Card: Informations Personnelles -->
            <div class="amazon-card" style="margin-bottom: 0;">
                <h2 class="section-title">
                    Informations Personnelles
                </h2>
                <div class="info-row">
                    <span class="info-label">Nom Complet</span>
                    <span class="info-value">{{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $vendeur->user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">{{ $vendeur->user->telephone ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pays / Ville</span>
                    <span class="info-value">{{ $vendeur->user->nationalite ?? '-' }} / {{ $vendeur->user->ville ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Inscrit le</span>
                    <span class="info-value">{{ $vendeur->created_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>

            <!-- Card: Pièce Justificative -->
            <div class="amazon-card" style="display: flex; flex-direction: column; margin-bottom: 0;">
                <h2 class="section-title">
                    Pièce Justificative
                </h2>
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fafafa; border: 1px dashed #ddd; padding: 25px; border-radius: 4px;">
                    @php
                        $docUrl = null;
                        if($vendeur->estParticulier() && $vendeur->particulier) $docUrl = $vendeur->particulier->document_url;
                        if($vendeur->estProfessionnel() && $vendeur->professionnel) $docUrl = $vendeur->professionnel->registre_url;
                    @endphp

                    @if($docUrl)
                        <i class="far fa-file-pdf" style="font-size: 2.5rem; color: #adb1b8; margin-bottom: 15px;"></i>
                        <p style="font-size: 0.85rem; color: #555; text-align: center; margin-bottom: 15px;">
                            Un document a été fourni pour ce dossier et est prêt à être inspecté.
                        </p>
                        <a href="{{ $docUrl }}" target="_blank" class="btn-amazon-orange" style="margin-top: auto;">
                            Visualiser le document
                        </a>
                    @else
                        <i class="fas fa-exclamation-triangle" style="font-size: 2.5rem; color: #adb1b8; margin-bottom: 15px;"></i>
                        <p style="font-size: 0.85rem; color: #888;">Aucun document joint n'est disponible.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Row 2: Layout Grid pour le reste -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start;">
            
            <!-- Left Column: Information Details -->
            <div style="display: flex; flex-direction: column; gap: 20px;">

                <!-- Card: Identité / Entreprise -->
                <div class="amazon-card" style="margin-bottom: 0;">
                    @if($vendeur->estProfessionnel() && $vendeur->professionnel)
                        <h2 class="section-title">
                            <i class="fas fa-building"></i> Détails de l'Entreprise
                        </h2>
                        <div class="info-row">
                            <span class="info-label">Raison Sociale</span>
                            <span class="info-value" style="color: #004aad;">{{ $vendeur->professionnel->nom_entreprise }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">N° RCCM</span>
                            <span class="info-value">{{ $vendeur->professionnel->numero_registre_commerce }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dates Registre</span>
                            <span class="info-value">
                                Em: <span style="color: #569b00;">{{ $vendeur->professionnel->date_emission_registre ? $vendeur->professionnel->date_emission_registre->format('d/m/Y') : '-' }}</span>
                                / Exp: <span style="color: #c40000;">{{ $vendeur->professionnel->date_expiration_registre ? $vendeur->professionnel->date_expiration_registre->format('d/m/Y') : '-' }}</span>
                            </span>
                        </div>
                    @else
                        <h2 class="section-title">
                            Pièce d'Identité
                        </h2>
                        <div class="info-row">
                            <span class="info-label">Type de Document</span>
                            <span class="info-value">{{ strtoupper($vendeur->particulier->type_document ?? 'N/A') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Numéro</span>
                            <span class="info-value">{{ $vendeur->particulier->numero_document ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dates Pièce</span>
                            <span class="info-value">
                                Em: <span style="color: #569b00;">{{ ($vendeur->particulier && $vendeur->particulier->date_emission_document) ? $vendeur->particulier->date_emission_document->format('d/m/Y') : '-' }}</span>
                                / Exp: <span style="color: #c40000;">{{ ($vendeur->particulier && $vendeur->particulier->date_expiration_document) ? $vendeur->particulier->date_expiration_document->format('d/m/Y') : '-' }}</span>
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Card: Abonnement -->
                <div class="amazon-card" style="margin-bottom: 0;">
                    <h2 class="section-title">
                        Abonnement & Formule
                    </h2>
                    @php
                        $formule = $vendeur->abonnement_actuel;
                    @endphp
                    <div class="info-row">
                        <span class="info-label">Formule Actuelle</span>
                        <span class="info-value">
                            @if($vendeur->abonnementActif)
                                <span style="color: #004aad;">{{ $formule->nom ?? $formule->type }}</span>
                            @else
                                <span style="color: #c45500;">Gratuit</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Commission</span>
                        <span class="info-value">{{ $formule ? $formule->commission : '0' }}%</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Page Pro</span>
                        <span class="info-value">{{ ($formule && $formule->page_pro) ? 'Inclus' : 'Non Inclus' }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Documents & Decisions -->
            <div style="display: flex; flex-direction: column; gap: 20px;">


                <!-- Decision & Actions -->
                @if($vendeur->statut_verification === 'en_attente')
                    <div class="amazon-card" style="border: 2px solid #fbd8b4; background: #fffcf9; margin-bottom: 0;">
                        <h2 class="section-title" style="border-bottom-color: #fbd8b4; color: #c45500;">
                            <i class="fas fa-gavel"></i> Décision Administrative
                        </h2>
                        
                        <div x-data="{ 
                            decision: 'approve', 
                            reason: 'Votre demande de compte vendeur n\'a pas pu être approuvée en l\'état sur Karnou. Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.',
                            selectedFields: [],
                            updateReason() {
                                let base = 'Votre demande de compte vendeur n\'a pas pu être approuvée en l\'état sur Karnou. Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.';
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
                            <form x-show="decision === 'approve'" method="POST" action="{{ route('admin.vendeurs.verification.approve', $vendeur) }}">
                                @csrf
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 5px;">Commentaire (optionnel)</label>
                                    <textarea name="commentaire" rows="5" style="width: 100%; padding: 10px; border: 1px solid #adb1b8; font-size: 0.85rem; border-radius: 4px; box-sizing: border-box;">Félicitations ! Votre identité a été confirmée. Vous pouvez désormais publier des annonces et effectuer des transactions en toute sécurité sur Karnou.</textarea>
                                </div>
                                <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 44px; background: #16a34a; border-color: #15803d; font-size: 0.9rem; font-weight: 600;">
                                    Continuer et Approuver ✓
                                </button>
                            </form>

                            <form x-show="decision === 'reject'" method="POST" action="{{ route('admin.vendeurs.verification.reject', $vendeur) }}">
                                @csrf
                                <div style="margin-bottom: 20px;">
                                    <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 10px; color: #111;">Précisez les champs à revoir :</label>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #fff; padding: 15px; border: 1px solid #eff3f6; border-radius: 4px;">
                                        @php
                                            $fields = [
                                                'Pièce d\'identité (CNI/Passeport)',
                                                'Registre de Commerce (RCCM)',
                                                'Nom / Prénom',
                                                'Raison sociale',
                                                'Coordonnées (Tel, Ville)',
                                                'Document illisible',
                                                'Document expiré',
                                                'Photo du document'
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
                @endif
            </div>
        </div>

    <!-- Subscription History Table -->
    <div class="amazon-card" style="margin-top: 5px;">
        <h2 class="section-title">
            Historique des Abonnements
        </h2>
        <table class="table-amazon">
            <thead>
                <tr>
                    <th>Formule</th>
                    <th>Période</th>
                    <th style="text-align: center;">Annonces</th>
                    <th style="text-align: center;">Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendeur->abonnements()->with('abonnement')->orderBy('date_debut', 'desc')->get() as $hist)
                    <tr>
                        <td style="font-weight: 600;">{{ $hist->abonnement->nom }}</td>
                        <td style="color: #555;">
                            {{ $hist->date_debut->format('d/m/Y') }} — {{ $hist->date_fin->format('d/m/Y') }}
                        </td>
                        <td style="text-align: center;">
                            @if($hist->estActif())
                                {{ $vendeur->annonces()->whereIn('statut', ['publiee', 'en_attente'])->count() }}
                            @else
                                {{ $hist->nombre_annonces_utilisees }} 
                            @endif
                            / {{ ($hist->abonnement->nombre_annonces == 0 || $hist->abonnement->nombre_annonces === null) ? '∞' : $hist->abonnement->nombre_annonces }}
                        </td>
                        <td style="text-align: center;">
                            @if($hist->estActif())
                                <span class="status-badge" style="background: #f7fff0; color: #569b00; border: 1px solid #c7e5a1;">ACTIF</span>
                            @else
                                <span class="status-badge" style="background: #fcfcfc; color: #888; border: 1px solid #ddd;">INACTIF</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px; color: #999;">Aucun historique trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Danger Zone Standardized -->
    <div class="amazon-card" style="border: 1px solid #f9c2c2; background: #fffcfc;">
        <h3 style="font-size: 0.95rem; color: #c40000; font-weight: 700; margin: 0 0 15px 0; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-exclamation-triangle"></i> Zone de Danger
        </h3>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="font-size: 0.85rem; font-weight: 700; color: #111; margin: 0;">Supprimer ce compte vendeur</p>
                <p style="font-size: 0.8rem; color: #666; margin: 5px 0 0 0;">Cette action supprimera également le compte utilisateur associé. Elle est irréversible.</p>
            </div>
            <form action="{{ route('admin.users.destroy', $vendeur->user_id) }}" method="POST" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer ce vendeur ?');">
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


