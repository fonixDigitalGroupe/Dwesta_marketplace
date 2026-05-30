<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-outfit font-black text-slate-800 tracking-tight mb-2">Récupération</h2>
        <p class="text-slate-500 font-medium">Lien de réinitialisation sécurisé</p>
    </div>

    <div class="mb-6 text-sm text-slate-500 font-medium leading-relaxed">
        {{ __('Oublié votre mot de passe ? Pas de problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-outfit font-bold text-slate-700 mb-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Envoyer le lien') }}
            </x-primary-button>
        </div>
        
        <div class="text-center pt-2">
            <a href="{{ route('login') }}" class="text-sm font-bold text-[#FF6B00] hover:underline">
                {{ __('Retour à la connexion') }}
            </a>
        </div>
    </form>
</x-guest-layout>
