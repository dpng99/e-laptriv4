# Cetak Biru Cascading SAKIP & Renstra Kejaksaan RI 2025-2029
## Bidang Pengampuan: Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

Dokumen ini menyajikan peta penjenjangan kinerja (*cascading structure*) secara utuh, rigid, dan terperinci untuk seluruh Sasaran Program (SP), Indikator Kinerja Program (IKP/IKSP), Sasaran Kegiatan (SK/Saskeg), dan Indikator Kinerja Kegiatan (IKK/IKSK) di lingkungan Jaksa Agung Muda Bidang Pembinaan (JAMBIN) sesuai dengan Peraturan Kejaksaan RI No. 4 Tahun 2025 dan pedoman evaluasi pengukuran kinerja SAKIP.

Arsitektur database SICANA mengimplementasikan struktur ini dengan pola *Adjacency List Pattern* menggunakan field `parent_id` untuk menghubungkan relasi dinamis tanpa batas (*Infinite Hierarchy*).

---

## 🪜 PETA HIERARKI TANGGA CASCADING & FORMULA PENGUKURAN

### 🎯 [SP 1] Sasaran Program: Meningkatnya akuntabilitas kinerja Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (Kolaborasi Lintas UKE I)
*   **Target (2025-2029):** Skor 72 -> 73 -> 75 -> 77 -> 80

#### 📊 [IKP 1.1] Indikator Kinerja Program: Nilai SAKIP Kejaksaan RI
*   **Metode Pengukuran:** Nilai Hasil Evaluasi AKIP Kejaksaan RI oleh Kementerian PANRB (Skala 0–100).
*   **Formula Capaian:** 
    $$\text{Capaian IKP 1.1} = \left( \frac{\text{Nilai SAKIP KemenPANRB}}{\text{Target SAKIP Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Hasil Evaluasi (LHE) AKIP Kementerian PANRB.

---

#### 🪜 [SK 1.1.1] Sasaran Kegiatan: Terwujudnya Perencanaan, Pemantauan, Evaluasi, dan Reformasi Birokrasi yang Efektif
*   **Unit Kerja Penanggung Jawab:** Biro Perencanaan

##### 📌 [IKK 1.1.1.1] Persentase layanan reformasi birokrasi sesuai SLA
*   **Pembilang (Numerator):** Jumlah layanan fasilitasi dan koordinasi Reformasi Birokrasi yang selesai tepat waktu sesuai SLA.
*   **Penyebut (Denominator):** Total target layanan atau dokumen Reformasi Birokrasi wajib dalam setahun.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan RB Tepat SLA}}{\text{Total Target Layanan RB}} \right) \times 100\%$$
*   **Sumber Data:** Log Sistem Informasi Reformasi Birokrasi / Biro Perencanaan.

##### 📌 [IKK 1.1.1.2] Persentase satker Kejaksaan RI yang mendapat pendampingan pembangunan zona integritas menuju WBK/WBBM
*   **Pembilang (Numerator):** Jumlah satuan kerja (Kejati/Kejari/Cabjari) yang selesai didampingi dalam pembangunan ZI oleh Tim Kerja Biro Perencanaan.
*   **Penyebut (Denominator):** Total seluruh satuan kerja Kejaksaan RI yang diusulkan dan menjadi target pendampingan pembangunan ZI.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Jumlah Satker Terdampingi ZI}}{\text{Total Satker Target Pendampingan ZI}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Pendampingan ZI Biro Perencanaan.

##### 📌 [IKK 1.1.1.3] Persentase layanan pemantauan dan evaluasi sesuai SLA
*   **Pembilang (Numerator):** Jumlah laporan pemantauan dan evaluasi kinerja yang selesai disusun tepat waktu sesuai SLA.
*   **Penyebut (Denominator):** Total target laporan pemantauan dan evaluasi kinerja wajib (Laporan Triwulanan, Tahunan, LKjIP).
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Laporan Monev Tepat SLA}}{\text{Total Target Laporan Monev Wajib}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Monev Kinerja Triwulanan (Sistem SICANA).

##### 📌 [IKK 1.1.1.4] Persentase layanan pengelolaan data kinerja sesuai SLA
*   **Pembilang (Numerator):** Jumlah permintaan layanan data kinerja dan perencanaan yang diselesaikan tepat waktu sesuai SLA.
*   **Penyebut (Denominator):** Total seluruh berkas permohonan layanan pengelolaan data perencanaan dan kinerja yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Pengelolaan Data Tepat SLA}}{\text{Total Permohonan Layanan Pengelolaan Data Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Log Layanan Data Seksi Kinerja Biro Perencanaan.

---

#### 🪜 [SK 1.1.2] Sasaran Kegiatan: Terwujudnya Evaluasi Akuntabilitas Kinerja Internal Instansi
*   **Unit Kerja Penanggung Jawab:** Biro Perencanaan (Kolaborasi Lintas UKE I)

##### 📌 [IKK 1.1.2.1] Nilai SAKIP UKE I Kejaksaan RI
*   **Pembilang (Numerator):** Jumlah total skor hasil evaluasi SAKIP internal dari seluruh Unit Kerja Eselon I Kejaksaan RI (9 UKE I).
*   **Penyebut (Denominator):** Total jumlah Unit Kerja Eselon I Kejaksaan RI yang dievaluasi (9 Unit).
*   **Formula Perhitungan:**
    $$\text{Capaian Nilai} = \frac{\text{Jumlah Total Skor SAKIP Seluruh UKE I}}{9}$$
*   **Sumber Data:** Laporan Hasil Evaluasi (LHE) AKIP internal tingkat UKE I yang diterbitkan oleh Jaksa Agung Muda Bidang Pengawasan.

##### 📌 [IKK 1.1.2.2] Nilai SAKIP Kejaksaan Tinggi/Kejaksaan Negeri/Cabang Kejaksaan Negeri
*   **Pembilang (Numerator):** Jumlah total skor hasil evaluasi SAKIP internal dari seluruh satuan kerja daerah (Kejati, Kejari, Cabjari) yang diserahkan oleh tim pengawas daerah.
*   **Penyebut (Denominator):** Total jumlah satuan kerja daerah yang dievaluasi kinerjanya.
*   **Formula Perhitungan:**
    $$\text{Rerata Nilai} = \frac{\text{Jumlah Total Skor SAKIP Satker Daerah}}{\text{Total Satker Daerah yang Dievaluasi}}$$
*   **Sumber Data:** LHE SAKIP Satker Daerah dari Bidang Pengawasan Daerah/Pusat.

---

#### 🪜 [SK 1.1.3] Sasaran Kegiatan: Meningkatnya Kualitas Perencanaan Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Biro Perencanaan

##### 📌 [IKK 1.1.3.1] Indeks Perencanaan Pembangunan Nasional (IPPN)
*   **Metode Pengukuran:** Nilai kepatuhan dan kualitas penyusunan dokumen perencanaan pembangunan berdasarkan penilaian Bappenas (Skala 0-100).
*   **Formula Perhitungan:** Menggunakan skor indeks IPPN Kelembagaan yang resmi dirilis oleh Kementerian PPN/Bappenas.
*   **Sumber Data:** Hasil Evaluasi IPPN Tingkat Kelembagaan dari Kementerian PPN/Bappenas.

---

#### 🪜 [SK 1.1.4] Sasaran Kegiatan: Meningkatnya Kualitas Tata Kelola Organisasi Kejaksaan yang Tepat Fungsi
*   **Unit Kerja Penanggung Jawab:** Biro Perencanaan

##### 📌 [IKK 1.1.4.1] Persentase Penyelesaian Restrukturisasi Organisasi
*   **Pembilang (Numerator):** Jumlah draf naskah usulan penataan struktur organisasi baru yang disetujui oleh KemenPAN-RB.
*   **Penyebut (Denominator):** Total target restrukturisasi organisasi Kejaksaan RI yang diamanatkan dalam Renstra untuk tahun berjalan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Usulan Restrukturisasi Disetujui}}{\text{Total Rencana Restrukturisasi Organisasi}} \right) \times 100\%$$
*   **Sumber Data:** Dokumen Usulan Penataan Organisasi Biro Perencanaan.

##### 📌 [IKK 1.1.4.2] Tingkat Realisasi Rencana Aksi RB General Kejaksaan RI
*   **Pembilang (Numerator):** Jumlah program rencana aksi Reformasi Birokrasi (RB) General yang berhasil direalisasikan dan diunggah bukti dukungnya.
*   **Penyebut (Denominator):** Total seluruh target rencana aksi RB General Kejaksaan RI tahun berjalan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Rencana Aksi RB Terealisasi}}{\text{Total Rencana Aksi RB Wajib}} \right) \times 100\%$$
*   **Sumber Data:** Portal Penilaian Mandiri Pelaksanaan Reformasi Birokrasi (PMPRB) KemenPAN-RB.

