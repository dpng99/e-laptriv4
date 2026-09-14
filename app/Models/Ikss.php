<?php

namespace App\Models;

use App\Enums\IndicatorDirection;
use App\Enums\MeasurementMode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ikss extends Model
{
    use HasFactory;

    protected $table = 'kinerja_ikss';
    protected $primaryKey = 'node_id';
    public $incrementing = false;

    protected $fillable = [
        'node_id', 'kode_ikss', 'nama_ikss', 'satuan', 'measurement_mode',
        'arah_kinerja', 'penanggung_jawab_teks',
    ];

    protected function casts(): array
    {
        return [
            'measurement_mode' => MeasurementMode::class,
            'arah_kinerja' => IndicatorDirection::class,
        ];
    }

    public function node(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'node_id');
    }
}
