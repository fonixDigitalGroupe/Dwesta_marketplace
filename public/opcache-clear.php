<?php
// Fichier temporaire de diagnostic : vide l'OPcache côté web/PHP-FPM.
// À supprimer après usage. Protégé par un jeton.

if (($_GET['token'] ?? '') !== 'karnou2026') {
    http_response_code(404);
    exit('Not found');
}

header('Content-Type: text/plain; charset=utf-8');

if (!function_exists('opcache_reset')) {
    exit('OPcache non disponible sur ce serveur.');
}

$ok = opcache_reset();

echo $ok ? "OPcache vidé ✅\n" : "opcache_reset() a renvoyé false\n";

if (function_exists('opcache_get_status')) {
    $status = @opcache_get_status(false);
    echo 'OPcache activé : ' . (($status['opcache_enabled'] ?? false) ? 'oui' : 'non') . "\n";
    echo 'validate_timestamps : ' . (ini_get('opcache.validate_timestamps') ?: '0') . "\n";
    echo 'revalidate_freq : ' . (ini_get('opcache.revalidate_freq') ?: '0') . "\n";
}

echo 'Heure : ' . date('Y-m-d H:i:s') . "\n";
