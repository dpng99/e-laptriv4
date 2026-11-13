#!/usr/bin/env python3
r"""
Generator Resmi Suite Identitas Visual & Logo "E-Laptri Pembinaan"
Jaksa Agung Muda Bidang Pembinaan (JAMBIN) — Kejaksaan Republik Indonesia

Arsitektur Desain (Authentic Organic Fusion):
1. Tiga Bintang Segitiga Tri Krama Adhyaksa (6-titik autentik r_in/R = 0.312, tanpa kotak pembungkus).
2. Sayap Kanopi Pembinaan Melengkung Aerodinamis dengan Bevel Masuk (\____ dan ____/).
3. Sembilan Pilar Vertikal Pembinaan (9 pilar simetris berujung V-shield halus) yang berfusi dengan
   Gelombang Kinerja Triwulanan Naik (TW I -> TW II -> TW III -> TW IV) & Pita S-Wave Mengalir.
4. Kompatibilitas SVG Universal: Seluruh <linearGradient> menggunakan gradientUnits="userSpaceOnUse"
   dan teks lockup bebas ketergantungan <tspan> sehingga tampil 100% identik pada Browser, QtSvg,
   PyMuPDF, Inkscape, CorelDRAW, dan MS Word.
"""

import math
from pathlib import Path
from PySide6.QtCore import QByteArray, QRectF
from PySide6.QtGui import QColor, QFont, QFontMetricsF, QGuiApplication, QImage, QPainter
from PySide6.QtSvg import QSvgRenderer
from PIL import Image, ImageFilter

ROOT = Path(__file__).resolve().parent.parent
PUBLIC_DIR = ROOT / "public"
LOGO_DIR = PUBLIC_DIR / "images" / "logo"
LOGO_DIR.mkdir(parents=True, exist_ok=True)


def rounded_polygon_path(pts, radii):
    """Build a smooth closed SVG path from polygon vertices with per-vertex corner rounding."""
    n = len(pts)
    if isinstance(radii, (int, float)):
        radii = [radii] * n
    cmds = []
    for i in range(n):
        p_prev = pts[(i - 1) % n]
        p_curr = pts[i]
        p_next = pts[(i + 1) % n]
        r = radii[i]
        if r <= 0:
            cmds.append(("L" if i > 0 else "M", p_curr))
            continue

        v1x, v1y = p_prev[0] - p_curr[0], p_prev[1] - p_curr[1]
        v2x, v2y = p_next[0] - p_curr[0], p_next[1] - p_curr[1]
        len1 = math.hypot(v1x, v1y)
        len2 = math.hypot(v2x, v2y)
        d = min(r, len1 * 0.45, len2 * 0.45)

        start = (p_curr[0] + (v1x / len1) * d, p_curr[1] + (v1y / len1) * d)
        end = (p_curr[0] + (v2x / len2) * d, p_curr[1] + (v2y / len2) * d)

        cmds.append(("M" if i == 0 else "L", start))
        cmds.append(("Q", p_curr, end))

    parts = []
    for c in cmds:
        if c[0] in ("M", "L"):
            parts.append(f"{c[0]} {c[1][0]:.2f},{c[1][1]:.2f}")
        elif c[0] == "Q":
            parts.append(f"Q {c[1][0]:.2f},{c[1][1]:.2f} {c[2][0]:.2f},{c[2][1]:.2f}")
    parts.append("Z")
    return " ".join(parts)


def tri_star_path(cx, cy, r_out, r_in_ratio=0.312, tip_round=1.2, waist_round=0.7):
    """Authentic 3-pointed Pembinaan Tri Krama Adhyaksa star (measured r_in/R = 0.312)."""
    r_in = r_out * r_in_ratio
    pts = []
    radii = []
    for k in range(6):
        rad = math.radians(k * 60)
        r = r_out if k % 2 == 0 else r_in
        x = cx + r * math.sin(rad)
        y = cy - r * math.cos(rad)
        pts.append((x, y))
        radii.append(tip_round if k % 2 == 0 else waist_round)
    return rounded_polygon_path(pts, radii)


