<?php
declare(strict_types=1);
require __DIR__ . '/_layout.php';

$schema = settings_schema();
$group  = (string) ($_GET['g'] ?? 'umum');
if (!isset($schema[$group])) {
    redirect('index.php');
}
$def = $schema[$group];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_check();
    $postData = is_array($_POST['s'] ?? null) ? $_POST['s'] : [];
    $toSave   = [];

    try {
        foreach ($def['sections'] as $fields) {
            foreach ($fields as $field) {
                $fullKey = $field['name'];
                $oldVal  = s($fullKey);
                $toSave[$fullKey] = collect_field_value($field, $postData, 'upload_s_', $group, $oldVal);
            }
        }
        settings_save($toSave);
        flash('success', 'Perubahan pada "' . $def['title'] . '" berhasil disimpan.');
        redirect('page.php?g=' . rawurlencode($group));
    } catch (Throwable $e) {
        flash('error', $e->getMessage());
    }
}

// Daftar koleksi yang berkaitan dengan grup halaman ini.
$relatedCollections = [];
foreach (collections_schema() as $cKey => $cDef) {
    if (($cDef['group'] ?? '') === $group) {
        $relatedCollections[$cKey] = $cDef;
    }
}

admin_header($def['title'], 'page:' . $group);
?>
<div class="page-lead">
  <div>
    <h1><?= e($def['title']) ?></h1>
    <p><?= e($def['desc']) ?></p>
  </div>
  <?php if (!empty($def['page'])): ?>
    <a class="btn" href="../<?= e($def['page']) ?>" target="_blank" rel="noreferrer">Buka Halaman Ini ↗</a>
  <?php endif; ?>
</div>

<?php if ($relatedCollections): ?>
  <div class="related-bar">
    <strong>Daftar terkait halaman ini:</strong>
    <?php foreach ($relatedCollections as $cKey => $cDef): ?>
      <a class="btn btn--sm" href="items.php?c=<?= e($cKey) ?>"><?= e($cDef['title']) ?> (<?= items_count($cKey) ?>) →</a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <?php foreach ($def['sections'] as $sectionTitle => $fields): ?>
    <section class="card">
      <div class="card-head"><h2><?= e($sectionTitle) ?></h2></div>
      <div class="stack">
        <?php foreach ($fields as $field): ?>
          <?php render_field($field, s($field['name']), 's'); ?>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>

  <div class="sticky-save">
    <span class="muted">Pastikan menyimpan setelah mengubah isi.</span>
    <button type="submit" class="btn btn--primary">Simpan Perubahan</button>
  </div>
</form>
<?php admin_footer(); ?>
