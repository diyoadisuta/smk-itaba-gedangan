<?php
/**
 * Pemasang (Installer) CMS SMK ITABA.
 *
 * 1. Bila config.php belum ada, tampilkan formulir koneksi database (MySQL / SQLite).
 * 2. Buat tabel database & isi seluruh konten awal website (seed).
 * 3. Buat akun Administrator pertama.
 * 4. Bila admin sudah ada, halaman ini otomatis terkunci demi keamanan.
 */
declare(strict_types=1);

define('INSTALLER', true);
require __DIR__ . '/includes/bootstrap.php';
require INC_DIR . '/seed.php';

session_boot();

$errors  = [];
$hasConfig = is_file(ROOT_DIR . '/config.php');
$dbReady = false;
$hasAdmin = false;

if ($hasConfig) {
    try {
        db_create_tables();
        $dbReady = true;
        $hasAdmin = (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn() > 0;
    } catch (Throwable $e) {
        $errors[] = 'Koneksi database gagal: ' . $e->getMessage();
    }
}

// Langkah 1: simpan config.php
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['step'] ?? '') === 'config' && !$hasAdmin) {
    csrf_check();
    $driver = ($_POST['driver'] ?? 'mysql') === 'sqlite' ? 'sqlite' : 'mysql';
    $host   = trim((string) ($_POST['host'] ?? 'localhost'));
    $port   = max(1, (int) ($_POST['port'] ?? 3306));
    $name   = trim((string) ($_POST['name'] ?? ''));
    $user   = trim((string) ($_POST['user'] ?? ''));
    $pass   = (string) ($_POST['pass'] ?? '');

    if ($driver === 'mysql' && ($name === '' || $user === '')) {
        $errors[] = 'Nama database dan user database wajib diisi.';
    } else {
        $cfg = [
            'db' => [
                'driver'      => $driver,
                'host'        => $host,
                'port'        => $port,
                'name'        => $name,
                'user'        => $user,
                'pass'        => $pass,
                'charset'     => 'utf8mb4',
                'sqlite_path' => 'storage/database.sqlite',
            ],
            'timezone'        => 'Asia/Jakarta',
            'upload_max_mb'   => 8,
            'image_max_width' => 1600,
            'debug'           => false,
        ];
        $GLOBALS['CONFIG'] = $cfg;
        try {
            db_create_tables();
            $export = "<?php\nreturn " . var_export($cfg, true) . ";\n";
            file_put_contents(ROOT_DIR . '/config.php', $export);
            redirect('install.php');
        } catch (Throwable $e) {
            $errors[] = 'Tidak dapat terhubung ke database: ' . $e->getMessage();
        }
    }
}

