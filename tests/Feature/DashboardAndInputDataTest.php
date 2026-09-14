<?php

namespace Tests\Feature;

use App\Models\Ikk;
use App\Models\KinerjaNode;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAndInputDataTest extends TestCase
{
    use RefreshDatabase;

    private User $operator;
    private UnitKerja $unit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unit = UnitKerja::create([
            'kode' => 'SET-JAMBIN',
            'nama' => 'Sekretariat JAMBIN',
            'is_active' => true,
        ]);

        $this->operator = User::factory()->create([
            'username' => 'set.jambin_test',
            'role_id' => 'OPR',
            'bidang_id' => 'SET',
            'nama_satker' => 'Sekretariat JAMBIN',
            'kinerja_unit_kerja_id' => $this->unit->id,
            'kinerja_role' => 'OPR',
            'kinerja_is_active' => true,
        ]);
    }

    public function test_operator_dashboard_renders_diagram_props_successfully(): void
    {
        $response = $this->actingAs($this->operator)->get(route('dashboard'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Dashboard')
            ->has('unitName')
            ->has('totalSp')
            ->has('totalIkk')
            ->has('ikkTerisi')
            ->has('rataCapaian')
            ->has('skPerformance')
            ->has('stats')
            ->has('statusList')
        );
    }

    public function test_input_data_page_renders_grouped_sp_sk(): void
    {
        // Create an indicator for this unit
        $node = KinerjaNode::create([
            'source_key' => 'IKK:1.3.6',
            'kode' => 'IKK 1.3.6',
            'nama' => 'Persentase Satker Pendampingan ZI',
            'jenis_node' => 'IKK',
            'is_active' => true,
            'input_enabled' => true,
            'calculation_type' => 'RATIO',
            'measurement_scope' => 'ORGANIZATION',
        ]);

        $this->unit->nodes()->attach($node->id, ['peran' => 'OWNER']);

        Ikk::create([
            'node_id' => $node->id,
            'kode_ikk' => 'IKK 1.3.6',
            'nama_ikk' => 'Persentase Satker Pendampingan ZI',
            'satuan' => '%',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->operator)->get(route('input-data.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('InputData/Index')
            ->has('selectedBiro')
            ->has('currentTahun')
            ->has('currentTriwulan')
            ->has('ikks')
            ->has('pengukuranIkk')
            ->has('targetIkk')
        );
    }

    public function test_store_pengukuran_supports_comma_and_dot_decimal_formats(): void
    {
        $node = KinerjaNode::create([
            'source_key' => 'IKK:1.3.6',
            'kode' => 'IKK 1.3.6',
            'nama' => 'Persentase Satker Pendampingan ZI',
            'jenis_node' => 'IKK',
            'is_active' => true,
            'input_enabled' => true,
            'calculation_type' => 'RATIO',
            'measurement_scope' => 'ORGANIZATION',
        ]);

        $this->unit->nodes()->attach($node->id, ['peran' => 'OWNER']);

        Ikk::create([
            'node_id' => $node->id,
            'kode_ikk' => 'IKK 1.3.6',
            'nama_ikk' => 'Persentase Satker Pendampingan ZI',
            'satuan' => '%',
            'is_active' => true,
        ]);

        $payload = [
            'tahun' => 2026,
            'triwulan' => 1,
            'data' => [
                [
                    'kode_ikk' => 'IKK 1.3.6',
                    'pembilang' => '3,12',
                    'penyebut' => '10.5',
                    'inputs' => [
                        'pembilang' => '3,12',
                        'penyebut' => '10.5',
                    ],
                ],
            ],
            'ikp_data' => [],
        ];

        $response = $this->actingAs($this->operator)->post(route('input-data.store'), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $measurement = \App\Models\Pengukuran::where('node_id', $node->id)->first();
        $this->assertNotNull($measurement);
        $this->assertEquals(3.12, $measurement->pembilang);
        $this->assertEquals(10.5, $measurement->penyebut);

        $inputRow = \App\Models\PengukuranInput::where('pengukuran_id', $measurement->id)
            ->where('input_key', 'pembilang')
            ->first();
        $this->assertNotNull($inputRow);
        $this->assertEquals(3.12, $inputRow->nilai);
    }

    public function test_can_store_single_ikp_independently(): void
    {
        $node = KinerjaNode::create([
            'source_key' => 'TEST:DIRECT',
            'kode' => 'IKP TEST DIRECT',
            'nama' => 'Indeks Kepuasan Pelayanan',
            'jenis_node' => \App\Enums\NodeType::IKP,
            'calculation_type' => 'DIRECT_VALUE',
            'input_enabled' => true,
            'is_active' => true,
        ]);
        $this->unit->nodes()->attach($node->id, ['peran' => 'OWNER']);

        \App\Models\Ikp::create([
            'node_id' => $node->id,
            'kode_ikp' => 'IKP TEST DIRECT',
            'nama_ikp' => 'Indeks Kepuasan Pelayanan',
            'target_tahunan' => 100,
            'satuan' => 'Skor',
            'is_active' => true,
        ]);

        $payload = [
            'tahun' => 2026,
            'triwulan' => 1,
            'ikp_data' => [
                [
                    'kode_ikp' => 'IKP TEST DIRECT',
                    'realisasi' => '88.5',
                    'analisis_capaian' => 'Capaian sangat baik',
                ],
            ],
        ];

        $response = $this->actingAs($this->operator)->post(route('input-data.store'), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $measurement = \App\Models\Pengukuran::where('node_id', $node->id)->first();
        $this->assertNotNull($measurement);
        $this->assertEquals(88.5, $measurement->realisasi);
        $this->assertEquals('Capaian sangat baik', $measurement->analisis_capaian);
    }
}

