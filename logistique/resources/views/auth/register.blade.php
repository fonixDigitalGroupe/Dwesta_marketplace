<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-gray-900">Rejoignez l'équipe</h2>
        <p class="text-sm text-gray-500 mt-2">Saisissez votre email ou téléphone pour commencer.</p>
    </div>

    <form method="POST" action="{{ route('register.step1') }}">
        @csrf

        <!-- Contact Field -->
        <div>
            <x-input-label for="contact" :value="__('Email ou Numéro de téléphone')" />
            <x-text-input id="contact" class="block mt-1 w-full" type="text" name="contact" :value="old('contact')" required autofocus placeholder="ex: livreur@karnou.com ou 77..." />
            <x-input-error :messages="$errors->get('contact')" class="mt-2" />
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center py-3 text-lg">
                {{ __('Continuer') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Déjà inscrit ? Connectez-vous') }}
            </a>
        </div>
    </form>
</x-guest-layout>
