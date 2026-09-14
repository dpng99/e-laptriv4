---
name: sicana_jambin_cascading
description: Cheatsheet and calculation engine rules for SAKIP & Renstra Kejaksaan RI 2025-2029 (JAMBIN Restrukturisasi v2)
---

> HISTORIS — runtime_authority: false. Definisi leaf/aggregate di bawah telah digantikan
> oleh `.agents/knowledge/cascading-jambin-v3-canonical.md`. Jangan menggunakannya
> untuk menentukan formula atau mengubah schema runtime.


# SAKIP & Renstra Cascading Cheatsheet (Restrukturisasi v2)

Use this skill when implementing database seeders, query logic, calculation engines, or API endpoints for SAKIP/Renstra indicator tracking (Pohon Kinerja & Pengukuran).

## Node Types (Restrukturisasi v2)
1. **IKP Mandiri (Leaf Node)**: Indikator Kinerja Program that stops at the IKP level (No SK/IKK children). Values come directly from external evaluations or index scores (e.g. IPA, ITKP, IRH, IKK LAN, SPBE). Inputs are stored directly in the `pengukurans` table for the IKP.
2. **IKP Agregatif (Roll-Up)**: Indikator Kinerja Program that has child SK & IKK nodes underneath it. Achievement values are recursively calculated bottom-up from child SKs and IKKs.

## Cascading Structure & Pengampu Bureau Map (Restrukturisasi v2)

1. **Biro Perencanaan**:
   - `SP 1` (SAKIP Kejaksaan RI) -> `IKP 1.1` [Agregatif] (Nilai SAKIP)
     - `SK 1.1.1` (Perencanaan, Pemantauan, Evaluasi, RB) -> `IKK 1.1.1.1` (layanan RB), `IKK 1.1.1.2` (pendampingan ZI), `IKK 1.1.1.3` (layanan monev), `IKK 1.1.1.4` (pengelolaan data kinerja)
     - `SK 1.1.2` (Evaluasi Akuntabilitas Kinerja) -> `IKK 1.1.2.1` (SAKIP UKE I), `IKK 1.1.2.2` (SAKIP satker daerah)
     - `SK 1.1.3` (Kualitas Perencanaan) -> `IKK 1.1.3.1` (IPPN)
     - `SK 1.1.4` (Tata Kelola Organisasi Tepat Fungsi) -> `IKK 1.1.4.1` (Restrukturisasi), `IKK 1.1.4.2` (Rencana Aksi RB General)
   - `SP 6` (Kapasitas Kelembagaan) -> `IKP 6.1` [Mandiri] (Nilai Evaluasi Kelembagaan), `IKP 6.2` [Agregatif] (Kepatuhan SOP)
     - `SK 6.2.1` (Tata Kelola Organisasi UKE I Tepat Fungsi) -> `IKK 6.2.1.1` (Rencana Aksi RB Tematik)

2. **Biro Keuangan**:
   - `SP 4` (Efisiensi Anggaran) -> `IKP 4.1` [Agregatif] (Nilai Kinerja Anggaran)
     - `SK 4.1.1` (Anggaran UKE I) -> `IKK 4.1.1.1` (NKA UKE I)
     - `SK 4.1.2` (Anggaran Daerah) -> `IKK 4.1.2.1` (NKA Satker Daerah)

3. **Biro Perlengkapan**:
   - `SP 5` (Tata Kelola Aset & Pengadaan) -> `IKP 5.1` [Mandiri] (Indeks Pengelolaan Aset), `IKP 5.2` [Mandiri] (Indeks Tata Kelola Pengadaan)
   - `SP 16` (Sarana & Prasarana) -> `IKP 16.1` [Agregatif] (Utilisasi Sarpras)
     - `SK 16.1.1` (Gedung, Rumah Dinas, Mobil, IT, dll) -> `IKK 16.1.1.1` to `IKK 16.1.1.10`

4. **Biro Umum**:
   - `SP 16` (Sarana & Prasarana) -> `IKP 16.1` [Agregatif] (Utilisasi Sarpras)
     - `SK 16.2.1` (Ketatausahaan Pimpinan, Protokol, Security, RT) -> `IKK 16.2.1.1` to `IKK 16.2.1.5`

