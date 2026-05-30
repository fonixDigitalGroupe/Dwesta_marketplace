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
        Schema::table('shipping_rules', function (Blueprint $table) {
            $table->foreignId('source_country_id')->nullable()->constrained('countries')->onDelete('cascade');
            $table->foreignId('destination_country_id')->nullable()->constrained('countries')->onDelete('cascade');
            $table->string('zone_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_rules', function (Blueprint $table) {
            $table->dropForeign(['source_country_id']);
            $table->dropForeign(['destination_country_id']);
            $table->dropColumn(['source_country_id', 'destination_country_id']);
            $table->string('zone_name')->nullable(false)->change();
        });
    }
};
