<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="bg-white border border-slate-200 p-12 text-center rounded-xl shadow-sm">
                <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-desktop text-3xl"></i>
                </div>
                <h1 class="text-3xl font-black text-slate-900 mb-4">Bienvenue sur votre Terminal Agence</h1>
                <p class="text-slate-500 max-w-lg mx-auto leading-relaxed">
                    Votre terminal est prêt. Les fonctionnalités de gestion des colis, inventaire et finances seront bientôt disponibles dans cette nouvelle interface simplifiée.
                </p>
                <div class="mt-10 flex justify-center gap-4">
                    <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-slate-900 text-white font-black text-xs uppercase tracking-widest hover:bg-black transition rounded">
                        Configurer mon agence
                    </a>
                    <a href="/" class="px-6 py-3 border border-slate-200 text-slate-600 font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition rounded">
                        Retour au site
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
