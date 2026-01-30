<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Annonce;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage
        Schema::disableForeignKeyConstraints();
        Conversation::truncate();
        Message::truncate();
        Schema::enableForeignKeyConstraints();

        $acheteurs = User::role('acheteur')->get();
        $vendeurs = User::role('vendeur')->get();
        $annonces = Annonce::where('statut', 'publiee')->get();

        if ($acheteurs->isEmpty() || $vendeurs->isEmpty() || $annonces->isEmpty()) {
            $this->command->warn('Pas assez de données pour créer des messages.');
            return;
        }

        // Créer 10 conversations
        for ($i = 0; $i < 10; $i++) {
            $acheteur = $acheteurs->random();
            $vendeur = $vendeurs->random();
            $annonce = $annonces->random();

            $conversation = Conversation::create([
                'user1_id' => $acheteur->id,
                'user2_id' => $vendeur->id,
                'annonce_id' => $annonce->id,
                'last_message_at' => now()->subDays(rand(0, 15)),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            // Messages de la conversation
            $messagesData = [
                [
                    'sender' => $acheteur,
                    'text' => 'Bonjour, est-ce que cet article est toujours disponible ?',
                    'delay' => 0,
                ],
                [
                    'sender' => $vendeur,
                    'text' => 'Bonjour ! Oui, l\'article est toujours disponible.',
                    'delay' => rand(5, 60),
                ],
                [
                    'sender' => $acheteur,
                    'text' => 'Parfait ! Est-il possible de négocier le prix ?',
                    'delay' => rand(5, 30),
                ],
                [
                    'sender' => $vendeur,
                    'text' => 'Je peux vous faire une petite réduction si vous prenez plusieurs articles.',
                    'delay' => rand(10, 45),
                ],
                [
                    'sender' => $acheteur,
                    'text' => 'D\'accord, je vais réfléchir. Merci pour votre réponse !',
                    'delay' => rand(30, 120),
                ],
            ];

            $baseTime = $conversation->created_at;
            foreach ($messagesData as $msgData) {
                $baseTime = $baseTime->addMinutes($msgData['delay']);
                $isRead = rand(0, 1) == 1;
                
                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $msgData['sender']->id,
                    'content' => $msgData['text'],
                    'read_at' => $isRead ? $baseTime->addMinutes(rand(1, 60)) : null,
                    'created_at' => $baseTime,
                ]);
            }

            // Mettre à jour last_message_at
            $conversation->update([
                'last_message_at' => $baseTime,
            ]);
        }

        $this->command->info('✓ Messages créés : 10 conversations avec ~5 messages chacune');
    }
}
