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
        Schema::table('banners', function (Blueprint $box) {
            $box->string('famille')->nullable()->after('title');
            $box->foreignId('category_id')->nullable()->after('famille')->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $box) {
            $box->dropForeign(['category_id']);
            $box->dropColumn(['famille', 'category_id']);
        });
    }
};
