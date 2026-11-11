<?php
declare(strict_types=1);
require __DIR__ . '/_layout.php';

$collection = (string) ($_GET['c'] ?? '');
$def = collection_def($collection);
if (!$def) {
    redirect('index.php');
}

$action = (string) ($_GET['action'] ?? 'list');
$id     = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_check();
    $postAction = (string) ($_POST['action'] ?? 'save');
    $postId     = (int) ($_POST['id'] ?? 0);

    try {
        if ($postAction === 'delete' && $postId > 0) {
            $existing = item_find($postId);
            if ($existing && $existing['_collection'] === $collection) {
                foreach ($def['fields'] as $f) {
                    if (($f['type'] ?? '') === 'image' && !empty($existing[$f['key']])) {
                        delete_upload((string) $existing[$f['key']]);
                    }
                }
                item_delete($postId);
                flash('success', ucfirst($def['singular']) . ' berhasil dihapus.');
            }
            redirect('items.php?c=' . rawurlencode($collection));
        }

        if ($postAction === 'move' && $postId > 0) {
            $dir = ((string) ($_POST['dir'] ?? 'up')) === 'up' ? -1 : 1;
            item_move($postId, $dir);
            redirect('items.php?c=' . rawurlencode($collection));
        }

        if ($postAction === 'toggle' && $postId > 0) {
            $existing = item_find($postId);
            if ($existing && $existing['_collection'] === $collection) {
                item_set_active($postId, !$existing['_active']);
            }
            redirect('items.php?c=' . rawurlencode($collection));
        }

        if ($postAction === 'save') {
            $existing = $postId > 0 ? item_find($postId) : null;
            if ($postId > 0 && (!$existing || $existing['_collection'] !== $collection)) {
                redirect('items.php?c=' . rawurlencode($collection));
            }
            $input  = is_array($_POST['d'] ?? null) ? $_POST['d'] : [];
            $active = !empty($_POST['is_active']);
            $data   = [];

            foreach ($def['fields'] as $field) {
                $key    = $field['key'];
                $oldVal = (string) ($existing[$key] ?? '');
                $data[$key] = collect_field_value($field, $input, 'upload_d_', $collection, $oldVal);
                if (!empty($field['required']) && $data[$key] === '') {
                    throw new RuntimeException('Kolom "' . $field['label'] . '" wajib diisi.');
                }
            }

            if ($existing) {
                item_update($postId, $data, $active);
                flash('success', ucfirst($def['singular']) . ' berhasil diperbarui.');
            } else {
                item_create($collection, $data, $active);
                flash('success', ucfirst($def['singular']) . ' baru berhasil ditambahkan.');
            }
            redirect('items.php?c=' . rawurlencode($collection));
        }
    } catch (Throwable $e) {
        flash('error', $e->getMessage());
        $action = $postId > 0 ? 'edit' : 'new';
        $id     = $postId;
    }
}

$groupKey = $def['group'] ?? '';
$groupDef = settings_schema()[$groupKey] ?? null;

admin_header($def['title'], 'col:' . $collection);

if ($action === 'new' || $action === 'edit'):
    $editing = $action === 'edit' ? item_find($id) : null;
    if ($action === 'edit' && (!$editing || $editing['_collection'] !== $collection)) {
        redirect('items.php?c=' . rawurlencode($collection));
    }
    $posted = is_array($_POST['d'] ?? null) ? $_POST['d'] : null;
    $isActive = $editing ? $editing['_active'] : true;
    ?>
    <div class="page-lead">
      <div>
        <h1><?= $editing ? 'Ubah ' : 'Tambah ' ?><?= e(ucfirst($def['singular'])) ?></h1>
        <p><a href="items.php?c=<?= e($collection) ?>">← Kembali ke daftar <?= e($def['title']) ?></a></p>
      </div>
    </div>

    <form method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= (int) ($editing['_id'] ?? 0) ?>">

      <section class="card">
        <div class="stack">
          <?php foreach ($def['fields'] as $field):
              $k = $field['key'];
              $val = $posted[$k] ?? ($editing[$k] ?? ($field['default'] ?? ''));
              render_field($field, (string) $val, 'd');
          endforeach; ?>

          <hr style="border:0;border-top:1px solid var(--line);margin:4px 0">
          <label class="check-field">
            <input type="checkbox" name="is_active" value="1"<?= $isActive ? ' checked' : '' ?>>
            <span>Tampilkan di website</span>
          </label>
        </div>
      </section>

      <div class="form-actions">
        <button type="submit" class="btn btn--primary">Simpan</button>
        <a class="btn" href="items.php?c=<?= e($collection) ?>">Batal</a>
      </div>
    </form>
