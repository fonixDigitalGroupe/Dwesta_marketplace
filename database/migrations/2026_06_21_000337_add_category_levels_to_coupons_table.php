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
        Schema::table('coupons', function (Blueprint $table) {
            $table->foreignId('category_id_n1')->nullable()->after('category_id')->constrained('categories')->nullOnDelete();
            $table->foreignId('category_id_n2')->nullable()->after('category_id_n1')->constrained('categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign(['category_id_n1']);
            $table->dropForeign(['category_id_n2']);
            $table->dropColumn(['category_id_n1', 'category_id_n2']);
        });
    }
};
