<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleaseEscrowFunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'escrow:release-funds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Libère les fonds bloqués (séquestre) après 14 jours si aucun litige n\'est en cours.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Démarrage de la libération des fonds sous séquestre...");

        // Trouver les transactions en attente dont la date de libération est passée
        $transactions = Transaction::where('wallet_status', 'pending')
            ->where('release_at', '<=', Carbon::now())
            ->where('statut', 'succes') // Seulement les transactions réussies
            ->with(['order.litiges']) // Charger les litiges liés à la commande
            ->get();

        $count = 0;

        foreach ($transactions as $transaction) {
            
            // Vérifier s'il y a un litige en cours sur la commande
            $hasActiveDispute = false;
            
            if ($transaction->order) {
                $hasActiveDispute = $transaction->order->litiges()
                    ->whereIn('statut', ['nouveau', 'en_attente', 'en_cours'])
                    ->exists();
            }

            if ($hasActiveDispute) {
                $this->warn("Transaction #{$transaction->id} bloquée par un litige en cours.");
                continue;
            }

            // Libération des fonds
            DB::beginTransaction();
            try {
                // Mettre à jour la transaction
                $transaction->wallet_status = 'available';
                $transaction->save();

                // Créditer le wallet de l'utilisateur (vendeur)
                $user = User::find($transaction->user_id);
                if ($user) {
                    // On suppose qu'on utilise le champ credit_balance comme "Wallet disponible"
                    // Ou on pourrait ajouter un champ specifique wallet_balance plus tard.
                    // Pour l'instant, utilisons credit_balance car c'est ce qu'on a.
                    // ATTENTION: credit_balance est aussi utilisé pour acheter des options. 
                    // Il faudrait idéalement séparer "Credits pub" et "Revenus ventes".
                    // Pour cette V1, on mélange tout dans le même pot car c'est de l'argent.
                    
                    $user->increment('credit_balance', $transaction->montant);
                }

                DB::commit();
                $this->info("Fonds libérés pour Transaction #{$transaction->id} : {$transaction->montant} FCFA");
                $count++;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Erreur libération escrow transaction #{$transaction->id}: " . $e->getMessage());
                $this->error("Erreur pour Transaction #{$transaction->id}");
            }
        }

        $this->info("Terminé. {$count} transactions traitées.");
    }
}
