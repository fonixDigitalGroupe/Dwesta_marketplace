@extends('partenaire::layouts.partenaire')

@section('title', 'Karnou Partenaire')
@section('theme-color', '#000000')

@push('styles')
<style>
    .splash {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #000;
        text-align: center;
    }
    .splash-logo {
        opacity: 0;
        transform: scale(.95);
        animation: splashIn 1s cubic-bezier(.2, .8, .2, 1) forwards;
    }
    @keyframes splashIn {
        to { opacity: 1; transform: scale(1); }
    }
    .splash-title {
        font-size: 56px; font-weight: 900; color: var(--karnou-blue);
        letter-spacing: -1px; line-height: 1;
    }
    .splash-badge {
        display: inline-block; background: var(--karnou-blue); color: #000;
        font-size: 14px; font-weight: 900; padding: 2px 12px; border-radius: 4px;
        margin-top: -6px;
    }
    .splash-sub {
        margin-top: 14px; font-size: 12px; font-weight: 700;
        letter-spacing: 4px; color: #94A3B8;
    }
    .splash-footer {
        position: absolute; bottom: calc(40px + var(--sab));
        color: #94A3B8; opacity: .6; font-size: 13px; font-weight: 600;
    }
    .splash-spinner {
        position: absolute; bottom: calc(90px + var(--sab));
        width: 26px; height: 26px; border-radius: 50%;
        border: 3px solid rgba(255,255,255,.15);
        border-top-color: var(--karnou-orange);
        animation: spin .8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="splash">
    <div class="splash-logo">
        <div class="splash-title">KARNOU</div>
        <div class="splash-badge">PRO</div>
        <div class="splash-sub">LOGISTIQUE</div>
    </div>

    <div class="splash-spinner"></div>
    <div class="splash-footer">Partenaire Officiel Karnou</div>
</div>
@endsection

@push('scripts')
<script>
    // Avance automatique après l'animation (équivalent du setTimeout natif).
    setTimeout(function () {
        window.location.replace(@json($next));
    }, 2600);
</script>
@endpush
