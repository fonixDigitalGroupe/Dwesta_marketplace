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
            if (!Schema::hasColumn('coupons', 'category_id_n1')) {
                $table->foreignId('category_id_n1')->nullable()->after('category_id')->constrained('categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('coupons', 'category_id_n2')) {
                $table->foreignId('category_id_n2')->nullable()->after('category_id_n1')->constrained('categories')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (Schema::hasColumn('coupons', 'category_id_n1')) {
                $table->dropForeign(['category_id_n1']);
            }
            if (Schema::hasColumn('coupons', 'category_id_n2')) {
                $table->dropForeign(['category_id_n2']);
            }
            if (Schema::hasColumn('coupons', 'category_id_n1')) {
                $table->dropColumn('category_id_n1');
            }
            if (Schema::hasColumn('coupons', 'category_id_n2')) {
                $table->dropColumn('category_id_n2');
            }
        });
    }
};
