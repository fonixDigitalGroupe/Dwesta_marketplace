@extends('layouts.app')

@section('title', 'Conversation - Mady Market')

@push('styles')
<style>
    .conv-wrapper {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
        height: calc(100vh - 160px);
        display: flex;
        flex-direction: column;
    }
    .conv-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        border: 1px solid #eee;
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }
    .conv-header {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid #f0f0f0;
        background: #fff;
        z-index: 10;
    }
    .back-link {
        color: #999;
        font-size: 1.2rem;
        transition: color 0.2s;
    }
    .back-link:hover { color: #333; }
    
    .other-user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        background: #f5f5f5;
    }
    .other-user-info h2 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: #000;
    }
    .annonce-link {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        color: #bf0000;
        text-decoration: none;
        font-weight: 600;
    }
    .annonce-link:hover { text-decoration: underline; }

    .messages-area {
        flex: 1;
        overflow-y: auto;
        padding: 2rem;
        background: #fdfdfd;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .message-row {
        display: flex;
        width: 100%;
    }
    .message-row.mine { justify-content: flex-end; }
    .message-row.theirs { justify-content: flex-start; }

    .bubble {
        max-width: 70%;
        padding: 0.8rem 1.2rem;
        border-radius: 18px;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
        box-shadow: 0 2px 5px rgba(0,0,0,0.03);
    }
    .mine .bubble {
        background: #bf0000;
        color: #fff;
        border-bottom-right-radius: 4px;
    }
    .theirs .bubble {
        background: #fff;
        color: #333;
        border: 1px solid #eee;
        border-bottom-left-radius: 4px;
    }
    .bubble-meta {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
        font-size: 10px;
        margin-top: 4px;
        opacity: 0.7;
    }
    .mine .bubble-meta { color: #fff; }
    .theirs .bubble-meta { color: #999; }

    .input-area {
        padding: 1.2rem 1.5rem;
        background: #fff;
        border-top: 1px solid #f0f0f0;
    }
    .input-form {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f5f5f5;
        padding: 0.5rem 0.5rem 0.5rem 1.2rem;
        border-radius: 30px;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .input-form:focus-within {
        background: #fff;
        border-color: #bf0000;
        box-shadow: 0 0 0 3px rgba(191,0,0,0.1);
    }
    .message-input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        font-size: 0.95rem;
        color: #333;
        padding: 0.5rem 0;
        resize: none;
        max-height: 120px;
    }
    .send-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #bf0000;
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .send-btn:hover {
        background: #a00000;
        transform: scale(1.05);
    }
    .send-btn:active { transform: scale(0.95); }
</style>
@endpush

@section('content')
<div class="conv-wrapper">
    @php
        $otherUser = $conversation->user1_id == Auth::id() ? $conversation->user2 : $conversation->user1;
    @endphp

    <div class="conv-card">
        <div class="conv-header">
            <a href="{{ route('conversations.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
            </a>
            <img src="{{ $otherUser->avatar ? Storage::url($otherUser->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name) }}" class="other-user-avatar">
            <div class="other-user-info">
                <h2>{{ $otherUser->name }}</h2>
                @if($conversation->annonce)
                    <a href="{{ route('annonces.show', $conversation->annonce) }}" class="annonce-link">
                        <i class="fas fa-tag"></i>
                        {{ Str::limit($conversation->annonce->titre, 35) }}
                    </a>
                @endif
            </div>
        </div>

        <div class="messages-area" id="messages-container">
            @forelse($conversation->messages as $message)
                <div class="message-row {{ $message->sender_id == Auth::id() ? 'mine' : 'theirs' }}">
                    <div class="bubble">
                        <div class="content">{{ $message->content }}</div>
                        <div class="bubble-meta">
                            {{ $message->created_at->format('H:i') }}
                            @if($message->sender_id == Auth::id())
                                <i class="fas fa-check{{ $message->read_at ? '-double' : '' }}"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #999; margin-top: 4rem;">
                    <i class="far fa-comments fa-3x" style="display: block; margin-bottom: 1rem;"></i>
                    Aucun message dans cette conversation.
                </div>
            @endforelse
        </div>

        <div class="input-area">
            <form action="{{ route('conversations.messages.store', $conversation) }}" method="POST" class="input-form">
                @csrf
                <textarea name="content" class="message-input" placeholder="Écrivez votre message..." required rows="1" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                <button type="submit" class="send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    });
</script>
@endsection
