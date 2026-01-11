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
        Schema::table('page_pro', function (Blueprint $table) {
            $table->string('couleur_primaire')->default('#3b82f6')->after('description'); // Bleu par défaut
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_pro', function (Blueprint $table) {
            $table->dropColumn('couleur_primaire');
        });
    }
};
