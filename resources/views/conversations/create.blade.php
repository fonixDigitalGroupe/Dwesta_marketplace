@extends('layouts.app')

@section('title', 'Nouveau message')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Nouveau message</h1>
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        </div>
        
        <form action="{{ route('conversations.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
            @if(request('annonce_id'))
                <input type="hidden" name="annonce_id" value="{{ request('annonce_id') }}">
            @endif

            <div class="flex items-center space-x-3 bg-blue-50 p-3 rounded-lg border border-blue-100">
                <img src="{{ $recipient->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($recipient->name) }}" class="w-10 h-10 rounded-full bg-white">
                <div>
                    <div class="text-xs text-gray-500 uppercase tracking-wide">Destinataire</div>
                    <div class="font-bold text-gray-900">{{ $recipient->name }}</div>
                </div>
            </div>

            @if(request('annonce_id') && $annonce = \App\Models\Annonce::find(request('annonce_id')))
                <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center text-xl">📦</div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide">Concernant</div>
                        <div class="font-medium text-gray-900 truncate max-w-[200px]">{{ $annonce->titre }}</div>
                    </div>
                </div>
            @endif

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Votre message</label>
                <textarea name="message" id="message" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Bonjour, je suis intéressé par..." required autofocus></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow transition transform hover:-translate-y-0.5">
                Envoyer le message
            </button>
        </form>
    </div>
</div>
@endsection
