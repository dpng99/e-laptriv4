# Formula Registry — e-LKjIP Pembinaan

## 1. Purpose

Formula registry memastikan formula tidak di-hard-code berdasarkan kode indikator.

Database menyimpan `formula_key`, sedangkan Laravel resolve ke calculator strategy.

## 2. DIRECT_VALUE

### Use

Nilai langsung.

### Inputs

- `value`

### Formula

`result = value`

## 3. EXTERNAL_SCORE

### Use

Nilai resmi evaluator eksternal.

Contoh:

- Nilai SAKIP;
- nilai evaluasi eksternal lain;
- nilai RB jika canonical menggunakan nilai resmi evaluator.

### Inputs

- `official_score`

### Formula

`result = official_score`

### Notes

Child contribution tidak boleh di-average.

## 4. RATIO_PERCENTAGE

### Inputs

- numerator
- denominator

### Formula

`result = numerator / denominator * 100`

### Validation

- denominator > 0
- numerator >= 0
- numerator <= denominator hanya jika domain indikator mengharuskan bagian dari total.

## 5. INDEX_SCORE

### Meaning

Gunakan jika canonical memang mendefinisikan kalkulasi relatif antara skor indeks dan target/skor maksimum tertentu.

### Formula

`result = index_score / index_reference * 100`

### Warning

Jangan menggunakan target kinerja sebagai `index_reference` kecuali definisi indikator memang menyatakan demikian.

## 6. UNFAVORABLE_PERCENTAGE

### Formula

`result = (1 - numerator / denominator) * 100`

### Use

Indikator dengan arah semakin rendah kondisi buruk semakin baik.

Harus didukung definisi resmi.

## 7. WEIGHTED_SUM

### Components

Setiap component:

- value/score
- optional maximum/reference
- weight

### Pattern A

Jika component sudah dalam skala final:

`result = SUM(component_value * weight)`

### Pattern B

Jika normalized:

`normalized_component = value/reference`

`result = SUM(normalized_component * weight)`

Pattern wajib disimpan explicit dalam metadata formula.

## 8. AVERAGE_COMPONENTS

### Formula

`result = AVERAGE(component_1 ... component_n)`

### Rule

Hanya component yang didaftarkan pada formula.

Tidak boleh `AVERAGE(all children)`.

## 9. AVERAGE_OF_RATIOS

### Formula

Untuk n component:

`ratio_i = numerator_i / denominator_i * 100`

`result = AVERAGE(ratio_i)`

### Example

Sertifikasi Jaksa + ASN non-Jaksa.

## 10. SURVEY_INDEX

Beberapa pattern survey dapat digunakan.

### Normalized Score

`result = total_score / (respondents * questions * max_scale) * 100`

### Rating Distribution

`result = SUM(rating_i * frequency_i) / (max_rating * SUM(frequency_i)) * 100`

Formula metadata harus menentukan variant.

## 11. AGGREGATE_AVG

### Use

Hanya node `AGREGATIF`.

### Formula

`result = AVERAGE(configured_child_values)`

### Requirement

Children harus berasal dari explicit calculation dependency.

## 12. Organizational Aggregation Methods

Disimpan terpisah dari `formula_key`.

Allowed:

- `NONE`
- `SUM`
- `AVERAGE`
- `WEIGHTED_AVERAGE`
- `SUM_INPUTS_THEN_CALCULATE`
- `LATEST`
- `DIRECT_OVERRIDE`

### SUM_INPUTS_THEN_CALCULATE

Untuk rasio populasi:

`SUM(numerator_unit) / SUM(denominator_unit) * 100`

Bukan average realization unit.

## 13. Formula Interface

Recommended PHP contract:

```php
interface FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult;
}
```

`CalculationResult` minimal:

```php
final class CalculationResult
{
    public function __construct(
        public readonly ?float $value,
        public readonly array $components = [],
        public readonly array $warnings = [],
    ) {}
}
```

## 14. Formula Status

- RESOLVED: formula dapat dieksekusi.
- EXTERNAL: input direct/external.
- DOCUMENTED_ONLY: formula didokumentasikan tetapi belum cukup untuk automasi.
- UNRESOLVED: engine harus menolak kalkulasi.
