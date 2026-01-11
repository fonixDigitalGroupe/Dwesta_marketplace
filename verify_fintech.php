<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Models\Annonce;
use App\Models\Transaction;
use App\Models\Order;
use App\Services\AnnoncePaymentService;
use App\Services\CartService;
use App\Services\LogisticsService;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

echo "--- Démarrage de la Vérification Fintech ---\n";

// 1. Setup Vendeur
$vendeurUser = User::where('email', 'vendeur@test.com')->first();
if (!$vendeurUser) {
    $vendeurUser = User::factory()->create(['email' => 'vendeur@test.com', 'credit_balance' => 60000, 'password' => bcrypt('password')]);
    $vendeur = Vendeur::create(['user_id' => $vendeurUser->id, 'type' => 'particulier', 'statut_verification' => 'verifie', 'actif' => true]);
    VendeurParticulier::create(['vendeur_id' => $vendeur->id, 'type_document' => 'cni', 'numero_document' => '123']);
} else {
    $vendeurUser->update(['credit_balance' => 60000]); // Reset crédits pour test
    $vendeur = $vendeurUser->vendeur;
}
echo "Vendeur prêt : {$vendeurUser->email} (Solde: {$vendeurUser->credit_balance})\n";

// 2. Setup Catégorie Véhicule (Payante)
$catVehicule = Category::where('slug', 'like', '%vehicule%')->first();
if (!$catVehicule) {
    $catVehicule = Category::create(['nom' => 'Véhicules Test', 'slug' => 'vehicules-test', 'listing_price' => 50000]);
}
echo "Catégorie Véhicule : {$catVehicule->nom} (Prix: {$catVehicule->listing_price})\n";

// 3. Test Paiement Publication
$paymentService = new AnnoncePaymentService();
$canAfford = $paymentService->canAffordPublication($vendeurUser, $catVehicule);
echo "Peut payer ? " . ($canAfford ? 'OUI' : 'NON') . "\n";

if ($canAfford) {
    $paid = $paymentService->processPublicationPayment($vendeurUser, $catVehicule, "TEST-AUTO");
    echo "Paiement effectué ? " . ($paid ? 'OUI' : 'NON') . "\n";
    echo "Nouveau solde vendeur : {$vendeurUser->fresh()->credit_balance}\n"; // Devrait être 10000
}

// 4. Test Séquestre (Checkout)
$acheteur = User::where('email', 'client@test.com')->first();
if (!$acheteur) {
    $acheteur = User::factory()->create(['email' => 'client@test.com', 'password' => bcrypt('password')]);
}
Auth::login($acheteur);

// Créer une annonce pour le test
$annonce = Annonce::create([
    'vendeur_id' => $vendeur->id,
    'categorie_id' => $catVehicule->id,
    'titre' => 'Voiture Test',
    'description' => 'Description test',
    'prix' => 5000000,
    'type' => 'vehicule',
    'statut' => 'publiee'
]);

// Ajouter au panier
$cartService = app(CartService::class);
$cartService->add($annonce->id, 1);

// Simuler Checkout
$checkout = new CheckoutController($cartService, app(LogisticsService::class));
session(['checkout_adresse' => 'Bangui', 'checkout_mode' => 'domicile']);

$request = new Request(['moyen_paiement' => 'om']);
try {
    $checkout->process($request);
    echo "Checkout terminé.\n";
} catch (\Exception $e) {
    echo "Erreur Checkout: " . $e->getMessage() . "\n";
}

// Vérifier Transaction Séquestre
$transaction = Transaction::where('user_id', $vendeurUser->id)
    ->where('wallet_status', 'pending')
    ->latest()
    ->first();

if ($transaction) {
    echo "Transaction trouvée : ID #{$transaction->id}, Montant: {$transaction->montant}, Status Wallet: {$transaction->wallet_status}, Release: {$transaction->release_at}\n";
    
    // 5. Test Libération Fonds (Simulation temps)
    echo "Simulation : Avance dans le temps > 14 jours...\n";
    $transaction->update(['release_at' => now()->subDay()]);
    
    // Exécuter la commande
    Artisan::call('escrow:release-funds');
    echo Artisan::output();
    
    $transaction->refresh();
    echo "Statut final Wallet : {$transaction->wallet_status}\n";
    echo "Solde final Vendeur : {$vendeurUser->fresh()->credit_balance}\n";
} else {
    echo "ERREUR : Pas de transaction pending trouvée pour le vendeur.\n";
}

echo "--- Fin vérification ---\n";
