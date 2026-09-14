# AGENT RULES — e-LKjIP Pembinaan / JAMBIN V3

Dokumen ini wajib dibaca sebelum agent mengubah cascading, formula, database, seeder, controller, service, API, React UI, dashboard, atau test.

## 1. Source of Truth

Urutan rujukan domain: dokumen resmi, dataset yang direkonsiliasi, lalu
`knowledge/cascading-jambin-v3-canonical.md` dan pasangan machine-readable
`database/data/jambin_architecture_v3.php`. Dokumen turunan bukan authority paralel.
Instruksi eksplisit pengguna mengatur lingkup pekerjaan. Pada e-laptriv4, UI/UX
branch sumber harus dipertahankan. Nama repository baru tidak mengubah versi
kontrak domain V3.1.

Jangan mengubah kode/nama indikator resmi tanpa dasar pada source of truth.

## 2. Fundamental Separation

Selalu bedakan:

- **Performance Graph**: hubungan sasaran, indikator, kegiatan, kontribusi.
- **Calculation Graph**: dependency yang benar-benar menghasilkan angka.

Aturan non-negotiable:

> Punya child SK/IKK tidak berarti nilai IKP dihitung dari child.

## 3. Node Types

### MANDIRI
Indikator memiliki sumber nilai atau formula sendiri.

MANDIRI boleh mempunyai SK/IKK di bawahnya sebagai `CONTRIBUTION`, `CASCADING`, `REFERENCE`, atau `SAME_INDICATOR`.

MANDIRI tidak boleh dihitung dengan `average(all children)`.

### AGREGATIF
Nilai indikator memang secara eksplisit dihitung dari node child yang dikonfigurasi sebagai operand.

AGREGATIF hanya boleh membaca child dengan dependency kalkulasi eksplisit, terutama `FORMULA_COMPONENT`.

## 4. Relation Types

Allowed:

- `STRUCTURAL`
- `CASCADING`
- `FORMULA_COMPONENT`
- `CONTRIBUTION`
- `SAME_INDICATOR`
- `ORG_AGGREGATION`
- `REFERENCE`

Calculation engine:

- BOLEH membaca `FORMULA_COMPONENT`.
- BOLEH membaca `ORG_AGGREGATION` jika aggregation strategy dikonfigurasi.
- TIDAK BOLEH menghitung dari `STRUCTURAL`, `CASCADING`, `CONTRIBUTION`, atau `REFERENCE`.
- `SAME_INDICATOR` harus mempunyai inheritance mode eksplisit.

## 5. Measurement Semantics

Empat konsep harus selalu terpisah:

1. `RAW INPUT`
2. `TARGET`
3. `REALIZATION`
4. `ACHIEVEMENT`

Untuk indikator positif, default capaian:

`achievement = realization / target * 100`

Target bukan denominator untuk rumus realisasi.

Belum ada input bukan berarti realisasi `0`.

## 6. Input Philosophy

Prioritaskan input data faktual.

Contoh benar:

- Jumlah satker yang patuh
- Jumlah satker yang dinilai

Contoh yang tidak diprioritaskan:

- User mengetik realisasi 84%

Jika hasil dapat dihitung sistem, hasil harus read-only.

Untuk indikator kepatuhan, input berupa **jumlah**, bukan checklist dokumen/satker.

## 7. Ratio Aggregation

Untuk rasio antarunit/satker, jika canonical menentukan agregasi populasi:

`SUM(numerator) / SUM(denominator) * 100`

Jangan gunakan average persentase unit kecuali secara eksplisit diperintahkan formula resmi.

## 8. Formula

Jangan menyimpan PHP/JavaScript executable formula dan jangan menggunakan `eval()`.

Gunakan `formula_key` + calculator class/strategy.

Jika formula belum dapat dipastikan:

- `formula_status = UNRESOLVED`
- engine dilarang menghitung.

Jangan menciptakan formula.

## 9. Coding Architecture

Controller harus tipis.

Business logic berada di:

- Service
- Calculation Engine
- Formula Strategy
- Rollup/Aggregation Service
- Target Resolver
- Status Resolver
- Input Schema Service

Dilarang membuat logika seperti:

```php
if ($kode === 'IKP 6.2') { ... }
elseif ($kode === 'IKP 15.1') { ... }
```

Rumus harus dipilih melalui konfigurasi canonical.

## 10. React Rules

React tidak boleh hard-code formula indikator.

React harus merender form berdasarkan schema API.

User melihat label bisnis seperti:

`Jumlah satker yang patuh`

bukan:

`numerator`

## 11. Target Tables

Target hanya menyimpan target.

Jangan gunakan tabel `target_*` sebagai tempat raw input atau realisasi.

Unique constraint minimal:

`UNIQUE(kode_*, tahun, triwulan)`

atau foreign-key equivalent yang menjamin satu target per indikator/periode.

## 12. Status Dashboard

- `capaian >= 100%` → `TERCAPAI`
- `capaian < 100% && triwulan < 4` → `BELUM_TERCAPAI`
- `capaian < 100% && triwulan == 4` → `TIDAK_TERCAPAI`

## 13. Audit & Versioning

Pengukuran final harus merekam snapshot minimal:

- target yang digunakan
- formula version yang digunakan
- realisasi
- capaian
- timestamp kalkulasi
- user submit/review

Perubahan master formula/target tidak boleh mengubah histori pengukuran final.

## 14. Testing

Setiap perubahan calculation behavior wajib memiliki automated test.

Minimal test:

- MANDIRI tidak roll-up child.
- CONTRIBUTION tidak dibaca calculation engine.
- AGREGATIF hanya membaca configured child.
- ratio denominator 0 ditolak.
- missing input != 0.
- SAKIP tidak average SK/IKK.
- RB tidak average SP/IKP.
- target != realization.
- achievement dihitung setelah realization.
