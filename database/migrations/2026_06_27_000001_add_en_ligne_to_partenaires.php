<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Statut « en ligne » (disponible pour recevoir des courses) des partenaires
     * + horodatage de la dernière position GPS poussée par l'app.
     */
    public function up(): void
    {
        Schema::table('livreurs', function (Blueprint $table) {
            if (! Schema::hasColumn('livreurs', 'en_ligne')) {
                $table->boolean('en_ligne')->default(false)->after('actif');
            }
        });

        Schema::table('transporteurs', function (Blueprint $table) {
            if (! Schema::hasColumn('transporteurs', 'en_ligne')) {
                $table->boolean('en_ligne')->default(false)->after('actif');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'position_updated_at')) {
                $table->timestamp('position_updated_at')->nullable()->after('longitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('livreurs', function (Blueprint $table) {
            if (Schema::hasColumn('livreurs', 'en_ligne')) {
                $table->dropColumn('en_ligne');
            }
        });

        Schema::table('transporteurs', function (Blueprint $table) {
            if (Schema::hasColumn('transporteurs', 'en_ligne')) {
                $table->dropColumn('en_ligne');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'position_updated_at')) {
                $table->dropColumn('position_updated_at');
            }
        });
    }
};