def shield_bottom_y(x):
    """Smooth organic V-chevron bottom contour centered at x=256 inside 512x512."""
    dx = abs(x - 256.0)
    return 488.0 - 0.66 * dx - 0.0006 * (dx ** 2)


def wave_y(x):
    """Exact cubic S-curve centerline from (112, 338) rising smoothly to (400, 288)."""
    t = max(0.0, min(1.0, (x - 112.0) / 288.0))
    s = t * t * (3.0 - 2.0 * t)
    return 338.0 - 50.0 * s


def slanted_pill(xL, xR, yTopL, yTopR, yBotR, yBotL, radii=(4.5, 4.5, 4.5, 4.5)):
    pts = [(xL, yTopL), (xR, yTopR), (xR, yBotR), (xL, yBotL)]
    return rounded_polygon_path(pts, list(radii))


def compute_fusion_geometry():
    """Return dictionary of exact vector path strings for the E-Laptri Pembinaan Fusion Emblem."""
    channel_half = 13.0

    star_top = tri_star_path(256.0, 72.0, 46.5)
    star_left = tri_star_path(147.0, 152.0, 45.0)
    star_right = tri_star_path(365.0, 152.0, 45.0)

    # Left Canopy Wing curving smoothly into Upper Column 4 (x=215..231)
    left_wing = rounded_polygon_path([
        (102.0, 214.0),
        (231.0, 209.0),
        (231.0, wave_y(231.0) - channel_half),
        (215.0, wave_y(215.0) - channel_half),
        (215.0, 227.0),
        (118.0, 230.0),
    ], [2.2, 12.5, 4.2, 4.2, 7.5, 3.5])

    # Right Canopy Wing curving smoothly into Upper Column 6 (x=281..297)
    right_wing = rounded_polygon_path([
        (281.0, 209.0),
        (410.0, 214.0),
        (394.0, 230.0),
        (297.0, 227.0),
        (297.0, wave_y(297.0) - channel_half),
        (281.0, wave_y(281.0) - channel_half),
    ], [12.5, 2.2, 3.5, 7.5, 4.2, 4.2])

    # Center Axis Column 5 (x=248..264)
    center_top = slanted_pill(
        248.0, 264.0, 208.0, 208.0,
        wave_y(264.0) - channel_half, wave_y(248.0) - channel_half,
        (6.0, 6.0, 4.2, 4.2),
    )
    center_bot = rounded_polygon_path([
        (248.0, wave_y(248.0) + channel_half),
        (264.0, wave_y(264.0) + channel_half),
        (264.0, 483.0),
        (256.0, 490.0),
        (248.0, 483.0),
    ], [4.2, 4.2, 4.0, 3.5, 4.0])

    # Lower segments of Column 4 and Column 6
    col4_bot = slanted_pill(
        215.0, 231.0,
        wave_y(215.0) + channel_half, wave_y(231.0) + channel_half,
        shield_bottom_y(231.0), shield_bottom_y(215.0),
        (4.2, 4.2, 4.5, 4.5),
    )
    col6_bot = slanted_pill(
        281.0, 297.0,
        wave_y(281.0) + channel_half, wave_y(297.0) + channel_half,
        shield_bottom_y(297.0), shield_bottom_y(281.0),
        (4.2, 4.2, 4.5, 4.5),
    )

    # Outer 6 Pillars: Columns 1, 2, 3 (left) & Columns 7, 8, 9 (right)
    upper_bars = []
    lower_bars = []
    col_specs = [
        (116.0, 132.0, 245.0),  # Col 1 (TW I)
        (149.0, 165.0, 244.0),  # Col 2
        (182.0, 198.0, 243.0),  # Col 3 (TW II)
        (314.0, 330.0, 243.0),  # Col 7 (TW III)
        (347.0, 363.0, 244.0),  # Col 8
        (380.0, 396.0, 245.0),  # Col 9 (TW IV)
    ]
    for xL, xR, yTop in col_specs:
        upper_bars.append(slanted_pill(
            xL, xR, yTop, yTop,
            wave_y(xR) - channel_half, wave_y(xL) - channel_half,
            (5.0, 5.0, 4.2, 4.2),
        ))
        lower_bars.append(slanted_pill(
            xL, xR,
            wave_y(xL) + channel_half, wave_y(xR) + channel_half,
            shield_bottom_y(xR), shield_bottom_y(xL),
            (4.2, 4.2, 4.5, 4.5),
        ))

    # Pure Analytical 2-Curve Cubic Bezier Silk S-Wave Ribbon (exact match to wave_y(x) from 112->400)
    ribbon = (
        "M 112.00,336.20 "
        "C 208.00,331.50 304.00,281.50 400.00,286.20 "
        "Q 403.60,288.00 400.00,289.80 "
        "C 304.00,294.50 208.00,344.50 112.00,339.80 "
        "Q 108.40,338.00 112.00,336.20 Z"
    )

    return {
        "stars": [star_top, star_left, star_right],
        "upper": [left_wing, right_wing, center_top] + upper_bars,
        "ribbon": ribbon,
        "lower": [col4_bot, center_bot, col6_bot] + lower_bars,
    }


