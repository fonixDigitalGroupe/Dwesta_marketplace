<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing SMTP Connection...\n";
echo "Mailer: " . config('mail.default') . "\n";
echo "Host: " . config('mail.mailers.smtp.host') . "\n";
echo "Port: " . config('mail.mailers.smtp.port') . "\n";
echo "User: " . config('mail.mailers.smtp.username') . "\n";
echo "From: " . config('mail.from.address') . "\n";

try {
    Mail::raw('Test email from Karnou CLI diagnostic script.', function ($message) {
        $message->to('fonixdigitalgroupe0@gmail.com')
                ->subject('Karnou SMTP Test');
    });
    echo "SUCCESS: Test email sent!\n";
} catch (\Exception $e) {
    echo "FAILURE: " . $e->getMessage() . "\n";
}
