<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            if (!Schema::hasColumn('annonces', 'poids_palier')) {
                // petit | moyen | volumineux | lourd — sert à calculer les frais de livraison
                $table->string('poids_palier')->nullable()->after('type_livraison');
            }
        });
    }

    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            if (Schema::hasColumn('annonces', 'poids_palier')) {
                $table->dropColumn('poids_palier');
            }
        });
    }
};
