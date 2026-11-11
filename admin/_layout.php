<?php
/**
 * Bootstrap & tata letak panel admin.
 */
declare(strict_types=1);

define('BASE_PREFIX', '../');
require dirname(__DIR__) . '/includes/bootstrap.php';

/** Render satu field form berdasarkan definisi skema. */
function render_field(array $field, string $value, string $prefix = ''): void
{
    $name = $prefix !== '' ? $prefix . '[' . $field['key'] . ']' : $field['key'];
    $id   = 'f_' . preg_replace('/[^a-z0-9_]+/i', '_', $name);
    $type = $field['type'] ?? 'text';
    $req  = !empty($field['required']) ? ' required' : '';
    $help = $field['help'] ?? '';

    if ($type === 'checkbox') {
        $checked = ($value === '1' || $value === 'true') ? ' checked' : '';
        echo '<label class="check-field"><input type="checkbox" name="' . e($name) . '" value="1"' . $checked . '><span>' . e($field['label']) . '</span></label>';
        if ($help !== '') {
            echo '<small class="field-help">' . e($help) . '</small>';
        }
        return;
    }

    echo '<div class="field">';
    echo '<label for="' . e($id) . '">' . e($field['label']);
    if (!empty($field['required'])) {
        echo ' <span class="req">*</span>';
    }
    echo '</label>';

    switch ($type) {
        case 'textarea':
            echo '<textarea id="' . e($id) . '" name="' . e($name) . '" rows="3"' . $req . '>' . e($value) . '</textarea>';
            break;

        case 'rich':
            if (!empty($field['multiline'])) {
                echo '<textarea id="' . e($id) . '" name="' . e($name) . '" rows="4"' . $req . '>' . e($value) . '</textarea>';
            } else {
                echo '<input id="' . e($id) . '" name="' . e($name) . '" type="text" value="' . e($value) . '"' . $req . '>';
            }
            $help = ($help !== '' ? $help . ' · ' : '') . 'Boleh memakai <em>teks miring</em>, <strong>tebal</strong>, dan <br> untuk ganti baris.';
            break;

        case 'richarea':
            echo '<textarea id="' . e($id) . '" name="' . e($name) . '" rows="6"' . $req . '>' . e($value) . '</textarea>';
            $help = ($help !== '' ? $help . ' · ' : '') . 'Boleh memakai <strong>tebal</strong> dan <em>miring</em>.';
            break;

        case 'lines':
            echo '<textarea id="' . e($id) . '" name="' . e($name) . '" rows="5"' . $req . '>' . e($value) . '</textarea>';
            break;

        case 'select':
            $opts = $field['options'] ?? [];
            if (!empty($field['options_from'])) {
                $opts = collection_options($field['options_from']);
            }
            echo '<select id="' . e($id) . '" name="' . e($name) . '"' . $req . '>';
            foreach ($opts as $k => $lbl) {
                $sel = (string) $k === $value ? ' selected' : '';
                echo '<option value="' . e((string) $k) . '"' . $sel . '>' . e($lbl) . '</option>';
            }
            echo '</select>';
            break;

        case 'icon':
            echo '<div class="icon-picker">';
            echo '<span class="icon-preview" data-icon-preview="' . e($id) . '">' . icon($value !== '' ? $value : 'star') . '</span>';
            echo '<select id="' . e($id) . '" name="' . e($name) . '" data-icon-select>';
            foreach (icon_options() as $k => $lbl) {
                $sel = $k === $value ? ' selected' : '';
                echo '<option value="' . e($k) . '"' . $sel . '>' . e($lbl) . '</option>';
            }
            echo '</select></div>';
            break;

        case 'image':
            $fileKey = 'upload_' . preg_replace('/[^a-z0-9_]+/i', '_', $name);
            echo '<div class="image-field">';
            if ($value !== '') {
                echo '<div class="image-preview"><img src="' . e(asset($value)) . '" alt=""><code>' . e($value) . '</code></div>';
            }
            echo '<div class="image-inputs">';
            echo '<input type="file" name="' . e($fileKey) . '" accept="image/jpeg,image/png,image/webp,image/gif">';
            echo '<input id="' . e($id) . '" name="' . e($name) . '" type="text" value="' . e($value) . '" placeholder="Atau tulis path/URL gambar"' . $req . '>';
            echo '</div></div>';
            $help = ($help !== '' ? $help . ' · ' : '') . 'Pilih file baru untuk mengganti (JPG/PNG/WebP, maks ' . config('upload_max_mb', 8) . ' MB). Otomatis dikompres.';
            break;

        case 'url':
        case 'email':
        case 'number':
            echo '<input id="' . e($id) . '" name="' . e($name) . '" type="' . e($type) . '" value="' . e($value) . '"' . $req . '>';
            break;

        default:
            echo '<input id="' . e($id) . '" name="' . e($name) . '" type="text" value="' . e($value) . '"' . $req . '>';
    }

    if ($help !== '') {
        echo '<small class="field-help">' . e($help) . '</small>';
    }
    echo '</div>';
}

