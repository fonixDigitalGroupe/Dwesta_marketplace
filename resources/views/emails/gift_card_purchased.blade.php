<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f0f2f5; padding: 20px; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #2196F3, #1565C0); padding: 36px 30px; text-align: center; }
        .header h1 { color: #fff; font-size: 26px; margin: 0 0 8px 0; }
        .header p { color: rgba(255,255,255,0.85); font-size: 15px; margin: 0; }
        .content { padding: 32px 30px; }
        .content p { font-size: 15px; color: #444; margin: 0 0 16px 0; }
        .card-box {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            border-radius: 16px;
            padding: 28px 30px;
            margin: 24px 0;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .card-label { font-size: 11px; color: rgba(255,255,255,0.6); letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px; }
        .card-code { font-size: 28px; font-weight: 800; letter-spacing: 6px; color: #fff; font-family: 'Courier New', monospace; margin: 8px 0 20px 0; word-break: break-all; }
        .card-amount { font-size: 22px; font-weight: 700; color: #FFD700; }
        .card-expiry { font-size: 13px; color: rgba(255,255,255,0.7); margin-top: 12px; }
        .card-brand { position: absolute; top: 20px; right: 24px; font-size: 18px; font-weight: 900; color: rgba(255,255,255,0.3); letter-spacing: -1px; }
        .info-box { background: #f8f9fa; border-radius: 8px; padding: 16px 20px; margin: 20px 0; border-left: 4px solid #2196F3; }
        .info-box p { margin: 0; font-size: 14px; color: #555; }
        .btn { display: inline-block; background-color: #2196F3; color: #ffffff !important; padding: 14px 30px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 15px; margin-top: 20px; }
        .footer { text-align: center; font-size: 12px; color: #999; padding: 24px 30px; border-top: 1px solid #eee; background: #fafafa; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎁 Votre Carte Cadeau est prête !</h1>
            <p>Merci pour votre achat sur Karnou Marketplace</p>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $user->prenom ?? $user->name ?? 'Client' }}</strong>,</p>
            <p>Bonne nouvelle ! Votre paiement a été confirmé et votre carte cadeau Karnou a été générée avec succès. Voici vos informations :</p>

            <div class="card-box">
                <div class="card-brand">KARNOU</div>
                <div class="card-label">Code de la carte</div>
                <div class="card-code">{{ $giftCard->code }}</div>
                <div class="card-label">Montant disponible</div>
                <div class="card-amount">{{ number_format($giftCard->amount, 0, ',', ' ') }} FCFA</div>
                <div class="card-expiry">Valable jusqu'au {{ $giftCard->expiry_date->format('d/m/Y') }}</div>
            </div>

            <div class="info-box">
                <p><strong>💡 Comment utiliser votre carte ?</strong><br>
                Rendez-vous sur <a href="{{ route('gift-cards.index') }}" style="color: #2196F3;">karnou.fr/cartes-cadeaux</a>, cliquez sur "Utiliser une carte" et entrez le code ci-dessus pour créditer votre compte.</p>
            </div>

            <p>Vous pouvez également offrir ce code à la personne de votre choix. Il lui suffira de le scanner ou de le saisir lors du paiement.</p>

            <center>
                <a href="{{ route('gift-cards.index') }}" class="btn">Voir mes cartes cadeaux</a>
            </center>

            <p style="margin-top: 24px;">Merci pour votre confiance.<br><strong>L'équipe Karnou</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Karnou Marketplace. Tous droits réservés.<br>
            Ceci est un message automatique, merci de ne pas y répondre directement.
        </div>
    </div>
</body>
</html>
