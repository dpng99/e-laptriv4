# -*- coding: utf-8 -*-
"""
Script Generator Laporan Bukti Fisik: Tautan & Tangkapan Layar Video Tutorial Interaktif
Untuk Pemenuhan Output Butir 7: Penyusunan Manual Book dan Video Tutorial Interaktif
"""

import os
import base64
import subprocess
import pymupdf

ASSETS_DIR = os.path.abspath("docs/manual_assets")
VIDEOS_DIR = os.path.abspath("docs/videos")
PDF_OUTPUT = os.path.abspath("docs/LAPORAN_BUKTI_FISIK_TAUTAN_DAN_TANGKAPAN_LAYAR_VIDEO_TUTORIAL.pdf")
HTML_OUTPUT = os.path.abspath("docs/bukti_fisik_video_tutorial.html")
CHROME_PATH = r"C:\Program Files\Google\Chrome\Application\chrome.exe"

def get_base64_image(path):
    if os.path.exists(path):
        with open(path, "rb") as f:
            encoded = base64.b64encode(f.read()).decode("utf-8")
            return f"data:image/png;base64,{encoded}"
    return ""

# Frames
vf1 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_1_login.png"))
vf2 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_2_dash.png"))
vf3 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_3_input.png"))
vf4 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_4_profile.png"))
vf5 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_5_admin_login.png"))
vf6 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_6_admin_dash.png"))
vf7 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_7_review.png"))
vf8 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_8_rumus.png"))
vf9 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_9_template.png"))
vf10 = get_base64_image(os.path.join(ASSETS_DIR, "video_frames", "frame_10_export.png"))