/** Memproses nilai field dari $_POST dan $_FILES. */
function collect_field_value(array $field, array $postSource, string $uploadPrefix, string $subdir, string $oldValue = ''): string
{
    $key  = $field['key'];
    $type = $field['type'] ?? 'text';

    if ($type === 'checkbox') {
        return !empty($postSource[$key]) ? '1' : '';
    }

    $val = isset($postSource[$key]) ? trim((string) $postSource[$key]) : '';

    if ($type === 'image') {
        $fileKey = $uploadPrefix . $key;
        if (!empty($_FILES[$fileKey]['name']) && ($_FILES[$fileKey]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            $newPath = handle_image_upload($_FILES[$fileKey], $subdir);
            if ($oldValue !== '' && $oldValue !== $newPath) {
                delete_upload($oldValue);
            }
            return $newPath;
        }
    }

    return $val;
}

function admin_header(string $title, string $activeNav = ''): void
{
    $reqPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '';
    if (preg_match('#/admin$#', $reqPath)) {
        redirect('/admin/index.php');
    }
    $user = require_login();
    $groups = settings_schema();
    $collections = collections_schema();
    ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title) ?> — Admin <?= e(s('umum.site_name')) ?></title>
  <link rel="icon" href="<?= e(asset(s('umum.logo'))) ?>" type="image/png">
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="admin-shell">
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-brand">
        <img src="<?= e(asset(s('umum.logo'))) ?>" alt="">
        <div><strong><?= e(s('umum.site_name')) ?></strong><span>Panel Pengelola</span></div>
      </div>

      <nav class="sidebar-nav">
        <a href="index.php" class="<?= $activeNav === 'dashboard' ? 'active' : '' ?>"><?= icon('compass') ?><span>Dasbor</span></a>

        <p class="nav-section">Pengaturan &amp; Halaman</p>
        <?php foreach ($groups as $gKey => $gDef): ?>
          <a href="page.php?g=<?= e($gKey) ?>" class="<?= $activeNav === 'page:' . $gKey ? 'active' : '' ?>"><?= icon($gDef['icon'] ?? 'book') ?><span><?= e($gDef['title']) ?></span></a>
        <?php endforeach; ?>

        <p class="nav-section">Daftar Konten</p>
        <?php
        $mainCollections = ['program', 'guru', 'prestasi', 'potret_juara', 'dokumentasi', 'album', 'fasilitas', 'ekskul', 'spmb_gelombang', 'spmb_biaya', 'spmb_syarat'];
        foreach ($mainCollections as $cKey):
            $cDef = $collections[$cKey];
        ?>
          <a href="items.php?c=<?= e($cKey) ?>" class="<?= $activeNav === 'col:' . $cKey ? 'active' : '' ?>"><span class="nav-dot"></span><span><?= e($cDef['title']) ?></span></a>
        <?php endforeach; ?>

        <?php if (is_admin()): ?>
          <p class="nav-section">Sistem</p>
          <a href="users.php" class="<?= $activeNav === 'users' ? 'active' : '' ?>"><?= icon('users') ?><span>Akun Pengelola</span></a>
        <?php endif; ?>
      </nav>

      <div class="sidebar-foot">
        <div class="user-pill">
          <strong><?= e($user['name']) ?></strong>
          <small>@<?= e($user['username']) ?> · <?= $user['role'] === 'admin' ? 'Admin' : 'Editor' ?></small>
        </div>
        <a class="btn btn--sm" href="logout.php">Keluar</a>
      </div>
    </aside>

    <div class="main-area">
      <header class="topbar-admin">
        <button type="button" class="btn btn--sm mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">☰ Menu</button>
        <div class="topbar-title"><?= e($title) ?></div>
        <div class="topbar-actions">
          <a class="btn btn--sm" href="../index.php" target="_blank" rel="noreferrer">Lihat Website ↗</a>
        </div>
      </header>

      <main class="content">
        <?php foreach (flashes() as $fl): ?>
          <div class="alert alert--<?= e($fl['type']) ?>"><?= e($fl['message']) ?></div>
        <?php endforeach; ?>
    <?php
}

function admin_footer(): void
{
    $iconMap = [];
    foreach (icon_library() as $k => [, $paths]) {
        $iconMap[$k] = $paths;
    }
    ?>
      </main>
    </div>
  </div>
  <script>
    const ICONS = <?= json_encode($iconMap, JSON_UNESCAPED_SLASHES) ?>;
    document.querySelectorAll('[data-icon-select]').forEach((sel) => {
      sel.addEventListener('change', () => {
        const box = document.querySelector(`[data-icon-preview="${sel.id}"] svg`);
        if (box && ICONS[sel.value]) box.innerHTML = ICONS[sel.value];
      });
    });
    document.querySelectorAll('[data-confirm]').forEach((el) => {
      el.addEventListener('submit', (e) => {
        if (!confirm(el.getAttribute('data-confirm'))) e.preventDefault();
      });
    });
  </script>
</body>
</html>
    <?php
}

