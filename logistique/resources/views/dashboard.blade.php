<x-map-layout>
    <div x-data="{ 
        state: 'offline', 
        activity: 95, 
        rating: 4.9, 
        income: 0,
        showRequest: false,
        timer: 15,
        timerInterval: null,
        
        goOnline() {
            this.state = 'online';
            setTimeout(() => {
                if(this.state === 'online') this.triggerRequest();
            }, 5000);
        },
        
        goOffline() {
            this.state = 'offline';
            this.showRequest = false;
        },
        
        triggerRequest() {
            this.showRequest = true;
            this.timer = 15;
            this.timerInterval = setInterval(() => {
                if(this.timer > 0) this.timer--;
                else this.closeRequest();
            }, 1000);
        },
        
        closeRequest() {
            this.showRequest = false;
            clearInterval(this.timerInterval);
        }
    }" class="relative h-[100dvh] w-full bg-slate-50 overflow-hidden font-sans">
        
        <!-- Map Background -->
        <div id="map" class="absolute inset-0 z-0 yango-map"></div>

        <!-- Top Navigation Bar -->
        <div class="absolute top-0 left-0 w-full z-20 pt-8 px-6 flex justify-between items-center pointer-events-none">
            <!-- Left: Search/Menu Button -->
            <button @click="sidebarOpen = true" class="pointer-events-auto w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-2xl active:scale-95 transition-all group overflow-hidden">
                <div class="w-full h-full flex items-center justify-center bg-slate-900 group-hover:bg-primary transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
            </button>

            <!-- Center: Earnings Bubble -->
            <a href="{{ route('missions.earnings') }}" class="pointer-events-auto bg-white border border-slate-100 pl-2 pr-6 py-2 rounded-2xl flex items-center gap-3 shadow-2xl active:scale-95 transition-all">
                <div class="w-10 h-10 rounded-xl bg-green-500 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 1v22M17 5H9.5a4.5 4.5 0 1 0 0 9h5a4.5 4.5 0 1 1 0 9H6"></path></svg>
                </div>
                <div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Gains du jour</div>
                    <div class="text-lg font-outfit font-black text-slate-900 leading-none">0 CFA</div>
                </div>
            </a>

            <!-- Right: Profile -->
            <button @click="sidebarOpen = true" class="pointer-events-auto w-14 h-14 bg-white rounded-2xl border-4 border-white flex items-center justify-center shadow-2xl active:scale-95 transition-transform overflow-hidden">
                 <div class="bg-primary w-full h-full flex items-center justify-center text-white text-xl font-outfit font-black" style="background-color: var(--primary);">{{ strtoupper(substr(Auth::user()->prenom ?? Auth::user()->name, 0, 1)) }}</div>
            </button>
        </div>

        <!-- Floating Action Buttons -->
        <div x-show="state === 'online'" class="absolute bottom-40 right-6 z-20 flex flex-col space-y-4">
             <button class="w-16 h-16 bg-white rounded-2xl shadow-2xl flex items-center justify-center text-slate-800 active:scale-90 transition-all border border-slate-100 group">
                 <svg class="w-7 h-7 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
             </button>
             <button class="w-16 h-16 bg-white rounded-2xl shadow-2xl flex items-center justify-center text-slate-800 active:scale-90 transition-all border border-slate-100 group">
                 <svg class="w-7 h-7 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
             </button>
        </div>

        <!-- Main Toggle Button -->
        <div class="absolute bottom-10 left-0 w-full z-30 flex justify-center px-8">
            <button @click="state === 'offline' ? goOnline() : goOffline()" 
                    :class="state === 'offline' ? 'bg-[#004aad] shadow-blue-500/20' : 'bg-slate-900 shadow-slate-900/20'"
                    class="w-full h-24 rounded-[32px] font-outfit font-black text-[24px] uppercase tracking-wider flex items-center justify-center transition-all duration-500 active:scale-95 shadow-2xl group overflow-hidden relative text-white">
                
                <div x-show="state === 'online'" class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>
                
                <div class="flex items-center gap-4">
                    <div x-show="state === 'offline'" class="w-3 h-3 bg-white rounded-full animate-ping"></div>
                    <span x-text="state === 'offline' ? 'Passer en ligne' : 'Se déconnecter'"></span>
                </div>
            </button>
        </div>

        <!-- Full-Screen Order Request Overlay -->
        <div x-show="showRequest" 
             x-transition:enter="transition ease-out duration-500 transform"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="absolute inset-0 z-50 bg-[#004aad] flex flex-col pt-12 px-8 overflow-hidden" style="display: none;">
            
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32 blur-3xl"></div>

            <!-- Close Button -->
            <button @click="closeRequest()" class="w-14 h-14 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Order Header -->
            <div class="mt-12 flex flex-col items-center">
                <div class="bg-white/15 backdrop-blur-md border border-white/10 px-6 py-2 rounded-2xl">
                    <span class="text-white font-outfit font-black text-[12px] uppercase tracking-[0.2em]">Nouvelle Mission</span>
                </div>
                <h2 class="mt-10 text-white font-outfit font-black text-[64px] leading-none tracking-tight">1 500 <span class="text-2xl font-bold uppercase ml-1 opacity-60">CFA</span></h2>
                <div class="mt-4 flex items-center gap-3">
                    <div class="bg-orange-500 text-white font-outfit font-black text-[11px] px-4 py-1.5 rounded-xl tracking-widest">+2 POINTS</div>
                    <span class="text-white/60 font-bold text-sm tracking-wide">Inclus dans la mission</span>
                </div>
            </div>

            <!-- Addresses Section -->
            <div class="mt-16 space-y-12 relative pl-12 before:absolute before:left-4 before:top-2 before:bottom-2 before:w-0.5 before:bg-white/20">
                <div class="relative">
                    <div class="absolute -left-[45px] top-1.5 w-7 h-7 bg-white rounded-xl shadow-lg flex items-center justify-center">
                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                    </div>
                    <p class="text-white/40 font-outfit font-black text-[11px] uppercase tracking-widest mb-2">Point de Ramassage</p>
                    <p class="text-white font-outfit font-extrabold text-[22px] leading-tight">Centre Commercial Prima</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-[45px] top-1.5 w-7 h-7 bg-orange-500 rounded-xl shadow-lg flex items-center justify-center border-4 border-[#004aad]">
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    </div>
                    <p class="text-white/40 font-outfit font-black text-[11px] uppercase tracking-widest mb-2">Lieu de Livraison</p>
                    <p class="text-white font-outfit font-extrabold text-[22px] leading-tight">Riviera III - Villa 42A</p>
                </div>
            </div>

            <!-- Accept Section -->
            <div class="mt-auto mb-16 flex flex-col items-center">
                <!-- Accept Button with Pulsing Progress -->
                <a href="{{ route('missions.available') }}" class="w-full relative group h-28 bg-white text-[#004aad] rounded-[36px] flex items-center justify-center font-outfit font-black text-[28px] tracking-tight active:scale-95 transition-all shadow-2xl shadow-blue-900/40 overflow-hidden">
                    <div class="absolute left-0 top-0 h-full bg-slate-100 transition-all duration-100 ease-linear" :style="`width: ${ (timer / 15) * 100 }%`" style="opacity: 0.15"></div>
                    <span class="relative z-10 flex items-center gap-4">
                        ACCEPTER
                        <span class="w-10 h-10 rounded-full bg-[#004aad] text-white flex items-center justify-center text-lg" x-text="timer"></span>
                    </span>
                </a>
                <button @click="closeRequest()" class="mt-8 text-white/30 font-outfit font-black uppercase tracking-widest text-[12px] hover:text-white/60 transition-colors">IGNORER LA MISSION</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lat = 5.345317;
            var lng = -4.024429;

            var map = L.map('map', {
                zoomControl: false,
                attributionControl: false
            }).setView([lat, lng], 16);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 20
            }).addTo(map);

            // Large yellow marker for Yango Start
            var driverIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `
                    <div class="relative w-12 h-12 flex items-center justify-center">
                        <div class="absolute inset-0 bg-[#FFDD00] animate-pulse rounded-full opacity-30 shadow-2xl"></div>
                        <div class="w-7 h-7 bg-[#FFDD00] rounded-full border-[6px] border-white shadow-xl"></div>
                    </div>
                `,
                iconSize: [48, 48],
                iconAnchor: [24, 24]
            });

            L.marker([lat, lng], {icon: driverIcon}).addTo(map);
        });
    </script>
    @endpush

    <style>
        .custom-div-icon div {
             cursor: pointer;
        }
        .custom-div-icon .bg-\[\#FFDD00\], .custom-div-icon .bg-\[\#276EF1\] {
            background-color: #004aad !important;
        }
    </style>

    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</x-map-layout>
