<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetSk extends Model
{
    use HasFactory;

    protected $table = 'target_sk';

    protected $fillable = [
        'kode_sk',
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

    public function sk()
    {
        return $this->belongsTo(Sk::class, 'kode_sk', 'kode_sk');
    }
}
