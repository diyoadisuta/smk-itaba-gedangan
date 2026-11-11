<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$activePage = 'program';
$pageTitle  = s('program.meta_title');
$pageDesc   = s('program.meta_description');

$programs = items('program');

require INC_DIR . '/header.php';
?>
  <main id="konten">
    <section class="page-hero" data-watermark="<?= e(s('program.hero_watermark')) ?>">
      <div class="container page-hero-inner">
        <nav class="breadcrumb reveal" aria-label="Breadcrumb"><a href="index.php">Beranda</a><span aria-hidden="true">/</span><span aria-current="page">Program Keahlian</span></nav>
        <p class="eyebrow reveal"><?= e(s('program.hero_eyebrow')) ?></p>
        <h1 class="reveal" data-delay="1"><?= rich(s('program.hero_title')) ?></h1>
        <p class="reveal" data-delay="2"><?= e(s('program.hero_text')) ?></p>
      </div>
    </section>

    <section class="section" aria-label="Daftar program keahlian">
      <div class="container">
        <?php foreach ($programs as $i => $pr):
          $style   = ($pr['gaya'] ?? 'dkv') === 'tkr' ? 'tkr' : 'dkv';
          $slug    = $pr['slug'] ?? strtolower($pr['singkatan'] ?? 'prog-' . ($i + 1));
          $reverse = $i % 2 === 1 ? ' reverse' : '';
          $tagColor = $style === 'tkr' ? 'var(--lime)' : 'var(--lime-soft)';
        ?>
          <article class="program-detail<?= $reverse ?> reveal" id="<?= e($slug) ?>" aria-labelledby="<?= e($slug) ?>-title">
            <div class="program-visual program-visual--<?= e($style) ?>">
              <span class="tile-symbol" aria-hidden="true"><?= e($pr['simbol'] ?? '✳') ?></span>
              <div class="tile-top">
                <span class="icon-badge icon-badge--lime"><?= icon($pr['icon'] ?? 'star') ?></span>
              </div>
              <div>
                <p class="tile-code"><?= e($pr['kode'] ?? '') ?></p>
                <h2 id="<?= e($slug) ?>-title"><?= e($pr['nama'] ?? '') ?><?php if (!empty($pr['singkatan'])): ?> <small><?= e($pr['singkatan']) ?></small><?php endif; ?></h2>
                <?php if (!empty($pr['tagline'])): ?>
                  <p style="margin-top:12px;font-size:14px;color:<?= $tagColor ?>"><em><?= e($pr['tagline']) ?></em></p>
                <?php endif; ?>
              </div>
            </div>
            <div class="program-body">
              <p class="lead"><?= e($pr['deskripsi'] ?? '') ?></p>

              <?php $skills = lines($pr['kompetensi'] ?? ''); if ($skills): ?>
                <p class="sub-label">Kompetensi yang Dipelajari</p>
                <ul class="skill-list">
                  <?php foreach ($skills as $sk): ?>
                    <li><?= icon('check') ?><?= e($sk) ?></li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>

              <?php $jobs = lines($pr['peluang'] ?? ''); if ($jobs): ?>
                <p class="sub-label">Peluang Kerja &amp; Ruang Berkarya</p>
                <div class="chips">
                  <?php foreach ($jobs as $jb): ?><span><?= e($jb) ?></span><?php endforeach; ?>
                </div>
              <?php endif; ?>

              <?php if (!empty($pr['highlight_judul']) || !empty($pr['highlight_teks'])): ?>
                <div class="highlight-box">
                  <?= icon('ball') ?>
                  <div>
                    <strong><?= e($pr['highlight_judul'] ?? '') ?></strong>
                    <p><?= e($pr['highlight_teks'] ?? '') ?></p>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="section section--tint" aria-labelledby="cta-title">
      <div class="container">
        <div class="cta-band reveal">
          <div>
            <p class="eyebrow"><?= e(s('program.cta_eyebrow')) ?></p>
            <h2 id="cta-title"><?= rich(s('program.cta_title')) ?></h2>
            <p><?= e(s('program.cta_text')) ?></p>
          </div>
          <div class="cta-actions">
            <a class="btn btn-primary" id="cta-spmb-btn" href="spmb.php">Info pendaftaran <span class="arrow">→</span></a>
          </div>
        </div>
      </div>
    </section>

    <section class="section" aria-label="Halaman selanjutnya">
      <div class="container">
        <a class="next-page reveal" id="next-galeri" href="galeri.php">
          <div><small>Selanjutnya</small><strong>Pustaka Galeri &amp; Instagram</strong></div>
          <span class="tile-arrow" aria-hidden="true">→</span>
        </a>
      </div>
    </section>
  </main>
<?php require INC_DIR . '/footer.php'; ?>

