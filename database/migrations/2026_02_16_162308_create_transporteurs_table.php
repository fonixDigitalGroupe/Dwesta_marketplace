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
        Schema::create('transporteurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informations Véhicule
            $table->string('type_vehicule')->nullable(); // Moto, Voiture, Camion, Van, etc.
            $table->string('marque_vehicule')->nullable();
            $table->string('modele_vehicule')->nullable();
            $table->string('immatriculation')->nullable();
            
            // KYC / Documents
            $table->string('numero_permis')->nullable();
            $table->string('numero_cni')->nullable();
            
            $table->string('permis_recto')->nullable();
            $table->string('permis_verso')->nullable();
            $table->string('cni_recto')->nullable();
            $table->string('cni_verso')->nullable();
            
            $table->string('carte_grise')->nullable();
            $table->string('assurance')->nullable();
            
            // Statut de vérification
            $table->enum('statut_verification', ['en_attente', 'verifie', 'rejete'])->default('en_attente');
            $table->text('raison_rejet')->nullable();
            
            $table->boolean('actif')->default(true);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('statut_verification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transporteurs');
    }
};
