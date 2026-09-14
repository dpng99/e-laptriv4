<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengukuranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->assignedUnit() !== null;
    }

    protected function prepareForValidation(): void
    {
        $normalizeRow = function ($row) {
            if (!is_array($row)) return $row;
            foreach (['pembilang', 'penyebut', 'realisasi'] as $field) {
                if (isset($row[$field]) && is_string($row[$field])) {
                    $cleaned = trim(str_replace(',', '.', $row[$field]));
                    $row[$field] = ($cleaned === '') ? null : $cleaned;
                }
            }
            if (isset($row['inputs']) && is_array($row['inputs'])) {
                foreach ($row['inputs'] as $k => $v) {
                    if (is_string($v)) {
                        $cleaned = trim(str_replace(',', '.', $v));
                        $row['inputs'][$k] = ($cleaned === '') ? null : $cleaned;
                    }
                }
            }
            return $row;
        };

        $data = $this->input('data');
        if (is_array($data)) {
            $this->merge([
                'data' => array_map($normalizeRow, $data),
            ]);
        }

        $ikpData = $this->input('ikp_data');
        if (is_array($ikpData)) {
            $this->merge([
                'ikp_data' => array_map($normalizeRow, $ikpData),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'tahun' => 'required|integer|min:2025|max:2029',
            'triwulan' => 'required|integer|min:1|max:4',
            'data' => 'nullable|array',
            'data.*' => 'array',
            'data.*.kode_ikk' => 'required|string|distinct',
            'data.*.pembilang' => 'nullable|numeric',
            'data.*.penyebut' => 'nullable|numeric',
            'data.*.realisasi' => 'nullable|numeric',
            'data.*.inputs' => 'nullable|array',
            'data.*.inputs.*' => 'nullable|numeric',
            'data.*.analisis_capaian' => 'nullable|string',
            'data.*.kendala' => 'nullable|string',
            'data.*.upaya' => 'nullable|string',
            'data.*.hambatan_kendala' => 'nullable|string',
            'data.*.langkah_tindak_lanjut' => 'nullable|string',
            'ikp_data' => 'nullable|array',
            'ikp_data.*' => 'array',
            'ikp_data.*.kode_ikp' => 'required|string|distinct',
            'ikp_data.*.pembilang' => 'nullable|numeric',
            'ikp_data.*.penyebut' => 'nullable|numeric',
            'ikp_data.*.realisasi' => 'nullable|numeric',
            'ikp_data.*.inputs' => 'nullable|array',
            'ikp_data.*.inputs.*' => 'nullable|numeric',
            'ikp_data.*.analisis_capaian' => 'nullable|string',
            'ikp_data.*.kendala' => 'nullable|string',
            'ikp_data.*.upaya' => 'nullable|string',
        ];
    }
}
