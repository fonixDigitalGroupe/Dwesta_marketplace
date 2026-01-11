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
        Schema::create('litiges', function (Blueprint $table) {
            $table->id();
            // Lié à une commande (Phase 6) ou transaction. Pour l'instant nullable.
            $table->foreignId('commande_id')->nullable(); 
            // Utilisateur qui signale
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            // Utilisateur signalé
            $table->foreignId('reported_id')->constrained('users')->onDelete('cascade');
            
            $table->enum('motif', ['non_recu', 'non_conforme', 'autre']);
            $table->text('description');
            
            $table->enum('statut', ['en_cours', 'resolu', 'ferme'])->default('en_cours');
            $table->text('resolution')->nullable(); // Explication de la résolution
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('litiges');
    }
};
