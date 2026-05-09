<div class="wa-sidebar">
    <div class="wa-sidebar-header" style="height: 50px; background: #fff; padding: 0 15px; border-bottom: 1px solid #f0f0f0;">
        <h1 style="font-size: 1rem; font-weight: 700; color: #333; margin: 0;">Toutes</h1>

    </div>
    <div class="wa-list-container">
        @if($conversations->count() > 0)
            <div class="conv-list">
                @foreach($conversations as $conv)
                    @php
                        $otherUser = $conv->user1_id == Auth::id() ? $conv->user2 : $conv->user1;
                        $lastMessage = $conv->messages()->latest()->first();
                        $unreadCount = $conv->messages()->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();
                        
                        $isOtherPro = $otherUser->vendeur && $otherUser->vendeur->estProfessionnel();
                        $shopLogo = ($isOtherPro && $otherUser->vendeur->pagePro) ? $otherUser->vendeur->pagePro->logo : null;
                        $companyName = ($isOtherPro && $otherUser->vendeur->pagePro) ? $otherUser->vendeur->pagePro->nom_boutique : 'Particulier';
                        
                        // Active state
                        $isActive = isset($conversation) && $conversation->id === $conv->id;
                    @endphp
                    <a href="{{ route('conversations.show', $conv) }}" class="conv-item {{ $isActive ? 'active' : '' }}">
                        <div class="conv-main">
                            <div class="conv-avatar-wrapper">
                                @if($isOtherPro)
                                    @if($shopLogo)
                                        <img src="{{ Storage::url($shopLogo) }}" class="conv-avatar">
                                    @else
                                        <div class="conv-avatar" style="display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #94a3b8; border: 1px solid #e5e7eb;">
                                            <i class="fas fa-store" style="font-size: 1.1rem;"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="conv-avatar" style="display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: #475569; border: 1px solid #e5e7eb; font-weight: 600; font-size: 1.1rem;">
                                        {{ substr($otherUser->name, 0, 1) }}
                                    </div>
                                @endif
                                
                                @if($unreadCount > 0)
                                    <span class="unread-indicator"></span>
                                @endif
                            </div>
                            <div class="conv-content">
                                <div class="conv-top-line">
                                    <div class="conv-name">{{ $otherUser->name }}</div>
                                    <div class="conv-time">
                                        {{ $lastMessage ? $lastMessage->created_at->format('H:i') : $conv->created_at->format('H:i') }}
                                    </div>
                                </div>
                                <div class="conv-company">{{ $companyName }}</div>
                                <div class="conv-status" style="display: flex; justify-content: space-between; align-items: center;">
                                    @if($unreadCount > 0)
                                        <span class="status-unread">[Non lu]</span>
                                    @else
                                        <span></span>
                                    @endif
                                    
                                    {{-- Delete Conversation Button --}}
                                    <div class="conv-delete-action" style="opacity: 0; transition: opacity 0.2s;" onclick="event.preventDefault(); openDeleteConvModal({{ $conv->id }}, '{{ addslashes($otherUser->name) }}')">
                                        <i class="far fa-trash-alt" style="color: #94a3b8; font-size: 0.9rem;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94a3b8'"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-inbox" style="padding: 2rem 1rem;">
                <p style="font-size: 0.9rem; color: #94a3b8; text-align: center;">Aucun message</p>
            </div>
        @endif
    </div>
</div>
