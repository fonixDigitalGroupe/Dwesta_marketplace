<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
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
        $clientId = env('ORANGE_SMS_CLIENT_ID');
        $clientSecret = env('ORANGE_SMS_CLIENT_SECRET');
        $basicToken = base64_encode($clientId . ':' . $clientSecret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $basicToken,
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://api.orange.com/oauth/v3/token', [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->failed()) {
            throw new \Exception("Failed to get Orange SMS Access Token: " . $response->body());
        }

        return $response->json('access_token');
    }

    protected function sendSms($token, $to, $message)
    {
        $senderNumber = env('ORANGE_SMS_SENDER_NUMBER'); // ex: +22100000000
        $senderName = env('ORANGE_SMS_SENDER_NAME', 'Karnou');

        $url = "https://api.orange.com/smsmessaging/v1/outbound/tel:{$senderNumber}/requests";

        $response = Http::withToken($token)
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
