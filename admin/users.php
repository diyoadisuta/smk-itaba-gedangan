<?php
declare(strict_types=1);
require __DIR__ . '/_layout.php';

$me = require_admin();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_check();
    $act = (string) ($_POST['action'] ?? '');

    if ($act === 'create') {
        $username = strtolower(trim((string) ($_POST['username'] ?? '')));
        $name     = trim((string) ($_POST['name'] ?? ''));
        $role     = ($_POST['role'] ?? 'editor') === 'admin' ? 'admin' : 'editor';
        $password = (string) ($_POST['password'] ?? '');

        if (!preg_match('/^[a-z0-9_.\-]{3,40}$/', $username)) {
            flash('error', 'Username harus 3–40 karakter (huruf kecil, angka, titik, garis bawah).');
        } elseif (strlen($password) < 8) {
            flash('error', 'Password minimal 8 karakter.');
        } else {
            try {
                $stmt = db()->prepare('INSERT INTO users (username, name, password_hash, role, created_at) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$username, $name !== '' ? $name : $username, password_hash($password, PASSWORD_DEFAULT), $role, now()]);
                flash('success', 'Akun "' . $username . '" berhasil dibuat.');
            } catch (PDOException $e) {
                flash('error', 'Username sudah digunakan.');
            }
        }
        redirect('users.php');
    }

    if ($act === 'password') {
        $uid = (int) ($_POST['id'] ?? 0);
        $pw  = (string) ($_POST['password'] ?? '');
        if (strlen($pw) < 8) {
            flash('error', 'Password baru minimal 8 karakter.');
        } else {
            db()->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([password_hash($pw, PASSWORD_DEFAULT), $uid]);
            flash('success', 'Password berhasil diperbarui.');
        }
        redirect('users.php');
    }

    if ($act === 'delete') {
        $uid = (int) ($_POST['id'] ?? 0);
        if ($uid === (int) $me['id']) {
            flash('error', 'Anda tidak dapat menghapus akun yang sedang dipakai.');
        } else {
            db()->prepare('DELETE FROM users WHERE id = ?')->execute([$uid]);
            flash('success', 'Akun dihapus.');
        }
        redirect('users.php');
    }
}

$users = db()->query('SELECT id, username, name, role, last_login, created_at FROM users ORDER BY id ASC')->fetchAll();

admin_header('Akun Pengelola', 'users');
?>
<div class="page-lead">
  <div>
    <h1>Akun Pengelola</h1>
    <p>Tambah pengelola baru atau ganti password. Peran <strong>Editor</strong> dapat mengelola seluruh konten tetapi tidak dapat mengelola akun.</p>
  </div>
</div>

<section class="card" style="padding:0;overflow:hidden">
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Username</th>
          <th>Peran</th>
          <th>Login Terakhir</th>
          <th style="text-align:right">Ganti Password / Hapus</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><strong><?= e($u['name']) ?></strong></td>
            <td><code><?= e($u['username']) ?></code></td>
            <td><?= $u['role'] === 'admin' ? 'Administrator' : 'Editor' ?></td>
            <td><?= e($u['last_login'] ?: '—') ?></td>
            <td>
              <div class="row-actions">
                <form method="post" style="display:flex;gap:6px">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="password">
                  <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                  <input type="password" name="password" placeholder="Password baru (min 8)" minlength="8" required style="padding:5px 9px;border:1px solid #c8d3cc;border-radius:6px;font-size:12.5px">
                  <button type="submit" class="btn btn--sm">Simpan</button>
                </form>
                <?php if ((int) $u['id'] !== (int) $me['id']): ?>
                  <form method="post" data-confirm="Hapus akun @<?= e($u['username']) ?>?">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                    <button type="submit" class="btn btn--sm btn--danger">Hapus</button>
                  </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<section class="card">
  <div class="card-head"><h2>Tambah Akun Baru</h2></div>
  <form method="post" class="stack">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="create">
    <div class="grid-2">
      <div class="field"><label for="name">Nama Lengkap</label><input id="name" name="name" required></div>
      <div class="field"><label for="username">Username Login</label><input id="username" name="username" required placeholder="huruf kecil tanpa spasi"></div>
    </div>
    <div class="grid-2">
      <div class="field">
        <label for="role">Peran</label>
        <select id="role" name="role">
          <option value="editor">Editor (kelola konten)</option>
          <option value="admin">Administrator (akses penuh)</option>
        </select>
      </div>
      <div class="field"><label for="password">Password (minimal 8 karakter)</label><input id="password" name="password" type="password" minlength="8" required></div>
    </div>
    <div><button type="submit" class="btn btn--primary">+ Buat Akun</button></div>
  </form>
</section>
<?php admin_footer(); ?>
