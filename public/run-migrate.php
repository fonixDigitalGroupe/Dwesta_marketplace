<?php
// ⚠️  SCRIPT TEMPORAIRE — se supprime automatiquement après exécution
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->call('migrate', ['--force' => true]);
$output = $kernel->output();

// Auto-suppression
@unlink(__FILE__);

echo '<pre style="font-family:monospace;background:#1e1e1e;color:#d4d4d4;padding:20px;border-radius:8px;">';
echo "✅ Migration terminée (status: $status)\n\n";
echo htmlspecialchars($output);
echo "\n🗑️  Ce fichier a été supprimé automatiquement.";
echo '</pre>';
