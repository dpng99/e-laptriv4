<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\KinerjaNode;
use App\Models\UnitKerja;
use App\Enums\NodeType;

class CalculationEngineTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_nodes_using_factory(): void
    {
        $node = KinerjaNode::factory()->create();
        $this->assertDatabaseHas('kinerja_nodes', ['id' => $node->id]);
    }
}
