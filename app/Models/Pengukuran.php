<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengukuran extends Model
{
    use HasFactory;

    protected $table = 'kinerja_pengukurans';

    protected $fillable = [
        'node_id', 'target_id', 'unit_kerja_id', 'tahun', 'triwulan',
        'pembilang', 'penyebut', 'realisasi', 'capaian', 'status',
        'target_snapshot', 'formula_key_snapshot', 'formula_version_snapshot',
        'status_capaian', 'calculation_trace', 'source_reference', 'evidence_reference',
        'analisis_capaian', 'kendala', 'upaya', 'created_by', 'updated_by',
        'submitted_by', 'verified_by', 'approved_by', 'locked_by',
        'submitted_at', 'verified_at', 'approved_at', 'locked_at', 'calculated_at',
    ];

    protected function casts(): array
    {
        return [
            'pembilang' => 'float',
            'penyebut' => 'float',
            'realisasi' => 'float',
            'capaian' => 'float',
            'target_snapshot' => 'float',
            'calculation_trace' => 'array',
            'submitted_at' => 'datetime',
            'verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'locked_at' => 'datetime',
            'calculated_at' => 'datetime',
        ];
    }

    public function isFinal(): bool
    {
        return $this->locked_at !== null || $this->approved_at !== null
            || in_array(strtoupper((string) $this->status), ['FINAL', 'APPROVED', 'LOCKED'], true);
    }

    /**
     * Historical report imports hold values published by their source when the
     * underlying formula operands are unavailable. They must not be replaced by
     * a later automatic recalculation.
     */
    public function isReported(): bool
    {
        return strtoupper((string) $this->status) === 'REPORTED';
    }

    public function node(): BelongsTo { return $this->belongsTo(KinerjaNode::class, 'node_id'); }
    public function target(): BelongsTo { return $this->belongsTo(Target::class); }
    public function unit(): BelongsTo { return $this->belongsTo(UnitKerja::class, 'unit_kerja_id'); }
    public function inputs(): HasMany { return $this->hasMany(PengukuranInput::class); }
}
