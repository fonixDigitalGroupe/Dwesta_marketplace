<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\HomeSection;
use Illuminate\Database\Seeder;

class HomePromotionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Home Sections
        HomeSection::updateOrCreate(['source_type' => 'flash_sale'], [
            'title' => 'Ventes Flash du Jour',
            'type' => 'slider',
            'limit' => 10,
            'order' => 1,
            'active' => true,
        ]);

        HomeSection::updateOrCreate(['source_type' => 'cheapest'], [
            'title' => 'Offres Imbattables',
            'type' => 'grid',
            'limit' => 8,
            'order' => 2,
            'active' => true,
        ]);

        HomeSection::updateOrCreate(['source_type' => 'newest'], [
            'title' => 'Dernières Opportunités',
            'type' => 'slider',
            'limit' => 12,
            'order' => 3,
            'active' => true,
        ]);

        // 2. Set some products on Promo for Flash Sales
        $annonces = Annonce::publiees()->take(20)->get();
        foreach ($annonces as $index => $annonce) {
            if ($index < 5) {
                // deep discount for flash sale
                $annonce->update([
                    'prix_original' => $annonce->prix * 1.5,
                    'promo_expires_at' => now()->addHours(rand(1, 24)),
                ]);
            } elseif ($index < 12) {
                // normal discount
                $annonce->update([
                    'prix_original' => $annonce->prix * 1.2,
                ]);
            }
        }
    }
}
