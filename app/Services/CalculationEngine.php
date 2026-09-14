<?php

namespace App\Services;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\RumusIndikator;
use App\Models\Target;
use App\Services\Calculation\AchievementService;
use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaContext;
use App\Services\Calculation\FormulaRegistry;
use App\Services\Calculation\StatusResolver;
use App\Services\Formula\FormulaResolver;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CalculationEngine
{
    public function __construct(
        private readonly FormulaRegistry $formulaRegistry = new FormulaRegistry(),
        private readonly AchievementService $achievementService = new AchievementService(),
        private readonly StatusResolver $statusResolver = new StatusResolver(),
        private readonly FormulaResolver $formulas = new FormulaResolver(),
        private readonly TargetResolver $targets = new TargetResolver(),
    ) {}

    public function calculateNode(KinerjaNode $node, int $tahun, int $triwulan, ?int $unitKerjaId = null): ?Pengukuran
    {
        $unitKerjaId ??= $this->ownerUnitId($node);
        return DB::transaction(function () use ($node, $tahun, $triwulan, $unitKerjaId) {
            $node = KinerjaNode::whereKey($node->id)->lockForUpdate()->firstOrFail();
            $measurement = Pengukuran::where('node_id', $node->id)->where('unit_kerja_id', $unitKerjaId)
                ->where('tahun', $tahun)->where('triwulan', $triwulan)->lockForUpdate()->first();
            if ($measurement?->isFinal()) {
                return $measurement;
            }

            $formula = $this->formulas->active($node);
            $key = $this->formulas->key($node, $formula);
            $status = $this->formulas->status($node, $formula);
            $children = $node->formulaChildren()->get();
            // Structural/contribution nodes do not gain measurements merely by being traversed.
            if (!$measurement && $children->isEmpty()) {
                return null;
            }
            $measurement ??= new Pengukuran([
                'node_id' => $node->id, 'unit_kerja_id' => $unitKerjaId,
                'tahun' => $tahun, 'triwulan' => $triwulan,
            ]);
            $target = $this->targets->resolve($node->id, $tahun, $triwulan);
            $raw = $measurement->exists ? $measurement->inputs()->pluck('nilai', 'input_key')->all() : [];
            foreach (['pembilang', 'penyebut'] as $field) {
                if (!array_key_exists($field, $raw) && $measurement->$field !== null) {
                    $raw[$field] ??= $measurement->$field;
                }
            }
            // Only uncalculated legacy direct scores may use their old result column as input.
            if (!$measurement->calculated_at && in_array($key, ['DIRECT_VALUE', 'EXTERNAL_SCORE', 'EXTERNAL_VALUE', 'COUNT', 'INDEX_SCORE'], true)) {
                $raw['realisasi'] ??= $measurement->realisasi;
                if ($measurement->exists && $raw['realisasi'] !== null) {
                    $measurement->inputs()->firstOrCreate(['input_key' => 'realisasi'], ['nilai' => $raw['realisasi']]);
                }
            }

            $schemaKeys = array_column($this->formulas->definition($node)['input_schema']['fields'] ?? [], 'key');
            if ($schemaKeys && array_intersect($schemaKeys, array_keys($raw))) {
                // A cleared canonical field takes precedence over legacy result aliases.
                $raw = array_intersect_key($raw, array_flip($schemaKeys));
            }

            $childMeasurements = $children->map(function ($child) use ($tahun, $triwulan, $unitKerjaId) {
                return Pengukuran::where('node_id', $child->id)->where('unit_kerja_id', $unitKerjaId)
                    ->where('tahun', $tahun)->where('triwulan', $triwulan)->first()
                    ?? new Pengukuran(['node_id' => $child->id, 'realisasi' => null]);
            });
            // Bind indicator components only when the graph explicitly marks that dependency.
            foreach ($formula?->components ?? [] as $component) {
                if ($component->source_type === 'INDICATOR') {
                    $raw[$component->input_key ?: $component->kode_komponen] = $children->contains('id', $component->source_node_id)
                        ? $childMeasurements->firstWhere('node_id', $component->source_node_id)?->realisasi : null;
                }
            }
            $blocked = in_array($status, ['DRAFT', 'UNRESOLVED', 'DOCUMENTED', 'DOCUMENTED_ONLY'], true);
            if ($blocked || !$this->formulaRegistry->has($key)) {
                $reason = config('formula_review.unresolved', [])[$node->source_key] ?? "Formula {$key} ({$status}) belum dapat dieksekusi.";
                $result = new CalculationResult(null, [], [$reason]);
            } else {
                $result = $this->formulaRegistry->calculate($key, new FormulaContext(
                    node: $node, rawInputs: $raw, target: $target,
                    childrenMeasurements: $childMeasurements, formula: $formula,
                ));
            }
            // Missing operands invalidate an old draft result; never retain a stale success.
            $measurement->realisasi = $result->value;
            $measurement->created_by ??= auth()->user()?->username ?? 'system';
            $measurement->updated_by = auth()->user()?->username ?? $measurement->updated_by ?? 'system';
            return $this->applyAchievement($measurement, $node, $target, $formula, $key, $status, $result);
        });
    }

    public function calculateAll(int $tahun, int $triwulan, ?int $unitKerjaId = null): void
    {
        $nodes = KinerjaNode::where('is_active', true)->whereIn('jenis_node', ['IKP', 'IKK'])
            ->where('source_key', 'not like', 'IKP:18.%')->where('source_key', 'not like', 'IKK:18.%')
            ->with('children')->get()->keyBy('id');
        $done = [];
        $visiting = [];
        $visit = function (KinerjaNode $node) use (&$visit, &$done, &$visiting, $nodes, $tahun, $triwulan, $unitKerjaId) {
            if (isset($done[$node->id])) return;
            if (isset($visiting[$node->id])) throw new RuntimeException('Siklus dependency formula: '.$node->source_key);
            $visiting[$node->id] = true;
            foreach ($node->children as $child) {
                if ($child->pivot->jenis_relasi === 'FORMULA_COMPONENT' && $nodes->has($child->id)) {
                    $visit($nodes->get($child->id));
                }
            }
            $dependencyIds = $node->children->filter(fn ($child) => $child->pivot->jenis_relasi === 'FORMULA_COMPONENT')->pluck('id');
            $units = Pengukuran::whereIn('node_id', $dependencyIds->push($node->id))->where('tahun', $tahun)->where('triwulan', $triwulan)
                ->when($unitKerjaId !== null, fn ($q) => $q->where('unit_kerja_id', $unitKerjaId))->pluck('unit_kerja_id');
            foreach ($units->unique() as $id) {
                $this->calculateNode($node, $tahun, $triwulan, $id);
            }
            unset($visiting[$node->id]);
            $done[$node->id] = true;
        };
        DB::transaction(function () use ($nodes, $visit) { foreach ($nodes as $node) $visit($node); });
    }

    public function calculateLeafCapaian(?string $formulaVal, float $realisasi, float $pembilang = 0, float $penyebut = 1, float $target = 0): float
    {
        $polarity = strtoupper((string) $formulaVal) === 'UNFAVORABLE_PERCENTAGE' ? 'MINIMIZE' : 'MAXIMIZE';
        return (float) ($this->achievementService->calculate($realisasi, $target, $polarity) ?? 0.0);
    }

    private function applyAchievement(Pengukuran $measurement, KinerjaNode $node, ?Target $target, ?RumusIndikator $formula, string $key, string $status, CalculationResult $result): Pengukuran
    {
        $targetValue = $target?->nilai_target;
        $polarity = $formula?->arah_kinerja?->value === 'LOWER_IS_BETTER' ? 'MINIMIZE' : 'MAXIMIZE';
        $measurement->target_id = $target?->id;
        $measurement->capaian = $this->achievementService->calculate(
            $measurement->realisasi, $targetValue, $polarity,
            $formula?->batas_capaian !== null ? (float) $formula->batas_capaian : null,
        );
        $measurement->target_snapshot = $targetValue;
        $measurement->formula_key_snapshot = $key;
        $measurement->formula_version_snapshot = $formula ? (string) $formula->versi : null;
        $measurement->status_capaian = $this->statusResolver->resolve($measurement->capaian, $measurement->triwulan, $measurement->realisasi);
        $measurement->calculation_trace = [
            'formula_id' => $formula?->id, 'formula_version' => $formula?->versi,
            'formula_key' => $key, 'formula_status' => $status,
            'formula_display' => $formula?->rumus_tampilan,
            'architecture_version' => $this->formulas->definition($node)['formula_version'] ?? null,
            'target_id' => $target?->id, 'target_document_id' => $target?->dokumen_kinerja_id,
            'target_period' => $target?->periode, 'polarity' => $polarity,
            'realisasi' => $measurement->realisasi, 'target' => $targetValue,
            'capaian' => $measurement->capaian, 'status' => $measurement->status_capaian,
            'components' => $result->components,
            'warnings' => array_merge($result->warnings, $target ? [] : ['Target terpilih belum tersedia atau ambigu.']),
            'calculated_at' => now()->toIso8601String(),
        ];
        $measurement->calculated_at = now();
        $measurement->save();
        return $measurement;
    }

    private function ownerUnitId(KinerjaNode $node): ?int
    {
        $owners = $node->units()->wherePivot('peran', 'OWNER')->get();
        return $owners->count() === 1 ? $owners->first()->id : null;
    }
}
