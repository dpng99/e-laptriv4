---
name: cascading_jambin_v3_canonical
version: 3.1
status: CANONICAL-CONTRACT
runtime_authority: true
scope: JAMBIN / Program Dukungan Manajemen / Renstra Kejaksaan RI 2025-2029
replaces_for_runtime: cascading-jambin-v2.md
preserves: nomenklatur dan struktur substansi v2 yang masih valid
consolidates:
  - cascading-jambin-v3-canonical-draft
  - cascading-jambin-v3-canonical-mui
backend: Laravel
frontend: ReactJS + Inertia.js + Material UI
machine_readable_pair: database/data/jambin_architecture_v3.php
---

# Cetak Biru Cascading JAMBIN V3 — Canonical

## 0. Tujuan Dokumen

Dokumen ini menjadi **single canonical contract** untuk domain cascading, calculation engine, database, input, Laravel, ReactJS + Inertia.js + Material UI, testing, staging, dan promosi e-LKjIP Pembinaan ke production.

V3 **tidak membuang v2**. V2 tetap berguna sebagai sumber nomenklatur, pemetaan SK/IKK, formula, dan penjelasan operasional. Namun V3 memperbaiki kekeliruan arsitektural utama pada v2, yaitu:

> **keberadaan SK/IKK di bawah IKP tidak otomatis berarti nilai IKP dihitung dari rata-rata child.**

V3 memisahkan secara tegas:

1. **Performance Graph** — siapa mendukung siapa dalam struktur kinerja;
2. **Calculation Graph** — nilai indikator dihitung dari input/komponen apa;
3. **Organizational Aggregation** — bagaimana nilai dikonsolidasikan antarunit/satker;
4. **Measurement Semantics** — raw input, realisasi, target, capaian, dan status.

Dokumen ini harus dibaca oleh:
- AI Agent perencana;
- AI Agent programmer;
- developer Laravel;
- developer React;
- reviewer SAKIP;
- administrator master formula;
- tester.

---

# 1. Source of Truth

Urutan otoritas implementasi:

1. Dokumen resmi Renstra Kejaksaan RI 2025–2029;
2. Kepja/IKU Kejaksaan RI 2025–2029;
3. dataset canonical yang telah direkonsiliasi;
4. dokumen `cascading-jambin-v3-canonical.md` ini;
5. `database/data/jambin_architecture_v3.php` sebagai representasi machine-readable yang wajib identik dengan dokumen ini;
6. kode aplikasi dan automated tests;
7. `cascading-jambin-v2.md` hanya sebagai referensi historis/nomenklatur, dengan `runtime_authority: false`.

Dokumen `formula-registry.md`, `input-schema.md`, `database-architecture.md`, atau `testing-rules.md` boleh dibuat sebagai dokumentasi turunan, tetapi tidak menjadi authority paralel. Jika berbeda, dokumen ini yang berlaku.

Jika kode aplikasi bertentangan dengan dokumen canonical ini, **kode yang harus diperbaiki**, bukan dokumen canonical yang diam-diam mengikuti kode.

## 1.1 Register sumber dasar

| Sumber | Fungsi authority |
|---|---|
| `KEPJA 1184_Indikator Kinerja Utama IKU 2025-2029.pdf` | Nama, definisi, formula, satuan, target, dan penanggung jawab indikator sesuai ruang lingkupnya |
| `A.1.3. Renstra Kejaksaan 2025-2029-Final.pdf` | Arsitektur strategi, program, sasaran, periode, dan target Renstra |
| `lkjip-kejari-cabjari.docx` | Kebutuhan data dan struktur pelaporan Kejari/Cabjari; bukan authority untuk mengubah definisi IKU/Renstra |
| `lkjip-kejati.docx` | Kebutuhan data dan struktur pelaporan Kejati; bukan authority untuk mengubah definisi IKU/Renstra |

Setiap fakta runtime wajib menyimpan referensi dokumen dan halaman/bagian. Jika referensi tepat belum tersedia, tandai `UNRESOLVED`; jangan mengisi halaman berdasarkan perkiraan.

---

# 2. Perubahan Fundamental dari V2 ke V3

## 2.1 Definisi lama yang dihentikan

V2 menggunakan pendekatan:

```text
IKP punya SK/IKK
→ IKP AGREGATIF
→ average/roll-up child
```

Pendekatan tersebut **tidak boleh lagi digunakan sebagai aturan umum**.

## 2.2 Definisi V3

### MANDIRI

`MANDIRI` berarti:

> Nilai indikator mempunyai sumber nilai/formula sendiri dan **tidak bergantung pada generic roll-up child performance**.

Node MANDIRI **boleh mempunyai SK/IKK**.

Contoh:
- Nilai SAKIP;
- NKA;
- IPA;
- Kepatuhan SOP;
- Sistem Merit;
- Digitalisasi proses bisnis;
- Utilisasi sarpras;
- Indeks kepuasan/survei.

### AGREGATIF

`AGREGATIF` berarti:

> Nilai indikator memang secara eksplisit dihitung dari configured child indicator yang menjadi operand formula.

AGREGATIF tidak boleh menggunakan:

```text
AVERAGE(all children)
```

tanpa konfigurasi eksplisit.

---

# 3. Performance Graph vs Calculation Graph

## 3.1 Performance Graph

Menjawab:

> Sasaran/indikator/kegiatan ini mendukung outcome yang mana?

Contoh:

```text
SP 15
└── IKP 15.1 Digitalisasi Proses Bisnis Inti
    ├── SK 15.1.1 Statistik Kriminal & TI
    ├── SK 15.2.1 Sistem TI / SPPT-TI
    ├── SK 15.3.1 Kualitas Data
    ├── SK 15.4.1 Keamanan TI
    └── SK 15.5.1 Administrasi Perkara Berbasis TI
```

## 3.2 Calculation Graph

Menjawab:

> Dari data apa nilai IKP 15.1 dihitung?

```text
proses_bisnis_terdigitalisasi
                \
                 → RATIO_PERCENTAGE → Realisasi IKP 15.1
                /
total_proses_bisnis_inti
```

SK/IKK TI tetap mendukung IKP 15.1, tetapi **tidak otomatis menjadi operand formula**.

---

# 4. Relation Types Canonical

| Relation Type | Makna | Dibaca Calculation Engine |
|---|---|---:|
| `STRUCTURAL` | pasangan sasaran-indikator resmi | Tidak |
| `CASCADING` | penjenjangan kinerja | Tidak |
| `CONTRIBUTION` | child mendukung outcome parent | Tidak |
| `FORMULA_COMPONENT` | child indikator adalah operand formula parent | Ya |
| `SAME_INDICATOR` | indikator sama pada level/unit berbeda | Kondisional |
| `ORG_AGGREGATION` | konsolidasi nilai antarunit/satker | Ya, jika method dikonfigurasi |
| `REFERENCE` | enabler/referensi | Tidak |

Nama relation type runtime wajib menggunakan nilai pada tabel di atas. Alias seperti `STRUCTURE`, `CASCADE`, `REPORTING`, dan `SHARED_OWNERSHIP` tidak boleh dimasukkan sebagai nilai baru tanpa migration/mapping eksplisit. Bila konsep reporting atau shared ownership diperlukan, simpan sebagai metadata edge atau perluas enum melalui perubahan versi canonical.

## 4.1 Rule wajib

```text
CONTRIBUTION != FORMULA_COMPONENT
CASCADING != FORMULA_COMPONENT
STRUCTURAL != FORMULA_COMPONENT
```

Calculation engine dilarang mencari semua child lalu menghitung average secara otomatis.

---

# 5. Measurement Semantics

Selalu pisahkan:

```text
RAW INPUT
    ↓
FORMULA
    ↓
REALISASI
    ↓
TARGET
    ↓
CAPAIAN TERHADAP TARGET
    ↓
STATUS
```

## 5.1 Raw Input

Contoh:

```text
Jumlah satker patuh      = 420
Jumlah satker dinilai    = 500
```

## 5.2 Realisasi

```text
420 / 500 × 100 = 84%
```

## 5.3 Target

```text
85%
```

## 5.4 Capaian terhadap target

Untuk indikator positif:

```text
84 / 85 × 100 = 98,82%
```

## 5.5 Status

