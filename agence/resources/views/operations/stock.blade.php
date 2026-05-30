<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Inventaire du Stock Local</h2>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-plus mr-2"></i> Ajouter un colis
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="p-4 border-b">Référence</th>
                                    <th class="p-4 border-b">Client</th>
                                    <th class="p-4 border-b">Date Réception</th>
                                    <th class="p-4 border-b">Status</th>
                                    <th class="p-4 border-b">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 border-b">#PKG-2024-001</td>
                                    <td class="p-4 border-b">Moussa Diop</td>
                                    <td class="p-4 border-b">13 Mai 2026</td>
                                    <td class="p-4 border-b"><span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">En Stock</span></td>
                                    <td class="p-4 border-b">
                                        <button class="text-blue-600 hover:underline">Gérer</button>
                                    </td>
                                </tr>
                                <!-- More items would go here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
