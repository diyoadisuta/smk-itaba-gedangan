<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$activePage = 'profil';
$pageTitle  = s('profil.meta_title');
$pageDesc   = s('profil.meta_description');

$fakta      = items('fakta');
$rutinitas  = items('rutinitas');
$nilai      = items('nilai');
$fasilitas  = items('fasilitas');
$ekskul     = items('ekskul');
$marqueeWords = lines(s('profil.marquee')) ?: ['Berkarakter', 'Inovatif', 'Kompetitif'];

require INC_DIR . '/header.php';
?>
  <main id="konten">
    <section class="page-hero" data-watermark="<?= e(s('profil.hero_watermark')) ?>">
      <img class="page-hero-media" src="<?= e(asset(s('profil.hero_image'))) ?>" alt="">
      <div class="container page-hero-inner">
        <nav class="breadcrumb reveal" aria-label="Breadcrumb"><a href="index.php">Beranda</a><span aria-hidden="true">/</span><span aria-current="page">Profil</span></nav>
        <p class="eyebrow reveal"><?= e(s('profil.hero_eyebrow')) ?></p>
        <h1 class="reveal" data-delay="1"><?= rich(s('profil.hero_title')) ?></h1>
        <p class="reveal" data-delay="2"><?= e(s('profil.hero_text')) ?></p>
      </div>
    </section>

    <!-- Tentang kami -->
    <section class="section" id="tentang" aria-labelledby="tentang-title">
      <div class="container about-grid">
        <div class="about-copy reveal">
          <p class="eyebrow"><?= e(s('profil.tentang_eyebrow')) ?></p>
          <h2 id="tentang-title" class="display"><?= rich(s('profil.tentang_title')) ?></h2>
          <p class="lead"><?= e(s('profil.tentang_lead')) ?></p>
          <?= paragraphs(s('profil.tentang_body')) ?>
        </div>
        <aside class="fact-card reveal" data-delay="1" aria-label="Fakta sekolah">
          <div class="fact-big"><?= e(s('umum.tahun_berdiri')) ?></div>
          <p class="fact-caption"><?= e(s('profil.fact_caption')) ?></p>
          <dl class="fact-list">
            <?php foreach ($fakta as $f): ?>
              <div><dt><?= e($f['label'] ?? '') ?></dt><dd><?= e($f['nilai'] ?? '') ?></dd></div>
            <?php endforeach; ?>
          </dl>
        </aside>
      </div>
    </section>

    <!-- Pembiasaan Keagamaan / Rutinitas Pesantren -->
    <section class="section section--tint" id="pembiasaan" aria-labelledby="pembiasaan-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('profil.pembiasaan_eyebrow')) ?></p>
            <h2 id="pembiasaan-title" class="display"><?= rich(s('profil.pembiasaan_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('profil.pembiasaan_text')) ?></p>
        </div>

        <div class="routine-grid">
          <?php foreach ($rutinitas as $i => $rt): ?>
            <article class="routine-card reveal"<?= $i % 3 ? ' data-delay="' . ($i % 3) . '"' : '' ?>>
              <span class="routine-time"><?= e($rt['waktu'] ?? '') ?></span>
              <h3><?= e($rt['judul'] ?? '') ?></h3>
              <p><?= e($rt['deskripsi'] ?? '') ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Nilai Kami -->
    <section class="section" id="nilai" aria-labelledby="nilai-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('profil.nilai_eyebrow')) ?></p>
            <h2 id="nilai-title" class="display"><?= rich(s('profil.nilai_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('profil.nilai_text')) ?></p>
        </div>
        <div class="value-grid">
          <?php foreach ($nilai as $i => $nl): ?>
            <article class="value-card reveal"<?= $i % 3 ? ' data-delay="' . ($i % 3) . '"' : '' ?>>
              <span class="value-num"><?= num2($i + 1) ?></span>
              <span class="icon-badge"><?= icon($nl['icon'] ?? 'star') ?></span>
              <h3><?= e($nl['judul'] ?? '') ?></h3>
              <p><?= e($nl['deskripsi'] ?? '') ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- FASILITAS SEKOLAH -->
    <section class="section section--tint" id="fasilitas" aria-labelledby="fasilitas-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('profil.fasilitas_eyebrow')) ?></p>
            <h2 id="fasilitas-title" class="display"><?= rich(s('profil.fasilitas_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('profil.fasilitas_text')) ?></p>
        </div>

        <div class="facility-lead-box reveal">
          <div class="facility-lead-badge">
            <strong><?= e(s('profil.fasilitas_badge_big')) ?></strong>
            <span><?= e(s('profil.fasilitas_badge_small')) ?></span>
          </div>
          <p><?= rich(s('profil.fasilitas_lead')) ?></p>
        </div>

        <div class="facility-grid">
          <?php foreach ($fasilitas as $i => $fs): ?>
            <article class="facility-card reveal"<?= $i % 3 ? ' data-delay="' . ($i % 3) . '"' : '' ?>>
              <span class="icon-badge"><?= icon($fs['icon'] ?? 'building') ?></span>
              <div><strong><?= e($fs['nama'] ?? '') ?></strong><small><?= e($fs['keterangan'] ?? '') ?></small></div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- EKSKUL & KOMUNITAS BELAJAR -->
    <section class="section" id="ekskul" aria-labelledby="ekskul-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('profil.ekskul_eyebrow')) ?></p>
            <h2 id="ekskul-title" class="display"><?= rich(s('profil.ekskul_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('profil.ekskul_text')) ?></p>
        </div>

        <div class="ekskul-category-grid">
          <?php foreach ($ekskul as $i => $ek): ?>
            <article class="ekskul-category reveal"<?= $i % 2 ? ' data-delay="1"' : '' ?>>
              <div>
                <div class="ekskul-cat-head">
                  <span class="icon-badge<?= !empty($ek['aksen']) ? ' icon-badge--lime' : '' ?>"><?= icon($ek['icon'] ?? 'star') ?></span>
                  <div>
                    <h3><?= e($ek['judul'] ?? '') ?></h3>
                    <p><?= e($ek['subjudul'] ?? '') ?></p>
                  </div>
                </div>
                <ul class="ekskul-list" style="margin-top:20px">
                  <?php foreach (lines($ek['daftar'] ?? '') as $ln):
                    [$namaEks, $tagEks] = split_pair($ln);
                  ?>
                    <li><span class="ekskul-dot"></span><span><?= e($namaEks) ?></span><?php if ($tagEks !== ''): ?><span class="ekskul-tag"><?= e($tagEks) ?></span><?php endif; ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Sejarah -->
    <section class="section section--tint" id="sejarah" aria-labelledby="sejarah-title">
      <div class="container split">
        <div class="media-frame reveal">
          <img src="<?= e(asset(s('profil.sejarah_image'))) ?>" alt="Tampak gedung <?= e(s('umum.site_name')) ?>" loading="lazy">
          <span class="media-tag"><?= e(s('profil.sejarah_tag')) ?></span>
        </div>
        <div class="history-copy reveal" data-delay="1">
          <p class="eyebrow"><?= e(s('profil.sejarah_eyebrow')) ?></p>
          <h2 id="sejarah-title" class="display"><?= rich(s('profil.sejarah_title')) ?></h2>
          <?= paragraphs(s('profil.sejarah_body')) ?>
          <?php if (s('profil.sejarah_quote') !== ''): ?>
            <blockquote class="pull-quote"><?= e(s('profil.sejarah_quote')) ?></blockquote>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Motto -->
    <div class="marquee" aria-label="<?= e(implode(', ', $marqueeWords)) ?>">
      <div class="marquee-track" aria-hidden="true">
        <?php for ($r = 0; $r < 4; $r++): foreach ($marqueeWords as $mw): ?>
          <span><?= e($mw) ?></span>
        <?php endforeach; endfor; ?>
      </div>
    </div>

    <section class="section" aria-label="Halaman selanjutnya">
      <div class="container">
        <a class="next-page reveal" id="next-program" href="program.php">
          <div><small>Selanjutnya</small><strong>Program Keahlian DKV &amp; TKR</strong></div>
          <span class="tile-arrow" aria-hidden="true">→</span>
        </a>
      </div>
    </section>
  </main>
<?php require INC_DIR . '/footer.php'; ?>

