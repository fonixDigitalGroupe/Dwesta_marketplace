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
    .annonce-context {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1rem;
        background: #fff9f0;
        border: 1px solid #ffecb3;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .annonce-icon {
        font-size: 1.2rem;
    }
    .annonce-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #856404;
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
<div class="message-create-container">
    <div class="message-card">
        <div class="message-card-header">
            <h1>Nouveau message</h1>
            <a href="{{ url()->previous() }}" style="color: #999;"><i class="fas fa-times"></i></a>
        </div>
        
        <form action="{{ route('conversations.store') }}" method="POST" class="message-form">
            @csrf
            <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
            @if(request('annonce_id'))
                <input type="hidden" name="annonce_id" value="{{ request('annonce_id') }}">
            @endif

            <div class="recipient-info">
                <img src="{{ $recipient->avatar ? Storage::url($recipient->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($recipient->name) }}" class="recipient-avatar">
                <div class="recipient-details">
                    <div class="label">Destinataire</div>
                    <div class="name">{{ $recipient->name }}</div>
                </div>
            </div>

            @if(request('annonce_id') && $annonce = \App\Models\Annonce::find(request('annonce_id')))
                <div class="annonce-context">
                    <span class="annonce-icon">📦</span>
                    <div class="annonce-details">
                        <div style="font-size: 0.7rem; color: #b08d24; text-transform: uppercase; font-weight: 700;">Concernant</div>
                        <div class="annonce-title">{{ $annonce->titre }}</div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="message">Votre message</label>
                <textarea name="message" id="message" class="form-textarea" placeholder="Dites quelque chose au vendeur..." required autofocus></textarea>
            </div>

            <button type="submit" class="btn-send">
                Envoyer le message
            </button>
        </form>
    </div>
</div>
@endsection
