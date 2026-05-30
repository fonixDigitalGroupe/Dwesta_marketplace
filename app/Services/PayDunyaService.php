<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayDunyaService
{
    protected $masterKey;
    protected $publicKey;
    protected $privateKey;
    protected $token;
    protected $mode;
    protected $baseUrl;

    public function __construct()
    {
        $this->masterKey = config('services.paydunya.master_key');
        $this->publicKey = config('services.paydunya.public_key');
        $this->privateKey = config('services.paydunya.private_key');
        $this->token = config('services.paydunya.token');
        $this->mode = config('services.paydunya.mode', 'test');
        
        $this->baseUrl = $this->mode === 'live' 
            ? 'https://app.paydunya.com/api/v1' 
            : 'https://app.paydunya.com/sandbox-api/v1';
    }

    /**
     * Initialiser une session de paiement (Checkout Pre-built)
     */
    public function createCheckoutSession($total, $description, $successUrl, $cancelUrl, $customData = [], $method = null)
    {
        $payload = [
            'invoice' => [
                'total_amount' => $total,
                'description' => $description,
            ],
            'store' => [
                'name' => "Dwesta Marketplace",
            ],
            'actions' => [
                'cancel_url' => $cancelUrl,
                'return_url' => $successUrl,
                'callback_url' => route('paydunya.callback'), 
            ],
            'custom_data' => $customData
        ];

        // Ajouter des canaux spécifiques si demandés
        if ($method) {
            $channels = $this->getChannelsForMethod($method);
            if ($channels) {
                $payload['actions']['channels'] = $channels;
            }
        }

        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => $this->masterKey,
            'PAYDUNYA-PRIVATE-KEY' => $this->privateKey,
            'PAYDUNYA-TOKEN' => $this->token,
        ])->post($this->baseUrl . '/checkout-invoice/create', $payload);

        if ($response->successful()) {
            $data = $response->json();
            if ($data['response_code'] === '00') {
                return (object) [
                    'url' => $data['response_text'], // L'URL de redirection
                    'token' => $data['token']
                ];
            }
        }

        Log::error('PayDunya Session Error: ' . $response->body());
        throw new \Exception('Impossible d\'initier le paiement PayDunya : ' . ($response->json('response_text') ?? 'Erreur inconnue'));
    }

    /**
     * Vérifier un paiement via le token de facture
     */
    public function verifyPayment($token)
    {
        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => $this->masterKey,
            'PAYDUNYA-PRIVATE-KEY' => $this->privateKey,
            'PAYDUNYA-TOKEN' => $this->token,
        ])->get($this->baseUrl . '/checkout-invoice/confirm/' . $token);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
    /**
     * Effectuer un virement (Disbursement) vers un compte Mobile Money
     */
    public function disburse($amount, $phone, $method, $customData = [])
    {
        $channel = $this->getChannelsForMethod($method);
        if (!$channel) {
            throw new \Exception("Méthode de retrait non supportée : " . $method);
        }

        $payload = [
            'account_alias' => $phone,
            'amount' => $amount,
            'withdraw_mode' => $channel[0], // ex: orange-money-sn
        ];

        if (!empty($customData)) {
            $payload['custom_data'] = $customData;
        }

        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => $this->masterKey,
            'PAYDUNYA-PRIVATE-KEY' => $this->privateKey,
            'PAYDUNYA-TOKEN' => $this->token,
        ])->post($this->baseUrl . '/disbursement/disburse' , $payload);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('PayDunya Disbursement Error: ' . $response->body());
        return [
            'response_code' => 'failure',
            'response_text' => $response->json('response_text') ?? 'Erreur lors du virement PayDunya'
        ];
    }

    /**
     * Mapper les méthodes internes vers les canaux PayDunya
     */
    protected function getChannelsForMethod($method)
    {
        return match($method) {
            'om' => ['orange-money-sn'],
            'wave' => ['wave-sn'],
            'free' => ['free-money-sn'],
            'cb' => ['card'],
            default => null
        };
    }
}
