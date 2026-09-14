<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Legacy bidang codes are intentionally kept as the access-control source.
     * The kinerja unit codes are longer and cannot be stored in users.bidang_id
     * (CHAR(5)), so all translations live in one place.
     */
    public const BIDANG_UNIT_CODES = [
        'JMBIN' => 'JAMBIN',
        'SET' => 'SET-JAMBIN',
        'REN' => 'RO-REN',
        'PEG' => 'RO-PEG',
        'KEU' => 'RO-KEU',
        'KAP' => 'RO-KAP',
        'HLN' => 'RO-HUK-HLN',
        'UMUM' => 'RO-UMUM',
        'PDTI' => 'PUSDASKRIMTI',
        'PSKPH' => 'PUSTRAJAKGAKUM',
        'PKY' => 'PKY',
    ];

    protected $primaryKey = 'username';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'nama_satker',
        'bidang_id',
        'role_id',
        'is_active',
        'kinerja_unit_kerja_id',
        'kinerja_role',
        'kinerja_is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'kinerja_is_active' => 'boolean',
        ];
    }

    public function kinerjaUnit(): BelongsTo
    {
        return $this->belongsTo(UnitKerja::class, 'kinerja_unit_kerja_id');
    }

    public function assignedUnit(): ?UnitKerja
    {
        $unitCode = self::BIDANG_UNIT_CODES[strtoupper(trim((string) $this->bidang_id))] ?? null;

        if ($unitCode !== null) {
            return UnitKerja::query()->where('kode', $unitCode)->first();
        }

        return $this->kinerjaUnit;
    }

    public function isAdmin(): bool
    {
        return strtoupper(trim((string) ($this->role_id ?: $this->kinerja_role))) === 'ADMIN';
    }

    public function isOperator(): bool
    {
        return in_array(
            strtoupper(trim((string) ($this->role_id ?: $this->kinerja_role))),
            ['OPR', 'OPERATOR'],
            true,
        );
    }

    public function landingRoute(): string
    {
        return $this->isAdmin() ? 'admin.dashboard' : 'dashboard';
    }

    /**
     * Laravel Auth uses this to know the login credential column name.
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }
}
