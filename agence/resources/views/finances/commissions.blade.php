<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Commissions & Gains</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                            <h3 class="text-blue-800 font-medium text-sm uppercase tracking-wider">Gains ce mois</h3>
                            <p class="text-3xl font-extrabold text-blue-900 mt-2">15,400 FCFA</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-xl border border-green-100">
                            <h3 class="text-green-800 font-medium text-sm uppercase tracking-wider">Portefeuille disponible</h3>
                            <p class="text-3xl font-extrabold text-green-900 mt-2">42,850 FCFA</p>
                            <button class="mt-4 text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Demander un retrait</button>
                        </div>
                        <div class="bg-purple-50 p-6 rounded-xl border border-purple-100">
                            <h3 class="text-purple-800 font-medium text-sm uppercase tracking-wider">Total cumulé</h3>
                            <p class="text-3xl font-extrabold text-purple-900 mt-2">128,000 FCFA</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Détail des commissions récentes</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-xs uppercase text-gray-500">
                                    <th class="p-4 border-b">Date</th>
                                    <th class="p-4 border-b">Type d'opération</th>
                                    <th class="p-4 border-b">Package</th>
                                    <th class="p-4 border-b text-right">Commission</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-sm">
                                    <td class="p-4 border-b">13 Mai 2026, 14:20</td>
                                    <td class="p-4 border-b">Réception Colis</td>
                                    <td class="p-4 border-b">#PKG-992</td>
                                    <td class="p-4 border-b text-right font-bold text-green-600">+250 FCFA</td>
                                </tr>
                                <tr class="text-sm">
                                    <td class="p-4 border-b">13 Mai 2026, 10:15</td>
                                    <td class="p-4 border-b">Remise Client</td>
                                    <td class="p-4 border-b">#PKG-841</td>
                                    <td class="p-4 border-b text-right font-bold text-green-600">+500 FCFA</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