```text
capaian >= 100
→ TERCAPAI

capaian < 100 dan TW 1-3
→ BELUM_TERCAPAI

capaian < 100 dan TW 4
→ TIDAK_TERCAPAI
```

## 5.6 Nilai Laporan yang Belum Direkonsiliasi

Jika laporan kinerja yang ditetapkan sebagai sumber hanya menyediakan nilai
realisasi dan/atau capaian, sedangkan operand formula canonical tidak tersedia,
aplikasi boleh menyimpannya sebagai pengukuran berstatus `REPORTED` dengan
`source_reference`, `evidence_reference`, dan `calculation_trace` yang jelas.

`REPORTED` bukan `RAW INPUT`, bukan hasil baru calculation engine, dan bukan
pengganti formula canonical. Nilai tersebut:

- tidak boleh mengisi tabel target;
- tidak boleh dibuatkan pembilang, penyebut, atau komponen secara tebakan;
- tidak boleh ditimpa oleh `calculateNode`/`calculateAll`;
- tidak boleh diajukan, diverifikasi, atau disetujui sampai direkonsiliasi ke
  dokumen sumber dan operand formula yang lengkap tersedia.

Setelah operand resmi tersedia, reviewer membuat atau memulihkan pengukuran
berbasis raw input sesuai formula canonical; jangan menganggap nilai
`REPORTED` sebagai bukti bahwa formula sudah tervalidasi.

---

# 6. Scope Program JAMBIN Canonical

Scope runtime JAMBIN V3:

| SP | Sasaran Program |
|---|---|
| SP 1 | Meningkatnya akuntabilitas kinerja Kejaksaan RI |
| SP 4 | Meningkatnya efisiensi dan efektivitas penggunaan anggaran Kejaksaan RI |
| SP 5 | Meningkatnya kualitas tata kelola aset dan pengadaan Kejaksaan RI |
| SP 6 | Meningkatnya kapasitas kelembagaan dan ketatalaksanaan Kejaksaan RI |
| SP 7 | Meningkatnya kualitas kebijakan penegakan hukum |
| SP 8 | Meningkatnya kuantitas dan kualitas SDM aparatur Kejaksaan RI |
| SP 10 | Meningkatnya kualitas layanan internal dukungan manajemen dan kesehatan yustisial |
| SP 11 | Meningkatnya kompetensi aparatur Kejaksaan RI |
| SP 13 | Meningkatnya kualitas layanan hukum dan hubungan luar negeri |
| SP 15 | Meningkatnya efektivitas pelaksanaan tugas dan fungsi Kejaksaan berbasis TI |
| SP 16 | Meningkatnya kuantitas dan kualitas sarana dan prasarana yang mendukung kinerja Kejaksaan RI |

> SP 2 tidak dimasukkan ke runtime scope JAMBIN V3 ini karena ownership indikatornya bukan menjadi input utama JAMBIN pada konfigurasi aplikasi saat ini. Jika dibutuhkan sebagai cross-program reference, gunakan `REFERENCE`/ownership terpisah, jangan dimasukkan diam-diam sebagai input JAMBIN.

Input dan pelaporan operasional JAMBIN dimulai dari `SP → IKP → SK → IKK`. Node `SS` dan `IKSS` boleh dipertahankan dalam canonical graph sebagai referensi/crosswalk strategis, tetapi bukan scope input operasional pada kontrak ini.

---

# 7. Master Classification IKP JAMBIN

| IKP | Nama Ringkas | Tipe Node V3 | Formula Key / Pattern | Input User | Child Default |
|---|---|---|---|---|---|
| IKP 1.1 | Nilai SAKIP Kejaksaan RI | `MANDIRI` | `EXTERNAL_SCORE` | Nilai resmi SAKIP | `CONTRIBUTION` |
| IKP 4.1 | Nilai Kinerja Anggaran | `MANDIRI` | `WEIGHTED_SUM` | Komponen resmi NKA | `CONTRIBUTION`; `ORG_AGGREGATION` terpisah bila diperlukan |
| IKP 5.1 | Indeks Pengelolaan Aset | `MANDIRI` | `WEIGHTED_SUM` | X1..X8 | `CONTRIBUTION` |
| IKP 5.2 | Indeks Tata Kelola Pengadaan | `MANDIRI` | `SUM` | SP, KSDM, TK | `CONTRIBUTION` |
| IKP 6.1 | Nilai Evaluasi Kelembagaan | `MANDIRI` | `SUM` | komponen struktur + proses | `CONTRIBUTION` |
| IKP 6.2 | Kepatuhan Satker terhadap SOP | `MANDIRI` | `RATIO_PERCENTAGE` | jumlah patuh, jumlah dinilai | `CONTRIBUTION`; org aggregation terpisah |
| IKP 7.1 | Indeks Kualitas Kebijakan | `MANDIRI` | `WEIGHTED_SUM` | 5 dimensi | `CONTRIBUTION` |
| IKP 7.2 | Indeks Reformasi Hukum | `MANDIRI` | `WEIGHTED_SUM` | 4 dimensi | `CONTRIBUTION` |
| IKP 8.1 | Indeks Sistem Merit | `MANDIRI` | `WEIGHTED_SUM` | 8 aspek | `CONTRIBUTION` |
| IKP 8.2 | Kecukupan, Kesesuaian, Pengembangan SDM | `MANDIRI` | `AVERAGE_COMPONENTS` | 3 komponen | `CONTRIBUTION` |
| IKP 8.3 | Indeks Profesionalitas SDM | `MANDIRI` | `WEIGHTED_SUM` | kualifikasi, kompetensi, kinerja, disiplin | `CONTRIBUTION` |
| IKP 10.1 | Kepuasan Layanan Dukungan Internal | `MANDIRI` | `AVERAGE_COMPONENTS` | nilai layanan/komponen survei eksplisit | hanya explicit component yang dikonfigurasi |
| IKP 10.2 | Kepuasan RS/Klinik/Faskes Yustisial | `MANDIRI` | `SURVEY_INDEX` | distribusi rating / skor survei | `CONTRIBUTION` |
| IKP 11.1 | Competency Fit Index | `MANDIRI` | `RATIO_PERCENTAGE` | total skor aktual, total skor ideal | `CONTRIBUTION` |
| IKP 11.2 | Aparatur Bersertifikasi Sesuai Jabatan | `MANDIRI` | `AVERAGE_OF_RATIOS` | 4 raw counts | `CONTRIBUTION` |
| IKP 13.1 | Kepuasan Satker atas Layanan Hukum | `MANDIRI` | `SURVEY_INDEX` | TS, R, P, M | `CONTRIBUTION` |
| IKP 13.2 | Kepuasan Mitra Luar Negeri | `MANDIRI` | `SURVEY_INDEX` | TS, R, P, M | `CONTRIBUTION` |
| IKP 15.1 | Digitalisasi Proses Bisnis Inti | `MANDIRI` | `RATIO_PERCENTAGE` | proses terdigitalisasi, total proses | `CONTRIBUTION` |
| IKP 16.1 | Utilisasi Sarpras | `MANDIRI` | `RATIO_PERCENTAGE` | sarpras dimanfaatkan, total sarpras | `CONTRIBUTION` |

## 7.1 Consequence

Pada canonical JAMBIN V3 ini, **seluruh IKP utama di atas diperlakukan MANDIRI secara calculation graph**.

Formula key pada tabel adalah keputusan runtime tunggal, bukan daftar alternatif. `formula_status` untuk SAKIP adalah `EXTERNAL`; formula lain hanya boleh berstatus `RESOLVED` setelah input, bobot, precision, period mode, dan dependency-nya lengkap pada config. Bagian yang belum lengkap wajib `UNRESOLVED` dan tidak dieksekusi.

Jika pada masa depan ada IKP yang benar-benar dibentuk dari child, barulah gunakan `AGREGATIF`.

---

# 8. Cascading per Program

# SP 1 — Akuntabilitas Kinerja

## IKP 1.1 — Nilai SAKIP Kejaksaan RI

```yaml
tipe_node: MANDIRI
formula_key: EXTERNAL_SCORE
input_enabled: true
measurement_scope: ORGANIZATION
child_relation: CONTRIBUTION
```

### Input User

```text
Nilai SAKIP hasil evaluasi resmi [      ]
```

