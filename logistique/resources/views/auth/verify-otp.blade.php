<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </div>
        <h2 class="text-2xl font-black text-gray-900">Vérification OTP</h2>
        <p class="text-sm text-gray-500 mt-2">Un code de vérification a été envoyé à <br><span class="font-bold text-gray-900">{{ $contact }}</span></p>
    </div>

    <form method="POST" action="{{ route('register.otp.verify') }}">
        @csrf

        <!-- OTP Input -->
        <div>
            <x-input-label for="otp" :value="__('Code de validation (4 chiffres)')" />
            <div class="flex justify-between gap-2 mt-2">
                <input id="otp" name="otp" type="text" maxlength="4" class="block w-full text-center text-3xl font-black tracking-[1em] py-4 rounded-2xl border-gray-200 focus:border-blue-500 focus:ring-blue-500" placeholder="0000" required autofocus>
            </div>
            <x-input-error :messages="$errors->get('otp')" class="mt-2 text-center" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-4 text-lg bg-blue-600 hover:bg-blue-700">
                {{ __('Vérifier le code') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Vous n'avez pas reçu le code ? 
                <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline">Renvoyer</a>
            </p>
        </div>
    </form>
</x-guest-layout>
