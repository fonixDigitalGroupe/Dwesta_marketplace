<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; padding-top: 20px; }
        .info-box { background-color: #e9ecef; padding: 15px; border-radius: 5px; margin-top: 15px; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nouveau Dossier Vendeur</h2>
        </div>
        <div class="content">
            <p>Bonjour Admin,</p>
            <p>Un utilisateur a déposé une demande pour devenir vendeur sur la plateforme.</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Informations de l'Utilisateur</h3>
                <strong>Nom complet :</strong> {{ $vendeur->user->prenom }} {{ $vendeur->user->nom }}<br>
                <strong>Nationalité :</strong> {{ $vendeur->user->nationalite ?? 'Non renseignée' }}<br>
                <strong>Téléphone :</strong> {{ $vendeur->user->telephone ?? 'Non renseigné' }}<br>
                <strong>E-mail :</strong> {{ $vendeur->user->email }}<br>
                <strong>Inscrit le :</strong> {{ $vendeur->created_at->format('d/m/Y H:i') }}
            </div>

            <div class="info-box" style="background-color: #f1f3f5; border-left: 4px solid #007bff;">
                <h3 style="margin-top: 0; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Détails du Dossier Vendeur</h3>
                <strong>Type de compte :</strong> {{ ucfirst($vendeur->type) }}<br>
                
                @if($vendeur->estProfessionnel() && $vendeur->professionnel)
                    <strong>Entreprise :</strong> {{ $vendeur->professionnel->nom_entreprise }}<br>
                    <strong>RCCM :</strong> {{ $vendeur->professionnel->numero_registre_commerce }}<br>
                    <strong>NIF :</strong> {{ $vendeur->professionnel->numero_identification_fiscale }}<br>
                @elseif($vendeur->estParticulier() && $vendeur->particulier)
                    <strong>Type de doc :</strong> {{ strtoupper($vendeur->particulier->type_document) }}<br>
                    <strong>Numéro :</strong> {{ $vendeur->particulier->numero_document }}<br>
                @endif
            </div>

            <p>Veuillez examiner les documents fournis dans l'administration pour approuver ou rejeter cette demande.</p>
            <p style="text-align: center;">
                <a href="{{ route('admin.vendeurs.verification.index') }}" class="btn">Examiner le dossier</a>
            </p>
        </div>
        <div class="footer">
            Système de notification Dwesta.
        </div>
    </div>
</body>
</html>
