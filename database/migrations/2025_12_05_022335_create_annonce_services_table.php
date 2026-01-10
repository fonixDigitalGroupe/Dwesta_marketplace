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
        Schema::create('annonce_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->unique()->constrained('annonces')->onDelete('cascade');
            $table->enum('type_tarification', ['fixe', 'horaire', 'devis'])->default('fixe');
            $table->decimal('tarif_horaire', 10, 2)->nullable();
            $table->string('duree_estimee')->nullable(); // Ex: "2 heures", "1 jour"
            $table->boolean('deplacement_inclus')->default(false);
            $table->text('zone_intervention')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonce_services');
    }
};
