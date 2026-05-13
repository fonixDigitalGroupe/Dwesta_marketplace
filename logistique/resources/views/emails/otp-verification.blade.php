<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f9; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background-color: #004aad; padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; font-weight: 800; }
        .content { padding: 40px; text-align: center; }
        .otp-code { font-size: 48px; font-weight: 900; color: #004aad; letter-spacing: 10px; margin: 30px 0; padding: 20px; background-color: #f0f7ff; border-radius: 12px; display: inline-block; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KARNOU LOGISTIQUE</h1>
        </div>
        <div class="content">
            <h2>Vérification de votre compte</h2>
            <p>Bonjour,</p>
            <p>Utilisez le code ci-dessous pour valider votre inscription sur la plateforme livreur Karnou.</p>
            <div class="otp-code">{{ $otp }}</div>
            <p>Ce code expirera dans 10 minutes.</p>
            <p>Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet e-mail.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Karnou Marketplace. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
