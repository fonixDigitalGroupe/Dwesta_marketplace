<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Journal d'Activité</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-4 border-l-4 border-blue-500 bg-blue-50 rounded-r-lg">
                            <div class="bg-blue-100 p-2 rounded-full text-blue-600">
                                <i class="fas fa-barcode"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold">Réception de colis</p>
                                <p class="text-xs text-gray-600">Le colis #PKG-992 a été scanné et mis en stock par Jean Relais.</p>
                                <p class="text-[10px] text-gray-400 mt-1">Aujourd'hui, 14:20</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 border-l-4 border-green-500 bg-green-50 rounded-r-lg">
                            <div class="bg-green-100 p-2 rounded-full text-green-600">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold">Livraison client</p>
                                <p class="text-xs text-gray-600">Le colis #PKG-841 a été remis au client Moussa Diop.</p>
                                <p class="text-[10px] text-gray-400 mt-1">Aujourd'hui, 10:15</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
