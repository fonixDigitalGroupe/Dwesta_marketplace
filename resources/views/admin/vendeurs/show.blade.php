@extends('layouts.admin')

@section('title', 'Dossier Vendeur - ' . ($vendeur->user->prenom ?? 'Utilisateur'))

@push('styles')
    <style>
        .main-content { background-color: #eef1f4 !important; }
        input:focus, textarea:focus, select:focus { border-color: #ff9900 !important; outline: none; }
        .sheet textarea, .sheet input, .sheet select, .sheet button { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }

        .sheet {
            max-width: 860px;
            margin: -20px auto 40px;
            background: #fff;
            border: 1px solid #e6e9ee;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            padding: 48px 56px;
            color: #1f2937;
        }
        @media (max-width: 640px) { .sheet { padding: 28px 22px; } }

        .sheet-eyebrow { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: #0f172a; }
        .sheet-title { font-size: 1.7rem; font-weight: 800; color: #0f172a; margin: 6px 0 10px; line-height: 1.15; }
        .sheet-meta { font-size: 0.85rem; color: #64748b; }

        .sec { margin-top: 38px; }
        .sec-h { font-size: 0.95rem; font-weight: 800; color: #0f172a; padding-bottom: 8px; border-bottom: 1px solid #e6e9ee; margin-bottom: 4px; display: flex; align-items: baseline; gap: 10px; }
        .sec-h .num { color: #0f172a; font-weight: 800; }

        .dl { margin: 14px 0 0; border: 1px solid #e6e9ee; border-radius: 8px; overflow: hidden; }
        .dl-row { display: grid; grid-template-columns: 220px 1fr; font-size: 0.88rem; border-bottom: 1px solid #e6e9ee; }
        .dl-row:last-child { border-bottom: none; }
        .dl-row dt { color: #374151; font-weight: 600; margin: 0; padding: 11px 14px; background: #d1d5db; border-right: 1px solid #e6e9ee; }
        .dl-row dd { color: #0f172a; font-weight: 600; margin: 0; padding: 11px 14px; }
        @media (max-width: 520px) {
            .dl-row { grid-template-columns: 1fr; }
            .dl-row dt { border-right: none; border-bottom: 1px solid #e6e9ee; }
        }

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
    $estPro = $vendeur->estProfessionnel();
    if ($estPro) {
        $docLabel = 'Registre de commerce';
        $docPath  = $vendeur->professionnel->registre_commerce_path ?? null;
        $docUrl   = $vendeur->professionnel->registre_url ?? null;
    } else {
        $docLabel = "Pièce d'identité";
        $docPath  = $vendeur->particulier->document_path ?? null;
        $docUrl   = $vendeur->particulier->document_url ?? null;
    }
    $formule = $vendeur->abonnement_actuel;
@endphp

<div class="sheet">

    {{-- Barre d'actions --}}
    <div class="no-print" style="display: flex; justify-content: flex-end; margin-bottom: 16px;">
        <a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" title="Fermer"
           style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; padding: 0; font-size: 1.2rem; line-height: 1; background: #dc2626; color: #fff; border: 1px solid #dc2626; border-radius: 6px; text-decoration: none; transition: background 0.2s;"
           onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">&times;</a>
    </div>
    <hr class="no-print" style="border: none; border-top: 1px solid #e6e9ee; margin: 0 0 24px;">

    {{-- En-tête du dossier --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap; padding-bottom: 22px; border-bottom: 1px solid #e6e9ee;">
        <div>
            <div class="sheet-eyebrow">Dossier de vérification — Vendeur</div>
            <h1 class="sheet-title">{{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}</h1>
            <div class="sheet-meta">
                Dossier n° {{ $vendeur->id }} · Ouvert le {{ $vendeur->created_at->format('d/m/Y') }} · {{ $estPro ? 'Professionnel' : 'Particulier' }}
            </div>
        </div>
        <div style="text-align: right; font-size: 0.95rem; font-weight: 700;">
            <span style="color: #64748b; font-weight: 600;">Statut :</span>
            @if ($vendeur->statut_verification === 'en_attente')
                <span style="color: #f68b1e;">En attente</span>
            @elseif ($vendeur->statut_verification === 'verifie')
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
            <div class="dl-row"><dt>Nom complet</dt><dd>{{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}</dd></div>
            <div class="dl-row"><dt>Téléphone</dt><dd>{{ $vendeur->user->telephone ?? '—' }}</dd></div>
            <div class="dl-row"><dt>Adresse</dt><dd>{{ $vendeur->user->adresse ?: '—' }}</dd></div>
            <div class="dl-row"><dt>Ville</dt><dd>{{ $vendeur->user->ville ?: '—' }}</dd></div>
            <div class="dl-row"><dt>Région</dt><dd>{{ $vendeur->user->region ?: '—' }}</dd></div>
            <div class="dl-row"><dt>Code postal</dt><dd>{{ $vendeur->user->code_postal ?: '—' }}</dd></div>
            <div class="dl-row"><dt>Pays</dt><dd>{{ $pays ?: '—' }}</dd></div>
            @if($vendeur->user->latitude && $vendeur->user->longitude)
                <div class="dl-row"><dt>Localisation GPS</dt><dd>
                    <a href="https://www.google.com/maps?q={{ $vendeur->user->latitude }},{{ $vendeur->user->longitude }}" target="_blank" style="color:#2563eb; text-decoration:none;">
                        <i class="fas fa-map-marker-alt"></i> {{ $vendeur->user->latitude }}, {{ $vendeur->user->longitude }}
                    </a>
                </dd></div>
            @endif
        </dl>
    </div>

    {{-- 2. Pièce justificative (particulier ou entreprise) --}}
    <div class="sec">
        @if($estPro)
            <h2 class="sec-h"><span class="num">2.</span> Entreprise</h2>
            <dl class="dl">
                <div class="dl-row"><dt>Raison sociale</dt><dd>{{ $vendeur->professionnel->nom_entreprise ?? '—' }}</dd></div>
                <div class="dl-row"><dt>N° RCCM</dt><dd>{{ $vendeur->professionnel->numero_registre_commerce ?? '—' }}</dd></div>
                <div class="dl-row"><dt>Adresse entreprise</dt><dd>{{ $vendeur->professionnel->adresse_entreprise ?: '—' }}</dd></div>
                <div class="dl-row"><dt>Téléphone entreprise</dt><dd>{{ $vendeur->professionnel->telephone_entreprise ?: '—' }}</dd></div>
                <div class="dl-row"><dt>Email entreprise</dt><dd>{{ $vendeur->professionnel->email_entreprise ?: '—' }}</dd></div>
                <div class="dl-row"><dt>Émission</dt><dd>{{ optional($vendeur->professionnel?->date_emission_registre)->format('d/m/Y') ?? '—' }}</dd></div>
                <div class="dl-row"><dt>Expiration</dt><dd>{{ optional($vendeur->professionnel?->date_expiration_registre)->format('d/m/Y') ?? '—' }}</dd></div>
            </dl>
        @else
            <h2 class="sec-h"><span class="num">2.</span> Pièce d'identité</h2>
            <dl class="dl">
                <div class="dl-row"><dt>Type de document</dt><dd>{{ strtoupper($vendeur->particulier->type_document ?? '—') }}</dd></div>
                <div class="dl-row"><dt>Numéro</dt><dd>{{ $vendeur->particulier->numero_document ?? '—' }}</dd></div>
                <div class="dl-row"><dt>Émission</dt><dd>{{ optional($vendeur->particulier?->date_emission_document)->format('d/m/Y') ?? '—' }}</dd></div>
                <div class="dl-row"><dt>Expiration</dt><dd>{{ optional($vendeur->particulier?->date_expiration_document)->format('d/m/Y') ?? '—' }}</dd></div>
            </dl>
        @endif

        @if($docPath && $docUrl)
            <div class="doc-grid">
                <div>
                    <span class="doc-label">{{ $docLabel }}</span>
                    <a href="{{ $docUrl }}" target="_blank" class="doc-box">
                        @if(Str::endsWith(strtolower($docPath), '.pdf'))
                            <div class="doc-pdf"><i class="far fa-file-pdf" style="font-size: 1.8rem; color: #ef4444;"></i><div style="font-size: 0.78rem; color: #475569; margin-top: 6px;">Voir le PDF</div></div>
                        @else
                            <img src="{{ $docUrl }}" alt="{{ $docLabel }}">
                        @endif
                    </a>
                </div>
            </div>
        @else
            <div class="doc-empty" style="margin-top: 14px;">Aucun document fourni</div>
        @endif
    </div>

    {{-- 3. Abonnement & formule --}}
    <div class="sec">
        <h2 class="sec-h"><span class="num">3.</span> Abonnement &amp; formule</h2>
        <dl class="dl">
            <div class="dl-row"><dt>Formule actuelle</dt><dd>{{ $vendeur->abonnementActif ? ($formule->nom ?? $formule->type ?? '—') : 'Gratuit' }}</dd></div>
            <div class="dl-row"><dt>Commission</dt><dd>{{ $formule ? $formule->commission : '0' }}%</dd></div>
            <div class="dl-row"><dt>Page Pro</dt><dd>{{ ($formule && $formule->page_pro) ? 'Inclus' : 'Non inclus' }}</dd></div>
        </dl>
    </div>

    @if($vendeur->statut_verification === 'rejete' && $vendeur->raison_rejet)
        <div class="sec">
            <h2 class="sec-h" style="border-bottom-color: #c40000; color: #c40000;"><i class="fas fa-times-circle"></i> Motif du rejet</h2>
            <p style="font-size: 0.88rem; color: #555; white-space: pre-line; margin: 12px 0 0;">{{ $vendeur->raison_rejet }}</p>
        </div>
    @endif

    {{-- 4. Décision administrative --}}
    <div class="sec no-print">
        <h2 class="sec-h"><span class="num">4.</span> Décision administrative</h2>

        @if($vendeur->statut_verification === 'en_attente')
            <div class="panel" style="border: 1px solid #e6e9ee; background: #fff;"
                 x-data="{
                    decision: 'approve',
                    reason: 'Votre demande de compte vendeur n\'a pas pu être approuvée en l\'état sur Karnou. Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.',
                    selectedFields: [],
                    updateReason() {
                        let base = 'Votre demande de compte vendeur n\'a pas pu être approuvée en l\'état sur Karnou. Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.';
                        if (this.selectedFields.length > 0) { base += '\n\nChamps à revoir :\n' + this.selectedFields.map(f => ' - ' + f).join('\n'); }
                        this.reason = base;
                    }
                 }">
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <label style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.85rem; cursor: pointer; padding: 10px; background: #fff; border: 1px solid #eff3f6; border-radius: 6px;">
                        <input type="radio" x-model="decision" value="approve" name="decision_type">
                        <span style="font-weight: 700; color: #111;">Approuver</span>
                    </label>
                    <label style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.85rem; cursor: pointer; padding: 10px; background: #fff; border: 1px solid #eff3f6; border-radius: 6px;">
                        <input type="radio" x-model="decision" value="reject" name="decision_type">
                        <span style="font-weight: 700; color: #111;">Rejeter</span>
                    </label>
                </div>

                <form x-show="decision === 'approve'" method="POST" action="{{ route('admin.vendeurs.verification.approve', $vendeur) }}">
                    @csrf
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; margin-bottom: 6px;">Commentaire (optionnel)</label>
                    <textarea name="commentaire" rows="4" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; font-size: 0.85rem; border-radius: 6px; box-sizing: border-box;">Félicitations ! Votre identité a été confirmée. Vous pouvez désormais publier des annonces et effectuer des transactions en toute sécurité sur Karnou.</textarea>
                    <button type="submit" style="display: block; margin: 14px 0 0 auto; height: 42px; padding: 0 24px; background: #2563eb; color: #fff; border: none; border-radius: 6px; font-size: 0.9rem; font-weight: 700; cursor: pointer;">Approuver le dossier</button>
                </form>

                <form x-show="decision === 'reject'" method="POST" action="{{ route('admin.vendeurs.verification.reject', $vendeur) }}">
                    @csrf
                    <label style="display: block; font-size: 0.78rem; font-weight: 700; margin-bottom: 10px;">Champs à revoir</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #fff; padding: 15px; border: 1px solid #eff3f6; border-radius: 6px; margin-bottom: 14px;">
                        @php
                            $fields = ['Pièce d\'identité (CNI/Passeport)', 'Registre de commerce (RCCM)', 'Nom / Prénom', 'Raison sociale', 'Coordonnées (Tel, Ville)', 'Document illisible', 'Document expiré', 'Photo du document'];
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
                    <button type="submit" style="display: block; margin: 14px 0 0 auto; height: 42px; padding: 0 24px; background: #dc2626; color: #fff; border: none; border-radius: 6px; font-size: 0.9rem; font-weight: 700; cursor: pointer;">Rejeter le dossier</button>
                </form>
            </div>
        @elseif($vendeur->statut_verification === 'verifie')
            <div class="panel" style="background: #f7fff0; border: 1px solid #c7e5a1;">
                <p style="font-size: 0.88rem; color: #569b00; font-weight: 600; margin: 0;"><i class="fas fa-check-circle"></i> Ce dossier a été vérifié et approuvé.</p>
            </div>
        @else
            <div class="panel" style="background: #fff5f5; border: 1px solid #f9c2c2;">
                <p style="font-size: 0.88rem; color: #c40000; font-weight: 600; margin: 0;"><i class="fas fa-times-circle"></i> Ce dossier a été rejeté.</p>
            </div>
        @endif
    </div>

    {{-- Zone de danger --}}
    <div class="sec no-print">
        <h2 class="sec-h" style="border-bottom-color: #c40000; color: #c40000;"><i class="fas fa-exclamation-triangle"></i> Zone de danger</h2>
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-top: 14px;">
            <p style="font-size: 0.83rem; color: #666; margin: 0;">Supprime ce compte vendeur ainsi que l'utilisateur associé. Cette action est irréversible.</p>
            <form action="{{ route('admin.users.destroy', $vendeur->user_id) }}" method="POST" onsubmit="return confirm('Êtes-vous certain de vouloir supprimer ce vendeur ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-secondary" style="color: #c40000; border-color: #f9c2c2;">Supprimer définitivement</button>
            </form>
        </div>
    </div>

</div>
@endsection
