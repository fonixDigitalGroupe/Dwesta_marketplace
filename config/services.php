<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI', '/auth/facebook/callback'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', '/auth/google/callback'),
    ],

    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

    'paydunya' => [
        'master_key' => env('PAYDUNYA_MASTER_KEY'),
        'public_key' => env('PAYDUNYA_PUBLIC_KEY'),
        'private_key' => env('PAYDUNYA_PRIVATE_KEY'),
        'token' => env('PAYDUNYA_TOKEN'),
        'mode' => env('PAYDUNYA_MODE', 'test'),
    ],

    'orange_sms' => [
        'client_id'     => env('ORANGE_SMS_CLIENT_ID'),
        'client_secret' => env('ORANGE_SMS_CLIENT_SECRET'),
        'sender_number' => env('ORANGE_SMS_SENDER_NUMBER'),
        'sender_name'   => env('ORANGE_SMS_SENDER_NAME', 'Karnou'),
    ],

    /*
    | URL publique de la PWA partenaire (karnou-pwa). Les livreurs/transporteurs
    | y téléversent leurs documents sur le disque "public" (partenaire/...).
    | Le hub partage la base mais pas le storage : on construit donc les URLs
    | des documents PWA à partir de cette base. Défaut : l'URL du hub lui-même.
    */
    'partenaire' => [
        'url' => env('KARNOU_PWA_URL', env('APP_URL')),
        // Chemin absolu vers le disque public de karnou-pwa (storage/app/public).
        // Permet au hub de servir les documents partenaire depuis le disque
        // partagé du serveur. Défaut : projet karnou-pwa frère du hub.
        'path' => env('KARNOU_PWA_PATH'),
    ],

];
