@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Espace Transporteur</h1>

    <!-- Action SCAN -->
    <div class="mb-8 p-6 bg-blue-50 border border-blue-200 rounded-lg flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-blue-800">Scanner un colis</h2>
            <p class="text-blue-600">Simulez le scan lors du ramassage chez le vendeur.</p>
        </div>
        <a href="{{ route('scan.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow">
            Ouvrir le Scanner
        </a>
    </div>

    <!-- Colis à Ramasser (PRET) -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 text-gray-700">📦 Colis prêts à être ramassés (Chez le Vendeur)</h2>
        @if($ordersPickup->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Référence</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Vendeur</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Adresse</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordersPickup as $order)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="font-bold">{{ $order->reference }}</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $order->seller->user->prenom }} {{ $order->seller->user->nom }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $order->seller->user->adresse }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <!-- Simulation Scan Rapide -->
                                <form action="{{ route('scan.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $order->tracking_token }}">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded text-xs">
                                        Scanner (Ramasser)
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 bg-white p-4 rounded shadow">Aucun colis en attente de ramassage.</p>
        @endif
    </div>

    <!-- Colis En Route -->
    <div>
        <h2 class="text-xl font-bold mb-4 text-gray-700">🚚 Colis en cours de livraison</h2>
        @if($ordersEnRoute->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Référence</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Destination</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordersEnRoute as $order)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="font-bold">{{ $order->reference }}</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $order->adresse_livraison }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">En Route</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 bg-white p-4 rounded shadow">Aucun colis en cours de transport.</p>
        @endif
    </div>
</div>
@endsection
