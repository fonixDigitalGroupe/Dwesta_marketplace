@extends('layouts.app')

@section('title', 'Messagerie - Karnou')

@push('styles')
<style>
    /* WhatsApp Layout */
    .main-content {
        overflow: hidden;
        box-shadow: none !important;
    }
    .wa-container {
        display: flex;
        flex-direction: row-reverse;
        height: 70vh;
        max-height: 750px;
        min-height: 500px;
        background: #fff;
        border-radius: 0;
        box-shadow: none;
        border: 1px solid #f0f0f0;
        overflow: hidden;
        margin-top: 0;
    }
    .wa-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #f8f9fa;
        overflow: hidden;
        width: 100%;
        height: 100%;
    }
    .wa-sidebar {
        width: 280px;
        border-left: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        background: #fff;
    }

    @media (max-width: 767px) {
        .wa-sidebar {
            width: 100%;
        }
        .wa-main {
            display: none;
        }
        .wa-container {
            height: calc(100vh - 100px);
            margin-bottom: 1rem;
        }
    }
    .wa-sidebar-header {
        height: 60px;
        padding: 0 1rem;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
        font-weight: 700;
        color: #1a1a1a;
        background: #f8fafc;
        font-size: 0.95rem;
    }
    .wa-list-container {
        flex: 1;
        overflow-y: auto;
    }
    /* Hide scrollbar for a cleaner look like WhatsApp */
    .wa-list-container::-webkit-scrollbar { width: 6px; }
    .wa-list-container::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }

    .conv-list {
        display: flex;
        flex-direction: column;
    }
    .conv-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.1s;
        position: relative;
    }
    .conv-item:hover, .conv-item.active {
        background: #f8fafc;
    }
    .conv-item.active {
        /* le trait vertical bleu a été retiré */
    }
    .conv-item.unread::before {
        content: '';
        /* retiré pour plus de neutralité */
    }

    .conv-main {
        display: flex;
        width: 100%;
        align-items: center;
        gap: 1rem;
    }
    .conv-avatar-wrapper {
        position: relative;
        flex-shrink: 0;
    }
    .conv-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        object-fit: cover;
    }
    .unread-indicator {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 12px;
        height: 12px;
        background: #475569; /* Gris Slate neutre et pro */
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .conv-content {
        min-width: 0;
        flex: 1;
    }
    .conv-top-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }
    .conv-name {
        font-weight: 500;
        color: #333;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .conv-time {
        font-size: 0.75rem;
        color: #999;
    }
    .conv-company {
        font-size: 0.8rem;
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }
    .conv-status {
        display: flex;
        gap: 6px;
        font-size: 0.75rem;
    }
    .status-unread { color: #004aad; font-weight: 500; }
    .status-product { color: #888; }
    .conv-snippet {
        font-size: 0.85rem;
        color: #777;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .unread .conv-snippet {
        color: #333;
        font-weight: 500;
    }

    .wa-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #f1f5f9;
        align-items: center;
        justify-content: center;
    }
    .wa-main-empty {
        text-align: center;
        color: #64748b;
    }
    .wa-main-empty img {
        width: 250px;
        margin-bottom: 2rem;
        opacity: 0.7;
    }
    .wa-main-empty h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .wa-main-empty p {
        font-size: 0.9rem;
        max-width: 400px;
        margin: 0 auto;
    }
    .account-header h1 {
        text-align: left;
    }
</style>
@endpush
@section('content')
<div class="dashboard-container">
    @include('partials.profile-sidebar')
    
    <div class="main-content">
        <div class="account-header" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Messagerie</h1>
        </div>
        
        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">


            <div style="background: #ffffff; padding: 20px;">
                @forelse($conversations as $conv)
                    @php
                        $otherUser = $conv->user1_id == Auth::id() ? $conv->user2 : $conv->user1;
                        $lastMsg = $conv->messages()->latest()->first();
                        $isSystem = ($otherUser->hasRole('admin'));
                    @endphp
                    <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; padding: 20px; margin-bottom: 15px; position: relative; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 500;">
                                {{ $lastMsg ? $lastMsg->created_at->translatedFormat('d M') : $conv->created_at->translatedFormat('d M') }}
                            </span>
                            <a href="{{ route('conversations.show', $conv) }}" style="color: #ea580c; font-weight: 600; font-size: 0.9rem; text-decoration: none;">Détails</a>
                        </div>

                        <h2 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 5px 0 10px;">
                            @if($isSystem)
                                Notification de l'administration 💡
                            @else
                                Conversation avec {{ $otherUser->name }}
                            @endif
                        </h2>

                        <div style="font-size: 0.9rem; color: #475569; line-height: 1.6; margin-bottom: 15px;">
                            {{ $lastMsg ? Str::limit(strip_tags($lastMsg->content), 300) : 'Démarrer une discussion...' }}
                        </div>

                        @if($lastMsg && $lastMsg->image_path)
                            <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; padding: 12px; display: flex; gap: 15px; align-items: center; max-width: 500px;">
                                <div style="width: 80px; height: 60px; flex-shrink: 0; background: #f8fafc; border-radius: 4px; overflow: hidden; border: 1px solid #f1f5f9;">
                                    <img src="{{ Storage::url($lastMsg->image_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #1e293b; font-size: 0.9rem;">
                                        @if($lastMsg->annonce)
                                            {{ $lastMsg->annonce->titre }}
                                        @else
                                            Offre Promotionnelle
                                        @endif
                                    </div>
                                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">Voir les détails du message</div>
                                </div>
                            </div>
                        @elseif($conv->annonce)
                             <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; padding: 12px; display: flex; gap: 15px; align-items: center; max-width: 500px;">
                                <div style="width: 80px; height: 60px; flex-shrink: 0; background: #f8fafc; border-radius: 4px; overflow: hidden; border: 1px solid #f1f5f9;">
                                    <img src="{{ $conv->annonce->photoPrincipale()->url ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #1e293b; font-size: 0.9rem;">{{ $conv->annonce->titre }}</div>
                                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">{{ number_format($conv->annonce->prix, 0, ',', ' ') }} FCFA</div>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 4px; padding: 60px; text-align: center; color: #94a3b8;">
                        <i class="far fa-comment-alt" style="font-size: 3rem; margin-bottom: 20px;"></i>
                        <h3 style="font-size: 1.1rem; color: #64748b;">Aucun message pour le moment</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
