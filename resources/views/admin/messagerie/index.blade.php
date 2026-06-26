@extends('layouts.admin')

@section('title', 'Messagerie')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        .gm-card { background: #fff; border: 1px solid #eff3f6; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); min-height: 78vh; display: flex; flex-direction: column; }

        /* Barre d'outils (façon Gmail) */
        .gm-toolbar {
            display: flex; align-items: center; gap: 16px;
            padding: 14px 20px; border-bottom: 1px solid #eff3f6; background: #fff;
        }
        .gm-title { display: flex; align-items: center; gap: 10px; font-size: 1rem; font-weight: 700; color: #202124; }
        .gm-title i { color: #ea4335; }
        .gm-compose {
            display: inline-flex; align-items: center; gap: 10px;
            background: #c2e7ff; color: #001d35; border: none;
            padding: 12px 22px 12px 18px; border-radius: 999px;
            font-size: 0.85rem; font-weight: 600; cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12); transition: box-shadow 0.2s, background 0.2s;
        }
        .gm-compose:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.18); background: #b3dffc; }

        /* Onglets Réception / Envoyés */
        .gm-tabbtn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: 999px;
            font-size: 0.8rem; font-weight: 600; text-decoration: none;
            color: #5f6368; background: #f1f3f4; border: 1px solid transparent; transition: all 0.2s;
        }
        .gm-tabbtn:hover { background: #e8eaed; color: #202124; }
        .gm-tabbtn.active { background: #e8f0fe; color: #1a73e8; border-color: #d2e3fc; }

        /* Navigation verticale (façon Gmail) */
        .gm-navitem {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px; border-radius: 0 999px 999px 0; margin-left: -16px;
            font-size: 0.88rem; font-weight: 600; text-decoration: none; color: #5f6368; transition: all 0.15s;
        }
        .gm-navitem i { width: 18px; text-align: center; }
        .gm-navitem:hover { background: #f1f3f4; color: #202124; }
        .gm-navitem.active { background: #fce8e6; color: #d93025; }

        /* Liste façon Gmail */
        .gm-list { list-style: none; margin: 0; padding: 0; }
        .gm-row {
            display: flex; align-items: center; gap: 14px;
            padding: 12px 20px; border-bottom: 1px solid #f1f3f4;
            text-decoration: none; color: inherit; cursor: pointer;
            transition: box-shadow 0.15s, background 0.15s; background: #fff;
        }
        .gm-row:hover { box-shadow: inset 1px 0 0 #dadce0, inset -1px 0 0 #dadce0, 0 1px 2px rgba(60,64,67,.2); z-index: 1; }
        .gm-row.unread { background: #fff; }
        .gm-row.read { background: #fff; }
        .gm-list { flex: 1; }

        .gm-avatar {
            width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 0.95rem; text-transform: uppercase;
        }
        .gm-mid { flex: 1; min-width: 0; }
        .gm-name { font-size: 0.88rem; color: #202124; }
        .gm-row.unread .gm-name { font-weight: 700; }
        .gm-snippet { font-size: 0.82rem; color: #5f6368; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .gm-row.unread .gm-snippet { color: #202124; font-weight: 600; }
        .gm-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0; }
        .gm-del { background: none; border: none; color: #c5221f; cursor: pointer; font-size: 0.85rem; padding: 4px; opacity: 0; transition: opacity 0.15s; }
        .gm-row:hover .gm-del { opacity: 0.75; }
        .gm-del:hover { opacity: 1; }
        .gm-date { font-size: 0.72rem; color: #5f6368; white-space: nowrap; }
        .gm-row.unread .gm-date { color: #202124; font-weight: 700; }
        .gm-tag { font-size: 0.62rem; font-weight: 700; padding: 1px 7px; border-radius: 99px; text-transform: uppercase; }
        .gm-tag-vendeur { color: #1e40af; background: #e8f0fe; }
        .gm-tag-client { color: #475569; background: #f1f3f4; }
        .gm-unread-dot { width: 8px; height: 8px; border-radius: 50%; background: #1a73e8; flex-shrink: 0; }

        .gm-empty { padding: 60px 20px; text-align: center; color: #80868b; }
        .gm-empty i { font-size: 3rem; color: #dadce0; display: block; margin-bottom: 14px; }

        /* Pop-up de composition (façon Gmail, en bas à droite) */
        .gm-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.15); display: none; z-index: 9998; }
        .gm-overlay.open { display: block; }
        .gm-compose-box {
            position: fixed; bottom: 0; right: 24px; width: 500px; max-width: calc(100vw - 24px);
            background: #fff; border-radius: 14px 14px 0 0; box-shadow: 0 12px 40px rgba(0,0,0,0.30);
            z-index: 9999; display: none; flex-direction: column; overflow: hidden;
        }
        .gm-compose-box.open { display: flex; animation: gmRise 0.25s ease; }
        @keyframes gmRise { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .gm-compose-head {
            background: linear-gradient(180deg, #ff9900 0%, #e77600 100%);
            color: #fff; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center;
            font-size: 0.92rem; font-weight: 700; letter-spacing: 0.01em;
        }
        .gm-compose-head .gm-head-title { display: flex; align-items: center; gap: 9px; }
        .gm-compose-close { background: rgba(255,255,255,0.2); border: none; color: #fff; cursor: pointer; font-size: 1rem; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
        .gm-compose-close:hover { background: rgba(255,255,255,0.35); }

        .gm-compose-body { padding: 18px; }
        .gm-flabel { display: block; font-size: 0.68rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 6px; }
        .gm-field {
            width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 11px 12px;
            font-size: 0.85rem; outline: none; color: #202124; background: #fafbfc; margin-bottom: 16px; transition: all 0.18s;
        }
        .gm-field:focus { border-color: #ff9900; background: #fff; box-shadow: 0 0 0 3px rgba(255,153,0,0.15); }
        .gm-textarea {
            width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; padding: 12px;
            font-size: 0.9rem; min-height: 170px; resize: vertical; color: #202124; background: #fafbfc; transition: all 0.18s;
        }
        .gm-textarea:focus { border-color: #ff9900; background: #fff; box-shadow: 0 0 0 3px rgba(255,153,0,0.15); }
        .gm-compose-foot { padding: 0 18px 18px; display: flex; align-items: center; gap: 12px; }
        .gm-send {
            background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); color: #fff; border: none; border-radius: 999px;
            padding: 11px 30px; font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: all 0.2s;
            box-shadow: 0 2px 6px rgba(231,118,0,0.35);
        }
        .gm-send:hover { background: linear-gradient(180deg, #f08804 0%, #d87300 100%); box-shadow: 0 3px 10px rgba(231,118,0,0.45); }

        .alert-ok { background: #e6f4ea; border: 1px solid #a8d5b1; color: #137333; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.85rem; }
        .alert-err { background: #fce8e6; border: 1px solid #f5c6c2; color: #c5221f; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.85rem; }
    </style>
@endpush

@section('content')
@php
    $palette = ['#1a73e8','#ea4335','#fbbc04','#34a853','#a142f4','#f5511e','#00897b','#d81b60'];
@endphp
<div style="max-width: 1600px; margin: -30px auto 0; width: 100%;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; min-height: 78vh; display: flex; flex-direction: column;">

        @if(session('success'))
            <div class="alert-ok">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-err">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-err">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        @php $isSent = ($folder ?? 'inbox') === 'sent'; @endphp

        {{-- Corps : navigation verticale (gauche) + liste (droite), façon Gmail --}}
        <div style="display: flex; gap: 0; flex: 1; align-items: stretch;">

            {{-- Navigation gauche --}}
            <div style="width: 220px; flex-shrink: 0; border-right: 1px solid #eff3f6; padding-right: 16px;">
                <button type="button" class="gm-compose" style="width: 100%; justify-content: center; margin-bottom: 18px;" onclick="openCompose()">
                    <i class="fas fa-pen"></i> Nouveau message
                </button>
                <nav style="display: flex; flex-direction: column; gap: 6px;">
                    <a href="{{ route('admin.messagerie.index', ['folder' => 'inbox']) }}" class="gm-navitem {{ !$isSent ? 'active' : '' }}">
                        <i class="fas fa-inbox"></i> Réception
                    </a>
                    <a href="{{ route('admin.messagerie.index', ['folder' => 'sent']) }}" class="gm-navitem {{ $isSent ? 'active' : '' }}">
                        <i class="fas fa-paper-plane"></i> Envoyés
                    </a>
                </nav>
            </div>

            {{-- Liste des conversations --}}
            <div style="flex: 1; min-width: 0; padding-left: 16px;">
        <ul class="gm-list">
            @forelse($conversations as $conv)
                @php
                    $other = $conv->user1_id == $adminId ? $conv->user2 : $conv->user1;
                    $last = $conv->messages->first();
                    $isUnread = $last && $last->sender_id != $adminId && is_null($last->read_at);
                    $name = trim(($other->prenom ?? '') . ' ' . ($other->nom ?? '')) ?: ($other->email ?? 'Utilisateur');
                    $initial = mb_substr($other->prenom ?? ($other->nom ?? ($other->email ?? 'U')), 0, 1);
                    $color = $palette[($other->id ?? 0) % count($palette)];
                    $isVendeur = $other && $other->vendeur;
                @endphp
                <li class="gm-row {{ $isUnread ? 'unread' : 'read' }}">
                    <a href="{{ route('admin.messagerie.show', $conv) }}" style="display:flex; align-items:center; gap:14px; flex:1; min-width:0; text-decoration:none; color:inherit;">
                        @if($isUnread)<span class="gm-unread-dot"></span>@else<span style="width:8px;flex-shrink:0;"></span>@endif
                        <div class="gm-avatar" style="background: {{ $color }};">{{ $initial }}</div>
                        <div class="gm-mid">
                            <div class="gm-name">{{ $name }}
                                <span class="gm-tag {{ $isVendeur ? 'gm-tag-vendeur' : 'gm-tag-client' }}">{{ $isVendeur ? 'Vendeur' : 'Client' }}</span>
                            </div>
                            <div class="gm-snippet">{{ $last ? \Illuminate\Support\Str::limit(strip_tags($last->content), 90) : 'Aucun message' }}</div>
                        </div>
                    </a>
                    <div class="gm-meta">
                        <span class="gm-date">{{ $conv->last_message_at ? $conv->last_message_at->translatedFormat('d M') : '' }}</span>
                        <form id="del-conv-{{ $conv->id }}" action="{{ route('admin.messagerie.destroy', $conv) }}" method="POST" style="display:none;">
                            @csrf @method('DELETE')
                            <input type="hidden" name="folder" value="{{ $folder ?? 'inbox' }}">
                        </form>
                        <button type="button" class="gm-del" title="Supprimer" onclick="confirmDeleteConv({{ $conv->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
            @empty
                <li class="gm-empty">
                    <i class="fas fa-inbox"></i>
                    Aucune conversation. Cliquez sur « Nouveau message » pour écrire à un vendeur ou un client.
                </li>
            @endforelse
        </ul>

        @if($conversations->hasPages())
            <div style="padding: 14px 20px;">{{ $conversations->links('vendor.pagination.karnou') }}</div>
        @endif
            </div>{{-- /colonne droite --}}
        </div>{{-- /corps --}}
    </div>
</div>

{{-- Pop-up de composition --}}
<div class="gm-overlay" id="gm-overlay" onclick="closeCompose()"></div>
<div class="gm-compose-box" id="gm-compose-box">
    <div class="gm-compose-head">
        <span class="gm-head-title"><i class="fas fa-pen"></i> Nouveau message</span>
        <button type="button" class="gm-compose-close" onclick="closeCompose()">&times;</button>
    </div>
    <form action="{{ route('admin.messagerie.send') }}" method="POST" id="send-form" onsubmit="return confirmSend()">
        @csrf
        <div class="gm-compose-body">
            <label class="gm-flabel">Destinataire(s)</label>
            <select name="mode" id="mode" class="gm-field" onchange="toggleRecipient()">
                <option value="user">À : un utilisateur précis</option>
                <option value="vendeurs">À : tous les vendeurs</option>
                <option value="clients">À : tous les clients</option>
            </select>

            <div id="recipient-wrap">
                <label class="gm-flabel">Choisir le destinataire</label>
                <select name="recipient_id" id="recipient_id" class="gm-field">
                    <option value="">— Sélectionner —</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->prenom }} {{ $u->nom }} — {{ $u->email ?? $u->telephone }} {{ $u->vendeur ? '(Vendeur)' : '(Client)' }}</option>
                    @endforeach
                </select>
            </div>

            <label class="gm-flabel">Message</label>

            <textarea name="message" id="message" class="gm-textarea" placeholder="Rédigez votre message…" required>{{ old('message') }}</textarea>
        </div>
        <div class="gm-compose-foot">
            <button type="submit" class="gm-send"><i class="fas fa-paper-plane"></i> Envoyer</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function openCompose() {
        document.getElementById('gm-compose-box').classList.add('open');
        document.getElementById('gm-overlay').classList.add('open');
        toggleRecipient();
    }
    function closeCompose() {
        document.getElementById('gm-compose-box').classList.remove('open');
        document.getElementById('gm-overlay').classList.remove('open');
    }
    function toggleRecipient() {
        var mode = document.getElementById('mode').value;
        var wrap = document.getElementById('recipient-wrap');
        var sel = document.getElementById('recipient_id');
        if (mode === 'user') { wrap.style.display = 'block'; sel.setAttribute('required','required'); }
        else { wrap.style.display = 'none'; sel.removeAttribute('required'); }
    }
    function confirmDeleteConv(id) {
        Swal.fire({
            title: 'Supprimer cette discussion ?',
            text: "Tous les messages de cette conversation seront définitivement supprimés.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e67e00',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('del-conv-' + id).submit();
            }
        });
    }

    function confirmSend() {
        var mode = document.getElementById('mode').value;
        if (mode === 'user') return true;
        var cible = mode === 'vendeurs' ? 'TOUS les vendeurs' : 'TOUS les clients';
        return window.confirm('Confirmer l\'envoi de ce message à ' + cible + ' ?');
    }
    // Fait disparaître automatiquement les messages de notification
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert-ok, .alert-err').forEach(function (el) {
            setTimeout(function () {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 500);
            }, 3500);
        });
    });

    // Ouvre automatiquement la fenêtre si des erreurs de validation existent
    @if($errors->any() || old('message'))
        document.addEventListener('DOMContentLoaded', openCompose);
    @endif
</script>
@endpush
@endsection
