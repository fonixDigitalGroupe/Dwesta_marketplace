<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On lève l'unicité (country_id, delivery_type) pour autoriser plusieurs paliers.
        try {
            Schema::table('inter_region_tariffs', function (Blueprint $table) {
                $table->dropUnique('inter_region_country_delivery_unique');
            });
        } catch (\Throwable $e) {
            // index absent : on ignore
        }

        Schema::table('inter_region_tariffs', function (Blueprint $table) {
            if (!Schema::hasColumn('inter_region_tariffs', 'poids_palier')) {
                $table->string('poids_palier')->nullable()->after('delivery_type');
            }
        });

        try {
            Schema::table('inter_region_tariffs', function (Blueprint $table) {
                $table->unique(['country_id', 'delivery_type', 'poids_palier'], 'inter_region_country_delivery_palier_unique');
            });
        } catch (\Throwable $e) {
            // ignore si déjà présent
        }
    }

    public function down(): void
    {
        Schema::table('inter_region_tariffs', function (Blueprint $table) {
            try { $table->dropUnique('inter_region_country_delivery_palier_unique'); } catch (\Throwable $e) {}
            if (Schema::hasColumn('inter_region_tariffs', 'poids_palier')) {
                $table->dropColumn('poids_palier');
            }
        });
    }
};
