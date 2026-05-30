<x-map-layout>
    <div class="h-[100dvh] flex flex-col bg-white overflow-hidden">
        <!-- Minimal Yango Header -->
        <div class="flex items-center px-4 py-4 bg-white border-b border-gray-100 sticky top-0 z-30">
            <a href="{{ route('dashboard') }}" class="p-2 -ml-2 text-black active:scale-95 transition-transform">
                 <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-[19px] font-black text-black ml-4">Détails de la course</h1>
        </div>

        <div class="flex-1 overflow-y-auto">
            <!-- Order Header -->
            <div class="px-6 py-10 flex flex-col items-center border-b border-gray-50">
                <span class="text-gray-400 font-black text-[11px] uppercase tracking-[0.2em] mb-2">Estimation des gains</span>
                <h2 class="text-[44px] font-black text-black tracking-tighter leading-none mb-1">{{ number_format($mission->frais_port ?? 1500, 0, ',', ' ') }} <span class="text-xl font-bold uppercase ml-1 text-gray-300">CFA</span></h2>
                <div class="mt-4 inline-flex items-center space-x-2 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-full border border-blue-100">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    <span class="text-[12px] font-black uppercase tracking-widest text-shadow">Course Directe</span>
                </div>
            </div>

            <!-- Trajet Details -->
            <div class="px-8 py-10 space-y-10 relative pl-14 before:absolute before:left-9 before:top-12 before:bottom-12 before:w-[1px] before:bg-gray-100">
                <div class="relative">
                    <div class="absolute -left-[32px] top-1 w-4 h-4 bg-black rounded-sm border-2 border-white shadow-sm"></div>
                    <p class="text-[11px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1">Point A (Collecte)</p>
                    <p class="text-[18px] font-black text-black">{{ $mission->seller->adresse ?? 'Point De Collecte' }}</p>
                    <p class="text-gray-400 text-[13px] mt-1">{{ $mission->seller->nom_boutique }}</p>
                </div>

                <div class="relative">
                    <div class="absolute -left-[32px] top-1 w-4 h-4 bg-white rounded-full border-2 border-gray-200 shadow-sm"></div>
                    <p class="text-[11px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1">Point B (Livraison)</p>
                    <p class="text-[18px] font-black text-black">{{ $mission->adresse_livraison }}</p>
                </div>
            </div>

            <!-- Client Info -->
            <div class="mx-6 p-6 bg-gray-50 rounded-[28px] border border-gray-100">
                 <p class="text-black/40 font-black text-[10px] uppercase tracking-widest mb-4">Informations Colis</p>
                 <div class="flex items-center space-x-4">
                     <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-black border border-gray-100">
                          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                     </div>
                     <div class="flex flex-col">
                         <span class="text-black font-black text-[15px]">{{ $mission->total_produits }} article(s)</span>
                         <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Remise en main propre</span>
                     </div>
                 </div>
            </div>
        </div>

        <!-- Sticky Bottom Final Validation (OTP) -->
        <div class="p-6 border-t border-gray-50 bg-white shadow-2xl">
            <div x-data="{ state: 'ready', otp: '' }">
                <template x-if="state === 'ready'">
                    <div class="flex flex-col space-y-4">
                         <button @click="state = 'on_site'" class="w-full h-20 bg-black text-white font-black rounded-[24px] text-[20px] uppercase tracking-tighter active:scale-95 transition-transform">
                             Je suis sur place
                         </button>
                    </div>
                </template>

                <template x-if="state === 'on_site'">
                     <div class="flex flex-col space-y-4">
                         <button @click="state = 'otp'" class="w-full h-20 bg-[#276EF1] text-white font-black rounded-[24px] text-[20px] uppercase tracking-tighter active:scale-95 transition-transform">
                             Démarrer la course
                         </button>
                         <button @click="state = 'ready'" class="text-gray-400 font-bold uppercase tracking-widest text-[11px] text-center">Annuler</button>
                    </div>
                </template>

                <template x-if="state === 'otp'">
                    <div class="space-y-6">
                        <input type="number" 
                               x-model="otp"
                               placeholder="Code OTP du client" 
                               class="w-full bg-gray-50 border-none rounded-[20px] py-6 text-center text-3xl font-black tracking-[0.3em] focus:ring-4 focus:ring-[#276EF1]/50 placeholder:text-gray-200">
                        
                        <button :disabled="otp.length < 4" 
                                class="w-full h-20 bg-black text-white font-black rounded-[24px] text-[20px] uppercase tracking-tighter active:scale-95 transition-transform disabled:opacity-20 translate-y-0 focus:ring-4 focus:ring-[#276EF1]/50">
                            Terminer la course
                        </button>
                        
                        <button @click="state = 'ready'" class="w-full text-gray-400 font-bold py-2 text-xs uppercase tracking-widest text-center">
                            Retour
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-map-layout>
