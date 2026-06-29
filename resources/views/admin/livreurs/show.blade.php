@extends('layouts.admin')

@section('title', 'Dossier Livreur - ' . ($livreur->user->prenom ?? 'Utilisateur'))

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        input:focus, textarea:focus, select:focus { border-color: #ff9900 !important; outline: none; }

        .card { background: #fff; border: 1px solid #eff3f6; border-radius: 10px; padding: 22px; }
        .card + .card { margin-top: 18px; }

        .sec-title { font-size: 0.78rem; font-weight: 700; color: #334155; margin: 0 0 16px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 10px; }
        .sec-num { width: 22px; height: 22px; border-radius: 50%; background: #fff7ed; color: #ea580c; font-size: 0.72rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; flex: none; }

        .info-row { display: grid; grid-template-columns: 160px 1fr; gap: 12px; padding: 9px 0; font-size: 0.85rem; border-bottom: 1px dashed #f1f5f9; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #64748b; font-weight: 500; }
        .info-value { color: #0f172a; font-weight: 600; }

        .status-badge { padding: 3px 12px; border-radius: 99px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em; display: inline-block; }
        .st-pending { background: #fff8f3; color: #f68b1e; border: 1px solid #fbd8b4; }
        .st-ok { background: #f7fff0; color: #569b00; border: 1px solid #c7e5a1; }
        .st-ko { background: #fff5f5; color: #c40000; border: 1px solid #f9c2c2; }

        .btn-secondary { background: #fff; border: 1px solid #ddd; color: #475569; padding: 7px 14px; border-radius: 6px; font-size: 0.82rem; font-weight: 600; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; }
        .btn-secondary:hover { background: #f7f7f7; border-color: #ccc; color: #111; }

        /* Bandeau identité */
        .dossier-header { display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; background: #fff; border: 1px solid #eff3f6; border-radius: 10px; padding: 20px 24px; margin-bottom: 18px; }
        .avatar { width: 56px; height: 56px; border-radius: 50%; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem; border: 1px solid #ffedd5; flex: none; }
        .chip { display: inline-flex; align-items: center; gap: 6px; background: #f8fafc; border: 1px solid #eef2f6; border-radius: 99px; padding: 3px 10px; font-size: 0.74rem; color: #475569; font-weight: 500; }
        .chip i { color: #94a3b8; font-size: 0.72rem; }

        /* Mise en page dossier */
        .dossier-grid { display: grid; grid-template-columns: 1fr 330px; gap: 18px; align-items: start; }
        @media (max-width: 992px) { .dossier-grid { grid-template-columns: 1fr; } }

        /* Pièces jointes */
        .doc-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        @media (max-width: 600px) { .doc-grid { grid-template-columns: 1fr 1fr; } }
        .doc-label { display: block; font-size: 0.72rem; color: #94a3b8; margin-bottom: 6px; font-weight: 600; }
        .doc-box { display: block; border-radius: 8px; overflow: hidden; border: 1px solid #eee; transition: border-color .15s; }
        .doc-box:hover { border-color: #f68b1e; }
        .doc-box img { width: 100%; height: 140px; object-fit: cover; display: block; }
        .doc-pdf { padding: 28px 10px; text-align: center; background: #f8fafc; }
        .doc-empty { padding: 22px; background: #f9fafb; border: 1px dashed #e2e8f0; border-radius: 8px; text-align: center; color: #94a3b8; font-size: 0.82rem; }
    </style>
@endpush

@section('content')
@php
    $pieceLabel = $livreur->type_piece ? strtoupper($livreur->type_piece) : ($livreur->type_document ?? 'Pièce');
    $idDocs = array_values(array_filter([
        ['label' => $pieceLabel, 'path' => $livreur->document_piece, 'url' => $documents['document_piece']],
        ['label' => 'Recto',     'path' => $livreur->document_recto, 'url' => $documents['document_recto']],
        ['label' => 'Verso',     'path' => $livreur->document_verso, 'url' => $documents['document_verso']],
    ], fn ($d) => !empty($d['path'])));
    $vehDocs = array_values(array_filter([
        ['label' => 'Pièce véhicule', 'path' => $livreur->photo_vehicule, 'url' => $documents['photo_vehicule']],
    ], fn ($d) => !empty($d['path'])));
    $initiales = strtoupper(mb_substr($livreur->user->prenom ?? '', 0, 1) . mb_substr($livreur->user->nom ?? '', 0, 1));
@endphp

<div style="max-width: 1240px; margin: -30px auto 0;">

    {{-- Bandeau identité --}}
    <div class="dossier-header">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div class="avatar">{{ $initiales ?: '?' }}</div>
            <div>
                <div style="font-size: 1.15rem; font-weight: 700; color: #0f172a;">{{ $livreur->user->prenom }} {{ $livreur->user->nom }}</div>
                <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px;">
                    <span class="chip"><i class="fas fa-hashtag"></i> Dossier #{{ $livreur->id }}</span>
                    <span class="chip"><i class="fas fa-phone"></i> {{ $livreur->user->telephone ?? '—' }}</span>
                    <span class="chip"><i class="fas fa-flag"></i> {{ $pays ?? '—' }}</span>
                    <span class="chip"><i class="fas fa-motorcycle"></i> {{ $livreur->type_vehicule ?? '—' }}</span>
                </div>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            @if ($livreur->statut_verification === 'en_attente')
                <span class="status-badge st-pending">EN ATTENTE</span>
            @elseif ($livreur->statut_verification === 'verifie')
                <span class="status-badge st-ok">VÉRIFIÉ</span>
            @else
                <span class="status-badge st-ko">REJETÉ</span>
            @endif
            <a href="{{ route('admin.livreurs.index') }}" class="btn-secondary"><i class="fas fa-chevron-left"></i> Retour</a>
        </div>
    </div>

    <div class="dossier-grid">

        {{-- ===================== COLONNE PRINCIPALE ===================== --}}
        <div>
            {{-- 1. Identité & coordonnées --}}
            <div class="card">
                <h2 class="sec-title"><span class="sec-num">1</span> Identité &amp; coordonnées</h2>
                <div class="info-row"><span class="info-label">Nom complet</span><span class="info-value">{{ $livreur->user->prenom }} {{ $livreur->user->nom }}</span></div>
                <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $livreur->user->email ?: '—' }}</span></div>
                <div class="info-row"><span class="info-label">Téléphone</span><span class="info-value">{{ $livreur->user->telephone ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Pays</span><span class="info-value">{{ $pays ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Région</span><span class="info-value">{{ $livreur->region ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Ville</span><span class="info-value">{{ $livreur->user->ville ?? '—' }}</span></div>
            </div>

            {{-- 2. Pièce d'identité --}}
            <div class="card">
                <h2 class="sec-title"><span class="sec-num">2</span> Pièce d'identité</h2>
                <div class="info-row"><span class="info-label">Type de pièce</span><span class="info-value">{{ strtoupper($livreur->type_piece ?? $livreur->type_document ?? '—') }}</span></div>
                <div class="info-row"><span class="info-label">N° de pièce</span><span class="info-value">{{ $livreur->numero_piece ?? $livreur->numero_document ?? '—' }}</span></div>

                <div style="margin-top: 16px;">
                    <span class="doc-label">Pièces jointes</span>
                    @if(count($idDocs) === 0)
                        <div class="doc-empty">Aucun document d'identité fourni</div>
                    @else
                        <div class="doc-grid">
                            @foreach($idDocs as $doc)
                                <div>
                                    <span class="doc-label">{{ $doc['label'] }}</span>
                                    <a href="{{ $doc['url'] }}" target="_blank" class="doc-box">
                                        @if(Str::endsWith(strtolower($doc['path']), '.pdf'))
                                            <div class="doc-pdf"><i class="far fa-file-pdf" style="font-size: 1.8rem; color: #ef4444;"></i><div style="font-size: 0.78rem; color: #475569; margin-top: 6px;">Voir le PDF</div></div>
                                        @else
                                            <img src="{{ $doc['url'] }}" alt="{{ $doc['label'] }}">
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- 3. Véhicule --}}
            <div class="card">
                <h2 class="sec-title"><span class="sec-num">3</span> Véhicule</h2>
                <div class="info-row"><span class="info-label">Type de véhicule</span><span class="info-value">{{ $livreur->type_vehicule ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">N° de châssis</span><span class="info-value">{{ $livreur->numero_chassis ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Immatriculation</span><span class="info-value">{{ $livreur->immatriculation ?? '—' }}</span></div>

                <div style="margin-top: 16px;">
                    <span class="doc-label">Pièce véhicule</span>
                    @if(count($vehDocs) === 0)
                        <div class="doc-empty">Aucune pièce véhicule fournie</div>
                    @else
                        <div class="doc-grid">
                            @foreach($vehDocs as $doc)
                                <div>
                                    <a href="{{ $doc['url'] }}" target="_blank" class="doc-box">
                                        @if(Str::endsWith(strtolower($doc['path']), '.pdf'))
                                            <div class="doc-pdf"><i class="far fa-file-pdf" style="font-size: 1.8rem; color: #ef4444;"></i><div style="font-size: 0.78rem; color: #475569; margin-top: 6px;">Voir le PDF</div></div>
                                        @else
                                            <img src="{{ $doc['url'] }}" alt="{{ $doc['label'] }}">
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if($livreur->statut_verification === 'rejete' && $livreur->raison_rejet)
                <div class="card" style="border-color: #f9c2c2; background: #fffcfc;">
                    <h2 class="sec-title" style="border-bottom-color: #f9c2c2; color: #c40000;"><i class="fas fa-times-circle"></i> Motif du rejet</h2>
                    <p style="font-size: 0.85rem; color: #555; white-space: pre-line; margin: 0;">{{ $livreur->raison_rejet }}</p>
                </div>
            @endif
        </div>

        {{-- ===================== COLONNE LATÉRALE ===================== --}}
        <aside>
            {{-- Synthèse --}}
            <div class="card">
                <h2 class="sec-title"><i class="fas fa-folder-open" style="color:#f68b1e;"></i> Synthèse</h2>
                <div class="info-row"><span class="info-label">Statut</span><span class="info-value">
                    @if ($livreur->statut_verification === 'en_attente')<span class="status-badge st-pending">EN ATTENTE</span>
                    @elseif ($livreur->statut_verification === 'verifie')<span class="status-badge st-ok">VÉRIFIÉ</span>
                    @else<span class="status-badge st-ko">REJETÉ</span>@endif
                </span></div>
                <div class="info-row"><span class="info-label">Disponibilité</span><span class="info-value">{{ $livreur->en_ligne ? 'En ligne' : 'Hors ligne' }}</span></div>
                <div class="info-row"><span class="info-label">Pièces jointes</span><span class="info-value">{{ count($idDocs) + count($vehDocs) }}</span></div>
                <div class="info-row"><span class="info-label">Inscrit le</span><span class="info-value">{{ $livreur->created_at->format('d/m/Y à H:i') }}</span></div>
            </div>

            {{-- Décision / statut --}}
            @if($livreur->statut_verification === 'en_attente')
                <div class="card" style="border: 2px solid #fbd8b4; background: #fffcf9;"
                     x-data="{
                        decision: 'approve',
                        reason: 'Votre demande de compte livreur n\'a pas pu être approuvée en l\'état sur Karnou. Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.',
                        selectedFields: [],
                        updateReason() {
                            let base = 'Votre demande de compte livreur n\'a pas pu être approuvée en l\'état sur Karnou. Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.';
                            if (this.selectedFields.length > 0) { base += '\n\nChamps à revoir :\n' + this.selectedFields.map(f => ' - ' + f).join('\n'); }
                            this.reason = base;
                        }
                     }">
                    <h2 class="sec-title" style="border-bottom-color: #fbd8b4; color: #c45500;"><i class="fas fa-gavel"></i> Décision</h2>

                    <div style="display: flex; gap: 8px; margin-bottom: 18px;">
                        <label style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 0.82rem; cursor: pointer; padding: 8px; background: #fff; border: 1px solid #eff3f6; border-radius: 6px;">
                            <input type="radio" x-model="decision" value="approve" name="decision_type">
                            <span style="font-weight: 700; color: #16a34a;">Approuver</span>
                        </label>
                        <label style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 0.82rem; cursor: pointer; padding: 8px; background: #fff; border: 1px solid #eff3f6; border-radius: 6px;">
                            <input type="radio" x-model="decision" value="reject" name="decision_type">
                            <span style="font-weight: 700; color: #b91c1c;">Rejeter</span>
                        </label>
                    </div>

                    <form x-show="decision === 'approve'" method="POST" action="{{ route('admin.livreurs.approve', $livreur) }}">
                        @csrf
                        <label style="display: block; font-size: 0.76rem; font-weight: 700; margin-bottom: 5px;">Commentaire (optionnel)</label>
                        <textarea name="commentaire" rows="4" style="width: 100%; padding: 9px; border: 1px solid #cbd5e1; font-size: 0.82rem; border-radius: 6px; box-sizing: border-box;">Félicitations ! Votre dossier de livreur a été validé. Vous pouvez désormais recevoir des commandes de livraison sur Karnou.</textarea>
                        <button type="submit" style="width: 100%; margin-top: 12px; height: 42px; background: #16a34a; color: #fff; border: none; border-radius: 6px; font-size: 0.88rem; font-weight: 700; cursor: pointer;">Approuver le dossier ✓</button>
                    </form>

                    <form x-show="decision === 'reject'" method="POST" action="{{ route('admin.livreurs.reject', $livreur) }}">
                        @csrf
                        <label style="display: block; font-size: 0.76rem; font-weight: 700; margin-bottom: 8px;">Champs à revoir</label>
                        <div style="display: flex; flex-direction: column; gap: 6px; background: #fff; padding: 12px; border: 1px solid #eff3f6; border-radius: 6px; margin-bottom: 12px;">
                            @php
                                $fields = ['Pièce d\'identité', 'Numéro de pièce', 'Pièce véhicule', 'Type de véhicule', 'Immatriculation', 'Document illisible', 'Document expiré', 'Coordonnées'];
                            @endphp
                            @foreach($fields as $field)
                                <label style="display: flex; align-items: start; gap: 8px; font-size: 0.78rem; cursor: pointer; line-height: 1.3;">
                                    <input type="checkbox" value="{{ $field }}" x-model="selectedFields" @change="updateReason()" style="margin-top: 2px;">
                                    <span>{{ $field }}</span>
                                </label>
                            @endforeach
                        </div>
                        <label style="display: block; font-size: 0.76rem; font-weight: 700; margin-bottom: 5px;">Motif détaillé (obligatoire)</label>
                        <textarea name="raison_rejet" x-model="reason" required rows="6" style="width: 100%; padding: 9px; border: 1px solid #cbd5e1; font-size: 0.82rem; border-radius: 6px; box-sizing: border-box;"></textarea>
                        <button type="submit" style="width: 100%; margin-top: 12px; height: 42px; background: #dc2626; color: #fff; border: none; border-radius: 6px; font-size: 0.88rem; font-weight: 700; cursor: pointer;">Rejeter le dossier ✕</button>
                    </form>
                </div>
            @else
                <div class="card">
                    <h2 class="sec-title"><i class="fas fa-gavel" style="color:#f68b1e;"></i> Décision</h2>
                    @if($livreur->statut_verification === 'verifie')
                        <p style="font-size: 0.85rem; color: #569b00; font-weight: 600; margin: 0 0 14px;"><i class="fas fa-check-circle"></i> Dossier vérifié et approuvé.</p>
                        <form action="{{ route('admin.livreurs.reject', $livreur) }}" method="POST" onsubmit="return confirm('Rejeter ce dossier déjà vérifié ?')">
                            @csrf
                            <input type="hidden" name="raison_rejet" value="Dossier réexaminé puis rejeté par l'administration.">
                            <button type="submit" class="btn-secondary" style="width: 100%; color: #c40000; border-color: #f9c2c2;">Rejeter ce dossier</button>
                        </form>
                    @else
                        <p style="font-size: 0.85rem; color: #c40000; font-weight: 600; margin: 0 0 14px;"><i class="fas fa-times-circle"></i> Dossier rejeté.</p>
                        <form action="{{ route('admin.livreurs.approve', $livreur) }}" method="POST">
                            @csrf
                            <button type="submit" style="width: 100%; height: 40px; background: #16a34a; color: #fff; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Approuver finalement</button>
                        </form>
                    @endif
                </div>
            @endif

            {{-- Zone de danger --}}
            <div class="card" style="border-color: #f9c2c2; background: #fffcfc;">
                <h2 class="sec-title" style="border-bottom-color: #f9c2c2; color: #c40000;"><i class="fas fa-exclamation-triangle"></i> Zone de danger</h2>
                <p style="font-size: 0.8rem; color: #666; margin: 0 0 12px;">Supprime la fiche livreur et ses documents. Action irréversible.</p>
                <form action="{{ route('admin.livreurs.destroy', $livreur) }}" method="POST" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer ce livreur ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-secondary" style="width: 100%; color: #c40000; border-color: #f9c2c2;">Supprimer définitivement</button>
                </form>
            </div>
        </aside>
    </div>
</div>
@endsection
