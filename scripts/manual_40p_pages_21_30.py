# -*- coding: utf-8 -*-
"""
Modul Penyusun Halaman 21 sampai 30
Buku Manual Operasional e-LAPTRI v4 (e-LKjIP Pembinaan)
Jaksa Agung Muda Bidang Pembinaan Kejaksaan Agung RI: Dr. Hendro Dewanto, S.H., M.Hum.
"""

def get_pages_21_to_30(assets):
    pages = []

    # ==========================================
    # HALAMAN 21: BAB V - 5.2 PENGISIAN RUMUS RASIO (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-21">
        <div class="header">
            <span>BAB V: INPUT PENGUKURAN KINERJA</span>
            <span>5.2 PENGISIAN KOMPONEN RUMUS RASIO</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN</div>
            <h2 class="title-primary">5.2 PENGISIAN KOMPONEN RUMUS RASIO (X1 &amp; X2)</h2>

            <p class="paragraph">
                Mayoritas indikator kinerja di lingkungan JAMBIN merupakan indikator bertipe <strong>RATIO (Persentase)</strong>. Sesuai prinsip SAKIP modern, operator dilarang langsung mengetik angka persentase akhir. Operator wajib memasukkan angka mentah pembilang ($X_1$) dan penyebut ($X_2$):
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_input_details')}" class="screenshot-img" alt="Form Pengisian Variabel Mentah X1 dan X2">
                <div class="screenshot-caption">Gambar 5.2: Kartu Input Komponen Rumus Rasio (Pembilang X1 dan Penyebut X2) beserta Live Preview Realisasi</div>
            </div>

            <h3 class="subtitle-primary">ATURAN BAKU PENGISIAN VARIABEL MENTAH:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Variabel Pembilang ($X_1$ / Numerator):</strong><br>
                    Isi dengan angka riil capaian output yang berhasil diselesaikan pada triwulan aktif (misal: jumlah pegawai yang mengikuti diklat = 450 orang).
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[2] Variabel Penyebut ($X_2$ / Denominator):</strong><br>
                    Isi dengan angka total populasi atau target total beban kerja (misal: total pegawai yang wajib mengikuti diklat = 500 orang). Angka tidak boleh 0.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[3] Live Preview Realisasi Terkalkulasi:</strong><br>
                    Sistem secara instan menghitung: $(450 / 500) \times 100\% = 90.00\%$. Operator dapat langsung memvalidasi kebenaran angka sebelum disimpan.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[4] Informasi Petunjuk Rumus Resmi:</strong><br>
                    Di bawah kotak input tercantum teks panduan resmi dari Kepja 1184/2025 yang menjelaskan secara detail definisi pembilang dan penyebut.
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>PENCEGAHAN PEMBAGIAN DENGAN NOL (DIVISION BY ZERO):</strong><br>
                Jika penyebut ($X_2$) bernilai 0 karena kegiatan belum berjalan pada triwulan tersebut, sistem akan secara otomatis menandai realisasi sebagai <code>0.00%</code> atau <code>Belum Ada Beban Kerja</code>, mencegah terjadinya crash atau galat kalkulasi numerik.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 21 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 22: BAB V - 5.3 MANDIRI VS AGREGATIF
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-22">
        <div class="header">
            <span>BAB V: INPUT PENGUKURAN KINERJA</span>
            <span>5.3 INDIKATOR MANDIRI VS AGREGATIF</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN</div>
            <h2 class="title-primary">5.3 PERBEDAAN INDIKATOR MANDIRI VS AGREGATIF / ROLL-UP</h2>

            <p class="paragraph">
                Dalam arsitektur e-LAPTRI v4, setiap indikator kinerja diklasifikasikan ke dalam dua mekanisme pengisian yang sangat berbeda. Pemahaman atas klasifikasi ini penting agar operator tidak menunggu data yang seharusnya diinput mandiri:
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 8px 0;">
                <div style="background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 6px; padding: 8px;">
                    <div style="font-weight: 800; font-size: 8pt; color: #1e40af; margin-bottom: 4px;">
                        TIPE A: INDIKATOR MANDIRI (STANDALONE)
                    </div>
                    <p style="font-size: 7.1pt; color: #1e3a8a; line-height: 1.4; margin: 0 0 6px 0;">
                        Indikator yang nilai realisasinya bersumber murni dari pelaksanaan tugas internal satu unit kerja (satker tunggal).
                    </p>
                    <ul style="margin: 0; padding-left: 14px; font-size: 7pt; color: #172554; line-height: 1.35;">
                        <li><strong>Contoh:</strong> IKK 14.1.1 (Persentase penyusunan RKA-K/L oleh Biro Perencanaan).</li>
                        <li><strong>Alur Input:</strong> Operator satker penanggung jawab langsung menginput nilai mentah $X_1$ dan $X_2$.</li>
                        <li><strong>Independensi:</strong> Tidak dipengaruhi oleh pengisian data dari biro atau pusat lainnya.</li>
                    </ul>
                </div>

                <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 6px; padding: 8px;">
                    <div style="font-weight: 800; font-size: 8pt; color: #166534; margin-bottom: 4px;">
                        TIPE B: INDIKATOR AGREGATIF / ROLL-UP
                    </div>
                    <p style="font-size: 7.1pt; color: #14532d; line-height: 1.4; margin: 0 0 6px 0;">
                        Indikator pada tingkat program/strategis yang nilainya dihimpun secara otomatis dari konsolidasi multi-indikator atau lintas-satker.
                    </p>
                    <ul style="margin: 0; padding-left: 14px; font-size: 7pt; color: #052e16; line-height: 1.35;">
                        <li><strong>Contoh:</strong> IKP 13.1 (Persentase Capaian Kinerja Pembinaan Terpadu JAMBIN).</li>
                        <li><strong>Alur Hitung:</strong> Dihitung otomatis oleh calculation engine dengan formula <code>WEIGHTED_SUM</code>.</li>
                        <li><strong>Kotak Input Terkunci:</strong> Operator tidak menginput nilai manual; nilai berubah seiring submit dari satker anak.</li>
                    </ul>
                </div>
            </div>

            <h3 class="subtitle-primary">MATRIKS PEMBEDAHAN LOGIKA SISTEM:</h3>
            <table class="table-styled" style="font-size: 7.2pt; margin-top: 4px;">
                <tr>
                    <th style="width: 25%;">Parameter Pembeda</th>
                    <th style="width: 37%;">Indikator Mandiri</th>
                    <th>Indikator Agregatif / Roll-up</th>
                </tr>
                <tr>
                    <td><strong>Atribut Node</strong></td>
                    <td><code>node.input_enabled = true</code></td>
                    <td><code>node.input_enabled = false</code></td>
                </tr>
                <tr>
                    <td><strong>Tampilan di Antarmuka</strong></td>
                    <td>Memunculkan form input aktif dengan tombol simpan.</td>
                    <td>Tampil sebagai angka terkalkulasi dengan label <em>Agregat Otomatis</em>.</td>
                </tr>
                <tr>
                    <td><strong>Tipe Formula</strong></td>
                    <td><code>DIRECT_VALUE</code>, <code>RATIO</code>, <code>COUNT</code></td>
                    <td><code>SUM</code>, <code>AVERAGE</code>, <code>WEIGHTED_SUM</code></td>
                </tr>
                <tr>
                    <td><strong>Ketergantungan</strong></td>
                    <td>Dapat diselesaikan secara mandiri oleh satker.</td>
                    <td>Final setelah seluruh child node relasi <code>FORMULA_COMPONENT</code> terisi.</td>
                </tr>
            </table>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>PRINSIP FORMULA COMPONENT:</strong><br>
                Engine e-LAPTRI v4 hanya melakukan roll-up jika edge relasi bertipe <code>FORMULA_COMPONENT</code>. Relasi bertipe <code>CONTRIBUTION</code> tidak akan pernah dijumlahkan secara otomatis, melindungi integritas skor agregat.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 22 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 23: BAB V - 5.4 KALKULASI CAPAIAN
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-23">
        <div class="header">
            <span>BAB V: INPUT PENGUKURAN KINERJA</span>
            <span>5.4 MEKANISME KALKULASI CAPAIAN</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN</div>
            <h2 class="title-primary">5.4 MEKANISME KALKULASI REALISASI &amp; CAPAIAN TARGET</h2>

            <p class="paragraph">
                Sistem e-LAPTRI v4 membedakan secara tegas antara konsep <strong>Realisasi</strong> (output fisik dalam satuan indikator) dan <strong>Capaian terhadap Target</strong> (persentase keberhasilan terhadap standar yang ditetapkan):
            </p>

            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 10px; margin: 8px 0;">
                <div style="font-size: 7.8pt; font-weight: 800; color: #064e3b; text-transform: uppercase; margin-bottom: 6px; text-align: center;">
                    FORMULASI MATEMATIKA BAKU SAKIP PADA e-LAPTRI v4
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px; text-align: center;">
                        <div style="font-size: 7.2pt; color: #64748b; font-weight: 700;">1. RUMUS REALISASI (OUTPUT)</div>
                        <div style="font-size: 11pt; font-weight: 800; color: #0284c7; margin: 4px 0;">
                            $$\text{{Realisasi}} = \frac{{X_1}}{{X_2}} \times 100\%$$
                        </div>
                        <div style="font-size: 6.8pt; color: #475569;">Di mana $X_1$ adalah pembilang dan $X_2$ adalah penyebut.</div>
                    </div>

                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px; text-align: center;">
                        <div style="font-size: 7.2pt; color: #64748b; font-weight: 700;">2. RUMUS CAPAIAN TERHADAP TARGET</div>
                        <div style="font-size: 11pt; font-weight: 800; color: #059669; margin: 4px 0;">
                            $$\text{{Capaian}} = \frac{{\text{{Realisasi}}}}{{\text{{Target}}}} \times 100\%$$
                        </div>
                        <div style="font-size: 6.8pt; color: #475569;">Untuk indikator dengan arah kinerja positif <em>(maximize)</em>.</div>
                    </div>
                </div>
            </div>

            <h3 class="subtitle-primary">PENANGANAN 2 KONDISI KHUSUS DALAM SAKIP:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 4px;">
                <div class="feature-box">
                    <strong style="color: #92400e; font-size: 7.6pt;">A. Arah Kinerja Negatif (Minimize)</strong>
                    <p style="font-size: 7pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Untuk indikator di mana semakin kecil nilai realisasi semakin baik (misalnya waktu penyelesaian temuan BPK atau angka pelanggaran disiplin), formulanya adalah:
                        $$\text{{Capaian}} = \left( 1 + \frac{{\text{{Target}} - \text{{Realisasi}}}}{{\text{{Target}}}} \right) \times 100\%$$
                    </p>
                </div>

                <div class="feature-box">
                    <strong style="color: #7c3aed; font-size: 7.6pt;">B. Kebijakan Batas Atas (Capping 100% / 120%)</strong>
                    <p style="font-size: 7pt; color: #475569; margin: 2px 0 0 0; line-height: 1.35;">
                        Sesuai standar PermenPAN-RB No. 88 Tahun 2021, capaian yang melebihi target secara ekstrem dapat dibatasi (capped) maksimal pada angka <strong>120.00%</strong> untuk mencegah distorsi nilai rata-rata sasaran program secara artifisial.
                    </p>
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>PEMISAHAN KOLOM PENYIMPANAN DI DATABASE:</strong><br>
                Sistem tidak pernah menimpa nilai pembilang ke kolom realisasi. Pembilang disimpan di <code>kinerja_pengukuran_inputs</code>, realisasi disimpan di <code>kinerja_pengukurans.realisasi</code>, dan capaian di <code>kinerja_pengukurans.capaian</code>.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 23 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 24: BAB V - 5.5 LEMBAR ANALISIS (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-24">
        <div class="header">
            <span>BAB V: INPUT PENGUKURAN KINERJA</span>
            <span>5.5 PENYUSUNAN LEMBAR ANALISIS KINERJA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN</div>
            <h2 class="title-primary">5.5 PENYUSUNAN LEMBAR ANALISIS KINERJA, KENDALA &amp; SOLUSI</h2>

            <p class="paragraph">
                Laporan Akuntabilitas Kinerja (LKjIP) tidak hanya menyajikan angka numerik, tetapi menuntut penjelasan naratif yang mendalam. Formulir e-LAPTRI v4 menyediakan ruas analisis yang wajib diisi oleh operator untuk setiap indikator yang mengalami deviasi target:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_input_analysis')}" class="screenshot-img" alt="Form Lembar Analisis Kinerja, Kendala dan Solusi">
                <div class="screenshot-caption">Gambar 5.3: Ruas Pengisian Narasi Analisis Kinerja, Identifikasi Faktor Kendala &amp; Tindak Lanjut Solutif</div>
            </div>

            <h3 class="subtitle-primary">3 KOMPONEN NARASI EVALUASI STANDAR SAKIP:</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Analisis Keberhasilan:</strong><br>
                    Uraikan faktor pendorong utama yang mendukung ketercapaian target (misal: akselerasi sistem digital, kerja sama lintas-sektoral, atau komitmen pimpinan).
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[2] Identifikasi Kendala:</strong><br>
                    Jelaskan secara transparan hambatan internal maupun eksternal yang menyebabkan target belum optimal (misal: keterlambatan petunjuk teknis anggaran).
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[3] Rencana Tindak Lanjut:</strong><br>
                    Sebutkan langkah konkret dan jadwal mitigasi untuk mengatasi kendala tersebut pada triwulan berikutnya (misal: percepatan revisi DIPA).
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>INTEGRASI LANGSUNG KE LAPORAN WORD (LKjIP):</strong><br>
                Teks yang Anda ketikkan pada ketiga kolom ini akan diserap secara otomatis oleh generator dokumen ke dalam Bab III Laporan LKjIP JAMBIN. Gunakan tata bahasa resmi kedinasan yang jelas, terukur, dan tidak bertele-tele.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 24 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 25: BAB V - 5.6 EVIDENCE & AUTOSAVE
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-25">
        <div class="header">
            <span>BAB V: INPUT PENGUKURAN KINERJA</span>
            <span>5.6 EVIDENCE &amp; MEKANISME AUTOSAVE</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN</div>
            <h2 class="title-primary">5.6 UNGGAH BUKTI DUKUNG (EVIDENCE) &amp; FITUR AUTOSAVE</h2>

            <p class="paragraph">
                Dalam penilaian SAKIP oleh Kementerian PAN-RB dan BPKP, angka tanpa bukti dukung dianggap nihil. Oleh karena itu, e-LAPTRI v4 mewajibkan pelampiran berkas digital (evidence) untuk setiap komponen angka yang diinput:
            </p>

            <table class="table-styled" style="font-size: 7.2pt; margin-top: 4px;">
                <tr>
                    <th style="width: 25%;">Kategori Indikator</th>
                    <th style="width: 40%;">Contoh Bukti Dukung Sah (Evidence)</th>
                    <th>Format &amp; Batas Berkas</th>
                </tr>
                <tr>
                    <td><strong>Pengadaan &amp; Sarpras (BMN)</strong></td>
                    <td>Surat Perintah Kerja (SPK), Berita Acara Serah Terima (BAST), Tangkapan Layar e-Katalog, Laporan SIMAK BMN.</td>
                    <td>PDF (Maks. 10 MB per berkas)</td>
                </tr>
                <tr>
                    <td><strong>Pengembangan SDM (Diklat)</strong></td>
                    <td>Sertifikat Diklat, Surat Perintah Tugas, Rekapitulasi Jam Pelajaran (JP) dari Badiklat Kejaksaan RI.</td>
                    <td>PDF / ZIP (Maks. 15 MB)</td>
                </tr>
                <tr>
                    <td><strong>Perencanaan &amp; Anggaran</strong></td>
                    <td>DIPA Petikan, Laporan Realisasi Anggaran (LRA) OMSPAN, Berita Acara Rekonsiliasi KPPN.</td>
                    <td>PDF / XLSX (Maks. 10 MB)</td>
                </tr>
                <tr>
                    <td><strong>Regulasi &amp; Kebijakan</strong></td>
                    <td>Keputusan Jaksa Agung (KEPJA), Surat Edaran (SE), Naskah Akademik Policy Brief resmi.</td>
                    <td>PDF (Maks. 10 MB)</td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 10px;">MEKANISME PENYIMPANAN OTOMATIS (AUTOSAVE ASINKRON):</h3>
            <div style="background: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 8px; padding: 10px; margin: 6px 0;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <div style="display: flex; gap: 8px; align-items: flex-start;">
                        <div style="background: #0284c7; color: #fff; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 8pt; flex-shrink: 0;">1</div>
                        <div>
                            <strong style="color: #0369a1; font-size: 7.5pt;">Debounce Autosave 1.5 Detik:</strong>
                            <p style="font-size: 6.9pt; color: #475569; margin: 2px 0 0 0; line-height: 1.3;">
                                Saat operator mengetik angka mentah atau narasi kendala, sistem menunggu 1.5 detik setelah jeda pengetikan lalu mengirim data ke server secara latar belakang (AJAX).
                            </p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: flex-start;">
                        <div style="background: #059669; color: #fff; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 8pt; flex-shrink: 0;">2</div>
                        <div>
                            <strong style="color: #064e3b; font-size: 7.5pt;">Indikator Status Penyimpanan:</strong>
                            <p style="font-size: 6.9pt; color: #475569; margin: 2px 0 0 0; line-height: 1.3;">
                                Ikon awan di pojok kanan bawah kartu berubah: <span style="color: #d97706; font-weight: bold;">Menyimpan...</span> → <span style="color: #166534; font-weight: bold;">Tersimpan Otomatis</span>. Pengguna tidak perlu takut data hilang saat koneksi terputus.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 6px;">
                <strong>VERIFIKASI INTEGRITAS BERKAS:</strong><br>
                Seluruh berkas bukti dukung yang diunggah diberi tanda stempel waktu digital (*digital timestamp*) dan nama pengunggah. Bukti dukung ini dapat diunduh langsung oleh Verifikator JAMBIN saat tahapan reviu.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 25 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 26: BAB V - 5.7 FINALISASI SUBMIT (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-26">
        <div class="header">
            <span>BAB V: INPUT PENGUKURAN KINERJA</span>
            <span>5.7 FINALISASI &amp; SUBMIT DATA KE JAMBIN</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB V: PANDUAN OPERATOR: INPUT PENGUKURAN</div>
            <h2 class="title-primary">5.7 FINALISASI DATA &amp; PROSEDUR SUBMIT PENGUKURAN KE JAMBIN</h2>

            <p class="paragraph">
                Setelah seluruh indikator diisi variabel mentah $X_1/X_2$, narasi analisis kendala dilengkapi, dan berkas bukti dukung diunggah, operator wajib melakukan finalisasi pelaporan melalui <strong>Sticky Action Bar</strong> yang melayang di bagian bawah layar:
            </p>

            <div class="screenshot-card">
                <div style="background: #0f172a; padding: 8px 12px; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; color: #ffffff;">
                    <div>
                        <span style="font-size: 7.5pt; color: #94a3b8;">Status Pengisian: </span>
                        <strong style="font-size: 8.5pt; color: #34d399;">16 dari 16 Indikator Terisi (100%)</strong>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button style="background: #334155; color: #fff; border: 1px solid #475569; padding: 4px 10px; border-radius: 4px; font-size: 7.5pt; font-weight: 700;">Simpan Draf</button>
                        <button style="background: #059669; color: #fff; border: none; padding: 4px 14px; border-radius: 4px; font-size: 7.5pt; font-weight: 800;">Ajukan ke JAMBIN (Submit Data) →</button>
                    </div>
                </div>
                <div class="screenshot-caption">Gambar 5.4: Bilah Tindakan Mengambang (Sticky Action Bar) untuk Validasi Kelengkapan &amp; Finalisasi Pengajuan Data</div>
            </div>

            <h3 class="subtitle-primary">4 LANGKAH PROSEDUR SUBMIT KINERJA:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Pengecekan Validasi Mandiri:</strong><br>
                    Periksa badge persentase pengisian. Jika masih ada indikator yang terlewat, klik tautan indikator terkait untuk melengkapi ruas yang kosong.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[2] Klik Tombol "Ajukan ke JAMBIN":</strong><br>
                    Sistem akan memunculkan jendela dialog konfirmasi yang memuat ringkasan capaian triwulanan satker Anda.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[3] Konfirmasi &amp; Pernyataan Integritas:</strong><br>
                    Centang kotak pernyataan: <em>"Data dan berkas dukung yang dilaporkan adalah benar dan sah sesuai dokumen sumber"</em>, lalu klik <strong>Kirim</strong>.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #7c3aed;">[4] Penguncian Formulir (Read-Only):</strong><br>
                    Status pengukuran berubah menjadi <code>SUBMITTED</code>. Formulir langsung beralih ke mode baca (*read-only*) untuk melindungi data selama diaudit.
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>NOTIFIKASI KE VERIFIKATOR PUSAT:</strong><br>
                Saat proses submit selesai, sistem secara otomatis mengirimkan notifikasi tugas audit ke dashboard Verifikator JAMBIN di Biro Perencanaan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 26 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 27: BAB VI - 6.1 DASHBOARD ADMIN JAMBIN (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-27">
        <div class="header">
            <span>BAB VI: AUDIT &amp; REVIEW DATA JAMBIN</span>
            <span>6.1 DASHBOARD KONSOLIDASI NASIONAL</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR: REVIEW DATA</div>
            <h2 class="title-primary">6.1 DASHBOARD PEMANTAUAN KINERJA KONSOLIDASI JAMBIN</h2>

            <p class="paragraph">
                Bagi pengguna bertaraf Super Admin (<code>admin.jambin</code>) dan Tim SAKIP Biro Perencanaan, dashboard utama menampilkan status konsolidasi kinerja dari seluruh 10 Unit Kerja Eselon II di lingkungan Pembinaan:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_admin_dash')}" class="screenshot-img" alt="Dashboard Konsolidasi Administrator JAMBIN">
                <div class="screenshot-caption">Gambar 6.1: Antarmuka Dashboard Eksekutif Pemantauan Capaian Kinerja Makro JAMBIN</div>
            </div>

            <h3 class="subtitle-primary">FITUR KONTROL PADA DASHBOARD PUSAT:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Kartu Realisasi Makro JAMBIN:</strong><br>
                    Menampilkan nilai rata-rata tertimbang capaian seluruh sasaran program (SP) dan IKSS pembinaan untuk triwulan yang sedang dievaluasi.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[2] Radar Kepatuhan Satker (10 Biro/Pusat):</strong><br>
                    Menghitung jumlah satker yang telah berstatus <code>APPROVED</code>, <code>SUBMITTED</code>, maupun yang masih dalam status <code>DRAFT</code>.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[3] Early Warning Indikator Kritis:</strong><br>
                    Daftar indikator kegiatan yang capaiannya berada di bawah 50% ditampilkan di baris teratas agar pimpinan dapat memberikan arahan asistensi segera.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #7c3aed;">[4] Pintasan Cepat Verifikasi &amp; Ekspor:</strong><br>
                    Tombol akses langsung untuk membuka lembar kerja audit (*Review Data*) atau langsung meluncurkan generator Laporan LKjIP Word.
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>RUJUKAN RAPAT PIMPINAN JAMBIN:</strong><br>
                Dashboard ini dirancang khusus untuk ditampilkan pada layar monitor ruang rapat pimpinan saat berlangsungnya Rapim Evaluasi Kinerja Triwulanan yang dipimpin oleh <strong>Dr. Hendro Dewanto, S.H., M.Hum.</strong>
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 27 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 28: BAB VI - 6.2 MONITORING KEPATUHAN
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-28">
        <div class="header">
            <span>BAB VI: AUDIT &amp; REVIEW DATA JAMBIN</span>
            <span>6.2 MONITORING KEPATUHAN PENGISIAN</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR: REVIEW DATA</div>
            <h2 class="title-primary">6.2 MONITORING KEPATUHAN PENGISIAN SELURUH SATKER</h2>

            <p class="paragraph">
                Tepat waktu dan lengkapnya pelaporan kinerja merupakan indikator kedisiplinan organisasi. Sistem e-LAPTRI v4 menyajikan tabel pemantauan kepatuhan pengisian data dari 10 Unit Kerja Eselon II secara waktu nyata <em>(real-time)</em>:
            </p>

            <table class="table-styled" style="font-size: 7.1pt; margin-top: 4px;">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 22%;">Unit Kerja Eselon II</th>
                    <th style="width: 14%;">Total IKK</th>
                    <th style="width: 16%;">Status Submit</th>
                    <th style="width: 20%;">Waktu Penyampaian</th>
                    <th>Status Audit Verifikator</th>
                </tr>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td>Sekretariat JAMBIN</td>
                    <td style="text-align: center;">7 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>08 April 2026 14:22 WIB</td>
                    <td><strong style="color: #059669;">APPROVED</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td>Biro Perencanaan</td>
                    <td style="text-align: center;">12 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>07 April 2026 09:15 WIB</td>
                    <td><strong style="color: #059669;">APPROVED</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">3</td>
                    <td>Biro Kepegawaian</td>
                    <td style="text-align: center;">16 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>09 April 2026 16:40 WIB</td>
                    <td><strong style="color: #d97706;">PROSES AUDIT</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">4</td>
                    <td>Biro Keuangan</td>
                    <td style="text-align: center;">14 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>08 April 2026 11:05 WIB</td>
                    <td><strong style="color: #059669;">APPROVED</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">5</td>
                    <td>Biro Perlengkapan</td>
                    <td style="text-align: center;">11 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>09 April 2026 10:12 WIB</td>
                    <td><strong style="color: #d97706;">PROSES AUDIT</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">6</td>
                    <td>Biro Hukum &amp; HLN</td>
                    <td style="text-align: center;">8 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>09 April 2026 17:55 WIB</td>
                    <td><strong style="color: #059669;">APPROVED</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">7</td>
                    <td>Biro Umum</td>
                    <td style="text-align: center;">9 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>10 April 2026 08:30 WIB</td>
                    <td><strong style="color: #d97706;">PROSES AUDIT</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">8</td>
                    <td>Pusdaskrimti</td>
                    <td style="text-align: center;">10 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>06 April 2026 15:10 WIB</td>
                    <td><strong style="color: #059669;">APPROVED</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">9</td>
                    <td>Pustrajakgakum</td>
                    <td style="text-align: center;">5 IKK</td>
                    <td><span class="badge-role badge-opr">SUBMITTED</span></td>
                    <td>08 April 2026 13:45 WIB</td>
                    <td><strong style="color: #059669;">APPROVED</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;">10</td>
                    <td>Pusat Kesehatan Yustisial</td>
                    <td style="text-align: center;">5 IKK</td>
                    <td><span class="badge-role badge-admin">DRAFT</span></td>
                    <td>- (Belum Final)</td>
                    <td><strong style="color: #dc2626;">MENUNGGU SUBMIT</strong></td>
                </tr>
            </table>

            <h3 class="subtitle-primary" style="margin-top: 8px;">MEKANISME TEGURAN KETERLAMBATAN:</h3>
            <div class="callout callout-warning">
                <strong>SURAT PERINGATAN OTOMATIS:</strong><br>
                Sistem secara otomatis menerbitkan rekapitulasi satker yang belum melakukan finalisasi 24 jam sebelum batas akhir pengisian. Rekapitulasi ini disampaikan kepada Sekretaris JAMBIN sebagai dasar penerbitan surat teguran dinas.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 28 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 29: BAB VI - 6.3 HALAMAN REVIEW DATA (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-29">
        <div class="header">
            <span>BAB VI: AUDIT &amp; REVIEW DATA JAMBIN</span>
            <span>6.3 MODUL REVIEW DATA DATAGRID</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR: REVIEW DATA</div>
            <h2 class="title-primary">6.3 HALAMAN REVIEW DATA: FILTER MULTI-SATKER &amp; DATAGRID</h2>

            <p class="paragraph">
                Modul <strong>Review Data</strong> adalah ruang kerja utama bagi Verifikator Kinerja di Biro Perencanaan. Menggunakan komponen MUI X-DataGrid berperforma tinggi, modul ini memungkinkan pemeriksaan ratusan indikator dengan cepat:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_review_idx')}" class="screenshot-img" alt="Halaman Review Data Kinerja Seluruh Satker">
                <div class="screenshot-caption">Gambar 6.2: Lembar Kerja Pemeriksaan &amp; Filter Terpadu Seluruh Indikator Kinerja Satker</div>
            </div>

            <h3 class="subtitle-primary">FUNGSI PENGENDALI AUDIT PADA REVIEW DATAGRID:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[1] Dropdown Multi-Satker:</strong><br>
                    Memilih unit kerja yang ingin diperiksa (misal hanya menampilkan Biro Keuangan), atau memilih opsi <em>Semua Satker</em> untuk evaluasi menyeluruh.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">[2] Bilah Pencarian Cerdas (Global Search):</strong><br>
                    Cari indikator secara instan menggunakan kata kunci kode (misal: <code>18.1.1</code>) atau potongan kalimat nama indikator/satker.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">[3] Kolom Status Audit Kinerja:</strong><br>
                    Tabel menampilkan badge status visual: <span class="badge-role badge-opr">Approved</span>, <span class="badge-role" style="background:#fef3c7; color:#92400e;">Submitted</span>, atau <span class="badge-role badge-admin">Revisi</span>.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">[4] Tombol Tindakan "Periksa Detail":</strong><br>
                    Klik ikon mata / tombol <em>Review</em> pada baris indikator untuk membuka lembar kerja audit mendalam komponen $X_1/X_2$ dan berkas evidence.
                </div>
            </div>

            <div class="callout callout-info" style="margin-top: 8px;">
                <strong>FITUR SORTING &amp; EXPORT SPREADSHEET:</strong><br>
                Verifikator dapat mengurutkan data berdasarkan persentase capaian terendah untuk mendeteksi deviasi secara cepat, atau mengekspor tabel review ke format CSV/Excel untuk rekapitulasi rapat pimpinan.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 29 dari 40</span>
        </div>
    </div>
    """)

    # ==========================================
    # HALAMAN 30: BAB VI - 6.4 DETAIL LEMBAR AUDIT (SCREENSHOT)
    # ==========================================
    pages.append(f"""
    <div class="page" id="page-30">
        <div class="header">
            <span>BAB VI: AUDIT &amp; REVIEW DATA JAMBIN</span>
            <span>6.4 LEMBAR KERJA VERIFIKASI DATA</span>
        </div>
        <div class="content">
            <div class="chapter-badge">BAB VI: PANDUAN VERIFIKATOR: REVIEW DATA</div>
            <h2 class="title-primary">6.4 DETAIL LEMBAR KERJA VERIFIKASI: AUDIT NILAI &amp; EVIDENCE</h2>

            <p class="paragraph">
                Saat verifikator mengeklik salah satu baris indikator, sistem menyajikan <strong>Lembar Audit Terperinci</strong>. Di sinilah proses verifikasi objektif berlangsung guna memastikan keabsahan angka realisasi terhadap berkas fisik:
            </p>

            <!-- Screenshot Card -->
            <div class="screenshot-card">
                <img src="{assets.get('img_review_det')}" class="screenshot-img" alt="Detail Lembar Kerja Verifikasi Pengukuran">
                <div class="screenshot-caption">Gambar 6.3: Lembar Kerja Audit Menampilkan Rincian Komponen Mentah X1/X2, Evidence &amp; Riwayat Revisi</div>
            </div>

            <h3 class="subtitle-primary">4 CHECKLIST WAJIB VERIFIKATOR KINERJA:</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 7.2pt; margin-top: 4px;">
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #0369a1;">1. Cek Kesesuaian Target KEPJA:</strong><br>
                    Pastikan target pembanding yang digunakan adalah target KEPJA 1184/2025 yang telah ditetapkan untuk triwulan bersangkutan.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #064e3b;">2. Verifikasi Angka Mentah ($X_1$ &amp; $X_2$):</strong><br>
                    Cocokkan apakah angka pembilang dan penyebut yang diinput operator sesuai persis dengan nominal/kuantitas pada berkas dokumen sumber.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #d97706;">3. Validasi Keabsahan Berkas Evidence:</strong><br>
                    Unduh dan buka berkas bukti dukung yang dilampirkan. Pastikan dokumen telah ditandatangani pejabat berwenang dan memiliki cap dinas.
                </div>
                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 4px; padding: 5px 8px;">
                    <strong style="color: #7c3aed;">4. Telaah Kualitas Narasi Kendala:</strong><br>
                    Pastikan narasi kendala memberikan alasan yang logis, tidak sekadar mengulang kalimat indikator, dan memiliki rencana tindak lanjut nyata.
                </div>
            </div>

            <div class="callout callout-warning" style="margin-top: 8px;">
                <strong>AUDIT TRAIL VERIFIKASI TEREKAM ABADI:</strong><br>
                Setiap tindakan verifikasi mencatat identitas verifikator (<code>users.username</code>) dan cap waktu ke dalam kolom <code>verified_by</code> dan <code>verified_at</code> pada tabel <code>kinerja_pengukurans</code>, menjamin akuntabilitas reviu.
            </div>
        </div>
        <div class="footer">
            <span>JAKSA AGUNG MUDA BIDANG PEMBINAAN</span>
            <span>RENSTRA 2025-2029 &amp; KEPJA 1184/2025</span>
            <span>Halaman 30 dari 40</span>
        </div>
    </div>
    """)

    return pages
