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
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            // Annonce signalée
            $table->foreignId('annonce_id')->constrained('annonces')->onDelete('cascade');
            // Utilisateur qui signale (nullable : les visiteurs non connectés peuvent aussi signaler)
            $table->foreignId('reporter_id')->nullable()->constrained('users')->onDelete('set null');
            // Email de contact (facultatif, surtout pour les visiteurs non connectés)
            $table->string('email')->nullable();

            $table->enum('motif', [
                'contrefacon',
                'interdit',
                'arnaque',
                'contenu_inapproprie',
                'description_trompeuse',
                'autre',
            ]);
            $table->text('description')->nullable();

            $table->enum('statut', ['nouveau', 'traite', 'rejete'])->default('nouveau');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
