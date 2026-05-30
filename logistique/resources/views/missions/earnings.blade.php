<x-map-layout>
    <div class="h-[100dvh] flex flex-col bg-slate-50 overflow-hidden font-sans">
        <!-- Professional Header -->
        <div class="flex items-center px-6 py-8 bg-white border-b border-slate-100 sticky top-0 z-30">
            <a href="{{ route('dashboard') }}" class="w-12 h-12 flex items-center justify-center bg-slate-50 rounded-xl text-slate-900 active:scale-95 transition-all">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl font-outfit font-black text-slate-900 ml-6 tracking-tight">Solde & Revenus</h1>
        </div>

        <div class="flex-1 overflow-y-auto">
            <!-- Balance Card -->
            <div class="bg-white px-8 py-12 flex flex-col items-center border-b border-slate-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-primary/5 rounded-full -mr-24 -mt-24 blur-3xl"></div>
                
                <span class="text-slate-400 font-outfit font-black text-[11px] uppercase tracking-[0.2em] mb-4">Solde actuel disponible</span>
                <h2 class="text-[56px] font-outfit font-black text-slate-900 tracking-tighter leading-none mb-4">27 700 <span class="text-2xl font-bold uppercase ml-1 opacity-20">CFA</span></h2>
                
                <div class="inline-flex items-center gap-2 bg-green-50 text-green-600 px-4 py-1.5 rounded-xl border border-green-100">
                    <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
                    <p class="font-outfit font-black text-xs tracking-wide uppercase">+1 500 CFA aujourd'hui</p>
                </div>
                
                <button class="mt-12 w-full h-16 bg-primary text-white rounded-2xl font-outfit font-black text-[16px] uppercase tracking-widest shadow-xl shadow-blue-500/20 active:scale-95 transition-all" style="background-color: var(--primary);">
                    Demander un virement
                </button>
            </div>

            <!-- Transaction History -->
            <div class="mt-10 px-6">
                <h3 class="text-slate-400 font-outfit font-black text-[11px] uppercase tracking-[0.2em] ml-2 mb-6">HISTORIQUE DES MISSIONS</h3>
                
                <div class="space-y-4 mb-12">
                    <div class="bg-white p-6 rounded-3xl border border-slate-50 flex items-center justify-between shadow-sm group hover:border-primary/20 transition-all">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[17px] font-outfit font-extrabold text-slate-900 tracking-tight">Mission terminée</span>
                                <span class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-wider">Aujourd'hui · 01:45</span>
                            </div>
                        </div>
                        <span class="text-xl font-outfit font-black text-slate-900">+1 500</span>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-slate-50 flex items-center justify-between shadow-sm group hover:border-primary/20 transition-all">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[17px] font-outfit font-extrabold text-slate-900 tracking-tight">Mission terminée</span>
                                <span class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-wider">18 Mai · 23:10</span>
                            </div>
                        </div>
                        <span class="text-xl font-outfit font-black text-slate-900">+2 200</span>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-12 px-6 pb-12">
                <div class="bg-slate-900/5 backdrop-blur-sm p-6 rounded-3xl border border-slate-100 flex gap-4">
                    <svg class="w-6 h-6 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path></svg>
                    <p class="text-slate-500 text-xs leading-relaxed font-medium">
                        Les fonds sont transférés automatiquement vers votre compte partenaire chaque semaine. Les délais de traitement peuvent varier selon votre établissement bancaire.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-map-layout>
