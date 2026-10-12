import os
import qrcode

OUTPUT_DIR = os.path.abspath("docs/manual_assets")
os.makedirs(OUTPUT_DIR, exist_ok=True)

modules = [
    ("qr_modul_1.png", "https://kejaksaan.go.id/elaptri/tutorial/modul-1-pengenalan-dan-login"),
    ("qr_modul_2.png", "https://kejaksaan.go.id/elaptri/tutorial/modul-2-dashboard-dan-visualisasi"),
    ("qr_modul_3.png", "https://kejaksaan.go.id/elaptri/tutorial/modul-3-input-sasaran-program-ikp"),
    ("qr_modul_4.png", "https://kejaksaan.go.id/elaptri/tutorial/modul-4-input-sasaran-kegiatan-ikk"),
    ("qr_modul_5.png", "https://kejaksaan.go.id/elaptri/tutorial/modul-5-analisis-capaian-dan-kendala"),
    ("qr_modul_6.png", "https://kejaksaan.go.id/elaptri/tutorial/modul-6-verifikasi-review-admin"),
    ("qr_modul_7.png", "https://kejaksaan.go.id/elaptri/tutorial/modul-7-manajemen-rumus-dan-indikator"),
    ("qr_modul_8.png", "https://kejaksaan.go.id/elaptri/tutorial/modul-8-ekspor-laporan-lkjip-word"),
    ("qr_video_full.png", "https://kejaksaan.go.id/elaptri/tutorial/playlist-lengkap-video-manual-elaptri")
]

for filename, url in modules:
    qr = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_H,
        box_size=8,
        border=2,
    )
    qr.add_data(url)
    qr.make(fit=True)
    img = qr.make_image(fill_color="#0f172a", back_color="#ffffff")
    img_path = os.path.join(OUTPUT_DIR, filename)
    img.save(img_path)
    print(f"Generated QR code: {filename} -> {url}")

print("All QR codes successfully generated!")
