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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('tracking_token')->nullable()->unique()->after('reference');
            $table->string('qr_code_token')->nullable()->unique()->after('tracking_token');
            // Statuts possibles : paye, en_attente_depot, en_point_relais, receptionne, litige
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['tracking_token', 'qr_code_token']);
        });
    }
};
