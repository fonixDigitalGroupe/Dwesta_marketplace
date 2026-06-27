@extends('partenaire::layouts.partenaire')

@section('title', 'Vérification — Karnou Partenaire')

@section('content')
<div class="pt-screen" x-data="otpForm()">
    <div class="pt-header">
        <a href="{{ route('partenaire.login') }}" class="pt-back" aria-label="Retour">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div class="pt-progress"><i style="width:50%"></i></div>
    </div>

    <form method="POST" action="{{ route('partenaire.otp.verify') }}" class="pt-screen" style="padding:0;">
        @csrf
        <div class="pt-body">
            <h1 class="pt-title">Vérification</h1>
            <p class="pt-subtitle">Saisissez le code à 4 chiffres envoyé au <strong style="color:#fff">{{ $phone }}</strong>.</p>

            @if (session('dev_otp'))
                <div class="pt-note" style="margin-top:18px;">Code de test (local) : <strong>{{ session('dev_otp') }}</strong></div>
            @endif
            @if ($errors->any())
                <div class="pt-alert" style="margin-top:18px;">{{ $errors->first() }}</div>
            @endif

            <div class="pt-otp">
                @for ($i = 0; $i < 4; $i++)
                    <input type="tel" inputmode="numeric" maxlength="1" name="otp[]"
                           x-ref="d{{ $i }}"
                           @input="onInput($event, {{ $i }})"
                           @keydown.backspace="onBackspace($event, {{ $i }})"
                           {{ $i === 0 ? 'autofocus' : '' }}>
                @endfor
            </div>

            <p class="pt-muted" style="text-align:center;margin-top:26px;">
                <template x-if="timer > 0">
                    <span>Renvoyer le code dans <span x-text="timer"></span> s</span>
                </template>
                <template x-if="timer === 0">
                    <span>Vous n'avez rien reçu&nbsp;?</span>
                </template>
            </p>
            <div style="text-align:center;margin-top:6px;">
                <button type="button" class="pt-link" :disabled="timer > 0"
                        :style="timer > 0 ? 'opacity:.4;cursor:default' : ''"
                        @click="$refs.resend.submit()">Renvoyer le code</button>
            </div>
        </div>

        <div class="pt-footer">
            <button type="submit" class="pt-btn">Vérifier</button>
        </div>
    </form>

    {{-- Formulaire caché pour le renvoi --}}
    <form method="POST" action="{{ route('partenaire.otp.resend') }}" x-ref="resend" hidden>@csrf</form>
</div>

@push('scripts')
<script>
    function otpForm() {
        return {
            timer: 59,
            init() {
                const tick = () => { if (this.timer > 0) { this.timer--; setTimeout(tick, 1000); } };
                setTimeout(tick, 1000);
            },
            onInput(e, i) {
                const v = e.target.value.replace(/\D/g, '');
                e.target.value = v.slice(-1);
                if (e.target.value && i < 3) this.$refs['d' + (i + 1)].focus();
            },
            onBackspace(e, i) {
                if (!e.target.value && i > 0) this.$refs['d' + (i - 1)].focus();
            },
        };
    }
</script>
@endpush
@endsection
