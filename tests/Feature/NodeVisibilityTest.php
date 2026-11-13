<?php

namespace Tests\Feature;

use App\Models\Ikk;
use App\Models\Ikp;
use App\Models\KinerjaNode;
use App\Models\Sk;
use App\Models\Sp;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class NodeVisibilityTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $operator;
    private UnitKerja $unit;
    private KinerjaNode $spNode;
    private KinerjaNode $ikpNode;
    private KinerjaNode $skNode;
    private KinerjaNode $ikkNode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unit = UnitKerja::create([
            'kode' => 'RO-REN',
            'nama' => 'Biro Perencanaan',
            'is_active' => true,
        ]);

        $this->admin = User::factory()->create([
            'username' => 'admin.vis.test',
            'role_id' => 'ADMIN',
            'kinerja_role' => 'ADMIN',
            'is_active' => true,
            'kinerja_is_active' => true,
        ]);

        $this->operator = User::factory()->create([
            'username' => 'opr.ren.test',
            'role_id' => 'OPR',
            'bidang_id' => 'REN',
            'nama_satker' => 'Biro Perencanaan',
            'kinerja_unit_kerja_id' => $this->unit->id,
            'kinerja_role' => 'OPR',
            'is_active' => true,
            'kinerja_is_active' => true,
        ]);

        $this->spNode = KinerjaNode::create([
            'source_key' => 'SP:1',
            'kode' => 'SP 1',
            'nama' => 'Meningkatnya akuntabilitas kinerja Kejaksaan RI',
            'jenis_node' => 'SP',
            'is_active' => true,
        ]);
        Sp::create([
            'node_id' => $this->spNode->id,
            'kode_sp' => 'SP 1',
            'nama_sp' => 'Meningkatnya akuntabilitas kinerja Kejaksaan RI',
        ]);

        $this->ikpNode = KinerjaNode::create([
            'source_key' => 'IKP:1.1',
            'kode' => 'IKP 1.1',
            'nama' => 'Nilai SAKIP Kejaksaan RI',
            'jenis_node' => 'IKP',
            'calculation_type' => 'EXTERNAL_SCORE',
            'input_enabled' => true,
            'is_active' => true,
        ]);
        Ikp::create([
            'node_id' => $this->ikpNode->id,
            'kode_ikp' => 'IKP 1.1',
            'nama_ikp' => 'Nilai SAKIP Kejaksaan RI',
            'satuan' => 'Nilai',
        ]);
        $this->ikpNode->units()->attach($this->unit->id, ['peran' => 'OWNER']);
        $this->spNode->children()->attach($this->ikpNode->id, ['jenis_relasi' => 'STRUCTURAL', 'dasar_relasi' => 'RENSTRA_2025_2029']);

        $this->skNode = KinerjaNode::create([
            'source_key' => 'SK:1.1.1',
            'kode' => 'SK 1.1.1',
            'nama' => 'Terwujudnya Perencanaan dan RB yang Efektif',
            'jenis_node' => 'SK',
            'is_active' => true,
        ]);
        Sk::create([
            'node_id' => $this->skNode->id,
            'kode_sk' => 'SK 1.1.1',
            'nama_sk' => 'Terwujudnya Perencanaan dan RB yang Efektif',
        ]);
        $this->skNode->units()->attach($this->unit->id, ['peran' => 'OWNER']);
        $this->ikpNode->children()->attach($this->skNode->id, ['jenis_relasi' => 'CONTRIBUTION', 'dasar_relasi' => 'RENSTRA_2025_2029']);

        $this->ikkNode = KinerjaNode::create([
            'source_key' => 'IKK:1.1.1.1',
            'kode' => 'IKK 1.1.1.1',
            'nama' => 'Persentase layanan RB sesuai SLA',
            'jenis_node' => 'IKK',
            'calculation_type' => 'RATIO',
            'input_enabled' => true,
            'is_active' => true,
        ]);
        Ikk::create([
            'node_id' => $this->ikkNode->id,
            'kode_ikk' => 'IKK 1.1.1.1',
            'nama_ikk' => 'Persentase layanan RB sesuai SLA',
            'satuan' => '%',
        ]);
        $this->ikkNode->units()->attach($this->unit->id, ['peran' => 'OWNER']);
        $this->skNode->children()->attach($this->ikkNode->id, ['jenis_relasi' => 'STRUCTURAL', 'dasar_relasi' => 'RENSTRA_2025_2029']);
    }

    public function test_admin_can_hide_and_show_sk_and_ikk_individually(): void
    {
        // Hide IKK
        $this->actingAs($this->admin)
            ->patch(route('admin.visibility.toggle', $this->ikkNode->id), ['is_active' => false])
            ->assertRedirect();

        $this->assertFalse($this->ikkNode->fresh()->is_active);

        // Show IKK back
        $this->actingAs($this->admin)
            ->patch(route('admin.visibility.toggle', $this->ikkNode->id), ['is_active' => true])
            ->assertRedirect();

        $this->assertTrue($this->ikkNode->fresh()->is_active);
    }

    public function test_admin_cannot_hide_sp_or_ikp_nodes(): void
    {
        $this->actingAs($this->admin)
            ->patch(route('admin.visibility.toggle', $this->ikpNode->id), ['is_active' => false])
            ->assertSessionHasErrors('node_id');

        $this->actingAs($this->admin)
            ->patch(route('admin.visibility.toggle', $this->spNode->id), ['is_active' => false])
            ->assertSessionHasErrors('node_id');

        $this->assertTrue($this->ikpNode->fresh()->is_active);
        $this->assertTrue($this->spNode->fresh()->is_active);
    }

    public function test_operator_cannot_access_visibility_endpoints(): void
    {
        $this->actingAs($this->operator)
            ->patch(route('admin.visibility.toggle', $this->ikkNode->id), ['is_active' => false])
            ->assertForbidden();

        $this->actingAs($this->operator)
            ->post(route('admin.visibility.bulk'), ['target_level' => 'ALL_SK_IKK', 'is_active' => false])
            ->assertForbidden();
    }

    public function test_hiding_sk_cascades_operational_invisibility_to_child_ikks_across_all_views_and_blocks_operator_submit(): void
    {
        // Admin hides parent SK only (child IKK still has is_active = true in DB)
        $this->actingAs($this->admin)
            ->patch(route('admin.visibility.toggle', $this->skNode->id), ['is_active' => false])
            ->assertRedirect();

        $this->assertFalse($this->skNode->fresh()->is_active);
        $this->assertFalse($this->ikkNode->fresh()->isEffectivelyVisible());

        // 1. Operator Input Data page must not list the IKK under hidden SK
        $this->actingAs($this->operator)
            ->get(route('input-data.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('InputData/Index')
                ->has('ikks', 0)
                ->has('ikpInputs', 1)
            );

        // 2. Operator attempting to submit measurement for the hidden IKK must be blocked (403)
        $this->actingAs($this->operator)
            ->post(route('input-data.store'), [
                'tahun' => 2026,
                'triwulan' => 1,
                'data' => [
                    [
                        'kode_ikk' => 'IKK 1.1.1.1',
                        'pembilang' => '10',
                        'penyebut' => '10',
                    ],
                ],
            ])
            ->assertForbidden();

        // 3. Operator Dashboard must show 0 visible IKK
        $this->actingAs($this->operator)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->where('totalIkk', 0)
            );

        // 4. Admin Review Data hides both SK and its child IKK by default (only SP and IKP remain in data)
        $this->actingAs($this->admin)
            ->get(route('review-data.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('ReviewData/Index')
                ->has('data', 2)
                ->has('allData', 4)
            );
    }

    public function test_admin_can_bulk_hide_and_show_all_sk_and_ikk(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.visibility.bulk'), [
                'target_level' => 'ALL_SK_IKK',
                'is_active' => false,
            ])
            ->assertRedirect();

        $this->assertFalse($this->skNode->fresh()->is_active);
        $this->assertFalse($this->ikkNode->fresh()->is_active);
        $this->assertTrue($this->ikpNode->fresh()->is_active);

        $this->actingAs($this->admin)
            ->post(route('admin.visibility.bulk'), [
                'target_level' => 'ALL_SK_IKK',
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertTrue($this->skNode->fresh()->is_active);
        $this->assertTrue($this->ikkNode->fresh()->is_active);
    }

    public function test_word_export_excludes_hidden_sk_and_ikk_while_retaining_ikp(): void
    {
        // Hide SK 1.1.1
        $this->actingAs($this->admin)
            ->patch(route('admin.visibility.toggle', $this->skNode->id), ['is_active' => false])
            ->assertRedirect();

        $filePath = app(\App\Services\WordExportService::class)->generateLkjiP(2026, 1);
        $this->assertFileExists($filePath);

        $zip = new \ZipArchive();
        $this->assertTrue($zip->open($filePath) === true);
        $xml = (string) $zip->getFromName('word/document.xml');
        $zip->close();
        @unlink($filePath);

        // IKP 1.1 must still be present in the report
        $this->assertStringContainsString('Nilai SAKIP Kejaksaan RI', $xml);
        // Hidden SK 1.1.1 and its child IKK 1.1.1.1 must NOT appear in the Word export
        $this->assertStringNotContainsString('Terwujudnya Perencanaan dan RB yang Efektif', $xml);
        $this->assertStringNotContainsString('Persentase layanan RB sesuai SLA', $xml);
    }
}
