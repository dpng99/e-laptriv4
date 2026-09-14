<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomponenRumus extends Model
{
    use HasFactory;

    protected $table = 'kinerja_komponen_rumus';

    protected $fillable = [
        'rumus_indikator_id', 'kode_komponen', 'nama_komponen', 'tipe_data',
        'source_type', 'source_node_id', 'input_key', 'aggregation', 'bobot', 'urutan', 'penjelasan',
    ];

    protected function casts(): array
    {
        return ['bobot' => 'decimal:4'];
    }

    public function formula(): BelongsTo
    {
        return $this->belongsTo(RumusIndikator::class, 'rumus_indikator_id');
    }

    public function sourceNode(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'source_node_id');
    }
}
