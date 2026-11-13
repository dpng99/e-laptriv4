<?php

namespace App\Services;

use App\Enums\NodeType;
use App\Models\KinerjaNode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class NodeVisibilityService
{
    /**
     * Toggle visibility (is_active) of a single SK or IKK node.
     * SP and IKP nodes are canonical Perjanjian Kinerja anchors and cannot be hidden.
     *
     * @return array{updated_count: int, node_id: int, is_active: bool}
     */
    public function toggleNode(KinerjaNode $node, bool $isActive, bool $cascadeToChildren = false, string $actor = 'admin'): array
    {
        $type = $node->jenis_node instanceof NodeType ? $node->jenis_node->value : (string) $node->jenis_node;

        if (!in_array($type, ['SK', 'IKK'], true)) {
            throw ValidationException::withMessages([
                'node_id' => 'Hanya Sasaran Kegiatan (SK) dan Indikator Kinerja Kegiatan (IKK) yang dapat disembunyikan atau dimunculkan.',
            ]);
        }

        $updatedCount = 0;

        DB::transaction(function () use ($node, $type, $isActive, $cascadeToChildren, &$updatedCount) {
            $node->is_active = $isActive;
            $node->save();
            $updatedCount++;

            if ($type === 'SK' && $cascadeToChildren) {
                $childIkkIds = $node->children()
                    ->where('kinerja_nodes.jenis_node', 'IKK')
                    ->pluck('kinerja_nodes.id');

                if ($childIkkIds->isNotEmpty()) {
                    $updatedCount += KinerjaNode::whereIn('id', $childIkkIds)
                        ->update(['is_active' => $isActive, 'updated_at' => now()]);
                }
            }
        });

        Log::info('Admin Visibility Mutation: Single node visibility updated', [
            'actor' => $actor,
            'node_id' => $node->id,
            'source_key' => $node->source_key,
            'jenis_node' => $type,
            'is_active' => $isActive,
            'cascade_to_children' => $cascadeToChildren,
            'updated_count' => $updatedCount,
        ]);

        return [
            'updated_count' => $updatedCount,
            'node_id' => $node->id,
            'is_active' => $isActive,
        ];
    }

    /**
     * Bulk update visibility for SK and/or IKK nodes, optionally scoped by Unit Kerja.
     */
    public function bulkUpdate(string $targetLevel, bool $isActive, ?int $unitKerjaId = null, string $actor = 'admin'): int
    {
        $allowedLevels = match (strtoupper($targetLevel)) {
            'SK' => ['SK'],
            'IKK' => ['IKK'],
            'ALL_SK_IKK', 'ALL' => ['SK', 'IKK'],
            default => throw ValidationException::withMessages([
                'target_level' => 'Target level visibilitas harus bernilai SK, IKK, atau ALL_SK_IKK.',
            ]),
        };

        $updatedCount = DB::transaction(function () use ($allowedLevels, $isActive, $unitKerjaId) {
            $query = KinerjaNode::query()->whereIn('jenis_node', $allowedLevels);

            if ($unitKerjaId !== null) {
                $query->whereHas('units', fn ($q) => $q->whereKey($unitKerjaId));
            }

            return $query->update([
                'is_active' => $isActive,
                'updated_at' => now(),
            ]);
        });

        Log::info('Admin Visibility Mutation: Bulk visibility updated', [
            'actor' => $actor,
            'target_level' => $targetLevel,
            'is_active' => $isActive,
            'unit_kerja_id' => $unitKerjaId,
            'updated_count' => $updatedCount,
        ]);

        return $updatedCount;
    }

    /**
     * Summary counts of SK and IKK visibility across the graph.
     *
     * @return array{
     *   total_sk: int,
     *   active_sk: int,
     *   hidden_sk: int,
     *   total_ikk: int,
     *   visible_ikk: int,
     *   hidden_ikk: int
     * }
     */
    public function getVisibilitySummary(): array
    {
        $totalSk = KinerjaNode::where('jenis_node', 'SK')->count();
        $activeSk = KinerjaNode::where('jenis_node', 'SK')->where('is_active', true)->count();

        $totalIkk = KinerjaNode::where('jenis_node', 'IKK')->count();
        $visibleIkk = KinerjaNode::where('jenis_node', 'IKK')->visibleOperational()->count();

        return [
            'total_sk' => $totalSk,
            'active_sk' => $activeSk,
            'hidden_sk' => max(0, $totalSk - $activeSk),
            'total_ikk' => $totalIkk,
            'visible_ikk' => $visibleIkk,
            'hidden_ikk' => max(0, $totalIkk - $visibleIkk),
        ];
    }
}