---

### 🎯 [SP 4] Sasaran Program: Meningkatnya efisiensi dan efektivitas penggunaan anggaran Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)
*   **Target (2025-2029):** Nilai 90 -> 90.25 -> 90.5 -> 90.75 -> 91

#### 📊 [IKP 4.1] Indikator Kinerja Program: Nilai Kinerja Anggaran Kejaksaan RI
*   **Metode Pengukuran:** Skor Kinerja Anggaran Gabungan / IKPA dari Kementerian Keuangan (Aplikasi SMART Kemenkeu & OM-SPAN) skala 0–100.
*   **Formula Capaian:** 
    $$\text{NKA} = (20\% \times \text{Aspek Perencanaan}) + (55\% \times \text{Kesesuaian Pelaksanaan}) + (25\% \times \text{Capaian Output})$$
    $$\text{Capaian IKP 4.1} = \left(\frac{\text{Nilai NKA Aktual Kemenkeu}}{\text{Target Nilai NKA Renstra}}\right) \times 100\%$$
*   **Sumber Data:** Aplikasi Monev Kemenkeu (SMART Kemenkeu & OM-SPAN).

---

#### 🪜 [SK 4.1.1] Sasaran Kegiatan: Meningkatnya efisiensi dan efektivitas Perencanaan dan penggunaan anggaran Kejaksaan UKE I
*   **Unit Kerja Penanggung Jawab:** Biro Keuangan & Biro Perencanaan (Kolaborasi UKE I)

##### 📌 [IKK 4.1.1.1] NKA UKE I
*   **Pembilang (Numerator):** Akumulasi rata-rata Nilai Kinerja Pelaksanaan Anggaran (IKPA) ditambah rata-rata Nilai Kinerja Anggaran (NKPA) dari seluruh Unit Kerja Eselon I.
*   **Penyebut (Denominator):** Target Nilai Kinerja Anggaran Eselon I yang tercantum dalam Perjanjian Kinerja.
*   **Formula Perhitungan:**
    $$\text{Nilai NKA UKE I} = \frac{\text{Rata-rata IKPA UKE I} + \text{Rata-rata NKPA UKE I}}{2}$$
*   **Sumber Data:** Portal Sistem Informasi SMART/Monev Anggaran Kementerian Keuangan.

---

#### 🪜 [SK 4.1.2] Sasaran Kegiatan: Meningkatnya efisiensi dan efektivitas Perencanaan dan penggunaan anggaran di Daerah
*   **Unit Kerja Penanggung Jawab:** Biro Keuangan & Biro Perencanaan (Kolaborasi Satker Vertikal)

##### 📌 [IKK 4.1.2.1] NKA Kejaksaan Tinggi/Kejaksaan Negeri/Cabang Kejaksaan Negeri
*   **Pembilang (Numerator):** Akumulasi rata-rata Nilai Kinerja Pelaksanaan Anggaran (IKPA) ditambah rata-rata Nilai Kinerja Anggaran (NKPA) dari satker daerah (Kejati, Kejari, Cabjari).
*   **Penyebut (Denominator):** Target Nilai Kinerja Anggaran satker daerah tahun berjalan.
*   **Formula Perhitungan:**
    $$\text{Nilai NKA Satker Daerah} = \frac{\text{Nilai IKPA Satker} + \text{Nilai NKPA Satker}}{2}$$
*   **Sumber Data:** Portal Aplikasi OM-SPAN & SAKTI Kemenkeu tingkat Satker Daerah.

---

### 🎯 [SP 5] Sasaran Program: Meningkatnya kualitas tata kelola aset dan pengadaan Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 5.1] Indikator Kinerja Program: Indeks Pengelolaan Aset Kejaksaan RI
*   **Metode Pengukuran:** Skor kualitatif tata kelola aset negara berdasarkan penilaian Kemenkeu (Skala 1.0 - 5.0).
*   **Sumber Data:** Laporan Indeks Pengelolaan Aset (IPA) Kementerian Keuangan.

#### 📊 [IKP 5.2] Indikator Kinerja Program: Indeks Tata Kelola Pengadaan Kejaksaan RI
*   **Metode Pengukuran:** Skor penilaian kematangan Unit Kerja Pengadaan Barang/Jasa (UKPBJ) oleh LKPP (Skala 0-100).
*   **Sumber Data:** Portal ITKP LKPP (Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah).

---

#### 🪜 [SK 5.1.1] Sasaran Kegiatan: Meningkatnya keberhasilan pengelolaan aset UKE I Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Biro Perlengkapan

##### 📌 [IKK 5.1.1.1] Persentase jumlah Barang Milik Negara (BMN) dalam kondisi siap pakai
*   **Pembilang (Numerator):** Jumlah unit BMN (kendaraan fungsional, peralatan teknologi, gedung) yang berada dalam kondisi baik dan rusak ringan layak pakai.
*   **Penyebut (Denominator):** Total unit seluruh BMN Kejaksaan RI yang tercatat dalam daftar inventaris aset.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{BMN Kondisi Siap Pakai}}{\text{Total BMN Terdaftar}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Buku Inventaris Aset dari Aplikasi SIMAN v2 Kementerian Keuangan.

---

#### 🪜 [SK 5.2.1] Sasaran Kegiatan: Meningkatnya kegiatan analisis kebutuhan, penatausahaan BMN, pengadaan barang/jasa, dan pengelolaan BMN
*   **Unit Kerja Penanggung Jawab:** Biro Perlengkapan

##### 📌 [IKK 5.2.1.1] Persentase jumlah satuan kerja yang telah melaksanakan inventarisasi barang milik negara
*   **Pembilang (Numerator):** Jumlah satuan kerja (Pusat & Daerah) yang telah tuntas melaksanakan inventarisasi berkala dan rekonsiliasi aset.
*   **Penyebut (Denominator):** Total seluruh satuan kerja Kejaksaan RI yang tercatat sebagai wajib lapor aset.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Jumlah Satker Selesai Inventarisasi}}{\text{Total Satker Wajib Lapor}} \right) \times 100\%$$
*   **Sumber Data:** Berita Acara Rekonsiliasi BMN Satker dari Aplikasi SIMAN v2.

##### 📌 [IKK 5.2.1.2] Persentase layanan analisis kebutuhan dan penatausahaan barang milik negara sesuai SLA
*   **Pembilang (Numerator):** Jumlah berkas analisis kebutuhan dan penatausahaan BMN yang diselesaikan secara tuntas sesuai batas waktu SLA.
*   **Penyebut (Denominator):** Total seluruh permohonan analisis kebutuhan dan penatausahaan BMN yang diajukan oleh satker.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Penatausahaan Tepat SLA}}{\text{Total Permohonan Penatausahaan Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Log Tiket Penatausahaan Aset Biro Perlengkapan.

##### 📌 [IKK 5.2.1.3] Persentase layanan pengadaan sesuai SLA
*   **Pembilang (Numerator):** Jumlah layanan pengadaan barang/jasa (mulai dari tender hingga penandatanganan kontrak) yang diselesaikan tepat waktu sesuai SLA.
*   **Penyebut (Denominator):** Total seluruh rencana paket pengadaan barang dan jasa wajib tender tahun berjalan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Pengadaan Tepat SLA}}{\text{Total Paket Pengadaan Direncanakan}} \right) \times 100\%$$
*   **Sumber Data:** Sistem Layanan Pengadaan Secara Elektronik (SPSE) Biro Perlengkapan.

