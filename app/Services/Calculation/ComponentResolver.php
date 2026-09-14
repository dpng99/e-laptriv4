<?php

namespace App\Services\Calculation;

use App\Services\Formula\FormulaResolver;

class ComponentResolver
{
    public function resolve(FormulaContext $context): array
    {
        $formula = $context->formula;
        if (!$formula && $context->node->exists) {
            $formula = app(FormulaResolver::class)->active($context->node);
        }
        if ($formula) {
            return $formula->components->map(fn ($c) => [
                'key' => $c->input_key ?: $c->kode_komponen,
                'name' => $c->nama_komponen,
                'weight' => $c->bobot ?? 0,
            ])->all();
        }
        return app(FormulaResolver::class)->definition($context->node)['formula_components'] ?? [];
    }
}
