<?php
/**
 * Bootstrap CMS: memuat konfigurasi, koneksi database, sesi, dan helper.
 * Setiap halaman publik maupun admin memanggil file ini terlebih dahulu.
 */
declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));
define('INC_DIR', __DIR__);
define('UPLOAD_DIR', ROOT_DIR . '/assets/uploads');
define('UPLOAD_URL', 'assets/uploads');

// Prefix relatif menuju root website ('' untuk halaman publik, '../' untuk admin).
if (!defined('BASE_PREFIX')) {
    define('BASE_PREFIX', '');
}

$configFile = ROOT_DIR . '/config.php';
if (!is_file($configFile)) {
    if (!defined('INSTALLER')) {
        http_response_code(503);
        echo '<!doctype html><meta charset="utf-8"><title>Belum dikonfigurasi</title>'
            . '<div style="font-family:sans-serif;max-width:560px;margin:80px auto;line-height:1.6">'
            . '<h1>Website belum dikonfigurasi</h1>'
            . '<p>Salin <code>config.sample.php</code> menjadi <code>config.php</code>, isi data database, '
            . 'lalu buka <a href="' . BASE_PREFIX . 'install.php">install.php</a>.</p></div>';
        exit;
    }
    $GLOBALS['CONFIG'] = require ROOT_DIR . '/config.sample.php';
} else {
    $GLOBALS['CONFIG'] = require $configFile;
}

function config(string $key, $default = null)
{
    $value = $GLOBALS['CONFIG'];
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

date_default_timezone_set((string) config('timezone', 'Asia/Jakarta'));

if (config('debug')) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}

require INC_DIR . '/db.php';
require INC_DIR . '/helpers.php';
require INC_DIR . '/icons.php';
require INC_DIR . '/schema.php';