5. **Biro Kepegawaian**:
   - `SP 8` (Kuantitas & Kualitas SDM) -> `IKP 8.1` [Mandiri] (Sistem Merit), `IKP 8.2` [Mandiri] (Kecukupan SDM), `IKP 8.3` [Agregatif] (Indeks Profesionalitas)
     - `SK 8.1.1` (Pembinaan & Pengelolaan) -> `IKK 8.1.1.1` to `IKK 8.1.1.4`
     - `SK 8.2.1` (Kecukupan & Kesesuaian) -> `IKK 8.2.1.1` to `IKK 8.2.1.3`
     - `SK 8.3.1` (Pengembangan SDM) -> `IKK 8.3.1.1`, `IKK 8.3.1.2`
     - `SK 8.5.1` (ASN Berakhlak) -> `IKK 8.5.1.1`

6. **Pustrajakgakum**:
   - `SP 7` (Kualitas Kebijakan Penegakan Hukum) -> `IKP 7.1` [Mandiri] (Indeks Kualitas Kebijakan)

7. **Biro Hukum & Hubungan Luar Negeri**:
   - `SP 7` (Kualitas Kebijakan Penegakan Hukum) -> `IKP 7.2` [Mandiri] (Indeks Reformasi Hukum)
   - `SP 13` (Layanan Hukum & Hubungan Luar Negeri) -> `IKP 13.1` [Mandiri] (Kepuasan Layanan Hukum), `IKP 13.2` [Agregatif] (Kepuasan Mitra Luar Negeri)
     - `SK 13.2.1` (Pelayanan Peraturan, Hukum & HLN) -> `IKK 13.2.1.1` to `IKK 13.2.1.5`

8. **Pusat Kesehatan Yustisial**:
   - `SP 10` (Dukungan Manajemen & Kesehatan Yustisial) -> `IKP 10.2` [Agregatif] (Kepuasan RS/Klinik)
     - `SK 10.2.1` (Kesehatan Yustisial) -> `IKK 10.2.1.1` to `IKK 10.2.1.4`

9. **Sekretariat JAMBIN**:
   - `SP 10` (Dukungan Manajemen & Kesehatan Yustisial) -> `IKP 10.1` [Mandiri] (Indeks Kepuasan Layanan Dukungan Internal)

10. **Pusdaskrimti**:
    - `SP 15` (Dukungan TI) -> `IKP 15.1` [Agregatif] (Digitalisasi Bisnis Inti)
      - `SK 15.1.1` (Statistik Kriminal & TI) -> `IKK 15.1.1.1` to `IKK 15.1.1.3`
      - `SK 15.2.1` (Sistem TI / SPPT-TI) -> `IKK 15.2.1.1`, `IKK 15.2.1.2`
      - `SK 15.3.1` (Kualitas Data) -> `IKK 15.3.1.1` to `IKK 15.3.1.4`
      - `SK 15.4.1` (Keamanan TI) -> `IKK 15.4.1.1`
      - `SK 15.5.1` (Administrasi Penanganan Perkara) -> `IKK 15.5.1.1`

## Implementation Guidance for Calculation rollup (Restrukturisasi Database v2):
- The architecture uses distinct tables for indicators: `sp`, `ikp`, `sk`, `ikk`. Target data and realizations are stored in respective target tables: `target_sp`, `target_ikp`, `target_sk`, `target_ikk`.
- Formula properties are stored in `rumus_indikator` (related to leaf nodes).
- The engine (`IkssCalculationEngine.php`) performs bottom-up recursive rollups:
  - **Leaf Node (`IKK` or `IKP Mandiri`)**: Populated directly by users/operators in `target_ikk` and `target_ikp`. Descriptions from `rumus_indikator` MUST be shown as tooltips in the input UI.
  - **`SK`**: Average or aggregate of child `IKK`s, stored in `target_sk`.
  - **`IKP Agregatif`**: Calculated from child `SK`s, stored in `target_ikp`.
  - **`SP`**: Aggregate of child `IKP`s (both Agregatif and Mandiri), stored in `target_sp`.
- **Dashboard Status Logic**: 
  - Capaian >= 100% -> "Tercapai". 
  - Capaian < 100% (Triwulan 1-3) -> "Belum Tercapai". 
  - Capaian < 100% (Triwulan 4) -> "Tidak Tercapai".
