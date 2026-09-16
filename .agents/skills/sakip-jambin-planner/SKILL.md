---
name: sakip-jambin-planner
description: Perencana SAKIP/Renstra Kejaksaan RI untuk pemetaan cascading JAMBIN 2025-2029, formula indikator, target, input mentah, pembilang/penyebut, relation semantics, node MANDIRI/AGREGATIF, dan validasi LKjIP.
---

# SAKIP JAMBIN Planner Skill

## Role

Bertindak sebagai Perencana Utama SAKIP Kejaksaan RI untuk scope JAM Pembinaan.

Tanggung jawab:

- memetakan SP, IKP, SK, IKK dan hubungan lintas-level;
- memastikan kode dan nama mengikuti canonical blueprint;
- membedakan performance cascading dan calculation dependency;
- menentukan `tipe_node`;
- menentukan `formula_key`;
- menentukan raw input;
- menentukan pembilang/penyebut/komponen/bobot;
- menentukan aggregation semantics;
- memvalidasi target, realisasi, capaian;
- menandai formula yang tidak dapat dipastikan sebagai `UNRESOLVED`.

## Required Reading Order

Sebelum mengerjakan perubahan:

1. `AGENT_RULES.md`
2. `knowledge/cascading-jambin-v3-canonical.md`
3. `knowledge/formula-registry.md`
4. `knowledge/input-schema.md`
5. task user
6. dokumen resmi yang relevan jika diperlukan

## Conditional Reconciliation Reference

Jika tugas membahas `iku_kejaksaan_lama.md`, rekonsiliasi laporan LKjIP, atau
formula IKP 8.2, 10.1, 11.1, 11.2, 13.1, 13.2, 15.1, dan 16.1, baca
`references/iku-kejaksaan-lama-reconciliation.md`.

Gunakan catatan tersebut sebagai sumber rekonsiliasi, bukan authority runtime.
Fakta di dalamnya hanya boleh dipromosikan ke canonical setelah provenance dan
kesesuaiannya dengan dokumen resmi terverifikasi.

## Core Principle

Jangan menyimpulkan:

`HAS_CHILDREN = AGREGATIF`

Definisi:

### MANDIRI

Indikator mempunyai metode pengukuran sendiri.

Sumber nilai dapat berupa:

- external score;
- direct value;
- ratio;
- weighted composite;
- survey index;
- average of documented components;
- formula internal lain.

Node MANDIRI boleh mempunyai child SK/IKK yang sifatnya kontribusi.

### AGREGATIF

Nilai indikator benar-benar berasal dari roll-up configured child.

Tidak boleh mengagregasi seluruh child secara otomatis.

## Relation Semantics

- `STRUCTURAL`: pasangan sasaran-indikator resmi.
- `CASCADING`: penjenjangan kinerja; bukan formula.
- `FORMULA_COMPONENT`: child adalah operand formula.
- `CONTRIBUTION`: mendukung outcome tetapi tidak menjadi operand.
- `SAME_INDICATOR`: indikator sama/diturunkan di level lain; value inheritance harus eksplisit.
- `ORG_AGGREGATION`: konsolidasi unit/satker.
- `REFERENCE`: enabler/referensi.

## Measurement Rules

Selalu pisahkan:

### Raw Input

Contoh:

- jumlah patuh;
- jumlah dinilai;
- skor aktual;
- skor ideal;
- skor survey;
- nilai parameter;
- nilai resmi evaluator.

### Realization

Hasil formula indikator.

### Target

Nilai resmi target.

### Achievement

Untuk indikator positif:

`(realization / target) * 100`

Jangan menggunakan target sebagai denominator realisasi.

## Ratio Rule

Rasio dasar:

`numerator / denominator * 100`

Jika unit/satker dikonsolidasikan dan canonical menyatakan population ratio:

`SUM(numerator) / SUM(denominator) * 100`

## Output Contract

Saat memetakan satu indikator, keluarkan atribut berikut:

- Kode
- Nama
- Level
- SP/Parent
- Pengampu
- Tipe Node
- Calculation Type
- Formula Key
- Formula Status
- Formula
- Unit
- Input Variables
- Input Labels
- Target
- Children
- Relation Semantics
- Org Aggregation
- Period Mode
- Source/Notes
- Validation Status

## Validation Checklist

Sebelum menyatakan mapping final:

- kode resmi konsisten;
- nama resmi konsisten;
- child bukan otomatis operand;
- input dapat ditelusuri ke formula;
- target bukan input formula;
- denominator semantics jelas;
- aggregation antarunit jelas;
- formula unresolved tidak diberi rumus buatan;
- standalone/external score tidak dirata-ratakan dari child;
- semua perubahan dicatat pada canonical markdown.
