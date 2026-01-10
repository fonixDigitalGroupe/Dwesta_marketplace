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
        Schema::create('vendeur_abonnements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->onDelete('cascade');
            $table->foreignId('abonnement_id')->constrained('abonnements')->onDelete('restrict');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('actif')->default(true);
            $table->boolean('renouvellement_automatique')->default(false);
            $table->integer('nombre_annonces_utilisees')->default(0); // Nombre d'annonces publiées
            $table->timestamps();
            
            $table->index('vendeur_id');
            $table->index('abonnement_id');
            $table->index('date_fin');
            $table->index('actif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendeur_abonnements');
    }
};
