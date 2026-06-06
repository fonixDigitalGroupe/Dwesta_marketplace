<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // On modifie l'ENUM pour accepter les nouvelles valeurs
        // Note: Change() ne supporte pas toujours bien les ENUM en natif selon la version de DB/Doctrine
        // Utilisation d'un statement Raw pour être sûr de la compatibilité MySQL
        DB::statement("ALTER TABLE shipping_rules MODIFY COLUMN delivery_type ENUM('domicile', 'point_relais', 'livraison_domicile', 'retrait_point_relais') NOT NULL");
        
        // Optionnel: Migration des anciennes données si nécessaire (ici on laisse les deux formats pour l'instant)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE shipping_rules MODIFY COLUMN delivery_type ENUM('domicile', 'point_relais') NOT NULL");
    }
};
