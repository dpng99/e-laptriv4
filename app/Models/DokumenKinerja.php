<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DokumenKinerja extends Model
{
    use HasFactory;

    protected $table = 'kinerja_dokumens';

    protected $fillable = [
        'kode', 'jenis', 'nomor', 'nama', 'versi', 'tahun_mulai',
        'tahun_selesai', 'status', 'file_path',
    ];

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function referensiNodes(): HasMany
    {
        return $this->hasMany(ReferensiNode::class);
    }
}
