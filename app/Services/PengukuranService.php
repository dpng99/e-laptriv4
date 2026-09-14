<?php

namespace App\Services;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PengukuranService
{
    public function __construct(private readonly CalculationEngine $calculationEngine) {}

    public function storeMeasurement(KinerjaNode $node, int $unitId, int $tahun, int $triwulan, array $row, string $username = 'system'): Pengukuran
    {
        return DB::transaction(function () use ($node, $unitId, $tahun, $triwulan, $row, $username) {
            $node = KinerjaNode::whereKey($node->id)->lockForUpdate()->firstOrFail();
            if (!$node->is_active || !$node->input_enabled || $tahun < 2025 || $tahun > 2029 || $triwulan < 1 || $triwulan > 4) {
                throw ValidationException::withMessages(['data' => 'Indikator atau periode tidak tersedia untuk input.']);
            }
            abort_unless($node->units()->whereKey($unitId)->exists(), 403, 'Indikator bukan milik unit kerja ini.');
            $measurement = Pengukuran::firstOrNew([
                'node_id' => $node->id, 'unit_kerja_id' => $unitId, 'tahun' => $tahun, 'triwulan' => $triwulan,
            ]);
            if ($measurement->isFinal()) {
                throw ValidationException::withMessages(['data' => 'Pengukuran final atau terkunci tidak dapat diubah.']);
            }
            $inputs = app(MeasurementInputValidator::class)->validate($node, $row);
            $measurement->created_by ??= $username;
            $measurement->updated_by = $username;
            foreach (['analisis_capaian', 'kendala', 'upaya'] as $key) {
                if (array_key_exists($key, $row)) $measurement->$key = $row[$key];
            }
            if (array_key_exists('hambatan_kendala', $row)) $measurement->kendala = $row['kendala'] ?? $row['hambatan_kendala'];
            if (array_key_exists('langkah_tindak_lanjut', $row)) $measurement->upaya = $row['upaya'] ?? $row['langkah_tindak_lanjut'];
            foreach (['pembilang', 'penyebut'] as $key) {
                if (array_key_exists($key, $inputs)) $measurement->$key = $inputs[$key];
            }
            $measurement->save();
            foreach ($inputs as $key => $value) {
                // Keep explicit nulls: a cleared operand must not resurrect a legacy value.
                $measurement->inputs()->updateOrCreate(['input_key' => $key], ['nilai' => $value, 'nilai_teks' => null]);
            }
            if (array_key_exists('realisasi', $inputs)) $measurement->update(['realisasi' => $inputs['realisasi']]);
            return $this->calculationEngine->calculateNode($node, $tahun, $triwulan, $unitId) ?? $measurement;
        });
    }

    public function recalculateAll(int $tahun, int $triwulan, ?int $unitId = null): void
    {
        $this->calculationEngine->calculateAll($tahun, $triwulan, $unitId);
    }
}
