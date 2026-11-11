<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$activePage = 'spmb';
$bodyClass  = 'spmb-page';
$pageTitle  = s('spmb.meta_title');
$pageDesc   = s('spmb.meta_description');

$gelombang = items('spmb_gelombang');
$biaya     = items('spmb_biaya');
$syarat    = items('spmb_syarat');
$formUrl   = safe_url(s('umum.spmb_form_url'));

require INC_DIR . '/header.php';
?>
  <main id="konten">
    <section class="page-hero" data-watermark="<?= e(s('spmb.hero_watermark')) ?>">
      <div class="container page-hero-inner">
        <nav class="breadcrumb reveal" aria-label="Breadcrumb"><a href="index.php">Beranda</a><span aria-hidden="true">/</span><span aria-current="page"><?= e(s('umum.spmb_label')) ?></span></nav>
        <p class="eyebrow reveal"><?= e(s('spmb.hero_eyebrow')) ?></p>
        <h1 class="reveal" data-delay="1"><?= rich(s('spmb.hero_title')) ?></h1>
        <p class="reveal" data-delay="2"><?= e(s('spmb.hero_text')) ?></p>
        <?php if ($formUrl !== ''): ?>
          <a class="btn btn-lime reveal" data-delay="3" id="hero-form-btn" href="<?= e($formUrl) ?>" target="_blank" rel="noreferrer"><?= e(s('spmb.hero_button')) ?> <span class="arrow">↗</span></a>
        <?php endif; ?>
      </div>
      <?php if (s('spmb.badge_image') !== ''): ?>
        <img class="spmb-badge-img reveal" src="<?= e(asset(s('spmb.badge_image'))) ?>" alt="Lencana <?= e(s('umum.spmb_label')) ?>" loading="lazy">
      <?php endif; ?>
    </section>

    <nav class="subnav" aria-label="Navigasi halaman SPMB">
      <div class="container subnav-inner">
        <a href="#jadwal" class="active">Jadwal</a>
        <a href="#biaya">Biaya</a>
        <a href="#syarat">Persyaratan</a>
        <a href="#daftar">Daftar &amp; bertanya</a>
        <a href="#lokasi">Sekretariat</a>
      </div>
    </nav>

    <!-- Jadwal -->
    <section class="section" id="jadwal" aria-labelledby="jadwal-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('spmb.jadwal_eyebrow')) ?></p>
            <h2 id="jadwal-title" class="display"><?= rich(s('spmb.jadwal_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('spmb.jadwal_text')) ?></p>
        </div>
        <div class="round-grid">
          <?php foreach ($gelombang as $i => $gl):
            $feat = !empty($gl['featured']);
          ?>
            <article class="round<?= $feat ? ' round--featured' : '' ?> reveal"<?= $i % 3 ? ' data-delay="' . ($i % 3) . '"' : '' ?>>
              <span class="round-index"><?= num2($i + 1) ?></span>
              <span class="icon-badge<?= $feat ? ' icon-badge--lime' : '' ?>"><?= icon('calendar') ?></span>
              <p class="round-label"><?= e($gl['label'] ?? '') ?></p>
              <strong><?= e($gl['tanggal'] ?? '') ?></strong>
              <small><?= e($gl['keterangan'] ?? '') ?></small>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Biaya -->
    <section class="section section--dark on-dark" id="biaya" aria-labelledby="biaya-title">
      <div class="container cost-grid">
        <div class="reveal">
          <p class="eyebrow"><?= e(s('spmb.biaya_eyebrow')) ?></p>
          <h2 id="biaya-title" class="display"><?= rich(s('spmb.biaya_title')) ?></h2>
          <p class="lead"><?= e(s('spmb.biaya_text')) ?></p>
        </div>
        <div class="cost-list reveal" data-delay="1">
          <?php foreach ($biaya as $by): ?>
            <div class="cost-row"><span><?= e($by['item'] ?? '') ?></span><strong><?= e($by['nominal'] ?? '') ?></strong></div>
          <?php endforeach; ?>
          <?php if (s('spmb.biaya_cakupan') !== ''): ?>
            <p><?= rich(s('spmb.biaya_cakupan')) ?></p>
          <?php endif; ?>
          <?php if (s('spmb.biaya_spp') !== ''): ?>
            <p class="spp-note"><?= icon('info') ?><span><?= e(s('spmb.biaya_spp')) ?></span></p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Persyaratan -->
    <section class="section" id="syarat" aria-labelledby="syarat-title">
      <div class="container req-grid">
        <div class="reveal">
          <p class="eyebrow"><?= e(s('spmb.syarat_eyebrow')) ?></p>
          <h2 id="syarat-title" class="display"><?= rich(s('spmb.syarat_title')) ?></h2>
          <p><?= e(s('spmb.syarat_text')) ?></p>
          <?php if ($formUrl !== ''): ?>
            <a class="link-arrow" href="<?= e($formUrl) ?>" target="_blank" rel="noreferrer">Buka formulir online <span>↗</span></a>
          <?php endif; ?>
        </div>
        <ol class="req-list">
          <?php foreach ($syarat as $i => $sy): ?>
            <li class="reveal"><span><?= num2($i + 1) ?></span><p><?= e($sy['teks'] ?? '') ?></p></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </section>

    <!-- QR -->
    <section class="section section--dark on-dark" id="daftar" aria-labelledby="daftar-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('spmb.daftar_eyebrow')) ?></p>
            <h2 id="daftar-title" class="display"><?= rich(s('spmb.daftar_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('spmb.daftar_text')) ?></p>
        </div>
        <div class="qr-grid">
          <article class="qr-card reveal">
            <img src="<?= e(asset(s('spmb.qr_form'))) ?>" alt="QR code formulir pendaftaran <?= e(s('umum.spmb_label')) ?>" loading="lazy">
            <div><span><?= e(s('spmb.qr_form_label')) ?></span><strong><?= e(s('spmb.qr_form_title')) ?></strong><?php if ($formUrl !== ''): ?><a href="<?= e($formUrl) ?>" target="_blank" rel="noreferrer">Atau buka formulir online ↗</a><?php endif; ?></div>
          </article>
          <article class="qr-card reveal" data-delay="1">
            <img src="<?= e(asset(s('spmb.qr_admin'))) ?>" alt="QR code untuk menghubungi admin SPMB" loading="lazy">
            <div><span><?= e(s('spmb.qr_admin_label')) ?></span><strong><?= e(s('spmb.qr_admin_title')) ?></strong><small><?= e(s('spmb.qr_admin_text')) ?></small></div>
          </article>
        </div>
      </div>
    </section>

    <!-- Lokasi & Sekretariat -->
    <section class="section section--tint" id="lokasi" aria-labelledby="lokasi-title">
      <div class="container">
        <div class="location-band reveal">
          <div>
            <p class="eyebrow"><?= e(s('spmb.lokasi_eyebrow')) ?></p>
            <h2 id="lokasi-title" class="display"><?= rich(s('spmb.lokasi_title')) ?></h2>
          </div>
          <div>
            <p><strong>Lokasi Sekretariat:</strong> <?= e(s('umum.address')) ?>.</p>
            <?php if (s('spmb.ketua_panitia') !== ''): ?>
              <p style="font-size:13.5px;color:var(--forest-2);font-weight:600;margin-bottom:12px"><?= e(s('spmb.ketua_panitia')) ?></p>
            <?php endif; ?>
            <a class="link-arrow" href="<?= e(maps_url()) ?>" target="_blank" rel="noreferrer">Lihat petunjuk lokasi di Google Maps <span>↗</span></a>
            <?php if (s('spmb.lokasi_note') !== ''): ?>
              <small><?= e(s('spmb.lokasi_note')) ?></small>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  </main>
<?php require INC_DIR . '/footer.php'; ?>

