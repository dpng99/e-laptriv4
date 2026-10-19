# -*- coding: utf-8 -*-
"""
Modul Penyusun Halaman 31 sampai 40
Buku Manual Operasional e-LAPTRI v4 (e-LKjIP Pembinaan)
Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI: Dr. Hendro Dewanto, S.H., M.Hum.
"""

def get_pages_31_to_40(assets):
    pages = []

    # ==========================================
    # HALAMAN 31: BAB VI - 6.5 ALUR APPROVAL & REVISI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-31">
        <div class="header">
            <span>BAB VI: AUDIT &amp; REVIEW DATA JAMBIN</span>
            <span>6.5 ALUR APPROVAL &amp; PENGEMBALIAN REVISI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR: REVIEW DATA</div>
            <h2 class="title-primary">6.5 ALUR APPROVAL &amp; PROSEDUR PENGEMBALIAN DATA REVISI</h2>

            <p class="paragraph">
                Tahap akhir verifikasi memberikan dua opsi keputusan resmi kepada Verifikator JAMBIN terhadap berkas laporan yang diajukan oleh Operator Satker:
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 8px 0;">
                <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 6px; padding: 8px;">
                    <div style="font-weight: 800; font-size: 8pt; color: #166534; margin-bottom: 4px;">
                        KEPUTUSAN A: SETUJUI DATA (APPROVE)
                    </div>
                    <p style="font-size: 7.1pt; color: #14532d; line-height: 1.35; margin: 0 0 6px 0;">
                        Diberikan apabila seluruh variabel mentah $X_1/X_2$ valid, cocok dengan berkas evidence, dan narasi kendala telah memenuhi kaidah SAKIP.
                    </p>
                    <ul style="margin: 0; padding-left: 14px; font-size: 7pt; color: #052e16; line-height: 1.35;">
                        <li>Status data berubah menjadi <code>APPROVED</code> (Hijau).</li>
                        <li>Nilai realisasi otomatis diikutsertakan dalam roll-up agregasi tingkat program (SP) dan IKSS JAMBIN.</li>
                        <li>Data siap diekspor ke Laporan LKjIP Word resmi.</li>
                    </ul>
                </div>

                <div style="background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 6px; padding: 8px;">
                    <div style="font-weight: 800; font-size: 8pt; color: #991b1b; margin-bottom: 4px;">
                        KEPUTUSAN B: KEMBALIKAN UNTUK REVISI
                    </div>
                    <p style="font-size: 7.1pt; color: #7f1d1d; line-height: 1.35; margin: 0 0 6px 0;">
                        Diberikan jika ditemukan ketidaksesuaian angka numerik, berkas bukti dukung tidak sah, atau analisis kendala belum memadai.
                    </p>
                    <ul style="margin: 0; padding-left: 14px; font-size: 7pt; color: #450a0a; line-height: 1.35;">
                        <li>Status data berubah menjadi <code>REVISION_REQUESTED</code>.</li>
                        <li>Verifikator <strong>wajib</strong> mengisi catatan koreksi spesifik pada modal dialog yang muncul.</li>
                        <li>Formulir di sisi Operator Satker otomatis terbuka kembali (*unfreeze*) untuk perbaikan data.</li>
                    </ul>
                </div>
            </div>

            <h3 class="subtitle-primary">STANDAR PENULISAN CATATAN KOREKSI OLEH VERIFIKATOR:</h3>
            <div class="callout callout-warning">
                <strong>PANDUAN CATATAN REVISI YANG KONSTRUKTIF:</strong><br>
                Catatan koreksi wajib menyebutkan secara jelas poin kesalahan dan dokumen apa yang harus diperbaiki.
                <br><em>Contoh Baik:</em> <code>"Variabel pembilang X1 tercatat 50 berkas, namun pada lampiran BAST fisik hanya tertera 42 berkas. Mohon sesuaikan angka X1 atau unggah addendum BAST yang sah."</code>
                <br><em>Contoh Buruk (Dilarang):</em> <code>"Data salah, tolong perbaiki."</code> (Tidak informatif dan memperlambat penyelesaian).
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>BATAS WAKTU PERBAIKAN DATA REVISI:</strong><br>
                Operator satker diberikan waktu maksimal 2 x 24 jam hari kerja untuk menyelesaikan perbaikan dan melakukan submit ulang sejak status revisi diterbitkan oleh verifikator.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 31 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 32: BAB VII - 7.1 KATALOG FORMULA REGISTRY (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-32">
        <div class="header">
            <span>BAB VII: FORMULA REGISTRY &amp; ENGINE</span>
            <span>7.1 KATALOG FORMULA REGISTRY</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VII: PANDUAN ADMIN: FORMULA REGISTRY</div>
            <h2 class="title-primary">7.1 KATALOG FORMULA INDIKATOR &amp; FORMULA REGISTRY</h2>

            <p class="paragraph">
                Untuk mencegah terjadinya modifikasi rumus tanpa izin, seluruh formulasi perhitungan 119 indikator kinerja diatur secara tersentralisasi pada modul <strong>Formula Registry</strong> yang dikelola oleh Administrator JAMBIN:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_rumus_idx')}" class="screenshot-img" alt="Katalog Formula Registry Indikator">
                <div class="screenshot-caption">Gambar 7.1: Antarmuka Formula Registry Memuat Daftar Seluruh Formula Resmi Kepja 1184/2025</div>
            </div>

            <h3 class="subtitle-primary">FITUR KONTROL PADA FORMULA REGISTRY:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Pencarian Cepat Formula:</strong><br>
                    Cari formula berdasarkan kode indikator (misal: <code>IKP 16.2</code>) atau nama satuan kerja pengampu untuk membedah logika hitung aktif.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[2] Kolom Klasifikasi Tipe Kalkulasi:</strong><br>
                    Menampilkan tipe kalkulasi canonical yang terikat pada indikator (seperti <code>RATIO</code>, <code>DIRECT_VALUE</code>, atau <code>WEIGHTED_SUM</code>).
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[3] Teks Formula Sumber Resmi:</strong><br>
                    Menampilkan rumusan kalimat asli dari Kepja 1184/2025 sebagai dasar rujukan yuridis sebelum diuraikan menjadi komponen matematis.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #7c3aed;">[4] Tombol Konfigurasi Komponen:</strong><br>
                    Akses menuju formulir perincian variabel mentah $X_1/X_2$, pembobotan, dan penetapan sumber data indikator.
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>LARANGAN EKSEKUSI STRING RUMUS SECARA DINAMIS:</strong><br>
                Sistem e-LAPTRI v4 secara ketat melarang eksekusi teks rumus menggunakan <code>eval()</code>. Semua kalkulasi dieksekusi melalui *Calculation Strategy Class* khusus yang telah teruji unit test secara ketat.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 32 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 33: BAB VII - 7.2 9 TIPE KALKULASI (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-33">
        <div class="header">
            <span>BAB VII: FORMULA REGISTRY &amp; ENGINE</span>
            <span>7.2 KONFIGURASI 9 TIPE KALKULASI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VII: PANDUAN ADMIN: FORMULA REGISTRY</div>
            <h2 class="title-primary">7.2 KONFIGURASI 9 TIPE KALKULASI KINERJA &amp; KOMPONEN</h2>

            <p class="paragraph">
                Saat administrator membuka menu edit formula, sistem menyajikan konfigurasi komponen pembentuk rumus. Sesuai arsitektur canonical, setiap indikator wajib menggunakan salah satu dari <strong>9 Tipe Kalkulasi Resmi</strong>:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_rumus_edit')}" class="screenshot-img" alt="Form Konfigurasi Komponen Rumus Indikator">
                <div class="screenshot-caption">Gambar 7.2: Formulir Penyetelan Tipe Kalkulasi, Bobot Komponen &amp; Pemilihan Sumber Data</div>
            </div>

            <table class="table-styled" style="font-size: 7.1pt; margin-top: 4px;">
                <tr>
                    <th style="width: 22%;">Tipe Kalkulasi</th>
                    <th style="width: 38%;">Logika Operasi Matematis</th>
                    <th>Contoh Penggunaan pada JAMBIN</th>
                </tr>
                <tr>
                    <td><strong>DIRECT_VALUE</strong></td>
                    <td>Nilai realisasi diambil langsung dari input tunggal angka.</td>
                    <td>IKP 21.1 (Jumlah Policy Brief Terekomendasi).</td>
                </tr>
                <tr>
                    <td><strong>EXTERNAL_SCORE</strong></td>
                    <td>Skor resmi dari hasil evaluasi kementerian/lembaga luar.</td>
                    <td>IKSS 2.1 (Indeks RB dari KemenPAN-RB).</td>
                </tr>
                <tr>
                    <td><strong>RATIO</strong></td>
                    <td>Persentase dari pembagian pembilang dan penyebut $(X_1 / X_2) \times 100\%$.</td>
                    <td>IKK 14.1.1 (Persentase RKA-K/L Sesuai Standar).</td>
                </tr>
                <tr>
                    <td><strong>AVERAGE</strong></td>
                    <td>Rata-rata aritmatika dari seluruh child bertipe <code>FORMULA_COMPONENT</code>.</td>
                    <td>Program yang memiliki sub-kegiatan berbobot setara.</td>
                </tr>
                <tr>
                    <td><strong>WEIGHTED_SUM</strong></td>
                    <td>Penjumlahan berbobot: $\sum (\text{{Nilai}}_i \times \text{{Bobot}}_i)$.</td>
                    <td>Indeks komposit pelayanan atau indeks maturitas SAKIP.</td>
                </tr>
                <tr>
                    <td><strong>SUM</strong></td>
                    <td>Penjumlahan murni kuantitas dari seluruh unit kerja bawahan.</td>
                    <td>Total volume pengadaan atau total layanan pemeriksaan.</td>
                </tr>
                <tr>
                    <td><strong>COUNT</strong></td>
                    <td>Penghitungan frekuensi keterjadian kegiatan yang terlaksana.</td>
                    <td>Jumlah regulasi yang selesai diharmonisasi.</td>
                </tr>
                <tr>
                    <td><strong>SURVEY_INDEX</strong></td>
                    <td>Skala indeks hasil kuesioner persepsi kepuasan (skala 1-4 / 1-100).</td>
                    <td>IKP 19.1 (Indeks Kepuasan Layanan Protokol &amp; Umum).</td>
                </tr>
                <tr>
                    <td><strong>CUSTOM</strong></td>
                    <td>Formula bersyarat khusus dengan algoritma kalkulasi spesifik.</td>
                    <td>Indikator kepatuhan dengan penalti deviasi waktu.</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 33 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 34: BAB VII - 7.3 VERSIONING RUMUS & GRAPH VALIDATOR
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-34">
        <div class="header">
            <span>BAB VII: FORMULA REGISTRY &amp; ENGINE</span>
            <span>7.3 VERSIONING RUMUS &amp; AUDIT TRAIL</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VII: PANDUAN ADMIN: FORMULA REGISTRY</div>
            <h2 class="title-primary">7.3 VERSIONING FORMULA, AUDIT TRAIL &amp; INTEGRITAS GRAPH</h2>

            <p class="paragraph">
                Perubahan formula indikator di tengah berjalannya periode Renstra berpotensi merusak validitas data historis triwulan sebelumnya. Oleh sebab itu, e-LAPTRI v4 menerapkan mekanisme <strong>Formula Versioning</strong> dan <strong>Graph Integrity Validator</strong>:
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin: 8px 0;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px;">
                    <strong style="color: #0369a1; font-size: 7.8pt;">1. Versioning Rumus Bebas Dampak (Non-Breaking)</strong>
                    <p style="font-size: 7.1pt; color: #475569; margin: 3px 0 0 0; line-height: 1.35;">
                        Ketika suatu formula diubah (misalnya penyesuaian bobot komponen), sistem membuat rekaman versi baru dengan penanda tahun berlaku (<code>tahun_mulai</code>). Pengukuran triwulan lampau tetap merujuk pada versi lama, sehingga angka historis LKjIP tidak pernah berubah secara tiba-tiba.
                    </p>
                </div>

                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px;">
                    <strong style="color: #064e3b; font-size: 7.8pt;">2. Deteksi Siklus Otomatis (GraphValidator)</strong>
                    <p style="font-size: 7.1pt; color: #475569; margin: 3px 0 0 0; line-height: 1.35;">
                        Setiap kali ada relasi baru yang ditambahkan antar-indikator, layanan <code>GraphValidator.php</code> mengeksekusi algoritma *Cycle Detection (Tarjan / DFS)*. Jika relasi tersebut menimbulkan ketergantungan melingkar ($A \rightarrow B \rightarrow A$), sistem menolak penyimpanan secara otomatis.
                    </p>
                </div>
            </div>

            <h3 class="subtitle-primary">REKAPITULASI LOG AUDIT TRAIL PERUBAHAN RUMUS:</h3>
            <table class="table-styled" style="font-size: 7.1pt; margin-top: 4px;">
                <tr>
                    <th style="width: 18%;">Cap Waktu</th>
                    <th style="width: 16%;">Kode Indikator</th>
                    <th style="width: 16%;">Pengubah</th>
                    <th style="width: 25%;">Perubahan Logika Formula</th>
                    <th>Dasar Kebijakan</th>
                </tr>
                <tr>
                    <td>15 Jan 2026 10:14</td>
                    <td><strong>IKSS 1.1</strong></td>
                    <td><code>admin.jambin</code></td>
                    <td>Normalisasi tipe ke <code>EXTERNAL_SCORE</code></td>
                    <td>Surat Edaran KemenPAN-RB</td>
                </tr>
                <tr>
                    <td>20 Jan 2026 14:30</td>
                    <td><strong>IKP 15.1</strong></td>
                    <td><code>admin.jambin</code></td>
                    <td>Penetapan komponen pembobotan sistem merit</td>
                    <td>Kepja Nomor 1184/2025</td>
                </tr>
                <tr>
                    <td>02 Feb 2026 09:25</td>
                    <td><strong>IKK 14.1.2</strong></td>
                    <td><code>admin.jambin</code></td>
                    <td>Penambahan variabel penyebut ($X_2$)</td>
                    <td>Reviu SAKIP Biro Perencanaan</td>
                </tr>
            </table>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>PENGUNCIAN FORMULA SAAT PERIODE PELAPORAN BERJALAN:</strong><br>
                Administrator dilarang mengubah tipe kalkulasi saat periode pelaporan triwulan sedang dalam status aktif/terbuka. Perubahan formula hanya dapat dieksekusi setelah seluruh satker menyelesaikan siklus triwulan aktif.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 34 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 35: BAB VIII - 8.1 MANAJEMEN TEMPLATE WORD (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-35">
        <div class="header">
            <span>BAB VIII: TEMPLATE LKJIP &amp; PELAPORAN</span>
            <span>8.1 MANAJEMEN TEMPLATE DOKUMEN WORD</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VIII: BUILDER TEMPLATE LKJIP &amp; PELAPORAN</div>
            <h2 class="title-primary">8.1 MANAJEMEN TEMPLATE DOKUMEN WORD LKjIP SAKIP</h2>

            <p class="paragraph">
                Penyusunan Laporan Kinerja (LKjIP) di e-LAPTRI v4 tidak lagi menggunakan cara manual salin-tempel ke Microsoft Word. Modul <strong>Template Builder LKjIP</strong> memisahkan desain dokumen dinas dari data transaksi kinerja secara elegan:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_template')}" class="screenshot-img" alt="Manajemen Template Dokumen LKjIP Word">
                <div class="screenshot-caption">Gambar 8.1: Modul Manajemen Template Dokumen Word LKjIP Berstandar Resmi Kejaksaan RI</div>
            </div>

            <h3 class="subtitle-primary">FASILITAS PENGELOLAAN TEMPLATE LAPORAN:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Daftar Template Tersimpan:</strong><br>
                    Menampilkan seluruh versi template Word (.docx) yang pernah diunggah, lengkap dengan stempel waktu, status aktif, dan nama administrator.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[2] Penanda Template Aktif (Default):</strong><br>
                    Satu template ditandai dengan badge hijau <em>Aktif</em> sebagai rujukan utama yang akan dipakai saat tombol ekspor ditekan oleh pengguna.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[3] Tombol Upload Template Baru:</strong><br>
                    Memungkinkan administrator mengunggah berkas Word (.docx) rancangan baru yang telah disesuaikan tata letak dan logo kedinasannya.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #7c3aed;">[4] Unduh Template Asli (Download Base):</strong><br>
                    Administrator dapat mengunduh master template baku untuk melihat susunan tag placeholder sebelum melakukan modifikasi desain.
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>KEMUDAHAN PENYESUAIAN FORMAT DINAS:</strong><br>
                Jika Sekretariat JAMBIN menetapkan perubahan tata letak surat resmi atau penambahan kata sambutan, administrator cukup memperbarui berkas Word tanpa perlu mengubah baris kode program (*zero-code styling*).
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 35 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 36: BAB VIII - 8.2 STANDARDISASI PLACEHOLDER WORD
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-36">
        <div class="header">
            <span>BAB VIII: TEMPLATE LKJIP &amp; PELAPORAN</span>
            <span>8.2 KAMUS PLACEHOLDER DINAMIS PHPWORD</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VIII: BUILDER TEMPLATE LKJIP &amp; PELAPORAN</div>
            <h2 class="title-primary">8.2 STANDARDISASI PLACEHOLDER &amp; TAGGING DINAMIS PHPWORD</h2>

            <p class="paragraph">
                Generator dokumen e-LAPTRI v4 bekerja dengan membaca token penanda <em>(placeholder tags)</em> di dalam berkas Microsoft Word (.docx). Saat proses ekspor dijalankan, engine PHPWord mengganti setiap token dengan data kinerja riil:
            </p>

            <table class="table-styled" style="font-size: 7.2pt; margin-top: 4px;">
                <tr>
                    <th style="width: 25%;">Token Placeholder Word</th>
                    <th style="width: 35%;">Format Data yang Dihasilkan</th>
                    <th>Contoh Nilai Pengganti Otomatis</th>
                </tr>
                <tr>
                    <td><code>${{TAHUN}}</code></td>
                    <td>Tahun anggaran evaluasi kinerja.</td>
                    <td><strong>2026</strong></td>
                </tr>
                <tr>
                    <td><code>${{TRIWULAN}}</code></td>
                    <td>Nomor triwulan angka romawi.</td>
                    <td><strong>Triwulan I (Satu)</strong></td>
                </tr>
                <tr>
                    <td><code>${{NAMA_JAMBIN}}</code></td>
                    <td>Nama pejabat pimpinan pengarah JAMBIN.</td>
                    <td><strong>Dr. Hendro Dewanto, S.H., M.Hum.</strong></td>
                </tr>
                <tr>
                    <td><code>${{JABATAN_JAMBIN}}</code></td>
                    <td>Nomenklatur jabatan pimpinan kedinasan.</td>
                    <td><strong>Jaksa Agung Muda Bidang Pembinaan</strong></td>
                </tr>
                <tr>
                    <td><code>${{TANGGAL_CETAK}}</code></td>
                    <td>Tanggal penerbitan dokumen laporan resmi.</td>
                    <td><strong>10 April 2026</strong></td>
                </tr>
                <tr>
                    <td><code>${{TABEL_IKSS}}</code></td>
                    <td>Tabel kompilasi capaian SS &amp; IKSS Makro.</td>
                    <td>Tabel 2 IKSS lengkap dengan target &amp; realisasi.</td>
                </tr>
                <tr>
                    <td><code>${{TABEL_IKP}}</code></td>
                    <td>Tabel rekapitulasi 20 Indikator Program.</td>
                    <td>Tabel 20 IKP beserta analisis capaian triwulan.</td>
                </tr>
                <tr>
                    <td><code>${{TABEL_IKK}}</code></td>
                    <td>Tabel detail 97 Indikator Kegiatan Satker.</td>
                    <td>Tabel 97 IKK lengkap dengan pembilang &amp; penyebut.</td>
                </tr>
                <tr>
                    <td><code>${{KENDALA_UTAMA}}</code></td>
                    <td>Kompilasi narasi kendala paling kritis.</td>
                    <td>Paragraf uraian hambatan prioritas antar-biro.</td>
                </tr>
                <tr>
                    <td><code>${{SOLUSI_TINDAK_LANJUT}}</code></td>
                    <td>Kompilasi rekomendasi aksi perbaikan.</td>
                    <td>Langkah strategis mitigasi triwulan berikutnya.</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 8px;">ATURAN PENGETIKAN TAG PLACEHOLDER PADA MICROSOFT WORD:</h3>
            <div class="callout callout-warning">
                <strong>PANDUAN PENGETIKAN TAG AGAR TIDAK EROR:</strong>
                <ul style="margin: 3px 0 0 14px; padding: 0; line-height: 1.35;">
                    <li>Ketikkan tag secara langsung tanpa putus: <code>${{NAMA_JAMBIN}}</code>. Jangan menyalin sebagian atau mengganti gaya huruf di tengah tag.</li>
                    <li>Hindari format teks terpisah dalam satu kurung kurawal (jangan membuat huruf <code>NAMA</code> tebal sementara kurung kurawal biasa).</li>
                    <li>Gunakan font standar seperti Arial, Calibri, atau Times New Roman pada master template dokumen Word Anda.</li>
                </ul>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 36 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 37: BAB VIII - 8.3 PROSEDUR UPLOAD CUSTOM TEMPLATE
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-37">
        <div class="header">
            <span>BAB VIII: TEMPLATE LKJIP &amp; PELAPORAN</span>
            <span>8.3 PROSEDUR UPLOAD CUSTOM TEMPLATE</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VIII: BUILDER TEMPLATE LKJIP &amp; PELAPORAN</div>
            <h2 class="title-primary">8.3 PROSEDUR UNGGAH CUSTOM TEMPLATE &amp; VALIDASI SISTEM</h2>

            <p class="paragraph">
                Administrator dapat memperbarui format dokumen LKjIP kapan saja tanpa bantuan pengembang perangkat lunak. Prosedur pengunggahan custom template dilaksanakan melalui 4 tahapan sistematis berikut:
            </p>

            <div style="display: grid; grid-template-columns: 1fr; gap: 6px; margin: 8px 0;">
                <div style="background: #f8fafc; border-left: 3.5px solid #0284c7; padding: 6px 10px; border-radius: 4px;">
                    <strong style="color: #0369a1; font-size: 8pt;">Langkah 1: Unduh Master Template Rujukan</strong>
                    <div style="font-size: 7.2pt; color: #334155; margin-top: 2px;">
                        Klik tombol <strong>Download Default Template</strong> pada modul template e-LAPTRI v4. Berkas <code>template_lkjip_jambin_master.docx</code> akan terunduh ke komputer Anda sebagai basis acuan desain.
                    </div>
                </div>

                <div style="background: #f8fafc; border-left: 3.5px solid #059669; padding: 6px 10px; border-radius: 4px;">
                    <strong style="color: #064e3b; font-size: 8pt;">Langkah 2: Modifikasi Tata Letak Dokumen di Microsoft Word</strong>
                    <div style="font-size: 7.2pt; color: #334155; margin-top: 2px;">
                        Buka berkas di MS Word. Anda bebas mengubah kop surat resmi, jenis font kedinasan, batas margin halaman, atau kata sambutan. Pastikan tag placeholder penting (seperti <code>${{NAMA_JAMBIN}}</code> dan <code>${{TABEL_IKK}}</code>) tetap dipertahankan.
                    </div>
                </div>

                <div style="background: #f8fafc; border-left: 3.5px solid #d97706; padding: 6px 10px; border-radius: 4px;">
                    <strong style="color: #92400e; font-size: 8pt;">Langkah 3: Unggah Berkas &amp; Validasi Sintaks Otomatis</strong>
                    <div style="font-size: 7.2pt; color: #334155; margin-top: 2px;">
                        Buka kembali modul template di peramban, klik <strong>Upload Template</strong>, pilih berkas <code>.docx</code> yang telah disunting, beri label nama versi (misal: <em>Template LKjIP Edisi Renstra 2026</em>), lalu klik <strong>Simpan</strong>. Sistem akan memvalidasi apakah tag XML di dalam berkas terbaca sempurna.
                    </div>
                </div>

                <div style="background: #f8fafc; border-left: 3.5px solid #7c3aed; padding: 6px 10px; border-radius: 4px;">
                    <strong style="color: #5b21b6; font-size: 8pt;">Langkah 4: Aktivasi Template Sebagai Rujukan Utama</strong>
                    <div style="font-size: 7.2pt; color: #334155; margin-top: 2px;">
                        Setelah berkas terunggah, klik tombol <strong>Aktifkan</strong> pada baris template tersebut. Sistem secara otomatis mengalihkan generator dokumen untuk menggunakan template baru ini saat pengguna melakukan ekspor laporan.
                    </div>
                </div>
            </div>

            <h3 class="subtitle-primary">FITUR RESET KE PENGATURAN AWAL (FACTORY RESET):</h3>
            <div class="callout callout-info">
                <strong>TOMBOL RESET KE TEMPLATE DEFAULT:</strong><br>
                Jika berkas custom yang diunggah mengalami kerusakan format atau susunan tabel berantakan saat dibuka, administrator dapat mengeklik tombol <strong>Reset Default Template</strong>. Sistem akan mengembalikan template ke kondisi baku awal yang teruji secara instan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 37 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 38: BAB VIII - 8.4 EKSPOR LKJIP WORD (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-38">
        <div class="header">
            <span>BAB VIII: TEMPLATE LKJIP &amp; PELAPORAN</span>
            <span>8.4 MODUL EKSPOR LAPORAN LKJIP WORD</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VIII: BUILDER TEMPLATE LKJIP &amp; PELAPORAN</div>
            <h2 class="title-primary">8.4 MODUL EKSPOR LAPORAN LKjIP TRIWULANAN &amp; HASIL DOCX</h2>

            <p class="paragraph">
                Puncak dari seluruh proses perekaman dan audit kinerja adalah penerbitan <strong>Laporan Kinerja Instansi Pemerintah (LKjIP)</strong> triwulanan. Melalui modul <strong>Ekspor Laporan</strong>, dokumen resmi berpuluh-puluh halaman dapat dihasilkan dalam hitungan detik:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_export')}" class="screenshot-img" alt="Modul Ekspor Laporan LKjIP Triwulanan Word">
                <div class="screenshot-caption">Gambar 8.2: Antarmuka Modul Ekspor Laporan LKjIP Triwulanan ke Berkas Microsoft Word (.docx)</div>
            </div>

            <h3 class="subtitle-primary">3 LANGKAH MUDAH PENERBITAN DOKUMEN RESMI LKjIP:</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div class="feature-box">
                    <strong style="color: #0369a1;">[1] Tentukan Periode:</strong>
                    <p style="font-size: 6.9pt; color: #475569; margin: 2px 0 0 0; line-height: 1.3;">
                        Pilih Tahun Anggaran (misal 2026) dan Triwulan yang akan dilaporkan pada bilah dropdown pemilih.
                    </p>
                </div>
                <div class="feature-box">
                    <strong style="color: #064e3b;">[2] Klik Unduh Word:</strong>
                    <p style="font-size: 6.9pt; color: #475569; margin: 2px 0 0 0; line-height: 1.3;">
                        Klik tombol biru <strong>Unduh Dokumen Word (.docx)</strong>. Sistem akan mengompilasi seluruh data terverifikasi secara asinkron.
                    </p>
                </div>
                <div class="feature-box">
                    <strong style="color: #d97706;">[3] Siap Tanda Tangan:</strong>
                    <p style="font-size: 6.9pt; color: #475569; margin: 2px 0 0 0; line-height: 1.3;">
                        Berkas terunduh otomatis ke folder Download komputer, lengkap dengan cover, tabel rapi, dan kolom pengesahan pimpinan.
                    </p>
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>STRUKTUR KELUARAN DOKUMEN LKjIP BAKU:</strong><br>
                Dokumen hasil unduhan telah memuat: Cover Judul Dinas, Lembar Pengesahan, Kata Pengantar atas nama <strong>Dr. Hendro Dewanto, S.H., M.Hum.</strong>, Daftar Isi, Bab I Pendahuluan, Bab II Rencana Strategis, Bab III Akuntabilitas Kinerja (Tabel IKSS, IKP, IKK, Kendala &amp; Solusi), serta Bab IV Penutup.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 38 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 39: BAB IX - 9.1 TROUBLESHOOTING & FAQ
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-39">
        <div class="header">
            <span>BAB IX: PANDUAN TROUBLESHOOTING</span>
            <span>9.1 PEMECAHAN MASALAH UMUM (FAQ)</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IX: TROUBLESHOOTING &amp; HELPDESK SAKIP</div>
            <h2 class="title-primary">9.1 PEMECAHAN MASALAH UMUM (TROUBLESHOOTING &amp; FAQ)</h2>

            <p class="paragraph">
                Berikut adalah panduan solusi cepat atas kendala teknis operasional yang paling sering dihadapi oleh operator maupun administrator selama siklus pelaporan berlangsung:
            </p>

            <div style="display: grid; grid-template-columns: 1fr; gap: 5px; margin-top: 4px;">
                <div class="faq-item">
                    <div class="faq-q">1. Mengapa nilai realisasi tetap 0% padahal saya sudah mengisi angka pembilang?</div>
                    <div class="faq-a">
                        Periksa ruas penyebut ($X_2$). Pada rumus bertipe <code>RATIO</code>, realisasi adalah hasil pembagian $X_1$ terhadap $X_2$. Jika penyebut masih kosong atau bernilai nol, sistem tidak dapat menghitung persentase. Pastikan kedua kolom terisi angka valid.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-q">2. Mengapa formulir input terkunci dan seluruh tombol simpan tidak bisa diklik?</div>
                    <div class="faq-a">
                        Status pengukuran satker Anda telah berada dalam posisi <code>SUBMITTED</code> atau <code>APPROVED</code>, atau batas waktu triwulan telah ditutup. Jika terdapat revisi darurat, hubungi Verifikator JAMBIN di Biro Perencanaan untuk membuka kunci data.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-q">3. Sesi tiba-tiba logout dan muncul pesan "419 Page Expired" saat menekan tombol submit?</div>
                    <div class="faq-a">
                        Token keamanan CSRF peramban telah kedaluwarsa karena halaman didiamkan terlalu lama tanpa aktivitas. Muat ulang halaman (*refresh / F5*), login kembali, lalu periksa data Anda. Fitur autosave telah menyimpan sebagian besar ketikan Anda sebelumnya.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-q">4. Dokumen Word hasil ekspor memunculkan tag mentah seperti ${{NAMA_JAMBIN}} alih-alih teks nama?</div>
                    <div class="faq-a">
                        Terdapat kesalahan pengetikan spasi atau format karakter pada master template Word yang diunggah. Buka modul <em>Template LKjIP</em> lalu klik <strong>Reset Default Template</strong> untuk memulihkan master template standar yang valid.
                    </div>
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 6px;">
                <strong>PEMBERSIHAN TEMPORARY CACHE BROWSER:</strong><br>
                Jika tampilan grafik atau tabel data tampak tidak sinkron setelah adanya pembaruan sistem oleh Pusdaskrimti, tekan tombol kombinasi <code>Ctrl + F5</code> (Hard Refresh) pada peramban Anda untuk mengosongkan cache lama.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 39 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 40: BAB IX - 9.2 HELPDESK & PENGESAHAN PENUTUP
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-40">
        <div class="header">
            <span>BAB IX: PANDUAN TROUBLESHOOTING</span>
            <span>9.2 HELPDESK &amp; LEMBAR PENGESAHAN AKHIR</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IX: TROUBLESHOOTING &amp; HELPDESK SAKIP</div>
            <h2 class="title-primary">9.2 STANDAR PELAYANAN HELPDESK &amp; PENGESAHAN PENUTUP</h2>

            <p class="paragraph">
                Apabila kendala teknis atau permohonan pembetulan data pasca-approval tidak dapat diselesaikan melalui prosedur mandiri, satuan kerja dapat memanfaatkan kanal layanan resmi Helpdesk e-LAPTRI JAMBIN:
            </p>

            <table class="table-styled" style="font-size: 7.2pt; margin-top: 4px;">
                <tr>
                    <th style="width: 25%;">Kanal Layanan</th>
                    <th style="width: 35%;">Unit Penanggung Jawab</th>
                    <th>Cakupan Bantuan &amp; Kontak Resmi</th>
                </tr>
                <tr>
                    <td><strong>Helpdesk SAKIP &amp; Rumus</strong></td>
                    <td>Bagian Evaluasi &amp; Pelaporan Kinerja, Biro Perencanaan Kejagung RI</td>
                    <td>Konsultasi substansi indikator, reviu LKjIP, pembetulan target, pembukaan kunci data revisi.<br><strong>Gedung Utama Kejagung Lt. 6</strong></td>
                </tr>
                <tr>
                    <td><strong>Helpdesk IT &amp; Server</strong></td>
                    <td>Subdit Pengelolaan Sistem Informasi, Pusdaskrimti Kejagung RI</td>
                    <td>Kendala gagal login, reset kata sandi darurat, bug antarmuka, gangguan koneksi jaringan.<br><strong>Ext. 1240 / helpdesk@kejaksaan.go.id</strong></td>
                </tr>
            </table>

            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; margin: 8px 0;">
                <div style="font-size: 7.5pt; font-weight: 800; color: #0f172a; margin-bottom: 2px;">
                    PROSEDUR BERITA ACARA PEMBETULAN DATA KINERJA (BAP-DK):
                </div>
                <div style="font-size: 6.9pt; color: #475569; line-height: 1.35;">
                    Setiap pembetulan data kinerja yang telah berstatus <code>APPROVED</code> wajib disertai <strong>Surat Permohonan Resmi / Nota Dinas</strong> yang ditandatangani oleh Kepala Biro / Kepala Pusat bersangkutan yang ditujukan kepada Sekretaris JAMBIN guna menjaga integritas audit SAKIP.
                </div>
            </div>

            <div style="margin-top: 14px; border-top: 1.5px solid #cbd5e1; padding-top: 10px; display: flex; justify-content: space-between; align-items: flex-end;">
                <div style="width: 50%;">
                    <div style="font-size: 7.5pt; color: #64748b; font-weight: 700;">DITERBITKAN SECARA RESMI DI JAKARTA:</div>
                    <div style="font-size: 7.2pt; color: #334155; margin-top: 2px; line-height: 1.35;">
                        Buku Manual Operasional e-LAPTRI v4 ini dinyatakan sah dan berlaku mengikat sebagai Standar Operasional Prosedur bagi seluruh jajaran di lingkungan Jaksa Agung Muda Bidang Pembinaan sejak tanggal ditetapkan.
                    </div>
                </div>

                <div style="width: 44%; text-align: center;">
                    <div style="font-size: 7.8pt; color: #64748b;">Ditetapkan di Jakarta, Maret 2026</div>
                    <div style="font-size: 8.5pt; font-weight: 800; color: #0f172a; margin-top: 2px;">Jaksa Agung Muda Bidang Pembinaan</div>
                    <div style="height: 38px; display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 7pt; color: #94a3b8; font-style: italic;">[ Tanda Tangan &amp; Cap Kedinasan ]</span>
                    </div>
                    <div style="font-size: 9.5pt; font-weight: 800; color: #0f172a; text-decoration: underline;">Dr. HENDRO DEWANTO, S.H., M.Hum.</div>
                    <div style="font-size: 7.8pt; color: #475569;">Jaksa Utama Madya</div>
                </div>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 40 dari 40</span>
        </div>
    </div>
    """)

    return pages
