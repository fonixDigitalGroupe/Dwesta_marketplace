<?php

namespace Tests\Feature;

use App\Models\Abonnement;
use App\Models\CreditPack;
use App\Models\Order;
use App\Models\User;
use App\Models\Vendeur;
use App\Services\PayDunyaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PayDunyaIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mocking PayDunya config
        config(['services.paydunya.master_key' => 'master_key']);
        config(['services.paydunya.public_key' => 'public_key']);
        config(['services.paydunya.private_key' => 'private_key']);
        config(['services.paydunya.token' => 'token']);
        config(['services.paydunya.mode' => 'test']);
    }

    /** @test */
    public function it_can_handle_marketplace_order_ipn()
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id]);
        $order = Order::create([
            'user_id' => $user->id,
            'vendeur_id' => $vendeur->id,
            'reference' => 'TEST_ORDER_123',
            'total_produits' => 1000,
            'frais_port' => 0,
            'commission_plateforme' => 150,
            'total_final' => 1000,
            'statut' => 'en_attente',
            'adresse_livraison' => 'Test Address',
            'mode_livraison' => 'domicile',
            'gestion_paiement' => 'commande',
            'moyen_paiement' => 'paydunya',
            'paydunya_token' => 'test_token'
        ]);

        // Mock PayDunya confirmation API
        Http::fake([
            'https://app.paydunya.com/sandbox-api/v1/checkout-invoice/confirm/test_token' => Http::response([
                'status' => 'completed',
                'response_text' => 'Paiement effectué',
                'custom_data' => [
                    'type' => 'marketplace_order',
                    'order_id' => $order->id
                ]
            ], 200)
        ]);

        $response = $this->post(route('paydunya.callback'), [
            'token' => 'test_token'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('paye', $order->fresh()->statut);
    }

    /** @test */
    public function it_can_handle_seller_subscription_ipn()
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id]);
        $abonnement = Abonnement::create([
            'nom' => 'Pro',
            'type' => Abonnement::TYPE_BASIC,
            'prix_mensuel' => 5000,
            'commission' => 10,
            'actif' => true
        ]);

        Http::fake([
            'https://app.paydunya.com/sandbox-api/v1/checkout-invoice/confirm/sub_token' => Http::response([
                'status' => 'completed',
                'custom_data' => [
                    'type' => 'seller_subscription',
                    'vendeur_id' => $vendeur->id,
                    'plan_id' => $abonnement->id
                ]
            ], 200)
        ]);

        $response = $this->post(route('paydunya.callback'), [
            'token' => 'sub_token'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('vendeur_abonnements', [
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true
        ]);
    }
    
    /** @test */
    public function it_can_handle_gift_card_purchase_ipn()
    {
        $user = User::factory()->create();

        Http::fake([
            'https://app.paydunya.com/sandbox-api/v1/checkout-invoice/confirm/gift_token' => Http::response([
                'status' => 'completed',
                'custom_data' => [
                    'type' => 'gift_card_purchase',
                    'user_id' => $user->id,
                    'amount' => 10000
                ]
            ], 200)
        ]);

        $response = $this->post(route('paydunya.callback'), [
            'token' => 'gift_token'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('gift_cards', [
            'buyer_id' => $user->id,
            'amount' => 10000,
            'status' => 'active'
        ]);
    }
}
