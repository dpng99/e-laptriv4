<?php

namespace Tests\Feature;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Services\CalculationEngine;
use App\Services\InputSchemaService;
use App\Services\PengukuranService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReconciledDocumentFormulasTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    private function store(KinerjaNode $node, array $inputs, int $quarter = 2): Pengukuran
    {
        return app(PengukuranService::class)->storeMeasurement(
            $node,
            $node->units()->firstOrFail()->id,
            2026,
            $quarter,
            ['inputs' => $inputs],
            'operator.test'
        );
    }

    public function test_ikp_7_1_is_external_score_and_accepts_official_lan_score(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:7.1')->firstOrFail();

        $this->assertSame('EXTERNAL_SCORE', $node->calculation_type);
        $this->assertSame('EXTERNAL_SCORE', $node->formula_key);

        $schema = app(InputSchemaService::class)->getSchemaForNode($node);
        $this->assertSame('EXTERNAL_SCORE', $schema['formula_key']);
        $this->assertCount(1, $schema['fields']);
        $this->assertSame('nilai_ikk_resmi', $schema['fields'][0]['key']);

        $saved = $this->store($node, ['nilai_ikk_resmi' => 80.04]);
        $this->assertSame(80.04, (float) $saved->realisasi);
    }

    public function test_ikp_7_2_uses_sum_with_corrected_weights_and_special_appreciation_formula(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:7.2')->firstOrFail();

        $this->assertSame('SUM', $node->calculation_type);
        $this->assertSame('SUM', $node->formula_key);

        $schema = app(InputSchemaService::class)->getSchemaForNode($node);
        $this->assertSame('SUM', $schema['formula_key']);
        $this->assertCount(4, $schema['fields']);
        $this->assertSame('X1', $schema['fields'][0]['key']);
        $this->assertSame('X2', $schema['fields'][1]['key']);
        $this->assertSame('X3', $schema['fields'][2]['key']);
        $this->assertSame('X4', $schema['fields'][3]['key']);
        $this->assertSame(25, $schema['fields'][0]['max']);
        $this->assertSame(25, $schema['fields'][1]['max']);
        $this->assertSame(30, $schema['fields'][2]['max']);
        $this->assertSame(20, $schema['fields'][3]['max']);

        // Input data matching Bab III document:
        // X1 = 25, X2 = 22.5, X3 = 28, X4 = 15
        // Nilai Awal = 25 + 22.5 + 28 + 15 = 90.5
        // Nilai Apresiasi = (100 - 90.5) * 80% = 7.6
        // Nilai Akhir = 90.5 + 7.6 = 98.10
        $saved = $this->store($node, [
            'X1' => 25,
            'X2' => 22.5,
            'X3' => 28,
            'X4' => 15,
        ]);

        $this->assertSame(98.10, (float) $saved->realisasi);
        $trace = $saved->calculation_trace['components'];
        $this->assertSame(90.5, (float) $trace['nilai_awal']);
        $this->assertSame(7.6, (float) $trace['nilai_apresiasi']);
        $this->assertSame(98.1, (float) $trace['nilai_akhir']);
    }

    public function test_ikp_8_1_is_external_score_and_accepts_official_merit_score(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:8.1')->firstOrFail();

        $this->assertSame('EXTERNAL_SCORE', $node->calculation_type);
        $this->assertSame('EXTERNAL_SCORE', $node->formula_key);

        $schema = app(InputSchemaService::class)->getSchemaForNode($node);
        $this->assertSame('EXTERNAL_SCORE', $schema['formula_key']);
        $this->assertCount(1, $schema['fields']);
        $this->assertSame('nilai_sistem_merit_resmi', $schema['fields'][0]['key']);

        $saved = $this->store($node, ['nilai_sistem_merit_resmi' => 329]);
        $this->assertSame(329.0, (float) $saved->realisasi);
    }

    public function test_ikp_11_1_is_ratio_percentage_calculating_competency_fit_index(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:11.1')->firstOrFail();

        $this->assertSame('RATIO', $node->calculation_type);
        $this->assertSame('RATIO_PERCENTAGE', $node->formula_key);

        $schema = app(InputSchemaService::class)->getSchemaForNode($node);
        $this->assertSame('RATIO_PERCENTAGE', $schema['formula_key']);
        $this->assertCount(2, $schema['fields']);
        $this->assertSame('skor_kompetensi_aktual', $schema['fields'][0]['key']);
        $this->assertSame('skor_kompetensi_ideal', $schema['fields'][1]['key']);

        $saved = $this->store($node, [
            'skor_kompetensi_aktual' => 17415,
            'skor_kompetensi_ideal' => 42039,
        ]);
        // 17415 / 42039 * 100 = 41.4258...
        $this->assertSame(41.4258, (float) $saved->realisasi);
    }

    public function test_ikp_10_2_survey_schema_label_is_neutral(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:10.2')->firstOrFail();
        $schema = app(InputSchemaService::class)->getSchemaForNode($node);

        $this->assertStringContainsString('Skala Likert maks', $schema['fields'][1]['label']);
    }

    public function test_ikp_15_1_digitalization_ratio_calculation(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:15.1')->firstOrFail();
        $schema = app(InputSchemaService::class)->getSchemaForNode($node);

        $this->assertStringContainsString('10 proses bisnis inti', $schema['fields'][1]['help_text']);

        $saved = $this->store($node, [
            'proses_bisnis_terdigitalisasi' => 4,
            'total_proses_bisnis_inti' => 10,
        ]);
        // 4 / 10 * 100 = 40.0%
        $this->assertSame(40.0, (float) $saved->realisasi);
    }
}
