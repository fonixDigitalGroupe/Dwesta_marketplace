<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_rules', function (Blueprint $table) {
            if (!Schema::hasColumn('shipping_rules', 'poids_palier')) {
                // null = s'applique à tous les poids ; sinon petit|moyen|volumineux|lourd
                $table->string('poids_palier')->nullable()->after('delivery_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('shipping_rules', function (Blueprint $table) {
            if (Schema::hasColumn('shipping_rules', 'poids_palier')) {
                $table->dropColumn('poids_palier');
            }
        });
    }
};
