<?php
declare(strict_types=1);
require __DIR__ . '/_layout.php';

admin_header('Dasbor', 'dashboard');

$cards = [
    ['Program Keahlian', items_count('program'), 'items.php?c=program'],
    ['Pendidik & Tendik', items_count('guru'), 'items.php?c=guru'],
    ['Prestasi Siswa', items_count('prestasi'), 'items.php?c=prestasi'],
    ['Foto Dokumentasi', items_count('dokumentasi'), 'items.php?c=dokumentasi'],
    ['Album Google Drive', items_count('album'), 'items.php?c=album'],
    ['Fasilitas Sekolah', items_count('fasilitas'), 'items.php?c=fasilitas'],
    ['Kategori Ekskul', items_count('ekskul'), 'items.php?c=ekskul'],
    ['Gelombang SPMB', items_count('spmb_gelombang'), 'items.php?c=spmb_gelombang'],
];
?>
<?php if (is_file(ROOT_DIR . '/install.php')): ?>
  <div class="alert alert--error">
    <strong>Penting untuk keamanan:</strong> Setelah website terpasang di hosting, hapus file <code>install.php</code> melalui File Manager cPanel.
  </div>
<?php endif; ?>

<div class="page-lead">
  <div>
    <h1>Selamat datang, <?= e(current_user()['name']) ?></h1>
    <p>Pilih halaman atau daftar konten yang ingin Anda perbarui.</p>
  </div>
  <div class="form-actions">
    <a class="btn btn--primary" href="items.php?c=prestasi&amp;action=new">+ Tambah Prestasi</a>
    <a class="btn btn--primary" href="items.php?c=dokumentasi&amp;action=new">+ Tambah Foto Dokumentasi</a>
  </div>
</div>

<div class="stat-cards">
  <?php foreach ($cards as [$label, $count, $href]): ?>
    <a class="stat-card" href="<?= e($href) ?>">
      <strong><?= (int) $count ?></strong>
      <span><?= e($label) ?> →</span>
    </a>
  <?php endforeach; ?>
</div>

<section class="card">
  <div class="card-head"><h2>Kelola Teks &amp; Gambar per Halaman</h2></div>
  <div class="stat-cards" style="margin-bottom:0">
    <?php foreach (settings_schema() as $gKey => $gDef): ?>
      <a class="stat-card" href="page.php?g=<?= e($gKey) ?>">
        <strong style="font-size:16px"><?= e($gDef['title']) ?></strong>
        <span><?= e($gDef['desc']) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="card">
  <div class="card-head"><h2>Panduan Singkat</h2></div>
  <ul style="margin:0;padding-left:18px;color:var(--muted);display:grid;gap:6px">
    <li><strong>Mengubah teks/judul/kontak:</strong> buka menu di bagian <em>Pengaturan &amp; Halaman</em> di sebelah kiri, ubah isinya, lalu klik <strong>Simpan Perubahan</strong>.</li>
    <li><strong>Menambah/mengurutkan daftar</strong> (guru, prestasi, foto, fasilitas, ekskul, biaya SPMB): buka menu di bagian <em>Daftar Konten</em>. Gunakan tombol <strong>↑</strong> dan <strong>↓</strong> untuk mengatur urutan tampil.</li>
    <li><strong>Mengganti foto:</strong> cukup pilih file JPG/PNG/WebP dari komputer atau HP. Sistem otomatis memperkecil ukuran file agar website tetap cepat.</li>
  </ul>
</section>
<?php admin_footer(); ?>

