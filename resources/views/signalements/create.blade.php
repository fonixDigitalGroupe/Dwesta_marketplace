@extends('layouts.app')

@section('title', 'Signaler l\'annonce - Karnou')

@section('content')
<style>
    body { background: #f1f1f2 !important; }
    @media (max-width: 1024px) {
        .report-footer { flex-direction: column-reverse; }
        .report-footer .report-btn-cancel,
        .report-footer .report-btn-send { width: 100%; }
    }
</style>
<div style="max-width: 640px; margin: 0.75rem auto; padding: 0 1rem;">

    <a href="{{ route('annonces.show', $annonce) }}"
       style="display: inline-flex; align-items: center; gap: 0.4rem; color: #6b7280; text-decoration: none; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.25rem;">
        <i class="fas fa-chevron-left"></i> Retour à l'annonce
    </a>

    <div style="background: #fff; overflow: hidden; border-radius: 10px;">

        <!-- Header -->
        <div style="padding: 1.1rem 1.5rem;">
            <h1 style="margin: 0; font-family: 'Outfit','Inter',sans-serif; font-size: 1.15rem; font-weight: 600; color: #374151;">
                Signaler cette annonce
            </h1>
        </div>

        <!-- Annonce concernée -->
        <div style="display: flex; align-items: center; gap: 0.9rem; padding: 1rem; margin: 0 1.5rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 10px;">
            @php($photo = $annonce->photoPrincipale() ?? $annonce->photos->first())
            @if($photo)
                <img src="{{ $photo->url }}" alt="{{ $annonce->titre }}"
                     style="width: 56px; height: 56px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
            @endif
            <div style="min-width: 0;">
                <div style="font-family: 'Inter',sans-serif; font-size: 0.9rem; font-weight: 700; color: #1a1a1a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $annonce->titre }}</div>
                <div style="font-size: 0.85rem; color: #f68b1e; font-weight: 700;">{{ number_format($annonce->prix_affiche, 0, ',', ' ') }} FCFA</div>
            </div>
        </div>

        <form method="POST" action="{{ route('signalements.store', $annonce) }}">
            @csrf
            <div style="padding: 1.5rem;">
                <p style="margin: 0 0 1.25rem; font-family: 'Inter',sans-serif; font-size: 0.88rem; color: #6b7280; line-height: 1.5;">
                    Aidez-nous à garder la marketplace sûre. Indiquez pourquoi cette annonce vous semble abusive ; notre équipe de modération l'examinera.
                </p>

                @if($errors->hasAny(['motif','description','email']))
                    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 0.6rem 0.8rem; border-radius: 8px; font-size: 0.82rem; margin-bottom: 1.25rem;">
                        @foreach($errors->only(['motif','description','email']) as $messages)
                            @foreach((array) $messages as $message)
                                <div>{{ $message }}</div>
                            @endforeach
                        @endforeach
                    </div>
                @endif

                <label style="display: block; font-family: 'Inter',sans-serif; font-size: 0.82rem; font-weight: 600; color: #374151; margin-bottom: 0.35rem;">Motif *</label>
                <select name="motif" required
                    style="width: 100%; padding: 0.7rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.88rem; color: #1a1a1a; background: #fff; margin-bottom: 1.25rem;">
                    <option value="" disabled {{ old('motif') ? '' : 'selected' }}>— Choisir un motif —</option>
                    @foreach(\App\Models\Signalement::MOTIFS as $value => $label)
                        <option value="{{ $value }}" {{ old('motif') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <label style="display: block; font-family: 'Inter',sans-serif; font-size: 0.82rem; font-weight: 600; color: #374151; margin-bottom: 0.35rem;">Détails (facultatif)</label>
                <textarea name="description" rows="5" maxlength="2000" placeholder="Précisez le problème…"
                    style="width: 100%; padding: 0.7rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.88rem; color: #1a1a1a; resize: vertical; margin-bottom: 1.25rem;">{{ old('description') }}</textarea>

                @guest
                <label style="display: block; font-family: 'Inter',sans-serif; font-size: 0.82rem; font-weight: 600; color: #374151; margin-bottom: 0.35rem;">Votre email (facultatif)</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="pour vous recontacter si besoin"
                    style="width: 100%; padding: 0.7rem 0.75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 0.88rem; color: #1a1a1a;">
                @endguest
            </div>

            <!-- Footer -->
            <div class="report-footer" style="display: flex; justify-content: flex-end; gap: 0.6rem; padding: 1rem 1.5rem; background: #fff;">
                <a href="{{ route('annonces.show', $annonce) }}" class="report-btn-cancel"
                    style="padding: 0.6rem 1.2rem; border: 1px solid #d1d5db; background: #fff; color: #374151; border-radius: 8px; font-size: 0.88rem; font-weight: 600; text-decoration: none; text-align: center;">
                    Annuler
                </a>
                <button type="submit" class="report-btn-send"
                    style="padding: 0.6rem 1.4rem; border: none; background: #f68b1e; color: #fff; border-radius: 8px; font-size: 0.88rem; font-weight: 700; cursor: pointer; transition: background 0.2s;"
                    onmouseover="this.style.background='#e07b10'" onmouseout="this.style.background='#f68b1e'">
                    Envoyer le signalement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
