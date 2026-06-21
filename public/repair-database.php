<?php
/**
 * ⚠️ REPAIR DATABASE SCRIPT — STANDALONE
 * This script adds missing columns to the 'coupons' table in production.
 * IT WILL SELF-DELETE AFTER RUNNING.
 */

define('LARAVEL_START', microtime(true));

// Load .env
$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    die("❌ .env file not found.");
}

$env = [];
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    $parts = explode('=', $line, 2);
    if (count($parts) === 2) {
        $env[trim($parts[0])] = trim($parts[1], " \t\n\r\0\x0B\"'");
    }
}

$db_host = $env['DB_HOST'] ?? '127.0.0.1';
$db_port = $env['DB_PORT'] ?? '3306';
$db_name = $env['DB_DATABASE'] ?? '';
$db_user = $env['DB_USERNAME'] ?? '';
$db_pass = $env['DB_PASSWORD'] ?? '';

if (!$db_name || !$db_user) {
    die("❌ Database configuration missing in .env");
}

try {
    $dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    echo "<h1>🛠️ Database Repair Script</h1>";
    echo "<pre>";

    // Column: banner_image
    $checkBanner = $pdo->query("SHOW COLUMNS FROM coupons LIKE 'banner_image'")->fetch();
    if (!$checkBanner) {
        $pdo->exec("ALTER TABLE coupons ADD COLUMN banner_image VARCHAR(191) NULL AFTER category_id");
        echo "✅ Added 'banner_image' column.\n";
    } else {
        echo "ℹ️ 'banner_image' already exists.\n";
    }

    // Column: category_id_n1
    $checkN1 = $pdo->query("SHOW COLUMNS FROM coupons LIKE 'category_id_n1'")->fetch();
    if (!$checkN1) {
        $pdo->exec("ALTER TABLE coupons ADD COLUMN category_id_n1 BIGINT(20) UNSIGNED NULL AFTER banner_image");
        echo "✅ Added 'category_id_n1' column.\n";
    } else {
        echo "ℹ️ 'category_id_n1' already exists.\n";
    }

    // Column: category_id_n2
    $checkN2 = $pdo->query("SHOW COLUMNS FROM coupons LIKE 'category_id_n2'")->fetch();
    if (!$checkN2) {
        $pdo->exec("ALTER TABLE coupons ADD COLUMN category_id_n2 BIGINT(20) UNSIGNED NULL AFTER category_id_n1");
        echo "✅ Added 'category_id_n2' column.\n";
    } else {
        echo "ℹ️ 'category_id_n2' already exists.\n";
    }

    // Mark migrations as complete
    $migrations = [
        '2026_06_20_235602_add_images_to_coupons_table',
        '2026_06_21_000337_add_category_levels_to_coupons_table'
    ];

    $checkBatch = $pdo->query("SELECT MAX(batch) as max_batch FROM migrations")->fetch();
    $nextBatch = ($checkBatch['max_batch'] ?? 0) + 1;

    foreach ($migrations as $m) {
        $exists = $pdo->prepare("SELECT id FROM migrations WHERE migration = ?");
        $exists->execute([$m]);
        if (!$exists->fetch()) {
            $insert = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
            $insert->execute([$m, $nextBatch]);
            echo "✅ Marked migration $m as complete.\n";
        } else {
            echo "ℹ️ Migration $m already recorded.\n";
        }
    }

    echo "\n🚀 Database is now up to date!";
    echo "</pre>";

} catch (PDOException $e) {
    die("❌ Database Error: " . $e->getMessage());
} finally {
    // SELF-DELETE
    if (file_exists(__FILE__)) {
        unlink(__FILE__);
        echo "<p>🗑️ This script has been automatically deleted for security.</p>";
    }
}