### Realisasi

```text
realisasi = nilai_sakip_resmi
```

### Capaian

```text
capaian = realisasi / target_sakip * 100
```

### Larangan

Dilarang:

```text
AVG(SK 1.1.x)
AVG(IKK 1.1.x.x)
WEIGHTED_SUM(perencanaan,pengukuran,pelaporan,evaluasi)
```

untuk menggantikan nilai SAKIP resmi.

Empat komponen evaluasi AKIP dapat disimpan sebagai **detail evaluasi**, tetapi bukan sumber final nilai SAKIP kecuali ada keputusan resmi baru.

### Performance Children

```text
IKP 1.1
├── SK 1.1.1 Terwujudnya Perencanaan, Pemantauan, Evaluasi, dan RB yang Efektif
│   ├── IKK 1.1.1.1 Persentase layanan reformasi birokrasi sesuai SLA
│   ├── IKK 1.1.1.2 Persentase satker mendapat pendampingan ZI menuju WBK/WBBM
│   ├── IKK 1.1.1.3 Persentase layanan pemantauan dan evaluasi sesuai SLA
│   └── IKK 1.1.1.4 Persentase layanan pengelolaan data kinerja sesuai SLA
├── SK 1.1.2 Terwujudnya Evaluasi Akuntabilitas Kinerja Internal Instansi
│   ├── IKK 1.1.2.1 Nilai SAKIP UKE I
│   └── IKK 1.1.2.2 Nilai SAKIP Kejati/Kejari/Cabjari
├── SK 1.1.3 Meningkatnya Kualitas Perencanaan Kejaksaan RI
│   └── IKK 1.1.3.1 Indeks Perencanaan Pembangunan Nasional (IPPN)
└── SK 1.1.4 Meningkatnya Kualitas Tata Kelola Organisasi yang Tepat Fungsi
    ├── IKK 1.1.4.1 Persentase Penyelesaian Restrukturisasi Organisasi
    └── IKK 1.1.4.2 Tingkat Realisasi Rencana Aksi RB General
```

Semua relasi IKP 1.1 → SK di atas:

```text
CONTRIBUTION
```

---

# SP 4 — Efisiensi dan Efektivitas Anggaran

## IKP 4.1 — Nilai Kinerja Anggaran Kejaksaan RI

```yaml
tipe_node: MANDIRI
formula_key: WEIGHTED_SUM
input_enabled: true
measurement_scope: ORGANIZATION
```

### Formula Canonical

Gunakan komponen NKA resmi yang berlaku pada blueprint/IKU, bukan average SK.

Baseline V3:

```text
X1 = Nilai Kinerja Perencanaan Anggaran
X2 = Nilai Kinerja Pelaksanaan Anggaran

NKA = normalized(X1) × 50% + normalized(X2) × 50%
```

Jika formula resmi pada tahun tertentu berubah, buat formula version baru.

### Children

```text
IKP 4.1
├── SK 4.1.1 Efisiensi dan efektivitas perencanaan/penggunaan anggaran UKE I
│   └── IKK 4.1.1.1 NKA UKE I
└── SK 4.1.2 Efisiensi dan efektivitas perencanaan/penggunaan anggaran daerah
    └── IKK 4.1.2.1 NKA Kejati/Kejari/Cabjari
```

Relasi tersebut merupakan performance/organizational view.

**Jangan otomatis:**

```text
IKP 4.1 = AVG(IKK 4.1.1.1, IKK 4.1.2.1)
```

Jika konsolidasi nilai unit dibutuhkan, konfigurasi `ORG_AGGREGATION` secara eksplisit.

---

# SP 5 — Tata Kelola Aset dan Pengadaan

## IKP 5.1 — Indeks Pengelolaan Aset

```yaml
tipe_node: MANDIRI
formula_key: WEIGHTED_SUM
input_enabled: true
```

### Komponen

| Key | Komponen | Bobot |
|---|---|---:|
| X1 | Tindak lanjut temuan LHP BPK terkait BMN | 15% |
| X2 | Realisasi PNBP pengelolaan aset | 10% |
| X3 | Ketepatan laporan dan usulan RKBMN | 10% |
| X4 | Asuransi BMN | 10% |
| X5 | Tindak lanjut pemanfaatan/pemindahtanganan/penghapusan BMN | 15% |
| X6 | Tindak lanjut BMN rusak berat | 10% |
| X7 | BMN memiliki dokumen kepemilikan | 15% |
| X8 | Penggunaan BMN sesuai ketentuan | 15% |

### Input UI

```text
X1 Tindak lanjut LHP BPK          [ ]
X2 Realisasi PNBP                 [ ]
...
X8 Penggunaan BMN                 [ ]
```

Bobot read-only.

## IKP 5.2 — Indeks Tata Kelola Pengadaan

```yaml
tipe_node: MANDIRI
formula_key: SUM
input_enabled: true
```

Komponen:

```text
SP   = Pemanfaatan Sistem Pengadaan
KSDM = Kualifikasi/kompetensi SDM PBJ
TK   = Tingkat Kematangan UKPBJ
```

Formula:

```text
ITKP = SP + KSDM + TK
```

---

# SP 6 — Kapasitas Kelembagaan dan Ketatalaksanaan

## IKP 6.1 — Nilai Evaluasi Kelembagaan

```yaml
tipe_node: MANDIRI
formula_key: SUM
input_enabled: true
```

Komponen minimal:

```text
X1 = Nilai dimensi struktur setelah pembobotan
X2 = Nilai dimensi proses organisasi setelah pembobotan

NEK = X1 + X2
```

## IKP 6.2 — Tingkat Kepatuhan Satker terhadap SOP

```yaml
tipe_node: MANDIRI
formula_key: RATIO_PERCENTAGE
input_enabled: true
measurement_scope: ORGANIZATION
org_aggregation: SUM_INPUTS_THEN_CALCULATE
```

### Input User

```text
Jumlah satker yang patuh      [ ]
Jumlah satker yang dinilai    [ ]
```

### Formula

```text
realisasi =
jumlah_satker_patuh / jumlah_satker_dinilai × 100
```

### Organizational Aggregation

Jika diinput per unit:

```text
SUM(jumlah_patuh_unit)
---------------------- × 100
SUM(jumlah_dinilai_unit)
```

Bukan:

```text
AVG(persentase_unit)
```

### Child

```text
IKP 6.2
└── SK 6.2.1 Tata Kelola Organisasi UKE I Tepat Fungsi
    └── IKK 6.2.1.1 Implementasi RB UKE I berdasarkan Rencana Aksi RB Tematik
```

Relasi:

```text
CONTRIBUTION
```

---

# SP 7 — Kualitas Kebijakan Penegakan Hukum

## IKP 7.1 — Indeks Kualitas Kebijakan

```yaml
tipe_node: MANDIRI
formula_key: WEIGHTED_SUM
input_enabled: true
```

| Key | Dimensi | Bobot |
|---|---|---:|
| X1 | Profil | 10% |
| X2 | Perencanaan kebijakan | 20% |
| X3 | Implementasi kebijakan | 25% |
| X4 | Evaluasi dan keberlanjutan kebijakan | 30% |
| X5 | Transparansi dan partisipasi publik | 15% |

## IKP 7.2 — Indeks Reformasi Hukum

```yaml
tipe_node: MANDIRI
formula_key: WEIGHTED_SUM
input_enabled: true
```

| Key | Dimensi | Bobot |
|---|---|---:|
| X1 | Koordinasi harmonisasi peraturan | 25% |
| X2 | Kompetensi legal drafter | 25% |
| X3 | Kualitas re-regulasi/deregulasi | 35% |
| X4 | Penataan database peraturan | 15% |

---

# SP 8 — Kuantitas dan Kualitas SDM

## IKP 8.1 — Indeks Sistem Merit

```yaml
tipe_node: MANDIRI
formula_key: WEIGHTED_SUM
input_enabled: true
```

| Key | Aspek | Bobot |
|---|---|---:|
| X1 | Perencanaan kebutuhan | 20% |
| X2 | Pengadaan | 10% |
| X3 | Pengembangan karier | 25% |
| X4 | Promosi dan mutasi | 10% |
| X5 | Manajemen kinerja | 15% |
| X6 | Penggajian, penghargaan, disiplin | 10% |
| X7 | Perlindungan dan pelayanan | 5% |
| X8 | Sistem informasi | 5% |

