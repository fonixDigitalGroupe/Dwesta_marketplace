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
        Schema::table('abonnements', function (Blueprint $table) {
            // NULL = pas de limite de chiffre d'affaires
            $table->bigInteger('limite_chiffre_affaires')->nullable()->after('nombre_annonces')
                  ->comment('Limite annuelle de chiffre d\'affaires en FCFA. NULL = illimité.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abonnements', function (Blueprint $table) {
            $table->dropColumn('limite_chiffre_affaires');
        });
    }
};
