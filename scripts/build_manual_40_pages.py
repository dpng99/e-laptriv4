# -*- coding: utf-8 -*-
"""
Script Generator Buku Manual Operasional E-LAPTRI v4 (40 Halaman)
Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI: Dr. Hendro Dewanto, S.H., M.Hum.
"""

import os
import sys
import base64
import subprocess

# Menambahkan folder scripts ke sys.path
SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
if SCRIPT_DIR not in sys.path:
    sys.path.insert(0, SCRIPT_DIR)

from manual_40p_pages_1_10 import get_pages_1_to_10
from manual_40p_pages_11_20 import get_pages_11_to_20
from manual_40p_pages_21_30 import get_pages_21_to_30
from manual_40p_pages_31_40 import get_pages_31_to_40

PROJECT_ROOT = os.path.abspath(os.path.join(SCRIPT_DIR, ".."))
ASSETS_DIR = os.path.join(PROJECT_ROOT, "docs", "manual_assets")
HTML_OUTPUT = os.path.join(PROJECT_ROOT, "docs", "manual_40_halaman.html")
PDF_OUTPUT = os.path.join(PROJECT_ROOT, "docs", "Buku_Manual_E-LAPTRI_40_Halaman.pdf")
CHROME_PATH = r"C:\Program Files\Google\Chrome\Application\chrome.exe"

def get_base64_image(filename):
    path = os.path.join(ASSETS_DIR, filename)
    if os.path.exists(path):
        with open(path, "rb") as f:
            encoded = base64.b64encode(f.read()).decode("utf-8")
            return f"data:image/png;base64,{encoded}"
    else:
        print(f"Warning: Asset file tidak ditemukan: {path}")
    return ""

