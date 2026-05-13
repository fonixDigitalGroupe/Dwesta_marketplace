<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl p-12 text-center border border-gray-100">
                <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-gray-900 mb-4">Aucun Point Relais assigné</h1>
                <p class="text-lg text-gray-500 max-w-xl mx-auto mb-10">
                    Votre compte n'est pas encore associé à un point relais actif sur la plateforme Karnou. Veuillez contacter l'administration pour activer votre agence.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="mailto:support@karnou.com" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:bg-blue-700 transition">
                        Contacter le Support
                    </a>
                    <a href="{{ config('app.main_url', 'http://0.0.0.0:8000') }}" class="inline-block bg-gray-100 text-gray-700 font-bold py-3 px-8 rounded-xl hover:bg-gray-200 transition">
                        Retourner au site principal
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
