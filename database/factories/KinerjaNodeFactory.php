<?php

namespace Database\Factories;

use App\Models\KinerjaNode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KinerjaNode>
 */
class KinerjaNodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'jenis_node' => \App\Enums\NodeType::SS->value,
            'source_key' => $this->faker->uuid(),
            'kode' => 'N-' . $this->faker->unique()->numberBetween(100, 999),
            'nama' => $this->faker->sentence(4),
            'satuan' => '%',
            'calculation_type' => 'DIRECT_VALUE',
            'formula_key' => null,
            'input_enabled' => true,
            'measurement_scope' => 'UNIT',
            'tahun_mulai' => 2025,
            'tahun_selesai' => 2029,
            'is_active' => true,
        ];
    }
}
