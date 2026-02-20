<?php
try {
    $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
    
    // Create Product
    $product = $stripe->products->create([
        'name' => 'Abonnement Vendeur Mensuel',
        'description' => 'Abonnement pour vendeurs sur la marketplace'
    ]);
    
    // Create Price (10.00 EUR/month)
    $price = $stripe->prices->create([
        'unit_amount' => 1000,
        'currency' => 'eur',
        'recurring' => ['interval' => 'month'],
        'product' => $product->id,
    ]);
    
    echo "Created Stripe Price: " . $price->id . "\n";
    
    // Update Database
    $count = App\Models\Abonnement::where('prix_mensuel', '>', 0)->update(['stripe_price_id' => $price->id]);
    echo "Updated $count subscriptions in database.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
exit();
