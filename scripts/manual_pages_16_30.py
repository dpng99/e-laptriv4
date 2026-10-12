# -*- coding: utf-8 -*-
"""
Modul Halaman 16 sampai 30:
- Halaman 16: BAB III - 3.2 Prosedur Login & Autentikasi Sistem [Screenshot Login]
- Halaman 17: BAB III - 3.3 Manajemen Profil, Perubahan Kata Sandi [Screenshot Profil]
- Halaman 18: BAB IV - 4.1 Antarmuka Utama Operator & Widget Status [Screenshot Dashboard Opr]
- Halaman 19: BAB IV - 4.2 Visualisasi Grafik Kinerja & Analisis Tren [Screenshot Charts]
- Halaman 20: BAB IV - 4.3 Monitoring Status Periode Pelaporan Triwulan I - IV
- Halaman 21: BAB V - 5.1 Struktur Form Input Dinamis & Tab Level [Screenshot Input SP]
- Halaman 22: BAB V - 5.2 Pengisian Komponen Rumus Rasio (X1 & X2) [Screenshot Details]
- Halaman 23: BAB V - 5.3 Perbedaan Indikator Mandiri vs Indikator Agregatif
- Halaman 24: BAB V - 5.4 Kalkulasi Otomatis Realisasi & Capaian Target
- Halaman 25: BAB V - 5.5 Penyusunan Analisis Kinerja: Kendala & Solusi [Screenshot Analisis]
- Halaman 26: BAB V - 5.6 Mekanisme Autosave, Validasi Input & Evidence
- Halaman 27: BAB V - 5.7 Finalisasi Data & Prosedur Submit ke JAMBIN
- Halaman 28: BAB VI - 6.1 Dashboard Pemantauan Kinerja Nasional [Screenshot Dashboard Admin]
- Halaman 29: BAB VI - 6.2 Monitoring Kepatuhan Pengisian Seluruh Satker Eselon II
- Halaman 30: BAB VI - 6.3 Halaman Review Data: Filter & DataGrid [Screenshot Review Index]
"""

