<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Vendeur;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

echo "--- Démarrage de la Vérification Supply Chain ---\n";

// 1. Setup Vendeur
$vendeurUser = User::where('email', 'vendeur@test.com')->first();
if (!$vendeurUser) {
    echo "UTILISATEUR VENDEUR MANQUANT (Lancez verify_fintech.php d'abord)\n";
    exit;
}
$vendeur = $vendeurUser->vendeur;
Auth::login($vendeurUser);

// 2. Créer une Commande PAYE
$order = Order::create([
    'user_id' => 1, // Pas important pour ce test
    'vendeur_id' => $vendeur->id,
    'reference' => 'LOG-' . Str::random(6),
    'total_produits' => 10000,
    'frais_port' => 1000,
    'commission_plateforme' => 1000,
    'total_final' => 12000,
    'statut' => Order::STATUT_PAYE,
    'adresse_livraison' => '123 Rue Test',
    'mode_livraison' => 'point_relais',
    'tracking_token' => 'TRK-' . Str::random(10),
    'qr_code_token' => 'QR-' . Str::random(10),
]);

echo "Commande créée : {$order->reference} (Statut: {$order->statut})\n";

// 3. Vendeur marque comme PRET
$logisticsController = new LogisticsController();
try {
    $logisticsController->markAsReady($order);
    echo "Action Vendeur : Marquer prêt\n";
    echo "Nouveau statut : {$order->fresh()->statut}\n"; // Attendu: pret_expedition
} catch (\Exception $e) {
    echo "Erreur MarkAsReady: " . $e->getMessage() . "\n";
}

// 4. Transporteur scanne (Tracking Token)
$scanController = app(ScanController::class);
$requestPickup = new Request(['token' => $order->tracking_token]);

// Simuler login transporteur (optionnel pour ScanController actuellement mais bon)
// Auth::login($transporteurUser); 

try {
    // Hack: ScanController utilise back()->with(), en CLI ça retourne un RedirectResponse
    // On va juste appeler process et voir si ça exceptionne pas, puis check DB
    $scanController->process($requestPickup);
    echo "Action Transporteur : Scan Tracking Token\n";
    echo "Nouveau statut : {$order->fresh()->statut}\n"; // Attendu: en_route
} catch (\Exception $e) {
     // En CLI back() peut échouer si pas de session session/route, mais l'action DB devrait passer
     echo "Note: " . $e->getMessage() . "\n";
}
echo "Statut après Pickup : {$order->fresh()->statut}\n";


// 5. Relais scanne Arrivée (Tracking Token)
$requestArrival = new Request(['token' => $order->tracking_token]);
try {
    $scanController->process($requestArrival);
    echo "Action Relais : Scan Arrivée (Tracking)\n";
} catch (\Exception $e) {}
echo "Statut après Arrivée Relais : {$order->fresh()->statut}\n"; // Attendu: disponible

// 6. Relais scanne Remise Client (QR Token)
$requestDelivery = new Request(['token' => $order->qr_code_token]);
try {
    $scanController->process($requestDelivery);
    echo "Action Relais : Scan Remise Client (QR)\n";
} catch (\Exception $e) {}
echo "Statut après Remise Client : {$order->fresh()->statut}\n"; // Attendu: livre

echo "--- Fin vérification ---\n";
