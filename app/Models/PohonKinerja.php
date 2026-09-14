<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PohonKinerja extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'level',
        'kode_indikator',
        'nama_kinerja',
        'unit_pengampu',
        'tipe_formula',
        'rumus_deskripsi',
        'nama_pembilang',
        'nama_penyebut',
        'satuan',
        'tahun_mulai',
        'tahun_selesai',
        'is_active',
        'sumber_data',
    ];

    // Relasi Parent (Atasan)
    public function parent()
    {
        return $this->belongsTo(PohonKinerja::class, 'parent_id');
    }

    // Relasi Children (Bawahan Direct)
    public function children()
    {
        return $this->hasMany(PohonKinerja::class, 'parent_id');
    }

    // Relasi Children Rekursif (Pohon Tak Terbatas)
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    // Relasi ke Transaksi Pengukuran
    public function pengukurans()
    {
        return $this->hasMany(Pengukuran::class, 'pohon_kinerja_id');
    }

    // Scope untuk Level
    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    // Scope untuk Unit Pengampu
    public function scopeByUnit($query, $unit)
    {
        return $query->where('unit_pengampu', $unit);
    }

    // Calculation Engine untuk Menghitung Capaian IKK secara Otomatis
    public function calculateCapaian($pembilang, $penyebut, $target = null)
    {
        if ($this->tipe_formula === 'RATIO_PERCENTAGE') {
            return ($penyebut > 0) ? ($pembilang / $penyebut) * 100 : 0;
        }

        if ($this->tipe_formula === 'UNFAVORABLE_PERCENTAGE') {
            return ($penyebut > 0) ? (1 - ($pembilang / $penyebut)) * 100 : 100;
        }

        if ($this->tipe_formula === 'INDEX_SCORE') {
            return ($target > 0) ? ($pembilang / $target) * 100 : 0;
        }

        return 0;
    }
}