@extends('layouts.admin')

@section('title', 'Dossier Livreur - ' . ($livreur->user->prenom ?? 'Utilisateur'))

@push('styles')
    <style>
        .main-content { background-color: #eef1f4 !important; }
        input:focus, textarea:focus, select:focus { border-color: #ff9900 !important; outline: none; }

        /* La feuille (page de document) */
        .sheet {
            max-width: 860px;
            margin: -20px auto 40px;
            background: #fff;
            border: 1px solid #e6e9ee;
            border-radius: 6px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
            padding: 48px 56px;
            color: #1f2937;
        }
        @media (max-width: 640px) { .sheet { padding: 28px 22px; } }

        .sheet-eyebrow { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: #0f172a; }
        .sheet-title { font-size: 1.7rem; font-weight: 800; color: #0f172a; margin: 6px 0 10px; line-height: 1.15; }
        .sheet-meta { font-size: 0.85rem; color: #64748b; }

        .status-badge { padding: 3px 12px; border-radius: 99px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em; display: inline-block; }
        .st-pending { background: #fff8f3; color: #f68b1e; border: 1px solid #fbd8b4; }
        .st-ok { background: #f7fff0; color: #569b00; border: 1px solid #c7e5a1; }
        .st-ko { background: #fff5f5; color: #c40000; border: 1px solid #f9c2c2; }

        /* Titres de section façon document */
        .sec { margin-top: 38px; }
        .sec-h { font-size: 0.95rem; font-weight: 800; color: #0f172a; padding-bottom: 8px; border-bottom: 1px solid #e6e9ee; margin-bottom: 4px; display: flex; align-items: baseline; gap: 10px; }
        .sec-h .num { color: #0f172a; font-weight: 800; }

        /* Lignes d'information (liste de définitions) */
        .dl { margin: 14px 0 0; border: 1px solid #e6e9ee; border-radius: 8px; overflow: hidden; }
        .dl-row { display: grid; grid-template-columns: 220px 1fr; font-size: 0.88rem; border-bottom: 1px solid #e6e9ee; }
        .dl-row:last-child { border-bottom: none; }
        .dl-row dt { color: #475569; font-weight: 600; margin: 0; padding: 11px 14px; background: #f8fafc; border-right: 1px solid #e6e9ee; }
        .dl-row dd { color: #0f172a; font-weight: 600; margin: 0; padding: 11px 14px; }
        @media (max-width: 520px) {
            .dl-row { grid-template-columns: 1fr; }
            .dl-row dt { border-right: none; border-bottom: 1px solid #e6e9ee; }
        }

        /* Pièces jointes */
        .doc-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-top: 14px; }
        @media (max-width: 600px) { .doc-grid { grid-template-columns: 1fr 1fr; } }
        .doc-label { display: block; font-size: 0.72rem; color: #94a3b8; margin-bottom: 6px; font-weight: 600; }
        .doc-box { display: block; border-radius: 8px; overflow: hidden; border: 1px solid #e6e9ee; transition: border-color .15s; }
        .doc-box:hover { border-color: #f68b1e; }
        .doc-box img { width: 100%; height: 150px; object-fit: cover; display: block; }
        .doc-pdf { padding: 30px 10px; text-align: center; background: #f8fafc; }
        .doc-empty { padding: 20px; background: #f9fafb; border: 1px dashed #e2e8f0; border-radius: 8px; text-align: center; color: #94a3b8; font-size: 0.82rem; }

        .btn-secondary { background: #fff; border: 1px solid #ddd; color: #475569; padding: 7px 14px; border-radius: 6px; font-size: 0.82rem; font-weight: 600; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; }
        .btn-secondary:hover { background: #f7f7f7; border-color: #ccc; color: #111; }

        .panel { margin-top: 16px; padding: 20px; border-radius: 8px; }

        @media print {
            .main-content { background: #fff !important; }
            .sheet { box-shadow: none; border: none; margin: 0; max-width: 100%; }
            .no-print { display: none !important; }
        }
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
@endphp

<div class="sheet">

    {{-- Barre d'actions (non imprimée) --}}
    <div class="no-print" style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
        <a href="{{ route('admin.livreurs.index') }}" class="btn-secondary" title="Fermer"
           style="width: 36px; height: 36px; padding: 0; font-size: 1.2rem; line-height: 1;">&times;</a>
    </div>
    <hr class="no-print" style="border: none; border-top: 1px solid #e6e9ee; margin: 0 0 24px;">

    {{-- En-tête du dossier --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap; padding-bottom: 22px; border-bottom: 1px solid #e6e9ee;">
        <div>
            <div class="sheet-eyebrow">Dossier de vérification — Livreur</div>
            <h1 class="sheet-title">{{ $livreur->user->prenom }} {{ $livreur->user->nom }}</h1>
            <div class="sheet-meta">
                Dossier n° {{ $livreur->id }} · Ouvert le {{ $livreur->created_at->format('d/m/Y') }}
            </div>
        </div>
        <div style="text-align: right; font-size: 0.95rem; font-weight: 700;">
            <span style="color: #64748b; font-weight: 600;">Statut :</span>
            @if ($livreur->statut_verification === 'en_attente')
                <span style="color: #f68b1e;">En attente</span>
            @elseif ($livreur->statut_verification === 'verifie')
                <span style="color: #569b00;">Vérifié</span>
            @else
                <span style="color: #c40000;">Rejeté</span>
            @endif
        </div>
    </div>

    {{-- 1. Identité & coordonnées --}}
    <div class="sec">
        <h2 class="sec-h"><span class="num">1.</span> Identité &amp; coordonnées</h2>
        <dl class="dl">
            <div class="dl-row"><dt>Nom complet</dt><dd>{{ $livreur->user->prenom }} {{ $livreur->user->nom }}</dd></div>
            <div class="dl-row"><dt>Email</dt><dd>{{ $livreur->user->email ?: '—' }}</dd></div>
            <div class="dl-row"><dt>Téléphone</dt><dd>{{ $livreur->user->telephone ?? '—' }}</dd></div>
            <div class="dl-row"><dt>Pays</dt><dd>{{ $pays ?? '—' }}</dd></div>
            <div class="dl-row"><dt>Région</dt><dd>{{ $livreur->region ?? '—' }}</dd></div>
        </dl>
    </div>

    {{-- 2. Pièce d'identité --}}
    <div class="sec">
        <h2 class="sec-h"><span class="num">2.</span> Pièce d'identité</h2>
        <dl class="dl">
            <div class="dl-row"><dt>Type de pièce</dt><dd>{{ strtoupper($livreur->type_piece ?? $livreur->type_document ?? '—') }}</dd></div>
            <div class="dl-row"><dt>N° de pièce</dt><dd>{{ $livreur->numero_piece ?? $livreur->numero_document ?? '—' }}</dd></div>
        </dl>
        @if(count($idDocs) === 0)
            <div class="doc-empty" style="margin-top: 14px;">Aucun document d'identité fourni</div>
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

    {{-- 3. Véhicule --}}
    <div class="sec">
        <h2 class="sec-h"><span class="num">3.</span> Véhicule</h2>
        <dl class="dl">
            <div class="dl-row"><dt>Type de véhicule</dt><dd>{{ $livreur->type_vehicule ?? '—' }}</dd></div>
            <div class="dl-row"><dt>N° de châssis</dt><dd>{{ $livreur->numero_chassis ?? '—' }}</dd></div>
            <div class="dl-row"><dt>Immatriculation</dt><dd>{{ $livreur->immatriculation ?? '—' }}</dd></div>
        </dl>
        @if(count($vehDocs) === 0)
            <div class="doc-empty" style="margin-top: 14px;">Aucune pièce véhicule fournie</div>
        @else
            <div class="doc-grid">
                @foreach($vehDocs as $doc)
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

    @if($livreur->statut_verification === 'rejete' && $livreur->raison_rejet)
        <div class="sec">
            <h2 class="sec-h" style="border-bottom-color: #c40000; color: #c40000;"><i class="fas fa-times-circle"></i> Motif du rejet</h2>
            <p style="font-size: 0.88rem; color: #555; white-space: pre-line; margin: 12px 0 0;">{{ $livreur->raison_rejet }}</p>
        </div>
    @endif

    {{-- 4. Décision administrative --}}
    <div class="sec no-print">
        <h2 class="sec-h"><span class="num">4.</span> Décision administrative</h2>

        @if($livreur->statut_verification === 'en_attente')
            <div class="panel" style="border: 1px solid #e6e9ee; background: #fff;"
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
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <label style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.85rem; cursor: pointer; padding: 10px; background: #fff; border: 1px solid #eff3f6; border-radius: 6px;">
                        <input type="radio" x-model="decision" value="approve" name="decision_type">
                        <span style="font-weight: 700; color: #16a34a;">Approuver</span>
                    </label>
                    <label style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.85rem; cursor: pointer; padding: 10px; background: #fff; border: 1px solid #eff3f6; border-radius: 6px;">
                        <input type="radio" x-model="decision" value="reject" name="decision_type">
                        <span style="font-weight: 700; color: #b91c1c;">Rejeter</span>
                    </label>
                </div>

                <form x-show="decision === 'approve'" method="POST" action="{{ route('admin.livreurs.approve', $livreur) }}">
                    @csrf
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; margin-bottom: 6px;">Commentaire (optionnel)</label>
                    <textarea name="commentaire" rows="4" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; font-size: 0.85rem; border-radius: 6px; box-sizing: border-box;">Félicitations ! Votre dossier de livreur a été validé. Vous pouvez désormais recevoir des commandes de livraison sur Karnou.</textarea>
                    <button type="submit" style="width: 100%; margin-top: 14px; height: 46px; background: #2563eb; color: #fff; border: none; border-radius: 6px; font-size: 0.9rem; font-weight: 700; cursor: pointer;">Approuver le dossier</button>
                </form>

                <form x-show="decision === 'reject'" method="POST" action="{{ route('admin.livreurs.reject', $livreur) }}">
                    @csrf
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; margin-bottom: 10px;">Champs à revoir</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #fff; padding: 15px; border: 1px solid #eff3f6; border-radius: 6px; margin-bottom: 14px;">
                        @php
                            $fields = ['Prénom / Nom', 'Téléphone', 'Type de pièce', 'Numéro de pièce', 'Type de véhicule', 'Numéro de châssis', 'Immatriculation', 'Région', 'Pièce justificative', 'Document du véhicule'];
                        @endphp
                        @foreach($fields as $field)
                            <label style="display: flex; align-items: start; gap: 8px; font-size: 0.8rem; cursor: pointer; line-height: 1.3;">
                                <input type="checkbox" value="{{ $field }}" x-model="selectedFields" @change="updateReason()" style="margin-top: 2px;">
                                <span>{{ $field }}</span>
                            </label>
                        @endforeach
                    </div>
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; margin-bottom: 6px;">Motif détaillé (obligatoire)</label>
                    <textarea name="raison_rejet" x-model="reason" required rows="6" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; font-size: 0.85rem; border-radius: 6px; box-sizing: border-box;"></textarea>
                    <button type="submit" style="width: 100%; margin-top: 14px; height: 46px; background: #dc2626; color: #fff; border: none; border-radius: 6px; font-size: 0.9rem; font-weight: 700; cursor: pointer;">Rejeter le dossier</button>
                </form>
            </div>
        @elseif($livreur->statut_verification === 'verifie')
            <div class="panel" style="background: #f7fff0; border: 1px solid #c7e5a1;">
                <p style="font-size: 0.88rem; color: #569b00; font-weight: 600; margin: 0 0 14px;"><i class="fas fa-check-circle"></i> Ce dossier a été vérifié et approuvé.</p>
                <form action="{{ route('admin.livreurs.reject', $livreur) }}" method="POST" onsubmit="return confirm('Rejeter ce dossier déjà vérifié ?')">
                    @csrf
                    <input type="hidden" name="raison_rejet" value="Dossier réexaminé puis rejeté par l'administration.">
                    <button type="submit" class="btn-secondary" style="color: #c40000; border-color: #f9c2c2;">Rejeter ce dossier</button>
                </form>
            </div>
        @else
            <div class="panel" style="background: #fff5f5; border: 1px solid #f9c2c2;">
                <p style="font-size: 0.88rem; color: #c40000; font-weight: 600; margin: 0 0 14px;"><i class="fas fa-times-circle"></i> Ce dossier a été rejeté.</p>
                <form action="{{ route('admin.livreurs.approve', $livreur) }}" method="POST">
                    @csrf
                    <button type="submit" style="height: 42px; padding: 0 22px; background: #16a34a; color: #fff; border: none; border-radius: 6px; font-weight: 700; cursor: pointer;">Approuver finalement</button>
                </form>
            </div>
        @endif
    </div>

    {{-- Zone de danger --}}
    <div class="sec no-print">
        <h2 class="sec-h" style="border-bottom-color: #c40000; color: #c40000;"><i class="fas fa-exclamation-triangle"></i> Zone de danger</h2>
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-top: 14px;">
            <p style="font-size: 0.83rem; color: #666; margin: 0;">Supprime la fiche livreur et ses documents. Cette action est irréversible.</p>
            <form action="{{ route('admin.livreurs.destroy', $livreur) }}" method="POST" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer ce livreur ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-secondary" style="color: #c40000; border-color: #f9c2c2;">Supprimer définitivement</button>
            </form>
        </div>
    </div>

</div>
@endsection
