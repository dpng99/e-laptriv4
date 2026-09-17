<?php

namespace Tests\Feature;

use App\Models\KinerjaNode;
use App\Services\CalculationEngine;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\LaporanKinerjaTriwulanI2026Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LaporanKinerjaTriwulanI2026SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_all_reported_triwulan_one_2026_ikp_measurements_idempotently(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(LaporanKinerjaTriwulanI2026Seeder::class);

        $measurements = DB::table('kinerja_pengukurans as p')
            ->join('kinerja_nodes as n', 'n.id', '=', 'p.node_id')
            ->where('p.tahun', 2026)
            ->where('p.triwulan', 1)
            ->whereIn('n.kode', ['IKP 4.1', 'IKP 6.2', 'IKP 16.1'])
            ->select('n.kode', 'p.realisasi', 'p.capaian', 'p.status', 'p.source_reference')
            ->orderBy('n.kode')
            ->get();

        $this->assertCount(3, $measurements);
        $byCode = $measurements->keyBy('kode');
        $this->assertSame('DRAFT', $byCode['IKP 4.1']->status);
        $this->assertSame(90.095, (float) $byCode['IKP 4.1']->realisasi);
        $this->assertSame(80.0412, (float) $byCode['IKP 6.2']->realisasi);
        $this->assertSame(87.8982, (float) $byCode['IKP 16.1']->realisasi);
        $this->assertStringContainsString('Laporan Kinerja Triwulan I Tahun 2026', $byCode['IKP 4.1']->source_reference);

        $inputs = DB::table('kinerja_pengukuran_inputs as pi')
            ->join('kinerja_pengukurans as p', 'p.id', '=', 'pi.pengukuran_id')
            ->join('kinerja_nodes as n', 'n.id', '=', 'p.node_id')
            ->where('p.tahun', 2026)
            ->where('p.triwulan', 1)
            ->where('n.kode', 'IKP 6.2')
            ->pluck('pi.nilai', 'pi.input_key')
            ->all();

        $this->assertSame(389.0, (float) $inputs['jumlah_satker_patuh']);
        $this->assertSame(486.0, (float) $inputs['jumlah_satker_dinilai']);

        $this->assertSame(19, DB::table('kinerja_pengukurans')
            ->where('tahun', 2026)->where('triwulan', 1)->count());

        $this->assertSame(0, DB::table('kinerja_pengukurans')
            ->where('tahun', 2026)->where('triwulan', 1)
            ->where(function ($query): void {
                $query->whereNull('analisis_capaian')
                    ->orWhereNull('kendala')
                    ->orWhereNull('upaya');
            })
            ->count());

        $ikp51NodeId = KinerjaNode::where('kode', 'IKP 5.1')->value('id');
        $this->assertDatabaseHas('kinerja_pengukurans', [
            'node_id' => $ikp51NodeId,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 3.75,
            'capaian' => 104.17,
            'status' => 'REPORTED',
        ]);

        app(CalculationEngine::class)->calculateAll(2026, 1);

        $this->assertDatabaseHas('kinerja_pengukurans', [
            'node_id' => $ikp51NodeId,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 3.75,
            'status' => 'REPORTED',
        ]);
    }
}
