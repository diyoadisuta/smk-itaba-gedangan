<?php
/**
 * Header publik.
 * Variabel yang dapat diset sebelum memanggil:
 * - $pageTitle, $pageDesc, $activePage ('beranda'|'profil'|'program'|'galeri'|'sambutan'|'kontak'|'spmb')
 * - $bodyClass
 */
declare(strict_types=1);
$pageTitle  = $pageTitle  ?? s('beranda.meta_title');
$pageDesc   = $pageDesc   ?? s('beranda.meta_description');
$activePage = $activePage ?? '';
$bodyClass  = $bodyClass  ?? '';
$logoUrl    = asset(s('umum.logo'));
$nav = [
    'beranda'  => ['index.php', 'Beranda'],
    'profil'   => ['profil.php', 'Profil'],
    'program'  => ['program.php', 'Program Keahlian'],
    'galeri'   => ['galeri.php', 'Galeri'],
    'sambutan' => ['sambutan.php', 'Sambutan'],
    'kontak'   => ['kontak.php', 'Kontak'],
];
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#0f3b2e">
  <meta name="description" content="<?= e($pageDesc) ?>">
  <title><?= e($pageTitle) ?></title>
  <link rel="icon" href="<?= e($logoUrl) ?>" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="<?= e(asset('styles.css')) ?>">
  <script>document.documentElement.classList.add('js');</script>
  <script src="<?= e(asset('script.js')) ?>" defer></script>
</head>
<body<?= $bodyClass !== '' ? ' class="' . e($bodyClass) . '"' : '' ?>>
  <a class="skip-link" href="#konten">Lewati ke konten</a>

  <div class="topbar">
    <div class="container topbar-inner">
      <span class="topbar-address"><?= icon('pin') ?><?= e(s('umum.topbar_address')) ?> · NPSN: <?= e(s('umum.npsn')) ?></span>
      <div class="topbar-links">
        <?php if (s('umum.email') !== ''): ?>
          <a href="mailto:<?= e(s('umum.email')) ?>"><?= icon('mail') ?><?= e(s('umum.email')) ?></a>
        <?php endif; ?>
        <?php if (s('umum.instagram_url') !== ''): ?>
          <a href="<?= e(safe_url(s('umum.instagram_url'))) ?>" target="_blank" rel="noreferrer">Instagram</a>
        <?php endif; ?>
        <?php if (s('umum.facebook_url') !== ''): ?>
          <a href="<?= e(safe_url(s('umum.facebook_url'))) ?>" target="_blank" rel="noreferrer">Facebook</a>
        <?php endif; ?>
        <?php if (s('umum.tiktok_url') !== ''): ?>
          <a href="<?= e(safe_url(s('umum.tiktok_url'))) ?>" target="_blank" rel="noreferrer">TikTok</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <header class="site-header">
    <div class="container nav-wrap">
      <a class="brand" href="index.php" aria-label="<?= e(s('umum.site_name')) ?>, ke beranda">
        <span class="brand-mark"><img src="<?= e($logoUrl) ?>" alt="Logo <?= e(s('umum.site_name')) ?>"></span>
        <span class="brand-copy"><strong><?= e(s('umum.site_name')) ?></strong><small><?= e(s('umum.site_location')) ?></small></span>
      </a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-nav" aria-label="Buka menu"><span></span><span></span></button>
      <nav id="main-nav" class="main-nav" aria-label="Navigasi utama">
        <?php foreach ($nav as $key => [$href, $label]): ?>
          <a href="<?= e($href) ?>"<?= $activePage === $key ? ' aria-current="page"' : '' ?>><?= e($label) ?></a>
        <?php endforeach; ?>
        <a class="nav-cta" href="spmb.php"<?= $activePage === 'spmb' ? ' aria-current="page"' : '' ?>><?= e(s('umum.spmb_label')) ?> <span aria-hidden="true">↗</span></a>
      </nav>
    </div>
  </header>

