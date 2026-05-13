<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de dossier - Karnou</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #1a1a1a;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: 800;
            color: #004aad;
            margin-bottom: 30px;
            text-decoration: none;
        }
        h1 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #111;
        }
        p {
            font-size: 15px;
            margin-bottom: 24px;
            color: #444;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #004aad;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .info-box ul {
            margin: 0;
            padding-left: 20px;
            font-size: 14px;
            color: #555;
        }
        .footer {
            font-size: 13px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 40px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #fff3cd;
            color: #856404;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">KARNOU</div>
        
        <h1>Merci pour votre demande !</h1>
        
        <p>Bonjour {{ $vendeur->user->prenom }},</p>
        
        <p>Nous avons bien reçu votre dossier pour devenir vendeur sur <strong>Karnou Marketplace</strong>. Nos équipes vont maintenant procéder à la vérification de vos documents.</p>
        
        <div class="info-box">
            <p style="font-weight: 700; margin-bottom: 10px;">Récapitulatif de votre demande :</p>
            <ul>
                <li><strong>Type de compte :</strong> {{ ucfirst($vendeur->type) }}</li>
                @if($vendeur->type === 'professionnel')
                    <li><strong>Entreprise :</strong> {{ $vendeur->professionnel->nom_entreprise }}</li>
                @endif
                <li><strong>Statut actuel :</strong> <span class="status-badge">En cours d'examen</span></li>
            </ul>
        </div>
        
        <p>Cette étape de vérification prend généralement <strong>24 à 48 heures ouvrées</strong>. Vous recevrez un nouvel e-mail dès que votre compte sera activé ou si nous avons besoin de précisions complémentaires.</p>
        
        <p>En attendant, vous pouvez compléter votre profil ou explorer la plateforme.</p>
        
        <div class="footer">
            Cordialement,<br>
            L'équipe Karnou Marketplace<br><br>
            &copy; {{ date('Y') }} Karnou. Tous droits réservés.
        </div>
    </div>
</body>
</html>
