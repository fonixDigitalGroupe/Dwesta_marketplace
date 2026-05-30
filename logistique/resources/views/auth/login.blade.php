<x-guest-layout>
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-outfit font-black text-slate-800 tracking-tight mb-2">Bon retour !</h2>
        <p class="text-slate-500 font-medium">Connectez-vous à votre espace Transporteur</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse Email')" class="font-outfit font-bold text-slate-700 mb-1" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Mot de passe')" class="font-outfit font-bold text-slate-700" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-[#FF6B00] hover:text-[#E65A00] transition-colors" href="{{ route('password.request') }}">
                        {{ __('Oublié ?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-lg border-slate-200 text-[#FF6B00] focus:ring-[#FF6B00]/20 transition-all" name="remember">
            <span class="ms-3 text-sm text-slate-500 font-medium cursor-pointer" onclick="document.getElementById('remember_me').click()">{{ __('Rester connecté') }}</span>
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-2">
            <p class="text-sm text-slate-500 font-medium">
                Pas encore de compte ? 
                <a href="{{ route('register') }}" class="text-[#FF6B00] font-bold hover:underline">S'inscrire</a>
            </p>
        </div>
    </form>
</x-guest-layout>
