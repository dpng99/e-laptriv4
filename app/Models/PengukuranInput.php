<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengukuranInput extends Model
{
    use HasFactory;

    protected $table = 'kinerja_pengukuran_inputs';

    protected $fillable = [
        'pengukuran_id', 'komponen_rumus_id', 'input_key', 'nilai', 'nilai_teks', 'catatan',
    ];

    protected function casts(): array
    {
        return ['nilai' => 'float'];
    }

    public function pengukuran(): BelongsTo
    {
        return $this->belongsTo(Pengukuran::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(KomponenRumus::class, 'komponen_rumus_id');
    }
}
