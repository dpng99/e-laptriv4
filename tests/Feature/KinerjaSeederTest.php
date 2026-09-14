<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KinerjaSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_dataset_jambin_operational_scope_is_seeded_completely(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('kinerja_sp', 12);
        $this->assertDatabaseCount('kinerja_ikp', 20);
        $this->assertDatabaseCount('kinerja_sk', 35);
        $this->assertGreaterThan(0, DB::table('kinerja_ikk')->count());

        $operationalNodes = DB::table('kinerja_nodes')
            ->whereIn('jenis_node', ['SP', 'IKP', 'SK', 'IKK'])
            ->count();

        $this->assertSame(
            DB::table('kinerja_sp')->count()
                + DB::table('kinerja_ikp')->count()
                + DB::table('kinerja_sk')->count()
                + DB::table('kinerja_ikk')->count(),
            $operationalNodes,
        );
    }

    public function test_lkjip_targets_are_available_for_operational_indicators(): void
    {
        $this->seed(DatabaseSeeder::class);

        $targetedOperationalTypes = DB::table('kinerja_targets')
            ->join('kinerja_nodes', 'kinerja_nodes.id', '=', 'kinerja_targets.node_id')
            ->whereIn('jenis_node', ['SP', 'IKP', 'SK', 'IKK'])
            ->distinct()
            ->orderBy('jenis_node')
            ->pluck('jenis_node')
            ->all();

        $this->assertSame(['IKK', 'IKP'], $targetedOperationalTypes);
    }

    public function test_operational_formula_types_are_executable_for_lkjip(): void
    {
        $this->seed(DatabaseSeeder::class);

        $formulaTypes = DB::table('kinerja_rumus_indikators')
            ->join('kinerja_nodes', 'kinerja_nodes.id', '=', 'kinerja_rumus_indikators.node_id')
            ->whereIn('jenis_node', ['IKP', 'IKK'])
            ->distinct()
            ->pluck('tipe_formula')
            ->all();

        $this->assertNotContains('DOCUMENTED', $formulaTypes);
        $this->assertContains('CHILD_AGGREGATION', $formulaTypes);
        $this->assertTrue(
            collect($formulaTypes)->intersect(['RATIO_PERCENTAGE', 'DIRECT_VALUE', 'INDEX_SCORE', 'WEIGHTED_SUM', 'EXTERNAL_VALUE'])->isNotEmpty(),
            'Minimal satu tipe formula leaf harus operasional.',
        );
    }

    public function test_operational_cascading_relations_exist(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertRelationExists('SP:1', 'IKP:1.1');
        $this->assertRelationExists('IKP:1.1', 'SK:1.1');
        $this->assertRelationExists('SK:1.1', 'IKK:1.1.1');
    }

    private function assertRelationExists(string $parentKey, string $childKey): void
    {
        $parent = DB::table('kinerja_nodes')->where('source_key', $parentKey)->value('id');
        $child = DB::table('kinerja_nodes')->where('source_key', $childKey)->value('id');

        $this->assertNotNull($parent, "Parent node {$parentKey} tidak ditemukan.");
        $this->assertNotNull($child, "Child node {$childKey} tidak ditemukan.");

        $this->assertDatabaseHas('kinerja_relasi', [
            'parent_node_id' => $parent,
            'child_node_id' => $child,
        ]);
    }
}
