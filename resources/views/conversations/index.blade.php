@extends('layouts.app')

@section('title', 'Ma Messagerie')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Mes Messages</h1>
    </div>

    @if($conversations->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @foreach($conversations as $conversation)
                @php
                    $otherUser = $conversation->user1_id == Auth::id() ? $conversation->user2 : $conversation->user1;
                    $lastMessage = $conversation->messages()->latest()->first();
                    $unreadCount = $conversation->messages()->where('sender_id', '!=', Auth::id())->whereNull('read_at')->count();
                @endphp
                <a href="{{ route('conversations.show', $conversation) }}" class="block hover:bg-gray-50 border-b last:border-b-0 p-4 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <img src="{{ $otherUser->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name) }}" alt="{{ $otherUser->name }}" class="w-12 h-12 rounded-full object-cover">
                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $otherUser->name }}</div>
                                @if($conversation->annonce)
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <span class="mr-1">Concernant :</span>
                                        <span class="font-medium text-blue-600 truncate max-w-xs">{{ $conversation->annonce->titre }}</span>
                                    </div>
                                @endif
                                <div class="text-sm text-gray-600 mt-1 truncate max-w-md">
                                    {{ $lastMessage ?Str::limit($lastMessage->content, 60) : 'Nouvelle conversation' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400 whitespace-nowrap ml-4">
                            {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : $conversation->created_at->diffForHumans() }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900">Aucune conversation</h3>
            <p class="text-gray-500 mt-1">Vos échanges avec les vendeurs apparaîtront ici.</p>
        </div>
    @endif
</div>
@endsection
