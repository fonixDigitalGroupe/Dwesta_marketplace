<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrangeSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toOrangeSms($notifiable);
        $to = $notifiable->routeNotificationFor('mail') ?: $notifiable->telephone;

        // Si on a un numéro spécifique pour le SMS dans reg_info ou autre
        if (session('reg_info') && isset(session('reg_info')['telephone'])) {
            $to = session('reg_info')['telephone'];
        }

        if (!$to) {
            return;
        }

        // Formatage du numéro (ex: +221...)
        $to = $this->formatPhoneNumber($to);

        try {
            $token = $this->getAccessToken();
            $this->sendSms($token, $to, $message);
        } catch (\Exception $e) {
            Log::error("Orange SMS Error: " . $e->getMessage());
        }
    }

    protected function getAccessToken()
    {
        // Le token Orange est valable ~1h : on le met en cache pour éviter
        // un appel HTTP supplémentaire à chaque envoi (et donc la lenteur).
        return Cache::remember('orange_sms_access_token', now()->addMinutes(50), function () {
            $clientId = config('services.orange_sms.client_id');
            $clientSecret = config('services.orange_sms.client_secret');
            $basicToken = base64_encode($clientId . ':' . $clientSecret);

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $basicToken,
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ])
                ->connectTimeout(5)
                ->timeout(8)
                ->asForm()
                ->post('https://api.orange.com/oauth/v3/token', [
                    'grant_type' => 'client_credentials',
                ]);

            if ($response->failed()) {
                throw new \Exception("Failed to get Orange SMS Access Token: " . $response->body());
            }

            return $response->json('access_token');
        });
    }

    protected function sendSms($token, $to, $message)
    {
        $senderNumber = config('services.orange_sms.sender_number'); // ex: +22500000000
        $senderName = config('services.orange_sms.sender_name', 'Karnou');

        if (empty($senderNumber)) {
            throw new \Exception("ORANGE_SMS_SENDER_NUMBER manquant : impossible d'envoyer le SMS (numéro expéditeur Orange non configuré).");
        }

        $url = "https://api.orange.com/smsmessaging/v1/outbound/tel:" . rawurlencode($senderNumber) . "/requests";

        $response = Http::withToken($token)
            ->connectTimeout(5)
            ->timeout(10)
            ->post($url, [
                'outboundSMSMessageRequest' => [
                    'address' => 'tel:' . $to,
                    'outboundSMSTextMessage' => [
                        'message' => $message,
                    ],
                    'senderAddress' => 'tel:' . $senderNumber,
                    'senderName'    => $senderName,
                ],
            ]);

        if ($response->failed()) {
            throw new \Exception("Failed to send Orange SMS: " . $response->body());
        }
    }

    protected function formatPhoneNumber($number)
    {
        // Nettoyer le numéro
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // Ajouter le préfixe si manquant (ex: Sénégal 221)
        if (strlen($number) == 9) {
            $number = '221' . $number;
        }
        
        return '+' . $number;
    }
}
