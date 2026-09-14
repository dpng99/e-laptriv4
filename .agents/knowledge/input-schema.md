# Input Schema — e-LKjIP Pembinaan

## 1. Goal

User harus mengisi data dengan bahasa operasional, bukan bahasa database/formula.

## 2. Fundamental UX

Tampilkan:

- `Jumlah satker yang patuh`
- `Jumlah satker yang dinilai`

Jangan tampilkan:

- `NUMERATOR`
- `DENOMINATOR`

Role formula hanya untuk backend.

## 3. Field Schema

Recommended:

```json
{
  "key": "jumlah_patuh",
  "label": "Jumlah satker yang patuh",
  "role": "NUMERATOR",
  "input_type": "number",
  "data_type": "integer",
  "required": true,
  "min": 0,
  "tooltip": "Jumlah satuan kerja yang dinyatakan patuh berdasarkan hasil monitoring.",
  "editable": true
}
```

## 4. Supported Input Types

- number
- decimal
- percentage
- currency
- select
- radio
- text
- textarea
- date

Upload attachment adalah metadata pendukung dan tidak menggantikan numeric raw input kecuali flow khusus.

## 5. Input Modes

### DIRECT

Satu nilai:

```text
Nilai resmi [      ]
```

### RATIO

```text
Jumlah memenuhi kondisi [      ]
Jumlah yang dinilai      [      ]
```

### COMPONENT

```text
Komponen A [      ]
Komponen B [      ]
Komponen C [      ]
```

### SURVEY

```text
Total skor          [      ]
Jumlah responden    [      ]
Jumlah pertanyaan   [      ]
Skor maksimum       [      ] (boleh locked)
```

### AVERAGE_OF_RATIOS

Group UI:

```text
Kelompok Jaksa
- Bersertifikat
- Total Jaksa

Kelompok ASN Non-Jaksa
- Bersertifikat
- Total ASN Non-Jaksa
```

## 6. Kepatuhan Rule

Indikator kepatuhan menggunakan input jumlah agregat.

Tidak perlu input dokumen/checklist per satker.

Example:

```text
Jumlah satker yang patuh      [420]
Jumlah satker yang dinilai    [500]
```

## 7. Read-Only

Secara default read-only:

- formula
- bobot resmi
- target resmi
- realization
- achievement
- calculated status

## 8. Dynamic API Contract

Example response:

```json
{
  "indicator": {
    "kode": "IKP 6.2",
    "nama": "Tingkat kepatuhan satuan kerja terhadap SOP",
    "tipe_node": "MANDIRI",
    "formula_key": "RATIO_PERCENTAGE"
  },
  "period": {
    "tahun": 2026,
    "triwulan": 2
  },
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
  ],
  "computed": {
    "target": 85,
    "realization": null,
    "achievement": null
  }
}
```

## 9. AGREGATIF Node UI

Jika node `AGREGATIF`:

- jangan render raw input parent;
- tampilkan dependency child;
- tampilkan status data child;
- tampilkan result read-only.

Example:

```text
IKP X — dihitung otomatis

SK X.1   95%  ✓
SK X.2   90%  ✓
SK X.3   --   Belum lengkap

Realisasi: Belum dapat dihitung
```

## 10. Validation UX

Pesan harus domain-friendly.

Contoh:

`Jumlah satker yang dinilai harus lebih dari 0.`

bukan:

`denominator invalid`.
