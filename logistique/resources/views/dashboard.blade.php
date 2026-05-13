<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-black text-gray-900">Bonjour, {{ Auth::user()->prenom }} !</h1>
                    <p class="text-sm text-gray-500">Prêt pour vos prochaines missions ?</p>
                </div>
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                    {{ substr(Auth::user()->prenom, 0, 1) }}
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 italic">
                    <span class="block text-xs text-gray-400 uppercase font-black tracking-widest mb-1">En cours</span>
                    <span class="text-2xl font-black text-blue-600">{{ $activeDeliveries->count() }}</span>
                </div>
                <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 italic">
                    <span class="block text-xs text-gray-400 uppercase font-black tracking-widest mb-1">Terminées</span>
                    <span class="text-2xl font-black text-green-600">{{ $completedDeliveries->count() }}</span>
                </div>
            </div>

            <!-- Quick Action: Browse Missions -->
            <a href="{{ route('missions.available') }}" class="block bg-orange-500 hover:bg-orange-600 text-white p-6 rounded-3xl shadow-xl mb-10 transition transform active:scale-95 group">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-black mb-1">Nouvelles Missions</h2>
                        <p class="text-sm opacity-90">Consulter les colis disponibles pour livraison.</p>
                    </div>
                    <div class="bg-white/20 p-2 rounded-xl group-hover:translate-x-1 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </div>
                </div>
            </a>

            <!-- Active Deliveries -->
            <div class="mb-8">
                <h3 class="text-lg font-black text-gray-900 mb-4 px-1">Missions en cours</h3>
                
                @forelse($activeDeliveries as $delivery)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 mb-4 relative overflow-hidden">
                        <div class="absolute right-0 top-0 bg-blue-50 text-blue-600 text-[10px] font-black px-3 py-1 rounded-bl-xl">EN ROUTE</div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Référence : {{ $delivery->reference }}</span>
                                <h4 class="font-bold text-gray-900 text-sm mb-2 line-clamp-1">{{ $delivery->adresse_livraison }}</h4>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                                    <span class="text-xs text-gray-500 font-semibold">{{ $delivery->total_final }} FCFA</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <a href="{{ route('missions.show', $delivery) }}" class="bg-gray-50 text-gray-700 text-center py-2 rounded-xl text-xs font-bold hover:bg-gray-100">Détails</a>
                            <a href="#" class="bg-blue-600 text-white text-center py-2 rounded-xl text-xs font-bold hover:bg-blue-700">Scanner</a>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-10 text-center">
                        <div class="text-gray-300 mb-2 font-bold tracking-widest uppercase text-xs">Aucune mission active</div>
                        <p class="text-gray-400 text-xs">Les colis que vous acceptez apparaîtront ici.</p>
                    </div>
                @endforelse
            </div>

            <!-- Recent Activity -->
            <div>
                <h3 class="text-lg font-black text-gray-900 mb-4 px-1">Dernières livraisons</h3>
                <div class="space-y-4">
                    @foreach($completedDeliveries as $delivery)
                        <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-50">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-50 text-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-900">{{ $delivery->reference }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $delivery->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-black text-green-600">+ {{ $delivery->total_final }} FCFA</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
