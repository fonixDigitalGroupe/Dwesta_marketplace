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
        Schema::create('page_pro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->unique()->constrained('vendeurs')->onDelete('cascade');
            $table->string('slug')->unique(); // URL unique pour la page pro
            $table->string('logo')->nullable(); // Chemin vers le logo
            $table->string('banniere')->nullable(); // Chemin vers la bannière
            $table->text('description')->nullable(); // Description de la page pro
            $table->json('categories')->nullable(); // Catégories de produits/services (à implémenter avec Phase 3)
            $table->string('telephone_contact')->nullable(); // Téléphone de contact
            $table->string('email_contact')->nullable(); // Email de contact
            $table->string('site_web')->nullable(); // Site web
            $table->json('reseaux_sociaux')->nullable(); // Réseaux sociaux (Facebook, Instagram, etc.)
            $table->boolean('actif')->default(true); // Page active ou non
            $table->integer('vues')->default(0); // Nombre de vues de la page
            $table->timestamps();
            
            $table->index('vendeur_id');
            $table->index('slug');
            $table->index('actif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_pro');
    }
};
