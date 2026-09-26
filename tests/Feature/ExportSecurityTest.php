<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class ExportSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create([
            'username' => 'admin.export.test',
            'bidang_id' => 'JMBIN',
            'role_id' => 'ADMIN',
            'is_active' => true,
        ]);
    }

    public function test_export_index_validates_tahun_and_triwulan(): void
    {
        $admin = $this->createAdmin();

        // Valid query
        $response = $this->actingAs($admin)->get('/export?tahun=2026&triwulan=1');
        $response->assertOk();

        // Invalid triwulan (> 4)
        $invalidResponse = $this->actingAs($admin)->get('/export?tahun=2026&triwulan=5');
        $invalidResponse->assertSessionHasErrors(['triwulan']);

        // Invalid tahun (< 2020)
        $invalidYearResponse = $this->actingAs($admin)->get('/export?tahun=1999&triwulan=1');
        $invalidYearResponse->assertSessionHasErrors(['tahun']);
    }

    public function test_export_word_rejects_invalid_route_parameters(): void
    {
        $admin = $this->createAdmin();

        // Invalid triwulan '5' does not match regex [1-4] -> 404
        $response = $this->actingAs($admin)->get('/export/word/2026/5');
        $response->assertNotFound();

        // Non-numeric year does not match regex [0-9]{4} -> 404
        $responseNan = $this->actingAs($admin)->get('/export/word/abcd/1');
        $responseNan->assertNotFound();
    }

    public function test_export_word_enforces_rate_limiting(): void
    {
        $admin = $this->createAdmin();

        $mock = $this->mock(\App\Services\WordExportService::class);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_test');
        file_put_contents($tempFile, 'dummy content');
        $mock->shouldReceive('generateLkjiP')->andReturn($tempFile);

        // Execute 10 requests within limit
        for ($i = 0; $i < 10; $i++) {
            $this->actingAs($admin)->get('/export/word/2026/1')->assertOk();
            // Re-create tempFile if deleted after send
            if (!file_exists($tempFile)) {
                file_put_contents($tempFile, 'dummy content');
            }
        }

        // 11th request exceeds limit and gets 429
        $response = $this->actingAs($admin)->get('/export/word/2026/1');
        $response->assertStatus(429);

        if (file_exists($tempFile)) {
            @unlink($tempFile);
        }
    }
}
