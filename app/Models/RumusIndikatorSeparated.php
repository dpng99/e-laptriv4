<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumusIndikatorSeparated extends Model
{
    use HasFactory;

    protected $table = 'rumus_indikator';

    protected $fillable = [
        'kode_indikator',
        'tipe_formula',
        'nama_pembilang',
        'nama_penyebut',
        'satuan',
        'deskripsi',
    ];
}
