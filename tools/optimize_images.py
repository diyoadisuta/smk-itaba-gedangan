"""Optimasi aset gambar dari folder sumber ke website/assets/img.

Jalankan dari root project:  python3 website/tools/optimize_images.py
"""
from pathlib import Path
from PIL import Image, ImageOps

ROOT = Path(__file__).resolve().parents[2]
SRC = ROOT / "KEBUTUHAN FILE WEB SEKOLAH "
OUT = ROOT / "website" / "assets" / "img"
OUT.mkdir(parents=True, exist_ok=True)

GURU = SRC / "B. Kepala sekolah dan guru tertentu"
FOTO = SRC / "C. Foto-dokumentasi (file asli)"
DATA = SRC / "A. Data utama"

PORTRAITS = {
    "joko-siswanto": GURU / "pak jokooo.png",
    "umi-hanik": GURU / "Bu hanik.png",
    "muis-lidinillah": GURU / "p muis.jpg",
    "nurul-abshori": GURU / "PAK NURUL.jpg",
    "bambang-purwanto": GURU / "Pak Bambang.png",
    "arifin": GURU / "IPIN NEWW.png",
    "kunto-wibisono": GURU / "Pak Kunto.jpg",
    "zahrotul-ilmi": GURU / "Bu Ilmii.png",
    "m-rois": GURU / "M. ROIS",
}


def flatten(im: Image.Image, bg=(255, 255, 255)) -> Image.Image:
    im = ImageOps.exif_transpose(im)
    if im.mode in ("RGBA", "LA", "P"):
        im = im.convert("RGBA")
        base = Image.new("RGB", im.size, bg)
        base.paste(im, mask=im.split()[-1])
        return base
    return im.convert("RGB")


def portrait(name: str, path: Path, size=(600, 750)):
    im = flatten(Image.open(path))
    # crop 4:5, condong ke atas agar wajah tidak terpotong
    im = ImageOps.fit(im, size, Image.LANCZOS, centering=(0.5, 0.2))
    im.save(OUT / f"{name}.webp", "WEBP", quality=82, method=6)


def main():
    for name, path in PORTRAITS.items():
        portrait(name, path)

    hero = flatten(Image.open(FOTO / "Gedung smk itaba.png"))
    hero.thumbnail((2000, 2000), Image.LANCZOS)
    hero.save(OUT / "gedung.webp", "WEBP", quality=80, method=6)

    logo = ImageOps.exif_transpose(Image.open(FOTO / "LOGO SMK ITABA BARU NGAE DEWE.png")).convert("RGBA")
    for s in (512, 192, 64):
        l = logo.copy()
        l.thumbnail((s, s), Image.LANCZOS)
        l.save(OUT / f"logo-{s}.png", optimize=True)
    logo.thumbnail((512, 512), Image.LANCZOS)
    logo.save(OUT / "logo.webp", "WEBP", quality=90, method=6)

    poster = flatten(Image.open(ROOT / "Poster SPMB 2027.jpg"))
    poster.save(OUT / "poster-spmb.webp", "WEBP", quality=85, method=6)

    for name, fn in (("qr-whatsapp", "ADMIN SPMB SMK ITABA Tahun Ajaran 2027_2028.png"),
                     ("qr-formulir", "BARCODE SPMB SMK ITABA TAHUN AJARAN 2027_2028.png")):
        q = flatten(Image.open(DATA / fn))
        q.thumbnail((600, 600), Image.LANCZOS)
        q.save(OUT / f"{name}.png", optimize=True)

    lencana = ImageOps.exif_transpose(Image.open(DATA / "Lencana SPMB SMK ITABA Online.png")).convert("RGBA")
    lencana.thumbnail((640, 640), Image.LANCZOS)
    lencana.save(OUT / "lencana-spmb.webp", "WEBP", quality=88, method=6)

    for f in sorted(OUT.iterdir()):
        print(f"{f.name:28s} {f.stat().st_size // 1024:5d} KB")


if __name__ == "__main__":
    main()
