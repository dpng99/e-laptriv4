# -*- coding: utf-8 -*-
"""
Modul Penyusun Halaman 1 sampai 10
Buku Manual Operasional e-LAPTRI v4 (e-LKjIP Pembinaan)
Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI: Dr. Hendro Dewanto, S.H., M.Hum.
"""

def get_pages_1_to_10(assets):
    pages = []

    # ==========================================
    # HALAMAN 1: COVER UTAMA
    # ==========================================
    pages.append(f"""
    <div class="page page-cover" id="page-1">
        <div style="padding: 26mm 18mm 18mm 18mm; height: 100%; display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box; position: relative;">
            <!-- Top Header Badge -->
            <div style="border-left: 4.5px solid #f59e0b; padding-left: 14px;">
                <span style="font-size: 11pt; font-weight: 800; letter-spacing: 2px; color: #f59e0b; text-transform: uppercase;">Kejaksaan Republik Indonesia</span><br>
                <span style="font-size: 14.5pt; font-weight: 700; color: #e2e8f0; letter-spacing: 0.5px;">JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            </div>

            <!-- Main Title Banner -->
            <div style="margin-top: 25px;">
                <div style="display: inline-block; background: rgba(245, 158, 11, 0.2); border: 1px solid #f59e0b; padding: 5px 14px; border-radius: 20px; font-size: 8.5pt; font-weight: 700; color: #fbbf24; margin-bottom: 12px; letter-spacing: 0.5px;">
                    DOKUMEN RESMI PANDUAN TEKNIS OPERASIONAL SISTEM INFORMASI
                </div>
                <h1 style="font-size: 34pt; font-weight: 900; line-height: 1.1; margin: 0 0 12px 0; color: #ffffff; letter-spacing: -0.5px;">
                    BUKU MANUAL<br><span style="color: #38bdf8;">E-LAPTRI v4</span>
                </h1>
                <h2 style="font-size: 14pt; font-weight: 600; color: #94a3b8; line-height: 1.4; margin: 0 0 20px 0;">
                    Buku Panduan Operasional Sistem Pelaporan Kinerja Triwulanan &amp; Evaluasi Akuntabilitas Kinerja Instansi Pemerintah (e-LKjIP)
                </h2>
                <div style="height: 4px; width: 120px; background: linear-gradient(90deg, #f59e0b, #38bdf8); border-radius: 2px;"></div>
            </div>

            <!-- System Spec Highlights -->
            <div style="background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(255,255,255,0.18); border-radius: 12px; padding: 16px; backdrop-filter: blur(8px);">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; text-align: center;">
                    <div>
                        <div style="font-size: 7.5pt; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Arsitektur Cascading</div>
                        <div style="font-size: 10.5pt; font-weight: 800; color: #38bdf8; margin-top: 2px;">JAMBIN V3 Canonical (DAG)</div>
                    </div>
                    <div style="border-left: 1px solid rgba(255,255,255,0.12); border-right: 1px solid rgba(255,255,255,0.12);">
                        <div style="font-size: 7.5pt; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Dasar Nomenklatur</div>
                        <div style="font-size: 10.5pt; font-weight: 800; color: #f59e0b; margin-top: 2px;">Renstra Kejaksaan 2025-2029</div>
                    </div>
                    <div>
                        <div style="font-size: 7.5pt; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Regulasi SAKIP Resmi</div>
                        <div style="font-size: 10.5pt; font-weight: 800; color: #34d399; margin-top: 2px;">KEPJA Nomor 1184 / 2025</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Badges -->
            <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 16px;">
                <div>
                    <div style="font-size: 8.5pt; color: #cbd5e1; font-weight: 700;">Edisi Standar Operasional Prosedur 2026</div>
                    <div style="font-size: 7.8pt; color: #94a3b8; margin-top: 2px;">Dilengkapi Tangkapan Layar HD Asli, Formula Registry, dan Generator LKjIP Otomatis</div>
                </div>
                <div style="text-align: right;">
                    <span style="background: #064e3b; color: #6ee7b7; font-size: 8.5pt; font-weight: 800; padding: 6px 14px; border-radius: 6px; border: 1px solid #059669; letter-spacing: 0.5px;">
                        40 HALAMAN LENGKAP
                    </span>
                </div>
            </div>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 2: IDENTITAS DOKUMEN & PENGESAHAN
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-2">
        <div class="header">
            <span>KEJAKSAAN AGUNG REPUBLIK INDONESIA</span>
            <span>BUKU MANUAL E-LAPTRI v4 | EDISI RESMI 2026</span>
        </div>
        <div class="content">
            <h2 class="title-primary" style="margin-top: 4px;">LEMBAR IDENTITAS DOKUMEN &amp; TIM PENGARAH</h2>
            <p class="paragraph">
                Buku Manual ini disusun sebagai pedoman teknis operasional baku bagi seluruh Unit Kerja Eselon II di lingkungan Jaksa Agung Muda Bidang Pembinaan (JAMBIN) dalam merekam, menghitung, memvalidasi, dan melaporkan capaian kinerja triwulanan secara digital melalui sistem informasi e-LAPTRI v4.
            </p>

            <table class="table-styled" style="margin-top: 8px;">
                <tr>
                    <th style="width: 32%;">Parameter Dokumen</th>
                    <th>Keterangan Resmi Kedinasan</th>
                </tr>
                <tr>
                    <td><strong>Judul Publikasi</strong></td>
                    <td>Buku Manual Operasional e-LAPTRI v4 (e-LKjIP Pembinaan JAMBIN)</td>
                </tr>
                <tr>
                    <td><strong>Nomor Dokumen</strong></td>
                    <td>MAN-01/JAMBIN/SAKIP-REN/03/2026</td>
                </tr>
                <tr>
                    <td><strong>Versi Sistem</strong></td>
                    <td>e-LAPTRI v4.0.2 (Arsitektur Canonical Cascading DAG)</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Berlaku</strong></td>
                    <td>1 Januari 2026 (Berlaku untuk Siklus Kinerja 2025-2029)</td>
                </tr>
                <tr>
                    <td><strong>Unit Penerbit</strong></td>
                    <td>Sekretariat Jaksa Agung Muda Bidang Pembinaan cq. Bagian Reformasi Birokrasi &amp; Biro Perencanaan Kejaksaan Agung RI</td>
                </tr>
                <tr>
                    <td><strong>Klasifikasi Akses</strong></td>
                    <td>INTERNAL DINAS KEJAKSAAN REPUBLIK INDONESIA</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 14px;">SUSUNAN TIM PENGARAH &amp; PENYUSUN SISTEM</h3>
            <table class="table-styled">
                <tr>
                    <th style="width: 32%;">Jabatan Kedinasan</th>
                    <th>Nama &amp; Peran Strategis</th>
                </tr>
                <tr>
                    <td><strong>Pengarah Utama</strong></td>
                    <td><strong style="color: #064e3b;">Dr. Hendro Dewanto, S.H., M.Hum.</strong><br><span style="font-size: 7.2pt; color: #64748b;">Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI</span></td>
                </tr>
                <tr>
                    <td><strong>Penanggung Jawab</strong></td>
                    <td><strong>Sekretaris Jaksa Agung Muda Bidang Pembinaan (Sesjambin)</strong></td>
                </tr>
                <tr>
                    <td><strong>Ketua Pelaksana</strong></td>
                    <td><strong>Kepala Biro Perencanaan Kejaksaan Agung RI</strong></td>
                </tr>
                <tr>
                    <td><strong>Tim Teknis &amp; IT</strong></td>
                    <td>Pusat Data Statistik Kriminal dan Teknologi Informasi (Pusdaskrimti) Kejaksaan Agung RI</td>
                </tr>
                <tr>
                    <td><strong>Tim Regulasi &amp; Substansi</strong></td>
                    <td>Pusat Strategi Kebijakan Penegakan Hukum (Pustrajakgakum) &amp; Tim SAKIP Biro Perencanaan</td>
                </tr>
                <tr>
                    <td><strong>Koordinator Pelaporan Satker</strong></td>
                    <td>Para Pejabat Penghubung / PIC Kinerja Eselon II (Biro Umum, Biro Kepegawaian, Biro Keuangan, Biro Perlengkapan, Biro Hukum &amp; HLN, dan Pusat Kesehatan Yustisial)</td>
                </tr>
            </table>

            <div class="callout callout-warning" style="margin-top: 12px;">
                <strong>HAK CIPTA &amp; KETENTUAN PENGGUNAAN INTERNAL:</strong><br>
                Seluruh arsitektur graph cascading, formulasi matematis indikator, format template Word LKjIP, dan tangkapan layar dalam buku panduan ini merupakan hak kekayaan intelektual kedinasan Kejaksaan Republik Indonesia. Dilarang menggandakan atau menyebarluaskan dokumen ini di luar kepentingan dinas tanpa izin tertulis dari Sekretariat Jaksa Agung Muda Bidang Pembinaan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 2 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 3: KATA PENGANTAR JAMBIN
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-3">
        <div class="header">
            <span>KATA PENGANTAR RESMI</span>
            <span>BUKU MANUAL E-LAPTRI v4</span>
        </div>
        <div class="content">
            <div style="text-align: center; margin-bottom: 12px;">
                <h2 style="font-size: 14pt; font-weight: 800; color: #0f172a; margin: 0; text-transform: uppercase;">KATA PENGANTAR</h2>
                <h3 style="font-size: 10.5pt; font-weight: 700; color: #064e3b; margin: 3px 0 0 0;">JAKSA AGUNG MUDA BIDANG PEMBINAAN KEJAKSAAN AGUNG RI</h3>
                <div style="width: 70px; height: 3px; background: #d97706; margin: 8px auto;"></div>
            </div>

            <p class="paragraph">
                Puji dan syukur senantiasa kita panjatkan ke hadirat Tuhan Yang Maha Esa, karena atas rahmat dan perkenan-Nya, implementasi aplikasi <strong>e-LAPTRI Versi 4 (e-LKjIP Pembinaan)</strong> yang berbasis <em>Canonical Cascading Architecture</em> serta penerbitan <strong>Buku Manual Operasional 40 Halaman</strong> ini dapat terwujud secara komprehensif, terstruktur, dan akuntabel.
            </p>
            <p class="paragraph">
                Akuntabilitas kinerja merupakan salah satu pilar fundamental dalam Reformasi Birokrasi Tematik Kejaksaan RI. Sejalan dengan Rencana Strategis (Renstra) Kejaksaan RI Tahun 2025-2029 dan Keputusan Jaksa Agung RI Nomor 1184 Tahun 2025 tentang Indikator Kinerja Utama (IKU), pengukuran capaian kinerja di lingkungan Jaksa Agung Muda Bidang Pembinaan harus bergerak dari sekadar formalitas pelaporan administratif menjadi instrumen kendali strategis yang objektif, transparan, dan berbasis bukti nyata <em>(evidence-based governance)</em>.
            </p>
            <p class="paragraph">
                Aplikasi <strong>e-LAPTRI v4</strong> menghadirkan pembaruan sistem yang sangat mendasar:
            </p>

            <div style="display: grid; grid-template-columns: 1fr; gap: 6px; margin: 8px 0;">
                <div style="background: #f8fafc; border-left: 3.5px solid #0284c7; padding: 6px 10px; border-radius: 4px;">
                    <strong style="color: #0369a1; font-size: 8pt;">1. Arsitektur Directed Acyclic Graph (DAG) Bebas Siklus:</strong>
                    <div style="font-size: 7.4pt; color: #334155; margin-top: 1px;">
                        Mencegah distorsi generic average yang keliru dan memastikan setiap keterkaitan antara Sasaran Strategis (SS), Sasaran Program (SP), hingga Sasaran Kegiatan (SK) terdefinisi secara semantik.
                    </div>
                </div>
                <div style="background: #f8fafc; border-left: 3.5px solid #059669; padding: 6px 10px; border-radius: 4px;">
                    <strong style="color: #064e3b; font-size: 8pt;">2. Rekam Data Mentah (Raw Inputs X1 dan X2):</strong>
                    <div style="font-size: 7.4pt; color: #334155; margin-top: 1px;">
                        Setiap persentase realisasi wajib dibuktikan dengan input pembilang ($X_1$) dan penyebut ($X_2$) sehingga seluruh kalkulasi memiliki audit trail numerik yang dapat diverifikasi oleh Inspektorat maupun KemenPAN-RB.
                    </div>
                </div>
                <div style="background: #f8fafc; border-left: 3.5px solid #d97706; padding: 6px 10px; border-radius: 4px;">
                    <strong style="color: #92400e; font-size: 8pt;">3. Otomasi Generator Dokumen LKjIP Word:</strong>
                    <div style="font-size: 7.4pt; color: #334155; margin-top: 1px;">
                        Menghasilkan Laporan Kinerja instansi triwulanan secara otomatis dalam format Word (.docx) berstandar kedinasan hanya dalam hitungan detik.
                    </div>
                </div>
            </div>

            <p class="paragraph">
                Saya menyampaikan apresiasi yang tinggi kepada Biro Perencanaan, Pusdaskrimti, Pustrajakgakum, serta seluruh Pejabat Pembuat Komitmen dan Operator Kinerja di lingkungan JAMBIN. Jadikan buku panduan ini sebagai rujukan utama dalam menjalankan pelaporan kinerja yang tertib, cepat, dan presisi.
            </p>

            <div style="margin-top: 16px; float: right; width: 230px; text-align: center;">
                <div style="font-size: 8pt; color: #64748b;">Jakarta, Maret 2026</div>
                <div style="font-size: 8.8pt; font-weight: 700; color: #0f172a; margin-top: 2px;">Jaksa Agung Muda Bidang Pembinaan</div>
                <div style="height: 40px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 7.5pt; color: #94a3b8; font-style: italic;">[ Tanda Tangan Kedinasan &amp; Cap Resmi ]</span>
                </div>
                <div style="font-size: 9.5pt; font-weight: 800; color: #0f172a; text-decoration: underline;">Dr. HENDRO DEWANTO, S.H., M.Hum.</div>
                <div style="font-size: 8pt; color: #475569;">Jaksa Utama Madya</div>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 3 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 4: DAFTAR ISI & GLOSARIUM
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-4">
        <div class="header">
            <span>DAFTAR ISI &amp; GLOSARIUM</span>
            <span>BUKU MANUAL E-LAPTRI v4</span>
        </div>
        <div class="content">
            <h2 class="title-primary" style="margin-top: 4px; margin-bottom: 8px;">DAFTAR ISI &amp; GLOSARIUM SISTEM</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <!-- Kolom Kiri: TOC Bab I - V -->
                <div style="font-size: 7.6pt; line-height: 1.45;">
                    <div style="font-weight: 800; color: #064e3b; border-bottom: 1.5px solid #064e3b; padding-bottom: 2px; margin-bottom: 4px; font-size: 8pt;">
                        BAGIAN I &amp; TAHAP OPERATOR SATKER
                    </div>
                    <div class="toc-line"><span>Lembar Identitas &amp; Pengesahan Dokumen</span><span>2</span></div>
                    <div class="toc-line"><span>Kata Pengantar JAMBIN: Dr. Hendro Dewanto, S.H., M.Hum.</span><span>3</span></div>
                    <div class="toc-line"><span>Daftar Isi Lengkap &amp; Glosarium SAKIP</span><span>4</span></div>
                    
                    <div class="toc-head">BAB I: PENDAHULUAN &amp; ARSITEKTUR e-LAPTRI v4</div>
                    <div class="toc-item"><span>1.1 Latar Belakang &amp; Transformasi Digital</span><span>5</span></div>
                    <div class="toc-item"><span>1.2 Dasar Hukum &amp; Regulasi SAKIP Kejaksaan RI</span><span>6</span></div>
                    <div class="toc-item"><span>1.3 Topologi Arsitektur Teknologi &amp; Keamanan</span><span>7</span></div>
                    <div class="toc-item"><span>1.4 Peta Distribusi 10 Satker Eselon II JAMBIN</span><span>8</span></div>

                    <div class="toc-head">BAB II: KERANGKA CASCADING JAMBIN 2025-2029</div>
                    <div class="toc-item"><span>2.1 Pohon Kinerja Bebas Siklus (Canonical DAG)</span><span>9</span></div>
                    <div class="toc-item"><span>2.2 Taksonomi 7 Semantik Relasi Antar-Indikator</span><span>10</span></div>
                    <div class="toc-item"><span>2.3 Matriks Sasaran Strategis (SS) &amp; IKSS</span><span>11</span></div>
                    <div class="toc-item"><span>2.4 Matriks 12 Sasaran Program (SP) &amp; 20 IKP</span><span>12</span></div>
                    <div class="toc-item"><span>2.5 Matriks Sasaran Kegiatan (SK) &amp; 97 IKK</span><span>13</span></div>

                    <div class="toc-head">BAB III: HAK AKSES, AUTENTIKASI &amp; KEAMANAN</div>
                    <div class="toc-item"><span>3.1 Manajemen Peran Pengguna (RBAC)</span><span>14</span></div>
                    <div class="toc-item"><span>3.2 Prosedur Login &amp; Autentikasi [Screenshot]</span><span>15</span></div>
                    <div class="toc-item"><span>3.3 Manajemen Profil &amp; Keamanan Kata Sandi [Screenshot]</span><span>16</span></div>

                    <div class="toc-head">BAB IV: DASHBOARD &amp; MONITORING OPERATOR</div>
                    <div class="toc-item"><span>4.1 Antarmuka Utama Dashboard Operator [Screenshot]</span><span>17</span></div>
                    <div class="toc-item"><span>4.2 Visualisasi Grafik Kinerja &amp; Tren [Screenshot]</span><span>18</span></div>
                    <div class="toc-item"><span>4.3 Manajemen Siklus Pelaporan Triwulan I - IV</span><span>19</span></div>
                </div>

                <!-- Kolom Kanan: TOC Bab V - IX & Glosarium -->
                <div style="font-size: 7.6pt; line-height: 1.45;">
                    <div style="font-weight: 800; color: #0f172a; border-bottom: 1.5px solid #0f172a; padding-bottom: 2px; margin-bottom: 4px; font-size: 8pt;">
                        BAGIAN II: TAHAP INPUT, AUDIT &amp; ADMIN
                    </div>
                    <div class="toc-head">BAB V: PANDUAN INPUT PENGUKURAN KINERJA</div>
                    <div class="toc-item"><span>5.1 Form Input Dinamis &amp; Tab Navigasi [Screenshot]</span><span>20</span></div>
                    <div class="toc-item"><span>5.2 Pengisian Komponen Rasio (X1 &amp; X2) [Screenshot]</span><span>21</span></div>
                    <div class="toc-item"><span>5.3 Indikator Mandiri vs Indikator Agregatif</span><span>22</span></div>
                    <div class="toc-item"><span>5.4 Mekanisme Kalkulasi Realisasi &amp; Capaian</span><span>23</span></div>
                    <div class="toc-item"><span>5.5 Lembar Analisis Kinerja &amp; Kendala [Screenshot]</span><span>24</span></div>
                    <div class="toc-item"><span>5.6 Bukti Dukung (Evidence) &amp; Autosave</span><span>25</span></div>
                    <div class="toc-item"><span>5.7 Finalisasi &amp; Prosedur Submit ke JAMBIN [Screenshot]</span><span>26</span></div>

                    <div class="toc-head">BAB VI: VERIFIKASI &amp; AUDIT DATA JAMBIN</div>
                    <div class="toc-item"><span>6.1 Dashboard Konsolidasi Kinerja JAMBIN [Screenshot]</span><span>27</span></div>
                    <div class="toc-item"><span>6.2 Monitoring Kepatuhan Pengisian Satker</span><span>28</span></div>
                    <div class="toc-item"><span>6.3 Review Data Multi-Satker DataGrid [Screenshot]</span><span>29</span></div>
                    <div class="toc-item"><span>6.4 Detail Lembar Audit Kinerja &amp; Nilai [Screenshot]</span><span>30</span></div>
                    <div class="toc-item"><span>6.5 Alur Approval &amp; Pengembalian Revisi Data</span><span>31</span></div>

                    <div class="toc-head">BAB VII: FORMULA REGISTRY &amp; ENGINE RUMUS</div>
                    <div class="toc-item"><span>7.1 Katalog Formula Registry Indikator [Screenshot]</span><span>32</span></div>
                    <div class="toc-item"><span>7.2 Konfigurasi 9 Tipe Kalkulasi Rumus [Screenshot]</span><span>33</span></div>
                    <div class="toc-item"><span>7.3 Versioning Rumus &amp; Audit Trail Graph</span><span>34</span></div>

                    <div class="toc-head">BAB VIII: TEMPLATE LKJIP &amp; EKSPOR WORD</div>
                    <div class="toc-item"><span>8.1 Manajemen Template Dokumen Word [Screenshot]</span><span>35</span></div>
                    <div class="toc-item"><span>8.2 Standardisasi Placeholder Dinamis PHPWord</span><span>36</span></div>
                    <div class="toc-item"><span>8.3 Prosedur Unggah Custom Template DOCX</span><span>37</span></div>
                    <div class="toc-item"><span>8.4 Modul Ekspor Laporan LKjIP Word [Screenshot]</span><span>38</span></div>

                    <div class="toc-head">BAB IX: PANDUAN TROUBLESHOOTING &amp; HELPDESK</div>
                    <div class="toc-item"><span>9.1 Pemecahan Masalah Umum (FAQ Teknis)</span><span>39</span></div>
                    <div class="toc-item"><span>9.2 Helpdesk SAKIP, Berita Acara &amp; Pengesahan</span><span>40</span></div>
                </div>
            </div>

            <!-- Glosarium Ringkas -->
            <div style="margin-top: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 6px 10px;">
                <div style="font-size: 7.5pt; font-weight: 800; color: #064e3b; text-transform: uppercase; margin-bottom: 3px;">
                    Glosarium Intuitif SAKIP JAMBIN:
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; font-size: 6.8pt; color: #334155;">
                    <div><strong>DAG:</strong> Graph berarah bebas siklus; mencegah perataan otomatis (generic averaging) pada parent node.</div>
                    <div><strong>Raw Inputs ($X_1, X_2$):</strong> Angka riil pembilang dan penyebut dari dokumen sumber resmi satker.</div>
                    <div><strong>Mandiri vs Agregatif:</strong> Mandiri diisi satker langsung; Agregatif dikonsolidasikan otomatis oleh engine.</div>
                </div>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 4 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 5: BAB I - 1.1 LATAR BELAKANG & TRANSFORMASI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-5">
        <div class="header">
            <span>BAB I: PENDAHULUAN &amp; ARSITEKTUR</span>
            <span>1.1 LATAR BELAKANG &amp; TRANSFORMASI DIGITAL</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB I: PENDAHULUAN &amp; ARSITEKTUR SISTEM</div>
            <h2 class="title-primary">1.1 LATAR BELAKANG &amp; TRANSFORMASI DIGITAL e-LAPTRI v4</h2>

            <p class="paragraph">
                Penyelenggaraan Sistem Akuntabilitas Kinerja Instansi Pemerintah (SAKIP) di lingkungan Jaksa Agung Muda Bidang Pembinaan (JAMBIN) Kejaksaan Agung RI menuntut adanya sistem informasi yang tidak sekadar mencatat data secara pasif, tetapi mampu mengawal validitas formula, mencegah distorsi angka capaian, dan menyajikan laporan kinerja secara otomatis dan transparan.
            </p>

            <!-- Visual Infografis Perbandingan -->
            <div style="margin: 8px 0; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div style="background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 6px; padding: 8px;">
                    <div style="font-weight: 800; font-size: 8pt; color: #991b1b; display: flex; align-items: center; margin-bottom: 4px;">
                        <span style="background: #ef4444; color: #fff; border-radius: 50%; width: 15px; height: 15px; display: inline-flex; justify-content: center; align-items: center; margin-right: 5px; font-size: 6.5pt;">✕</span>
                        PARADIGMA LAMA (SEBELUM v4)
                    </div>
                    <ul style="margin: 0; padding-left: 14px; font-size: 7.2pt; color: #7f1d1d; line-height: 1.4;">
                        <li>Pelaporan manual berbasis lembar sebar Excel terpisah per satker.</li>
                        <li>Rumus rata-rata linier otomatis (generic averaging) yang meratakan nilai tanpa memperhatikan bobot dan tipe indikator.</li>
                        <li>Hanya menginput persentase akhir (%) tanpa pembuktian angka mentah pembilang dan penyebut.</li>
                        <li>Penyusunan dokumen LKjIP triwulanan memakan waktu berminggu-minggu secara manual di Microsoft Word.</li>
                    </ul>
                </div>

                <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 6px; padding: 8px;">
                    <div style="font-weight: 800; font-size: 8pt; color: #166534; display: flex; align-items: center; margin-bottom: 4px;">
                        <span style="background: #22c55e; color: #fff; border-radius: 50%; width: 15px; height: 15px; display: inline-flex; justify-content: center; align-items: center; margin-right: 5px; font-size: 6.5pt;">✓</span>
                        PARADIGMA BARU e-LAPTRI v4
                    </div>
                    <ul style="margin: 0; padding-left: 14px; font-size: 7.2pt; color: #14532d; line-height: 1.4;">
                        <li>Arsitektur Canonical Directed Acyclic Graph (DAG) berbasis web terpusat.</li>
                        <li>Aturan kalkulasi ketat dengan 9 Tipe Formula resmi (DIRECT_VALUE, RATIO, WEIGHTED_SUM, dll.).</li>
                        <li>Wajib merekam variabel mentah $X_1$ (pembilang) dan $X_2$ (penyebut) dengan bukti dukung dokumen (evidence).</li>
                        <li>Generator Dokumen Word LKjIP instan dengan templating cerdas sekali klik.</li>
                    </ul>
                </div>
            </div>

            <h3 class="subtitle-primary">3 TUJUAN STRATEGIS TRANSFORMASI e-LAPTRI v4</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-top: 6px;">
                <div class="feature-box" style="border-top: 3px solid #0284c7;">
                    <div style="font-size: 7.8pt; font-weight: 800; color: #0369a1;">1. INTEGRITAS DATA</div>
                    <p style="font-size: 7.1pt; color: #475569; margin: 3px 0 0 0; line-height: 1.35;">
                        Setiap capaian kinerja dapat diaudit kembali hingga ke lembar bukti dukung terkecil pada tingkat satuan kerja pelaksana teknis.
                    </p>
                </div>
                <div class="feature-box" style="border-top: 3px solid #059669;">
                    <div style="font-size: 7.8pt; font-weight: 800; color: #064e3b;">2. EFISIENSI WAKTU</div>
                    <p style="font-size: 7.1pt; color: #475569; margin: 3px 0 0 0; line-height: 1.35;">
                        Mengeliminasi redundansi kompilasi manual antar-biro sehingga pimpinan memperoleh laporan konsolidasi tepat waktu.
                    </p>
                </div>
                <div class="feature-box" style="border-top: 3px solid #d97706;">
                    <div style="font-size: 7.8pt; font-weight: 800; color: #92400e;">3. KENDALI STRATEGIS</div>
                    <p style="font-size: 7.1pt; color: #475569; margin: 3px 0 0 0; line-height: 1.35;">
                        Menyajikan visualisasi tren dan early warning jika terdapat indikator program yang mengalami kendala realisasi.
                    </p>
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 10px;">
                <strong>ARAHAN JAKSA AGUNG MUDA BIDANG PEMBINAAN:</strong><br>
                Sistem e-LAPTRI v4 diposisikan sebagai instrumen utama dalam rapat evaluasi pimpinan JAMBIN setiap akhir triwulan, guna membedah realisasi anggaran yang berkorelasi langsung dengan output kinerja riil instansi.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 5 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 6: BAB I - 1.2 DASAR HUKUM & REGULASI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-6">
        <div class="header">
            <span>BAB I: PENDAHULUAN &amp; ARSITEKTUR</span>
            <span>1.2 DASAR HUKUM &amp; REGULASI ACUAN</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB I: PENDAHULUAN &amp; ARSITEKTUR SISTEM</div>
            <h2 class="title-primary">1.2 LANDASAN HUKUM &amp; STANDAR REGULASI KINERJA</h2>

            <p class="paragraph">
                Penyusunan arsitektur data, formula indikator, serta siklus pelaporan e-LAPTRI v4 dibangun di atas landasan hukum nasional dan peraturan internal Kejaksaan Republik Indonesia yang mengikat:
            </p>

            <div style="display: grid; grid-template-columns: 1fr; gap: 6px; margin: 8px 0;">
                <div class="card-regulasi" style="border-left-color: #064e3b;">
                    <div class="regulasi-title">1. Undang-Undang Nomor 11 Tahun 2021 tentang Kejaksaan Republik Indonesia</div>
                    <div class="regulasi-desc">Perubahan atas UU No. 16 Tahun 2004 yang menegaskan kemandirian kejaksaan dalam tata kelola administrasi aparatur, organisasi, dan pengelolaan keuangan negara berbasis akuntabilitas kinerja.</div>
                </div>

                <div class="card-regulasi" style="border-left-color: #0284c7;">
                    <div class="regulasi-title">2. Peraturan Presiden Nomor 29 Tahun 2014 tentang SAKIP</div>
                    <div class="regulasi-desc">Mengatur kewajiban setiap instansi pemerintah untuk menyelenggarakan perencanaan, penetapan target, pengukuran capaian, evaluasi internal, dan pelaporan kinerja berkala.</div>
                </div>

                <div class="card-regulasi" style="border-left-color: #d97706;">
                    <div class="regulasi-title">3. Peraturan MenPAN-RB Nomor 88 Tahun 2021 tentang Evaluasi Kinerja</div>
                    <div class="regulasi-desc">Pedoman teknis evaluasi akuntabilitas kinerja instansi pemerintah dengan fokus pada kebermanfaatan hasil <em>(outcome)</em>, pencegahan formalitas semu, dan konsistensi berjenjang (cascading).</div>
                </div>

                <div class="card-regulasi" style="border-left-color: #7c3aed;">
                    <div class="regulasi-title">4. Keputusan Jaksa Agung RI Nomor 1184 Tahun 2025 tentang IKU Kejaksaan RI</div>
                    <div class="regulasi-desc"><strong>Sumber Resmi Nomenklatur &amp; Target Utama:</strong> Menetapkan kode indikator, teks definisi operasional, formula matematis, target tahunan 2025-2029, dan unit penanggung jawab utama.</div>
                </div>

                <div class="card-regulasi" style="border-left-color: #e11d48;">
                    <div class="regulasi-title">5. Rencana Strategis (Renstra) Kejaksaan RI Tahun 2025-2029</div>
                    <div class="regulasi-desc">Dokumen induk rencana pembangunan jangka menengah Kejaksaan RI yang memuat visi misi Jaksa Agung, Sasaran Strategis (SS), Sasaran Program (SP), dan Sasaran Kegiatan (SK) bidang Pembinaan.</div>
                </div>
            </div>

            <!-- Kepatuhan Audit Table -->
            <table class="table-styled" style="margin-top: 6px;">
                <tr>
                    <th style="width: 25%;">Lembaga Penilai</th>
                    <th style="width: 35%;">Aspek yang Dinilai</th>
                    <th>Standar Kepatuhan pada e-LAPTRI v4</th>
                </tr>
                <tr>
                    <td><strong>KemenPAN-RB</strong></td>
                    <td>Evaluasi Nilai SAKIP (A / BB / B)</td>
                    <td>Pohon kinerja terstruktur vertikal bebas siklus (DAG), formula rasio eksplisit.</td>
                </tr>
                <tr>
                    <td><strong>BPKP</strong></td>
                    <td>Audit Akuntabilitas Keuangan &amp; Kinerja</td>
                    <td>Bukti dukung <em>(evidence)</em> terunggah langsung pada setiap komponen pembilang &amp; penyebut.</td>
                </tr>
                <tr>
                    <td><strong>Inspektorat Kejagung</strong></td>
                    <td>Reviu Kinerja Triwulanan Internal</td>
                    <td>Audit trail verifikasi berjenjang dari Operator Satker ke Verifikator JAMBIN.</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 6 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 7: BAB I - 1.3 ARSITEKTUR TEKNOLOGI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-7">
        <div class="header">
            <span>BAB I: PENDAHULUAN &amp; ARSITEKTUR</span>
            <span>1.3 ARSITEKTUR TEKNOLOGI &amp; KEAMANAN DATA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB I: PENDAHULUAN &amp; ARSITEKTUR SISTEM</div>
            <h2 class="title-primary">1.3 TOPOLOGI ARSITEKTUR TEKNOLOGI &amp; KEAMANAN DATA</h2>

            <p class="paragraph">
                Aplikasi e-LAPTRI v4 dibangun dengan pendekatan arsitektur <em>Modular-Monolith Modern</em> menggunakan kerangka kerja Laravel 12 pada sisi backend yang dipadukan secara reaktif dengan React SPA melalui protokol Inertia.js.
            </p>

            <!-- Diagram Topologi Visual -->
            <div style="background: #0f172a; border-radius: 8px; padding: 10px; color: #ffffff; margin: 8px 0;">
                <div style="font-size: 7.8pt; font-weight: 800; color: #38bdf8; text-transform: uppercase; margin-bottom: 6px; text-align: center;">
                    DIAGRAM ALIR LAYER SISTEM e-LAPTRI v4
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; text-align: center;">
                    <div style="background: #1e293b; border: 1px solid #334155; border-radius: 6px; padding: 6px;">
                        <div style="font-size: 7.2pt; color: #94a3b8; font-weight: 700;">PRESENTATION LAYER</div>
                        <div style="font-size: 9pt; font-weight: 800; color: #38bdf8; margin: 2px 0;">React 18 + Inertia.js</div>
                        <div style="font-size: 6.8pt; color: #cbd5e1;">MUI X-DataGrid, MUI Charts, Tailwind CSS, Framer Motion</div>
                    </div>
                    <div style="background: #1e293b; border: 1px solid #334155; border-radius: 6px; padding: 6px;">
                        <div style="font-size: 7.2pt; color: #94a3b8; font-weight: 700;">APPLICATION CORE</div>
                        <div style="font-size: 9pt; font-weight: 800; color: #34d399; margin: 2px 0;">Laravel 12 Engine</div>
                        <div style="font-size: 6.8pt; color: #cbd5e1;">GraphValidator, Formula Registry, PHPWord LKjIP Exporter</div>
                    </div>
                    <div style="background: #1e293b; border: 1px solid #334155; border-radius: 6px; padding: 6px;">
                        <div style="font-size: 7.2pt; color: #94a3b8; font-weight: 700;">PERSISTENCE LAYER</div>
                        <div style="font-size: 9pt; font-weight: 800; color: #f59e0b; margin: 2px 0;">MySQL 8+ Database</div>
                        <div style="font-size: 6.8pt; color: #cbd5e1;">Tabel Prefiks kinerja_*, Graph Nodes &amp; Relasi Edges</div>
                    </div>
                </div>
            </div>

            <h3 class="subtitle-primary">4 FITUR UTAMA TEKNOLOGI e-LAPTRI v4</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 6px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 9px;">
                    <strong style="color: #0369a1; font-size: 7.8pt;">A. Zero-Latency Page Navigation (SPA)</strong>
                    <p style="font-size: 7pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Navigasi antar halaman berlangsung instan tanpa browser reload, mempertahankan state form input komponen saat berpindah antar indikator.
                    </p>
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 9px;">
                    <strong style="color: #064e3b; font-size: 7.8pt;">B. Atomic Database Transactions</strong>
                    <p style="font-size: 7pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Setiap proses submit data dan perubahan formula dieksekusi secara atomic; jika terjadi galat, database di-rollback otomatis tanpa data korup.
                    </p>
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 9px;">
                    <strong style="color: #92400e; font-size: 7.8pt;">C. Multi-Level RBAC &amp; Session Guard</strong>
                    <p style="font-size: 7pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Pemisahan tegas hak akses Operator Satker dan Super Admin JAMBIN dengan proteksi token CSRF dan penguncian sesi aktif otomatis.
                    </p>
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 9px;">
                    <strong style="color: #7c3aed; font-size: 7.8pt;">D. Mathematical Formula Sandbox</strong>
                    <p style="font-size: 7pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Evaluasi rumus menggunakan parser aman berdasar komponen input terdaftar, mutlak tanpa mengeksekusi string berbahaya <em>(no eval)</em>.
                    </p>
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>STANDAR KEAMANAN DATA SAKIP:</strong><br>
                Kata sandi pengguna dienkripsi dengan algoritma <code>bcrypt (cost 12)</code>. Seluruh berkas bukti dukung yang diunggah disimpan di direktori terlindung dengan validasi tipe MIME biner untuk mencegah injeksi skrip berbahaya.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 7 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 8: BAB I - 1.4 DISTRIBUSI 10 SATKER ESELON II
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-8">
        <div class="header">
            <span>BAB I: PENDAHULUAN &amp; ARSITEKTUR</span>
            <span>1.4 DISTRIBUSI 10 SATKER ESELON II JAMBIN</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB I: PENDAHULUAN &amp; ARSITEKTUR SISTEM</div>
            <h2 class="title-primary">1.4 PETA DISTRIBUSI 10 SATKER ESELON II DI LINGKUNGAN JAMBIN</h2>

            <p class="paragraph">
                Ruang lingkup pelaporan e-LAPTRI v4 mencakup 10 Unit Kerja Eselon II di lingkungan Jaksa Agung Muda Bidang Pembinaan. Masing-masing unit memiliki kewenangan operasional atas Sasaran Kegiatan (SK) dan Indikator Kinerja Kegiatan (IKK) yang telah ditetapkan:
            </p>

            <table class="table-styled" style="font-size: 7.4pt; margin-top: 6px;">
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 14%;">Kode Satker</th>
                    <th style="width: 25%;">Nama Unit Kerja Eselon II</th>
                    <th style="width: 16%;">Username Akun</th>
                    <th>Fokus Substansi Kinerja SAKIP</th>
                </tr>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td><strong>SET</strong></td>
                    <td>Sekretariat JAMBIN</td>
                    <td><code>set.jambin</code></td>
                    <td>Tata kelola umum pimpinan, koordinasi internal pembinaan, administrasi kedinasan.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td><strong>REN</strong></td>
                    <td>Biro Perencanaan</td>
                    <td><code>ro.ren</code></td>
                    <td>Perencanaan strategis, penyusunan anggaran, reviu SAKIP, dan evaluasi kinerja nasional.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">3</td>
                    <td><strong>PEG</strong></td>
                    <td>Biro Kepegawaian</td>
                    <td><code>ro.peg</code></td>
                    <td>Manajemen talenta ASN, mutasi/promosi, sistem merit, diklat, dan kepatuhan disiplin.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">4</td>
                    <td><strong>KEU</strong></td>
                    <td>Biro Keuangan</td>
                    <td><code>ro.keu</code></td>
                    <td>Realisasi anggaran belanja, laporan keuangan instansi (UAPA), dan perbendaharaan.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">5</td>
                    <td><strong>KAP</strong></td>
                    <td>Biro Perlengkapan</td>
                    <td><code>ro.kap</code></td>
                    <td>Pengadaan barang/jasa pemerintah, pengelolaan BMN, dan pemeliharaan aset dinas.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">6</td>
                    <td><strong>HLN</strong></td>
                    <td>Biro Hukum &amp; Hublu</td>
                    <td><code>ro.huk.hln</code></td>
                    <td>Penyusunan regulasi kejaksaan, telaah hukum, dan kerja sama luar negeri.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">7</td>
                    <td><strong>UMUM</strong></td>
                    <td>Biro Umum</td>
                    <td><code>ro.umum</code></td>
                    <td>Layanan rumah tangga, keamanan dalam, protokol kedinasan, dan tata usaha pimpinan.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">8</td>
                    <td><strong>PDTI</strong></td>
                    <td>Pusdaskrimti</td>
                    <td><code>pusdaskrimti</code></td>
                    <td>Transformasi digital, infrastruktur IT, jaringan komunikasi data, dan keamanan siber.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">9</td>
                    <td><strong>PSKPH</strong></td>
                    <td>Pustrajakgakum</td>
                    <td><code>pustrajakgakum</code></td>
                    <td>Penyusunan naskah kebijakan strategis penegakan hukum dan kajian ilmiah institusi.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">10</td>
                    <td><strong>PKY</strong></td>
                    <td>Pusat Kesehatan Yustisial</td>
                    <td><code>pky</code></td>
                    <td>Pelayanan medis forensik, kesehatan pegawai kejaksaan, dan operasional RS Adhyaksa.</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>PERAN AKUN ADMIN PUSAT (SUPER ADMIN JAMBIN):</strong><br>
                Di atas 10 Satker Eselon II di atas, terdapat akun tingkat pusat <code>admin.jambin</code> dengan kode bidang <code>JMBIN</code>. Akun ini memiliki hak akses penuh dalam memverifikasi seluruh laporan, mengonfigurasi formula nasional, dan mengekspor dokumen LKjIP JAMBIN.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 8 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 9: BAB II - 2.1 POHON KINERJA BEBAS SIKLUS (DAG)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-9">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.1 POHON KINERJA CANONICAL (DAG)</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA SAKIP &amp; CASCADING CANONICAL</div>
            <h2 class="title-primary">2.1 POHON KINERJA &amp; HIERARKI CASCADING CANONICAL (DAG)</h2>

            <p class="paragraph">
                Salah satu lompatan terbesar dalam sistem e-LAPTRI v4 adalah penggunaan struktur data <strong>Directed Acyclic Graph (DAG)</strong> menggantikan pohon hirarki linier kaku (tree tunggal). Pendekatan ini memungkinkan simpul indikator memiliki relasi multi-parent tanpa menciptakan siklus loop perhitungan.
            </p>

            <!-- Diagram Alir Cascading Hierarki -->
            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 10px; margin: 8px 0;">
                <div style="font-size: 7.8pt; font-weight: 800; color: #064e3b; text-transform: uppercase; margin-bottom: 6px; text-align: center;">
                    HIERARKI PENJENJANGAN KINERJA CANONICAL JAMBIN 2025-2029
                </div>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <div style="background: #091a2b; color: #ffffff; border-radius: 5px; padding: 5px 8px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 800; font-size: 8pt; color: #38bdf8;">LEVEL 1: SASARAN STRATEGIS (SS)</span>
                        <span style="font-size: 7pt; background: rgba(56, 189, 248, 0.2); padding: 1px 6px; border-radius: 3px;">2 Sasaran Strategis Makro</span>
                    </div>
                    <div style="text-align: center; font-size: 7pt; color: #64748b; line-height: 1;">↓ Ditopang oleh Indikator Kinerja Sasaran Strategis</div>
                    <div style="background: #0d2847; color: #ffffff; border-radius: 5px; padding: 5px 8px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 800; font-size: 8pt; color: #f59e0b;">LEVEL 2: INDIKATOR KINERJA SASARAN STRATEGIS (IKSS)</span>
                        <span style="font-size: 7pt; background: rgba(245, 158, 11, 0.2); padding: 1px 6px; border-radius: 3px;">2 Indikator Utama JAMBIN</span>
                    </div>
                    <div style="text-align: center; font-size: 7pt; color: #64748b; line-height: 1;">↓ Menurun secara Cascading &amp; Lintas-Program</div>
                    <div style="background: #064e3b; color: #ffffff; border-radius: 5px; padding: 5px 8px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 800; font-size: 8pt; color: #34d399;">LEVEL 3: SASARAN PROGRAM (SP) &amp; IKP</span>
                        <span style="font-size: 7pt; background: rgba(52, 211, 153, 0.2); padding: 1px 6px; border-radius: 3px;">12 Sasaran Program &amp; 20 IKP</span>
                    </div>
                    <div style="text-align: center; font-size: 7pt; color: #64748b; line-height: 1;">↓ Diturunkan ke Satuan Kerja Pelaksana Teknis Eselon II</div>
                    <div style="background: #1e293b; color: #ffffff; border-radius: 5px; padding: 5px 8px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 800; font-size: 8pt; color: #e2e8f0;">LEVEL 4: SASARAN KEGIATAN (SK) &amp; IKK</span>
                        <span style="font-size: 7pt; background: rgba(226, 232, 240, 0.2); padding: 1px 6px; border-radius: 3px;">35 Sasaran Kegiatan &amp; 97 IKK Output</span>
                    </div>
                </div>
            </div>

            <h3 class="subtitle-primary">3 ATURAN BAKU INTEGRITAS GRAPH CANONICAL</h3>
            <div style="display: grid; grid-template-columns: 1fr; gap: 5px; margin-top: 6px;">
                <div class="card-regulasi" style="border-left-color: #ef4444;">
                    <strong style="color: #991b1b; font-size: 7.8pt;">1. DILARANG MERATA-RATAKAN ANAK SECARA GENERIK (NO GENERIC AVERAGE)</strong>
                    <div class="regulasi-desc">Sistem tidak boleh menghitung capaian parent dengan <code>average(all children)</code> hanya karena parent memiliki child node. Perhitungan wajib merujuk pada formula spesifik dan tipe semantik relasi.</div>
                </div>
                <div class="card-regulasi" style="border-left-color: #0284c7;">
                    <strong style="color: #0369a1; font-size: 7.8pt;">2. DUKUNGAN RELASI LINTAS-PROGRAM (CROSS-PROGRAM DAG)</strong>
                    <div class="regulasi-desc">Sistem mengizinkan simpul pada tingkat atas (misalnya IKSS 2.1) terhubung langsung ke Sasaran Program (SP 18) atau IKK tertentu tanpa terhambat struktur pohon linier yang kaku.</div>
                </div>
                <div class="card-regulasi" style="border-left-color: #059669;">
                    <strong style="color: #064e3b; font-size: 7.8pt;">3. SEPARASI TABEL BISNIS DAN GRAPH REGISTRY</strong>
                    <div class="regulasi-desc">Tabel <code>kinerja_nodes</code> berfungsi sebagai registrasi identitas teknis, sedangkan atribut bisnis tetap tersimpan utuh pada tabel masing-masing (<code>kinerja_ss</code>, <code>kinerja_sp</code>, <code>kinerja_sk</code>, dsb.).</div>
                </div>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 9 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 10: BAB II - 2.2 TAKSONOMI 7 SEMANTIK RELASI
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-10">
        <div class="header">
            <span>BAB II: CASCADING JAMBIN 2025-2029</span>
            <span>2.2 TAKSONOMI SEMANTIK RELASI</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB II: KERANGKA SAKIP &amp; CASCADING CANONICAL</div>
            <h2 class="title-primary">2.2 TAKSONOMI 7 SEMANTIK RELASI ANTAR-INDIKATOR</h2>

            <p class="paragraph">
                Dalam tabel <code>kinerja_relasi</code>, setiap edge penghubung antar-indikator wajib didefinisikan dengan atribut <code>jenis_relasi</code> yang eksplisit. Hal ini menjamin bahwa mesin hitung mengeksekusi data sesuai logika bisnis SAKIP Kejaksaan RI:
            </p>

            <table class="table-styled" style="font-size: 7.2pt; margin-top: 4px;">
                <tr>
                    <th style="width: 22%;">Tipe Semantik Relasi</th>
                    <th style="width: 28%;">Makna Konseptual</th>
                    <th>Perilaku Kalkulasi pada Engine e-LAPTRI v4</th>
                </tr>
                <tr>
                    <td><strong style="color: #064e3b;">STRUCTURAL</strong></td>
                    <td>Pasangan resmi sasaran dengan indikatornya pada level yang sama.</td>
                    <td>Tidak ada perhitungan matematis; indikator menjadi pengukur formal ketercapaian sasaran induknya.</td>
                </tr>
                <tr>
                    <td><strong style="color: #0284c7;">CASCADING</strong></td>
                    <td>Penjenjangan logis dari outcome strategis ke output teknis.</td>
                    <td>Menunjukkan alur penugasan sasaran tanpa implikasi kalkulasi numerik otomatis ke parent.</td>
                </tr>
                <tr>
                    <td><strong style="color: #d97706;">FORMULA_COMPONENT</strong></td>
                    <td>Child node merupakan operand langsung dalam formula parent.</td>
                    <td><strong>Hanya relasi ini</strong> yang dihitung otomatis oleh engine untuk operasi SUM, AVERAGE, atau RATIO.</td>
                </tr>
                <tr>
                    <td><strong style="color: #7c3aed;">CONTRIBUTION</strong></td>
                    <td>Child mendukung ketercapaian parent tanpa ikatan formula matematis.</td>
                    <td>Mencegah child bernilai tinggi mendongkrak capaian parent secara artifisial (misal: IKP 10.1 dan SK/IKK kontribusi).</td>
                </tr>
                <tr>
                    <td><strong style="color: #059669;">SAME_INDICATOR</strong></td>
                    <td>Indikator yang sama diturunkan persis pada level di bawahnya.</td>
                    <td>Nilai realisasi diteruskan secara langsung <em>(pass-through)</em> tanpa dirata-ratakan dengan indikator lain.</td>
                </tr>
                <tr>
                    <td><strong style="color: #e11d48;">ORG_AGGREGATION</strong></td>
                    <td>Konsolidasi nilai indikator yang sama lintas satker Eselon II.</td>
                    <td>Engine menjumlahkan atau merata-ratakan capaian dari 10 Biro/Pusat menjadi capaian nasional JAMBIN.</td>
                </tr>
                <tr>
                    <td><strong style="color: #475569;">REFERENCE</strong></td>
                    <td>Keterkaitan referensi dokumen pendukung atau faktor pemungkin.</td>
                    <td>Hubungan analitis murni untuk kebutuhan penyusunan narasi evaluasi kinerja pada LKjIP.</td>
                </tr>
            </table>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>CONTOH KASUS INTEGRITAS RELASI:</strong><br>
                Pada IKP 5.1 (Indeks Kepuasan Layanan Pembinaan), simpul anak bertipe <code>CONTRIBUTION</code> tidak dihitung otomatis sebagai pembagi atau penambah. Nilai IKP 5.1 dihitung murni berdasarkan survei resmi tersendiri, menjaga keaslian angka indeks sesuai metodologi Kepja 1184 Tahun 2025.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 10 dari 40</span>
        </div>
    </div>
    """)

    return pages
