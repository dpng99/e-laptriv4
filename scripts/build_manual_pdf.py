# -*- coding: utf-8 -*-
"""
Script Generator Buku Manual Operasional E-LAPTRI (45 Halaman)
Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI
"""

import os
import base64
import subprocess
import pymupdf

from manual_pages_1_15 import get_pages_1_to_15
from manual_pages_16_30 import get_pages_16_to_30
from manual_pages_31_45 import get_pages_31_to_45

ASSETS_DIR = os.path.abspath("docs/manual_assets")
PDF_OUTPUT = os.path.abspath("docs/Buku_Manual_E-LAPTRI_45_Halaman.pdf")
HTML_OUTPUT = os.path.abspath("docs/manual_45_halaman.html")
CHROME_PATH = r"C:\Program Files\Google\Chrome\Application\chrome.exe"

def get_base64_image(filename):
    path = os.path.join(ASSETS_DIR, filename)
    if os.path.exists(path):
        with open(path, "rb") as f:
            encoded = base64.b64encode(f.read()).decode("utf-8")
            return f"data:image/png;base64,{encoded}"
    return ""

print("Mengumpulkan seluruh aset visual tangkapan layar dan barcode QR...")
assets = {
    'img_login': get_base64_image("01_login_page.png"),
    'img_dashboard': get_base64_image("02_operator_dashboard.png"),
    'img_charts': get_base64_image("02b_operator_dashboard_charts.png"),
    'img_input_sp': get_base64_image("03_input_data_sp.png"),
    'img_input_details': get_base64_image("04_input_data_details.png"),
    'img_input_analysis': get_base64_image("04b_input_data_analysis.png"),
    'img_profile': get_base64_image("06_profile_page.png"),
    'img_admin_dash': get_base64_image("07_admin_dashboard.png"),
    'img_review_idx': get_base64_image("08_review_data_index.png"),
    'img_review_det': get_base64_image("09_review_data_detail.png"),
    'img_rumus_idx': get_base64_image("10_admin_rumus_index.png"),
    'img_rumus_edit': get_base64_image("10b_admin_rumus_edit.png"),
    'img_template': get_base64_image("11_admin_template_index.png"),
    'img_export': get_base64_image("12_export_index.png"),
    'vf_1': get_base64_image("video_frames/frame_1_login.png"),
    'vf_2': get_base64_image("video_frames/frame_2_dash.png"),
    'vf_3': get_base64_image("video_frames/frame_3_input.png"),
    'vf_4': get_base64_image("video_frames/frame_4_profile.png"),
    'vf_6': get_base64_image("video_frames/frame_6_admin_dash.png"),
    'vf_7': get_base64_image("video_frames/frame_7_review.png"),
    'vf_8': get_base64_image("video_frames/frame_8_rumus.png"),
    'vf_10': get_base64_image("video_frames/frame_10_export.png"),
}

print("Menyusun konten 45 halaman dokumen publikasi...")
p1_15 = get_pages_1_to_15(assets)
p16_30 = get_pages_16_to_30(assets)
p31_45 = get_pages_31_to_45(assets)

all_pages = p1_15 + p16_30 + p31_45
print(f"Total halaman yang dirakit: {len(all_pages)}")

