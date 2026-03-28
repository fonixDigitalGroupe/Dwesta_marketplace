<?php

namespace App\Services;

use App\Models\Annonce;
use App\Models\AnnonceCreditService;
use App\Models\CreditPack;
use App\Models\CreditServiceConfig;
use App\Models\CreditTransaction;
use App\Models\User;
use App\Models\UserCredit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreditService
{
    /**
     * Retourne le solde de crédits d'un utilisateur.
     */
    public function solde(User $user): int
    {
        return UserCredit::soldeFor($user->id);
    }

    /**
     * Vérifie si l'utilisateur a assez de crédits.
     */
    public function aAssezDeCredits(User $user, int $montant): bool
    {
        return $this->solde($user) >= $montant;
    }

    /**
     * Crédite un utilisateur suite à l'achat d'un pack.
     * Appelé par le webhook Stripe ou manuellement par l'admin.
     */
    public function acheter(User $user, CreditPack $pack, string $reference = null): void
    {
        $total = $pack->total_credits;

        DB::transaction(function () use ($user, $pack, $total, $reference) {
            $userCredit = UserCredit::firstOrCreate(
                ['user_id' => $user->id],
                ['credits_disponibles' => 0]
            );
            $userCredit->increment('credits_disponibles', $total);

            CreditTransaction::create([
                'user_id'      => $user->id,
                'type'         => 'achat',
                'montant'      => $total,
                'description'  => "Achat du pack « {$pack->nom} » ({$pack->credits} + {$pack->bonus_credits} bonus)",
                'reference'    => $reference,
                'related_type' => CreditPack::class,
                'related_id'   => $pack->id,
            ]);
        });
    }

    /**
     * Attribue des crédits manuellement (bonus admin).
     */
    public function attribuerBonus(User $user, int $montant, string $raison): void
    {
        DB::transaction(function () use ($user, $montant, $raison) {
            UserCredit::updateOrCreate(
                ['user_id' => $user->id],
                ['credits_disponibles' => DB::raw("credits_disponibles + {$montant}")]
            );

            CreditTransaction::create([
                'user_id'     => $user->id,
                'type'        => 'bonus',
                'montant'     => $montant,
                'description' => "Bonus admin : {$raison}",
            ]);
        });
    }

    /**
     * Dépense des crédits pour activer un service sur une annonce.
     *
     * @throws \Exception Si le solde est insuffisant ou si le service n'existe pas.
     */
    public function activerService(User $user, Annonce $annonce, string $cle): AnnonceCreditService
    {
        $config = CreditServiceConfig::where('cle', $cle)->where('actif', true)->firstOrFail();

        if (!$this->aAssezDeCredits($user, $config->credits_requis)) {
            throw new \Exception("Solde insuffisant. Ce service nécessite {$config->credits_requis} crédits.");
        }

        $creditService = null;

        DB::transaction(function () use ($user, $annonce, $config, &$creditService) {
            UserCredit::where('user_id', $user->id)
                ->decrement('credits_disponibles', $config->credits_requis);

            CreditTransaction::create([
                'user_id'      => $user->id,
                'type'         => 'depense',
                'montant'      => -$config->credits_requis,
                'description'  => "Service « {$config->nom} » sur l'annonce #{$annonce->id}",
                'related_type' => Annonce::class,
                'related_id'   => $annonce->id,
            ]);

            $creditService = AnnonceCreditService::create([
                'annonce_id'       => $annonce->id,
                'service'          => $config->cle,
                'credits_depenses' => $config->credits_requis,
                'demarre_le'       => now(),
                'expire_le'        => $config->calculerExpiration(),
            ]);

            if (in_array($config->cle, ['mise_en_avant', 'boost'])) {
                $annonce->options()->updateOrCreate(
                    ['annonce_id' => $annonce->id],
                    ['a_la_une' => true, 'a_la_une_expire_le' => $config->calculerExpiration()]
                );
            } elseif ($config->cle === 'urgent') {
                $annonce->options()->updateOrCreate(
                    ['annonce_id' => $annonce->id],
                    ['urgent' => true, 'urgent_expire_le' => $config->calculerExpiration()]
                );
            } elseif ($config->cle === 'video') {
                $annonce->options()->updateOrCreate(
                    ['annonce_id' => $annonce->id],
                    ['video' => true, 'video_expire_le' => $config->calculerExpiration()]
                );
            }
        });

        return $creditService;
    }

    /**
     * Désactive les services expirés (appelé par le scheduler).
     */
    public function expirerServicesDepasses(): int
    {
        $expired = AnnonceCreditService::where('expire_le', '<', now())->get();
        $count = 0;

        foreach ($expired as $service) {
            try {
                if (in_array($service->service, ['mise_en_avant', 'boost'])) {
                    $autresActifs = AnnonceCreditService::where('annonce_id', $service->annonce_id)
                        ->where('service', $service->service)
                        ->where('id', '!=', $service->id)
                        ->actif()
                        ->count();

                    if ($autresActifs === 0) {
                        $service->annonce->options()->update(['a_la_une' => false]);
                    }
                }

                $service->delete();
                $count++;
            } catch (\Exception $e) {
                Log::error("Erreur expiration service crédit #{$service->id}: " . $e->getMessage());
            }
        }

        return $count;
    }
}
