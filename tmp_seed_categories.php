<?php

use App\Models\Category;

$familles = ['E-commerce', 'Services', 'Immobilier', 'Véhicules'];

foreach ($familles as $familleName) {
    echo "Processing $familleName...\n";
    $parent = Category::whereNull('parent_id')->where('nom', 'like', '%' . $familleName . '%')->first();
    
    if ($parent) {
        $level2 = Category::where('parent_id', $parent->id)->first();
        if ($level2) {
            echo "Adding 15 subcategories to {$level2->nom}...\n";
            for ($i = 1; $i <= 15; $i++) {
                Category::create([
                    'nom' => "Sous-cat {$familleName} {$i}",
                    'parent_id' => $level2->id,
                    'active' => true,
                    'ordre' => $i
                ]);
            }
        }
    }
}
echo "Done!\n";
