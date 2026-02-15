<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; padding-bottom: 20px; }
        .content { padding: 20px 0; }
        .status { font-weight: bold; font-size: 18px; padding: 10px; border-radius: 5px; text-align: center; }
        .approved { background-color: #d4edda; color: #155724; }
        .rejected { background-color: #f8d7da; color: #721c24; }
        .footer { text-align: center; font-size: 12px; color: #777; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <p>Bonjour {{ $vendeur->user->prenom ?? 'Cher Vendeur' }},</p>
            
            @if($vendeur->statut_verification === 'verifie')
                <div class="status approved">
                    Félicitations ! Votre compte vendeur a été APPROUVÉ.
                </div>
            @else
                <div class="status rejected">
                    Désolé, votre demande a été REJETÉE.
                </div>
                <p><strong>Raison :</strong> {{ $vendeur->raison_rejet ?? 'Non spécifiée.' }}</p>
                <p>Si vous souhaitez contester cette décision ou corriger vos informations, vous pouvez soumettre à nouveau votre dossier depuis votre tableau de bord.</p>
            @endif
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Dwesta Marketplace.
        </div>
    </div>
</body>
</html>