##### 📌 [IKK 5.2.1.4] Persentase layanan pengelolaan barang milik negara sesuai SLA
*   **Pembilang (Numerator):** Jumlah penetapan keputusan pengelolaan BMN (PSP, pemindahtanganan, penghapusan) yang selesai diproses tepat SLA.
*   **Penyebut (Denominator):** Total seluruh berkas permohonan pengelolaan BMN yang diajukan oleh satuan kerja.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Pengelolaan BMN Tepat SLA}}{\text{Total Permohonan Pengelolaan BMN Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Aplikasi SIMAN v2 (Modul Pengelolaan).

---

### 🎯 [SP 6] Sasaran Program: Meningkatnya kapasitas kelembagaan dan ketatalaksanaan Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 6.1] Indikator Kinerja Program: Nilai Evaluasi Kelembagaan Kejaksaan RI
*   **Metode Pengukuran:** Skor kematangan tata kelola kelembagaan (tepat ukuran, tepat struktur, tepat proses) oleh KemenPAN-RB (Skala 0-100).
*   **Sumber Data:** Laporan Hasil Evaluasi Tata Kelola Kelembagaan KemenPAN-RB.

#### 📊 [IKP 6.2] Indikator Kinerja Program: Tingkat kepatuhan satuan kerja terhadap standar operasional prosedur
*   **Metode Pengukuran:** Persentase satker yang dinilai mematuhi SOP operasional layanan internal maupun yustisial.
*   **Sumber Data:** Laporan Inspeksi Pemenuhan SOP Kejaksaan RI oleh Jaksa Agung Muda Bidang Pengawasan.

---

#### 🪜 [SK 6.2.1] Sasaran Kegiatan: Meningkatnya kualitas Tata Kelola Organisasi UKE I Kejaksaan yang tepat fungsi
*   **Unit Kerja Penanggung Jawab:** Biro Perencanaan (Kolaborasi UKE I)

##### 📌 [IKK 6.2.1.1] Persentase implementasi RB UKE I berdasarkan Rencana Aksi RB Tematik
*   **Pembilang (Numerator):** Jumlah program rencana aksi Reformasi Birokrasi (RB) Tematik yang berhasil diimplementasikan di masing-masing UKE I.
*   **Penyebut (Denominator):** Total seluruh target rencana aksi RB Tematik nasional yang didelegasikan ke Kejaksaan RI.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Rencana Aksi RB Tematik Terpenuhi}}{\text{Total Rencana Aksi RB Tematik Wajib}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Pelaksanaan RB Tematik Biro Perencanaan.

---

### 🎯 [SP 7] Sasaran Program: Meningkatnya kualitas kebijakan penegakan hukum
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 7.1] Indikator Kinerja Program: Indeks Kualitas Kebijakan Kejaksaan RI
*   **Metode Pengukuran:** Penilaian kualitas formulasi, implementasi, dan evaluasi peraturan Kejaksaan oleh LAN RI (Skala 0-100).
*   **Sumber Data:** Hasil Pengukuran Indeks Kualitas Kebijakan (IKK) oleh Lembaga Administrasi Negara.

#### 📊 [IKP 7.2] Indikator Kinerja Program: Indeks Reformasi Hukum pada Kejaksaan RI
*   **Metode Pengukuran:** Kepatuhan dan kualitas harmonisasi regulasi nasional yang dievaluasi Kemenkumham (Skala 0-100).
*   **Sumber Data:** Laporan Evaluasi Indeks Reformasi Hukum Kejaksaan RI dari Kemenkumham.

---

#### 🪜 [SK 7.1.1] Sasaran Kegiatan: Meningkatnya kegiatan strategi kebijakan penegakan hukum
*   **Unit Kerja Penanggung Jawab:** Pusat Strategi Kebijakan Penegakan Hukum (Pustrajakgakum)

##### 📌 [IKK 7.1.1.1] Persentase layanan program dan evaluasi sesuai SLA
*   **Pembilang (Numerator):** Jumlah penelaahan program strategis penegakan hukum yang diselesaikan tepat waktu sesuai SLA.
*   **Penyebut (Denominator):** Total seluruh usulan penelaahan program dan evaluasi kebijakan penegakan hukum yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Program Selesai Tepat SLA}}{\text{Total Permohonan Layanan Program Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Log Surat Masuk/Keluar Pustrajakgakum.

##### 📌 [IKK 7.1.1.2] Tingkat ketepatan waktu penyampaian laporan penyusunan dan pemberian rekomendasi kebijakan terkait strategi kebijakan penegakan hukum, intelijen pidana, perdata, tata usaha negara, serta politik hukum, pemerintahan dan pembangunan SDM dalam bentuk policy brief atau policy paper
*   **Pembilang (Numerator):** Jumlah laporan rekomendasi kebijakan (*Policy Brief / Policy Paper*) yang disusun dan diserahkan kepada Jaksa Agung tepat waktu.
*   **Penyebut (Denominator):** Total seluruh target draf rekomendasi kebijakan strategis yang diamanatkan dalam rencana kerja tahunan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Policy Paper Tepat Waktu Diserahkan}}{\text{Total Rencana Kerja Policy Paper Wajib}} \right) \times 100\%$$
*   **Sumber Data:** Register Arsip Produk Kebijakan Pustrajakgakum.

##### 📌 [IKK 7.1.1.3] Persentase layanan pengelolaan jurnal ilmiah Kejaksaan (The Prosecutor Law Review) sesuai SLA
*   **Pembilang (Numerator):** Jumlah artikel dan edisi jurnal ilmiah yang berhasil diterbitkan tuntas tepat waktu sesuai SLA.
*   **Penyebut (Denominator):** Total target edisi publikasi jurnal ilmiah tahun berjalan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Edisi Jurnal Terbit Tepat SLA}}{\text{Total Target Publikasi Jurnal}} \right) \times 100\%$$
*   **Sumber Data:** Portal OJS (Open Journal System) *The Prosecutor Law Review*.

##### 📌 [IKK 7.1.1.4] Persentase layanan pembinaan karya tulis ilmiah (makalah) di lingkungan Kejaksaan Agung sesuai SLA
*   **Pembilang (Numerator):** Jumlah bimbingan teknis dan asistensi penulisan karya tulis ilmiah yang diselesaikan tepat SLA.
*   **Penyebut (Denominator):** Total seluruh permohonan pembinaan karya tulis ilmiah yang diajukan oleh pegawai.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Pembinaan Selesai Tepat SLA}}{\text{Total Permohonan Pembinaan Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Log Agenda Kegiatan Pembinaan Pustrajakgakum.

##### 📌 [IKK 7.1.1.5] Persentase layanan penilaian karya tulis ilmiah (makalah) di lingkungan Kejaksaan Agung sesuai SLA
*   **Pembilang (Numerator):** Jumlah berkas karya tulis ilmiah (peserta seleksi/fungsional) yang selesai dinilai tepat SLA.
*   **Penyebut (Denominator):** Total seluruh draf karya tulis ilmiah masuk yang wajib dinilai oleh Tim Penilai.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Penilaian Selesai Tepat SLA}}{\text{Total Draf Karya Tulis Wajib Dinilai}} \right) \times 100\%$$
*   **Sumber Data:** SK Hasil Penilaian Karya Ilmiah Pustrajakgakum.

##### 📌 [IKK 7.1.1.6] Persentase layanan pemantauan dan evaluasi kebijakan strategis di bidang penegakan hukum dalam bentuk perjalanan dinas sesuai SLA
*   **Pembilang (Numerator):** Jumlah perjalanan dinas pemantauan dan evaluasi kebijakan yang terlaksana tuntas sesuai SLA.
*   **Penyebut (Denominator):** Total rencana perjalanan dinas pemantauan/evaluasi kebijakan strategis yang dianggarkan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Giat Monev Terlaksana Tepat SLA}}{\text{Total Rencana Giat Monev Dianggarkan}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Perjalanan Dinas & SPT Pustrajakgakum.

##### 📌 [IKK 7.1.1.7] Persentase layanan survei kepuasan msayarakat terhadap pelayanan publik Kejaksaan RI sesuai SLA
*   **Pembilang (Numerator):** Jumlah laporan survei kepuasan masyarakat skala nasional yang diselesaikan dan dianalisis tepat SLA.
*   **Penyebut (Denominator):** Total target kegiatan survei nasional kepuasan pelayanan publik Kejaksaan RI.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Survei Selesai Tepat SLA}}{\text{Total Rencana Survei Nasional}} \right) \times 100\%$$
*   **Sumber Data:** Dokumen Laporan Survei Kepuasan Nasional Pelayanan Publik Kejaksaan.

---

#### 🪜 [SK 7.2.1] Sasaran Kegiatan: Meningkatnya keberhasilan pernyusunan strategi kebijakan penegakan hukum
*   **Unit Kerja Penanggung Jawab:** Pustrajakgakum

##### 📌 [IKK 7.2.1.1] Persentase Capaian Implementasi Policy Brief untuk Harmonisasi Kebijakan
*   **Pembilang (Numerator):** Jumlah rekomendasi policy brief yang diadopsi/diterjemahkan ke dalam regulasi internal atau eksternal yang sah.
*   **Penyebut (Denominator):** Total draf naskah policy brief yang diterbitkan dan diserahkan kepada pengambil kebijakan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Policy Brief yang Diimplementasikan}}{\text{Total Policy Brief Diterbitkan}} \right) \times 100\%$$
*   **Sumber Data:** Arsip Disposisi Harmonisasi Kebijakan Pustrajakgakum.