def get_palette(theme="dark"):
    if theme == "light":
        return {
            "gold_stops": [
                ("0%", "#F5B815"),
                ("52%", "#EA980B"),
                ("100%", "#B45309"),
            ],
            "ribbon_stops": [
                ("0%", "#047857"),
                ("48%", "#059669"),
                ("82%", "#10B981"),
                ("100%", "#D97706"),
            ],
            "emerald_stops": [
                ("0%", "#065F46"),
                ("44%", "#047857"),
                ("80%", "#059669"),
                ("100%", "#10B981"),
            ],
            "title_e": "#059669",
            "title_dash": "#D97706",
            "title_main": "#0F172A",
            "pembinaan_g1": "#EA980B",
            "pembinaan_g2": "#B45309",
            "subtitle": "#334155",
            "caption": "#64748B",
            "badge_bg": "#FEF3C7",
            "badge_border": "#F59E0B",
            "badge_text": "#B45309",
            "divider": "#CBD5E1",
        }
    return {
        "gold_stops": [
            ("0%", "#FEF08A"),
            ("42%", "#F5B815"),
            ("100%", "#D97706"),
        ],
        "ribbon_stops": [
            ("0%", "#059669"),
            ("48%", "#10B981"),
            ("80%", "#34D399"),
            ("100%", "#F59E0B"),
        ],
        "emerald_stops": [
            ("0%", "#047857"),
            ("42%", "#059669"),
            ("78%", "#10B981"),
            ("100%", "#34D399"),
        ],
        "title_e": "#34D399",
        "title_dash": "#FBBF24",
        "title_main": "#FFFFFF",
        "pembinaan_g1": "#FDE047",
        "pembinaan_g2": "#F59E0B",
        "subtitle": "#94A3B8",
        "caption": "#64748B",
        "badge_bg": "#451A03",
        "badge_border": "#F59E0B",
        "badge_text": "#FBBF24",
        "divider": "#334155",
    }


def measure_headline_segments(font_px):
    """Measure exact horizontal advance of ('E', '-', 'LAPTRI', 'PEMBINAAN') in Segoe UI Bold/Black."""
    font = QFont("Segoe UI")
    font.setPixelSize(int(font_px))
    font.setWeight(QFont.Black)
    fm = QFontMetricsF(font)
    segs = ["E", "-", "LAPTRI", "PEMBINAAN"]
    widths = [fm.horizontalAdvance(s) for s in segs]
    return segs, widths


