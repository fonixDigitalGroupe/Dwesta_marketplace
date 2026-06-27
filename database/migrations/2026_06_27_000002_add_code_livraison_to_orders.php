<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Code de livraison à 4 chiffres : remis au client, saisi par le livreur
     * pour confirmer la remise du colis (étape « validation OTP » de l'app).
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'code_livraison')) {
                $table->string('code_livraison', 8)->nullable()->after('tracking_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'code_livraison')) {
                $table->dropColumn('code_livraison');
            }
        });
    }
};
