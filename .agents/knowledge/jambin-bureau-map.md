# JAMBIN Bureau / Cascading Map — Restrukturisasi Input

Dokumen ini mempertahankan peta organisasi/coding dari restrukturisasi yang diberikan untuk agent. Semantik kalkulasinya tunduk pada `cascading-jambin-v3-canonical.md`.

## 1. Biro Perencanaan

### SP 1 — SAKIP Kejaksaan RI

- IKP 1.1 — Nilai SAKIP
  - canonical calculation: `MANDIRI`
  - child semantics default: `CONTRIBUTION`

Child:

- SK 1.1.1 — Perencanaan, Pemantauan, Evaluasi, RB
  - IKK 1.1.1.1 — layanan RB
  - IKK 1.1.1.2 — pendampingan ZI
  - IKK 1.1.1.3 — layanan monev
  - IKK 1.1.1.4 — pengelolaan data kinerja
- SK 1.1.2 — Evaluasi Akuntabilitas Kinerja
  - IKK 1.1.2.1 — SAKIP UKE I
  - IKK 1.1.2.2 — SAKIP satker daerah
- SK 1.1.3 — Kualitas Perencanaan
  - IKK 1.1.3.1 — IPPN
- SK 1.1.4 — Tata Kelola Organisasi Tepat Fungsi
  - IKK 1.1.4.1 — Restrukturisasi
  - IKK 1.1.4.2 — Rencana Aksi RB General

### SP 6 — Kapasitas Kelembagaan

- IKP 6.1 — Nilai Evaluasi Kelembagaan — `MANDIRI`
- IKP 6.2 — Kepatuhan SOP — `MANDIRI`, `RATIO_PERCENTAGE`
  - SK 6.2.1 — Tata Kelola Organisasi UKE I Tepat Fungsi
    - IKK 6.2.1.1 — Rencana Aksi RB Tematik

## 2. Biro Keuangan

### SP 4 — Efisiensi Anggaran

- IKP 4.1 — Nilai Kinerja Anggaran — `MANDIRI/COMPOSITE`
  - SK 4.1.1 — Anggaran UKE I
    - IKK 4.1.1.1 — NKA UKE I
  - SK 4.1.2 — Anggaran Daerah
    - IKK 4.1.2.1 — NKA Satker Daerah

Child tidak otomatis menjadi formula component NKA pusat.

## 3. Biro Perlengkapan

### SP 5 — Tata Kelola Aset & Pengadaan

- IKP 5.1 — Indeks Pengelolaan Aset — `MANDIRI`, weighted composite
- IKP 5.2 — Indeks Tata Kelola Pengadaan — `MANDIRI`

### SP 16 — Sarana & Prasarana

- IKP 16.1 — Utilisasi Sarpras — `MANDIRI`, `RATIO_PERCENTAGE`
  - SK 16.1.1 — Gedung, Rumah Dinas, Mobil, IT, dll
    - IKK 16.1.1.1 s.d. IKK 16.1.1.10

## 4. Biro Umum

### SP 16

- IKP 16.1 — Utilisasi Sarpras
  - SK 16.2.1 — Ketatausahaan Pimpinan, Protokol, Security, RT
    - IKK 16.2.1.1 s.d. IKK 16.2.1.5

## 5. Biro Kepegawaian

### SP 8 — Kuantitas & Kualitas SDM

- IKP 8.1 — Sistem Merit — `MANDIRI`
- IKP 8.2 — Kecukupan SDM — `MANDIRI`, `AVERAGE_COMPONENTS`
- IKP 8.3 — Indeks Profesionalitas — `MANDIRI/COMPOSITE`

Child map:

- SK 8.1.1 — Pembinaan & Pengelolaan
  - IKK 8.1.1.1 s.d. IKK 8.1.1.4
- SK 8.2.1 — Kecukupan & Kesesuaian
  - IKK 8.2.1.1 s.d. IKK 8.2.1.3
- SK 8.3.1 — Pengembangan SDM
  - IKK 8.3.1.1
  - IKK 8.3.1.2
- SK 8.5.1 — ASN Berakhlak
  - IKK 8.5.1.1

## 6. Pustrajakgakum

### SP 7

- IKP 7.1 — Indeks Kualitas Kebijakan — `MANDIRI`

## 7. Biro Hukum & Hubungan Luar Negeri

### SP 7

- IKP 7.2 — Indeks Reformasi Hukum — `MANDIRI`

### SP 13

- IKP 13.1 — Kepuasan Layanan Hukum — `MANDIRI`, survey
- IKP 13.2 — Kepuasan Mitra Luar Negeri — `MANDIRI`, survey
  - SK 13.2.1 — Pelayanan Peraturan, Hukum & HLN
    - IKK 13.2.1.1 s.d. IKK 13.2.1.5

## 8. Pusat Kesehatan Yustisial

### SP 10

- IKP 10.2 — Kepuasan RS/Klinik — `MANDIRI`, survey
  - SK 10.2.1 — Kesehatan Yustisial
    - IKK 10.2.1.1 s.d. IKK 10.2.1.4

Jika struktur level lain menampilkan indikator identik, gunakan `SAME_INDICATOR` hanya jika inheritance semantics telah dikonfigurasi.

## 9. Sekretariat JAMBIN

### SP 10

- IKP 10.1 — Indeks Kepuasan Layanan Dukungan Internal — `MANDIRI`
  - formula mengikuti survey/average documented components
  - child yang benar-benar menjadi operand harus ditandai `FORMULA_COMPONENT`; lainnya `CONTRIBUTION`.

## 10. Pusdaskrimti

### SP 15 — Dukungan TI

- IKP 15.1 — Digitalisasi Bisnis Inti — `MANDIRI`, `RATIO_PERCENTAGE`

Child:

- SK 15.1.1 — Statistik Kriminal & TI
  - IKK 15.1.1.1 s.d. IKK 15.1.1.3
- SK 15.2.1 — Sistem TI / SPPT-TI
  - IKK 15.2.1.1
  - IKK 15.2.1.2
- SK 15.3.1 — Kualitas Data
  - IKK 15.3.1.1 s.d. IKK 15.3.1.4
- SK 15.4.1 — Keamanan TI
  - IKK 15.4.1.1
- SK 15.5.1 — Administrasi Penanganan Perkara
  - IKK 15.5.1.1

Semua child default `CONTRIBUTION` terhadap IKP 15.1 kecuali source canonical menyatakan sebagai operand formula.
