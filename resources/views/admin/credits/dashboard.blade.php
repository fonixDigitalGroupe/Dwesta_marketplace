@extends('layouts.admin')

@section('title', 'Tableau de bord - Crédits')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        .amazon-card {
            background: #fff;
            border: 1px solid #e7e7e7;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
    <div style="max-width: 100%;">

        <!-- Main Conteneur style Amazon Card -->
        <div
            style="background: #fff; border: 1px solid #e7e7e7; border-top: none; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    Tableau de bord système des crédits
                </h1>

                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.credits.packs') }}"
                        style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Gérer les packs
                    </a>
                    <a href="{{ route('admin.credits.services') }}"
                        style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Tarifs des services
                    </a>
                    <a href="{{ route('admin.credits.attribuer') }}"
                        style="background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); border: 1px solid #004aad; color: #fff; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                        Attribuer crédits
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div
                    style="background-color: #f3f9f4; border: 1px solid #28a745; color: #28a745; padding: 10px 15px; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Stats --}}
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                <div
                    style="background:#fff; border: 1px solid #e7e7e7; border-left: 4px solid #0066c0; padding:1.5rem; text-align:center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: #111;">{{ number_format($totalCreditsVendus) }}
                    </div>
                    <div style="color: #555; font-size: 0.85rem; margin-top: 0.3rem;">Crédits vendus (Total)</div>
                </div>
                <div
                    style="background:#fff; border: 1px solid #e7e7e7; border-left: 4px solid #c40000; padding:1.5rem; text-align:center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: #111;">{{ number_format($totalCreditDepenses) }}
                    </div>
                    <div style="color: #555; font-size: 0.85rem; margin-top: 0.3rem;">Crédits dépensés (Total)</div>
                </div>
                <div
                    style="background:#fff; border: 1px solid #e7e7e7; border-left: 4px solid #008a00; padding:1.5rem; text-align:center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: #111;">{{ $totalPacks }}</div>
                    <div style="color: #555; font-size: 0.85rem; margin-top: 0.3rem;">Packs de crédits actifs</div>
                </div>
            </div>

            {{-- Dernières transactions --}}
            <h2
                style="font-size: 1rem; font-weight: 500; color: #111; margin-bottom: 15px; border-bottom: 1px solid #e7e7e7; padding-bottom: 10px;">
                Dernières transactions</h2>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Utilisateur</th>
                        <th
                            style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">
                            Type</th>
                        <th
                            style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">
                            Montant</th>
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Description</th>
                        <th
                            style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;">
                            Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $tx)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td
                                style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; border-right: 1px solid #e7e7e7;">
                                {{ $tx->user?->prenom }} {{ $tx->user?->nom }}
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                <span
                                    style="font-size: 0.75rem; font-weight: 600; color: {{ $tx->type === 'achat' ? '#569b00' : ($tx->type === 'depense' ? '#c40000' : '#e77600') }};">
                                    {{ ucfirst($tx->type) }}
                                </span>
                            </td>
                            <td
                                style="padding: 12px 15px; text-align: right; font-size: 0.85rem; font-weight: 700; border-right: 1px solid #e7e7e7; color: {{ $tx->montant > 0 ? '#569b00' : '#c40000' }};">
                                {{ $tx->montant > 0 ? '+' : '' }}{{ $tx->montant }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                {{ Str::limit($tx->description, 70) }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555;">
                                {{ $tx->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucune transaction récente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection