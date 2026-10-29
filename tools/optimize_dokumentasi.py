"""Optimasi foto prestasi & dokumentasi kegiatan ke website/assets/img.

Sumber : website/KEBUTUHAN FILE WEB SEKOLAH_/
Output : website/assets/img/prestasi/*.webp
         website/assets/img/dokumentasi/*.webp
         website/assets/img/owi-juara.webp (maskot)

Jalankan dari folder website:  python tools/optimize_dokumentasi.py
"""
from pathlib import Path
from PIL import Image, ImageOps

Image.MAX_IMAGE_PIXELS = None

WEB = Path(__file__).resolve().parents[1]
SRC = WEB / "KEBUTUHAN FILE WEB SEKOLAH_"
PRESTASI_SRC = SRC / "D. Tambahan (jika ada)" / "PRESTASI SISWA"
FOTO = SRC / "C. Foto-dokumentasi (file asli)" / "C. Foto-dokumentasi (file asli)"
KEGIATAN = FOTO / "KEGIATAN SISWA DAN EKSLUL"
OWI = FOTO / "MASKOT SMK ITABA (OWI)"

OUT = WEB / "assets" / "img"
OUT_PRESTASI = OUT / "prestasi"
OUT_DOK = OUT / "dokumentasi"

# nama output -> file sumber
PRESTASI = {
    "lks-animasi-2024-1": "JUARA 1 LKS KAB BIDANG ANIMASI  (1).jpg",
    "lks-animasi-2024-2": "JUARA 1 LKS KAB BIDANG ANIMASI  (2).jpg",
    "lks-2025-1": "JUARA 2 DAN 3 LKS KABUPATEN (2).jpg",
    "lks-2025-2": "JUARA 2 DAN 3 LKS KABUPATEN (1).jpg",
    "aksi-gemilang-2025": "JUARA 2 AKSI GEMILANG DENGAN DEWAN PEMUDA (1).jpg",
    "visualisation-fest-2023": "JUARA LOMBA MALANG.jpg",
    "silat-kapolresta-2022": "JUARA 1 PENCAK SILAT.jpeg",
    "silat-kejurcab-2023": "JUARA PENCAK SILAT.jpg",
    "silat-putri-2025": "pencak silat putri.jpg",
    "gerak-jalan-2023": "JUARA GERAK JALAN.jpg",
    "pbb-2023": "JUARA PBB.jpg",
}

# Potret studio siswa berprestasi (PNG transparan)
JUARA_STUDIO = {
    "juara-studio-1": "PEO_9721.png",
    "juara-studio-2": "PEO_9702.png",
    "juara-studio-3": "PEO_9739.png",
    "juara-studio-4": "PEO_9728.png",
    "juara-studio-5": "PEO_9712.png",
    "juara-studio-6": "PEO_9753.png",
}

DOKUMENTASI = {
    "hsn-2024-bersama": "HSN (7).jpg",
    "hsn-2024-amanat": "HSN (4).jpg",
    "pawai-hsn": "PAWAI HSN (2).jpg",
    "ziarah-muassis-1": "ZIARAH MUASIS SMK ITABA (2).jpg",
    "ziarah-muassis-2": "ZIARAH MUASIS SMK ITABA (1).jpg",
    "ki-ub-tv": "KUNJUNGAN INDUSTRI (4).jpg",
    "ki-ub-studio": "KUNJUNGAN INDUSTRI (3).jpg",
    "ki-ub-plakat": "KUNJUNGAN INDUSTRI (2).jpg",
    "ki-bbppmpv": "KUNJUNGAN INDUSTRI (7).jpg",
    "ki-wawancara": "KUNJUNGAN INDUSTRI (6).jpg",
    "pramuka-1": "EKSKUL PRAMUKA (1).jpg",
    "pramuka-2": "EKSKUL PRAMUKA (2).jpg",
    "paskibra-1": "PASKIBRA SMK ITABA (2).jpg",
    "paskibra-2": "PASKIBRA SMK ITABA (1).jpg",
    "team-digitaba": "KEGIATAN SISWA TEAM DIGITABA.jpg",
    "team-dekade": "TEAM DEKADE PRODUCTION.png",
    "metaverse": "metaverse.png",
    "game-3d-art": "EKTA GAME 3D ART.png",
    "siswa-dkv": "PEO_9653.png",
    "siswa-tkr": "PEO_9643.png",
    "siswa-tkr-alat-ukur": "PEO_9614.png",
    "siswa-dkv-kamera": "PEO_9667.png",
    "job-fair-2024": "PENYALURAN TENAGA KERJA LEWAT BKK SMK ITABA (1).jpg",
}


def load(path: Path, bg=(255, 255, 255)) -> Image.Image:
    """Buka gambar, putar sesuai EXIF, potong area transparan, ratakan ke RGB."""
    im = ImageOps.exif_transpose(Image.open(path))
    if im.mode in ("RGBA", "LA", "P"):
        im = im.convert("RGBA")
        bbox = im.split()[-1].getbbox()
        if bbox:
            im = im.crop(bbox)
        base = Image.new("RGB", im.size, bg)
        base.paste(im, mask=im.split()[-1])
        return base
    return im.convert("RGB")


def save(im: Image.Image, dest: Path, max_side=1400, quality=78):
    im.thumbnail((max_side, max_side), Image.LANCZOS)
    dest.parent.mkdir(parents=True, exist_ok=True)
    im.save(dest, "WEBP", quality=quality, method=6)
    print(f"{dest.relative_to(OUT)!s:42s} {im.width}x{im.height}  {dest.stat().st_size // 1024:4d} KB")


def main():
    for name, fn in PRESTASI.items():
        save(load(PRESTASI_SRC / fn), OUT_PRESTASI / f"{name}.webp")

    for name, fn in JUARA_STUDIO.items():
        save(load(KEGIATAN / fn), OUT_PRESTASI / f"{name}.webp", max_side=900)

    for name, fn in DOKUMENTASI.items():
        save(load(KEGIATAN / fn), OUT_DOK / f"{name}.webp")

    # Maskot OWI memegang piala (tetap transparan)
    owi = ImageOps.exif_transpose(Image.open(OWI / "BIG OWI.png")).convert("RGBA")
    bbox = owi.split()[-1].getbbox()
    if bbox:
        owi = owi.crop(bbox)
    owi.thumbnail((560, 560), Image.LANCZOS)
    owi.save(OUT / "owi-juara.webp", "WEBP", quality=88, method=6)
    print(f"owi-juara.webp {owi.width}x{owi.height}")


if __name__ == "__main__":
    main()
