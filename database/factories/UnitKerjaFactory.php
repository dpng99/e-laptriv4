<?php

namespace Database\Factories;

use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UnitKerja>
 */
class UnitKerjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'kode' => $this->faker->unique()->numerify('UK-####'),
            'nama' => 'Unit Kerja ' . $this->faker->company(),
            'is_active' => true,
        ];
    }
}
