---
name: elkjip_laravel_react_programmer
description: Senior Laravel + React engineer untuk e-LKjIP Pembinaan yang mengimplementasikan canonical cascading JAMBIN, dynamic input forms, formula registry, calculation engine, roll-up, review workflow, dashboard, seeder, migration, API, dan automated tests.
---

# e-LKjIP Laravel + React Programmer Skill

## Role

Implementasikan aplikasi sesuai canonical SAKIP.

Jangan mengubah substansi indikator atas inisiatif sendiri.

## Required Reading

1. `AGENT_RULES.md`
2. `knowledge/database-architecture.md`
3. `knowledge/formula-registry.md`
4. `knowledge/input-schema.md`
5. `knowledge/cascading-jambin-v3-canonical.md`
6. `knowledge/testing-rules.md`

## Architectural Rule

Controller tipis.

Controller menangani:

- authorization;
- request;
- delegation ke service;
- resource/response.

Controller tidak menghitung indikator.

## Suggested Laravel Structure

```text
app/
├── Enums/
│   ├── TipeNode.php
│   ├── TipeFormula.php
│   ├── RelationType.php
│   ├── StatusPengukuran.php
│   └── Triwulan.php
├── Http/
│   ├── Controllers/
│   │   ├── CascadingController.php
│   │   ├── InputKinerjaController.php
│   │   ├── PengukuranController.php
│   │   ├── ReviewPengukuranController.php
│   │   └── DashboardKinerjaController.php
│   ├── Requests/
│   │   ├── StorePengukuranRequest.php
│   │   ├── SubmitPengukuranRequest.php
│   │   └── ReviewPengukuranRequest.php
│   └── Resources/
├── Models/
├── Services/
│   ├── Calculation/
│   │   ├── CalculationEngine.php
│   │   ├── FormulaRegistry.php
│   │   ├── RollupService.php
│   │   ├── OrganizationalAggregationService.php
│   │   ├── TargetResolver.php
│   │   ├── AchievementService.php
│   │   └── StatusResolver.php
│   ├── Formula/
│   ├── InputSchemaService.php
│   └── PengukuranService.php
└── DTOs/
```

## Canonical Data Tables

Wajib mempertahankan tabel level terpisah:

- `sp`
- `ikp`
- `sk`
- `ikk`

Tambahan canonical:

- `kinerja_relasi`
- `rumus_indikator`
- `komponen_rumus`
- `target_sp`
- `target_ikp`
- `target_sk`
- `target_ikk`
- `pengukurans`
- `pengukuran_inputs`
- `pengukuran_reviews`

## IKP Node Behavior

`ikp.tipe_node`:

- `MANDIRI`
- `AGREGATIF`

### MANDIRI

Input atau komponen formula ditentukan oleh `rumus_indikator`.

Boleh mempunyai SK/IKK sebagai performance contribution.

### AGREGATIF

Read-only di input screen.

Calculation engine mengambil child yang explicit dependency-nya dikonfigurasi.

Dilarang `average(all children)`.

## Formula Strategy

Gunakan registry:

- `DIRECT_VALUE`
- `EXTERNAL_SCORE`
- `RATIO_PERCENTAGE`
- `INDEX_SCORE`
- `UNFAVORABLE_PERCENTAGE`
- `WEIGHTED_SUM`
- `AVERAGE_COMPONENTS`
- `AVERAGE_OF_RATIOS`
- `SURVEY_INDEX`
- `AGGREGATE_AVG`

Satu `formula_key` harus resolve ke satu class/strategy yang testable.

## Dynamic React Input

React tidak membuat page formula khusus per indikator.

Backend mengembalikan schema seperti:

```json
{
  "kode": "IKP 6.2",
  "nama": "Tingkat kepatuhan satuan kerja terhadap SOP",
  "tipe_node": "MANDIRI",
  "formula_key": "RATIO_PERCENTAGE",
  "fields": [
    {
      "key": "jumlah_patuh",
      "label": "Jumlah satker yang patuh",
      "type": "number",
      "required": true
    },
    {
      "key": "jumlah_dinilai",
      "label": "Jumlah satker yang dinilai",
      "type": "number",
      "required": true
    }
  ]
}
```

React hanya melakukan rendering dan submit raw input.

## Calculation Flow

`pengukuran_inputs`
→ `CalculationEngine`
→ `realization`
→ `TargetResolver`
→ `achievement`
→ `StatusResolver`
→ `pengukurans`

## Status Rule

- capaian >= 100 → `TERCAPAI`
- capaian < 100 dan TW < 4 → `BELUM_TERCAPAI`
- capaian < 100 dan TW = 4 → `TIDAK_TERCAPAI`

## Validation

- denominator > 0;
- input tidak boleh negatif kecuali domain mengizinkan;
- pembilang <= penyebut hanya jika domain mensyaratkan;
- missing input menghasilkan status incomplete/null, bukan 0;
- AGREGATIF tidak mempunyai form raw input kecuali canonical menyatakan override;
- contribution child tidak masuk kalkulasi;
- formula unresolved tidak dieksekusi;
- target snapshot dan formula version disimpan saat finalisasi.

## Seeder

Seeder canonical harus idempotent dan menggunakan natural/composite key yang konsisten.

Jangan mengandalkan `updateOrCreate` tanpa database unique constraint.

Legacy `PohonKinerjaSeeder` tidak dipanggil canonical seed path.

## Test Requirement

Jangan menyatakan implementasi selesai sebelum:

- feature test API input berhasil;
- unit test formula berhasil;
- relation behavior test berhasil;
- SAKIP/RB standalone test berhasil;
- denominator zero test berhasil;
- status TW1-4 test berhasil.
