@extends('layouts.app')

@section('title', 'Conversation')

@section('content')
<div class="container mx-auto px-4 py-6 h-[calc(100vh-140px)] flex flex-col">
    @php
        $otherUser = $conversation->user1_id == Auth::id() ? $conversation->user2 : $conversation->user1;
    @endphp

    <!-- Header -->
    <div class="bg-white shadow rounded-t-lg p-4 flex items-center justify-between z-10">
        <div class="flex items-center space-x-3">
            <a href="{{ route('conversations.index') }}" class="text-gray-500 hover:text-gray-700 mr-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <img src="{{ $otherUser->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name) }}" class="w-10 h-10 rounded-full bg-gray-200">
            <div>
                <h2 class="font-bold text-gray-800 leading-tight">{{ $otherUser->name }}</h2>
                @if($conversation->annonce)
                    <a href="{{ route('annonces.show', $conversation->annonce) }}" class="text-xs text-blue-600 hover:underline flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        {{ Str::limit($conversation->annonce->titre, 40) }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 bg-gray-50 overflow-y-auto p-4 space-y-4" id="messages-container">
        @foreach($conversation->messages as $message)
            <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[75%] {{ $message->sender_id == Auth::id() ? 'bg-blue-600 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none' }} rounded-2xl px-4 py-2 shadow-sm">
                    <p class="text-sm whitespace-pre-wrap">{{ $message->content }}</p>
                    <div class="text-[10px] mt-1 {{ $message->sender_id == Auth::id() ? 'text-blue-100' : 'text-gray-400' }} text-right">
                        {{ $message->created_at->format('H:i') }}
                        @if($message->sender_id == Auth::id())
                            @if($message->read_at)
                                <span class="ml-1">✓✓</span>
                            @else
                                <span class="ml-1">✓</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Input Area -->
    <div class="bg-white p-4 border-t rounded-b-lg">
        <form action="{{ route('conversations.messages.store', $conversation) }}" method="POST" class="flex items-end space-x-2">
            @csrf
            <div class="flex-1 bg-gray-100 rounded-lg p-2 focus-within:ring-2 focus-within:ring-blue-500 focus-within:bg-white transition">
                <textarea name="content" rows="1" class="w-full bg-transparent border-none focus:ring-0 resize-none max-h-32 text-sm" placeholder="Écrivez votre message..." required oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2.5 transition flex-shrink-0 shadow-lg">
                <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>
    </div>
</div>

<script>
    // Scroll to bottom on load
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
