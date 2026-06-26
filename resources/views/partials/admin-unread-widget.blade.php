{{-- Pop-up d'alerte messages non lus pour l'admin (compte Karnou) --}}
@unless(request()->routeIs('admin.messagerie.*'))
    @php
        $karnou = \App\Models\User::where('email', 'admin@karnou.com')->first()
            ?? \App\Models\User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->first();

        $awCount = 0;
        $awLatest = null;
        if ($karnou) {
            $base = \App\Models\Message::whereNull('read_at')
                ->where('sender_id', '!=', $karnou->id)
                ->whereHas('conversation', function ($q) use ($karnou) {
                    $q->where('user1_id', $karnou->id)->orWhere('user2_id', $karnou->id);
                });
            $awCount = (clone $base)->count();
            if ($awCount > 0) {
                $awLatest = (clone $base)->with('sender')->latest()->first();
            }
        }
    @endphp

    @if($awCount > 0 && $awLatest)
        @php
            $s = $awLatest->sender;
            $awName = $s ? (trim(($s->prenom ?? '') . ' ' . ($s->nom ?? '')) ?: ($s->email ?? 'Un utilisateur')) : 'Un utilisateur';
            $awUrl = route('admin.messagerie.show', $awLatest->conversation_id);
            $awSnippet = \Illuminate\Support\Str::limit(strip_tags($awLatest->content ?? ''), 70) ?: 'Nouveau message.';
        @endphp

        <style>
            #aw-widget { position: fixed; bottom: 20px; right: 20px; z-index: 100000; width: 330px; max-width: calc(100vw - 40px); background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 12px 40px rgba(0,0,0,0.18); overflow: hidden; transform: translateY(140%); opacity: 0; transition: transform 0.35s cubic-bezier(0.22,1,0.36,1), opacity 0.35s ease; }
            #aw-widget.show { transform: translateY(0); opacity: 1; }
            #aw-widget .aw-head { display: flex; align-items: center; gap: 10px; padding: 12px 14px; background: #fff; color: #1e293b; border-bottom: 1px solid #eef0f2; }
            #aw-widget .aw-icon { width: 36px; height: 36px; border-radius: 50%; background: #fff4e5; color: #f68b1e; display: flex; align-items: center; justify-content: center; flex-shrink: 0; position: relative; }
            #aw-widget .aw-badge { position: absolute; top: -5px; right: -5px; min-width: 18px; height: 18px; padding: 0 4px; background: #ef4444; color: #fff; font-size: 0.65rem; font-weight: 800; border-radius: 999px; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; }
            #aw-widget .aw-title { font-weight: 700; font-size: 0.9rem; flex: 1; color: #1e293b; }
            #aw-widget .aw-close { cursor: pointer; color: #94a3b8; background: none; border: none; font-size: 1.1rem; }
            #aw-widget .aw-body { padding: 14px; display: block; text-decoration: none; color: inherit; }
            #aw-widget .aw-sender { font-weight: 700; font-size: 0.85rem; color: #1e293b; margin-bottom: 3px; }
            #aw-widget .aw-snippet { font-size: 0.82rem; color: #64748b; line-height: 1.4; }
            #aw-widget .aw-cta { display: block; margin: 0 14px 14px; text-align: center; background: #f68b1e; color: #fff; font-weight: 700; font-size: 0.85rem; padding: 9px; border-radius: 8px; text-decoration: none; }
        </style>

        <div id="aw-widget">
            <div class="aw-head">
                <div class="aw-icon"><i class="fas fa-comment-dots"></i><span class="aw-badge">{{ $awCount > 9 ? '9+' : $awCount }}</span></div>
                <div class="aw-title">{{ $awCount > 1 ? $awCount . ' nouveaux messages' : 'Nouveau message' }}</div>
                <button type="button" class="aw-close" onclick="document.getElementById('aw-widget').classList.remove('show')">&times;</button>
            </div>
            <a href="{{ $awUrl }}" class="aw-body">
                <div class="aw-sender">{{ $awName }}</div>
                <div class="aw-snippet">{{ $awSnippet }}</div>
            </a>
            <a href="{{ $awUrl }}" class="aw-cta">Voir le message</a>
        </div>

        <script>
            (function () {
                var w = document.getElementById('aw-widget');
                if (w) setTimeout(function () { w.classList.add('show'); }, 700);
            })();
        </script>
    @endif
@endunless
