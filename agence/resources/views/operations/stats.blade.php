<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Statistiques & Performance</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="p-6 border rounded-xl">
                            <h3 class="font-bold mb-4 text-gray-700">Volume de colis (7 derniers jours)</h3>
                            <div class="h-40 bg-gray-50 flex items-end justify-between p-4 gap-2">
                                <div class="bg-blue-400 w-full" style="height: 40%"></div>
                                <div class="bg-blue-400 w-full" style="height: 60%"></div>
                                <div class="bg-blue-400 w-full" style="height: 35%"></div>
                                <div class="bg-blue-400 w-full" style="height: 45%"></div>
                                <div class="bg-blue-400 w-full" style="height: 80%"></div>
                                <div class="bg-blue-400 w-full" style="height: 55%"></div>
                                <div class="bg-blue-600 w-full" style="height: 90%"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-gray-400 mt-2 uppercase">
                                <span>Lun</span><span>Mar</span><span>Mer</span><span>Jeu</span><span>Ven</span><span>Sam</span><span>Dim</span>
                            </div>
                        </div>

                        <div class="p-6 border rounded-xl">
                            <h3 class="font-bold mb-4 text-gray-700">Temps moyen de garde (heures)</h3>
                            <div class="flex items-center justify-center h-40">
                                <div class="text-center">
                                    <p class="text-5xl font-black text-blue-600">18.5</p>
                                    <p class="text-sm text-gray-500 font-medium mt-1">Heures en moyenne</p>
                                    <p class="text-xs text-green-600 mt-2"><i class="fas fa-caret-down"></i> -12% vs mois dernier</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
