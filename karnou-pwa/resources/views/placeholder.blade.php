@extends('partenaire::layouts.partenaire')

@section('title', $titre ?? 'Karnou Partenaire')

@section('content')
<div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:32px;background:#000;">
    <div style="width:72px;height:72px;border-radius:20px;background:rgba(0,74,173,.18);display:flex;align-items:center;justify-content:center;font-size:32px;margin-bottom:24px;">🚧</div>
    <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:10px;">{{ $titre ?? 'À venir' }}</h1>
    <p style="font-size:15px;color:#94A3B8;line-height:1.5;max-width:280px;">{{ $message ?? 'Cet écran sera disponible bientôt.' }}</p>

    <a href="{{ route('partenaire.entry') }}"
       style="margin-top:28px;background:var(--karnou-orange);color:#fff;text-decoration:none;padding:14px 28px;border-radius:999px;font-size:16px;font-weight:600;">
        Retour
    </a>
</div>
@endsection
