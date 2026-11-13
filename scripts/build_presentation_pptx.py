# -*- coding: utf-8 -*-
"""
Generator Materi Presentasi PowerPoint (.pptx) Pengenalan Aplikasi E-LAPTRI untuk Operator
Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI: Dr. Hendro Dewanto, S.H., M.Hum.
Total: 20 Slide Widescreen (16:9)
"""

import os
import sys
from pptx import Presentation
from pptx.util import Inches, Pt
from pptx.dml.color import RGBColor
from pptx.enum.text import PP_ALIGN
from pptx.enum.shapes import MSO_SHAPE

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
PROJECT_ROOT = os.path.abspath(os.path.join(SCRIPT_DIR, ".."))
ASSETS_DIR = os.path.join(PROJECT_ROOT, "docs", "manual_assets")
OUTPUT_PPTX = os.path.join(PROJECT_ROOT, "docs", "Materi_Pengenalan_Aplikasi_E-LAPTRI_Operator.pptx")

# Palet Warna Resmi Kedinasan Kejaksaan RI
COLOR_NAVY_DARK = RGBColor(9, 26, 43)     # #091A2B
COLOR_SLATE_DARK = RGBColor(15, 23, 42)    # #0F172A
COLOR_EMERALD_DARK = RGBColor(6, 78, 59)   # #064E3B
COLOR_EMERALD_MED = RGBColor(5, 150, 105)  # #059669
COLOR_EMERALD_LIGHT = RGBColor(240, 253, 244) # #F0FDF4
COLOR_AMBER = RGBColor(245, 158, 11)       # #F59E0B
COLOR_AMBER_DARK = RGBColor(217, 119, 6)   # #D97706
COLOR_SKY_BLUE = RGBColor(2, 132, 199)     # #0284C7
COLOR_BLUE_LIGHT = RGBColor(239, 246, 255) # #EFF6FF
COLOR_WHITE = RGBColor(255, 255, 255)
COLOR_BG_GRAY = RGBColor(248, 250, 252)    # #F8FAFC
COLOR_TEXT_DARK = RGBColor(30, 41, 59)     # #1E293B
COLOR_TEXT_MUTED = RGBColor(100, 116, 139) # #64748B
COLOR_BORDER = RGBColor(203, 213, 225)     # #CBD5E1
COLOR_RED_DARK = RGBColor(185, 28, 28)     # #B91C1C
COLOR_RED_LIGHT = RGBColor(254, 242, 242)  # #FEF2F2

FONT_PRIMARY = "Arial"

def create_shape(slide, shape_type, left, top, width, height, fill_color, line_color=None, line_width=Pt(1)):
    shape = slide.shapes.add_shape(shape_type, left, top, width, height)
    shape.fill.solid()
    shape.fill.fore_color.rgb = fill_color
    if line_color:
        shape.line.color.rgb = line_color
        shape.line.width = line_width
    else:
        shape.line.fill.background()
    return shape

def add_header(slide, title_text, category_text, slide_number):
    # Top banner background
    banner = create_shape(slide, MSO_SHAPE.RECTANGLE, Inches(0), Inches(0), Inches(13.333), Inches(1.15), COLOR_SLATE_DARK)
    
    # Category badge
    cat_box = slide.shapes.add_textbox(Inches(0.8), Inches(0.18), Inches(9.0), Inches(0.3))
    tf_c = cat_box.text_frame
    tf_c.word_wrap = True
    p_c = tf_c.paragraphs[0]
    p_c.text = category_text.upper()
    p_c.font.name = FONT_PRIMARY
    p_c.font.size = Pt(9.5)
    p_c.font.bold = True
    p_c.font.color.rgb = COLOR_AMBER

    # Title text
    title_box = slide.shapes.add_textbox(Inches(0.8), Inches(0.42), Inches(10.5), Inches(0.6))
    tf_t = title_box.text_frame
    tf_t.word_wrap = True
    p_t = tf_t.paragraphs[0]
    p_t.text = title_text
    p_t.font.name = FONT_PRIMARY
    p_t.font.size = Pt(17)
    p_t.font.bold = True
    p_t.font.color.rgb = COLOR_WHITE

    # Right branding badge
    brand_box = slide.shapes.add_textbox(Inches(10.2), Inches(0.22), Inches(2.4), Inches(0.7))
    tf_b = brand_box.text_frame
    tf_b.word_wrap = True
    p_b1 = tf_b.paragraphs[0]
    p_b1.alignment = PP_ALIGN.RIGHT
    p_b1.text = "E-LAPTRI PEMBINAAN"
    p_b1.font.name = FONT_PRIMARY
    p_b1.font.size = Pt(8.5)
    p_b1.font.bold = True
    p_b1.font.color.rgb = COLOR_AMBER

    p_b2 = tf_b.add_paragraph()
    p_b2.alignment = PP_ALIGN.RIGHT
    p_b2.text = f"Slide {slide_number} dari 20"
    p_b2.font.name = FONT_PRIMARY
    p_b2.font.size = Pt(8)
    p_b2.font.color.rgb = COLOR_TEXT_MUTED

    # Bottom footer line on slide
    create_shape(slide, MSO_SHAPE.RECTANGLE, Inches(0.8), Inches(7.15), Inches(11.733), Inches(0.02), COLOR_BORDER)
    foot_box = slide.shapes.add_textbox(Inches(0.8), Inches(7.18), Inches(11.733), Inches(0.28))
    tf_f = foot_box.text_frame
    p_f = tf_f.paragraphs[0]
    p_f.text = "Kejaksaan Republik Indonesia | Jaksa Agung Muda Bidang Pembinaan (JAMBIN) | Renstra 2025-2029 & KEPJA 1184/2025"
    p_f.font.name = FONT_PRIMARY
    p_f.font.size = Pt(7.5)
    p_f.font.color.rgb = COLOR_TEXT_MUTED

def add_card(slide, left, top, width, height, title, bg_color=COLOR_WHITE, border_color=COLOR_BORDER, title_color=COLOR_EMERALD_DARK):
    create_shape(slide, MSO_SHAPE.ROUNDED_RECTANGLE, left, top, width, height, bg_color, border_color, Pt(1))
    if title:
        title_box = slide.shapes.add_textbox(left + Inches(0.2), top + Inches(0.15), width - Inches(0.4), Inches(0.4))
        tf = title_box.text_frame
        tf.word_wrap = True
        p = tf.paragraphs[0]
        p.text = title.upper()
        p.font.name = FONT_PRIMARY
        p.font.size = Pt(11)
        p.font.bold = True
        p.font.color.rgb = title_color
    return left + Inches(0.2), top + Inches(0.55), width - Inches(0.4), height - Inches(0.7)

def add_bullet(text_frame, bold_prefix, text_body, pt_size=10, is_first=False, text_color=COLOR_TEXT_DARK):
    p = text_frame.paragraphs[0] if is_first else text_frame.add_paragraph()
    p.space_after = Pt(4)
    p.space_before = Pt(2)
    
    r1 = p.add_run()
    r1.text = bold_prefix + " "
    r1.font.name = FONT_PRIMARY
    r1.font.bold = True
    r1.font.size = Pt(pt_size)
    r1.font.color.rgb = text_color

    r2 = p.add_run()
    r2.text = text_body
    r2.font.name = FONT_PRIMARY
    r2.font.bold = False
    r2.font.size = Pt(pt_size)
    r2.font.color.rgb = text_color

