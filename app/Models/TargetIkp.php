<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetIkp extends Model
{
    use HasFactory;

    protected $table = 'target_ikp';

    protected $fillable = [
        'kode_ikp',
        'tahun',
        'triwulan',
        'target',
        'realisasi',
        'capaian',
        'analisis_capaian',
        'hambatan_kendala',
        'langkah_tindak_lanjut',
        'kendala',
        'upaya',
    ];

    public function ikp()
    {
        return $this->belongsTo(Ikp::class, 'kode_ikp', 'kode_ikp');
    }
}
