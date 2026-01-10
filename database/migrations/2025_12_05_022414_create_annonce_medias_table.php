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
        Schema::create('annonce_medias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained('annonces')->onDelete('cascade');
            $table->enum('type', ['photo', 'video'])->default('photo');
            $table->string('chemin'); // Chemin vers le fichier
            $table->string('nom_original')->nullable();
            $table->integer('taille')->nullable(); // Taille en octets
            $table->string('mime_type')->nullable();
            $table->integer('ordre')->default(0); // Ordre d'affichage
            $table->boolean('est_principale')->default(false); // Photo principale
            $table->timestamps();
            
            $table->index('annonce_id');
            $table->index('type');
            $table->index('ordre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonce_medias');
    }
};
