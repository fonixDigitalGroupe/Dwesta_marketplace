@extends('layouts.admin')

@section('title', 'Modération des Annonces')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <span style="color: var(--mady-red); font-weight: 700;">Modération</span>
@endsection

@section('content')
<div class="card-pro" style="overflow: hidden;">
    
    <!-- Header -->
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--slate-100); background: #fff; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.25rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.02em; margin-bottom: 0.25rem;">Modération des Annonces</h1>
            <p style="font-size: 0.875rem; color: var(--slate-500); font-weight: 500;">Examinez et validez les nouvelles annonces avant publication.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #333;">
            <div>
                Afficher 
                <select onchange="window.location.href = '{{ request()->url() }}?per_page=' + this.value" 
                    style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                    <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                lignes
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="padding: 0;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: var(--slate-50); border-bottom: 1px solid var(--slate-100);">
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Annonce</th>
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Vendeur</th>
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Prix</th>
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Date</th>
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($annonces as $annonce)
                <tr style="border-bottom: 1px solid var(--slate-100); transition: background 0.2s;" onmouseover="this.style.background='var(--slate-50)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 2rem;">
                        <div style="font-weight: 700; color: var(--slate-900); font-size: 0.9375rem; margin-bottom: 4px;">{{ $annonce->titre }}</div>
                        <div style="font-size: 0.75rem; color: var(--slate-500); line-height: 1.4;">{{ Str::limit($annonce->description, 80) }}</div>
                    </td>
                    <td style="padding: 1.25rem 2rem;">
                        <span style="font-size: 0.875rem; font-weight: 600; color: var(--slate-700);">{{ $annonce->vendeur->user->name ?? 'N/A' }}</span>
                    </td>
                    <td style="padding: 1.25rem 2rem; font-weight: 800; color: var(--slate-900); font-size: 0.9375rem;">
                        {{ number_format($annonce->prix, 0, ',', ' ') }} FCFA
                    </td>
                    <td style="padding: 1.25rem 2rem; font-size: 0.8125rem; color: var(--slate-400); font-weight: 500;">
                        {{ $annonce->created_at->format('d/m/Y') }}
                    </td>
                    <td style="padding: 1.25rem 2rem; text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <form action="{{ route('admin.annonces.moderation.approve', $annonce) }}" method="POST">
                                @csrf
                                <button type="submit" style="padding: 8px 16px; background: #f0fdf4; border: 1px solid #10b981; border-radius: 8px; color: #059669; font-size: 0.75rem; font-weight: 800; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#10b981'; this.style.color='#fff'" onmouseout="this.style.background='#f0fdf4'; this.style.color='#059669'">
                                    Approuver
                                </button>
                            </form>
                            <form action="{{ route('admin.annonces.moderation.reject', $annonce) }}" method="POST">
                                @csrf
                                <button type="submit" style="padding: 8px 16px; background: #fef2f2; border: 1px solid #ef4444; border-radius: 8px; color: #b91c1c; font-size: 0.75rem; font-weight: 800; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='#fff'" onmouseout="this.style.background='#fef2f2'; this.style.color='#b91c1c'">
                                    Rejeter
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem; text-align: center; color: var(--slate-400); font-weight: 500;">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 1rem; opacity: 0.3;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p>Aucune annonce en attente de modération.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($annonces->hasPages())
    <div style="padding: 1.5rem 2rem; border-top: 1px solid var(--slate-100); background: var(--slate-50);">
        {{ $annonces->links() }}
    </div>
    @endif
</div>
@endsection
