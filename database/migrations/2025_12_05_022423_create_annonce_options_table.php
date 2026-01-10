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
        Schema::create('annonce_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained('annonces')->onDelete('cascade');
            $table->boolean('a_la_une')->default(false);
            $table->boolean('urgent')->default(false);
            $table->boolean('video')->default(false);
            $table->boolean('republication_auto')->default(false);
            $table->decimal('frais_insertion', 10, 2)->default(0);
            $table->timestamp('a_la_une_expire_le')->nullable();
            $table->timestamp('urgent_expire_le')->nullable();
            $table->timestamp('video_expire_le')->nullable();
            $table->timestamps();
            
            $table->index('annonce_id');
            $table->index('a_la_une');
            $table->index('urgent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonce_options');
    }
};
