> Dokumen canonical: `.agents/knowledge/cascading-jambin-v3-canonical.md`.
> Tabel runtime tetap `kinerja_*`; struktur UI/UX sumber dibekukan untuk e-laptriv4.

# Project-Specific Rules for e-LKjIP Pembinaan

## 1. Source of Truth
- Gunakan Renstra Kejaksaan RI 2025-2029 dan Kepja 1184 Tahun 2025 sebagai sumber resmi nama, kode, target, definisi, dan formula indikator.
- `database/data/kinerja_jambin_2025_2029.json` menyimpan transkripsi sumber; `database/data/jambin_architecture_v3.php` menyimpan klasifikasi arsitektur aplikasi.
- Jangan mengubah hubungan atau formula hanya berdasarkan kemiripan nama. Relasi analitis harus diberi tipe yang eksplisit.

## 2. Canonical Performance Graph
- `kinerja_nodes` adalah identitas canonical seluruh SS/IKSS/SP/IKP/SK/IKK.
- Tabel `kinerja_ss`, `kinerja_ikss`, `kinerja_sp`, `kinerja_ikp`, `kinerja_sk`, dan `kinerja_ikk` adalah detail per jenis node dan tetap dipertahankan untuk nomenklatur/domain fields.
- Graph dapat berupa DAG dan tidak harus linear SS -> IKSS -> SP -> IKP -> SK -> IKK.
- Jangan menggunakan `pohon_kinerjas.parent_id` sebagai sumber utama perhitungan baru.

## 3. Relation Semantics
- Enforce the composite unique key `UNIQUE(kode_*, tahun, triwulan)` on the respective target/measurement tables. *Note: As approved, a unified `kinerja_targets` and `kinerja_pengukurans` table architecture is permitted, provided the composite uniqueness by node and period is maintained.*
Gunakan `kinerja_relasi.jenis_relasi` secara eksplisit:
- `STRUCTURAL`: pasangan sasaran-indikator resmi pada level yang sama.
- `CASCADING`: hubungan penjenjangan outcome/output, tanpa implikasi matematis otomatis.
- `FORMULA_COMPONENT`: child adalah operand langsung formula parent.
- `CONTRIBUTION`: child mendukung outcome parent tetapi tidak dihitung otomatis ke parent.
- `SAME_INDICATOR`: indikator yang sama diturunkan pada level lain; nilai dapat diteruskan tanpa dirata-ratakan dengan indikator lain.
- `ORG_AGGREGATION`: konsolidasi indikator antarunit/satker.
- `REFERENCE`: hubungan referensi/enabler saja.

DILARANG menghitung parent dengan `average(all children)` hanya karena parent mempunyai anak.

## 4. Calculation Types
`kinerja_nodes.calculation_type` dan formula aktif harus menggunakan salah satu:
- `DIRECT_VALUE`
- `EXTERNAL_SCORE`
- `RATIO`
- `AVERAGE`
- `SUM`
- `WEIGHTED_SUM`
- `COUNT`
- `SURVEY_INDEX`
- `CUSTOM`
- `DOCUMENTED` hanya sebagai fallback untuk formula yang belum dinormalisasi.

Formula component disimpan pada `kinerja_komponen_rumus` dan sumbernya harus eksplisit:
- `INPUT`: nilai mentah X1/X2/... dari `kinerja_pengukuran_inputs`.
- `INDICATOR`: nilai realisasi node indikator lain melalui `source_node_id`.

Hanya relasi `FORMULA_COMPONENT` yang boleh dipakai untuk generic child-based AVERAGE/SUM/COUNT.

## 5. Measurement Semantics
- `realisasi` adalah hasil formula indikator pada satuan indikator.
- `capaian` adalah capaian terhadap target, umumnya `(realisasi / target) x 100%` untuk arah kinerja positif.
- Jangan menyimpan pembilang sebagai realisasi jika formula indikator adalah rasio.
- Simpan input formula mentah pada `kinerja_pengukuran_inputs`; jangan memadatkan X1..Xn ke satu kolom.
- Target tahunan tetap disimpan pada `kinerja_targets` dan terpisah dari pengukuran.

## 6. Seeder Rules
Urutan canonical seed:
1. dokumen dan unit kerja;
2. node SS/IKSS/SP/IKP/SK/IKK;
3. referensi dan relasi dasar;
4. unit-node;
5. rumus dan target;
6. `CascadingArchitectureSeeder` sebagai normalisasi final tipe kalkulasi, komponen rumus, dan semantik relasi.

`PohonKinerjaSeeder` adalah legacy dan tidak boleh dipanggil oleh `DatabaseSeeder` untuk arsitektur canonical baru.

## 7. UI/UX
- Form input harus membaca `node.input_enabled`, bukan label `MANDIRI/AGREGATIF`.
- Jika formula mempunyai komponen INPUT, tampilkan field berdasarkan `node.formulas.components` beserta nama komponen, bobot, dan petunjuk formula.
- Tampilkan `realisasi`, `target`, dan `capaian terhadap target` sebagai tiga konsep terpisah.

## 8. Testing
Minimal uji:
- seed dapat dijalankan idempotent;
- IKP 10.1 mandiri; SK/IKK kontribusi tidak menjadi operand otomatis;
- IKP 5.1 tidak merata-ratakan IKK kontribusi;
- SAME_INDICATOR tidak menjadi average;
- weighted formula memakai bobot komponen;
- capaian dihitung setelah realisasi dan target tersedia.
