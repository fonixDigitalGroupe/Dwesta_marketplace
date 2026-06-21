@extends('layouts.admin')

@section('title', 'Historique des Campagnes')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    .card-amazon {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .badge-target {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
    }
    .badge-pro { background: #e3f2fd; color: #1976d2; }
    .badge-part { background: #f3e5f5; color: #7b1fa2; }
    .badge-all { background: #f1f5f9; color: #475569; }
</style>
@endpush

@section('content')
<div style="max-width: 1100px; margin: 0 auto; padding: 20px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #111; margin: 0;">📢 Historique des Campagnes</h1>
            <p style="font-size: 0.85rem; color: #666; margin-top: 4px;">Retrouvez l'historique des notifications envoyées aux vendeurs.</p>
        </div>
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary" style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: 1px solid #a88734; color: #111; font-weight: 600;">
            <i class="fas fa-plus"></i> Nouvelle Campagne
        </a>
    </div>

    <div class="card-amazon">
        <table class="table mb-0">
            <thead style="background: #f6f6f6;">
                <tr>
                    <th style="border-top: none; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Date</th>
                    <th style="border-top: none; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Coupon</th>
                    <th style="border-top: none; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Cible</th>
                    <th style="border-top: none; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">Sujet</th>
                    <th style="border-top: none; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; text-align: center;">Vendeurs</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                    <tr>
                        <td style="font-size: 0.85rem; vertical-align: middle;">{{ $campaign->created_at->format('d/m/Y H:i') }}</td>
                        <td style="vertical-align: middle;">
                            <span style="font-family: monospace; background: #fff8e1; color: #f57c00; padding: 2px 6px; border-radius: 4px; font-weight: 700;">
                                {{ $campaign->coupon->code ?? 'N/A' }}
                            </span>
                        </td>
                        <td style="vertical-align: middle;">
                            @if($campaign->target_type == 'professionnel')
                                <span class="badge-target badge-pro">PRO</span>
                            @elseif($campaign->target_type == 'particulier')
                                <span class="badge-target badge-part">PARTICULIER</span>
                            @else
                                <span class="badge-target badge-all">TOUS</span>
                            @endif
                        </td>
                        <td style="font-size: 0.85rem; color: #333; vertical-align: middle;">{{ $campaign->subject }}</td>
                        <td style="text-align: center; vertical-align: middle;">
                            <span style="font-weight: 700; color: #111;">{{ $campaign->sent_count }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: #999;">
                            <i class="fas fa-bullhorn fa-3x mb-3" style="opacity: 0.2;"></i>
                            <p>Aucune campagne n'a été envoyée pour le moment.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($campaigns->hasPages())
            <div style="padding: 15px; border-top: 1px solid #dee2e6;">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
