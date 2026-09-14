<?php

namespace App\Services;

use App\Models\KinerjaNode;

class InputSchemaService
{
    private static ?array $architectureConfig = null;

    public function getSchemaForNode(KinerjaNode $node): array
    {
        $code = str_replace(['IKP:', 'IKK:'], '', $node->source_key);
        $arch = $this->getArchitectureIndicator($code);

        // 1. If explicit input_schema defined in canonical architecture
        if (!empty($arch['input_schema']['fields'])) {
            $componentsMap = collect($arch['formula_components'] ?? [])->keyBy('key');

            $fields = array_map(function ($f) use ($componentsMap) {
                $comp = $componentsMap->get($f['key'] ?? '');
                $label = $f['label'] ?? ($comp['name'] ?? 'Nilai');

                $help = $f['help_text'] 
                    ?? ($f['description'] 
                    ?? ($comp ? ($comp['name'] . (isset($comp['weight']) ? ' (bobot ' . ($comp['weight'] * 100) . '%)' : '')) : $label));

                $placeholder = $f['placeholder'] ?? ('Contoh: Masukkan ' . strtolower($label) . '...');

                return array_merge($f, [
                    'label' => $label,
                    'help_text' => $help,
                    'description' => $help,
                    'placeholder' => $placeholder,
                ]);
            }, $arch['input_schema']['fields']);

            return [
                'kode' => $node->kode ?: $node->source_key,
                'nama' => $node->nama,
                'satuan' => $node->satuan,
                'tipe_node' => $arch['tipe_node'] ?? 'MANDIRI',
                'formula_key' => $node->formula_key ?: ($arch['formula_key'] ?? 'DIRECT_VALUE'),
                'period_mode' => $arch['period_mode'] ?? 'PERIODIC',
                'fields' => $fields,
            ];
        }

        // 2. If node has formula components in database
        $formula = $node->formulas()->where('is_active', true)->orderByDesc('versi')->with('components')->first();
        if ($formula && $formula->components->isNotEmpty()) {
            $fields = $formula->components->map(function ($c) use ($formula, $node) {
                $isPembilang = in_array(strtolower($c->kode_komponen), ['pembilang', 's', 'x1_pembilang'], true);
                $isPenyebut = in_array(strtolower($c->kode_komponen), ['penyebut', 't', 'x2_penyebut'], true);

                $label = $isPembilang
                    ? 'Pembilang (Numerator)'
                    : ($isPenyebut
                        ? 'Penyebut (Denominator)'
                        : ($c->nama_komponen . ($c->bobot ? ' (bobot ' . ($c->bobot * 100) . '%)' : '')));

                $helpText = $isPembilang
                    ? ($formula->judul_pembilang ?: ($c->penjelasan ?: 'Jumlah realisasi capaian yang diperoleh'))
                    : ($isPenyebut
                        ? ($formula->judul_penyebut ?: ($c->penjelasan ?: 'Jumlah total target atau sasaran populasi'))
                        : ($c->penjelasan ?: 'Komponen: ' . $c->nama_komponen));

                $placeholder = 'Contoh: Masukkan ' . strtolower($label) . '...';

                return [
                    'key' => $c->input_key ?: $c->kode_komponen,
                    'label' => $label,
                    'type' => 'decimal',
                    'required' => true,
                    'min' => $isPenyebut ? 1 : 0,
                    'max' => 100,
                    'help_text' => $helpText,
                    'description' => $helpText,
                    'placeholder' => $placeholder,
                ];
            })->toArray();

            return [
                'kode' => $node->kode ?: $node->source_key,
                'nama' => $node->nama,
                'satuan' => $node->satuan,
                'tipe_node' => 'MANDIRI',
                'formula_key' => $node->formula_key ?: 'WEIGHTED_SUM',
                'fields' => $fields,
            ];
        }

        // 3. If standard ratio with judul_pembilang & judul_penyebut
        $calcType = strtoupper((string) ($node->calculation_type ?: $formula?->tipe_formula?->value));
        if (in_array($calcType, ['RATIO', 'RATIO_PERCENTAGE', 'UNFAVORABLE_PERCENTAGE'], true)) {
            $pembilangDesc = $formula?->judul_pembilang ?: 'Jumlah Realisasi Capaian';
            $penyebutDesc = $formula?->judul_penyebut ?: 'Jumlah Target / Total Populasi';

            return [
                'kode' => $node->kode ?: $node->source_key,
                'nama' => $node->nama,
                'satuan' => $node->satuan ?: '%',
                'tipe_node' => 'MANDIRI',
                'formula_key' => 'RATIO_PERCENTAGE',
                'fields' => [
                    [
                        'key' => 'pembilang',
                        'label' => 'Pembilang (Numerator)',
                        'type' => 'decimal',
                        'required' => true,
                        'min' => 0,
                        'help_text' => $pembilangDesc,
                        'description' => $pembilangDesc,
                        'placeholder' => 'Contoh: ' . $pembilangDesc . '...',
                    ],
                    [
                        'key' => 'penyebut',
                        'label' => 'Penyebut (Denominator)',
                        'type' => 'decimal',
                        'required' => true,
                        'min' => 1,
                        'help_text' => $penyebutDesc,
                        'description' => $penyebutDesc,
                        'placeholder' => 'Contoh: ' . $penyebutDesc . '...',
                    ],
                ],
            ];
        }

        // 4. Default direct value / score
        $desc = 'Nilai realisasi ' . ($node->nama ?: 'Indikator') . ($node->satuan ? ' (' . $node->satuan . ')' : '');
        return [
            'kode' => $node->kode ?: $node->source_key,
            'nama' => $node->nama,
            'satuan' => $node->satuan,
            'tipe_node' => 'MANDIRI',
            'formula_key' => 'DIRECT_VALUE',
            'fields' => [
                [
                    'key' => 'realisasi',
                    'label' => 'Nilai Realisasi Aktual',
                    'type' => 'decimal',
                    'required' => true,
                    'min' => 0,
                    'help_text' => $desc,
                    'description' => $desc,
                    'placeholder' => 'Contoh: ' . $desc . '...',
                ],
            ],
        ];
    }

    private function getArchitectureIndicator(string $code): ?array
    {
        if (self::$architectureConfig === null) {
            $path = database_path('data/jambin_architecture_v3.php');
            if (file_exists($path)) {
                self::$architectureConfig = require $path;
            } else {
                self::$architectureConfig = [];
            }
        }

        return self::$architectureConfig['indicators'][$code] ?? null;
    }
}