def get_pages_16_to_30(assets):
    pages = []

    # ==========================================
    # HALAMAN 16: BAB III - 3.2 PROSEDUR LOGIN
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-16">
        <div class="header">
            <span>BAB III: HAK AKSES & KEAMANAN</span>
            <span>3.2 PROSEDUR LOGIN SISTEM</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB III: HAK AKSES, AUTENTIKASI & KEAMANAN SISTEM</div>
            <h2 class="title-primary">3.2 PROSEDUR LOGIN & AUTENTIKASI SISTEM</h2>
            
            <p class="paragraph">
                Akses ke dalam portal e-LAPTRI dilakukan melalui browser web modern (Google Chrome, Microsoft Edge, atau Mozilla Firefox) dengan mengakses alamat portal resmi internal Kejaksaan RI:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_login']}" class="screenshot-img" style="max-height: 110mm;">
                <div class="screenshot-caption">Gambar 3.1: Antarmuka Halaman Login Resmi Aplikasi e-LAPTRI Kejaksaan RI</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">LANGKAH-LANGKAH MASUK KE SISTEM:</h3>
            <ol style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li>Buka browser dan arahkan ke URL <code>https://elaptri.kejaksaan.go.id</code> (atau port lokal pengujian).</li>
                <li>Pada kotak <strong>Username</strong>, masukkan ID pengguna resmi satuan kerja (contoh: <code>ro.ren</code>, <code>ro.peg</code>, atau <code>admin.jambin</code>).</li>
                <li>Pada kotak <strong>Password</strong>, masukkan kata sandi kedinasan yang terdaftar.</li>
                <li>Centang opsi <em>"Ingat Saya" (Remember Me)</em> jika menggunakan komputer dinas pribadi terpercaya.</li>
                <li>Klik tombol <strong>MASUK KE SISTEM</strong>. Sistem akan memverifikasi kredensial dan mengarahkan pengguna ke Dashboard sesuai peran masing-masing.</li>
            </ol>

            <div class="callout callout-warning">
                <strong>PERINGATAN KEAMANAN:</strong><br>
                Sistem e-LAPTRI membatasi percobaan gagal login maksimal 5 kali berturut-turut. Jika akun terkunci, hubungi Administrator Pusdaskrimti untuk prosedur pembukaan blokir <em>(unlock account)</em>.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 16 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 17: BAB III - 3.3 PROFIL & GANTI PASSWORD
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-17">
        <div class="header">
            <span>BAB III: HAK AKSES & KEAMANAN</span>
            <span>3.3 MANAJEMEN PROFIL & PASSWORD</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB III: HAK AKSES, AUTENTIKASI & KEAMANAN SISTEM</div>
            <h2 class="title-primary">3.3 MANAJEMEN PROFIL, PERUBAHAN KATA SANDI & SESI</h2>
            
            <p class="paragraph">
                Untuk menjaga kerahasiaan dan keamanan data kinerja, setiap Operator Satker diwajibkan memperbarui kata sandi default pada saat pertama kali login dan secara berkala setiap 90 hari melalui halaman Profil:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_profile']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 3.2: Halaman Manajemen Informasi Akun dan Pembaruan Kata Sandi</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">PROSEDUR PENGGANTIAN KATA SANDI:</h3>
            <ol style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li>Klik nama pengguna pada pojok kanan atas bilah navigasi, lalu pilih menu <strong>Profil Akun</strong>.</li>
                <li>Pada bagian <em>Perbarui Kata Sandi (Update Password)</em>, masukkan kata sandi lama pada kolom <strong>Current Password</strong>.</li>
                <li>Ketikkan kata sandi baru yang kuat pada kolom <strong>New Password</strong> (minimal 8 karakter kombinasi huruf besar, kecil, angka, dan simbol).</li>
                <li>Ulangi pengetikan kata sandi baru pada kolom <strong>Confirm Password</strong>.</li>
                <li>Klik tombol <strong>SIMPAN PERUBAHAN</strong>. Notifikasi konfirmasi akan muncul setelah kata sandi berhasil diperbarui.</li>
            </ol>

            <div class="callout callout-info">
                <strong>TERMINASI SESI (LOGOUT):</strong><br>
                Selalu akhiri penggunaan aplikasi dengan menekan tombol <strong>Keluar (Logout)</strong> sebelum menutup browser, terutama jika menggunakan perangkat kerja bersama (shared PC).
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 17 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 18: BAB IV - 4.1 DASHBOARD OPERATOR
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-18">
        <div class="header">
            <span>BAB IV: PANDUAN OPERATOR SATKER</span>
            <span>4.1 DASHBOARD UTAMA OPERATOR</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IV: PANDUAN OPERATOR SATKER: DASHBOARD & NAVIGASI</div>
            <h2 class="title-primary">4.1 ANTARMUKA UTAMA OPERATOR & WIDGET STATUS REAL-TIME</h2>
            
            <p class="paragraph">
                Setelah berhasil masuk, Operator Satker disambut oleh Dashboard Interaktif yang menampilkan ringkasan status pengisian dan ketercapaian kinerja satuan kerjanya:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_dashboard']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 4.1: Dashboard Utama Operator Satker (Biro Perencanaan)</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">ANATOMI WIDGET & STATISTIK UTAMA:</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 28%;">Nama Widget</th>
                    <th>Fungsi dan Keterangan Analitis</th>
                </tr>
                <tr>
                    <td><strong>Hero Banner Identitas</strong></td>
                    <td>Menampilkan salam kedinasan, nama resmi Satker Eselon II (contoh: Biro Perencanaan), periode aktif (Tahun 2026 Triwulan II), serta shortcut cepat menuju menu Input Data.</td>
                </tr>
                <tr>
                    <td><strong>Total Indikator</strong></td>
                    <td>Jumlah seluruh IKP dan IKK yang menjadi tanggung jawab satuan kerja bersangkutan berdasarkan penugasan Renstra 2025-2029.</td>
                </tr>
                <tr>
                    <td><strong>Indikator Terisi</strong></td>
                    <td>Menghitung berapa indikator yang telah memiliki data pengukuran lengkap (nilai pembilang, penyebut, realisasi, dan narasi analisis).</td>
                </tr>
                <tr>
                    <td><strong>Rata-Rata Capaian (%)</strong></td>
                    <td>Tingkat efektivitas kinerja agregat terhadap target triwulanan yang ditetapkan.</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 18 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 19: BAB IV - 4.2 VISUALISASI GRAFIK
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-19">
        <div class="header">
            <span>BAB IV: PANDUAN OPERATOR SATKER</span>
            <span>4.2 VISUALISASI GRAFIK KINERJA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IV: PANDUAN OPERATOR SATKER: DASHBOARD & NAVIGASI</div>
            <h2 class="title-primary">4.2 VISUALISASI GRAFIK KINERJA & ANALISIS TREN</h2>
            
            <p class="paragraph">
                Dashboard e-LAPTRI dilengkapi diagram grafis dinamis berbasis Chart.js & Material UI untuk memudahkan visualisasi pencapaian indikator:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_charts']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 4.2: Visualisasi Diagram Lingkar Progres dan Diagram Batang Capaian SK</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">INTERPRETASI VISUAL DIAGRAM:</h3>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Progress Pie Chart (Kiri):</strong> Menggambarkan persentase rasio indikator yang sudah diisi secara lengkap (warna hijau) dibandingkan yang masih berstatus draf kosong (warna abu-abu).</li>
                <li><strong>Sasaran Kegiatan Bar Chart (Tengah):</strong> Membandingkan target persentase (garis patokan) dengan realisasi aktual tiap Sasaran Kegiatan (SK 1, SK 2, dst.), membantu operator mengidentifikasi kegiatan mana yang di bawah target.</li>
                <li><strong>Status Pie Chart (Kanan):</strong> Mengklasifikasikan hasil pengukuran ke dalam 3 zona performa:
                    <span style="color: #059669; font-weight: 700;">Tercapai (≥ 100%)</span>, 
                    <span style="color: #d97706; font-weight: 700;">Belum Tercapai (80% - 99.9%)</span>, dan 
                    <span style="color: #dc2626; font-weight: 700;">Tidak Tercapai (&lt; 80%)</span>.
                </li>
            </ul>

            <div class="callout callout-info">
                <strong>FITUR DRILL-DOWN GRAFIK:</strong><br>
                Arahkan kursor mouse ke setiap batang atau sektor diagram untuk melihat nilai detail nominal pembilang, penyebut, dan target snapshot indikator bersangkutan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 19 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 20: BAB IV - 4.3 MONITORING STATUS PERIODE
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-20">
        <div class="header">
            <span>BAB IV: PANDUAN OPERATOR SATKER</span>
            <span>4.3 SIKLUS PELAPORAN TRIWULANAN</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IV: PANDUAN OPERATOR SATKER: DASHBOARD & NAVIGASI</div>
            <h2 class="title-primary">4.3 MONITORING STATUS PERIODE PELAPORAN (TRIWULAN I - IV)</h2>
            
            <p class="paragraph">
                Pelaporan e-LAPTRI mengikuti siklus triwulanan yang ketat. Setiap triwulan memiliki tanggal batas akhir <em>(cut-off date)</em> pengisian dan validasi data:
            </p>

            <table class="table-styled" style="font-size: 8pt; margin: 15px 0;">
                <tr>
                    <th style="width: 16%;">Periode</th>
                    <th style="width: 28%;">Bulan Pelaksanaan</th>
                    <th style="width: 26%;">Batas Akhir Input Satker</th>
                    <th>Jadwal Review & Ekspor LKjIP</th>
                </tr>
                <tr>
                    <td><strong>Triwulan I</strong></td>
                    <td>Januari s/d Maret</td>
                    <td>10 April</td>
                    <td>11 - 20 April (Review & Cetak LKjIP TW I)</td>
                </tr>
                <tr>
                    <td><strong>Triwulan II</strong></td>
                    <td>April s/d Juni</td>
                    <td>10 Juli</td>
                    <td>11 - 20 Juli (Review & Cetak LKjIP TW II)</td>
                </tr>
                <tr>
                    <td><strong>Triwulan III</strong></td>
                    <td>Juli s/d September</td>
                    <td>10 Oktober</td>
                    <td>11 - 20 Oktober (Review & Cetak LKjIP TW III)</td>
                </tr>
                <tr>
                    <td><strong>Triwulan IV</strong></td>
                    <td>Oktober s/d Desember</td>
                    <td>10 Januari (Tahun Berikutnya)</td>
                    <td>11 - 25 Januari (Konsolidasi LKjIP Tahunan)</td>
                </tr>
            </table>

            <h3 class="subtitle-primary">LIFECYCLE STATUS DATA PENGUKURAN:</h3>
            <div style="display: flex; justify-content: space-between; align-items: center; text-align: center; font-size: 8pt; margin: 15px 0;">
                <div style="background: #f1f5f9; border: 1px solid #94a3b8; border-radius: 6px; padding: 10px; width: 22%;">
                    <strong style="color: #475569;">1. DRAFT</strong><br>
                    Data disimpan lokal oleh Operator Satker. Bebas diedit.
                </div>
                <span style="font-weight: 800; color: #64748b;">➔</span>
                <div style="background: #e0f2fe; border: 1px solid #0284c7; border-radius: 6px; padding: 10px; width: 22%;">
                    <strong style="color: #0284c7;">2. SUBMITTED</strong><br>
                    Diajukan ke JAMBIN. Form terkunci read-only.
                </div>
                <span style="font-weight: 800; color: #64748b;">➔</span>
                <div style="background: #dcfce7; border: 1px solid #059669; border-radius: 6px; padding: 10px; width: 22%;">
                    <strong style="color: #059669;">3. APPROVED</strong><br>
                    Disahkan Verifikator. Masuk rekapitulasi LKjIP resmi.
                </div>
                <span style="font-weight: 800; color: #64748b;">➔</span>
                <div style="background: #fee2e2; border: 1px solid #dc2626; border-radius: 6px; padding: 10px; width: 22%;">
                    <strong style="color: #dc2626;">4. REVISION</strong><br>
                    Dikembalikan verifikator. Wajib diperbaiki satker.
                </div>
            </div>

            <div class="callout callout-warning">
                <strong>ATURAN CUT-OFF OTOMATIS:</strong><br>
                Setelah batas waktu <em>cut-off date</em> berakhir, sistem akan mengunci form input secara otomatis. Permohonan pembukaan kembali masa pengisian <em>(open lock)</em> harus melalui persetujuan tertulis Kepala Biro Perencanaan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 20 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 21: BAB V - 5.1 STRUKTUR FORM INPUT
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-21">
        <div class="header">
            <span>BAB V: PANDUAN OPERATOR SATKER</span>
            <span>5.1 STRUKTUR FORM INPUT DINAMIS</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN KINERJA</div>
            <h2 class="title-primary">5.1 STRUKTUR FORM INPUT DINAMIS & NAVIGASI TAB LEVEL</h2>
            
            <p class="paragraph">
                Menu <strong>Input Data</strong> (`/input-data`) dirancang dengan antarmuka dinamis modern yang memandu operator menginput capaian kinerja per tingkatan hierarki:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_input_sp']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 5.1: Antarmuka Form Input Pengukuran Kinerja Sasaran Program & Kegiatan</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">KOMPONEN PENGENDALI FORM:</h3>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Toolbar Filter Periode (Atas):</strong> Memungkinkan operator berganti Tahun Anggaran (2025-2029) dan Triwulan Pelaporan (TW I, II, III, IV).</li>
                <li><strong>Level Navigation Tabs:</strong> Tab peralihan antara <em>Sasaran Program (SP / IKP)</em> dan <em>Sasaran Kegiatan (SK / IKK)</em>. Operator hanya akan melihat tab yang menjadi tugas unitnya.</li>
                <li><strong>Accordion Sasaran Kegiatan:</strong> Setiap SK dikemas dalam wadah accordion yang dapat dibuka/tutup secara mandiri untuk kemudahan navigasi layar.</li>
                <li><strong>Header Info Card:</strong> Menampilkan kode indikator, nama resmi Renstra, satuan pengukuran (persen/indeks/dokumen), target triwulan, dan unit pengampu.</li>
            </ul>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 21 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 22: BAB V - 5.2 KOMPONEN RUMUS RASIO
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-22">
        <div class="header">
            <span>BAB V: PANDUAN OPERATOR SATKER</span>
            <span>5.2 KOMPONEN RUMUS RASIO</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN KINERJA</div>
            <h2 class="title-primary">5.2 PENGISIAN KOMPONEN RUMUS RASIO (X1 & X2)</h2>
            
            <p class="paragraph">
                Untuk indikator bertipe <strong>RATIO</strong>, sistem mengharuskan operator mengisi nilai mentah dari dua komponen rumus dasar, yaitu Pembilang ($X_1$) dan Penyebut ($X_2$):
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_input_details']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 5.2: Bidang Input Variabel Mentah Komponen Rumus dan Kalkulasi Otomatis</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">ATURAN PENGISIAN VARIABEL MENTAH:</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 25%;">Komponen Input</th>
                    <th style="width: 35%;">Makna Operasional</th>
                    <th>Contoh Nilai Nyata</th>
                </tr>
                <tr>
                    <td><strong>Pembilang ($X_1$)</strong></td>
                    <td>Jumlah unit, berkas, atau kegiatan yang telah selesai diselesaikan pada triwulan berjalan.</td>
                    <td>Contoh: <code>45</code> dokumen telaahan hukum yang selesai diharmonisasi.</td>
                </tr>
                <tr>
                    <td><strong>Penyebut ($X_2$)</strong></td>
                    <td>Total populasi atau target beban kerja keseluruhan yang masuk/ditugaskan pada periode tersebut.</td>
                    <td>Contoh: <code>50</code> rancangan regulasi yang diterima oleh Biro Hukum.</td>
                </tr>
                <tr>
                    <td><strong>Realisasi Otomatis</strong></td>
                    <td>Dihitung otomatis oleh engine sistem: (X1 / X2) &times; 100%.</td>
                    <td>Hasil: (45 / 50) &times; 100% = <strong>90.00%</strong>. Field ini terkunci (read-only).</td>
                </tr>
            </table>

            <div class="callout callout-warning">
                <strong>PENCEGAHAN KESALAHAN MATEMATIS (DIVISION BY ZERO):</strong><br>
                Jika penyebut ($X_2$) bernilai 0 (karena belum ada kegiatan), sistem secara cerdas mengatur realisasi menjadi 0.00% dan memunculkan peringatan kuning agar operator mengisi justifikasi pada kolom kendala.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 22 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 23: BAB V - 5.3 MANDIRI VS AGREGATIF
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-23">
        <div class="header">
            <span>BAB V: PANDUAN OPERATOR SATKER</span>
            <span>5.3 INDIKATOR MANDIRI VS AGREGATIF</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN KINERJA</div>
            <h2 class="title-primary">5.3 PERBEDAAN INDIKATOR MANDIRI VS AGREGATIF</h2>
            
            <p class="paragraph">
                Dalam arsitektur e-LAPTRI canonical v3/v4, formulir input dikendalikan oleh properti <code>node.input_enabled</code> dan klasifikasi indikator:
            </p>

            <table class="table-styled" style="font-size: 8pt; margin: 15px 0;">
                <tr>
                    <th style="width: 25%;">Kategori</th>
                    <th style="width: 35%;">Ciri & Karakteristik Sistem</th>
                    <th>Perilaku Input Operator</th>
                </tr>
                <tr>
                    <td><strong style="color: #0284c7;">INDIKATOR MANDIRI</strong><br>(Leaf Node / Direct)</td>
                    <td>
                        • Diampu oleh satu unit kerja spesifik.<br>
                        • Memiliki rumus berbasis komponen input ($X_1, X_2$) atau nilai tunggal.<br>
                        • <code>input_enabled = TRUE</code>.
                    </td>
                    <td>
                        Operator dapat mengetikkan nilai angka mentah pada kolom input dan mengklik tombol simpan.
                    </td>
                </tr>
                <tr>
                    <td><strong style="color: #059669;">INDIKATOR AGREGATIF</strong><br>(Consolidated / Roll-up)</td>
                    <td>
                        • Terbentuk dari konsolidasi beberapa sub-indikator atau lintas satker.<br>
                        • Nilai dihitung melalui roll-up formula (AVERAGE, WEIGHTED_SUM, SUM).<br>
                        • <code>input_enabled = FALSE</code>.
                    </td>
                    <td>
                        Kolom input dinonaktifkan (abu-abu/terkunci). Nilai terisi otomatis ketika seluruh sub-indikator anak telah diinput oleh satker pengampu masing-masing.
                    </td>
                </tr>
            </table>

            <h3 class="subtitle-primary">CONTOH KASUS PENERAPAN PADA JAMBIN:</h3>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.6; margin: 0 0 15px 20px;">
                <li><strong>IKP 1.1 (Persentase Kepatuhan Pelaporan Kinerja):</strong> Bersifat <em>MANDIRI</em> bagi Biro Perencanaan. Nilai pembilang adalah jumlah satker tepat waktu, penyebut adalah 10 satker.</li>
                <li><strong>IKP 5.1 (Indeks SPBE Kejaksaan):</strong> Menggunakan tipe <em>DIRECT_VALUE</em> dari hasil evaluasi resmi KemenPAN-RB yang diinput Pusdaskrimti, tanpa merata-ratakan IKK di bawahnya.</li>
                <li><strong>IKP 10.1 (Kebijakan Strategis):</strong> Bersifat <em>MANDIRI</em> bagi Pustrajakgakum. Seluruh rekomendasi kebijakan tidak digabung otomatis ke IKP lain.</li>
            </ul>

            <div class="callout callout-info">
                <strong>ATURAN UI/UX KINERJA:</strong><br>
                Sistem tidak lagi mengunci form berdasarkan label teks semata, melainkan mengevaluasi relasi database secara dinamis.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 23 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 24: BAB V - 5.4 KALKULASI REALISASI & CAPAIAN
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-24">
        <div class="header">
            <span>BAB V: PANDUAN OPERATOR SATKER</span>
            <span>5.4 KALKULASI REALISASI & CAPAIAN TARGET</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN KINERJA</div>
            <h2 class="title-primary">5.4 KALKULASI OTOMATIS REALISASI & CAPAIAN TERHADAP TARGET</h2>
            
            <p class="paragraph">
                Dalam evaluasi SAKIP, <strong>Realisasi</strong> dan <strong>Capaian terhadap Target</strong> adalah dua konsep yang berbeda secara fundamental. Sistem e-LAPTRI memisahkannya dengan tegas:
            </p>

            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 15px; margin: 15px 0;">
                <div style="font-weight: 800; color: #0f172a; margin-bottom: 8px;">FORMULA MATEMATIS SISTEM:</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div style="background: #ffffff; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0;">
                        <span style="font-weight: 700; color: #0284c7;">1. Rumus Nilai Realisasi (R)</span>
                        <div style="font-size: 10.5pt; font-weight: 800; color: #0f172a; margin: 8px 0; text-align: center;">
                            R = (Pembilang X1 / Penyebut X2) &times; 100
                        </div>
                        <span style="font-size: 8pt; color: #64748b;">Dihasilkan dalam satuan asli indikator (misal: %).</span>
                    </div>
                    <div style="background: #ffffff; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0;">
                        <span style="font-weight: 700; color: #059669;">2. Rumus Capaian Kinerja (C)</span>
                        <div style="font-size: 10.5pt; font-weight: 800; color: #0f172a; margin: 8px 0; text-align: center;">
                            C = (Realisasi / Target Snapshot) &times; 100%
                        </div>
                        <span style="font-size: 8pt; color: #64748b;">Tingkat persentase pencapaian sasaran Renstra.</span>
                    </div>
                </div>
            </div>

            <h3 class="subtitle-primary">ARAH KINERJA INDIKATOR (INDICATOR DIRECTION):</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 25%;">Tipe Arah</th>
                    <th style="width: 35%;">Logika Capaian</th>
                    <th>Contoh Indikator</th>
                </tr>
                <tr>
                    <td><strong>Positive (Maximize)</strong></td>
                    <td>Semakin tinggi realisasi, semakin baik capaiannya: C = (R / T) &times; 100%.</td>
                    <td>Persentase Realisasi Anggaran, Kepatuhan Pelaporan Kinerja.</td>
                </tr>
                <tr>
                    <td><strong>Negative (Minimize)</strong></td>
                    <td>Semakin rendah realisasi, semakin baik performa satker: C = ((2T - R) / T) &times; 100%.</td>
                    <td>Persentase Pelanggaran Disiplin Pegawai, Temuan Kerugian BPK.</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 15px;">
                <strong>CAPAIAN MAKSIMAL (CAPPING):</strong><br>
                Sesuai pedoman evaluasi KemenPAN-RB, nilai capaian terhadap target yang melebihi 100% tetap ditampilkan nilai aslinya di aplikasi (misal: 112.50%), namun saat kompilasi agregat LKjIP dapat dikenakan batas wajar (capping 100% atau 120%) sesuai kebijakan pimpinan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 24 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 25: BAB V - 5.5 PENYUSUNAN ANALISIS
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-25">
        <div class="header">
            <span>BAB V: PANDUAN OPERATOR SATKER</span>
            <span>5.5 PENYUSUNAN ANALISIS KINERJA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN KINERJA</div>
            <h2 class="title-primary">5.5 PENYUSUNAN ANALISIS KINERJA: KENDALA & RENCANA SOLUSI</h2>
            
            <p class="paragraph">
                Laporan Kinerja (LKjIP) yang berkualitas tidak hanya menyajikan angka matematis, melainkan harus disertai narasi analitis yang komprehensif. Pada setiap kartu indikator, operator wajib mengisi 3 kolom evaluasi:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_input_analysis']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 5.3: Form Pengisian Analisis Capaian Kinerja, Kendala Operasional, dan Upaya Solutif</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">STANDAR PENULISAN NARASI LKJIP:</h3>
            <ol style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Analisis Capaian:</strong> Uraikan perbandingan antara realisasi aktual dengan target triwulan, efisiensi penggunaan sumber daya, serta program utama yang mendukung pencapaian.</li>
                <li><strong>Faktor Kendala / Penghambat:</strong> Identifikasi masalah internal maupun eksternal yang dihadapi (contoh: keterlambatan regulasi teknis, keterbatasan sarana IT, kendala koordinasi lintas instansi).</li>
                <li><strong>Upaya Tindak Lanjut:</strong> Rumuskan langkah konkret, realistis, dan berjangka waktu yang akan dieksekusi pada triwulan berikutnya untuk mengatasi kendala tersebut.</li>
            </ol>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 25 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 26: BAB V - 5.6 AUTOSAVE & VALIDASI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-26">
        <div class="header">
            <span>BAB V: PANDUAN OPERATOR SATKER</span>
            <span>5.6 AUTOSAVE & VALIDASI INPUT</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN KINERJA</div>
            <h2 class="title-primary">5.6 MEKANISME AUTOSAVE, VALIDASI INPUT & EVIDENCE PENDUKUNG</h2>
            
            <p class="paragraph">
                Aplikasi e-LAPTRI v4 dilengkapi mekanisme pengamanan data berlapis untuk mencegah kehilangan data akibat gangguan jaringan internet atau listrik padam saat proses pengisian:
            </p>

            <h3 class="subtitle-primary">1. STICKY ACTION BAR & SIMPAN CEPAT</h3>
            <p class="paragraph">
                Di bagian bawah layar monitor, tersedia <em>Sticky Action Bar</em> yang tetap melayang saat pengguna menggulir halaman. Bilah ini memuat:
            </p>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Status Perubahan Data:</strong> Mendeteksi jika terdapat angka atau narasi yang diubah namun belum disimpan (indikator teks oranye: <em>"Ada perubahan yang belum disimpan"</em>).</li>
                <li><strong>Tombol Simpan Semua (Save All):</strong> Mengirimkan seluruh draf input dalam satu transaksi aman (Atomic DB Transaction).</li>
                <li><strong>Tombol Simpan Per Indikator:</strong> Setiap kartu indikator memiliki tombol simpan mandiri untuk fleksibilitas operator.</li>
            </ul>

            <h3 class="subtitle-primary">2. VALIDASI DATA REAL-TIME</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 25%;">Validasi Sistem</th>
                    <th style="width: 35%;">Respon Sistem</th>
                    <th>Tindakan Perbaikan</th>
                </tr>
                <tr>
                    <td>Karakter Non-Angka pada Nilai Mentah</td>
                    <td>Kotak input berwarna merah; pesan: <em>"Harus berupa angka numerik valid"</em>.</td>
                    <td>Hapus huruf atau spasi, gunakan titik untuk desimal.</td>
                </tr>
                <tr>
                    <td>Pembilang Lebih Besar dari Penyebut (Rasio Sederhana)</td>
                    <td>Peringatan oranye validasi logika kuota.</td>
                    <td>Periksa kembali dokumen bukti rekapitulasi satker.</td>
                </tr>
                <tr>
                    <td>Narasi Analisis Kosong</td>
                    <td>Sistem memblokir proses submit final.</td>
                    <td>Isi uraian analisis capaian, kendala, dan upaya.</td>
                </tr>
            </table>

            <div class="callout callout-warning" style="margin-top: 15px;">
                <strong>MANAJEMEN EVIDENCE (DOKUMEN PENDUKUNG):</strong><br>
                Seluruh angka pembilang dan penyebut yang diinput harus didukung oleh dokumen resmi (contoh: Surat Perintah, Berita Acara, Laporan SIMPEG, atau Rekapitulasi SPAN Kemenkeu). Simpan berkas tersebut dalam folder arsip satker untuk keperluan pemeriksaan inspektorat.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 26 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 27: BAB V - 5.7 FINALISASI DATA & SUBMIT
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-27">
        <div class="header">
            <span>BAB V: PANDUAN OPERATOR SATKER</span>
            <span>5.7 FINALISASI & PROSEDUR SUBMIT</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN KINERJA</div>
            <h2 class="title-primary">5.7 FINALISASI DATA & PROSEDUR SUBMIT KE TINGKAT JAMBIN</h2>
            
            <p class="paragraph">
                Tahap akhir bagi Operator Satker setelah menyelesaikan penginputan seluruh indikator adalah melakukan finalisasi dan pengajuan resmi <em>(submission)</em> ke Tim Verifikator JAMBIN:
            </p>

            <h3 class="subtitle-primary">CHECKLIST PRA-SUBMISI OPERATOR:</h3>
            <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px; margin-bottom: 15px;">
                <label style="display: block; font-size: 8.5pt; color: #334155; margin-bottom: 6px;">
                    <input type="checkbox" checked disabled> Seluruh IKP dan IKK tanggung jawab satuan kerja telah terisi 100%.
                </label>
                <label style="display: block; font-size: 8.5pt; color: #334155; margin-bottom: 6px;">
                    <input type="checkbox" checked disabled> Angka realisasi telah dicocokkan dengan data riil pada laporan bulanan kedinasan.
                </label>
                <label style="display: block; font-size: 8.5pt; color: #334155; margin-bottom: 6px;">
                    <input type="checkbox" checked disabled> Narasi kendala dan rencana tindak lanjut telah disetujui oleh Kepala Biro / Kepala Pusat.
                </label>
                <label style="display: block; font-size: 8.5pt; color: #334155;">
                    <input type="checkbox" checked disabled> Seluruh tombol simpan telah ditekan dan tidak ada perubahan menggantung <em>(unsaved changes)</em>.
                </label>
            </div>

            <h3 class="subtitle-primary">LANGKAH-LANGKAH SUBMISI RESMI:</h3>
            <ol style="font-size: 8.5pt; color: #334155; line-height: 1.6; margin: 0 0 15px 20px;">
                <li>Pada bagian atas formulir Input Data, periksa indikator keterisian pada badge ringkasan.</li>
                <li>Klik tombol <strong>AJUKAN KE JAMBIN (SUBMIT DATA)</strong>.</li>
                <li>Modal konfirmasi akan muncul memuat rekapitulasi data yang akan dikirimkan beserta pernyataan pakta integritas kebenaran data.</li>
                <li>Klik tombol <strong>YA, AJUKAN LAPORAN</strong>.</li>
                <li>Status data akan berubah menjadi <span class="badge-role" style="background: #e0f2fe; color: #0369a1; border: 1px solid #38bdf8;">SUBMITTED</span>.</li>
            </ol>

            <div class="callout callout-warning">
                <strong>IMPLIKASI STATUS SUBMITTED:</strong><br>
                Setelah diajukan, seluruh formulir input akan terkunci menjadi <em>Read-Only</em>. Satker tidak dapat lagi merubah angka atau teks kecuali apabila Tim Verifikator JAMBIN menolak data dan mengembalikannya dengan status <em>Revisi</em>.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 27 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 28: BAB VI - 6.1 DASHBOARD ADMIN JAMBIN
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-28">
        <div class="header">
            <span>BAB VI: PANDUAN ADMIN & VERIFIKATOR</span>
            <span>6.1 DASHBOARD PEMANTAUAN NASIONAL</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR & ADMIN: REVIEW & AUDIT DATA</div>
            <h2 class="title-primary">6.1 DASHBOARD PEMANTAUAN KINERJA NASIONAL / JAMBIN</h2>
            
            <p class="paragraph">
                Administrator JAMBIN (Biro Perencanaan) memiliki akses khusus melalui akun <code>admin.jambin</code> untuk memantau performa agregat seluruh unit kerja di lingkungan Pembinaan:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_admin_dash']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 6.1: Dashboard Administrator Tingkat JAMBIN (Executive Command Center)</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">FITUR COMMAND CENTER ADMIN:</h3>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Matriks Progres Pengisian Nasional:</strong> Menampilkan persentase kepatuhan pengisian 10 satuan kerja Eselon II secara real-time.</li>
                <li><strong>Peta Capaian 11 Sasaran Program (SP 1 s/d SP 16):</strong> Rekapitulasi status ketercapaian 11 Sasaran Program pembinaan triwulanan berdasarkan realisasi 19 IKP.</li>
                <li><strong>Kotak Peringatan Kinerja Rendah:</strong> Otomatis mendeteksi indikator kritis yang realisasinya berada di bawah 80% dari target Renstra.</li>
            </ul>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 28 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 29: BAB VI - 6.2 MONITORING KEPATUHAN SATKER
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-29">
        <div class="header">
            <span>BAB VI: PANDUAN ADMIN & VERIFIKATOR</span>
            <span>6.2 MONITORING KEPATUHAN SELURUH SATKER</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR & ADMIN: REVIEW & AUDIT DATA</div>
            <h2 class="title-primary">6.2 MONITORING KEPATUHAN PENGISIAN SELURUH SATKER</h2>
            
            <p class="paragraph">
                Tingkat kepatuhan pelaporan triwulanan diukur berdasarkan kecepatan dan kelengkapan 10 Satuan Kerja Eselon II dalam menyelesaikan input data sebelum batas waktu (cut-off):
            </p>

            <table class="table-styled" style="font-size: 8pt; margin: 15px 0;">
                <tr>
                    <th style="width: 28%;">Satuan Kerja Eselon II</th>
                    <th style="width: 14%;">Jml Indikator</th>
                    <th style="width: 16%;">Status Pengisian</th>
                    <th style="width: 18%;">Tgl Submit</th>
                    <th>Tindakan Verifikator</th>
                </tr>
                <tr>
                    <td><strong>Biro Perencanaan</strong></td>
                    <td>8 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>08 April 2026</td>
                    <td>Siap diverifikasi</td>
                </tr>
                <tr>
                    <td><strong>Biro Kepegawaian</strong></td>
                    <td>12 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>09 April 2026</td>
                    <td>Siap diverifikasi</td>
                </tr>
                <tr>
                    <td><strong>Biro Keuangan</strong></td>
                    <td>10 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>07 April 2026</td>
                    <td>Disetujui (Approved)</td>
                </tr>
                <tr>
                    <td><strong>Biro Perlengkapan</strong></td>
                    <td>9 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>10 April 2026</td>
                    <td>Siap diverifikasi</td>
                </tr>
                <tr>
                    <td><strong>Biro Umum</strong></td>
                    <td>7 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>09 April 2026</td>
                    <td>Siap diverifikasi</td>
                </tr>
                <tr>
                    <td><strong>Biro Hukum & HLN</strong></td>
                    <td>6 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>08 April 2026</td>
                    <td>Siap diverifikasi</td>
                </tr>
                <tr>
                    <td><strong>Pusdaskrimti</strong></td>
                    <td>11 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>06 April 2026</td>
                    <td>Disetujui (Approved)</td>
                </tr>
                <tr>
                    <td><strong>Pustrajakgakum</strong></td>
                    <td>5 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>10 April 2026</td>
                    <td>Siap diverifikasi</td>
                </tr>
                <tr>
                    <td><strong>Pusat Kesehatan Yustisial</strong></td>
                    <td>4 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>09 April 2026</td>
                    <td>Siap diverifikasi</td>
                </tr>
                <tr>
                    <td><strong>Sekretariat JAMBIN</strong></td>
                    <td>3 IKK</td>
                    <td><span style="color: #059669; font-weight: 700;">100% Lengkap</span></td>
                    <td>05 April 2026</td>
                    <td>Disetujui (Approved)</td>
                </tr>
            </table>

            <div class="callout callout-info">
                <strong>SISTEM NOTIFIKASI OTOMATIS:</strong><br>
                Biro Perencanaan dapat mengirimkan notifikasi <em>reminder</em> otomatis via aplikasi kepada satker yang belum menginput data saat H-3 menjelang cut-off date.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 29 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 30: BAB VI - 6.3 REVIEW DATA GRID
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-30">
        <div class="header">
            <span>BAB VI: PANDUAN ADMIN & VERIFIKATOR</span>
            <span>6.3 HALAMAN REVIEW DATA KINERJA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR & ADMIN: REVIEW & AUDIT DATA</div>
            <h2 class="title-primary">6.3 HALAMAN REVIEW DATA: FILTER PERIODE & DATAGRID</h2>
            
            <p class="paragraph">
                Menu <strong>Review Data</strong> (`/review-data`) merupakan lembar kerja audit utama bagi Tim Verifikator JAMBIN untuk memeriksa seluruh indikator dalam satu tabel terpusat <em>(DataGrid)</em>:
            </p>

            <div class="screenshot-card">
                <img src="{assets['img_review_idx']}" class="screenshot-img" style="max-height: 105mm;">
                <div class="screenshot-caption">Gambar 6.2: Halaman DataGrid Review Kinerja SAKIP Seluruh Indikator JAMBIN</div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">KAPABILITAS DATAGRID AUDIT:</h3>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.5; margin: 0 0 10px 20px;">
                <li><strong>Filter Multi-Kriteria:</strong> Memilih Tahun Anggaran, Triwulan, Satuan Kerja Pengampu, dan Tingkat Indikator (SP, IKP, SK, IKK).</li>
                <li><strong>Pencarian Instan (Instant Search):</strong> Menemukan indikator secara cepat berdasarkan kode Renstra atau kata kunci nama kegiatan.</li>
                <li><strong>Visual Status Chip:</strong> Label warna otomatis penanda status ketercapaian target (Tercapai / Belum Tercapai / Tidak Tercapai).</li>
                <li><strong>Tombol Detail Verifikasi:</strong> Ikon mata / kaca pembesar untuk membuka lembar audit mendalam per indikator.</li>
            </ul>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 30 dari 45</span>
        </div>
    </div>
    """)

    return pages
