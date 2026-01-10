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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendeur_id')->constrained('vendeurs')->onDelete('cascade');
            $table->string('reference')->unique(); // MM-XXXX
            $table->decimal('total_produits', 12, 2);
            $table->decimal('frais_port', 12, 2)->default(0);
            $table->decimal('commission_plateforme', 12, 2);
            $table->decimal('total_final', 12, 2);
            $table->string('statut')->default('en_attente'); // en_attente, paye, expedie, livre, annule, litige
            $table->text('adresse_livraison')->nullable();
            $table->string('mode_livraison')->nullable(); // domicile, point_relais
            $table->string('qr_code_path')->nullable();
            $table->text('notes_vendeur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