def add_screenshot_frame(slide, filename, left, top, width, height, caption=""):
    path = os.path.join(ASSETS_DIR, filename)
    if not os.path.exists(path):
        print(f"Warning: Screenshot tidak ditemukan: {path}")
        return

    # Frame latar belakang
    frame_h = height + (Inches(0.35) if caption else 0)
    create_shape(slide, MSO_SHAPE.ROUNDED_RECTANGLE, left, top, width, frame_h, COLOR_BG_GRAY, COLOR_BORDER, Pt(1))
    
    # Sisipkan Gambar
    img_pad = Inches(0.06)
    img = slide.shapes.add_picture(path, left + img_pad, top + img_pad, width - (img_pad * 2), height - (img_pad * 2))
    
    if caption:
        cap_box = slide.shapes.add_textbox(left, top + height, width, Inches(0.35))
        tf = cap_box.text_frame
        tf.word_wrap = True
        p = tf.paragraphs[0]
        p.alignment = PP_ALIGN.CENTER
        p.text = caption
        p.font.name = FONT_PRIMARY
        p.font.size = Pt(8.5)
        p.font.italic = True
        p.font.color.rgb = COLOR_TEXT_MUTED

def main():
    print("=================================================================")
    print("  MEMBANGUN MATERI PRESENTASI POWERPOINT E-LAPTRI (20 SLIDE)     ")
    print("  Jaksa Agung Muda Bidang Pembinaan: Dr. Hendro Dewanto, S.H., M.Hum.")
    print("=================================================================")

    prs = Presentation()
    prs.slide_width = Inches(13.333)
    prs.slide_height = Inches(7.5)
    blank_layout = prs.slide_layouts[6]

    # =========================================================================
    # SLIDE 1: COVER PRESENTASI
    # =========================================================================
    slide1 = prs.slides.add_slide(blank_layout)
    create_shape(slide1, MSO_SHAPE.RECTANGLE, Inches(0), Inches(0), Inches(13.333), Inches(7.5), COLOR_NAVY_DARK)

    # Accent decorative strip
    create_shape(slide1, MSO_SHAPE.RECTANGLE, Inches(0.8), Inches(0.8), Inches(0.12), Inches(5.9), COLOR_AMBER)

    # Top Institution Header
    top_box = slide1.shapes.add_textbox(Inches(1.2), Inches(0.8), Inches(11.0), Inches(0.8))
    tf1 = top_box.text_frame
    p = tf1.paragraphs[0]
    p.text = "KEJAKSAAN REPUBLIK INDONESIA"
    p.font.name = FONT_PRIMARY
    p.font.size = Pt(13)
    p.font.bold = True
    p.font.color.rgb = COLOR_AMBER
    
    p2 = tf1.add_paragraph()
    p2.text = "JAKSA AGUNG MUDA BIDANG PEMBINAAN (JAMBIN)"
    p2.font.name = FONT_PRIMARY
    p2.font.size = Pt(15)
    p2.font.bold = True
    p2.font.color.rgb = COLOR_WHITE

    # Badge Sosialisasi
    badge = create_shape(slide1, MSO_SHAPE.ROUNDED_RECTANGLE, Inches(1.2), Inches(2.2), Inches(5.8), Inches(0.42), COLOR_EMERALD_DARK, COLOR_EMERALD_MED)
    b_box = slide1.shapes.add_textbox(Inches(1.2), Inches(2.2), Inches(5.8), Inches(0.42))
    p_b = b_box.text_frame.paragraphs[0]
    p_b.alignment = PP_ALIGN.CENTER
    p_b.text = "MATERI SOSIALISASI & BIMTEK OPERATOR KINERJA 2026"
    p_b.font.name = FONT_PRIMARY
    p_b.font.size = Pt(9.5)
    p_b.font.bold = True
    p_b.font.color.rgb = COLOR_WHITE

    # Big Title
    title_box = slide1.shapes.add_textbox(Inches(1.15), Inches(2.8), Inches(11.0), Inches(2.2))
    tf_t = title_box.text_frame
    p_t1 = tf_t.paragraphs[0]
    p_t1.text = "PENGENALAN SISTEM INFORMASI"
    p_t1.font.name = FONT_PRIMARY
    p_t1.font.size = Pt(28)
    p_t1.font.bold = True
    p_t1.font.color.rgb = COLOR_WHITE

    p_t2 = tf_t.add_paragraph()
    p_t2.text = "E-LAPTRI"
    p_t2.font.name = FONT_PRIMARY
    p_t2.font.size = Pt(46)
    p_t2.font.bold = True
    p_t2.font.color.rgb = COLOR_SKY_BLUE

    p_t3 = tf_t.add_paragraph()
    p_t3.text = "Sistem Pengukuran Kinerja Triwulanan & e-LKjIP Berbasis Canonical Cascading JAMBIN"
    p_t3.font.name = FONT_PRIMARY
    p_t3.font.size = Pt(13)
    p_t3.font.color.rgb = COLOR_TEXT_MUTED

    # Bottom Leadership Box
    create_shape(slide1, MSO_SHAPE.ROUNDED_RECTANGLE, Inches(1.2), Inches(5.5), Inches(11.0), Inches(1.2), COLOR_SLATE_DARK, COLOR_AMBER, Pt(1))
    lead_box = slide1.shapes.add_textbox(Inches(1.4), Inches(5.6), Inches(10.6), Inches(1.0))
    tf_l = lead_box.text_frame
    p_l1 = tf_l.paragraphs[0]
    p_l1.text = "Pengarah Utama: Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI"
    p_l1.font.name = FONT_PRIMARY
    p_l1.font.size = Pt(10)
    p_l1.font.color.rgb = COLOR_AMBER

    p_l2 = tf_l.add_paragraph()
    p_l2.text = "Dr. HENDRO DEWANTO, S.H., M.Hum."
    p_l2.font.name = FONT_PRIMARY
    p_l2.font.size = Pt(14)
    p_l2.font.bold = True
    p_l2.font.color.rgb = COLOR_WHITE

    p_l3 = tf_l.add_paragraph()
    p_l3.text = "Inisiator: Dr. M. Priandhika Abadi Noer, S.H., M.H. | Tim Penyusun: Tim Efektif | 10 Satker Eselon II JAMBIN"
    p_l3.font.name = FONT_PRIMARY
    p_l3.font.size = Pt(9.5)
    p_l3.font.color.rgb = COLOR_TEXT_MUTED

    # =========================================================================
    # SLIDE 2: LATAR BELAKANG & TRANSFORMASI DIGITAL
    # =========================================================================
    slide2 = prs.slides.add_slide(blank_layout)
    add_header(slide2, "Latar Belakang & Transformasi Digital Pelaporan Kinerja", "BAB I: PENDAHULUAN & ARSITEKTUR", 2)

    # Kolom Kiri: Paradigma Lama
    cx, cy, cw, ch = add_card(slide2, Inches(0.8), Inches(1.4), Inches(5.7), Inches(5.5), "PARADIGMA SEBELUMNYA (MANUAL)", COLOR_RED_LIGHT, COLOR_RED_DARK, COLOR_RED_DARK)
    tb2_l = slide2.shapes.add_textbox(cx, cy, cw, ch)
    tf2_l = tb2_l.text_frame
    tf2_l.word_wrap = True
    add_bullet(tf2_l, "1. Pelaporan Terfragmentasi:", "Pengumpulan data menggunakan spreadsheet Excel terpisah antar-satker, rentan tercecer dan formula tidak sinkron.", 10.5, True)
    add_bullet(tf2_l, "2. Tanpa Bukti Numerik:", "Hanya mencatat persentase akhir (%) tanpa melampirkan angka mentah pembilang dan penyebut yang dapat diaudit.", 10.5)
    add_bullet(tf2_l, "3. Generic Averaging Keliru:", "Menjumlahkan atau merata-ratakan indikator secara linier tanpa memperhitungkan bobot dan semantik relasi.", 10.5)
    add_bullet(tf2_l, "4. Kompilasi Lambat:", "Penyusunan dokumen LKjIP triwulanan memakan waktu berminggu-minggu dengan pengetikan manual di Word.", 10.5)

    # Kolom Kanan: Paradigma Baru
    cx, cy, cw, ch = add_card(slide2, Inches(6.8), Inches(1.4), Inches(5.7), Inches(5.5), "PARADIGMA BARU E-LAPTRI (DIGITAL INTEGRITAS)", COLOR_EMERALD_LIGHT, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb2_r = slide2.shapes.add_textbox(cx, cy, cw, ch)
    tf2_r = tb2_r.text_frame
    tf2_r.word_wrap = True
    add_bullet(tf2_r, "1. Arsitektur Terpusat Web:", "Single source of truth berbasis web responsif yang terhubung langsung ke database kinerja JAMBIN.", 10.5, True)
    add_bullet(tf2_r, "2. Rekam Variabel Mentah (X1 & X2):", "Operator wajib menginput nilai riil pembilang dan penyebut dengan bukti dukung (evidence) PDF yang sah.", 10.5)
    add_bullet(tf2_r, "3. Canonical Directed Acyclic Graph (DAG):", "Mesin hitung cerdas dengan 9 tipe formula baku SAKIP tanpa distorsi generic average.", 10.5)
    add_bullet(tf2_r, "4. Ekspor LKjIP Word Instan:", "Penerbitan dokumen resmi LKjIP berstandar kedinasan hanya dengan sekali klik (otomasi PHPWord).", 10.5)

    # =========================================================================
    # SLIDE 3: LANDASAN HUKUM & REGULASI SAKIP
    # =========================================================================
    slide3 = prs.slides.add_slide(blank_layout)
    add_header(slide3, "Landasan Regulasi & Sumber Kebijakan Resmi SAKIP", "BAB I: REGULASI & STANDAR KINERJA", 3)

    regs = [
        ("Perpres No. 29 Tahun 2014", "Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP)", "Mewajibkan penyelenggaraan perencanaan, pengukuran kinerja berkala, evaluasi, dan penyusunan pelaporan akuntabilitas secara sistematis."),
        ("PermenPAN-RB No. 88 Tahun 2021", "Pedoman Evaluasi Akuntabilitas Kinerja Pemerintah", "Menetapkan standar kualitas cascading (penjenjangan), kebermanfaatan hasil (outcome), serta validitas data dukung kinerja."),
        ("Keputusan Jaksa Agung No. 1184 / 2025", "Indikator Kinerja Utama (IKU) Kejaksaan RI", "SUMBER UTAMA: Menetapkan nomenklatur resmi, kode indikator, teks definisi operasional, formula matematis, target tahunan, dan PIC satker."),
        ("Renstra Kejaksaan RI 2025-2029", "Rencana Strategis Jangka Menengah Kejaksaan Agung", "Memuat arah kebijakan, Sasaran Strategis (SS), Sasaran Program (SP), dan Sasaran Kegiatan (SK) di lingkungan JAMBIN.")
    ]

    for i, (r_title, r_sub, r_desc) in enumerate(regs):
        rx = Inches(0.8 + (i % 2) * 5.95)
        ry = Inches(1.4 + (i // 2) * 2.7)
        cx, cy, cw, ch = add_card(slide3, rx, ry, Inches(5.8), Inches(2.5), r_title, COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
        tb = slide3.shapes.add_textbox(cx, cy, cw, ch)
        tf = tb.text_frame
        tf.word_wrap = True
        add_bullet(tf, "Substansi:", r_sub, 9.5, True, COLOR_AMBER_DARK)
        add_bullet(tf, "Keterkaitan Sistem:", r_desc, 9.5, False, COLOR_TEXT_DARK)

    # =========================================================================
    # SLIDE 4: ARSITEKTUR CASCADING JAMBIN (DAG)
    # =========================================================================
    slide4 = prs.slides.add_slide(blank_layout)
    add_header(slide4, "Arsitektur Pohon Kinerja Bebas Siklus (DAG Canonical)", "BAB II: KERANGKA SAKIP & CASCADING", 4)

    # Hirarki Vertikal Box (Kiri)
    cx, cy, cw, ch = add_card(slide4, Inches(0.8), Inches(1.4), Inches(6.0), Inches(5.5), "HIERARKI PENJENJANGAN KINERJA CANONICAL", COLOR_WHITE, COLOR_SKY_BLUE, COLOR_NAVY_DARK)
    tb4 = slide4.shapes.add_textbox(cx, cy, cw, ch)
    tf4 = tb4.text_frame
    tf4.word_wrap = True
    add_bullet(tf4, "LEVEL 1: Sasaran Strategis (SS)", "2 SS Makro Bidang Pembinaan (Akuntabilitas & Transformasi Tata Kelola).", 9.5, True)
    add_bullet(tf4, "LEVEL 2: Indikator Strategis (IKSS)", "2 IKSS Makro (Nilai SAKIP & Indeks Reformasi Birokrasi dari KemenPAN-RB).", 9.5)
    add_bullet(tf4, "LEVEL 3: Sasaran Program (SP)", "12 Sasaran Program prioritas JAMBIN yang diampu oleh Para Kepala Biro / Pusat.", 9.5)
    add_bullet(tf4, "LEVEL 4: Indikator Program (IKP)", "20 Indikator Kinerja Program sebagai tolok ukur keberhasilan sasaran program.", 9.5)
    add_bullet(tf4, "LEVEL 5: Sasaran Kegiatan (SK)", "35 Sasaran Kegiatan operasional pada 10 Unit Kerja Eselon II JAMBIN.", 9.5)
    add_bullet(tf4, "LEVEL 6: Indikator Kegiatan (IKK)", "97 IKK Output langsung tempat para Operator Satker menginput data triwulanan.", 9.5)

    # Prinsip Penting Box (Kanan)
    cx, cy, cw, ch = add_card(slide4, Inches(7.0), Inches(1.4), Inches(5.5), Inches(5.5), "3 PRINSIP BAKU ENGINE E-LAPTRI", COLOR_BLUE_LIGHT, COLOR_SKY_BLUE, COLOR_SKY_BLUE)
    tb4_r = slide4.shapes.add_textbox(cx, cy, cw, ch)
    tf4_r = tb4_r.text_frame
    tf4_r.word_wrap = True
    add_bullet(tf4_r, "1. Dilarang Generic Average:", "Sistem TIDAK PERNAH merata-ratakan seluruh child secara otomatis. Kalkulasi hanya berjalan jika ada relasi FORMULA_COMPONENT.", 10, True, COLOR_NAVY_DARK)
    add_bullet(tf4_r, "2. Bebas Siklus (No Cycle Loop):", "GraphValidator memastikan tidak ada hubungan melingkar (A memanggil B, B memanggil A) yang memicu crash kalkulasi.", 10, False, COLOR_NAVY_DARK)
    add_bullet(tf4_r, "3. Relasi Lintas-Program:", "Mendukung hubungan analitis langsung dari IKSS ke SK/IKK tertentu tanpa terikat struktur linier pohon konvensional.", 10, False, COLOR_NAVY_DARK)

    # =========================================================================
    # SLIDE 5: PETA 10 UNIT KERJA ESELON II
    # =========================================================================
    slide5 = prs.slides.add_slide(blank_layout)
    add_header(slide5, "Peta Distribusi 10 Satuan Kerja Eselon II JAMBIN", "BAB I: DISTRIBUSI PENGGUNA", 5)

    satkers = [
        ("SET", "Sekretariat JAMBIN", "set.jambin", "3 SK / 7 IKK", "Tata kelola pimpinan & koordinasi"),
        ("REN", "Biro Perencanaan", "ro.ren", "4 SK / 12 IKK", "Perencanaan anggaran & SAKIP"),
        ("PEG", "Biro Kepegawaian", "ro.peg", "5 SK / 16 IKK", "Manajemen talenta ASN & diklat"),
        ("KEU", "Biro Keuangan", "ro.keu", "4 SK / 14 IKK", "Realisasi anggaran & LK UAPA"),
        ("KAP", "Biro Perlengkapan", "ro.kap", "4 SK / 11 IKK", "Pengadaan barang/jasa & BMN"),
        ("HLN", "Biro Hukum & Hublu", "ro.huk.hln", "3 SK / 8 IKK", "Harmonisasi regulasi & MoU LN"),
        ("UMUM", "Biro Umum", "ro.umum", "3 SK / 9 IKK", "Kerumahtanggaan & fasilitas"),
        ("PDTI", "Pusdaskrimti", "pusdaskrimti", "4 SK / 10 IKK", "Infrastruktur IT & Satu Data"),
        ("PSKPH", "Pustrajakgakum", "pustrajakgakum", "2 SK / 5 IKK", "Kajian strategi & policy brief"),
        ("PKY", "Pusat Kesehatan Yustisial", "pky", "3 SK / 5 IKK", "Layanan RS Adhyaksa & medis")
    ]

    for i, (code, name, usr, vol, scope) in enumerate(satkers):
        col = i % 5
        row = i // 5
        sx = Inches(0.8 + col * 2.38)
        sy = Inches(1.4 + row * 2.7)
        cx, cy, cw, ch = add_card(slide5, sx, sy, Inches(2.28), Inches(2.5), code, COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
        tb = slide5.shapes.add_textbox(cx, cy, cw, ch)
        tf = tb.text_frame
        tf.word_wrap = True
        add_bullet(tf, name, "", 8.5, True, COLOR_NAVY_DARK)
        add_bullet(tf, "User:", usr, 8, False, COLOR_SKY_BLUE)
        add_bullet(tf, "Beban:", vol, 8, False, COLOR_AMBER_DARK)
        add_bullet(tf, "Fokus:", scope, 7.5, False, COLOR_TEXT_MUTED)

    # =========================================================================
    # SLIDE 6: MANAJEMEN PERAN & AKUN (RBAC)
    # =========================================================================
    slide6 = prs.slides.add_slide(blank_layout)
    add_header(slide6, "Manajemen Peran Pengguna & Batas Kewenangan (RBAC)", "BAB III: HAK AKSES & KEAMANAN", 6)

    cx, cy, cw, ch = add_card(slide6, Inches(0.8), Inches(1.4), Inches(5.7), Inches(5.5), "OPERATOR SATKER ESELON II", COLOR_EMERALD_LIGHT, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb6_l = slide6.shapes.add_textbox(cx, cy, cw, ch)
    tf6_l = tb6_l.text_frame
    tf6_l.word_wrap = True
    add_bullet(tf6_l, "1. Input Data Pengukuran:", "Menginput variabel mentah pembilang (X1) dan penyebut (X2) untuk IKK di bawah satkernya.", 10, True)
    add_bullet(tf6_l, "2. Unggah Evidence:", "Melampirkan bukti dukung fisik digital (PDF/DOCX/JPG) yang sah untuk setiap realisasi angka.", 10)
    add_bullet(tf6_l, "3. Isi Lembar Kendala:", "Menyusun analisis capaian, hambatan teknis, dan rencana tindak lanjut triwulanan.", 10)
    add_bullet(tf6_l, "4. Submit Data ke JAMBIN:", "Mengunci form dan mengajukan laporan triwulanan secara resmi ke verifikator pusat.", 10)
    add_bullet(tf6_l, "5. Tindak Lanjut Revisi:", "Memperbaiki angka/dokumen apabila verifikator meminta revisi atas data yang diajukan.", 10)

    cx, cy, cw, ch = add_card(slide6, Inches(6.8), Inches(1.4), Inches(5.7), Inches(5.5), "VERIFIKATOR & ADMIN JAMBIN PUSAT", COLOR_BLUE_LIGHT, COLOR_SKY_BLUE, COLOR_NAVY_DARK)
    tb6_r = slide6.shapes.add_textbox(cx, cy, cw, ch)
    tf6_r = tb6_r.text_frame
    tf6_r.word_wrap = True
    add_bullet(tf6_r, "1. Pemantauan Nasional:", "Memonitor kepatuhan dan capaian 10 Satker Eselon II secara waktu nyata (real-time).", 10, True)
    add_bullet(tf6_r, "2. Audit & Verifikasi Angka:", "Memeriksa kesesuaian input pembilang/penyebut terhadap berkas evidence yang diunggah.", 10)
    add_bullet(tf6_r, "3. Approval / Permintaan Revisi:", "Menyetujui data (APPROVED) atau mengembalikan form disertai catatan koreksi resmi.", 10)
    add_bullet(tf6_r, "4. Formula & Template Builder:", "Mengelola 119 rumus resmi dan mengatur master template dokumen Word LKjIP SAKIP.", 10)
    add_bullet(tf6_r, "5. Penerbitan Dokumen Final:", "Mengekspor Laporan LKjIP triwulanan final untuk diserahkan kepada Jaksa Agung Muda.", 10)

    # =========================================================================
    # SLIDE 7: LOGIN & AUTENTIKASI SISTEM
    # =========================================================================
    slide7 = prs.slides.add_slide(blank_layout)
    add_header(slide7, "Prosedur Login & Autentikasi Sistem E-LAPTRI", "BAB III: HAK AKSES & KEAMANAN", 7)

    # Gambar Screenshot (Kiri)
    add_screenshot_frame(slide7, "01_login_page.png", Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), "Antarmuka Login Resmi Portal E-LAPTRI")

    # Panduan Langkah (Kanan)
    cx, cy, cw, ch = add_card(slide7, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "PANDUAN LOGIN BAGI OPERATOR", COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb7 = slide7.shapes.add_textbox(cx, cy, cw, ch)
    tf7 = tb7.text_frame
    tf7.word_wrap = True
    add_bullet(tf7, "[1] Username Satker:", "Ketik username akun satker resmi Anda (misal: ro.ren, ro.keu, ro.peg). Gunakan huruf kecil tanpa spasi.", 10, True)
    add_bullet(tf7, "[2] Kata Sandi:", "Ketik kata sandi kedinasan Anda. Karakter disamarkan demi keamanan saat bekerja bersama tim.", 10)
    add_bullet(tf7, "[3] Tombol Masuk:", "Klik Masuk ke Sistem. Sistem secara otomatis membaca peran Anda dan membuka Dashboard Satker.", 10)
    add_bullet(tf7, "Proteksi Rate Limiting:", "Salah kata sandi lebih dari 5 kali akan mengunci akun sementara selama 60 detik demi mencegah brute-force.", 9.5, False, COLOR_RED_DARK)
    add_bullet(tf7, "Lupa Password:", "Segera hubungi Helpdesk Pusdaskrimti untuk verifikasi identitas dan permohonan reset password kedinasan.", 9.5, False, COLOR_TEXT_MUTED)

    # =========================================================================
    # SLIDE 8: PROFIL PENGGUNA & GANTI PASSWORD
    # =========================================================================
    slide8 = prs.slides.add_slide(blank_layout)
    add_header(slide8, "Manajemen Profil Akun & Keamanan Kata Sandi", "BAB III: HAK AKSES & KEAMANAN", 8)

    add_screenshot_frame(slide8, "06_profile_page.png", Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), "Formulir Pengaturan Profil & Ganti Kata Sandi")

    cx, cy, cw, ch = add_card(slide8, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "PROTOKOL KEAMANAN AKUN", COLOR_WHITE, COLOR_SKY_BLUE, COLOR_NAVY_DARK)
    tb8 = slide8.shapes.add_textbox(cx, cy, cw, ch)
    tf8 = tb8.text_frame
    tf8.word_wrap = True
    add_bullet(tf8, "1. Akses Menu Profil:", "Klik foto / nama satuan kerja di pojok kanan atas bilah navigasi, lalu pilih 'Profil'.", 10, True)
    add_bullet(tf8, "2. Ganti Password Berkala:", "Disarankan mengganti kata sandi setiap awal triwulan atau setelah adanya pergantian personil PIC satker.", 10)
    add_bullet(tf8, "3. Standar Sandi Kuat:", "Gunakan minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan karakter khusus.", 10)
    add_bullet(tf8, "4. Session Timeout 120 Menit:", "Sistem otomatis logout setelah 120 menit tidak ada aktivitas. Lindungi data saat meninggalkan meja kerja.", 10, False, COLOR_AMBER_DARK)
    add_bullet(tf8, "5. Akun Melekat pada Unit:", "Akun melekat pada nomenklatur biro/pusat, bukan perorangan. Wajib serah terima resmi saat mutasi pegawai.", 9.5, False, COLOR_TEXT_MUTED)

    # =========================================================================
    # SLIDE 9: TOUR DASHBOARD OPERATOR
    # =========================================================================
    slide9 = prs.slides.add_slide(blank_layout)
    add_header(slide9, "Tour Antarmuka Dashboard Operator Satker", "BAB IV: MONITORING KINERJA", 9)

    add_screenshot_frame(slide9, "02_operator_dashboard.png", Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), "Dashboard Kinerja Operator Satker Eselon II")

    cx, cy, cw, ch = add_card(slide9, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "ANATOMI WIDGET DASHBOARD", COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb9 = slide9.shapes.add_textbox(cx, cy, cw, ch)
    tf9 = tb9.text_frame
    tf9.word_wrap = True
    add_bullet(tf9, "[1] Kartu Ringkasan Indikator:", "Menampilkan total Sasaran Kegiatan (SK) dan Indikator Kinerja Kegiatan (IKK) yang diampu oleh satker.", 10, True)
    add_bullet(tf9, "[2] Progress Bar Pengisian:", "Persentase kelengkapan pengisian data variabel mentah terhadap total indikator yang wajib dilaporkan.", 10)
    add_bullet(tf9, "[3] Filter Tahun & Triwulan:", "Dropdown untuk berpindah periode pelaporan aktif (Tahun 2025-2029 dan Triwulan I s.d. IV).", 10)
    add_bullet(tf9, "[4] Banner Status Pelaporan:", "Menandai posisi data saat ini: DRAFT (bisa diedit), SUBMITTED (menunggu audit), atau APPROVED (selesai).", 10)
    add_bullet(tf9, "Aksi Cepat:", "Klik tombol hijau 'Input Data Kinerja' di sidebar samping untuk segera mengisi indikator yang belum lengkap.", 9.5, False, COLOR_EMERALD_MED)

    # =========================================================================
    # SLIDE 10: GRAFIK KINERJA & TREN
    # =========================================================================
    slide10 = prs.slides.add_slide(blank_layout)
    add_header(slide10, "Visualisasi Grafik Capaian & Analisis Tren Kinerja", "BAB IV: MONITORING KINERJA", 10)

    add_screenshot_frame(slide10, "02b_operator_dashboard_charts.png", Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), "Visualisasi Donut Chart & Bar Chart Realisasi vs Target")

    cx, cy, cw, ch = add_card(slide10, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "MEMBACA 4 ZONA WARNA CAPAIAN", COLOR_WHITE, COLOR_SKY_BLUE, COLOR_NAVY_DARK)
    tb10 = slide10.shapes.add_textbox(cx, cy, cw, ch)
    tf10 = tb10.text_frame
    tf10.word_wrap = True
    add_bullet(tf10, "1. Zona Hijau (≥ 100%):", "Tercapai / Melebihi Target. Menunjukkan kegiatan operasional berjalan sangat efektif sesuai rencana.", 9.5, True, COLOR_EMERALD_MED)
    add_bullet(tf10, "2. Zona Biru (80% - 99%):", "On Track / Baik. Progres kegiatan berada pada jalur target yang diharapkan.", 9.5, False, COLOR_SKY_BLUE)
    add_bullet(tf10, "3. Zona Kuning (50% - 79%):", "Perhatian Khusus. Diperlukan percepatan penyerapan anggaran atau mitigasi hambatan teknis.", 9.5, False, COLOR_AMBER_DARK)
    add_bullet(tf10, "4. Zona Merah (< 50%):", "Kritis. Realisasi sangat rendah; wajib melampirkan narasi kendala mendalam dan solusi mitigasi.", 9.5, False, COLOR_RED_DARK)
    add_bullet(tf10, "Bar Chart Target vs Realisasi:", "Membandingkan langsung target resmi KEPJA (abu-abu) dengan realisasi riil (biru) untuk tiap kode IKK.", 9.5, False, COLOR_TEXT_MUTED)

    # =========================================================================
    # SLIDE 11: JADWAL & SIKLUS PELAPORAN
    # =========================================================================
    slide11 = prs.slides.add_slide(blank_layout)
    add_header(slide11, "Jadwal Siklus Pelaporan Kinerja Triwulan I - IV", "BAB IV: SIKLUS PELAPORAN", 11)

    schedules = [
        ("TRIWULAN I", "1 Jan - 31 Mar", "10 April (23.59 WIB)", "Kesiapan awal kegiatan, lelang pengadaan, dan serapan awal DIPA."),
        ("TRIWULAN II", "1 Jan - 30 Jun", "10 Juli (23.59 WIB)", "Evaluasi semester I, reviu capaian tengah tahun, dan percepatan output."),
        ("TRIWULAN III", "1 Jan - 30 Sep", "10 Oktober (23.59 WIB)", "Akselerasi kegiatan prioritas, penyelesaian kendala serapan anggaran."),
        ("TRIWULAN IV", "1 Jan - 31 Des", "15 Januari (Tahun Depan)", "Laporan Tahunan Akuntabilitas Kinerja (LKjIP Final JAMBIN)")
    ]

    for i, (q_name, q_span, q_dl, q_focus) in enumerate(schedules):
        qx = Inches(0.8 + i * 2.95)
        cx, cy, cw, ch = add_card(slide11, qx, Inches(1.4), Inches(2.85), Inches(4.3), q_name, COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
        tb = slide11.shapes.add_textbox(cx, cy, cw, ch)
        tf = tb.text_frame
        tf.word_wrap = True
        add_bullet(tf, "Cakupan:", q_span, 9.5, True, COLOR_NAVY_DARK)
        add_bullet(tf, "Tenggat Waktu:", q_dl, 9.5, False, COLOR_RED_DARK)
        add_bullet(tf, "Fokus:", q_focus, 9, False, COLOR_TEXT_MUTED)

    # Alert Box Bawah
    create_shape(slide11, MSO_SHAPE.ROUNDED_RECTANGLE, Inches(0.8), Inches(5.9), Inches(11.733), Inches(1.0), COLOR_RED_LIGHT, COLOR_RED_DARK, Pt(1))
    alert_tb = slide11.shapes.add_textbox(Inches(1.0), Inches(5.95), Inches(11.333), Inches(0.9))
    tf_a = alert_tb.text_frame
    tf_a.word_wrap = True
    p_a1 = tf_a.paragraphs[0]
    p_a1.text = "PERINGATAN DISIPLIN PENGISIAN DATA:"
    p_a1.font.bold = True
    p_a1.font.size = Pt(10)
    p_a1.font.color.rgb = COLOR_RED_DARK
    p_a2 = tf_a.add_paragraph()
    p_a2.text = "Sistem secara otomatis mengunci formulir input pada pukul 23.59 WIB di tanggal batas akhir. Satker yang belum melakukan submit akan tercatat sebagai 'Non-Compliant' pada laporan rekapitulasi ke pimpinan JAMBIN."
    p_a2.font.size = Pt(9)
    p_a2.font.color.rgb = COLOR_TEXT_DARK

    # =========================================================================
    # SLIDE 12: FORMULIR INPUT DATA DINAMIS
    # =========================================================================
    slide12 = prs.slides.add_slide(blank_layout)
    add_header(slide12, "Formulir Input Data Dinamis & Tab Navigasi", "BAB V: PANDUAN INPUT PENGUKURAN", 12)

    add_screenshot_frame(slide12, "03_input_data_sp.png", Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), "Antarmuka Input Pengukuran Kinerja Tingkat SP dan SK")

    cx, cy, cw, ch = add_card(slide12, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "CARA MENGOPERASIKAN FORMULIR", COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb12 = slide12.shapes.add_textbox(cx, cy, cw, ch)
    tf12 = tb12.text_frame
    tf12.word_wrap = True
    add_bullet(tf12, "[1] Selector Periode:", "Pastikan Tahun dan Triwulan yang dipilih telah sesuai sebelum mengisi.", 10, True)
    add_bullet(tf12, "[2] Tab Sasaran Program (SP):", "Klik tab SP untuk melihat kelompok program yang menjadi mandat satker Anda.", 10)
    add_bullet(tf12, "[3] Accordion Sasaran Kegiatan (SK):", "Klik baris SK untuk membuka kartu-kartu Indikator Kinerja Kegiatan (IKK) di bawahnya.", 10)
    add_bullet(tf12, "[4] Indikator Input Enabled:", "Kotak input hanya terbuka untuk indikator yang menjadi kewenangan satker Anda.", 10)
    add_bullet(tf12, "[5] Badge Kelengkapan:", "Status berubah dari 'Belum Lengkap' (merah) menjadi 'Lengkap' (hijau) setelah seluruh variabel terisi.", 10)

    # =========================================================================
    # SLIDE 13: PENGISIAN RUMUS RASIO (X1 & X2)
    # =========================================================================
    slide13 = prs.slides.add_slide(blank_layout)
    add_header(slide13, "Pengisian Variabel Mentah Rumus Rasio (X1 & X2)", "BAB V: PANDUAN INPUT PENGUKURAN", 13)

    add_screenshot_frame(slide13, "04_input_data_details.png", Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), "Kartu Input Variabel Pembilang (X1) dan Penyebut (X2)")

    cx, cy, cw, ch = add_card(slide13, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "ATURAN INPUT VARIABEL MENTAH", COLOR_WHITE, COLOR_SKY_BLUE, COLOR_NAVY_DARK)
    tb13 = slide13.shapes.add_textbox(cx, cy, cw, ch)
    tf13 = tb13.text_frame
    tf13.word_wrap = True
    add_bullet(tf13, "DILARANG KETIK PERSEN LANGSUNG:", "Operator dilarang langsung mengetik '90%'. Wajib memasukkan angka riil pembilang dan penyebut.", 10, True, COLOR_RED_DARK)
    add_bullet(tf13, "[1] Pembilang (X1 / Numerator):", "Capaian output riil triwulan (contoh: 450 pegawai telah mengikuti diklat).", 10)
    add_bullet(tf13, "[2] Penyebut (X2 / Denominator):", "Total target/populasi beban kerja (contoh: total 500 pegawai wajib diklat).", 10)
    add_bullet(tf13, "[3] Live Preview Realisasi:", "Sistem otomatis menghitung: (450 / 500) x 100% = 90.00%. Hasil tampil instan di kartu.", 10, False, COLOR_EMERALD_MED)
    add_bullet(tf13, "Pencegahan Division by Zero:", "Jika penyebut bernilai 0 (kegiatan belum jalan), sistem otomatis mencatat 0.00% tanpa error.", 9.5, False, COLOR_TEXT_MUTED)

    # =========================================================================
    # SLIDE 14: MANDIRI VS AGREGATIF
    # =========================================================================
    slide14 = prs.slides.add_slide(blank_layout)
    add_header(slide14, "Memahami Indikator Mandiri vs Indikator Agregatif", "BAB V: PANDUAN INPUT PENGUKURAN", 14)

    cx, cy, cw, ch = add_card(slide14, Inches(0.8), Inches(1.4), Inches(5.7), Inches(5.5), "INDIKATOR MANDIRI (STANDALONE)", COLOR_BLUE_LIGHT, COLOR_SKY_BLUE, COLOR_NAVY_DARK)
    tb14_l = slide14.shapes.add_textbox(cx, cy, cw, ch)
    tf14_l = tb14_l.text_frame
    tf14_l.word_wrap = True
    add_bullet(tf14_l, "Karakteristik Utama:", "Nilai realisasi bersumber dari pelaksanaan teknis internal 1 satuan kerja saja.", 10.5, True)
    add_bullet(tf14_l, "Ciri pada Antarmuka:", "Kotak input pembilang (X1) dan penyebut (X2) TERBUKA dan berwarna putih bersih.", 10.5)
    add_bullet(tf14_l, "Tindakan Operator:", "Operator satker WAJIB mengisi data numerik dan melampirkan berkas bukti dukung.", 10.5)
    add_bullet(tf14_l, "Contoh Indikator:", "IKK 14.1.1 (Penyusunan RKA-K/L oleh Biro Perencanaan) atau IKK 16.1.1 (Laporan Keuangan oleh Biro Keuangan).", 10, False, COLOR_TEXT_MUTED)

    cx, cy, cw, ch = add_card(slide14, Inches(6.8), Inches(1.4), Inches(5.7), Inches(5.5), "INDIKATOR AGREGATIF / ROLL-UP", COLOR_EMERALD_LIGHT, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb14_r = slide14.shapes.add_textbox(cx, cy, cw, ch)
    tf14_r = tb14_r.text_frame
    tf14_r.word_wrap = True
    add_bullet(tf14_r, "Karakteristik Utama:", "Nilai dihimpun secara otomatis dari konsolidasi multi-indikator atau lintas-satker.", 10.5, True)
    add_bullet(tf14_r, "Ciri pada Antarmuka:", "Kotak input TERKUNCI (abu-abu / disabled) dengan label 'Agregat Otomatis'.", 10.5)
    add_bullet(tf14_r, "Tindakan Operator:", "Operator TIDAK PERLU menginput manual; nilai akan terkalkulasi otomatis setelah anak-anaknya diinput.", 10.5)
    add_bullet(tf14_r, "Contoh Indikator:", "IKP 13.1 (Persentase Kinerja Terpadu JAMBIN) yang merupakan agregat berbobot dari seluruh biro.", 10, False, COLOR_TEXT_MUTED)

    # =========================================================================
    # SLIDE 15: LEMBAR ANALISIS KINERJA
    # =========================================================================
    slide15 = prs.slides.add_slide(blank_layout)
    add_header(slide15, "Penyusunan Lembar Analisis Kinerja, Kendala & Solusi", "BAB V: PANDUAN INPUT PENGUKURAN", 15)

    add_screenshot_frame(slide15, "04b_input_data_analysis.png", Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), "Ruas Form Analisis Kinerja, Kendala dan Tindak Lanjut")

    cx, cy, cw, ch = add_card(slide15, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "3 KOLOM WAJIB EVALUASI SAKIP", COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb15 = slide15.shapes.add_textbox(cx, cy, cw, ch)
    tf15 = tb15.text_frame
    tf15.word_wrap = True
    add_bullet(tf15, "[1] Analisis Keberhasilan:", "Uraikan faktor kunci yang mendukung ketercapaian target (misal: akselerasi digital, koordinasi aktif).", 10, True)
    add_bullet(tf15, "[2] Identifikasi Kendala:", "Jelaskan secara objektif hambatan yang menyebabkan deviasi (misal: keterlambatan regulasi teknis).", 10)
    add_bullet(tf15, "[3] Rencana Tindak Lanjut:", "Langkah konkret perbaikan pada triwulan berikutnya (misal: revisi DIPA atau percepatan bimtek).", 10)
    add_bullet(tf15, "Masuk Otomatis ke LKjIP:", "Teks narasi yang Anda ketik akan diserap langsung ke Bab III Laporan LKjIP JAMBIN Word resmi.", 9.5, False, COLOR_AMBER_DARK)
    add_bullet(tf15, "Gunakan Bahasa Kedinasan:", "Tuliskan uraian yang terukur, faktual, dan hindari kalimat berulang tanpa makna.", 9.5, False, COLOR_TEXT_MUTED)

    # =========================================================================
    # SLIDE 16: UPLOAD EVIDENCE & AUTOSAVE
    # =========================================================================
    slide16 = prs.slides.add_slide(blank_layout)
    add_header(slide16, "Unggah Bukti Dukung (Evidence) & Fitur Autosave", "BAB V: PANDUAN INPUT PENGUKURAN", 16)

    cx, cy, cw, ch = add_card(slide16, Inches(0.8), Inches(1.4), Inches(5.7), Inches(5.5), "STANDAR BUKTI DUKUNG SAH (EVIDENCE)", COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb16_l = slide16.shapes.add_textbox(cx, cy, cw, ch)
    tf16_l = tb16_l.text_frame
    tf16_l.word_wrap = True
    add_bullet(tf16_l, "1. Format Berkas Sah:", "Format PDF, DOCX, XLSX, atau JPG resmi yang telah bertanda tangan pejabat dan berstempel dinas.", 10, True)
    add_bullet(tf16_l, "2. Batas Ukuran Berkas:", "Maksimal 10 MB per dokumen (atau 15 MB untuk arsip ZIP jika bukti terdiri dari banyak sertifikat).", 10)
    add_bullet(tf16_l, "3. Relevansi Angka:", "Isi dokumen bukti WAJIB mencerminkan angka riil pada variabel pembilang (X1) yang Anda inputkan.", 10)
    add_bullet(tf16_l, "4. Penamaan Berkas Teratur:", "Gunakan format nama jelas: BAST_Pengadaan_TW1_RoKap.pdf atau SK_Mutasi_TW2_RoPeg.pdf.", 10)

    cx, cy, cw, ch = add_card(slide16, Inches(6.8), Inches(1.4), Inches(5.7), Inches(5.5), "MEKANISME AUTOSAVE DI LATAR BELAKANG", COLOR_BLUE_LIGHT, COLOR_SKY_BLUE, COLOR_NAVY_DARK)
    tb16_r = slide16.shapes.add_textbox(cx, cy, cw, ch)
    tf16_r = tb16_r.text_frame
    tf16_r.word_wrap = True
    add_bullet(tf16_r, "1. Debounce 1.5 Detik:", "Sistem menyimpan data secara otomatis 1.5 detik setelah operator berhenti mengetik angka atau narasi.", 10, True)
    add_bullet(tf16_r, "2. Tanpa Reload Halaman:", "Penyimpanan berlangsung di latar belakang (AJAX asinkron), tidak mengganggu alur pengetikan Anda.", 10)
    add_bullet(tf16_r, "3. Indikator Status Awan:", "Perhatikan ikon status di pojok kanan kartu: 'Menyimpan...' (kuning) -> 'Tersimpan Otomatis' (hijau).", 10)
    add_bullet(tf16_r, "4. Aman Saat Putus Koneksi:", "Data tidak akan hilang jika peramban tidak sengaja tertutup saat pengetikan berlangsung.", 10, False, COLOR_EMERALD_MED)

    # =========================================================================
    # SLIDE 17: FINALISASI & PROSEDUR SUBMIT
    # =========================================================================
    slide17 = prs.slides.add_slide(blank_layout)
    add_header(slide17, "Finalisasi Data & Prosedur Submit ke JAMBIN", "BAB V: FINALISASI LAPORAN", 17)

    # Box Gambar Sticky Bar
    create_shape(slide17, MSO_SHAPE.ROUNDED_RECTANGLE, Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), COLOR_SLATE_DARK, COLOR_AMBER, Pt(1))
    bar_tb = slide17.shapes.add_textbox(Inches(1.0), Inches(1.6), Inches(6.1), Inches(4.7))
    tf_bar = bar_tb.text_frame
    tf_bar.word_wrap = True
    p = tf_bar.paragraphs[0]
    p.text = "STICKY ACTION BAR (PENGUNCI LAPORAN)"
    p.font.bold = True
    p.font.size = Pt(13)
    p.font.color.rgb = COLOR_AMBER

    add_bullet(tf_bar, "Validasi Kelengkapan:", "Bilah melayang menampilkan indikator: '16 dari 16 Indikator Terisi (100%)'.", 10.5, False, COLOR_WHITE)
    add_bullet(tf_bar, "Tombol Simpan Draf:", "Menyimpan seluruh progres tanpa mengunci form jika Anda masih ingin melengkapi bukti.", 10.5, False, COLOR_BORDER)
    add_bullet(tf_bar, "Tombol Ajukan ke JAMBIN:", "Mengirimkan data ke antrean verifikator Biro Perencanaan untuk diaudit.", 10.5, False, COLOR_EMERALD_MED)
    add_bullet(tf_bar, "Penguncian Form:", "Setelah tombol submit ditekan, formulir otomatis terkunci (read-only mode).", 10.5, False, COLOR_AMBER)

    cx, cy, cw, ch = add_card(slide17, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "4 TAHAP PROSEDUR SUBMIT", COLOR_WHITE, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb17 = slide17.shapes.add_textbox(cx, cy, cw, ch)
    tf17 = tb17.text_frame
    tf17.word_wrap = True
    add_bullet(tf17, "Langkah 1: Periksa Progress Bar", "Pastikan progress bar pengisian telah mencapai 100% dan tidak ada IKK berstatus merah.", 10, True)
    add_bullet(tf17, "Langkah 2: Klik Ajukan ke JAMBIN", "Klik tombol hijau 'Ajukan ke JAMBIN (Submit Data)'. Modal konfirmasi akan muncul.", 10)
    add_bullet(tf17, "Langkah 3: Pernyataan Integritas", "Centang pernyataan kebenaran data dan keabsahan berkas bukti dukung yang diunggah.", 10)
    add_bullet(tf17, "Langkah 4: Konfirmasi Terkirim", "Status berubah menjadi SUBMITTED. Verifikator pusat segera menerima notifikasi audit.", 10)

    # =========================================================================
    # SLIDE 18: ALUR VERIFIKASI & REVISI
    # =========================================================================
    slide18 = prs.slides.add_slide(blank_layout)
    add_header(slide18, "Alur Pemeriksaan, Approval & Penanganan Revisi Data", "BAB VI: VERIFIKASI & AUDIT", 18)

    add_screenshot_frame(slide18, "08_review_data_index.png", Inches(0.8), Inches(1.4), Inches(6.5), Inches(5.1), "Modul Review DataGrid Tempat Verifikator Mengaudit Kinerja")

    cx, cy, cw, ch = add_card(slide18, Inches(7.5), Inches(1.4), Inches(5.0), Inches(5.5), "2 KEMUNGKINAN HASIL AUDIT", COLOR_WHITE, COLOR_SKY_BLUE, COLOR_NAVY_DARK)
    tb18 = slide18.shapes.add_textbox(cx, cy, cw, ch)
    tf18 = tb18.text_frame
    tf18.word_wrap = True
    add_bullet(tf18, "STATUS A: APPROVED (Disetujui)", "Data valid dan berkas lengkap. Nilai otomatis di-roll-up ke capaian makro JAMBIN dan siap di-generate ke Word LKjIP.", 10, True, COLOR_EMERALD_DARK)
    add_bullet(tf18, "STATUS B: REVISI (Perlu Perbaikan)", "Ditemukan ketidakcocokan angka pembilang/penyebut atau berkas dukung kurang. Verifikator memberikan catatan koreksi.", 10, False, COLOR_RED_DARK)
    add_bullet(tf18, "Form Terbuka Kembali (Unfreeze):", "Saat status revisi aktif, formulir satker Anda otomatis terbuka kembali untuk disunting.", 9.5, False, COLOR_TEXT_DARK)
    add_bullet(tf18, "Batas Waktu Revisi 2x24 Jam:", "Operator wajib menyelesaikan koreksi dan mengklik submit ulang maksimal 2 hari kerja.", 9.5, False, COLOR_AMBER_DARK)

    # =========================================================================
    # SLIDE 19: TIPS SUKSES & HAL YANG WAJIB DIHINDARI
    # =========================================================================
    slide19 = prs.slides.add_slide(blank_layout)
    add_header(slide19, "Tips Sukses & Hal-Hal yang Wajib Dihindari Operator", "BAB IX: PANDUAN PRAKTIS OPERATOR", 19)

    cx, cy, cw, ch = add_card(slide19, Inches(0.8), Inches(1.4), Inches(5.7), Inches(5.5), "TIPS SUKSES OPERATOR (DO'S)", COLOR_EMERALD_LIGHT, COLOR_EMERALD_MED, COLOR_EMERALD_DARK)
    tb19_l = slide19.shapes.add_textbox(cx, cy, cw, ch)
    tf19_l = tb19_l.text_frame
    tf19_l.word_wrap = True
    add_bullet(tf19_l, "1. Siapkan Berkas Sejak Dini:", "Kumpulkan dokumen BAST, SPK, dan DIPA sebelum triwulan berakhir agar input cepat.", 10, True)
    add_bullet(tf19_l, "2. Teliti Angka Mentah:", "Pastikan angka pembilang cocok persis dengan lampiran bukti dukung.", 10)
    add_bullet(tf19_l, "3. Narasi Kendala Realistis:", "Tuliskan kendala riil dan rencana mitigasi yang konkret untuk bahan laporan pimpinan.", 10)
    add_bullet(tf19_l, "4. Submit H-2 Batas Waktu:", "Jangan menunggu menit-menit akhir untuk menghindari antrean jaringan internet kedinasan.", 10)

    cx, cy, cw, ch = add_card(slide19, Inches(6.8), Inches(1.4), Inches(5.7), Inches(5.5), "HAL WAJIB DIHINDARI (DON'TS)", COLOR_RED_LIGHT, COLOR_RED_DARK, COLOR_RED_DARK)
    tb19_r = slide19.shapes.add_textbox(cx, cy, cw, ch)
    tf19_r = tb19_r.text_frame
    tf19_r.word_wrap = True
    add_bullet(tf19_r, "1. Mengetik Persen Langsung:", "Dilarang memaksakan input persen jika formulir meminta variabel X1 dan X2.", 10, True)
    add_bullet(tf19_r, "2. Upload Berkas Tanpa Tanda Tangan:", "Hindari mengunggah draf dokumen yang belum bertanda tangan dan cap resmi dinas.", 10)
    add_bullet(tf19_r, "3. Mengosongkan Narasi Kendala:", "Jika capaian di bawah 100%, wajib mengisi kolom hambatan dan rencana tindak lanjut.", 10)
    add_bullet(tf19_r, "4. Membiarkan Akun Terkunci:", "Jangan membagikan kredensial login kepada pihak di luar tim pelaksana kinerja satker.", 10)

    # =========================================================================
    # SLIDE 20: PENUTUP & TANYA JAWAB
    # =========================================================================
    slide20 = prs.slides.add_slide(blank_layout)
    create_shape(slide20, MSO_SHAPE.RECTANGLE, Inches(0), Inches(0), Inches(13.333), Inches(7.5), COLOR_NAVY_DARK)

    # Big Center Banner
    center_box = slide20.shapes.add_textbox(Inches(1.5), Inches(1.0), Inches(10.333), Inches(2.2))
    tf20_c = center_box.text_frame
    tf20_c.word_wrap = True
    p1 = tf20_c.paragraphs[0]
    p1.alignment = PP_ALIGN.CENTER
    p1.text = "TERIMA KASIH"
    p1.font.name = FONT_PRIMARY
    p1.font.size = Pt(40)
    p1.font.bold = True
    p1.font.color.rgb = COLOR_AMBER

    p2 = tf20_c.add_paragraph()
    p2.alignment = PP_ALIGN.CENTER
    p2.text = "Mewujudkan Akuntabilitas Kinerja Bidang Pembinaan yang Transparan & Terpercaya"
    p2.font.name = FONT_PRIMARY
    p2.font.size = Pt(14)
    p2.font.color.rgb = COLOR_WHITE

    p3 = tf20_c.add_paragraph()
    p3.alignment = PP_ALIGN.CENTER
    p3.text = "SESI DISKUSI, TANYA JAWAB & PRAKTIK LANGSUNG"
    p3.font.name = FONT_PRIMARY
    p3.font.size = Pt(12)
    p3.font.bold = True
    p3.font.color.rgb = COLOR_SKY_BLUE

    # 2 Kontak Box
    cx1, cy1, cw1, ch1 = add_card(slide20, Inches(1.5), Inches(3.5), Inches(5.0), Inches(2.5), "HELPDESK SUBSTANSI SAKIP", COLOR_SLATE_DARK, COLOR_AMBER, COLOR_AMBER)
    tb_h1 = slide20.shapes.add_textbox(cx1, cy1, cw1, ch1)
    tf_h1 = tb_h1.text_frame
    tf_h1.word_wrap = True
    add_bullet(tf_h1, "Unit Pengampu:", "Bagian Evaluasi & Pelaporan Kinerja, Biro Perencanaan", 9.5, True, COLOR_WHITE)
    add_bullet(tf_h1, "Layanan:", "Konsultasi indikator, pembetulan target, pembukaan kunci form revisi.", 9, False, COLOR_BORDER)
    add_bullet(tf_h1, "Lokasi:", "Gedung Utama Kejaksaan Agung RI Lt. 6", 9, False, COLOR_AMBER)

    cx2, cy2, cw2, ch2 = add_card(slide20, Inches(6.8), Inches(3.5), Inches(5.0), Inches(2.5), "HELPDESK TEKNIS & SERVER IT", COLOR_SLATE_DARK, COLOR_SKY_BLUE, COLOR_SKY_BLUE)
    tb_h2 = slide20.shapes.add_textbox(cx2, cy2, cw2, ch2)
    tf_h2 = tb_h2.text_frame
    tf_h2.word_wrap = True
    add_bullet(tf_h2, "Unit Pengampu:", "Pusdaskrimti Kejaksaan Agung RI", 9.5, True, COLOR_WHITE)
    add_bullet(tf_h2, "Layanan:", "Kendala akun login, reset password darurat, gangguan jaringan server.", 9, False, COLOR_BORDER)
    add_bullet(tf_h2, "Kontak:", "Ext. 1240 | Email: helpdesk@kejaksaan.go.id", 9, False, COLOR_SKY_BLUE)

    # Footer Leadership
    foot_lead = slide20.shapes.add_textbox(Inches(1.5), Inches(6.3), Inches(10.333), Inches(0.8))
    tf_fl = foot_lead.text_frame
    p_fl = tf_fl.paragraphs[0]
    p_fl.alignment = PP_ALIGN.CENTER
    p_fl.text = "Jaksa Agung Muda Bidang Pembinaan: Dr. HENDRO DEWANTO, S.H., M.Hum. | Tim Penyusun: Tim Efektif"
    p_fl.font.name = FONT_PRIMARY
    p_fl.font.size = Pt(11)
    p_fl.font.bold = True
    p_fl.font.color.rgb = COLOR_WHITE

    print(f"Menyimpan berkas presentasi PowerPoint ke: {OUTPUT_PPTX}...")
    prs.save(OUTPUT_PPTX)

    file_size_mb = os.path.getsize(OUTPUT_PPTX) / (1024 * 1024)
    print(f"SUKSES! Berkas presentasi tercipta: {OUTPUT_PPTX}")
    print(f"Ukuran berkas: {file_size_mb:.2f} MB")
    print(f"Total Slide: {len(prs.slides)} Slide Widescreen (16:9)")
    print("=================================================================")

if __name__ == "__main__":
    main()
