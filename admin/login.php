<?php
declare(strict_types=1);

define('BASE_PREFIX', '../');
require dirname(__DIR__) . '/includes/bootstrap.php';

if (current_user()) {
    redirect('index.php');
}

$error = '';
if (!empty($_GET['expired'])) {
    $error = 'Sesi Anda telah berakhir karena tidak ada aktivitas. Silakan masuk kembali.';
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_check();
    if (login_throttled()) {
        $error = 'Terlalu banyak percobaan login gagal. Silakan tunggu 15 menit lalu coba lagi.';
    } else {
        $username = strtolower(trim((string) ($_POST['username'] ?? '')));
        $password = (string) ($_POST['password'] ?? '');

        $stmt = db()->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            login_clear_failures();
            session_regenerate_id(true);
            $_SESSION['uid'] = (int) $user['id'];
            $_SESSION['last_seen'] = time();
            db()->prepare('UPDATE users SET last_login = ? WHERE id = ?')->execute([now(), $user['id']]);
            redirect('index.php');
        } else {
            login_record_failure();
            $error = 'Username atau password salah.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk — Admin <?= e(s('umum.site_name')) ?></title>
  <link rel="icon" href="<?= e(asset(s('umum.logo'))) ?>" type="image/png">
  <link rel="stylesheet" href="admin.css">
</head>
<body class="auth-body">
  <main class="auth-card">
    <div class="auth-brand">
      <img src="<?= e(asset(s('umum.logo'))) ?>" alt="Logo <?= e(s('umum.site_name')) ?>">
      <div><strong><?= e(s('umum.site_name')) ?></strong><span>Panel Pengelola Website</span></div>
    </div>

    <h1>Masuk</h1>
    <p class="muted" style="margin-bottom:18px">Masukkan akun pengelola untuk mengubah konten website.</p>

    <?php if ($error !== ''): ?>
      <div class="alert alert--error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="stack">
      <?= csrf_field() ?>
      <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" required autofocus autocomplete="username" value="<?= e($_POST['username'] ?? '') ?>">
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">
      </div>
      <button class="btn btn--primary" type="submit">Masuk →</button>
    </form>

    <p style="margin-top:20px;font-size:12.5px;text-align:center"><a href="../index.php">← Kembali ke website</a></p>
  </main>
</body>
</html>
