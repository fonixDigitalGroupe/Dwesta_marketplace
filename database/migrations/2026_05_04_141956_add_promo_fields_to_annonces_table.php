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
        Schema::table('annonces', function (Blueprint $table) {
            $table->decimal('prix_original', 12, 2)->nullable()->after('prix')->comment('Prix avant promotion');
            $table->timestamp('promo_expires_at')->nullable()->after('prix_original')->comment('Date de fin de la promotion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropColumn(['prix_original', 'promo_expires_at']);
        });
    }
};
