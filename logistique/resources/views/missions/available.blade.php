<x-map-layout>
    <div class="h-[100dvh] flex flex-col bg-slate-50 overflow-hidden font-sans">
        <!-- Professional Header -->
        <div class="flex items-center px-6 py-8 bg-white border-b border-slate-100 sticky top-0 z-30">
            <a href="{{ route('dashboard') }}" class="w-12 h-12 flex items-center justify-center bg-slate-50 rounded-xl text-slate-900 active:scale-95 transition-all">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl font-outfit font-black text-slate-900 ml-6 tracking-tight">Missions Disponibles</h1>
        </div>

        <div class="flex-1 overflow-y-auto px-6 py-8 space-y-6">
            @forelse($missions as $mission)
                <div class="bg-white rounded-[32px] border border-slate-100 p-8 flex flex-col shadow-sm hover:shadow-md transition-all group">
                    <!-- Fare & Points -->
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-3">Rémunération</div>
                            <h2 class="text-slate-900 font-outfit font-black text-[36px] leading-none tracking-tighter">{{ number_format($mission->frais_port ?? 1500, 0, ',', ' ') }} <span class="text-xl font-bold opacity-40">CFA</span></h2>
                            <div class="mt-4 inline-flex items-center gap-2 bg-blue-50 text-primary px-4 py-1.5 rounded-xl border border-blue-100">
                                <span class="text-[11px] font-outfit font-black tracking-widest">+2 POINTS</span>
                            </div>
                        </div>
                        <div class="text-right">
                             <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path></svg>
                             </div>
                             <p class="text-slate-900 font-outfit font-extrabold text-sm mt-2">~ 12 min</p>
                        </div>
                    </div>

                    <!-- Route -->
                    <div class="space-y-10 relative pl-10 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-100">
                        <div class="relative">
                            <div class="absolute -left-[39px] top-1.5 w-5 h-5 bg-slate-900 rounded-lg border-4 border-white shadow-md"></div>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest leading-none mb-2">Ramassage</p>
                            <p class="text-[17px] font-outfit font-bold text-slate-800 tracking-tight">{{ $mission->seller->adresse ?? 'Point De Collecte Akwaba' }}</p>
                        </div>
                        <div class="relative">
                            <div class="absolute -left-[39px] top-1.5 w-5 h-5 bg-white rounded-full border-4 border-slate-200 shadow-md"></div>
                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest leading-none mb-2">Livraison</p>
                            <p class="text-[17px] font-outfit font-bold text-slate-800 tracking-tight">{{ $mission->adresse_livraison }}</p>
                        </div>
                    </div>

                    <!-- Action -->
                    <div class="mt-10 pt-8 border-t border-slate-50">
                        <form action="{{ route('missions.accept', $mission) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-full h-16 bg-primary text-white font-outfit font-black rounded-2xl text-lg active:scale-95 transition-all shadow-lg shadow-blue-500/20 flex items-center justify-center gap-3" style="background-color: var(--primary);">
                                <span>Accepter la mission</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 12h14M12 5l7 7-7 7"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-32 text-center flex flex-col items-center">
                    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center text-slate-300 mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" stroke-width="2"></path></svg>
                    </div>
                    <p class="text-slate-400 font-outfit font-black uppercase tracking-widest text-xs">Aucune offre disponible</p>
                </div>
            @endforelse
        </div>
    </div>
</x-map-layout>
