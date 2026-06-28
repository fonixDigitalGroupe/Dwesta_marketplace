<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Active tous les livreurs déjà inscrits : statut "vérifié" + actif.
     */
    public function up(): void
    {
        DB::table('livreurs')->update([
            'statut_verification' => 'verifie',
            'raison_rejet'        => null,
            'actif'               => true,
        ]);
    }

    /**
     * Pas de rollback : l'état précédent par livreur n'est pas conservé.
     */
    public function down(): void
    {
        // no-op
    }
};
