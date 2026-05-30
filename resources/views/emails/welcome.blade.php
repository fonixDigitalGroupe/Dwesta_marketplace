<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #f8f9fa; }
        .content { padding: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue sur Karnou !</h1>
        </div>
        <div class="content">
            <p>Bonjour {{ $user->prenom . ' ' . $user->nom }},</p>
            <p>Nous sommes ravis de vous accueillir sur <strong>Karnou Marketplace</strong>. Votre compte a été créé avec succès.</p>
            <p>Vous pouvez dès maintenant explorer nos offres, ajouter des produits à vos favoris et commencer à faire vos achats.</p>
            <p style="text-align: center;">
                <a href="{{ config('app.url') }}" class="btn">Accéder à la Marketplace</a>
            </p>
            <p>À très bientôt,<br>L'équipe Karnou</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Karnou Marketplace. Tous droits réservés.
        </div>
    </div>
</body>
</html>
