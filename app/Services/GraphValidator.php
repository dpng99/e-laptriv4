<?php

namespace App\Services;

use App\Models\KinerjaNode;
use InvalidArgumentException;

class GraphValidator
{
    public function assertCanConnect(KinerjaNode $parent, KinerjaNode $child): void
    {
        if ($parent->is($child)) {
            throw new InvalidArgumentException('Node tidak dapat menjadi parent bagi dirinya sendiri.');
        }

        if ($this->canReach($child, $parent)) {
            throw new InvalidArgumentException('Relasi ditolak karena akan membentuk siklus cascading.');
        }
    }

    public function canReach(KinerjaNode $start, KinerjaNode $target): bool
    {
        $visited = [];
        $queue = [$start->getKey()];

        while ($queue !== []) {
            $nodeId = array_shift($queue);

            if ($nodeId === $target->getKey()) {
                return true;
            }

            if (isset($visited[$nodeId])) {
                continue;
            }

            $visited[$nodeId] = true;

            $children = KinerjaNode::query()
                ->whereKey($nodeId)
                ->firstOrFail()
                ->children()
                ->pluck('kinerja_nodes.id')
                ->all();

            array_push($queue, ...$children);
        }

        return false;
    }
}
