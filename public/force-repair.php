<?php
/**
 * ⚠️ FORCE REPAIR DATABASE SCRIPT
 * This script ensures all missing tables and columns are present.
 */

define('LARAVEL_START', microtime(true));

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

try {
    $dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    echo "<h1>🛠️ Force Database Repair</h1>";
    echo "<pre>";

    // Column: banner_image
    $checkBanner = $pdo->query("SHOW COLUMNS FROM coupons LIKE 'banner_image'")->fetch();
    if (!$checkBanner) {
        $pdo->exec("ALTER TABLE coupons ADD COLUMN banner_image VARCHAR(191) NULL AFTER category_id");
        echo "✅ Added 'banner_image' column.\n";
    }

    // Column: landing_page_image
    $checkLanding = $pdo->query("SHOW COLUMNS FROM coupons LIKE 'landing_page_image'")->fetch();
    if (!$checkLanding) {
        $pdo->exec("ALTER TABLE coupons ADD COLUMN landing_page_image VARCHAR(191) NULL AFTER banner_image");
        echo "✅ Added 'landing_page_image' column.\n";
    }

    // Category levels
    foreach(['category_id_n1', 'category_id_n2'] as $col) {
        $check = $pdo->query("SHOW COLUMNS FROM coupons LIKE '$col'")->fetch();
        if (!$check) {
            $pdo->exec("ALTER TABLE coupons ADD COLUMN $col BIGINT(20) UNSIGNED NULL");
            echo "✅ Added '$col' column.\n";
        }
    }

    // Table: campaigns
    $checkCampaigns = $pdo->query("SHOW TABLES LIKE 'campaigns'")->fetch();
    if (!$checkCampaigns) {
        $pdo->exec("CREATE TABLE campaigns (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            coupon_id BIGINT(20) UNSIGNED NOT NULL,
            target_type ENUM('particulier', 'professionnel', 'all') DEFAULT 'all',
            subject VARCHAR(191) NOT NULL,
            message TEXT NOT NULL,
            sent_count INT DEFAULT 0,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            CONSTRAINT fk_campaign_coupon FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "✅ Created 'campaigns' table.\n";
    } else {
        echo "ℹ️ 'campaigns' table already exists.\n";
    }

    echo "\n🚀 Done! Please delete this file (/public/force-repair.php) manually after use.";
    echo "</pre>";

} catch (PDOException $e) {
    die("❌ Database Error: " . $e->getMessage());
}
