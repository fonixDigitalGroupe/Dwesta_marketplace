<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['achat', 'depense', 'bonus', 'remboursement']);
            $table->bigInteger('montant'); // positif = achat/bonus, négatif = dépense
            $table->string('description');
            $table->string('reference')->nullable(); // stripe payment intent ID, etc.
            $table->nullableMorphs('related'); // polymorphe → CreditPack, Annonce, etc.
            $table->timestamps();

            $table->index('user_id');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_transactions');
    }
};
