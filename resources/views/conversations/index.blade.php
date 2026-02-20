@extends('layouts.app')

@section('title', 'Messagerie - Mady Market')

@push('styles')
<style>
    .inbox-wrapper {
        max-width: 1000px;
        margin: 3rem auto;
        padding: 0 1.5rem;
    }
    .inbox-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .inbox-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: #000;
        margin: 0;
    }
    .inbox-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid #eee;
        overflow: hidden;
    }
    .conv-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f5f5f5;
        transition: all 0.2s;
    }
    .conv-item:last-child { border-bottom: none; }
    .conv-item:hover {
        background: #fafafa;
    }
    .conv-item.unread {
        background: #fff9f9;
        border-left: 4px solid #bf0000;
    }

    .conv-main {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        flex: 1;
        min-width: 0;
    }
    .conv-avatar-wrapper {
        position: relative;
        flex-shrink: 0;
    }
    .conv-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        background: #f0f0f0;
    }
    .unread-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        background: #bf0000;
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 6px;
        border-radius: 10px;
        border: 2px solid #fff;
    }

    .conv-content {
        min-width: 0;
        flex: 1;
    }
    .conv-name {
        font-weight: 700;
        color: #000;
        font-size: 1rem;
        margin-bottom: 0.15rem;
    }
    .conv-annonce {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        color: #bf0000;
        font-weight: 600;
        margin-bottom: 0.3rem;
    }
    .conv-snippet {
        font-size: 0.85rem;
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .unread .conv-snippet {
        color: #000;
        font-weight: 600;
    }

    .conv-meta {
        text-align: right;
        flex-shrink: 0;
        margin-left: 1.5rem;
    }
    .conv-time {
        font-size: 0.75rem;
        color: #999;
    }
    
    .empty-inbox {
        text-align: center;
        padding: 5rem 2rem;
        background: #fff;
        border-radius: 12px;
        border: 1px solid #eee;
    }
    .empty-icon {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1.5rem;
    }
    .empty-inbox h3 {
        font-size: 1.25rem;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .empty-inbox p { color: #888; }
</style>
@endpush

@section('content')
<div class="inbox-wrapper">
    <div class="inbox-header">
        <h1>Mes Messages</h1>
    </div>

    @if($conversations->count() > 0)
        <div class="inbox-card">
            @foreach($conversations as $conversation)
                @php
                    $otherUser = $conversation->user1_id == Auth::id() ? $conversation->user2 : $conversation->user1;
                    $lastMessage = $conversation->messages()->latest()->first();
                    $unreadCount = $conversation->messages()->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();
                @endphp
                <a href="{{ route('conversations.show', $conversation) }}" class="conv-item {{ $unreadCount > 0 ? 'unread' : '' }}">
                    <div class="conv-main">
                        <div class="conv-avatar-wrapper">
                            <img src="{{ $otherUser->avatar ? Storage::url($otherUser->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name) }}" class="conv-avatar">
                            @if($unreadCount > 0)
                                <span class="unread-badge">{{ $unreadCount }}</span>
                            @endif
                        </div>
                        <div class="conv-content">
                            <div class="conv-name">{{ $otherUser->name }}</div>
                            @if($conversation->annonce)
                                <div class="conv-annonce">
                                    <i class="fas fa-tag"></i>
                                    {{ Str::limit($conversation->annonce->titre, 40) }}
                                </div>
                            @endif
                            <div class="conv-snippet">
                                {{ $lastMessage ? $lastMessage->content : 'Nouvelle conversation' }}
                            </div>
                        </div>
                    </div>
                    <div class="conv-meta">
                        <div class="conv-time">
                            {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : $conversation->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-inbox">
            <div class="empty-icon">
                <i class="far fa-comments"></i>
            </div>
            <h3>Aucune conversation</h3>
            <p>Commencez à discuter avec des vendeurs pour voir vos messages ici.</p>
        </div>
    @endif
</div>
@endsection