html_content = f"""<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Manual E-LAPTRI - 45 Halaman</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <style>
        @page {{
            size: A4 portrait;
            margin: 0;
        }}
        * {{
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }}
        body {{
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, Helvetica, sans-serif;
            color: #1e293b;
            background-color: #f1f5f9;
        }}
        .page {{
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background: #ffffff;
            position: relative;
            page-break-after: always;
            page-break-inside: avoid;
            padding: 13mm 16mm 13mm 16mm;
            box-sizing: border-box;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }}
        .page-cover {{
            padding: 0 !important;
            background: linear-gradient(135deg, #091a2b 0%, #0d2847 45%, #064e3b 100%) !important;
            color: #ffffff !important;
        }}
        .header {{
            height: 8.5mm;
            border-bottom: 1.5px solid #cbd5e1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 7.5pt;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 3mm;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }}
        .footer {{
            position: absolute;
            bottom: 5.5mm;
            left: 16mm;
            right: 16mm;
            height: 7mm;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 7.5pt;
            font-weight: 600;
            color: #94a3b8;
        }}
        .content {{
            flex: 1;
            overflow: hidden;
        }}
        .chapter-badge {{
            display: inline-block;
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            font-size: 7pt;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 4px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }}
        .title-primary {{
            font-size: 12.5pt;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
            margin: 0 0 8px 0;
            letter-spacing: -0.2px;
        }}
        .subtitle-primary {{
            font-size: 9pt;
            font-weight: 700;
            color: #064e3b;
            margin: 10px 0 5px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 2px;
        }}
        .paragraph {{
            font-size: 8.2pt;
            line-height: 1.5;
            color: #334155;
            margin: 0 0 6px 0;
            text-align: justify;
        }}
        .table-styled {{
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0;
            font-size: 7.8pt;
        }}
        .table-styled th {{
            background: #0f172a;
            color: #ffffff;
            padding: 4.5px 7px;
            text-align: left;
            font-weight: 700;
            border: 1px solid #0f172a;
        }}
        .table-styled td {{
            padding: 4px 7px;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            vertical-align: top;
        }}
        .table-styled tr:nth-child(even) {{
            background: #f8fafc;
        }}
        .screenshot-card {{
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            overflow: hidden;
            background: #f8fafc;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin: 6px 0;
            text-align: center;
        }}
        .screenshot-img {{
            width: 100%;
            display: block;
            object-fit: contain;
        }}
        .screenshot-caption {{
            font-size: 7pt;
            font-weight: 600;
            color: #475569;
            background: #f1f5f9;
            padding: 3px 6px;
            border-top: 1px solid #e2e8f0;
            font-style: italic;
        }}
        .callout {{
            border-radius: 6px;
            padding: 7px 11px;
            margin: 8px 0;
            font-size: 7.8pt;
            line-height: 1.45;
        }}
        .callout-info {{
            background: #eff6ff;
            border-left: 3.5px solid #3b82f6;
            color: #1e3a8a;
        }}
        .callout-warning {{
            background: #fffbeb;
            border-left: 3.5px solid #f59e0b;
            color: #92400e;
        }}
        .badge-role {{
            font-size: 7pt;
            font-weight: 800;
            padding: 1.5px 5px;
            border-radius: 3px;
            display: inline-block;
        }}
        .badge-admin {{
            background: #fdf2f8;
            color: #9d174d;
            border: 1px solid #fbcfe8;
        }}
        .badge-opr {{
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }}
        .card-regulasi {{
            background: #f8fafc;
            border-left: 3px solid #064e3b;
            border-top: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 5px 8px;
            margin-bottom: 5px;
        }}
        .regulasi-title {{
            font-weight: 700;
            font-size: 8.2pt;
            color: #0f172a;
        }}
        .regulasi-desc {{
            font-size: 7.2pt;
            color: #475569;
            margin-top: 1px;
            line-height: 1.35;
        }}
        .toc-line {{
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dotted #cbd5e1;
            padding: 2px 0;
            font-weight: 700;
            color: #0f172a;
        }}
        .toc-head {{
            font-weight: 800;
            color: #064e3b;
            margin-top: 4px;
            padding: 1.5px 0;
            font-size: 8.2pt;
            text-transform: uppercase;
        }}
        .toc-item {{
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dotted #e2e8f0;
            padding: 1.5px 0 1.5px 8px;
            color: #334155;
        }}
        .feature-box {{
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px;
        }}
        .qr-card {{
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 5px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }}
        .qr-img {{
            width: 24mm;
            height: 24mm;
            display: block;
            margin: 0 auto 3px auto;
        }}
        .qr-title {{
            font-size: 7.2pt;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.15;
        }}
        .qr-desc {{
            font-size: 6.2pt;
            color: #64748b;
            margin-top: 2px;
            line-height: 1.25;
        }}
        .faq-item {{
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 6.5px 9px;
            margin-bottom: 6px;
            background: #ffffff;
        }}
        .faq-q {{
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 3px;
            font-size: 7.8pt;
        }}
        .faq-a {{
            font-size: 7.2pt;
            color: #334155;
            line-height: 1.4;
        }}
    </style>
</head>
<body>
{''.join(all_pages)}
</body>
</html>
"""

print(f"Menyimpan berkas HTML di {HTML_OUTPUT}...")
with open(HTML_OUTPUT, "w", encoding="utf-8") as f:
    f.write(html_content)

print(f"Mengonversi berkas HTML ke PDF menggunakan Chrome headless ({CHROME_PATH})...")
cmd = [
    CHROME_PATH,
    "--headless=new",
    "--disable-gpu",
    "--no-sandbox",
    "--no-pdf-header-footer",
    f"--print-to-pdf={PDF_OUTPUT}",
    HTML_OUTPUT
]

result = subprocess.run(cmd, capture_output=True, text=True)
if result.returncode != 0:
    print("Chrome conversion error:", result.stderr)
else:
    print("Chrome headless berhasil mencetak PDF.")

# Verifikasi Jumlah Halaman dengan PyMuPDF
doc = pymupdf.open(PDF_OUTPUT)
page_count = len(doc)
doc.close()

file_size_mb = os.path.getsize(PDF_OUTPUT) / (1024 * 1024)
print(f"HASIL VERIFIKASI DOKUMEN PDF:")
print(f"- Lokasi Berkas : {PDF_OUTPUT}")
print(f"- Jumlah Halaman: {page_count} Halaman")
print(f"- Ukuran Berkas : {file_size_mb:.2f} MB")

if page_count == 45:
    print("STATUS: SEMPURNA! Dokumen PDF tepat 45 Halaman sesuai permintaan!")
else:
    print(f"CATATAN: Terdeteksi {page_count} halaman (target: 45). Memeriksa pembagian halaman...")
