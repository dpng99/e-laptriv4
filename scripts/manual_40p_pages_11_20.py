# -*- coding: utf-8 -*-
"""
Modul Penyusun Halaman 11 sampai 20
Buku Manual Operasional e-LAPTRI v4 (e-LKjIP Pembinaan)
Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI: Dr. Hendro Dewanto, S.H., M.Hum.
"""

def get_pages_11_to_20(assets):
    pages = []

    # ==========================================
    # HALAMAN 11: BAB II - 2.3 MATRIKS SS & IKSS
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-11">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.3 MATRIKS SASARAN STRATEGIS (SS) &amp; IKSS</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA SAKIP &amp; CASCADING CANONICAL</div>
            <h2 class="title-primary">2.3 MATRIKS SASARAN STRATEGIS (SS) &amp; IKSS UTAMA JAMBIN</h2>

            <p class="paragraph">
                Tingkat tertinggi dalam penjenjangan kinerja bidang Pembinaan dipimpin langsung oleh Jaksa Agung Muda Bidang Pembinaan. Sesuai Renstra Kejaksaan RI 2025-2029 dan Kepja 1184 Tahun 2025, terdapat 2 Sasaran Strategis (SS) yang ditopang oleh 2 Indikator Kinerja Sasaran Strategis (IKSS):
            </p>

            <table class="table-styled" style="font-size: 7.2pt; margin-top: 6px;">
                <tr>
                    <th style="width: 10%;">Kode</th>
                    <th style="width: 32%;">Nomenklatur Sasaran Strategis / IKSS</th>
                    <th style="width: 12%;">Satuan</th>
                    <th style="width: 26%;">Target 5 Tahun (2025 - 2029)</th>
                    <th>Satker Pengampu</th>
                </tr>
                <tr style="background: #f1f5f9; font-weight: 700;">
                    <td>SS 1</td>
                    <td colspan="4">Meningkatnya Akuntabilitas Kinerja dan Keuangan Kejaksaan RI</td>
                </tr>
                <tr>
                    <td style="padding-left: 14px;"><strong>IKSS 1.1</strong></td>
                    <td>Nilai Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) Kejaksaan RI</td>
                    <td>Nilai / Predikat</td>
                    <td>2025: <strong>81.50 (A)</strong> | 2026: <strong>82.00 (A)</strong><br>2027: <strong>82.50 (A)</strong> | 2028: <strong>83.00 (A)</strong><br>2029: <strong>83.50 (A)</strong></td>
                    <td>Biro Perencanaan (Setjambin)</td>
                </tr>
                <tr style="background: #f1f5f9; font-weight: 700;">
                    <td>SS 2</td>
                    <td colspan="4">Terwujudnya Transformasi Tata Kelola Kejaksaan yang Modern, Adaptif &amp; Berintegritas</td>
                </tr>
                <tr>
                    <td style="padding-left: 14px;"><strong>IKSS 2.1</strong></td>
                    <td>Indeks Reformasi Birokrasi (RB) Kejaksaan Republik Indonesia</td>
                    <td>Indeks</td>
                    <td>2025: <strong>85.00</strong> | 2026: <strong>85.50</strong><br>2027: <strong>86.00</strong> | 2028: <strong>86.50</strong><br>2029: <strong>87.00</strong></td>
                    <td>Biro Perencanaan (Setjambin)</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 10px;">KARAKTERISTIK PENGUKURAN INDIKATOR STRATEGIS (IKSS)</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 4px;">
                <div class="feature-box">
                    <strong style="color: #0369a1; font-size: 7.8pt;">1. Evaluasi Independen Eksternal</strong>
                    <p style="font-size: 7.1pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Kedua nilai IKSS diperoleh dari hasil evaluasi resmi Kementerian PAN-RB yang diterbitkan setiap tahun. Angka ini dimasukkan ke sistem e-LAPTRI v4 dengan tipe formula <code>EXTERNAL_SCORE</code>.
                    </p>
                </div>
                <div class="feature-box">
                    <strong style="color: #064e3b; font-size: 7.8pt;">2. Lintas-Sektoral &amp; Multi-Biro</strong>
                    <p style="font-size: 7.1pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Pencapaian IKSS ditopang oleh kinerja operasional seluruh 10 Biro dan Pusat di lingkungan JAMBIN, mulai dari pengelolaan anggaran di Biro Keuangan hingga sistem IT di Pusdaskrimti.
                    </p>
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 10px;">
                <strong>CATATAN TARGET GANDA:</strong><br>
                Sistem e-LAPTRI v4 menyimpan target versi KEPJA 1184/2025 dan target Renstra 2025-2029 secara terpisah pada tabel <code>kinerja_targets</code>. Default operasional mengacu pada KEPJA 1184/2025 (<code>is_selected = true</code>).
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 11 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 12: BAB II - 2.4 MATRIKS 12 SP & 20 IKP
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-12">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.4 MATRIKS 12 PROGRAM &amp; 20 IKP</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA SAKIP &amp; CASCADING CANONICAL</div>
            <h2 class="title-primary">2.4 MATRIKS 12 SASARAN PROGRAM (SP) &amp; 20 IKP JAMBIN</h2>

            <p class="paragraph">
                Tingkat kedua diturunkan menjadi 12 Sasaran Program (SP 13 s.d. SP 24) yang diukur oleh 20 Indikator Kinerja Program (IKP). Setiap program menjadi tanggung jawab langsung para Kepala Biro dan Kepala Pusat:
            </p>

            <table class="table-styled" style="font-size: 7.1pt; margin-top: 4px;">
                <tr>
                    <th style="width: 8%;">Kode SP</th>
                    <th style="width: 28%;">Sasaran Program (SP)</th>
                    <th style="width: 10%;">Kode IKP</th>
                    <th style="width: 38%;">Indikator Kinerja Program (IKP)</th>
                    <th>Unit PIC</th>
                </tr>
                <tr>
                    <td><strong>SP 13</strong></td>
                    <td>Dukungan Manajemen &amp; Pelaksanaan Tugas</td>
                    <td><strong>IKP 13.1</strong></td>
                    <td>Persentase Capaian Kinerja Pembinaan Terpadu</td>
                    <td>SETJAMBIN</td>
                </tr>
                <tr>
                    <td><strong>SP 14</strong></td>
                    <td>Perencanaan Strategis &amp; Akuntabilitas Kinerja</td>
                    <td><strong>IKP 14.1<br>IKP 14.2</strong></td>
                    <td>Persentase Keselarasan Dokumen Renja-RKA-K/L<br>Tingkat Kematangan Pengelolaan SAKIP</td>
                    <td>RO REN</td>
                </tr>
                <tr>
                    <td><strong>SP 15</strong></td>
                    <td>Pengelolaan Kepegawaian &amp; SDM Aparatur</td>
                    <td><strong>IKP 15.1<br>IKP 15.2</strong></td>
                    <td>Indeks Sistem Merit Manajemen ASN Kejaksaan<br>Persentase Penempatan Jabatan Sesuai Kompetensi</td>
                    <td>RO PEG</td>
                </tr>
                <tr>
                    <td><strong>SP 16</strong></td>
                    <td>Pengelolaan Keuangan &amp; BMN Akuntabel</td>
                    <td><strong>IKP 16.1<br>IKP 16.2</strong></td>
                    <td>Opini BPK atas Laporan Keuangan Kejaksaan (WTP)<br>Persentase Nilai Kinerja Pengelolaan Anggaran (IKPA)</td>
                    <td>RO KEU</td>
                </tr>
                <tr>
                    <td><strong>SP 17</strong></td>
                    <td>Pengelolaan Sarana &amp; Prasarana Perlengkapan</td>
                    <td><strong>IKP 17.1</strong></td>
                    <td>Persentase Pemanfaatan &amp; Tertib Administrasi BMN</td>
                    <td>RO KAP</td>
                </tr>
                <tr>
                    <td><strong>SP 18</strong></td>
                    <td>Pelayanan Hukum &amp; Hubungan Luar Negeri</td>
                    <td><strong>IKP 18.1</strong></td>
                    <td>Persentase Harmonisasi Regulasi Kejaksaan Tepat Waktu</td>
                    <td>RO HLN</td>
                </tr>
                <tr>
                    <td><strong>SP 19</strong></td>
                    <td>Pelayanan Kerumahtanggaan &amp; Umum</td>
                    <td><strong>IKP 19.1</strong></td>
                    <td>Indeks Kepuasan Layanan Protokol &amp; Fasilitas Umum</td>
                    <td>RO UMUM</td>
                </tr>
                <tr>
                    <td><strong>SP 20</strong></td>
                    <td>Teknologi Informasi &amp; Satu Data Kejaksaan</td>
                    <td><strong>IKP 20.1<br>IKP 20.2</strong></td>
                    <td>Indeks Sistem Pemerintahan Berbasis Elektronik (SPBE)<br>Persentase Uptime Layanan Pusat Data Terpadu</td>
                    <td>PUSDAS</td>
                </tr>
                <tr>
                    <td><strong>SP 21</strong></td>
                    <td>Strategi Kebijakan Penegakan Hukum</td>
                    <td><strong>IKP 21.1</strong></td>
                    <td>Jumlah Policy Brief Kebijakan Hukum Terekomendasi</td>
                    <td>PUSTRA</td>
                </tr>
                <tr>
                    <td><strong>SP 22</strong></td>
                    <td>Layanan Kesehatan Yustisial &amp; Medis Pegawai</td>
                    <td><strong>IKP 22.1</strong></td>
                    <td>Tingkat Kualitas &amp; Kesiapan Layanan RS Adhyaksa</td>
                    <td>PKY</td>
                </tr>
            </table>

            <div class="callout callout-warning" style="margin-top: 6px;">
                <strong>CATATAN KHUSUS METODOLOGI MANDIRI:</strong><br>
                IKP 15.1 (Indeks Sistem Merit) dan IKP 20.1 (Indeks SPBE) adalah contoh <strong>Indikator Mandiri</strong> bertipe <code>EXTERNAL_SCORE</code> yang ditetapkan oleh KemenPAN-RB / KASN. Angka tersebut tidak dihitung dari penjumlahan sub-indikator kegiatan (IKK) di bawahnya.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 12 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 13: BAB II - 2.5 MATRIKS 35 SK & 97 IKK
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-13">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.5 MATRIKS 35 SK &amp; 97 IKK SATKER</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA SAKIP &amp; CASCADING CANONICAL</div>
            <h2 class="title-primary">2.5 MATRIKS SASARAN KEGIATAN (SK) &amp; 97 IKK OUTPUT</h2>

            <p class="paragraph">
                Tingkat operasional terbawah adalah Sasaran Kegiatan (SK) dan Indikator Kinerja Kegiatan (IKK). Inilah simpul di mana para operator Satker Eselon II menginput realisasi triwulanan secara langsung beserta berkas bukti dukung:
            </p>

            <div style="background: #0f172a; color: #ffffff; border-radius: 8px; padding: 8px 12px; margin-bottom: 8px;">
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; text-align: center;">
                    <div>
                        <div style="font-size: 7pt; color: #94a3b8; text-transform: uppercase;">Total Sasaran Kegiatan</div>
                        <div style="font-size: 13pt; font-weight: 800; color: #38bdf8;">35 SK</div>
                    </div>
                    <div>
                        <div style="font-size: 7pt; color: #94a3b8; text-transform: uppercase;">Total Indikator Output</div>
                        <div style="font-size: 13pt; font-weight: 800; color: #34d399;">97 IKK</div>
                    </div>
                    <div>
                        <div style="font-size: 7pt; color: #94a3b8; text-transform: uppercase;">Formula Terdokumentasi</div>
                        <div style="font-size: 13pt; font-weight: 800; color: #f59e0b;">119 Rumus</div>
                    </div>
                    <div>
                        <div style="font-size: 7pt; color: #94a3b8; text-transform: uppercase;">Target Terdaftar (5 Thn)</div>
                        <div style="font-size: 13pt; font-weight: 800; color: #f43f5e;">1.190 Baris</div>
                    </div>
                </div>
            </div>

            <h3 class="subtitle-primary">DISTRIBUSI BEBAN KERJA INPUT IKK PER UNIT KERJA</h3>
            <table class="table-styled" style="font-size: 7.2pt; margin-top: 4px;">
                <tr>
                    <th style="width: 25%;">Unit Kerja Eselon II</th>
                    <th style="width: 15%;">Jumlah SK</th>
                    <th style="width: 15%;">Jumlah IKK</th>
                    <th>Contoh IKK Prioritas / Mandat Langsung</th>
                </tr>
                <tr>
                    <td><strong>Sekretariat JAMBIN</strong></td>
                    <td style="text-align: center;">3 SK</td>
                    <td style="text-align: center;">7 IKK</td>
                    <td>Persentase disposisi pimpinan yang ditindaklanjuti tepat waktu.</td>
                </tr>
                <tr>
                    <td><strong>Biro Perencanaan</strong></td>
                    <td style="text-align: center;">4 SK</td>
                    <td style="text-align: center;">12 IKK</td>
                    <td>Tingkat kepatuhan penyampaian Laptri seluruh satker Kejaksaan se-Indonesia.</td>
                </tr>
                <tr>
                    <td><strong>Biro Kepegawaian</strong></td>
                    <td style="text-align: center;">5 SK</td>
                    <td style="text-align: center;">16 IKK</td>
                    <td>Persentase pegawai yang telah mengikuti pengembangan kompetensi 20 JP.</td>
                </tr>
                <tr>
                    <td><strong>Biro Keuangan</strong></td>
                    <td style="text-align: center;">4 SK</td>
                    <td style="text-align: center;">14 IKK</td>
                    <td>Persentase penyelesaian LPJ bendahara pengeluaran tanpa keterlambatan.</td>
                </tr>
                <tr>
                    <td><strong>Biro Perlengkapan</strong></td>
                    <td style="text-align: center;">4 SK</td>
                    <td style="text-align: center;">11 IKK</td>
                    <td>Persentase pengadaan barang/jasa melalui e-Katalog LKPP.</td>
                </tr>
                <tr>
                    <td><strong>Biro Hukum &amp; HLN</strong></td>
                    <td style="text-align: center;">3 SK</td>
                    <td style="text-align: center;">8 IKK</td>
                    <td>Jumlah naskah kerja sama luar negeri (MoU/MLA) yang difasilitasi.</td>
                </tr>
                <tr>
                    <td><strong>Biro Umum</strong></td>
                    <td style="text-align: center;">3 SK</td>
                    <td style="text-align: center;">9 IKK</td>
                    <td>Persentase ketersediaan fasilitas gedung kantor yang layak &amp; aman.</td>
                </tr>
                <tr>
                    <td><strong>Pusdaskrimti</strong></td>
                    <td style="text-align: center;">4 SK</td>
                    <td style="text-align: center;">10 IKK</td>
                    <td>Persentase satker yang terhubung jaringan terpadu Kejaksaan RI.</td>
                </tr>
                <tr>
                    <td><strong>Pustrajakgakum</strong></td>
                    <td style="text-align: center;">2 SK</td>
                    <td style="text-align: center;">5 IKK</td>
                    <td>Persentase naskah akademik kebijakan penegakan hukum yang ditindaklanjuti.</td>
                </tr>
                <tr>
                    <td><strong>Pusat Kesehatan Yustisial</strong></td>
                    <td style="text-align: center;">3 SK</td>
                    <td style="text-align: center;">5 IKK</td>
                    <td>Jumlah layanan pemeriksaan kesehatan tahanan/pegawai yang terlaksana.</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 6px;">
                <strong>KODE NORMALISASI VS KODE CETAK SUMBER:</strong><br>
                Sistem e-LAPTRI v4 menormalkan kode IKK menjadi format hierarki terstruktur (misal <code>IKK 18.1.1</code>), namun tetap menyimpan kode cetak sumber asli dari lampiran KEPJA 1184/2025 pada kolom <code>kinerja_ikk.kode_sumber</code> guna menjaga konsistensi saat audit.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 13 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 14: BAB III - 3.1 MANAJEMEN AKUN & RBAC
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-14">
        <div class="header">
            <span>BAB III: HAK AKSES &amp; KEAMANAN</span>
            <span>3.1 MANAJEMEN PERAN PENGGUNA (RBAC)</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB III: HAK AKSES, AUTENTIKASI &amp; KEAMANAN</div>
            <h2 class="title-primary">3.1 MANAJEMEN PERAN PENGGUNA &amp; MATRIKS KEWENANGAN (RBAC)</h2>

            <p class="paragraph">
                Sistem e-LAPTRI v4 menerapkan kontrol akses berbasis peran <em>(Role-Based Access Control / RBAC)</em> yang memisahkan secara ketat batas kewenangan antara unit pelaksana operasional dengan unit pengawas dan verifikator di tingkat pusat:
            </p>

            <table class="table-styled" style="font-size: 7.2pt; margin-top: 6px;">
                <tr>
                    <th style="width: 25%;">Fitur / Modul Sistem</th>
                    <th style="width: 25%; text-align: center;">Operator Satker Eselon II<br><span style="font-weight: normal; font-size: 6.5pt;">(ro.ren, ro.keu, ro.peg, dsb.)</span></th>
                    <th style="width: 25%; text-align: center;">Super Admin / Verifikator JAMBIN<br><span style="font-weight: normal; font-size: 6.5pt;">(admin.jambin)</span></th>
                    <th style="text-align: center;">Deskripsi Kewenangan</th>
                </tr>
                <tr>
                    <td><strong>Dashboard Kinerja</strong></td>
                    <td style="text-align: center;"><span style="color: #059669; font-weight: 800;">✓</span> (Satker Sendiri)</td>
                    <td style="text-align: center;"><span style="color: #059669; font-weight: 800;">✓</span> (Nasional / Seluruh Satker)</td>
                    <td>Operator hanya memantau KPI satkernya; Admin memantau 10 Satker terpadu.</td>
                </tr>
                <tr>
                    <td><strong>Input Data Kinerja Triwulan</strong></td>
                    <td style="text-align: center;"><span style="color: #059669; font-weight: 800;">✓</span> (Input Nilai X1/X2 &amp; Eviden)</td>
                    <td style="text-align: center;"><span style="color: #dc2626; font-weight: 800;">✕</span> (Read-Only)</td>
                    <td>Menjaga integritas; Admin pusat tidak boleh merekayasa angka riil satker.</td>
                </tr>
                <tr>
                    <td><strong>Submit Pengukuran ke JAMBIN</strong></td>
                    <td style="text-align: center;"><span style="color: #059669; font-weight: 800;">✓</span> (Kunci Form Otomatis)</td>
                    <td style="text-align: center;"><span style="color: #dc2626; font-weight: 800;">✕</span> (Tidak Berlaku)</td>
                    <td>Operator mengunci data draf untuk diteruskan ke verifikator pusat.</td>
                </tr>
                <tr>
                    <td><strong>Verifikasi &amp; Approval Kinerja</strong></td>
                    <td style="text-align: center;"><span style="color: #dc2626; font-weight: 800;">✕</span> (Tidak Memiliki Akses)</td>
                    <td style="text-align: center;"><span style="color: #059669; font-weight: 800;">✓</span> (Setujui / Kembalikan Revisi)</td>
                    <td>Hak prerogatif Admin JAMBIN / Biro Perencanaan untuk memvalidasi angka.</td>
                </tr>
                <tr>
                    <td><strong>Formula Registry (Rumus)</strong></td>
                    <td style="text-align: center;"><span style="color: #dc2626; font-weight: 800;">✕</span> (Hanya Melihat Rumus)</td>
                    <td style="text-align: center;"><span style="color: #059669; font-weight: 800;">✓</span> (Konfigurasi Tipe &amp; Komponen)</td>
                    <td>Pengubahan tipe rumus dan operand hanya dilakukan oleh Administrator.</td>
                </tr>
                <tr>
                    <td><strong>Template Builder LKjIP (Word)</strong></td>
                    <td style="text-align: center;"><span style="color: #dc2626; font-weight: 800;">✕</span> (Tidak Memiliki Akses)</td>
                    <td style="text-align: center;"><span style="color: #059669; font-weight: 800;">✓</span> (Upload, Ganti &amp; Aktifkan)</td>
                    <td>Pengaturan layout dokumen resmi Word LKjIP dikelola terpusat.</td>
                </tr>
                <tr>
                    <td><strong>Ekspor Dokumen LKjIP (.docx)</strong></td>
                    <td style="text-align: center;"><span style="color: #dc2626; font-weight: 800;">✕</span> (Hanya Draf Ringkasan)</td>
                    <td style="text-align: center;"><span style="color: #059669; font-weight: 800;">✓</span> (Unduh Dokumen Lengkap Resmi)</td>
                    <td>Dokumen final Word hanya diterbitkan setelah seluruh satker disetujui.</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 10px;">PROSEDUR PENGGANTIAN OPERATOR SATKER</h3>
            <div class="callout callout-warning">
                <strong>KETENTUAN ROTASI / MUTASI PEGAWAI:</strong><br>
                Akun operator melekat pada satuan kerja (misal <code>ro.keu</code> untuk Biro Keuangan), bukan pada nama perorangan pegawai. Apabila terjadi pergantian PIC pelaporan kinerja, Pejabat Eselon III/IV terkait wajib:
                <ol style="margin: 4px 0 0 16px; padding: 0;">
                    <li>Melakukan serah terima akun kedinasan dan riwayat dokumen evidence triwulanan.</li>
                    <li>Segera melakukan pembaruan kata sandi di menu <em>Profil Pengguna</em>.</li>
                    <li>Melaporkan nomor kontak PIC baru ke Helpdesk Biro Perencanaan.</li>
                </ol>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 14 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 15: BAB III - 3.2 PROSEDUR LOGIN (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-15">
        <div class="header">
            <span>BAB III: HAK AKSES &amp; KEAMANAN</span>
            <span>3.2 PROSEDUR LOGIN &amp; AUTENTIKASI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB III: HAK AKSES, AUTENTIKASI &amp; KEAMANAN</div>
            <h2 class="title-primary">3.2 PANDUAN AUTENTIKASI &amp; PROSEDUR LOGIN KE SISTEM</h2>

            <p class="paragraph">
                Akses ke dalam portal e-LAPTRI v4 dilakukan melalui peramban web modern (Google Chrome atau Microsoft Edge) dengan membuka tautan resmi intranet Kejaksaan RI. Tampilan antarmuka login dirancang bersih, aman, dan responsif:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_login')}" class="screenshot-img" alt="Halaman Login e-LAPTRI v4">
                <div class="screenshot-caption">Gambar 3.1: Antarmuka Halaman Login Resmi e-LAPTRI v4 (e-LKjIP Pembinaan)</div>
            </div>

            <h3 class="subtitle-primary">ANATOMI ELEMEN ANTARMUKA HALAMAN LOGIN:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Kolom Username Kedinasan:</strong><br>
                    Masukkan identitas akun satker resmi (contoh: <code>ro.ren</code>, <code>ro.peg</code>, atau <code>admin.jambin</code>). Format peka huruf kecil <em>(lowercase)</em>.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[2] Kolom Kata Sandi (Password):</strong><br>
                    Ketikkan kata sandi akun Anda. Karakter disamarkan secara otomatis demi menjaga kerahasiaan saat berada di ruang kerja bersama.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[3] Tombol "Masuk ke Sistem":</strong><br>
                    Klik tombol untuk memvalidasi kredensial. Sistem akan memeriksa peran dan mengarahkan pengguna secara otomatis ke Dashboard yang sesuai.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[4] Banner Informasi &amp; Keamanan Sesi:</strong><br>
                    Menampilkan pengumuman resmi terkait periode pelaporan triwulan yang sedang dibuka serta peringatan enkripsi data aman.
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>PENANGANAN GAGAL LOGIN:</strong><br>
                Jika salah memasukkan kata sandi lebih dari 5 kali berturut-turut, sistem akan menerapkan proteksi *rate limiting* selama 60 detik. Hubungi Helpdesk Pusdaskrimti apabila lupa kata sandi kedinasan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 15 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 16: BAB III - 3.3 MANAJEMEN PROFIL (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-16">
        <div class="header">
            <span>BAB III: HAK AKSES &amp; KEAMANAN</span>
            <span>3.3 MANAJEMEN PROFIL &amp; KATA SANDI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB III: HAK AKSES, AUTENTIKASI &amp; KEAMANAN</div>
            <h2 class="title-primary">3.3 MANAJEMEN PROFIL AKUN &amp; KEAMANAN KATA SANDI</h2>

            <p class="paragraph">
                Setiap Operator Satker dan Administrator wajib memelihara keamanan akunnya secara berkala. Menu <strong>Profil Pengguna</strong> dapat diakses dengan mengeklik foto profil / nama satker di pojok kanan atas bilah navigasi:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_profile')}" class="screenshot-img" alt="Halaman Profil Pengguna e-LAPTRI v4">
                <div class="screenshot-caption">Gambar 3.2: Formulir Pengaturan Profil &amp; Pembaruan Kata Sandi Akun</div>
            </div>

            <h3 class="subtitle-primary">PROSEDUR STANDAR PENGGANTIAN KATA SANDI:</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div class="feature-box">
                    <strong style="color: #0369a1;">Langkah 1: Kata Sandi Saat Ini</strong>
                    <p style="font-size: 6.9pt; color: #475569; margin: 2px 0 0 0; line-height: 1.3;">
                        Ketikkan kata sandi lama yang sedang aktif sebagai bentuk konfirmasi kepemilikan akun yang sah.
                    </p>
                </div>
                <div class="feature-box">
                    <strong style="color: #064e3b;">Langkah 2: Kata Sandi Baru</strong>
                    <p style="font-size: 6.9pt; color: #475569; margin: 2px 0 0 0; line-height: 1.3;">
                        Ketikkan kata sandi baru (minimal 8 karakter, kombinasi huruf besar, huruf kecil, angka, dan simbol).
                    </p>
                </div>
                <div class="feature-box">
                    <strong style="color: #d97706;">Langkah 3: Simpan Pembaruan</strong>
                    <p style="font-size: 6.9pt; color: #475569; margin: 2px 0 0 0; line-height: 1.3;">
                        Ketik ulang pada kolom konfirmasi, kemudian klik tombol <strong>Simpan Perubahan</strong>.
                    </p>
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>PROTOKOL KEAMANAN SESI (SESSION TIMEOUT):</strong><br>
                Sistem dilengkapi fitur <em>auto-logout</em> otomatis setelah 120 menit tidak ada aktivitas. Hal ini bertujuan untuk melindungi data pengukuran kinerja dari manipulasi pihak tidak berwenang saat perangkat ditinggalkan di meja kerja.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 16 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 17: BAB IV - 4.1 DASHBOARD OPERATOR (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-17">
        <div class="header">
            <span>BAB IV: DASHBOARD &amp; MONITORING</span>
            <span>4.1 ANTARMUKA DASHBOARD OPERATOR</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IV: PANDUAN OPERATOR SATKER: MONITORING</div>
            <h2 class="title-primary">4.1 ANTARMUKA UTAMA DASHBOARD OPERATOR SATKER</h2>

            <p class="paragraph">
                Setelah berhasil login, Operator Satker langsung diarahkan ke <strong>Dashboard Kinerja Satker</strong>. Halaman ini berfungsi sebagai pusat kendali untuk memantau status pengisian dan capaian kinerja unit secara komprehensif:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_dashboard')}" class="screenshot-img" alt="Dashboard Kinerja Operator Satker">
                <div class="screenshot-caption">Gambar 4.1: Tampilan Utama Dashboard Operator Kinerja Biro / Pusat JAMBIN</div>
            </div>

            <h3 class="subtitle-primary">BEDAH ELEMEN KARTU INFORMASI (WIDGET KPI):</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Kartu Total Sasaran &amp; Indikator:</strong><br>
                    Menampilkan ringkasan total Sasaran Kegiatan (SK) dan Indikator Kinerja Kegiatan (IKK) yang menjadi tanggung jawab satker Anda pada tahun anggaran aktif.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[2] Widget Progres Pengisian (Progress Bar):</strong><br>
                    Menginformasikan persentase indikator yang telah diisi variabel mentah $X_1/X_2$ terhadap total indikator yang wajib dilaporkan pada triwulan bersangkutan.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[3] Filter Tahun Anggaran &amp; Triwulan:</strong><br>
                    Dropdown pemilih periode (Tahun 2025-2029 dan Triwulan I s.d. IV) untuk melihat riwayat capaian kinerja historis maupun periode berjalan.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #7c3aed;">[4] Banner Notifikasi Status Pelaporan:</strong><br>
                    Menandai posisi data saat ini: apakah berstatus <code>DRAFT</code> (masih bisa diedit), <code>SUBMITTED</code> (menunggu verifikasi), atau <code>APPROVED</code>.
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>PANDUAN OPERATOR CEPAT:</strong><br>
                Jika kartu progres belum mencapai 100%, segera klik tombol <strong>Input Data Kinerja</strong> pada bilah navigasi samping untuk menyelesaikan indikator yang belum terisi sebelum batas waktu triwulan ditutup.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 17 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 18: BAB IV - 4.2 GRAFIK KINERJA (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-18">
        <div class="header">
            <span>BAB IV: DASHBOARD &amp; MONITORING</span>
            <span>4.2 VISUALISASI GRAFIK KINERJA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IV: PANDUAN OPERATOR SATKER: MONITORING</div>
            <h2 class="title-primary">4.2 VISUALISASI GRAFIK KINERJA &amp; ANALISIS TREN CAPAIAN</h2>

            <p class="paragraph">
                Bagian bawah dashboard menyajikan visualisasi data interaktif menggunakan teknologi MUI X-Charts. Visualisasi ini dirancang agar pimpinan satker dapat membaca peta keberhasilan dan titik kritis secara instan tanpa perlu membaca tabel panjang:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_charts')}" class="screenshot-img" alt="Grafik Kinerja Operator Satker">
                <div class="screenshot-caption">Gambar 4.2: Visualisasi Diagram Donut Proporsi Status &amp; Bar Chart Realisasi vs Target</div>
            </div>

            <h3 class="subtitle-primary">INTERPRETASI 2 DIAGRAM UTAMA:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 4px;">
                <div class="feature-box">
                    <strong style="color: #0369a1; font-size: 7.6pt;">[A] Donut Chart Proporsi Capaian Target:</strong>
                    <p style="font-size: 7pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Mengelompokkan seluruh indikator ke dalam 4 zona ketercapaian:
                        <br>• <span style="color: #166534; font-weight: bold;">Tercapai (≥ 100%)</span>: Berwarna Hijau.
                        <br>• <span style="color: #1e40af; font-weight: bold;">On Track (80% - 99%)</span>: Berwarna Biru.
                        <br>• <span style="color: #92400e; font-weight: bold;">Perhatian (50% - 79%)</span>: Berwarna Kuning.
                        <br>• <span style="color: #991b1b; font-weight: bold;">Kritis (&lt; 50%)</span>: Berwarna Merah.
                    </p>
                </div>
                <div class="feature-box">
                    <strong style="color: #064e3b; font-size: 7.6pt;">[B] Bar Chart Realisasi vs Target IKK:</strong>
                    <p style="font-size: 7pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Membandingkan secara berdampingan antara target KEPJA yang ditetapkan (batang abu-abu) dengan realisasi riil triwulan (batang biru/hijau) untuk setiap kode indikator kegiatan satker.
                    </p>
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>KEGUNAAN UNTUK BAHAN RAPAT PIMPINAN:</strong><br>
                Grafik ini dapat dijadikan bahan paparan evaluasi internal unit kerja bersama Kepala Biro / Kepala Pusat guna mengidentifikasi kegiatan apa saja yang memerlukan percepatan serapan atau penyelesaian kendala teknis.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 18 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 19: BAB IV - 4.3 MANAJEMEN SIKLUS TRIWULAN
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-19">
        <div class="header">
            <span>BAB IV: DASHBOARD &amp; MONITORING</span>
            <span>4.3 SIKLUS PELAPORAN TRIWULAN I - IV</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB IV: PANDUAN OPERATOR SATKER: MONITORING</div>
            <h2 class="title-primary">4.3 MANAJEMEN SIKLUS PELAPORAN TRIWULAN &amp; LIFECYCLE DATA</h2>

            <p class="paragraph">
                Pelaporan kinerja triwulanan e-LAPTRI v4 dilaksanakan secara periodik 4 kali dalam setahun anggaran. Setiap periode memiliki jadwal pengisian yang ketat agar laporan kompilasi nasional dapat diserahkan ke Jaksa Agung dan KemenPAN-RB tepat waktu:
            </p>

            <table class="table-styled" style="font-size: 7.2pt; margin-top: 4px;">
                <tr>
                    <th style="width: 14%;">Periode</th>
                    <th style="width: 26%;">Cakupan Realisasi Data</th>
                    <th style="width: 25%;">Batas Akhir Input Operator</th>
                    <th>Fokus Evaluasi SAKIP</th>
                </tr>
                <tr>
                    <td><strong>Triwulan I</strong></td>
                    <td>1 Januari s.d. 31 Maret</td>
                    <td>10 April Pukul 23.59 WIB</td>
                    <td>Kesiapan awal program, tender pengadaan, dan baseline realisasi.</td>
                </tr>
                <tr>
                    <td><strong>Triwulan II</strong></td>
                    <td>1 Januari s.d. 30 Juni (Semester I)</td>
                    <td>10 Juli Pukul 23.59 WIB</td>
                    <td>Evaluasi paruh tahun anggaran, progres serapan, dan reviu target.</td>
                </tr>
                <tr>
                    <td><strong>Triwulan III</strong></td>
                    <td>1 Januari s.d. 30 September</td>
                    <td>10 Oktober Pukul 23.59 WIB</td>
                    <td>Akselerasi kegiatan prioritas, identifikasi kendala akhir tahun.</td>
                </tr>
                <tr>
                    <td><strong>Triwulan IV</strong></td>
                    <td>1 Januari s.d. 31 Desember (Tahunan)</td>
                    <td>15 Januari (Tahun Berikutnya)</td>
                    <td>Laporan Akuntabilitas Kinerja Tahunan (LKjIP Final JAMBIN).</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 10px;">DIAGRAM ALIR SIKLUS STATUS DATA (DATA LIFECYCLE):</h3>
            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 10px; margin: 6px 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; text-align: center;">
                    <div style="background: #e2e8f0; border-radius: 5px; padding: 6px 10px; width: 22%;">
                        <div style="font-size: 7pt; color: #475569; font-weight: 700;">STATUS 1</div>
                        <div style="font-size: 9pt; font-weight: 800; color: #0f172a;">DRAFT</div>
                        <div style="font-size: 6.5pt; color: #64748b; margin-top: 2px;">Input data &amp; bukti bebas diedit operator.</div>
                    </div>
                    <div style="font-size: 11pt; color: #94a3b8; font-weight: bold;">→</div>
                    <div style="background: #e0f2fe; border-radius: 5px; padding: 6px 10px; width: 22%;">
                        <div style="font-size: 7pt; color: #0369a1; font-weight: 700;">STATUS 2</div>
                        <div style="font-size: 9pt; font-weight: 800; color: #0284c7;">SUBMITTED</div>
                        <div style="font-size: 6.5pt; color: #0369a1; margin-top: 2px;">Form terkunci, masuk antrean audit JAMBIN.</div>
                    </div>
                    <div style="font-size: 11pt; color: #94a3b8; font-weight: bold;">⇄</div>
                    <div style="background: #fef3c7; border-radius: 5px; padding: 6px 10px; width: 22%;">
                        <div style="font-size: 7pt; color: #92400e; font-weight: 700;">STATUS 3 (OPSI)</div>
                        <div style="font-size: 9pt; font-weight: 800; color: #d97706;">REVISI</div>
                        <div style="font-size: 6.5pt; color: #92400e; margin-top: 2px;">Dikembalikan verifikator dengan catatan koreksi.</div>
                    </div>
                    <div style="font-size: 11pt; color: #94a3b8; font-weight: bold;">→</div>
                    <div style="background: #dcfce7; border-radius: 5px; padding: 6px 10px; width: 22%;">
                        <div style="font-size: 7pt; color: #166534; font-weight: 700;">STATUS 4</div>
                        <div style="font-size: 9pt; font-weight: 800; color: #15803d;">APPROVED</div>
                        <div style="font-size: 6.5pt; color: #166534; margin-top: 2px;">Sah secara hukum &amp; siap di-generate ke Word.</div>
                    </div>
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>DISIPLIN TENGGAT WAKTU PELAPORAN:</strong><br>
                Sistem akan mengunci fitur input secara otomatis tepat pada pukul 23.59 WIB pada tanggal batas akhir. Satker yang belum melakukan submit akan tercatat sebagai *Non-Compliant* pada rekapitulasi kepatuhan pimpinan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 19 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 20: BAB V - 5.1 FORM INPUT DINAMIS (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-20">
        <div class="header">
            <span>BAB V: INPUT PENGUKURAN KINERJA</span>
            <span>5.1 STRUKTUR FORM INPUT DINAMIS</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN</div>
            <h2 class="title-primary">5.1 STRUKTUR FORM INPUT DINAMIS &amp; TAB NAVIGASI LEVEL</h2>

            <p class="paragraph">
                Modul <strong>Input Data</strong> merupakan jantung operasional aplikasi e-LAPTRI v4. Formulir ini dirancang dinamis: antarmuka hanya akan memunculkan ruas input komponen sesuai dengan formula aktif yang terdaftar di sistem:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_input_sp')}" class="screenshot-img" alt="Formulir Input Data Kinerja Level SP dan SK">
                <div class="screenshot-caption">Gambar 5.1: Formulir Input Data Terstruktur dengan Navigasi Tab Program &amp; Accordion Kegiatan</div>
            </div>

            <h3 class="subtitle-primary">PANDUAN KONTROL FORMULIR INPUT DINAMIS:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Toolbar Periode Pelaporan:</strong><br>
                    Pastikan Anda memilih Tahun Anggaran dan Triwulan yang sesuai sebelum mulai mengisi. Status pelaporan aktif ditampilkan di bilah atas.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[2] Tab Navigasi Sasaran Program:</strong><br>
                    Menampilkan daftar Sasaran Program (SP) yang relevan dengan satker Anda. Klik tab untuk berpindah kelompok sasaran secara instan.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[3] Accordion Sasaran Kegiatan (SK):</strong><br>
                    Klik bilah accordion SK untuk membuka daftar Indikator Kinerja Kegiatan (IKK) yang berada di bawahnya secara rapi.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #7c3aed;">[4] Badge Status Indikator:</strong><br>
                    Setiap kartu IKK dilengkapi label status: <span class="badge-role badge-admin">Belum Diisi</span> atau <span class="badge-role badge-opr">Lengkap</span> untuk memudahkan pelacakan.
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>SISTEM INPUT BERBASIS ATRIBUT NODE:</strong><br>
                Sesuai aturan arsitektur, formulir e-LAPTRI v4 memeriksa nilai <code>node.input_enabled</code>. Hanya indikator yang ditandai aktif untuk satker Anda yang akan memunculkan kotak input variabel, mencegah kekeliruan salah input pada indikator biro lain.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 20 dari 40</span>
        </div>
    </div>
    """)

    return pages
