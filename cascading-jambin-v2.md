---
name: cascading_jambin_v2
version: 2.0
status: LEGACY_REFERENCE
runtime_authority: false
superseded_by: cascading-jambin-v3-canonical.md
---

# Cetak Biru Cascading SAKIP & Renstra Kejaksaan RI 2025-2029
## Restrukturisasi v2 — LEGACY REFERENCE

> **DEPRECATED FOR RUNTIME**
>
> Dokumen ini dipertahankan sebagai referensi historis untuk:
> - nomenklatur SP, IKP, SK, IKK;
> - pemetaan unit pengampu;
> - deskripsi indikator;
> - formula/detail operasional yang belum seluruhnya dipindahkan.
>
> Dokumen ini **tidak lagi menjadi source of truth untuk calculation behavior aplikasi**.
>
> Untuk implementasi Laravel, React, seeder, calculation engine, input schema, dan testing, gunakan:
>
> `cascading-jambin-v3-canonical.md`
>
> Jika terjadi konflik antara v2 dan v3, maka **v3 yang berlaku**.
# Cetak Biru Cascading SAKIP & Renstra Kejaksaan RI 2025-2029 (Restrukturisasi v2)
## Bidang Pengampuan: Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

Dokumen ini merupakan hasil restrukturisasi penjenjangan kinerja (*cascading structure*) di lingkungan Jaksa Agung Muda Bidang Pembinaan (JAMBIN) sesuai dengan Peraturan Kejaksaan RI No. 4 Tahun 2025. 

Pada versi ini, dilakukan pemisahan tegas antara:
1.  **IKP Agregatif (Roll-Up):** Indikator Kinerja Program yang memiliki silsilah Sasaran Kegiatan (SK) dan Indikator Kinerja Kegiatan (IKK) di bawahnya. Nilai capaian dihitung secara rekursif dari bawah ke atas (*bottom-up*).
2.  **IKP Mandiri (Leaf Node):** Indikator Kinerja Program yang **berhenti di level IKP saja** karena merupakan nilai indeks/skor hasil evaluasi eksternal atau instansi pembina pusat. Untuk indikator jenis ini, **tidak ada SK dan IKK di bawahnya**, sehingga sistem memperlakukannya sebagai *Leaf Node* tempat *input kasar* (Direct Value) dilakukan, dan cascading ditulis apa adanya sampai dengan rumus IKP-nya saja.

---

## 🪜 PETA HIERARKI TANGGA CASCADING & FORMULA PENGUKURAN

### 🎯 [SP 1] Sasaran Program: Meningkatnya akuntabilitas kinerja Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (Kolaborasi Lintas UKE I)
*   **Target (2025-2029):** Skor 72 -> 73 -> 75 -> 77 -> 80

