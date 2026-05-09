@if(session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
    <div x-data="{ 
            show: true,
            message: '{{ session('success') ?? session('error') ?? session('warning') ?? session('info') }}',
            type: '{{ session('success') ? 'success' : (session('error') ? 'error' : (session('warning') ? 'warning' : 'info')) }}'
        }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed bottom-6 right-6 z-50 flex items-center p-4 min-w-[320px] bg-[#1a1c23] text-white rounded-xl shadow-2xl border-l-[4px]"
        style="backdrop-filter: blur(8px); background-color: rgba(26, 28, 35, 0.95);"
        :class="{
            'border-emerald-500': type === 'success',
            'border-rose-500': type === 'error',
            'border-amber-500': type === 'warning',
            'border-[#004aad]': type === 'info'
        }"
        role="alert">
        
        <div class="ml-2 text-[0.92rem] font-medium tracking-tight" x-text="message"></div>
        <button type="button" class="ml-auto flex items-center justify-center w-7 h-7 rounded-full hover:bg-white/10 transition-colors text-white/50 hover:text-white" aria-label="Close" @click="show = false">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
@endif

<!-- Support pour les événements déclenchés par Livewire ou AJAX (window.dispatchEvent) -->
<div x-data="{ notifications: [] }"
     @notify.window="notifications.push({
         id: Date.now(),
         message: $event.detail.message,
         type: $event.detail.type || 'success'
     }); setTimeout(() => { notifications = notifications.filter(n => n.id !== notifications[0].id) }, 4000)"
     class="fixed bottom-4 right-4 z-50 space-y-4">
    <template x-for="notification in notifications" :key="notification.id">
        <div x-show="true"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="flex items-center p-4 w-full max-w-xs bg-[#1a1c23] text-white rounded-xl shadow-2xl border-l-[4px]"
             style="backdrop-filter: blur(8px); background-color: rgba(26, 28, 35, 0.95);"
             :class="{
                'border-emerald-500': notification.type === 'success',
                'border-rose-500': notification.type === 'error',
                'border-amber-500': notification.type === 'warning',
                'border-[#004aad]': notification.type === 'info'
             }"
             role="alert">
            <div class="ml-2 text-[0.92rem] font-medium tracking-tight" x-text="notification.message"></div>
        </div>
    </template>
</div>
