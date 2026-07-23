<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Lever l'unicité sur `type` pour autoriser plusieurs plans (par famille)
        try {
            Schema::table('abonnements', function (Blueprint $table) {
                $table->dropUnique('abonnements_type_unique');
            });
        } catch (\Throwable $e) {
            // index déjà absent : on ignore
        }

        Schema::table('abonnements', function (Blueprint $table) {
            if (!Schema::hasColumn('abonnements', 'famille')) {
                $table->string('famille')->default('E-commerce')->after('type');
            }
            if (!Schema::hasColumn('abonnements', 'duree_jours')) {
                $table->integer('duree_jours')->default(30)->after('prix_mensuel');
            }
            // `type` devient nullable (les plans libres n'en ont pas besoin)
            $table->string('type')->nullable()->change();
        });

        // Les plans existants sont des plans E-commerce (vendeur)
        DB::table('abonnements')->whereNull('famille')->update(['famille' => 'E-commerce']);
    }

    public function down(): void
    {
        Schema::table('abonnements', function (Blueprint $table) {
            if (Schema::hasColumn('abonnements', 'famille')) {
                $table->dropColumn('famille');
            }
            if (Schema::hasColumn('abonnements', 'duree_jours')) {
                $table->dropColumn('duree_jours');
            }
        });
    }
};
