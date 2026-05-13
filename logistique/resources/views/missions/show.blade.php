<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border border-gray-100 shadow-sm">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                </a>
                <h1 class="text-2xl font-black text-gray-900">Détails Mission</h1>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block mb-1">Réf. commande</span>
                        <p class="text-xl font-black text-gray-900">{{ $order->reference }}</p>
                    </div>
                    <div class="px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-xs font-black">
                        {{ strtoupper($order->statut_label) }}
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Pickup -->
                    <div class="flex gap-4 relative">
                        <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-gray-100 dashed"></div>
                        <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-lg flex-shrink-0 flex items-center justify-center z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block mb-1">Point de retrait (Vendeur)</span>
                            <p class="font-bold text-gray-900">{{ $order->seller->nom_boutique }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $order->seller->user->adresse ?? 'Adresse non spécifiée' }}</p>
                        </div>
                    </div>

                    <!-- Delivery -->
                    <div class="flex gap-4">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex-shrink-0 flex items-center justify-center z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block mb-1">Destination (Client)</span>
                            <p class="font-bold text-gray-900">{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $order->adresse_livraison }}</p>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->adresse_livraison) }}" target="_blank" class="text-blue-600 text-[10px] font-black uppercase tracking-widest mt-3 block hover:underline">Ouvrir dans Maps →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="bg-gray-50 rounded-3xl p-6 mb-8">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Contenu du colis</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center bg-white p-3 rounded-2xl border border-gray-100">
                            <span class="text-sm font-bold text-gray-700">{{ $item->annonce->titre }}</span>
                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-lg text-[10px] font-black">x{{ $item->quantite }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Footer Actions -->
             <div class="fixed bottom-0 left-0 w-full p-6 bg-white border-t border-gray-100 z-50">
                @if($order->statut == Order::STATUT_EN_ROUTE)
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl transition active:scale-95">
                        Confirmer la livraison (Scan QR)
                    </button>
                @endif
             </div>
             <div class="h-24"></div>

        </div>
    </div>
</x-app-layout>
