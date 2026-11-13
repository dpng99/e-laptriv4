<?php

namespace App\Http\Middleware;

use App\Models\SerenataConfig;
use App\Models\SerenataSyncLog;
use App\Services\Serenata\SerenataSignatureService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class VerifySerenataApiSignature
{
    public function __construct(
        private readonly SerenataSignatureService $signatureService,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $moduleType = str_contains(strtolower($request->path()), 'narasi') ? 'NARASI' : 'NILAI';
        $config = SerenataConfig::current();

        // 1. Check integration active switch
        if (!$config->is_enabled) {
            return $this->reject($request, $moduleType, 403, 'Integrasi API SERENATA PANEV sedang dinonaktifkan.');
        }

        // 2. Enforce HTTPS on production
        if (app()->environment('production') && !$request->secure()) {
            return $this->reject($request, $moduleType, 403, 'Koneksi API SERENATA PANEV wajib menggunakan protokol HTTPS.');
        }

        // 3. Optional IP Allowlist check
        $allowedIps = array_values(array_filter((array) $config->allowed_ips, fn ($ip) => is_string($ip) && trim($ip) !== ''));
        if (!empty($allowedIps)) {
            $clientIp = (string) $request->ip();
            if (!IpUtils::checkIp($clientIp, $allowedIps)) {
                return $this->reject($request, $moduleType, 403, "Alamat IP {$clientIp} tidak terdaftar pada IP Allowlist SERENATA PANEV.");
            }
        }

        // 4. Check credentials configured
        if (!$config->hasCredentials()) {
            return $this->reject($request, $moduleType, 503, 'Kredensial keamanan API SERENATA PANEV belum diinisialisasi.');
        }

        // 5. Verify Bearer API Key (constant-time SHA-256 comparison)
        $bearerToken = (string) $request->bearerToken();
        if ($bearerToken === '' || !$config->verifyApiKey($bearerToken)) {
            return $this->reject($request, $moduleType, 401, 'Bearer API Key tidak valid atau tidak ditemukan.');
        }

        // 6. Anti-Replay validation: Timestamp & One-Time Nonce
        $timestamp = (string) $request->header(SerenataSignatureService::HEADER_TIMESTAMP, '');
        $nonce = (string) $request->header(SerenataSignatureService::HEADER_NONCE, '');
        $replayCheck = $this->signatureService->validateTimestampAndNonce($timestamp, $nonce);

        if (!$replayCheck['valid']) {
            return $this->reject($request, $moduleType, 401, (string) $replayCheck['reason']);
        }

        // 7. HMAC-SHA256 Canonical Request Signature verification
        $providedSignature = (string) $request->header(SerenataSignatureService::HEADER_SIGNATURE, '');
        $hmacSecret = (string) $config->getHmacSecret();

        $canonicalString = $this->signatureService->buildCanonicalFromRequest($request, $timestamp, $nonce);
        $expectedSignature = $this->signatureService->sign($canonicalString, $hmacSecret);

        if (!$this->signatureService->verify($expectedSignature, $providedSignature)) {
            return $this->reject($request, $moduleType, 401, 'Tanda tangan kriptografi X-Serenata-Signature (HMAC-SHA256) tidak valid.');
        }

        return $next($request);
    }

    private function reject(Request $request, string $moduleType, int $httpStatus, string $reason): Response
    {
        $tahun = is_numeric($request->query('tahun')) ? (int) $request->query('tahun') : null;
        $triwulan = is_numeric($request->query('triwulan')) ? (int) $request->query('triwulan') : null;

        SerenataSyncLog::create([
            'module_type' => $moduleType,
            'direction' => 'PULL',
            'status' => 'REJECTED',
            'http_status' => $httpStatus,
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'ikp_count' => 0,
            'payload_hash' => null,
            'ip_address' => $request->ip(),
            'endpoint' => '/' . ltrim($request->path(), '/'),
            'actor' => 'serenata_client',
            'error_message' => $reason,
            'response_summary' => null,
            'duration_ms' => 0,
            'created_at' => now(),
        ]);

        Log::warning('SERENATA PANEV API Access Rejected', [
            'module_type' => $moduleType,
            'http_status' => $httpStatus,
            'reason' => $reason,
            'ip' => $request->ip(),
            'path' => $request->path(),
        ]);

        return response()->json([
            'error' => 'SERENATA_SECURITY_REJECTION',
            'module_type' => $moduleType,
            'message' => $reason,
        ], $httpStatus);
    }
}
