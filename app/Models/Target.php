<?php

namespace App\Models;

use App\Enums\TargetStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    use HasFactory;

    protected $table = 'kinerja_targets';

    protected $fillable = [
        'node_id', 'dokumen_kinerja_id', 'tahun', 'periode', 'nilai_target',
        'nilai_teks_sumber', 'status', 'status_perbandingan', 'is_selected', 'catatan',
    ];

    protected function casts(): array
    {
        return [
            'nilai_target' => 'float',
            'status' => TargetStatus::class,
            'is_selected' => 'boolean',
        ];
    }

    public function node(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'node_id');
    }

    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(DokumenKinerja::class, 'dokumen_kinerja_id');
    }
}
