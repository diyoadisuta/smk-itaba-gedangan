<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$activePage = 'beranda';
$pageTitle  = s('beranda.meta_title');
$pageDesc   = s('beranda.meta_description');

$gelombang = items('spmb_gelombang');
$stats     = items('stats');
$programs  = items('program');
$awards    = array_slice(array_values(array_filter(items('prestasi'), static fn($a) => !empty($a['beranda']))), 0, 3);
$ytId      = youtube_id(s('umum.youtube_url'));
$heroImg   = asset(s('beranda.hero_image'));

require INC_DIR . '/header.php';
?>
  <main id="konten">
    <!-- Hero -->
    <section class="hero" aria-labelledby="hero-title">
      <div class="hero-media" role="img" aria-label="Gedung <?= e(s('umum.site_name')) ?>" style="background-image:url('<?= e($heroImg) ?>')"></div>
      <div class="hero-shade"></div>
      <div class="container hero-grid">
        <div>
          <p class="eyebrow reveal"><?= e(s('beranda.hero_eyebrow')) ?></p>
          <h1 id="hero-title" class="reveal" data-delay="1"><?= rich(s('beranda.hero_title')) ?></h1>
          <p class="hero-lede reveal" data-delay="2"><?= e(s('beranda.hero_lede')) ?></p>
          <div class="hero-actions reveal" data-delay="3">
            <a class="btn btn-lime" id="hero-program-btn" href="program.php">Jelajahi program <span class="arrow">→</span></a>
            <a class="btn btn-ghost" id="hero-profil-btn" href="profil.php">Kenali <?= e(s('umum.site_name')) ?></a>
          </div>
          <div class="hero-values reveal" data-delay="4">
            <?php foreach (lines(s('beranda.hero_values')) as $val): ?><span><?= e($val) ?></span><?php endforeach; ?>
          </div>
        </div>

        <aside class="hero-card reveal" data-delay="3" aria-label="Info SPMB">
          <span class="badge"><?= e(s('umum.spmb_label')) ?></span>
          <h2><?= e(s('beranda.hero_card_title')) ?></h2>
          <p><?= e(s('beranda.hero_card_subtitle')) ?></p>
          <ul class="wave-list">
            <?php foreach ($gelombang as $w): ?>
              <li><span><?= e($w['label'] ?? '') ?></span><strong><?= e($w['tanggal'] ?? '') ?></strong></li>
            <?php endforeach; ?>
          </ul>
          <a class="link-arrow" href="spmb.php">Info pendaftaran lengkap <span>→</span></a>
        </aside>
      </div>
    </section>

    <!-- Stats -->
    <section class="stats" aria-label="Sekilas <?= e(s('umum.site_name')) ?>">
      <div class="container">
        <div class="stats-grid reveal">
          <?php foreach ($stats as $st): ?>
            <div class="stat<?= !empty($st['accent']) ? ' stat--accent' : '' ?>"><strong><?= e($st['value'] ?? '') ?></strong><span><?= e($st['label'] ?? '') ?></span></div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Tentang singkat -->
    <section class="section" aria-labelledby="tentang-title">
      <div class="container split">
        <div class="media-frame reveal">
          <img src="<?= e(asset(s('beranda.tentang_image'))) ?>" alt="Tampak gedung <?= e(s('umum.site_name')) ?>" loading="lazy">
          <span class="media-tag"><?= e(s('beranda.tentang_tag')) ?></span>
          <div class="media-float"><strong><?= e(s('umum.tahun_berdiri')) ?></strong><span>Tahun berdiri</span></div>
        </div>
        <div class="split-copy reveal" data-delay="1">
          <p class="eyebrow"><?= e(s('beranda.tentang_eyebrow')) ?></p>
          <h2 id="tentang-title" class="display"><?= rich(s('beranda.tentang_title')) ?></h2>
          <p class="lead"><?= e(s('beranda.tentang_lead')) ?></p>
          <?= paragraphs(s('beranda.tentang_text')) ?>
          <a class="link-arrow" href="profil.php">Selengkapnya tentang profil sekolah <span>→</span></a>
        </div>
      </div>
    </section>

    <!-- Program singkat -->
    <section class="section section--tint" aria-labelledby="program-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('beranda.program_eyebrow')) ?></p>
            <h2 id="program-title" class="display"><?= rich(s('beranda.program_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('beranda.program_text')) ?></p>
        </div>
        <div class="tile-grid">
          <?php foreach ($programs as $i => $pr):
            $style = ($pr['gaya'] ?? 'dkv') === 'tkr' ? 'tkr' : 'dkv';
            $slug  = $pr['slug'] ?? strtolower($pr['singkatan'] ?? '');
          ?>
            <a class="tile tile--<?= e($style) ?> reveal" id="tile-<?= e($slug) ?>"<?= $i > 0 ? ' data-delay="' . ($i % 3) . '"' : '' ?> href="program.php#<?= e($slug) ?>">
              <span class="tile-symbol" aria-hidden="true"><?= e($pr['simbol'] ?? '✳') ?></span>
              <div class="tile-top">
                <span class="icon-badge<?= $style === 'dkv' ? ' icon-badge--lime' : '' ?>"><?= icon($pr['icon'] ?? 'star') ?></span>
                <span class="tile-arrow" aria-hidden="true">↗</span>
              </div>
              <div>
                <p class="tile-code"><?= e($pr['kode'] ?? '') ?></p>
                <h3><?= e($pr['nama'] ?? '') ?><?php if (!empty($pr['singkatan'])): ?> <small><?= e($pr['singkatan']) ?></small><?php endif; ?></h3>
                <p><?= e($pr['ringkasan'] ?? '') ?></p>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Fasilitas & Ekskul Teaser -->
    <section class="section" aria-labelledby="fasilitas-teaser-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('beranda.fasilitas_eyebrow')) ?></p>
            <h2 id="fasilitas-teaser-title" class="display"><?= rich(s('beranda.fasilitas_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('beranda.fasilitas_text')) ?></p>
        </div>

        <div class="tile-grid">
          <article class="facility-category reveal" style="padding:34px;background:#fff;border:1px solid var(--line);border-radius:var(--radius);display:flex;flex-direction:column;justify-content:space-between;gap:24px">
            <div>
              <span class="badge" style="margin-bottom:14px"><?= e(s('beranda.fas_card_badge')) ?></span>
              <h3 style="font-size:26px;font-weight:800;color:var(--forest);margin-bottom:12px;letter-spacing:-.02em"><?= e(s('beranda.fas_card_title')) ?></h3>
              <p style="color:var(--muted);font-size:14.5px;line-height:1.7"><?= e(s('beranda.fas_card_text')) ?></p>
            </div>
            <div>
              <a class="btn btn-primary" href="profil.php#fasilitas">Lihat semua fasilitas <span class="arrow">→</span></a>
            </div>
          </article>

          <article class="ekskul-category reveal" data-delay="1" style="padding:34px;background:var(--cream);border:1px solid var(--line);border-radius:var(--radius);display:flex;flex-direction:column;justify-content:space-between;gap:24px">
            <div>
              <span class="badge" style="margin-bottom:14px;background:var(--forest);color:var(--lime)"><?= e(s('beranda.eks_card_badge')) ?></span>
              <h3 style="font-size:26px;font-weight:800;color:var(--forest);margin-bottom:12px;letter-spacing:-.02em"><?= e(s('beranda.eks_card_title')) ?></h3>
              <p style="color:var(--muted);font-size:14.5px;line-height:1.7"><?= e(s('beranda.eks_card_text')) ?></p>
            </div>
            <div>
              <a class="btn btn-lime" href="profil.php#ekskul">Jelajahi ekskul &amp; komunitas <span class="arrow">→</span></a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- Sambutan singkat -->
    <section class="section quote-band on-dark" aria-labelledby="sambutan-title">
      <div class="container quote-grid">
        <div class="quote-photo reveal">
          <img src="<?= e(asset(s('sambutan.kepsek_foto'))) ?>" alt="<?= e(s('sambutan.kepsek_nama')) ?>, <?= e(s('sambutan.kepsek_jabatan')) ?>" loading="lazy">
          <span><?= e(s('sambutan.kepsek_label')) ?></span>
        </div>
        <div class="reveal" data-delay="1">
          <p class="eyebrow" id="sambutan-title"><?= e(s('beranda.sambutan_eyebrow')) ?></p>
          <span class="quote-mark" aria-hidden="true">“</span>
          <blockquote><?= e(s('beranda.sambutan_quote')) ?></blockquote>
          <div class="quote-sign">
            <div><strong><?= e(s('sambutan.kepsek_nama')) ?></strong><span><?= e(s('sambutan.kepsek_jabatan')) ?></span></div>
            <a class="link-arrow" href="sambutan.php">Sambutan &amp; jajaran pendidik <span>→</span></a>
          </div>
        </div>
      </div>
    </section>

    <!-- Video Profil & Prestasi Siswa Showcase -->
    <section class="section section--tint" aria-labelledby="galeri-home-title">
      <div class="container">
        <div class="section-head reveal">
          <div>
            <p class="eyebrow"><?= e(s('beranda.video_eyebrow')) ?></p>
            <h2 id="galeri-home-title" class="display"><?= rich(s('beranda.video_title')) ?></h2>
          </div>
          <p><?= e(s('beranda.video_text')) ?></p>
        </div>

        <div class="home-showcase reveal">
          <div>
            <?php if ($ytId !== ''): ?>
              <a class="video-facade" href="https://youtu.be/<?= e($ytId) ?>" target="_blank" rel="noreferrer" data-yt="<?= e($ytId) ?>" data-title="Video Profil <?= e(s('umum.site_name')) ?>" aria-label="Putar video profil <?= e(s('umum.site_name')) ?>">
                <img src="https://i.ytimg.com/vi/<?= e($ytId) ?>/maxresdefault.jpg" alt="Cuplikan video profil <?= e(s('umum.site_name')) ?>" loading="lazy" width="1280" height="720" onerror="this.onerror=null;this.src='https://i.ytimg.com/vi/<?= e($ytId) ?>/hqdefault.jpg'">
                <span class="video-play" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M8 5.5v13a1 1 0 0 0 1.5.86l10.5-6.5a1 1 0 0 0 0-1.72L9.5 4.64A1 1 0 0 0 8 5.5Z"/></svg></span>
                <span class="video-label"><strong><?= e(s('beranda.video_label')) ?></strong><small>Klik untuk memutar langsung</small></span>
              </a>
            <?php endif; ?>
          </div>

          <div class="home-awards">
            <?php foreach ($awards as $aw): ?>
              <a class="home-award" href="galeri.php#prestasi">
                <img src="<?= e(asset($aw['foto'] ?? '')) ?>" alt="<?= e($aw['alt'] ?: ($aw['judul'] ?? '')) ?>" width="96" height="80" loading="lazy">
                <div>
                  <small><?= e($aw['beranda_label'] ?: ($aw['meta'] ?? '')) ?></small>
                  <strong><?= e($aw['beranda_judul'] ?: ($aw['judul'] ?? '')) ?></strong>
                  <span><?= e($aw['beranda_sub'] ?: ($aw['peringkat'] ?? '')) ?></span>
                </div>
              </a>
            <?php endforeach; ?>
            <a class="link-arrow" href="galeri.php">Lihat semua prestasi &amp; dokumentasi kegiatan <span>→</span></a>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA SPMB -->
    <section class="section" aria-labelledby="cta-title">
      <div class="container">
        <div class="cta-band reveal">
          <div>
            <p class="eyebrow"><?= e(s('beranda.cta_eyebrow')) ?></p>
            <h2 id="cta-title"><?= rich(s('beranda.cta_title')) ?></h2>
            <p><?= e(s('beranda.cta_text')) ?></p>
          </div>
          <div class="cta-actions">
            <a class="btn btn-primary" id="cta-spmb-btn" href="spmb.php">Info pendaftaran <span class="arrow">→</span></a>
            <a class="btn btn-light" id="cta-kontak-btn" href="kontak.php">Hubungi kami <span class="arrow">→</span></a>
          </div>
        </div>
      </div>
    </section>
  </main>
<?php require INC_DIR . '/footer.php'; ?>

