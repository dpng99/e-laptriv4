<?php

namespace Database\Seeders;

use App\Models\KinerjaNode;
use App\Models\Target;
use App\Models\UnitKerja;
use App\Services\CalculationEngine;
use App\Services\Formula\FormulaResolver;
use App\Services\InputSchemaService;
use App\Services\PengukuranService;
use Illuminate\Database\Seeder;

class Pengukuran2025Seeder extends Seeder
{
    public function run(): void
    {
        $pengukuranService = app(PengukuranService::class);
        $inputSchemaService = app(InputSchemaService::class);
        $formulaResolver = app(FormulaResolver::class);

        $tahun = 2025;
        $units = UnitKerja::with(['nodes' => function ($q) {
            $q->whereIn('jenis_node', ['IKP', 'IKK'])->with('formulas.components');
        }])->get();

        foreach ($units as $unit) {
            foreach ($unit->nodes as $node) {
                if (!$node->is_active || !$node->input_enabled) {
                    continue;
                }

                $target = Target::where('node_id', $node->id)->where('tahun', $tahun)->first();
                $targetVal = $target && is_numeric($target->nilai_target) ? (float) $target->nilai_target : 100.0;
                $schema = $inputSchemaService->getSchemaForNode($node);
                $definition = $formulaResolver->definition($node);
                $canonicalFields = collect($definition['input_schema']['fields'] ?? [])->keyBy('key');
                $fields = $schema['fields'] ?? [];

                for ($tw = 1; $tw <= 4; $tw++) {
                    $progressFactor = 0.75 + ($tw * 0.07); // TW1: 0.82, TW2: 0.89, TW3: 0.96, TW4: 1.03
                    $expectedRealisasi = round($targetVal * $progressFactor, 2);

                    $row = [
                        'inputs' => [],
                        'analisis_capaian' => "Capaian kinerja Triwulan {$tw} Tahun {$tahun} pada indikator {$node->nama} terealisasi sesuai target tahapan dengan capaian yang baik.",
                        'kendala' => "Tantangan koordinasi teknis dan integrasi data dukung pada awal triwulan telah dimitigasi secara komprehensif.",
                        'upaya' => "Peningkatan monitoring berkala dan penguatan koordinasi antar unit pelaksana secara berkelanjutan.",
                    ];

                    if (!empty($fields)) {
                        $hasPembilang = false;
                        $hasPenyebut = false;
                        foreach ($fields as $f) {
                            $k = $f['key'];
                            $kLower = strtolower($k);
                            $canon = $canonicalFields->get($k, []);
                            $max = $canon['max'] ?? ($f['max'] ?? null);

                            if ($k === 'pembilang') {
                                $hasPembilang = true;
                            } elseif ($k === 'penyebut') {
                                $hasPenyebut = true;
                            } elseif (in_array($k, ['nilai_sakip_resmi', 'nilai_ikk_resmi', 'nilai_sistem_merit_resmi', 'realisasi', 'external_score'], true)) {
                                $val = $expectedRealisasi;
                                if ($max !== null) $val = min($max, $val);
                                $row['inputs'][$k] = $val;
                                $row['realisasi'] = $val;
                            } elseif (str_starts_with($kLower, 'total_') || str_ends_with($kLower, '_ideal') || str_ends_with($kLower, '_maksimal')) {
                                $row['inputs'][$k] = 100.0;
                            } elseif (str_starts_with($kLower, 'skor_') || str_starts_with($kLower, 'jumlah_') || str_contains($kLower, 'terdigitalisasi') || str_contains($kLower, 'dimanfaatkan') || str_contains($kLower, 'bersertifikat')) {
                                $val = min(100.0, round($expectedRealisasi, 1));
                                if ($max !== null) $val = min($max, $val);
                                $row['inputs'][$k] = $val;
                            } elseif (in_array($k, ['SP', 'KSDM', 'TK'], true)) {
                                $val = round($expectedRealisasi / 3, 2);
                                if ($max !== null) $val = min($max, $val);
                                $row['inputs'][$k] = $val;
                            } elseif (in_array($k, ['KECUKUPAN', 'PENGEMBANGAN', 'PENGELOLAAN'], true)) {
                                $val = round($expectedRealisasi, 2);
                                if ($max !== null) $val = min($max, $val);
                                $row['inputs'][$k] = $val;
                            } elseif (str_starts_with($k, 'IKL_')) {
                                $val = round($expectedRealisasi, 2);
                                if ($max !== null) $val = min($max, $val);
                                $row['inputs'][$k] = $val;
                            } elseif (preg_match('/^X\d+$/', $k)) {
                                $numComps = count($fields);
                                if (($schema['formula_key'] ?? '') === 'SUM') {
                                    if ($max !== null) {
                                        $val = min($max, round($expectedRealisasi * ($max / 100), 2));
                                    } else {
                                        $val = round($expectedRealisasi / $numComps, 2);
                                    }
                                } else {
                                    $val = round($expectedRealisasi, 2);
                                    if ($max !== null) $val = min($max, $val);
                                }
                                $row['inputs'][$k] = $val;
                            } else {
                                $val = round($expectedRealisasi, 2);
                                if ($max !== null) $val = min($max, $val);
                                $row['inputs'][$k] = $val;
                            }
                        }

                        if ($hasPembilang && $hasPenyebut) {
                            $py = 100.0;
                            $pb = min(100.0, round($expectedRealisasi, 1));
                            $row['pembilang'] = $pb;
                            $row['penyebut'] = $py;
                            $row['inputs']['pembilang'] = $pb;
                            $row['inputs']['penyebut'] = $py;
                        }
                    } else {
                        $py = 100.0;
                        $pb = min(100.0, round($expectedRealisasi, 1));
                        $row['pembilang'] = $pb;
                        $row['penyebut'] = $py;
                        $row['inputs']['pembilang'] = $pb;
                        $row['inputs']['penyebut'] = $py;
                    }

                    $pengukuranService->storeMeasurement($node, $unit->id, $tahun, $tw, $row, 'seeder-2025');
                }
            }
        }

        // Recalculate all node levels and aggregations
        for ($tw = 1; $tw <= 4; $tw++) {
            $pengukuranService->recalculateAll($tahun, $tw);
        }
    }
}