---

### 🎯 [SP 8] Sasaran Program: Meningkatnya kuantitas dan kualitas SDM aparatur Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 8.1] Indikator Kinerja Program: Indeks Sistem Merit Kejaksaan RI
*   **Metode Pengukuran:** Skor kematangan penerapan meritokrasi dalam karir kepegawaian oleh KASN / BKN (Skala 0-100).
*   **Sumber Data:** Laporan Hasil Evaluasi Sistem Merit Kejaksaan RI oleh BKN.

#### 📊 [IKP 8.2] Indikator Kinerja Program: Persentase kecukupan, kesesuaian, dan pengembangan SDM Kejaksaan RI
*   **Metode Pengukuran:** Penilaian komposit keselarasan kuantitas dan kualitas SDM dengan kompetensi jabatan (Skala 0-100%).
*   **Sumber Data:** Analisis Kepegawaian Aplikasi MySimkari.

#### 📊 [IKP 8.3] Indikator Kinerja Program: Indeks Profesionalitas SDM Kejaksaan RI
*   **Metode Pengukuran:** Skor pengukuran indeks profesionalitas aparatur sipil negara Kejaksaan berdasarkan BKN (Skala 1.0 - 5.0).
*   **Sumber Data:** Hasil Pengukuran Indeks Profesionalitas ASN (IP-ASN) Kejaksaan RI.

---

#### 🪜 [SK 8.1.1] Sasaran Kegiatan: Meningkatnya Kegiatan Pembinaan dan Pengelolaan Kepegawaian di Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Biro Kepegawaian

##### 📌 [IKK 8.1.1.1] Persentase layanan umum kepegawaian sesuai SLA
*   **Pembilang (Numerator):** Jumlah berkas administrasi umum pegawai (Karis/Karsu, Kartu Pegawai, dll) selesai diproses tepat SLA.
*   **Penyebut (Denominator):** Total seluruh usulan administrasi umum kepegawaian yang diajukan oleh pegawai.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Umum Pegawai Selesai Tepat SLA}}{\text{Total Permohonan Layanan Umum Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Database SIMPEG Aplikasi MySimkari Biro Kepegawaian.

##### 📌 [IKK 8.1.1.2] Persentase layanan pengembangan kepegawaian sesuai SLA
*   **Pembilang (Numerator):** Jumlah berkas tugas belajar, izin belajar, dan ujian penyesuaian yang selesai diproses tepat SLA.
*   **Penyebut (Denominator):** Total seluruh berkas administrasi pengembangan karir pegawai yang diajukan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Pengembangan Selesai Tepat SLA}}{\text{Total Usulan Administrasi Pengembangan Karir}} \right) \times 100\%$$
*   **Sumber Data:** Modul Pengembangan Karir MySimkari.

##### 📌 [IKK 8.1.1.3] Persentase layanan kepangkatan dan mutasi kepegawaian sesuai SLA
*   **Pembilang (Numerator):** Jumlah draf Surat Keputusan (SK) kenaikan pangkat dan nota usul mutasi yang disahkan tepat SLA.
*   **Penyebut (Denominator):** Total seluruh usulan kenaikan pangkat dan mutasi pegawai berkas lengkap yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Pangkat & Mutasi Selesai Tepat SLA}}{\text{Total Usulan Kenaikan Pangkat/Mutasi}} \right) \times 100\%$$
*   **Sumber Data:** Integrasi Sistem MySimkari dan SIASN BKN.

##### 📌 [IKK 8.1.1.4] Persentase layanan pemberhentian dan pensiun sesuai SLA
*   **Pembilang (Numerator):** Jumlah penetapan SK pemberhentian dengan hormat (SK Pensiun) selesai diproses tepat SLA.
*   **Penyebut (Denominator):** Total berkas pensiun pegawai yang mencapai Batas Usia Pensiun (BUP) wajib lapor.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan SK Pensiun Selesai Tepat SLA}}{\text{Total Berkas Pegawai Mencapai BUP}} \right) \times 100\%$$
*   **Sumber Data:** Modul Layanan Pensiun Taspen / MySimkari.

---

#### 🪜 [SK 8.2.1] Sasaran Kegiatan: Meningkatnya kecukupan dan kesesuaian SDM Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Biro Kepegawaian

##### 📌 [IKK 8.2.1.1] Tingkat Kecukupan Personil Jaksa
*   **Pembilang (Numerator):** Jumlah riil personil Jaksa aktif eksisting di seluruh Kejaksaan RI.
*   **Penyebut (Denominator):** Jumlah formasi form ideal kebutuhan Jaksa secara nasional berdasarkan peta jabatan instansi.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Jumlah Jaksa Aktif Eksisting}}{\text{Jumlah Ideal Formasi Jaksa Nasional}} \right) \times 100\%$$
*   **Sumber Data:** Buku Bezetting Pegawai Biro Kepegawaian.

##### 📌 [IKK 8.2.1.2] Tingkat kesesuaian pengelolaan SDM Jaksa
*   **Pembilang (Numerator):** Jumlah instrumen pengelolaan SDM Jaksa (Pola Karir, Penilaian Angka Kredit) yang telah sesuai standar regulasi.
*   **Penyebut (Denominator):** Total seluruh instrumen standar pengelolaan kompetensi Jaksa.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Instrumen Pengelolaan SDM Jaksa Sesuai}}{\text{Total Standar Instrumen Pengelolaan}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Evaluasi Pengelolaan Jabatan Fungsional Jaksa.

##### 📌 [IKK 8.2.1.3] Tingkat kesesuaian kompetensi pegawai terhadap persyaratan kompetensi jabatan
*   **Pembilang (Numerator):** Jumlah pegawai yang memiliki kompetensi aktual sesuai (*matching*) dengan syarat jabatan yang diemban.
*   **Penyebut (Denominator):** Total seluruh pegawai yang telah mengikuti penilaian asesmen profil kompetensi.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Jumlah Pegawai Kompetensi Sesuai}}{\text{Total Pegawai Mengikuti Asesmen}} \right) \times 100\%$$
*   **Sumber Data:** Database Hasil Asesmen Profil Kompetensi MySimkari.

---

#### 🪜 [SK 8.3.1] Sasaran Kegiatan: Meningkatnya kualitas pengelolaan dan pengembangan SDM Kejaksaan RI yang efektif
*   **Unit Kerja Penanggung Jawab:** Biro Kepegawaian (Kolaborasi Badiklat)

##### 📌 [IKK 8.3.1.1] Tingkat Pengembangan Kapasitas personil Jaksa
*   **Pembilang (Numerator):** Jumlah Jaksa yang telah mengikuti diklat teknis atau pengembangan kompetensi minimal 20 JP dalam setahun.
*   **Penyebut (Denominator):** Total keseluruhan jumlah Jaksa aktif eksisting secara nasional.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Jumlah Jaksa Mengikuti Diklat}}{\text{Total Jaksa Aktif Nasional}} \right) \times 100\%$$
*   **Sumber Data:** Register Pendidikan dan Pelatihan MySimkari.

##### 📌 [IKK 8.3.1.2] Persentase SDM Kejaksaan RI yang telah memiliki sertifikat sesuai standar kompetensi
*   **Pembilang (Numerator):** Jumlah pegawai Kejaksaan yang memiliki sertifikat kompetensi keahlian spesifik yang sah.
*   **Penyebut (Denominator):** Total seluruh SDM Kejaksaan RI wajib sertifikasi fungsional keahlian.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Jumlah SDM Bersertifikat Kompetensi}}{\text{Total SDM Wajib Sertifikasi}} \right) \times 100\%$$
*   **Sumber Data:** Bank Data Sertifikat Pegawai Biro Kepegawaian.

---

#### 🪜 [SK 8.5.1] Sasaran Kegiatan: Meningkatnya kualitas ASN Kejaksaan yang berakhlak
*   **Unit Kerja Penanggung Jawab:** Biro Kepegawaian

##### 📌 [IKK 8.5.1.1] Indeks Kepuasan Pegawai terhadap Layanan Manajemen ASN
*   **Pembilang (Numerator):** Akumulasi skor kepuasan dari kuesioner skala Likert responden pegawai internal Kejaksaan.
*   **Penyebut (Denominator):** Total seluruh responden pegawai yang mengisi kuesioner survei.
*   **Formula Perhitungan:** Nilai rata-rata dari seluruh skor kepuasan pegawai internal (Skala 1.0 - 5.0) terhadap layanan pembinaan kepegawaian.
*   **Sumber Data:** Laporan Hasil Survei Kepuasan Manajemen Internal Biro Kepegawaian.

