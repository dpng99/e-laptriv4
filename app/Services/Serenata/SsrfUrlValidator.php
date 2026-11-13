<?php

namespace App\Services\Serenata;

use Illuminate\Validation\ValidationException;

class SsrfUrlValidator
{
    private const BLOCKED_HOSTNAMES = [
        'localhost',
        'localhost.localdomain',
        'metadata.google.internal',
        'metadata',
        'instance-data',
    ];

    /**
     * Validate an outbound webhook URL against Server-Side Request Forgery (SSRF) risks.
     *
     * @throws ValidationException
     */
    public function validateOrFail(string $url, string $fieldName = 'webhook_url'): string
    {
        $url = trim($url);
        if ($url === '' || filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw ValidationException::withMessages([
                $fieldName => 'Format URL webhook SERENATA PANEV tidak valid.',
            ]);
        }

        $parts = parse_url($url);
        if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host'])) {
            throw ValidationException::withMessages([
                $fieldName => 'URL webhook harus memiliki skema dan host yang valid.',
            ]);
        }

        $scheme = strtolower((string) $parts['scheme']);
        $isProduction = app()->environment('production');

        if ($isProduction && $scheme !== 'https') {
            throw ValidationException::withMessages([
                $fieldName => 'Pada environment production, URL webhook SERENATA PANEV wajib menggunakan protokol HTTPS.',
            ]);
        }

        if (!in_array($scheme, ['https', 'http'], true)) {
            throw ValidationException::withMessages([
                $fieldName => 'Protokol URL webhook hanya mendukung HTTPS (atau HTTP pada mode pengembangan).',
            ]);
        }

        if (!empty($parts['user']) || !empty($parts['pass'])) {
            throw ValidationException::withMessages([
                $fieldName => 'URL webhook tidak boleh menyertakan kredensial inline (user:password@host).',
            ]);
        }

        $host = strtolower(trim((string) $parts['host'], '[]'));

        if (
            in_array($host, self::BLOCKED_HOSTNAMES, true)
            || str_ends_with($host, '.local')
            || str_ends_with($host, '.internal')
            || str_ends_with($host, '.localhost')
        ) {
            throw ValidationException::withMessages([
                $fieldName => "Host '{$host}' ditolak oleh sistem proteksi SSRF (internal/loopback host tidak diizinkan).",
            ]);
        }

        // If the host is an IP literal (IPv4 or IPv6), strictly reject private, loopback, link-local, or reserved ranges
        if (filter_var($host, FILTER_VALIDATE_IP) !== false) {
            if (!$this->isPublicIp($host)) {
                throw ValidationException::withMessages([
                    $fieldName => "Alamat IP '{$host}' ditolak oleh sistem proteksi SSRF (IP privat/loopback/metadata tidak diizinkan).",
                ]);
            }

            return $url;
        }

        // For domain names, resolve DNS records if available and verify none point to private/internal IPs
        $resolvedIps = @gethostbynamel($host);
        if (is_array($resolvedIps) && !empty($resolvedIps)) {
            foreach ($resolvedIps as $ip) {
                if (!$this->isPublicIp($ip)) {
                    throw ValidationException::withMessages([
                        $fieldName => "Domain '{$host}' mengarah ke alamat IP internal/privat ({$ip}) dan diblokir oleh proteksi SSRF.",
                    ]);
                }
            }
        } elseif ($isProduction) {
            throw ValidationException::withMessages([
                $fieldName => "Domain '{$host}' tidak dapat di-resolve oleh DNS server.",
            ]);
        }

        return $url;
    }

    public function isPublicIp(string $ip): bool
    {
        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }
}
