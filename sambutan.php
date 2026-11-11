<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$activePage = 'sambutan';
$pageTitle  = s('sambutan.meta_title');
$pageDesc   = s('sambutan.meta_description');

$guru = items('guru');

require INC_DIR . '/header.php';
?>
  <main id="konten">
    <section class="page-hero" data-watermark="<?= e(s('sambutan.hero_watermark')) ?>">
      <div class="container page-hero-inner">
        <nav class="breadcrumb reveal" aria-label="Breadcrumb"><a href="index.php">Beranda</a><span aria-hidden="true">/</span><span aria-current="page">Sambutan</span></nav>
        <p class="eyebrow reveal"><?= e(s('sambutan.hero_eyebrow')) ?></p>
        <h1 class="reveal" data-delay="1"><?= rich(s('sambutan.hero_title')) ?></h1>
        <p class="reveal" data-delay="2"><?= e(s('sambutan.hero_text')) ?></p>
      </div>
    </section>

    <!-- Sambutan Kepala Sekolah -->
    <section class="section" id="kepala-sekolah" aria-labelledby="sambutan-title">
      <div class="container welcome-grid">
        <figure class="principal reveal">
          <img src="<?= e(asset(s('sambutan.kepsek_foto'))) ?>" alt="<?= e(s('sambutan.kepsek_nama')) ?>, <?= e(s('sambutan.kepsek_jabatan')) ?>">
          <figcaption><span><?= e(s('sambutan.kepsek_label')) ?></span><strong><?= e(s('sambutan.kepsek_nama')) ?></strong></figcaption>
        </figure>
        <div class="welcome-quote reveal" data-delay="1">
          <p class="eyebrow"><?= e(s('sambutan.sambutan_eyebrow')) ?></p>
          <h2 id="sambutan-title" class="display"><?= rich(s('sambutan.sambutan_title')) ?></h2>
          <span class="quote-mark" aria-hidden="true">“</span>
          <blockquote><?= e(s('sambutan.sambutan_quote')) ?></blockquote>
          <div style="margin-bottom:28px;color:#4b5a52;line-height:1.75"><?= paragraphs(s('sambutan.sambutan_body')) ?></div>
          <div class="signature">
            <span class="icon-badge icon-badge--lime"><?= icon('user') ?></span>
            <div><strong><?= e(s('sambutan.kepsek_nama')) ?></strong><span><?= e(s('sambutan.kepsek_jabatan')) ?></span></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Warga sekolah / Tenaga Pendidik & Kependidikan -->
    <section class="section section--tint" id="pendidik" aria-labelledby="pendidik-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('sambutan.pendidik_eyebrow')) ?></p>
            <h2 id="pendidik-title" class="display"><?= rich(s('sambutan.pendidik_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('sambutan.pendidik_text')) ?></p>
        </div>

        <div class="people-grid">
          <?php foreach ($guru as $i => $gr): ?>
            <article class="person<?= !empty($gr['featured']) ? ' featured' : '' ?> reveal"<?= $i % 3 ? ' data-delay="' . ($i % 3) . '"' : '' ?>>
              <div class="person-photo"><img src="<?= e(asset($gr['foto'] ?? '')) ?>" alt="<?= e($gr['nama'] ?? '') ?>" loading="lazy"></div>
              <div class="person-info">
                <div>
                  <span class="person-role"><?= e($gr['jabatan'] ?? '') ?></span>
                  <strong><?= e($gr['nama'] ?? '') ?></strong>
                </div>
                <p class="person-message"><?= e($gr['pesan'] ?? '') ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="section" aria-label="Halaman selanjutnya">
      <div class="container">
        <a class="next-page reveal" id="next-kontak" href="kontak.php">
          <div><small>Selanjutnya</small><strong>Kunjungi &amp; Hubungi Kami</strong></div>
          <span class="tile-arrow" aria-hidden="true">→</span>
        </a>
      </div>
    </section>
  </main>
<?php require INC_DIR . '/footer.php'; ?>