---

### 🎯 [SP 10] Sasaran Program: Meningkatnya kualitas layanan internal dukungan manajemen dan kesehatan yustisial
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 10.1] Indikator Kinerja Program: Indeks kepuasan layanan dukungan internal manajemen Kejaksaan RI
*   **Metode Pengukuran:** Nilai rata-rata kuesioner kepuasan pegawai internal terhadap pelayanan kesekretariatan Eselon I.
*   **Sumber Data:** Laporan Hasil Survei Kepuasan Kesekretariatan Internal Kejaksaan.

#### 📊 [IKP 10.2] Indikator Kinerja Program: Tingkat kepuasan Stakeholder terhadap Rumah Sakit Adhyaksa, Klinik Adhyaksa, dan Fasilitas Kesehatan Yustisial lainnya
*   **Metode Pengukuran:** Nilai rata-rata survei kepuasan pasien/stakeholder terhadap kualitas rumah sakit dan klinik Adhyaksa (Skala 1-5).
*   **Sumber Data:** Laporan Hasil Kuesioner Kepuasan Stakeholder Kesehatan Yustisial.

---

#### 🪜 [SK 10.1.1] Sasaran Kegiatan: Meningkatnya kualitas layanan dukungan manajemen di lingkungan Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Sekretariat JAMBIN (Kolaborasi Inter-UKE I)

##### 📌 [IKK 10.1.1.1] Indeks Kepuasan Pegawai terhadap Layanan dukungan manajemen Satker UKE I
*   **Pengukuran:** Tingkat kepuasan pegawai internal terhadap transparansi dan respons kesekretariatan.
*   **Formula Perhitungan:** Nilai rerata rating kuesioner kepuasan pegawai internal (Skala 1.0 - 5.0).
*   **Sumber Data:** Laporan Hasil Survei Kepuasan Layanan Kesekretariatan Internal.

---

#### 🪜 [SK 10.2.1] Sasaran Kegiatan: Meningkatnya kualitas penyelenggaraan kegiatan kesehatan yustisial
*   **Unit Kerja Penanggung Jawab:** Pusat Kesehatan Yustisial (PKY)

##### 📌 [IKK 10.2.1.1] Persentase pemenuhan target Indikator Nasional Mutu Pelayanan Kesehatan di Rumah Sakit Adhyaksa
*   **Pembilang (Numerator):** Jumlah parameter nasional mutu pelayanan kesehatan di RS Adhyaksa yang memenuhi standar Kementerian Kesehatan.
*   **Penyebut (Denominator):** Total seluruh Indikator Nasional Mutu (INM) Pelayanan Kesehatan wajib dari Kemenkes.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Indikator Mutu RS Terpenuhi}}{\text{Total Indikator Nasional Mutu Wajib}} \right) \times 100\%$$
*   **Sumber Data:** Portal Indikator Mutu RS Adhyaksa / Aplikasi Mutu Kemenkes.

##### 📌 [IKK 10.2.1.2] Tingkat pemahaman para stakeholder terhadap tugas dan fungsi Pusat Kesehatan Yustisial
*   **Pembilang (Numerator):** Jumlah responden stakeholder yustisial (penyidik, JPU, hakim, dll) yang paham peran PKY dalam pembuktian hukum.
*   **Penyebut (Denominator):** Total responden survei yang mengisi kuesioner.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Responden Stakeholder Paham}}{\text{Total Responden Survei PKY}} \right) \times 100\%$$
*   **Sumber Data:** Hasil Survei Pemahaman Stakeholder Yustisial PKY.

##### 📌 [IKK 10.2.1.3] Persentase pemenuhan Hospital Safety Index di Rumah Sakit Adhyaksa
*   **Pembilang (Numerator):** Skor aktual penilaian Hospital Safety Index RS Adhyaksa dari lembaga penilaian kredibel.
*   **Penyebut (Denominator):** Skor ideal maksimal standar keselamatan rumah sakit Kemenkes.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Skor Aktual HSI}}{\text{Skor Ideal HSI Kemenkes}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Penilaian MFK Akreditasi RS Adhyaksa.

##### 📌 [IKK 10.2.1.4] Jumlah kegiatan pelayanan kesehatan yustisial pada Rumah Sakit Adhyaksa, Klinik Adhyaksa, dan Fasilitas Kesehatan Yustisial lainnya
*   **Pengukuran:** Jumlah kuantitatif dari tindakan kesehatan yustisial (Visum et repertum, autopsi, perawatan kesehatan tahanan yustisial).
*   **Formula Perhitungan:** Akumulasi tindakan pelayanan kesehatan yustisial yang tercatat (Angka mutlak).
*   **Sumber Data:** Berkas Register Tindakan Medis SIMRS Adhyaksa.

---

### 🎯 [SP 13] Sasaran Program: Meningkatnya Kualitas Layanan Hukum dan Hubungan Luar Negeri
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 13.1] Indikator Kinerja Program: Indeks kepuasan satker Kejaksaan atas layanan hukum
*   **Metode Pengukuran:** Nilai kepuasan dari kuesioner evaluasi layanan harmonisasi draf peraturan internal oleh Biro Hukum (Skala 1-5).
*   **Sumber Data:** Laporan Hasil Evaluasi Pelayanan Hukum Biro Hukum & HLN.

#### 📊 [IKP 13.2] Indikator Kinerja Program: Indeks kepuasan institusi mitra luar negeri terhadap kualitas kerja sama kelembagaan Kejaksaan RI
*   **Metode Pengukuran:** Survei kepuasan mitra kelembagaan asing atas kualitas pelaksanaan MLA/Ekstradisi.
*   **Sumber Data:** Dokumen Lembar Umpan Balik (Feedback Sheet) dari Mitra Asing.

---

#### 🪜 [SK 13.1.1] Sasaran Kegiatan: Meningkatnya kualitas layanan harmonitasi regulasi dan hubungan luar negeri Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Biro Hukum dan Hubungan Luar Negeri

##### 📌 [IKK 13.1.1.1] Persentase regulasi yang berhasil ditetapkan/disahkan
*   **Pembilang (Numerator):** Jumlah draf rancangan regulasi internal Kejaksaan (Perja/Pedoman/Instruksi) yang tuntas diharmonisasi dan resmi diundangkan.
*   **Penyebut (Denominator):** Total seluruh rancangan usulan regulasi yang masuk ke Biro Hukum dan Hubungan Luar Negeri.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Rancangan Regulasi Resmi Disahkan}}{\text{Total Usulan Regulasi Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Portal Jaringan Dokumentasi dan Informasi Hukum (JDIH) Kejaksaan RI.

##### 📌 [IKK 13.1.1.2] Persentase keberhasilan terjalinnya kerjasama internasional dan antar lembaga
*   **Pembilang (Numerator):** Jumlah naskah perjanjian kerja sama (MoU/Letter of Intent) yang resmi disepakati dan ditandatangani.
*   **Penyebut (Denominator):** Total usulan inisiasi rencana kerja sama internasional dan nasional yang diajukan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Naskah Kerja Sama Resmi Ditandatangani}}{\text{Total Rencana Kerja Sama yang Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Dokumen Register Perjanjian Kerja Sama Biro Hukum & HLN.

---

#### 🪜 [SK 13.2.1] Sasaran Kegiatan: Meningkatnya pelaksanaan kegiatan pelayanan penyusunan rancangan peraturan perundang-undangan, pertimbangan hukum, kerja sama dan hubungan luar negeri
*   **Unit Kerja Penanggung Jawab:** Biro Hukum dan Hubungan Luar Negeri

##### 📌 [IKK 13.2.1.1] Persentase layanan penelaahan, perancangan perundang-undangan dan pertimbangan hukum sesuai SLA
*   **Pembilang (Numerator):** Jumlah rancangan regulasi yang selesai ditelaah secara yuridis tepat waktu sesuai SLA.
*   **Penyebut (Denominator):** Total seluruh berkas permohonan penelaahan perundang-undangan yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Penelaahan Selesai Tepat SLA}}{\text{Total Permohonan Penelaahan Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Log Persuratan Masuk/Keluar Seksi Penelaahan Biro Hukum.

##### 📌 [IKK 13.2.1.2] Persentase layanan kerja sama hukum dan hubungan luar negeri sesuai SLA
*   **Pembilang (Numerator):** Jumlah dokumen administrasi kerja sama dan fasilitasi delegasi luar negeri selesai diproses tepat SLA.
*   **Penyebut (Denominator):** Total berkas permohonan kerja sama dan hubungan luar negeri yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Kerja Sama Selesai Tepat SLA}}{\text{Total Berkas Kerja Sama Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Kerja Sama Biro Hukum & HLN.

##### 📌 [IKK 13.2.1.3] Persentase layanan perpustakaan dan dokumentasi hukum sesuai SLA
*   **Pembilang (Numerator):** Jumlah transaksi layanan pencarian katalog buku, dokumentasi hukum, dan pinjaman perpustakaan dilayani tepat SLA.
*   **Penyebut (Denominator):** Total seluruh transaksi/kunjungan ke perpustakaan Kejaksaan RI.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Perpustakaan Terpenuhi Tepat SLA}}{\text{Total Transaksi Layanan Perpustakaan}} \right) \times 100\%$$
*   **Sumber Data:** Log Pengunjung Digital Perpustakaan Kejaksaan Agung.

