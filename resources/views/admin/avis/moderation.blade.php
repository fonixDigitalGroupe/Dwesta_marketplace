@extends('layouts.app')

@section('title', 'Modération des Avis')

@section('content')
    <div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1 style="color: #333; margin: 0;">Modération des Avis</h1>
                <a href="{{ route('home') }}"
                    style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                    Accueil
                </a>
            </div>

            @if(session('success'))
                <div
                    style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if($avisEnAttente->count() > 0)
                <div style="display: grid; gap: 1.5rem;">
                    @foreach($avisEnAttente as $avis)
                        <div style="padding: 1.5rem; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #ffc107;">
                            <div style="display: grid; grid-template-columns: 1fr auto; gap: 2rem;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                        <div>
                                            <div style="font-weight: 600; color: #333; margin-bottom: 0.25rem;">
                                                {{ $avis->user->prenom }} {{ $avis->user->nom ?? '' }}
                                            </div>
                                            <div style="color: #666; font-size: 0.875rem;">
                                                Avis pour : <a href="{{ route('annonces.show', $avis->annonce) }}"
                                                    style="color: #EF3B2D; text-decoration: none;">{{ $avis->annonce->titre }}</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $avis->note)
                                                <span style="color: #ffc107; font-size: 1.25rem;">★</span>
                                            @else
                                                <span style="color: #ddd; font-size: 1.25rem;">★</span>
                                            @endif
                                        @endfor
                                        <span style="color: #666; margin-left: 0.5rem;">{{ $avis->note }} / 5</span>
                                    </div>

                                    <p
                                        style="color: #666; line-height: 1.6; margin: 0 0 1rem 0; background: white; padding: 1rem; border-radius: 4px;">
                                        {{ $avis->commentaire }}</p>

                                    @if($avis->photos && count($avis->photos) > 0)
                                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem;">
                                            @foreach($avis->photos as $photoPath)
                                                <img src="{{ asset('storage/' . $photoPath) }}" alt="Photo avis"
                                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">
                                            @endforeach
                                        </div>
                                    @endif

                                    <div style="color: #666; font-size: 0.875rem;">
                                        Soumis le {{ $avis->created_at->format('d/m/Y à H:i') }}
                                    </div>
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                    <form method="POST" action="{{ route('admin.avis.approve', $avis) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                            style="background: #28a745; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 500; cursor: pointer; white-space: nowrap;">
                                            ✓ Approuver
                                        </button>
                                    </form>

                                    <button type="button"
                                        onclick="document.getElementById('reject-form-{{ $avis->id }}').style.display = 'block';"
                                        style="background: #dc3545; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 500; cursor: pointer; white-space: nowrap;">
                                        ✗ Rejeter
                                    </button>

                                    <form id="reject-form-{{ $avis->id }}" method="POST"
                                        action="{{ route('admin.avis.reject', $avis) }}"
                                        style="display: none; margin-top: 1rem; padding: 1rem; background: white; border-radius: 4px; border: 1px solid #ddd;">
                                        @csrf
                                        <label style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">
                                            Raison du rejet <span style="color: #EF3B2D;">*</span>
                                        </label>
                                        <textarea name="raison_rejet" required rows="3"
                                            style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.875rem; resize: vertical;"
                                            placeholder="Expliquez pourquoi cet avis est rejeté..."></textarea>
                                        <div style="display: flex; gap: 0.5rem; margin-top: 0.75rem;">
                                            <button type="submit"
                                                style="background: #dc3545; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                                                Confirmer le rejet
                                            </button>
                                            <button type="button"
                                                onclick="document.getElementById('reject-form-{{ $avis->id }}').style.display = 'none';"
                                                style="background: #6c757d; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; font-size: 0.875rem; cursor: pointer;">
                                                Annuler
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div style="display: flex; justify-content: center; margin-top: 2rem;">
                    {{ $avisEnAttente->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #666;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
                    <p style="margin: 0; font-size: 1.125rem;">Aucun avis en attente de modération</p>
                </div>
            @endif
        </div>
    </div>
@endsection