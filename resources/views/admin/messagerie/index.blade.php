@extends('layouts.admin')

@section('title', 'Messagerie')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .amazon-card { background: #fff; border: 1px solid #eff3f6; border-radius: 8px; padding: 24px; }
        .section-title { font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: 0.06em; }
        .field-label { display: block; font-size: 0.72rem; font-weight: 600; color: #94a3b8; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.06em; }

        input, select, textarea { width: 100%; padding: 10px 14px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.85rem; outline: none; background: #fff; color: #475569; transition: all 0.2s; }
        input:focus, select:focus, textarea:focus { border-color: #ff9900 !important; box-shadow: 0 0 0 3px rgba(255,153,0,0.15); }

        .btn-orange { background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: 1px solid #c05d00; color: #fff; padding: 10px 16px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; cursor: pointer; width: 100%; transition: all 0.2s; }
        .btn-orange:hover { background: linear-gradient(180deg, #f08804 0%, #d87300 100%); }

        .badge-amazon { font-size: 0.72rem; font-weight: 700; padding: 2px 8px; border-radius: 12px; }
        .badge-vendeur { color: #1e40af; background: #eff6ff; }
        .badge-client { color: #475569; background: #f1f5f9; }

        .alert-ok { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.85rem; }
        .alert-err { background: #fff5f5; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.85rem; }
    </style>
@endpush

@section('content')
<div style="max-width: 1400px; margin: 20px auto 0; width: 100%;">
    <div class="amazon-card">

        {{-- Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                <i class="fas fa-envelope" style="font-size: 0.8rem;"></i>
                <span>Messagerie</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-err"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-err">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start;">

            {{-- Conversations récentes --}}
            <div>
                <h3 class="section-title">Conversations</h3>
                <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #eff3f6;">
                    <thead>
                        <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Destinataire</th>
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Dernier message</th>
                            <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 120px;">Date</th>
                            <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 90px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conversations as $conv)
                            @php
                                $other = $conv->user1_id == $adminId ? $conv->user2 : $conv->user1;
                                $last = $conv->messages->first();
                            @endphp
                            <tr style="border-bottom: 1px solid #eff3f6;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 12px 15px; font-size: 0.82rem; font-weight: 700; color: #111; border-right: 1px solid #eff3f6;">
                                    {{ $other->prenom ?? '' }} {{ $other->nom ?? '' }}
                                    <div style="font-size: 0.72rem; color: #94a3b8; font-weight: normal;">{{ $other->email ?? $other->telephone ?? '' }}</div>
                                </td>
                                <td style="padding: 12px 15px; font-size: 0.8rem; color: #555; border-right: 1px solid #eff3f6;">
                                    {{ $last ? \Illuminate\Support\Str::limit(strip_tags($last->content), 70) : '—' }}
                                </td>
                                <td style="padding: 12px 15px; font-size: 0.75rem; color: #64748b; text-align: center; border-right: 1px solid #eff3f6;">
                                    {{ $conv->last_message_at ? $conv->last_message_at->format('d/m/Y H:i') : '' }}
                                </td>
                                <td style="padding: 12px 15px; text-align: right;">
                                    <a href="{{ route('conversations.show', $conv) }}" style="color: #0066c0; font-size: 0.8rem; text-decoration: none; font-weight: 600;">Ouvrir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                    Aucune conversation pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>

                @if($conversations->hasPages())
                    <div style="margin-top: 16px;">{{ $conversations->links('vendor.pagination.karnou') }}</div>
                @endif
            </div>

            {{-- Formulaire d'envoi --}}
            <div>
                <h3 class="section-title">Envoyer un message</h3>
                <form action="{{ route('admin.messagerie.send') }}" method="POST" id="send-form" onsubmit="return confirmSend()">
                    @csrf

                    <div style="margin-bottom: 18px;">
                        <label class="field-label">Destinataire(s)</label>
                        <select name="mode" id="mode" onchange="toggleRecipient()">
                            <option value="user">Un utilisateur précis</option>
                            <option value="vendeurs">Tous les vendeurs</option>
                            <option value="clients">Tous les clients</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 18px;" id="recipient-wrap">
                        <label class="field-label">Choisir l'utilisateur</label>
                        <select name="recipient_id" id="recipient_id">
                            <option value="">— Sélectionner —</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">
                                    {{ $u->prenom }} {{ $u->nom }} — {{ $u->email ?? $u->telephone }} {{ $u->vendeur ? '(Vendeur)' : '(Client)' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label class="field-label">Message</label>
                        <textarea name="message" id="message" rows="6" placeholder="Votre message..." required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-orange">
                        <i class="fas fa-paper-plane"></i> ENVOYER
                    </button>
                </form>

                <p style="font-size: 0.72rem; color: #94a3b8; margin-top: 12px; line-height: 1.5;">
                    Le message apparaît dans la boîte de réception du destinataire (notification + popup), envoyé par le compte Karnou.
                </p>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleRecipient() {
        var mode = document.getElementById('mode').value;
        var wrap = document.getElementById('recipient-wrap');
        var sel = document.getElementById('recipient_id');
        if (mode === 'user') {
            wrap.style.display = 'block';
            sel.setAttribute('required', 'required');
        } else {
            wrap.style.display = 'none';
            sel.removeAttribute('required');
        }
    }

    function confirmSend() {
        var mode = document.getElementById('mode').value;
        if (mode === 'user') return true;
        var cible = mode === 'vendeurs' ? 'TOUS les vendeurs' : 'TOUS les clients';
        return window.confirm('Confirmer l\'envoi de ce message à ' + cible + ' ?');
    }

    document.addEventListener('DOMContentLoaded', toggleRecipient);
</script>
@endpush
@endsection
