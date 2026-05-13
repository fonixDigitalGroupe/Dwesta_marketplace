<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion du Point Relais') }} : {{ $currentRelais->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 uppercase">En attente de réception</p>
                    <p class="mt-2 text-3xl font-bold text-blue-600">{{ $incomingOrders->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 uppercase">En stock (A retirer)</p>
                    <p class="mt-2 text-3xl font-bold text-orange-600">{{ $stockOrders->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Livraisons (Mois)</p>
                    <p class="mt-2 text-3xl font-bold text-green-600">0</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Incoming Orders -->
                <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-800 uppercase text-xs">Arrivées attendues (Livreurs en route)</h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($incomingOrders as $order)
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-bold text-sm">#{{ $order->reference }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->buyer->name }}</p>
                                    </div>
                                    <form action="{{ route('orders.receive', $order) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-blue-700">Scanner Réception</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="p-8 text-center text-gray-400 text-sm italic">Aucun colis attendu pour le moment.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Stock Orders -->
                <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">
                    <div class="p-4 border-b border-gray-100 bg-orange-50/50">
                        <h3 class="font-bold text-orange-800 uppercase text-xs">Colis en stock (Prêts pour le client)</h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($stockOrders as $order)
                            <div class="p-4 hover:bg-gray-50 transition border-l-4 border-orange-400">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-bold text-sm">#{{ $order->reference }}</p>
                                        <p class="text-xs text-gray-500">Client : {{ $order->buyer->name }}</p>
                                        <p class="text-xs font-medium text-orange-600 mt-1">Code retrait requis</p>
                                    </div>
                                    <form action="{{ route('orders.deliver', $order) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-orange-600">Confirmer Remise</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="p-8 text-center text-gray-400 text-sm italic">Pas de colis en stock.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
