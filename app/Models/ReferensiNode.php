<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferensiNode extends Model
{
    use HasFactory;

    protected $table = 'kinerja_referensi_nodes';

    protected $fillable = [
        'node_id', 'dokumen_kinerja_id', 'kode_sumber', 'halaman', 'catatan',
    ];

    public function node(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'node_id');
    }

    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(DokumenKinerja::class, 'dokumen_kinerja_id');
    }
}
