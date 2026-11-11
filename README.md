# Website & CMS Resmi SMK ITABA (Gedangan, Sidoarjo)

Website profil resmi **SMK Islam Tarbiyatul Badriyah (SMK ITABA) Gedangan, Sidoarjo** (NPSN: `69852106`), dilengkapi **CMS (Content Management System) berbasis PHP + MySQL** agar seluruh konten dapat dikelola langsung oleh pihak sekolah melalui panel admin.

---

## Struktur Halaman Publik

1. **Beranda (`index.php`)** — Hero, jadwal gelombang SPMB, statistik sekilas, tentang singkat, program keahlian, sorotan fasilitas & ekskul, pesan kepala sekolah, video profil & prestasi terbaru.
2. **Profil (`profil.php`)** — Tentang sekolah, fakta sekolah, pembiasaan pagi pesantren, nilai utama, 14 fasilitas, 15 ekskul & komunitas belajar, dan sejarah.
3. **Program Keahlian (`program.php`)** — Desain Komunikasi Visual (DKV) & Teknik Kendaraan Ringan (TKR), kompetensi, peluang kerja, serta peluang magang/karier ke Jepang.
4. **Galeri & Prestasi (`galeri.php`)** — Video profil YouTube, prestasi siswa dengan filter kategori, potret wajah juara, dokumentasi kegiatan dengan filter, dan 18 album Google Drive.
5. **Sambutan & Pendidik (`sambutan.php`)** — Sambutan Kepala Sekolah beserta jajaran pendidik dan tenaga kependidikan.
6. **Kontak (`kontak.php`)** — Alamat, email, telepon/WhatsApp, media sosial, dan peta Google Maps.
7. **SPMB (`spmb.php`)** — Jadwal gelombang, rincian biaya, persyaratan berkas, QR code formulir & admin, serta lokasi sekretariat.

---

## Fitur Panel Admin (`/admin`)

- **Pengaturan & Halaman (`admin/page.php`)**: mengubah identitas sekolah, logo, alamat, kontak, link media sosial, link formulir SPMB, link video YouTube, judul/deskripsi SEO, serta seluruh teks & gambar pada 7 halaman.
- **Daftar Konten (`admin/items.php`)**: menambah, mengubah, menghapus, menyembunyikan/menampilkan, dan mengatur urutan (↑/↓) untuk:
  - Program Keahlian
  - Pendidik & Tenaga Kependidikan
  - Prestasi Siswa, Kategori Prestasi, Ringkasan Prestasi, & Potret Wajah Juara
  - Dokumentasi Kegiatan, Kategori Dokumentasi, & Album Google Drive
  - Fasilitas, Kategori Ekskul, Fakta Sekolah, Pembiasaan Pagi, Nilai Utama, & Statistik Beranda
  - Gelombang SPMB, Rincian Biaya SPMB, & Persyaratan SPMB
- **Upload Gambar Otomatis**: upload foto JPG/PNG/WebP langsung dari komputer/HP, otomatis diperkecil (maks. lebar 1600 px) dan dikonversi ke WebP agar website tetap ringan.
- **Manajemen Akun (`admin/users.php`)**: mendukung peran **Administrator** (akses penuh) dan **Editor** (kelola konten), ganti password, proteksi CSRF, dan pembatasan percobaan login (rate limiting).

---

## Cara Memasang di Hosting (cPanel)

### Cara 1 — Otomatis melalui `install.php` (Disarankan)

1. Upload seluruh file project ini ke folder `public_html` di cPanel.
2. Buat database MySQL dan user database baru di menu **MySQL® Databases** cPanel, lalu hubungkan user ke database tersebut dengan izin **ALL PRIVILEGES**.
3. Buka `https://domain-sekolah.sch.id/install.php` di browser:
   - Langkah 1: masukkan nama database, user, dan password database.
   - Langkah 2: buat akun Administrator pertama. Seluruh konten awal website akan terisi otomatis.
4. Setelah selesai, **hapus file `install.php`** melalui File Manager cPanel.
5. Panel admin dapat diakses di `https://domain-sekolah.sch.id/admin`.

### Cara 2 — Impor Manual melalui phpMyAdmin

1. Salin `config.sample.php` menjadi `config.php`, lalu isi nama database, user, dan password MySQL.
2. Buka **phpMyAdmin**, pilih database Anda, lalu **Import** file `database.sql`.
3. Masuk ke `/admin` menggunakan akun awal:
   - **Username:** `admin`
   - **Password:** `itaba2026` *(segera ganti di menu **Akun Pengelola** setelah masuk)*.
4. Hapus file `install.php` dan `database.sql` dari server.

---

## Menjalankan Secara Lokal

Membutuhkan PHP 8.0+ dengan ekstensi `pdo_mysql` (atau `pdo_sqlite`) dan `gd`:

```bash
php -S localhost:8000
```

Buka `http://localhost:8000/install.php` dan pilih **SQLite** untuk mencoba tanpa perlu memasang MySQL lokal.
