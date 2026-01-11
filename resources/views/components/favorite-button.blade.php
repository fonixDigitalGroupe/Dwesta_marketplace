@props(['annonce'])

@php
    $isFavorite = Auth::check() ? Auth::user()->favorites->contains($annonce->id) : false;
@endphp

<div x-data="{ 
        isFavorite: {{ $isFavorite ? 'true' : 'false' }}, 
        count: {{ $annonce->favoritedBy()->count() }},
        loading: false,
        toggle() {
            if (this.loading) return;
            @auth
                this.loading = true;
                fetch('{{ route('favorites.toggle', $annonce) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else if (response.status === 401) {
                         window.location.href = '{{ route('login') }}';
                         throw new Error('Unauthenticated');
                    }
                    throw new Error('Network response was not ok');
                })
                .then(data => {
                    this.isFavorite = !this.isFavorite;
                    this.count = data.count;
                    
                    // Dispatch event for toast
                    window.dispatchEvent(new CustomEvent('notify', { 
                        detail: { 
                            message: data.message, 
                            type: 'success' 
                        } 
                    }));
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    this.loading = false;
                });
            @else
                window.location.href = '{{ route('login') }}';
            @endauth
        }
     }" 
     class="inline-flex items-center">
    
    <button @click="toggle()" 
            class="p-2 rounded-full transition transform hover:scale-110 focus:outline-none"
            :class="isFavorite ? 'text-red-500 hover:bg-red-50' : 'text-gray-400 hover:text-red-500 hover:bg-gray-100'"
            :disabled="loading">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="isFavorite ? 'fill-current' : 'fill-none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>
    <span x-show="count > 0" x-text="count" class="ml-1 text-sm text-gray-500"></span>
</div>
