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
        Schema::create('annonce_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->unique()->constrained('annonces')->onDelete('cascade');
            $table->decimal('prix_moyen_marche', 10, 2)->nullable(); // Prix moyen marché (ICASES)
            $table->json('badges')->nullable(); // Badges spéciaux (Nouveau, Promo, etc.)
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->string('etat')->nullable(); // Neuf, Occasion, Reconditionné
            $table->integer('quantite')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonce_produits');
    }
};