def render_mark_defs_and_group(geom, pal, prefix="elp", offset_x=0.0, offset_y=0.0, scale=1.0):
    gold_stops_xml = "\n      ".join(f'<stop offset="{o}" stop-color="{c}" />' for o, c in pal["gold_stops"])
    ribbon_stops_xml = "\n      ".join(f'<stop offset="{o}" stop-color="{c}" />' for o, c in pal["ribbon_stops"])
    emerald_stops_xml = "\n      ".join(f'<stop offset="{o}" stop-color="{c}" />' for o, c in pal["emerald_stops"])

    defs_xml = f"""    <linearGradient id="{prefix}_gold" gradientUnits="userSpaceOnUse" x1="256" y1="25" x2="256" y2="340">
      {gold_stops_xml}
    </linearGradient>
    <linearGradient id="{prefix}_ribbon" gradientUnits="userSpaceOnUse" x1="112" y1="338" x2="400" y2="288">
      {ribbon_stops_xml}
    </linearGradient>
    <linearGradient id="{prefix}_emerald" gradientUnits="userSpaceOnUse" x1="120" y1="488" x2="396" y2="290">
      {emerald_stops_xml}
    </linearGradient>"""

    stars_xml = "\n      ".join(f'<path d="{d}" />' for d in geom["stars"])
    upper_xml = "\n      ".join(f'<path d="{d}" />' for d in geom["upper"])
    lower_xml = "\n      ".join(f'<path d="{d}" />' for d in geom["lower"])

    transform_attr = ""
    if offset_x != 0.0 or offset_y != 0.0 or scale != 1.0:
        transform_attr = f' transform="translate({offset_x:.2f}, {offset_y:.2f}) scale({scale:.4f})"'

    group_xml = f"""  <g{transform_attr}>
    <!-- 3 Bintang Segitiga Tri Krama Adhyaksa & Sayap Kanopi Pembinaan -->
    <g fill="url(#{prefix}_gold)">
      {stars_xml}
      {upper_xml}
    </g>
    <!-- Pita Gelombang Kinerja Triwulanan (Fluid Ascending S-Wave) -->
    <path d="{geom['ribbon']}" fill="url(#{prefix}_ribbon)" />
    <!-- 9 Pilar Kinerja Kejaksaan Emerald -->
    <g fill="url(#{prefix}_emerald)">
      {lower_xml}
    </g>
  </g>"""
    return defs_xml, group_xml


def build_mark_svg(geom, theme="dark", viewbox="0 0 512 512", width=512, height=512):
    pal = get_palette(theme)
    defs_xml, group_xml = render_mark_defs_and_group(geom, pal, prefix=f"m_{theme}")
    return f"""<svg xmlns="http://www.w3.org/2000/svg" viewBox="{viewbox}" width="{width}" height="{height}">
  <defs>
{defs_xml}
  </defs>
{group_xml}
</svg>
"""


def build_app_icon_svg(geom):
    """Optional OS/PWA App Launcher Icon (concentric solid-geometry squircle border for universal SVG support)."""
    pal = get_palette("dark")
    defs_xml, group_xml = render_mark_defs_and_group(geom, pal, prefix="app", offset_x=38.0, offset_y=38.0, scale=0.8516)
    return f"""<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="512" height="512">
  <defs>
    <linearGradient id="app_ring" gradientUnits="userSpaceOnUse" x1="16" y1="16" x2="496" y2="496">
      <stop offset="0%" stop-color="#D97706" />
      <stop offset="50%" stop-color="#059669" />
      <stop offset="100%" stop-color="#047857" />
    </linearGradient>
    <linearGradient id="app_bg" gradientUnits="userSpaceOnUse" x1="20" y1="20" x2="492" y2="492">
      <stop offset="0%" stop-color="#0F172A" />
      <stop offset="60%" stop-color="#0B1324" />
      <stop offset="100%" stop-color="#042F2E" />
    </linearGradient>
{defs_xml}
  </defs>
  <rect x="16" y="16" width="480" height="480" rx="112" fill="url(#app_ring)" />
  <rect x="20" y="20" width="472" height="472" rx="108" fill="url(#app_bg)" />
{group_xml}
</svg>
"""


def build_flat_mark_svg(geom, viewbox="0 0 512 512", width=512, height=512):
    """Solid 2-spot-color institutional vector mark (for stationery, embroidery, stamps, & nanosvg/PyMuPDF)."""
    stars_xml = "\n    ".join(f'<path d="{d}" fill="#F3BE1C" />' for d in geom["stars"])
    upper_xml = "\n    ".join(f'<path d="{d}" fill="#EA980B" />' for d in geom["upper"])
    lower_xml = "\n    ".join(f'<path d="{d}" fill="#059669" />' for d in geom["lower"])
    return f"""<svg xmlns="http://www.w3.org/2000/svg" viewBox="{viewbox}" width="{width}" height="{height}">
  <g>
    {stars_xml}
    {upper_xml}
    <path d="{geom['ribbon']}" fill="#10B981" />
    {lower_xml}
  </g>
</svg>
"""


