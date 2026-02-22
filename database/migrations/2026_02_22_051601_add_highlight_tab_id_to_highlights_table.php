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
        Schema::table('highlights', function (Blueprint $table) {
            $table->foreignId('highlight_tab_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->dropUnique(['tab', 'position']);
        });

        // Migrate data
        $highlights = DB::table('highlights')->get();
        $tabMapping = [
            'hightech' => 'High-Tech',
            'marchands' => 'Marchands à la une',
            'electromenager' => 'Electroménager',
            'culturel' => 'Culturel',
            'expedie_karnou' => 'Expédié par Karnou',
            'occasion' => 'Occasion',
            'neuf' => 'Neuf',
        ];

        foreach ($highlights as $highlight) {
            $tabName = $tabMapping[$highlight->tab] ?? ucfirst($highlight->tab);
            $tabId = DB::table('highlight_tabs')->where('slug', $highlight->tab)->value('id');

            if (!$tabId) {
                $tabId = DB::table('highlight_tabs')->insertGetId([
                    'name' => $tabName,
                    'slug' => $highlight->tab,
                    'position' => 0,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('highlights')->where('id', $highlight->id)->update(['highlight_tab_id' => $tabId]);
        }

        Schema::table('highlights', function (Blueprint $table) {
            $table->unsignedBigInteger('highlight_tab_id')->nullable(false)->change();
            $table->unique(['highlight_tab_id', 'position']);
            // We keep 'tab' column for a while or drop it if we are sure
            // $table->dropColumn('tab');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('highlights', function (Blueprint $table) {
            $table->dropUnique(['highlight_tab_id', 'position']);
            $table->dropForeign(['highlight_tab_id']);
            $table->dropColumn('highlight_tab_id');
            $table->unique(['tab', 'position']);
        });
    }
};
