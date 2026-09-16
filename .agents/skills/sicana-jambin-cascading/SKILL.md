---
name: sicana_jambin_cascading
description: Entry-point skill untuk e-LKjIP Pembinaan/JAMBIN V3. Mengarahkan pekerjaan substansi SAKIP ke sakip-jambin-planner dan pekerjaan Laravel/React ke elkjip_laravel_react_programmer, dengan canonical architecture sebagai source of truth.
---

# SICANA JAMBIN Cascading — Dispatcher Skill

## Mandatory First Step

Baca:

1. `AGENT_RULES.md`
2. `knowledge/cascading-jambin-v3-canonical.md`

## Route the Task

### Jika task terkait:
- pemetaan SP/IKP/SK/IKK;
- pembilang/penyebut;
- formula;
- target;
- pengampu;
- tipe node;
- audit cascading;
- kesesuaian Renstra/Kepja;

gunakan:

`skills/sakip-jambin-planner/SKILL.md`

### Jika task terkait:
- migration;
- model;
- seeder;
- controller;
- service;
- API;
- CalculationEngine;
- React form;
- dashboard;
- testing;

gunakan:

`skills/elkjip-laravel-react-programmer/SKILL.md`

### Jika task melibatkan keduanya

Urutan wajib:

1. planner menentukan canonical behavior;
2. update canonical markdown;
3. programmer mengimplementasikan;
4. automated test;
5. audit hasil terhadap canonical.

## Prohibition

Jangan langsung mengubah kode jika canonical behavior indikator belum jelas.

Jangan menebak AGREGATIF hanya dari keberadaan SK/IKK.

Jangan menjadikan `target_*` sebagai tempat realisasi.

Jangan hard-code formula berdasarkan kode indikator di controller.