## IKP 8.2 — Persentase Kecukupan, Kesesuaian, dan Pengembangan SDM

```yaml
tipe_node: MANDIRI
formula_key: AVERAGE_COMPONENTS
input_enabled: true
```

Komponen:

```text
KECUKUPAN
PENGEMBANGAN
PENGELOLAAN
```

Formula:

```text
KKP = (KECUKUPAN + PENGEMBANGAN + PENGELOLAAN) / 3
```

## IKP 8.3 — Indeks Profesionalitas SDM

```yaml
tipe_node: MANDIRI
formula_key: WEIGHTED_SUM
input_enabled: true
```

| Komponen | Bobot |
|---|---:|
| Kualifikasi | 20% |
| Kompetensi | 40% |
| Kinerja | 30% |
| Disiplin | 10% |

### Performance Children SP 8

```text
SK 8.1.1 Pembinaan dan Pengelolaan Kepegawaian
├── IKK 8.1.1.1 Layanan umum kepegawaian sesuai SLA
├── IKK 8.1.1.2 Layanan pengembangan kepegawaian sesuai SLA
├── IKK 8.1.1.3 Layanan kepangkatan dan mutasi sesuai SLA
└── IKK 8.1.1.4 Layanan pemberhentian dan pensiun sesuai SLA

SK 8.2.1 Kecukupan dan Kesesuaian SDM
├── IKK 8.2.1.1 Tingkat Kecukupan Personil Jaksa
├── IKK 8.2.1.2 Tingkat kesesuaian pengelolaan SDM Jaksa
└── IKK 8.2.1.3 Tingkat kesesuaian kompetensi pegawai terhadap persyaratan jabatan

SK 8.3.1 Pengelolaan dan Pengembangan SDM
├── IKK 8.3.1.1 Tingkat Pengembangan Kapasitas Personil Jaksa
└── IKK 8.3.1.2 Persentase SDM yang memiliki sertifikat sesuai standar kompetensi

SK 8.5.1 ASN Kejaksaan yang BerAKHLAK
└── IKK 8.5.1.1 Indeks Kepuasan Pegawai terhadap Layanan Manajemen ASN
```

Child di atas default `CONTRIBUTION`.

---

# SP 10 — Dukungan Manajemen dan Kesehatan Yustisial

## IKP 10.1 — Indeks Kepuasan Layanan Dukungan Internal

```yaml
tipe_node: MANDIRI
formula_key: AVERAGE_COMPONENTS
input_enabled: true
```

Formula konseptual:

```text
IKDIM = (IKL1 + IKL2 + ... + IKLn) / N
```

Masing-masing `IKL` dapat dihitung dari survey normalized formula.

### Important Rule

Jangan menggunakan heuristic:

```text
"ambil IKK pertama dari setiap SK"
```

sebagai formula dependency.

Jika child indikator benar-benar merepresentasikan IKL1...IKLn, daftar kodenya harus ditulis eksplisit pada config.

## IKP 10.2 — Kepuasan Stakeholder terhadap RS/Klinik/Faskes Yustisial

```yaml
tipe_node: MANDIRI
formula_key: SURVEY_INDEX
input_enabled: true
```

Pattern distribusi rating:

```text
realisasi =
SUM(rating × jumlah_responden_rating)
------------------------------------- × 100
5 × total_responden
```

### Performance Child

```text
SK 10.2.1 Kualitas Penyelenggaraan Kesehatan Yustisial
├── IKK 10.2.1.1 Pemenuhan Indikator Nasional Mutu Pelayanan Kesehatan
├── IKK 10.2.1.2 Tingkat pemahaman stakeholder terhadap tugas/fungsi PKY
├── IKK 10.2.1.3 Pemenuhan Hospital Safety Index
└── IKK 10.2.1.4 Jumlah kegiatan pelayanan kesehatan yustisial
```

IKP 10.2 bukan average empat IKK tersebut.

---

# SP 11 — Kompetensi Aparatur

## IKP 11.1 — Indeks Kesesuaian Kompetensi (Competency Fit Index)

```yaml
tipe_node: MANDIRI
formula_key: RATIO_PERCENTAGE
input_enabled: true
```

Formula:

```text
CFIj =
SUM(skor_kompetensi_aktual)
---------------------------- × 100
SUM(skor_kompetensi_ideal)
```

### Input

```text
Total skor kompetensi aktual [ ]
Total skor kompetensi ideal  [ ]
```

Target resmi baseline:
- 2025: 70
- 2026: 75
- 2027: 80
- 2028: 85
- 2029: 90

## IKP 11.2 — Persentase Aparatur yang Memiliki Sertifikasi Kompetensi Sesuai Jabatan

```yaml
tipe_node: MANDIRI
formula_key: AVERAGE_OF_RATIOS
input_enabled: true
```

Formula:

```text
N1 = jaksa_bersertifikat / total_jaksa × 100
N2 = asn_non_jaksa_bersertifikat / total_asn_non_jaksa × 100
ASK = (N1 + N2) / 2
```

### Input

```text
Jumlah Jaksa bersertifikat                [ ]
Jumlah total Jaksa                        [ ]
Jumlah ASN non-Jaksa bersertifikat        [ ]
Jumlah total ASN non-Jaksa                [ ]
```

Target resmi baseline:
- 2025: 50%
- 2026: 65%
- 2027: 75%
- 2028: 85%
- 2029: 95%

### Performance Child

```text
SK 11.1 Meningkatnya kualitas pengelolaan dan pengembangan SDM yang efektif
├── IKK 11.1.1 Tingkat Pengembangan Kapasitas Personil Jaksa
└── IKK 11.1.2 Persentase SDM yang memiliki sertifikat sesuai standar kompetensi
```

Hubungan IKP 11.1/11.2 → SK 11.1 merupakan pemetaan substansi/performance.

---

# SP 13 — Layanan Hukum dan Hubungan Luar Negeri

## IKP 13.1 — Indeks Kepuasan Satker atas Layanan Hukum

```yaml
tipe_node: MANDIRI
formula_key: SURVEY_INDEX
input_enabled: true
```

Formula normalized survey:

```text
IKLH = TS / (R × P × M) × 100
```

Input:

```text
Total skor (TS)       [ ]
Jumlah responden (R)  [ ]
Jumlah pertanyaan (P) [ ]
Skor maksimal (M)     [ ]
```

## IKP 13.2 — Indeks Kepuasan Institusi Mitra Luar Negeri

```yaml
tipe_node: MANDIRI
formula_key: SURVEY_INDEX
input_enabled: true
```

Gunakan formula survei resmi pada canonical source. Child layanan bukan operand otomatis.

### Performance Child

```text
SK 13.2.1 Pelayanan Peraturan, Hukum, Kerja Sama dan HLN
├── IKK 13.2.1.1 Layanan penelaahan/perancangan/pertimbangan hukum sesuai SLA
├── IKK 13.2.1.2 Layanan kerja sama hukum dan HLN sesuai SLA
├── IKK 13.2.1.3 Layanan perpustakaan dan dokumentasi hukum sesuai SLA
├── IKK 13.2.1.4 Layanan hukum pada perwakilan Kejaksaan di luar negeri sesuai SLA
└── IKK 13.2.1.5 Layanan perkantoran perwakilan Kejaksaan di luar negeri sesuai SLA
```

Relasi ke IKP 13.2:

```text
CONTRIBUTION
```

---

# SP 15 — Dukungan Teknologi Informasi

## IKP 15.1 — Persentase Digitalisasi Proses Bisnis Inti

```yaml
tipe_node: MANDIRI
formula_key: RATIO_PERCENTAGE
input_enabled: true
```

Formula:

```text
DPB =
jumlah_proses_bisnis_terdigitalisasi
------------------------------------- × 100
total_proses_bisnis_inti
```

### Input User

```text
Jumlah proses bisnis inti yang telah terdigitalisasi [ ]
Total proses bisnis inti                            [ ]
```

### Performance Children

