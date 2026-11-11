<?php
/**
 * Fungsi bantu umum: escaping, konten, URL aset, sesi/login, CSRF, upload gambar.
 */
declare(strict_types=1);

/* ------------------------------------------------------------------ */
/* Escaping & format konten                                            */
/* ------------------------------------------------------------------ */

/** Escape teks biasa untuk HTML. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Teks "kaya" terbatas: hanya mengizinkan <br>, <em>, <strong>, <b>, <i>, <u>, <small>, <a href>.
 * Atribut lain dibuang agar aman dari XSS.
 */
function rich($html): string
{
    $html = strip_tags((string) $html, '<br><em><strong><b><i><u><small><a>');
    $html = preg_replace_callback('#<(/?)([a-z]+)([^>]*)>#i', static function (array $m): string {
        $tag = strtolower($m[2]);
        if ($m[1] === '/') {
            return $tag === 'br' ? '' : "</$tag>";
        }
        if ($tag === 'a') {
            if (preg_match('#href\s*=\s*(["\'])(.*?)\1#i', $m[3], $h)) {
                $href = trim(html_entity_decode($h[2], ENT_QUOTES, 'UTF-8'));
                if (preg_match('#^(https?:|mailto:|tel:|\#|[a-z0-9_\-]+\.php)#i', $href)) {
                    $ext = preg_match('#^https?:#i', $href) ? ' target="_blank" rel="noreferrer"' : '';
                    return '<a href="' . e($href) . '"' . $ext . '>';
                }
            }
            return '<a>';
        }
        return $tag === 'br' ? '<br>' : "<$tag>";
    }, $html);
    // Rapikan karakter & yang belum di-encode.
    return preg_replace('/&(?!#?[a-z0-9]+;)/i', '&amp;', $html);
}

/** Teks kaya multi-paragraf: setiap baris kosong memisahkan paragraf <p>. */
function paragraphs($text, string $class = ''): string
{
    $blocks = preg_split('/\R\s*\R/', trim((string) $text)) ?: [];
    $out = '';
    $attr = $class !== '' ? ' class="' . e($class) . '"' : '';
    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') {
            continue;
        }
        $out .= '<p' . $attr . '>' . nl2br(rich($block), false) . '</p>';
    }
    return $out;
}

/** Memecah teks menjadi daftar baris yang tidak kosong. */
function lines($text): array
{
    $result = [];
    foreach (preg_split('/\R/', (string) $text) ?: [] as $line) {
        $line = trim($line);
        if ($line !== '') {
            $result[] = $line;
        }
    }
    return $result;
}

/** Memecah baris "Nama | Tag" menjadi pasangan [nama, tag]. */
function split_pair(string $line, string $sep = '|'): array
{
    $parts = array_map('trim', explode($sep, $line, 2));
    return [$parts[0], $parts[1] ?? ''];
}

/** Memecah teks berkoma menjadi array. */
function csv_list($text): array
{
    return array_values(array_filter(array_map('trim', explode(',', (string) $text)), 'strlen'));
}

/** Nomor urut 2 digit: 1 => "01". */
function num2(int $n): string
{
    return str_pad((string) $n, 2, '0', STR_PAD_LEFT);
}

/* ------------------------------------------------------------------ */
/* Settings                                                            */
/* ------------------------------------------------------------------ */

/** Mengambil nilai pengaturan; bila belum diisi di database memakai default dari schema. */
function s(string $key): string
{
    $all = settings_all();
    if (array_key_exists($key, $all) && $all[$key] !== null) {
        return (string) $all[$key];
    }
    return (string) (setting_defaults()[$key] ?? '');
}

/* ------------------------------------------------------------------ */
/* URL & aset                                                          */
/* ------------------------------------------------------------------ */

function is_external_url(string $url): bool
{
    return (bool) preg_match('#^([a-z][a-z0-9+.\-]*:|//)#i', $url);
}

/** URL aset relatif terhadap root website (aman untuk halaman admin di subfolder). */
function asset(string $path): string
{
    $path = trim($path);
    if ($path === '' || is_external_url($path)) {
        return $path;
    }
    return BASE_PREFIX . ltrim($path, '/');
}

/** Hanya izinkan URL http(s), mailto, tel, atau path relatif. */
function safe_url(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '';
    }
    if (preg_match('#^(https?:|mailto:|tel:|\#|/)#i', $url) || !preg_match('#^[a-z][a-z0-9+.\-]*:#i', $url)) {
        return $url;
    }
    return '#';
}

