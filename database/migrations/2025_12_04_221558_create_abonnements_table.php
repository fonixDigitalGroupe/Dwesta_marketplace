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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique(); // gratuit, basic, expert
            $table->string('nom'); // Nom affiché
            $table->text('description')->nullable();
            $table->integer('nombre_annonces')->default(0); // 0 = illimité
            $table->decimal('commission', 5, 2)->default(0); // Pourcentage de commission (ex: 5.00 pour 5%)
            $table->decimal('prix_mensuel', 10, 2)->default(0); // Prix en devise locale
            $table->boolean('page_pro')->default(false); // Accès à la page pro
            $table->boolean('actif')->default(true);
            $table->integer('ordre')->default(0); // Ordre d'affichage
            $table->timestamps();
            
            $table->index('type');
            $table->index('actif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonnements');
    }
};
