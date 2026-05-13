<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-gray-100 shadow-sm">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </a>
                <h1 class="text-2xl font-black text-gray-900">Missions Disponibles</h1>
            </div>

            <div class="space-y-4">
                @forelse($missions as $mission)
                    <div class="bg-white rounded-3XL shadow-sm border border-gray-100 p-6 relative overflow-hidden flex flex-col gap-4">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Zone de livraison</span>
                                    <p class="font-black text-gray-900">{{ Str::limit($mission->adresse_livraison, 30) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Gains</span>
                                <p class="text-lg font-black text-blue-600">{{ $mission->frais_port ?? '1500' }} FCFA</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 py-3 border-y border-gray-50">
                            <div class="flex-1">
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Vendeur</span>
                                <p class="text-sm font-bold text-gray-700">{{ $mission->seller->nom_boutique ?? 'Karnou Partner' }}</p>
                            </div>
                            <div class="flex-1 text-right">
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">Colis</span>
                                <p class="text-sm font-bold text-gray-700">{{ $mission->total_produits }} article(s)</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-2">
                             <span class="text-xs text-gray-500 font-medium italic">Paru il y a {{ $mission->created_at->diffForHumans() }}</span>
                             <form action="{{ route('missions.accept', $mission) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-6 py-3 rounded-2xl shadow-lg transition active:scale-95">
                                    Accepter la mission
                                </button>
                             </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl border-2 border-dashed border-gray-100 p-20 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <p class="text-gray-400 font-bold">Aucune mission disponible pour le moment.</p>
                        <p class="text-gray-300 text-xs mt-2">Revenez plus tard ou rafraîchissez la page.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
