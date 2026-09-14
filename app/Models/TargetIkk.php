<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetIkk extends Model
{
    use HasFactory;

    protected $table = 'target_ikk';

    protected $fillable = [
        'kode_ikk',
        'tahun',
        'triwulan',
        'target',
        'pembilang',
        'penyebut',
        'realisasi',
        'capaian',
        'analisis_capaian',
        'hambatan_kendala',
        'langkah_tindak_lanjut',
        'kendala',
        'upaya',
    ];

    public function ikk()
    {
        return $this->belongsTo(Ikk::class, 'kode_ikk', 'kode_ikk');
    }
}
