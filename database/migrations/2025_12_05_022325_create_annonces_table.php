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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('restrict');
            $table->string('type'); // 'produit', 'service', 'immobilier', 'vehicule'
            $table->string('titre');
            $table->decimal('prix', 10, 2)->nullable(); // Prix peut être null pour services
            $table->text('description');
            $table->enum('type_livraison', ['livraison', 'retrait', 'les_deux'])->nullable();
            $table->enum('disponibilite', ['en_stock', 'rupture_stock', 'sur_commande'])->default('en_stock');
            $table->integer('nb_photos')->default(0);
            $table->boolean('video_achetee')->default(false);
            $table->enum('statut', ['brouillon', 'en_attente', 'publiee', 'rejetee', 'expiree'])->default('brouillon');
            $table->text('raison_rejet')->nullable();
            $table->timestamp('publiee_le')->nullable();
            $table->timestamp('expire_le')->nullable();
            $table->integer('vues')->default(0);
            $table->timestamps();
            
            $table->index('vendeur_id');
            $table->index('categorie_id');
            $table->index('type');
            $table->index('statut');
            $table->index('publiee_le');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