// Langkah 2: isi konten awal & buat akun admin
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['step'] ?? '') === 'admin' && $dbReady && !$hasAdmin) {
    csrf_check();
    $username = strtolower(trim((string) ($_POST['username'] ?? '')));
    $name     = trim((string) ($_POST['name'] ?? 'Administrator'));
    $password = (string) ($_POST['password'] ?? '');
    $confirm  = (string) ($_POST['password_confirm'] ?? '');

    if (!preg_match('/^[a-z0-9_.\-]{3,40}$/', $username)) {
        $errors[] = 'Username harus 3–40 karakter (huruf kecil, angka, titik, garis bawah).';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password minimal 8 karakter.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Konfirmasi password tidak sama.';
    }

    if (!$errors) {
        // Simpan seluruh pengaturan default bila belum ada.
        if ((int) db()->query('SELECT COUNT(*) FROM settings')->fetchColumn() === 0) {
            settings_save(setting_defaults());
        }
        seed_run();

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare('INSERT INTO users (username, name, password_hash, role, created_at) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$username, $name !== '' ? $name : 'Administrator', $hash, 'admin', now()]);

        $_SESSION['uid'] = (int) db()->lastInsertId();
        $_SESSION['last_seen'] = time();
        flash('success', 'Instalasi selesai! Selamat datang di CMS SMK ITABA.');
        redirect('admin/index.php');
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Instalasi CMS SMK ITABA</title>
  <link rel="stylesheet" href="admin/admin.css">
</head>
<body class="auth-body">
  <main class="auth-card" style="max-width:520px">
    <div class="auth-brand">
      <img src="assets/img/logo-itaba-256.png" alt="Logo SMK ITABA">
      <div><strong>CMS SMK ITABA</strong><span>Pemasangan Awal</span></div>
    </div>

    <?php foreach ($errors as $err): ?>
      <div class="alert alert--error"><?= e($err) ?></div>
    <?php endforeach; ?>

    <?php if ($hasAdmin): ?>
      <h1>CMS Sudah Terpasang</h1>
      <p class="muted">Database dan akun administrator sudah aktif. Demi keamanan, hapus file <code>install.php</code> dari server hosting Anda.</p>
      <div class="form-actions" style="margin-top:20px">
        <a class="btn btn--primary" href="admin/login.php">Masuk ke Panel Admin →</a>
        <a class="btn" href="index.php">Lihat Website</a>
      </div>

    <?php elseif (!$dbReady): ?>
      <h1>1. Koneksi Database</h1>
      <p class="muted">Masukkan detail database MySQL dari cPanel hosting Anda.</p>
      <form method="post" class="stack">
        <?= csrf_field() ?>
        <input type="hidden" name="step" value="config">
        <div class="field">
          <label for="driver">Jenis Database</label>
          <select id="driver" name="driver" onchange="document.getElementById('mysql-fields').hidden = this.value === 'sqlite'">
            <option value="mysql">MySQL / MariaDB (Hosting cPanel — Disarankan)</option>
            <option value="sqlite">SQLite (File lokal / uji coba)</option>
          </select>
        </div>
        <div id="mysql-fields" class="stack">
          <div class="grid-2">
            <div class="field"><label for="host">Host</label><input id="host" name="host" value="<?= e($_POST['host'] ?? 'localhost') ?>" required></div>
            <div class="field"><label for="port">Port</label><input id="port" name="port" type="number" value="<?= e($_POST['port'] ?? '3306') ?>" required></div>
          </div>
          <div class="field"><label for="name">Nama Database</label><input id="name" name="name" value="<?= e($_POST['name'] ?? '') ?>" placeholder="contoh: u12345_itaba"></div>
          <div class="field"><label for="user">User Database</label><input id="user" name="user" value="<?= e($_POST['user'] ?? '') ?>" placeholder="contoh: u12345_admin"></div>
          <div class="field"><label for="pass">Password Database</label><input id="pass" name="pass" type="password"></div>
        </div>
        <button class="btn btn--primary" type="submit">Hubungkan &amp; Lanjut →</button>
      </form>

    <?php else: ?>
      <h1>2. Buat Akun Administrator</h1>
      <p class="muted">Seluruh konten website saat ini (profil, jurusan, guru, galeri, prestasi, dan SPMB) akan otomatis dimasukkan ke database.</p>
      <form method="post" class="stack">
        <?= csrf_field() ?>
        <input type="hidden" name="step" value="admin">
        <div class="field"><label for="name">Nama Lengkap</label><input id="name" name="name" value="<?= e($_POST['name'] ?? 'Admin SMK ITABA') ?>" required></div>
        <div class="field"><label for="username">Username Login</label><input id="username" name="username" value="<?= e($_POST['username'] ?? 'admin') ?>" required autocomplete="username"></div>
        <div class="field"><label for="password">Password (minimal 8 karakter)</label><input id="password" name="password" type="password" required minlength="8" autocomplete="new-password"></div>
        <div class="field"><label for="password_confirm">Ulangi Password</label><input id="password_confirm" name="password_confirm" type="password" required minlength="8" autocomplete="new-password"></div>
        <button class="btn btn--primary" type="submit">Pasang CMS &amp; Masuk →</button>
      </form>
    <?php endif; ?>
  </main>
</body>
</html>
