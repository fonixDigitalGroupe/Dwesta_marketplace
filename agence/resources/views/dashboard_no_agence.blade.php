<x-guest-layout>
    <div class="py-12 px-4 text-center">
        <div class="w-24 h-24 bg-emerald-50 text-emerald-600 rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
        <h1 class="text-3xl font-black text-slate-900 mb-4">Accès Agence Requis</h1>
        <p class="text-slate-500 mb-10 max-w-sm mx-auto leading-relaxed">Votre compte n'est actuellement associé à aucun point relais partenaire Karnou. Si vous gérez une agence, veuillez contacter l'administration pour l'activation.</p>
        
        <div class="space-y-4">
            <a href="mailto:partenaires@karnou.com" class="block bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 px-10 rounded-2xl shadow-xl transition active:scale-95">
                Contacter le support
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-slate-400 font-bold hover:text-slate-600 transition">Se déconnecter</button>
            </form>
        </div>
    </div>
</x-guest-layout>
