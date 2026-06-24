{{-- Widget global : alerte de messages non lus (toutes les pages) --}}
@auth
@unless(request()->routeIs('conversations.*'))
    @php
        $uid = auth()->id();
        $unreadMsgCount = \App\Models\Message::whereNull('read_at')
            ->where('sender_id', '!=', $uid)
            ->whereHas('conversation', function ($q) use ($uid) {
                $q->where('user1_id', $uid)->orWhere('user2_id', $uid);
            })
            ->count();

        $latestUnread = null;
        if ($unreadMsgCount > 0) {
            $latestUnread = \App\Models\Message::with(['sender', 'conversation'])
                ->whereNull('read_at')
                ->where('sender_id', '!=', $uid)
                ->whereHas('conversation', function ($q) use ($uid) {
                    $q->where('user1_id', $uid)->orWhere('user2_id', $uid);
                })
                ->latest()
                ->first();
        }
    @endphp

    @if($unreadMsgCount > 0 && $latestUnread)
        @php
            $sender = $latestUnread->sender;
            $senderName = $sender ? ($sender->name ?? trim(($sender->prenom ?? '') . ' ' . ($sender->nom ?? ''))) : 'Un utilisateur';
            $senderName = $senderName ?: 'Un utilisateur';
            $convUrl = route('conversations.show', $latestUnread->conversation_id);
            $snippet = \Illuminate\Support\Str::limit(strip_tags($latestUnread->content ?? ''), 70);
            if ($snippet === '') { $snippet = 'Vous avez un nouveau message.'; }
        @endphp

        <style>
            #unread-msg-widget {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 100000;
                width: 320px;
                max-width: calc(100vw - 40px);
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
                overflow: hidden;
                transform: translateY(140%);
                opacity: 0;
                transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.35s ease;
                pointer-events: none;
            }
            #unread-msg-widget.show {
                transform: translateY(0);
                opacity: 1;
                pointer-events: auto;
            }
            #unread-msg-widget .umw-header {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 14px;
                background: #004aad;
                color: #fff;
            }
            #unread-msg-widget .umw-icon {
                width: 36px; height: 36px;
                border-radius: 50%;
                background: rgba(255,255,255,0.2);
                display: flex; align-items: center; justify-content: center;
                font-size: 0.95rem;
                flex-shrink: 0;
                position: relative;
            }
            #unread-msg-widget .umw-badge {
                position: absolute;
                top: -5px; right: -5px;
                min-width: 18px; height: 18px;
                padding: 0 4px;
                background: #ef4444;
                color: #fff;
                font-size: 0.65rem;
                font-weight: 800;
                border-radius: 999px;
                display: flex; align-items: center; justify-content: center;
                border: 2px solid #fff;
            }
            #unread-msg-widget .umw-title { font-weight: 700; font-size: 0.9rem; flex: 1; }
            #unread-msg-widget .umw-close {
                cursor: pointer; color: #fff; opacity: 0.85;
                font-size: 1.1rem; padding: 2px 4px; background: none; border: none;
            }
            #unread-msg-widget .umw-close:hover { opacity: 1; }
            #unread-msg-widget .umw-body { padding: 14px; display: block; text-decoration: none; color: inherit; }
            #unread-msg-widget .umw-sender { font-weight: 700; font-size: 0.85rem; color: #1e293b; margin-bottom: 3px; }
            #unread-msg-widget .umw-snippet { font-size: 0.82rem; color: #64748b; line-height: 1.4; }
            #unread-msg-widget .umw-cta {
                display: block;
                margin: 0 14px 14px;
                text-align: center;
                background: #f68b1e;
                color: #fff;
                font-weight: 700;
                font-size: 0.85rem;
                padding: 9px;
                border-radius: 8px;
                text-decoration: none;
                transition: background 0.2s;
            }
            #unread-msg-widget .umw-cta:hover { background: #e07a0c; }

            @media (max-width: 600px) {
                #unread-msg-widget {
                    left: 12px; right: 12px; bottom: 12px;
                    width: auto; max-width: none;
                }
            }
        </style>

        <div id="unread-msg-widget" data-count="{{ $unreadMsgCount }}">
            <div class="umw-header">
                <div class="umw-icon">
                    <i class="fas fa-comment-dots"></i>
                    <span class="umw-badge">{{ $unreadMsgCount > 9 ? '9+' : $unreadMsgCount }}</span>
                </div>
                <div class="umw-title">{{ $unreadMsgCount > 1 ? $unreadMsgCount . ' nouveaux messages' : 'Nouveau message' }}</div>
                <button type="button" class="umw-close" onclick="dismissUnreadWidget()" aria-label="Fermer">&times;</button>
            </div>
            <a href="{{ $convUrl }}" class="umw-body">
                <div class="umw-sender">{{ $senderName }}</div>
                <div class="umw-snippet">{{ $snippet }}</div>
            </a>
            <a href="{{ $convUrl }}" class="umw-cta">Voir le message</a>
        </div>

        <script>
            (function () {
                var w = document.getElementById('unread-msg-widget');
                if (!w) return;
                var count = w.getAttribute('data-count');
                var dismissed = null;
                try { dismissed = sessionStorage.getItem('unreadMsgDismissed'); } catch (e) {}
                // Réaffiche si le nombre de non-lus a changé depuis la dernière fermeture
                if (dismissed !== count) {
                    setTimeout(function () { w.classList.add('show'); }, 700);
                }
                window.dismissUnreadWidget = function () {
                    w.classList.remove('show');
                    try { sessionStorage.setItem('unreadMsgDismissed', count); } catch (e) {}
                };
            })();
        </script>
    @endif
@endunless
@endauth
