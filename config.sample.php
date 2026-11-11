<?php
/**
 * Konfigurasi CMS SMK ITABA.
 *
 * Salin file ini menjadi `config.php`, lalu sesuaikan nilai di bawah
 * dengan data database dari hosting (cPanel » MySQL Databases).
 * File `config.php` TIDAK ikut di-commit ke Git (lihat .gitignore).
 */
return [
    'db' => [
        // 'mysql' untuk hosting. 'sqlite' hanya untuk uji coba lokal.
        'driver'   => 'mysql',
        'host'     => 'localhost',
        'port'     => 3306,
        'name'     => 'nama_database',
        'user'     => 'user_database',
        'pass'     => 'password_database',
        'charset'  => 'utf8mb4',
        // Dipakai bila driver = sqlite (path relatif terhadap root website).
        'sqlite_path' => 'storage/database.sqlite',
    ],

    // Zona waktu sekolah.
    'timezone' => 'Asia/Jakarta',

    // Ukuran maksimal upload gambar (MB) & lebar maksimal hasil kompres (px).
    'upload_max_mb'    => 8,
    'image_max_width'  => 1600,

    // true = tampilkan pesan error detail (JANGAN aktifkan di server produksi).
    'debug' => false,
];

