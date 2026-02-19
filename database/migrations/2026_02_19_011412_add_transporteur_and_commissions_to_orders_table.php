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
            $table->foreignId('transporteur_id')->nullable()->constrained('transporteurs')->onDelete('set null');
            $table->foreignId('livreur_id')->nullable()->constrained('livreurs')->onDelete('set null');
            $table->foreignId('destination_point_relais_id')->nullable()->constrained('point_relais')->onDelete('set null');
            
            $table->integer('commission_transporteur')->default(0);
            $table->integer('commission_livreur')->default(0);
            $table->integer('commission_point_relais')->default(0);
            
            $table->string('pays_depart')->nullable();
            $table->string('pays_destination')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('transporteur_id');
            $table->dropConstrainedForeignId('livreur_id');
            $table->dropConstrainedForeignId('destination_point_relais_id');
            $table->dropColumn([
                'commission_transporteur',
                'commission_livreur',
                'commission_point_relais',
                'pays_depart',
                'pays_destination'
            ]);
        });
    }
};
