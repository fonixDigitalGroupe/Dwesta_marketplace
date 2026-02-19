<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Promo Galaxy S24
        Banner::create([
            'title' => 'Précommandez le Galaxy S24',
            'image_url' => 'https://images.samsung.com/is/image/samsung/assets/sn/home/2024/Galaxy_S24_Ultra_Main_KV_1440x640_pc.jpg',
            'link_url' => '/recherche?q=Galaxy+S24',
            'order' => 1,
            'active' => true,
        ]);

        // 2. Offre iPhone 15
        Banner::create([
            'title' => 'iPhone 15 Pro - Titane',
            'image_url' => 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-1inch-naturaltitanium?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1692846362799',
            'link_url' => '/recherche?q=iPhone+15',
            'order' => 2,
            'active' => true,
        ]);

        // 3. Promo Laptop
        Banner::create([
            'title' => 'MacBook Air M2 - Super Puissant',
            'image_url' => 'https://www.apple.com/v/macbook-air-13-and-15-m2/b/images/overview/hero/hero_midnight__sg7l33f8e8i6_large.jpg',
            'link_url' => '/recherche?q=MacBook',
            'order' => 3,
            'active' => true,
        ]);
        
        // 4. Promo Mode
        Banner::create([
            'title' => 'Collection Été 2024',
            'image_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop', // Exemple Unsplash
            'link_url' => '/categories/mode',
            'order' => 4,
            'active' => true,
        ]);
    }
}
