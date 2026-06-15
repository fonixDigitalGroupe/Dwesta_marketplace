<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bordereau - {{ $order->reference }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 13px; color: #333; }
        .header { display: table; width: 100%; border-bottom: 2px solid #004aad; padding-bottom: 10px; margin-bottom: 20px; }
        .header td { vertical-align: top; }
        .title { font-size: 24px; font-weight: bold; color: #004aad; }
        .ref { font-size: 16px; margin-top: 5px; font-weight: bold; }
        .qrcode { text-align: right; }
        .section { margin-bottom: 20px; }
        .section-title { font-size: 14px; font-weight: bold; background: #eee; padding: 5px; margin-bottom: 10px; }
        .grid { display: table; width: 100%; }
        .col { display: table-cell; width: 50%; padding-right: 20px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.items th, table.items td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.items th { background: #f9f9f9; font-weight: bold; }
        .totals { width: 50%; float: right; margin-top: 20px; border-collapse: collapse; }
        .totals td { padding: 5px; border-bottom: 1px solid #eee; }
        .totals .bold { font-weight: bold; font-size: 14px; }
        .footer { position: absolute; bottom: 30px; width: 100%; text-align: center; font-size: 10px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
        .barcode-container { margin-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td width="60%">
                    <div class="title">KARNOU MARKETPLACE</div>
                    <div>Bordereau d'expédition / Facture</div>
                    <div class="ref">Commande N° {{ $order->reference }}</div>
                    <div>Date : {{ $order->created_at->format('d/m/Y H:i') }}</div>
                </td>
                <td width="40%" class="qrcode">
                    @php
                        $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->errorCorrection('H')->generate($order->reference));
                    @endphp
                    <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
                </td>
            </tr>
        </table>
    </div>

    <div class="grid">
        <div class="col">
            <div class="section">
                <div class="section-title">Vendeur</div>
                <strong>{{ $vendeur->identite }}</strong><br>
                @if($vendeur->professionnel)
                    {{ $vendeur->professionnel->adresse_entreprise ?? '' }}<br>
                    Tél : {{ $vendeur->professionnel->telephone_entreprise ?? '-' }}<br>
                    Email : {{ $vendeur->professionnel->email_entreprise ?? '' }}
                @else
                    {{ $vendeur->user->email }}<br>
                    Tél : {{ $vendeur->user->telephone ?? '-' }}
                @endif
            </div>
        </div>
        <div class="col">
            <div class="section">
                <div class="section-title">Client / Destinataire</div>
                <strong>{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</strong><br>
                {{ $order->adresse_livraison }}<br>
                Tél : {{ $order->buyer->telephone ?? '-' }}<br>
                Email : {{ $order->buyer->email }}
            </div>
        </div>
    </div>

    <div class="section" style="clear: both; margin-top: 20px;">
        <div class="section-title">Détails de la commande</div>
        <table class="items">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Réf. / Variante</th>
                    <th>Qté</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->annonce ? $item->annonce->titre : 'Article inconnu' }}</td>
                        <td>{{ $item->variante ? $item->variante->nom : '-' }}</td>
                        <td>{{ $item->quantite }}</td>
                        <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td>Sous-total :</td>
                <td align="right">{{ number_format($order->total_produits, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td>Frais de port :</td>
                <td align="right">{{ number_format($order->frais_port, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td class="bold">Total à payer :</td>
                <td align="right" class="bold">{{ number_format($order->total_final ?? $order->total_produits, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td>Mode de paiement :</td>
                <td align="right">{{ strtoupper($order->mode_paiement ?? 'Non renseigné') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Document généré le {{ date('d/m/Y H:i') }} par Karnou Marketplace.<br>
        Merci de coller la partie supérieure de ce document (contenant le QR Code) visiblement sur le colis pour l'expédition.
    </div>

</body>
</html>
