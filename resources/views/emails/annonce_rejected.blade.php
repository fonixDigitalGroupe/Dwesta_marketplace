<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0; }
        .content { padding: 20px 0; }
        .status { font-weight: bold; font-size: 18px; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 20px; }
        .rejected { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .article-box { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center; }
        .article-img { width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; }
        .footer { text-align: center; font-size: 12px; color: #777; padding-top: 20px; border-top: 1px solid #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #bf0000; margin: 0;">Mise à jour de votre annonce</h2>
        </div>
        <div class="content">
            <p>Bonjour {{ $annonce->vendeur->user->prenom ?? 'Cher Vendeur' }},</p>
            
            <p>Nous vous informons qu'après modération, votre annonce a été <strong>refusée</strong> et ne sera pas publiée (ou a été retirée) du marketplace.</p>

            <div class="status rejected">
                Annonce Refusée
            </div>

            <div class="article-box">
                @if($annonce->photoPrincipale())
                    <img src="{{ $message->embed(public_path('storage/' . $annonce->photoPrincipale()->chemin)) }}" class="article-img">
                @endif
                <div>
                    <div style="font-weight: bold; font-size: 1.1rem; color: #111;">{{ $annonce->titre }}</div>
                    <div style="font-size: 0.9rem; color: #555;">Prix : {{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>
                </div>
            </div>

            <p><strong>Motif du rejet :</strong></p>
            <div style="background: #fff8f3; border-left: 4px solid #f68b1e; padding: 15px; font-style: italic; color: #555;">
                "{{ $annonce->raison_rejet ?? 'Aucun motif spécifique fourni.' }}"
            </div>

            <p>Vous pouvez modifier votre annonce depuis votre <a href="{{ route('vendeur.mes-annonces') }}" style="color: #004aad; text-decoration: none; font-weight: bold;">Espace Vendeur</a> pour la soumettre à nouveau après correction.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Dwesta Marketplace. Tous droits réservés.
        </div>
    </div>
</body>
</html>