##### 📌 [IKK 13.2.1.4] Persentase layanan hukum pada perwakilan Kejaksaan RI di luar negeri sesuai SLA
*   **Pembilang (Numerator):** Jumlah pemberian bantuan hukum dan koordinasi MLA transnasional oleh atase Kejaksaan selesai tepat SLA.
*   **Penyebut (Denominator):** Total berkas sengketa hukum transnasional yang didelegasikan penanganannya.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Hukum Atase Selesai Tepat SLA}}{\text{Total Berkas Hukum Delegasi}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Kerja Atase Kejaksaan KBRI Luar Negeri.

##### 📌 [IKK 13.2.1.5] Persentase layanan perkantoran perwakilan Kejaksaan RI di luar negeri sesuai SLA
*   **Pembilang (Numerator):** Jumlah urusan administrasi kesekretariatan atase Kejaksaan yang difasilitasi tuntas tepat SLA.
*   **Penyebut (Denominator):** Total target berkas administrasi rumah tangga atase Kejaksaan luar negeri.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Perkantoran Atase Tepat SLA}}{\text{Total Berkas Administrasi Atase}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Kinerja Bulanan Atase Kejaksaan.

---

### 🎯 [SP 15] Sasaran Program: Meningkatnya efektivitas pelaksanaan tugas dan fungsi Kejaksaan berbasis TI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 15.1] Indikator Kinerja Program: Persentase digitalisasi proses bisnis inti Kejaksaan RI
*   **Metode Pengukuran:** Penilaian tingkat maturitas penerapan teknologi informasi (Sistem Kertas Tanpa Dokumen/Paperless) pada tugas operasional yustisial.
*   **Sumber Data:** Hasil Audit Maturitas TI Pusdaskrimti.

---

#### 🪜 [SK 15.1.1] Sasaran Kegiatan: Meningkatnya kegiatan pengelolaan data, statistik kriminal serta penerapan dan pengembangan teknologi informasi
*   **Unit Kerja Penanggung Jawab:** Pusat Data Statistik Kriminal dan Teknologi Informasi (Pusdaskrimti)

##### 📌 [IKK 15.1.1.1] Persentase layanan pengelolaan data dan statistik kriminal
*   **Pembilang (Numerator):** Jumlah berkas rilis statistik kriminal nasional yang dipublikasikan tuntas tepat waktu.
*   **Penyebut (Denominator):** Total target publikasi statistik kriminal berkala wajib (Bulanan, Semesteran, Tahunan) di portal Satu Data.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Rilis Statistik Kriminal Tepat Waktu}}{\text{Total Publikasi Statistik Kriminal Wajib}} \right) \times 100\%$$
*   **Sumber Data:** Pangkalan Data Statistik Kriminal Pusdaskrimti.

##### 📌 [IKK 15.1.1.2] Persentase layanan penerapan dan pengembangan teknologi informasi sesuai SLA
*   **Pembilang (Numerator):** Jumlah permohonan pengembangan sistem informasi (fitur SICANA, portal, email, dll) yang tuntas dikembangkan tepat SLA.
*   **Penyebut (Denominator):** Total seluruh tiket usulan pengembangan teknologi informasi satker yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Pengembangan TI Selesai Tepat SLA}}{\text{Total Tiket Pengembangan TI Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Log Tiket Helpdesk TI Pusdaskrimti.

##### 📌 [IKK 15.1.1.3] Persentase layanan perkantoran sesuai SLA
*   **Pembilang (Numerator):** Jumlah unit komputer dinas, konektivitas internet, dan lisensi software pendukung administrasi yang dipelihara tepat SLA.
*   **Penyebut (Denominator):** Total target pemeliharaan sarana administrasi komputer perkantoran.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Sarana TI Dipelihara Tepat SLA}}{\text{Total Target Pemeliharaan Sarana TI}} \right) \times 100\%$$
*   **Sumber Data:** Log Pemeliharaan Infrastruktur TI Pusdaskrimti.

---

#### 🪜 [SK 15.2.1] Sasaran Kegiatan: Meningkatnya pengembangan dan pemanfaatan Sistem Teknologi Informasi Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Pusdaskrimti

##### 📌 [IKK 15.2.1.1] Persentase Satuan Kerja yang Menggunakan CMS dalam rangka Implementasi SPPT-TI
*   **Pembilang (Numerator):** Jumlah satuan kerja (Kejati, Kejari, Cabjari) yang tercatat aktif melakukan input dokumen perkara secara konsisten pada CMS.
*   **Penyebut (Denominator):** Total seluruh satuan kerja Kejaksaan RI wajib menggunakan CMS (538 satker).
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Satker Aktif Menggunakan CMS}}{\text{Total Satker Kejaksaan Wajib CMS (538)}} \right) \times 100\%$$
*   **Sumber Data:** Log Server Transaksi Database Terpusat Aplikasi CMS.

##### 📌 [IKK 15.2.1.2] Indeks Pemerintah Digital
*   **Metode Pengukuran:** Nilai kematangan implementasi e-government dan arsitektur SPBE instansi Kejaksaan oleh KemenPAN-RB (Skala 1.0 - 5.0).
*   **Sumber Data:** Laporan Hasil Evaluasi Indeks SPBE Nasional KemenPAN-RB.

---

#### 🪜 [SK 15.3.1] Sasaran Kegiatan: Meningkatnya kualitas data Statistik Kriminal Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Pusdaskrimti

##### 📌 [IKK 15.3.1.1] Indeks kualitas data Kejaksaan RI
*   **Pengukuran:** Penilaian kualitas keandalan, kesahihan, dan kemutakhiran satu data Kejaksaan.
*   **Sumber Data:** Hasil Audit Penyelenggaraan Evaluasi Kualitas Data BPS Sektoral.

##### 📌 [IKK 15.3.1.2] Indeks penyelenggaraan statistik sektoral
*   **Pengukuran:** Nilai kematangan statistik sektoral Kejaksaan (Skala 1-5) oleh BPS.
*   **Sumber Data:** Laporan Hasil Penilaian IPS Kejaksaan RI dari BPS.

##### 📌 [IKK 15.3.1.3] Persentase satuan kerja yang telah menerapkan SPPT-TI dengan kualitas data yang berhasil dipertukarkan dengan Lembaga Penegak Hukum (LPH) lainnya terhadap data shahih sebesar minimal 70%
*   **Pembilang (Numerator):** Jumlah satuan kerja yang kualitas data perkara di CMS berhasil dipertukarkan secara shahih (>70%) di Puskarda SPPT-TI.
*   **Penyebut (Denominator):** Total seluruh satuan kerja Kejaksaan RI yang dihubungkan dengan SPPT-TI.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Satker Berhasil Pertukaran Data Shahih}}{\text{Total Satker Terhubung SPPT-TI}} \right) \times 100\%$$
*   **Sumber Data:** Dashboard Integrasi SPPT-TI Kemenko Polhukam / Pusdaskrimti.

##### 📌 [IKK 15.3.1.4] Tingkat keberhasilan penyelenggaraan tata kelola sistem Satu Data Kejaksaan
*   **Pembilang (Numerator):** Jumlah kluster database yustisial (Pidum, Pidsus, Datun, Pidmil) dan manajerial (MySimkari, SAKTI) yang berhasil disinkronkan ke dalam *Data Warehouse* terpusat.
*   **Penyebut (Denominator):** Total seluruh kluster sistem data mandiri yang eksis di lingkungan Kejaksaan RI.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Kluster Database Terintegrasi}}{\text{Total Kluster Database Eksisting}} \right) \times 100\%$$
*   **Sumber Data:** Log Sinkronisasi Puskarda Pusdaskrimti.

---

#### 🪜 [SK 15.4.1] Sasaran Kegiatan: Meningkatnya keamanan Sistem Teknologi Informasi Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Pusdaskrimti

