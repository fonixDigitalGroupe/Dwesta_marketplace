@extends('layouts.app')

@section('title', 'Vérification des Vendeurs')

@section('content')
<div style="max-width: 1200px; margin: 3rem auto; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <h1 style="color: #333; margin: 0;">Vérification des Vendeurs</h1>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('dashboard') }}" style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                    Dashboard
                </a>
                <a href="{{ route('profile.show') }}" style="display: inline-block; background: #17a2b8; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                    Mon profil
                </a>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        @if($vendeursEnAttente->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                            <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Vendeur</th>
                            <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Type</th>
                            <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Date de demande</th>
                            <th style="padding: 1rem; text-align: left; color: #333; font-weight: 600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendeursEnAttente as $vendeur)
                            <tr style="border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 1rem;">
                                    <div>
                                        <strong style="color: #333;">{{ $vendeur->user->prenom }} {{ $vendeur->user->nom ?? '' }}</strong>
                                        <div style="color: #666; font-size: 0.875rem; margin-top: 0.25rem;">
                                            {{ $vendeur->user->email }}
                                        </div>
                                        @if($vendeur->estProfessionnel() && $vendeur->professionnel)
                                            <div style="color: #666; font-size: 0.875rem; margin-top: 0.25rem;">
                                                {{ $vendeur->professionnel->nom_entreprise }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td style="padding: 1rem;">
                                    @if($vendeur->estParticulier())
                                        <span style="background: #e3f2fd; color: #1976d2; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 500;">
                                            Particulier
                                        </span>
                                    @else
                                        <span style="background: #fff3e0; color: #f57c00; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 500;">
                                            Professionnel
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 1rem; color: #666;">
                                    {{ $vendeur->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td style="padding: 1rem;">
                                    <a href="{{ route('admin.vendeurs.verification.show', $vendeur) }}" style="display: inline-block; background: #EF3B2D; color: white; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px; font-size: 0.875rem;">
                                        Vérifier
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 2rem;">
                {{ $vendeursEnAttente->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: #666;">
                <p style="font-size: 1.125rem; margin-bottom: 0.5rem;">Aucun vendeur en attente de vérification</p>
                <p style="font-size: 0.875rem;">Tous les vendeurs ont été vérifiés.</p>
            </div>
        @endif
    </div>
</div>
@endsection

