<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_service_configs', function (Blueprint $table) {
            $table->id();
            $table->string('cle')->unique(); // video, mise_en_avant, boost, republication, insertion
            $table->string('nom'); // Nom affiché à l'utilisateur
            $table->text('description')->nullable();
            $table->unsignedInteger('credits_requis');
            $table->unsignedSmallInteger('duree_jours')->nullable(); // null = permanent
            $table->boolean('actif')->default(true);
            $table->unsignedSmallInteger('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_service_configs');
    }
};
