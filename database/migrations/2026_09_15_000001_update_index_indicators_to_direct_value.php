<?php

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Services\CalculationEngine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private array $targetKeys = [
        'IKP:11.1',
        'IKK:4.1.1',
        'IKK:10.1.1',
        'IKK:10.2.1',
        'IKK:10.3.1',
        'IKK:10.4.1',
        'IKK:10.5.1',
        'IKK:10.8.2',
        'IKK:15.5.1',
    ];

    public function up(): void
    {
        DB::transaction(function () {
            // 1. Update KinerjaNode calculation type and formula key to DIRECT_VALUE
            DB::table('kinerja_nodes')
                ->whereIn('source_key', $this->targetKeys)
                ->update([
                    'calculation_type' => 'DIRECT_VALUE',
                    'formula_key' => 'DIRECT_VALUE',
                    'updated_at' => now(),
                ]);

            $nodeIds = DB::table('kinerja_nodes')
                ->whereIn('source_key', $this->targetKeys)
                ->pluck('id');

            $rumusIds = DB::table('kinerja_rumus_indikators')
                ->whereIn('node_id', $nodeIds)
                ->pluck('id');

            // 2. Remove legacy ratio components (pembilang & penyebut) so InputSchemaService falls back to single direct value
            DB::table('kinerja_komponen_rumus')
                ->whereIn('rumus_indikator_id', $rumusIds)
                ->delete();

            // 3. Update RumusIndikator to DIRECT_VALUE
            DB::table('kinerja_rumus_indikators')
                ->whereIn('node_id', $nodeIds)
                ->update([
                    'tipe_formula' => 'DIRECT_VALUE',
                    'status_formula' => 'RESOLVED; formula_key=DIRECT_VALUE',
                    'rumus_tampilan' => 'Realisasi Langsung / Indeks',
                    'judul_pembilang' => null,
                    'judul_penyebut' => null,
                    'updated_at' => now(),
                ]);

            // 4. Clean up and migrate existing measurements for these nodes
            $existingPengukurans = Pengukuran::whereIn('node_id', $nodeIds)->get();
            $calculationEngine = app(CalculationEngine::class);

            foreach ($existingPengukurans as $pengukuran) {
                // If pembilang exists and realisasi is null/empty, transfer pembilang value to realisasi
                $realisasiValue = $pengukuran->realisasi;
                if (($realisasiValue === null || $realisasiValue === '') && $pengukuran->pembilang !== null && $pengukuran->pembilang !== '') {
                    $realisasiValue = $pengukuran->pembilang;
                }

                if ($realisasiValue !== null && $realisasiValue !== '') {
                    $pengukuran->update([
                        'realisasi' => $realisasiValue,
                        'pembilang' => null,
                        'penyebut' => null,
                    ]);

                    // Update or create pengukuran_input for 'realisasi'
                    $pengukuran->inputs()->updateOrCreate(
                        ['input_key' => 'realisasi'],
                        ['nilai' => $realisasiValue, 'nilai_teks' => null]
                    );
                }

                // Delete obsolete pembilang and penyebut inputs
                $pengukuran->inputs()->whereIn('input_key', ['pembilang', 'penyebut'])->delete();

                // Recalculate node measurement
                $node = KinerjaNode::find($pengukuran->node_id);
                if ($node) {
                    $calculationEngine->calculateNode(
                        $node,
                        $pengukuran->tahun,
                        $pengukuran->triwulan,
                        $pengukuran->unit_kerja_id
                    );
                }
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            $ikkKeys = [
                'IKK:4.1.1',
                'IKK:10.1.1',
                'IKK:10.2.1',
                'IKK:10.3.1',
                'IKK:10.4.1',
                'IKK:10.5.1',
                'IKK:10.8.2',
                'IKK:15.5.1',
            ];

            // Revert IKK nodes
            DB::table('kinerja_nodes')
                ->whereIn('source_key', $ikkKeys)
                ->update([
                    'calculation_type' => 'RATIO',
                    'formula_key' => 'RATIO',
                    'updated_at' => now(),
                ]);

            // Revert IKP 11.1
            DB::table('kinerja_nodes')
                ->where('source_key', 'IKP:11.1')
                ->update([
                    'calculation_type' => 'RATIO',
                    'formula_key' => 'RATIO_PERCENTAGE',
                    'updated_at' => now(),
                ]);

            $ikkNodeIds = DB::table('kinerja_nodes')->whereIn('source_key', $ikkKeys)->pluck('id');
            DB::table('kinerja_rumus_indikators')
                ->whereIn('node_id', $ikkNodeIds)
                ->update([
                    'tipe_formula' => 'RATIO_PERCENTAGE',
                    'status_formula' => 'Transkripsi formula KEPJA; formula_type=RATIO_PERCENTAGE',
                    'rumus_tampilan' => '(Pembilang / Penyebut) x 100%',
                    'updated_at' => now(),
                ]);

            $ikp11NodeId = DB::table('kinerja_nodes')->where('source_key', 'IKP:11.1')->value('id');
            if ($ikp11NodeId) {
                DB::table('kinerja_rumus_indikators')
                    ->where('node_id', $ikp11NodeId)
                    ->update([
                        'tipe_formula' => 'RATIO',
                        'status_formula' => 'RESOLVED; formula_key=RATIO_PERCENTAGE',
                        'rumus_tampilan' => '(Pembilang / Penyebut) x 100%',
                        'updated_at' => now(),
                    ]);
            }
        });
    }
};
