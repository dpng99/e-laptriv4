<?php

namespace App\Services\Formula;

use App\Models\KinerjaNode;
use App\Models\RumusIndikator;

/** One formula version for calculation, validation and audit. */
class FormulaResolver
{
    public function active(KinerjaNode $node): ?RumusIndikator
    {
        return $node->formulas()->where('is_active', true)
            ->orderByDesc('versi')->orderByDesc('id')->with('components.sourceNode')->first();
    }

    public function definition(KinerjaNode $node): array
    {
        $config = require database_path('data/jambin_architecture_v3.php');
        foreach ($config['indicators'] as $definition) {
            if (($definition['source_key'] ?? null) === $node->source_key) {
                return $definition;
            }
        }
        return [];
    }

    public function status(KinerjaNode $node, ?RumusIndikator $formula): string
    {
        if (!$formula && $node->exists && $node->formulas()->exists()) return 'DOCUMENTED_ONLY';
        $pending = config('formula_review.unresolved', []);
        if (isset($pending[$node->source_key])) {
            return 'UNRESOLVED';
        }
        $status = strtoupper(trim(explode(';', $formula?->status_formula ?? '')[0]));
        if (in_array($status, ['RESOLVED', 'EXTERNAL', 'DRAFT', 'UNRESOLVED', 'DOCUMENTED_ONLY', 'DOCUMENTED'], true)) {
            return $status;
        }
        // Legacy transcription metadata is evidence provenance, not approval.
        // Keep the existing simple calculators compatible until source reconciliation.
        return $status === '' || str_starts_with($status, 'TRANSKRIPSI') ? 'LEGACY_COMPATIBLE' : 'UNRESOLVED';
    }

    public function key(KinerjaNode $node, ?RumusIndikator $formula): string
    {
        if ($formula && preg_match('/(?:^|;)\s*formula_key=([A-Z_]+)/i', $formula->status_formula ?? '', $matches)) {
            return strtoupper($matches[1]);
        }
        return strtoupper(trim($node->formula_key ?: $node->calculation_type ?: $formula?->tipe_formula?->value ?: 'DOCUMENTED'));
    }
}