##### 📌 [IKK 15.4.1.1] Indeks Kematangan Keamanan Siber Kejaksaan RI
*   **Metode Pengukuran:** Skor evaluasi kematangan CSIRT (Cyber Security Incident Response Team) Kejaksaan oleh BSSN (Skala 1.0 - 5.0).
*   **Sumber Data:** Laporan Hasil Audit Kematangan Keamanan Informasi (CSM) BSSN.

---

#### 🪜 [SK 15.5.1] Sasaran Kegiatan: Meningkatnya kualitas tata kelola administrasi penanganan perkara berbasis teknologi informasi
*   **Unit Kerja Penanggung Jawab:** Pusdaskrimti

##### 📌 [IKK 15.5.1.1] Indeks kepuasan pengguna internal terhadap sistem administrasi perkara berbasis TI
*   **Pembilang (Numerator):** Akumulasi skor kepuasan dari kuesioner skala Likert responden operator CMS satker.
*   **Penyebut (Denominator):** Total jumlah operator CMS satker responden survei.
*   **Formula Perhitungan:** Nilai rata-rata dari seluruh skor kepuasan operator (Skala 1.0 - 5.0).
*   **Sumber Data:** Laporan Evaluasi Kepuasan Pengguna CMS Pusdaskrimti.

---

### 🎯 [SP 16] Sasaran Program: Meningkatnya kuantitas dan kualitas sarana dan prasarana yang mendukung Kinerja Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 16.1] Indikator Kinerja Program: Tingkat utilisasi sarana dan prasarana Kejaksaan RI
*   **Metode Pengukuran:** Persentase pemanfaatan aset sarpras operasional dalam kondisi prima (Skala 0-100%).
*   **Sumber Data:** Buku Inventaris Sarpras Biro Perlengkapan / Aplikasi SIMAN v2.

---

#### 🪜 [SK 16.1.1] Sasaran Kegiatan: Meningkatnya jumlah gedung kantor, rumah negara, kendaraan jabatan, operasional, dan fungsional, perangkat pengolah data dan komunikasi, perlengkapan dan fasilitas perkantoran yang memadai
*   **Unit Kerja Penanggung Jawab:** Biro Perlengkapan (Kolaborasi Pengadaan)

##### 📌 [IKK 16.1.1.1] Persentase gedung kantor yang direhabilitasi
*   **Pembilang (Numerator):** Jumlah gedung kantor Kejaksaan Agung/Daerah selesai direnovasi fisik.
*   **Penyebut (Denominator):** Total target gedung kantor Kejaksaan yang direncanakan renovasi dalam DIPA/RKAKL.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Gedung Kantor Selesai Direnovasi}}{\text{Total Target Gedung Direncanakan Renovasi}} \right) \times 100\%$$
*   **Sumber Data:** Berita Acara Serah Terima (BAST) Pekerjaan Fisik & SIMAN.

##### 📌 [IKK 16.1.1.2] Persentase rumah negara yang direhabilitasi
*   **Pembilang (Numerator):** Jumlah unit rumah dinas Kejaksaan Agung/Daerah selesai direnovasi fisik.
*   **Penyebut (Denominator):** Total target unit rumah dinas Kejaksaan yang dianggarkan renovasi dalam DIPA.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Rumah Dinas Selesai Direnovasi}}{\text{Total Target Rumah Dinas Direncanakan Renovasi}} \right) \times 100\%$$
*   **Sumber Data:** Berita Acara Serah Terima (BAST) Pekerjaan Fisik & SIMAN.

##### 📌 [IKK 16.1.1.3] Persentase pembangunan gedung kantor satuan kerja yang baru
*   **Pembilang (Numerator):** Jumlah gedung kantor satker baru (Kejari baru/Cabjari naik tingkat) yang selesai dibangun fisiknya.
*   **Penyebut (Denominator):** Total target pembangunan gedung kantor baru yang dianggarkan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Gedung Kantor Selesai Dibangun}}{\text{Total Rencana Gedung Kantor Baru}} \right) \times 100\%$$
*   **Sumber Data:** Dokumen BAST Fisik Gedung Baru.

##### 📌 [IKK 16.1.1.4] Persentase pembangunan rumah negara baru
*   **Pembilang (Numerator):** Jumlah unit rumah dinas baru selesai dibangun fisiknya.
*   **Penyebut (Denominator):** Total target unit pembangunan rumah dinas baru yang direncanakan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Rumah Dinas Selesai Dibangun}}{\text{Total Rencana Rumah Dinas Baru}} \right) \times 100\%$$
*   **Sumber Data:** Dokumen BAST Fisik Rumah Dinas Baru.

##### 📌 [IKK 16.1.1.5] Persentase pengadaan mobil jabatan dan operasional
*   **Pembilang (Numerator):** Jumlah unit mobil dinas jabatan/operasional selesai diadakan dan diserahterimakan.
*   **Penyebut (Denominator):** Total target unit mobil dinas jabatan/operasional yang dianggarkan diadakan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Mobil Dinas Selesai Diadakan}}{\text{Total Target Pengadaan Mobil Dinas}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Buku Inventaris SIMAN.

##### 📌 [IKK 16.1.1.6] Persentase pengadaan mobil tahanan dan mobil fungsional lainnya
*   **Pembilang (Numerator):** Jumlah unit mobil tahanan dan fungsional (mobil barang bukti, mobil luhkum) selesai diadakan.
*   **Penyebut (Denominator):** Total target unit mobil tahanan dan fungsional yang direncanakan diadakan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Mobil Tahanan/Fungsional Selesai Diadakan}}{\text{Total Target Pengadaan Tahanan/Fungsional}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Buku Inventaris SIMAN.

##### 📌 [IKK 16.1.1.7] Persentase pengadaan sepeda motor dinas
*   **Pembilang (Numerator):** Jumlah unit sepeda motor dinas selesai diadakan dan tercatat dalam SIMAN.
*   **Penyebut (Denominator):** Total target unit sepeda motor dinas yang direncanakan diadakan dalam DIPA.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Sepeda Motor Dinas Selesai Diadakan}}{\text{Total Target Pengadaan Sepeda Motor}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Buku Inventaris SIMAN.

##### 📌 [IKK 16.1.1.8] Persentase pengadaan perangkat pengolah data dan komunikasi
*   **Pembilang (Numerator):** Jumlah set komputer, laptop, scanner, dan server yang selesai diadakan dan didistribusikan.
*   **Penyebut (Denominator):** Total target set perangkat pengolah data dan komunikasi yang direncanakan diadakan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Perangkat IT Selesai Diadakan}}{\text{Total Target Pengadaan Perangkat IT}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Buku Inventaris SIMAN.

##### 📌 [IKK 16.1.1.9] Persentase pengadaan perlengkapan dan fasilitas perkantoran
*   **Pembilang (Numerator):** Jumlah unit perlengkapan kantor (AC, genset, meubelair) selesai diadakan dan tercatat.
*   **Penyebut (Denominator):** Total target unit perlengkapan perkantoran yang dianggarkan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Fasilitas Kantor Selesai Diadakan}}{\text{Total Target Pengadaan Fasilitas}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Buku Inventaris SIMAN.

##### 📌 [IKK 16.1.1.10] Persentase terpenuhi sarana/prasarana intelijen dan penegakan hukum
*   **Pembilang (Numerator):** Jumlah unit sarana taktis intelijen (alat sadap, rompi tahanan, borgol) selesai diadakan.
*   **Penyebut (Denominator):** Total kebutuhan ideal unit sarana taktis intelijen dan penegakan hukum berdasarkan standar minimum.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Sarpras Taktis Selesai Diadakan}}{\text{Total Kebutuhan Ideal Sarpras Taktis}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Inventaris Sarpras Biro Perlengkapan / SIMAN.

---

#### 🪜 [SK 16.2.1] Sasaran Kegiatan: Meningkatnya kegiatan pelayanan ketatausahaan Jaksa Agung, Wakil Jaksa Agung, Staf Ahli, tata usaha pimpinan, Protokol dan Keamanan Pimpinan, Keamanan, tata usaha dan kearsipan, sarana prasarana dan Rumah Tangga
*   **Unit Kerja Penanggung Jawab:** Biro Umum

##### 📌 [IKK 16.2.1.1] Persentase layanan tata usaha pimpinan sesuai SLA
*   **Pembilang (Numerator):** Jumlah agenda persuratan, disposisi, dan registrasi pimpinan yang diselesaikan tepat SLA.
*   **Penyebut (Denominator):** Total berkas permohonan layanan tata usaha pimpinan yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan TU Pimpinan Selesai Tepat SLA}}{\text{Total Berkas TU Pimpinan Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Log Registrasi Surat Masuk pimpinan Biro Umum.

##### 📌 [IKK 16.2.1.2] Persentase layanan protokol dan pengamanan pimpinan sesuai SLA
*   **Pembilang (Numerator):** Jumlah kegiatan pendampingan dan keprotokolan pimpinan yang terlaksana tuntas tanpa AGHT (Ancaman, Gangguan, Hambatan, Tantangan) sesuai SLA.
*   **Penyebut (Denominator):** Total agenda kunjungan/kegiatan resmi pimpinan yang diajukan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Dukungan Protokol Sukses Terlaksana}}{\text{Total Agenda Resmi Pimpinan}} \right) \times 100\%$$
*   **Sumber Data:** Log Agenda Keprotokolan Biro Umum.

