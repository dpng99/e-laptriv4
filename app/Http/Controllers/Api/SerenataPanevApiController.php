<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SerenataConfig;
use App\Models\SerenataSyncLog;
use App\Services\Serenata\SerenataIkpPayloadService;
use App\Services\Serenata\SerenataSignatureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SerenataPanevApiController extends Controller
{
    public function __construct(
        private readonly SerenataIkpPayloadService $payloadService,
        private readonly SerenataSignatureService $signatureService,
    ) {}

    /**
     * GET /api/v1/serenata-panev/ikp/nilai
     * Dedicated endpoint for SERENATA PANEV - Modul Nilai IKP (explicit quantitative scores).
     */
    public function nilai(Request $request): JsonResponse
    {
        return $this->serveModulePayload($request, 'NILAI');
    }

    /**
     * GET /api/v1/serenata-panev/ikp/narasi
     * Dedicated endpoint for SERENATA PANEV - Modul Narasi IKP (explicit qualitative narratives).
     */
    public function narasi(Request $request): JsonResponse
    {
        return $this->serveModulePayload($request, 'NARASI');
    }

    private function serveModulePayload(Request $request, string $moduleType): JsonResponse
    {
        $startTime = microtime(true);

        $validator = Validator::make($request->query(), [
            'tahun' => 'nullable|integer|between:2025,2029',
            'triwulan' => 'nullable|integer|between:1,4',
            'kode_ikp' => 'nullable|string|max:30|regex:/^[A-Za-z0-9.:\-\s]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'INVALID_PARAMETERS',
                'module_type' => $moduleType,
                'message' => 'Parameter query tidak valid.',
                'details' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $tahun = (int) ($validated['tahun'] ?? 2025);
        $triwulan = (int) ($validated['triwulan'] ?? 1);
        $kodeIkp = $validated['kode_ikp'] ?? null;

        $payload = $moduleType === 'NARASI'
            ? $this->payloadService->buildNarasiPayload($tahun, $triwulan, $kodeIkp)
            : $this->payloadService->buildNilaiPayload($tahun, $triwulan, $kodeIkp);

        $rawBody = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $responseTimestamp = (string) time();
        $hmacSecret = (string) SerenataConfig::current()->getHmacSecret();
        $responseSignature = $hmacSecret !== ''
            ? $this->signatureService->signResponse($responseTimestamp, $moduleType, $rawBody, $hmacSecret)
            : '';

        $durationMs = (int) round((microtime(true) - $startTime) * 1000);
        $ikpCount = (int) ($payload['meta']['total_ikp'] ?? count($payload['data'] ?? []));
        $payloadHash = $payload['meta']['payload_sha256'] ?? hash('sha256', $rawBody);

        SerenataSyncLog::create([
            'module_type' => $moduleType,
            'direction' => 'PULL',
            'status' => 'SUCCESS',
            'http_status' => 200,
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'ikp_count' => $ikpCount,
            'payload_hash' => $payloadHash,
            'ip_address' => $request->ip(),
            'endpoint' => '/' . ltrim($request->path(), '/'),
            'actor' => 'serenata_client',
            'error_message' => null,
            'response_summary' => "Returned {$ikpCount} explicit IKP {$moduleType} records.",
            'duration_ms' => $durationMs,
            'created_at' => now(),
        ]);

        return response()->json($payload, 200, [
            SerenataSignatureService::HEADER_MODULE => $moduleType,
            SerenataSignatureService::HEADER_RESPONSE_TIMESTAMP => $responseTimestamp,
            SerenataSignatureService::HEADER_RESPONSE_SIGNATURE => $responseSignature,
            'Cache-Control' => 'no-store, no-cache, must-revalidate, private',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
