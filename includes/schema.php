<?php
/**
 * Skema konten CMS.
 *
 * - settings_schema(): teks/gambar tunggal per halaman (judul, paragraf, link, dll).
 * - collections_schema(): data berbentuk daftar (guru, prestasi, fasilitas, dll).
 *
 * Nilai "default" adalah konten awal website. Bila admin belum mengubah,
 * website otomatis memakai nilai default ini.
 *
 * Tipe field: text, textarea, rich (boleh <br>, <em>, <strong>, <a>), richarea (multi-paragraf),
 * lines (satu item per baris), url, email, image, select, icon, checkbox, number.
 */
declare(strict_types=1);

/** Pembuat definisi field ringkas. */
function fld(string $key, string $label, string $type = 'text', string $default = '', array $extra = []): array
{
    return array_merge(['key' => $key, 'label' => $label, 'type' => $type, 'default' => $default], $extra);
}

/** Field standar bagian kepala halaman (hero). */
function hero_fields(string $eyebrow, string $title, string $text, string $watermark, string $metaTitle, string $metaDesc): array
{
    return [
        fld('meta_title', 'Judul tab browser (SEO)', 'text', $metaTitle),
        fld('meta_description', 'Deskripsi singkat untuk Google (SEO)', 'textarea', $metaDesc, ['help' => 'Idealnya 120–160 karakter.']),
        fld('hero_watermark', 'Teks watermark besar di latar', 'text', $watermark),
        fld('hero_eyebrow', 'Label kecil di atas judul', 'text', $eyebrow),
        fld('hero_title', 'Judul halaman', 'rich', $title),
        fld('hero_text', 'Paragraf pembuka', 'textarea', $text),
    ];
}

/** Field standar kepala seksi (label kecil, judul, paragraf). */
function head_fields(string $prefix, string $eyebrow, string $title, string $text = '', string $textLabel = 'Paragraf pengantar'): array
{
    $fields = [
        fld($prefix . '_eyebrow', 'Label kecil', 'text', $eyebrow),
        fld($prefix . '_title', 'Judul seksi', 'rich', $title),
    ];
    if ($text !== '') {
        $fields[] = fld($prefix . '_text', $textLabel, 'textarea', $text);
    }
    return $fields;
}

