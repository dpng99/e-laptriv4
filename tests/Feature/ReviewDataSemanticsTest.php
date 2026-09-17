<?php

namespace Tests\Feature;

use App\Models\Ikp;
use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ReviewDataSemanticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_review_data_exposes_result_and_achievement_as_distinct_values(): void
    {
        $unit = UnitKerja::create(['kode' => 'RO-REN', 'nama' => 'Biro Perencanaan', 'is_active' => true]);
        $node = KinerjaNode::create([
            'source_key' => 'TEST:IKP-HASIL',
            'kode' => 'IKP TEST HASIL',
            'nama' => 'Indikator Uji Hasil Kinerja',
            'jenis_node' => 'IKP',
            'input_enabled' => true,
            'is_active' => true,
        ]);
        $node->units()->attach($unit->id, ['peran' => 'OWNER']);
        Ikp::create([
            'node_id' => $node->id,
            'kode_ikp' => 'IKP TEST HASIL',
            'nama_ikp' => 'Indikator Uji Hasil Kinerja',
            'satuan' => 'PERSEN',
        ]);
        Pengukuran::create([
            'node_id' => $node->id,
            'unit_kerja_id' => $unit->id,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 80.04,
            'capaian' => 94.17,
        ]);
        $admin = User::factory()->create(['role_id' => 'ADMIN']);

        $this->actingAs($admin)->get('/review-data?tahun=2026&triwulan=1')
            ->assertInertia(fn (Assert $page) => $page
                ->component('ReviewData/Index')
                ->where('data.0.hasil_kinerja', 80.04)
                ->where('data.0.capaian_terhadap_target', 94.17));
    }
}
