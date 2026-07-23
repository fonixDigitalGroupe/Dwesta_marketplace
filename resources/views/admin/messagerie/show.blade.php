@extends('layouts.admin')

@section('title', 'Conversation')

@push('styles')
    <style>
        .main-content { background-color: #fff !important; }

        .gm-card { background: #fff; border: 1px solid #eff3f6; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.04); min-height: 78vh; display: flex; flex-direction: column; }

        .gm-head { display: flex; align-items: center; gap: 14px; padding: 14px 20px; border-bottom: 1px solid #eff3f6; }
        .gm-back { color: #5f6368; font-size: 1.1rem; text-decoration: none; }
        .gm-back:hover { color: #202124; }
        .gm-avatar { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; text-transform: uppercase; flex-shrink: 0; }
        .gm-name { font-size: 0.95rem; font-weight: 700; color: #202124; }
        .gm-sub { font-size: 0.78rem; color: #5f6368; }
        .gm-tag { font-size: 0.62rem; font-weight: 700; padding: 1px 7px; border-radius: 99px; text-transform: uppercase; margin-left: 6px; }
        .gm-tag-vendeur { color: #1e40af; background: #e8f0fe; }
        .gm-tag-client { color: #475569; background: #f1f3f4; }

        .gm-thread { flex: 1; padding: 24px 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px; }
        .gm-msg { max-width: 70%; padding: 12px 16px; border-radius: 14px; font-size: 0.88rem; line-height: 1.5; word-wrap: break-word; }
        .gm-msg .gm-msg-meta { font-size: 0.68rem; margin-top: 6px; opacity: 0.7; }
        .gm-msg.mine { align-self: flex-end; background: #1a73e8; color: #fff; border-bottom-right-radius: 3px; }
        .gm-msg.theirs { align-self: flex-start; background: #f1f3f4; color: #202124; border-bottom-left-radius: 3px; }

        .gm-reply { border-top: 1px solid #eff3f6; padding: 14px 20px; }
        .gm-reply textarea { width: 100%; border: 1px solid #dee2e6; border-radius: 10px; padding: 12px 14px; font-size: 0.9rem; outline: none; resize: vertical; min-height: 70px; }
        .gm-reply textarea:focus { border-color: #1a73e8; box-shadow: 0 0 0 3px rgba(26,115,232,0.12); }
        .gm-send { margin-top: 10px; background: #1a73e8; color: #fff; border: none; border-radius: 999px; padding: 10px 26px; font-size: 0.85rem; font-weight: 700; cursor: pointer; }
        .gm-send:hover { background: #1765cc; }

        .alert-ok { background: #e6f4ea; border: 1px solid #a8d5b1; color: #137333; padding: 10px 16px; border-radius: 8px; margin-bottom: 14px; font-size: 0.85rem; }
        .alert-err { background: #fce8e6; border: 1px solid #f5c6c2; color: #c5221f; padding: 10px 16px; border-radius: 8px; margin-bottom: 14px; font-size: 0.85rem; }
    </style>
@endpush

@section('content')
@php
    $palette = ['#1a73e8','#ea4335','#fbbc04','#34a853','#a142f4','#f5511e','#00897b','#d81b60'];
    $name = trim(($other->prenom ?? '') . ' ' . ($other->nom ?? '')) ?: ($other->email ?? 'Utilisateur');
    $initial = mb_substr($other->prenom ?? ($other->nom ?? ($other->email ?? 'U')), 0, 1);
    $color = $palette[($other->id ?? 0) % count($palette)];
    $isVendeur = $other && $other->vendeur;
@endphp
<div style="max-width: 1100px; margin: 0 auto; width: 100%;">
    <div class="gm-card">

        {{-- En-tête de la conversation --}}
        <div class="gm-head">
            <a href="{{ route('admin.messagerie.index') }}" class="gm-back" title="Retour"><i class="fas fa-arrow-left"></i></a>
            <div class="gm-avatar" style="background: {{ $color }};">{{ $initial }}</div>
            <div>
                <div class="gm-name">{{ $name }}
                    <span class="gm-tag {{ $isVendeur ? 'gm-tag-vendeur' : 'gm-tag-client' }}">{{ $isVendeur ? 'Vendeur' : 'Client' }}</span>
                </div>
                <div class="gm-sub">{{ $other->email ?? '' }}{{ $other->telephone ? ' · ' . $other->telephone : '' }}</div>
            </div>
            <div style="margin-left: auto; display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('admin.messagerie.index', ['compose' => 1]) }}"
                   style="display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); color: #fff; border-radius: 999px; padding: 8px 16px; font-size: 0.8rem; font-weight: 700; text-decoration: none;">
                    <i class="fas fa-pen"></i> Nouveau message
                </a>
                <form id="del-conv" action="{{ route('admin.messagerie.destroy', $conversation) }}" method="POST" style="margin: 0;">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDeleteConv()" title="Supprimer la discussion"
                            style="background: none; border: 1px solid #f5c6c2; color: #c5221f; border-radius: 999px; padding: 8px 14px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div style="padding: 14px 20px 0;"><div class="alert-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div></div>
        @endif
        @if($errors->any())
            <div style="padding: 14px 20px 0;"><div class="alert-err">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div></div>
        @endif

        {{-- Fil de discussion --}}
        <div class="gm-thread" id="gm-thread">
            @forelse($messages as $msg)
                @php $mine = $msg->sender_id == $adminId; @endphp
                <div class="gm-msg {{ $mine ? 'mine' : 'theirs' }}">
                    @if($msg->annonce)
                        <a href="{{ route('annonces.show', $msg->annonce) }}" target="_blank" style="display:flex; gap:10px; align-items:center; text-decoration:none; background:#ffffff; border:1px solid #e2e8f0; border-radius:10px; padding:8px; margin-bottom:8px; max-width:280px;">
                            <div style="width:52px; height:52px; border-radius:8px; overflow:hidden; background:#f0f0f0; flex-shrink:0; display:flex; align-items:center; justify-content:center;">
                                @if($msg->annonce->photoPrincipale())
                                    <img src="{{ $msg->annonce->photoPrincipale()->url }}" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <i class="fas fa-image" style="color:#cbd5e1;"></i>
                                @endif
                            </div>
                            <div style="min-width:0;">
                                <div style="font-weight:700; font-size:0.82rem; color:#111; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $msg->annonce->titre }}</div>
                                <div style="font-size:0.75rem; color:#64748b; margin-top:2px;">Réf #{{ $msg->annonce->id }} · {{ number_format($msg->annonce->prix, 0, ',', ' ') }} FCFA</div>
                            </div>
                        </a>
                    @endif
                    {!! nl2br(e($msg->content)) !!}
                    <div class="gm-msg-meta">{{ $mine ? 'Karnou' : $name }} · {{ $msg->created_at->translatedFormat('d M Y H:i') }}</div>
                </div>
            @empty
                <div style="text-align: center; color: #80868b; margin: auto;">Aucun message dans cette conversation.</div>
            @endforelse
        </div>

        {{-- Zone de réponse --}}
        <div class="gm-reply">
            <form action="{{ route('admin.messagerie.reply', $conversation) }}" method="POST">
                @csrf
                <textarea name="message" placeholder="Répondre à {{ $name }}…" required>{{ old('message') }}</textarea>
                <button type="submit" class="gm-send"><i class="fas fa-paper-plane"></i> Envoyer</button>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Défile en bas du fil de discussion au chargement
    document.addEventListener('DOMContentLoaded', function () {
        var t = document.getElementById('gm-thread');
        if (t) t.scrollTop = t.scrollHeight;
    });

    // Disparition automatique des notifications
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert-ok, .alert-err').forEach(function (el) {
            setTimeout(function () {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 500);
            }, 3500);
        });
    });

    function confirmDeleteConv() {
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
                document.getElementById('del-conv').submit();
            }
        });
    }
</script>
@endpush
@endsection
