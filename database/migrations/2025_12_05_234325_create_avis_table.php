<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained('annonces')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // L'acheteur qui a laissé l'avis
            $table->foreignId('commande_id')->nullable(); // Sera utilisé en Phase 7, contrainte ajoutée plus tard
            $table->integer('note')->default(5); // Note de 1 à 5
            $table->text('commentaire')->nullable();
            $table->json('photos')->nullable(); // Photos ajoutées par l'acheteur
            $table->string('statut')->default('en_attente'); // 'en_attente', 'approuve', 'rejete'
            $table->text('raison_rejet')->nullable(); // Si l'avis est rejeté
            $table->foreignId('modere_par')->nullable()->constrained('users')->onDelete('set null'); // Admin qui a modéré
            $table->timestamp('modere_le')->nullable();
            $table->timestamps();

            $table->index('annonce_id');
            $table->index('user_id');
            $table->index('statut');
            $table->index('note');
            // Un utilisateur ne peut laisser qu'un seul avis par annonce
            $table->unique(['annonce_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
