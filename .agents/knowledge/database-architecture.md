> Referensi rancangan lama. Implementasi aktif menggunakan `kinerja_nodes`, detail
> `kinerja_sp/ikp/sk/ikk`, `kinerja_targets`, `kinerja_pengukurans`, dan
> `kinerja_pengukuran_inputs`. Pertahankan tabel tersebut sesuai keputusan pengguna.

# Database Architecture — e-LKjIP Pembinaan V3

## 1. Database Strategy

Gunakan satu database aplikasi.

Pertahankan tabel level terpisah:

- `sp`
- `ikp`
- `sk`
- `ikk`

Gunakan tabel relasi/dependency dan tabel formula untuk menghindari hard-code.

## 2. sp

Suggested columns:

```text
id
kode_sp
nama_sp
program_code
pengampu_unit_id nullable
is_active
timestamps
```

Unique:

`UNIQUE(kode_sp)`

## 3. ikp

```text
id
sp_id
kode_ikp
nama_ikp
tipe_node               MANDIRI|AGREGATIF
calculation_type
formula_key nullable
formula_status
satuan
polaritas                POSITIVE|NEGATIVE|NEUTRAL
period_mode
pengampu_unit_id nullable
is_active
timestamps
```

Unique:

`UNIQUE(kode_ikp)`

## 4. sk

```text
id
kode_sk
nama_sk
pengampu_unit_id nullable
is_active
timestamps
```

## 5. ikk

```text
id
sk_id
kode_ikk
nama_ikk
calculation_type
formula_key nullable
formula_status
satuan
polaritas
period_mode
pengampu_unit_id nullable
is_active
timestamps
```

## 6. kinerja_relasi

Graph relation across levels.

```text
id
parent_type
parent_id
child_type
child_id
relation_type
aggregation_method nullable
value_inheritance_mode nullable
weight nullable
sequence
metadata json nullable
timestamps
```

Allowed relation:

- STRUCTURAL
- CASCADING
- FORMULA_COMPONENT
- CONTRIBUTION
- SAME_INDICATOR
- ORG_AGGREGATION
- REFERENCE

Unique:

`UNIQUE(parent_type,parent_id,child_type,child_id,relation_type)`

## 7. rumus_indikator

```text
id
indikator_type          IKP|IKK|IKSS optional if expanded
indikator_id
formula_key
formula_status
formula_version
description
formula_display nullable
effective_from_year
effective_to_year nullable
metadata json nullable
is_active
timestamps
```

Unique:

`UNIQUE(indikator_type, indikator_id, formula_version)`

## 8. komponen_rumus

Internal components/raw variables.

```text
id
rumus_indikator_id
key
label
role
input_type
data_type
satuan nullable
weight nullable
default_value nullable
is_required
is_editable
sequence
description nullable
metadata json nullable
timestamps
```

Roles:

- DIRECT_INPUT
- NUMERATOR
- DENOMINATOR
- NUMERATOR_COMPONENT
- DENOMINATOR_COMPONENT
- COMPONENT
- WEIGHT
- MULTIPLIER

## 9. target_sp

```text
id
sp_id
tahun
triwulan
target_numeric nullable
target_text nullable
timestamps
```

Unique:

`UNIQUE(sp_id,tahun,triwulan)`

## 10. target_ikp

Same pattern:

`UNIQUE(ikp_id,tahun,triwulan)`

## 11. target_sk

`UNIQUE(sk_id,tahun,triwulan)`

## 12. target_ikk

`UNIQUE(ikk_id,tahun,triwulan)`

## 13. pengukurans

Stores measurement header + calculated result.

```text
id
indikator_type
indikator_id
unit_id
tahun
triwulan
status
target_source_id nullable
target_value_snapshot nullable
target_text_snapshot nullable
formula_id_snapshot nullable
formula_version_snapshot nullable
realisasi_numeric nullable
realisasi_text nullable
capaian nullable
status_capaian nullable
submitted_by nullable
submitted_at nullable
reviewed_by nullable
reviewed_at nullable
calculated_at nullable
timestamps
```

Unique recommended:

`UNIQUE(indikator_type,indikator_id,unit_id,tahun,triwulan)`

## 14. pengukuran_inputs

```text
id
pengukuran_id
komponen_rumus_id nullable
input_key
numeric_value nullable
text_value nullable
source_type
entered_by nullable
timestamps
```

Unique:

`UNIQUE(pengukuran_id,input_key)`

## 15. pengukuran_reviews

```text
id
pengukuran_id
reviewer_id
action
notes nullable
created_at
```

Actions:

- SUBMIT
- APPROVE
- REVISION
- REOPEN

## 16. Optional Tables

Recommended when needed:

- `units`
- `users`
- `roles`
- `permissions`
- `audit_logs`
- `pengukuran_attachments`
- `data_sources`

## 17. Separation Guarantee

Target table:

- target only.

Pengukuran input:

- raw input only.

Pengukuran:

- realization/achievement result.

Jangan menimpa konsep satu sama lain.

## 18. Seeder Order

Recommended:

```text
UnitSeeder
User/Role Seeder
SpSeeder
IkpSeeder
SkSeeder
IkkSeeder
KinerjaRelasiSeeder
RumusIndikatorSeeder
KomponenRumusSeeder
TargetSeeder
CascadingArchitectureSeeder
```

`CascadingArchitectureSeeder` melakukan final normalization/assertion.

Legacy `PohonKinerjaSeeder` tidak dipanggil canonical path.

## 19. Idempotency

Gunakan `updateOrCreate`/`upsert` plus unique database constraints.

Seeder harus dapat dijalankan ulang tanpa duplicate graph edges atau target.

## 20. Transaction

Canonical architecture seed sebaiknya dijalankan di database transaction.

Jika assertion gagal, rollback.
