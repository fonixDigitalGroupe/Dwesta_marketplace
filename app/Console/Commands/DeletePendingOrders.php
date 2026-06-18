<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;

class DeletePendingOrders extends Command
{
    protected $signature = 'orders:delete-pending {email : Email du vendeur}';
    protected $description = 'Supprimer toutes les commandes en attente de paiement d\'un vendeur';

    public function handle()
    {
        $email = $this->argument('email');
        $user  = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Utilisateur introuvable : {$email}");
            return 1;
        }

        $vendeur = $user->vendeur;
        if (!$vendeur) {
            $this->error("Cet utilisateur n'a pas de profil vendeur.");
            return 1;
        }

        $orders = Order::where('vendeur_id', $vendeur->id)
                       ->where('statut', 'en_attente')
                       ->get();

        if ($orders->isEmpty()) {
            $this->info("Aucune commande en attente trouvée pour {$email}.");
            return 0;
        }

        $this->table(
            ['ID', 'Référence', 'Total', 'Créée le'],
            $orders->map(fn($o) => [
                $o->id,
                $o->reference,
                number_format($o->total_final, 0, ',', ' ') . ' FCFA',
                $o->created_at->format('d/m/Y H:i'),
            ])
        );

        if (!$this->confirm("Supprimer ces {$orders->count()} commande(s) ?")) {
            $this->info('Annulé.');
            return 0;
        }

        $deleted = Order::where('vendeur_id', $vendeur->id)
                        ->where('statut', 'en_attente')
                        ->delete();

        $this->info("✓ {$deleted} commande(s) supprimée(s) avec succès.");
        return 0;
    }
}
