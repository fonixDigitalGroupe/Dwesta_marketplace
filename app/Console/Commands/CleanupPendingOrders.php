<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CleanupPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cleanup-pending {email : The email address of the seller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprime toutes les commandes en attente de paiement pour un vendeur spécifique';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->with('vendeur')->first();

        if (!$user) {
            $this->error("Utilisateur non trouvé : {$email}");
            return Command::FAILURE;
        }

        if (!$user->vendeur) {
            $this->error("L'utilisateur n'est pas un vendeur.");
            return Command::FAILURE;
        }

        $vendeur = $user->vendeur;
        $pendingOrders = Order::where('vendeur_id', $vendeur->id)
            ->where('statut', Order::STATUT_EN_ATTENTE)
            ->get();

        $count = $pendingOrders->count();

        if ($count === 0) {
            $this->info("Aucune commande en attente trouvée pour le vendeur : {$email}");
            return Command::SUCCESS;
        }

        if (!$this->confirm("Voulez-vous vraiment supprimer {$count} commandes en attente pour {$email} ? Cette action est irréversible.")) {
            $this->info("Action annulée.");
            return Command::SUCCESS;
        }

        try {
            DB::beginTransaction();

            foreach ($pendingOrders as $order) {
                $this->comment("Suppression de la commande {$order->reference}...");

                // Suppression manuelle des items (car pas de cascade en base)
                OrderItem::where('order_id', $order->id)->delete();

                // Suppression des transactions liées
                Transaction::where('order_id', $order->id)->delete();

                // Suppression de la commande
                $order->delete();
            }

            DB::commit();
            $this->info("Suppression terminée avec succès.");
            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Une erreur est survenue lors de la suppression : " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