/** Ambil ID YouTube dari URL atau ID mentah. */
function youtube_id(string $input): string
{
    $input = trim($input);
    if (preg_match('#(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([A-Za-z0-9_\-]{11})#', $input, $m)) {
        return $m[1];
    }
    return preg_match('#^[A-Za-z0-9_\-]{11}$#', $input) ? $input : '';
}

function maps_url(): string
{
    return 'https://maps.google.com/?q=' . rawurlencode(s('umum.maps_query'));
}

function maps_embed_url(): string
{
    return 'https://maps.google.com/maps?q=' . rawurlencode(s('umum.maps_query')) . '&output=embed';
}

/** Nomor WhatsApp => link wa.me. */
function whatsapp_url(string $number): string
{
    $digits = preg_replace('/\D+/', '', $number);
    if ($digits === '') {
        return '';
    }
    if (strpos($digits, '0') === 0) {
        $digits = '62' . substr($digits, 1);
    }
    return 'https://wa.me/' . $digits;
}

/* ------------------------------------------------------------------ */
/* Sesi, login & CSRF                                                  */
/* ------------------------------------------------------------------ */

function session_boot(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') === '443');
    session_name('itaba_cms');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function current_user(): ?array
{
    session_boot();
    static $user = false;
    if ($user !== false) {
        return $user;
    }
    $user = null;
    if (!empty($_SESSION['uid'])) {
        $stmt = db()->prepare('SELECT id, username, name, role FROM users WHERE id = ?');
        $stmt->execute([(int) $_SESSION['uid']]);
        $user = $stmt->fetch() ?: null;
    }
    return $user;
}

function is_admin(): bool
{
    $u = current_user();
    return $u !== null && $u['role'] === 'admin';
}

function require_login(): array
{
    $user = current_user();
    if (!$user) {
        redirect('/admin/login.php');
    }
    // Sesi kedaluwarsa setelah 2 jam tanpa aktivitas.
    if (isset($_SESSION['last_seen']) && time() - (int) $_SESSION['last_seen'] > 7200) {
        session_destroy();
        redirect('/admin/login.php?expired=1');
    }
    $_SESSION['last_seen'] = time();
    return $user;
}

function require_admin(): array
{
    $user = require_login();
    if ($user['role'] !== 'admin') {
        flash('error', 'Halaman ini hanya untuk Administrator.');
        redirect('index.php');
    }
    return $user;
}

function csrf_token(): string
{
    session_boot();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    session_boot();
    $token = $_POST['_csrf'] ?? '';
    if (!is_string($token) || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $token)) {
        http_response_code(419);
        exit('Sesi formulir kedaluwarsa. Silakan kembali, muat ulang halaman, lalu coba lagi.');
    }
}