```text
SK 15.1.1 Pengelolaan Data, Statistik Kriminal dan TI
├── IKK 15.1.1.1 Layanan pengelolaan data dan statistik kriminal
├── IKK 15.1.1.2 Layanan penerapan/pengembangan TI sesuai SLA
└── IKK 15.1.1.3 Layanan perkantoran sesuai SLA

SK 15.2.1 Pengembangan dan Pemanfaatan Sistem TI
├── IKK 15.2.1.1 Satker menggunakan CMS dalam implementasi SPPT-TI
└── IKK 15.2.1.2 Indeks Pemerintah Digital

SK 15.3.1 Kualitas Data Statistik Kriminal
├── IKK 15.3.1.1 Indeks kualitas data
├── IKK 15.3.1.2 Indeks penyelenggaraan statistik sektoral
├── IKK 15.3.1.3 Satker menerapkan SPPT-TI dengan pertukaran data sahih
└── IKK 15.3.1.4 Keberhasilan tata kelola Satu Data Kejaksaan

SK 15.4.1 Keamanan Sistem TI
└── IKK 15.4.1.1 Indeks Kematangan Keamanan Siber

SK 15.5.1 Administrasi Penanganan Perkara Berbasis TI
└── IKK 15.5.1.1 Indeks kepuasan pengguna internal sistem administrasi perkara
```

Semua child default:

```text
CONTRIBUTION
```

---

# SP 16 — Sarana dan Prasarana

## IKP 16.1 — Tingkat Utilisasi Sarana dan Prasarana

```yaml
tipe_node: MANDIRI
formula_key: RATIO_PERCENTAGE
input_enabled: true
```

Formula:

```text
USP =
jumlah_sarpras_dimanfaatkan
----------------------------- × 100
total_sarpras
```

Input:

```text
Jumlah sarpras yang dimanfaatkan [ ]
Total sarpras                     [ ]
```

### Child Biro Perlengkapan

```text
SK 16.1.1 Pemenuhan Gedung/Rumah/Kendaraan/Perangkat/Fasilitas
├── IKK 16.1.1.1 Gedung kantor direhabilitasi
├── IKK 16.1.1.2 Rumah negara direhabilitasi
├── IKK 16.1.1.3 Pembangunan gedung kantor baru
├── IKK 16.1.1.4 Pembangunan rumah negara baru
├── IKK 16.1.1.5 Pengadaan mobil jabatan/operasional
├── IKK 16.1.1.6 Pengadaan mobil tahanan/fungsional
├── IKK 16.1.1.7 Pengadaan sepeda motor dinas
├── IKK 16.1.1.8 Pengadaan perangkat pengolah data/komunikasi
├── IKK 16.1.1.9 Pengadaan perlengkapan/fasilitas perkantoran
└── IKK 16.1.1.10 Pemenuhan sarpras intelijen/penegakan hukum
```

### Child Biro Umum

```text
SK 16.2.1 Pelayanan TU Pimpinan, Protokol, Security, Arsip, Sarpras dan RT
├── IKK 16.2.1.1 Layanan tata usaha pimpinan sesuai SLA
├── IKK 16.2.1.2 Layanan protokol dan pengamanan pimpinan sesuai SLA
├── IKK 16.2.1.3 Layanan keamanan dalam sesuai SLA
├── IKK 16.2.1.4 Layanan tata usaha dan kearsipan sesuai SLA
└── IKK 16.2.1.5 Layanan prasarana, sarana dan rumah tangga sesuai SLA
```

Semua child tersebut:

```text
CONTRIBUTION
```

Bukan formula utilisasi.

---

# 9. Rules untuk IKK

IKK pada umumnya merupakan input leaf.

Setiap IKK wajib mempunyai:

```yaml
kode:
nama:
formula_key:
formula_status:
satuan:
input_fields:
target:
period_mode:
org_aggregation:
tooltip:
source:
```

## 9.1 Ratio IKK

UI:

```text
[Label bisnis pembilang] [ ]
[Label bisnis penyebut]  [ ]
```

Backend:

```text
realisasi = pembilang / penyebut × 100
```

## 9.2 Direct/External IKK

UI:

```text
Nilai resmi [ ]
```

## 9.3 Count IKK

UI:

```text
Jumlah kegiatan [ ]
```

Tidak perlu memaksa denominator.

---

# 10. Input UX Contract

## 10.1 User tidak melihat istilah database

Dilarang sebagai label utama:

```text
Numerator
Denominator
```

Tampilkan label operasional, misalnya:

```text
Jumlah satker yang patuh
Jumlah satker yang dinilai
```

## 10.2 Read-only

User operator tidak mengubah:

- formula;
- bobot;
- target resmi;
- realisasi hasil hitung;
- capaian;
- status.

Pengecualian direct/external score: field nilai resmi memang input.

## 10.3 Tooltip

Setiap field raw input wajib mempunyai:

- definisi;
- satuan;
- contoh;
- sumber data;
- constraint.

---

# 11. Formula Registry Canonical

Minimal:

```text
DIRECT_VALUE
EXTERNAL_SCORE
RATIO_PERCENTAGE
INDEX_SCORE
UNFAVORABLE_PERCENTAGE
WEIGHTED_SUM
SUM
AVERAGE_COMPONENTS
AVERAGE_OF_RATIOS
SURVEY_INDEX
COUNT
AGGREGATE_AVG
```

`SAME_INDICATOR` dan `ORG_AGGREGATION` bukan `formula_key`. Keduanya adalah relation/aggregation semantics. Formula rasio tetap memakai `RATIO_PERCENTAGE`, sedangkan konsolidasi antarunit ditentukan oleh `aggregation_method`, misalnya `SUM_INPUTS_THEN_CALCULATE`.

`DOCUMENTED` bukan executable formula.

Gunakan:

```text
formula_status = DOCUMENTED_ONLY
```

atau:

```text
formula_status = UNRESOLVED
```

jika engine belum boleh menghitung.

## 11.1 Pemisahan status sumber dan status formula

Jangan menggunakan satu kolom status untuk dua arti berbeda.

```text
source_evidence_status:
DOCUMENTED | DERIVED | PROPOSED | UNRESOLVED

formula_status:
RESOLVED | EXTERNAL | DOCUMENTED_ONLY | UNRESOLVED
```

`source_evidence_status = DOCUMENTED` berarti fakta telah ditemukan pada sumber resmi. Nilai tersebut tidak pernah menjadi perintah menjalankan formula. Hanya `formula_status = RESOLVED` atau `EXTERNAL` dengan `formula_key` terdaftar yang boleh diproses engine.

---

# 12. Organizational Aggregation

`ORG_AGGREGATION` harus selalu mempunyai `aggregation_method`.

Allowed baseline:

```text
NONE
SUM
AVERAGE
WEIGHTED_AVERAGE
SUM_INPUTS_THEN_CALCULATE
LATEST
DIRECT_OVERRIDE
```

Contoh kepatuhan SOP:

```text
formula_key = RATIO_PERCENTAGE
aggregation_method = SUM_INPUTS_THEN_CALCULATE
```

---

# 13. Period Mode

Setiap indikator wajib mempunyai period semantics:

```text
PERIODIC
CUMULATIVE
LATEST_VALUE
ANNUAL_ONLY
```

Jangan:

- menjumlahkan persentase TW1+TW2+TW3;
- membagi target tahunan menjadi empat secara otomatis;
- menganggap TW4 = SUM(TW1..TW4) tanpa aturan.

---

# 14. Database Contract

Canonical identity boleh tetap memakai:

```text
kinerja_nodes
```

dengan detail:

```text
kinerja_ss
kinerja_ikss
kinerja_sp
kinerja_ikp
kinerja_sk
kinerja_ikk
```

Yang penting:

```text
performance graph
formula graph
measurement
target
```

dipisah.

Tables minimum:

```text
kinerja_nodes
kinerja_relasi
kinerja_rumus_indikators
kinerja_komponen_rumus
kinerja_targets
kinerja_pengukurans
kinerja_pengukuran_inputs
```

---

# 15. Measurement Storage Contract

`kinerja_pengukurans` menyimpan:

```text
node_id
unit_id
tahun
triwulan
workflow_status
target_snapshot
formula_key_snapshot
formula_version_snapshot
realisasi
capaian
status_capaian
calculation_trace
source_reference
evidence_reference
submitted_by
submitted_at
reviewed_by
reviewed_at
locked_by
locked_at
calculated_at
```

