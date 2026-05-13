<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Agency Header -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-6 text-center md:text-left">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-[1.5rem] flex items-center justify-center shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-900">{{ $currentAgency->nom }}</h1>
                        <p class="text-slate-500 font-medium">{{ $currentAgency->adresse }}, {{ $currentAgency->region }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                     <span class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider">Point Relais Actif</span>
                </div>
            </div>

            <!-- Action Panels -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Reception Panel -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 group hover:border-emerald-200 transition-all duration-300">
                    <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16l-4-4m0 0l4-4m-4 4h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </span>
                        Réception de colis
                    </h2>
                    <form action="{{ route('packages.receive') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="relative">
                            <input type="text" name="reference" placeholder="Saisir ou scanner la référence..." class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-12 focus:ring-2 focus:ring-emerald-500 transition-all font-bold">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-200 transition active:scale-95">
                            Confirmer l'arrivée
                        </button>
                    </form>
                    <p class="mt-4 text-xs text-slate-400 font-medium text-center">Marque le colis comme arrivé au point relais et prêt pour retrait.</p>
                </div>

                <!-- Release Panel -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 group hover:border-blue-200 transition-all duration-300">
                    <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </span>
                        Remise au client
                    </h2>
                    <form action="{{ route('packages.release') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="relative">
                            <input type="text" name="reference" placeholder="Code retrait ou référence..." class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-12 focus:ring-2 focus:ring-blue-500 transition-all font-bold">
                            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-200 transition active:scale-95">
                            Confirmer la remise
                        </button>
                    </form>
                    <p class="mt-4 text-xs text-slate-400 font-medium text-center">Finalise la mission et marque la commande comme livrée.</p>
                </div>
            </div>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Expected Packages -->
                <div>
                     <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 px-4">Colis en approche ({{ $expectedPackages->count() }})</h3>
                     <div class="space-y-4">
                        @forelse($expectedPackages as $pkg)
                            <div class="bg-white p-6 rounded-3xl border border-slate-50 shadow-sm flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center">
                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900">{{ $pkg->reference }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">Par : {{ $pkg->transporteur->user->name ?? 'Livreur Pro' }}</p>
                                    </div>
                                </div>
                                <span class="bg-amber-50 text-amber-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider italic">En route</span>
                            </div>
                        @empty
                            <div class="bg-slate-50 rounded-3xl p-10 text-center border-2 border-dashed border-slate-100">
                                 <p class="text-slate-400 font-bold text-sm">Aucun colis en approche</p>
                            </div>
                        @endforelse
                     </div>
                </div>

                <!-- In Stock Packages -->
                <div>
                     <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 px-4">Colis en stock ({{ $inStockPackages->count() }})</h3>
                     <div class="space-y-4">
                        @forelse($inStockPackages as $pkg)
                             <div class="bg-white p-6 rounded-3xl border border-slate-50 shadow-sm flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900">{{ $pkg->reference }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">Client : {{ $pkg->buyer->name }}</p>
                                    </div>
                                </div>
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider italic">Prêt pour retrait</span>
                            </div>
                        @empty
                            <div class="bg-slate-50 rounded-3xl p-10 text-center border-2 border-dashed border-slate-100">
                                 <p class="text-slate-400 font-bold text-sm">Votre stock est vide</p>
                            </div>
                        @endforelse
                     </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
