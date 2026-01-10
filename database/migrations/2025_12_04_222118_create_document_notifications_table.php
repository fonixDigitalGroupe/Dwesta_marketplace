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
        Schema::create('document_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('vendeurs')->onDelete('cascade');
            $table->enum('type_document', ['particulier', 'professionnel', 'abonnement'])->default('particulier');
            $table->date('date_expiration');
            $table->integer('jours_avant_expiration')->default(30); // 30, 15, 7, 1 jours avant
            $table->boolean('envoyee')->default(false);
            $table->timestamp('envoyee_le')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
            
            $table->index('vendeur_id');
            $table->index('date_expiration');
            $table->index('envoyee');
            $table->index(['vendeur_id', 'type_document', 'jours_avant_expiration'], 'doc_notif_vendeur_type_jours_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_notifications');
    }
};