`kinerja_pengukuran_inputs` menyimpan raw values.

Target master tidak boleh menjadi tempat realisasi.

---

# 16. Calculation Engine Contract

Pseudo-flow:

```text
resolve node
    ↓
resolve formula status
    ↓
MANDIRI?
    ├── yes → load raw formula inputs
    │          ↓
    │       FormulaRegistry
    │          ↓
    │       realization
    │
    └── no / AGREGATIF
               ↓
        load explicit formula child
               ↓
          aggregation strategy
               ↓
           realization

realization
    ↓
resolve target
    ↓
achievement
    ↓
status
    ↓
persist snapshots
```

## 16.1 Forbidden

```text
average(all children)
first child as formula operand
first IKK of every SK
if kode == "IKP 6.2" in controller
```

---

# 17. Explicit Dependency Rule

Formula child harus ditulis dengan kode explicit.

Contoh benar:

```php
'10.1' => [
    'formula_children' => [
        'IKK:...',
        'IKK:...',
    ],
]
```

Contoh dilarang:

```php
$ikk = $sk->children()->first();
```

---

# 18. Seeder Contract

Urutan canonical:

```text
DokumenKinerjaSeeder
UnitKerjaSeeder
User/Role Seeder
SsSeeder
IkssSeeder
SpSeeder
IkpSeeder
SkSeeder
IkkSeeder
ReferensiNodeSeeder
RelasiKinerjaSeeder
UnitNodeKinerjaSeeder
RumusIndikatorSeeder
TargetSeeder
CascadingArchitectureSeeder
```

Legacy:

```text
PohonKinerjaSeeder
```

tidak boleh dipanggil canonical seed path.

Seeder:

- idempotent;
- transaction;
- `updateOrCreate`/`upsert`;
- database unique constraint;
- assertion setelah seed.

---

# 19. Automated Test Contract

Minimal wajib:

## Architecture

- seluruh SP JAMBIN tersedia;
- tidak ada legacy relation `DIRECT`;
- CONTRIBUTION tidak menjadi formula child;
- SAKIP child semua non-formula;
- formula child menggunakan explicit code.

## SAKIP

```text
Nilai SAKIP = nilai resmi
```

Perubahan IKK/SK tidak boleh mengubah Nilai SAKIP.

## Ratio

```text
420 / 500 = 84
```

denominator 0:

```text
validation error / null incomplete
```

bukan 0%.

## Missing Input

Missing bukan 0.

## Achievement

```text
84 / 85 × 100 = 98.8235...
```

## Status

TW2 98%:

```text
BELUM_TERCAPAI
```

TW4 98%:

```text
TIDAK_TERCAPAI
```

## Org Aggregate

```text
90/100
1/2
```

Expected:

```text
91/102 × 100
```

bukan:

```text
AVG(90,50)
```

---

# 20. Migration Rule dari V2

`cascading-jambin-v2.md` tidak langsung dihapus.

Statusnya menjadi:

```text
LEGACY_REFERENCE
```

Tambahkan di header v2:

```text
> DEPRECATED FOR RUNTIME:
> Gunakan cascading-jambin-v3-canonical.md sebagai source of truth.
> File ini dipertahankan untuk nomenklatur/detail historis.
```

Runtime tidak boleh membaca dua blueprint secara paralel.

---

# 21. Runtime Source of Truth

Satu file canonical human-readable:

```text
cascading-jambin-v3-canonical.md
```

Satu config machine-readable:

```text
database/data/jambin_architecture_v3.php
```

Keduanya harus sinkron.

Agent tidak boleh membaca `v2` lalu mengoverride keputusan `v3`.

## 21.1 Schema wajib `jambin_architecture_v3.php`

Config harus menggunakan key stabil dan tidak bergantung pada ID hasil auto-increment. Bentuk minimum:

```php
return [
    'metadata' => [
        'version' => '3.1',
        'effective_period' => '2025-2029',
        'runtime_authority' => true,
        'source_documents' => [
            'KEPJA 1184_Indikator Kinerja Utama IKU 2025-2029.pdf',
            'A.1.3. Renstra Kejaksaan 2025-2029-Final.pdf',
            'lkjip-kejari-cabjari.docx',
            'lkjip-kejati.docx',
        ],
    ],
    'indicators' => [
        'IKP:1.1' => [
            'display_code' => 'IKP 1.1',
            'display_name' => 'Nilai SAKIP Kejaksaan RI',
            'tipe_node' => 'MANDIRI',
            'formula_key' => 'EXTERNAL_SCORE',
            'formula_status' => 'EXTERNAL',
            'formula_version' => '3.1',
            'unit' => 'NILAI',
            'polarity' => 'MAXIMIZE',
            'period_mode' => 'ANNUAL_ONLY',
            'measurement_scope' => 'ORGANIZATION',
            'aggregation_method' => 'DIRECT_OVERRIDE',
            'input_enabled' => true,
            'input_schema' => [
                'fields' => [
                    [
                        'key' => 'nilai_sakip_resmi',
                        'label' => 'Nilai SAKIP hasil evaluasi resmi',
                        'input_type' => 'decimal',
                        'required' => true,
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
            ],
            'formula_children' => [],
            'contribution_children' => [
                'SK:1.1.1',
                'SK:1.1.2',
                'SK:1.1.3',
                'SK:1.1.4',
            ],
            'source_evidence_status' => 'DOCUMENTED',
            'source_references' => ['<required document/page reference>'],
        ],
    ],
];
```

Setiap indikator wajib memuat `display_code`, `display_name`, `tipe_node`, `formula_key`, `formula_status`, `formula_version`, `unit`, `polarity`, `period_mode`, `measurement_scope`, `aggregation_method`, `input_enabled`, `input_schema`, dependency eksplisit, status bukti, dan referensi sumber. Nilai kosong tidak boleh disamarkan dengan default executable.

Placeholder `<required document/page reference>` pada contoh schema bukan nilai runtime yang valid dan wajib diganti dengan referensi terverifikasi sebelum Gate B dinyatakan lulus.

---

# 22. Laravel Application Contract

## 22.1 Satu calculation path

```text
HTTP Controller
    ↓
Form Request + Policy
    ↓
PengukuranService
    ↓
InputSchemaService
    ↓
CalculationEngine
    ↓
FormulaRegistry
    ↓
Formula Calculator/Strategy
    ↓
AchievementService
    ↓
StatusResolver
    ↓
Persistence + Snapshot + Audit Trail
```

`CalculationEngine` adalah satu-satunya orchestrator calculation canonical. Service lama yang menghitung realisasi/capaian dengan jalur berbeda harus dihapus atau dideprecate setelah seluruh pemanggil dimigrasikan.

## 22.2 Controller tipis

`InputDataController` hanya boleh:

1. menerima request;
2. menjalankan authorization;
3. memakai Form Request untuk validasi;
4. memanggil `PengukuranService`;
5. mengembalikan response/redirect.

Controller tidak boleh menentukan formula, mencari child pertama, menghitung rasio, melakukan aggregation, atau membuat snapshot sendiri.

## 22.3 Precision dan calculation result

- Gunakan decimal terkontrol; jangan mengandalkan float biner untuk nilai resmi.
- Aturan precision, rounding, cap, dan division-by-zero berasal dari metadata canonical. Jika belum ditetapkan, statusnya `UNRESOLVED` dan tidak boleh dibuat default diam-diam.
- Calculation result minimal memuat `realisasi`, `capaian`, `status`, `components`, `warnings`, `formula_version`, dan `calculation_trace`.
- Missing input berbeda dari nol.

## 22.4 Database dan audit

- Target, raw input, realisasi, capaian, dan status disimpan sebagai konsep berbeda.
- Mutasi multi-tabel menggunakan transaksi.
- Gunakan foreign key, unique/check constraint, index, cast, dan versioning yang relevan.
- Simpan audit trail perubahan input, target, formula, review, rejection, approval, dan lock.
- Migration harus reversible dan tidak menghapus histori node/edge yang pernah berlaku.

---

# 23. ReactJS + Inertia.js + Material UI Contract

Material UI adalah standar UI final untuk halaman baru. React-Bootstrap atau komponen custom yang memiliki fungsi setara tidak boleh dicampur pada halaman baru. Migrasi halaman lama dilakukan bertahap tanpa memindahkan formula bisnis ke frontend.

