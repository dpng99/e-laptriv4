<?php

namespace App\Models;

use App\Enums\IndicatorDirection;
use App\Enums\MeasurementMode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ikk extends Model
{
    use HasFactory;

    protected $table = 'kinerja_ikk';
    protected $primaryKey = 'node_id';
    public $incrementing = false;

    protected $fillable = [
        'node_id', 'kode_ikk', 'kode_sumber', 'nama_ikk', 'satuan',
        'measurement_mode', 'arah_kinerja', 'penanggung_jawab_teks', 'penjelasan',
    ];

    protected $appends = ['rumus'];

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

    public function formulas()
    {
        return $this->hasMany(RumusIndikator::class, 'node_id', 'node_id');
    }

    public function rumus()
    {
        return $this->hasOne(RumusIndikator::class, 'node_id', 'node_id')
            ->where('is_active', true)->orderByDesc('versi');
    }

    public function getRumusAttribute()
    {
        $formula = $this->relationLoaded('rumus') ? $this->getRelation('rumus') : $this->rumus()->first();
        if (!$formula) return null;
        return new RumusIndikatorSeparated([
            'kode_indikator' => $this->kode_ikk,
            'tipe_formula' => $formula->tipe_formula?->value,
            'nama_pembilang' => $formula->judul_pembilang,
            'nama_penyebut' => $formula->judul_penyebut,
            'satuan' => $this->satuan,
            'deskripsi' => $formula->rumus_tampilan,
        ]);
    }
}
