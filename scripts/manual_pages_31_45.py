# -*- coding: utf-8 -*-
"""
Modul Halaman 31 sampai 45:
- Halaman 31: BAB VI - 6.4 Detail Lembar Kerja Verifikasi: Audit Realisasi [Screenshot Review Detail]
- Halaman 32: BAB VI - 6.5 Alur Approval & Prosedur Pengembalian Data (Revisi)
- Halaman 33: BAB VII - 7.1 Katalog Formula Indikator & Formula Registry [Screenshot Admin Rumus]
- Halaman 34: BAB VII - 7.2 Klasifikasi 9 Tipe Kalkulasi Kinerja Canonical
- Halaman 35: BAB VII - 7.3 Konfigurasi Komponen Rumus, Bobot & Sumber Data [Screenshot Rumus Edit]
- Halaman 36: BAB VII - 7.4 Versioning Formula & Audit Trail Perubahan Rumus
- Halaman 37: BAB VIII - 8.1 Manajemen Template Dokumen Word LKjIP SAKIP [Screenshot Template]
- Halaman 38: BAB VIII - 8.2 Standardisasi Placeholder & Tagging Dinamis PHPWord
- Halaman 39: BAB VIII - 8.3 Prosedur Upload Custom Template & Validasi Sistem
- Halaman 40: BAB IX - 9.1 Modul Ekspor Laporan LKjIP Triwulanan e-LAPTRI [Screenshot Export]
- Halaman 41: BAB IX - 9.2 Parameter Unduhan Dokumen Resmi DOCX & Analisis Output
- Halaman 42: BAB X - 10.1 Seri Video Tutorial Keseluruhan e-LAPTRI (Modul 1 s/d 8)
- Halaman 43: BAB X - 10.2 Matriks Akses Video Tutorial, Storyboard & Scan QR Code [9 QR Codes]
- Halaman 44: BAB XI - 11.1 Pemecahan Masalah Umum (Troubleshooting & FAQ)
- Halaman 45: BAB XI - 11.2 Standar Pelayanan Helpdesk & Berita Acara Rekonsiliasi
"""

