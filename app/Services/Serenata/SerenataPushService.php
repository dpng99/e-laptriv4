<?php

namespace App\Services\Serenata;

use App\Models\SerenataConfig;
use App\Models\SerenataSyncLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class SerenataPushService
{
    public function __construct(
        private readonly SerenataIkpPayloadService $payloadService,
        private readonly SerenataSignatureService $signatureService,
        private readonly SsrfUrlValidator $ssrfValidator,
    ) {}

    /**
     * Push explicit IKP quantitative scores (Modul Nilai IKP) to SERENATA PANEV.
     */
    public function pushNilai(
        int $tahun,
        int $triwulan,
        ?string $kodeIkp = null,
        string $actor = 'admin',
        ?string $ipAddress = null
    ): array {
        $config = SerenataConfig::current();
        $webhookUrl = trim((string) $config->webhook_nilai_url);

        if ($webhookUrl === '') {
            throw ValidationException::withMessages([
                'webhook_nilai_url' => 'URL Webhook untuk Modul Nilai IKP belum dikonfigurasi.',
            ]);
        }

        $payload = $this->payloadService->buildNilaiPayload($tahun, $triwulan, $kodeIkp);

        return $this->dispatchPush(
            config: $config,
            moduleType: 'NILAI',
            webhookUrl: $webhookUrl,
            urlFieldName: 'webhook_nilai_url',
            payload: $payload,
            tahun: $tahun,
            triwulan: $triwulan,
            actor: $actor,
            ipAddress: $ipAddress
        );
    }

    /**
     * Push explicit IKP qualitative narratives (Modul Narasi IKP) to SERENATA PANEV.
     */
    public function pushNarasi(
        int $tahun,
        int $triwulan,
        ?string $kodeIkp = null,
        string $actor = 'admin',
        ?string $ipAddress = null
    ): array {
        $config = SerenataConfig::current();
        $webhookUrl = trim((string) $config->webhook_narasi_url);

        if ($webhookUrl === '') {
            throw ValidationException::withMessages([
                'webhook_narasi_url' => 'URL Webhook untuk Modul Narasi IKP belum dikonfigurasi.',
            ]);
        }

        $payload = $this->payloadService->buildNarasiPayload($tahun, $triwulan, $kodeIkp);

        return $this->dispatchPush(
            config: $config,
            moduleType: 'NARASI',
            webhookUrl: $webhookUrl,
            urlFieldName: 'webhook_narasi_url',
            payload: $payload,
            tahun: $tahun,
            triwulan: $triwulan,
            actor: $actor,
            ipAddress: $ipAddress
        );
    }

    private function dispatchPush(
        SerenataConfig $config,
        string $moduleType,
        string $webhookUrl,
        string $urlFieldName,
        array $payload,
        int $tahun,
        int $triwulan,
        string $actor,
        ?string $ipAddress
    ): array {
        if (!$config->is_enabled) {
            throw ValidationException::withMessages([
                'is_enabled' => 'Integrasi SERENATA PANEV sedang dinonaktifkan.',
            ]);
        }

        $hmacSecret = $config->getHmacSecret();
        if (!$hmacSecret) {
            throw ValidationException::withMessages([
                'credentials' => 'Kredensial HMAC Secret belum dibuat. Silakan klik Generate / Rotasi Kredensial terlebih dahulu.',
            ]);
        }

        // Strict SSRF validation before making any outbound connection
        $validatedUrl = $this->ssrfValidator->validateOrFail($webhookUrl, $urlFieldName);

        $rawBody = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $timestamp = (string) time();
        $nonce = bin2hex(random_bytes(16));

        $urlParts = parse_url($validatedUrl);
        $path = $urlParts['path'] ?? '/';
        $queryParams = [];
        if (!empty($urlParts['query'])) {
            parse_str($urlParts['query'], $queryParams);
        }

        $canonical = $this->signatureService->buildCanonicalString(
            $timestamp,
            $nonce,
            'POST',
            $path,
            $queryParams,
            $rawBody
        );
        $signature = $this->signatureService->sign($canonical, $hmacSecret);
        $payloadHash = $payload['meta']['payload_sha256'] ?? hash('sha256', $rawBody);
        $ikpCount = (int) ($payload['meta']['total_ikp'] ?? count($payload['data'] ?? []));

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'User-Agent' => 'e-Laptri-JAMBIN-SerenataClient/1.0',
            SerenataSignatureService::HEADER_MODULE => $moduleType,
            SerenataSignatureService::HEADER_TIMESTAMP => $timestamp,
            SerenataSignatureService::HEADER_NONCE => $nonce,
            SerenataSignatureService::HEADER_SIGNATURE => $signature,
            'X-Idempotency-Key' => hash('sha256', "{$moduleType}:{$tahun}:{$triwulan}:{$payloadHash}:{$timestamp}"),
        ];

        $webhookToken = $config->getWebhookToken();
        if ($webhookToken) {
            $headers['Authorization'] = 'Bearer ' . $webhookToken;
        }

        $startTime = microtime(true);

        try {
            $response = Http::timeout(15)
                ->withoutRedirecting()
                ->withHeaders($headers)
                ->withBody($rawBody, 'application/json')
                ->post($validatedUrl);

            $durationMs = (int) round((microtime(true) - $startTime) * 1000);
            $isSuccess = $response->successful();
            $httpStatus = $response->status();
            $bodyPreview = mb_substr(trim((string) $response->body()), 0, 500);

            $log = SerenataSyncLog::create([
                'module_type' => $moduleType,
                'direction' => 'PUSH',
                'status' => $isSuccess ? 'SUCCESS' : 'FAILED',
                'http_status' => $httpStatus,
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'ikp_count' => $ikpCount,
                'payload_hash' => $payloadHash,
                'ip_address' => $ipAddress,
                'endpoint' => $validatedUrl,
                'actor' => $actor,
                'error_message' => $isSuccess ? null : "HTTP {$httpStatus} dari endpoint SERENATA PANEV.",
                'response_summary' => $bodyPreview ?: null,
                'duration_ms' => $durationMs,
                'created_at' => now(),
            ]);

            Log::info('SERENATA PANEV Push Executed', [
                'module_type' => $moduleType,
                'status' => $log->status,
                'http_status' => $httpStatus,
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'ikp_count' => $ikpCount,
                'actor' => $actor,
            ]);

            return [
                'success' => $isSuccess,
                'module_type' => $moduleType,
                'http_status' => $httpStatus,
                'ikp_count' => $ikpCount,
                'payload_hash' => $payloadHash,
                'duration_ms' => $durationMs,
                'log_id' => $log->id,
                'message' => $isSuccess
                    ? "Data Modul {$moduleType} IKP ({$ikpCount} IKP) berhasil dikirim ke SERENATA PANEV (HTTP {$httpStatus})."
                    : "Pengiriman Modul {$moduleType} IKP ditolak/gagal di server tujuan (HTTP {$httpStatus}).",
            ];
        } catch (Throwable $e) {
            $durationMs = (int) round((microtime(true) - $startTime) * 1000);

            $log = SerenataSyncLog::create([
                'module_type' => $moduleType,
                'direction' => 'PUSH',
                'status' => 'FAILED',
                'http_status' => 0,
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'ikp_count' => $ikpCount,
                'payload_hash' => $payloadHash,
                'ip_address' => $ipAddress,
                'endpoint' => $validatedUrl,
                'actor' => $actor,
                'error_message' => mb_substr($e->getMessage(), 0, 500),
                'response_summary' => null,
                'duration_ms' => $durationMs,
                'created_at' => now(),
            ]);

            Log::warning('SERENATA PANEV Push Exception', [
                'module_type' => $moduleType,
                'error' => $e->getMessage(),
                'actor' => $actor,
            ]);

            return [
                'success' => false,
                'module_type' => $moduleType,
                'http_status' => 0,
                'ikp_count' => $ikpCount,
                'payload_hash' => $payloadHash,
                'duration_ms' => $durationMs,
                'log_id' => $log->id,
                'message' => "Gagal menghubungi server SERENATA PANEV untuk Modul {$moduleType}: " . $e->getMessage(),
            ];
        }
    }
}
