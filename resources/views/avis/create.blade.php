@extends('layouts.app')

@section('title', 'Laisser un avis - ' . $annonce->titre)

@section('content')
    <div style="max-width: 800px; margin: 2rem auto; padding: 0 1rem;">
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 2rem;">
            <div style="margin-bottom: 2rem;">
                <a href="{{ route('annonces.show', $annonce) }}"
                    style="color: #666; text-decoration: none; font-size: 0.875rem;">
                    ← Retour à l'annonce
                </a>
                <h1 style="color: #333; margin: 1rem 0 0 0;">Laisser un avis</h1>
                <p style="color: #666; margin: 0.5rem 0 0 0;">{{ $annonce->titre }}</p>
            </div>

            @if($errors->any())
                <div
                    style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; border: 1px solid #f5c6cb;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('avis.store', $annonce) }}" enctype="multipart/form-data">
                @csrf

                <!-- Note (étoiles) -->
                <div style="margin-bottom: 2rem;">
                    <label
                        style="display: block; margin-bottom: 0.75rem; color: #333; font-weight: 500; font-size: 1.125rem;">
                        Note <span style="color: #EF3B2D;">*</span>
                    </label>
                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                        @for($i = 5; $i >= 1; $i--)
                            <label style="cursor: pointer;">
                                <input type="radio" name="note" value="{{ $i }}" required style="display: none;" {{ old('note') == $i ? 'checked' : '' }}>
                                <span class="star-rating" data-rating="{{ $i }}"
                                    style="font-size: 2.5rem; color: #ddd; transition: color 0.2s;">★</span>
                            </label>
                        @endfor
                        <span id="rating-text" style="color: #666; margin-left: 1rem; font-weight: 500;"></span>
                    </div>
                    @error('note')
                        <span
                            style="color: #EF3B2D; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Commentaire -->
                <div style="margin-bottom: 2rem;">
                    <label for="commentaire"
                        style="display: block; margin-bottom: 0.75rem; color: #333; font-weight: 500; font-size: 1.125rem;">
                        Commentaire <span style="color: #EF3B2D;">*</span>
                    </label>
                    <textarea name="commentaire" id="commentaire" rows="6" required minlength="10" maxlength="1000"
                        style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; font-family: inherit; resize: vertical;"
                        placeholder="Partagez votre expérience avec ce produit... (minimum 10 caractères)">{{ old('commentaire') }}</textarea>
                    <div style="color: #666; font-size: 0.875rem; margin-top: 0.5rem;">
                        <span id="char-count">0</span> / 1000 caractères
                    </div>
                    @error('commentaire')
                        <span
                            style="color: #EF3B2D; font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Boutons -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="{{ route('annonces.show', $annonce) }}"
                        style="display: inline-block; background: #6c757d; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 500;">
                        Annuler
                    </a>
                    <button type="submit"
                        style="background: #EF3B2D; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 500; font-size: 1rem; cursor: pointer;">
                        Publier mon avis
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Gestion des étoiles
            const stars = document.querySelectorAll('.star-rating');
            const ratingInputs = document.querySelectorAll('input[name="note"]');
            const ratingText = document.getElementById('rating-text');
            const ratingTexts = {
                1: 'Très mauvais',
                2: 'Mauvais',
                3: 'Moyen',
                4: 'Bon',
                5: 'Excellent'
            };

            function updateStars(rating) {
                stars.forEach((star, index) => {
                    const starRating = parseInt(star.dataset.rating);
                    if (starRating <= rating) {
                        star.style.color = '#ffc107';
                    } else {
                        star.style.color = '#ddd';
                    }
                });
                ratingText.textContent = ratingTexts[rating] || '';
            }

            // Au survol
            stars.forEach((star) => {
                star.addEventListener('mouseenter', function () {
                    const rating = parseInt(this.dataset.rating);
                    updateStars(rating);
                });
            });

            // Quand on quitte la zone
            document.querySelector('div[style*="display: flex"]').addEventListener('mouseleave', function () {
                const checked = document.querySelector('input[name="note"]:checked');
                if (checked) {
                    updateStars(parseInt(checked.value));
                } else {
                    updateStars(0);
                    ratingText.textContent = '';
                }
            });

            // Au clic
            ratingInputs.forEach((input) => {
                input.addEventListener('change', function () {
                    updateStars(parseInt(this.value));
                });
            });

            // Compteur de caractères
            const commentaire = document.getElementById('commentaire');
            const charCount = document.getElementById('char-count');

            commentaire.addEventListener('input', function () {
                charCount.textContent = this.value.length;
                if (this.value.length > 1000) {
                    charCount.style.color = '#EF3B2D';
                } else {
                    charCount.style.color = '#666';
                }
            });
        </script>
    @endpush
@endsection