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
        Schema::create('annonce_vehicules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->unique()->constrained('annonces')->onDelete('cascade');
            $table->string('marque');
            $table->string('modele');
            $table->integer('annee')->nullable();
            $table->integer('kilometrage')->nullable();
            $table->string('carburant')->nullable(); // Essence, Diesel, Électrique, Hybride
            $table->string('boite_vitesse')->nullable(); // Manuelle, Automatique
            $table->string('etat')->nullable(); // Neuf, Occasion, Reconditionné
            $table->string('couleur')->nullable();
            $table->integer('nombre_portes')->nullable();
            $table->integer('puissance')->nullable(); // en CV
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonce_vehicules');
    }
};
