<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Date à laquelle le vendeur a ouvert le détail de la commande.
            // NULL = commande jamais consultée par le vendeur (= "Nouveau").
            $table->timestamp('vendeur_vue_le')->nullable()->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('vendeur_vue_le');
        });
    }
};
