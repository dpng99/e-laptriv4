<?php

namespace Tests\Feature;

use App\Models\Ikk;
use App\Models\Ikp;
use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\SerenataConfig;
use App\Models\SerenataSyncLog;
use App\Models\Sk;
use App\Models\Sp;
use App\Models\Target;
use App\Models\UnitKerja;
use App\Models\User;
use App\Services\Serenata\SerenataSignatureService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SerenataPanevApiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private UnitKerja $unit;
    private KinerjaNode $ikpNode;
    private KinerjaNode $ikkNode;
    private array $credentials;
    private SerenataSignatureService $signatureService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->signatureService = app(SerenataSignatureService::class);

        $this->unit = UnitKerja::create([
            'kode' => 'RO-REN',
            'nama' => 'Biro Perencanaan',
            'is_active' => true,
        ]);

        $this->admin = User::factory()->create([
            'username' => 'admin.serenata.test',
            'role_id' => 'ADMIN',
            'kinerja_role' => 'ADMIN',
            'is_active' => true,
            'kinerja_is_active' => true,
        ]);

        $spNode = KinerjaNode::create([
            'source_key' => 'SP:1',
            'kode' => 'SP 1',
            'nama' => 'Meningkatnya akuntabilitas kinerja Kejaksaan RI',
            'jenis_node' => 'SP',
            'is_active' => true,
        ]);
        Sp::create([
            'node_id' => $spNode->id,
            'kode_sp' => 'SP 1',
            'nama_sp' => 'Meningkatnya akuntabilitas kinerja Kejaksaan RI',
        ]);

        $this->ikpNode = KinerjaNode::create([
            'source_key' => 'IKP:1.1',
            'kode' => 'IKP 1.1',
            'nama' => 'Nilai SAKIP Kejaksaan RI',
            'satuan' => 'Nilai',
            'jenis_node' => 'IKP',
            'calculation_type' => 'EXTERNAL_SCORE',
            'formula_key' => 'EXTERNAL_SCORE',
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
        $spNode->children()->attach($this->ikpNode->id, ['jenis_relasi' => 'STRUCTURAL', 'dasar_relasi' => 'RENSTRA_2025_2029']);

        $dokumen = \App\Models\DokumenKinerja::create([
            'kode' => 'RENSTRA-2025-2029',
            'jenis' => 'RENSTRA',
            'nama' => 'Renstra Kejaksaan RI 2025-2029',
            'tahun_mulai' => 2025,
            'tahun_selesai' => 2029,
            'status' => 'ACTIVE',
        ]);

        Target::create([
            'node_id' => $this->ikpNode->id,
            'dokumen_kinerja_id' => $dokumen->id,
            'tahun' => 2026,
            'periode' => 'TAHUNAN',
            'nilai_target' => 80.75,
            'nilai_teks_sumber' => '80.75',
        ]);

        Pengukuran::create([
            'node_id' => $this->ikpNode->id,
            'unit_kerja_id' => $this->unit->id,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 81.20,
            'capaian' => 100.56,
            'target_snapshot' => 80.75,
            'status_capaian' => 'TERCAPAI',
            'status' => 'REPORTED',
            'analisis_capaian' => 'Realisasi Nilai SAKIP mencapai 81.20 melampaui target 80.75.',
            'kendala' => 'Penyelarasan cascading di daerah masih bertahap.',
            'upaya' => 'Asistensi dan evaluasi AKIP terpadu.',
            'source_reference' => 'Laporan Kinerja JAMBIN TW I 2026',
            'evidence_reference' => 'LHE KemenPAN-RB',
        ]);

        // Also seed an SK and IKK to verify they are NEVER leaked in the explicit IKP APIs
        $skNode = KinerjaNode::create([
            'source_key' => 'SK:1.1.1',
            'kode' => 'SK 1.1.1',
            'nama' => 'Terwujudnya Perencanaan dan RB yang Efektif',
            'jenis_node' => 'SK',
            'is_active' => true,
        ]);
        Sk::create([
            'node_id' => $skNode->id,
            'kode_sk' => 'SK 1.1.1',
            'nama_sk' => 'Terwujudnya Perencanaan dan RB yang Efektif',
        ]);

        $this->ikkNode = KinerjaNode::create([
            'source_key' => 'IKK:1.1.1.1',
            'kode' => 'IKK 1.1.1.1',
            'nama' => 'Persentase layanan RB sesuai SLA',
            'jenis_node' => 'IKK',
            'is_active' => true,
        ]);
        Ikk::create([
            'node_id' => $this->ikkNode->id,
            'kode_ikk' => 'IKK 1.1.1.1',
            'nama_ikk' => 'Persentase layanan RB sesuai SLA',
            'satuan' => '%',
        ]);

        $config = SerenataConfig::current();
        $this->credentials = $config->rotateCredentials('admin.serenata.test');
    }

    private function buildSignedHeaders(string $path, array $query = [], ?string $apiKey = null, ?string $hmacSecret = null, ?string $timestamp = null, ?string $nonce = null): array
    {
        $apiKey ??= $this->credentials['api_key'];
        $hmacSecret ??= $this->credentials['hmac_secret'];
        $timestamp ??= (string) time();
        $nonce ??= bin2hex(random_bytes(16));

        $canonical = $this->signatureService->buildCanonicalString(
            $timestamp,
            $nonce,
            'GET',
            $path,
            $query,
            ''
        );
        $signature = $this->signatureService->sign($canonical, $hmacSecret);

        return [
            'Authorization' => 'Bearer ' . $apiKey,
            SerenataSignatureService::HEADER_TIMESTAMP => $timestamp,
            SerenataSignatureService::HEADER_NONCE => $nonce,
            SerenataSignatureService::HEADER_SIGNATURE => $signature,
        ];
    }

    public function test_nilai_api_returns_only_explicit_ikp_quantitative_values_without_narratives(): void
    {
        $path = '/api/v1/serenata-panev/ikp/nilai';
        $query = ['tahun' => 2026, 'triwulan' => 1];
        $headers = $this->buildSignedHeaders($path, $query);

        $response = $this->withHeaders($headers)
            ->getJson($path . '?' . http_build_query($query));

        $response->assertOk()
            ->assertHeader(SerenataSignatureService::HEADER_MODULE, 'NILAI')
            ->assertHeader(SerenataSignatureService::HEADER_RESPONSE_SIGNATURE)
            ->assertJsonPath('meta.module_type', 'NILAI')
            ->assertJsonPath('meta.entity_level', 'IKP_ONLY')
            ->assertJsonPath('meta.id_satker', '005016')
            ->assertJsonPath('meta.bulan', 3)
            ->assertJsonPath('meta.khusus', 2)
            ->assertJsonPath('meta.total_ikp', 1)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id_satker', '005016')
            ->assertJsonPath('data.0.kode_ikp', 'IKP 1.1')
            ->assertJsonPath('data.0.sub_indikator', 'IKP 1.1')
            ->assertJsonPath('data.0.source_key', 'IKP:1.1')
            ->assertJsonPath('data.0.bulan', 3)
            ->assertJsonPath('data.0.khusus', 2)
            ->assertJsonPath('data.0.capaian', 81.2)
            ->assertJsonPath('data.0.nilai_akhir_ikp', 81.2)
            ->assertJsonPath('data.0.nilai_target', 80.75)
            ->assertJsonPath('data.0.nilai_realisasi', 81.2)
            ->assertJsonPath('data.0.nilai_capaian', 100.56)
            ->assertJsonPath('data.0.status_capaian', 'TERCAPAI');

        $firstItem = $response->json('data.0');
        $this->assertArrayNotHasKey('komponen_nilai', $firstItem);
        $this->assertArrayNotHasKey('pembilang', $firstItem);
        $this->assertArrayNotHasKey('penyebut', $firstItem);
        $this->assertArrayNotHasKey('faktor', $firstItem);
        $this->assertArrayNotHasKey('langkah_optimalisasi', $firstItem);
        $this->assertArrayNotHasKey('analisis_capaian', $firstItem);
        $this->assertArrayNotHasKey('kendala', $firstItem);
        $this->assertArrayNotHasKey('upaya', $firstItem);
    }

    public function test_narasi_api_returns_only_explicit_ikp_qualitative_narratives_without_scores(): void
    {
        $path = '/api/v1/serenata-panev/ikp/narasi';
        $query = ['tahun' => 2026, 'triwulan' => 1];
        $headers = $this->buildSignedHeaders($path, $query);

        $response = $this->withHeaders($headers)
            ->getJson($path . '?' . http_build_query($query));

        $expectedFaktor = "Analisis Capaian:\nRealisasi Nilai SAKIP mencapai 81.20 melampaui target 80.75.\n\nKendala:\nPenyelarasan cascading di daerah masih bertahap.";

        $response->assertOk()
            ->assertHeader(SerenataSignatureService::HEADER_MODULE, 'NARASI')
            ->assertHeader(SerenataSignatureService::HEADER_RESPONSE_SIGNATURE)
            ->assertJsonPath('meta.module_type', 'NARASI')
            ->assertJsonPath('meta.entity_level', 'IKP_ONLY')
            ->assertJsonPath('meta.id_satker', '005016')
            ->assertJsonPath('meta.total_ikp', 1)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id_satker', '005016')
            ->assertJsonPath('data.0.kode_ikp', 'IKP 1.1')
            ->assertJsonPath('data.0.faktor', $expectedFaktor)
            ->assertJsonPath('data.0.langkah_optimalisasi', 'Asistensi dan evaluasi AKIP terpadu.')
            ->assertJsonPath('data.0.analisis_capaian', 'Realisasi Nilai SAKIP mencapai 81.20 melampaui target 80.75.')
            ->assertJsonPath('data.0.kendala', 'Penyelarasan cascading di daerah masih bertahap.')
            ->assertJsonPath('data.0.upaya', 'Asistensi dan evaluasi AKIP terpadu.')
            ->assertJsonPath('data.0.is_narasi_lengkap', true);

        $firstItem = $response->json('data.0');
        $this->assertArrayNotHasKey('capaian', $firstItem);
        $this->assertArrayNotHasKey('nilai_akhir_ikp', $firstItem);
        $this->assertArrayNotHasKey('nilai_target', $firstItem);
        $this->assertArrayNotHasKey('nilai_realisasi', $firstItem);
        $this->assertArrayNotHasKey('nilai_capaian', $firstItem);
        $this->assertArrayNotHasKey('komponen_nilai', $firstItem);
    }

    public function test_api_rejects_invalid_key_expired_timestamp_replay_nonce_and_tampered_signature(): void
    {
        $path = '/api/v1/serenata-panev/ikp/nilai';
        $query = ['tahun' => 2026, 'triwulan' => 1];

        // 1. Invalid API Key
        $badKeyHeaders = $this->buildSignedHeaders($path, $query, 'srnt_live_wrong_key');
        $this->withHeaders($badKeyHeaders)
            ->getJson($path . '?' . http_build_query($query))
            ->assertStatus(401);

        // 2. Expired Timestamp (> 300s old)
        $expiredTs = (string) (time() - 600);
        $expiredHeaders = $this->buildSignedHeaders($path, $query, null, null, $expiredTs);
        $this->withHeaders($expiredHeaders)
            ->getJson($path . '?' . http_build_query($query))
            ->assertStatus(401);

        // 3. Replay Attack (reusing the same Nonce)
        $fixedNonce = 'unique_nonce_1234567890_abcdef';
        $validHeaders = $this->buildSignedHeaders($path, $query, null, null, null, $fixedNonce);
        $this->withHeaders($validHeaders)
            ->getJson($path . '?' . http_build_query($query))
            ->assertOk();

        // Second request with identical nonce must be rejected 401
        $this->withHeaders($validHeaders)
            ->getJson($path . '?' . http_build_query($query))
            ->assertStatus(401)
            ->assertJsonPath('error', 'SERENATA_SECURITY_REJECTION');

        // 4. Tampered query parameters (signed for triwulan=1, requested triwulan=2)
        $tamperedHeaders = $this->buildSignedHeaders($path, ['tahun' => 2026, 'triwulan' => 1]);
        $this->withHeaders($tamperedHeaders)
            ->getJson($path . '?tahun=2026&triwulan=2')
            ->assertStatus(401);
    }

    public function test_api_enforces_ip_allowlist_when_configured(): void
    {
        $config = SerenataConfig::current();
        $config->update(['allowed_ips' => ['203.0.113.50']]);

        $path = '/api/v1/serenata-panev/ikp/narasi';
        $query = ['tahun' => 2026, 'triwulan' => 1];
        $headers = $this->buildSignedHeaders($path, $query);

        // Request from 127.0.0.1 is not in allowed_ips -> 403
        $this->withHeaders($headers)
            ->getJson($path . '?' . http_build_query($query))
            ->assertStatus(403);
    }

    public function test_ssrf_protection_blocks_private_loopback_and_cloud_metadata_webhook_urls(): void
    {
        $unsafeUrls = [
            'http://127.0.0.1:8080/internal',
            'https://169.254.169.254/latest/meta-data/',
            'https://192.168.1.10/webhook',
            'https://10.0.0.5/webhook',
            'https://localhost/webhook',
        ];

        foreach ($unsafeUrls as $unsafeUrl) {
            $this->actingAs($this->admin)
                ->put(route('admin.serenata.config.update'), [
                    'is_enabled' => true,
                    'webhook_nilai_url' => $unsafeUrl,
                    'webhook_narasi_url' => '',
                    'rate_limit_per_minute' => 30,
                ])
                ->assertSessionHasErrors('webhook_nilai_url');
        }
    }

    public function test_admin_can_push_nilai_and_narasi_separately_with_hmac_signatures(): void
    {
        Http::fake([
            'https://serenata-panev.kejaksaan.go.id/*' => Http::response(['status' => 'received'], 200),
        ]);

        $config = SerenataConfig::current();
        $config->update([
            'webhook_nilai_url' => 'https://serenata-panev.kejaksaan.go.id/api/v1/receive/ikp-nilai',
            'webhook_narasi_url' => 'https://serenata-panev.kejaksaan.go.id/api/v1/receive/ikp-narasi',
        ]);

        // 1. Push Modul Nilai IKP
        $this->actingAs($this->admin)
            ->post(route('admin.serenata.push.nilai'), ['tahun' => 2026, 'triwulan' => 1])
            ->assertRedirect()
            ->assertSessionHas('success');

        // 2. Push Modul Narasi IKP
        $this->actingAs($this->admin)
            ->post(route('admin.serenata.push.narasi'), ['tahun' => 2026, 'triwulan' => 1])
            ->assertRedirect()
            ->assertSessionHas('success');

        $nilaiLog = SerenataSyncLog::where('direction', 'PUSH')->where('module_type', 'NILAI')->first();
        $narasiLog = SerenataSyncLog::where('direction', 'PUSH')->where('module_type', 'NARASI')->first();

        $this->assertNotNull($nilaiLog);
        $this->assertEquals('SUCCESS', $nilaiLog->status);
        $this->assertEquals(1, $nilaiLog->ikp_count);

        $this->assertNotNull($narasiLog);
        $this->assertEquals('SUCCESS', $narasiLog->status);
        $this->assertEquals(1, $narasiLog->ikp_count);
    }
}
