# -*- coding: utf-8 -*-
"""
Modul Halaman 1 sampai 15:
- Halaman 1: Cover Utama Buku Manual E-LAPTRI
- Halaman 2: Lembar Pengesahan, Identitas Dokumen & Hak Cipta
- Halaman 3: Kata Pengantar Jaksa Agung Muda Pembinaan
- Halaman 4: Daftar Isi Lengkap (Bagian I - XI)
- Halaman 5: Glosarium & Taksonomi SAKIP JAMBIN
- Halaman 6: BAB I - 1.1 Latar Belakang & Transformasi Digital
- Halaman 7: BAB I - 1.2 Dasar Hukum & Regulasi Acuan
- Halaman 8: BAB I - 1.3 Tujuan, Manfaat & Sasaran Pengguna
- Halaman 9: BAB I - 1.4 Topologi & Arsitektur Teknologi e-LAPTRI v4
- Halaman 10: BAB II - 2.1 Pohon Kinerja & Hierarki Cascading Canonical
- Halaman 11: BAB II - 2.2 Taksonomi Semantik Relasi Antar-Indikator
- Halaman 12: BAB II - 2.3 Matriks Sasaran Strategis (SS 1 - SS 4) & IKSS
- Halaman 13: BAB II - 2.4 Matriks 11 Sasaran Program (SP) & 19 IKP JAMBIN
- Halaman 14: BAB II - 2.5 Matriks Sasaran Kegiatan (SK) & Distribusi Satker Eselon II
- Halaman 15: BAB III - 3.1 Manajemen Akun & Hak Akses Berbasis Peran (RBAC)
"""

