@extends('layouts.app')

@section('title', 'Nouveau message - Mady Market')

@push('styles')
<style>
    .message-create-container {
        max-width: 600px;
        margin: 4rem auto;
        padding: 0 1rem;
    }
    .message-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #eee;
        overflow: hidden;
    }
    .message-card-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafafa;
    }
    .message-card-header h1 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #333;
        margin: 0;
    }
    .message-form {
        padding: 2rem;
    }
    .recipient-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8faff;
        border-radius: 8px;
        border: 1px solid #eef2ff;
        margin-bottom: 1.5rem;
    }
    .recipient-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .recipient-details .label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #999;
        letter-spacing: 0.5px;
        font-weight: 700;
    }
    .recipient-details .name {
        font-weight: 700;
        color: #000;
    }
    .annonce-share-card {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 1.5rem;
        text-decoration: none;
        color: inherit;
        display: block;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .annonce-share-media {
        width: 100%;
        height: 200px;
        background: #f1f5f9;
        overflow: hidden;
        position: relative;
    }
    .annonce-share-media img,
    .annonce-share-media video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .annonce-share-media .no-media-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 3rem;
    }
    .annonce-share-body {
        padding: 1rem 1.25rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbff;
    }
    .annonce-share-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #004aad;
        letter-spacing: 0.06em;
        margin-bottom: 4px;
    }
    .annonce-share-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .annonce-share-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: #004aad;
        margin-bottom: 4px;
    }
    .annonce-share-desc {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .form-textarea {
        width: 100%;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        min-height: 150px;
        outline: none;
        transition: border-color 0.2s;
    }
    .form-textarea:focus {
        border-color: #bf0000;
    }
    .btn-send {
        width: 100%;
        padding: 1rem;
        background: #bf0000;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 800;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(191,0,0,0.2);
    }
    .btn-send:hover {
        background: #a00000;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(191,0,0,0.3);
    }
</style>
@endpush

@section('content')
<nav class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a> &gt; 
    <a href="{{ route('account.index') }}">Mon compte</a> &gt; 
    <a href="{{ route('conversations.index') }}">Mes messages</a> &gt; 
    <span>Nouveau message</span>
</nav>

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <div class="main-content">
        <div class="message-card">
            <div class="message-card-header">
                <h1>Nouveau message</h1>
                <a href="{{ url()->previous() }}" style="color: #999;"><i class="fas fa-times"></i></a>
            </div>
            
            <form action="{{ route('conversations.store') }}" method="POST" class="message-form">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
                @if(isset($annonceId) && $annonceId)
                    <input type="hidden" name="annonce_id" value="{{ $annonceId }}">
                @endif

                <div class="recipient-info">
                    <img src="{{ $recipient->avatar ? Storage::url($recipient->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($recipient->name) }}" class="recipient-avatar">
                    <div class="recipient-details">
                        <div class="label">Destinataire</div>
                        <div class="name">{{ $recipient->name }}</div>
                    </div>
                </div>

                @if(isset($annonceId) && ($annonce = \App\Models\Annonce::with(['medias', 'produit'])->find($annonceId)))
                    @php
                        $media = $annonce->video ?: $annonce->photoPrincipale();
                        $isVideo = $media && $media->type === 'video';
                    @endphp
                    <a href="{{ route('annonces.show', $annonce->slug) }}" class="annonce-share-card" target="_blank">
                        <div class="annonce-share-media">
                            @if($media)
                                @if($isVideo)
                                    <video src="{{ $media->url }}" muted playsinline preload="metadata"></video>
                                @else
                                    <img src="{{ $media->url }}" alt="{{ $annonce->titre }}">
                                @endif
                            @else
                                <div class="no-media-placeholder"><i class="fas fa-image"></i></div>
                            @endif
                        </div>
                        <div class="annonce-share-body">
                            <div class="annonce-share-label">
                                <i class="fas fa-link" style="margin-right:4px;"></i>Produit partagé
                            </div>
                            <div class="annonce-share-title">{{ $annonce->titre }}</div>
                            <div class="annonce-share-price">{{ number_format($annonce->prix, 0, ',', ' ') }} CFA</div>
                            @if($annonce->description)
                                <div class="annonce-share-desc">{{ $annonce->description }}</div>
                            @endif
                        </div>
                    </a>
                @endif

                <div class="form-group">
                    <label for="message">Votre message</label>
                    <textarea name="message" id="message" class="form-textarea" placeholder="Dites quelque chose au vendeur..." required autofocus>{{ $prefilledMessage ?? '' }}</textarea>
                </div>

                <button type="submit" class="btn-send">
                    Envoyer le message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
