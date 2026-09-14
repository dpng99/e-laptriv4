<?php

namespace App\Services\Formula;

use App\Models\KinerjaNode;
use App\Models\RumusIndikator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FormulaVersionService
{
    public function save(array $data, ?RumusIndikator $previous = null): RumusIndikator
    {
        return DB::transaction(function () use ($data, $previous) {
            $node = KinerjaNode::whereKey($data['node_id'])->lockForUpdate()->firstOrFail();
            if ($previous && (int) $previous->node_id !== (int) $node->id) {
                throw ValidationException::withMessages(['node_id' => 'Versi rumus tidak dapat dipindahkan ke indikator lain.']);
            }
            if ($previous) {
                $previous = RumusIndikator::whereKey($previous->id)->lockForUpdate()->firstOrFail();
                $latest = $node->formulas()->max('versi');
                if ((int) $previous->versi !== (int) $latest) {
                    throw ValidationException::withMessages(['formula' => 'Rumus telah diperbarui. Buka versi terbaru sebelum menyimpan.']);
                }
                $validIds = $previous->components()->pluck('id');
                foreach ($data['komponen'] ?? [] as $component) {
                    if (!empty($component['id']) && !$validIds->contains($component['id'])) {
                        throw ValidationException::withMessages(['komponen' => 'Komponen bukan milik versi rumus ini.']);
                    }
                }
            }
            $resolver = app(FormulaResolver::class);
            $definition = $resolver->definition($node);
            $key = $data['tipe_formula'];
            if ($definition) {
                $expectedType = match ($definition['formula_key']) {
                    'AVERAGE_COMPONENTS', 'AVERAGE_OF_RATIOS' => 'AVERAGE',
                    'RATIO_PERCENTAGE' => 'RATIO',
                    default => $definition['formula_key'],
                };
                $expectedKeys = collect($definition['formula_components'] ?? [])->pluck('key')->sort()->values()->all();
                $actualKeys = collect($data['komponen'] ?? [])->pluck('kode_komponen')->sort()->values()->all();
                // Existing ratio component identities and form fields remain compatible.
                if ($data['tipe_formula'] !== $expectedType || $actualKeys !== $expectedKeys) {
                    throw ValidationException::withMessages(['tipe_formula' => 'Perubahan jenis atau operand formula canonical memerlukan rekonsiliasi kontrak indikator.']);
                }
                $key = $definition['formula_key'];
                $weights = collect($definition['formula_components'] ?? [])->keyBy('key');
                foreach ($data['komponen'] ?? [] as $component) {
                    $expected = $weights->get($component['kode_komponen']);
                    if (isset($expected['weight']) && (float) ($component['bobot'] ?? 0) !== (float) $expected['weight']) {
                        throw ValidationException::withMessages(['komponen' => 'Bobot resmi harus mengikuti kontrak indikator.']);
                    }
                }
            }
            $active = $data['is_active'] ?? true;
            $status = $definition['formula_status'] ?? 'RESOLVED';
            if (isset(config('formula_review.unresolved', [])[$node->source_key])) $status = 'UNRESOLVED';
            if (!$active) $status = 'DRAFT';
            $attributes = collect($data)->except('komponen')->all();
            $attributes['versi'] = ((int) $node->formulas()->max('versi')) + 1;
            $attributes['is_active'] = $active;
            $attributes['status_formula'] = $status.'; formula_key='.$key;
            $attributes['kebijakan_data_kosong'] = 'BLOCK';
            if ($active) $node->formulas()->update(['is_active' => false]);
            $formula = $node->formulas()->create($attributes);
            foreach ($data['komponen'] ?? [] as $component) {
                unset($component['id']);
                $component['source_type'] = 'INPUT';
                $component['input_key'] = $component['kode_komponen'];
                $formula->components()->create($component);
            }
            if ($active) $node->update(['calculation_type' => $data['tipe_formula'], 'formula_key' => $key]);
            return $formula;
        });
    }

    public function archive(RumusIndikator $formula): void
    {
        DB::transaction(function () use ($formula) {
            KinerjaNode::whereKey($formula->node_id)->lockForUpdate()->firstOrFail();
            $formula->update(['is_active' => false]);
        });
    }
}
