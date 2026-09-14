<?php

namespace Tests\Feature;

use App\Models\KinerjaNode;
use App\Models\RelasiKinerja;
use App\Models\RumusIndikator;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CascadingArchitectureV3Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_sakip_is_external_score_and_independent_from_contribution_children(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:1.1')->firstOrFail();

        $this->assertSame('EXTERNAL_SCORE', $node->calculation_type);
        $this->assertSame('EXTERNAL_SCORE', $node->formula_key);
        $this->assertTrue($node->input_enabled);
        $this->assertSame('ORGANIZATION', $node->measurement_scope);
        $this->assertSame(0, $node->formulaChildren()->count());
        $this->assertGreaterThan(0, $node->childrenByRelation('CONTRIBUTION')->count());
    }

    public function test_ikp_10_1_is_mandiri_average_components_with_contribution_children(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:10.1')->firstOrFail();

        $this->assertSame('AVERAGE', $node->calculation_type);
        $this->assertSame('AVERAGE_COMPONENTS', $node->formula_key);
        $this->assertTrue($node->input_enabled);
        $this->assertSame(0, $node->formulaChildren()->count());
        $this->assertGreaterThan(0, $node->childrenByRelation('CONTRIBUTION')->count());
    }

    public function test_ipa_has_eight_weighted_raw_components_and_sk_children_are_not_formula_operands(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:5.1')->firstOrFail();
        $formula = RumusIndikator::where('node_id', $node->id)->where('is_active', true)->firstOrFail();

        $this->assertSame('WEIGHTED_SUM', $node->calculation_type);
        $this->assertCount(8, $formula->components()->get());
        $this->assertSame(0, $node->formulaChildren()->count());
        $this->assertGreaterThan(0, $node->childrenByRelation('CONTRIBUTION')->count());
    }

    public function test_ikp_10_2_uses_survey_index_and_sk_children_are_contribution(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:10.2')->firstOrFail();

        $this->assertSame('SURVEY_INDEX', $node->calculation_type);
        $this->assertSame('SURVEY_INDEX', $node->formula_key);
        $this->assertTrue($node->input_enabled);
        $this->assertGreaterThan(0, $node->childrenByRelation('CONTRIBUTION')->count());
    }

    public function test_program_scope_contains_all_jambin_support_management_programs(): void
    {
        $expected = ['SP:1', 'SP:4', 'SP:5', 'SP:6', 'SP:7', 'SP:8', 'SP:10', 'SP:11', 'SP:13', 'SP:15', 'SP:16'];

        foreach ($expected as $sourceKey) {
            $this->assertDatabaseHas('kinerja_nodes', ['source_key' => $sourceKey]);
        }
    }

    public function test_no_jambin_ikp_to_sk_relation_is_legacy_direct(): void
    {
        $jambinIkpIds = KinerjaNode::where('jenis_node', 'IKP')
            ->whereIn('source_key', array_map(fn ($code) => 'IKP:'.$code, [
                '1.1','4.1','5.1','5.2','6.1','6.2','7.1','7.2','8.1','8.2','8.3',
                '10.1','10.2','11.1','11.2','13.1','13.2','15.1','16.1',
            ]))
            ->pluck('id');

        $this->assertSame(0, RelasiKinerja::whereIn('parent_node_id', $jambinIkpIds)->where('jenis_relasi', 'DIRECT')->count());
    }
}