def build_horizontal_lockup_svg(geom, theme="dark"):
    """Official Horizontal Lockup: Open Fusion Emblem + E-LAPTRI PEMBINAAN Wordmark (1280 x 330)."""
    pal = get_palette(theme)
    defs_xml, group_xml = render_mark_defs_and_group(geom, pal, prefix=f"hz_{theme}", offset_x=16.0, offset_y=21.6, scale=0.56)

    _, widths = measure_headline_segments(62)
    x_e = 352.0
    x_dash = x_e + widths[0] + 1.5
    x_laptri = x_dash + widths[1] + 2.5
    x_pemb = x_laptri + widths[2] + 22.0

    return f"""<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1280 330" width="1280" height="330">
  <defs>
{defs_xml}
    <linearGradient id="hz_pemb_{theme}" gradientUnits="userSpaceOnUse" x1="{x_pemb:.1f}" y1="95" x2="{x_pemb + widths[3]:.1f}" y2="155">
      <stop offset="0%" stop-color="{pal['pembinaan_g1']}" />
      <stop offset="100%" stop-color="{pal['pembinaan_g2']}" />
    </linearGradient>
  </defs>

{group_xml}

  <!-- Subtle Institutional Vertical Divider -->
  <line x1="322" y1="68" x2="322" y2="262" stroke="{pal['divider']}" stroke-width="2" stroke-linecap="round" />

  <!-- Official Lockup Typography (tspan-free for universal SVG/QtSvg/Word compatibility) -->
  <g font-family="'Segoe UI', 'Plus Jakarta Sans', Arial, sans-serif">
    <text x="{x_e:.1f}" y="146" font-size="62" font-weight="800" fill="{pal['title_e']}">E</text>
    <text x="{x_dash:.1f}" y="146" font-size="62" font-weight="800" fill="{pal['title_dash']}">-</text>
    <text x="{x_laptri:.1f}" y="146" font-size="62" font-weight="800" fill="{pal['title_main']}">LAPTRI</text>
    <text x="{x_pemb:.1f}" y="146" font-size="62" font-weight="800" fill="url(#hz_pemb_{theme})">PEMBINAAN</text>

    <!-- JAMBIN Pill Badge -->
    <rect x="354" y="175" width="106" height="32" rx="8" fill="{pal['badge_bg']}" stroke="{pal['badge_border']}" stroke-width="1.5" />
    <text x="407" y="197" font-size="16" font-weight="800" fill="{pal['badge_text']}" text-anchor="middle" letter-spacing="1.5">JAMBIN</text>

    <text x="476" y="198" font-size="22" font-weight="700" fill="{pal['subtitle']}">Sistem Informasi Laporan Kinerja Triwulanan</text>

    <text x="354" y="244" font-size="16" font-weight="700" fill="{pal['caption']}" letter-spacing="2.2">JAKSA AGUNG MUDA BIDANG PEMBINAAN • KEJAKSAAN AGUNG R.I.</text>
  </g>
</svg>
"""


