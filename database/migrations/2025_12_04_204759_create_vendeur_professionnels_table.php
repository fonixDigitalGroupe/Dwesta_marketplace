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
        Schema::create('vendeur_professionnels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->unique()->constrained('vendeurs')->onDelete('cascade');
            $table->string('nom_entreprise');
            $table->string('numero_registre_commerce')->nullable();
            $table->string('registre_commerce_path')->nullable(); // Chemin vers le document
            $table->date('date_expiration_registre')->nullable();
            $table->string('numero_identification_fiscale')->nullable();
            $table->string('adresse_entreprise')->nullable();
            $table->string('telephone_entreprise')->nullable();
            $table->string('email_entreprise')->nullable();
            $table->text('description_entreprise')->nullable();
            $table->string('site_web')->nullable();
            $table->timestamps();
            
            $table->index('vendeur_id');
            $table->index('numero_registre_commerce');
            $table->index('date_expiration_registre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendeur_professionnels');
    }
};
