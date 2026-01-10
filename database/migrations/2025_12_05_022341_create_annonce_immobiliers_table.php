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
        Schema::create('annonce_immobiliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->unique()->constrained('annonces')->onDelete('cascade');
            $table->enum('type_transaction', ['vente', 'location'])->default('vente');
            $table->decimal('prix_vente', 12, 2)->nullable();
            $table->decimal('loyer_mensuel', 10, 2)->nullable();
            $table->decimal('charges_mensuelles', 10, 2)->nullable();
            $table->integer('surface')->nullable(); // en m²
            $table->integer('nombre_pieces')->nullable();
            $table->integer('nombre_chambres')->nullable();
            $table->integer('nombre_salles_bain')->nullable();
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('pays')->default('Mali');
            $table->json('equipements')->nullable(); // Climatisation, Parking, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonce_immobiliers');
    }
};
