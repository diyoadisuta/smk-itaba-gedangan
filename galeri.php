<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$activePage = 'galeri';
$pageTitle  = s('galeri.meta_title');
$pageDesc   = s('galeri.meta_description');

$ytId         = youtube_id(s('umum.youtube_url'));
$prestasiStats = items('prestasi_stats');
$prestasiKat   = items('prestasi_kategori');
$prestasi      = items('prestasi');
$potretJuara   = items('potret_juara');
$dokKat        = items('dokumentasi_kategori');
$dokumentasi   = items('dokumentasi');
$albums        = items('album');

require INC_DIR . '/header.php';
?>
  <main id="konten">
    <section class="page-hero" data-watermark="<?= e(s('galeri.hero_watermark')) ?>">
      <div class="container page-hero-inner">
        <nav class="breadcrumb reveal" aria-label="Breadcrumb"><a href="index.php">Beranda</a><span aria-hidden="true">/</span><span aria-current="page">Galeri &amp; Prestasi</span></nav>
        <p class="eyebrow reveal"><?= e(s('galeri.hero_eyebrow')) ?></p>
        <h1 class="reveal" data-delay="1"><?= rich(s('galeri.hero_title')) ?></h1>
        <p class="reveal" data-delay="2"><?= e(s('galeri.hero_text')) ?></p>
      </div>
    </section>

    <nav class="subnav" aria-label="Bagian halaman galeri">
      <div class="container subnav-inner">
        <a href="#video">Video Profil</a>
        <a href="#prestasi">Prestasi Siswa</a>
        <a href="#dokumentasi">Dokumentasi Kegiatan</a>
        <a href="#album">Album Lengkap</a>
      </div>
    </nav>

    <!-- ============ VIDEO PROFIL ============ -->
    <section class="section section--dark on-dark" id="video" aria-labelledby="video-title">
      <div class="container video-grid">
        <div class="reveal">
          <p class="eyebrow"><?= e(s('galeri.video_eyebrow')) ?></p>
          <h2 id="video-title" class="display"><?= rich(s('galeri.video_title')) ?></h2>
          <p class="lead"><?= e(s('galeri.video_text')) ?></p>
          <ul class="video-points">
            <?php foreach (lines(s('galeri.video_points')) as $i => $pt): ?>
              <li><span aria-hidden="true"><?= num2($i + 1) ?></span><?= e($pt) ?></li>
            <?php endforeach; ?>
          </ul>
          <?php if ($ytId !== ''): ?>
            <a class="link-arrow" href="https://youtu.be/<?= e($ytId) ?>" target="_blank" rel="noreferrer">Buka di YouTube <span>↗</span></a>
          <?php endif; ?>
        </div>
        <div class="reveal" data-delay="1">
          <?php if ($ytId !== ''): ?>
            <a class="video-facade" id="video-profil" href="https://youtu.be/<?= e($ytId) ?>" target="_blank" rel="noreferrer" data-yt="<?= e($ytId) ?>" data-title="Video Profil <?= e(s('umum.site_name')) ?>" aria-label="Putar video profil <?= e(s('umum.site_name')) ?>">
              <img src="https://i.ytimg.com/vi/<?= e($ytId) ?>/maxresdefault.jpg" alt="Cuplikan video profil <?= e(s('umum.site_name')) ?>" loading="lazy" width="1280" height="720" onerror="this.onerror=null;this.src='https://i.ytimg.com/vi/<?= e($ytId) ?>/hqdefault.jpg'">
              <span class="video-play" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M8 5.5v13a1 1 0 0 0 1.5.86l10.5-6.5a1 1 0 0 0 0-1.72L9.5 4.64A1 1 0 0 0 8 5.5Z"/></svg></span>
              <span class="video-label"><strong><?= e(s('galeri.video_label')) ?></strong><small><?= e(s('galeri.video_sublabel')) ?></small></span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- ============ PRESTASI SISWA ============ -->
    <section class="section" id="prestasi" aria-labelledby="prestasi-title">
      <div class="container">
        <div class="section-head prestasi-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('galeri.prestasi_eyebrow')) ?></p>
            <h2 id="prestasi-title" class="display"><?= rich(s('galeri.prestasi_title')) ?></h2>
          </div>
          <div class="prestasi-head-side reveal" data-delay="1">
            <img class="owi-juara" src="<?= e(asset(s('galeri.prestasi_mascot'))) ?>" alt="Owi, maskot <?= e(s('umum.site_name')) ?>, memegang piala" width="544" height="560" loading="lazy">
            <p><?= e(s('galeri.prestasi_text')) ?></p>
          </div>
        </div>

        <div class="prestasi-stats reveal">
          <?php foreach ($prestasiStats as $ps): ?>
            <div<?= !empty($ps['accent']) ? ' class="is-accent"' : '' ?>><strong><?= e($ps['value'] ?? '') ?></strong><span><?= e($ps['label'] ?? '') ?></span></div>
          <?php endforeach; ?>
        </div>

        <div class="gallery-filter-tabs reveal" role="group" aria-label="Filter prestasi" data-filter-group="prestasi">
          <button type="button" class="filter-btn active" data-filter="all" aria-pressed="true"><?= e(s('galeri.prestasi_all_label')) ?></button>
          <?php foreach ($prestasiKat as $kat): ?>
            <button type="button" class="filter-btn" data-filter="<?= e($kat['slug'] ?? '') ?>" aria-pressed="false"><?= e($kat['label'] ?? '') ?></button>
          <?php endforeach; ?>
        </div>

        <div class="award-grid" data-filter-items="prestasi">
          <?php foreach ($prestasi as $i => $aw):
            $rankClass = 'award-rank' . (!empty($aw['gaya_peringkat']) ? ' award-rank--' . e($aw['gaya_peringkat']) : '');
            $cardClass = 'award-card' . (!empty($aw['featured']) ? ' award-card--featured' : '') . ' reveal';
            $fotoUrl   = asset($aw['foto'] ?? '');
            $caption   = $aw['caption'] ?: ($aw['judul'] ?? '');
            $alt       = $aw['alt'] ?: ($aw['judul'] ?? '');
            $posStyle  = !empty($aw['posisi']) ? ' style="object-position:' . e($aw['posisi']) . '"' : '';
            $tags      = csv_list($aw['tags'] ?? '');
          ?>
            <article class="<?= $cardClass ?>" data-category="<?= e($aw['kategori'] ?? '') ?>">
              <button type="button" class="award-media" data-lightbox="prestasi" data-src="<?= e($fotoUrl) ?>" data-caption="<?= e($caption) ?>">
                <img src="<?= e($fotoUrl) ?>" alt="<?= e($alt) ?>" loading="lazy"<?= $posStyle ?>>
                <span class="award-zoom" aria-hidden="true"><?= icon('zoom') ?></span>
              </button>
              <div class="award-body">
                <div class="award-meta"><span class="<?= $rankClass ?>"><?= e($aw['peringkat'] ?? '') ?></span><span><?= e($aw['meta'] ?? '') ?></span></div>
                <h3><?= e($aw['judul'] ?? '') ?></h3>
                <p><?= rich($aw['deskripsi'] ?? '') ?></p>
                <div class="award-foot">
                  <div class="award-tags">
                    <?php foreach ($tags as $tg): ?><span><?= e($tg) ?></span><?php endforeach; ?>
                  </div>
                  <?php if (!empty($aw['foto2'])): ?>
                    <button type="button" class="award-more" data-lightbox="prestasi" data-src="<?= e(asset($aw['foto2'])) ?>" data-caption="<?= e($aw['caption2'] ?: ($aw['judul'] ?? '')) ?>">+1 foto</button>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <?php if ($potretJuara): ?>
          <div class="champion-wall reveal" aria-label="Potret siswa berprestasi">
            <div class="champion-copy">
              <p class="eyebrow"><?= e(s('galeri.champion_eyebrow')) ?></p>
              <h3><?= rich(s('galeri.champion_title')) ?></h3>
              <p><?= e(s('galeri.champion_text')) ?></p>
            </div>
            <div class="champion-strip">
              <?php foreach ($potretJuara as $pj):
                $pjSrc = asset($pj['foto'] ?? '');
                $pjCap = $pj['caption'] ?? '';
                $pjAlt = $pj['alt'] ?: $pjCap;
              ?>
                <button type="button" data-lightbox="juara" data-src="<?= e($pjSrc) ?>" data-caption="<?= e($pjCap) ?>"><img src="<?= e($pjSrc) ?>" alt="<?= e($pjAlt) ?>" loading="lazy"></button>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- ============ DOKUMENTASI KEGIATAN ============ -->
    <section class="section section--tint" id="dokumentasi" aria-labelledby="dokumentasi-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('galeri.dok_eyebrow')) ?></p>
            <h2 id="dokumentasi-title" class="display"><?= rich(s('galeri.dok_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('galeri.dok_text')) ?></p>
        </div>

        <div class="gallery-filter-tabs reveal" role="group" aria-label="Filter dokumentasi" data-filter-group="dokumentasi">
          <button type="button" class="filter-btn active" data-filter="all" aria-pressed="true"><?= e(s('galeri.dok_all_label')) ?></button>
          <?php foreach ($dokKat as $dk): ?>
            <button type="button" class="filter-btn" data-filter="<?= e($dk['slug'] ?? '') ?>" aria-pressed="false"><?= e($dk['label'] ?? '') ?></button>
          <?php endforeach; ?>
        </div>

        <div class="doc-masonry" data-filter-items="dokumentasi">
          <?php foreach ($dokumentasi as $dk):
            $dkSrc = asset($dk['foto'] ?? '');
            $dkCap = $dk['caption'] ?: ($dk['judul'] ?? '');
            $dkAlt = $dk['alt'] ?: $dkCap;
          ?>
            <button type="button" class="doc-item" data-category="<?= e($dk['kategori'] ?? '') ?>" data-lightbox="dokumentasi" data-src="<?= e($dkSrc) ?>" data-caption="<?= e($dkCap) ?>">
              <img src="<?= e($dkSrc) ?>" alt="<?= e($dkAlt) ?>" loading="lazy">
              <span class="doc-cap"><small><?= e($dk['label'] ?? '') ?></small><strong><?= e($dk['judul'] ?? '') ?></strong></span>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ============ ALBUM LENGKAP (Google Drive) ============ -->
    <section class="section" id="album" aria-labelledby="album-title">
      <div class="container">
        <div class="section-head">
          <div class="reveal">
            <p class="eyebrow"><?= e(s('galeri.album_eyebrow')) ?></p>
            <h2 id="album-title" class="display"><?= rich(s('galeri.album_title')) ?></h2>
          </div>
          <p class="reveal" data-delay="1"><?= e(s('galeri.album_text')) ?></p>
        </div>

        <div class="album-grid reveal">
          <?php foreach ($albums as $al): ?>
            <a class="album-link" href="<?= e(safe_url($al['url'] ?? '')) ?>" target="_blank" rel="noreferrer"><span class="album-ico" aria-hidden="true"><?= e($al['ikon'] ?: '📁') ?></span><span><strong><?= e($al['judul'] ?? '') ?></strong><small><?= e($al['keterangan'] ?? '') ?></small></span><span class="album-arrow" aria-hidden="true">↗</span></a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Halaman Selanjutnya -->
    <section class="section section--tint" aria-label="Halaman selanjutnya">
      <div class="container">
        <a class="next-page reveal" id="next-sambutan" href="sambutan.php">
          <div><small>Selanjutnya</small><strong>Sambutan &amp; Warga Sekolah</strong></div>
          <span class="tile-arrow" aria-hidden="true">→</span>
        </a>
      </div>
    </section>
  </main>

  <!-- Lightbox -->
  <dialog class="lightbox" id="lightbox" aria-label="Pratinjau foto">
    <button type="button" class="lightbox-close" data-lb="close" aria-label="Tutup">✕</button>
    <button type="button" class="lightbox-nav lightbox-prev" data-lb="prev" aria-label="Foto sebelumnya">‹</button>
    <figure>
      <img id="lightbox-img" src="" alt="">
      <figcaption id="lightbox-cap"></figcaption>
    </figure>
    <button type="button" class="lightbox-nav lightbox-next" data-lb="next" aria-label="Foto berikutnya">›</button>
  </dialog>
<?php require INC_DIR . '/footer.php'; ?>