def build_vertical_lockup_svg(geom, theme="dark"):
    """Official Ceremonial Vertical Lockup for LKjIP Covers & Official Presentations (860 x 860)."""
    pal = get_palette(theme)
    defs_xml, group_xml = render_mark_defs_and_group(geom, pal, prefix=f"vt_{theme}", offset_x=199.6, offset_y=28.0, scale=0.90)

    _, widths = measure_headline_segments(54)
    total_w = widths[0] + 1.5 + widths[1] + 2.0 + widths[2] + 19.0 + widths[3]
    x_e = 430.0 - total_w / 2.0
    x_dash = x_e + widths[0] + 1.5
    x_laptri = x_dash + widths[1] + 2.0
    x_pemb = x_laptri + widths[2] + 19.0

    return f"""<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 860 860" width="860" height="860">
  <defs>
{defs_xml}
    <linearGradient id="vt_pemb_{theme}" gradientUnits="userSpaceOnUse" x1="{x_pemb:.1f}" y1="540" x2="{x_pemb + widths[3]:.1f}" y2="600">
      <stop offset="0%" stop-color="{pal['pembinaan_g1']}" />
      <stop offset="100%" stop-color="{pal['pembinaan_g2']}" />
    </linearGradient>
  </defs>

{group_xml}

  <g font-family="'Segoe UI', 'Plus Jakarta Sans', Arial, sans-serif">
    <text x="{x_e:.1f}" y="586" font-size="54" font-weight="800" fill="{pal['title_e']}">E</text>
    <text x="{x_dash:.1f}" y="586" font-size="54" font-weight="800" fill="{pal['title_dash']}">-</text>
    <text x="{x_laptri:.1f}" y="586" font-size="54" font-weight="800" fill="{pal['title_main']}">LAPTRI</text>
    <text x="{x_pemb:.1f}" y="586" font-size="54" font-weight="800" fill="url(#vt_pemb_{theme})">PEMBINAAN</text>
  </g>

  <g font-family="'Segoe UI', 'Plus Jakarta Sans', Arial, sans-serif" text-anchor="middle">
    <text x="430" y="636" font-size="22" font-weight="700" fill="{pal['subtitle']}">Sistem Informasi Laporan Kinerja Triwulanan</text>

    <line x1="270" y1="670" x2="590" y2="670" stroke="{pal['divider']}" stroke-width="2" stroke-linecap="round" />

    <text x="430" y="712" font-size="18" font-weight="800" fill="{pal['badge_text']}" letter-spacing="2.4">JAKSA AGUNG MUDA BIDANG PEMBINAAN</text>

    <text x="430" y="748" font-size="16" font-weight="700" fill="{pal['caption']}" letter-spacing="2.8">KEJAKSAAN AGUNG REPUBLIK INDONESIA</text>
  </g>
</svg>
"""


def build_pembinaan_original_svg():
    r"""
    100% Authentic Vectorization of the Official Logo Pembinaan Kejaksaan RI (JAMBIN):
    - 3 crisp 6-vertex 3-pointed stars (r_in/R = 0.312)
    - Inward-beveled canopy wings (\____ and ____/)
    - 9 symmetrical vertical pillars tapering to V-chevron bottom in authentic Pembinaan Gold (#F3BE1C)
    """
    star_top = tri_star_path(256.0, 72.0, 46.5)
    star_left = tri_star_path(147.0, 152.0, 45.0)
    star_right = tri_star_path(365.0, 152.0, 45.0)

    left_wing = rounded_polygon_path([
        (102.0, 214.0),
        (231.0, 214.0),
        (231.0, 471.0),
        (215.0, 460.0),
        (215.0, 230.0),
        (118.0, 230.0),
    ], [1.5, 4.0, 2.5, 2.5, 4.0, 2.5])

    right_wing = rounded_polygon_path([
        (281.0, 214.0),
        (410.0, 214.0),
        (394.0, 230.0),
        (297.0, 230.0),
        (297.0, 460.0),
        (281.0, 471.0),
    ], [4.0, 1.5, 2.5, 4.0, 2.5, 2.5])

    center_col = slanted_pill(248.0, 264.0, 213.0, 213.0, 488.0, 488.0, (4.0, 4.0, 4.0, 4.0))

    bars = [
        slanted_pill(116.0, 132.0, 246.0, 246.0, 384.0, 396.0, (2.5, 2.5, 2.0, 2.0)),  # Col 1
        slanted_pill(149.0, 165.0, 246.0, 246.0, 426.0, 414.0, (2.5, 2.5, 2.0, 2.0)),  # Col 2
        slanted_pill(182.0, 198.0, 246.0, 246.0, 434.0, 446.0, (2.5, 2.5, 2.0, 2.0)),  # Col 3
        slanted_pill(314.0, 330.0, 246.0, 246.0, 446.0, 434.0, (2.5, 2.5, 2.0, 2.0)),  # Col 7
        slanted_pill(347.0, 363.0, 246.0, 246.0, 414.0, 426.0, (2.5, 2.5, 2.0, 2.0)),  # Col 8
        slanted_pill(380.0, 396.0, 246.0, 246.0, 396.0, 384.0, (2.5, 2.5, 2.0, 2.0)),  # Col 9
    ]
    bars_xml = "\n    ".join(f'<path d="{d}" />' for d in [left_wing, right_wing, center_col] + bars)

    return f"""<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="512" height="512">
  <defs>
    <linearGradient id="pemb_orig_gold" gradientUnits="userSpaceOnUse" x1="256" y1="25" x2="256" y2="490">
      <stop offset="0%" stop-color="#F8CA30" />
      <stop offset="50%" stop-color="#F3BE1C" />
      <stop offset="100%" stop-color="#E0A80E" />
    </linearGradient>
  </defs>
  <g fill="url(#pemb_orig_gold)">
    <path d="{star_top}" />
    <path d="{star_left}" />
    <path d="{star_right}" />
    {bars_xml}
  </g>
</svg>
"""


