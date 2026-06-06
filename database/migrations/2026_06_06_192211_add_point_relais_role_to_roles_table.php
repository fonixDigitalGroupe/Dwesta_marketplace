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
        if (Schema::hasTable('roles')) {
            \Spatie\Permission\Models\Role::firstOrCreate([
                'name' => 'point relais',
                'guard_name' => 'web'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('roles')) {
            \Spatie\Permission\Models\Role::where('name', 'point relais')
                ->where('guard_name', 'web')
                ->delete();
        }
    }
};