def main():
    print("=================================================================")
    print("  GENERATOR BUKU MANUAL OPERASIONAL E-LAPTRI v4 (40 HALAMAN)    ")
    print("  Jaksa Agung Muda Bidang Pembinaan: Dr. Hendro Dewanto, S.H., M.Hum.")
    print("=================================================================")

    print("1. Mengumpulkan seluruh aset tangkapan layar resolusi tinggi...")
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
    }

    print("2. Menyusun modul halaman 1 sampai 40...")
    p1_10 = get_pages_1_to_10(assets)
    p11_20 = get_pages_11_to_20(assets)
    p21_30 = get_pages_21_to_30(assets)
    p31_40 = get_pages_31_to_40(assets)

    all_pages = p1_10 + p11_20 + p21_30 + p31_40
    print(f"   Total halaman berhasil dirakit: {len(all_pages)} halaman.")

    if len(all_pages) != 40:
        print(f"Error: Jumlah halaman tidak persis 40 (dihasilkan: {len(all_pages)})!")
        sys.exit(1)

    print("3. Membangun dokumen HTML standar print CSS...")
    html_content = f"""<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Manual E-LAPTRI v4 - 40 Halaman Lengkap</title>
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
            padding: 12mm 15mm 12mm 15mm;
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
            height: 8mm;
            border-bottom: 1.5px solid #cbd5e1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 7.2pt;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 2.5mm;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }}
        .footer {{
            position: absolute;
            bottom: 5mm;
            left: 15mm;
            right: 15mm;
            height: 6.5mm;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 7.2pt;
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
            font-size: 6.8pt;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 4px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }}
        .title-primary {{
            font-size: 11.5pt;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
            margin: 0 0 6px 0;
            letter-spacing: -0.2px;
        }}
        .subtitle-primary {{
            font-size: 8.5pt;
            font-weight: 700;
            color: #064e3b;
            margin: 8px 0 4px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 2px;
            text-transform: uppercase;
        }}
        .paragraph {{
            font-size: 7.8pt;
            line-height: 1.45;
            color: #334155;
            margin: 0 0 5px 0;
            text-align: justify;
        }}
        .table-styled {{
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
            font-size: 7.4pt;
        }}
        .table-styled th {{
            background: #0f172a;
            color: #ffffff;
            padding: 4px 6px;
            text-align: left;
            font-weight: 700;
            border: 1px solid #0f172a;
        }}
        .table-styled td {{
            padding: 3.5px 6px;
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            margin: 5px 0;
            text-align: center;
        }}
        .screenshot-img {{
            width: 100%;
            display: block;
            object-fit: contain;
            max-height: 102mm;
        }}
        .screenshot-caption {{
            font-size: 6.8pt;
            font-weight: 600;
            color: #475569;
            background: #f1f5f9;
            padding: 3px 6px;
            border-top: 1px solid #e2e8f0;
            font-style: italic;
        }}
        .callout {{
            border-radius: 5px;
            padding: 6px 10px;
            margin: 6px 0;
            font-size: 7.4pt;
            line-height: 1.4;
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
            font-size: 6.8pt;
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
            padding: 4.5px 7px;
            margin-bottom: 4px;
        }}
        .regulasi-title {{
            font-weight: 700;
            font-size: 7.8pt;
            color: #0f172a;
        }}
        .regulasi-desc {{
            font-size: 6.8pt;
            color: #475569;
            margin-top: 1px;
            line-height: 1.3;
        }}
        .toc-line {{
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dotted #cbd5e1;
            padding: 1.5px 0;
            font-weight: 700;
            color: #0f172a;
        }}
        .toc-head {{
            font-weight: 800;
            color: #064e3b;
            margin-top: 3px;
            padding: 1.5px 0;
            font-size: 7.8pt;
            text-transform: uppercase;
        }}
        .toc-item {{
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dotted #e2e8f0;
            padding: 1px 0 1px 6px;
            color: #334155;
        }}
        .feature-box {{
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 6px 8px;
        }}
        .faq-item {{
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 5px 8px;
            margin-bottom: 5px;
            background: #ffffff;
        }}
        .faq-q {{
            font-weight: 700;
            color: #0369a1;
            margin-bottom: 2px;
            font-size: 7.5pt;
        }}
        .faq-a {{
            font-size: 6.9pt;
            color: #334155;
            line-height: 1.35;
        }}
    </style>
</head>
<body>
{"".join(all_pages)}
</body>
</html>
"""

    print(f"4. Menulis berkas HTML ke: {HTML_OUTPUT}")
    with open(HTML_OUTPUT, "w", encoding="utf-8") as f:
        f.write(html_content)

    file_size_mb = os.path.getsize(HTML_OUTPUT) / (1024 * 1024)
    print(f"   Ukuran berkas HTML: {file_size_mb:.2f} MB.")

    print(f"5. Mengeksekusi Google Chrome Headless untuk menghasilkan PDF...")
    if not os.path.exists(CHROME_PATH):
        print(f"Error: Chrome tidak ditemukan di {CHROME_PATH}")
        sys.exit(1)

    cmd = [
        CHROME_PATH,
        "--headless",
        "--disable-gpu",
        "--no-sandbox",
        "--run-all-compositor-stages-before-draw",
        f"--print-to-pdf={PDF_OUTPUT}",
        "--no-pdf-header-footer",
        HTML_OUTPUT
    ]

    result = subprocess.run(cmd, capture_output=True, text=True)
    if result.returncode == 0:
        pdf_size_mb = os.path.getsize(PDF_OUTPUT) / (1024 * 1024)
        print(f"   SUKSES! Dokumen PDF berhasil dicetak: {PDF_OUTPUT}")
        print(f"   Ukuran berkas PDF: {pdf_size_mb:.2f} MB")
    else:
        print(f"Error saat mengeksekusi Chrome:")
        print(result.stderr)
        sys.exit(1)

    print("=================================================================")
    print("  PROSES SELESAI: 40 HALAMAN BUKU MANUAL E-LAPTRI v4 TERCIPTA!   ")
    print("=================================================================")

if __name__ == "__main__":
    main()
