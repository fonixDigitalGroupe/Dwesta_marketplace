<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inter_region_tariffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('delivery_type')->default('livraison_domicile'); // livraison_domicile | retrait_point_relais
            $table->decimal('same_region_price', 10, 2)->default(0);   // livraison dans la même région
            $table->decimal('inter_region_price', 10, 2)->default(0);  // livraison entre régions différentes
            $table->string('delivery_delay')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // un tarif par pays ET par mode de livraison
            $table->unique(['country_id', 'delivery_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inter_region_tariffs');
    }
};
