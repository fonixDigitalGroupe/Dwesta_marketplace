<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Litiges & Anomalies</h2>
                    
                    <div class="flex gap-4 mb-8">
                        <div class="bg-red-50 p-4 rounded-lg flex-1 border border-red-100">
                            <h3 class="text-red-700 font-semibold mb-1">En attente</h3>
                            <p class="text-3xl font-bold text-red-800">2</p>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg flex-1 border border-orange-100">
                            <h3 class="text-orange-700 font-semibold mb-1">En cours</h3>
                            <p class="text-3xl font-bold text-orange-800">5</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg flex-1 border border-green-100">
                            <h3 class="text-green-700 font-semibold mb-1">Résolus (30j)</h3>
                            <p class="text-3xl font-bold text-green-800">12</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="p-4 border-b">ID Litige</th>
                                    <th class="p-4 border-b">Colis</th>
                                    <th class="p-4 border-b">Motif</th>
                                    <th class="p-4 border-b">Date</th>
                                    <th class="p-4 border-b">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-4 border-b italic text-gray-500" colspan="5">Aucun litige urgent en cours.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