#### 📊 [IKP 1.1] Indikator Kinerja Program: Nilai SAKIP Kejaksaan RI
*   **Sifat Node:** Agregatif (Roll-up dari SK di bawahnya)
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
*   **Sifat Node:** Agregatif (Roll-up dari SK di bawahnya)
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
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Skor kualitatif tata kelola aset negara berdasarkan penilaian Kemenkeu (Skala 1.0 - 5.0).
*   **Formula Capaian:** 
    $$\text{Capaian IKP 5.1} = \left( \frac{\text{Indeks Pengelolaan Aset (IPA) Aktual}}{\text{Target Indeks Pengelolaan Aset Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Indeks Pengelolaan Aset (IPA) Kementerian Keuangan.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Nilai diinput langsung (Direct Input) oleh operator Biro Perlengkapan sesuai rilis Kementerian Keuangan.

#### 📊 [IKP 5.2] Indikator Kinerja Program: Indeks Tata Kelola Pengadaan Kejaksaan RI
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Skor penilaian kematangan Unit Kerja Pengadaan Barang/Jasa (UKPBJ) oleh LKPP (Skala 0-100).
*   **Formula Capaian:**
    $$\text{Capaian IKP 5.2} = \left( \frac{\text{Indeks Tata Kelola Pengadaan (ITKP) Aktual}}{\text{Target ITKP Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Portal ITKP LKPP.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Nilai diinput langsung (Direct Input) oleh operator Biro Perlengkapan berdasarkan rilis LKPP.

---

### 🎯 [SP 6] Sasaran Program: Meningkatnya kapasitas kelembagaan dan ketatalaksanaan Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 6.1] Indikator Kinerja Program: Nilai Evaluasi Kelembagaan Kejaksaan RI
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Skor kematangan tata kelola kelembagaan (tepat ukuran, tepat struktur, tepat proses) oleh KemenPAN-RB (Skala 0-100).
*   **Formula Capaian:**
    $$\text{Capaian IKP 6.1} = \left( \frac{\text{Skor Hasil Evaluasi Kelembagaan Aktual}}{\text{Target Skor Evaluasi Kelembagaan Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Hasil Evaluasi Tata Kelola Kelembagaan KemenPAN-RB.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Nilai diinput langsung (Direct Input) oleh operator Biro Perencanaan sesuai rilis dari KemenPAN-RB.

#### 📊 [IKP 6.2] Indikator Kinerja Program: Tingkat kepatuhan satuan kerja terhadap standar operasional prosedur
*   **Sifat Node:** Agregatif (Roll-up dari SK di bawahnya)
*   **Metode Pengukuran:** Persentase satker yang dinilai mematuhi SOP operasional layanan internal maupun yustisial.
*   **Formula Capaian:**
    $$\text{Capaian IKP 6.2} = \left( \frac{\text{Jumlah Satker Patuh SOP Aktual}}{\text{Target Jumlah Satker Patuh SOP}} \right) \times 100\%$$
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
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Penilaian kualitas formulasi, implementasi, dan evaluasi peraturan Kejaksaan oleh LAN RI (Skala 0-100).
*   **Formula Capaian:**
    $$\text{Capaian IKP 7.1} = \left( \frac{\text{Skor Indeks Kualitas Kebijakan (IKK) Aktual}}{\text{Target Indeks Kualitas Kebijakan Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Hasil Pengukuran Indeks Kualitas Kebijakan (IKK) oleh Lembaga Administrasi Negara.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Nilai diinput langsung (Direct Input) oleh operator Pustrajakgakum sesuai rilis LAN RI.

#### 📊 [IKP 7.2] Indikator Kinerja Program: Indeks Reformasi Hukum pada Kejaksaan RI
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Kepatuhan dan kualitas harmonisasi regulasi nasional yang dievaluasi Kemenkumham (Skala 0-100).
*   **Formula Capaian:**
    $$\text{Capaian IKP 7.2} = \left( \frac{\text{Skor Indeks Reformasi Hukum (IRH) Aktual}}{\text{Target Indeks Reformasi Hukum Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Evaluasi Indeks Reformasi Hukum Kejaksaan RI dari Kemenkumham.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Nilai diinput langsung (Direct Input) oleh operator Biro Hukum & HLN sesuai rilis Kemenkumham.

---

### 🎯 [SP 8] Sasaran Program: Meningkatnya kuantitas dan kualitas SDM aparatur Kejaksaan RI
*   **Unit Pengampu:** Jaksa Agung Muda Bidang Pembinaan (JAMBIN)

#### 📊 [IKP 8.1] Indikator Kinerja Program: Indeks Sistem Merit Kejaksaan RI
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Skor kematangan penerapan meritokrasi dalam karir kepegawaian oleh KASN / BKN (Skala 0-100).
*   **Formula Capaian:**
    $$\text{Capaian IKP 8.1} = \left( \frac{\text{Skor Sistem Merit Aktual}}{\text{Target Skor Sistem Merit Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Hasil Evaluasi Sistem Merit Kejaksaan RI oleh BKN.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Nilai diinput langsung (Direct Input) oleh operator Biro Kepegawaian sesuai penilaian resmi BKN.

#### 📊 [IKP 8.2] Indikator Kinerja Program: Persentase kecukupan, kesesuaian, dan pengembangan SDM Kejaksaan RI
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Penilaian komposit keselarasan kuantitas dan kualitas SDM dengan kompetensi jabatan (Skala 0-100%).
*   **Formula Capaian:**
    $$\text{Capaian IKP 8.2} = \left( \frac{\text{Realisasi Aktual (\%)}}{\text{Target Renstra (\%)}} \right) \times 100\%$$
*   **Sumber Data:** Analisis Kepegawaian Aplikasi MySimkari.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Data ditarik kasar dari database MySimkari.

#### 📊 [IKP 8.3] Indikator Kinerja Program: Indeks Profesionalitas SDM Kejaksaan RI
*   **Sifat Node:** Agregatif (Roll-up dari SK di bawahnya)
*   **Metode Pengukuran:** Skor pengukuran indeks profesionalitas aparatur sipil negara Kejaksaan berdasarkan BKN (Skala 1.0 - 5.0).
*   **Formula Capaian:**
    $$\text{Capaian IKP 8.3} = \left( \frac{\text{Skor IP-ASN BKN Aktual}}{\text{Target IP-ASN Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Hasil Pengukuran Indeks Profesionalitas ASN (IP-ASN) Kejaksaan RI oleh BKN.

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
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Nilai rata-rata kuesioner kepuasan pegawai internal terhadap pelayanan kesekretariatan Eselon I.
*   **Formula Capaian:**
    $$\text{Capaian IKP 10.1} = \left( \frac{\text{Skor Indeks Kepuasan Aktual}}{\text{Target Skor Indeks Kepuasan Renstra}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Hasil Survei Kepuasan Kesekretariatan Internal Kejaksaan.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Nilai diinput langsung (Direct Input) oleh operator Sekretariat JAMBIN sesuai survei internal berkala.

#### 📊 [IKP 10.2] Indikator Kinerja Program: Tingkat kepuasan Stakeholder terhadap Rumah Sakit Adhyaksa, Klinik Adhyaksa, dan Fasilitas Kesehatan Yustisial lainnya
*   **Sifat Node:** Agregatif (Roll-up dari SK di bawahnya)
*   **Metode Pengukuran:** Nilai rata-rata survei kepuasan pasien/stakeholder terhadap kualitas rumah sakit dan klinik Adhyaksa (Skala 1-5).
*   **Formula Capaian:**
    $$\text{Capaian IKP 10.2} = \left( \frac{\text{Rata-rata Skor Kepuasan Faskes Aktual}}{\text{Target Skor Kepuasan Faskes}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Hasil Kuesioner Kepuasan Stakeholder Kesehatan Yustisial.

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
*   **Sifat Node:** Mandiri (Leaf Node - Berhenti di Sini)
*   **Metode Pengukuran:** Nilai kepuasan dari kuesioner evaluasi layanan harmonisasi draf peraturan internal oleh Biro Hukum (Skala 1-5).
*   **Formula Capaian:**
    $$\text{Capaian IKP 13.1} = \left( \frac{\text{Skor Kepuasan Layanan Aktual}}{\text{Target Skor Kepuasan Layanan}} \right) \times 100\%$$
*   **Sumber Data:** Laporan Hasil Evaluasi Pelayanan Hukum Biro Hukum & HLN.
*   *Catatan Arsitektur:* Tidak ada SK & IKK di bawahnya. Nilai diinput langsung (Direct Input) oleh operator Biro Hukum & HLN sesuai survei kepuasan satker tahunan.

#### 📊 [IKP 13.2] Indikator Kinerja Program: Indeks kepuasan institusi mitra luar negeri terhadap kualitas kerja sama kelembagaan Kejaksaan RI
*   **Sifat Node:** Agregatif (Roll-up dari SK di bawahnya)
*   **Metode Pengukuran:** Survei kepuasan mitra kelembagaan asing atas kualitas pelaksanaan MLA/Ekstradisi.
*   **Formula Capaian:**
    $$\text{Capaian IKP 13.2} = \left( \frac{\text{Rata-rata Skor Kepuasan Mitra Aktual}}{\text{Target Skor Kepuasan Mitra}} \right) \times 100\%$$
*   **Sumber Data:** Dokumen Lembar Umpan Balik (Feedback Sheet) dari Mitra Asing.

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
*   **Sifat Node:** Agregatif (Roll-up dari SK di bawahnya)
*   **Metode Pengukuran:** Penilaian tingkat maturitas penerapan teknologi informasi (Sistem Kertas Tanpa Dokumen/Paperless) pada tugas operasional yustisial.
*   **Formula Capaian:**
    $$\text{Capaian IKP 15.1} = \left( \frac{\text{Skor Kematangan TI Aktual}}{\text{Target Skor Kematangan TI}} \right) \times 100\%$$
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
*   **Pembilang (Numerator):** Jumlah kluster database yustisial (Pidum, Pidsus, Datun, Pidmil) and manajerial (MySimkari, SAKTI) yang berhasil disinkronkan ke dalam *Data Warehouse* terpusat.
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
*   **Sifat Node:** Agregatif (Roll-up dari SK di bawahnya)
*   **Metode Pengukuran:** Persentase pemanfaatan aset sarpras operasional dalam kondisi prima (Skala 0-100%).
*   **Formula Capaian:**
    $$\text{Capaian IKP 16.1} = \left( \frac{\text{Rata-rata Realisasi Sarpras Siap Pakai}}{\text{Target Standar Penilaian}} \right) \times 100\%$$
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
*   **Penyebut (Denominator):** Total target set perangkat pengolah data and komunikasi yang direncanakan diadakan.
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
