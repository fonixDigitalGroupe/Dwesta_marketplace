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
        Schema::create('vendeurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['particulier', 'professionnel'])->default('particulier');
            $table->enum('statut_verification', ['en_attente', 'verifie', 'rejete'])->default('en_attente');
            $table->text('raison_rejet')->nullable();
            $table->timestamp('verifie_le')->nullable();
            $table->foreignId('verifie_par')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('actif')->default(true);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('type');
            $table->index('statut_verification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendeurs');
    }
};
