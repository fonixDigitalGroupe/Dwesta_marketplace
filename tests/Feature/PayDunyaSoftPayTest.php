<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Annonce;
use App\Models\Variante;
use App\Services\PayDunyaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;

class PayDunyaSoftPayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock PayDunya External JSON API
        Http::fake([
            '*/checkout-invoice/create' => Http::response([
                'response_code' => '00',
                'response_text' => 'https://payment.paydunya.com/invoice/TEST_TOKEN',
                'token' => 'TEST_TOKEN'
            ], 200),
            '*/softpay/wave-senegal' => Http::response([
                'success' => true,
                'url' => 'https://pay.wave.com/c/TEST_WAVE_TOKEN'
            ], 200),
        ]);
    }

    public function test_checkout_redirects_to_softpay_url_for_wave()
    {
        $user = User::factory()->create(['telephone' => '771234567']);
        $this->actingAs($user);

        // Create a dummy order
        $order = Order::create([
            'user_id' => $user->id,
            'vendeur_id' => $user->id, // Assume seller id is same for test
            'statut' => 'en_attente',
            'reference' => 'TEST_REF_123',
            'moyen_paiement' => 'wave',
            'total_produits' => 1000,
            'frais_port' => 0,
            'commission_plateforme' => 0,
            'total_final' => 1000,
            'gestion_paiement' => 'commande',
            'adresse_livraison' => 'Test Address',
            'mode_livraison' => 'domicile',
        ]);

        $response = $this->post(route('checkout.process'), [
            'gestion_paiement' => 'commande',
            'moyen_paiement' => 'wave',
            'phone_number' => '771234567'
        ]);

        // It should redirect to the WAVE URL provided by SoftPay
        $response->assertRedirect('https://pay.wave.com/c/TEST_WAVE_TOKEN');
    }
}
