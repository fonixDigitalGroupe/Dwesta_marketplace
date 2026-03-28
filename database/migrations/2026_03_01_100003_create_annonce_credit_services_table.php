<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonce_credit_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained()->cascadeOnDelete();
            $table->string('service'); // video, mise_en_avant, boost, republication, insertion
            $table->unsignedInteger('credits_depenses');
            $table->timestamp('demarre_le')->useCurrent();
            $table->timestamp('expire_le')->nullable(); // null = permanent
            $table->timestamps();

            $table->index(['annonce_id', 'service']);
            $table->index('expire_le');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonce_credit_services');
    }
};
