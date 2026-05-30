<x-guest-layout>
    <div class="mb-10 text-center">
        <h2 class="text-[28px] font-black text-slate-900 tracking-tighter leading-tight">Vérification</h2>
        <p class="text-[14px] text-slate-500 mt-2 leading-relaxed px-4">Entrez le code envoyé à <br><span class="font-bold text-slate-900">{{ $contact }}</span></p>
    </div>

    <form method="POST" action="{{ route('register.otp.verify') }}" class="flex-1 flex flex-col m-0">
        @csrf

        <!-- OTP Input -->
        <div class="flex-1">
            <div class="flex justify-center mt-2 px-4">
                <input id="otp" name="otp" type="text" maxlength="4" autofocus
                    class="block w-full text-center text-[42px] font-black tracking-[0.5em] py-6 rounded-[28px] border-none bg-slate-50 focus:ring-2 focus:ring-blue-600 transition-all placeholder-slate-200" 
                    placeholder="0000" required>
            </div>
            @if($errors->has('otp'))
                <p class="text-red-500 text-[13px] font-bold mt-4 text-center">{{ $errors->first('otp') }}</p>
            @endif
        </div>

        <div class="mt-auto pt-10">
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-5 rounded-[22px] shadow-xl shadow-blue-500/20 transition active:scale-[0.98] text-[16px]">
                Vérifier le code
            </button>
            
            <div class="mt-8 text-center">
                <p class="text-[14px] text-slate-500">
                    Pas reçu ? 
                    <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:underline ml-1">Renvoyer</a>
                </p>
            </div>
        </div>
    </form>
</x-guest-layout>
