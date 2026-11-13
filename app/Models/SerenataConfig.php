<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Throwable;

class SerenataConfig extends Model
{
    protected $table = 'serenata_configs';

    protected $fillable = [
        'is_enabled',
        'api_key_prefix',
        'api_key_hash',
        'hmac_secret_encrypted',
        'webhook_nilai_url',
        'webhook_narasi_url',
        'webhook_token_encrypted',
        'allowed_ips',
        'rate_limit_per_minute',
        'last_rotated_at',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'allowed_ips' => 'array',
            'rate_limit_per_minute' => 'integer',
            'last_rotated_at' => 'datetime',
        ];
    }

    public static function current(): self
    {
        $config = self::query()->first();
        if (!$config) {
            $config = self::query()->create([
                'is_enabled' => true,
                'allowed_ips' => [],
                'rate_limit_per_minute' => 30,
            ]);
        }

        return $config;
    }

    public function hasCredentials(): bool
    {
        return !empty($this->api_key_hash) && !empty($this->hmac_secret_encrypted);
    }

    public function verifyApiKey(string $providedKey): bool
    {
        if (empty($this->api_key_hash) || $providedKey === '') {
            return false;
        }

        $providedHash = hash('sha256', $providedKey);

        return hash_equals((string) $this->api_key_hash, $providedHash);
    }

    public function getHmacSecret(): ?string
    {
        if (empty($this->hmac_secret_encrypted)) {
            return null;
        }

        try {
            return Crypt::decryptString($this->hmac_secret_encrypted);
        } catch (Throwable) {
            return null;
        }
    }

    public function getWebhookToken(): ?string
    {
        if (empty($this->webhook_token_encrypted)) {
            return null;
        }

        try {
            return Crypt::decryptString($this->webhook_token_encrypted);
        } catch (Throwable) {
            return null;
        }
    }

    public function setWebhookToken(?string $plainToken): void
    {
        if ($plainToken === null || trim($plainToken) === '') {
            $this->webhook_token_encrypted = null;
            return;
        }

        $this->webhook_token_encrypted = Crypt::encryptString(trim($plainToken));
    }

    /**
     * Generate and persist a new cryptographic API Key (SHA-256 hashed at rest)
     * and HMAC-SHA256 Shared Secret (AES-256 encrypted at rest).
     *
     * @return array{api_key: string, hmac_secret: string, prefix: string}
     */
    public function rotateCredentials(string $actor = 'admin'): array
    {
        $plainApiKey = 'srnt_live_' . bin2hex(random_bytes(24));
        $plainHmacSecret = bin2hex(random_bytes(32));
        $prefix = substr($plainApiKey, 0, 16) . '...' . substr($plainApiKey, -4);

        $this->api_key_prefix = $prefix;
        $this->api_key_hash = hash('sha256', $plainApiKey);
        $this->hmac_secret_encrypted = Crypt::encryptString($plainHmacSecret);
        $this->last_rotated_at = now();
        $this->updated_by = $actor;
        $this->save();

        return [
            'api_key' => $plainApiKey,
            'hmac_secret' => $plainHmacSecret,
            'prefix' => $prefix,
        ];
    }
}