## 23.1 Struktur frontend

```text
resources/js/
├── Layouts/
│   ├── AppLayout.jsx
│   ├── AppNavbar.jsx
│   ├── AppSidebar.jsx
│   └── AppFooter.jsx
├── Pages/
│   ├── Dashboard/
│   ├── Cascading/
│   ├── Pengukuran/
│   ├── Review/
│   ├── Monitoring/
│   └── Lkjip/
├── Components/
│   ├── performance/
│   ├── measurement/
│   ├── dashboard/
│   ├── forms/
│   ├── tables/
│   └── feedback/
├── hooks/
├── services/
├── theme/
└── utils/
```

## 23.2 Komponen MUI

- Navigasi: `AppBar`, `Drawer`, `Toolbar`, `Breadcrumbs`.
- Layout: `Container`, `Grid`, `Stack`, `Card`, `Paper`.
- Form: `TextField`, `Select`, `Autocomplete`, `RadioGroup`, `DatePicker`, `Button`.
- Data: `DataGrid` dan tree component MUI untuk pohon kinerja.
- Feedback: `Alert`, `Snackbar`, `Dialog`, `Skeleton`, `Tooltip`.
- Workflow: `Tabs`, `Stepper`, `Chip`.

Chart hanya menggunakan library yang dipilih proyek dan harus mengikuti theme MUI.

## 23.3 Theme dan accessibility

Theme terpusat wajib mendefinisikan warna, typography, spacing, radius, elevation, breakpoint, dan status token. Status tidak boleh disampaikan hanya melalui warna; gunakan teks, ikon, dan `Chip`.

```text
TERCAPAI
BELUM_TERCAPAI
TIDAK_TERCAPAI
BELUM_DIINPUT
DIKUNCI
```

Setiap halaman harus memiliki loading, empty, validation error, forbidden, stale/conflict, dan generic error state. Form dapat digunakan dengan keyboard, memiliki label yang terhubung, menjaga error server, dan mencegah submit ganda.

## 23.4 Dynamic input schema

Frontend hanya merender schema yang dikirim backend.

```jsx
<DynamicMeasurementForm
  schema={indicator.input_schema}
  initialValues={measurement.raw_inputs}
  readOnly={measurement.locked}
  onSubmit={submitMeasurement}
/>
```

Aturan wajib:

- jangan membuat page khusus per IKP/IKK;
- jangan membuat switch formula bisnis berdasarkan kode indikator di JSX;
- gunakan label bisnis, helper text, unit, required, min/max, options, repeater/table schema, serta evidence requirement dari backend;
- `realisasi`, `target`, `capaian`, dan `status` read-only;
- direct realization input hanya tersedia untuk formula yang mengizinkannya, seperti `DIRECT_VALUE` dan `EXTERNAL_SCORE`;
- preview frontend bersifat nonfinal; nilai final selalu berasal dari backend.

## 23.5 Halaman minimum

| Halaman | Fungsi |
|---|---|
| Dashboard | Ringkasan target, realisasi, capaian, status, tren, dan indikator belum diinput |
| Pohon Kinerja | Graph SS–IKK, filter tahun/program, formula, relasi, dan dependency |
| Input Pengukuran | Dynamic form berdasarkan raw input schema dan periode |
| Review Pengukuran | Review, komentar, pengembalian, persetujuan, dan lock |
| Monitoring | Perbandingan unit/satker dan hasil agregasi |
| Master Formula | Formula key, versi, status, dependency, dan effective period |
| Master Target | Target tahunan/triwulanan, sumber, versi, dan audit trail |
| LKjIP | Preview kelengkapan serta export |
| Audit Trail | Histori perubahan input, target, formula, review, dan lock |

---

# 24. Authorization, API, Dashboard, dan Export Contract

## 24.1 Authorization dan scope

Semua query dan mutation wajib memeriksa:

```text
role pengguna
satker
id_kejati
id_kejari
level organisasi
tahun aktif
triwulan
workflow status
locked_at
```

Gunakan Policy/Gate untuk membatasi role, satker, level, tahun, periode, serta status workflow. Pengguna tidak boleh melihat atau mengubah data di luar scope-nya.

## 24.2 API/DTO

- Gunakan Form Request untuk validasi dan normalisasi.
- Gunakan API Resource/DTO yang stabil; jangan mengirim seluruh model tanpa pembatasan.
- Gunakan eager loading, pagination, select terbatas, dan index untuk query utama.
- Lindungi mass assignment, upload bukti, parameter export, dan formula injection.

## 24.3 Dashboard

Dashboard hanya membaca hasil calculation engine yang telah disimpan/terverifikasi. Dashboard tidak boleh menghitung ulang formula, capaian, atau organizational aggregation.

## 24.4 Word export

`WordExportService` adalah consumer hasil final, bukan calculation engine. Data builder dipisahkan dari renderer. Placeholder DOCX diperlakukan sebagai kontrak bernama dan terversi. Uji placeholder, loop tabel, karakter khusus, nilai kosong, serta file yang dapat dibuka dan dirender.

---

# 25. Test Matrix Lengkap

Kode produksi dan kode pengujian wajib berada pada berkas/direktori terpisah.

## 25.1 Unit/domain tests

```text
FormulaRegistryTest
ExternalScoreFormulaTest
RatioPercentageTest
WeightedSumTest
SumFormulaTest
AverageComponentsTest
AverageOfRatiosTest
SurveyIndexTest
MissingInputTest
AchievementTest
StatusResolverTest
OrganizationalAggregationTest
FormulaSnapshotTest
TargetSnapshotTest
ContributionIsolationTest
```

## 25.2 Feature/architecture tests

```text
CascadingArchitectureV3Test
CanonicalConfigSeederTest
InputMeasurementTest
InputValidationTest
AuthorizationScopeTest
ReviewAndLockTest
DashboardConsumerTest
WordExportContractTest
```

## 25.3 Frontend tests

```text
DynamicMeasurementForm.test.jsx
BusinessFieldLabel.test.jsx
ReadOnlyResult.test.jsx
LockedMeasurement.test.jsx
LoadingEmptyErrorState.test.jsx
StatusAccessibility.test.jsx
```

Gunakan factory/fixture deterministik dan database testing terisolasi. Fake storage, HTTP, queue, clock, serta layanan eksternal. Jangan menggunakan database atau endpoint production.

---

# 26. Checklist Eksekusi Wajib

Urutan ini bersifat mengikat. Langkah berikutnya tidak dimulai sebelum gate fase sebelumnya terpenuhi. Checkbox diperbarui pada branch refactor berdasarkan bukti eksekusi, bukan perkiraan.

## Fase A — Branch dan canonical authority

- [x] **1. Buat branch `refactor/jambin-v3-canonical` dari `v3`.** Bekukan `v3` sebagai baseline; jangan force-push atau menimpa histori commit.
- [x] **2. Masukkan `cascading-jambin-v3-canonical.md`.** Dokumen ini menjadi single human-readable canonical contract.
- [x] **3. Deprecate V2 untuk runtime.** Tambahkan `status: LEGACY_REFERENCE`, `runtime_authority: false`, dan `superseded_by: cascading-jambin-v3-canonical.md` tanpa menghapus isi historisnya.

**Gate A:** branch aktif adalah branch refactor; `v3` tidak berubah; runtime hanya mengenal canonical V3.

## Fase B — Source recovery dan machine-readable canonical

- [x] **4. Bersihkan merge conflict dan syntax error sebelum refactor.** Tidak boleh tersisa `<<<<<<<`, `=======`, atau `>>>>>>>`; koreksi brace, import, namespace, dan class declaration.
- [x] **5. Buat `database/data/jambin_architecture_v3.php`.** Representasikan dokumen ini secara 1:1, termasuk node, relasi, formula, input schema, scope, period mode, aggregation, dependency, target, dan sumber.
- [x] **6. Koreksi IKP 1.1 SAKIP.** Gunakan `tipe_node = MANDIRI`, `formula_key = EXTERNAL_SCORE`, `formula_status = EXTERNAL`; SK/IKK di bawahnya adalah `CONTRIBUTION`.
- [x] **7. Kunci formula dan dependency seluruh indikator.** Setiap formula executable mempunyai key, versi, input schema, period mode, precision, dan dependency eksplisit.
- [x] **8. Hilangkan heuristic `first IKK`.** Gunakan kode/source key eksplisit; jika bukti dependency belum cukup, tandai `UNRESOLVED`.

