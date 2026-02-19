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
        Schema::table('point_relais', function (Blueprint $table) {
            $table->string('pays')->nullable()->after('adresse');
            $table->string('region')->nullable()->after('pays');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('point_relais', function (Blueprint $table) {
            $table->dropColumn(['pays', 'region']);
        });
    }
};
