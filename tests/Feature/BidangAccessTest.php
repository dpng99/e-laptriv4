<?php

namespace Tests\Feature;

use App\Models\Ikk;
use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class BidangAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_only_access_review_and_export_menus(): void
    {
        $admin = User::factory()->create([
            'bidang_id' => 'JMBIN',
            'role_id' => 'ADMIN',
        ]);

        $this->actingAs($admin)->get('/dashboard')->assertForbidden();
        $this->actingAs($admin)->get('/input-data')->assertForbidden();
        $this->actingAs($admin)->post('/input-data')->assertForbidden();
        $this->actingAs($admin)->get('/review-data')->assertOk();
        $this->actingAs($admin)->get('/export')->assertOk();
    }

    public function test_operator_can_only_access_dashboard_and_input_menus(): void
    {
        $this->createUnit('RO-REN', 'Biro Perencanaan');

        $operator = $this->createOperator('REN');

        $this->actingAs($operator)->get('/dashboard')->assertOk();
        $this->actingAs($operator)->get('/input-data')->assertOk();
        $this->actingAs($operator)->get('/review-data')->assertForbidden();
        $this->actingAs($operator)->get('/export')->assertForbidden();
    }

    public function test_inactive_users_are_forbidden_and_logged_out(): void
    {
        $this->createUnit('RO-REN', 'Biro Perencanaan');
        $operator = $this->createOperator('REN');
        $operator->update(['is_active' => false]);

        $response = $this->actingAs($operator)->get('/dashboard');
        $response->assertForbidden();
        $this->assertGuest();
    }

    public function test_dashboard_and_input_only_return_indicators_for_the_logged_in_bidang(): void
    {
        $renUnit = $this->createUnit('RO-REN', 'Biro Perencanaan');
        $keuUnit = $this->createUnit('RO-KEU', 'Biro Keuangan');
        $renIkk = $this->createIkk('IKK TEST REN', 'Indikator Perencanaan', $renUnit);
        $keuIkk = $this->createIkk('IKK TEST KEU', 'Indikator Keuangan', $keuUnit);

        Pengukuran::create([
            'node_id' => $renIkk->node_id,
            'unit_kerja_id' => $renUnit->id,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 50,
            'capaian' => 50,
        ]);
        Pengukuran::create([
            'node_id' => $keuIkk->node_id,
            'unit_kerja_id' => $keuUnit->id,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 100,
            'capaian' => 100,
        ]);

        $operator = $this->createOperator('REN');

        $this->actingAs($operator)
            ->get('/dashboard?tahun=2026&triwulan=1')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->where('unitName', 'Biro Perencanaan')
                ->where('totalIkk', 1)
                ->where('ikkTerisi', 1)
                ->where('rataCapaian', 50)
                ->has('statusList', 1)
                ->where('statusList.0.kode', 'IKK TEST REN'));

        $this->actingAs($operator)
            ->get('/input-data?tahun=2026&triwulan=1')
            ->assertInertia(fn (Assert $page) => $page
                ->component('InputData/Index')
                ->where('selectedBiro', 'Biro Perencanaan')
                ->where('bidangId', 'REN')
                ->has('ikks', 1)
                ->where('ikks.0.kode_ikk', 'IKK TEST REN'));
    }

    public function test_operator_cannot_submit_another_bidangs_indicator(): void
    {
        $this->createUnit('RO-REN', 'Biro Perencanaan');
        $keuUnit = $this->createUnit('RO-KEU', 'Biro Keuangan');
        $keuIkk = $this->createIkk('IKK TEST KEU', 'Indikator Keuangan', $keuUnit);
        $operator = $this->createOperator('REN');

        $this->actingAs($operator)->post('/input-data', [
            'tahun' => 2026,
            'triwulan' => 1,
            'data' => [[
                'kode_ikk' => $keuIkk->kode_ikk,
                'pembilang' => 10,
                'penyebut' => 20,
            ]],
        ])->assertForbidden();

        $this->assertDatabaseCount('kinerja_pengukurans', 0);
    }

    public function test_operator_measurement_is_saved_with_its_unit_id(): void
    {
        $renUnit = $this->createUnit('RO-REN', 'Biro Perencanaan');
        $renIkk = $this->createIkk('IKK TEST REN', 'Indikator Perencanaan', $renUnit);
        $operator = $this->createOperator('REN');

        $this->actingAs($operator)
            ->from('/input-data')
            ->post('/input-data', [
                'tahun' => 2026,
                'triwulan' => 1,
                'data' => [[
                    'kode_ikk' => $renIkk->kode_ikk,
                    'pembilang' => 10,
                    'penyebut' => 20,
                ]],
            ])
            ->assertRedirect('/input-data');

        $this->assertDatabaseHas('kinerja_pengukurans', [
            'node_id' => $renIkk->node_id,
            'unit_kerja_id' => $renUnit->id,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 50,
            'capaian' => null,
            'created_by' => $operator->username,
        ]);
    }

    private function createOperator(string $bidangId): User
    {
        return User::factory()->create([
            'bidang_id' => $bidangId,
            'role_id' => 'OPR',
        ]);
    }

    private function createUnit(string $code, string $name): UnitKerja
    {
        return UnitKerja::create([
            'kode' => $code,
            'nama' => $name,
            'is_active' => true,
        ]);
    }

    private function createIkk(string $code, string $name, UnitKerja $unit): Ikk
    {
        $node = KinerjaNode::create([
            'jenis_node' => 'IKK',
            'input_enabled' => true,
            'calculation_type' => 'RATIO',
            'formula_key' => 'RATIO_PERCENTAGE',
            'source_key' => 'TEST:'.$code,
            'tahun_mulai' => 2025,
            'tahun_selesai' => 2029,
            'is_active' => true,
        ]);

        $ikk = Ikk::create([
            'node_id' => $node->id,
            'kode_ikk' => $code,
            'nama_ikk' => $name,
            'measurement_mode' => 'DIRECT',
            'arah_kinerja' => 'HIGHER_IS_BETTER',
        ]);

        $node->units()->attach($unit->id, ['peran' => 'OWNER']);

        return $ikk;
    }
}
