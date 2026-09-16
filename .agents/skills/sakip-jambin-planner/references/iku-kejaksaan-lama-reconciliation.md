# Rekonsiliasi `iku_kejaksaan_lama.md`

## Status dan provenance

- Sumber yang ditelaah: `C:\Users\ACER1\Downloads\iku_kejaksaan_lama.md`.
- Tanggal telaah: 2026-09-16.
- Status: `HISTORICAL_RECONCILIATION_SOURCE`.
- `runtime_authority: false`.
- Dokumen tampak sebagai hasil OCR/transkripsi IKU 2025-2029, tetapi tidak
  memuat metadata keputusan, nomor dokumen, versi, atau bagian awal yang cukup
  untuk membuktikan otoritasnya secara mandiri.
- Jangan mengimpor, men-seed, atau mengeksekusi formula dari dokumen ini secara
  langsung. Rekonsiliasi terhadap dokumen resmi dan canonical V3 terlebih dahulu.

## Temuan formula yang dapat digunakan untuk rekonsiliasi

| Indikator | Bukti dalam sumber | Implikasi rekonsiliasi |
|---|---|---|
| IKP 8.2 | Baris 535-548 mendefinisikan tiga komponen dan `KKP = rata-rata(...)`. | Mendukung `AVERAGE_COMPONENTS`; tidak mendukung bobot 30/40/30 tanpa sumber resmi lain. |
| IKP 11.1 | Baris 745-760 mendefinisikan CFI sebagai total skor kompetensi aktual dibagi total skor kompetensi ideal, dikali 100. | Mendukung `RATIO_PERCENTAGE`; jangan ubah menjadi `DIRECT_VALUE` hanya berdasarkan laporan turunan. |
| IKP 11.2 | Baris 775-790 menghitung dua rasio kelompok lalu merata-ratakannya. | Mendukung `AVERAGE_OF_RATIOS` dengan empat raw count. |
| IKP 16.1 | Baris 997-1006 membagi sarpras yang digunakan dengan total sarpras tahun berjalan. | Mendukung `RATIO_PERCENTAGE`. |

Temuan di atas menguatkan canonical, tetapi tidak menggantikannya. Jika terdapat
konflik dengan dokumen resmi yang provenance-nya lengkap, gunakan urutan source
of truth dalam `AGENT_RULES.md`.

## Konflik yang wajib tetap `UNRESOLVED`

| Indikator | Konflik/ketidaklengkapan | Perlakuan |
|---|---|---|
| IKP 10.1 | Target baris 657 memakai skala 3,6-4,0, sedangkan formula baris 670-675 menormalisasi ke persen. | Jangan mengeksekusi sampai skala keluaran, target, dan variant survei diklarifikasi. |
| IKP 13.1 | Target baris 858 memakai skala 3,6-4,0, sedangkan formula baris 869-871 menghasilkan persen. | `UNRESOLVED`; jangan menyamakan target indeks dengan hasil persen. |
| IKP 13.2 | Target baris 889 memakai skala 3,6-4,0, sedangkan formula baris 899-901 menghasilkan persen. | `UNRESOLVED`; perlu konfirmasi dokumen resmi/instrumen survei. |
| IKP 15.1 | Baris 964-978 mendukung rasio proses terdigitalisasi terhadap total proses bisnis inti, tetapi tidak menetapkan total tetap 4 atau 10. | Formula rasio dapat dipetakan, tetapi nilai/semantik denominator tetap `UNRESOLVED`. |

## Indikasi kesalahan transkripsi

- IKP 6.1 pada baris 321 memakai simbol `NKA`, padahal konteksnya Nilai Evaluasi
  Kelembagaan.
- IKP 7.1 pada baris 412 menjelaskan `NKA` sebagai Indeks Kualitas Kebijakan;
  simbol yang tampil pada formula adalah `IKK`.
- IKP 10.2 diberi header `Indikator Kinerja Kegiatan (IKK)` meskipun kodenya
  ditulis IKP 10.2.
- Persamaan dan tabel mengandung karakter OCR rusak. Jangan melakukan parsing
  formula otomatis tanpa verifikasi visual terhadap sumber resmi.

## Batas cakupan dan identitas data

- Berkas dimulai sekitar halaman 16 sehingga bagian awal, termasuk IKP 1.1
  Nilai SAKIP, tidak lengkap.
- Dokumen mencakup program selain Dukungan Manajemen. Kode indikator dapat
  digunakan ulang pada konteks program berbeda.
- Jangan gunakan `kode indikator` saja sebagai natural key. Sertakan program,
  sasaran, level, periode/versi, dan ownership yang relevan.
- Indikator di luar scope JAMBIN canonical harus diperlakukan sebagai
  `REFERENCE` atau scope program terpisah; jangan digabung hanya karena kode
  atau namanya mirip.

## Aturan keputusan

1. Pertahankan perhitungan dinamis berbasis `formula_key`, input schema, variant,
   normalization/reference, precision, dan formula version.
2. Jangan hard-code formula berdasarkan kode indikator.
3. Jangan menganggap child sebagai operand tanpa relasi `FORMULA_COMPONENT`.
4. Jika skala, denominator, bobot, atau variant formula belum pasti, tetapkan
   `formula_status = UNRESOLVED` dan larang engine menghitung.
5. Catat dokumen ini sebagai provenance rekonsiliasi pada audit, bukan sebagai
   dasar tunggal untuk mengubah canonical atau runtime.
