<?php
/**
 * Footer publik.
 */
declare(strict_types=1);
$logoUrl = asset(s('umum.logo'));
$spmbBase = ($activePage ?? '') === 'spmb' ? '' : 'spmb.php';
?>
  <footer class="site-footer">
    <div class="container footer-grid">
      <div>
        <a class="brand footer-brand" href="index.php"><span class="brand-mark"><img src="<?= e($logoUrl) ?>" alt="Logo <?= e(s('umum.site_name')) ?>"></span><span class="brand-copy"><strong><?= e(s('umum.site_name')) ?></strong><small><?= e(s('umum.tagline')) ?></small></span></a>
        <p class="footer-about"><?= e(s('umum.footer_about')) ?></p>
        <div class="socials">
          <?php if (s('umum.instagram_url') !== ''): ?>
            <a href="<?= e(safe_url(s('umum.instagram_url'))) ?>" target="_blank" rel="noreferrer" aria-label="Instagram"><?= icon('instagram') ?></a>
          <?php endif; ?>
          <?php if (s('umum.facebook_url') !== ''): ?>
            <a href="<?= e(safe_url(s('umum.facebook_url'))) ?>" target="_blank" rel="noreferrer" aria-label="Facebook"><?= icon('facebook') ?></a>
          <?php endif; ?>
          <?php if (s('umum.tiktok_url') !== ''): ?>
            <a href="<?= e(safe_url(s('umum.tiktok_url'))) ?>" target="_blank" rel="noreferrer" aria-label="TikTok"><?= icon('tiktok') ?></a>
          <?php endif; ?>
          <?php if (s('umum.email') !== ''): ?>
            <a href="mailto:<?= e(s('umum.email')) ?>" aria-label="Email"><?= icon('mail') ?></a>
          <?php endif; ?>
        </div>
      </div>
      <div class="footer-col"><h3>Jelajahi</h3><ul><li><a href="index.php">Beranda</a></li><li><a href="profil.php">Profil</a></li><li><a href="program.php">Program Keahlian</a></li><li><a href="galeri.php">Galeri</a></li><li><a href="sambutan.php">Sambutan</a></li><li><a href="kontak.php">Kontak</a></li></ul></div>
      <div class="footer-col"><h3><?= e(s('umum.spmb_label')) ?></h3><ul><li><a href="<?= e($spmbBase) ?>#jadwal">Jadwal pendaftaran</a></li><li><a href="<?= e($spmbBase) ?>#biaya">Rincian biaya</a></li><li><a href="<?= e($spmbBase) ?>#syarat">Persyaratan</a></li><?php if (s('umum.spmb_form_url') !== ''): ?><li><a href="<?= e(safe_url(s('umum.spmb_form_url'))) ?>" target="_blank" rel="noreferrer">Formulir online ↗</a></li><?php endif; ?></ul></div>
      <div class="footer-col"><h3>Alamat &amp; NPSN</h3><address><?= nl2br(e(s('umum.address')), false) ?><br><br><strong>NPSN:</strong> <?= e(s('umum.npsn')) ?></address></div>
    </div>
    <div class="container footer-bottom"><span>© <span id="year"><?= date('Y') ?></span> <?= e(s('umum.site_name')) ?> <?= e(str_replace(' · ', ', ', s('umum.site_location'))) ?></span><a href="#">Kembali ke atas ↑</a></div>
  </footer>
</body>
</html>

