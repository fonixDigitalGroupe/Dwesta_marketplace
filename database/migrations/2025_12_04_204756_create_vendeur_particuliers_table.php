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
        Schema::create('vendeur_particuliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->unique()->constrained('vendeurs')->onDelete('cascade');
            $table->enum('type_document', ['cni', 'passeport', 'recepisse'])->nullable();
            $table->string('numero_document')->nullable();
            $table->string('document_path')->nullable(); // Chemin vers le document uploadé
            $table->date('date_expiration_document')->nullable();
            $table->date('date_emission_document')->nullable();
            $table->string('lieu_emission')->nullable();
            $table->timestamps();
            
            $table->index('vendeur_id');
            $table->index('date_expiration_document');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendeur_particuliers');
    }
};
