@extends('partenaire::layouts.partenaire')

@section('title', 'Mes gains — Karnou Partenaire')

@push('styles')
<style>
    .gn-head { display: flex; align-items: center; justify-content: space-between; padding: calc(14px + var(--sat)) 20px 0; }
    .gn-head b { color: #fff; font-weight: 800; font-size: 17px; }
    .gn-body { flex: 1; overflow-y: auto; padding: 20px 20px calc(24px + var(--sab)); }
    .gn-balance { text-align: center; margin-bottom: 34px; }
    .gn-label { color: #94A3B8; font-size: 12px; font-weight: 900; letter-spacing: 1.5px; }
    .gn-value { color: #fff; font-size: 52px; font-weight: 900; margin-top: 8px; }
    .gn-value span { font-size: 22px; color: #64748B; }
    .gn-trend { display: inline-flex; align-items: center; gap: 6px; margin-top: 12px; background: rgba(0,74,173,.16); color: #7eb3ff; padding: 6px 14px; border-radius: 999px; font-size: 13px; font-weight: 700; }
    .gn-payout { width: 100%; margin-top: 22px; height: 58px; background: var(--karnou-orange); color: #fff; border: 0; border-radius: 16px; font-size: 16px; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; font-family: inherit; }
    .gn-payout:disabled { opacity: .5; cursor: not-allowed; }
    .gn-hint { text-align: center; color: #64748B; font-size: 12px; margin-top: 10px; }
    .gn-sec { color: #64748B; font-size: 12px; font-weight: 900; letter-spacing: 1.5px; margin: 8px 0 12px; }
    .gn-tx { display: flex; align-items: center; gap: 14px; padding: 14px; background: #121212; border: 1px solid rgba(255,255,255,.06); border-radius: 16px; margin-bottom: 10px; }
    .gn-tx .ic { width: 40px; height: 40px; border-radius: 12px; background: rgba(0,74,173,.16); color: #7eb3ff; display: flex; align-items: center; justify-content: center; font-size: 18px; flex: none; }
    .gn-tx .info { flex: 1; }
    .gn-tx .info b { color: #fff; font-size: 15px; font-weight: 600; }
    .gn-tx .info small { display: block; color: #64748B; font-size: 12px; }
    .gn-tx .amt { color: #22C55E; font-weight: 800; font-size: 15px; }
    .gn-empty { text-align: center; color: #64748B; padding: 40px 0; }
</style>
@endpush

@section('content')
<div class="pt-screen">
    <div class="gn-head">
        <a href="{{ route('partenaire.home') }}" class="pt-back" aria-label="Fermer">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </a>
        <b>Mes gains</b>
        <div style="width:44px"></div>
    </div>

    <div class="gn-body">
        <div class="gn-balance">
            <div class="gn-label">TOTAL DES COMMISSIONS</div>
            <div class="gn-value">{{ number_format($soldeTotal, 0, ',', ' ') }} <span>CFA</span></div>
            <div class="gn-trend">📈 +{{ number_format($gainsJour, 0, ',', ' ') }} CFA aujourd'hui</div>

            <button class="gn-payout" disabled title="Bientôt disponible">💼 Retirer mes fonds</button>
            <div class="gn-hint">Le retrait sera disponible prochainement.</div>
        </div>

        <div class="gn-sec">DERNIÈRES COURSES</div>

        @forelse ($courses as $c)
            <div class="gn-tx">
                <span class="ic">↗</span>
                <div class="info">
                    <b>Course {{ $c->reference }}</b>
                    <small>{{ $c->updated_at?->diffForHumans() }}</small>
                </div>
                <span class="amt">+{{ number_format((int) $c->commission, 0, ',', ' ') }} CFA</span>
            </div>
        @empty
            <div class="gn-empty">Aucune course terminée pour le moment.</div>
        @endforelse
    </div>
</div>
@endsection