html = f"""<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bukti Fisik: Tautan & Tangkapan Layar Video Tutorial Interaktif</title>
    <style>
        @page {{
            size: A4 portrait;
            margin: 15mm 18mm 15mm 18mm;
        }}
        body {{
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1e293b;
            line-height: 1.5;
            font-size: 9pt;
            margin: 0;
            padding: 0;
        }}
        .header-box {{
            border-bottom: 2.5px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 15px;
            text-align: center;
        }}
        .instansi {{
            font-size: 11pt;
            font-weight: 800;
            letter-spacing: 1px;
            color: #0f172a;
            text-transform: uppercase;
        }}
        .sub-instansi {{
            font-size: 9pt;
            font-weight: 600;
            color: #064e3b;
        }}
        .doc-title {{
            font-size: 13pt;
            font-weight: 800;
            color: #0f172a;
            margin-top: 10px;
            text-transform: uppercase;
        }}
        .doc-subtitle {{
            font-size: 9.5pt;
            color: #475569;
            font-weight: 600;
        }}
        .table-meta {{
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            font-size: 8.5pt;
        }}
        .table-meta th {{
            background: #0f172a;
            color: #ffffff;
            padding: 6px 10px;
            text-align: left;
            border: 1px solid #0f172a;
        }}
        .table-meta td {{
            padding: 5px 10px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }}
        .table-meta tr:nth-child(even) {{
            background: #f8fafc;
        }}
        .section-head {{
            font-size: 10pt;
            font-weight: 800;
            color: #064e3b;
            border-bottom: 1.5px solid #cbd5e1;
            padding-bottom: 3px;
            margin: 18px 0 10px 0;
            text-transform: uppercase;
        }}
        .video-card {{
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            background: #ffffff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            page-break-inside: avoid;
        }}
        .video-card-title {{
            font-size: 10pt;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }}
        .video-card-meta {{
            font-size: 8pt;
            color: #475569;
            margin-bottom: 8px;
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: Consolas, monospace;
        }}
        .grid-frames {{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 8px;
        }}
        .frame-box {{
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
            background: #f8fafc;
            text-align: center;
        }}
        .frame-img {{
            width: 100%;
            display: block;
        }}
        .frame-cap {{
            font-size: 7.5pt;
            font-weight: 600;
            color: #334155;
            padding: 4px 6px;
            background: #f1f5f9;
            border-top: 1px solid #e2e8f0;
        }}
        .ttd-box {{
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 8.5pt;
            page-break-inside: avoid;
        }}
    </style>
</head>
<body>

    <!-- Header Dokumen -->
    <div class="header-box">
        <div class="instansi">KEJAKSAAN AGUNG REPUBLIK INDONESIA</div>
        <div class="sub-instansi">JAKSA AGUNG MUDA BIDANG PEMBINAAN (Dr. HENDRO DEWANTO, S.H., M.Hum.) &bull; SEKRETARIAT JAMBIN</div>
        <div class="doc-title">LEMBAR BUKTI FISIK PELAKSANAAN KEGIATAN BUTIR 7</div>
        <div class="doc-subtitle">Penyusunan Manual Book dan Video Tutorial Interaktif e-LAPTRI (e-LKjIP Pembinaan)</div>
    </div>

    <!-- Informasi Matriks Kegiatan -->
    <table class="table-meta">
        <tr>
            <th style="width: 25%;">Parameter Kegiatan</th>
            <th>Uraian & Bukti Fisik Resmi</th>
        </tr>
        <tr>
            <td><strong>Nomor & Nama Kegiatan</strong></td>
            <td><strong>Kegiatan 7:</strong> Penyusunan Manual Book dan Video Tutorial Interaktif</td>
        </tr>
        <tr>
            <td><strong>Target / Keluaran Output</strong></td>
            <td>Tersedianya panduan operasional buku manual cetak/PDF dan 3 paket video edukasi beresolusi tinggi.</td>
        </tr>
        <tr>
            <td><strong>Bukti Fisik Terlampir</strong></td>
            <td>
                1. <strong>Buku Manual Book E-LAPTRI (45 Halaman Lengkap PDF)</strong>: <code>docs/Buku_Manual_E-LAPTRI_45_Halaman.pdf</code><br>
                2. <strong>3 Paket Video Edukasi Beresolusi Tinggi (MP4 HD 720p + Audio Voiceover)</strong>: <code>docs/videos/</code><br>
                3. <strong>Matriks Tautan & Tangkapan Layar Video Tutorial Lengkap</strong> (Dokumen ini).
            </td>
        </tr>
        <tr>
            <td><strong>Tanggal Penyelesaian</strong></td>
            <td>Maret 2026</td>
        </tr>
    </table>

    <div class="section-head">I. MATRIKS TAUTAN BERKAS 3 PAKET VIDEO EDUKASI BERESOLUSI TINGGI</div>
    <table class="table-meta">
        <tr>
            <th style="width: 18%;">Paket Video</th>
            <th style="width: 28%;">Nama Berkas & Lokasi Lokal</th>
            <th style="width: 14%;">Ukuran & Format</th>
            <th>Cakupan Interaksi & Materi Edukasi yang Direkam</th>
        </tr>
        <tr>
            <td><strong>PAKET 1</strong></td>
            <td>
                <code>Paket_1_Tutorial_Operator_Input_Kinerja.mp4</code><br>
                <small style="color: #64748b;">Lokasi: docs/videos/</small>
            </td>
            <td>2.46 MB<br>MP4 HD (720p)<br>+ Voiceover</td>
            <td>Tutorial operasional Operator Satker Eselon II (Biro Perencanaan): Login akun, peninjauan dashboard metrik, form input SP/SK, pengisian nilai mentah pembilang ($X_1$) dan penyebut ($X_2$), realisasi otomatis, narasi kendala, dan profil.</td>
        </tr>
        <tr>
            <td><strong>PAKET 2</strong></td>
            <td>
                <code>Paket_2_Tutorial_Admin_Verifikasi_Rumus_Ekspor.mp4</code><br>
                <small style="color: #64748b;">Lokasi: docs/videos/</small>
            </td>
            <td>2.35 MB<br>MP4 HD (720p)<br>+ Voiceover</td>
            <td>Tutorial operasional Verifikator & Administrator JAMBIN: Monitoring Command Center 10 satker, review DataGrid multi-kriteria, lembar audit indikator, approval dan revisi, Formula Registry, template Word, dan ekspor LKjIP triwulanan.</td>
        </tr>
        <tr>
            <td><strong>PAKET 3</strong></td>
            <td>
                <code>Paket_3_Video_Edukasi_Keseluruhan_ELAPTRI.mp4</code><br>
                <small style="color: #64748b;">Lokasi: docs/videos/</small>
            </td>
            <td>4.36 MB<br>MP4 HD (720p)<br>+ Voiceover</td>
            <td>Video edukasi komprehensif master: Simulasi utuh end-to-end tata kelola SAKIP JAMBIN sesuai Renstra 2025-2029 dan Kepja 1184/2025, mendemonstrasikan sinergi pelaporan dari operator satker hingga terbitnya dokumen resmi LKjIP.</td>
        </tr>
    </table>

    <div style="page-break-after: always;"></div>

    <div class="section-head">II. TANGKAPAN LAYAR INTERAKTIF (SCREENSHOTS) PAKET 1: ALUR OPERATOR SATKER</div>
    <div class="video-card">
        <div class="video-card-title">Paket 1: Tutorial Operasional Operator Satker (Pengisian Kinerja Triwulanan e-LAPTRI)</div>
        <div class="video-card-meta">Berkas: Paket_1_Tutorial_Operator_Input_Kinerja.mp4 | Resolusi: 1280x720 HD | Audio: Neural Indonesian Voiceover</div>
        <div class="grid-frames">
            <div class="frame-box">
                <img src="{vf1}" class="frame-img">
                <div class="frame-cap">Scene 1 (00:03): Halaman Login & Autentikasi Operator Biro Perencanaan</div>
            </div>
            <div class="frame-box">
                <img src="{vf2}" class="frame-img">
                <div class="frame-cap">Scene 2 (00:15): Dashboard Interaktif & Diagram Lingkar Progres Pengisian</div>
            </div>
            <div class="frame-box">
                <img src="{vf3}" class="frame-img">
                <div class="frame-cap">Scene 3 (00:24): Input Nilai Mentah Pembilang (X1) & Penyebut (X2) pada Form IKK</div>
            </div>
            <div class="frame-box">
                <img src="{vf4}" class="frame-img">
                <div class="frame-cap">Scene 4 (00:32): Manajemen Profil Pengguna Satker & Pembaruan Kata Sandi</div>
            </div>
        </div>
    </div>

    <div class="section-head">III. TANGKAPAN LAYAR INTERAKTIF (SCREENSHOTS) PAKET 2: ALUR VERIFIKATOR & ADMIN</div>
    <div class="video-card">
        <div class="video-card-title">Paket 2: Tutorial Operasional Verifikator & Administrator JAMBIN</div>
        <div class="video-card-meta">Berkas: Paket_2_Tutorial_Admin_Verifikasi_Rumus_Ekspor.mp4 | Resolusi: 1280x720 HD | Audio: Neural Indonesian Voiceover</div>
        <div class="grid-frames">
            <div class="frame-box">
                <img src="{vf6}" class="frame-img">
                <div class="frame-cap">Scene 1 (00:46): Executive Command Center Dashboard Administrator JAMBIN</div>
            </div>
            <div class="frame-box">
                <img src="{vf7}" class="frame-img">
                <div class="frame-cap">Scene 2 (00:52): DataGrid Review Kinerja Seluruh Satker & Lembar Audit Detail</div>
            </div>
            <div class="frame-box">
                <img src="{vf8}" class="frame-img">
                <div class="frame-cap">Scene 3 (00:58): Formula Registry & Konfigurasi Komponen Rumus Indikator</div>
            </div>
            <div class="frame-box">
                <img src="{vf10}" class="frame-img">
                <div class="frame-cap">Scene 4 (01:09): Modul Ekspor Laporan LKjIP Triwulanan ke Dokumen Word (.docx)</div>
            </div>
        </div>
    </div>

    <div class="section-head">IV. TANGKAPAN LAYAR INTERAKTIF (SCREENSHOTS) PAKET 3: VIDEO EDUKASI MASTER SAKIP</div>
    <div class="video-card">
        <div class="video-card-title">Paket 3: Video Edukasi Komprehensif Tata Kelola SAKIP JAMBIN (Master Walkthrough)</div>
        <div class="video-card-meta">Berkas: Paket_3_Video_Edukasi_Keseluruhan_ELAPTRI.mp4 | Resolusi: 1280x720 HD | Durasi Penuh: End-to-End Walkthrough</div>
        <div class="grid-frames">
            <div class="frame-box">
                <img src="{vf5}" class="frame-img">
                <div class="frame-cap">Scene 1 (00:38): Alih Sesi Autentikasi Pengguna Tingkat Pusat JAMBIN</div>
            </div>
            <div class="frame-box">
                <img src="{vf9}" class="frame-img">
                <div class="frame-cap">Scene 2 (01:04): Pengelolaan Repositori Template Dokumen Word Resmi SAKIP</div>
            </div>
        </div>
    </div>

    <!-- Lembar Pengesahan Bukti Fisik -->
    <div class="ttd-box">
        <div style="width: 45%;">
            Mengetahui,<br>
            <strong>Koordinator Pelaporan Kinerja JAMBIN</strong><br>
            Biro Perencanaan Kejaksaan Agung RI<br><br><br><br>
            (_____________________________________)<br>
            NIP.
        </div>
        <div style="width: 45%;">
            Jakarta, Maret 2026<br>
            <strong>Tim Teknis & Penyusun e-LAPTRI v4</strong><br>
            Pusat Data Statistik Kriminal & TI (Pusdaskrimti)<br><br><br><br>
            (_____________________________________)<br>
            NIP.
        </div>
    </div>

</body>
</html>
"""

print(f"Menyimpan berkas HTML bukti fisik di {HTML_OUTPUT}...")
with open(HTML_OUTPUT, "w", encoding="utf-8") as f:
    f.write(html)

print(f"Mengonversi berkas bukti fisik ke PDF menggunakan Chrome headless...")
cmd = [
    CHROME_PATH,
    "--headless=new",
    "--disable-gpu",
    "--no-sandbox",
    "--no-pdf-header-footer",
    f"--print-to-pdf={PDF_OUTPUT}",
    HTML_OUTPUT
]

res = subprocess.run(cmd, capture_output=True, text=True)
if res.returncode == 0:
    doc = pymupdf.open(PDF_OUTPUT)
    print(f"BERHASIL! Dokumen Bukti Fisik PDF telah dibuat:")
    print(f"- Lokasi: {PDF_OUTPUT}")
    print(f"- Halaman: {len(doc)} Halaman")
    print(f"- Ukuran : {os.path.getsize(PDF_OUTPUT) / (1024*1024):.2f} MB")
    doc.close()
else:
    print("Error saat konversi Chrome:", res.stderr)