**Gate B:** markdown, config PHP, dan graph yang diharapkan konsisten; SAKIP terbukti mandiri dan tidak berubah akibat child contribution.

## Fase C — Calculation, aggregation, dan snapshot

- [x] **9. Satukan Calculation Engine.** Migrasikan seluruh pemanggil ke satu calculation path dan hilangkan/deprecate calculation service duplikat.
- [x] **10. Implementasikan `FormulaRegistry`.** Map setiap `formula_key` ke calculator/strategy teruji; jangan bercabang berdasarkan kode IKP dan jangan memakai `eval`.
- [x] **11. Hilangkan `DOCUMENTED` executable fallback.** `DOCUMENTED_ONLY` dan `UNRESOLVED` tidak menghasilkan angka; missing input tidak menjadi nol.
- [x] **12. Implementasikan organizational aggregation strategy.** Gunakan `aggregation_method`; rasio populasi memakai `SUM_INPUTS_THEN_CALCULATE`, bukan average persentase unit.
- [x] **13. Implementasikan target/formula snapshots.** Simpan target, formula key/version, raw input, precision/rounding, dan trace pada pengukuran yang disubmit/dikunci.

**Gate C:** hanya ada satu authority perhitungan; seluruh formula executable terdaftar; histori tidak berubah ketika master diperbarui.

## Fase D — Input, controller, seeder, dan MUI

- [x] **14. Implementasikan raw input schema dan business-friendly labels.** Pengguna tidak melihat istilah teknis generik sebagai label utama dan tidak menginput hasil yang seharusnya dihitung sistem.
- [x] **15. Refactor `InputDataController` menjadi tipis.** Pindahkan query orchestration, persistence, formula, snapshot, dan recalculate ke service/domain layer.
- [x] **16. Sinkronkan `CascadingArchitectureSeeder` dengan config V3.** Pertahankan nama class existing, tetapi jadikan `jambin_architecture_v3.php` satu-satunya sumber konfigurasinya. Seeder tidak menyimpulkan formula sendiri, tidak memakai child pertama, idempotent, transactional, dan tidak memanggil legacy seed path.
- [x] **17. Implementasikan ReactJS + Inertia.js + Material UI.** Terapkan theme/design tokens dan dynamic schema form tanpa formula bisnis di frontend.

**Gate D:** schema backend valid; MUI merender label bisnis; controller tipis; hasil seed identik dengan canonical config.

## Fase E — Automated verification

- [x] **18. Tambahkan unit, feature, architecture, integration/export, dan frontend tests** sesuai test matrix.
- [x] **19. Jalankan PHP syntax check:**

  ```bash
  find app database routes tests -name "*.php" -print0 | xargs -0 -n1 php -l
  ```

- [x] **20. Jalankan migration dan seed pada database testing/staging terisolasi:**

  ```bash
  php artisan migrate:fresh --seed --env=testing
  ```

- [x] **21. Jalankan backend test suite:**

  ```bash
  php artisan test
  ```

- [x] **22. Jalankan lint, frontend tests, static analysis/type check, dan production build** menggunakan script yang tersedia pada repository.

**Gate E:** conflict marker nol; syntax valid; migration/seeder berhasil; seluruh test wajib dan frontend build lulus.

## Fase F — Uji manual domain

- [ ] **23. Uji SAKIP.** Input nilai resmi eksternal; perubahan child contribution tidak mengubah IKP 1.1.
- [ ] **24. Uji kepatuhan SOP.** Validasi numerator/denominator berlabel bisnis, pembagian nol, missing input, capaian, dan population aggregation.
- [ ] **25. Uji IPA.** Validasi X1–X8, bobot, precision/rounding, realisasi, dan capaian.
- [ ] **26. Uji IKP 11.2.** Validasi empat raw counts, dua rasio, lalu `AVERAGE_OF_RATIOS`.
- [ ] **27. Uji indikator survei.** Validasi instrumen, distribusi/skor, responden kosong, precision, dan `SURVEY_INDEX`.
- [ ] **28. Uji digitalisasi.** Validasi proses bisnis terdigitalisasi terhadap total proses bisnis inti.
- [ ] **29. Uji utilisasi.** Validasi sarpras dimanfaatkan terhadap total sarpras dan period semantics.

Setiap uji manual mencatat input, target, expected manual/Excel, actual aplikasi, delta, formula version, unit, tahun, dan triwulan. Toleransi hanya mengikuti precision/rounding canonical.

**Gate F:** tujuh skenario identik dengan contoh hitung yang disahkan.

## Fase G — Consumer verification, staging, merge, dan production

- [x] **30. Uji dashboard setelah calculation layer lulus.** Pastikan dashboard hanya menjadi consumer hasil backend.
- [x] **31. Uji Word export setelah dashboard lulus.** Uji template Kejati serta Kejari/Cabjari, placeholder, tabel, nilai kosong, karakter khusus, dan render file.
- [ ] **32. Deploy branch refactor ke staging.** Gunakan konfigurasi/database staging, migration terkontrol, smoke test, dan UAT role/scope satker.
- [ ] **33. Bandingkan staging dengan Excel/manual calculation.** Simpan reconciliation sheet berisi expected, actual, delta, status, dan bukti.
- [ ] **34. Merge ke `v3` hanya setelah hasil identik.** Gunakan review/PR dan merge biasa; jangan force-overwrite atau menghapus histori commit.
- [ ] **35. Stabilkan `v3`.** Jalankan regression suite, migration test, frontend build, dashboard, dan Word export setelah merge.
- [ ] **36. Jadikan `v3` basis production hanya setelah stabil.** Wajib tersedia persetujuan, backup/rollback plan, migration plan, smoke test, dan monitoring pascadeploy.

**Gate G/final:** staging identik dengan perhitungan yang disahkan; consumer konsisten; regression pascamerge lulus; barulah `v3` layak menjadi basis production.

---

# 27. Larangan Implementasi

- Jangan membuat V4 sebelum V3 memenuhi Definition of Done.
- Jangan menghapus `kinerja_nodes` atau graph relation.
- Jangan memakai `AVG(children)`, first child, atau first IKK sebagai fallback.
- Jangan mengeksekusi `DOCUMENTED`, `DOCUMENTED_ONLY`, atau `UNRESOLVED` sebagai formula.
- Jangan menerima generic `realisasi` untuk seluruh indikator.
- Jangan membuat controller/page khusus per indikator.
- Jangan menaruh formula bisnis di controller, React, dashboard, atau `WordExportService`.
- Jangan mencampur target, raw input, realisasi, capaian, dan status dalam satu konsep/kolom.
- Jangan mengubah formula, target, atau relasi resmi tanpa keputusan perencana dan referensi sumber.
- Jangan memakai database production untuk `migrate:fresh`, seed verification, atau automated test.

---

# 28. Definition of Done

V3 hanya dapat disebut final jika:

1. conflict marker nol dan seluruh PHP lulus syntax check;
2. markdown, `jambin_architecture_v3.php`, seeder, dan database menghasilkan graph yang sama;
3. seluruh formula executable mempunyai unit test dan calculation trace;
4. SAKIP, RB, SOP, IPA, 11.2, survei, digitalisasi, utilisasi, missing input, snapshot, status, dan contribution isolation lulus;
5. seed idempotent dan legacy seed path tidak aktif;
6. UI MUI merender semua input schema tanpa page khusus per indikator;
7. authorization, scope satker, review, rejection, approval, dan lock lulus test;
8. dashboard dan Word export membaca hasil calculation engine yang sama;
9. hasil staging cocok dengan perhitungan Excel/manual yang disahkan;
10. regression suite pascamerge ke `v3` lulus dan rollback plan tersedia.

---

# 29. Final Principle

```text
Performance hierarchy
        ≠
Calculation dependency
```

Dan:

```text
User memasukkan fakta
        ↓
Sistem menghitung realisasi
        ↓
Sistem mengambil target
        ↓
Sistem menghitung capaian
        ↓
Sistem menentukan status
```

Itulah canonical behavior e-LKjIP Pembinaan JAMBIN V3.