def render_svg_to_pil(svg_str, out_w, out_h, supersample=4, bg_color=None):
    """Render SVG string to anti-aliased RGBA PIL Image via 4x-8x supersampled Qt QSvgRenderer."""
    render_w = out_w * supersample
    render_h = out_h * supersample
    renderer = QSvgRenderer(QByteArray(svg_str.encode("utf-8")))
    qimg = QImage(render_w, render_h, QImage.Format_ARGB32_Premultiplied)
    if bg_color is None:
        qimg.fill(QColor(0, 0, 0, 0))
    else:
        qimg.fill(QColor(bg_color))

    painter = QPainter(qimg)
    painter.setRenderHint(QPainter.Antialiasing, True)
    painter.setRenderHint(QPainter.TextAntialiasing, True)
    painter.setRenderHint(QPainter.SmoothPixmapTransform, True)
    renderer.render(painter, QRectF(0, 0, render_w, render_h))
    painter.end()

    qimg_rgba = qimg.convertToFormat(QImage.Format_RGBA8888)
    ptr = qimg_rgba.constBits()
    pil_hi = Image.frombytes("RGBA", (render_w, render_h), bytes(ptr), "raw", "RGBA", qimg_rgba.bytesPerLine(), 1)
    if supersample > 1:
        return pil_hi.resize((out_w, out_h), Image.Resampling.LANCZOS)
    return pil_hi


