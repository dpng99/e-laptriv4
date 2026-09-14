<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetSp extends Model
{
    use HasFactory;

    protected $table = 'target_sp';

    protected $fillable = [
        'kode_sp',
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

    public function sp()
    {
        return $this->belongsTo(Sp::class, 'kode_sp', 'kode_sp');
    }
}