<?php else:
    $rows = items($collection, false);
    $thumbKey = $def['thumb'] ?? '';
    $cols = $def['columns'] ?? [];
    $fieldLabels = [];
    foreach ($def['fields'] as $f) {
        $fieldLabels[$f['key']] = $f['label'];
    }
    ?>
    <div class="page-lead">
      <div>
        <h1><?= e($def['title']) ?></h1>
        <p>
          <?= e($def['desc'] ?? ('Kelola daftar ' . strtolower($def['title']) . '.')) ?>
          <?php if ($groupDef): ?>
            · Bagian dari halaman <a href="page.php?g=<?= e($groupKey) ?>"><strong><?= e($groupDef['title']) ?></strong></a>
          <?php endif; ?>
        </p>
      </div>
      <div class="form-actions">
        <?php if (!empty($groupDef['page'])): ?>
          <a class="btn" href="../<?= e($groupDef['page']) ?>" target="_blank" rel="noreferrer">Lihat di Website ↗</a>
        <?php endif; ?>
        <a class="btn btn--primary" href="items.php?c=<?= e($collection) ?>&amp;action=new">+ Tambah <?= e(ucfirst($def['singular'])) ?></a>
      </div>
    </div>

    <?php
    // Tampilkan pintasan ke sub-koleksi bila sedang di halaman prestasi / dokumentasi.
    $siblingCollections = [];
    if ($groupKey !== '') {
        foreach (collections_schema() as $cKey => $cDef) {
            if (($cDef['group'] ?? '') === $groupKey && $cKey !== $collection) {
                $siblingCollections[$cKey] = $cDef;
            }
        }
    }
    if ($siblingCollections): ?>
      <div class="related-bar">
        <strong>Daftar lain di halaman <?= e($groupDef['title'] ?? '') ?>:</strong>
        <?php foreach ($siblingCollections as $cKey => $cDef): ?>
          <a class="btn btn--sm" href="items.php?c=<?= e($cKey) ?>"><?= e($cDef['title']) ?> (<?= items_count($cKey) ?>)</a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <section class="card" style="padding:0;overflow:hidden">
      <?php if (!$rows): ?>
        <div style="padding:36px;text-align:center">
          <p class="muted">Belum ada data pada daftar ini.</p>
          <a class="btn btn--primary" href="items.php?c=<?= e($collection) ?>&amp;action=new">+ Tambah <?= e(ucfirst($def['singular'])) ?> Pertama</a>
        </div>
      <?php else: ?>
        <div class="table-wrap">
          <table class="data-table">
            <thead>
              <tr>
                <th style="width:44px">#</th>
                <?php if ($thumbKey !== ''): ?><th style="width:74px">Foto</th><?php endif; ?>
                <?php foreach ($cols as $ck): ?><th><?= e($fieldLabels[$ck] ?? ucfirst($ck)) ?></th><?php endforeach; ?>
                <th style="width:90px">Status</th>
                <th style="text-align:right;width:240px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $idx => $r): ?>
                <tr class="<?= $r['_active'] ? '' : 'is-inactive' ?>">
                  <td><?= $idx + 1 ?></td>
                  <?php if ($thumbKey !== ''): ?>
                    <td>
                      <?php if (!empty($r[$thumbKey])): ?>
                        <img class="thumb" src="<?= e(asset((string) $r[$thumbKey])) ?>" alt="">
                      <?php endif; ?>
                    </td>
                  <?php endif; ?>
                  <?php foreach ($cols as $ci => $ck): ?>
                    <td>
                      <?php if ($ci === 0): ?>
                        <a href="items.php?c=<?= e($collection) ?>&amp;action=edit&amp;id=<?= $r['_id'] ?>"><strong><?= e((string) ($r[$ck] ?? '—')) ?></strong></a>
                      <?php else: ?>
                        <?= e((string) ($r[$ck] ?? '')) ?>
                      <?php endif; ?>
                    </td>
                  <?php endforeach; ?>
                  <td>
                    <form method="post" style="display:inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="action" value="toggle">
                      <input type="hidden" name="id" value="<?= $r['_id'] ?>">
                      <button type="submit" class="badge-status <?= $r['_active'] ? 'on' : 'off' ?>" style="border:0;cursor:pointer" title="Klik untuk mengubah status">
                        <?= $r['_active'] ? 'Tampil' : 'Sembunyi' ?>
                      </button>
                    </form>
                  </td>
                  <td>
                    <div class="row-actions">
                      <form method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="move">
                        <input type="hidden" name="id" value="<?= $r['_id'] ?>">
                        <input type="hidden" name="dir" value="up">
                        <button type="submit" class="btn btn--sm" title="Naikkan urutan"<?= $idx === 0 ? ' disabled' : '' ?>>↑</button>
                      </form>
                      <form method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="move">
                        <input type="hidden" name="id" value="<?= $r['_id'] ?>">
                        <input type="hidden" name="dir" value="down">
                        <button type="submit" class="btn btn--sm" title="Turunkan urutan"<?= $idx === count($rows) - 1 ? ' disabled' : '' ?>>↓</button>
                      </form>
                      <a class="btn btn--sm" href="items.php?c=<?= e($collection) ?>&amp;action=edit&amp;id=<?= $r['_id'] ?>">Ubah</a>
                      <form method="post" data-confirm="Hapus <?= e($def['singular']) ?> ini?">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $r['_id'] ?>">
                        <button type="submit" class="btn btn--sm btn--danger">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </section>
<?php endif;
admin_footer();
