<?php
// Script de diagnostic - À SUPPRIMER APRÈS USAGE
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Coupon;
use App\Models\Campaign;

echo "<pre style='font-family:monospace;font-size:13px;padding:20px;'>";
echo "=== DIAGNOSTIC BANNIÈRES COUPONS ===\n\n";

// Tous les coupons avec leurs campagnes
$coupons = Coupon::with('campaigns')->orderBy('id', 'desc')->take(10)->get();

echo "--- Derniers 10 coupons ---\n";
foreach ($coupons as $c) {
    echo "ID:{$c->id} | Code:{$c->code} | is_active:" . ($c->is_active ? 'OUI' : 'NON');
    echo " | banner_image:" . ($c->banner_image ? $c->banner_image : 'NULL');
    echo " | campaigns:" . $c->campaigns->count() . "\n";
}

echo "\n--- Coupons éligibles pour la bannière home ---\n";
echo "(is_active=true + has campaigns + banner_image not null)\n\n";

$eligible = Coupon::where('is_active', true)->has('campaigns')->whereNotNull('banner_image')->get();
if ($eligible->isEmpty()) {
    echo "⚠ AUCUN coupon éligible trouvé !\n";
} else {
    foreach ($eligible as $c) {
        echo "✅ ID:{$c->id} | Code:{$c->code} | Image: {$c->banner_image}\n";
    }
}

echo "\n--- Bannières classiques actives ---\n";
$banners = \App\Models\Banner::active()->count();
echo "Nombre de bannières Banner: {$banners}\n";

echo "</pre>";
