@extends('layouts.app')

@section('title', 'Conversation - Karnou')

@push('styles')
<style>
    /* Aligner la hauteur du sidebar avec le conteneur principal */
    .sidebar {
        height: auto !important;
    }

    .main-content {
        overflow: hidden;
        box-shadow: none !important;
    }
    .wa-container {
        display: flex;
        flex-direction: row-reverse;
        width: 100%;
        height: 85vh;
        max-height: 900px;
        min-height: 600px;
        background: #fff;
        border-radius: 0;
        box-shadow: none;
        border: none;
        overflow: hidden;
        margin-top: 0;
    }

    /* MINI LAYOUT ADJUSTMENTS */
    @if(request('layout') == 'mini')
    body { background: #fff !important; padding: 0 !important; margin: 0 !important; }
    .header, .footer, .rk-breadcrumb, .breadcrumb, .partials-profile-sidebar, .sidebar, .account-header, .wa-sidebar { display: none !important; }
    .main-content { padding: 0 !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; height: 100vh !important; }
    .dashboard-container { display: block !important; margin: 0 !important; padding: 0 !important; border: none !important; }
    .wa-container { height: 100vh !important; max-height: 100vh !important; border: none !important; }
    .wa-main { width: 100% !important; height: 100vh !important; }
    .messages-viewport { padding: 15px !important; }
    .chat-input-box { padding: 12px 15px !important; }
    @endif
    .wa-sidebar {
        width: 280px;
        border-left: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        background: #fff;
    }
    .wa-sidebar-header {
        height: 60px;
        padding: 0 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f0f0f0;
        background: #fff;
    }
    .wa-sidebar-header h1 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }
    .wa-sidebar-header-icons {
        display: flex;
        gap: 12px;
        color: #666;
        font-size: 1.1rem;
    }
    .wa-sidebar-header-icons i {
        cursor: pointer;
        transition: color 0.2s;
    }
    .wa-sidebar-header-icons i:hover { color: #333; }

    .wa-list-container {
        flex: 1;
        overflow-y: auto;
    }
    .wa-list-container::-webkit-scrollbar { width: 5px; }
    .wa-list-container::-webkit-scrollbar-thumb { background-color: #ddd; border-radius: 10px; }

    .conv-list {
        display: flex;
        flex-direction: column;
    }
    .conv-item {
        display: flex;
        align-items: center;
        padding: 1.25rem 1rem;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.2s;
    }
    .conv-item:hover, .conv-item.active {
        background: #f0f2f5;
    }
    .conv-item.active { background: #f0f2f5; }

    .conv-main {
        display: flex;
        width: 100%;
        align-items: center;
        gap: 0.75rem;
    }
    .conv-avatar-wrapper {
        position: relative;
        flex-shrink: 0;
    }
    .conv-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #eee;
    }
    .unread-indicator {
        position: absolute;
        top: 0;
        left: 0;
        width: 10px;
        height: 10px;
        background: #00c853;
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
        margin-bottom: 2px;
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

    .wa-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #fff;
        min-width: 0;
    }
    .conv-header {
        height: 60px;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f0f0f0;
        background: #fff;
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .header-right {
        display: flex;
        gap: 15px;
        color: #666;
        font-size: 1.1rem;
    }
    .header-right i { cursor: pointer; }

    .other-user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }
    .other-user-info { display: flex; align-items: center; gap: 8px; }
    .other-user-info h2 {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    .local-time {
        font-size: 0.85rem;
        color: #888;
    }

    .messages-viewport {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: #f1f5f9;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .date-separator {
        display: flex;
        justify-content: center;
        margin: 1.5rem 0 1rem;
    }
    .date-separator span {
        background: #f1f5f9;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 4px 14px;
        border-radius: 20px;
        letter-spacing: 0.3px;
    }

    .message-group {
        display: flex;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    .message-group.mine { justify-content: flex-end; }
    .message-group.theirs { justify-content: flex-start; }

    .message-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 85%;
    }
    .mine .message-wrapper { align-items: flex-end; }
    .theirs .message-wrapper { align-items: flex-start; }

    .message-time-top {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-bottom: 6px;
        font-weight: 500;
    }
    .mine .message-time-top { text-align: right; margin-right: 15px; }
    .theirs .message-time-top { text-align: left; margin-left: 15px; }

    .message-bubble {
        padding: 0;
        background: transparent;
    }

    /* Product card within chat */
    .chat-product-card {
        background: transparent;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        width: 210px;
        transition: transform 0.2s;
    }
    .chat-product-card:hover {
        transform: translateY(-2px);
    }
    .chat-product-image {
        width: 100%;
        height: 140px;
        object-fit: contain;
        background: transparent;
    }
    .chat-product-info {
        padding: 1rem;
    }
    .chat-product-title {
        font-size: 0.9rem;
        color: #333;
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .chat-product-price {
        font-size: 1.2rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 2px;
    }
    .chat-product-min {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 4px;
    }

    .chat-action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }
    .chat-action-btn {
        padding: 6px 12px;
        border-radius: 20px;
        border: 1px solid #e0e0e0;
        background: #fff;
        font-size: 0.8rem;
        color: #666;
        text-decoration: none;
        transition: all 0.2s;
    }
    .chat-action-btn:hover {
        background: #f5f5f5;
        border-color: #ccc;
    }

    /* Standard message bubble - FLAT VERSION */
    .text-bubble {
        padding: 5px 0;
        background: transparent;
        border-radius: 0;
        font-size: 0.95rem;
        line-height: 1.5;
        box-shadow: none;
    }
    .mine .text-bubble {
        background: transparent;
        border: none;
        color: #333;
        box-shadow: none;
        text-align: right;
    }
    .theirs .text-bubble {
        background: transparent;
        color: #333;
        border: none;
        box-shadow: none;
        text-align: left;
    }

    /* Delete message action */
    /* Supprimer message - VERSION DISCRÈTE */
    .message-group { position: relative; }
    .delete-msg-btn {
        opacity: 0;
        transition: opacity 0.2s;
        color: #94a3b8;
        cursor: pointer;
        font-size: 0.8rem;
        padding: 0 4px;
        background: transparent;
        border: none;
        order: 2; /* Pour s'afficher après le texte ou avant selon le flex */
    }
    .message-group:hover .delete-msg-btn {
        opacity: 1;
    }
    .delete-msg-btn:hover {
        color: #ef4444;
    }

    .msg-input-bar {
        padding: 1.5rem;
        background: #fff;
        border-top: 1px solid #f0f0f0;
    }
    .toolbar {
        display: flex;
        gap: 18px;
        margin-bottom: 12px;
        color: #666;
        font-size: 1.1rem;
    }
    .toolbar i { cursor: pointer; transition: color 0.2s; }
    .toolbar i:hover { color: #333; }

    .add-media-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
        margin-bottom: 5px;
    }
    .add-media-btn:hover {
        background: #e2e8f0;
        color: #334155;
    }
    .media-menu {
        position: absolute;
        bottom: 100%;
        left: 0;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        display: none;
        flex-direction: column;
        padding: 8px;
        min-width: 150px;
        z-index: 1000;
        margin-bottom: 15px;
    }
    .media-menu.active { display: flex; }
    .media-menu div {
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #1e293b;
        transition: background 0.2s;
        font-size: 0.9rem;
    }
    .media-menu div:hover { background: #f8fafc; }
    .media-menu i { font-size: 1.1rem; width: 20px; text-align: center; }

    .input-container {
        position: relative;
        background: #f1f5f9;
        border-radius: 12px;
        padding: 5px;
        display: flex;
        flex-direction: column;
    }
    .chat-textarea {
        width: 100%;
        background: transparent;
        border: none;
        outline: none;
        font-size: 1rem;
        color: #333;
        resize: none;
        min-height: 40px;
        max-height: 200px;
        padding: 10px 5px;
    }
    .input-main {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        padding: 0 10px;
    }
    .input-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 10px 5px;
        border-top: 1px solid rgba(0,0,0,0.03);
    }
    .resize-handle { color: #cbd5e1; font-size: 0.8rem; cursor: pointer; }
    .send-btn {
        background: #ff6600;
        color: #fff;
        border: none;
        padding: 8px 24px;
        border-radius: 20px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .send-btn:hover { background: #e55c00; transform: scale(1.02); }

    /* Responsive */
    @media (max-width: 991px) {
        .wa-sidebar { width: 280px; }
    }
    @media (max-width: 767px) {
        .wa-sidebar { display: none; }
        .back-btn { display: flex !important; }
    }
    /* Product preview bar in input */
    .product-preview-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 15px;
        background: #fff;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        border-radius: 12px 12px 0 0;
        margin: -5px -5px 5px -5px;
    }
    .prod-prev-left { display: flex; align-items: center; gap: 12px; overflow: hidden; }
    .prod-prev-img { width: 45px; height: 45px; border-radius: 6px; object-fit: cover; border: 1px solid #f1f5f9; }
    .prod-prev-details { overflow: hidden; }
    .prod-prev-title { font-size: 0.9rem; color: #334155; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .prod-prev-meta { font-size: 0.8rem; color: #1e293b; display: flex; align-items: center; gap: 8px; font-weight: 600; }
    .prod-prev-sep { color: #e2e8f0; font-weight: normal; }
    .prod-prev-min { color: #64748b; font-weight: normal; }
    .prod-prev-close { color: #94a3b8; cursor: pointer; font-size: 1.2rem; padding: 5px; transition: color 0.2s; }
    .prod-prev-close:hover { color: #ef4444; }

    /* Modal de suppression */
    .delete-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    .delete-modal-overlay.active {
        display: flex;
    }
    .delete-modal {
        background: #fff;
        padding: 24px;
        border-radius: 3px; /* Coins moins arrondis comme WA Web */
        max-width: 480px;
        width: 100%;
        text-align: left;
        box-shadow: 0 17px 50px 0 rgba(0,0,0,.19), 0 12px 15px 0 rgba(0,0,0,.24);
    }
    .delete-modal h3 { 
        margin-bottom: 20px; 
        color: #54656f; 
        font-size: 1rem; 
        font-weight: 400;
    }
    .delete-modal p { 
        color: #54656f; 
        margin-bottom: 30px; 
        font-size: 0.9rem;
    }
    .delete-modal-actions { 
        display: flex; 
        gap: 8px; 
        justify-content: flex-end;
    }
    .delete-modal-actions button {
        padding: 10px 24px;
        border-radius: 3px;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid #e9edef;
        text-transform: uppercase;
        font-size: 0.85rem;
        background: transparent;
        transition: background 0.2s;
    }
    .btn-cancel-delete { 
        color: #54656f; /* Gris neutre pour Annuler */
        border: none !important;
    }
    .btn-cancel-delete:hover { background: #f8fafc; }
    .btn-confirm-delete { 
        background: #54656f !important; 
        color: #fff !important;
        border: none !important;
    }
    .btn-confirm-delete:hover { background: #45525b !important; }
    .delete-modal-icon { display: none; } /* On enlève l'icône rouge trop agressive */
    .account-header h1 {
        text-align: right;
    }
    .conv-item:hover .conv-delete-action { opacity: 1 !important; }
    .conv-item.active .conv-delete-action { opacity: 0.5; }
    .conv-item.active:hover .conv-delete-action { opacity: 1 !important; }
</style>
@endpush

@section('content')
@if(request('layout') != 'mini')
<nav class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a> &gt; 
    <a href="{{ route('account.index') }}">Mon compte</a> &gt; 
    <a href="{{ route('conversations.index') }}">Mes messages</a>
</nav>
@endif

<div class="dashboard-container">
    @if(request('layout') != 'mini')
        @include('partials.profile-sidebar')
    @endif

    <div class="main-content">
        <div class="account-header" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Messagerie</h1>
        </div>

        @php
            $otherUser = $conversation->user1_id == Auth::id() ? $conversation->user2 : $conversation->user1;
        @endphp
        <div class="wa-container">
            {{-- 1. Sidebar (List) - LEFT SIDERBAR --}}


            {{-- 2. Main (Viewport and Input) - RIGHT SIDE --}}
            <div class="wa-main" style="flex: 1; display: flex; flex-direction: column; background: #fff; overflow: hidden;">
                
                <!-- Alibaba Style Header -->
                <div class="conv-header" style="height: 64px; background: #fff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; padding: 0 24px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        @php
                            $isOtherPro = $otherUser->vendeur && $otherUser->vendeur->estProfessionnel();
                            $shopLogo = ($isOtherPro && $otherUser->vendeur->pagePro) ? $otherUser->vendeur->pagePro->logo : null;
                        @endphp
                        <div style="width: 38px; height: 38px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #475569; font-size: 1.1rem; flex-shrink: 0; overflow: hidden; border: 1px solid #e5e7eb;">
                            @if($isOtherPro)
                                @if($shopLogo)
                                    <img src="{{ Storage::url($shopLogo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-store" style="font-size: 1.1rem; color: #94a3b8;"></i>
                                @endif
                            @else
                                {{ substr($otherUser->name, 0, 1) }}
                            @endif
                        </div>
                        <div style="display: flex; flex-direction: column; justify-content: center;">
                            @php
                                // Par défaut, on simule que l'utilisateur est en ligne s'il a été actif très récemment.
                                // À adapter avec votre logique (ex: Cache::has('user-online-' . $otherUser->id))
                                $isOnline = $otherUser->updated_at && $otherUser->updated_at->diffInMinutes(now()) < 30;
                            @endphp
                            <div style="font-size: 1.05rem; font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 6px; line-height: 1.2;">
                                {{ $otherUser->name }} 
                                @if($isOnline)
                                    <span style="font-size: 10px; color: #10b981;" title="En ligne"><i class="fas fa-circle"></i></span>
                                @else
                                    <span style="font-size: 10px; color: #cbd5e1;" title="Hors ligne"><i class="fas fa-circle"></i></span>
                                @endif
                            </div>
                            <div style="font-size: 0.75rem; color: #64748b; font-weight: 500; margin-top: 2px;">
                                @if($isOnline)
                                    En ligne
                                @else
                                    Vu(e) le {{ $otherUser->updated_at ? $otherUser->updated_at->format('d/m/Y à H:i') : 'récemment' }}
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Messages Viewport -->
                <div class="messages-viewport" id="messages-container" style="flex: 1; background: #ffffff; overflow-y: auto; padding: 24px 32px; display: flex; flex-direction: column; gap: 12px;">
                    @forelse($conversation->messages as $message)
                        @php 
                            $isMine = ($message->sender_id == Auth::id());
                            $sender = $message->sender;
                        @endphp
                        
                        <div class="message-wrapper {{ $isMine ? 'mine' : 'theirs' }}" style="display: flex; flex-direction: column; align-items: {{ $isMine ? 'flex-end' : 'flex-start' }}; align-self: {{ $isMine ? 'flex-end' : 'flex-start' }}; margin-bottom: 12px; width: 100%;">
                            
                            <div style="display: flex; gap: 8px; flex-direction: row; width: 100%; justify-content: {{ $isMine ? 'flex-end' : 'flex-start' }}; align-items: flex-end;">

                                {{-- Avatar for received messages --}}
                                @if(!$isMine)
                                    @php
                                        $isSenderPro = $sender->vendeur && $sender->vendeur->estProfessionnel();
                                        $senderShopLogo = ($isSenderPro && $sender->vendeur->pagePro) ? $sender->vendeur->pagePro->logo : null;
                                    @endphp
                                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #475569; font-size: 0.75rem; flex-shrink: 0; margin-bottom: 2px; overflow: hidden; border: 1px solid #e5e7eb;">
                                        @if($isSenderPro)
                                            @if($senderShopLogo)
                                                <img src="{{ Storage::url($senderShopLogo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <i class="fas fa-store" style="font-size: 0.75rem; color: #94a3b8;"></i>
                                            @endif
                                        @else
                                            {{ substr($sender->name, 0, 1) }}
                                        @endif
                                    </div>
                                @endif

                                {{-- The Card --}}
                                <div class="message-card" style="background: #ffffff; border-radius: 12px; border-bottom-{{ $isMine ? 'right' : 'left' }}-radius: 2px; padding: {{ $message->annonce ? '0' : '12px 16px' }}; min-width: {{ $message->annonce ? '220px' : '60px' }}; max-width: {{ $message->annonce ? '240px' : '55%' }}; position: relative; box-shadow: none; overflow: hidden;">
                                    <div style="display: flex; flex-direction: column; gap: {{ $message->annonce ? '0' : '6px' }};">
                                        
                                         @if($message->annonce)
                                            <a href="{{ route('annonces.show', $message->annonce) }}" style="text-decoration: none; display: flex; flex-direction: column; background: #ffffff;">
                                                <div style="width: 100%; height: 140px; background: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden; border-bottom: 1px solid #f1f5f9;">
                                                    <img src="{{ $message->annonce->photoPrincipale()->url ?? '' }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                                <div style="padding: 10px 14px;">
                                                    <div style="font-weight: 500; font-size: 0.85rem; color: #1e293b; line-height: 1.3; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $message->annonce->titre }}</div>
                                                    <div style="color: #111827; font-weight: 800; font-size: 1.05rem;">{{ number_format($message->annonce->prix, 0, ',', ' ') }} F CFA</div>
                                                    <div style="color: #64748b; font-size: 0.75rem; margin-top: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">{{ strip_tags($message->annonce->description ?? '') }}</div>
                                                </div>
                                            </a>
                                            @if($message->content && !str_contains(strtolower($message->content), 'bonjour, je suis intéressé') && !str_contains(strtolower($message->content), 'bonjour je suis intéressé') && !str_starts_with($message->content, 'http'))
                                                <div class="message-body-text" style="font-size: 0.95rem; color: #1e293b; line-height: 1.5; word-wrap: break-word; padding: 0 14px 8px;">
                                                    {!! nl2br(e($message->content)) !!}
                                                </div>
                                            @endif
                                        @elseif($message->image_path)
                                            @if($message->content)
                                                <div class="message-body-text" style="font-size: 0.95rem; color: #1e293b; line-height: 1.5; word-wrap: break-word; padding-bottom: 8px;">
                                                    {!! nl2br(e($message->content)) !!}
                                                </div>
                                            @endif
                                            {{-- Rich Image Card Style (Amazon/Alibaba) --}}
                                            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; display: flex; gap: 12px; align-items: center; margin-top: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                                                <div style="width: 70px; height: 50px; background: #f8fafc; border-radius: 4px; overflow: hidden; border: 1px solid #f1f5f9; flex-shrink: 0;">
                                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($message->image_path) }}" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="window.open(this.src, '_blank')">
                                                </div>
                                                <div style="flex: 1; overflow: hidden;">
                                                    <div style="font-weight: 700; color: #334155; font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Offre Promotionnelle</div>
                                                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">Voir les détails du coupon</div>
                                                </div>
                                                <i class="fas fa-chevron-right" style="color: #cbd5e1; font-size: 0.8rem;"></i>
                                            </div>
                                        @elseif($message->file_path)
                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($message->file_path) }}" target="_blank" style="text-decoration: none; display: flex; align-items: center; gap: 12px; background: #f1f5f9; padding: 10px; border-radius: 8px; margin-bottom: 4px;">
                                                <div style="width: 32px; height: 32px; background: #e2e8f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #475569;">
                                                    <i class="fas fa-file"></i>
                                                </div>
                                                <div style="flex: 1; overflow: hidden;">
                                                    <div style="font-size: 0.85rem; font-weight: 500; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ basename($message->file_path) }}</div>
                                                    <div style="font-size: 0.72rem; color: #64748b;">Document</div>
                                                </div>
                                                <i class="fas fa-download" style="color: #94a3b8; font-size: 0.9rem;"></i>
                                            </a>
                                            @if($message->content)
                                                <div class="message-body-text" style="font-size: 0.95rem; color: #1e293b; line-height: 1.5; word-wrap: break-word; padding-top: 4px;">
                                                    {!! nl2br(e($message->content)) !!}
                                                </div>
                                            @endif
                                        @else
                                            {{-- Regular Message Body --}}
                                            <div class="message-body-text" style="font-size: 0.95rem; color: #1e293b; line-height: 1.5; word-wrap: break-word;">
                                                {!! nl2br(e($message->content)) !!}
                                            </div>
                                        @endif
                                        
                                        {{-- Actions under message text --}}
                                        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #f1f5f9; padding: {{ $message->annonce ? '8px 16px 12px' : '8px 0 0' }}; margin-top: {{ $message->annonce ? '0' : '4px' }};">
                                            <div style="display: flex; gap: 15px; font-size: 0.72rem; font-weight: 500; color: #64748b;">
                                                @if($isMine)
                                                <form action="{{ route('conversations.messages.destroy', [$conversation, $message, 'layout' => request('layout')]) }}" method="POST" onsubmit="return confirm('Souhaitez-vous vraiment supprimer ce message ?');" style="margin: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background: transparent; border: none; color: inherit; cursor: pointer; padding: 0; font-family: inherit; font-size: inherit; font-weight: inherit; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                                        <i class="far fa-trash-alt"></i> Supprimer
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                            
                                            <div style="font-size: 0.68rem; color: #94a3b8; display: flex; align-items: center; gap: 4px;">
                                                {{ $message->created_at->format('H:i') }}
                                                @if($isMine)
                                                    <i class="fas fa-check-double" style="color: #94a3b8;" title="Lu"></i>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #94a3b8;">
                            <i class="far fa-comments" style="font-size: 4rem; opacity: 0.2; margin-bottom: 16px;"></i>
                            <p style="font-size: 0.95rem; font-weight: 500; color: #475569;">Commencez la discussion avec {{ $otherUser->name }}</p>
                            <span style="font-size: 0.8rem; color: #94a3b8; margin-top: 4px;">Dites bonjour ou posez une question sur un produit.</span>
                        </div>
                    @endforelse
                </div>

                <!-- Input Area (Alibaba Style) -->
                <div class="chat-input-box" style="padding: 16px 24px; border-top: 1px solid #e5e7eb; background: #fff;">
                    <form action="{{ route('conversations.messages.store', $conversation) }}" id="chat-form" method="POST" enctype="multipart/form-data" style="margin: 0;">
                        @csrf
                        @if(request('layout'))
                            <input type="hidden" name="layout" value="{{ request('layout') }}">
                        @endif
                        <input type="file" name="attachment" id="chat-attachment-input" style="display: none;" onchange="updateFileStatus(this)">
                        
                        {{-- Product Preview Area (if coming from an ad) --}}
                        @if(session('show_annonce_preview') && $conversation->annonce)
                            <div id="product-preview-bar" style="padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-bottom: none; border-top-left-radius: 8px; border-top-right-radius: 8px; position: relative; display: flex; gap: 12px; align-items: flex-start;">
                                <input type="hidden" name="annonce_id" id="hidden_annonce_id" value="{{ $conversation->annonce_id }}">
                                <img src="{{ $conversation->annonce->photoPrincipale()->url ?? '' }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e7eb;">
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 600; font-size: 0.85rem; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;">{{ $conversation->annonce->titre }}</div>
                                    <div style="font-weight: 700; font-size: 0.9rem; color: #ea580c; margin-bottom: 2px;">{{ number_format($conversation->annonce->prix, 0, ',', ' ') }} F CFA</div>
                                    <div style="font-size: 0.75rem; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ strip_tags($conversation->annonce->description ?? '') }}</div>
                                </div>
                                <div onclick="removeProductPreviewInInput()" style="position: absolute; top: 8px; right: 8px; background: #e2e8f0; color: #475569; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.6rem;">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        @endif

                        {{-- Image Preview Area --}}
                        <div id="image-preview-wrapper" style="display: none; padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-bottom: none; border-top-left-radius: 8px; border-top-right-radius: 8px; position: relative;">
                            <img id="image-preview" src="#" style="max-height: 100px; border-radius: 4px; display: block;">
                            <div onclick="removeSelectedFile()" style="position: absolute; top: 5px; left: 105px; background: rgba(0,0,0,0.5); color: #fff; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.7rem;">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>

                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; border-top-left-radius: {{ (session('show_annonce_preview') && $conversation->annonce) ? '0' : '8px' }}; border-top-right-radius: {{ (session('show_annonce_preview') && $conversation->annonce) ? '0' : '8px' }}; transition: border-color 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02) inset;" onfocusin="this.style.borderColor='#ea580c'" onfocusout="this.style.borderColor='#e2e8f0'">
                            <textarea name="content" id="chat-textarea" placeholder="Saisissez votre message pour {{ $otherUser->name }}..." style="width: 100%; height: 64px; background: transparent; border: none; outline: none; resize: none; font-size: 0.95rem; line-height: 1.5; color: #1e293b; padding: 12px 16px;"></textarea>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 16px; border-top: 1px solid #f8fafc; background: #f8fafc; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                                <div style="font-size: 0.75rem; color: #64748b; display: flex; gap: 12px; align-items: center;">
                                    <i class="fas fa-paperclip" style="cursor: pointer; font-size: 1.1rem; transition: color 0.2s;" onmouseover="this.style.color='#ea580c'" onmouseout="this.style.color='#64748b'" title="Joindre un fichier" onclick="document.getElementById('chat-attachment-input').click()"></i>
                                    <i class="far fa-image" style="cursor: pointer; font-size: 1.1rem; transition: color 0.2s;" onmouseover="this.style.color='#ea580c'" onmouseout="this.style.color='#64748b'" title="Ajouter une image" onclick="document.getElementById('chat-attachment-input').click()"></i>
                                    <span id="selected-file-info" style="color: #ea580c; font-weight: 500;"></span>
                                    <span style="opacity: 0.6; margin-left: 8px;">Appuyez sur "Entrée" pour envoyer</span>
                                </div>
                                <button type="submit" id="send-button" style="background: #ea580c; color: #fff; border: none; padding: 8px 24px; border-radius: 4px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: background 0.2s; box-shadow: 0 1px 3px rgba(234,88,12,0.2); display: flex; align-items: center; gap: 8px;" onmouseover="this.style.background='#d84315'" onmouseout="this.style.background='#ea580c'">
                                    <i class="far fa-paper-plane"></i> Envoyer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>

{{-- WhatsApp Style Delete Modal --}}
<div class="delete-modal-overlay" id="delete-modal-overlay">
    <div class="delete-modal">
        <h3 id="delete-modal-title">Supprimer le message ?</h3>
        <p id="delete-modal-text">Voulez-vous supprimer ce message ?</p>
        <div class="delete-modal-actions">
            <button class="btn-cancel-delete" onclick="closeDeleteModal()">Annuler</button>
            <button class="btn-confirm-delete" id="confirm-delete-btn" onclick="confirmDelete()">Supprimer le message</button>
        </div>
    </div>
</div>

{{-- Hidden form for conversation deletion --}}
<form id="delete-conversation-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    let deleteUrl = null;
    let isDeletingAnnonce = false;

    function openDeleteModal(url, isAnnonce = false) {
        deleteUrl = url;
        isDeletingAnnonce = isAnnonce;
        
        const title = document.getElementById('delete-modal-title');
        const text = document.getElementById('delete-modal-text');
        
        if (isAnnonce) {
            title.textContent = 'Retirer ce produit ?';
            text.textContent = 'Ce produit ne sera plus associé à cette conversation.';
        } else {
            title.textContent = 'Supprimer ce message ?';
            text.textContent = 'Cette action est irréversible. Le message sera définitivement supprimé.';
        }
        
        document.getElementById('delete-modal-overlay').classList.add('active');
    }

    function closeDeleteModal() {
        deleteUrl = null;
        document.getElementById('delete-modal-overlay').classList.remove('active');
    }

    function confirmDelete() {
        if (!deleteUrl) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        form.innerHTML = ''; // Clear previous content if any
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        form.appendChild(csrf);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }

    function updateFileStatus(input) {
        const info = document.getElementById('selected-file-info');
        const previewWrapper = document.getElementById('image-preview-wrapper');
        const previewImg = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Preview for images
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewWrapper.style.display = 'block';
                }
                reader.readAsDataURL(file);
                info.textContent = ''; // Don't show name for images, preview is enough
            } else {
                previewWrapper.style.display = 'none';
                info.textContent = '📎 ' + file.name; // Keep name for regular files
            }

            const sendBtn = document.getElementById('send-button');
            if (sendBtn) {
                sendBtn.style.background = '#e55c00';
                sendBtn.style.boxShadow = '0 0 10px rgba(255,102,0,0.3)';
            }
        } else {
            removeSelectedFile();
        }
    }

    function removeSelectedFile() {
        if (document.getElementById('chat-attachment-input')) {
            document.getElementById('chat-attachment-input').value = '';
        }
        document.getElementById('selected-file-info').textContent = '';
        document.getElementById('image-preview-wrapper').style.display = 'none';
        const sendBtn = document.getElementById('send-button');
        if (sendBtn) {
            sendBtn.style.background = '#ea580c';
            sendBtn.style.boxShadow = 'none';
        }
    }



    function removeProductPreviewInInput() {
        if (document.getElementById('product-preview-bar')) {
            document.getElementById('product-preview-bar').style.display = 'none';
        }
        if (document.getElementById('hidden_annonce_id')) {
            document.getElementById('hidden_annonce_id').remove();
        }
    }

    // Fermer le modal en cliquant en dehors
    document.getElementById('delete-modal-overlay').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-scroll to bottom
        const container = document.getElementById('messages-container');
        if (container) container.scrollTop = container.scrollHeight;

        // Handle prefilled textarea
        const textarea = document.getElementById('chat-textarea');
        if (textarea && textarea.value.trim() !== '') {
            textarea.style.height = '';
            textarea.style.height = textarea.scrollHeight + 'px';
            textarea.focus();
            textarea.setSelectionRange(textarea.value.length, textarea.value.length);
        }

        // Envoyer avec Entrée
        if (textarea) {
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    document.getElementById('send-button').click();
                }
            });
        }

        // --- Conversation Deletion ---
        let convIdToDelete = null;

        window.openDeleteConvModal = function(id, name) {
            convIdToDelete = id;
            document.getElementById('delete-modal-title').textContent = 'Supprimer la discussion ?';
            document.getElementById('delete-modal-text').textContent = 'Voulez-vous supprimer la discussion avec ' + name + ' ? Cette action est irréversible.';
            document.getElementById('confirm-delete-btn').textContent = 'Supprimer';
            document.getElementById('confirm-delete-btn').setAttribute('onclick', 'confirmDeleteConv()');
            document.getElementById('delete-modal-overlay').classList.add('active');
        };

        window.closeDeleteModal = function() {
            document.getElementById('delete-modal-overlay').classList.remove('active');
            // Reset modal for messages (default)
            setTimeout(() => {
                document.getElementById('delete-modal-title').textContent = 'Supprimer le message ?';
                document.getElementById('delete-modal-text').textContent = 'Voulez-vous supprimer ce message ?';
                document.getElementById('confirm-delete-btn').textContent = 'Supprimer le message';
                document.getElementById('confirm-delete-btn').setAttribute('onclick', 'confirmDelete()');
            }, 300);
        };

        window.confirmDeleteConv = function() {
            if (convIdToDelete) {
                const layout = new URLSearchParams(window.location.search).get('layout') || '';
                const form = document.getElementById('delete-conversation-form');
                form.action = '/messagerie/' + convIdToDelete + (layout ? '?layout=' + layout : '');
                form.submit();
            }
        };
    });
</script>
@endsection
