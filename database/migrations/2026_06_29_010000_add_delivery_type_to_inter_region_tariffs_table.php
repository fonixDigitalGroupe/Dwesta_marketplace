<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('inter_region_tariffs', 'delivery_type')) {
            Schema::table('inter_region_tariffs', function (Blueprint $table) {
                $table->string('delivery_type')->default('livraison_domicile')->after('country_id');
            });
        }

        // Remplace la contrainte unique (country_id) par (country_id, delivery_type).
        // On ajoute d'abord le nouvel index composite (country_id en tête couvre la FK),
        // puis on supprime l'ancien index unique.
        Schema::table('inter_region_tariffs', function (Blueprint $table) {
            $table->unique(['country_id', 'delivery_type'], 'inter_region_country_delivery_unique');
        });

        Schema::table('inter_region_tariffs', function (Blueprint $table) {
            $table->dropUnique('inter_region_tariffs_country_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('inter_region_tariffs', function (Blueprint $table) {
            $table->unique('country_id', 'inter_region_tariffs_country_id_unique');
        });

        Schema::table('inter_region_tariffs', function (Blueprint $table) {
            $table->dropUnique('inter_region_country_delivery_unique');
            $table->dropColumn('delivery_type');
        });
    }
};
