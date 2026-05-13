<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification Karnou</title>
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
        .otp-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #004aad;
            font-family: 'Courier New', Courier, monospace;
        }
        .footer {
            font-size: 13px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 40px;
        }
        .expiry-note {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">KARNOU</div>
        
        <h1>Vérifiez votre adresse e-mail</h1>
        
        <p>Bonjour {{ $prenom }},</p>
        
        <p>Merci de vous être inscrit sur <strong>Karnou Marketplace</strong>. Pour finaliser la configuration de votre compte, veuillez saisir le code de vérification à usage unique suivant :</p>
        
        <div class="otp-container">
            <div class="otp-code">{{ $otp }}</div>
            <div class="expiry-note">Ce code expire dans 15 minutes.</div>
        </div>
        
        <p>Si vous n'avez pas demandé ce code, vous pouvez ignorer cet e-mail en toute sécurité. Quelqu'un a peut-être saisi votre adresse e-mail par erreur.</p>
        
        <div class="footer">
            Cordialement,<br>
            L'équipe Karnou Marketplace<br><br>
            &copy; {{ date('Y') }} Karnou. Tous droits réservés.
        </div>
    </div>
</body>
</html>
