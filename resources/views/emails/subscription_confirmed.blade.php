<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9f9f9; padding: 20px; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border: 1px solid #eee; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #f68b1e; padding-bottom: 20px; margin-bottom: 25px; }
        .header h1 { color: #f68b1e; font-size: 24px; margin: 0; }
        .content { font-size: 16px; color: #444; }
        .plan-box { background-color: #f8f9fa; border-radius: 6px; padding: 20px; margin: 20px 0; border: 1px solid #e9ecef; }
        .plan-name { font-size: 20px; font-weight: 700; color: #004aad; margin-bottom: 10px; }
        .plan-details { font-size: 14px; color: #666; }
        .btn { display: inline-block; background-color: #004aad; color: #ffffff !important; padding: 12px 25px; border-radius: 4px; text-decoration: none; font-weight: 700; margin-top: 20px; }
        .footer { text-align: center; font-size: 12px; color: #999; padding-top: 30px; border-top: 1px solid #eee; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirmation d'Abonnement</h1>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $vendeurAbonnement->vendeur->identite }}</strong>,</p>
            
            <p>Nous avons le plaisir de vous confirmer l'activation de votre nouvel abonnement sur <strong>Karnou / Dwesta Marketplace</strong>.</p>
            
            <div class="plan-box">
                <div class="plan-name">{{ $vendeurAbonnement->abonnement->nom }}</div>
                <div class="plan-details">
                    <p><strong>Date de début :</strong> {{ $vendeurAbonnement->date_debut->format('d/m/Y') }}</p>
                    <p><strong>Date de fin :</strong> {{ $vendeurAbonnement->date_fin->format('d/m/Y') }}</p>
                    <p><strong>Prix :</strong> {{ number_format($vendeurAbonnement->abonnement->prix_mensuel, 0, ',', ' ') }} FCFA/mois</p>
                </div>
            </div>

            <p>Vous pouvez dès maintenant profiter de tous les avantages liés à votre forfait. Boostez vos ventes et gérez votre boutique avec nos outils professionnels !</p>
            
            <center>
                <a href="{{ route('vendeur.show') }}" class="btn">Accéder à mon tableau de bord</a>
            </center>

            <p>Merci de votre confiance.</p>
            <p>L'équipe Karnou</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Dwesta Marketplace. Tous droits réservés.<br>
            Ceci est un message automatique, merci de ne pas y répondre directement.
        </div>
    </div>
</body>
</html>
