<?php
// ⚠️ SCRIPT TEMPORAIRE — SUPPRIMER APRÈS UTILISATION
// Lit la config Laravel pour la connexion DB
$env = [];
foreach (file(__DIR__ . '/../.env') as $line) {
    $line = trim($line);
    if ($line && !str_starts_with($line, '#') && str_contains($line, '=')) {
        [$key, $val] = explode('=', $line, 2);
        $env[trim($key)] = trim($val, '"\'');
    }
}

try {
    $pdo = new PDO(
        "mysql:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_DATABASE']};charset=utf8mb4",
        $env['DB_USERNAME'],
        $env['DB_PASSWORD']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $results = [];

    // Vérifier et ajouter category_id_n1
    $cols = $pdo->query("SHOW COLUMNS FROM `coupons` LIKE 'category_id_n1'")->fetchAll();
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `coupons` ADD COLUMN `category_id_n1` BIGINT UNSIGNED NULL AFTER `category_id`");
        $results[] = "✅ Colonne <b>category_id_n1</b> ajoutée.";
    } else {
        $results[] = "ℹ️ Colonne <b>category_id_n1</b> existait déjà.";
    }

    // Vérifier et ajouter category_id_n2
    $cols2 = $pdo->query("SHOW COLUMNS FROM `coupons` LIKE 'category_id_n2'")->fetchAll();
    if (empty($cols2)) {
        $pdo->exec("ALTER TABLE `coupons` ADD COLUMN `category_id_n2` BIGINT UNSIGNED NULL AFTER `category_id_n1`");
        $results[] = "✅ Colonne <b>category_id_n2</b> ajoutée.";
    } else {
        $results[] = "ℹ️ Colonne <b>category_id_n2</b> existait déjà.";
    }

    // Marquer la migration comme faite dans la table migrations
    $existing = $pdo->query("SELECT * FROM `migrations` WHERE `migration` = '2026_06_21_000337_add_category_levels_to_coupons_table'")->fetchAll();
    if (empty($existing)) {
        $batch = $pdo->query("SELECT MAX(`batch`) as b FROM `migrations`")->fetch()['b'] ?? 1;
        $pdo->exec("INSERT INTO `migrations` (`migration`, `batch`) VALUES ('2026_06_21_000337_add_category_levels_to_coupons_table', " . ($batch + 1) . ")");
        $results[] = "✅ Migration enregistrée dans la table migrations.";
    }

    // Auto-suppression
    @unlink(__FILE__);
    $results[] = "🗑️ Ce fichier a été <b>supprimé automatiquement</b>.";

    echo '<div style="font-family:monospace;background:#1e1e1e;color:#d4d4d4;padding:24px;border-radius:8px;line-height:2">';
    echo '<h3 style="color:#4ec9b0">Migration réussie !</h3>';
    foreach ($results as $r) echo "<p>$r</p>";
    echo '</div>';

} catch (Exception $e) {
    echo '<pre style="background:#bf0000;color:#fff;padding:20px;border-radius:8px;">❌ Erreur : ' . $e->getMessage() . '</pre>';
}
