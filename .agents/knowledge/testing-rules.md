# Testing Rules — e-LKjIP Pembinaan

## 1. Test Layers

Wajib:

- Unit test formula strategy
- Unit test achievement/status
- Feature test input API
- Feature test review workflow
- Architecture test/seeder assertion
- Integration test roll-up/aggregation

## 2. Architecture Assertions

### IKP MANDIRI

- dapat mempunyai child;
- child CONTRIBUTION tidak masuk kalkulasi;
- tidak di-average dari child.

### IKP AGREGATIF

- mempunyai explicit calculation dependency;
- generic all-child averaging dilarang;
- incomplete child menghasilkan incomplete/null sesuai rule.

## 3. Mandatory SAKIP Test

Assert Nilai SAKIP:

- `tipe_node = MANDIRI`;
- value source direct/external;
- child SK/IKK bukan operand generic;
- changing child achievement tidak mengubah Nilai SAKIP.

## 4. Mandatory RB Test

Nilai RB tidak berubah hanya karena capaian SP/IKP pendukung berubah.

## 5. Ratio Test

Input:

- numerator = 420
- denominator = 500

Expected realization:

`84`

Denominator 0:

- validation error;
- bukan result 0.

## 6. Missing Input

Jika numerator atau denominator belum diisi:

- result null/incomplete;
- bukan 0.

## 7. Achievement

Realization 84, Target 85:

Expected:

`98.823529...`

Display rounding ditangani presentation layer.

## 8. Dashboard Status

### TW1-3

Capaian 99.99:

`BELUM_TERCAPAI`

Capaian 100:

`TERCAPAI`

### TW4

Capaian 99.99:

`TIDAK_TERCAPAI`

Capaian 100:

`TERCAPAI`

## 9. Population Aggregation

Unit A:

90/100

Unit B:

1/2

Jika aggregation = `SUM_INPUTS_THEN_CALCULATE`:

Expected:

`91 / 102 * 100`

Tidak boleh `AVG(90,50)`.

## 10. Formula Component

AVERAGE/SUM/WEIGHTED_SUM hanya mengambil configured components.

Unrelated CONTRIBUTION child tidak boleh masuk.

## 11. Snapshot

Setelah pengukuran APPROVED:

- perubahan target master tidak mengubah snapshot;
- perubahan formula master tidak mengubah formula version snapshot.

## 12. Seeder Tests

Assert:

- tidak ada duplicate code;
- tidak ada duplicate relation;
- target period unique;
- formula version unique;
- setiap MANDIRI yang membutuhkan input mempunyai active formula;
- setiap AGREGATIF mempunyai dependency kalkulasi;
- relation type valid;
- no legacy relation semantic.
