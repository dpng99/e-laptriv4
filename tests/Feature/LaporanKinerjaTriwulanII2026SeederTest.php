<?php

namespace Tests\Feature;

use App\Models\KinerjaNode;
use App\Services\CalculationEngine;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\LaporanKinerjaTriwulanII2026Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LaporanKinerjaTriwulanII2026SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_all_reported_triwulan_two_2026_ikp_measurements_idempotently(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(LaporanKinerjaTriwulanII2026Seeder::class);
        $this->seed(LaporanKinerjaTriwulanII2026Seeder::class);

        $measurements = DB::table('kinerja_pengukurans as p')
            ->join('kinerja_nodes as n', 'n.id', '=', 'p.node_id')
            ->where('p.tahun', 2026)
            ->where('p.triwulan', 2)
            ->whereIn('n.kode', ['IKP 4.1', 'IKP 6.2', 'IKP 8.2'])
            ->select('n.kode', 'p.realisasi', 'p.status', 'p.source_reference')
            ->orderBy('n.kode')
            ->get()
            ->keyBy('kode');

        $this->assertCount(3, $measurements);
        $this->assertSame('DRAFT', $measurements['IKP 4.1']->status);
        $this->assertSame(58.985, (float) $measurements['IKP 4.1']->realisasi);
        $this->assertSame(80.0412, (float) $measurements['IKP 6.2']->realisasi);
        $this->assertSame(83.52, (float) $measurements['IKP 8.2']->realisasi);
        $this->assertStringContainsString('Laporan Kinerja Triwulan II Tahun 2026', $measurements['IKP 4.1']->source_reference);

        $inputs = DB::table('kinerja_pengukuran_inputs as pi')
            ->join('kinerja_pengukurans as p', 'p.id', '=', 'pi.pengukuran_id')
            ->join('kinerja_nodes as n', 'n.id', '=', 'p.node_id')
            ->where('p.tahun', 2026)
            ->where('p.triwulan', 2)
            ->where('n.kode', 'IKP 8.2')
            ->pluck('pi.nilai', 'pi.input_key')
            ->all();

        $this->assertSame(83.61, (float) $inputs['KECUKUPAN']);
        $this->assertSame(84.34, (float) $inputs['PENGEMBANGAN']);
        $this->assertSame(82.61, (float) $inputs['PENGELOLAAN']);

        $this->assertSame(19, DB::table('kinerja_pengukurans')
            ->where('tahun', 2026)->where('triwulan', 2)->count());

        $this->assertSame(0, DB::table('kinerja_pengukurans')
            ->where('tahun', 2026)->where('triwulan', 2)
            ->where(function ($query): void {
                $query->whereNull('analisis_capaian')
                    ->orWhereNull('kendala')
                    ->orWhereNull('upaya');
            })
            ->count());

        $ikp102NodeId = KinerjaNode::where('kode', 'IKP 10.2')->value('id');
        $this->assertDatabaseHas('kinerja_pengukurans', [
            'node_id' => $ikp102NodeId,
            'tahun' => 2026,
            'triwulan' => 2,
            'realisasi' => 98.25,
            'capaian' => 115.59,
            'status' => 'REPORTED',
        ]);

        app(CalculationEngine::class)->calculateAll(2026, 2);

        $this->assertDatabaseHas('kinerja_pengukurans', [
            'node_id' => $ikp102NodeId,
            'tahun' => 2026,
            'triwulan' => 2,
            'realisasi' => 98.25,
            'status' => 'REPORTED',
        ]);
    }
}