def main():
    _app = QGuiApplication.instance() or QGuiApplication([])
    geom = compute_fusion_geometry()

    # 1. Generate Primary Vector SVGs
    mark_dark_svg = build_mark_svg(geom, theme="dark")
    mark_light_svg = build_mark_svg(geom, theme="light")
    mark_flat_svg = build_flat_mark_svg(geom)
    favicon_svg = build_mark_svg(geom, theme="dark", viewbox="72 16 368 484", width=512, height=512)
    hz_dark_svg = build_horizontal_lockup_svg(geom, theme="dark")
    hz_light_svg = build_horizontal_lockup_svg(geom, theme="light")
    vt_dark_svg = build_vertical_lockup_svg(geom, theme="dark")
    vt_light_svg = build_vertical_lockup_svg(geom, theme="light")
    app_icon_svg = build_app_icon_svg(geom)
    pembinaan_orig_svg = build_pembinaan_original_svg()

    svg_outputs = {
        LOGO_DIR / "elaptri-pembinaan-mark.svg": mark_dark_svg,
        LOGO_DIR / "elaptri-pembinaan-mark-light.svg": mark_light_svg,
        LOGO_DIR / "elaptri-pembinaan-mark-flat.svg": mark_flat_svg,
        LOGO_DIR / "elaptri-pembinaan-logo-horizontal.svg": hz_dark_svg,
        LOGO_DIR / "elaptri-pembinaan-logo-horizontal-light.svg": hz_light_svg,
        LOGO_DIR / "elaptri-pembinaan-logo-vertical.svg": vt_dark_svg,
        LOGO_DIR / "elaptri-pembinaan-logo-vertical-light.svg": vt_light_svg,
        LOGO_DIR / "elaptri-pembinaan-app-icon.svg": app_icon_svg,
        LOGO_DIR / "logo-pembinaan-original.svg": pembinaan_orig_svg,
        PUBLIC_DIR / "favicon.svg": favicon_svg,
        # Keep legacy filenames in sync so zero stale/boxy SVGs exist anywhere in public/images/logo/
        LOGO_DIR / "elaptri-mark.svg": mark_dark_svg,
        LOGO_DIR / "elaptri-mark-light.svg": mark_light_svg,
        LOGO_DIR / "elaptri-logo-horizontal.svg": hz_dark_svg,
        LOGO_DIR / "elaptri-logo-horizontal-light.svg": hz_light_svg,
        LOGO_DIR / "elaptri-logo-vertical.svg": vt_dark_svg,
        LOGO_DIR / "elaptri-logo-vertical-light.svg": vt_light_svg,
        LOGO_DIR / "elaptri-app-icon.svg": app_icon_svg,
    }

    for path, content in svg_outputs.items():
        path.write_text(content, encoding="utf-8")

    # 2. Generate High-Resolution Supersampled Transparent PNGs (NO dark square box on marks!)
    render_svg_to_pil(mark_dark_svg, 1024, 1024, supersample=2).save(LOGO_DIR / "elaptri-pembinaan-mark-1024.png")
    img_512 = render_svg_to_pil(mark_dark_svg, 512, 512, supersample=4)
    img_512.save(LOGO_DIR / "elaptri-pembinaan-mark-512.png")
    img_512.save(LOGO_DIR / "elaptri-icon-512x512.png")

    render_svg_to_pil(mark_light_svg, 512, 512, supersample=4).save(LOGO_DIR / "elaptri-pembinaan-mark-light-512.png")
    render_svg_to_pil(mark_dark_svg, 192, 192, supersample=4).save(LOGO_DIR / "elaptri-icon-192x192.png")
    render_svg_to_pil(favicon_svg, 180, 180, supersample=4).save(PUBLIC_DIR / "apple-touch-icon.png")

    # Lockup PNGs for Word, PDF, PowerPoint, & Official Headers
    render_svg_to_pil(hz_dark_svg, 1680, 440, supersample=2).save(LOGO_DIR / "elaptri-pembinaan-logo-horizontal.png")
    render_svg_to_pil(hz_light_svg, 1680, 440, supersample=2).save(LOGO_DIR / "elaptri-pembinaan-logo-horizontal-light.png")
    render_svg_to_pil(vt_light_svg, 1075, 1075, supersample=2).save(LOGO_DIR / "elaptri-pembinaan-logo-vertical-light.png")
    render_svg_to_pil(app_icon_svg, 512, 512, supersample=4).save(LOGO_DIR / "elaptri-pembinaan-app-icon-512.png")

    # 3. Generate Multi-Resolution Transparent favicon.ico (16x16, 32x32, 48x48)
    ico_base = render_svg_to_pil(favicon_svg, 256, 256, supersample=4)
    ico_48 = ico_base.resize((48, 48), Image.Resampling.LANCZOS)
    ico_32 = ico_base.resize((32, 32), Image.Resampling.LANCZOS).filter(
        ImageFilter.UnsharpMask(radius=0.7, percent=85, threshold=2)
    )
    ico_16 = ico_base.resize((16, 16), Image.Resampling.LANCZOS).filter(
        ImageFilter.UnsharpMask(radius=0.6, percent=95, threshold=2)
    )
    ico_48.save(
        PUBLIC_DIR / "favicon.ico",
        format="ICO",
        sizes=[(16, 16), (32, 32), (48, 48)],
        append_images=[ico_32, ico_16],
    )

    print("Successfully generated full E-Laptri Pembinaan vector & raster logo suite!")


if __name__ == "__main__":
    main()