def get_pages_1_to_15(assets):
    pages = []

    # ==========================================
    # HALAMAN 1: COVER UTAMA
    # ==========================================
    pages.append(f"""
    <div class="page page-cover" id="page-1">
        <div style="padding: 30mm 20mm 20mm 20mm; height: 100%; display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box; position: relative;">
            <!-- Top Badge -->
            <div style="border-left: 4px solid #f59e0b; padding-left: 15px;">
                <span style="font-size: 11pt; font-weight: 800; letter-spacing: 2px; color: #f59e0b; text-transform: uppercase;">Kejaksaan Republik Indonesia</span><br>
                <span style="font-size: 14pt; font-weight: 700; color: #e2e8f0;">JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            </div>

            <!-- Main Title Banner -->
            <div style="margin-top: 40px;">
                <div style="display: inline-block; background: rgba(245, 158, 11, 0.2); border: 1px solid #f59e0b; padding: 6px 14px; border-radius: 20px; font-size: 9pt; font-weight: 700; color: #fbbf24; margin-bottom: 15px;">
                    DOKUMEN RESMI PANDUAN TEKNIS SISTEM INFORMASI
                </div>
                <h1 style="font-size: 34pt; font-weight: 900; line-height: 1.1; margin: 0 0 15px 0; color: #ffffff; letter-spacing: -0.5px;">
                    BUKU MANUAL<br><span style="color: #38bdf8;">E-LAPTRI</span>
                </h1>
                <h2 style="font-size: 15pt; font-weight: 600; color: #94a3b8; line-height: 1.4; margin: 0 0 25px 0;">
                    Buku Panduan Operasional Sistem Pelaporan Kinerja Triwulanan & Evaluasi Akuntabilitas Kinerja Instansi Pemerintah (e-LKjIP)
                </h2>
                <div style="height: 4px; width: 120px; background: linear-gradient(90deg, #f59e0b, #38bdf8); border-radius: 2px;"></div>
            </div>

            <!-- System Spec Highlights -->
            <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 18px; backdrop-filter: blur(8px);">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; text-align: center;">
                    <div>
                        <div style="font-size: 8pt; color: #94a3b8; text-transform: uppercase;">Arsitektur Cascading</div>
                        <div style="font-size: 11pt; font-weight: 800; color: #38bdf8; margin-top: 3px;">JAMBIN V3 Canonical</div>
                    </div>
                    <div style="border-left: 1px solid rgba(255,255,255,0.1); border-right: 1px solid rgba(255,255,255,0.1);">
                        <div style="font-size: 8pt; color: #94a3b8; text-transform: uppercase;">Dasar Nomenklatur</div>
                        <div style="font-size: 11pt; font-weight: 800; color: #f59e0b; margin-top: 3px;">Renstra 2025-2029</div>
                    </div>
                    <div>
                        <div style="font-size: 8pt; color: #94a3b8; text-transform: uppercase;">Regulasi SAKIP</div>
                        <div style="font-size: 11pt; font-weight: 800; color: #34d399; margin-top: 3px;">Kepja 1184 / 2025</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Badges -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">
                <div>
                    <div style="font-size: 8.5pt; color: #cbd5e1; font-weight: 600;">Edisi Standar Operasional Prosedur 2026</div>
                    <div style="font-size: 8pt; color: #64748b;">Dilengkapi Tangkapan Layar HD, Formula Registry & Video Screenrecord Langsung Laptop (MP4 HD)</div>
                </div>
                <div style="text-align: right;">
                    <span style="background: #064e3b; color: #6ee7b7; font-size: 8.5pt; font-weight: 700; padding: 6px 14px; border-radius: 6px; border: 1px solid #059669;">
                        45 HALAMAN LENGKAP
                    </span>
                </div>
            </div>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 2: IDENTITAS DOKUMEN & LEGALITAS
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-2">
        <div class="header">
            <span>KEJAKSAAN AGUNG REPUBLIK INDONESIA</span>
            <span>BUKU MANUAL E-LAPTRI | EDISI 2026</span>
        </div>
        <div class="content">
            <h2 class="title-primary" style="margin-top: 10px;">LEMBAR IDENTITAS DOKUMEN & PENGESAHAN</h2>
            <p class="paragraph">
                Buku Manual ini disusun sebagai pedoman teknis operasional baku bagi seluruh Unit Kerja Eselon II di lingkungan Jaksa Agung Muda Bidang Pembinaan dalam merekam, menghitung, memvalidasi, dan melaporkan capaian kinerja triwulanan secara digital.
            </p>

            <table class="table-styled" style="margin-top: 15px;">
                <tr>
                    <th style="width: 32%;">Parameter Dokumen</th>
                    <th>Keterangan Resmi</th>
                </tr>
                <tr>
                    <td><strong>Judul Publikasi</strong></td>
                    <td>Buku Manual Operasional e-LAPTRI (e-LKjIP Pembinaan JAMBIN)</td>
                </tr>
                <tr>
                    <td><strong>Nomor Dokumen</strong></td>
                    <td>MAN-01/JAMBIN/SAKIP-REN/03/2026</td>
                </tr>
                <tr>
                    <td><strong>Versi Sistem</strong></td>
                    <td>e-LAPTRI v4.0.2 (Canonical Cascading Architecture)</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Efektif</strong></td>
                    <td>1 Januari 2026</td>
                </tr>
                <tr>
                    <td><strong>Penerbit</strong></td>
                    <td>Sekretariat Jaksa Agung Muda Bidang Pembinaan cq. Bagian Reformasi Birokrasi & Biro Perencanaan Kejaksaan Agung RI</td>
                </tr>
                <tr>
                    <td><strong>Klasifikasi Akses</strong></td>
                    <td>INTERNAL DINAS KEJAKSAAN REPUBLIK INDONESIA</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 25px;">SUSUNAN TIM PENGARAH & PENYUSUN</h3>
            <table class="table-styled">
                <tr>
                    <th style="width: 32%;">Jabatan Kedinasan</th>
                    <th>Nama & Peran Fungsional</th>
                </tr>
                <tr>
                    <td><strong>Pengarah Utama</strong></td>
                    <td>Jaksa Agung Muda Bidang Pembinaan (Dr. Hendro Dewanto, S.H., M.Hum.)</td>
                </tr>
                <tr>
                    <td><strong>Penanggung Jawab</strong></td>
                    <td>Sekretaris Jaksa Agung Muda Bidang Pembinaan (Sesjambin)</td>
                </tr>
                <tr>
                    <td><strong>Ketua Pelaksana</strong></td>
                    <td>Kepala Biro Perencanaan Kejaksaan Agung RI</td>
                </tr>
                <tr>
                    <td><strong>Tim Teknis & Substansi</strong></td>
                    <td>Tim SAKIP Biro Perencanaan, Tim IT Pusdaskrimti, Tim Regulasi Pustrajakgakum, serta Koordinator Pelaporan Eselon II (Biro Umum, Biro Kepegawaian, Biro Keuangan, Biro Perlengkapan, Biro Hukum & HLN, dan Pusat Kesehatan Yustisial)</td>
                </tr>
            </table>

            <div class="callout callout-warning" style="margin-top: 25px;">
                <strong>HAK CIPTA & KETENTUAN DISTRIBUSI:</strong><br>
                Seluruh isi, diagram cascading, struktur formula, format template Word LKjIP, dan tangkapan layar dalam buku ini dilindungi hak cipta kedinasan Kejaksaan Republik Indonesia. Dilarang menggandakan, menyebarluaskan, atau memodifikasi sebagian atau seluruh isi buku ini tanpa izin tertulis dari Sekretariat Jaksa Agung Muda Bidang Pembinaan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 2 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 3: KATA PENGANTAR
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-3">
        <div class="header">
            <span>KATA PENGANTAR</span>
            <span>BUKU MANUAL E-LAPTRI</span>
        </div>
        <div class="content">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="font-size: 15pt; font-weight: 800; color: #0f172a; margin: 0; text-transform: uppercase;">KATA PENGANTAR</h2>
                <h3 style="font-size: 11pt; font-weight: 600; color: #064e3b; margin: 4px 0 0 0;">JAKSA AGUNG MUDA BIDANG PEMBINAAN KEJAKSAAN AGUNG RI</h3>
                <div style="width: 80px; height: 3px; background: #d97706; margin: 10px auto;"></div>
            </div>

            <p class="paragraph">
                Puji dan syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa, atas limpahan rahmat dan karunia-Nya, penyempurnaan aplikasi <strong>e-LAPTRI Versi 4 (e-LKjIP Pembinaan)</strong> beserta penerbitan <strong>Buku Manual Operasional 45 Halaman</strong> ini dapat terselesaikan dengan baik dan terstandarisasi.
            </p>
            <p class="paragraph">
                Penerapan Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) yang efektif, objektif, dan transparan merupakan amanat strategis reformasi birokrasi Kejaksaan RI. Sesuai dengan Rencana Strategis (Renstra) Kejaksaan RI Tahun 2025-2029 dan Keputusan Jaksa Agung Nomor 1184 Tahun 2025, pengukuran kinerja tidak boleh lagi dipandang sebagai rutinitas administratif semata, melainkan instrumen kendali strategis manajemen berbasis kinerja <em>(performance-based management)</em>.
            </p>
            <p class="paragraph">
                Aplikasi e-LAPTRI v4 hadir membawa terobosan fundamental:
            </p>
            <ul style="font-size: 9pt; color: #334155; line-height: 1.6; margin: 0 0 15px 20px;">
                <li><strong>Arsitektur Canonical Directed Acyclic Graph (DAG):</strong> Menghilangkan kekeliruan perhitungan linear dan melarang generic averaging yang mendistorsi angka capaian.</li>
                <li><strong>Dynamic Calculation Engine & Raw Input:</strong> Mengharuskan pencatatan variabel mentah ($X_1$ pembilang, $X_2$ penyebut) sehingga setiap persentase realisasi memiliki bukti audit matematis yang solid.</li>
                <li><strong>Word Template Generator Otomatis:</strong> Mempercepat penyusunan Laporan Kinerja (LKjIP) triwulanan dari hitungan minggu menjadi hitungan detik dengan tata letak dokumen resmi standar Kejaksaan RI.</li>
            </ul>
            <p class="paragraph">
                Saya menyampaikan apresiasi setinggi-tingginya kepada Tim Penyusun Biro Perencanaan, Pusdaskrimti, serta seluruh Operator Eselon II di lingkungan JAMBIN. Manfaatkan buku manual ini dan serial video tutorial terlampir dengan saksama guna mewujudkan akuntabilitas kinerja JAMBIN yang berintegritas dan terpercaya.
            </p>

            <div style="margin-top: 35px; float: right; width: 220px; text-align: center;">
                <div style="font-size: 9pt; color: #64748b;">Jakarta, Maret 2026</div>
                <div style="font-size: 9.5pt; font-weight: 700; color: #0f172a; margin-top: 5px;">Jaksa Agung Muda Bidang Pembinaan</div>
                <div style="height: 50px;"></div>
                <div style="font-size: 10pt; font-weight: 800; color: #0f172a; text-decoration: underline;">Dr. HENDRO DEWANTO, S.H., M.Hum.</div>
                <div style="font-size: 8.5pt; color: #475569;">Jaksa Utama Madya</div>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 3 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 4: DAFTAR ISI LENGKAP
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-4">
        <div class="header">
            <span>DAFTAR ISI</span>
            <span>BUKU MANUAL E-LAPTRI</span>
        </div>
        <div class="content">
            <h2 class="title-primary" style="margin-top: 5px; margin-bottom: 15px;">DAFTAR ISI LENGKAP</h2>
            
            <div style="font-size: 8.5pt; line-height: 1.5; color: #1e293b;">
                <div style="display: flex; justify-content: space-between; font-weight: 800; border-bottom: 1.5px solid #0f172a; padding-bottom: 3px; margin-bottom: 6px;">
                    <span>BAB / BAGIAN MATERI OPERASIONAL</span>
                    <span>HALAMAN</span>
                </div>

                <div class="toc-line"><span>LEMBAR IDENTITAS DOKUMEN & PENGESAHAN</span><span>2</span></div>
                <div class="toc-line"><span>KATA PENGANTAR JAKSA AGUNG MUDA BIDANG PEMBINAAN</span><span>3</span></div>
                <div class="toc-line"><span>DAFTAR ISI LENGKAP</span><span>4</span></div>
                <div class="toc-line"><span>GLOSARIUM & TAKSONOMI KINERJA SAKIP JAMBIN</span><span>5</span></div>

                <div class="toc-head">BAB I: PENDAHULUAN & ARSITEKTUR SISTEM</div>
                <div class="toc-item"><span>1.1 Latar Belakang & Transformasi Digital e-LAPTRI</span><span>6</span></div>
                <div class="toc-item"><span>1.2 Dasar Hukum & Regulasi Acuan</span><span>7</span></div>
                <div class="toc-item"><span>1.3 Tujuan, Manfaat, & Sasaran Pengguna</span><span>8</span></div>
                <div class="toc-item"><span>1.4 Arsitektur Teknologi & Topologi Sistem v4</span><span>9</span></div>

                <div class="toc-head">BAB II: KERANGKA KERJA KINERJA & CASCADING JAMBIN 2025-2029</div>
                <div class="toc-item"><span>2.1 Pohon Kinerja & Hierarki Cascading Canonical</span><span>10</span></div>
                <div class="toc-item"><span>2.2 Taksonomi Semantik Relasi Antar-Indikator</span><span>11</span></div>
                <div class="toc-item"><span>2.3 Matriks Sasaran Strategis (SS 1 - SS 4) & IKSS</span><span>12</span></div>
                <div class="toc-item"><span>2.4 Matriks 11 Sasaran Program (SP) & 19 IKP JAMBIN</span><span>13</span></div>
                <div class="toc-item"><span>2.5 Matriks Sasaran Kegiatan (SK) & Distribusi Satker Eselon II</span><span>14</span></div>

                <div class="toc-head">BAB III: HAK AKSES, AUTENTIKASI & KEAMANAN SISTEM</div>
                <div class="toc-item"><span>3.1 Manajemen Akun & Hak Akses Berbasis Peran (RBAC)</span><span>15</span></div>
                <div class="toc-item"><span>3.2 Prosedur Login & Autentikasi Sistem [Tangkapan Layar]</span><span>16</span></div>
                <div class="toc-item"><span>3.3 Manajemen Profil, Perubahan Kata Sandi & Sesi [Tangkapan Layar]</span><span>17</span></div>

                <div class="toc-head">BAB IV: PANDUAN OPERATOR SATKER: DASHBOARD & NAVIGASI</div>
                <div class="toc-item"><span>4.1 Antarmuka Utama Operator & Widget Status Real-Time [Tangkapan Layar]</span><span>18</span></div>
                <div class="toc-item"><span>4.2 Visualisasi Grafik Kinerja & Analisis Tren [Tangkapan Layar]</span><span>19</span></div>
                <div class="toc-item"><span>4.3 Monitoring Status Periode Pelaporan Triwulan I - IV</span><span>20</span></div>

                <div class="toc-head">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN KINERJA TRIWULANAN</div>
                <div class="toc-item"><span>5.1 Struktur Form Input Dinamis & Navigasi Tab Level [Tangkapan Layar]</span><span>21</span></div>
                <div class="toc-item"><span>5.2 Pengisian Komponen Rumus Rasio (Pembilang X1 & Penyebut X2) [Tangkapan Layar]</span><span>22</span></div>
                <div class="toc-item"><span>5.3 Perbedaan Indikator Mandiri vs Indikator Agregatif</span><span>23</span></div>
                <div class="toc-item"><span>5.4 Kalkulasi Otomatis Realisasi & Capaian Terhadap Target</span><span>24</span></div>
                <div class="toc-item"><span>5.5 Penyusunan Analisis Kinerja: Faktor Kendala & Solusi [Tangkapan Layar]</span><span>25</span></div>
                <div class="toc-item"><span>5.6 Mekanisme Autosave, Validasi Input & Evidence Pendukung</span><span>26</span></div>
                <div class="toc-item"><span>5.7 Finalisasi Data & Prosedur Submit Pengukuran ke JAMBIN</span><span>27</span></div>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 4 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 5: GLOSARIUM & TAKSONOMI SAKIP
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-5">
        <div class="header">
            <span>DAFTAR ISI (LANJUTAN) & GLOSARIUM</span>
            <span>BUKU MANUAL E-LAPTRI</span>
        </div>
        <div class="content">
            <div style="font-size: 8.5pt; line-height: 1.5; color: #1e293b; margin-bottom: 15px;">
                <div class="toc-head">BAB VI: PANDUAN VERIFIKATOR & ADMIN: REVIEW & AUDIT DATA</div>
                <div class="toc-item"><span>6.1 Dashboard Pemantauan Kinerja Nasional / JAMBIN [Tangkapan Layar]</span><span>28</span></div>
                <div class="toc-item"><span>6.2 Monitoring Kepatuhan Pengisian Seluruh Satker Eselon II</span><span>29</span></div>
                <div class="toc-item"><span>6.3 Halaman Review Data: Filter Periode & DataGrid [Tangkapan Layar]</span><span>30</span></div>
                <div class="toc-item"><span>6.4 Detail Lembar Kerja Verifikasi: Audit Realisasi [Tangkapan Layar]</span><span>31</span></div>
                <div class="toc-item"><span>6.5 Alur Approval & Prosedur Pengembalian Data (Revisi)</span><span>32</span></div>

                <div class="toc-head">BAB VII: PANDUAN ADMIN: FORMULA REGISTRY & MANAJEMEN RUMUS</div>
                <div class="toc-item"><span>7.1 Katalog Formula Indikator & Formula Registry [Tangkapan Layar]</span><span>33</span></div>
                <div class="toc-item"><span>7.2 Klasifikasi 9 Tipe Kalkulasi Kinerja Canonical</span><span>34</span></div>
                <div class="toc-item"><span>7.3 Konfigurasi Komponen Rumus, Bobot & Sumber Data [Tangkapan Layar]</span><span>35</span></div>
                <div class="toc-item"><span>7.4 Versioning Formula & Audit Trail Perubahan Rumus</span><span>36</span></div>

                <div class="toc-head">BAB VIII: BUILDER TEMPLATE LKJIP & PELAPORAN WORD</div>
                <div class="toc-item"><span>8.1 Manajemen Template Dokumen Word LKjIP SAKIP [Tangkapan Layar]</span><span>37</span></div>
                <div class="toc-item"><span>8.2 Standardisasi Placeholder & Tagging Dinamis PHPWord</span><span>38</span></div>
                <div class="toc-item"><span>8.3 Prosedur Upload Custom Template & Validasi Sistem</span><span>39</span></div>

                <div class="toc-head">BAB IX: GENERASI & EKSPOR LAPORAN AKUNTABILITAS (LKJIP)</div>
                <div class="toc-item"><span>9.1 Modul Ekspor Laporan LKjIP Triwulanan e-LAPTRI [Tangkapan Layar]</span><span>40</span></div>
                <div class="toc-item"><span>9.2 Parameter Unduhan Dokumen Resmi DOCX & Analisis Output</span><span>41</span></div>

                <div class="toc-head">BAB X: VIDEO TUTORIAL KESELURUHAN (SCREENRECORD INTERAKTIF LAPTOP)</div>
                <div class="toc-item"><span>10.1 Spesifikasi Video Screenrecord Interaktif Laptop [Frame Rekaman]</span><span>42</span></div>
                <div class="toc-item"><span>10.2 Panduan Akses Berkas Video MP4 & Storyboard Rekaman [File Lokal]</span><span>43</span></div>

                <div class="toc-head">BAB XI: TROUBLESHOOTING, FAQ & BANTUAN OPERASIONAL</div>
                <div class="toc-item"><span>11.1 Pemecahan Masalah Umum (Troubleshooting & FAQ)</span><span>44</span></div>
                <div class="toc-item"><span>11.2 Standar Pelayanan Helpdesk & Berita Acara Rekonsiliasi</span><span>45</span></div>
            </div>

            <h3 class="subtitle-primary" style="margin-top: 10px;">GLOSARIUM & ISTILAH UTAMA SISTEM</h3>
            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 25%;">Istilah</th>
                    <th>Definisi Operasional e-LAPTRI</th>
                </tr>
                <tr>
                    <td><strong>Cascading Kinerja</strong></td>
                    <td>Penjenjangan tujuan, sasaran, dan indikator kinerja secara vertikal dari level Kejaksaan Agung ke JAMBIN hingga ke level Satker Biro/Pusat.</td>
                </tr>
                <tr>
                    <td><strong>Directed Acyclic Graph (DAG)</strong></td>
                    <td>Struktur data pohon kinerja di mana simpul indikator dapat terhubung multi-parent tanpa siklus loop, mencegah ketergantungan linier kaku.</td>
                </tr>
                <tr>
                    <td><strong>Formula Component</strong></td>
                    <td>Variabel dasar pembentuk rumus (seperti $X_1$ Pembilang, $X_2$ Penyebut) yang harus diisi dengan angka riil dari dokumen sumber.</td>
                </tr>
                <tr>
                    <td><strong>Mandiri vs Agregatif</strong></td>
                    <td>Indikator Mandiri bernilai langsung dari input satker tunggal; Indikator Agregatif terkonsolidasi dari roll-up sub-node atau multi-unit kerja.</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 5 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 6: BAB I - 1.1 LATAR BELAKANG
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-6">
        <div class="header">
            <span>BAB I: PENDAHULUAN & ARSITEKTUR</span>
            <span>1.1 LATAR BELAKANG</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB I: PENDAHULUAN & ARSITEKTUR SISTEM</div>
            <h2 class="title-primary">1.1 LATAR BELAKANG & TRANSFORMASI DIGITAL</h2>
            
            <p class="paragraph">
                Penyelenggaraan tata kelola pemerintahan yang baik <em>(good governance)</em> di tubuh Kejaksaan Republik Indonesia menuntut adanya pertanggungjawaban kinerja yang transparan, terukur, dan akuntabel. Jaksa Agung Muda Bidang Pembinaan (JAMBIN) memegang peranan krusial sebagai tulang punggung organisasi Kejaksaan RI dalam pengelolaan sumber daya manusia, tata kelola keuangan negara, sarana prasarana perlengkapan, perencanaan strategis, regulasi hukum, hingga teknologi informasi kriminal.
            </p>
            <p class="paragraph">
                Sebelum diterapkannya aplikasi <strong>e-LAPTRI Versi 4</strong>, proses pengumpulan dan konsolidasi Laporan Kinerja Triwulanan (Lap-Tri) di lingkungan JAMBIN menghadapi berbagai kendala struktural yang signifikan:
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 15px 0;">
                <div class="feature-box">
                    <div style="font-weight: 700; color: #b91c1c; margin-bottom: 5px;">Tantangan Sistem Manual / Legacy</div>
                    <ul style="font-size: 8pt; margin: 0; padding-left: 15px; line-height: 1.5; color: #475569;">
                        <li>Fragmentasi data di spreadsheet Excel tiap Biro/Pusat.</li>
                        <li>Ketiadaan validasi matematis komponen rumus ($X_1/X_2$).</li>
                        <li>Rumus rata-rata generik yang mendistorsi capaian nyata.</li>
                        <li>Proses rekapitulasi LKjIP memakan waktu 2-3 minggu.</li>
                        <li>Jejak audit (audit trail) revisi data tidak terekam otomatis.</li>
                    </ul>
                </div>
                <div class="feature-box">
                    <div style="font-weight: 700; color: #047857; margin-bottom: 5px;">Solusi Modern e-LAPTRI Versi 4</div>
                    <ul style="font-size: 8pt; margin: 0; padding-left: 15px; line-height: 1.5; color: #475569;">
                        <li>Single source of truth terintegrasi database terpusat.</li>
                        <li>Dynamic input komponen rumus dengan validasi zero-division.</li>
                        <li>Canonical cascading DAG sesuai Renstra 2025-2029.</li>
                        <li>Otomatisasi cetak dokumen LKjIP Word dalam hitungan detik.</li>
                        <li>Audit log historis dan alur verifikasi bertingkat.</li>
                    </ul>
                </div>
            </div>

            <p class="paragraph">
                Transformasi ini tidak sekadar memindahkan pencatatan dari kertas ke layar komputer, tetapi mendesain ulang arsitektur pengukuran kinerja JAMBIN agar memenuhi standar evaluasi Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) yang ditetapkan Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi (KemenPAN-RB).
            </p>

            <div class="callout callout-info" style="margin-top: 15px;">
                <strong>FOKUS STRATEGIS TRANSFORMASI e-LAPTRI:</strong><br>
                Menjamin bahwa setiap angka kinerja yang tersaji pada Laporan Kinerja (LKjIP) JAMBIN dapat diuji validitasnya hingga ke tingkat dokumen bukti fisik (evidence) paling dasar di setiap satuan kerja.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 6 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 7: BAB I - 1.2 DASAR HUKUM
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-7">
        <div class="header">
            <span>BAB I: PENDAHULUAN & ARSITEKTUR</span>
            <span>1.2 DASAR HUKUM REGULASI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB I: PENDAHULUAN & ARSITEKTUR SISTEM</div>
            <h2 class="title-primary">1.2 DASAR HUKUM & REGULASI ACUAN</h2>
            
            <p class="paragraph">
                Pengembangan dan pengoperasian sistem e-LAPTRI berpijak pada landasan hukum peraturan perundang-undangan nasional dan regulasi internal Kejaksaan RI:
            </p>

            <div style="margin-top: 10px;">
                <div class="card-regulasi">
                    <div class="regulasi-title">1. Undang-Undang Nomor 11 Tahun 2021</div>
                    <div class="regulasi-desc">Perubahan atas Undang-Undang Nomor 16 Tahun 2004 tentang Kejaksaan Republik Indonesia, yang menegaskan kemandirian, akuntabilitas, dan modernisasi tata kelola aparatur kejaksaan.</div>
                </div>

                <div class="card-regulasi">
                    <div class="regulasi-title">2. Peraturan Presiden Nomor 29 Tahun 2014</div>
                    <div class="regulasi-desc">Tentang Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP), yang mewajibkan seluruh kementerian/lembaga merumuskan perencanaan kinerja, pengukuran kinerja, pelaporan kinerja, dan evaluasi kinerja secara berkesinambungan.</div>
                </div>

                <div class="card-regulasi">
                    <div class="regulasi-title">3. Peraturan MenPAN-RB Nomor 88 Tahun 2021</div>
                    <div class="regulasi-desc">Pedoman Evaluasi Akuntabilitas Kinerja Instansi Pemerintah, yang menitikberatkan pada logisnya penjenjangan sasaran kinerja (cascading) dan ketepatan pemilihan indikator output/outcome.</div>
                </div>

                <div class="card-regulasi">
                    <div class="regulasi-title">4. Rencana Strategis (Renstra) Kejaksaan RI Tahun 2025-2029</div>
                    <div class="regulasi-desc">Dokumen induk rencana pembangunan jangka menengah Kejaksaan RI yang memuat 4 Sasaran Strategis (SS), 11 Sasaran Program (SP) dalam ruang lingkup Pembinaan, 19 Indikator Kinerja Program (IKP), serta 35 Sasaran Kegiatan (SK) dan 97 IKK terkait beserta target kumulatif lima tahunan.</div>
                </div>

                <div class="card-regulasi">
                    <div class="regulasi-title">5. Keputusan Jaksa Agung RI Nomor 1184 Tahun 2025</div>
                    <div class="regulasi-desc">Tentang Penetapan Indikator Kinerja Utama (IKU), Indikator Kinerja Program (IKP), Indikator Kinerja Kegiatan (IKK), dan Definisi Operasional Formula di Lingkungan Kejaksaan Republik Indonesia.</div>
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 15px;">
                <strong>KEWAJIBAN HUKUM OPERATOR SATKER:</strong><br>
                Setiap data yang dimasukkan ke dalam aplikasi e-LAPTRI memiliki kekuatan pertanggungjawaban hukum kedinasan. Data kinerja yang dilaporkan secara tidak akurat atau sengaja dimanipulasi melanggar disiplin aparatur sipil negara dan kode etik profesi Kejaksaan RI.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 7 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 8: BAB I - 1.3 TUJUAN & PENGGUNA
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-8">
        <div class="header">
            <span>BAB I: PENDAHULUAN & ARSITEKTUR</span>
            <span>1.3 TUJUAN, MANFAAT & SASARAN PENGGUNA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB I: PENDAHULUAN & ARSITEKTUR SISTEM</div>
            <h2 class="title-primary">1.3 TUJUAN, MANFAAT & SASARAN PENGGUNA</h2>
            
            <h3 class="subtitle-primary">TUJUAN OPERASIONAL SISTEM</h3>
            <ul style="font-size: 8.5pt; color: #334155; line-height: 1.6; margin: 0 0 15px 20px;">
                <li>Menyediakan instrumen digital input kinerja triwulanan yang terintegrasi untuk 10 Satker Eselon II di lingkungan JAMBIN.</li>
                <li>Memvalidasi kebenaran matematis penghitungan realisasi dan capaian indikator secara real-time.</li>
                <li>Menerapkan alur persetujuan bertingkat (approval workflow) antara Operator Satker dan Tim Verifikator JAMBIN.</li>
                <li>Menghasilkan draf dokumen Laporan Akuntabilitas Kinerja (LKjIP) resmi dalam format Microsoft Word (.docx) secara instan.</li>
            </ul>

            <h3 class="subtitle-primary">MANFAAT BAGI ORGANISASI</h3>
            <table class="table-styled">
                <tr>
                    <th style="width: 25%;">Perspektif</th>
                    <th>Manfaat Nyata e-LAPTRI</th>
                </tr>
                <tr>
                    <td><strong>Pimpinan (JAMBIN)</strong></td>
                    <td>Pemantauan <em>(monitoring)</em> progres ketercapaian target Renstra secara visual dan real-time tanpa menunggu laporan tahunan berakhir.</td>
                </tr>
                <tr>
                    <td><strong>Verifikator (Biro Ren)</strong></td>
                    <td>Kemudahan audit konsistensi data antara target, input mentah, bukti pendukung, dan evaluasi narasi kendala.</td>
                </tr>
                <tr>
                    <td><strong>Operator Satker</strong></td>
                    <td>Panduan jelas komponen apa saja yang perlu disiapkan, penghitungan persentase otomatis tanpa risiko salah rumus kalkulator.</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 15px;">MATRIKS PERAN & SASARAN PENGGUNA</h3>
            <table class="table-styled">
                <tr>
                    <th style="width: 18%;">Tingkat Peran</th>
                    <th style="width: 27%;">Pengguna (Role)</th>
                    <th>Hak Akses & Kewenangan Sistem</th>
                </tr>
                <tr>
                    <td><span class="badge-role badge-admin">ADMIN</span></td>
                    <td>Biro Perencanaan / Tim SAKIP JAMBIN</td>
                    <td>Mengelola formula registry, monitoring seluruh satker, verifikasi/approval data, builder template LKjIP, dan ekspor laporan nasional.</td>
                </tr>
                <tr>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>10 Satker Eselon II JAMBIN</td>
                    <td>Mengisi nilai mentah ($X_1, X_2$), menginput narasi kendala & upaya, mengelola profil satker, dan mengajukan (submit) data triwulanan.</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 8 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 9: BAB I - 1.4 TOPOLOGI TEKNOLOGI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-9">
        <div class="header">
            <span>BAB I: PENDAHULUAN & ARSITEKTUR</span>
            <span>1.4 ARSITEKTUR & TOPOLOGI SISTEM</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB I: PENDAHULUAN & ARSITEKTUR SISTEM</div>
            <h2 class="title-primary">1.4 TOPOLOGI & ARSITEKTUR TEKNOLOGI e-LAPTRI v4</h2>
            
            <p class="paragraph">
                Sistem e-LAPTRI v4 dirancang menggunakan arsitektur modern berstandar enterprise dengan pola <em>Single Page Application (SPA) Monolith</em> yang memisahkan antara Presentation Layer yang responsif dan Robust Backend Engine:
            </p>

            <div style="background: #0f172a; color: #ffffff; border-radius: 8px; padding: 15px; margin: 15px 0;">
                <div style="font-size: 9.5pt; font-weight: 700; color: #38bdf8; margin-bottom: 8px;">STACK TEKNOLOGI INTI:</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 8pt;">
                    <div>
                        <span style="color: #f59e0b; font-weight: 700;">Backend Framework:</span> Laravel 11.x (PHP 8.4)<br>
                        <span style="color: #f59e0b; font-weight: 700;">Frontend UI:</span> React 18.3 & Inertia.js<br>
                        <span style="color: #f59e0b; font-weight: 700;">Component Library:</span> Material UI (MUI v5)
                    </div>
                    <div>
                        <span style="color: #f59e0b; font-weight: 700;">Database:</span> MySQL 8.0 / MariaDB 10.11<br>
                        <span style="color: #f59e0b; font-weight: 700;">Document Generator:</span> PHPWord 1.3 / ZIP Engine<br>
                        <span style="color: #f59e0b; font-weight: 700;">Asset Bundler:</span> Vite 6.0 Modern ESM
                    </div>
                </div>
            </div>

            <h3 class="subtitle-primary">DIAGRAM ALIR DATA & EKSEKUSI SISTEM</h3>
            <div style="border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px; background: #f8fafc; font-size: 8pt; line-height: 1.5;">
                <div style="display: flex; justify-content: space-between; align-items: center; text-align: center;">
                    <div style="background: #ffffff; border: 1.5px solid #0284c7; border-radius: 6px; padding: 8px; width: 22%;">
                        <strong style="color: #0284c7;">Operator Input</strong><br>
                        Form React (MUI)<br>
                        Input $X_1$ & $X_2$
                    </div>
                    <span style="font-weight: 800; color: #64748b;">➔ HTTP POST ➔</span>
                    <div style="background: #ffffff; border: 1.5px solid #059669; border-radius: 6px; padding: 8px; width: 22%;">
                        <strong style="color: #059669;">Calculation Engine</strong><br>
                        Formula Resolver<br>
                        Kalkulasi Realisasi & Target
                    </div>
                    <span style="font-weight: 800; color: #64748b;">➔ AUDIT ➔</span>
                    <div style="background: #ffffff; border: 1.5px solid #d97706; border-radius: 6px; padding: 8px; width: 22%;">
                        <strong style="color: #d97706;">Review & Approval</strong><br>
                        Admin JAMBIN<br>
                        Status Disetujui
                    </div>
                    <span style="font-weight: 800; color: #64748b;">➔ EKSPOR ➔</span>
                    <div style="background: #ffffff; border: 1.5px solid #7c3aed; border-radius: 6px; padding: 8px; width: 22%;">
                        <strong style="color: #7c3aed;">LKjIP DOCX</strong><br>
                        PHPWord Engine<br>
                        Format Resmi SAKIP
                    </div>
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 15px;">
                <strong>STANDAR KEAMANAN SISTEM:</strong><br>
                Sistem mengimplementasikan proteksi CSRF Token pada setiap mutasi data, Enkripsi Hash Argon2id untuk kata sandi, Session State Server-Side, serta pemisahan data tingkat baris berdasarkan hak akses unit kerja.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 9 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 10: BAB II - 2.1 POHON KINERJA CASCADING
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-10">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.1 POHON KINERJA CANONICAL</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA KERJA KINERJA & CASCADING JAMBIN</div>
            <h2 class="title-primary">2.1 POHON KINERJA & HIERARKI CASCADING CANONICAL</h2>
            
            <p class="paragraph">
                Pohon Kinerja e-LAPTRI Versi 4 mengadopsi struktur penjenjangan canonical 6 tingkat yang selaras secara ketat dengan Renstra Kejaksaan RI 2025-2029. Pohon kinerja ini tidak memperlakukan pohon sebagai relasi pohon hierarki biner sederhana, melainkan <strong>Directed Acyclic Graph (DAG)</strong>:
            </p>

            <table class="table-styled" style="margin-top: 10px;">
                <tr>
                    <th style="width: 14%;">Level</th>
                    <th style="width: 26%;">Entitas Kinerja</th>
                    <th style="width: 25%;">Tingkat Akuntabilitas</th>
                    <th>Contoh Kode Canonical</th>
                </tr>
                <tr>
                    <td><strong>Level 1</strong></td>
                    <td>Sasaran Strategis (SS)</td>
                    <td>Kejaksaan Agung RI (Makro)</td>
                    <td><code>SS 1 s/d SS 4</code></td>
                </tr>
                <tr>
                    <td><strong>Level 2</strong></td>
                    <td>Indikator SS (IKSS)</td>
                    <td>Tingkat Lembaga Nasional</td>
                    <td><code>IKSS 1.1, IKSS 4.1</code></td>
                </tr>
                <tr>
                    <td><strong>Level 3</strong></td>
                    <td>Sasaran Program (SP)</td>
                    <td>Tingkat Eselon I (JAMBIN)</td>
                    <td><code>11 SP (SP 1 s/d SP 16)</code></td>
                </tr>
                <tr>
                    <td><strong>Level 4</strong></td>
                    <td>Indikator Program (IKP)</td>
                    <td>Program Pembinaan JAMBIN</td>
                    <td><code>19 IKP (IKP 1.1 s/d IKP 16.1)</code></td>
                </tr>
                <tr>
                    <td><strong>Level 5</strong></td>
                    <td>Sasaran Kegiatan (SK)</td>
                    <td>Tingkat Eselon II (Biro/Pusat)</td>
                    <td><code>35 SK (SK 1.1 s/d SK 16.1)</code></td>
                </tr>
                <tr>
                    <td><strong>Level 6</strong></td>
                    <td>Indikator Kegiatan (IKK)</td>
                    <td>Output Operasional Satker</td>
                    <td><code>97 IKK Operasional Satker</code></td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 15px;">PRINSIP BEBAS SIKLUS (DIRECTED ACYCLIC GRAPH)</h3>
            <p class="paragraph">
                Dalam arsitektur DAG e-LAPTRI, sebuah Indikator Kegiatan (IKK) dapat mengalirkan data capaiannya ke beberapa Sasaran Kegiatan (SK) atau Sasaran Program (SP) tanpa menimbulkan kontradiksi data. Namun, sistem secara mutlak menolak adanya <em>circular reference</em> (simpul $A$ mengacu ke $B$, dan $B$ kembali mengacu ke $A$).
            </p>

            <div class="callout callout-warning">
                <strong>ATURAN MUTLAK CANONICAL KINERJA:</strong><br>
                Tabel <code>kinerja_nodes</code> merupakan identitas utama seluruh SS, IKSS, SP, IKP, SK, dan IKK. Jangan sekali-kali mengasumsikan bahwa parent node dihitung dari rata-rata seluruh child node. Setiap hubungan kalkulasi harus terdaftar secara eksplisit pada relasi formula!
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 10 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 11: BAB II - 2.2 TAKSONOMI SEMANTIK RELASI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-11">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.2 TAKSONOMI SEMANTIK RELASI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA KERJA KINERJA & CASCADING JAMBIN</div>
            <h2 class="title-primary">2.2 TAKSONOMI SEMANTIK RELASI ANTAR-INDIKATOR</h2>
            
            <p class="paragraph">
                Setiap relasi pada tabel <code>kinerja_relasi</code> memiliki atribut <code>jenis_relasi</code> yang didefinisikan secara tegas untuk mencegah distorsi matematis dalam penghitungan otomatis:
            </p>

            <table class="table-styled">
                <tr>
                    <th style="width: 24%;">Jenis Relasi</th>
                    <th style="width: 28%;">Makna Konseptual</th>
                    <th>Implikasi Perhitungan Matematis</th>
                </tr>
                <tr>
                    <td><code>STRUCTURAL</code></td>
                    <td>Pasangan sasaran dan indikator pada level yang sama.</td>
                    <td>Tidak ada perhitungan roll-up; indikator mengukur ketercapaian sasaran induknya.</td>
                </tr>
                <tr>
                    <td><code>CASCADING</code></td>
                    <td>Penjenjangan outcome ke output dari level atas ke bawah.</td>
                    <td>Sebagai penjelas hierarki logis; <strong>tidak otomatis dihitung rata-rata</strong> ke parent.</td>
                </tr>
                <tr>
                    <td><code>FORMULA_COMPONENT</code></td>
                    <td>Child merupakan operand langsung rumus matematika parent.</td>
                    <td><strong>Dihitung secara matematis</strong> sesuai rumus parent (misal: AVERAGE, SUM, atau WEIGHTED_SUM).</td>
                </tr>
                <tr>
                    <td><code>CONTRIBUTION</code></td>
                    <td>Child mendukung sasaran parent tetapi non-matematis.</td>
                    <td>Digunakan dalam analisis narasi kualitatif LKjIP; tidak mempengaruhi angka realisasi parent.</td>
                </tr>
                <tr>
                    <td><code>SAME_INDICATOR</code></td>
                    <td>Indikator yang sama diturunkan pada level bawahan.</td>
                    <td>Nilai realisasi diteruskan secara langsung tanpa dirata-ratakan dengan indikator lain.</td>
                </tr>
                <tr>
                    <td><code>ORG_AGGREGATION</code></td>
                    <td>Konsolidasi indikator antarunit kerja / satker.</td>
                    <td>Penggabungan nilai dari beberapa satker pengampu (misal: rata-rata nilai Reformasi Birokrasi).</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 15px;">
                <strong>LARANGAN GENERIC AVERAGE:</strong><br>
                Sistem e-LAPTRI v4 melarang keras perhitungan:
                <div style="text-align: center; margin: 8px 0; font-family: monospace; font-size: 9pt; background: #ffffff; padding: 6px; border-radius: 4px; border: 1px solid #cbd5e1;">
                    Parent_Value = Average(Child_1, Child_2, ..., Child_n)
                </div>
                Perhitungan rata-rata hanya boleh dieksekusi bila relasi berjenis <code>FORMULA_COMPONENT</code> dan formula induk bertipe <code>AVERAGE</code>.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 11 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 12: BAB II - 2.3 SASARAN STRATEGIS (SS)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-12">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.3 MATRIKS SASARAN STRATEGIS & IKSS</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA KERJA KINERJA & CASCADING JAMBIN</div>
            <h2 class="title-primary">2.3 MATRIKS SASARAN STRATEGIS (SS 1 - SS 4) & IKSS</h2>
            
            <p class="paragraph">
                Berdasarkan Renstra Kejaksaan RI Tahun 2025-2029, terdapat 4 Sasaran Strategis utama tingkat lembaga di mana Jaksa Agung Muda Bidang Pembinaan memberikan kontribusi vital:
            </p>

            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 10%;">Kode</th>
                    <th style="width: 38%;">Sasaran Strategis (SS) / Indikator (IKSS)</th>
                    <th style="width: 15%;">Satuan</th>
                    <th style="width: 15%;">Target 2026</th>
                    <th>Peran Sektor Pembinaan</th>
                </tr>
                <tr style="background: #f1f5f9; font-weight: 700;">
                    <td>SS 1</td>
                    <td colspan="4">Terwujudnya Penegakan Hukum yang Berkeadilan, Berkepastian, dan Berkemanfaatan</td>
                </tr>
                <tr>
                    <td>IKSS 1.1</td>
                    <td>Tingkat Kepuasan Masyarakat terhadap Layanan Penegakan Hukum Kejaksaan</td>
                    <td>Indeks (1-4)</td>
                    <td>3.65</td>
                    <td>Dukungan sarana prasarana modern & pelayanan publik terpadu (PTSP).</td>
                </tr>
                <tr style="background: #f1f5f9; font-weight: 700;">
                    <td>SS 2</td>
                    <td colspan="4">Terwujudnya Pencegahan Tindak Pidana Korupsi dan Pemulihan Aset Negara yang Optimal</td>
                </tr>
                <tr>
                    <td>IKSS 2.1</td>
                    <td>Persentase Nilai Pemulihan Aset Tindak Pidana Korupsi</td>
                    <td>Persen (%)</td>
                    <td>85.00%</td>
                    <td>Pengelolaan gudang barang bukti dan data statistik perampasan aset (Pusdaskrimti).</td>
                </tr>
                <tr style="background: #f1f5f9; font-weight: 700;">
                    <td>SS 3</td>
                    <td colspan="4">Terwujudnya Tata Kelola Kelembagaan Kejaksaan yang Akuntabel, Transparan, dan Modern</td>
                </tr>
                <tr>
                    <td>IKSS 3.1</td>
                    <td>Indeks Reformasi Birokrasi (RB) Kejaksaan RI</td>
                    <td>Poin (0-100)</td>
                    <td>88.50</td>
                    <td><strong>Unit Pengampu Utama:</strong> Biro Perencanaan & Seluruh Biro JAMBIN.</td>
                </tr>
                <tr>
                    <td>IKSS 3.2</td>
                    <td>Nilai Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP)</td>
                    <td>Predikat</td>
                    <td>A (Memuaskan)</td>
                    <td>Pengelolaan dan pengawalan aplikasi e-LAPTRI v4 di seluruh satker.</td>
                </tr>
                <tr style="background: #f1f5f9; font-weight: 700;">
                    <td>SS 4</td>
                    <td colspan="4">Terwujudnya Sumber Daya Manusia Kejaksaan yang Profesional, Berintegritas, dan Sejahtera</td>
                </tr>
                <tr>
                    <td>IKSS 4.1</td>
                    <td>Indeks Profesionalitas Aparatur Sipil Negara (IP ASN) Kejaksaan</td>
                    <td>Indeks (0-100)</td>
                    <td>85.00</td>
                    <td><strong>Unit Pengampu Utama:</strong> Biro Kepegawaian & Pusat Kesehatan Yustisial.</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 12px;">
                <strong>KETERKAITAN IKSS & e-LAPTRI:</strong><br>
                Realisasi IKSS 3.1, 3.2, dan 4.1 secara langsung dipasok dari kompilasi Sasaran Program (SP) dan Sasaran Kegiatan (SK) di lingkungan JAMBIN.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 12 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 13: BAB II - 2.4 SASARAN PROGRAM (SP)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-13">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.4 MATRIKS 11 SASARAN PROGRAM & 19 IKP</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA KERJA KINERJA & CASCADING JAMBIN</div>
            <h2 class="title-primary">2.4 MATRIKS 11 SASARAN PROGRAM (SP) & 19 IKP JAMBIN</h2>
            
            <p class="paragraph" style="margin-bottom: 6px;">
                Berdasarkan Rencana Strategis (Renstra) Kejaksaan RI Tahun 2025–2029 dan Keputusan Jaksa Agung RI Nomor 1184 Tahun 2025, Jaksa Agung Muda Bidang Pembinaan (JAMBIN) mengampu <strong>11 Sasaran Program (SP)</strong> yang dijabarkan ke dalam <strong>19 Indikator Kinerja Program (IKP)</strong> sebagai instrumen pengukuran outcome tingkat Eselon I:
            </p>

            <table class="table-styled" style="font-size: 6.5pt; line-height: 1.2;">
                <thead>
                    <tr>
                        <th style="width: 6%;">Kode</th>
                        <th style="width: 29%;">Sasaran Program (SP)</th>
                        <th style="width: 7%;">IKP</th>
                        <th style="width: 34%;">Indikator Kinerja Program (IKP)</th>
                        <th style="width: 8%;">Satuan</th>
                        <th>Unit Pengampu (C.q.)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>SP 1</strong></td>
                        <td>Meningkatnya akuntabilitas kinerja Kejaksaan RI</td>
                        <td><strong>IKP 1.1</strong></td>
                        <td>Nilai SAKIP Kejaksaan RI</td>
                        <td>Nilai</td>
                        <td>Biro Perencanaan</td>
                    </tr>
                    <tr>
                        <td><strong>SP 4</strong></td>
                        <td>Meningkatnya efisiensi dan efektivitas penggunaan anggaran Kejaksaan RI</td>
                        <td><strong>IKP 4.1</strong></td>
                        <td>Nilai Kinerja Anggaran Kejaksaan RI</td>
                        <td>Nilai</td>
                        <td>Biro Keuangan</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><strong>SP 5</strong></td>
                        <td rowspan="2">Meningkatnya kualitas tata kelola aset dan pengadaan Kejaksaan RI</td>
                        <td><strong>IKP 5.1</strong></td>
                        <td>Indeks Pengelolaan Aset Kejaksaan RI</td>
                        <td>Indeks</td>
                        <td>Biro Perlengkapan</td>
                    </tr>
                    <tr>
                        <td><strong>IKP 5.2</strong></td>
                        <td>Indeks Tata Kelola Pengadaan Kejaksaan RI</td>
                        <td>Indeks</td>
                        <td>Biro Perlengkapan</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><strong>SP 6</strong></td>
                        <td rowspan="2">Meningkatnya kapasitas kelembagaan dan ketatalaksanaan Kejaksaan RI</td>
                        <td><strong>IKP 6.1</strong></td>
                        <td>Nilai Evaluasi Kelembagaan Kejaksaan RI</td>
                        <td>Nilai</td>
                        <td>Biro Perencanaan</td>
                    </tr>
                    <tr>
                        <td><strong>IKP 6.2</strong></td>
                        <td>Tingkat Kepatuhan Satker terhadap Standar Operasional Prosedur</td>
                        <td>%</td>
                        <td>Biro Perencanaan</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><strong>SP 7</strong></td>
                        <td rowspan="2">Meningkatnya kualitas kebijakan penegakan hukum</td>
                        <td><strong>IKP 7.1</strong></td>
                        <td>Indeks Kualitas Kebijakan Kejaksaan RI</td>
                        <td>Indeks</td>
                        <td>Biro Hukum &amp; HLN</td>
                    </tr>
                    <tr>
                        <td><strong>IKP 7.2</strong></td>
                        <td>Indeks Reformasi Hukum Kejaksaan RI</td>
                        <td>%</td>
                        <td>Biro Hukum &amp; HLN</td>
                    </tr>
                    <tr>
                        <td rowspan="3"><strong>SP 8</strong></td>
                        <td rowspan="3">Meningkatnya kuantitas dan kualitas SDM aparatur Kejaksaan RI</td>
                        <td><strong>IKP 8.1</strong></td>
                        <td>Indeks Sistem Merit Kejaksaan RI</td>
                        <td>Indeks</td>
                        <td>Biro Kepegawaian</td>
                    </tr>
                    <tr>
                        <td><strong>IKP 8.2</strong></td>
                        <td>Persentase Kecukupan, Kesesuaian, dan Pengembangan SDM</td>
                        <td>%</td>
                        <td>Biro Kepegawaian &amp; Biro Perencanaan</td>
                    </tr>
                    <tr>
                        <td><strong>IKP 8.3</strong></td>
                        <td>Indeks Profesionalitas SDM Kejaksaan RI</td>
                        <td>Indeks</td>
                        <td>Biro Kepegawaian</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><strong>SP 10</strong></td>
                        <td rowspan="2">Meningkatnya kualitas layanan internal dukungan manajemen dan kesehatan yustisial</td>
                        <td><strong>IKP 10.1</strong></td>
                        <td>Indeks Kepuasan Layanan Dukungan Internal Manajemen Kejaksaan RI</td>
                        <td>Indeks</td>
                        <td>Biro Perencanaan &amp; Biro Umum</td>
                    </tr>
                    <tr>
                        <td><strong>IKP 10.2</strong></td>
                        <td>Tingkat Kepuasan Stakeholder terhadap RS/Klinik/Faskes Yustisial</td>
                        <td>%</td>
                        <td>Pusat Kesehatan Yustisial</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><strong>SP 11</strong></td>
                        <td rowspan="2">Meningkatnya kompetensi aparatur Kejaksaan RI</td>
                        <td><strong>IKP 11.1</strong></td>
                        <td>Indeks Kesesuaian Kompetensi (Competency Fit Index) Aparatur</td>
                        <td>Indeks</td>
                        <td>Biro Kepegawaian &amp; Badiklat</td>
                    </tr>
                    <tr>
                        <td><strong>IKP 11.2</strong></td>
                        <td>Persentase Aparatur Bersertifikasi Kompetensi Sesuai Jabatan</td>
                        <td>%</td>
                        <td>Biro Kepegawaian &amp; Badiklat</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><strong>SP 13</strong></td>
                        <td rowspan="2">Meningkatnya kualitas layanan hukum dan hubungan luar negeri</td>
                        <td><strong>IKP 13.1</strong></td>
                        <td>Indeks Kepuasan Satker Kejaksaan atas Layanan Hukum</td>
                        <td>Indeks</td>
                        <td>Biro Hukum &amp; HLN</td>
                    </tr>
                    <tr>
                        <td><strong>IKP 13.2</strong></td>
                        <td>Indeks Kepuasan Institusi Mitra LN terhadap Fasilitasi Kerja Sama</td>
                        <td>Indeks</td>
                        <td>Biro Hukum &amp; HLN</td>
                    </tr>
                    <tr>
                        <td><strong>SP 15</strong></td>
                        <td>Meningkatnya efektivitas pelaksanaan tugas &amp; fungsi Kejaksaan berbasis TI</td>
                        <td><strong>IKP 15.1</strong></td>
                        <td>Persentase Digitalisasi Proses Bisnis Inti Kejaksaan RI</td>
                        <td>%</td>
                        <td>Pusdaskrimti</td>
                    </tr>
                    <tr>
                        <td><strong>SP 16</strong></td>
                        <td>Meningkatnya kuantitas &amp; kualitas sarpras pendukung kinerja Kejaksaan RI</td>
                        <td><strong>IKP 16.1</strong></td>
                        <td>Tingkat Utilisasi Sarana dan Prasarana Kejaksaan RI</td>
                        <td>%</td>
                        <td>Biro Perlengkapan</td>
                    </tr>
                </tbody>
            </table>

            <div class="callout callout-info" style="margin-top: 6px; padding: 6px 10px; font-size: 7pt; line-height: 1.3;">
                <strong>RUANG LINGKUP &amp; SEMANTIK KALKULASI IKP JAMBIN V3:</strong><br>
                Sesuai Kepja 1184/2025 dan Renstra 2025-2029, JAMBIN mengampu <strong>11 Sasaran Program (SP)</strong> di atas (SP 2 di luar input operasional JAMBIN). Pada arsitektur canonical e-LAPTRI v4, ke-19 IKP berstatus <strong>MANDIRI</strong> secara calculation graph; simpul anak Sasaran Kegiatan (SK) dan IKK berfungsi sebagai kontribusi substantif (<em>CONTRIBUTION</em>) dan dilarang dirata-ratakan otomatis ke parent tanpa formula terkonfigurasi.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 13 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 14: BAB II - 2.5 SASARAN KEGIATAN (SK)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-14">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.5 MATRIKS SASARAN KEGIATAN & DISTRIBUSI ESELON II</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA KERJA KINERJA & CASCADING JAMBIN</div>
            <h2 class="title-primary">2.5 MATRIKS SASARAN KEGIATAN (SK) & DISTRIBUSI SATKER ESELON II</h2>
            
            <p class="paragraph" style="margin-bottom: 8px;">
                Di bawah 11 Sasaran Program, Renstra Kejaksaan RI 2025–2029 dan Kepja 1184/2025 menetapkan <strong>35 Sasaran Kegiatan (SK)</strong> dan <strong>97 Indikator Kinerja Kegiatan (IKK)</strong> yang didistribusikan kepada 10 Unit Kerja Eselon II di lingkungan JAMBIN:
            </p>

            <table class="table-styled" style="font-size: 7.2pt; line-height: 1.25;">
                <thead>
                    <tr>
                        <th style="width: 25%;">Satuan Kerja Eselon II</th>
                        <th style="width: 14%;">Kode Satker</th>
                        <th style="width: 47%;">Cakupan Sasaran Kegiatan (SK) Pengampu</th>
                        <th style="width: 14%;">Output IKK</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Biro Perencanaan</strong></td>
                        <td><code>RO-REN</code></td>
                        <td>SK 1.1, SK 1.2, SK 1.3 (Perencanaan &amp; SAKIP), SK 6.1, SK 6.2 (Kelembagaan &amp; SOP), SK 10.1, SK 10.5 (Dukungan Manajemen)</td>
                        <td>17 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Biro Keuangan</strong></td>
                        <td><code>RO-KEU</code></td>
                        <td>SK 4.1 (Laporan Keuangan SAP), SK 4.2 (Efisiensi Anggaran UKE I), SK 4.3 (Pembinaan Keuangan), SK 10.2 (Layanan Keuangan)</td>
                        <td>9 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Biro Perlengkapan</strong></td>
                        <td><code>RO-KAP</code></td>
                        <td>SK 5.1 (Penatausahaan BMN &amp; PBJ), SK 5.2 (Aset UKE I), SK 10.4 (Manajemen Aset), SK 16.1 (Utilisasi Gedung &amp; Sarpras)</td>
                        <td>17 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Biro Kepegawaian</strong></td>
                        <td><code>RO-PEG</code></td>
                        <td>SK 8.1 (Manajemen ASN &amp; Merit), SK 8.2 (Kebutuhan &amp; Karir SDM), SK 8.3 (Disiplin), SK 11.1 (Kompetensi Jabatan)</td>
                        <td>10 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Biro Umum</strong></td>
                        <td><code>RO-UMUM</code></td>
                        <td>SK 10.3 (Layanan Umum), SK 10.6 (Tata Usaha Pimpinan, Protokol &amp; Kamsus), SK 10.7 (Dukungan Operasional Satker)</td>
                        <td>11 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Biro Hukum &amp; HLN</strong></td>
                        <td><code>RO-HUK-HLN</code></td>
                        <td>SK 7.1 (Penyusunan Regulasi), SK 13.1 (Layanan Hukum Satker), SK 13.2 (Fasilitasi Kerja Sama Luar Negeri)</td>
                        <td>7 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Pusdaskrimti</strong></td>
                        <td><code>PUSDASKRIMTI</code></td>
                        <td>SK 15.1 s/d SK 15.5 (Statistik Kriminal, Infrastruktur TI, Kualitas Data, Cyber Security &amp; Case Management TI)</td>
                        <td>11 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Pustrajakgakum</strong></td>
                        <td><code>PUSTRAJAKGAKUM</code></td>
                        <td>SK 7.2 (Penyusunan Riset Kebijakan Gakum), SK 7.3 (Diseminasi &amp; Pemanfaatan Rekomendasi Kebijakan)</td>
                        <td>8 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Pusat Kesehatan Yustisial</strong></td>
                        <td><code>PKY</code></td>
                        <td>SK 10.8 (Kualitas Layanan RS/Klinik Adhyaksa), SK 10.9 (Penyelenggaraan Kesehatan &amp; Forensik Yustisial)</td>
                        <td>7 IKK</td>
                    </tr>
                    <tr>
                        <td><strong>Sekretariat JAMBIN</strong></td>
                        <td><code>SET-JAMBIN</code></td>
                        <td>Koordinasi teknis pengendalian program, fasilitasi lintas biro/pusat, dan pengawasan internal manajerial</td>
                        <td>Enabler</td>
                    </tr>
                </tbody>
            </table>

            <div class="callout callout-info" style="margin-top: 8px; font-size: 7.2pt; line-height: 1.3;">
                <strong>INTEGRASI OPERASIONAL ESELON II:</strong><br>
                Masing-masing Operator Satker Eselon II hanya mengisi data realisasi dan variabel formula mentah ($X_1, X_2$) untuk Sasaran Kegiatan (SK) dan IKK yang menjadi tupoksinya. Nilai IKP dikonsolidasikan secara transparan melalui e-LAPTRI tanpa tumpang tindih tanggung jawab.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 14 dari 45</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 15: BAB III - 3.1 MANAJEMEN AKUN & RBAC
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-15">
        <div class="header">
            <span>BAB III: HAK AKSES & KEAMANAN</span>
            <span>3.1 MANAJEMEN AKUN & RBAC</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB III: HAK AKSES, AUTENTIKASI & KEAMANAN SISTEM</div>
            <h2 class="title-primary">3.1 MANAJEMEN AKUN & HAK AKSES BERBASIS PERAN (RBAC)</h2>
            
            <p class="paragraph">
                Aplikasi e-LAPTRI menerapkan kontrol akses berbasis peran <em>(Role-Based Access Control / RBAC)</em> yang ketat. Setiap pengguna diidentifikasi menggunakan <code>username</code> unik dan terikat langsung pada satuan kerja induk:
            </p>

            <table class="table-styled" style="font-size: 8pt;">
                <tr>
                    <th style="width: 22%;">Username Akun</th>
                    <th style="width: 30%;">Satuan Kerja Resmi</th>
                    <th style="width: 14%;">Bidang ID</th>
                    <th style="width: 14%;">Peran (Role)</th>
                    <th>Lingkup Kewenangan</th>
                </tr>
                <tr style="background: #fdf2f8;">
                    <td><code>admin.jambin</code></td>
                    <td>Jaksa Agung Muda Bidang Pembinaan</td>
                    <td><code>JMBIN</code></td>
                    <td><span class="badge-role badge-admin">ADMIN</span></td>
                    <td>Super Admin: monitoring 10 satker, verifikasi approval, template builder, formula editor.</td>
                </tr>
                <tr>
                    <td><code>ro.ren</code></td>
                    <td>Biro Perencanaan</td>
                    <td><code>REN</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input kinerja program, anggaran, dan reformasi birokrasi (SK 1, SK 2).</td>
                </tr>
                <tr>
                    <td><code>ro.peg</code></td>
                    <td>Biro Kepegawaian</td>
                    <td><code>PEG</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input kinerja manajemen SDM, merit system, dan pelatihan (SK 3, SK 4).</td>
                </tr>
                <tr>
                    <td><code>ro.keu</code></td>
                    <td>Biro Keuangan</td>
                    <td><code>KEU</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input kinerja realisasi anggaran & laporan keuangan SAP (SK 5, SK 6).</td>
                </tr>
                <tr>
                    <td><code>ro.kap</code></td>
                    <td>Biro Perlengkapan</td>
                    <td><code>KAP</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input kinerja pengadaan barang/jasa dan manajemen BMN (SK 7, SK 8).</td>
                </tr>
                <tr>
                    <td><code>ro.umum</code></td>
                    <td>Biro Umum</td>
                    <td><code>UMUM</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input kinerja tata usaha, kearsipan, dan protokoler (SK 9, SK 10).</td>
                </tr>
                <tr>
                    <td><code>ro.huk.hln</code></td>
                    <td>Biro Hukum & HLN</td>
                    <td><code>HLN</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input telaahan hukum dan kerja sama internasional (SK 11, SK 12).</td>
                </tr>
                <tr>
                    <td><code>pusdaskrimti</code></td>
                    <td>Pusdaskrimti</td>
                    <td><code>PDTI</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input infrastruktur IT, SPBE, dan statistik kriminal (SK 13, SK 14).</td>
                </tr>
                <tr>
                    <td><code>pustrajakgakum</code></td>
                    <td>Pustrajakgakum</td>
                    <td><code>PSKPH</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input riset strategi kebijakan penegakan hukum (SK 15, SK 16).</td>
                </tr>
                <tr>
                    <td><code>pky</code></td>
                    <td>Pusat Kesehatan Yustisial</td>
                    <td><code>PKY</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input pelayanan kesehatan dan tes narkotika pegawai (SK 17, SK 18).</td>
                </tr>
                <tr>
                    <td><code>set.jambin</code></td>
                    <td>Sekretariat JAMBIN</td>
                    <td><code>SET</code></td>
                    <td><span class="badge-role badge-opr">OPERATOR</span></td>
                    <td>Input koordinasi pembinaan dan pengawasan internal (SK 19).</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 10px;">
                <strong>ISOLASI DATA UNIT KERJA:</strong><br>
                Operator Biro Perencanaan tidak dapat mengedit atau melihat draf data input milik Biro Kepegawaian sebelum data tersebut disubmit ke tingkat JAMBIN, menjamin integritas data antar-satker.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 & KEPJA 1184/2025</span>
            <span>Halaman 15 dari 45</span>
        </div>
    </div>
    """)

    return pages
