<?php

namespace App\Models;

use App\Enums\FormulaType;
use App\Enums\IndicatorDirection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RumusIndikator extends Model
{
    use HasFactory;

    protected $table = 'kinerja_rumus_indikators';

    protected $fillable = [
        'node_id', 'versi', 'tipe_formula', 'arah_kinerja', 'rumus_tampilan',
        'status_formula', 'batas_capaian', 'jumlah_desimal',
        'kebijakan_data_kosong', 'is_active', 'judul_pembilang', 'judul_penyebut',
    ];

    protected function casts(): array
    {
        return [
            'tipe_formula' => FormulaType::class,
            'arah_kinerja' => IndicatorDirection::class,
            'batas_capaian' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function node(): BelongsTo
    {
        return $this->belongsTo(KinerjaNode::class, 'node_id');
    }

    public function components(): HasMany
    {
        return $this->hasMany(KomponenRumus::class);
    }
}