function settings_schema(): array
{
    static $schema = null;
    if ($schema !== null) {
        return $schema;
    }

    $schema = [
        'umum' => [
            'title' => 'Identitas & Kontak',
            'desc'  => 'Nama sekolah, alamat, kontak, media sosial, dan tautan penting yang tampil di seluruh halaman.',
            'icon'  => 'building',
            'sections' => [
                'Identitas Sekolah' => [
                    fld('site_name', 'Nama singkat sekolah', 'text', 'SMK ITABA'),
                    fld('site_fullname', 'Nama resmi sekolah', 'text', 'SMK Islam Tarbiyatul Badriyah'),
                    fld('site_location', 'Lokasi singkat (di bawah logo)', 'text', 'Gedangan · Sidoarjo'),
                    fld('tagline', 'Slogan', 'text', 'Berkarakter · Inovatif · Kompetitif'),
                    fld('npsn', 'NPSN', 'text', '69852106'),
                    fld('tahun_berdiri', 'Tahun berdiri', 'text', '2010'),
                    fld('yayasan', 'Yayasan penaung', 'text', 'Yayasan Al Badriyah Al Mustofa'),
                    fld('logo', 'Logo sekolah', 'image', 'assets/img/logo-itaba-256.png', ['help' => 'Disarankan PNG persegi transparan, minimal 256×256 px.']),
                    fld('footer_about', 'Deskripsi singkat di footer', 'textarea', 'SMK Islam Tarbiyatul Badriyah (NPSN: 69852106). Membangun kompetensi, membentuk karakter, menyiapkan generasi yang siap berkarya dan berkembang.'),
                ],
                'Alamat & Kontak' => [
                    fld('topbar_address', 'Alamat singkat (bar atas)', 'text', 'Tebel, Gedangan, Sidoarjo'),
                    fld('address', 'Alamat lengkap', 'textarea', 'Jl. RA Mustika Tebel Timur, RT 02 RW 07, Desa Tebel, Kecamatan Gedangan, Kabupaten Sidoarjo 61254'),
                    fld('email', 'Email resmi', 'email', 'semkitaba10@gmail.com'),
                    fld('whatsapp', 'Nomor WhatsApp / telepon (opsional)', 'text', '', ['help' => 'Contoh: 081234567890. Kosongkan bila tidak ingin ditampilkan.']),
                    fld('maps_query', 'Kata kunci lokasi Google Maps', 'text', 'SMK ITABA Tebel Gedangan Sidoarjo', ['help' => 'Teks yang dicari di Google Maps untuk peta & tombol petunjuk arah.']),
                ],
                'Media Sosial' => [
                    fld('instagram_url', 'Link Instagram', 'url', 'https://instagram.com/smkitabagedangan'),
                    fld('instagram_handle', 'Nama akun Instagram', 'text', '@smkitabagedangan'),
                    fld('facebook_url', 'Link Facebook', 'url', 'https://facebook.com/smkitaba'),
                    fld('facebook_name', 'Nama halaman Facebook', 'text', 'SMK ITABA Gedangan'),
                    fld('tiktok_url', 'Link TikTok', 'url', 'https://www.tiktok.com/@smk.itaba.sidoarjo'),
                    fld('tiktok_handle', 'Nama akun TikTok', 'text', '@smk.itaba.sidoarjo'),
                    fld('youtube_url', 'Link video profil YouTube', 'url', 'https://youtu.be/oyTe0VfkwF4', ['help' => 'Tempel link video YouTube. Dipakai di Beranda & Galeri.']),
                ],
                'SPMB (Penerimaan Siswa Baru)' => [
                    fld('spmb_label', 'Label menu SPMB', 'text', 'SPMB 2027/2028'),
                    fld('spmb_tahun', 'Tahun ajaran SPMB', 'text', '2027/2028'),
                    fld('spmb_form_url', 'Link formulir pendaftaran online', 'url', 'https://forms.gle/X3WHkQAgbmE7r7Aj8'),
                ],
            ],
        ],

        'beranda' => [
            'title' => 'Beranda',
            'desc'  => 'Halaman utama website.',
            'icon'  => 'star',
            'page'  => 'index.php',
            'sections' => [
                'SEO' => [
                    fld('meta_title', 'Judul tab browser (SEO)', 'text', 'SMK ITABA — Berkarakter, Inovatif, Kompetitif'),
                    fld('meta_description', 'Deskripsi singkat untuk Google (SEO)', 'textarea', 'Website resmi SMK ITABA (SMK Islam Tarbiyatul Badriyah) Gedangan, Sidoarjo. Kenali program keahlian DKV dan TKR, fasilitas ber-AC, ekskul, dan SPMB 2027/2028.'),
                ],
                'Hero (bagian paling atas)' => [
                    fld('hero_image', 'Foto latar hero', 'image', 'assets/img/gedung.webp'),
                    fld('hero_eyebrow', 'Label kecil', 'text', 'SMK Islam Tarbiyatul Badriyah · Sidoarjo'),
                    fld('hero_title', 'Judul utama', 'rich', 'Belajar dengan makna.<br><em>Berkarya untuk masa depan.</em>'),
                    fld('hero_lede', 'Paragraf pembuka', 'textarea', 'Membangun kompetensi kejuruan DKV & TKR, membentuk karakter santri, dan menyiapkan generasi yang siap kerja, berwirausaha, serta bersaing global.'),
                    fld('hero_values', 'Nilai sekolah (satu per baris)', 'lines', "Berkarakter\nInovatif\nKompetitif"),
                    fld('hero_card_title', 'Kartu SPMB: judul', 'text', 'Langkah pertamamu dimulai di sini.'),
                    fld('hero_card_subtitle', 'Kartu SPMB: subjudul', 'text', 'Penerimaan Siswa Baru · Tahun Ajaran 2027/2028', ['help' => 'Jadwal gelombang diambil otomatis dari daftar "Gelombang SPMB".']),
                ],
                'Tentang Kami' => array_merge([
                    fld('tentang_image', 'Foto', 'image', 'assets/img/gedung.webp'),
                    fld('tentang_tag', 'Label pada foto', 'text', 'TEBEL · GEDANGAN · SIDOARJO'),
                ], head_fields('tentang', 'Tentang kami', 'Tempat tumbuhnya<br><em>keahlian dan karakter.</em>'), [
                    fld('tentang_lead', 'Paragraf utama', 'textarea', 'SMK ITABA memadukan pendidikan kejuruan, nilai-nilai keislaman, dan pembiasaan ibadah harian dalam lingkungan belajar yang dekat dengan kehidupan nyata.'),
                    fld('tentang_text', 'Paragraf lanjutan', 'richarea', 'Berdiri sejak 2010 di bawah naungan Yayasan Al Badriyah Al Mustofa, kami mendampingi siswa mengembangkan kompetensi kejuruan, akhlak mulia, dan rasa percaya diri untuk menapaki dunia kerja maupun berwirausaha mandiri.'),
                ]),
                'Program Keahlian (ringkas)' => head_fields('program', 'Temukan bidangmu', 'Dua jalur keahlian.<br><em>Banyak kemungkinan.</em>', 'Bangun kemampuan aplikatif yang relevan dengan industri kreatif dan otomotif modern, lengkap dengan peluang karier global.'),
                'Fasilitas & Ekskul (ringkas)' => array_merge(
                    head_fields('fasilitas', 'Lingkungan Belajar Unggul', 'Fasilitas modern &<br><em>komunitas kreatif.</em>', 'Didukung gedung 3 lantai terakreditasi di kawasan pendidikan Desa Tebel Gedangan, laboratorium full AC, dan 15 pilihan ekstrakurikuler.'),
                    [
                        fld('fas_card_badge', 'Kartu fasilitas: label', 'text', '14 Fasilitas Sekolah'),
                        fld('fas_card_title', 'Kartu fasilitas: judul', 'text', 'Sarana Belajar Lengkap & Terakreditasi'),
                        fld('fas_card_text', 'Kartu fasilitas: teks', 'textarea', 'Kelas dan laboratorium komputer/multimedia Full AC, Wi-Fi gratis 24 jam (up to 120 Mbps), bengkel otomotif, rumah produksi DKV, lapangan olahraga, hingga asrama pondok pesantren & musholla.'),
                        fld('eks_card_badge', 'Kartu ekskul: label', 'text', '15 Ekskul & Komunitas'),
                        fld('eks_card_title', 'Kartu ekskul: judul', 'text', 'Wadah Bakat, Teknologi & Karakter'),
                        fld('eks_card_text', 'Kartu ekskul: teks', 'textarea', 'Kembangkan potensi melalui Robotika & Virtual Metavers, Animasi Game 2D/3D, Video & Fotografi, Pencak Silat Pagar Nusa, Futsal, Bulu Tangkis, Pramuka, Teater, hingga SEMKIPALA.'),
                    ]
                ),
                'Pesan Kepala Sekolah (ringkas)' => [
                    fld('sambutan_eyebrow', 'Label kecil', 'text', 'Pesan kepala sekolah'),
                    fld('sambutan_quote', 'Kutipan singkat', 'textarea', 'Kami berkomitmen menyelenggarakan pendidikan yang memadukan kompetensi kejuruan, pendidikan karakter, dan nilai-nilai keislaman, sehingga mampu melahirkan lulusan yang siap menghadapi dunia kerja serta tantangan global.', ['help' => 'Nama & foto kepala sekolah diambil dari pengaturan halaman Sambutan.']),
                ],
                'Video & Prestasi' => array_merge(
                    head_fields('video', 'Video & Prestasi Terbaru', 'Profil sekolah &<br><em>kebanggaan kami.</em>', 'Tonton video profil resmi SMK ITABA dan lihat sebagian prestasi siswa di ajang LKS Kabupaten Sidoarjo hingga kejuaraan pencak silat.'),
                    [fld('video_label', 'Label pada video', 'text', 'PROFIL SMK ITABA', ['help' => 'Prestasi yang tampil di sini adalah prestasi yang dicentang "Tampilkan di Beranda".'])]
                ),
                'Ajakan SPMB (bawah)' => head_fields('cta', 'SPMB · Tahun Ajaran 2027/2028', 'Mari bertumbuh <em>bersama.</em>', 'Pilih bidang keahlian DKV atau TKR, siapkan berkas, dan bergabung bersama keluarga besar SMK ITABA.'),
            ],
        ],

        'profil' => [
            'title' => 'Profil',
            'desc'  => 'Tentang sekolah, pembiasaan, nilai, fasilitas, ekskul, dan sejarah.',
            'icon'  => 'book',
            'page'  => 'profil.php',
            'sections' => [
                'Kepala Halaman' => array_merge(
                    [fld('hero_image', 'Foto latar', 'image', 'assets/img/gedung.webp')],
                    hero_fields('Pendidikan yang menyiapkan kehidupan', 'Profil <em>SMK ITABA.</em>', 'SMK Islam Tarbiyatul Badriyah (NPSN: 69852106) — Didukung gedung 3 lantai terakreditasi, fasilitas modern ber-AC, serta beragam ekskul dan komunitas belajar pengembangan bakat siswa.', 'PROFIL', 'Profil, Fasilitas & Ekskul — SMK ITABA Gedangan', 'Profil SMK ITABA (SMK Islam Tarbiyatul Badriyah) Gedangan, Sidoarjo: Fasilitas lengkap ber-AC, 15 ekskul & komunitas belajar, nilai pesantren, dan akreditasi.')
                ),
                'Tentang Kami' => array_merge(
                    head_fields('tentang', '01 — Tentang kami', 'Tempat tumbuhnya<br><em>keahlian dan karakter.</em>'),
                    [
                        fld('tentang_lead', 'Paragraf utama', 'textarea', 'SMK ITABA (Sekolah Menengah Kejuruan Islam Tarbiyatul Badriyah) memadukan pendidikan kejuruan, nilai-nilai keislaman, dan pembentukan karakter dalam lingkungan belajar yang dekat dengan kehidupan nyata.'),
                        fld('tentang_body', 'Paragraf lanjutan', 'richarea', "Berdiri sejak 2010 di bawah naungan Yayasan Al Badriyah Al Mustofa, kami hadir dengan semangat untuk memberikan pendidikan yang tidak hanya berorientasi pada penguasaan ilmu pengetahuan dan keterampilan kejuruan, tetapi juga mengutamakan akhlak, kedisiplinan, dan etos kerja.\n\nSebagai lembaga pendidikan yang berakar pada nilai-nilai pondok pesantren, SMK ITABA mendampingi setiap peserta didik agar memiliki kompetensi kuat, berakhlak mulia, percaya diri, dan siap bersaing di dunia industri hingga tingkat internasional.", ['help' => 'Pisahkan paragraf dengan satu baris kosong.']),
                        fld('fact_caption', 'Keterangan angka besar (tahun berdiri)', 'text', 'Tahun berdiri', ['help' => 'Isi kartu fakta dikelola di daftar "Fakta Sekolah".']),
                    ]
                ),
                'Pembiasaan Pagi' => head_fields('pembiasaan', '02 — Karakter & Nilai Pesantren', 'Pembiasaan pagi<br><em>membentuk akhlak mulia.</em>', 'Setiap pagi sebelum kegiatan belajar mengajar dimulai pukul 08.10 WIB, peserta didik dibiasakan mengawali hari dengan ibadah dan pembinaan rohani.'),
                'Nilai Utama' => head_fields('nilai', '03 — Nilai Utama', 'Berkarakter, inovatif,<br><em>kompetitif.</em>', 'Pendidikan kejuruan berjalan berdampingan dengan pembiasaan keagamaan dan pembentukan akhlak.'),
                'Fasilitas' => array_merge(
                    head_fields('fasilitas', '04 — Sarana & Prasarana', 'Fasilitas belajar<br><em>lengkap & modern.</em>', 'Menunjang proses belajar teori dan praktik siswa dalam lingkungan yang nyaman, bersih, representatif, serta terakreditasi.'),
                    [
                        fld('fasilitas_badge_big', 'Lencana: teks besar', 'text', '3 Lantai'),
                        fld('fasilitas_badge_small', 'Lencana: teks kecil', 'text', 'Terakreditasi'),
                        fld('fasilitas_lead', 'Paragraf gedung', 'rich', 'Gedung SMK ITABA yang terletak di kawasan pendidikan Desa Tebel Gedangan terdiri dari <strong>3 lantai</strong> dan mempunyai ruang kelas untuk <em>Teori dan Praktek siswa</em>. Ruang yang nyaman dan lingkungan yang bersih akan membuat para siswa terhindar dari kejenuhan, serta telah <strong>TERAKREDITASI</strong>.'),
                    ]
                ),
                'Ekskul & Komunitas' => head_fields('ekskul', '05 — Bakat & Minat Siswa', 'Ekskul & komunitas<br><em>belajar kreatif.</em>', 'SMK ITABA menyediakan beragam wadah kegiatan ekstrakurikuler dan komunitas belajar untuk mengasah bakat, teknologi, kepemimpinan, dan potensi diri siswa.'),
                'Sejarah' => array_merge(
                    [
                        fld('sejarah_image', 'Foto', 'image', 'assets/img/gedung.webp'),
                        fld('sejarah_tag', 'Label pada foto', 'text', 'TEBEL · GEDANGAN · SIDOARJO'),
                    ],
                    head_fields('sejarah', '06 — Akar dan arah', 'Berangkat dari nilai.<br><em>Bertumbuh bersama zaman.</em>'),
                    [
                        fld('sejarah_body', 'Isi sejarah', 'richarea', "SMK ITABA (Sekolah Menengah Kejuruan Islam Tarbiyatul Badriyah) didirikan pada tahun 2010 oleh KH. Badrul Munir, M.Pd.I. (Alm.) dan kepemimpinan yayasan kini dilanjutkan oleh putra beliau, yakni <strong>Gus Anwaruddin</strong>, di bawah naungan <strong>Yayasan Al Badriyah Al Mustofa</strong>.\n\nPendidikan kejuruan berjalan berdampingan dengan pembiasaan keagamaan dan pembentukan akhlak mulia. Melalui program keahlian Desain Komunikasi Visual (DKV) dan Teknik Kendaraan Ringan (TKR), sekolah terus mengembangkan kurikulum yang aplikatif, relevan dengan kebutuhan dunia usaha dan dunia industri (DUDI), serta membuka akses kemitraan internasional.", ['help' => 'Pisahkan paragraf dengan satu baris kosong.']),
                        fld('sejarah_quote', 'Kutipan / motto', 'text', '“Membangun Kompetensi, Membentuk Karakter, Menyiapkan Masa Depan.”'),
                        fld('marquee', 'Teks berjalan (satu kata per baris)', 'lines', "Berkarakter\nInovatif\nKompetitif"),
                    ]
                ),
            ],
        ],

        'program' => [
            'title' => 'Program Keahlian',
            'desc'  => 'Kepala halaman dan ajakan SPMB. Detail jurusan dikelola di daftar "Program Keahlian".',
            'icon'  => 'pen',
            'page'  => 'program.php',
            'sections' => [
                'Kepala Halaman' => hero_fields('Temukan bidangmu', 'Dua jalur keahlian.<br><em>Banyak kemungkinan.</em>', 'Membekali peserta didik dengan kompetensi siap kerja, siap berwirausaha, dan siap bersaing di dunia industri hingga tingkat internasional.', 'DKV · TKR', 'Program Keahlian DKV & TKR — SMK ITABA', 'Program keahlian SMK ITABA: Desain Komunikasi Visual (DKV) dan Teknik Kendaraan Ringan (TKR). Kompetensi kejuruan dan peluang magang/karier ke Jepang.'),
                'Ajakan SPMB' => head_fields('cta', 'SPMB · Tahun Ajaran 2027/2028', 'Sudah menemukan <em>bidangmu?</em>', 'Pilih jurusan DKV atau TKR, siapkan berkas pendaftaran, dan bergabung bersama SMK ITABA.'),
            ],
        ],

        'galeri' => [
            'title' => 'Galeri & Prestasi',
            'desc'  => 'Video profil, prestasi siswa, dokumentasi kegiatan, dan album foto.',
            'icon'  => 'camera',
            'page'  => 'galeri.php',
            'sections' => [
                'Kepala Halaman' => hero_fields('Video · Prestasi · Dokumentasi', 'Cerita, karya &<br><em>prestasi SMK ITABA.</em>', 'Tonton video profil sekolah, kenali deretan juara kebanggaan kami, dan telusuri dokumentasi kegiatan santri, praktik kejuruan, kunjungan industri, hingga ekstrakurikuler.', 'GALERI', 'Galeri, Prestasi & Video Profil — SMK ITABA Gedangan', 'Video profil, prestasi siswa, dan dokumentasi kegiatan SMK ITABA Gedangan Sidoarjo: juara LKS, pencak silat Pagar Nusa, kunjungan industri, Hari Santri, pramuka, paskibra, dan karya siswa DKV & TKR.'),
                'Video Profil' => array_merge(
                    head_fields('video', 'Video Profil Sekolah', 'Kenali SMK ITABA<br><em>dalam beberapa menit.</em>', 'Lihat langsung suasana belajar, fasilitas, praktik DKV & TKR, serta budaya santri yang membentuk karakter siswa SMK ITABA Gedangan.'),
                    [
                        fld('video_points', 'Poin isi video (satu per baris)', 'lines', "Lingkungan & fasilitas sekolah\nPraktik kejuruan DKV & TKR\nKegiatan santri & ekstrakurikuler"),
                        fld('video_label', 'Label pada video', 'text', 'PROFIL SMK ITABA'),
                        fld('video_sublabel', 'Sub-label pada video', 'text', 'YouTube · SMK ITABA SIDOARJO', ['help' => 'Link video diatur di menu Identitas & Kontak.']),
                    ]
                ),
                'Prestasi Siswa' => array_merge(
                    head_fields('prestasi', 'Prestasi Siswa', 'Deretan juara<br><em>kebanggaan ITABA.</em>', 'Dari Lomba Kompetensi Siswa, festival kreatif, hingga gelanggang pencak silat — siswa SMK ITABA terus membuktikan bahwa karakter dan kompetensi bisa berjalan bersama.'),
                    [
                        fld('prestasi_mascot', 'Gambar maskot', 'image', 'assets/img/owi-juara.webp'),
                        fld('prestasi_all_label', 'Label tombol filter "semua"', 'text', 'Semua Prestasi'),
                    ]
                ),
                'Wajah Juara (potret)' => head_fields('champion', 'Wajah-wajah juara', 'Setiap piala punya <em>cerita.</em>', 'Siswa DKV, TKR, dan pramuka SMK ITABA bersama piala yang mereka perjuangkan.'),
                'Dokumentasi Kegiatan' => array_merge(
                    head_fields('dok', 'Dokumentasi Kegiatan', 'Momen belajar,<br><em>berkarya & bertumbuh.</em>', 'Klik foto untuk memperbesar. Gunakan kategori untuk menyaring kegiatan keagamaan, kunjungan industri, ekstrakurikuler, dan karya kejuruan.'),
                    [fld('dok_all_label', 'Label tombol filter "semua"', 'text', 'Semua')]
                ),
                'Album Lengkap' => head_fields('album', 'Album Lengkap', 'Arsip foto<br><em>setiap kegiatan.</em>', 'Ratusan foto resolusi penuh tersimpan rapi di Google Drive sekolah. Pilih album untuk melihat dan mengunduh dokumentasi lengkapnya.'),
            ],
        ],

        'sambutan' => [
            'title' => 'Sambutan & Pendidik',
            'desc'  => 'Sambutan kepala sekolah. Daftar guru dikelola di daftar "Pendidik & Tenaga Kependidikan".',
            'icon'  => 'user',
            'page'  => 'sambutan.php',
            'sections' => [
                'Kepala Halaman' => hero_fields('Pesan kepala sekolah', 'Sambutan &<br><em>warga sekolah.</em>', 'Jajaran pimpinan, pendidik, dan tenaga kependidikan yang mendampingi proses belajar serta pembentukan karakter peserta didik di SMK ITABA.', 'SAMBUTAN', 'Sambutan & Warga Sekolah — SMK ITABA', 'Sambutan Kepala SMK ITABA, Dr. Joko Siswanto, M.Pd.I, serta pesan para pendidik dan tenaga kependidikan SMK ITABA Gedangan, Sidoarjo.'),
                'Kepala Sekolah' => [
                    fld('kepsek_nama', 'Nama kepala sekolah', 'text', 'Dr. Joko Siswanto, M.Pd.I'),
                    fld('kepsek_jabatan', 'Jabatan', 'text', 'Kepala SMK ITABA'),
                    fld('kepsek_label', 'Label pada foto', 'text', 'KEPALA SEKOLAH'),
                    fld('kepsek_foto', 'Foto kepala sekolah', 'image', 'assets/img/joko-siswanto.webp', ['help' => 'Foto potret (tegak), disarankan rasio 4:5.']),
                ],
                'Isi Sambutan' => array_merge(
                    head_fields('sambutan', '01 — Pesan kepala sekolah', 'Tumbuh menjadi pribadi<br><em>yang siap berkarya.</em>'),
                    [
                        fld('sambutan_quote', 'Kutipan pembuka (huruf besar)', 'textarea', 'Puji syukur kehadirat Allah SWT atas segala rahmat dan karunia-Nya. Website ini hadir sebagai sarana informasi, komunikasi, dan publikasi berbagai kegiatan serta perkembangan SMK ITABA kepada peserta didik, orang tua, masyarakat, dan dunia industri.'),
                        fld('sambutan_body', 'Isi sambutan lanjutan', 'richarea', 'SMK ITABA berkomitmen menyelenggarakan pendidikan yang memadukan kompetensi kejuruan, pendidikan karakter, dan nilai-nilai keislaman, sehingga mampu melahirkan lulusan yang berakhlak mulia, kompeten, mandiri, inovatif, dan siap menghadapi dunia kerja serta tantangan global.', ['help' => 'Pisahkan paragraf dengan satu baris kosong.']),
                    ]
                ),
                'Pendidik & Tenaga Kependidikan' => head_fields('pendidik', '02 — Warga sekolah', 'Pendidik & tenaga<br><em>kependidikan.</em>', 'Mendampingi secara profesional dalam bidang kurikulum, kesiswaan, hubungan industri, sarana, keahlian jurusan, hingga tata usaha dan data sekolah.'),
            ],
        ],

        'kontak' => [
            'title' => 'Kontak',
            'desc'  => 'Teks halaman kontak. Alamat, email, dan media sosial diatur di Identitas & Kontak.',
            'icon'  => 'mail',
            'page'  => 'kontak.php',
            'sections' => [
                'Kepala Halaman' => hero_fields('Kunjungi kami', 'Mari bertumbuh<br><em>bersama.</em>', 'Datang langsung ke SMK ITABA atau hubungi kami melalui telepon, email, dan media sosial resmi sekolah.', 'KONTAK', 'Kontak & Lokasi — SMK ITABA Gedangan', 'Kontak dan lokasi SMK ITABA (SMK Islam Tarbiyatul Badriyah): Jl. RA Mustika Tebel Timur, Desa Tebel, Gedangan, Sidoarjo. NPSN 69852106.'),
                'Ajakan SPMB' => head_fields('cta', 'SPMB · Tahun Ajaran 2027/2028', 'Langkah pertamamu <em>dimulai di sini.</em>', 'Pendaftaran dapat dilakukan secara online atau diserahkan melalui SMP/MTs asal.'),
            ],
        ],

        'spmb' => [
            'title' => 'SPMB',
            'desc'  => 'Informasi penerimaan siswa baru. Gelombang, biaya, dan persyaratan dikelola di daftar masing-masing.',
            'icon'  => 'calendar',
            'page'  => 'spmb.php',
            'sections' => [
                'Kepala Halaman' => array_merge(
                    hero_fields('Penerimaan Siswa Baru · Tahun Ajaran 2027/2028', 'Langkah pertamamu<br>dimulai <em>di sini.</em>', 'Pilih bidang keahlian DKV atau TKR, siapkan berkas pendaftaran, dan bergabung bersama keluarga besar SMK ITABA.', 'ITABA', 'SPMB 2027/2028 — SMK ITABA Gedangan', 'Informasi SPMB SMK ITABA tahun ajaran 2027/2028: jadwal gelombang, rincian biaya seragam siap pakai, persyaratan, formulir online, dan kontak admin.'),
                    [
                        fld('hero_button', 'Teks tombol formulir', 'text', 'Isi formulir pendaftaran'),
                        fld('badge_image', 'Gambar lencana SPMB', 'image', 'assets/img/lencana-spmb.webp'),
                    ]
                ),
                'Jadwal' => head_fields('jadwal', '01 — Jadwal pendaftaran', 'Pilih gelombang<br><em>yang sesuai.</em>', 'Pastikan mengecek informasi terbaru dengan panitia. Pendaftaran dibuka melalui 3 gelombang terstruktur.'),
                'Biaya' => array_merge(
                    head_fields('biaya', '02 — Rincian biaya', 'Rencanakan<br><em>pendaftaranmu.</em>', 'Informasi biaya resmi berdasarkan dokumen SPMB SMK ITABA tahun ajaran 2027/2028.'),
                    [
                        fld('biaya_cakupan', 'Keterangan cakupan biaya', 'rich', '<strong>Cakupan Biaya:</strong> Biaya gelombang di atas sudah mencakup <strong>5 stel seragam (sudah terjahit dan siap pakai)</strong>, atribut seragam lengkap, dan kegiatan MPLS (Masa Pengenalan Lingkungan Sekolah).'),
                        fld('biaya_spp', 'Catatan SPP', 'textarea', 'SPP diperkirakan tetap Rp200.000/bulan (mengacu pada bulan Juli 2026). Mohon konfirmasi nominal tahun ajaran 2027/2028 kepada panitia saat pendaftaran.'),
                    ]
                ),
                'Persyaratan' => head_fields('syarat', '03 — Persyaratan', 'Siapkan berkas<br><em>pendaftaran.</em>', 'Isi formulir pendaftaran dan serahkan dengan melampirkan berkas persyaratan berikut (fotokopi masing-masing 2 lembar, kecuali pas foto).'),
                'QR Code Daftar & Bertanya' => array_merge(
                    head_fields('daftar', '04 — Daftar dan bertanya', 'Semua informasi<br><em>dalam genggaman.</em>', 'Scan QR code untuk langsung membuka formulir pendaftaran online atau menghubungi admin SPMB.'),
                    [
                        fld('qr_form', 'QR formulir', 'image', 'assets/img/qr-formulir-spmb.png'),
                        fld('qr_form_label', 'QR formulir: label', 'text', 'SCAN UNTUK MENDAFTAR'),
                        fld('qr_form_title', 'QR formulir: judul', 'text', 'Formulir SPMB'),
                        fld('qr_admin', 'QR admin', 'image', 'assets/img/qr-admin-spmb.png'),
                        fld('qr_admin_label', 'QR admin: label', 'text', 'INFORMASI PENDAFTARAN'),
                        fld('qr_admin_title', 'QR admin: judul', 'text', 'Admin SPMB'),
                        fld('qr_admin_text', 'QR admin: keterangan', 'text', 'Scan untuk menghubungi nomor resmi panitia sekolah.'),
                    ]
                ),
                'Sekretariat' => array_merge(
                    head_fields('lokasi', 'Sekretariat pendaftaran', 'Datang langsung<br>ke <em>SMK ITABA.</em>'),
                    [
                        fld('ketua_panitia', 'Ketua panitia', 'text', 'Ketua Panitia PPDB: Muis Lidinillah, S.Pd.'),
                        fld('lokasi_note', 'Catatan', 'text', 'Catatan: Pendaftaran juga dapat diserahkan melalui perwakilan di SMP/MTs asal.'),
                    ]
                ),
            ],
        ],
    ];

    // Lengkapi key penuh "grup.key".
    foreach ($schema as $group => &$def) {
        foreach ($def['sections'] as &$fields) {
            foreach ($fields as &$field) {
                $field['name'] = $group . '.' . $field['key'];
            }
        }
    }
    unset($def, $fields, $field);

    return $schema;
}

