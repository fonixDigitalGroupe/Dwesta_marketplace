<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;

class LogisticsService
{
    private const PALIER_ORDRE = ['petit' => 1, 'moyen' => 2, 'volumineux' => 3, 'lourd' => 4];

    /**
     * Frais de livraison (domicile + point relais) pour UNE annonce, du point de
     * vue d'un utilisateur (sa région/pays). Renvoie ['domicile'=>float|null,
     * 'point_relais'=>float|null] ; null si vendeur/destination inconnus.
     */
    public function feesForAnnonce(\App\Models\Annonce $annonce, $user): array
    {
        $vendeur = $annonce->vendeur;
        if (!$vendeur) {
            return ['domicile' => null, 'point_relais' => null];
        }
        $destCountryId = $this->resolveCountryId(($user->pays ?? null) ?: 'Sénégal');
        $destRegion = $user ? ($user->region ?: $user->ville) : null;
        $palier = $annonce->poids_palier ?? null;

        return [
            'domicile' => $this->computeShippingFeeForVendeur($vendeur, 'livraison_domicile', $destCountryId, $destRegion, $palier),
            'point_relais' => $this->computeShippingFeeForVendeur($vendeur, 'retrait_point_relais', $destCountryId, $destRegion, $palier),
        ];
    }

    public function resolveCountryId(?string $countryName)
    {
        if (empty($countryName)) {
            return null;
        }
        $c = \App\Models\Country::where('name', 'like', $countryName)
            ->orWhere('code', 'like', $countryName)
            ->first();
        return $c ? $c->id : null;
    }

    /**
     * Calcule les frais de livraison pour un vendeur (même logique que le checkout).
     */
    public function computeShippingFeeForVendeur($vendeur, string $mode, ?int $destCountryId, ?string $destRegion, ?string $palier = null): float
    {
        if (!$vendeur) {
            return 0;
        }
        $sourceCountryId = $this->resolveCountryId(optional($vendeur->user)->pays ?? 'Sénégal');
        $sourceRegion = optional($vendeur->user)->region;

        if ($destCountryId && $sourceCountryId && (int) $destCountryId === (int) $sourceCountryId) {
            $tarif = \App\Models\InterRegionTariff::where('country_id', $destCountryId)
                ->where('delivery_type', $mode)
                ->where('is_active', true)
                ->where(function ($q) use ($palier) {
                    $q->whereNull('poids_palier');
                    if ($palier) {
                        $q->orWhere('poids_palier', $palier);
                    }
                })
                ->orderByRaw("CASE WHEN poids_palier = ? THEN 0 ELSE 1 END", [$palier])
                ->first();

            if ($tarif) {
                $sameRegion = $sourceRegion && $destRegion
                    && mb_strtolower(trim($sourceRegion)) === mb_strtolower(trim($destRegion));
                return (float) ($sameRegion ? $tarif->same_region_price : $tarif->inter_region_price);
            }
        }

        $rule = \App\Models\ShippingRule::active()
            ->where('delivery_type', $mode)
            ->where('source_country_id', $sourceCountryId)
            ->where('destination_country_id', $destCountryId)
            ->where(function ($q) use ($destRegion) {
                $q->where('zone_name', $destRegion)
                    ->orWhereNull('zone_name')
                    ->orWhere('zone_name', '');
            })
            ->where(function ($q) use ($palier) {
                $q->whereNull('poids_palier');
                if ($palier) {
                    $q->orWhere('poids_palier', $palier);
                }
            })
            ->orderByRaw("CASE WHEN poids_palier = ? THEN 0 ELSE 1 END", [$palier])
            ->orderByRaw("CASE WHEN zone_name = ? THEN 0 ELSE 1 END", [$destRegion])
            ->first();

        return $rule ? (float) $rule->price : 0;
    }

    /**
     * Générer les jetons logistiques pour une commande
     */
    public function generateLogisticsTokens(Order $order)
    {
        $order->update([
            'tracking_token' => 'TRK-' . strtoupper(Str::random(12)),
            'qr_code_token' => 'QR-' . strtoupper(Str::random(16)),
        ]);
        
        return $order;
    }

    /**
     * Changer le statut de la commande avec validation
     */
    public function updateStatus(Order $order, string $newStatus)
    {
        // Définition des transitions autorisées
        $allowedTransitions = [
            Order::STATUT_PAYE => [Order::STATUT_PRET, Order::STATUT_ANNULE],
            Order::STATUT_PRET => [Order::STATUT_EN_ROUTE, Order::STATUT_ANNULE],
            Order::STATUT_EN_ROUTE => [Order::STATUT_DISPONIBLE, Order::STATUT_LITIGE],
            Order::STATUT_DISPONIBLE => [Order::STATUT_LIVRE, Order::STATUT_LITIGE],
            Order::STATUT_LIVRE => [Order::STATUT_LITIGE],
        ];

        if (isset($allowedTransitions[$order->statut]) && !in_array($newStatus, $allowedTransitions[$order->statut])) {
            throw new \Exception("Transition de statut non autorisée de {$order->statut} vers {$newStatus}");
        }

        $order->update(['statut' => $newStatus]);

        // À la livraison : les fonds du vendeur ne sont plus en séquestre → disponibles.
        // Même logique que l'app partenaire (PWA/mobile) : on incrémente aussi credit_balance.
        if ($newStatus === Order::STATUT_LIVRE) {
            $transactions = \App\Models\Transaction::where('order_id', $order->id)
                ->where('wallet_status', \App\Models\Transaction::STATUS_PENDING)
                ->get();

            foreach ($transactions as $tx) {
                $tx->update([
                    'wallet_status' => \App\Models\Transaction::STATUS_AVAILABLE,
                    'release_at'    => now(),
                ]);
                if ($tx->user) {
                    $tx->user->increment('credit_balance', $tx->montant);
                }
            }
        }

        return $order;
    }
}
