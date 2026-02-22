@extends('layouts.app')

@section('title', 'Détails du Litige #' . $litige->id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Litige #{{ $litige->id }}</h1>
            <p class="text-gray-500">Ouvert le {{ $litige->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <a href="{{ route('admin.litiges.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Retour à la liste</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Description du problème</h2>
                <div class="mb-4">
                    <span class="text-sm font-semibold text-gray-500 uppercase">Motif</span>
                    <div class="mt-1 px-3 py-1 bg-gray-100 rounded inline-block text-gray-800">{{ ucfirst($litige->motif) }}</div>
                </div>
                <div>
                    <span class="text-sm font-semibold text-gray-500 uppercase">Description</span>
                    <div class="mt-2 p-4 bg-gray-50 rounded text-gray-800 border">
                        {{ $litige->description }}
                    </div>
                </div>
            </div>

            @if($litige->order)
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Commande associée</h2>
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-500 uppercase">Référence</div>
                        <div class="font-mono font-bold">#{{ $litige->order->reference }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-500 uppercase">Montant Total</div>
                        <div class="font-bold text-red-600">{{ number_format($litige->order->total, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-500 uppercase">Statut Commande</div>
                        <div class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-bold">{{ strtoupper($litige->order->statut) }}</div>
                    </div>
                </div>
                
                <h3 class="font-semibold text-sm text-gray-600 mb-2">Articles de la commande :</h3>
                <div class="space-y-2">
                    @foreach($litige->order->items as $item)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded border">
                            <div class="flex items-center">
                                <span class="text-xs font-bold bg-gray-200 px-2 py-1 rounded mr-3">x{{ $item->quantite }}</span>
                                <span class="text-sm">{{ $item->annonce->titre }}</span>
                            </div>
                            <span class="text-sm font-semibold">{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t text-right">
                    <a href="#" class="text-blue-600 text-sm font-bold hover:underline">Voir les détails de la commande →</a>
                </div>
            </div>
            @endif

            @if($litige->statut == 'en_cours')
            <!-- Résolution Form -->
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500">
                <h2 class="text-lg font-bold mb-4">Résoudre le litige</h2>
                <form action="{{ route('admin.litiges.resolve', $litige) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Décision / Solution</label>
                        <textarea name="resolution" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Expliquez la résolution (remboursement, rejet, etc...)" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau Statut</label>
                        <select name="statut" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="resolu">Résolu (Favorable au client)</option>
                            <option value="ferme">Fermé (Sans suite / Favorable au vendeur)</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Enregistrer la décision</button>
                </form>
            </div>
            @else
            <!-- Décision affichée -->
            <div class="bg-green-50 shadow rounded-lg p-6 border border-green-200">
                <h2 class="text-lg font-bold mb-2 text-green-800">Litige {{ ucfirst($litige->statut) }}</h2>
                <p class="text-gray-700 font-semibold">Décision :</p>
                <p class="text-gray-600 mt-1">{{ $litige->resolution }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar Parties Prenantes -->
        <div class="space-y-6">
            <!-- Reporter -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Signalé par</h3>
                <div class="flex items-center">
                    <img src="{{ $litige->reporter->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($litige->reporter->name) }}" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <div class="font-bold">{{ $litige->reporter->name }}</div>
                        <div class="text-sm text-gray-500">{{ $litige->reporter->email }}</div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <a href="#" class="text-blue-600 text-sm hover:underline">Voir profil complet</a>
                </div>
            </div>

            <!-- Reported -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Contre</h3>
                <div class="flex items-center">
                    <img src="{{ $litige->reported->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($litige->reported->name) }}" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <div class="font-bold">{{ $litige->reported->name }}</div>
                        <div class="text-sm text-gray-500">{{ $litige->reported->email }}</div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t">
                    <a href="#" class="text-blue-600 text-sm hover:underline">Voir profil complet</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
