<x-map-layout>
    <div class="h-[100dvh] flex flex-col bg-[#F7F7F7] overflow-y-auto">
        <!-- Minimal Yango Header -->
        <div class="flex items-center px-4 py-4 bg-white border-b border-gray-100 sticky top-0 z-30">
            <a href="{{ route('dashboard') }}" class="p-2 -ml-2 text-black active:scale-95 transition-transform">
                 <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-[19px] font-black text-black ml-4">Profil</h1>
        </div>

        <div class="flex-1">
            <!-- User Primary Info Card -->
            <div class="bg-white px-6 py-8 flex items-center space-x-5 border-b border-gray-100">
                <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center text-black font-black text-2xl border border-gray-100">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-[22px] font-black tracking-tight text-black">{{ Auth::user()->prenom ?? Auth::user()->name }}</h2>
                    <div class="flex items-center text-gray-400 text-[13px] font-bold mt-1 uppercase tracking-widest">
                        <span>ID: 88723441</span>
                        <span class="mx-2">•</span>
                        <span>Taxi Standard</span>
                    </div>
                </div>
            </div>

            <!-- PERFORMANCE SECTION (Yango Style) -->
            <div class="p-5 grid grid-cols-2 gap-4">
                <!-- Activity Index (Circle) -->
                <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-100 flex flex-col items-center group active:scale-95 transition-transform cursor-pointer">
                    <div class="relative w-20 h-20 flex items-center justify-center">
                        <svg class="absolute inset-0 w-full h-full -rotate-90">
                            <circle cx="40" cy="40" r="36" class="stroke-gray-100 fill-none" stroke-width="6"></circle>
                            <circle cx="40" cy="40" r="36" class="stroke-[#004aad] fill-none" stroke-width="6" stroke-dasharray="226" stroke-dashoffset="22.6" stroke-linecap="round"></circle>
                        </svg>
                        <span class="text-[24px] font-black text-black tabular-nums">90</span>
                    </div>
                    <span class="mt-4 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Indice<br>d'activité</span>
                </div>

                <!-- Rating -->
                <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-100 flex flex-col items-center group active:scale-95 transition-transform cursor-pointer">
                    <div class="relative w-20 h-20 flex items-center justify-center">
                        <div class="flex items-center space-x-1">
                            <span class="text-[24px] font-black text-black">4.9</span>
                            <svg class="w-5 h-5 text-amber-500 mb-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                    </div>
                    <span class="mt-4 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Note du<br>chauffeur</span>
                </div>
            </div>

            <!-- REVENUE BLOCK -->
            <div class="px-5 pb-5">
                <div class="bg-white p-8 rounded-[38px] shadow-sm border border-gray-100 flex flex-col items-center space-y-2 group active:scale-95 transition-transform cursor-pointer overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-gray-50 rounded-full"></div>
                    
                    <span class="relative z-10 text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Solde Agent</span>
                    <h3 class="relative z-10 text-[38px] font-black tracking-tighter text-black">27 700 <span class="text-xl font-bold uppercase ml-1">CFA</span></h3>
                    <div class="relative z-10 flex items-center space-x-2 text-blue-600 font-bold text-sm">
                        <span>Détails</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </div>
                </div>
            </div>

            <!-- List of Options -->
            <div class="px-5 space-y-3 mt-4">
                <div class="bg-white flex items-center justify-between p-5 rounded-[22px] border border-gray-50 group active:bg-gray-50 transition cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="text-[17px] font-bold text-black">Véhicule</span>
                    </div>
                    <span class="text-gray-300 font-medium">Bujora · 162 AC</span>
                </div>

                <div class="bg-white flex items-center justify-between p-5 rounded-[22px] border border-gray-50 group active:bg-gray-50 transition cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <span class="text-[17px] font-bold text-black">Tarifs</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-20 mb-10 text-center">
                <p class="text-[10px] text-gray-300 font-bold uppercase tracking-[0.3em]">Yango Pro Clone · v4.12.0</p>
            </div>
        </div>
    </div>
</x-map-layout>
