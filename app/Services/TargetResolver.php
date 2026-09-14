<?php

namespace App\Services;

use App\Models\KinerjaNode;
use App\Models\Target;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TargetResolver
{
    public function resolve(int $nodeId, int $tahun, int $triwulan): ?Target
    {
        return $this->resolveMany([$nodeId], $tahun, $triwulan)->get($nodeId);
    }

    public function resolveMany(iterable $nodeIds, int $tahun, int $triwulan): Collection
    {
        return Target::query()->whereIn('node_id', collect($nodeIds)->all())
            ->where('tahun', $tahun)->where('is_selected', true)
            ->whereIn('periode', ['TW'.$triwulan, 'TAHUNAN'])->get()
            ->groupBy('node_id')->map(fn (Collection $targets) => $this->choose($targets, $triwulan))
            ->filter();
    }

    public function choose(Collection $targets, int $triwulan): ?Target
    {
        $selected = $targets->filter(fn ($t) => $t->is_selected);
        $quarter = $selected->where('periode', 'TW'.$triwulan);
        $candidates = $quarter->isNotEmpty() ? $quarter : $selected->where('periode', 'TAHUNAN');
        // Ambiguity is not resolved by whichever record was inserted last.
        return $candidates->count() === 1 ? $candidates->first() : null;
    }

    public function select(Target $target): Target
    {
        return DB::transaction(function () use ($target) {
            KinerjaNode::whereKey($target->node_id)->lockForUpdate()->firstOrFail();
            $target = Target::whereKey($target->id)->firstOrFail();
            if ($target->nilai_target === null) {
                throw ValidationException::withMessages(['target' => 'Target yang belum ditetapkan tidak dapat dipilih.']);
            }
            Target::where('node_id', $target->node_id)->where('tahun', $target->tahun)
                ->where('periode', $target->periode)->update(['is_selected' => false]);
            $target->refresh()->update(['is_selected' => true]);
            return $target;
        });
    }
}
