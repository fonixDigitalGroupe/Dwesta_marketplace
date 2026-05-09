@extends('layouts.admin')

@section('title', 'Tarification des Services')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    .amazon-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        padding: 20px;
    }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        @include('admin.partials.settings-tabs')

        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    Tarification des Services
                </h1>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.credits.services.create') }}" 
                       style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                        Nouveau service
                    </a>
                    <a href="{{ route('admin.credits.dashboard') }}" 
                       style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Tableau de bord
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div style="background-color: #f3f9f4; border: 1px solid #28a745; color: #28a745; padding: 10px 15px; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i> {{ session('success') }}
                </div>
            @endif

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Service</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 140px;">Crédits requis</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 140px;">Durée</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 100px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                                <div style="font-size: 0.85rem; color: #0066c0; font-weight: 500;">
                                    {{ $service->nom }}
                                </div>
                                <div style="font-size: 0.75rem; color: #555; margin-top: 2px;">
                                    Clé système : <span style="font-family: monospace; color: #111;">{{ $service->cle }}</span>
                                </div>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                <span style="font-size: 0.85rem; font-weight: 600; color: #111;">{{ $service->credits_requis }}</span>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                <span style="font-size: 0.85rem; color: #555;">
                                    {{ $service->duree_jours ? $service->duree_jours . ' jours' : 'Permanent' }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @if($service->actif)
                                    <span style="font-size: 0.75rem; color: #569b00; font-weight: 600;">Actif</span>
                                @else
                                    <span style="font-size: 0.75rem; color: #c40000; font-weight: 600;">Inactif</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.credits.services.edit', $service) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                       onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                       Modifier
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <form id="delete-form-{{ $service->id }}" action="{{ route('admin.credits.services.destroy', $service) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $service->id }})" 
                                                style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.textDecoration='underline'" 
                                                onmouseout="this.style.textDecoration='none'">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucun service configuré.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e67e00',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                borderRadius: '0'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
@endsection
