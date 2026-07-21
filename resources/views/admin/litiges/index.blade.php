@extends('layouts.admin')

@section('title', 'Gestion des Litiges')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <!-- Header -->
    <div style="margin-bottom: 2rem; border-bottom: 1px solid #e7e7e7; padding-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                <h1 style="font-size: 1.5rem; color: #111; font-weight: 700; margin-bottom: 0.25rem;">Gestion des Litiges</h1>
                <p style="font-size: 0.9rem; color: #555;">Supervisez et résolvez les conflits entre acheteurs et vendeurs.</p>
            </div>
            <div style="font-size: 0.85rem; color: #555; background: #f6f6f6; padding: 6px 12px; border-radius: 4px; border: 1px solid #e7e7e7;">
                <strong>{{ $litiges->total() }}</strong> litige(s) au total
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        
        <!-- Table Header Controls -->
        <div style="padding: 15px 20px; border-bottom: 1px solid #e7e7e7; background: #fafafa; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px; font-size: 0.85rem; color: #111;">
                <span>Afficher</span>
                <select onchange="window.location.href = '{{ request()->url() }}?per_page=' + this.value" 
                    style="padding: 5px 10px; border: 1px solid #adb1b8; border-radius: 3px; background: #fff; outline: none; cursor: pointer;">
                    <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>par page</span>
            </div>
        </div>

        <!-- Table -->
        <div style="overflow-x: auto;">
            @if($litiges->count() > 0)
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                            <th style="padding: 12px 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #111; letter-spacing: 0.03em; border-right: 1px solid #e7e7e7; width: 80px;">ID</th>
                            <th style="padding: 12px 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #111; letter-spacing: 0.03em; border-right: 1px solid #e7e7e7;">Signalé par / Contre</th>
                            <th style="padding: 12px 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #111; letter-spacing: 0.03em; border-right: 1px solid #e7e7e7;">Motif</th>
                            <th style="padding: 12px 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #111; letter-spacing: 0.03em; border-right: 1px solid #e7e7e7; width: 120px; text-align: center;">Statut</th>
                            <th style="padding: 12px 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #111; letter-spacing: 0.03em; text-align: right; width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($litiges as $litige)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.15s;" onmouseover="this.style.background='#f7faff'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px 20px; border-right: 1px solid #e7e7e7; color: #888; font-weight: 600;">#{{ $litige->id }}</td>
                            <td style="padding: 15px 20px; border-right: 1px solid #e7e7e7;">
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <div style="font-size: 0.85rem;">
                                        <span style="color: #666;">Par:</span> <strong style="color: #004aad;">{{ $litige->reporter->prenom }} {{ $litige->reporter->nom }}</strong>
                                    </div>
                                    <div style="font-size: 0.85rem;">
                                        <span style="color: #666;">Contre:</span> <strong style="color: #111;">{{ $litige->reported->prenom }} {{ $litige->reported->nom }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px 20px; border-right: 1px solid #e7e7e7;">
                                <span style="font-size: 0.75rem; color: #555; background: #f3f4f6; padding: 3px 8px; border-radius: 4px; font-weight: 600; border: 1px solid #e2e8f0;">
                                    {{ ucfirst($litige->motif) }}
                                </span>
                                <div style="margin-top: 6px; font-size: 0.75rem; color: #888;">Le {{ $litige->created_at->format('d/m/Y à H:i') }}</div>
                            </td>
                            <td style="padding: 15px 20px; border-right: 1px solid #e7e7e7; text-align: center;">
                                @if($litige->statut === 'en_cours')
                                    <span style="font-size: 0.7rem; color: #c45500; background: #fff8f3; padding: 4px 10px; border-radius: 12px; font-weight: 700; text-transform: uppercase; border: 1px solid #fbd8b4;">
                                        En cours
                                    </span>
                                @else
                                    <span style="font-size: 0.7rem; color: #166534; background: #f0fdf4; padding: 4px 10px; border-radius: 12px; font-weight: 700; text-transform: uppercase; border: 1px solid #bbf7d0;">
                                        Résolu
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 15px 20px; text-align: right;">
                                <a href="{{ route('admin.litiges.show', $litige) }}" 
                                   style="display: inline-block; color: #111; font-size: 0.8rem; text-decoration: none; padding: 6px 15px; background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; border-radius: 3px; font-weight: 500; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;"
                                   onmouseover="this.style.background='linear-gradient(to bottom, #e7eaf0, #d8dade)'; this.style.borderColor='#a2a6ac'"
                                   onmouseout="this.style.background='linear-gradient(to bottom, #f7f8fa, #e7e9ec)'; this.style.borderColor='#adb1b8'">
                                    Détails
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 60px 20px; text-align: center; color: #555; background: #fafafa;">
                    <i class="fas fa-handshake" style="font-size: 3rem; color: #16a34a; margin-bottom: 15px; opacity: 0.3;"></i>
                    <p style="font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 5px;">Aucun litige</p>
                    <p style="font-size: 0.85rem;">Aucun conflit n'est actuellement signalé sur la plateforme.</p>
                </div>
            @endif
        </div>

        @if($litiges->hasPages())
        <div style="padding: 20px; border-top: 1px solid #e7e7e7; background: #fafafa;">
            {{ $litiges->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