function flash(string $type, string $message): void
{
    session_boot();
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function flashes(): array
{
    session_boot();
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function client_ip(): string
{
    return substr((string) ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'), 0, 64);
}

/** Batasi percobaan login: maks 5 kali gagal per 15 menit per IP. */
function login_throttled(): bool
{
    $since = date('Y-m-d H:i:s', time() - 900);
    db()->prepare('DELETE FROM login_attempts WHERE attempted_at < ?')->execute([$since]);
    $stmt = db()->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip = ? AND attempted_at >= ?');
    $stmt->execute([client_ip(), $since]);
    return (int) $stmt->fetchColumn() >= 5;
}

function login_record_failure(): void
{
    db()->prepare('INSERT INTO login_attempts (ip, attempted_at) VALUES (?, ?)')->execute([client_ip(), now()]);
}

function login_clear_failures(): void
{
    db()->prepare('DELETE FROM login_attempts WHERE ip = ?')->execute([client_ip()]);
}

/* ------------------------------------------------------------------ */
/* Upload gambar                                                       */
/* ------------------------------------------------------------------ */

/**
 * Memproses upload gambar: validasi tipe & ukuran, resize, konversi ke WebP (bila GD tersedia).
 * Mengembalikan path relatif (mis. "assets/uploads/2026/11/foto-ab12cd.webp").
 *
 * @throws RuntimeException bila file tidak valid.
 */
function handle_image_upload(array $file, string $subdir = ''): string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $errors = [
            UPLOAD_ERR_INI_SIZE   => 'Ukuran file melebihi batas server.',
            UPLOAD_ERR_FORM_SIZE  => 'Ukuran file terlalu besar.',
            UPLOAD_ERR_PARTIAL    => 'Upload terputus, silakan coba lagi.',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder sementara server tidak tersedia.',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis file ke server.',
        ];
        throw new RuntimeException($errors[$file['error']] ?? 'Upload gagal.');
    }

    $maxBytes = (int) config('upload_max_mb', 8) * 1024 * 1024;
    if ($file['size'] > $maxBytes) {
        throw new RuntimeException('Ukuran gambar maksimal ' . config('upload_max_mb', 8) . ' MB.');
    }
    if (!is_uploaded_file($file['tmp_name']) && !defined('CMS_TESTING')) {
        throw new RuntimeException('File upload tidak valid.');
    }

    $info = @getimagesize($file['tmp_name']);
    $allowed = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG  => 'png',
        IMAGETYPE_GIF  => 'gif',
        IMAGETYPE_WEBP => 'webp',
    ];
    if ($info === false || !isset($allowed[$info[2]])) {
        throw new RuntimeException('Format gambar harus JPG, PNG, GIF, atau WebP.');
    }
    $type = $info[2];
    $ext  = $allowed[$type];

    $subdir = trim($subdir, '/');
    $relDir = UPLOAD_URL . '/' . ($subdir !== '' ? $subdir . '/' : '') . date('Y/m');
    $absDir = ROOT_DIR . '/' . $relDir;
    if (!is_dir($absDir) && !mkdir($absDir, 0775, true) && !is_dir($absDir)) {
        throw new RuntimeException('Folder upload tidak dapat dibuat. Periksa izin folder assets/uploads.');
    }

    $base = strtolower(pathinfo((string) $file['name'], PATHINFO_FILENAME));
    $base = trim(preg_replace('/[^a-z0-9]+/', '-', $base) ?? '', '-');
    $base = substr($base !== '' ? $base : 'gambar', 0, 50) . '-' . bin2hex(random_bytes(3));

    $maxWidth = (int) config('image_max_width', 1600);
    $canProcess = function_exists('imagecreatetruecolor') && $type !== IMAGETYPE_GIF;

    if ($canProcess) {
        $src = null;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = @imagecreatefromjpeg($file['tmp_name']);
                break;
            case IMAGETYPE_PNG:
                $src = @imagecreatefrompng($file['tmp_name']);
                break;
            case IMAGETYPE_WEBP:
                $src = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file['tmp_name']) : null;
                break;
        }
        if ($src) {
            // Koreksi orientasi foto dari kamera HP.
            if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
                $exif = @exif_read_data($file['tmp_name']);
                $rotate = [3 => 180, 6 => -90, 8 => 90][$exif['Orientation'] ?? 0] ?? 0;
                if ($rotate) {
                    $rotated = imagerotate($src, $rotate, 0);
                    if ($rotated) {
                        imagedestroy($src);
                        $src = $rotated;
                    }
                }
            }
            $w = imagesx($src);
            $h = imagesy($src);
            if ($w > $maxWidth) {
                $nw = $maxWidth;
                $nh = (int) round($h * $maxWidth / $w);
                $dst = imagecreatetruecolor($nw, $nh);
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                imagedestroy($src);
                $src = $dst;
            } else {
                imagealphablending($src, false);
                imagesavealpha($src, true);
            }

            if (function_exists('imagewebp')) {
                $rel = $relDir . '/' . $base . '.webp';
                $ok = imagewebp($src, ROOT_DIR . '/' . $rel, 82);
            } elseif ($type === IMAGETYPE_PNG) {
                $rel = $relDir . '/' . $base . '.png';
                $ok = imagepng($src, ROOT_DIR . '/' . $rel, 8);
            } else {
                $rel = $relDir . '/' . $base . '.jpg';
                $ok = imagejpeg($src, ROOT_DIR . '/' . $rel, 85);
            }
            imagedestroy($src);
            if ($ok) {
                return $rel;
            }
        }
    }

    // Tanpa GD / GIF: simpan file asli.
    $rel = $relDir . '/' . $base . '.' . $ext;
    $target = ROOT_DIR . '/' . $rel;
    $moved = defined('CMS_TESTING') ? copy($file['tmp_name'], $target) : move_uploaded_file($file['tmp_name'], $target);
    if (!$moved) {
        throw new RuntimeException('Gagal menyimpan gambar.');
    }
    return $rel;
}

/** Hapus file upload lama (hanya file di dalam assets/uploads). */
function delete_upload(string $path): void
{
    $path = str_replace('\\', '/', trim($path));
    if (strpos($path, UPLOAD_URL . '/') !== 0 || strpos($path, '..') !== false) {
        return;
    }
    $abs = ROOT_DIR . '/' . $path;
    if (is_file($abs)) {
        @unlink($abs);
    }
}

