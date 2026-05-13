<x-guest-layout>
    <div class="py-12 px-4 text-center">
        <div class="w-24 h-24 bg-orange-50 text-orange-600 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
        <h1 class="text-3xl font-black text-gray-900 mb-4">Profil non identifié</h1>
        <p class="text-gray-500 mb-10 max-w-sm mx-auto leading-relaxed">Désolé, votre compte n'est pas encore associé à un profil de livreur vérifié. Veuillez vous inscrire ou contacter l'administration.</p>
        
        <div class="space-y-4">
            <a href="{{ route('register') }}" class="block bg-blue-600 hover:bg-blue-700 text-white font-black py-4 px-10 rounded-2xl shadow-xl transition active:scale-95">
                Devenir Livreur
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 font-bold hover:text-gray-600 transition">Se déconnecter</button>
            </form>
        </div>
    </div>
</x-guest-layout>
