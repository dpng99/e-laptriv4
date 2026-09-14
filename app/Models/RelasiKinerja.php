<?php

namespace App\Models;

use App\Enums\RelationBasis;
use App\Enums\RelationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelasiKinerja extends Model
{
    use HasFactory;

    protected $table = 'kinerja_relasi';

    protected $fillable = [
        'parent_node_id', 'child_node_id', 'jenis_relasi', 'dasar_relasi',
        'bobot', 'dokumen_kinerja_id', 'halaman_sumber', 'catatan',
    ];

    protected function casts(): array
    {
        return [
            'jenis_relasi' => RelationType::class,
            'dasar_relasi' => RelationBasis::class,
            'bobot' => 'decimal:4',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'parent_node_id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'child_node_id');
    }

    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(DokumenKinerja::class, 'dokumen_kinerja_id');
    }
}
