<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Planifier la vérification des abonnements quotidiennement
Schedule::command('abonnements:verifier')
    ->daily()
    ->at('02:00');

// Planifier la vérification des documents expirés quotidiennement
Schedule::command('documents:verifier-expiration')
    ->daily()
    ->at('03:00');

// Planifier la vérification des options expirées quotidiennement
Schedule::command('annonces:verifier-options-expiration')
    ->daily()
    ->at('04:00');

// Planifier la republication automatique des annonces expirées quotidiennement
Schedule::command('annonces:republier-expirees')
    ->daily()
    ->at('05:00');
