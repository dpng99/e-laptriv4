<?php

namespace App\Services;

use App\Models\KinerjaNode;
use App\Services\Formula\FormulaResolver;
use Illuminate\Validation\ValidationException;

class MeasurementInputValidator
{
    public function validate(KinerjaNode $node, array $row): array
    {
        $schema = app(InputSchemaService::class)->getSchemaForNode($node);
        $fields = collect($schema['fields'])->keyBy('key');
        $definition = app(FormulaResolver::class)->definition($node);
        $canonicalFields = collect($definition['input_schema']['fields'] ?? [])->keyBy('key');
        $inputs = $row['inputs'] ?? [];
        if (!is_array($inputs)) {
            throw ValidationException::withMessages(['inputs' => 'Input formula harus berupa pasangan nama dan angka.']);
        }
        // Existing forms send result/legacy columns too. Only declared operands are authoritative.
        foreach (['pembilang', 'penyebut', 'realisasi'] as $key) {
            if ($fields->has($key) && array_key_exists($key, $row)) $inputs[$key] = $row[$key];
        }
        $clean = [];
        foreach ($inputs as $key => $value) {
            if (!$fields->has($key)) {
                if (in_array($key, ['pembilang', 'penyebut', 'realisasi'], true)) continue;
                throw ValidationException::withMessages(['inputs.'.$key => 'Operand tidak terdaftar pada rumus indikator.']);
            }
            $value = is_string($value) ? trim(str_replace(',', '.', $value)) : $value;
            if ($value === null || $value === '') { $clean[$key] = null; continue; }
            if (!is_numeric($value) || !is_finite((float) $value) || abs((float) $value) >= 100000000000000) {
                throw ValidationException::withMessages(['inputs.'.$key => 'Operand harus berupa angka dalam rentang penyimpanan.']);
            }
            $field = $canonicalFields->get($key, []);
            $minimum = $field['min'] ?? 0;
            if ((float) $value < $minimum || (isset($field['max']) && (float) $value > $field['max'])
                || ($key === 'penyebut' && (float) $value <= 0)) {
                throw ValidationException::withMessages(['inputs.'.$key => 'Nilai operand di luar batas rumus; penyebut harus lebih besar dari nol.']);
            }
            // Preserve decimal strings until arithmetic/persistence.
            $clean[$key] = (string) $value;
        }
        return $clean;
    }
}
