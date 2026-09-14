# Project-Specific Rules — e-LKjIP Pembinaan

## Domain

- Gunakan kode/nama canonical blueprint.
- Pertahankan tabel level terpisah `sp`, `ikp`, `sk`, `ikk`.
- `ikp.tipe_node`: `MANDIRI` atau `AGREGATIF`.

## Corrected Node Semantics

`MANDIRI` tidak berarti harus tidak punya child.

`MANDIRI` berarti nilai tidak berasal dari generic roll-up child.

`AGREGATIF` berarti nilai memang berasal dari configured child calculation dependencies.

## Formula

Gunakan formula registry.

Minimal supported:

- RATIO_PERCENTAGE
- INDEX_SCORE
- UNFAVORABLE_PERCENTAGE
- DIRECT_VALUE
- EXTERNAL_SCORE
- WEIGHTED_SUM
- AVERAGE_COMPONENTS
- AVERAGE_OF_RATIOS
- SURVEY_INDEX
- AGGREGATE_AVG

## Target Unique Key

Target harus unique per indikator, tahun, triwulan.

## UX

- dynamic input schema;
- tooltips dari `rumus_indikator`/`komponen_rumus`;
- hasil kalkulasi read-only;
- indikator kepatuhan input jumlah agregat.

## Dashboard

- >=100% TERCAPAI
- <100%, TW1-3 BELUM_TERCAPAI
- <100%, TW4 TIDAK_TERCAPAI

## Code

- thin controllers;
- formula in strategies/services;
- no indicator-specific controller branching;
- tests required.
