<?php
/**
 * Data awal koleksi (diambil dari konten website statis sebelumnya).
 * Dipakai oleh install.php saat database masih kosong.
 */
declare(strict_types=1);

function seed_data(): array
{
    return [
        'stats' => [
            ['value' => '2010', 'label' => 'Tahun berdiri · Yayasan Al Badriyah Al Mustofa'],
            ['value' => '69852106', 'label' => 'NPSN Sekolah Resmi'],
            ['value' => '14+ Fasilitas', 'label' => 'Gedung 3 Lantai · Lab AC · Wi-Fi 120 Mbps'],
            ['value' => '15 Ekskul & Komunitas', 'label' => 'Robotika, Futsal, Silat, Game 3D, Dll', 'accent' => '1'],
        ],

        'program' => [
            [
                'nama' => 'Desain Komunikasi Visual', 'singkatan' => 'DKV', 'slug' => 'dkv', 'kode' => '01 / KREATIF DIGITAL',
                'gaya' => 'dkv', 'icon' => 'pen', 'simbol' => '✳',
                'tagline' => '“Kreatif Berkarya, Siap Menghadapi Industri Global”',
                'ringkasan' => 'Kreatif berkarya di bidang desain grafis, ilustrasi, foto, video, animasi, UI/UX, serta peluang magang dan karier ke Jepang.',
                'deskripsi' => 'Program keahlian yang membekali peserta didik dengan kemampuan menciptakan karya visual untuk kebutuhan komunikasi, promosi, branding, media digital, dan industri kreatif modern.',
                'kompetensi' => "Desain grafis & ilustrasi\nFotografi & videografi\nAnimasi & motion graphics\nDesain UI/UX\nBranding & desain kemasan\nPenguasaan software desain",
                'peluang' => "Desainer Grafis\nIllustrator\nContent Creator\nVideographer\nEditor Video\nAnimator\nUI/UX Designer\nPhotographer\nSocial Media Designer\nWirausaha Kreatif",
                'highlight_judul' => 'Peluang Magang & Karier ke Jepang',
                'highlight_teks' => 'Lulusan DKV berpeluang mengikuti program magang dan bekerja di industri kreatif luar negeri, termasuk peluang kerja sama penyaluran tenaga kerja ke Jepang sesuai kualifikasi dan persyaratan.',
            ],
            [
                'nama' => 'Teknik Kendaraan Ringan', 'singkatan' => 'TKR', 'slug' => 'tkr', 'kode' => '02 / TEKNOLOGI OTOMOTIF',
                'gaya' => 'tkr', 'icon' => 'wrench', 'simbol' => '⌁',
                'tagline' => '“Terampil Menguasai Teknologi Otomotif, Siap Kerja dan Berkarier Global”',
                'ringkasan' => 'Kuasai perawatan mesin, kelistrikan, diagnosis kendaraan ringan, dan raih peluang karier hingga perusahaan otomotif Jepang.',
                'deskripsi' => 'Program keahlian yang membekali peserta didik dengan keterampilan dalam perawatan, perbaikan, diagnosis, dan pemeliharaan kendaraan ringan serta teknologi otomotif modern.',
                'kompetensi' => "Perawatan mesin kendaraan\nSistem kelistrikan otomotif\nPemindah tenaga, chassis & rem\nSistem kemudi & AC kendaraan\nDiagnosis kerusakan & alat ukur\nPenerapan K3 dan budaya industri",
                'peluang' => "Teknisi / Mekanik Otomotif\nService Advisor\nTeknisi Bengkel Resmi\nTeknisi Kendaraan Ringan\nWirausaha Bengkel Otomotif",
                'highlight_judul' => 'Peluang Magang & Karier di Perusahaan Otomotif Jepang',
                'highlight_teks' => 'Lulusan TKR memiliki akses peluang magang ke Jepang dan mengembangkan karier hingga bekerja di perusahaan otomotif Jepang melalui program kemitraan dan seleksi yang tersedia.',
            ],
        ],

        'fakta' => [
            ['label' => 'Status', 'nilai' => 'Telah TERAKREDITASI'],
            ['label' => 'NPSN Resmi', 'nilai' => '69852106'],
            ['label' => 'Nama Resmi', 'nilai' => 'SMK Islam Tarbiyatul Badriyah'],
            ['label' => 'Naungan', 'nilai' => 'Yayasan Al Badriyah Al Mustofa'],
            ['label' => 'Pendiri', 'nilai' => 'KH. Badrul Munir, M.Pd.I. (Alm.)'],
            ['label' => 'Pimpinan Yayasan', 'nilai' => 'Gus Anwaruddin'],
            ['label' => 'Lokasi', 'nilai' => 'Tebel · Gedangan · Sidoarjo'],
        ],

        'rutinitas' => [
            ['waktu' => 'Pagi Hari', 'judul' => 'Sholat Dhuha Berjamaah', 'deskripsi' => 'Membangun kedisiplinan spiritual dan menanamkan kebiasaan mendekatkan diri kepada Allah SWT sebelum memulai seluruh aktivitas belajar.'],
            ['waktu' => 'Pagi Hari', 'judul' => 'Yasin & Tahlil Bersama', 'deskripsi' => "Melestarikan tradisi keagamaan Ahlussunnah wal Jama'ah untuk memupuk kebersamaan, ketenangan jiwa, serta mendoakan kebaikan bagi sesama."],
            ['waktu' => 'Pukul 08.10 WIB', 'judul' => 'Mengaji & Masuk Kelas', 'deskripsi' => "Tadarus Al-Qur'an dilanjutkan pembelajaran mata pelajaran umum serta praktik produktif kejuruan di bengkel dan lab komputer."],
        ],

        'nilai' => [
            ['judul' => 'Kompetensi', 'icon' => 'medal', 'deskripsi' => 'Belajar melalui teori mendalam dan praktik nyata sesuai standar kebutuhan industri kerja.'],
            ['judul' => 'Karakter', 'icon' => 'shield-check', 'deskripsi' => 'Disiplin, tanggung jawab, kepedulian sosial, dan pembinaan akhlak berlandaskan nilai keislaman.'],
            ['judul' => 'Masa Depan', 'icon' => 'compass', 'deskripsi' => 'Siap bekerja di industri, siap berwirausaha mandiri, serta mampu bersaing hingga kancah internasional.'],
        ],

        'fasilitas' => [
            ['nama' => 'Guru Berkualitas', 'keterangan' => 'Kualifikasi S1 s.d S3 sesuai keahlian', 'icon' => 'graduation'],
            ['nama' => 'Lab. Komputer Full AC', 'keterangan' => 'Praktik digital & software modern', 'icon' => 'monitor'],
            ['nama' => 'Lab. Multimedia Full AC', 'keterangan' => 'Editing video, foto, & animasi DKV', 'icon' => 'video'],
            ['nama' => 'Perpustakaan Sekolah', 'keterangan' => 'Koleksi buku kejuruan & referensi', 'icon' => 'book'],
            ['nama' => 'Gedung Representative', 'keterangan' => 'Bangunan 3 lantai yang representatif', 'icon' => 'building'],
            ['nama' => 'Free Wi-Fi 24 Jam', 'keterangan' => 'Internet berkecepatan Up to 120 Mbps', 'icon' => 'wifi'],
            ['nama' => 'Kemitraan DUDI', 'keterangan' => 'Kerja sama dunia usaha & industri', 'icon' => 'users'],
            ['nama' => 'Ruang Kelas Full AC', 'keterangan' => 'Suasana belajar sejuk & kondusif', 'icon' => 'snow'],
            ['nama' => 'Lapangan Olahraga', 'keterangan' => 'Fasilitas futsal, bulu tangkis, dll', 'icon' => 'ball'],
            ['nama' => 'Koperasi Siswa', 'keterangan' => 'Layanan kebutuhan & perlengkapan', 'icon' => 'cart'],
            ['nama' => 'Asrama Ponpes & Musholla', 'keterangan' => 'Sarana ibadah & pondok pesantren', 'icon' => 'mosque'],
            ['nama' => 'Unit Produksi & Jasa', 'keterangan' => 'Wadah wirausaha karya kejuruan siswa', 'icon' => 'box'],
            ['nama' => 'Bengkel Otomotif', 'keterangan' => 'Praktik mesin, kelistrikan & servis TKR', 'icon' => 'wrench'],
            ['nama' => 'Rumah Produksi Kreatif', 'keterangan' => 'Studio karya & project riil DKV', 'icon' => 'brush'],
        ],

        'ekskul' => [
            ['judul' => 'Teknologi & Kreatif Digital', 'subjudul' => 'Eksplorasi software, robotik & multimedia', 'icon' => 'terminal', 'aksen' => '1',
             'daftar' => "Robotika & Virtual Metavers | Tech\nAnimasi Game 2D/3D | Game Dev\nVideo & Fotografi | Media\nDesain Grafis | Creative\nTEAM DIGITABA | Komunitas"],
            ['judul' => 'Olahraga & Bela Diri', 'subjudul' => 'Kesehatan fisik, sportivitas & seni silat', 'icon' => 'ball', 'aksen' => '1',
             'daftar' => "Futsal | Olahraga\nBulu Tangkis | Olahraga\nPencak Silat Pagar Nusa | Bela Diri Tradisi"],
            ['judul' => 'Kepemimpinan, Seni & Bahasa', 'subjudul' => 'Membentuk karakter, wawasan & kepercayaan diri', 'icon' => 'star',
             'daftar' => "Pramuka | Wajib / Karakter\nTeater | Seni Peran\nDEKADE TEAM | Komunitas Kreasi\nEnglish Conversation | Bahasa Global"],
            ['judul' => 'Sosial, Alam & Keahlian', 'subjudul' => 'Kepedulian sosial, lingkungan hidup & skill nyata', 'icon' => 'shield',
             'daftar' => "Pencinta Alam SMK ITABA (SEMKIPALA) | Petualang Alam\nPeduli Lingkungan Masyarakat | Aksi Sosial\nMengemudi | Life Skill Praktis"],
        ],

        'guru' => [
            ['nama' => 'Umi Hanik, M.Pd', 'jabatan' => 'Waka Kurikulum', 'foto' => 'assets/img/umi-hanik.webp', 'featured' => '1',
             'pesan' => '“Berkomitmen menghadirkan proses pembelajaran yang terarah, adaptif, dan relevan dengan kebutuhan dunia kerja serta mengintegrasikan pendidikan karakter dan nilai keislaman.”'],
            ['nama' => 'Muis Lidinillah, S.Pd', 'jabatan' => 'Waka Kesiswaan & Ketua PPDB', 'foto' => 'assets/img/muis-lidinillah.webp',
             'pesan' => '“Mendampingi potensi siswa dalam kedisiplinan, kepemimpinan, dan tanggung jawab agar tumbuh menjadi pribadi yang berakhlak mulia dan berprestasi.”'],
            ['nama' => 'Nurul Abshori, M.Pd', 'jabatan' => 'Wakil Hubinmas', 'foto' => 'assets/img/nurul-abshori.webp',
             'pesan' => '“Membangun sinergi kuat dengan dunia industri untuk memperluas peluang PKL, magang, sertifikasi, hingga karier internasional bagi para lulusan.”'],
            ['nama' => 'Bambang Purwanto, M.Pd', 'jabatan' => 'Waka Sarana & Prasarana', 'foto' => 'assets/img/bambang-purwanto.webp',
             'pesan' => '“Menyediakan fasilitas dan sarana belajar yang nyaman, aman, serta sesuai standar kebutuhan industri modern untuk menunjang praktik siswa.”'],
            ['nama' => 'Arifin, S.Ds', 'jabatan' => 'Kepala Program DKV', 'foto' => 'assets/img/arifin.webp',
             'pesan' => '“Mengembangkan kreativitas visual berbasis proyek nyata untuk mencetak insan kreatif digital yang inovatif dan siap bersaing di industri global.”'],
            ['nama' => 'Kunto Wibisono, S.T.', 'jabatan' => 'Kepala Program TKR', 'foto' => 'assets/img/kunto-wibisono.webp',
             'pesan' => '“Membekali keterampilan teknis otomotif, K3, dan etos kerja profesional serta membuka peluang karier hingga perusahaan otomotif Jepang.”'],
            ['nama' => 'Zahrotul Ilmi, S.Kom.', 'jabatan' => 'Operator Sekolah (Dapodik)', 'foto' => 'assets/img/zahrotul-ilmi.webp',
             'pesan' => '“Mendukung pengelolaan data dan sistem informasi sekolah secara tertib, akurat, dan transparan demi menunjang kualitas layanan pendidikan.”'],
            ['nama' => 'M. Rois, S.Pd', 'jabatan' => 'Kepala Tata Usaha', 'foto' => 'assets/img/m-rois.webp',
             'pesan' => '“Menjalankan layanan administrasi dan tata kelola sekolah yang profesional, tertib, dan responsif bagi seluruh keluarga besar SMK ITABA.”'],
        ],

        'spmb_gelombang' => [
            ['label' => 'Gelombang Istimewa', 'tanggal' => '01 Nov — 30 Des 2026', 'keterangan' => 'Periode pendaftaran awal', 'featured' => '1'],
            ['label' => 'Gelombang 1', 'tanggal' => '01 Jan — 30 Mar 2027', 'keterangan' => 'Periode pendaftaran reguler 1'],
            ['label' => 'Gelombang 2', 'tanggal' => '01 Apr — 10 Jul 2027', 'keterangan' => 'Periode pendaftaran reguler 2'],
        ],

        'spmb_biaya' => [
            ['item' => 'Formulir pendaftaran', 'nominal' => 'Rp100.000'],
            ['item' => 'Gelombang Istimewa', 'nominal' => 'Rp2.400.000'],
            ['item' => 'Gelombang 1', 'nominal' => 'Rp2.800.000'],
            ['item' => 'Gelombang 2', 'nominal' => 'Rp3.200.000'],
        ],

        'spmb_syarat' => [
            ['teks' => 'Fotokopi ijazah SD/MI — 2 lembar'],
            ['teks' => 'Fotokopi ijazah / SKHU / SKL dari SMP/MTs asal — 2 lembar'],
            ['teks' => 'Fotokopi Kartu Keluarga (KK) — 2 lembar'],
            ['teks' => 'Fotokopi Akta Kelahiran — 2 lembar'],
            ['teks' => 'Fotokopi KTP orang tua (Ayah dan Ibu) — 2 lembar'],
            ['teks' => 'Pas foto hitam putih 3×4 (seragam SMP/MTs asal) — 4 lembar'],
            ['teks' => 'Fotokopi kartu KIP / PIP / KPS / PKH — 2 lembar (jika ada)'],
        ],

        'prestasi_kategori' => [
            ['label' => 'Kompetensi & Kreatif', 'slug' => 'kejuruan'],
            ['label' => 'Pencak Silat', 'slug' => 'olahraga'],
            ['label' => 'Baris-berbaris & Kepemudaan', 'slug' => 'kepemudaan'],
        ],

        'prestasi_stats' => [
            ['value' => '9', 'label' => 'Catatan prestasi terdokumentasi'],
            ['value' => '2022–2025', 'label' => 'Rentang tahun kejuaraan'],
            ['value' => '3', 'label' => 'Bidang: kejuruan, olahraga, kepemudaan'],
            ['value' => 'Juara 1', 'label' => 'LKS Kabupaten Sidoarjo & Kapolresta Cup', 'accent' => '1'],
        ],

        'prestasi' => [
            [
                'judul' => 'Lomba Kompetensi Siswa (LKS) Dikmen Kabupaten Sidoarjo 2025', 'kategori' => 'kejuruan',
                'peringkat' => '🏆 Juara 2 & 3', 'gaya_peringkat' => '', 'meta' => 'Kabupaten Sidoarjo · Feb 2025',
                'deskripsi' => 'Dua siswa SMK ITABA sekaligus naik podium pada LKS Dikmen 18–21 Februari 2025: <strong>Juara 2 bidang Automobile Technology</strong> dan <strong>Juara 3 bidang Teknik Perancangan Model 3D (3D Game Art)</strong>. Bukti bahwa jurusan TKR dan DKV sama-sama bersaing di level kabupaten.',
                'tags' => 'TKR, DKV, LKS', 'foto' => 'assets/img/prestasi/lks-2025-1.webp',
                'alt' => 'Dua siswa SMK ITABA memegang piala Juara 2 dan Juara 3 LKS Dikmen Kabupaten Sidoarjo 2025',
                'caption' => 'Juara 2 Automobile Technology & Juara 3 Teknik Perancangan Model 3D (3D Game Art) — LKS Dikmen Kabupaten Sidoarjo, 18–21 Februari 2025',
                'foto2' => 'assets/img/prestasi/lks-2025-2.webp', 'caption2' => 'Foto bersama pembina dan juri LKS Dikmen Kabupaten Sidoarjo 2025',
                'featured' => '1', 'beranda' => '1', 'beranda_label' => 'LKS Kabupaten 2025',
                'beranda_judul' => 'Juara 2 Otomotif & Juara 3 3D Game Art', 'beranda_sub' => 'TKR & DKV · Tingkat Kabupaten Sidoarjo',
            ],
            [
                'judul' => 'LKS SMK Kabupaten Sidoarjo — Bidang Animasi', 'kategori' => 'kejuruan',
                'peringkat' => '🥇 Juara 1', 'gaya_peringkat' => 'gold', 'meta' => 'Kabupaten · 2024',
                'deskripsi' => 'Juara 1 Lomba Kompetensi Siswa tingkat SMK Kabupaten Sidoarjo (MKKS SMK Swasta) pada bidang animasi / teknik perancangan model 3D.',
                'tags' => 'DKV, Animasi', 'foto' => 'assets/img/prestasi/lks-animasi-2024-2.webp',
                'alt' => 'Siswa SMK ITABA memegang piala Juara 1 LKS bidang animasi bersama guru pembimbing',
                'caption' => 'Juara 1 LKS SMK Kabupaten Sidoarjo bidang Animasi (Teknik Perancangan Model 3D), 2024 — bersama guru pembimbing',
                'foto2' => 'assets/img/prestasi/lks-animasi-2024-1.webp', 'caption2' => 'Juara 1 LKS bidang Animasi 2024 — piala, piagam, dan sertifikat juara',
                'beranda' => '1', 'beranda_label' => 'LKS Kabupaten 2024', 'beranda_judul' => 'Juara 1 LKS SMK Bidang Animasi', 'beranda_sub' => 'DKV · Perancangan Model 3D',
            ],
            [
                'judul' => 'Visualisation Festival 2023', 'kategori' => 'kejuruan',
                'peringkat' => '🥇 Juara 1 & 2', 'gaya_peringkat' => 'gold', 'meta' => 'Malang · 2023',
                'deskripsi' => 'Tim kreatif SMK ITABA membawa pulang piagam Juara 1 dan Juara 2 sekaligus dalam ajang Visualisation Festival 2023 di Malang.',
                'tags' => 'DKV, Festival Kreatif', 'foto' => 'assets/img/prestasi/visualisation-fest-2023.webp',
                'alt' => 'Empat siswa SMK ITABA membawa piala dan piagam Visualisation Festival 2023',
                'caption' => 'Juara 1 & Juara 2 Visualisation Festival 2023, Malang',
            ],
            [
                'judul' => 'Pencak Silat Kapolresta Sidoarjo Cup 2022', 'kategori' => 'olahraga',
                'peringkat' => '🥇 Juara 1', 'gaya_peringkat' => 'gold', 'meta' => 'Kabupaten · Agt 2022',
                'deskripsi' => 'Berdiri di podium tertinggi kejuaraan pencak silat pelajar se-Kabupaten Sidoarjo di GOR Sidoarjo, Agustus 2022.',
                'tags' => 'Pencak Silat, Pelajar', 'foto' => 'assets/img/prestasi/silat-kapolresta-2022.webp',
                'alt' => 'Pesilat putri SMK ITABA berdiri di podium juara 1 Kapolresta Sidoarjo Cup 2022',
                'caption' => 'Juara 1 Pencak Silat Pelajar se-Kabupaten Sidoarjo — Kapolresta Sidoarjo Cup 2022, GOR Sidoarjo',
                'posisi' => 'center 20%',
                'beranda' => '1', 'beranda_label' => 'Kapolresta Cup Sidoarjo', 'beranda_judul' => 'Juara 1 Pencak Silat Pelajar', 'beranda_sub' => 'Prestasi bela diri tingkat kabupaten',
            ],
            [
                'judul' => 'Kejurcab Pagar Nusa Sidoarjo 2023', 'kategori' => 'olahraga',
                'peringkat' => '🥇 Emas & 🥉 Perunggu', 'gaya_peringkat' => 'gold', 'meta' => 'Kabupaten · 2023',
                'deskripsi' => 'Pesilat SMK ITABA meraih medali emas dan perunggu pada Kejuaraan Cabang Pencak Silat NU Pagar Nusa Sidoarjo, rangkaian peringatan Hari Santri 2023.',
                'tags' => 'Pagar Nusa, Hari Santri', 'foto' => 'assets/img/prestasi/silat-kejurcab-2023.webp',
                'alt' => 'Dua pesilat SMK ITABA menunjukkan medali emas dan perunggu Kejurcab Pagar Nusa Sidoarjo 2023',
                'caption' => 'Medali emas & perunggu — Kejurcab Pencak Silat NU Pagar Nusa Sidoarjo 2023',
                'posisi' => 'center 45%',
            ],
            [
                'judul' => 'Kejurcab IX Pagar Nusa Sidoarjo 2025 — Putri', 'kategori' => 'olahraga',
                'peringkat' => '🏅 Podium Juara', 'gaya_peringkat' => '', 'meta' => 'Kabupaten · Okt 2025',
                'deskripsi' => 'Kontingen putri RY-ITABA naik podium pada Kejurcab IX Pagar Nusa Sidoarjo, 10–12 Oktober 2025 di GOR Sidoarjo.',
                'tags' => 'Pagar Nusa, Putri', 'foto' => 'assets/img/prestasi/silat-putri-2025.webp',
                'alt' => 'Tiga pesilat putri kontingen RY-ITABA di podium Kejurcab IX Pagar Nusa Sidoarjo 2025',
                'caption' => 'Kontingen putri RY-ITABA di podium Kejurcab IX Pagar Nusa Sidoarjo, 10–12 Oktober 2025',
                'posisi' => 'center 62%',
            ],
            [
                'judul' => 'Aksi Gemilang bersama Dewan Pemuda', 'kategori' => 'kepemudaan',
                'peringkat' => '🥈 Juara 2', 'gaya_peringkat' => 'silver', 'meta' => '2025',
                'deskripsi' => 'Lewat gerakan <em>“Sedekah Sampah Menjadi Berkah”</em>, siswa SMK ITABA meraih Juara 2 — aksi sosial-lingkungan yang menjaga bumi sekaligus membantu sesama.',
                'tags' => 'Lingkungan, Kepemudaan', 'foto' => 'assets/img/prestasi/aksi-gemilang-2025.webp',
                'alt' => 'Siswa dan guru SMK ITABA di depan banner Sedekah Sampah Menjadi Berkah',
                'caption' => 'Juara 2 Aksi Gemilang bersama Dewan Pemuda — gerakan “Sedekah Sampah Menjadi Berkah”, 2025',
            ],
            [
                'judul' => 'Lomba Gerak Jalan Pelajar', 'kategori' => 'kepemudaan',
                'peringkat' => '🥉 Juara 3', 'gaya_peringkat' => 'bronze', 'meta' => 'Kec. Gedangan · 2023',
                'deskripsi' => 'Tim SMK ITABA meraih Juara 3 Lomba Gerak Jalan Pelajar tingkat Kecamatan Gedangan — buah latihan kekompakan dan disiplin barisan.',
                'tags' => 'Gerak Jalan, HUT RI', 'foto' => 'assets/img/prestasi/gerak-jalan-2023.webp',
                'alt' => 'Siswa SMK ITABA bersama perwakilan kecamatan memegang piala Juara 3 lomba gerak jalan',
                'caption' => 'Juara 3 Lomba Gerak Jalan Pelajar tingkat Kecamatan Gedangan, 2023',
            ],
            [
                'judul' => 'Lomba Peraturan Baris-Berbaris (PBB)', 'kategori' => 'kepemudaan',
                'peringkat' => '🏆 Juara', 'gaya_peringkat' => '', 'meta' => '2023',
                'deskripsi' => 'Pasukan PBB putri SMK ITABA merayakan piala dan piagam kejuaraan baris-berbaris bersama para guru pembina.',
                'tags' => 'PBB, Putri', 'foto' => 'assets/img/prestasi/pbb-2023.webp',
                'alt' => 'Pasukan PBB putri SMK ITABA berfoto bersama piala dan piagam',
                'caption' => 'Juara Lomba Peraturan Baris-Berbaris (PBB) — pasukan putri SMK ITABA, 2023',
            ],
        ],

        'potret_juara' => [
            ['foto' => 'assets/img/prestasi/juara-studio-1.webp', 'caption' => 'Siswa DKV, pramuka, dan TKR bersama piala kejuaraan', 'alt' => 'Tiga siswa SMK ITABA memegang piala bersama'],
            ['foto' => 'assets/img/prestasi/juara-studio-2.webp', 'caption' => 'Siswa pramuka SMK ITABA dengan piala kejuaraan', 'alt' => 'Siswa berseragam pramuka memegang piala'],
            ['foto' => 'assets/img/prestasi/juara-studio-3.webp', 'caption' => 'Siswi DKV SMK ITABA dengan piala kejuaraan', 'alt' => 'Siswi berseragam DKV memegang piala'],
            ['foto' => 'assets/img/prestasi/juara-studio-4.webp', 'caption' => 'Siswa TKR SMK ITABA dengan piala kejuaraan', 'alt' => 'Siswa berseragam TKR memegang piala'],
            ['foto' => 'assets/img/prestasi/juara-studio-5.webp', 'caption' => 'Siswi pramuka SMK ITABA dengan piala kejuaraan', 'alt' => 'Siswi berseragam pramuka memegang piala'],
            ['foto' => 'assets/img/prestasi/juara-studio-6.webp', 'caption' => 'Siswa SMK ITABA berseragam batik sekolah dengan piala kejuaraan', 'alt' => 'Siswa berseragam batik sekolah memegang piala'],
        ],

        'dokumentasi_kategori' => [
            ['label' => 'Hari Santri & Keagamaan', 'slug' => 'santri'],
            ['label' => 'Kunjungan Industri & Karier', 'slug' => 'industri'],
            ['label' => 'Ekskul & Organisasi', 'slug' => 'ekskul'],
            ['label' => 'Karya DKV & TKR', 'slug' => 'kejuruan'],
        ],

        'dokumentasi' => [
            ['foto' => 'assets/img/dokumentasi/hsn-2024-bersama.webp', 'kategori' => 'santri', 'label' => 'Hari Santri', 'judul' => 'Upacara HSN 2024', 'caption' => 'Foto bersama guru dan siswa pada upacara Hari Santri Nasional, 22 Oktober 2024', 'alt' => 'Guru dan siswa SMK ITABA berfoto bersama pada upacara Hari Santri Nasional 2024'],
            ['foto' => 'assets/img/dokumentasi/ki-ub-studio.webp', 'kategori' => 'industri', 'label' => 'Kunjungan Industri', 'judul' => 'Studio UB Medcom', 'caption' => 'Siswa mencoba peran presenter di Studio UB Medcom saat kunjungan industri', 'alt' => 'Siswa SMK ITABA berpose di panggung Studio UB Medcom'],
            ['foto' => 'assets/img/dokumentasi/metaverse.webp', 'kategori' => 'kejuruan', 'label' => 'Karya DKV', 'judul' => 'Virtual Metaverse', 'caption' => 'Eksplorasi virtual reality dan metaverse oleh siswa DKV', 'alt' => 'Siswa DKV memakai headset VR dalam visual dunia metaverse'],
            ['foto' => 'assets/img/dokumentasi/paskibra-1.webp', 'kategori' => 'ekskul', 'label' => 'Ekskul', 'judul' => 'Paskibra HUT RI ke-79', 'caption' => 'Anggota Paskibra SMK ITABA ceria usai bertugas pada upacara HUT RI ke-79', 'alt' => 'Anggota paskibra SMK ITABA berseragam putih berpose ceria'],
            ['foto' => 'assets/img/dokumentasi/ziarah-muassis-2.webp', 'kategori' => 'santri', 'label' => 'Keagamaan', 'judul' => 'Ziarah Muassis', 'caption' => 'Tabur bunga pada ziarah makam muassis (pendiri) SMK ITABA', 'alt' => 'Guru menabur bunga saat ziarah makam muassis disaksikan para siswi'],
            ['foto' => 'assets/img/dokumentasi/ki-ub-tv.webp', 'kategori' => 'industri', 'label' => 'Kunjungan Industri', 'judul' => 'Universitas Brawijaya TV', 'caption' => 'Kunjungan industri siswa SMK ITABA ke Universitas Brawijaya Televisi (UB TV)', 'alt' => 'Rombongan siswa SMK ITABA dengan banner kunjungan industri Universitas Brawijaya Televisi'],
            ['foto' => 'assets/img/dokumentasi/siswa-dkv.webp', 'kategori' => 'kejuruan', 'label' => 'Jurusan DKV', 'judul' => 'Siap Produksi Konten', 'caption' => 'Kamera, drone, dan laptop — perlengkapan harian siswa Desain Komunikasi Visual', 'alt' => 'Siswa DKV dengan kamera video, drone, dan laptop'],
            ['foto' => 'assets/img/dokumentasi/pramuka-1.webp', 'kategori' => 'ekskul', 'label' => 'Ekskul', 'judul' => 'Pramuka', 'caption' => 'Penyematan tanda dalam kegiatan ekstrakurikuler Pramuka', 'alt' => 'Pembina pramuka menyematkan tanda kepada anggota'],
            ['foto' => 'assets/img/dokumentasi/pawai-hsn.webp', 'kategori' => 'santri', 'label' => 'Hari Santri', 'judul' => 'Pawai HSN', 'caption' => 'Siswa putra berbusana santri — jas, peci, dan sarung — siap mengikuti pawai Hari Santri', 'alt' => 'Siswa putra berjas, berpeci, dan bersarung berfoto bersama'],
            ['foto' => 'assets/img/dokumentasi/ki-bbppmpv.webp', 'kategori' => 'industri', 'label' => 'Kunjungan Industri', 'judul' => 'BBPPMPV BOE Malang', 'caption' => 'Kunjungan industri siswa TKR ke BBPPMPV BOE Malang, 30 Oktober 2024', 'alt' => 'Rombongan siswa TKR dengan banner kunjungan industri BBPPMPV BOE'],
            ['foto' => 'assets/img/dokumentasi/team-dekade.webp', 'kategori' => 'ekskul', 'label' => 'Komunitas', 'judul' => 'Dekade Production', 'caption' => 'Dekade Production — tim produksi video siswa saat syuting di lapangan', 'alt' => 'Siswa memegang kamera dengan gimbal saat syuting di jalan'],
            ['foto' => 'assets/img/dokumentasi/game-3d-art.webp', 'kategori' => 'kejuruan', 'label' => 'Ekskul Game', 'judul' => 'Game 3D Art', 'caption' => 'Siswa merancang aset game 3D di laboratorium komputer', 'alt' => 'Siswa bekerja di depan monitor yang menampilkan model 3D'],
            ['foto' => 'assets/img/dokumentasi/ki-wawancara.webp', 'kategori' => 'industri', 'label' => 'Liputan Siswa', 'judul' => 'Reporter DKV Beraksi', 'caption' => 'Siswa DKV mewawancarai rekan TKR saat kunjungan industri', 'alt' => 'Siswi DKV memegang mikrofon mewawancarai siswa TKR'],
            ['foto' => 'assets/img/dokumentasi/hsn-2024-amanat.webp', 'kategori' => 'santri', 'label' => 'Hari Santri', 'judul' => 'Amanat Upacara', 'caption' => 'Pembina menyampaikan amanat upacara Hari Santri Nasional 2024 di halaman sekolah', 'alt' => 'Pembina upacara berpidato di depan banner Hari Santri Nasional 2024'],
            ['foto' => 'assets/img/dokumentasi/siswa-tkr.webp', 'kategori' => 'kejuruan', 'label' => 'Jurusan TKR', 'judul' => 'Teknisi Muda', 'caption' => 'Siswa Teknik Kendaraan Ringan dengan perkakas presisi bengkel', 'alt' => 'Dua siswa TKR berseragam hijau memegang perkakas bengkel'],
            ['foto' => 'assets/img/dokumentasi/team-digitaba.webp', 'kategori' => 'ekskul', 'label' => 'Media Sekolah', 'judul' => 'Team DIGITABA', 'caption' => 'Team DIGITABA — tim media sekolah mendokumentasikan kegiatan siswa', 'alt' => 'Anggota Team DIGITABA memotret dengan kamera'],
            ['foto' => 'assets/img/dokumentasi/job-fair-2024.webp', 'kategori' => 'industri', 'label' => 'BKK', 'judul' => 'Job Fair 2024', 'caption' => 'Job Fair & Open Recruitment 2024 — penyaluran tenaga kerja melalui BKK SMK ITABA', 'alt' => 'Peserta duduk di aula menghadiri Job Fair 2024'],
            ['foto' => 'assets/img/dokumentasi/ziarah-muassis-1.webp', 'kategori' => 'santri', 'label' => 'Keagamaan', 'judul' => 'Doa Bersama', 'caption' => 'Doa bersama siswa dan guru pada ziarah makam muassis SMK ITABA', 'alt' => 'Siswa duduk berdoa bersama di area makam muassis'],
            ['foto' => 'assets/img/dokumentasi/paskibra-2.webp', 'kategori' => 'ekskul', 'label' => 'Ekskul', 'judul' => 'Paskibra & Tamu Upacara', 'caption' => 'Paskibra SMK ITABA bersama tamu undangan upacara HUT RI ke-79', 'alt' => 'Anggota paskibra berfoto bersama tamu undangan di pendopo'],
            ['foto' => 'assets/img/dokumentasi/ki-ub-plakat.webp', 'kategori' => 'industri', 'label' => 'Kunjungan Industri', 'judul' => 'Penyerahan Cinderamata', 'caption' => 'Penyerahan plakat cinderamata SMK ITABA kepada pihak UB Medcom', 'alt' => 'Guru SMK ITABA menyerahkan plakat kepada perwakilan UB Medcom'],
            ['foto' => 'assets/img/dokumentasi/siswa-dkv-kamera.webp', 'kategori' => 'kejuruan', 'label' => 'Jurusan DKV', 'judul' => 'Foto & Videografi', 'caption' => 'Fotografer dan videografer muda jurusan DKV', 'alt' => 'Siswa dan siswi DKV membawa kamera video dan kamera foto'],
            ['foto' => 'assets/img/dokumentasi/pramuka-2.webp', 'kategori' => 'ekskul', 'label' => 'Ekskul', 'judul' => 'Pramuka Penegak', 'caption' => 'Anggota pramuka siaga dalam barisan kegiatan kepramukaan', 'alt' => 'Siswa berseragam pramuka berdiri tegap dalam barisan'],
            ['foto' => 'assets/img/dokumentasi/siswa-tkr-alat-ukur.webp', 'kategori' => 'kejuruan', 'label' => 'Jurusan TKR', 'judul' => 'Alat Ukur Presisi', 'caption' => 'Kunci torsi dan dial bore gauge — alat ukur presisi di bengkel TKR', 'alt' => 'Siswa TKR tersenyum memegang kunci torsi dan dial bore gauge'],
        ],

        'album' => [
            ['ikon' => '🎓', 'judul' => 'Wisuda 2026', 'keterangan' => 'Pelepasan siswa', 'url' => 'https://drive.google.com/drive/folders/1YTKlZ3eVD5gvigI-1y6kjne-lKgrdwKx?usp=drive_link'],
            ['ikon' => '🕌', 'judul' => 'Hari Santri 2026', 'keterangan' => 'Upacara & pawai', 'url' => 'https://drive.google.com/drive/folders/1iVdBFWfnIa1FL8fsk-48fT3zBl_Lcu-E?usp=sharing'],
            ['ikon' => '🌙', 'judul' => 'Maulid Nabi 2026', 'keterangan' => 'Peringatan keagamaan', 'url' => 'https://drive.google.com/drive/folders/1K3l0IRSCLyGh-JkfeEDZ8bJlq31I-NjU?usp=sharing'],
            ['ikon' => '🇮🇩', 'judul' => 'Merdeka Fest 2026', 'keterangan' => 'Perayaan HUT RI', 'url' => 'https://drive.google.com/drive/folders/1Z6QPMx8rBffaEl6ax3XLJz0G7jXRyy-k?usp=sharing'],
            ['ikon' => '🎒', 'judul' => 'MPLS 2026', 'keterangan' => 'Pengenalan lingkungan sekolah', 'url' => 'https://drive.google.com/drive/folders/1UDt6XKVfcgBJbhGMhUiQjfbcnzw26Af-?usp=sharing'],
            ['ikon' => '🏝️', 'judul' => 'Bali 2026', 'keterangan' => 'Study tour', 'url' => 'https://drive.google.com/drive/folders/17jEtOrDZ16qAU2GEHTi4qNc7T3ViUicF?usp=sharing'],
            ['ikon' => '🏭', 'judul' => 'Kunjungan Industri', 'keterangan' => 'DKV & TKR', 'url' => 'https://drive.google.com/drive/folders/1OCuvDuOlzkfSvTKNmPbABg0D9-93VbCd?usp=sharing'],
            ['ikon' => '💼', 'judul' => 'Pekan Karier', 'keterangan' => 'BKK & dunia kerja', 'url' => 'https://drive.google.com/drive/folders/1TQM8PGR_NaKzt9r4W6G7Mr9S0MNPlIPr?usp=sharing'],
            ['ikon' => '🛠️', 'judul' => 'Uji Kompetensi Keahlian', 'keterangan' => 'UKK siswa kelas XII', 'url' => 'https://drive.google.com/drive/folders/1oKzzP7Um9UNqN-_K0aY1GXZhfaWmPFw6?usp=sharing'],
            ['ikon' => '🎖️', 'judul' => 'Pelantikan OSIS', 'keterangan' => 'Organisasi siswa', 'url' => 'https://drive.google.com/drive/folders/19ROLZEZAMmxxFxNDtq6Q3_6TfjpztfHr?usp=sharing'],
            ['ikon' => '👩‍🏫', 'judul' => 'Hari Guru Nasional', 'keterangan' => 'Upacara peringatan', 'url' => 'https://drive.google.com/drive/folders/1FS2CRWdSmA-d5DdE2z0sbGPVf91pLwAf?usp=sharing'],
            ['ikon' => '📿', 'judul' => 'Pondok Ramadan', 'keterangan' => 'Kegiatan bulan suci', 'url' => 'https://drive.google.com/drive/folders/1Gjv2m0S1rRJlcAnX7R_e6Gi_FY6WjV20?usp=sharing'],
            ['ikon' => '🍲', 'judul' => 'Bagi Takjil', 'keterangan' => 'Berbagi di bulan Ramadan', 'url' => 'https://drive.google.com/drive/folders/1Y0w46qToIc_uGoZCy1xoGSn6h6e8HrQi?usp=sharing'],
            ['ikon' => '🐐', 'judul' => 'Idul Adha & Kurban', 'keterangan' => 'Penyembelihan hewan kurban', 'url' => 'https://drive.google.com/drive/folders/1vAs3WUHGLmqiL-I45euJ1eBlDjINWQOR?usp=sharing'],
            ['ikon' => '📝', 'judul' => 'Tes SPMB', 'keterangan' => 'Seleksi siswa baru', 'url' => 'https://drive.google.com/drive/folders/11DWmofg37bF58irgeOUtE2Qnht2672GS?usp=sharing'],
            ['ikon' => '📘', 'judul' => 'Pengambilan Rapor', 'keterangan' => 'Semester genap', 'url' => 'https://drive.google.com/drive/folders/1PiUkNwmu8ViF1C7NgdznB3_jgfxv1M7T?usp=sharing'],
            ['ikon' => '📗', 'judul' => 'Rapor Semester Ganjil', 'keterangan' => 'Pembagian rapor', 'url' => 'https://drive.google.com/drive/folders/180uayKM0RMLbdtUNqnqPslqqSjoabxL_?usp=sharing'],
            ['ikon' => '⚽', 'judul' => 'Ekskul Futsal', 'keterangan' => 'Latihan & pertandingan', 'url' => 'https://drive.google.com/drive/folders/1fA67slMeEqM1dLGf3ewHAqKhA00fAjtT?usp=drive_link'],
        ],
    ];
}

/** Isi koleksi yang masih kosong dengan data awal. Mengembalikan jumlah item yang ditambahkan. */
function seed_run(): int
{
    $count = 0;
    foreach (seed_data() as $collection => $rows) {
        if (items_count($collection) > 0) {
            continue;
        }
        foreach ($rows as $row) {
            item_create($collection, $row);
            $count++;
        }
    }
    return $count;
}

