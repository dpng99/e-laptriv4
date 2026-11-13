<?php

namespace App\Services\Serenata;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SerenataSignatureService
{
    public const HEADER_TIMESTAMP = 'X-Serenata-Timestamp';
    public const HEADER_NONCE = 'X-Serenata-Nonce';
    public const HEADER_SIGNATURE = 'X-Serenata-Signature';
    public const HEADER_MODULE = 'X-Serenata-Module';
    public const HEADER_RESPONSE_TIMESTAMP = 'X-Serenata-Response-Timestamp';
    public const HEADER_RESPONSE_SIGNATURE = 'X-Serenata-Response-Signature';

    /**
     * Build deterministic canonical string for HMAC-SHA256 signing.
     * Format: "{timestamp}.{nonce}.{UPPER_METHOD}.{normalized_path_and_sorted_query}.{sha256_body}"
     */
    public function buildCanonicalString(
        string $timestamp,
        string $nonce,
        string $method,
        string $path,
        array $queryParams = [],
        string $rawBody = ''
    ): string {
        $upperMethod = strtoupper(trim($method));
        $normalizedTarget = $this->normalizePathAndQuery($path, $queryParams);
        $effectiveBody = in_array($upperMethod, ['GET', 'HEAD'], true) ? '' : $rawBody;
        $bodyHash = hash('sha256', $effectiveBody);

        return implode('.', [
            trim($timestamp),
            trim($nonce),
            $upperMethod,
            $normalizedTarget,
            $bodyHash,
        ]);
    }

    public function buildCanonicalFromRequest(Request $request, string $timestamp, string $nonce): string
    {
        return $this->buildCanonicalString(
            $timestamp,
            $nonce,
            $request->getMethod(),
            '/' . ltrim($request->path(), '/'),
            $request->query(),
            (string) $request->getContent()
        );
    }

    public function normalizePathAndQuery(string $path, array $queryParams = []): string
    {
        $cleanPath = '/' . ltrim(trim($path), '/');

        if (empty($queryParams)) {
            return $cleanPath;
        }

        $normalizedParams = $this->sortQueryParamsRecursive($queryParams);
        $queryString = http_build_query($normalizedParams, '', '&', PHP_QUERY_RFC3986);

        return $queryString !== '' ? "{$cleanPath}?{$queryString}" : $cleanPath;
    }

    private function sortQueryParamsRecursive(array $params): array
    {
        ksort($params);
        foreach ($params as $k => $v) {
            if (is_array($v)) {
                $params[$k] = $this->sortQueryParamsRecursive($v);
            } else {
                $params[$k] = (string) $v;
            }
        }

        return $params;
    }

    public function sign(string $canonicalString, string $hmacSecret): string
    {
        return hash_hmac('sha256', $canonicalString, $hmacSecret);
    }

    public function verify(string $expectedSignature, string $providedSignature): bool
    {
        if ($expectedSignature === '' || $providedSignature === '') {
            return false;
        }

        return hash_equals(strtolower($expectedSignature), strtolower(trim($providedSignature)));
    }

    public function signResponse(string $timestamp, string $moduleType, string $rawBody, string $hmacSecret): string
    {
        $canonical = implode('.', [
            trim($timestamp),
            strtoupper(trim($moduleType)),
            hash('sha256', $rawBody),
        ]);

        return hash_hmac('sha256', $canonical, $hmacSecret);
    }

    /**
     * Validate timestamp freshness and one-time nonce uniqueness (Anti-Replay).
     *
     * @return array{valid: bool, reason: string|null}
     */
    public function validateTimestampAndNonce(string $timestamp, string $nonce, int $toleranceSeconds = 300): array
    {
        $timestamp = trim($timestamp);
        $nonce = trim($nonce);

        if ($timestamp === '' || !ctype_digit($timestamp)) {
            return ['valid' => false, 'reason' => 'Header X-Serenata-Timestamp tidak valid atau kosong.'];
        }

        $tsInt = (int) $timestamp;
        $drift = abs(time() - $tsInt);
        if ($drift > $toleranceSeconds) {
            return [
                'valid' => false,
                'reason' => "Timestamp request berada di luar batas toleransi keamanan ({$drift} detik > {$toleranceSeconds} detik).",
            ];
        }

        if ($nonce === '' || !preg_match('/^[A-Za-z0-9\-_]{16,128}$/', $nonce)) {
            return [
                'valid' => false,
                'reason' => 'Header X-Serenata-Nonce wajib terdiri dari 16-128 karakter alfanumerik/strip/underscore.',
            ];
        }

        $cacheKey = 'serenata_nonce:' . hash('sha256', $nonce);
        $stored = Cache::add($cacheKey, $tsInt, $toleranceSeconds * 2);

        if (!$stored) {
            return [
                'valid' => false,
                'reason' => 'Replay attack terdeteksi: X-Serenata-Nonce sudah pernah digunakan.',
            ];
        }

        return ['valid' => true, 'reason' => null];
    }
}
