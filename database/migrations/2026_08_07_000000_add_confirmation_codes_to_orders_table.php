<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Code à 4 chiffres remis par le VENDEUR au livreur/transporteur
            // pour confirmer le RAMASSAGE du colis.
            $table->string('code_ramassage', 8)->nullable()->after('code_livraison');

            // Code à 4 chiffres détenu par le POINT RELAIS, saisi par le
            // transporteur pour valider le dépôt du colis au point relais.
            $table->string('code_point_relais', 8)->nullable()->after('code_ramassage');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['code_ramassage', 'code_point_relais']);
        });
    }
};
