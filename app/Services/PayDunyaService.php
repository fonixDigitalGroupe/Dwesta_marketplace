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
    public function createCheckoutSession($total, $description, $successUrl, $cancelUrl, $customData = [], $method = null, $customer = [])
    {
        // Nettoyer le numéro de téléphone (enlever le +)
        $cleanPhone = !empty($customer['phone']) ? str_replace('+', '', $customer['phone']) : '';

        $payload = [
            'invoice' => [
                'total_amount' => $total,
                'description' => $description,
                'customer_name' => $customer['name'] ?? '',
                'customer_email' => $customer['email'] ?? '',
                'customer_phone' => $cleanPhone,
            ],
            'store' => [
                'name' => "Karnou",
            ],
            'actions' => [
                'cancel_url' => $cancelUrl,
                'return_url' => $successUrl,
                'callback_url' => route('paydunya.callback'), 
            ],
            'custom_data' => array_merge($customData, [
                'customer_name' => $customer['name'] ?? '',
                'customer_email' => $customer['email'] ?? '',
                'customer_phone' => $cleanPhone,
            ])
        ];

        // Ajouter les infos client si présentes
        if (!empty($customer)) {
            $payload['customer'] = [
                'name' => $customer['name'] ?? '',
                'first_name' => $customer['first_name'] ?? '',
                'last_name' => $customer['last_name'] ?? '',
                'email' => $customer['email'] ?? '',
                'phone' => $cleanPhone,
                'address' => $customer['address'] ?? '',
                'city' => $customer['city'] ?? '',
                'state' => $customer['state'] ?? '',
                'zip_code' => $customer['zip_code'] ?? '',
            ];
            
            // Format legacy/alternatif pour maximiser les chances de pré-remplissage
            $payload['customer_name'] = $customer['name'] ?? '';
            $payload['customer_email'] = $customer['email'] ?? '';
            $payload['customer_phone'] = $cleanPhone;
            $payload['customer_phonenumber'] = $cleanPhone;
            
            // Root level fields sometimes used by older versions or specific SDKs
            $payload['name'] = $customer['name'] ?? '';
            $payload['email'] = $customer['email'] ?? '';
            $payload['phone'] = $cleanPhone;

            // Extra common fields
            $payload['first_name'] = $customer['first_name'] ?? '';
            $payload['last_name'] = $customer['last_name'] ?? '';
            $payload['phone_number'] = $cleanPhone;
            $payload['email_address'] = $customer['email'] ?? '';
        }

        // Ajouter des canaux spécifiques si demandés (dans l'objet invoice selon la doc v1)
        if ($method) {
            $channels = $this->getChannelsForMethod($method);
            if ($channels) {
                $payload['invoice']['channels'] = $channels;
            }
        }


        file_put_contents('/tmp/paydunya_debug.log', date('Y-m-d H:i:s') . " - Payload: " . json_encode($payload, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
        Log::info('PayDunya Checkout Payload:', ['payload' => $payload]);

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
     * Initier un paiement direct via PSR (Partner Settlement Request)
     * Utile pour Orange Money (STK Push) et Wave (Lien direct)
     */
    public function initiateDirectPayment($invoiceToken, $phoneNumber, $method)
    {
        $channels = $this->getChannelsForMethod($method);
        if (!$channels) {
            throw new \Exception("Méthode de paiement non supportée pour le paiement direct : " . $method);
        }

        $payload = [
            'invoice_token' => $invoiceToken,
            'phone_number' => str_replace('+', '', $phoneNumber),
            'channel' => $channels[0],
        ];

        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => $this->masterKey,
            'PAYDUNYA-PRIVATE-KEY' => $this->privateKey,
            'PAYDUNYA-TOKEN' => $this->token,
        ])->post($this->baseUrl . '/psr/create', $payload);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('PayDunya PSR Error: ' . $response->body());
        return $response->json();
    }
    /**
     * Initier un paiement SoftPay (Paiement sans redirection personnalisé)
     * Permet de rediriger directement vers le portefeuille choisi ou de lancer un push.
     */
    public function softPay($invoiceToken, $method, $customer = [])
    {
        // Nettoyer le numéro : enlever + et le préfixe 221 pour n'envoyer que les 9 chiffres
        $cleanPhone = !empty($customer['phone']) ? str_replace('+', '', $customer['phone']) : '';
        if (str_starts_with($cleanPhone, '221')) {
            $cleanPhone = substr($cleanPhone, 3);
        }
        $name = $customer['name'] ?? '';
        $email = $customer['email'] ?? '';

        $endpoint = match($method) {
            'om' => '/softpay/new-orange-money-senegal',
            'wave' => '/softpay/wave-senegal',
            'free' => '/softpay/free-money-senegal',
            default => null
        };

        if (!$endpoint) {
            throw new \Exception("Méthode SoftPay non supportée : " . $method);
        }

        // Adapter le payload selon les exigences spécifiques de chaque endpoint PayDunya
        $payload = match($method) {
            'om' => [
                'customer_name' => $name,
                'customer_email' => $email,
                'phone_number' => $cleanPhone,
                'invoice_token' => $invoiceToken,
            ],
            'wave' => [
                'wave_senegal_fullName' => $name,
                'wave_senegal_email' => $email,
                'wave_senegal_phone' => $cleanPhone,
                'wave_senegal_payment_token' => $invoiceToken,
            ],
            'free' => [
                'customer_name' => $name,
                'customer_email' => $email,
                'phone_number' => $cleanPhone,
                'payment_token' => $invoiceToken,
            ],
        };

        $response = Http::withHeaders([
            'PAYDUNYA-MASTER-KEY' => $this->masterKey,
            'PAYDUNYA-PRIVATE-KEY' => $this->privateKey,
            'PAYDUNYA-TOKEN' => $this->token,
        ])->post($this->baseUrl . $endpoint, $payload);

        file_put_contents('/tmp/paydunya_debug.log', date('Y-m-d H:i:s') . " - SoftPay Response ($method): " . $response->body() . "\n", FILE_APPEND);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error("PayDunya SoftPay Error ($method): " . $response->body());
        return $response->json();
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
            'om' => ['orange-money-senegal'],
            'wave' => ['wave-senegal'],
            'free' => ['freemoney-senegal'],
            'cb' => ['card'],
            default => null
        };
    }
}