##### 📌 [IKK 16.2.1.3] Persentase layanan keamanan dalam sesuai SLA
*   **Pembilang (Numerator):** Jumlah hari penanganan patroli keamanan dalam kompleks kantor Kejagung selesai aman tanpa insiden sesuai SLA.
*   **Penyebut (Denominator):** Total jumlah hari dalam periode pelaporan (365 hari).
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Hari Aman Tanpa Insiden}}{\text{Total Hari Kalender}} \right) \times 100\%$$
*   **Sumber Data:** Log Laporan Harian Kamdal Kejaksaan Agung.

##### 📌 [IKK 16.2.1.4] Persentase layanan tata usaha dan kearsipan sesuai SLA
*   **Pembilang (Numerator):** Jumlah dokumen persuratan dan berkas arsip yang dikelola (disortir, disimpan, didistribusikan) tepat SLA.
*   **Penyebut (Denominator):** Total seluruh berkas persuratan dinas masuk dan keluar wajib kelola.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Surat & Arsip Tepat SLA}}{\text{Total Berkas Surat & Arsip Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Aplikasi Persuratan Digital (Srikandi / Internal).

##### 📌 [IKK 16.2.1.5] Persentase layanan prasarana sarana, dan rumah tangga sesuai SLA
*   **Pembilang (Numerator):** Jumlah pengajuan perbaikan fasilitas, konsumsi, dan perawatan rumah tangga gedung perkantoran selesai tepat SLA.
*   **Penyebut (Denominator):** Total seluruh usulan layanan prasarana sarana dan rumah tangga yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan RT Selesai Tepat SLA}}{\text{Total Permohonan Layanan RT Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Sistem Layanan Rumah Tangga / Biro Umum.

---

### 💼 DATA TRANSAKSIONAL TAMBAHAN: UNIT KERJA BIRO KEUANGAN (NON-IKP RENSTRA)
*Berikut adalah Sasaran Kegiatan dan IKK spesifik pelayanan fungsional Biro Keuangan yang ditarik dari Peta LKjIP 2026.*

#### 🪜 [SK_FIN_1] Sasaran Kegiatan: Meningkatnya kegiatan pembinaan pengelolaan keuangan Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Biro Keuangan

##### 📌 [IKK_FIN_1.1] Persentase layanan perbendaharaan sesuai SLA
*   **Pembilang (Numerator):** Jumlah berkas SPP/SPM yang diselesaikan tuntas tepat SLA.
*   **Penyebut (Denominator):** Total seluruh berkas permohonan pembayaran yang diajukan satker.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Berkas SPP/SPM Selesai Tepat SLA}}{\text{Total Usulan Pembayaran yang Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Aplikasi SAKTI Kemenkeu (Modul Pembayaran).

##### 📌 [IKK_FIN_1.2] Persentase layanan pendapatan dan piutang negara sesuai SLA
*   **Pembilang (Numerator):** Jumlah draf penetapan piutang tuntutan ganti rugi (TGR) / denda yustisial yang tuntas diproses sesuai SLA.
*   **Penyebut (Denominator):** Total permohonan penatausahaan pendapatan/piutang yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Piutang Selesai Tepat SLA}}{\text{Total Permohonan Layanan Piutang}} \right) \times 100\%$$
*   **Sumber Data:** Sistem Informasi Manajemen Pendapatan & Piutang Biro Keuangan.

##### 📌 [IKK_FIN_1.3] Jumlah laporan pelaksanaan kegiatan penggunaan anggaran PNBP sesuai SLA
*   **Pembilang (Numerator):** Jumlah dokumen laporan realisasi penggunaan PNBP sektoral yang diselesaikan tepat SLA.
*   **Penyebut (Denominator):** Total laporan wajib bulanan/triwulanan PNBP yang harus diserahkan ke Kemenkeu.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Laporan PNBP Selesai Tepat SLA}}{\text{Total Target Laporan PNBP Wajib}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Realisasi PNBP Seksi Pendapatan Biro Keuangan.

##### 📌 [IKK_FIN_1.4] Persentase layanan akuntansi dan pelaporan keuangan sesuai SLA
*   **Pembilang (Numerator):** Jumlah draf laporan keuangan UAPA tingkat kementerian/lembaga yang selesai disusun tepat SLA.
*   **Penyebut (Denominator):** Total laporan keuangan wajib periodik (Triwulanan, Tahunan).
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Laporan Keuangan Selesai Tepat SLA}}{\text{Total Target Laporan Keuangan Periodik}} \right) \times 100\%$$
*   **Sumber Data:** Portal Aplikasi SAKTI (Modul GL & Pelaporan).

##### 📌 [IKK_FIN_1.5] Persentase layanan umum keuangan sesuai SLA
*   **Pembilang (Numerator):** Jumlah fasilitasi administrasi keuangan umum (gaji, tunjangan kinerja, perjalanan dinas pimpinan) selesai diproses tepat SLA.
*   **Penyebut (Denominator):** Total seluruh berkas usulan administrasi keuangan umum yang masuk.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Layanan Keuangan Umum Tepat SLA}}{\text{Total Permohonan Keuangan Umum Masuk}} \right) \times 100\%$$
*   **Sumber Data:** Log Registrasi Persuratan Biro Keuangan.

##### 📌 [IKK_FIN_1.6] Persentase layanan perkantoran keuangan sesuai SLA
*   **Pembilang (Numerator):** Jumlah dukungan operasional kantor Biro Keuangan (pemeliharaan ATK, pembayaran listrik, langganan daya) selesai tepat SLA.
*   **Penyebut (Denominator):** Total target program pemeliharaan perkantoran keuangan.
*   **Formula Perhitungan:**
    $$P = \left( \frac{\text{Dukungan Perkantoran Keuangan Tepat SLA}}{\text{Total Target Pemeliharaan}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Realisasi Belanja Biro Keuangan.

---

#### 🪜 [SK_FIN_2] Sasaran Kegiatan: Meningkatnya Akuntabilitas Keuangan Kejaksaan RI
*   **Unit Kerja Penanggung Jawab:** Biro Keuangan

##### 📌 [IKK_FIN_2.1] Nilai Kualitas Pelaporan Keuangan Unit Akuntansi Pengguna Anggaran (UAPA) Kejaksaan RI
*   **Pengukuran:** Nilai kepatuhan format, ketepatan rekonsiliasi, dan keandalan draf laporan keuangan kementerian oleh Kemenkeu (Skala 0-100).
*   **Sumber Data:** Sertifikat Nilai Kualitas Pelaporan Keuangan UAPA dari Ditjen Perbendaharaan Kemenkeu.

---

## 💻 CATATAN ARSITEKTURAL BACKEND LARAVEL

SICANA mengimplementasikan cetak biru pohon di atas dengan model tabel relational yang kokoh:
1.  **Tabel Master `indikators`:** Menyimpan parameter SP, IKP, SK, dan IKK dalam satu tabel (*Adjacency List Pattern*) dengan relasi `parent_id` ke tabel dirinya sendiri. Kolom `tipe` (ROOT, STRATEGIS, PROGRAM, KEGIATAN, INDIKATOR) menentukan jenis node kueri.
2.  **Tabel Transaksi `pengukurans`:** Menyimpan target dan realisasi berkala satker pusat/daerah, diamankan oleh *Composite Unique Index* `UNIQUE(satker_id, indikator_id, tahun, triwulan)` guna mencegah kebocoran *double entry* data capaian.
3.  **Recursive bottom-up rollup:** Logic calculation engine diletakkan pada Service Class `IkssCalculationEngine.php` yang secara rekursif menelusuri data isian dari level IKK paling dasar (*leaf node*), merata-ratakan atau memformulasikannya sesuai jenis gerbang kalkulasi, hingga naik mencapai skor capaian puncak di Sasaran Program.

---
