<?php

namespace Tests\Feature;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\RumusIndikator;
use App\Models\Target;
use App\Models\User;
use App\Services\CalculationEngine;
use App\Services\Formula\FormulaVersionService;
use App\Services\PengukuranService;
use App\Services\TargetResolver;
use App\Services\WordExportService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BackendIntegrityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    private function node(string $code = 'IKP:6.2'): KinerjaNode
    {
        return KinerjaNode::where('source_key', $code)->firstOrFail();
    }

    private function store(KinerjaNode $node, array $inputs, int $quarter = 1): Pengukuran
    {
        return app(PengukuranService::class)->storeMeasurement($node, $node->units()->firstOrFail()->id, 2026, $quarter, ['inputs' => $inputs], 'operator.test');
    }

    public function test_all_nineteen_core_ikps_are_mandiri_with_no_formula_children(): void
    {
        $config = require database_path('data/jambin_architecture_v3.php');
        $this->assertCount(19, $config['indicators']);
        foreach ($config['indicators'] as $definition) {
            $node = $this->node($definition['source_key']);
            $this->assertSame('MANDIRI', $node->ikp->measurement_mode->value);
            $this->assertSame(0, $node->formulaChildren()->count());
        }
    }

    public function test_reseeding_preserves_component_ids_credentials_and_selected_target(): void
    {
        $node = $this->node('IKP:4.1');
        $formula = $node->formulas()->firstOrFail();
        $componentIds = $formula->components()->pluck('id')->all();
        $user = User::where('username', 'admin.jambin')->firstOrFail();
        $user->forceFill(['remember_token' => 'keep-session-token', 'is_active' => false])->save();
        $password = $user->password;
        $node->targets()->where('tahun', 2026)->update(['is_selected' => false]);
        $target = $node->targets()->where('tahun', 2026)->orderByDesc('id')->firstOrFail();
        $target->update(['is_selected' => true, 'nilai_target' => 87.25]);
        $this->seed(DatabaseSeeder::class);
        $this->assertSame($componentIds, $formula->components()->pluck('id')->all());
        $this->assertSame($password, $user->fresh()->password);
        $this->assertSame('keep-session-token', $user->fresh()->remember_token);
        $this->assertFalse($user->fresh()->is_active);
        $this->assertSame($target->id, app(TargetResolver::class)->resolve($node->id, 2026, 1)->id);
        $this->assertEquals(87.25, $target->fresh()->nilai_target);
    }

    public function test_clearing_an_operand_invalidates_old_draft_result(): void
    {
        $node = $this->node();
        $saved = $this->store($node, ['jumlah_satker_patuh' => 80, 'jumlah_satker_dinilai' => 100]);
        $this->assertSame(80.0, $saved->realisasi);
        $this->assertSame(94.12, $saved->capaian);
        $cleared = $this->store($node, ['jumlah_satker_dinilai' => null]);
        $this->assertNull($cleared->realisasi);
        $this->assertNull($cleared->capaian);
        $this->assertSame('operator.test', $cleared->created_by);
        $this->assertNotEmpty($cleared->calculation_trace['warnings']);
    }

    public function test_official_sakip_score_stays_independent_of_supporting_values(): void
    {
        $node = $this->node('IKP:1.1');
        $saved = $this->store($node, ['nilai_sakip_resmi' => 73]);
        $this->assertSame(73.0, $saved->realisasi);
        $this->assertSame(100.0, $saved->capaian);
        $child = $node->childrenByRelation('CONTRIBUTION')->firstOrFail();
        Pengukuran::create(['node_id' => $child->id, 'unit_kerja_id' => $saved->unit_kerja_id, 'tahun' => 2026, 'triwulan' => 1, 'realisasi' => 1]);
        $again = app(CalculationEngine::class)->calculateNode($node, 2026, 1, $saved->unit_kerja_id);
        $this->assertSame(73.0, $again->realisasi);
        $this->assertSame((string) $node->formulas()->first()->versi, $again->formula_version_snapshot);
    }

    public function test_final_snapshot_is_immutable_after_master_changes_and_recalculation(): void
    {
        $node = $this->node();
        $saved = $this->store($node, ['jumlah_satker_patuh' => 80, 'jumlah_satker_dinilai' => 100]);
        $saved->update(['status' => 'APPROVED', 'approved_at' => now()]);
        $before = $saved->fresh()->getAttributes();
        $node->targets()->update(['nilai_target' => 5]);
        $node->formulas()->update(['batas_capaian' => 1]);
        app(CalculationEngine::class)->calculateNode($node, 2026, 1, $saved->unit_kerja_id);
        $this->assertSame($before, $saved->fresh()->getAttributes());
        try {
            $this->store($node, ['jumlah_satker_patuh' => 5]);
            $this->fail('Final measurement must reject updates.');
        } catch (ValidationException) {
            $this->assertSame($before, $saved->fresh()->getAttributes());
        }
    }

    public function test_unresolved_scale_keeps_raw_data_without_publishing_a_false_result(): void
    {
        $unresolved = config('formula_review.unresolved', []);
        $unresolved['IKP:5.1'] = 'Skala komponen IPA 0-100 belum selaras dengan skala target indeks.';
        config(['formula_review.unresolved' => $unresolved]);

        $node = $this->node('IKP:5.1');
        $result = $this->store($node, array_fill_keys(['X1','X2','X3','X4','X5','X6','X7','X8'], 80));
        $this->assertSame(8, $result->inputs()->count());
        $this->assertNull($result->realisasi);
        $this->assertNull($result->capaian);
        $this->assertSame('UNRESOLVED', $result->calculation_trace['formula_status']);
    }

    public function test_unknown_formula_never_falls_back_to_direct_value(): void
    {
        $node = $this->node();
        $saved = $this->store($node, ['jumlah_satker_patuh' => 80, 'jumlah_satker_dinilai' => 100]);
        $node->formulas()->update(['status_formula' => 'RESOLVED; formula_key=UNREGISTERED']);
        $result = app(CalculationEngine::class)->calculateNode($node, 2026, 1, $saved->unit_kerja_id);
        $this->assertNull($result->realisasi);
    }

    public function test_targets_are_selected_by_period_and_ambiguity_is_not_guessed(): void
    {
        $node = $this->node();
        $annual = app(TargetResolver::class)->resolve($node->id, 2026, 2);
        $quarter = $annual->replicate();
        $quarter->periode = 'TW2';
        $quarter->nilai_target = 25;
        $quarter->save();
        $this->assertSame($quarter->id, app(TargetResolver::class)->resolve($node->id, 2026, 2)->id);
        $this->assertSame($annual->id, app(TargetResolver::class)->resolve($node->id, 2026, 1)->id);
        $node->targets()->where('tahun', 2026)->where('periode', 'TAHUNAN')->update(['is_selected' => true]);
        $this->assertNull(app(TargetResolver::class)->resolve($node->id, 2026, 1));
        app(TargetResolver::class)->select($annual);
        $this->assertSame($annual->id, app(TargetResolver::class)->resolve($node->id, 2026, 1)->id);
    }

    public function test_zero_denominator_and_unknown_operands_are_rejected(): void
    {
        $node = $this->node();
        foreach ([['jumlah_satker_dinilai' => 0], ['unexpected' => 10], ['jumlah_satker_patuh' => ['nested']]] as $input) {
            try { $this->store($node, $input); $this->fail('Invalid operand accepted.'); }
            catch (ValidationException) { $this->assertSame(0, $node->pengukurans()->count()); }
        }
    }

    public function test_batch_is_atomic_when_a_later_measurement_is_locked(): void
    {
        $first = $this->node('IKP:1.1');
        $unit = $first->units()->firstOrFail();
        $second = $this->node('IKP:6.2');
        $second->units()->syncWithoutDetaching([$unit->id => ['peran' => 'OWNER']]);
        Pengukuran::create(['node_id' => $second->id, 'unit_kerja_id' => $unit->id, 'tahun' => 2026, 'triwulan' => 1, 'status' => 'LOCKED']);
        $operator = User::factory()->create(['bidang_id' => 'TEST', 'role_id' => 'OPR', 'kinerja_role' => 'OPR', 'kinerja_unit_kerja_id' => $unit->id]);
        $response = $this->actingAs($operator)->post(route('input-data.store'), [
            'tahun' => 2026, 'triwulan' => 1, 'ikp_data' => [
                ['kode_ikp' => $first->ikp->kode_ikp, 'inputs' => ['nilai_sakip_resmi' => 73]],
                ['kode_ikp' => $second->ikp->kode_ikp, 'inputs' => ['jumlah_satker_patuh' => 1, 'jumlah_satker_dinilai' => 2]],
            ],
        ]);
        $response->assertSessionHasErrors();
        $this->assertSame(0, $first->pengukurans()->count());
    }

    public function test_formula_revision_preserves_history_and_reseed_does_not_reactivate_v1(): void
    {
        $node = $this->node('IKP:4.1');
        $first = $node->formulas()->firstOrFail();
        $componentIds = $first->components()->pluck('id')->all();
        $next = app(FormulaVersionService::class)->save([
            'node_id' => $node->id, 'tipe_formula' => 'WEIGHTED_SUM', 'arah_kinerja' => 'HIGHER_IS_BETTER',
            'is_active' => true, 'komponen' => $first->components->map(fn ($c) => [
                'id' => $c->id, 'kode_komponen' => $c->kode_komponen, 'nama_komponen' => $c->nama_komponen,
                'tipe_data' => 'DECIMAL', 'bobot' => $c->bobot,
            ])->all(),
        ], $first);
        $this->assertSame(2, (int) $next->versi);
        $this->assertFalse($first->fresh()->is_active);
        $this->assertSame($componentIds, $first->components()->pluck('id')->all());
        $this->seed(DatabaseSeeder::class);
        $this->assertSame($next->id, $node->formulas()->where('is_active', true)->sole()->id);
    }

    public function test_export_traversal_includes_contribution_children(): void
    {
        $method = new \ReflectionMethod(WordExportService::class, 'collectSasaranAndIkpData');
        $data = $method->invoke(app(WordExportService::class), 2026, 1);
        $json = json_encode($data);
        $this->assertStringContainsString('IKK 1.1.1', $json);
        $this->assertStringContainsString('IKK 16.1.1', $json);
    }

    public function test_explanation_migration_rolls_back_actual_columns(): void
    {
        $migration = require database_path('migrations/2026_09_01_075102_add_penjelasan_to_kinerja_tables.php');
        $migration->down();
        foreach (['kinerja_ikp', 'kinerja_ikk', 'kinerja_komponen_rumus'] as $table) $this->assertFalse(Schema::hasColumn($table, 'penjelasan'));
        $migration->up();
        $this->assertTrue(Schema::hasColumn('kinerja_ikp', 'penjelasan'));
    }
}
