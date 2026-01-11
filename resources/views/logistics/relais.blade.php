@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Espace Point Relais</h1>

    <!-- Action SCAN -->
    <div class="mb-8 p-6 bg-purple-50 border border-purple-200 rounded-lg flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-purple-800">Scanner un arrivage ou un retrait</h2>
            <p class="text-purple-600">Scannez un colis qui arrive ou le QR du client qui retire.</p>
        </div>
        <a href="{{ route('scan.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow">
            Ouvrir le Scanner
        </a>
    </div>

    <!-- Colis Arrivants (EN ROUTE) -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 text-gray-700">🚚 Colis en approche (À réceptionner)</h2>
        @if($ordersIncoming->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Référence</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordersIncoming as $order)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="font-bold">{{ $order->reference }}</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $order->buyer->prenom }} {{ $order->buyer->nom }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <!-- Simulation Scan Reception -->
                                <form action="{{ route('scan.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $order->tracking_token }}">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-xs">
                                        Scanner (Réceptionner)
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 bg-white p-4 rounded shadow">Aucun colis en approche.</p>
        @endif
    </div>

    <!-- Colis en Stock (DISPONIBLE) -->
    <div>
        <h2 class="text-xl font-bold mb-4 text-gray-700">📦 Colis en stock (Attente Client)</h2>
        @if($ordersInStock->count() > 0)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Référence</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Client</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">QR Client</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordersInStock as $order)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="font-bold">{{ $order->reference }}</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ $order->buyer->prenom }} {{ $order->buyer->nom }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-mono text-xs">
                                {{ $order->qr_code_token ?? 'N/A' }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <!-- Simulation Scan Retrait -->
                                <form action="{{ route('scan.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $order->qr_code_token }}">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded text-xs">
                                        Scanner (Remettre au Client)
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 bg-white p-4 rounded shadow">Aucun colis en stock.</p>
        @endif
    </div>
</div>
@endsection