/** Peta default seluruh pengaturan: ['grup.key' => default]. */
function setting_defaults(): array
{
    static $defaults = null;
    if ($defaults === null) {
        $defaults = [];
        foreach (settings_schema() as $def) {
            foreach ($def['sections'] as $fields) {
                foreach ($fields as $field) {
                    $defaults[$field['name']] = $field['default'];
                }
            }
        }
    }
    return $defaults;
}

/* ------------------------------------------------------------------ */
/* Koleksi / daftar                                                    */
/* ------------------------------------------------------------------ */

function collections_schema(): array
{
    static $schema = null;
    if ($schema !== null) {
        return $schema;
    }

    $rankStyles = ['' => 'Hijau (standar)', 'gold' => 'Emas', 'silver' => 'Perak', 'bronze' => 'Perunggu'];

    $schema = [
        'stats' => [
            'title' => 'Statistik Sekilas', 'singular' => 'statistik', 'group' => 'beranda',
            'desc' => 'Kotak angka di bawah hero Beranda.',
            'columns' => ['value', 'label'],
            'fields' => [
                fld('value', 'Angka / judul', 'text', '', ['required' => true]),
                fld('label', 'Keterangan', 'text'),
                fld('accent', 'Sorot dengan warna hijau muda', 'checkbox'),
            ],
        ],
        'program' => [
            'title' => 'Program Keahlian', 'singular' => 'program keahlian', 'group' => 'program',
            'desc' => 'Jurusan yang tampil di Beranda dan halaman Program Keahlian.',
            'columns' => ['nama', 'singkatan'],
            'fields' => [
                fld('nama', 'Nama program', 'text', '', ['required' => true]),
                fld('singkatan', 'Singkatan', 'text', '', ['help' => 'Contoh: DKV']),
                fld('slug', 'ID tautan (tanpa spasi)', 'text', '', ['help' => 'Dipakai untuk link langsung, contoh: dkv → program.php#dkv']),
                fld('kode', 'Label kode', 'text', '', ['help' => 'Contoh: 01 / KREATIF DIGITAL']),
                fld('gaya', 'Warna kartu', 'select', 'dkv', ['options' => ['dkv' => 'Hijau tua', 'tkr' => 'Abu gelap']]),
                fld('icon', 'Ikon', 'icon', 'star'),
                fld('simbol', 'Simbol dekoratif (1 karakter)', 'text', '✳'),
                fld('tagline', 'Slogan program', 'text'),
                fld('ringkasan', 'Ringkasan (kartu di Beranda)', 'textarea'),
                fld('deskripsi', 'Deskripsi utama', 'textarea'),
                fld('kompetensi', 'Kompetensi yang dipelajari (satu per baris)', 'lines'),
                fld('peluang', 'Peluang kerja (satu per baris)', 'lines'),
                fld('highlight_judul', 'Kotak sorotan: judul', 'text'),
                fld('highlight_teks', 'Kotak sorotan: isi', 'textarea'),
            ],
        ],
        'fakta' => [
            'title' => 'Fakta Sekolah', 'singular' => 'fakta', 'group' => 'profil',
            'desc' => 'Kartu fakta di samping "Tentang kami" (halaman Profil).',
            'columns' => ['label', 'nilai'],
            'fields' => [
                fld('label', 'Label', 'text', '', ['required' => true]),
                fld('nilai', 'Isi', 'text'),
            ],
        ],
        'rutinitas' => [
            'title' => 'Pembiasaan Pagi', 'singular' => 'kegiatan', 'group' => 'profil',
            'columns' => ['judul', 'waktu'],
            'fields' => [
                fld('waktu', 'Waktu', 'text', 'Pagi Hari'),
                fld('judul', 'Nama kegiatan', 'text', '', ['required' => true]),
                fld('deskripsi', 'Deskripsi', 'textarea'),
            ],
        ],
        'nilai' => [
            'title' => 'Nilai Utama', 'singular' => 'nilai', 'group' => 'profil',
            'columns' => ['judul'],
            'fields' => [
                fld('judul', 'Judul', 'text', '', ['required' => true]),
                fld('icon', 'Ikon', 'icon', 'star'),
                fld('deskripsi', 'Deskripsi', 'textarea'),
            ],
        ],
        'fasilitas' => [
            'title' => 'Fasilitas', 'singular' => 'fasilitas', 'group' => 'profil',
            'columns' => ['nama', 'keterangan'],
            'fields' => [
                fld('nama', 'Nama fasilitas', 'text', '', ['required' => true]),
                fld('keterangan', 'Keterangan singkat', 'text'),
                fld('icon', 'Ikon', 'icon', 'building'),
            ],
        ],
        'ekskul' => [
            'title' => 'Kategori Ekskul', 'singular' => 'kategori ekskul', 'group' => 'profil',
            'desc' => 'Setiap kategori berisi daftar ekskul.',
            'columns' => ['judul', 'subjudul'],
            'fields' => [
                fld('judul', 'Nama kategori', 'text', '', ['required' => true]),
                fld('subjudul', 'Keterangan', 'text'),
                fld('icon', 'Ikon', 'icon', 'star'),
                fld('aksen', 'Ikon berwarna hijau muda', 'checkbox'),
                fld('daftar', 'Daftar ekskul (satu per baris, format: Nama | Tag)', 'lines', '', ['help' => 'Contoh: Futsal | Olahraga']),
            ],
        ],
        'guru' => [
            'title' => 'Pendidik & Tenaga Kependidikan', 'singular' => 'pendidik', 'group' => 'sambutan',
            'columns' => ['nama', 'jabatan'], 'thumb' => 'foto',
            'fields' => [
                fld('nama', 'Nama lengkap & gelar', 'text', '', ['required' => true]),
                fld('jabatan', 'Jabatan', 'text'),
                fld('foto', 'Foto', 'image', '', ['help' => 'Foto potret (tegak), disarankan rasio 4:5.']),
                fld('pesan', 'Pesan / kutipan', 'textarea'),
                fld('featured', 'Sorot (label jabatan berwarna hijau muda)', 'checkbox'),
            ],
        ],
        'spmb_gelombang' => [
            'title' => 'Gelombang SPMB', 'singular' => 'gelombang', 'group' => 'spmb',
            'desc' => 'Tampil di halaman SPMB dan kartu SPMB di Beranda.',
            'columns' => ['label', 'tanggal'],
            'fields' => [
                fld('label', 'Nama gelombang', 'text', '', ['required' => true]),
                fld('tanggal', 'Periode', 'text', '', ['help' => 'Contoh: 01 Jan — 30 Mar 2027']),
                fld('keterangan', 'Keterangan', 'text'),
                fld('featured', 'Sorot (kartu berwarna gelap)', 'checkbox'),
            ],
        ],
        'spmb_biaya' => [
            'title' => 'Rincian Biaya SPMB', 'singular' => 'biaya', 'group' => 'spmb',
            'columns' => ['item', 'nominal'],
            'fields' => [
                fld('item', 'Komponen biaya', 'text', '', ['required' => true]),
                fld('nominal', 'Nominal', 'text', '', ['help' => 'Contoh: Rp2.400.000']),
            ],
        ],
        'spmb_syarat' => [
            'title' => 'Persyaratan SPMB', 'singular' => 'persyaratan', 'group' => 'spmb',
            'columns' => ['teks'],
            'fields' => [
                fld('teks', 'Persyaratan', 'text', '', ['required' => true]),
            ],
        ],
        'prestasi_kategori' => [
            'title' => 'Kategori Prestasi', 'singular' => 'kategori', 'group' => 'galeri',
            'desc' => 'Tombol filter di bagian prestasi.',
            'columns' => ['label', 'slug'],
            'fields' => [
                fld('label', 'Nama kategori', 'text', '', ['required' => true]),
                fld('slug', 'Kode (huruf kecil tanpa spasi)', 'text', '', ['required' => true, 'help' => 'Contoh: olahraga']),
            ],
        ],
        'prestasi_stats' => [
            'title' => 'Ringkasan Prestasi', 'singular' => 'ringkasan', 'group' => 'galeri',
            'columns' => ['value', 'label'],
            'fields' => [
                fld('value', 'Angka / judul', 'text', '', ['required' => true]),
                fld('label', 'Keterangan', 'text'),
                fld('accent', 'Sorot dengan warna', 'checkbox'),
            ],
        ],
        'prestasi' => [
            'title' => 'Prestasi Siswa', 'singular' => 'prestasi', 'group' => 'galeri',
            'columns' => ['judul', 'peringkat'], 'thumb' => 'foto',
            'fields' => [
                fld('judul', 'Nama lomba / prestasi', 'text', '', ['required' => true]),
                fld('kategori', 'Kategori', 'select', '', ['options_from' => 'prestasi_kategori']),
                fld('peringkat', 'Peringkat (boleh pakai emoji)', 'text', '', ['help' => 'Contoh: 🥇 Juara 1']),
                fld('gaya_peringkat', 'Warna label peringkat', 'select', '', ['options' => $rankStyles]),
                fld('meta', 'Tingkat & waktu', 'text', '', ['help' => 'Contoh: Kabupaten Sidoarjo · Feb 2025']),
                fld('deskripsi', 'Deskripsi', 'rich', '', ['multiline' => true]),
                fld('tags', 'Tag (pisahkan dengan koma)', 'text', '', ['help' => 'Contoh: DKV, Animasi']),
                fld('foto', 'Foto utama', 'image'),
                fld('alt', 'Deskripsi foto (untuk aksesibilitas)', 'text'),
                fld('caption', 'Keterangan saat foto diperbesar', 'text'),
                fld('posisi', 'Fokus foto (opsional)', 'select', '', ['options' => ['' => 'Tengah', 'center 20%' => 'Atas', 'center 45%' => 'Tengah-atas', 'center 62%' => 'Tengah-bawah', 'center 85%' => 'Bawah']]),
                fld('foto2', 'Foto tambahan (opsional)', 'image'),
                fld('caption2', 'Keterangan foto tambahan', 'text'),
                fld('featured', 'Kartu besar (sorotan utama)', 'checkbox'),
                fld('beranda', 'Tampilkan di Beranda (maks. 3)', 'checkbox'),
                fld('beranda_label', 'Beranda: label kecil', 'text', '', ['help' => 'Contoh: LKS Kabupaten 2025']),
                fld('beranda_judul', 'Beranda: judul singkat', 'text'),
                fld('beranda_sub', 'Beranda: keterangan', 'text'),
            ],
        ],
        'potret_juara' => [
            'title' => 'Potret Wajah Juara', 'singular' => 'potret', 'group' => 'galeri',
            'columns' => ['caption'], 'thumb' => 'foto',
            'fields' => [
                fld('foto', 'Foto', 'image', '', ['required' => true]),
                fld('caption', 'Keterangan', 'text'),
                fld('alt', 'Deskripsi foto (aksesibilitas)', 'text'),
            ],
        ],
        'dokumentasi_kategori' => [
            'title' => 'Kategori Dokumentasi', 'singular' => 'kategori', 'group' => 'galeri',
            'columns' => ['label', 'slug'],
            'fields' => [
                fld('label', 'Nama kategori', 'text', '', ['required' => true]),
                fld('slug', 'Kode (huruf kecil tanpa spasi)', 'text', '', ['required' => true, 'help' => 'Contoh: ekskul']),
            ],
        ],
        'dokumentasi' => [
            'title' => 'Dokumentasi Kegiatan', 'singular' => 'foto dokumentasi', 'group' => 'galeri',
            'columns' => ['judul', 'label'], 'thumb' => 'foto',
            'fields' => [
                fld('foto', 'Foto', 'image', '', ['required' => true]),
                fld('kategori', 'Kategori', 'select', '', ['options_from' => 'dokumentasi_kategori']),
                fld('label', 'Label kecil', 'text', '', ['help' => 'Contoh: Kunjungan Industri']),
                fld('judul', 'Judul', 'text', '', ['required' => true]),
                fld('caption', 'Keterangan saat diperbesar', 'text'),
                fld('alt', 'Deskripsi foto (aksesibilitas)', 'text'),
            ],
        ],
        'album' => [
            'title' => 'Album Google Drive', 'singular' => 'album', 'group' => 'galeri',
            'columns' => ['judul', 'keterangan'],
            'fields' => [
                fld('ikon', 'Ikon emoji', 'text', '📁', ['help' => 'Salin-tempel satu emoji, contoh: 🎓']),
                fld('judul', 'Nama album', 'text', '', ['required' => true]),
                fld('keterangan', 'Keterangan', 'text'),
                fld('url', 'Link Google Drive', 'url', '', ['required' => true]),
            ],
        ],
    ];

    return $schema;
}

function collection_def(string $name): ?array
{
    return collections_schema()[$name] ?? null;
}

/** Opsi select dinamis dari koleksi kategori: [slug => label]. */
function collection_options(string $collection): array
{
    $opts = ['' => '— Pilih —'];
    foreach (items($collection, false) as $row) {
        if (!empty($row['slug'])) {
            $opts[$row['slug']] = $row['label'] ?? $row['slug'];
        }
    }
    return $opts;
}

