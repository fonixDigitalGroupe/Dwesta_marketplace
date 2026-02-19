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
        Schema::create('livreurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type_vehicule'); // Moto, Voiture
            $table->string('type_document'); // CNI, Passport, Titre de séjour
            $table->string('numero_document')->nullable();
            $table->string('document_recto')->nullable();
            $table->string('document_verso')->nullable();
            $table->string('statut_verification')->default('en_attente');
            $table->text('raison_rejet')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livreurs');
    }
};
