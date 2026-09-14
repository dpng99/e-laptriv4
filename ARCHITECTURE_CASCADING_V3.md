# Arsitektur Cascading SAKIP V3 — JAMBIN

## Tujuan

Arsitektur V3 memisahkan **hierarki/kontribusi kinerja** dari **dependency formula**. Keberadaan SK/IKK di bawah IKP tidak berarti nilai IKP dihitung dengan rata-rata seluruh child.

## Model canonical

- `kinerja_nodes`: identitas seluruh SS, IKSS, SP, IKP, SK, IKK serta metadata kalkulasi.
- tabel detail `kinerja_ss`, `kinerja_ikss`, `kinerja_sp`, `kinerja_ikp`, `kinerja_sk`, `kinerja_ikk`: nomenklatur khusus per level.
- `kinerja_relasi`: graph/DAG hubungan kinerja.
- `kinerja_rumus_indikators`: definisi formula indikator.
- `kinerja_komponen_rumus`: komponen X1..Xn, bobot, dan sumber komponen.
- `kinerja_pengukuran_inputs`: nilai mentah komponen formula per pengukuran.
- `kinerja_targets`: target resmi tahunan/periode.
- `kinerja_pengukurans`: hasil realisasi dan capaian terhadap target.

## Relation types

| Type | Fungsi |
|---|---|
| `STRUCTURAL` | pasangan sasaran-indikator resmi |
| `CASCADING` | penjenjangan kinerja tanpa operasi matematika otomatis |
| `FORMULA_COMPONENT` | child adalah operand formula parent |
| `CONTRIBUTION` | child berkontribusi tetapi bukan operand formula |
| `SAME_INDICATOR` | indikator sama di level berbeda |
| `ORG_AGGREGATION` | konsolidasi antarunit/satker |
| `REFERENCE` | hubungan referensi/enabler |

## Calculation types

`DIRECT_VALUE`, `EXTERNAL_SCORE`, `RATIO`, `AVERAGE`, `SUM`, `WEIGHTED_SUM`, `COUNT`, `SURVEY_INDEX`, `CUSTOM`, dan fallback `DOCUMENTED`.

Calculation engine tidak boleh melakukan `average(all children)`. Generic AVERAGE/SUM/COUNT hanya membaca relasi `FORMULA_COMPONENT`.

## Semantik pengukuran

- **Input mentah**: X1..Xn, pembilang, penyebut, atau distribusi rating.
- **Realisasi**: hasil formula indikator pada satuan indikator.
- **Target**: nilai resmi dari `kinerja_targets`.
- **Capaian terhadap target**: dihitung setelah realisasi tersedia, umumnya `(realisasi / target) × 100%` untuk indikator positif.

Ketiga angka tersebut tidak boleh disamakan atau ditimpa satu sama lain.

## JAMBIN

Program Dukungan Manajemen yang masuk scope JAMBIN pada dataset canonical: SP 1, 4, 5, 6, 7, 8, 10, 11, 13, 15, dan 16.

`database/data/jambin_architecture.php` menjadi konfigurasi eksplisit untuk:

1. `calculation_type` per IKP;
2. `formula_key`;
3. komponen formula dan bobot;
4. permission input;
5. semantik relasi IKP→SK.

Contoh penting:

- IKP 5.1 IPA: `WEIGHTED_SUM` dari 8 parameter; SK/IKK aset adalah `CONTRIBUTION`.
- IKP 8.2: `AVERAGE` dari komponen kecukupan, pengembangan, dan pengelolaan SDM.
- IKP 10.1: `AVERAGE` nyata dari child yang ditandai `FORMULA_COMPONENT`.
- IKP 10.2: hubungan turunannya `SAME_INDICATOR`, bukan rata-rata seluruh IKK kesehatan.

## Seeder order

`DatabaseSeeder` menjalankan dataset dasar terlebih dahulu kemudian `CascadingArchitectureSeeder` sebagai normalisasi final. `PohonKinerjaSeeder` tidak lagi dijalankan oleh canonical seed path.

## Migrasi existing database

Untuk database yang sudah memiliki tabel V2:

```bash
php artisan migrate
php artisan db:seed --class=DatabaseSeeder
```

Seeder dirancang menggunakan `updateOrCreate` agar dapat dijalankan ulang. Sebelum deployment produksi, tetap lakukan backup database dan jalankan migration/seed pada staging terlebih dahulu.

## Validasi

Test `CascadingArchitectureV3Test` memeriksa minimal:

- IKP 10.1 mempunyai child `FORMULA_COMPONENT`;
- IKP 5.1 memiliki 8 komponen formula dan SK child bukan operand formula;
- IKP 10.2 mempunyai relasi `SAME_INDICATOR`;
- seluruh SP JAMBIN tersedia;
- tidak ada legacy relation `DIRECT` pada IKP JAMBIN.
