@extends('partenaire::layouts.partenaire')

@section('title', 'Connexion — Karnou Partenaire')

@section('content')
<div class="pt-screen">
    <div class="pt-header">
        <a href="{{ route('partenaire.entry') }}" class="pt-back" aria-label="Retour">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div class="pt-progress"><i style="width:25%"></i></div>
    </div>

    <form method="POST" action="{{ route('partenaire.otp.send') }}" class="pt-screen" style="padding:0;">
        @csrf
        <div class="pt-body">
            <h1 class="pt-title">Quel est votre numéro&nbsp;?</h1>
            <p class="pt-subtitle">Saisissez votre numéro pour rejoindre le réseau logistique Karnou.</p>

            @if ($errors->any())
                <div class="pt-alert" style="margin-top:18px;">{{ $errors->first() }}</div>
            @endif

            <div class="pt-phone-row" style="margin-top:24px;">
                <label class="pt-country">
                    <select name="phone_code">
                        @foreach ($pays as $p)
                            <option value="{{ $p['phoneCode'] }}" {{ old('phone_code', '+221') === $p['phoneCode'] ? 'selected' : '' }}>
                                {{ $p['flag'] }} {{ $p['phoneCode'] }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <div class="pt-card" style="flex:1;display:flex;align-items:center;">
                    <div class="pt-field" style="flex:1;">
                        <input class="pt-input" type="tel" inputmode="numeric" name="phone"
                               value="{{ old('phone') }}" placeholder="00 000 00 00"
                               autocomplete="tel-national" autofocus required>
                    </div>
                </div>
            </div>

            <p class="pt-muted" style="margin-top:16px;">
                Un code de vérification à 4 chiffres vous sera envoyé par SMS.
            </p>
        </div>

        <div class="pt-footer">
            <button type="submit" class="pt-btn">Continuer</button>
        </div>
    </form>
</div>
@endsection
