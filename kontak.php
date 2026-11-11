<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$activePage = 'kontak';
$pageTitle  = s('kontak.meta_title');
$pageDesc   = s('kontak.meta_description');
$waUrl      = whatsapp_url(s('umum.whatsapp'));

require INC_DIR . '/header.php';
?>
  <main id="konten">
    <section class="page-hero" data-watermark="<?= e(s('kontak.hero_watermark')) ?>">
      <div class="container page-hero-inner">
        <nav class="breadcrumb reveal" aria-label="Breadcrumb"><a href="index.php">Beranda</a><span aria-hidden="true">/</span><span aria-current="page">Kontak</span></nav>
        <p class="eyebrow reveal"><?= e(s('kontak.hero_eyebrow')) ?></p>
        <h1 class="reveal" data-delay="1"><?= rich(s('kontak.hero_title')) ?></h1>
        <p class="reveal" data-delay="2"><?= e(s('kontak.hero_text')) ?></p>
      </div>
    </section>

    <section class="section" aria-label="Informasi kontak">
      <div class="container contact-grid">
        <div class="contact-cards">
          <article class="contact-card reveal">
            <span class="icon-badge"><?= icon('pin') ?></span>
            <div>
              <h2>Alamat Sekolah</h2>
              <p><?= e(s('umum.address')) ?></p>
              <p style="margin-top:6px;font-size:13px;color:var(--muted)">NPSN: <?= e(s('umum.npsn')) ?> · <?= e(s('umum.yayasan')) ?></p>
            </div>
          </article>
          <?php if (s('umum.email') !== ''): ?>
            <article class="contact-card reveal" data-delay="1">
              <span class="icon-badge"><?= icon('mail') ?></span>
              <div>
                <h2>Email Resmi</h2>
                <a href="mailto:<?= e(s('umum.email')) ?>" id="contact-email"><?= e(s('umum.email')) ?></a>
              </div>
            </article>
          <?php endif; ?>
          <?php if ($waUrl !== ''): ?>
            <article class="contact-card reveal" data-delay="1">
              <span class="icon-badge"><?= icon('phone') ?></span>
              <div>
                <h2>Telepon / WhatsApp</h2>
                <a href="<?= e($waUrl) ?>" target="_blank" rel="noreferrer"><?= e(s('umum.whatsapp')) ?></a>
              </div>
            </article>
          <?php endif; ?>
          <article class="contact-card reveal" data-delay="2">
            <span class="icon-badge"><?= icon('share') ?></span>
            <div style="flex:1">
              <h2>Media Sosial Resmi</h2>
              <div class="social-list">
                <?php if (s('umum.instagram_url') !== ''): ?>
                  <a href="<?= e(safe_url(s('umum.instagram_url'))) ?>" target="_blank" rel="noreferrer" id="contact-instagram"><?= icon('instagram') ?><span><small>Instagram</small><strong><?= e(s('umum.instagram_handle')) ?></strong></span></a>
                <?php endif; ?>
                <?php if (s('umum.facebook_url') !== ''): ?>
                  <a href="<?= e(safe_url(s('umum.facebook_url'))) ?>" target="_blank" rel="noreferrer" id="contact-facebook"><?= icon('facebook') ?><span><small>Facebook</small><strong><?= e(s('umum.facebook_name')) ?></strong></span></a>
                <?php endif; ?>
                <?php if (s('umum.tiktok_url') !== ''): ?>
                  <a href="<?= e(safe_url(s('umum.tiktok_url'))) ?>" target="_blank" rel="noreferrer" id="contact-tiktok"><?= icon('tiktok') ?><span><small>TikTok</small><strong><?= e(s('umum.tiktok_handle')) ?></strong></span></a>
                <?php endif; ?>
              </div>
            </div>
          </article>
        </div>

        <div class="map-wrap reveal" data-delay="1">
          <iframe title="Peta lokasi <?= e(s('umum.site_name')) ?>" src="<?= e(maps_embed_url()) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <a class="btn btn-primary" id="map-btn" href="<?= e(maps_url()) ?>" target="_blank" rel="noreferrer">Buka di Google Maps <span class="arrow">↗</span></a>
        </div>
      </div>
    </section>

    <section class="section section--tint" aria-labelledby="cta-title">
      <div class="container">
        <div class="cta-band reveal">
          <div>
            <p class="eyebrow"><?= e(s('kontak.cta_eyebrow')) ?></p>
            <h2 id="cta-title"><?= rich(s('kontak.cta_title')) ?></h2>
            <p><?= e(s('kontak.cta_text')) ?></p>
          </div>
          <div class="cta-actions">
            <a class="btn btn-primary" id="cta-spmb-btn" href="spmb.php">Info pendaftaran <span class="arrow">→</span></a>
          </div>
        </div>
      </div>
    </section>
  </main>
<?php require INC_DIR . '/footer.php'; ?>

