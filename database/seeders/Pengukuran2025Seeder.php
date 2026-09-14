<?php

namespace Database\Seeders;

use App\Models\KinerjaNode;
use App\Models\Target;
use App\Models\UnitKerja;
use App\Services\CalculationEngine;
use App\Services\InputSchemaService;
use App\Services\PengukuranService;
use Illuminate\Database\Seeder;

class Pengukuran2025Seeder extends Seeder
{
    public function run(): void
    {
        $pengukuranService = app(PengukuranService::class);
        $inputSchemaService = app(InputSchemaService::class);
        $calculationEngine = app(CalculationEngine::class);

        $tahun = 2025;
        $units = UnitKerja::with(['nodes' => function ($q) {
            $q->whereIn('jenis_node', ['IKP', 'IKK'])->with('formulas.components');
        }])->get();

        foreach ($units as $unit) {
            foreach ($unit->nodes as $node) {
                $target = Target::where('node_id', $node->id)->where('tahun', $tahun)->first();
                $targetVal = $target && is_numeric($target->nilai_target) ? (float) $target->nilai_target : 100.0;
                $schema = $inputSchemaService->getSchemaForNode($node);
                $formulaKey = $node->formula_key ?: ($schema['formula_key'] ?? $node->calculation_type ?? 'DIRECT_VALUE');

                for ($tw = 1; $tw <= 4; $tw++) {
                    $progressFactor = 0.75 + ($tw * 0.07); // TW1: 0.82, TW2: 0.89, TW3: 0.96, TW4: 1.03
                    $row = [
                        'inputs' => [],
                        'analisis_capaian' => "Capaian kinerja Triwulan {$tw} Tahun {$tahun} pada indikator {$node->nama} terealisasi sesuai target tahapan dengan capaian yang baik.",
                        'kendala' => "Tantangan koordinasi teknis dan integrasi data dukung pada awal triwulan telah dimitigasi secara komprehensif.",
                        'upaya' => "Peningkatan monitoring berkala dan penguatan koordinasi antar unit pelaksana secara berkelanjutan.",
                    ];

                    if ($formulaKey === 'SAKIP_EXTERNAL_SCORE' || $formulaKey === 'EXTERNAL_SCORE') {
                        $score = round($targetVal * (0.95 + ($tw * 0.015)), 2);
                        $row['inputs']['external_score'] = $score;
                        $row['realisasi'] = $score;
                    } elseif ($formulaKey === 'IPA_WEIGHTED_SUM') {
                        $components = ['X1_KAP', 'X2_PND', 'X3_TRJ', 'X4_ORG', 'X5_LKS', 'X6_SDM', 'X7_AKN', 'X8_WAS'];
                        foreach ($components as $idx => $comp) {
                            $row['inputs'][$comp] = round(80 + ($tw * 3.5) + (($idx % 3) * 1.5), 2);
                        }
                    } elseif ($formulaKey === 'AVERAGE_COMPONENTS') {
                        $components = ['X1_SOP_DASKRIMTI', 'X2_SOP_TRAJAK', 'X3_SOP_PKY'];
                        foreach ($components as $idx => $comp) {
                            $row['inputs'][$comp] = round(85 + ($tw * 3) + ($idx * 1.2), 2);
                        }
                    } elseif ($formulaKey === 'AVERAGE_OF_RATIOS') {
                        $row['inputs']['X1_PB1'] = 40 + ($tw * 2);
                        $row['inputs']['X2_PY1'] = 50;
                        $row['inputs']['X3_PB2'] = 85 + ($tw * 3);
                        $row['inputs']['X4_PY2'] = 100;
                    } elseif ($formulaKey === 'SURVEY_INDEX') {
                        if ($targetVal <= 5.0) {
                            $score = round(3.2 + ($tw * 0.18), 2);
                        } else {
                            $score = round(80 + ($tw * 4.5), 2);
                        }
                        $row['inputs']['skor_survei'] = $score;
                        $row['realisasi'] = $score;
                    } elseif (!empty($schema['fields'])) {
                        $hasPembilang = false;
                        $hasPenyebut = false;
                        foreach ($schema['fields'] as $field) {
                            $k = $field['key'];
                            if ($k === 'pembilang') {
                                $hasPembilang = true;
                            } elseif ($k === 'penyebut') {
                                $hasPenyebut = true;
                            } elseif ($k === 'realisasi') {
                                $val = round($targetVal * $progressFactor, 2);
                                $row['realisasi'] = $val;
                                $row['inputs']['realisasi'] = $val;
                            } else {
                                $row['inputs'][$k] = round(80 + ($tw * 4), 2);
                            }
                        }
                        if ($hasPembilang && $hasPenyebut) {
                            $py = 100;
                            $pb = min(100, round($targetVal * $progressFactor, 1));
                            $row['pembilang'] = $pb;
                            $row['penyebut'] = $py;
                            $row['inputs']['pembilang'] = $pb;
                            $row['inputs']['penyebut'] = $py;
                        }
                    } else {
                        if ($node->satuan === '%' || $node->calculation_type === 'RATIO') {
                            $py = 100;
                            $pb = min(100, round($targetVal * $progressFactor, 1));
                            $row['pembilang'] = $pb;
                            $row['penyebut'] = $py;
                            $row['inputs']['pembilang'] = $pb;
                            $row['inputs']['penyebut'] = $py;
                        } else {
                            $val = round($targetVal * $progressFactor, 2);
                            $row['realisasi'] = $val;
                            $row['inputs']['realisasi'] = $val;
                        }
                    }

                    $pengukuranService->storeMeasurement($node, $unit->id, $tahun, $tw, $row, 'seeder');
                }
            }
        }

        // Recalculate all node levels and aggregations
        for ($tw = 1; $tw <= 4; $tw++) {
            $pengukuranService->recalculateAll($tahun, $tw);
        }
    }
}
