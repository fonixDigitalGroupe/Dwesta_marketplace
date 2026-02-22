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
        Schema::table('banners', function (Blueprint $table) {
            $table->string('promo_discount')->nullable()->after('link_url');
            $table->string('promo_conditions')->nullable()->after('promo_discount');
            $table->string('promo_code')->nullable()->after('promo_conditions');
            $table->boolean('has_payment_4x')->default(false)->after('promo_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['promo_discount', 'promo_conditions', 'promo_code', 'has_payment_4x']);
        });
    }
};