def get_pages_31_to_45(assets):
    pages = []

    # ==========================================
    # HALAMAN 31: BAB VI - 6.4 DETAIL LEMBAR AUDIT
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-31">
        <div class="header">
            <span>BAB VI: PANDUAN ADMIN & VERIFIKATOR</span>
            <span>6.4 LEMBAR KERJA VERIFIKASI DETAIL</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR & ADMIN: REVIEW & AUDIT DATA</div>
            <h2 class="title-primary">6.4 DETAIL LEMBAR KERJA VERIFIKASI: AUDIT REALISASI & KOMPONEN</h2>
            
            <p class="paragraph">
                Saat verifikator menekan tombol detail pada baris indikator, sistem menampilkan lembar audit komprehensif riwayat pengukuran antar-triwulan:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_review_det']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 6.3: Lembar Kerja Audit Verifikator Memuat Target, Realisasi & Analisis Narasi</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">TITIK KRITIS PEMERIKSAAN VERIFIKATOR:</h3>
            <ol style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Konsistensi Nilai Target:</strong> Memastikan target snapshot yang digunakan sesuai dengan Kepja 1184/2025 dan Perjanjian Kinerja (PK) yang telah ditandatangani Kepala Satker.</li>
                <li><strong>Kewajaran Nilai Pembilang dan Penyebut:</strong> Meneliti apakah angka pembilang ($X_1$) dan penyebut ($X_2$) mencerminkan beban kerja logis yang tercatat pada aplikasi persuratan dan administrasi kedinasan.</li>
                <li><strong>Kesesuaian Analisis Narasi:</strong> Memastikan kolom kendala bukan sekadar formalitas singkat, melainkan memuat akar permasalahan substansial.</li>
            </ol>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 31 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 32: BAB VI - 6.5 ALUR APPROVAL & REVISI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-32">
        <div class="header">
            <span>BAB VI: PANDUAN ADMIN & VERIFIKATOR</span>
            <span>6.5 ALUR APPROVAL & REVISI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR & ADMIN: REVIEW & AUDIT DATA</div>
            <h2 class="title-primary">6.5 ALUR APPROVAL & PROSEDUR PENGEMBALIAN DATA (REVISI)</h2>
            
            <p class="paragraph">
                Verifikator JAMBIN memiliki wewenang penuh untuk menyetujui atau menolak laporan kinerja yang diajukan oleh Operator Satker:
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin: 15px 0;">
                <div style="background: #f0fdf4; border: 1.5px solid #22c55e; border-radius: 8px; padding: 12px;">
                    <div style="font-weight: 800; color: #15803d; font-size: 9.5pt; margin-bottom: 6px;">1. PROSEDUR PERSETUJUAN (APPROVE)</div>
                    <ul style="font-size: 8pt; color: #334155; margin: 0; padding-left: 15px; line-height: 1.5;">
                        <li>Verifikator memastikan data lengkap dan bukti fisik valid.</li>
                        <li>Klik tombol hijau <strong>SETUJUI DATA (APPROVE)</strong>.</li>
                        <li>Status data berubah menjadi <span style="font-weight: 700; color: #15803d;">APPROVED</span>.</li>
                        <li>Data terkunci permanen dan langsung disuntikkan ke generator dokumen resmi LKjIP.</li>
                    </ul>
                </div>
                <div style="background: #fef2f2; border: 1.5px solid #ef4444; border-radius: 8px; padding: 12px;">
                    <div style="font-weight: 800; color: #b91c1c; font-size: 9.5pt; margin-bottom: 6px;">2. PROSEDUR PENGEMBALIAN (REJECT)</div>
                    <ul style="font-size: 8pt; color: #334155; margin: 0; padding-left: 15px; line-height: 1.5;">
                        <li>Jika ditemukan ketidaksesuaian angka atau narasi tidak lengkap.</li>
                        <li>Klik tombol merah <strong>KEMBALIKAN (REJECT / REVISI)</strong>.</li>
                        <li>Wajib mengetikkan <strong>Catatan Perbaikan (Rejection Notes)</strong> secara rinci.</li>
                        <li>Sistem otomatis membuka kembali kunci form di sisi Operator Satker disertai notifikasi perbaikan.</li>
                    </ul>
                </div>
            </div>

            <h3 class="subtitle-primary">SOP TINDAK LANJUT REVISI OLEH SATKER:</h3>
            <p class="paragraph">
                Satker yang menerima notifikasi pengembalian data diberikan waktu maksimal $2 \times 24$ jam kerja untuk melakukan koreksi nilai atau penyempurnaan narasi kendala, kemudian melakukan submisikan ulang ke aplikasi.
            </p>

            <div class="callout callout-info" style="margin-top: 15px;">
                <strong>HISTORI AUDIT JEJAK PERUBAHAN:</strong><br>
                Setiap siklus persetujuan dan penolakan terekam secara kronologis dalam tabel riwayat audit, mencakup nama verifikator, waktu eksekusi (timestamp), dan isi catatan perbaikan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 32 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 33: BAB VII - 7.1 KATALOG FORMULA
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-33">
        <div class="header">
            <span>BAB VII: PANDUAN ADMIN RUMUS</span>
            <span>7.1 KATALOG FORMULA REGISTRY</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VII: PANDUAN ADMIN: MANAJEMEN RUMUS & FORMULA REGISTRY</div>
            <h2 class="title-primary">7.1 KATALOG FORMULA INDIKATOR & FORMULA REGISTRY</h2>
            
            <p class="paragraph">
                Menu <strong>Manajemen Rumus</strong> (`/admin/rumus`) merupakan repositori sentral seluruh formula indikator kinerja di lingkungan JAMBIN yang dikendalikan secara parametrik:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_rumus_idx']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 7.1: Repositori Katalog Formula Registry dan Tipe Kalkulasi Aktif</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">KOLOM PENGATURAN FORMULA REGISTRY:</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 22%;">Nama Kolom</th>
                    <th>Fungsi Konfigurasi Sistem</th>
                </tr>
                <tr>
                    <td><strong>Kode & Nama Indikator</strong></td>
                    <td>Identitas resmi indikator (IKP atau IKK) yang terhubung pada <code>kinerja_nodes</code>.</td>
                </tr>
                <tr>
                    <td><strong>Versi Rumus</strong></td>
                    <td>Nomor rilis versi formula (contoh: <code>v1.0</code>, <code>v2.1</code>) untuk pelacakan perubahan historis.</td>
                </tr>
                <tr>
                    <td><strong>Tipe Formula</strong></td>
                    <td>Metode matematika kalkulasi (DIRECT_VALUE, RATIO, WEIGHTED_SUM, AVERAGE, dll.).</td>
                </tr>
                <tr>
                    <td><strong>Status Aktif</strong></td>
                    <td>Sakelar status operasional; hanya versi berstatus <em>Active</em> yang dieksekusi oleh Calculation Engine saat kalkulasi input.</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 33 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 34: BAB VII - 7.2 KLASIFIKASI 9 TIPE KALKULASI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-34">
        <div class="header">
            <span>BAB VII: PANDUAN ADMIN RUMUS</span>
            <span>7.2 KLASIFIKASI 9 TIPE KALKULASI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VII: PANDUAN ADMIN: MANAJEMEN RUMUS & FORMULA REGISTRY</div>
            <h2 class="title-primary">7.2 KLASIFIKASI 9 TIPE KALKULASI KINERJA CANONICAL</h2>
            
            <p class="paragraph">
                Arsitektur e-LAPTRI mendefinisikan 9 tipe kalkulasi baku pada atribut <code>kinerja_nodes.calculation_type</code> untuk menjamin standarisasi penghitungan:
            </p>

            <table class="table-styled" style="font-size: 7.5pt;">
                <tr>
                    <th style="width: 20%;">Tipe Kalkulasi</th>
                    <th style="width: 32%;">Definisi Matematis</th>
                    <th>Penerapan pada Indikator JAMBIN</th>
                </tr>
                <tr>
                    <td><code>DIRECT_VALUE</code></td>
                    <td>Nilai realisasi diinput langsung sebagai angka riil tanpa pembagian.</td>
                    <td>Indeks SPBE, Indeks Kebugaran Pegawai, Jumlah Rekomendasi Riset.</td>
                </tr>
                <tr>
                    <td><code>EXTERNAL_SCORE</code></td>
                    <td>Nilai didasarkan pada hasil penilaian instrumen pihak ketiga resmi.</td>
                    <td>Indeks Reformasi Birokrasi (KemenPAN-RB), Nilai SAKIP Nasional.</td>
                </tr>
                <tr>
                    <td><code>RATIO</code></td>
                    <td>Persentase perbandingan pembilang terhadap penyebut: $(X_1 / X_2) \times 100$.</td>
                    <td>Persentase Kepatuhan LHKPN, Persentase Realisasi Anggaran.</td>
                </tr>
                <tr>
                    <td><code>AVERAGE</code></td>
                    <td>Rata-rata aritmatika dari seluruh child relasi <code>FORMULA_COMPONENT</code>.</td>
                    <td>Rata-rata Ketercapaian Sasaran Kegiatan Lingkup Biro.</td>
                </tr>
                <tr>
                    <td><code>SUM</code></td>
                    <td>Penjumlahan total akumulatif dari seluruh komponen pembentuk.</td>
                    <td>Total Pegawai Kejaksaan yang Telah Lulus Diklat Fungsional.</td>
                </tr>
                <tr>
                    <td><code>WEIGHTED_SUM</code></td>
                    <td>Penjumlahan terbobot sub-komponen: $\\sum (N_i \\times W_i) / \\sum W_i$.</td>
                    <td>Nilai Kinerja Anggaran (NKA SMART Kemenkeu Berbobot).</td>
                </tr>
                <tr>
                    <td><code>COUNT</code></td>
                    <td>Penghitungan kuantitas dokumen / produk hukum yang telah disahkan.</td>
                    <td>Jumlah Regulasi dan SOP Pembinaan yang Telah Diundangkan.</td>
                </tr>
                <tr>
                    <td><code>SURVEY_INDEX</code></td>
                    <td>Indeks hasil olah kuesioner skala Likert (skala 1 s/d 4 atau 1 s/d 100).</td>
                    <td>Indeks Kepuasan Pengadaan Barang & Jasa di Lingkungan Kejaksaan.</td>
                </tr>
                <tr>
                    <td><code>CUSTOM</code></td>
                    <td>Formula algoritma khusus yang melibatkan transformasi non-linier.</td>
                    <td>Indeks Maturitas Manajemen Risiko JAMBIN.</td>
                </tr>
            </table>

            <div class="callout callout-warning" style="margin-top: 10px;">
                <strong>PENGGUNAAN TIPE DOCUMENTED:</strong><br>
                Tipe <code>DOCUMENTED</code> hanya diizinkan sebagai fallback sementara untuk indikator baru yang belum memiliki definisi pembilang/penyebut formal dari bagian perencanaan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 34 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 35: BAB VII - 7.3 BUILDER RUMUS & BOBOT
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-35">
        <div class="header">
            <span>BAB VII: PANDUAN ADMIN RUMUS</span>
            <span>7.3 BUILDER RUMUS & BOBOT KOMPONEN</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VII: PANDUAN ADMIN: MANAJEMEN RUMUS & FORMULA REGISTRY</div>
            <h2 class="title-primary">7.3 KONFIGURASI KOMPONEN RUMUS, BOBOT & SUMBER DATA</h2>
            
            <p class="paragraph">
                Melalui menu edit formula (`/admin/rumus/{id}/edit`), Administrator dapat menyusun formula dinamis beserta pembobotan komponen variabelnya:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_rumus_edit']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 7.2: Formulir Builder Pengaturan Komponen Variabel, Bobot & Tipe Sumber Data</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">PENGATURAN SUMBER KOMPONEN RUMUS:</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 25%;">Tipe Sumber</th>
                    <th style="width: 35%;">Mekanisme Aliran Data</th>
                    <th>Konfigurasi Database</th>
                </tr>
                <tr>
                    <td><code>INPUT</code></td>
                    <td>Nilai mentah diketik langsung oleh operator satker saat pelaporan triwulan.</td>
                    <td>Disimpan dalam tabel <code>kinerja_pengukuran_inputs</code> dengan variabel unik ($X_1, X_2$).</td>
                </tr>
                <tr>
                    <td><code>INDICATOR</code></td>
                    <td>Nilai otomatis ditarik dari hasil realisasi node indikator lain.</td>
                    <td>Dihubungkan melalui <code>source_node_id</code> pada tabel <code>kinerja_komponen_rumus</code>.</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 10px;">
                <strong>PEMBOBOTAN WEIGHTED SUM:</strong><br>
                Jika menggunakan tipe kalkulasi <code>WEIGHTED_SUM</code>, total kumulatif bobot seluruh komponen wajib bernilai persis <strong>100%</strong> (atau 1.0) agar tidak terjadi distorsi matematis.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 35 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 36: BAB VII - 7.4 VERSIONING FORMULA
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-36">
        <div class="header">
            <span>BAB VII: PANDUAN ADMIN RUMUS</span>
            <span>7.4 VERSIONING & AUDIT TRAIL RUMUS</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VII: PANDUAN ADMIN: MANAJEMEN RUMUS & FORMULA REGISTRY</div>
            <h2 class="title-primary">7.4 VERSIONING FORMULA & AUDIT TRAIL PERUBAHAN RUMUS</h2>
            
            <p class="paragraph">
                Salah satu keunggulan arsitektur e-LAPTRI v4 adalah prinsip <strong>Immutabilitas Pengukuran Historis</strong> melalui fitur <em>Formula Versioning</em>:
            </p>

            <h3 class="subtitle-primary">1. PRINSIP IMMUTABILITAS PENGUKURAN MASA LALU</h3>
            <p class="paragraph">
                Ketika sebuah formula indikator diubah oleh Administrator pada pertengahan tahun berjalan (misalnya karena perubahan regulasi KemenPAN-RB), sistem tidak menimpa <em>(overwrite)</em> formula lama. Sebagai gantinya, sistem membuat rekaman versi baru ($v_2$) dan menandai versi sebelumnya ($v_1$) sebagai arsip.
            </p>

            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 12px; margin: 15px 0; font-size: 8.5pt;">
                <div style="font-weight: 700; color: #0f172a; margin-bottom: 5px;">DAMPAK TEKNIS VERSIONING:</div>
                <div style="color: #334155; line-height: 1.5;">
                    • <strong>Laporan Tahun 2025:</strong> Tetap dihitung menggunakan formula $v_1$ (angka historis tidak berubah).<br>
                    • <strong>Laporan Tahun 2026:</strong> Dihitung otomatis menggunakan formula baru $v_2$.<br>
                    • Menghilangkan risiko perubahan angka capaian masa lalu saat audit BPK atau KemenPAN-RB.
                </div>
            </div>

            <h3 class="subtitle-primary">2. AUDIT TRAIL & LOG AKTIVITAS SISTEM</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 25%;">Atribut Log</th>
                    <th>Keterangan yang Terekam Otomatis</th>
                </tr>
                <tr>
                    <td><code>changed_by</code></td>
                    <td>Nama dan ID Administrator yang melakukan perubahan formula.</td>
                </tr>
                <tr>
                    <td><code>changed_at</code></td>
                    <td>Waktu presisi waktu lokal perubahan (Timestamp).</td>
                </tr>
                <tr>
                    <td><code>old_formula_schema</code></td>
                    <td>Salinan struktur formula lama dalam format JSON.</td>
                </tr>
                <tr>
                    <td><code>justification_notes</code></td>
                    <td>Dasar hukum atau surat perintah yang mendasari perubahan formula.</td>
                </tr>
            </table>

            <div class="callout callout-warning">
                <strong>ATURAN PERUBAHAN FORMULA:</strong><br>
                Perubahan formula aktif hanya boleh dilakukan oleh Administrator Biro Perencanaan setelah berkoordinasi dengan Pusdaskrimti dan mendapatkan persetujuan tertulis dari Sekretaris JAMBIN.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 36 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 37: BAB VIII - 8.1 TEMPLATE BUILDER WORD
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-37">
        <div class="header">
            <span>BAB VIII: BUILDER TEMPLATE LKJIP</span>
            <span>8.1 PENGATURAN TEMPLATE WORD</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VIII: BUILDER TEMPLATE LKJIP & PELAPORAN WORD</div>
            <h2 class="title-primary">8.1 MANAJEMEN TEMPLATE DOKUMEN WORD LKJIP SAKIP</h2>
            
            <p class="paragraph">
                Menu <strong>Template LKjIP</strong> (`/admin/template`) memungkinkan Administrator JAMBIN mengelola template berkas Microsoft Word (.docx) resmi yang digunakan mesin cetak laporan:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_template']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 8.1: Antarmuka Repositori dan Pengaturan Template Laporan LKjIP SAKIP</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">FUNGSI UTAMA MODUL TEMPLATE:</h3>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Unduh Template Standar (Download Default):</strong> Menyediakan template resmi awal yang telah disesuaikan dengan format tata naskah dinas Kejaksaan RI.</li>
                <li><strong>Unggah Template Kustom (Upload Template):</strong> Mengunggah desain berkas Word baru hasil modifikasi layout atau format tabel.</li>
                <li><strong>Sakelar Template Aktif (Activate):</strong> Memilih template mana yang digunakan sebagai master cetak oleh modul ekspor triwulanan.</li>
                <li><strong>Reset ke Pengaturan Awal:</strong> Mengembalikan format dokumen ke standar sistem jika template kustom mengalami kerusakan.</li>
            </ul>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 37 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 38: BAB VIII - 8.2 PLACEHOLDER PHPWORD
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-38">
        <div class="header">
            <span>BAB VIII: BUILDER TEMPLATE LKJIP</span>
            <span>8.2 KAMUS PLACEHOLDER PHPWORD</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VIII: BUILDER TEMPLATE LKJIP & PELAPORAN WORD</div>
            <h2 class="title-primary">8.2 STANDARDISASI PLACEHOLDER & TAGGING DINAMIS PHPWORD</h2>
            
            <p class="paragraph">
                Mesin template e-LAPTRI membaca tag khusus <em>(placeholder)</em> yang disisipkan di dalam dokumen Microsoft Word (.docx) untuk disuntikkan data database:
            </p>

            <table class="table-styled" style="font-size: 8pt; margin: 10px 0;">
                <tr>
                    <th style="width: 30%;">Placeholder Tag</th>
                    <th style="width: 32%;">Tipe Data Injeksi</th>
                    <th>Contoh Output Dokumen Word</th>
                </tr>
                <tr>
                    <td><code>${{TAHUN}}</code></td>
                    <td>Tahun Anggaran Pelaporan</td>
                    <td><code>2026</code></td>
                </tr>
                <tr>
                    <td><code>${{TRIWULAN}}</code></td>
                    <td>Angka Triwulan Aktif</td>
                    <td><code>Triwulan II</code></td>
                </tr>
                <tr>
                    <td><code>${{TANGGAL_CETAK}}</code></td>
                    <td>Tanggal Dokumen Diekspor</td>
                    <td><code>15 Juli 2026</code></td>
                </tr>
                <tr>
                    <td><code>${{NAMA_SATKER}}</code></td>
                    <td>Nama Satker / Instansi</td>
                    <td><code>Jaksa Agung Muda Bidang Pembinaan</code></td>
                </tr>
                <tr>
                    <td><code>${{BLOCK_KINERJA}}</code></td>
                    <td>Blok Tabel Berulang (Loop Table)</td>
                    <td>Membuat baris tabel otomatis untuk setiap SP & SK.</td>
                </tr>
                <tr>
                    <td><code>${{KODE_INDIKATOR}}</code></td>
                    <td>Kode Renstra Indikator</td>
                    <td><code>IKP 1.1</code> atau <code>IKK 3.2</code></td>
                </tr>
                <tr>
                    <td><code>${{NAMA_INDIKATOR}}</code></td>
                    <td>Nomenklatur Indikator</td>
                    <td><code>Persentase Realisasi Anggaran Pembinaan</code></td>
                </tr>
                <tr>
                    <td><code>${{TARGET_TRIWULAN}}</code></td>
                    <td>Target Kinerja Snapshot</td>
                    <td><code>95.00%</code></td>
                </tr>
                <tr>
                    <td><code>${{REALISASI_AKTUAL}}</code></td>
                    <td>Realisasi Hasil Formula</td>
                    <td><code>96.80%</code></td>
                </tr>
                <tr>
                    <td><code>${{CAPAIAN_PERSEN}}</code></td>
                    <td>Capaian Terhadap Target</td>
                    <td><code>101.89%</code></td>
                </tr>
                <tr>
                    <td><code>${{ANALISIS_CAPAIAN}}</code></td>
                    <td>Teks Narasi Analisis</td>
                    <td>Uraian faktor keberhasilan kegiatan.</td>
                </tr>
                <tr>
                    <td><code>${{KENDALA_OPERASIONAL}}</code></td>
                    <td>Teks Narasi Kendala</td>
                    <td>Uraian hambatan yang dihadapi.</td>
                </tr>
                <tr>
                    <td><code>${{RENCANA_TINDAK_LANJUT}}</code></td>
                    <td>Teks Narasi Upaya Solusi</td>
                    <td>Langkah strategis triwulan berikutnya.</td>
                </tr>
            </table>

            <div class="callout callout-warning">
                <strong>ATURAN PENULISAN TAGGING:</strong><br>
                Penulisan placeholder bersifat <em>Case-Sensitive</em> dan tidak boleh terpotong oleh format font yang berbeda di Microsoft Word. Pastikan seluruh tag berada dalam format teks biasa <em>(Plain Text)</em>.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 38 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 39: BAB VIII - 8.3 PROSEDUR UPLOAD TEMPLATE
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-39">
        <div class="header">
            <span>BAB VIII: BUILDER TEMPLATE LKJIP</span>
            <span>8.3 PROSEDUR UPLOAD & VALIDASI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VIII: BUILDER TEMPLATE LKJIP & PELAPORAN WORD</div>
            <h2 class="title-primary">8.3 PROSEDUR UPLOAD CUSTOM TEMPLATE & VALIDASI SISTEM</h2>
            
            <p class="paragraph">
                Untuk memperbarui format laporan LKjIP sesuai dengan pedoman tata naskah terbaru, ikuti langkah-langkah pengelolaan template berikut:
            </p>

            <h3 class="subtitle-primary">LANGKAH UNGGAH TEMPLATE BARU:</h3>
            <ol style="font-size: 8.5pt; color: #334155; line-height: 1.6; margin: 0 0 15px 20px;">
                <li>Buka menu <strong>Template LKjIP</strong> (`/admin/template`) dengan akun Administrator.</li>
                <li>Klik tombol <strong>Download Default Template</strong> untuk mendapatkan berkas acuan awal yang valid.</li>
                <li>Buka file berkas tersebut menggunakan Microsoft Word. Lakukan modifikasi desain (contoh: margin kertas, kop surat Kejaksaan, font, dan penomoran halaman) tanpa menghapus placeholder wajib.</li>
                <li>Simpan file dalam format <code>.docx</code>.</li>
                <li>Pada aplikasi e-LAPTRI, isi nama template pada kolom <strong>Nama Template</strong> (contoh: <em>"Template LKjIP Standar Renstra 2026 v2"</em>).</li>
                <li>Pilih file dengan menekan tombol <strong>Pilih Berkas</strong>, kemudian klik tombol <strong>UNGGAH TEMPLATE</strong>.</li>
            </ol>

            <h3 class="subtitle-primary">VALIDASI OTOMATIS OLEH ENGINE:</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 25%;">Item Pemeriksaan</th>
                    <th style="width: 35%;">Kondisi Lolos Uji</th>
                    <th>Respon Jika Gagal</th>
                </tr>
                <tr>
                    <td>Format Ekstensi Berkas</td>
                    <td>Berkas berekstensi <code>.docx</code> valid (MIME: OfficeOpenXML).</td>
                    <td>Sistem menolak format <code>.doc</code> lama atau PDF.</td>
                </tr>
                <tr>
                    <td>Kelengkapan Placeholder Wajib</td>
                    <td>Mengandung minimal tag <code>${{BLOCK_KINERJA}}</code> dan <code>${{TAHUN}}</code>.</td>
                    <td>Peringatan error: <em>"Tag tabel kinerja wajib tidak ditemukan"</em>.</td>
                </tr>
                <tr>
                    <td>Integritas Struktur XML</td>
                    <td>Struktur internal <code>word/document.xml</code> tidak korup.</td>
                    <td>Unggahan dibatalkan secara aman.</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 15px;">
                <strong>UJI COBA CETAK (TEST PRINT):</strong><br>
                Setelah template diaktifkan, Administrator disarankan melakukan ekspor uji coba triwulan sebelumnya untuk memastikan seluruh tabel terisi rapi sebelum digunakan resmi.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 39 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 40: BAB IX - 9.1 MODUL EKSPOR LKJIP
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-40">
        <div class="header">
            <span>BAB IX: GENERASI & EKSPOR LKJIP</span>
            <span>9.1 MODUL EKSPOR LAPORAN</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IX: GENERASI & EKSPOR LAPORAN AKUNTABILITAS (LKJIP)</div>
            <h2 class="title-primary">9.1 MODUL EKSPOR LAPORAN LKJIP TRIWULANAN e-LAPTRI</h2>
            
            <p class="paragraph">
                Modul <strong>Export Laporan</strong> (`/export`) dirancang untuk memproduksi berkas Laporan Kinerja (LKjIP) resmi secara otomatis dalam format Microsoft Word (.docx) siap cetak:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_export']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 9.1: Modul Ekspor Laporan Kinerja Triwulanan e-LAPTRI ke Format Microsoft Word</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">PARAMETER GENERASI DOKUMEN:</h3>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Pemilihan Tahun Anggaran:</strong> Mendukung penarikan data kinerja tahun 2025 hingga 2029.</li>
                <li><strong>Pemilihan Periode Triwulan:</strong> Memilih salah satu triwulan aktif (TW I, TW II, TW III, atau TW IV).</li>
                <li><strong>Status Kesiapan Data:</strong> Menampilkan status apakah seluruh 10 satker telah disetujui (Approved) untuk memastikan tidak ada data draf yang terikut.</li>
                <li><strong>Tombol Generate Word:</strong> Menjalankan engine PHPWord untuk merakit ratusan data indikator ke dalam dokumen resmi dalam hitungan detik.</li>
            </ul>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 40 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 41: BAB IX - 9.2 STRUKTUR OUTPUT LKJIP
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-41">
        <div class="header">
            <span>BAB IX: GENERASI & EKSPOR LKJIP</span>
            <span>9.2 STRUKTUR OUTPUT DOKUMEN WORD</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IX: GENERASI & EKSPOR LAPORAN AKUNTABILITAS (LKJIP)</div>
            <h2 class="title-primary">9.2 PARAMETER UNDUHAN RESMI & STRUKTUR OUTPUT LKJIP</h2>
            
            <p class="paragraph">
                Dokumen Microsoft Word (.docx) yang dihasilkan secara otomatis memiliki struktur bab standar laporan akuntabilitas kinerja instansi pemerintah:
            </p>

            <table class="table-styled" style="font-size: 8pt; margin: 15px 0;">
                <tr>
                    <th style="width: 25%;">Bagian Dokumen</th>
                    <th style="width: 35%;">Komponen yang Dihasilkan Otomatis</th>
                    <th>Sumber Data di Database</th>
                </tr>
                <tr>
                    <td><strong>Cover & Halaman Judul</strong></td>
                    <td>Kop surat resmi Kejaksaan RI, judul triwulan, tahun, dan identitas unit JAMBIN.</td>
                    <td>Konfigurasi aplikasi dan parameter filter.</td>
                </tr>
                <tr>
                    <td><strong>Kata Pengantar</strong></td>
                    <td>Draf sambutan Jaksa Agung Muda Pembinaan mengenai akuntabilitas triwulan berjalan.</td>
                    <td>Template master PHPWord.</td>
                </tr>
                <tr>
                    <td><strong>Bab I: Pendahuluan</strong></td>
                    <td>Tugas pokok, fungsi pembinaan, dan mandat penegakan hukum Kejaksaan RI.</td>
                    <td>Profil kelembagaan statis.</td>
                </tr>
                <tr>
                    <td><strong>Bab II: Perencanaan Kinerja</strong></td>
                    <td>Matriks Perjanjian Kinerja (PK) triwulanan dan target Renstra 2025-2029.</td>
                    <td>Tabel <code>kinerja_targets</code>.</td>
                </tr>
                <tr>
                    <td><strong>Bab III: Akuntabilitas Kinerja</strong></td>
                    <td>
                        • Tabel rekapitulasi capaian 11 Sasaran Program (SP 1 s/d SP 16).<br>
                        • Tabel realisasi Sasaran Kegiatan (35 SK operasional).<br>
                        • Narasi komprehensif analisis capaian, kendala, dan rencana solusi.
                    </td>
                    <td>Tabel <code>kinerja_pengukurans</code> dan <code>kinerja_pengukuran_inputs</code>.</td>
                </tr>
                <tr>
                    <td><strong>Bab IV: Penutup & Rekomendasi</strong></td>
                    <td>Kesimpulan ketercapaian target dan rekomendasi kebijakan manajerial.</td>
                    <td>Konsolidasi seluruh upaya tindak lanjut satker.</td>
                </tr>
            </table>

            <div class="callout callout-info">
                <strong>PENAMAAN FILE OTOMATIS:</strong><br>
                Berkas yang diunduh secara otomatis memiliki format nama standar kedinasan: <code>LKjIP_JAMBIN_Tahun_[TAHUN]_Triwulan_[TW].docx</code>, siap untuk ditandatangani dan disampaikan ke Kementerian PAN-RB.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 41 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 42: BAB X - 10.1 SPESIFIKASI VIDEO SCREENRECORD
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-42">
        <div class="header">
            <span>BAB X: VIDEO TUTORIAL SCREENRECORD</span>
            <span>10.1 SPESIFIKASI VIDEO REKAMAN LAPTOP</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB X: VIDEO TUTORIAL KESELURUHAN (SCREENRECORD LANGSUNG DARI LAPTOP)</div>
            <h2 class="title-primary">10.1 SPESIFIKASI VIDEO SCREENRECORD INTERAKTIF LAPTOP</h2>
            
            <p class="paragraph">
                Buku panduan operasional ini secara resmi dilengkapi dengan berkas <strong>Video Screenrecord Interaktif Asli</strong> berformat MP4 High Definition yang direkam secara langsung dari alur operasional aplikasi e-LAPTRI aktif di laptop ini, memperagakan seluruh siklus pelaporan tanpa rekayasa:
            </p>

            <table class="table-styled" style="font-size: 7.5pt; margin: 8px 0;">
                <tr>
                    <th style="width: 32%;">Paket Video Edukasi (MP4)</th>
                    <th style="width: 12%;">Ukuran</th>
                    <th style="width: 18%;">Format & Resolusi</th>
                    <th>Cakupan Interaksi & Materi Edukasi Kedinasan</th>
                </tr>
                <tr>
                    <td><strong>Paket 1: Video Tutorial Operator Satker</strong><br><span style="font-family: monospace; font-size: 6.8pt; color: #64748b;">Paket_1_Tutorial_Operator_Input_Kinerja.mp4</span></td>
                    <td>2.46 MB</td>
                    <td>MP4 H.264 HD (1280&times;720) + Audio Voiceover</td>
                    <td>Login akun Operator Satker (Biro Perencanaan), navigasi dashboard & chart performa, pembukaan accordion SK/IKK, pengetikan nilai mentah ($X_1$ pembilang & $X_2$ penyebut), kalkulasi otomatis realisasi & capaian, narasi kendala & upaya, hingga autosave & profil.</td>
                </tr>
                <tr>
                    <td><strong>Paket 2: Video Tutorial Verifikator & Admin</strong><br><span style="font-family: monospace; font-size: 6.8pt; color: #64748b;">Paket_2_Tutorial_Admin_Verifikasi_Rumus_Ekspor.mp4</span></td>
                    <td>2.35 MB</td>
                    <td>MP4 H.264 HD (1280&times;720) + Audio Voiceover</td>
                    <td>Login Super Admin JAMBIN, monitoring Command Center kepatuhan 10 Satker Eselon II, review DataGrid multi-kriteria, lembar kerja audit detail, alur approval & pengembalian revisi, Formula Registry & bobot rumus, template Word, dan ekspor LKjIP triwulanan.</td>
                </tr>
                <tr style="background: #f0fdf4; font-weight: 700;">
                    <td><strong>Paket 3: Video Edukasi Keseluruhan (Master)</strong><br><span style="font-family: monospace; font-size: 6.8pt; color: #15803d;">Paket_3_Video_Edukasi_Keseluruhan_ELAPTRI.mp4</span></td>
                    <td>4.36 MB</td>
                    <td>MP4 H.264 HD (1280&times;720) + Audio Voiceover</td>
                    <td>Simulasi end-to-end komprehensif akuntabilitas kinerja SAKIP JAMBIN sesuai Renstra 2025-2029 dan Kepja 1184/2025, memperagakan kolaborasi menyeluruh antar-peran (Operator Satker, Verifikator, Pimpinan) dalam penyusunan LKjIP.</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 8px;">GALERI FRAME SCREENRECORD LANGSUNG (BAGIAN 1: ALUR OPERATOR):</h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; margin-top: 5px;">
                <div style="border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: #f8fafc; text-align: center;">
                    <img src="{assets.get('vf_1', '')}" style="width: 100%; display: block;">
                    <div style="font-size: 6.5pt; font-weight: 700; color: #0f172a; padding: 2px;">Frame 1: Login Satker</div>
                </div>
                <div style="border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: #f8fafc; text-align: center;">
                    <img src="{assets.get('vf_2', '')}" style="width: 100%; display: block;">
                    <div style="font-size: 6.5pt; font-weight: 700; color: #0f172a; padding: 2px;">Frame 2: Dashboard Opr</div>
                </div>
                <div style="border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: #f8fafc; text-align: center;">
                    <img src="{assets.get('vf_3', '')}" style="width: 100%; display: block;">
                    <div style="font-size: 6.5pt; font-weight: 700; color: #0f172a; padding: 2px;">Frame 3: Input Variabel</div>
                </div>
                <div style="border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: #f8fafc; text-align: center;">
                    <img src="{assets.get('vf_4', '')}" style="width: 100%; display: block;">
                    <div style="font-size: 6.5pt; font-weight: 700; color: #0f172a; padding: 2px;">Frame 4: Manajemen Profil</div>
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>KEUNGGULAN SCREENRECORD LANGSUNG DARI LAPTOP:</strong><br>
                Seluruh video screenrecord direkam secara real-time dari aplikasi e-LAPTRI aktif di laptop ini, mencerminkan respons sistem sesungguhnya, kecepatan kalkulasi instan, dan tampilan nyata tanpa distorsi.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 42 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 43: BAB X - 10.2 TAUTAN & TANGKAPAN LAYAR
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-43">
        <div class="header">
            <span>BAB X: VIDEO TUTORIAL SCREENRECORD</span>
            <span>10.2 TAUTAN & TANGKAPAN LAYAR VIDEO</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB X: VIDEO TUTORIAL KESELURUHAN (SCREENRECORD LANGSUNG DARI LAPTOP)</div>
            <h2 class="title-primary">10.2 TAUTAN & TANGKAPAN LAYAR 3 PAKET VIDEO TUTORIAL INTERAKTIF</h2>
            
            <p class="paragraph">
                Sebagai pemenuhan bukti fisik kegiatan kedinasan, berikut disajikan matriks tautan berkas resmi <strong>3 Paket Video Edukasi Beresolusi Tinggi</strong> yang tersimpan pada laptop ini beserta tangkapan layar adegan interaktif sistem:
            </p>

            <div style="background: #0f172a; color: #f8fafc; border-radius: 6px; padding: 7px 11px; font-family: Consolas, monospace; font-size: 7.2pt; margin-bottom: 7px;">
                <span style="color: #38bdf8; font-weight: 700;">MATRIKS TAUTAN BERKAS VIDEO LOKAL LAPTOP:</span><br>
                • <strong>Paket 1:</strong> <code>d:\\Data B ackup Web\\e-laptriv4\\docs\\videos\\Paket_1_Tutorial_Operator_Input_Kinerja.mp4</code><br>
                • <strong>Paket 2:</strong> <code>d:\\Data B ackup Web\\e-laptriv4\\docs\\videos\\Paket_2_Tutorial_Admin_Verifikasi_Rumus_Ekspor.mp4</code><br>
                • <strong>Paket 3:</strong> <code>d:\\Data B ackup Web\\e-laptriv4\\docs\\videos\\Paket_3_Video_Edukasi_Keseluruhan_ELAPTRI.mp4</code>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 6px;">GALERI FRAME SCREENRECORD LANGSUNG (BAGIAN 2: ALUR ADMIN & LKJIP):</h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; margin: 4px 0 8px 0;">
                <div style="border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: #f8fafc; text-align: center;">
                    <img src="{assets.get('vf_6', '')}" style="width: 100%; display: block;">
                    <div style="font-size: 6.5pt; font-weight: 700; color: #0f172a; padding: 2px;">Frame 5: Dashboard Admin</div>
                </div>
                <div style="border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: #f8fafc; text-align: center;">
                    <img src="{assets.get('vf_7', '')}" style="width: 100%; display: block;">
                    <div style="font-size: 6.5pt; font-weight: 700; color: #0f172a; padding: 2px;">Frame 6: Review DataGrid</div>
                </div>
                <div style="border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: #f8fafc; text-align: center;">
                    <img src="{assets.get('vf_8', '')}" style="width: 100%; display: block;">
                    <div style="font-size: 6.5pt; font-weight: 700; color: #0f172a; padding: 2px;">Frame 7: Formula Builder</div>
                </div>
                <div style="border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden; background: #f8fafc; text-align: center;">
                    <img src="{assets.get('vf_10', '')}" style="width: 100%; display: block;">
                    <div style="font-size: 6.5pt; font-weight: 700; color: #0f172a; padding: 2px;">Frame 8: Ekspor LKjIP Word</div>
                </div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 6px;">TIMELINE & STORYBOARD REKAMAN LAYAR INTERAKTIF:</h3>
            <table class="table-styled" style="font-size: 7.2pt; margin: 4px 0;">
                <tr>
                    <th style="width: 16%;">Timestamp Video</th>
                    <th style="width: 24%;">Modul Aplikasi</th>
                    <th>Aksi Pengguna & Penjelasan Interaksi pada Video Screenrecord</th>
                </tr>
                <tr>
                    <td><code>00:00 - 00:10</code></td>
                    <td>Autentikasi & Login</td>
                    <td>Pengetikan kredensial Operator Biro Perencanaan (<code>ro.ren</code>), penekanan tombol submit, dan validasi sesi.</td>
                </tr>
                <tr>
                    <td><code>00:11 - 00:22</code></td>
                    <td>Dashboard Operator</td>
                    <td>Eksplorasi ringkasan metrik kinerja, progress lingkar keterisian, dan grafik batang capaian SK.</td>
                </tr>
                <tr>
                    <td><code>00:23 - 00:35</code></td>
                    <td>Input Kinerja SP & SK</td>
                    <td>Pengisian variabel mentah pembilang ($X_1$), penyebut ($X_2$), kalkulasi realisasi instan, dan penyimpanan form.</td>
                </tr>
                <tr>
                    <td><code>00:36 - 00:45</code></td>
                    <td>Profil & Logout</td>
                    <td>Pemeriksaan informasi profil akun satuan kerja, verifikasi kata sandi, dan pergantian sesi aman.</td>
                </tr>
                <tr>
                    <td><code>00:46 - 00:55</code></td>
                    <td>Admin Dashboard</td>
                    <td>Login Super Admin (<code>admin.jambin</code>) dan pemantauan matriks kepatuhan pelaporan seluruh Satker Eselon II.</td>
                </tr>
                <tr>
                    <td><code>00:56 - 01:05</code></td>
                    <td>Review & Formula</td>
                    <td>Audit baris indikator pada DataGrid, verifikasi lembar audit detail, dan konfigurasi bobot rumus di Formula Registry.</td>
                </tr>
                <tr>
                    <td><code>01:06 - 01:12</code></td>
                    <td>Template & Ekspor LKjIP</td>
                    <td>Pemeriksaan repositori template Word dan simulasi unduhan dokumen laporan kinerja triwulanan resmi (.docx).</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 43 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 44: BAB XI - 11.1 TROUBLESHOOTING & FAQ
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-44">
        <div class="header">
            <span>BAB XI: TROUBLESHOOTING & FAQ</span>
            <span>11.1 PEMECAHAN MASALAH UMUM</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB XI: TROUBLESHOOTING, FAQ & BANTUAN OPERASIONAL</div>
            <h2 class="title-primary">11.1 PEMECAHAN MASALAH UMUM (TROUBLESHOOTING & FAQ)</h2>
            
            <p class="paragraph">
                Daftar pertanyaan yang paling sering diajukan beserta solusi teknis jika operator menghadapi kendala operasional:
            </p>

            <div style="font-size: 8pt; line-height: 1.5;">
                <div class="faq-item">
                    <div class="faq-q">Q1: Mengapa tombol "Ajukan ke JAMBIN" berwarna abu-abu dan tidak dapat diklik?</div>
                    <div class="faq-a"><strong>Solusi:</strong> Tombol submit hanya akan aktif jika seluruh indikator wajib tanggung jawab satuan kerja telah terisi lengkap dan tersimpan. Periksa tab Sasaran Kegiatan, pastikan tidak ada indikator yang masih berstatus kosong atau belum terisi narasinya.</div>
                </div>

                <div class="faq-item">
                    <div class="faq-q">Q2: Mengapa sistem menolak saat menginput nilai pembilang ($X_1$) lebih besar dari penyebut ($X_2$)?</div>
                    <div class="faq-a"><strong>Solusi:</strong> Pada indikator rasio reguler persentase penyelesaian, penyebut merepresentasikan total beban kerja (kuota maksimal), sehingga pembilang tidak boleh melampaui penyebut. Jika kegiatan Anda memang melampaui target, periksa apakah indikator tersebut bertipe kuantitas akumulatif (SUM) atau laporkan ke Admin untuk verifikasi formula.</div>
                </div>

                <div class="faq-item">
                    <div class="faq-q">Q3: Bagaimana jika ada kesalahan ketik angka setelah laporan disetujui (Approved) oleh JAMBIN?</div>
                    <div class="faq-a"><strong>Solusi:</strong> Data yang sudah disetujui terkunci secara permanen di database. Operator harus mengajukan permohonan pembatalan persetujuan <em>(un-approve request)</em> kepada Administrator Biro Perencanaan disertai Surat Berita Acara Rekonsiliasi resmi.</div>
                </div>

                <div class="faq-item">
                    <div class="faq-q">Q4: Muncul pesan error saat menekan tombol "Export Word" di halaman Ekspor LKjIP?</div>
                    <div class="faq-a"><strong>Solusi:</strong> Error umumnya terjadi jika file template aktif di server mengalami korupsi XML atau ada tag placeholder yang terpotong. Administrator dapat menekan tombol <strong>Reset to Default Template</strong> pada menu Template LKjIP untuk mengembalikan fungsi ekspor normal.</div>
                </div>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 44 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 45: BAB XI - 11.2 HELPDESK & REKONSILIASI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-45">
        <div class="header">
            <span>BAB XI: TROUBLESHOOTING & FAQ</span>
            <span>11.2 HELPDESK & BERITA ACARA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB XI: TROUBLESHOOTING, FAQ & BANTUAN OPERASIONAL</div>
            <h2 class="title-primary">11.2 STANDAR PELAYANAN HELPDESK & BERITA ACARA REKONSILIASI</h2>
            
            <p class="paragraph">
                Untuk kendala teknis yang memerlukan intervensi langsung, Satker dapat menghubungi Tim Helpdesk Resmi Sistem e-LAPTRI:
            </p>

            <table class="table-styled" style="font-size: 8pt; margin: 10px 0;">
                <tr>
                    <th style="width: 28%;">Layanan Dukungan</th>
                    <th style="width: 32%;">Kontak Kedinasan</th>
                    <th>Lingkup Pelayanan Bantuan</th>
                </tr>
                <tr>
                    <td><strong>Helpdesk SAKIP (Substansi)</strong></td>
                    <td>Biro Perencanaan (Bagian Lapkin)<br>Email: <code>lapkin.jambin@kejaksaan.go.id</code></td>
                    <td>Konsultasi Renstra 2025-2029, target triwulan, definisi operasional indikator, dan pembukaan kunci laporan.</td>
                </tr>
                <tr>
                    <td><strong>Helpdesk IT (Infrastruktur)</strong></td>
                    <td>Pusdaskrimti Kejaksaan Agung RI<br>Hotline: <code>(021) 7221269 ext. 420</code></td>
                    <td>Reset kata sandi akun, kendala koneksi server, galat database, dan perbaikan template Word korup.</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 15px;">FORMAT LEMBAR BERITA ACARA REKONSILIASI DATA:</h3>
            <div style="border: 1px dashed #94a3b8; border-radius: 8px; padding: 12px; background: #f8fafc; font-size: 7.5pt; line-height: 1.5;">
                <div style="text-align: center; font-weight: 800; color: #0f172a; margin-bottom: 5px;">
                    BERITA ACARA REKONSILIASI & KOREKSI DATA KINERJA TRIWULANAN<br>
                    Nomor: BA-______ / C.1 / Lapkin / ______ / 2026
                </div>
                Pada hari ini, ___________ tanggal ___ bulan ____________ tahun 2026, telah dilaksanakan rekonsiliasi data kinerja e-LAPTRI antara Biro Perencanaan dengan Unit Kerja: <strong>_________________________________________</strong>, dengan hasil koreksi sebagai berikut:<br>
                1. Kode Indikator: ______________ Nama: _______________________________________________________<br>
                2. Realisasi Semula: ____________ Pembilang: ____________ Penyebut: ____________<br>
                3. Realisasi Menjadi: ____________ Pembilang: ____________ Penyebut: ____________<br>
                4. Alasan / Justifikasi Koreksi: ________________________________________________________________<br>
                <div style="display: flex; justify-content: space-between; margin-top: 25px; text-align: center;">
                    <div style="width: 45%;">
                        Operator Satuan Kerja,<br><br><br>
                        (_______________________________)<br>
                        NIP.
                    </div>
                    <div style="width: 45%;">
                        Verifikator Biro Perencanaan,<br><br><br>
                        (_______________________________)<br>
                        NIP.
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 20px; font-size: 8pt; color: #64748b; font-weight: 600;">
                — AKHIR DOKUMEN BUKU MANUAL E-LAPTRI 45 HALAMAN —
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 45 dari 45</span>
        </div>
    </div>
    """)

    return pages
