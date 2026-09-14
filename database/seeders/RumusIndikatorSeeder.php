<?php

namespace Database\Seeders;

use App\Enums\FormulaType;
use App\Models\RumusIndikator;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RumusIndikatorSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            foreach ($this->dataset()['strategics'] as $item) {
                $this->store('IKSS', $item['indicator_code'], $item['formula'] ?? null, $item['formula_status'] ?? 'Transkripsi KEPJA', $item);
            }

            foreach ($this->dataset()['programs'] as $item) {
                $this->store('IKP', $item['indicator_code'], $item['formula'] ?? null, 'Transkripsi formula KEPJA', $item);
            }

            foreach ($this->dataset()['activities'] as $item) {
                $status = ($item['source_indicator_code'] ?? $item['indicator_code']) !== $item['indicator_code']
                    ? 'Transkripsi KEPJA dengan normalisasi kode indikator'
                    : 'Transkripsi formula KEPJA';
                $this->store('IKK', $item['indicator_code'], $item['formula'] ?? null, $status, $item);
            }
        });
    }

    private function parseFormula(?string $formula, string $unit, string $indicatorName): array
    {
        $raw = is_string($formula) ? trim($formula) : '';
        $clean = str_replace(["\r\n", "\r"], "\n", $raw);
        
        $pembilang = null;
        $penyebut = null;
        
        if (preg_match('/(?:^|\n)\s*S\s*:\s*([^\n\r]+(?:\n(?!\s*[T|X|N|K|B]\s*:)[^\n\r]+)*)/i', $clean, $m)) {
            $pembilang = trim(preg_replace('/\s+/', ' ', $m[1]));
        }
        if (preg_match('/(?:^|\n)\s*T\s*:\s*([^\n\r]+(?:\n(?!\s*[S|X|N|K|B]\s*:)[^\n\r]+)*)/i', $clean, $m)) {
            $penyebut = trim(preg_replace('/\s+/', ' ', $m[1]));
        }
        
        if (!$pembilang && preg_match('/(?:^|\n)\s*X1\s*:\s*([^\n\r]+)/i', $clean, $m)) {
            $pembilang = trim(preg_replace('/\s+/', ' ', $m[1]));
        }
        if (!$penyebut && preg_match('/(?:^|\n)\s*X2\s*:\s*([^\n\r]+)/i', $clean, $m)) {
            $penyebut = trim(preg_replace('/\s+/', ' ', $m[1]));
        }

        if (!$pembilang) {
            $pembilang = "Jumlah realisasi pemenuhan / layanan yang diselesaikan pada {$indicatorName}";
        }
        if (!$penyebut) {
            $penyebut = "Total target permohonan / layanan wajib dalam 1 tahun";
        }

        $penjelasan = !empty($clean) ? trim(preg_replace('/\s+/', ' ', $clean)) : "Pengukuran indikator {$indicatorName} ({$unit}).";

        return [
            'pembilang' => $pembilang,
            'penyebut' => $penyebut,
            'penjelasan' => $penjelasan,
        ];
    }

    private function store(string $type, string $code, ?string $formula, string $status, array $item): void
    {
        $node = $this->node($type, $code);
        // Seed once: never overwrite edited versions or recreate referenced components.
        if ($node->formulas()->exists()) return;

        $formulaType = $this->formulaType($type, $code, $formula, $item);
        $parsed = $this->parseFormula($formula, $item['unit'] ?? '', $item['indicator_name'] ?? '');

        $rumus = RumusIndikator::query()->updateOrCreate(
            ['node_id' => $node->id, 'versi' => 1],
            [
                'tipe_formula' => $formulaType->value,
                'arah_kinerja' => 'HIGHER_IS_BETTER',
                'rumus_tampilan' => $formula,
                'status_formula' => $status.'; formula_type='.$formulaType->value,
                'batas_capaian' => null,
                'jumlah_desimal' => 2,
                'judul_pembilang' => $parsed['pembilang'],
                'judul_penyebut' => $parsed['penyebut'],
                'kebijakan_data_kosong' => 'BLOCK',
                'is_active' => true,
            ],
        );
        
        // Clean old components
        $rumus->components()->delete();

        $calcType = match ($formulaType) {
            FormulaType::RATIO, FormulaType::RATIO_PERCENTAGE => 'RATIO',
            FormulaType::UNFAVORABLE_PERCENTAGE => 'UNFAVORABLE_PERCENTAGE',
            FormulaType::EXTERNAL_VALUE, FormulaType::EXTERNAL_SCORE => 'EXTERNAL_SCORE',
            FormulaType::WEIGHTED_SUM => 'WEIGHTED_SUM',
            FormulaType::SUM => 'SUM',
            FormulaType::AVERAGE => 'AVERAGE',
            default => 'DIRECT_VALUE',
        };

        if (!$node->calculation_type) {
            $node->update([
                'calculation_type' => $calcType,
                'formula_key' => $node->formula_key ?: $calcType,
            ]);
        }

        if ($formulaType === FormulaType::UNFAVORABLE_PERCENTAGE) {
            $rumus->components()->create([
                'kode_komponen' => 'pembilang',
                'nama_komponen' => 'Pembilang (Jumlah Pelanggaran/Kasus)',
                'penjelasan' => $parsed['pembilang'],
                'urutan' => 1,
            ]);
            $rumus->components()->create([
                'kode_komponen' => 'penyebut',
                'nama_komponen' => 'Penyebut (Total Populasi Pegawai)',
                'penjelasan' => $parsed['penyebut'],
                'urutan' => 2,
            ]);
        } elseif ($formulaType === FormulaType::RATIO_PERCENTAGE || $formulaType === FormulaType::RATIO) {
            $rumus->components()->create([
                'kode_komponen' => 'pembilang',
                'nama_komponen' => 'Pembilang (Realisasi Capaian)',
                'penjelasan' => $parsed['pembilang'],
                'urutan' => 1,
            ]);
            $rumus->components()->create([
                'kode_komponen' => 'penyebut',
                'nama_komponen' => 'Penyebut (Total Target)',
                'penjelasan' => $parsed['penyebut'],
                'urutan' => 2,
            ]);
        }
        // For DIRECT_VALUE, EXTERNAL_VALUE, EXTERNAL_SCORE, etc.: do not create dummy ratio components
    }

    private function formulaType(string $type, string $code, ?string $formula, array $item): FormulaType
    {
        if ($type === 'IKSS') {
            return FormulaType::DOCUMENTED;
        }

        $plainCode = $this->plainCode($type, $code);
        if ($type === 'IKP' && isset($this->cascadingMap()['ikp_to_sk'][$plainCode])) {
            return FormulaType::CHILD_AGGREGATION;
        }

        $unit = strtolower((string) ($item['unit'] ?? ''));
        $text = strtolower((string) $formula);

        if (trim($text) === '') {
            return FormulaType::EXTERNAL_VALUE;
        }

        // 1. Ratio / Percentage indicators (check before generic text search)
        if (
            str_contains($unit, 'persentase')
            || str_contains($unit, '%')
            || str_contains($text, '100%')
            || str_contains($text, 'x 100')
            || str_contains($text, 'x100')
            || (str_contains($text, 'jumlah') && (str_contains($text, 'total') || str_contains($text, 'seluruh')))
        ) {
            return FormulaType::RATIO_PERCENTAGE;
        }

        // 2. Specific Direct Index / External Score indicators (e.g. IPPN 1.2.1)
        if ($plainCode === '1.2.1' || str_contains($text, 'ippn')) {
            return FormulaType::DIRECT_VALUE;
        }

        // 3. True weighted sum (must have explicit weights and components, not ratio or index)
        if (
            str_contains($text, 'bobot')
            && (str_contains($text, 'x1') || str_contains($text, 'komponen') || str_contains($text, 'parameter'))
            && !str_contains($unit, 'indeks')
        ) {
            return FormulaType::WEIGHTED_SUM;
        }

        // 4. Index indicators (input as direct index value)
        if (str_contains($unit, 'indeks') || str_contains($text, 'indeks')) {
            return FormulaType::DIRECT_VALUE;
        }

        // 5. Value / Direct scores
        if (str_contains($unit, 'nilai') || str_contains($text, 'nilai')) {
            return FormulaType::DIRECT_VALUE;
        }

        return FormulaType::DIRECT_VALUE;
    }
}
